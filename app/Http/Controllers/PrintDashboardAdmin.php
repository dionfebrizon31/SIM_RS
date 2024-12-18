<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\User;
use App\Models\Absensi;
use Illuminate\Http\Request;

class PrintDashboardAdmin extends Controller
{
    function PrintSuratCuti($hash)
    {
        
        $slug = User::where('slugname', $hash)->first(); // Cari user berdasarkan slug
        $cuti = Cuti::find($slug->id);
       
        $tanggalAwal = Carbon::parse($cuti->awalcuti);  // Misalnya tanggal mulai cuti
        $tanggalAkhir = Carbon::parse($cuti->akhircuti);  // Misalnya tanggal akhir cuti
        // Menghitung jumlah hari di antara dua tanggal (termasuk tanggal awal dan akhir)
        $jumlahHari = $tanggalAwal->diffInDays($tanggalAkhir) + 1; 
        $NativeVariabel =  new NativeVariabel();
        $jumlahHariText = $NativeVariabel->convertNumberToText($jumlahHari);

        
        // $countForYear = Cuti::whereYear('created_at', 2024)->count();
        $countForYear = Cuti::where('users_id', $slug->id)
                    ->whereYear('created_at', 2024)
                    ->count();
        $data = [
            'cuti' => $cuti,
            'jumlahHari' => $jumlahHari,
            'texthari'=> $jumlahHariText,
            'countlibur'=> $countForYear
            // Data lainnya
        ];

        $html = view('dashboard.cuti.suratcuti', $data)->render();  // Render view menjadi HTML
        // Menulis HTML ke PDF
        $mpdf = new \Mpdf\Mpdf();
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
        // Define a default page size/format by array - page will be 190mm wide x 236mm height
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [190, 236]]);

        // Define a default page using all default values except "L" for Landscape orientation
        $mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);
        // $mpdf->WriteHTML(view('dashboard.cuti.suratcuti' ));
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    
    }
    function PrintAllAbsensi()
    {
   
        $mpdf = new \Mpdf\Mpdf();
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
        $mpdf = new \Mpdf\Mpdf([
            'margin_left' => 0,   // Margin kiri
            'margin_right' => 0,  // Margin kanan
            'margin_top' => 0,    // Margin atas
            'margin_bottom' => 0, // Margin bawah
            'margin_header' => 0, // Margin header
            'margin_footer' => 0  // Margin footer
        ]);
        // Define a default page size/format by array - page will be 190mm wide x 236mm height
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [190, 236]]);
        $absensi = Absensi::orderBy('userid', 'asc')
                    ->orderBy('absen_at', 'asc')  // Kemudian urutkan berdasarkan tanggal
                    ->get();
        $tgldata = Absensi::orderBy('absen_at', 'asc')->get();

        $data = [
           'absensi'=> $absensi,
            'tanggal'=>$tgldata// Data lainnya
        ];
        // Define a default page using all default values except "L" for Landscape orientation
        $mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
        // Menulis HTML dengan view() dari Laravel
        $html = view('dashboard.absensi.PrintAllAbsensi',$data)->render();  // Render view menjadi HTML
        // Menulis HTML ke PDF
        
        $mpdf->WriteHTML($html);

        $mpdf->Output();
    
    }
}
