<?php

use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Post;
use App\Models\User;
use App\Models\Absensi;
use App\Models\Jobdesk;
use App\Models\Jabatans;
use App\Models\Jeniscuti;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use PHPUnit\TextUI\Configuration\Group;
use App\Http\Controllers\DashboardAdmin;
use App\Http\Controllers\DashboardAdminShow;
use App\Http\Controllers\PrintDashboardAdmin;

use PhpParser\Node\Scalar\MagicConst\Function_;

Route::get('/uji', function () {
    return view('dashboard.absensi.PrintAllAbsensi');
});
Route::post('/save-Absensi', [DashboardAdmin::class, 'Absensi']);
Route::get('/aa', [DashboardAdmin::class, 'saveLocation']);




Route::get('/', function () {
    // Ambil semua postingan dengan status 'public' dan paginasi
    $posts = Post::where('status', 'public')->latest()->paginate(2);

    return view('index', ['tittle' => 'Dashboard', 'posts' => $posts]);
});

Route::get('storage/{folder}/{filename}', [DashboardAdmin::class, 'ShowPublicPostingan']);
Route::get('penyimpanan/{divisi}/{username}/{filename}', [DashboardAdmin::class, 'ShowProfileUser']);

Route::get('/login', function () {
    return view('login');
});
Route::get('/visitor-login', function () {
    return view('loginvisitor');
});

Route::post('/visitor-login',[DashboardAdmin::class,'loginvisitor']);

Route::post('/login',[DashboardAdmin::class,'login']);

Route::get('/logout',[DashboardAdmin::class,'logout']);

