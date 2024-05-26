<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use HasFactory;

    protected $table = 'accounts';

    protected $fillable = [
        'account_number',
        'client_id',
        'type',
        'created_by'
    ];

    const TYPE_COURANT = 'Compte courant';
    const TYPE_SAVING = 'Compte épargne';

    const TYPES = [
        'courant' => self::TYPE_COURANT,
        'epargne' => self::TYPE_SAVING,
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'account_id', 'id');
    }
}
