<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Income;
use App\Models\Expense;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'pro_users' => User::where('plan', 'pro')->count(),
            'total_income' => Income::where('status', 'confirmed')->sum('amount'),
            'total_expenses' => Expense::where('status', 'completed')->sum('amount'),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function users()
    {
        $users = User::paginate(20);
        return view('admin.users', compact('users'));
    }

    public function categories()
    {
        $categories = Category::orderBy('type')->orderBy('name')->get();
        return view('admin.categories', compact('categories'));
    }

    public function updatePlan(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'plan' => 'required|in:free,pro'
        ]);

        $user->update(['plan' => $request->plan]);

        return redirect()->back()->with('success', 'User plan updated successfully.');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense'
        ]);

        Category::create([
            'name' => $request->name,
            'type' => $request->type,
            'user_id' => null // Global category
        ]);

        return redirect()->back()->with('success', 'Category created successfully.');
    }
}
