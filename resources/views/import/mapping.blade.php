@extends('layouts.main')

@section('dashboard-content')
<div class="px-6 py-12 max-w-6xl mx-auto">
    <div class="mb-8">
        <h2 class="text-3xl font-black text-text-main dark:text-white mb-2 italic">Map CSV Columns</h2>
        <p class="text-text-muted dark:text-gray-400">Match your bank export columns to the database fields.</p>
    </div>

    <form action="{{ route('import.store') }}" method="POST">
        @csrf
        <input type="hidden" name="temp_path" value="{{ $temp_path }}">

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Settings Column -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-surface-light dark:bg-surface-dark rounded-3xl p-6 border border-border-light dark:border-border-dark shadow-sm">
                    <h3 class="text-lg font-bold text-text-main dark:text-white mb-6 italic">Import Settings</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-text-muted mb-2">Payment Method</label>
                            <select name="payment_method_id" required
                                class="w-full rounded-xl border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark text-sm px-4 py-3 focus:border-primary focus:ring-primary">
                                @foreach($paymentMethods as $method)
                                    <option value="{{ $method->id }}">{{ $method->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-text-muted mb-2">Default Category</label>
                            <select name="category_id"
                                class="w-full rounded-xl border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark text-sm px-4 py-3 focus:border-primary focus:ring-primary">
                                <option value="">None</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-text-muted mb-2">Date Format</label>
                            <select name="date_format" required
                                class="w-full rounded-xl border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark text-sm px-4 py-3 focus:border-primary focus:ring-primary">
                                <option value="d/m/Y">DD/MM/YYYY (09/01/2026)</option>
                                <option value="d-m-Y">DD-MM-YYYY (09-01-2026)</option>
                                <option value="d.m.Y">DD.MM.YYYY (09.01.2026)</option>
                                <option value="d M Y">DD Mon YYYY (09 Jan 2026)</option>
                                <option value="d-M-Y">DD-Mon-YYYY (09-Jan-2026)</option>
                                <option value="Y-m-d">YYYY-MM-DD (2026-01-09)</option>
                                <option value="d/m/y">DD/MM/YY (09/01/26)</option>
                                <option value="d-m-y">DD-MM-YY (09-01-26)</option>
                                <option value="m/d/Y">MM/DD/YYYY (01/09/2026)</option>
                            </select>
                        </div>

                        <div class="pt-2">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <div class="relative flex items-center">
                                    <input type="checkbox" name="invert_amounts" value="1"
                                        class="h-5 w-5 rounded border-border-light dark:border-border-dark border-2 bg-transparent text-primary checked:bg-primary checked:border-primary focus:ring-0 focus:ring-offset-0 focus:outline-none transition-colors cursor-pointer">
                                </div>
                                <span class="text-sm font-medium text-text-main dark:text-gray-300 group-hover:text-primary transition-colors">Invert all amount signs (+/-)</span>
                            </label>
                            <p class="text-[10px] text-text-muted mt-2 italic">Tick this if your bank exports withdrawals as positive numbers.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-surface-light dark:bg-surface-dark rounded-3xl p-6 border border-border-light dark:border-border-dark shadow-sm">
                    <h3 class="text-lg font-bold text-text-main dark:text-white mb-4 italic">Accuracy & AI Assist</h3>
                    <div class="flex items-center justify-between">
                        <p class="text-xs text-text-muted">Auto-mapping confidence</p>
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full {{ $overallConfidence >= 70 ? 'bg-green-100 text-green-700' : ($overallConfidence >= 50 ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                            {{ $overallConfidence }}%
                        </span>
                    </div>
                    <p class="text-[10px] text-text-muted mt-2 italic">Low confidence? Consider AI assist, then review before import.</p>

                    <div class="mt-5">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="relative flex items-center">
                                <input type="checkbox" id="aiAssistToggle" class="h-5 w-5 rounded border-border-light dark:border-border-dark border-2 bg-transparent text-primary checked:bg-primary checked:border-primary focus:ring-0 focus:ring-offset-0 focus:outline-none transition-colors cursor-pointer">
                            </div>
                            <span class="text-sm font-medium text-text-main dark:text-gray-300 group-hover:text-primary transition-colors">Enable AI assist (DeepSeek)</span>
                        </label>
                        <p class="text-[10px] text-text-muted mt-2 italic">Sends headers + sample rows to DeepSeek to suggest a mapping.</p>
                    </div>

                    <button type="button" id="aiAssistBtn" class="mt-4 w-full bg-emerald-100 hover:bg-emerald-200 text-emerald-900 font-black py-3 rounded-xl transition-all hover:scale-[1.01] disabled:opacity-50 disabled:cursor-not-allowed">
                        GET AI MAPPING
                    </button>
                    <p id="aiAssistStatus" class="text-[10px] text-text-muted mt-2 italic"></p>
                    @if(!$aiAvailable)
                        <p class="text-[10px] text-red-600 mt-2 italic">AI assist disabled: set DEEPSEEK_API_KEY in your .env.</p>
                    @endif
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-primary/90 text-text-main font-black py-4 rounded-xl transition-all hover:scale-[1.01] flex items-center justify-center gap-2 italic">
                    <span class="material-symbols-outlined">data_saver_on</span>
                    <span>COMMIT IMPORT</span>
                </button>
                <a href="{{ route('import.index') }}" class="block text-center text-sm text-text-muted hover:text-text-main transition-colors mt-4">Cancel and Start Over</a>
            </div>

            <!-- Preview Table Column -->
            <div class="lg:col-span-2">
                <div class="bg-surface-light dark:bg-surface-dark rounded-3xl border border-border-light dark:border-border-dark shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-background-light/50 dark:bg-background-dark/50 border-b border-border-light dark:border-border-dark">
                                <tr>
                                    @foreach($rows[0] as $index => $cell)
                                    @php
                                        $selectedMapping = $suggestedMapping[$index] ?? '';
                                        $confidence = $confidenceByIndex[$index] ?? ['label' => 'Low', 'score' => 0];
                                        $confidenceClass = $confidence['label'] === 'High' ? 'text-green-700' : ($confidence['label'] === 'Medium' ? 'text-amber-700' : 'text-red-600');
                                    @endphp
                                    <th class="px-4 py-4">
                                        <select name="mapping[{{ $index }}]" 
                                            class="w-full text-xs font-bold rounded-lg border-border-light dark:border-border-dark bg-white dark:bg-background-dark focus:border-primary focus:ring-primary">
                                            <option value="" {{ $selectedMapping === '' ? 'selected' : '' }}>Ignore</option>
                                            <option value="date" {{ $selectedMapping === 'date' ? 'selected' : '' }}>Row: Date</option>
                                            <option value="description" {{ $selectedMapping === 'description' ? 'selected' : '' }}>Row: Description</option>
                                            <option value="amount" {{ $selectedMapping === 'amount' ? 'selected' : '' }}>Row: Amount (+/-)</option>
                                            <option value="amount_credit" {{ $selectedMapping === 'amount_credit' ? 'selected' : '' }}>Row: Credit (In)</option>
                                            <option value="amount_debit" {{ $selectedMapping === 'amount_debit' ? 'selected' : '' }}>Row: Debit (Out)</option>
                                        </select>
                                        <p class="mt-1 text-[10px] {{ $confidenceClass }}">Confidence: {{ $confidence['label'] }}</p>
                                    </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border-light dark:divide-border-dark">
                                @foreach($rows as $row)
                                <tr class="hover:bg-background-light/30 dark:hover:bg-white/5 transition-colors">
                                    @foreach($row as $cell)
                                    <td class="px-4 py-4 text-xs font-medium text-text-main dark:text-gray-300 truncate max-w-[150px]">
                                        {{ $cell }}
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <p class="text-xs text-text-muted mt-4 italic">* Showing first 10 rows for mapping purposes. All rows will be processed upon commit.</p>
            </div>
        </div>
    </form>
</div>

<script>
    (function () {
        const aiAvailable = @json($aiAvailable);
        const aiToggle = document.getElementById('aiAssistToggle');
        const aiButton = document.getElementById('aiAssistBtn');
        const aiStatus = document.getElementById('aiAssistStatus');
        const tempPath = @json($temp_path);

        function setButtonState() {
            const enabled = aiToggle.checked && aiAvailable;
            aiButton.disabled = !enabled;
        }

        aiToggle.addEventListener('change', setButtonState);
        setButtonState();

        aiButton.addEventListener('click', async () => {
            aiStatus.textContent = 'Requesting AI mapping...';
            try {
                const response = await window.axios.post('{{ route('import.ai-suggest') }}', {
                    temp_path: tempPath,
                });

                const mapping = response.data.mapping || {};
                const selects = document.querySelectorAll('select[name^="mapping["]');
                selects.forEach((select) => {
                    const match = select.name.match(/mapping\[(\d+)\]/);
                    if (!match) {
                        return;
                    }
                    const index = match[1];
                    if (mapping.hasOwnProperty(index)) {
                        select.value = mapping[index];
                    }
                });

                aiStatus.textContent = 'AI mapping applied. Please review before committing.';
            } catch (error) {
                const message = error?.response?.data?.message || 'AI mapping failed. Please try again.';
                aiStatus.textContent = message;
            }
        });
    })();
</script>
@endsection
