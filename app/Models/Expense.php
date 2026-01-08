<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    protected $fillable = [
        'user_id',
        'description',
        'amount',
        'category_id',
        'date',
        'status',
        'notes',
        'is_deductible',
        'receipt_url',
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
        'is_deductible' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}