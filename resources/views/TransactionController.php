<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'type' => 'required|in:income,expense',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
            'pcb_amount' => 'nullable|numeric|min:0',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // Max 2MB
        ]);

        if ($validatedData['type'] === 'income') {
            $incomeData = [
                'user_id' => Auth::id(),
                'description' => $validatedData['description'],
                'amount' => $validatedData['amount'],
                'category_id' => $validatedData['category_id'],
                'date' => $validatedData['date'],
                'notes' => $validatedData['notes'],
                'pcb_amount' => $validatedData['pcb_amount'] ?? null,
                'status' => 'confirmed', // As per documentation
            ];

            if ($request->hasFile('attachment')) {
                // Store in 'storage/app/public/attachments/{user_id}'
                $path = $request->file('attachment')->store('attachments/' . Auth::id(), 'public');
                $incomeData['attachment'] = $path;
            }

            Income::create($incomeData);

            return redirect()->route('dashboard')->with('success', 'Income recorded successfully.');
        }

        return redirect()->back()->with('error', 'Invalid transaction type.');
    }
}