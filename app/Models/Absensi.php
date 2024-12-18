<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','tgl','bln','tahun','status', 'latitude', 'longitude', 'absen_at'];
    // protected $timestamp = false;
    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
