<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pengajuan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function skck(): HasOne
    {
        return $this->hasOne(Skck::class);
    }

    public function domisili(): HasOne
    {
        return $this->hasOne(Domisili::class);
    }

    public function umum(): HasOne
    {
        return $this->hasOne(Umum::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(LogPengajuan::class);
    }
}
