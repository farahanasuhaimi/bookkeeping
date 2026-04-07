<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Income;
use App\Models\Expense;
use App\Models\PaymentMethod;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ImportController extends Controller
{
    public function index()
    {
        return view('import.index');
    }

    public function preview(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $path = $request->file('csv_file')->store('temp');
        $fullPath = storage_path('app/private/' . $path);

        $rows = [];
        if (($handle = fopen($fullPath, "r")) !== FALSE) {
            $count = 0;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE && $count < 10) {
                $rows[] = $data;
                $count++;
            }
            fclose($handle);
        }

        $paymentMethods = PaymentMethod::where('user_id', Auth::id())->get();
        $categories = Category::all();
        $mappingSuggestion = $this->buildMappingSuggestion($rows);

        return view('import.mapping', [
            'rows' => $rows,
            'temp_path' => $path,
            'paymentMethods' => $paymentMethods,
            'categories' => $categories,
            'suggestedMapping' => $mappingSuggestion['mapping'],
            'confidenceByIndex' => $mappingSuggestion['confidence_by_index'],
            'overallConfidence' => $mappingSuggestion['overall_confidence'],
            'aiAvailable' => !empty(config('services.deepseek.api_key')),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'temp_path' => 'required|string',
            'mapping' => 'required|array',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'category_id' => 'nullable|exists:categories,id',
            'date_format' => 'required|string',
            'invert_amounts' => 'nullable|boolean',
        ]);

        $fullPath = storage_path('app/private/' . $request->temp_path);
        $mapping = $request->mapping; // column index => model field
        $paymentMethodId = $request->payment_method_id;
        $categoryId = $request->category_id;
        $dateFormat = $request->date_format;
        $invertAmounts = $request->has('invert_amounts');

        if (($handle = fopen($fullPath, "r")) !== FALSE) {
            $isHeader = true;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($isHeader) {
                    $isHeader = false;
                    continue;
                }

                $record = [
                    'user_id' => Auth::id(),
                    'payment_method_id' => $paymentMethodId,
                    'category_id' => $categoryId,
                ];

                $creditAmount = 0;
                $debitAmount = 0;
                $standardAmount = null;

                foreach ($mapping as $index => $field) {
                    if ($field && isset($data[$index]) && trim($data[$index]) !== '') {
                        $value = trim($data[$index]);
                        
                        if ($field === 'date') {
                            try {
                                // Try selected format
                                $record['date'] = \Carbon\Carbon::createFromFormat($dateFormat, $value)->format('Y-m-d');
                            } catch (\Exception $e) {
                                // Fallback to fuzzy parsing if exact format fails
                                try {
                                    $record['date'] = \Carbon\Carbon::parse($value)->format('Y-m-d');
                                } catch (\Exception $e2) {
                                    // Will fallback to today's date later
                                }
                            }
                        } elseif (in_array($field, ['amount', 'amount_credit', 'amount_debit'])) {
                            // Handle accounting format (100.00) as negative
                            if (preg_match('/^\((.*)\)$/', $value, $matches)) {
                                $value = '-' . $matches[1];
                            }
                            $cleanValue = str_replace([',', 'RM', ' '], '', $value);
                            $floatValue = (float)$cleanValue;

                            if ($field === 'amount') {
                                $standardAmount = $floatValue;
                            } elseif ($field === 'amount_credit') {
                                $creditAmount = abs($floatValue);
                            } elseif ($field === 'amount_debit') {
                                $debitAmount = abs($floatValue);
                            }
                        } else {
                            $record[$field] = $value;
                        }
                    }
                }

                // Determine final amount
                if ($standardAmount !== null) {
                    $record['amount'] = $invertAmounts ? -$standardAmount : $standardAmount;
                } elseif ($creditAmount > 0) {
                    $record['amount'] = $creditAmount; // Credit is always positive (Income)
                } elseif ($debitAmount > 0) {
                    $record['amount'] = -$debitAmount; // Debit is always negative (Expense)
                }

                // Ensure date is present (fallback to today if missing or invalid)
                if (!isset($record['date'])) {
                    $record['date'] = now()->format('Y-m-d');
                }

                // Logic to determine Income vs Expense
                if (isset($record['amount']) && !empty($record['description'])) {
                    if ($record['amount'] > 0) {
                        $record['status'] = 'confirmed'; // Correct status for Income
                        Income::create(array_merge($record, ['source' => $record['description']]));
                    } else {
                        $record['amount'] = abs($record['amount']);
                        $record['status'] = 'completed'; // Correct status for Expense
                        Expense::create($record);
                    }
                }
            }
            fclose($handle);
        }

        Storage::delete($request->temp_path);

        return redirect()->route('dashboard')->with('success', 'Bank statement imported successfully.');
    }

    public function aiSuggest(Request $request)
    {
        $request->validate([
            'temp_path' => 'required|string',
        ]);

        $apiKey = config('services.deepseek.api_key');
        if (empty($apiKey)) {
            return response()->json([
                'ok' => false,
                'message' => 'AI assist is not configured. Add DEEPSEEK_API_KEY to your .env.',
            ], 422);
        }

        $fullPath = storage_path('app/private/' . $request->temp_path);
        $rows = [];
        if (($handle = fopen($fullPath, "r")) !== FALSE) {
            $count = 0;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE && $count < 15) {
                $rows[] = $data;
                $count++;
            }
            fclose($handle);
        }

        if (count($rows) < 2) {
            return response()->json([
                'ok' => false,
                'message' => 'Not enough rows to generate a mapping.',
            ], 422);
        }

        $headers = $rows[0];
        $sampleRows = array_slice($rows, 1);
        $prompt = $this->buildAiPrompt($headers, $sampleRows);

        $baseUrl = rtrim(config('services.deepseek.base_url'), '/');
        $model = config('services.deepseek.model');
        $timeout = (int) config('services.deepseek.timeout', 20);

        $response = Http::withToken($apiKey)
            ->timeout($timeout)
            ->post($baseUrl . '/chat/completions', [
                'model' => $model,
                'messages' => [
                    ['role' => 'system', 'content' => 'You map bank CSV columns to specific fields. Return only JSON.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.1,
            ]);

        if (!$response->successful()) {
            return response()->json([
                'ok' => false,
                'message' => 'AI request failed. Please try again.',
            ], 502);
        }

        $content = data_get($response->json(), 'choices.0.message.content', '');
        $parsed = $this->parseAiJson($content);
        if (!$parsed['ok']) {
            return response()->json([
                'ok' => false,
                'message' => 'AI response could not be parsed. Try again or map manually.',
            ], 422);
        }

        return response()->json([
            'ok' => true,
            'mapping' => $parsed['mapping'],
            'confidence_by_index' => $parsed['confidence_by_index'],
        ]);
    }

    private function buildMappingSuggestion(array $rows): array
    {
        if (count($rows) === 0) {
            return [
                'mapping' => [],
                'confidence_by_index' => [],
                'overall_confidence' => 0,
            ];
        }

        $headers = $rows[0];
        $sampleRows = array_slice($rows, 1);

        $mapping = [];
        $confidenceByIndex = [];
        $confidenceTotal = 0;
        $confidenceCount = 0;

        foreach ($headers as $index => $header) {
            $samples = [];
            foreach ($sampleRows as $row) {
                if (isset($row[$index])) {
                    $samples[] = $row[$index];
                }
            }

            $analysis = $this->scoreColumn($header, $samples);
            $mapping[$index] = $analysis['field'];
            $confidenceByIndex[$index] = [
                'score' => $analysis['confidence'],
                'label' => $analysis['label'],
            ];

            if ($analysis['field'] !== 'ignore') {
                $confidenceTotal += $analysis['confidence'];
                $confidenceCount++;
            }
        }

        $overall = $confidenceCount > 0 ? round($confidenceTotal / $confidenceCount) : 0;

        return [
            'mapping' => $mapping,
            'confidence_by_index' => $confidenceByIndex,
            'overall_confidence' => $overall,
        ];
    }

    private function scoreColumn(string $header, array $samples): array
    {
        $headerLower = strtolower(trim($header));
        $signals = $this->extractSignals($samples);

        $scores = [
            'date' => 0,
            'description' => 0,
            'amount' => 0,
            'amount_credit' => 0,
            'amount_debit' => 0,
            'ignore' => 0,
        ];

        if ($this->headerHas($headerLower, ['date', 'posting', 'value date', 'txn date', 'transaction date'])) {
            $scores['date'] += 70;
        }
        if ($this->headerHas($headerLower, ['desc', 'description', 'details', 'narration', 'merchant', 'reference', 'particulars', 'transaction'])) {
            $scores['description'] += 60;
        }
        if ($this->headerHas($headerLower, ['amount', 'amt', 'value'])) {
            $scores['amount'] += 55;
        }
        if ($this->headerHas($headerLower, ['credit', 'cr', 'deposit', 'in', 'received'])) {
            $scores['amount_credit'] += 70;
        }
        if ($this->headerHas($headerLower, ['debit', 'dr', 'withdrawal', 'out', 'paid'])) {
            $scores['amount_debit'] += 70;
        }
        if ($this->headerHas($headerLower, ['balance', 'running', 'available', 'avail', 'current balance'])) {
            $scores['ignore'] += 70;
        }

        if ($signals['date_ratio'] >= 0.6) {
            $scores['date'] += 30;
        }
        if ($signals['numeric_ratio'] >= 0.6) {
            $scores['amount'] += 25;
            $scores['amount_credit'] += 20;
            $scores['amount_debit'] += 20;
        }
        if ($signals['text_ratio'] >= 0.6) {
            $scores['description'] += 30;
        }
        if ($signals['negative_ratio'] >= 0.3) {
            $scores['amount'] += 10;
        }

        $bestField = 'ignore';
        $bestScore = 0;
        foreach ($scores as $field => $score) {
            if ($score > $bestScore) {
                $bestScore = $score;
                $bestField = $field;
            }
        }

        $confidence = min(100, $bestScore);
        $label = $confidence >= 70 ? 'High' : ($confidence >= 50 ? 'Medium' : 'Low');

        return [
            'field' => $bestField,
            'confidence' => $confidence,
            'label' => $label,
        ];
    }

    private function extractSignals(array $samples): array
    {
        $total = 0;
        $dateHits = 0;
        $numericHits = 0;
        $textHits = 0;
        $negativeHits = 0;

        foreach ($samples as $value) {
            $value = trim((string) $value);
            if ($value === '') {
                continue;
            }
            $total++;

            if (preg_match('/^\(?-?[\d,]+(?:\.\d+)?\)?$/', str_replace(['RM', ' '], '', $value))) {
                $numericHits++;
                if (preg_match('/^-|\(.*\)$/', $value)) {
                    $negativeHits++;
                }
            }

            if (preg_match('/^\d{1,2}[\/\-.]\d{1,2}[\/\-.]\d{2,4}$/', $value) || preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
                $dateHits++;
            }

            if (preg_match('/[a-zA-Z]/', $value)) {
                $textHits++;
            }
        }

        if ($total === 0) {
            return [
                'date_ratio' => 0,
                'numeric_ratio' => 0,
                'text_ratio' => 0,
                'negative_ratio' => 0,
            ];
        }

        return [
            'date_ratio' => $dateHits / $total,
            'numeric_ratio' => $numericHits / $total,
            'text_ratio' => $textHits / $total,
            'negative_ratio' => $negativeHits / $total,
        ];
    }

    private function headerHas(string $header, array $needles): bool
    {
        foreach ($needles as $needle) {
            if (str_contains($header, $needle)) {
                return true;
            }
        }
        return false;
    }

    private function buildAiPrompt(array $headers, array $sampleRows): string
    {
        $fields = [
            'date',
            'description',
            'amount',
            'amount_credit',
            'amount_debit',
            'ignore',
        ];

        return "Map the CSV columns to fields.\n"
            . "Fields: " . implode(', ', $fields) . "\n"
            . "Rules:\n"
            . "- Use 'amount' if the column has signed values.\n"
            . "- Use 'amount_credit' and 'amount_debit' if credits and debits are split.\n"
            . "- Use 'ignore' for balance or unrelated columns.\n"
            . "Return JSON ONLY with keys:\n"
            . "- mapping: object of column_index => field\n"
            . "- confidence_by_index: object of column_index => {score: 0-100}\n"
            . "CSV Headers:\n"
            . json_encode($headers) . "\n"
            . "Sample Rows:\n"
            . json_encode($sampleRows);
    }

    private function parseAiJson(string $content): array
    {
        $json = trim($content);
        $json = preg_replace('/^```json/i', '', $json);
        $json = preg_replace('/^```/', '', $json);
        $json = preg_replace('/```$/', '', $json);
        $json = trim($json);

        $decoded = json_decode($json, true);
        if (!is_array($decoded) || !isset($decoded['mapping'])) {
            return ['ok' => false];
        }

        $mapping = [];
        foreach ($decoded['mapping'] as $index => $field) {
            if (in_array($field, ['date', 'description', 'amount', 'amount_credit', 'amount_debit', 'ignore'], true)) {
                $mapping[(string) $index] = $field;
            }
        }

        $confidenceByIndex = [];
        if (isset($decoded['confidence_by_index']) && is_array($decoded['confidence_by_index'])) {
            foreach ($decoded['confidence_by_index'] as $index => $data) {
                $score = is_array($data) ? ($data['score'] ?? null) : $data;
                if (is_numeric($score)) {
                    $confidenceByIndex[(string) $index] = [
                        'score' => max(0, min(100, (int) $score)),
                    ];
                }
            }
        }

        return [
            'ok' => true,
            'mapping' => $mapping,
            'confidence_by_index' => $confidenceByIndex,
        ];
    }
}
