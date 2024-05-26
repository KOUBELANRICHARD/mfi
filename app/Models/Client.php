<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    const GENDER_MAN = 'Monsieur';
    const GENDER_WOMAN = 'Madame';
    const GENDER_YOUNG_WOMAN = 'Mademoiselle';

    const GENDER = [
        'monsieur' => self::GENDER_MAN,
        'madame' => self::GENDER_WOMAN,
        'mademoiselle' => self::GENDER_YOUNG_WOMAN,
    ];

    protected $fillable = [
        'name',
        'photo',
        'address',
        'location',
        'gender',
        'country',
        'created_by',
    ];

    public function transactions(): HasManyThrough
    {
        return $this->hasManyThrough(Transaction::class, Account::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // has many accounts
    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class, 'client_id', 'id');
    }
}
