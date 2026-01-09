<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Income;
use App\Models\Expense;
use App\Models\PaymentMethod;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

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

        return view('import.mapping', [
            'rows' => $rows,
            'temp_path' => $path,
            'paymentMethods' => $paymentMethods,
            'categories' => $categories
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
}
