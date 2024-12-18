<x-layout>
    <x-slot:tittle>{{ $tittle }}</x-slot>

    <head>
        <!-- Meta tag CSRF token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <section class="section main-section">
        <div class="card has-table  bg-red-500">
            <div class="card-content">
                <!-- Gambar -->


                <div class="w-full flex justify-center items-center mt-4">
                    <img src="https://avatars.dicebear.com/v2/initials/rebecca-bauch.svg" class="rounded-full w-32 h-32">
                </div>
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-8 p-4 w-full max-w-7xl">
                    <!-- Bagian Kiri (atas dan bawah) -->
                    <div class="flex-1 mx-10 space-y-4">
                        <!-- Bagian Kiri Atas -->
                        <div class="flex items-center">
                            <div class="text-lg font-semibold mr-2 w-1/3">Jenis Cuti</div>
                            <span class="text-gray-600 w-2/3">: {{ $cuti->jeniscutis->jenis }}</span>
                        </div>

                        <!-- Bagian Kiri Bawah -->
                        <div class="flex items-center">
                            <div class="text-lg font-semibold mr-2 w-1/3">Keterangan</div>
                            <span class="text-gray-600 w-2/3">: {{ $cuti->keterangan }}</span>
                        </div>
                        <div class="flex items-center">
                            <div class="text-lg font-semibold mr-2 w-1/3">Awal Pelaksanaan</div>
                            <span class="text-gray-600 w-2/3">: {{ $cuti->awalcuti }}</span>
                        </div>
                        <div class="flex items-center">
                            <div class="text-lg font-semibold mr-2 w-1/3">Akhir Pelaksanaan</div>
                            <span class="text-gray-600 w-2/3">: {{ $cuti->akhircuti }}</span>
                        </div>
                    </div>

                    <!-- Bagian Kanan (atas dan bawah) -->
                    <div class="flex-1 mx-10 space-y-4">
                        <!-- Bagian Kanan Atas -->
                        <div class="flex items-center">
                            <div class="text-lg font-semibold mr-2 w-1/3">Nip</div>
                            <span class="text-gray-600 w-2/3">: {{ $cuti->users->nip }}</span>
                        </div>
                        <!-- Bagian Kanan Atas -->
                        <div class="flex items-center">
                            <div class="text-lg font-semibold mr-2 w-1/3">Nama Lengkap</div>
                            <span class="text-gray-600 w-2/3">: {{ $cuti->users->name }}</span>
                        </div>
                        <div class="flex items-center">
                            <div class="text-lg font-semibold mr-2 w-1/3">Jabatan</div>
                            <span class="text-gray-600 w-2/3">: {{ $cuti->users->jabatans->name }}</span>
                        </div>
                        <!-- Bagian Kanan Atas -->
                        <div class="flex items-center">
                            <div class="text-lg font-semibold mr-2 w-1/3">alamat</div>
                            <span class="text-gray-600 w-2/3">: {{ $cuti->users->alamat }}</span>
                        </div>
                    </div>
                </div>
                <div class="mt-4 mx-4 flex flex-wrap  gap-4">
                    @if (($cuti->status == 'pending' && Auth::user()->role == 'admins') || Auth::user()->role == 'manager')
                        <!-- Tombol Cuti Diterima -->
                        <button name="status" data-urledit="{{ url('data/cutis/edit/' . $cuti->id) }}"
                            data-id="{{ $cuti->id }}" id="Edit-Cutis" value="approved"
                            class="bg-green-600 text-white font-semibold py-2 px-4 rounded-md shadow-md transition-transform transform duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-75 active:scale-95 hover:scale-105 hover:shadow-lg w-full sm:w-auto md:w-auto lg:w-auto">
                            Cuti Diterima
                        </button>

                        <!-- Tombol Cuti Ditolak -->
                        <button name="status" data-urledit="{{ url('data/cutis/edit/' . $cuti->id) }}"
                            data-id="{{ $cuti->id }}" id="Edit-Cutis" value="reject"
                            class="bg-red-600 text-white font-semibold py-2 px-4 rounded-md shadow-md transition-transform transform duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-75 active:scale-95 hover:scale-105 hover:shadow-lg w-full sm:w-auto md:w-auto lg:w-auto">
                            Cuti Ditolak
                        </button>
                    @endif
                    <a href="/cuti"
                        class="bg-sky-600 text-white font-semibold py-2 px-4 rounded-md shadow-md transition-transform transform duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-sky-400 focus:ring-opacity-75 active:scale-95 hover:scale-115 hover:shadow-lg w-full sm:w-auto md:w-auto lg:w-auto">
                        back
                    </a>
                </div>

            </div>
        </div>
    </section>




</x-layout>
