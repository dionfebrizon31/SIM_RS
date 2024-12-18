<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Nativevariabel extends Controller
{
    
    public function haversine($lat1, $lon1)
    { 
        // object perusahaan untuk cek distance
            $lat2 = -0.9472743;
            $lon2 =  100.6133113;
        // end

        $earthRadius = 6371;

        // Mengkonversi derajat ke radian
        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        // Perbedaan koordinat
        $latDiff = $latTo - $latFrom;
        $lonDiff = $lonTo - $lonFrom;

        // Haversine formula
        $a = sin($latDiff / 2) * sin($latDiff / 2) +
             cos($latFrom) * cos($latTo) *
             sin($lonDiff / 2) * sin($lonDiff / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        // Menghitung jarak
        $distance = $earthRadius * $c;

        return $distance; // Jarak dalam kilometer
    }
    public function convertNumberToText($number)
    {
        $number = (int) $number;  // Pastikan angka adalah integer
        
        // Array angka satuan dan puluhan
        $arr = [
            1 => 'satu',
            2 => 'dua',
            3 => 'tiga',
            4 => 'empat',
            5 => 'lima',
            6 => 'enam',
            7 => 'tujuh',
            8 => 'delapan',
            9 => 'sembilan',
            10 => 'sepuluh',
            11 => 'sebelas',
            12 => 'dua belas',
            13 => 'tiga belas',
            14 => 'empat belas',
            15 => 'lima belas',
            16 => 'enam belas',
            17 => 'tujuh belas',
            18 => 'delapan belas',
            19 => 'sembilan belas',
            20 => 'dua puluh',
            30 => 'tiga puluh',
            40 => 'empat puluh',
            50 => 'lima puluh',
            60 => 'enam puluh',
            70 => 'tujuh puluh',
            80 => 'delapan puluh',
            90 => 'sembilan puluh',
            100 => 'seratus'
        ];

        // Jika angka sudah ada dalam array
        if (isset($arr[$number])) {
            return $arr[$number];
        }

        // Untuk angka di atas 20 dan kurang dari 100
        $tens = floor($number / 10) * 10;  // Mengambil puluhan (20, 30, dst)
        $ones = $number % 10;  // Mengambil satuan (1, 2, dst)

        // Jika angka lebih dari 20 dan kurang dari 100
        if ($number > 20 && $number < 100) {
            // Jika angka satuan lebih dari 0
            if ($ones != 0) {
                return $arr[$tens] . ' ' . $arr[$ones];
            } else {
                // Jika hanya puluhan
                return $arr[$tens];
            }
        }

        // Jika lebih dari 100, kita bisa menambahkan case lain (misalnya seratus satu, seratus dua, dst)
        if ($number == 100) {
            return $arr[100];
        }

        return 'Angka tidak valid';  // Jika angka di luar yang dapat dikonversi
    }
}
