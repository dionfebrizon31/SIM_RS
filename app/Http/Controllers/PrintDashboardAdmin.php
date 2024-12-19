<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\User;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Mpdf\Mpdf;


class PrintDashboardAdmin extends Controller
{
    function PrintSuratCuti($hash)
    {        
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4', // Atau format kustom jika diperlukan
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0,
            'margin_header' => 0,
            'margin_footer' => 0
        ]);

        $slug = User::where('slugname', $hash)->first(); // Cari user berdasarkan slug
        $cuti = Cuti::find($slug->id);

        $tanggalAwal = Carbon::parse($cuti->awalcuti);  // Misalnya tanggal mulai cuti
        $tanggalAkhir = Carbon::parse($cuti->akhircuti);  // Misalnya tanggal akhir cuti
        // Menghitung jumlah hari di antara dua tanggal (termasuk tanggal awal dan akhir)
        $jumlahHari = $tanggalAwal->diffInDays($tanggalAkhir) + 1;
        $NativeVariabel = new NativeVariabel();
        $jumlahHariText = $NativeVariabel->convertNumberToText($jumlahHari);


        // $countForYear = Cuti::whereYear('created_at', 2024)->count();
        $countForYear = Cuti::where('users_id', $slug->id)
            ->whereYear('created_at', 2024)
            ->count();
        $data = [
            'cuti' => $cuti,
            'jumlahHari' => $jumlahHari,
            'texthari' => $jumlahHariText,
            'countlibur' => $countForYear
            // Data lainnya
        ];

        $html = view('dashboard.cuti.suratcuti', $data)->render();  // Render view menjadi HTML
        // Menulis HTML ke PDF
        // $mpdf->WriteHTML(view('dashboard.cuti.suratcuti' ));
        $mpdf->WriteHTML($html);
        $mpdf->Output();

    }
   
        

    public function PrintAllAbsensi()
    {
        // Inisialisasi mPDF hanya sekali
        $mpdf = new Mpdf([
            'orientation' => 'L',
            'mode' => 'utf-8',
            'format' => 'A4', // Atau format kustom jika diperlukan
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0,
            'margin_header' => 0,
            'margin_footer' => 0
        ]);

        // Ambil data absensi yang diurutkan berdasarkan absen_at
        $absensi = Absensi::orderBy('absen_at', 'asc')->get();

        // Ambil tanggal pertama dan terakhir dari data absensi
        $startDate = Carbon::parse($absensi->first()->absen_at)->startOfDay(); // Mulai hari
        $endDate = Carbon::parse($absensi->last()->absen_at)->endOfDay(); // Akhiri hari

        // Buat array untuk menampung data absensi berdasarkan tanggal
        $datesRange = [];
        $currentDate = $startDate;

        // Loop untuk membuat rentang tanggal antara startDate dan endDate
        while ($currentDate <= $endDate) {
            $datesRange[] = $currentDate->toDateString(); // Simpan tanggal dalam format YYYY-MM-DD
            $currentDate->addDay(); // Tambahkan 1 hari
        }

        // Array untuk menampung data absensi per user
        $Users = [];

        // Loop untuk setiap item data absensi
        foreach ($absensi as $item) {
            $userId = $item->user_id;
            $tanggal = Carbon::parse($item->absen_at)->toDateString(); // Format tanggal YYYY-MM-DD

            // Inisialisasi array untuk user jika belum ada
            if (!isset($Users[$userId])) {
                $Users[$userId] = [
                    'nama' => $item->user->name, // Mengambil nama dari relasi user
                    'absensi' => [] // Array untuk data absensi per tanggal
                ];
            }

            // Tentukan status absensi dan pastikan data checkin/checkout tidak tumpang tindih
            $status = $item->status;
            $waktu = Carbon::parse($item->absen_at)->format('H:i'); // Format waktu (jam:menit)

            // Pastikan kita hanya menambahkan status yang relevan per tanggal
            if ($status == 'checkin') {
                $Users[$userId]['absensi'][$tanggal]['checkin'] = $waktu;
            } elseif ($status == 'checkout') {
                $Users[$userId]['absensi'][$tanggal]['checkout'] = $waktu;
            } elseif ($status == 'latest') {
                $Users[$userId]['absensi'][$tanggal]['latest'] = $waktu;
            }
        }
        // Menambahkan Alfa untuk tanggal yang tidak ada data absensi
        foreach ($Users as $userId => $userData) {
            foreach ($datesRange as $tanggal) {
                // Jika tanggal tidak ada di data absensi, tambahkan status Alfa
                if (!isset($Users[$userId]['absensi'][$tanggal]['checkin'])) {
                    $Users[$userId]['absensi'][$tanggal]['checkin'] = 'Alfa'; // Set Alfa untuk checkin jika tidak ada
                
                }
                if (!isset($Users[$userId]['absensi'][$tanggal]['checkout'])) {
                    $Users[$userId]['absensi'][$tanggal]['checkout'] = 'Alfa'; // Set Alfa untuk checkout jika tidak ada
                }
                if (!isset($Users[$userId]['absensi'][$tanggal]['latest'])) {
                    $Users[$userId]['absensi'][$tanggal]['latest'] = 'Alfa'; // Set Alfa untuk latest jika tidak ada
                }
            }
        }


        // Siapkan data untuk dikirim ke view
        $data = [
            'Users' => $Users, // Mengirim data absensi per user dan tanggal
            'datesRange' => $datesRange // Rentang tanggal yang dihasilkan
        ];

        // Render view ke HTML
        $html = view('dashboard.absensi.PrintAllAbsensi', $data)->render();

        // Menulis HTML ke PDF
        $mpdf->WriteHTML($html);

        // Output PDF ke browser
        $mpdf->Output();
    }

}    