Route::middleware(['auth'])->group(function(){
    // absensi checkiin
    // Route::get('/absensi', function () {
    //     $userId = Auth::user()->id;
        
    //     // Mendapatkan tanggal hari ini
    //     $today = Carbon::now();
    //     $day = $today->day;
    //     // Mencari semua data absensi untuk hari ini berdasarkan user_id dan tanggal
    //     $absensi = Absensi::where('user_id', $userId)
    //         ->where('tgl', $day)
    //         ->get();

    //     // Menentukan tombol yang akan ditampilkan
    //     $tombol = ['checkin' => false, 'checkout' => false];

    //     // Jika tidak ada absensi untuk hari ini

    //     $tombol = ['checkin' => false, 'checkout' => false];
    //     // Cek apakah ada data absensi
    //     if ($absensi->isEmpty()) {
    //         // Jika tidak ada record absensi, tampilkan tombol Check-In untuk pertama kalinya
    //         $tombol['checkin'] = true;
    //     } else {
    //         // Iterasi melalui setiap record absensi
    //         foreach ($absensi as $record) {
    //             // Ambil semua status absensi untuk hari ini
    //             $statuses = $record->pluck('status')->toArray();

    //             // Jika ada status 'checkin' atau 'latest', tampilkan tombol Check-Out
    //             if (in_array('latest', $statuses) || in_array('checkin', $statuses)) {
    //                 $tombol['checkout'] = true;
    //             }

    //             // Jika ada status 'checkout', sembunyikan kedua tombol
    //             if (in_array('checkout', $statuses)) {
    //                 // Jika sudah checkout, sembunyikan kedua tombol
    //                 $tombol = ['checkin' => false, 'checkout' => false];
    //                 break;  // Keluar dari perulangan jika status checkout sudah ada
    //             }
    //         }
    //     }
    //     // dd($tombol);
    //     // dd($absensi->count());

    //     return view('dashboard.absensi.absensi', [
    //         'tittle' => 'Absensi',
    //         'tombol' => $tombol
    //     ]);
    // });
    Route::get('/absensi', [DashboardAdminShow::class,'AbsensiController']);
    Route::get('/data-absensi', function(){
        // Mencari semua data absensi untuk hari ini berdasarkan user_id dan tanggal pada absen_at
        $absensi = Absensi::orderBy('userid', 'asc')->get();

        return view('dashboard.absensi.dataabsensi',
        [
            'tittle'=>'Data Admin Absensi',
            'absensi'=> $absensi
        ]);
    });

    // 
    Route::get('/dashboard', function () {

        return view('dashboard.welcome',
        ['tittle' => 'Dashboard']);
    });
    // area admin
    Route::get('/jobdesk', function () {
        return view('dashboard.jobdesk',['tittle' => 'Job desk','karyawans'=> User::all()]);
    });    
    ////////////////////////////  AREA ADMIN SETTING Admins     /////////////////////////////////////////////
    Route::get('/jabatans', function () {
        return view('dashboard.jabatans',['tittle' => 'Jabatan','jabatans'=> Jabatans::all()]);
    });

    Route::get('/detail-jabatan/{id}', function ($id) {
        $jabatans = Jabatans::with('jobdesks')->findOrFail($id);
        $jabatansall = Jabatans::all();
        // Mengembalikan view dengan data jabatan dan jobdesk
        return view('dashboard.jabatan', [
            'tittle' => 'Detail Jabatan',
            'jabatansall' => $jabatansall,
            'jabatans' => $jabatans,
            'jobdesks' => $jabatans->jobdesks
        ]);
    });
    Route::post('/data/{type}/{action}',[DashboardAdmin::class,'keloladata']);
    Route::post('/data/{type}/{action}/{id}',[DashboardAdmin::class,'keloladata']);
    Route::delete('/data/{type}/{action}/{id}',[DashboardAdmin::class,'keloladata']);

    ////////////////////////////  AREA ADMIN SETTING Admins     /////////////////////////////////////////////
    Route::get('/admins', function () {
        $jabatans =  Jabatans::all();
        $users = User::all();
        return view('dashboard.dadmin',['tittle' => 'Admins','users'=> $users ,'jabatans'=>$jabatans ]);
    });
    Route::post('/admintambah',[DashboardAdmin::class,'tambahdata']);
    Route::post('/adminedit/{id}',[DashboardAdmin::class,'editdata']);
    Route::delete('/admindelete/{id}',[DashboardAdmin::class,'delete']);


    // area karyawan
    Route::get('/User', function () {
        $karyawans = User::latest()->get();
        $jabatans =  Jabatans::all();
        return view('dashboard.user',['tittle' => 'User','User'=> $karyawans,'jabatans'=> $jabatans]);
    });

    Route::get('/posts', function () {
        $posts = Post::latest()->get();
        return view('dashboard.posts',[
            'tittle' => 'Kelola Postingan',
            'posts'=> $posts
        ]);
    });

    // pengajuan cuti sistem from dion febrizon
    Route::get('/print-all-absensi', [PrintDashboardAdmin::class,'PrintAllAbsensi']);
    Route::get('/suratcuti/{slug}', [PrintDashboardAdmin::class,'PrintSuratCuti']);
    
    Route::get('/jenis-cuti',function (){
        $jeniscutis = Jeniscuti::latest()->get();
        return view('dashboard.cuti.jeniscuti',[
            'tittle' => 'Kelola Jenis Cuti',
            'jeniscutis'=>$jeniscutis
        ]
    );
    });
    Route::get('/cuti',function (){
        $cutis = Cuti::latest()->get();
        $jeniscutis = Jeniscuti::latest()->get();
       
        return view('dashboard.cuti.cuti',[
            'tittle' => 'Data Cuti',
            'cutis'=>$cutis,
            'jeniscutis'=>$jeniscutis
        ]
    );
    });
    Route::get('/cuti-detail/{id}', function ($id) {
        $detailcuti = Cuti::with('users')->findOrFail($id);
       
        // Mengembalikan view dengan data jabatan dan jobdesk
        return view('dashboard.cuti.cutidetail', [
            'tittle' => 'Detail Cuti',
            'cuti' => $detailcuti,
            
        ]);
    });

});


