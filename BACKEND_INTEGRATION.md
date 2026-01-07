# Backend Integration Guide

## Overview
This guide provides step-by-step instructions to integrate the frontend modal form with your Laravel backend.

---

## Step 1: Update Routes

**File**: `routes/web.php`

```php
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Add these transaction routes:
    Route::post('/api/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/api/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::put('/api/transactions/{id}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/api/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
});
```

---

## Step 2: Update TransactionController

**File**: `app/Http/Controllers/TransactionController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Store a newly created transaction
     */
    public function store(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:income,expense',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
            'is_deductible' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = Auth::user();
            $type = $request->input('type');

            if ($type === 'income') {
                $transaction = Income::create([
                    'user_id' => $user->id,
                    'description' => $request->input('description'),
                    'amount' => $request->input('amount'),
                    'category_id' => $request->input('category_id'),
                    'date' => $request->input('date'),
                    'notes' => $request->input('notes'),
                    'status' => 'confirmed'
                ]);
            } else {
                $transaction = Expense::create([
                    'user_id' => $user->id,
                    'description' => $request->input('description'),
                    'amount' => $request->input('amount'),
                    'category_id' => $request->input('category_id'),
                    'date' => $request->input('date'),
                    'notes' => $request->input('notes'),
                    'is_deductible' => $request->input('is_deductible', false),
                    'status' => 'completed'
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => ucfirst($type) . ' added successfully!',
                'data' => $transaction
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update a transaction
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $type = $request->input('type');

        if ($type === 'income') {
            $transaction = Income::where('user_id', $user->id)
                ->findOrFail($id);
        } else {
            $transaction = Expense::where('user_id', $user->id)
                ->findOrFail($id);
        }

        $validator = Validator::make($request->all(), [
            'description' => 'sometimes|required|string|max:255',
            'amount' => 'sometimes|required|numeric|min:0.01',
            'category_id' => 'sometimes|required|exists:categories,id',
            'date' => 'sometimes|required|date',
            'notes' => 'nullable|string|max:1000',
            'is_deductible' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $transaction->update($request->only([
                'description', 'amount', 'category_id', 'date', 'notes', 'is_deductible'
            ]));

            return response()->json([
                'success' => true,
                'message' => ucfirst($type) . ' updated successfully!',
                'data' => $transaction
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a transaction
     */
    public function destroy($id)
    {
        $user = Auth::user();
        
        $transaction = Income::where('user_id', $user->id)->find($id) 
                      ?? Expense::where('user_id', $user->id)->find($id);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found'
            ], 404);
        }

        try {
            $type = $transaction instanceof Income ? 'income' : 'expense';
            $transaction->delete();

            return response()->json([
                'success' => true,
                'message' => ucfirst($type) . ' deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
```

---

## Step 3: Update Dashboard Blade with Form Submission Handler

**File**: `resources/views/dashboard.blade.php` (Update the JavaScript section)

Replace the form submission handler in the script section:

