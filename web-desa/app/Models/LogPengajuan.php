<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogPengajuan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function pengajuan() : BelongsTo {
        return $this->belongsTo(Pengajuan::class);
    }

    function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }
}
