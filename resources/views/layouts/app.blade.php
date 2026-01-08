<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Bookkeeping')</title>
        
        <!-- Fonts & Icons -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
        @yield('content')

        <!-- Add Transaction Modal -->
        <div id="transactionModal" class="fixed inset-0 z-50 hidden flex items-center justify-center overflow-y-auto bg-black/50 dark:bg-black/70 p-4">
            <div class="w-full max-w-md rounded-2xl bg-surface-light dark:bg-surface-dark shadow-xl animation-fade-in">
                <!-- Modal Header -->
                <div class="border-b border-border-light dark:border-border-dark bg-background-light dark:bg-white/5 rounded-t-2xl px-6 py-4 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-text-main dark:text-white" id="modalTitle">Add Income</h3>
                    <button onclick="closeTransactionModal()" class="rounded-lg p-1 text-text-muted hover:bg-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <!-- Modal Content -->
                <form id="transactionForm" class="space-y-4 p-6">
                    @csrf
                    <!-- Transaction Type (hidden field) -->
                    <input type="hidden" id="transactionType" name="type" value="income">

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-text-main dark:text-white mb-2">Description</label>
                        <input type="text" id="description" name="description" placeholder="e.g., Freelance Project" required class="w-full rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-white/5 px-4 py-2.5 text-text-main dark:text-white placeholder-text-muted dark:placeholder-gray-500 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/50">
                    </div>

                    <!-- Amount -->
                    <div>
                        <label for="amount" class="block text-sm font-medium text-text-main dark:text-white mb-2">Amount (RM)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-2.5 text-text-muted dark:text-gray-400">RM</span>
                            <input type="number" id="amount" name="amount" placeholder="0.00" step="0.01" min="0" required class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-white/5 text-text-main dark:text-white placeholder-text-muted dark:placeholder-gray-500 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/50">
                        </div>
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-text-main dark:text-white mb-2">Category</label>
                        <select id="category" name="category_id" required class="w-full rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-white/5 px-4 py-2.5 text-text-main dark:text-white focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/50">
                            <option value="">Select a category</option>
                            <option value="1">Housing</option>
                            <option value="2">Transport</option>
                            <option value="3">Lifestyle</option>
                            <option value="4">Food & Dining</option>
                            <option value="5">Utilities</option>
                            <option value="6">Equipment</option>
                            <option value="7">Professional Services</option>
                            <option value="8">Other</option>
                        </select>
                    </div>
                    
                    <!-- Payment Method -->
                    <div>
                        <label for="payment_method" class="block text-sm font-medium text-text-main dark:text-white mb-2">Payment Method</label>
                        <div class="flex gap-2">
                             <select id="payment_method" name="payment_method_id" required class="flex-1 rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-white/5 px-4 py-2.5 text-text-main dark:text-white focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/50">
                                <option value="">Select Method</option>
                                @if(isset($paymentMethods))
                                    @foreach($paymentMethods as $method)
                                        <option value="{{ $method->id }}">{{ $method->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                             <button type="button" class="flex items-center justify-center rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-white/5 px-3 text-text-muted hover:text-primary transition-colors" title="Manage Methods">
                                <span class="material-symbols-outlined">settings</span>
                            </button>
                        </div>
                    </div>

                    <!-- Date -->
                    <div>
                        <label for="date" class="block text-sm font-medium text-text-main dark:text-white mb-2">Date</label>
                        <input type="date" id="date" name="date" required class="w-full rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-white/5 px-4 py-2.5 text-text-main dark:text-white focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/50">
                    </div>

                    <!-- Attachment -->
                    <div>
                        <label for="attachment" class="block text-sm font-medium text-text-main dark:text-white mb-2">Attachment (Optional)</label>
                        <div class="relative">
                            <input type="file" id="attachment" name="attachment" accept="image/*,.pdf" class="block w-full text-sm text-text-muted dark:text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                        </div>
                        <p class="mt-1 text-xs text-text-muted dark:text-gray-500">Max 10MB. Images or PDF.</p>
                    </div>

                    <!-- Tax Deductible (Expenses only) -->
                    <div id="deductibleSection" class="hidden space-y-2">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" id="isDeductible" name="is_deductible" class="w-4 h-4 rounded border-border-light dark:border-border-dark text-primary focus:ring-primary">
                            <span class="text-sm font-medium text-text-main dark:text-white">Tax Deductible</span>
                        </label>
                        <p class="text-xs text-text-muted dark:text-gray-400 ml-7">Mark if this expense can be claimed as a tax deduction</p>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-text-main dark:text-white mb-2">Notes (Optional)</label>
                        <textarea id="notes" name="notes" rows="2" placeholder="Add any additional details..." class="w-full rounded-lg border border-border-light dark:border-border-dark bg-surface-light dark:bg-white/5 px-4 py-2.5 text-text-main dark:text-white placeholder-text-muted dark:placeholder-gray-500 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/50 resize-none"></textarea>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="closeTransactionModal()" class="flex-1 rounded-lg border border-border-light dark:border-border-dark px-4 py-2.5 text-sm font-medium text-text-main dark:text-white hover:bg-background-light dark:hover:bg-white/5 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 rounded-lg bg-primary px-4 py-2.5 text-sm font-bold text-[#111814] hover:opacity-90 transition-opacity">
                            Save Transaction
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Transaction Form Script -->
        <script>
            const transactionModal = document.getElementById('transactionModal');
            const transactionForm = document.getElementById('transactionForm');
            const transactionTypeInput = document.getElementById('transactionType');
            const modalTitle = document.getElementById('modalTitle');
            const deductibleSection = document.getElementById('deductibleSection');
            const dateInput = document.getElementById('date');
            const categorySelect = document.getElementById('category');

            // Set today's date as default
            dateInput.valueAsDate = new Date();

            function openTransactionModal(type) {
                transactionTypeInput.value = type;
                modalTitle.textContent = type === 'income' ? 'Add Income' : 'Add Expense';
                deductibleSection.classList.toggle('hidden', type === 'income');

                // Update category options based on type
                updateCategoryOptions(type);

                transactionModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeTransactionModal() {
                transactionModal.classList.add('hidden');
                transactionForm.reset();
                dateInput.valueAsDate = new Date();
                document.body.style.overflow = 'auto';
            }

            function updateCategoryOptions(type) {
                const incomeOptions = [
                    { value: '1', text: 'Official Employment' },
                    { value: '2', text: 'Part-time / Business' },
                    { value: '', text: 'Other (Uncategorized)' }
                ];

                const expenseOptions = [
                    { value: '3', text: 'Housing' },
                    { value: '4', text: 'Transport' },
                    { value: '5', text: 'Lifestyle' },
                    { value: '6', text: 'Food & Dining' },
                    { value: '7', text: 'Utilities' },
                    { value: '8', text: 'Equipment' },
                    { value: '9', text: 'Professional Services' },
                    { value: '10', text: 'Other' },
                    { value: '11', text: 'Entertainment' }
                ];

                const options = type === 'income' ? incomeOptions : expenseOptions;
                categorySelect.innerHTML = '<option value="">Select a category</option>' +
                    options.map(opt => `<option value="${opt.value}">${opt.text}</option>`).join('');
            }

            // Form submission
            transactionForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                // No need to convert is_deductible manually if using FormData, 
                // but if we need boolean specifically for JSON validation on some servers it matters.
                // However, we are sending FormData (multipart/form-data) now for file upload support.
                
                // Add required checkboxes if unchecked (FormData doesn't include unchecked checkboxes)
                if (!formData.has('is_deductible')) {
                    formData.append('is_deductible', '0');
                } else {
                     // Ensure it sends '1' or 'true'
                     formData.set('is_deductible', '1');
                }

                try {
                    const response = await fetch('{{ route("transactions.store") }}', {
                        method: 'POST',
                        headers: {
                            // 'Content-Type': 'multipart/form-data', // DO NOT SET THIS! Browser sets it with boundary.
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        },
                        body: formData,
                    });

                    const result = await response.json();

                    if (result.success) {
                        // Show success message
                        showSuccessNotification(result.message);

                        // Close modal
                        closeTransactionModal();

                        // Refresh dashboard data after a short delay
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        showErrorNotification(result.message);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showErrorNotification('Failed to save transaction. Please try again.');
                }
            });

            // Helper function to show success notification
            function showSuccessNotification(message) {
                const notification = document.createElement('div');
                notification.className = 'fixed top-4 right-4 z-50 bg-green-500 dark:bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg animate-slide-in';
                notification.textContent = message;
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.classList.add('animate-slide-out');
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            }

            // Helper function to show error notification
            function showErrorNotification(message) {
                const notification = document.createElement('div');
                notification.className = 'fixed top-4 right-4 z-50 bg-red-500 dark:bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg animate-slide-in';
                notification.textContent = message;
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.classList.add('animate-slide-out');
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            }

            // Close modal when clicking outside
            transactionModal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeTransactionModal();
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !transactionModal.classList.contains('hidden')) {
                    closeTransactionModal();
                }
            });
        </script>

        <!-- Add CSS for modal animation -->
        <style>
            @keyframes fadeIn {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }

            @keyframes slideIn {
                from {
                    transform: translateX(400px);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }

            @keyframes slideOut {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(400px);
                    opacity: 0;
                }
            }

            .animation-fade-in {
                animation: fadeIn 0.3s ease-in-out;
            }

            .animate-slide-in {
                animation: slideIn 0.3s ease-out;
            }

            .animate-slide-out {
                animation: slideOut 0.3s ease-in;
            }
        </style>
    </body>
</html>