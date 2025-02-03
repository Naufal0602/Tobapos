<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    protected $fillable = [
        'total',
        'payment_method',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(TransactionItem::class);
    }

    protected function casts(): array
    {
        return [
            'total' => 'decimal:2',
        ];
    }
}
