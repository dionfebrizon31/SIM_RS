<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Post;
use App\Models\User;
use App\Models\Absensi;
use App\Models\Jobdesk;
use App\Models\Jabatans;

use App\Models\Jeniscuti;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Database\Seeders\Jabatan;
use App\Helpers\LocationHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class DashboardAdmin extends Controller
{


    public function Absensi(Request $request)
    {
        try {
            $nativevariabel = new NativeVariabel();
            // Menghitung jarak pengguna dengan lokasi absensi
            $distance = $nativevariabel->haversine($request->latitude, $request->longitude);
            $absensi = new Absensi();
            // Validasi inputan latitude dan longitude
            $request->validate([
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'status' => 'required',
            ]);
            $today = Carbon::now();


            if ($distance <= 30) {
                // Memisahkan tahun, bulan, dan hari
                $year = $today->year;
                $month = $today->month;
                $day = $today->day;
                $time = now()->format('H:i');
                $hour = $today->format('H');  // Format jam (24 jam)
                $minute = $today->format('i'); // Format menit

                if($request->status =="checkin")
                {
                    $absensi->user_id = Auth::user()->id; 
                    $absensi->latitude = $request->latitude;
                    $absensi->longitude = $request->longitude;
                    $absensi-> tgl = $day;
                    $absensi->bln = $month;
                    $absensi->tahun = $year;
                    if($time > '08:00'){
                        $absensi->status = 'latest';
                    }else{
                        $absensi->status = 'checkin';
                    }
                    $absensi-> absen_at = now();
                    $absensi->save();
                    return response()->json(['success' =>  "Sukses check-in absen pada jam $hour menit $minute status $absensi->status"]);
                }else if($request->status =="checkout"){
                    $absensi->user_id = Auth::user()->id; 
                    $absensi->latitude = $request->latitude;
                    $absensi->longitude = $request->longitude;
                    $absensi-> tgl = $day;
                    $absensi->bln = $month;
                    $absensi->tahun = $year;
                    $absensi->status = 'checkout';
                    $absensi-> absen_at = now();
                    $absensi->save();
                    return response()->json(['success' =>  "Sukses check-out absen pada jam $hour menit $minute status $absensi->status"]);
                }
                
            } 
            else {
                return response()->json(['success' =>  $distance .'status Terlalu jauh Dari Perusahaan']);
            }
          
            
        } catch (\Exception $e) {
            // Menangkap error jika ada yang gagal (misalnya validasi atau penyimpanan)
            return redirect('/uji')->with('gagal', 'Tanggal awal tidak boleh lebih besar dari tanggal akhir.');
        }
    }


    public function ShowPublicPostingan($folder, $filename)
    {
        $path = storage_path('app/public/' . $folder . '/' . $filename);
        
        if (!file_exists($path)) {
            abort(404); // Jika tidak ada, tampilkan halaman 404
        }
        return response()->file($path);
    }
    public function ShowProfileUser($divisi, $username,$filename)
    {
        $path = storage_path('app/public/user/' . $divisi . '/' . $username . '/' . $filename);
        
        if (!file_exists($path)) {
            abort(404); // Jika tidak ada, tampilkan halaman 404
        }
        return response()->file($path);
    }


    public function login(Request $request){
        $data = $request->only('username','password');
        iname: if(Auth::attempt($data)){
            $request->session()->regenerate();
            return redirect('/dashboard');

        }else{    
            return redirect()->back()->with('gagal','Username Atau Passsword Salah ');
        }
    }
    public function loginvisitor(Request $request){
        $data = $request->only('username','password');
        if (Auth::guard('visitor')->attempt($data)) {
           $request->session()->regenerate();
           return redirect('/');
        }
        else
        {    
            return redirect()->back()->with('gagal','Username Atau Passsword Salah ');
        }
    }


    public function logout()
    {
        if (Auth::guard('visitor')->check() && Auth::guard('visitor')->user()->role == 'users') {
            Auth::guard('visitor')->logout();
            return redirect('/'); // Optional: Redirect to login page after logout
        }else{
            Auth::logout();
            return redirect('/'); // Optional: Redirect to login page after logout
        }
        
        
    }

   
    public function keloladata(Request $request, $type,$action,$id="-1")
    {
        
        //type adalah nama tabel
        //action adalah tambah,edit,delete
        //id adalah id tabel database
        
        if((auth::user()->role== 'staff'|| auth::user()->role== 'admins') && $type ==  "cutis" && $action == "tambah" && $id == -1) {
  
            $validator = Validator::make($request->all(), [
                'jenis' => 'required',
                'keterangan' => 'required',
                'tglwal' => 'required',
                'tglakhir' => 'required',
            ]);

            // $tanggalawalcuti =  Carbon::parse($request->tglwal)->format('d F Y');
            // $tanggalakhircuti =  Carbon::parse($request->tglakhir)->format('d F Y');
            if ($request->tglawal > $request->tglakhir) {
                return redirect('/cuti')->with('gagal', 'Tanggal awal tidak boleh lebih besar dari tanggal akhir.');
            }
            
            
            $cutis = new Cuti();
            $cutis ->users_id = auth::user()->id;
            $cutis->jeniscutis_id = $request->jeniscuti;
            $cutis->keterangan = $request->keterangan;
            $cutis->awalcuti = $request->tglawal;
            $cutis->akhircuti = $request->tglakhir;
            $cutis->status = 'pending';
            $cutis->save();
            return redirect('/cuti')->with('sukses','sukses menyimpan data Jenis Cuti');;
        }
        else if ((auth::user()->role == 'staff') && $type == "cutis" && $action == "editdata") {
            $cutis = Cuti::find($request->id); // Pastikan nama modelnya sesuai, gunakan huruf kapital untuk nama model (Cuti)
            if ($request->tglawal > $request->tglakhir) {
                return redirect('/cuti')->with('gagal', 'Tanggal awal tidak boleh lebih besar dari tanggal akhir.');
            }
            $cutis ->users_id = auth::user()->id;
            $cutis->jeniscutis_id = $request->jeniscuti;
            $cutis->keterangan = $request->keterangan;
            $cutis->awalcuti = $request->tglawal;
            $cutis->akhircuti = $request->tglakhir;
            $cutis->status = 'pending';
            $cutis->save();
            if ($cutis) {
            // Lakukan operasi penghapusan atau apa pun yang diperlukan
            return redirect('/cuti')->with('sukses','sukses menyimpan data Jenis Cuti');
            }  
        }
        
        else if ((auth::user()->role == 'admins' || auth::user()->role == 'manager') && $type == "cutis" && $action == "edit") {
            try {
                
                $cutis = Cuti::find($request->id); // Pastikan nama modelnya sesuai, gunakan huruf kapital untuk nama model (Cuti)
                $cutis->status = $request->status; // Pastikan nama modelnya sesuai, gunakan huruf kapital untuk nama model (Cuti)
                $cutis-> save();
                if ($cutis) {
                    // Lakukan operasi penghapusan atau apa pun yang diperlukan
                    return response()->json([
                        'title'=>'Edited',
                        'text'=>'Data Sukses Di '.$request->status
                    ]);
                } else {
                    return response()->json(['error' => 'Record not found.'], 404);
                }
            } catch (\Exception $e) {
                // Tangani exception jika terjadi kesalahan
                return response()->json([
                        'title'=>'Edited',
                        'text'=>'Data gagal diedit'
                
                ]);  // Status 500 jika ada error internal
            }
        }
       
        

        
        // jenis cuti di bawah

        if(auth::user()->role== 'admins' && $type ==  "jeniscutis" && $action == "tambah") {
            $validator = Validator::make($request->all(), [
                'jenis' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect('/jenis-cuti')->with('gagal','Jenis Cuti Sudah Ada');
            }
            
            $savekan = new Jeniscuti();
            $savekan->jenis = $request->jenis;
            $savekan->save();
            return redirect('/jenis-cuti')->with('sukses','sukses menyimpan data Jenis Cuti');
        }
        else if(auth::user()->role== 'admins' && $type ==  "jeniscutis" && $action == "edit")
        {
            $jeniscuti = Jeniscuti::find($id);
            
            if(auth::user()->role== 'admins'){
                // Validasi input
                $validator = Validator::make($request->all(), [
               'jenis' => 'required',
                ]);
        
                if ($validator->fails()) {
                    return redirect('/jenis-cuti')->with('gagal','Jenis Cuti sudah ada');
                }
                $jeniscuti->jenis = $request->jenis;
                $jeniscuti->save();
                return redirect('/jenis-cuti')->with('sukses','sukses menyimpan data');
            }
        }
        else if(auth::user()->role== 'admins' && $type ==  "jeniscutis" && $action == "delete")
        {
            try {
                $Jeniscuti = Jeniscuti::find($id);
                $Jeniscuti->delete();
                
                return response()->json(['success' => 'Record deleted successfully.']);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to delete record.'], 500);
            }
        }




        // MERUPAKAN AREA LOKASI TABLE JABATAN DI KELOLA 

        if(auth::user()->role== 'admins' && $type ==  "jabatans" && $action == "tambah") {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:jabatans,name',
            ]);
            if ($validator->fails()) {
                return redirect('/'.$type)->with('gagal','Username atau email sudah ada');
            }
            
            $savekan = new Jabatans();
            $savekan->divisi = $request->divisi1 ?? $request->divisi2;
            $savekan->name = $request->name;
            $savekan->save();
            return redirect('/'.$type)->with('sukses','sukses menyimpan data jabatan');;
        }
        else if(auth::user()->role== 'admins' && $type ==  "jabatans" && $action == "edit")
        {
            $jabatans = Jabatans::find($id);
            
            if(auth::user()->role== 'admins'){
                // Validasi input
                $validator = Validator::make($request->all(), [
               'name' => 'required',
                ]);
        
                if ($validator->fails()) {
                    return redirect('/'.$type)->with('gagal','Username atau email sudah ada');
                }
                $jabatans->name = $request->name;
                $jabatans->save();
                return redirect('/'.$type)->with('sukses','sukses menyimpan data');
            }
        }
        else if(auth::user()->role== 'admins' && $type ==  "jabatans" && $action == "delete")
        {
            try {
                 // Temukan Jabatan berdasarkan ID
                $jabatan = Jabatans::find($id);
                // Hapus record terkait di Jobdesk yang memiliki jabatans_id
                Jobdesk::where('jabatans_id', $jabatan->id)->delete();
                user::where('jabatans_id', $id)->update(['jabatans_id' => 0]);

                $jabatanlagi = Jabatans::findOrFail($id);
                // Setelah itu, hapus Jabatan
                $jabatanlagi->delete();
                
                return response()->json(['success' => 'Record deleted successfully.']);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to delete record.'], 500);
            }
        }

        // MERUPAKAN AREA LOKASI TABLE Karyawan DI KELOLA 

        if(auth::user()->role== 'admins' && $type ==  "User" && $action == "tambah")
        {
            
            $User = new User();
            // Validasi input
            $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'name' => 'required',
            'username' => 'required|string|unique:users,username',
            'password' => 'required',
            'alamat' => 'required',
            'nohp' => 'required',
       
            'nip' => 'required',
        ]);
            

            if ($validator->fails()) {
                return redirect('/User')->with('gagal','Username atau email sudah ada');
            }
            $namepath = Jabatans::find($request->jabatans);
            $file_path = $namepath->divisi . "/" . $request->username;
            if (!file_exists($file_path)) {
                Storage::makeDirectory($file_path);
            }
            if ($request->file('gambar') >'') {
                $file = $request->file('gambar');
                $extension = $file->getClientOriginalExtension(); // atau bisa menggunakan getExtension() jika lebih sesuai
                $filename = $request->username . '.' . $extension;
                Storage::disk('user')->putFileAs($file_path, $file, $filename);
                $User->gambar = $filename;  // Pastikan ini adalah instance yang tepat                
            }
           
            $tanggal =  Carbon::parse($request->tglmasuk)->format('d F Y');
            

            $User->email = $request->email;
            $User->name = $request->name;
            $User->slugname = Str::slug($request->name);
            $User->username = $request->username;
            $User->role = $request->role;
            $User->jabatans_id = $request->jabatans;
            $User->password =  Hash::make($request->password);
            $User->nohp = $request->nohp;
            $User->alamat = $request->alamat; 
            $User->tglmasuk = $tanggal; 
            $User->nip = $request->nip; 
            $User->save();
            return redirect('/User')->with('sukses','sukses menyimpan data karyawan');
         
        }
        else if(auth::user()->role== 'admins' && $type ==  "User" && $action == "edit")
        {
            $User = User::find($id);rules: 
            // Validasi input
            $validator = Validator::make($request->all(), [
               'email' => 'required|email|unique:users,email' . $User->id,
               'name' => 'required',
               'username' => 'required|string|unique:users,username'.$User->username,
               'nohp' => 'required',
               'alamat' => 'required',
               'jabatans' => 'required'
            ]);
        
            if ($validator->fails()) {
                return redirect('/User')->with('gagal','Username atau email sudah ada');
            } 

            $namepath = Jabatans::find($request->jabatans);
            $file_path = $namepath->divisi . "/" . $request->username;

            $deletefile = $file_path.'/'.$User->gambar;
        
            if (Storage::disk('user')->exists($deletefile)) {
                // Jika file ada, hapus file tersebut
                Storage::disk('user')->delete($deletefile);
                dd("File tidak ditemukan: " . $deletefile);
                
            }
            if (!file_exists($file_path)) {
                Storage::makeDirectory($file_path);
            }
            if ($request->file('gambar') >'') {
                $file = $request->file('gambar');
                $extension = $file->getClientOriginalExtension(); // atau bisa menggunakan getExtension() jika lebih sesuai
                $filename = $request->username . '.' . $extension;
                
               

                Storage::disk('user')->putFileAs($file_path, $file, $filename);
                $User->gambar = $filename;  // Pastikan ini adalah instance yang tepat                
            }


            $tanggal =  Carbon::parse($request->tglmasuk)->format('d F Y');

            $User->email = $request->email;
            $User->name = $request->name;
            $User->username = $request->username;
            $User->nohp = $request->nohp;
            $User->alamat = $request->alamat;    
            $User->jabatans_id = $request->jabatans;    
            $User->tglmasuk = $tanggal; 
            $User->nip = $request->nip; 
            $User->save();
            return redirect('/User')->with('sukses','sukses menyimpan data');
        }else if(auth::user()->role== 'admins' && $type ==  "User" && $action == "delete")
        {
            try {
                $record = User::findOrFail($id);
                $file_path = $record->Jabatans->divisi . "/" . $record->username;
                $deletefile = $file_path . '/' . $record->gambar;
    
                if (Storage::disk('user')->exists($deletefile)) {
                    // Jika file ada, hapus file tersebut
                    Storage::disk('user')->delete($deletefile);
                }

                $record->delete();
                return response()->json(['success' => 'Record deleted successfully.']);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to delete record.'], 500);
            }
        }
    
        //  area untuk jobdesk deskripsi
        if(auth::user()->role== 'admins' && $type ==  "jobdesks" && $action == "tambah") {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:jobdesks,name',
                'deskripsi' => 'required|unique:jobdesks,name',
            ]);
            if ($validator->fails()) {
                return redirect('/'.'detail-jabatan/'.$id)->with('gagal','Nama Pekerjaan Sudah ada !!');
            }
            $savekan = new Jobdesk();
            $savekan->name = $request->name;
            $savekan->jabatans_id = $id;
            $savekan->deskripsi = $request->deskripsi;
            $savekan->save();
            return redirect('/'.'detail-jabatan/'.$id)->with('sukses','sukses menyimpan data jabatan');;
        }
        else if(auth::user()->role== 'admins' && $type ==  "jobdesks" && $action == "edit")
        {
            $jobdesks = Jobdesk::find($id);
            $idjob = $request->idjob;
            if(auth::user()->role== 'admins'){
                // Validasi input
                $validator = Validator::make($request->all(), [
               'name' => 'required',
                ]);
        
                if ($validator->fails()) {
                    return redirect('/detail-jabatan/'.$idjob)->with('gagal','Username atau email sudah ada');
                }
                
                $jobdesks->name = $request->name;
                $jobdesks->deskripsi = $request->deskripsi;
                $jobdesks->save();
                return redirect('/detail-jabatan/'.$idjob)->with('sukses', 'sukses menyimpan data');
            }
        }
        else if(auth::user()->role== 'admins' && $type ==  "jobdesks" && $action == "delete")
        {
            try {
                $Jobdesk = Jobdesk::findOrFail($id);
                $Jobdesk->delete();
                return response()->json(['success' => 'Record deleted successfully.']);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to delete record.'], 500);
            }
        }

        // area untuk postingan
        if(auth::user()->role== 'admins' && $type ==  "posts" && $action == "tambah") {
            $post = new Post();

            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'deskripsi' => 'required',
            ]);  
            if ($validator->fails()) {
               
                return redirect('/'.$type)->with('gagal','Judul Sudah Ada  !!');
            }


           // Ambil file gambar dari request
            $file = $request->file('gambar');

            // Ambil ekstensi file
            $extension = $file->getClientOriginalExtension(); // atau bisa menggunakan getExtension() jika lebih sesuai

            // Buat nama file yang bersih dan menggunakan slug dari judul
            $filename = Str::slug($request->title, '-') . '.' . $extension;

            // Simpan file di disk 'public' di folder 'postingan/'
            Storage::disk('public')->putFileAs('postingan', $file, $filename);

            // Simpan nama file pada database (asumsikan $post adalah instance dari model Post)
            $post->gambar = $filename;

            $post->title = $request->title;
            $post->slug = Str::of($request->title)->slug('-');
           
            if ($request->input('status') == true) {
                $status = "public";
            } else {
                $status = "private";
            }
   
            $post->status = $status;
            
            $post->deskripsi = $request->deskripsi;
            $post->save();
            return redirect('/'.$type)->with('sukses','sukses menyimpan data postingan');
        }
      
        else if(auth::user()->role== 'admins' && $type ==  "posts" && $action == "edit")
        {
            $post = Post::find($id);
            
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'deskripsi' => 'required',
            ]);  
            if ($validator->fails()) {
               
                return redirect('/'.$type)->with('gagal','Judul Sudah Ada  !!');
            }
         
            $post->title = $request->title;
            $post->slug = Str::of($request->title)->slug('-');
           
            if ($request->input('status') == true) {
                $status = "public";
            } else {
                $status = "private";
            }
            $post->status = $status;
            
            $post->deskripsi = $request->deskripsi;
            $post->save();
            return redirect('/'.$type)->with('sukses','sukses menyimpan data postingan');;
        }
          
        else if(auth::user()->role== 'admins' && $type ==  "posts" && $action == "delete")
        {
            try {
                $post = Post::findOrFail($id);
                $post->delete();
                return response()->json(['success' => 'Record deleted successfully.']);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to delete record.'], 500);
            }
        }



        
    }
 

}
