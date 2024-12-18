<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardAdminShow extends Controller
{
    public function AbsensiController(){
        $userId = Auth::user()->id;

        // Mendapatkan tanggal hari ini tanpa jam
        $todayDate = Carbon::now()->toDateString(); // Format Y-m-d, misalnya "2024-12-11"
        
        // Mencari semua data absensi untuk hari ini berdasarkan user_id dan tanggal pada absen_at
        $absensi = Absensi::where('user_id', $userId)
            ->whereDate('absen_at', $todayDate)  // Menggunakan whereDate untuk memastikan hanya membandingkan tanggal saja
            ->get();
        
        // Inisialisasi tombol dengan nilai default
        $tombol = ['checkin' => false, 'checkout' => false];
        
        // Cek apakah ada data absensi untuk hari ini
        if ($absensi->isEmpty()) {
            // Jika belum ada record absensi untuk hari ini, tampilkan tombol Check-In
            $tombol['checkin'] = true;
        } else {
            // Jika sudah ada data absensi untuk hari ini, cek statusnya satu per satu
            foreach ($absensi as $record) {
                $status = $record->status;

                if($status == 'latest'|| $status == 'checkin'){
                    $tombol = ['checkin' => false, 'checkout' => true];
                    
                }
                if($status =='checkout'){
                    $tombol = ['checkin' => false, 'checkout' => false];
                    
                }

            }
        }
        
        // Cek hasilnya
        // dd($tombol);
        
        
        // dd($absensi->count());

        return view('dashboard.absensi.absensi', [
            'tittle' => 'Absensi',
            'tombol' => $tombol
        ]);
    }



}
