<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absensi extends Model
{
    use HasFactory;
    protected $dates = ['absen_at', 'checkout_at']; // Menentukan kolom yang harus dikonversi menjadi objek Carbon
    // protected $dates = ['absen_at'];  // Menyatakan bahwa absen_at adalah kolom datetime
    protected $fillable = ['user_id','tgl','bln','tahun','status', 'latitude', 'longitude', 'absen_at'];
    // protected $timestamp = false;
    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
