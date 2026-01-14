<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentMethod;
use App\Models\Category;

class SettingsController extends Controller
{
    public function index()
    {
        return redirect()->route('settings.profile');
    }

    public function profile()
    {
        return view('settings.profile', [
            'user' => Auth::user(),
            'active_tab' => 'profile'
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password changed successfully.');
    }

    public function paymentMethods()
    {
        $paymentMethods = PaymentMethod::where('user_id', Auth::id())
            ->orWhereNull('user_id') // Show system defaults too
            ->get();
        return view('settings.payment-methods', [
            'paymentMethods' => $paymentMethods,
            'active_tab' => 'payment-methods'
        ]);
    }

    public function storePaymentMethod(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:50',
        ]);

        PaymentMethod::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'type' => $request->type ?? 'Bank',
        ]);

        return back()->with('success', 'Payment method added successfully.');
    }

    public function destroyPaymentMethod($id)
    {
        $method = PaymentMethod::where('user_id', Auth::id())->findOrFail($id);
        $method->delete();

        return back()->with('success', 'Payment method deleted successfully.');
    }

    public function categories()
    {
        $categories = Category::where('user_id', Auth::id())
            ->orWhereNull('user_id') // Show system defaults too
            ->get();
        return view('settings.categories', [
            'categories' => $categories,
            'active_tab' => 'categories'
        ]);
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:7',
        ]);

        Category::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'type' => $request->type,
            'icon' => $request->icon ?? 'category',
            'color' => $request->color ?? '#618975',
        ]);

        return back()->with('success', 'Category added successfully.');
    }

    public function destroyCategory($id)
    {
        $category = Category::where('user_id', Auth::id())->findOrFail($id);
        $category->delete();

        return back()->with('success', 'Category deleted successfully.');
    }

    public function preferences()
    {
        return view('settings.preferences', [
            'user' => Auth::user(),
            'active_tab' => 'preferences'
        ]);
    }

    public function updatePreferences(Request $request)
    {
        $user = Auth::user();

        $user->update([
            'show_tooltips' => $request->has('show_tooltips'),
        ]);

        return back()->with('success', 'Preferences updated successfully.');
    }
}
