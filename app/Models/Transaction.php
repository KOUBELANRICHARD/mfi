<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'amount',
        'type',
        'reference',
        'title',
        'value_date',
        'account_id',
        'client_id',
        'agency_id',
        'created_by'
    ];

    protected $casts = [
        'value_date' => 'datetime',
    ];

    const TYPE_DEBIT = 'Débit';
    const TYPE_CREDIT = 'Crédit';

    const TYPES = [
        'DEBIT' => self::TYPE_DEBIT,
        'CREDIT' => self::TYPE_CREDIT,
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