```javascript
// Form submission
transactionForm.addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const data = {
        type: formData.get('type'),
        description: formData.get('description'),
        amount: parseFloat(formData.get('amount')),
        category_id: formData.get('category_id'),
        date: formData.get('date'),
        notes: formData.get('notes'),
        is_deductible: formData.get('is_deductible') === 'on'
    };

    try {
        const response = await fetch('{{ route("transactions.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.success) {
            // Show success message
            showNotification(result.message, 'success');
            
            // Close modal
            closeTransactionModal();
            
            // Refresh dashboard data (reload page for now)
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            // Show error messages
            const errors = result.errors || {};
            const errorMessages = Object.values(errors)
                .flat()
                .join('\n');
            
            showNotification(errorMessages || 'Failed to save transaction', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('An error occurred. Please try again.', 'error');
    }
});

// Notification helper function
function showNotification(message, type = 'info') {
    // Create a toast notification
    const toast = document.createElement('div');
    toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg text-white z-50 ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    } shadow-lg`;
    toast.textContent = message;
    document.body.appendChild(toast);

    // Auto remove after 3 seconds
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
```

---

## Step 4: Update Models

### Income Model

**File**: `app/Models/Income.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = [
        'user_id',
        'description',
        'amount',
        'category_id',
        'date',
        'notes',
        'status'
    ];

    protected $casts = [
        'date' => 'datetime',
        'amount' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
```

### Expense Model

**File**: `app/Models/Expense.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'user_id',
        'description',
        'amount',
        'category_id',
        'date',
        'notes',
        'is_deductible',
        'status'
    ];

    protected $casts = [
        'date' => 'datetime',
        'amount' => 'decimal:2',
        'is_deductible' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
```

---

## Step 5: Create Category Seeder (if not exists)

**File**: `database/seeders/CategorySeeder.php`

```php
<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Income Categories
        $incomeCategories = ['Salary', 'Freelance Work', 'Business Income', 'Investment Returns', 'Other Income'];
        foreach ($incomeCategories as $name) {
            Category::firstOrCreate(['name' => $name, 'type' => 'income']);
        }

        // Expense Categories
        $expenseCategories = ['Housing', 'Transport', 'Lifestyle', 'Food & Dining', 'Utilities', 'Equipment', 'Professional Services', 'Other'];
        foreach ($expenseCategories as $name) {
            Category::firstOrCreate(['name' => $name, 'type' => 'expense']);
        }
    }
}
```

Run seeder:
```bash
php artisan db:seed --class=CategorySeeder
```

---

## Step 6: Update Category Migration

If your category table doesn't have a `type` column, create a migration:

```bash
php artisan make:migration add_type_to_categories_table
```

**Migration file**:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->enum('type', ['income', 'expense'])->default('expense')->after('name');
        });
    }

    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
```

Run:
```bash
php artisan migrate
```

---

## Step 7: Testing

### Test with Postman/Insomnia

**POST** `/api/transactions`

```json
{
  "type": "income",
  "description": "Freelance Web Design",
  "amount": 5000,
  "category_id": 1,
  "date": "2026-01-07",
  "notes": "Project for client ABC",
  "is_deductible": false
}
```

**Expected Response**:
```json
{
  "success": true,
  "message": "Income added successfully!",
  "data": {
    "id": 1,
    "user_id": 1,
    "description": "Freelance Web Design",
    "amount": "5000.00",
    "category_id": 1,
    "date": "2026-01-07",
    "notes": "Project for client ABC",
    "status": "confirmed",
    "created_at": "2026-01-07T10:00:00.000000Z",
    "updated_at": "2026-01-07T10:00:00.000000Z"
  }
}
```

---

## Step 8: Update Category Retrieval (Optional)

To make categories dynamic in the frontend, you can add an endpoint:

```php
// Add to TransactionController
public function getCategories($type)
{
    $categories = Category::where('type', $type)->get();
    return response()->json($categories);
}
```

Add route:
```php
Route::get('/api/categories/{type}', [TransactionController::class, 'getCategories']);
```

Update JavaScript to fetch categories dynamically (optional enhancement).

---

## Troubleshooting

### Issue: CSRF token mismatch
**Solution**: Ensure CSRF token is included in request headers

### Issue: 422 Validation error
**Solution**: Check validation error response and ensure all required fields are provided

### Issue: 404 Route not found
**Solution**: Make sure routes are properly registered and artisan route cache is cleared

```bash
php artisan route:clear
php artisan config:clear
```

### Issue: Mass assignment error
**Solution**: Ensure model `$fillable` property includes all fields

---

## Security Considerations

1. ✅ **CSRF Protection**: Included in form submission
2. ✅ **Authentication**: Routes protected with `middleware('auth')`
3. ✅ **Authorization**: Check user owns transaction in controller
4. ✅ **Validation**: All inputs validated
5. ✅ **SQL Injection**: Using Eloquent ORM prevents SQL injection
6. ✅ **XSS Protection**: Use `htmlspecialchars()` in Blade (automatic)

---

## Performance Tips

1. **Add Indexing**: Index `user_id`, `date`, `category_id` columns
2. **Eager Loading**: Use `with('category')` to prevent N+1 queries
3. **Pagination**: Implement pagination for transaction lists
4. **Caching**: Cache user statistics (totals) with cache keys

---

## Next Features

- [ ] Edit existing transactions
- [ ] Bulk import transactions
- [ ] Receipt image upload
- [ ] Recurring transactions
- [ ] Transaction filters/search
- [ ] Export to CSV/PDF
- [ ] Mobile app API

---

**Status**: Ready to implement
**Last Updated**: January 2026
