<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country',
        'county',
        'settlement',
        'street',
        'streetNumber',
        'contact_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'deleted_at' => 'timestamp',
        'contact_id' => 'integer',
    ];

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
}
