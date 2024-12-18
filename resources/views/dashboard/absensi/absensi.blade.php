<x-layout>
    <x-slot:tittle>{{ $tittle }}</x-slot>

    <section class="section main-section">
        <div class="card has-table">
            <div class="card-content">

                {{-- area pc --}}
                <div class=" hidden md:block  flex-wrap">
                    <div class="mx-8">
                        <h1 class="font-bold text-xl mt-4 mb-4 ml-[250px]">Your Profile</h1>

                        <div class="grid grid-cols-2  gap-y-1 font-medium mx-16 mt-2 mb-4">
                            <!-- Row 1 (Kiri-Kanan) -->
                            <p>Nomor Induk Pegawai </p>
                            <p class="-ml-20">: {{ Auth::user()->nip }}</p>
                            <!-- Row 1 (Kiri-Kanan) -->
                            <p>Nama Lengkap </p>
                            <p class="-ml-20">: {{ Auth::user()->name }}</p>
                            <!-- Row 1 (Kiri-Kanan) -->
                            <p>Email</p>
                            <p class="-ml-20">: {{ Auth::user()->email }}</p>
                            <!-- Row 1 (Kiri-Kanan) -->
                            <p>Nomor HP</p>
                            <p class="-ml-20">: {{ Auth::user()->nohp }}</p>
                            <!-- Row 1 (Kiri-Kanan) -->
                            <p>Alamat</p>
                            <p class="-ml-20">: {{ Auth::user()->alamat }}</p>

                        </div>
                    </div>

                </div>

                {{-- area mobile --}}
                <div class="block md:hidden mb-4">
                    <div class="w-full mx-8 flex justify-center items-center">
                        <table class="mx-auto">
                            <tbody>
                                <tr class="mr-6 ">
                                    <td class="image-cell">
                                        <div class="image">
                                            <img src="https://avatars.dicebear.com/v2/initials/rebecca-bauch.svg"
                                                class="rounded-full">
                                        </div>
                                    </td>
                                    <!-- Row 1 (Kiri-Kanan) -->
                                    <td data-label="Nomor Induk Pegawai" class="ml-2 justify-self-start">:
                                        {{ Auth::user()->nip }}</td>
                                    <!-- Row 1 (Kiri-Kanan) -->
                                    <td data-label="Nama Lengkap" class="ml-2 justify-self-start ">:
                                        {{ Auth::user()->name }}</td>
                                    <!-- Row 1 (Kiri-Kanan) -->
                                    <td data-label="Email" class="ml-2 justify-self-start">: {{ Auth::user()->email }}
                                    </td>
                                    <!-- Row 1 (Kiri-Kanan) -->
                                    <td data-label="Nomor HP" class="ml-2 justify-self-start">: {{ Auth::user()->nohp }}
                                    </td>
                                    <!-- Row 1 (Kiri-Kanan) -->
                                    <td data-label="Alamat" class="ml-2 justify-self-start">:
                                        {{ Auth::user()->alamat }}</td>


                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div>
                    {{-- {{ dd($tombol) }} --}}
                    {{-- {{ dd(Auth::user()->id) }} --}}
                    @php
                        $time = now()->format('H:i');
                    @endphp

                    @if ($tombol['checkin'])
                        <button id="CheckInAbsensi"
                            class="bg-blue-500 text-white font-bold py-2 px-4 rounded shadow-lg transform transition duration-300 hover:bg-blue-600 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-400">
                            Checkin Absensi
                        </button>
                    @endif

                    @if ($tombol['checkout'])
                        @if ($time > '15:00')
                            <button id="CheckOutAbsensi"
                                class="bg-blue-500 text-white font-bold py-2 px-4 rounded shadow-lg transform transition duration-300 hover:bg-blue-600 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                Checkout Absensi
                            </button>
                        @else
                            <div
                                class="flex items-center justify-between p-4 mb-4 text-sm text-gray-800 bg-yellow-100 border border-yellow-400 rounded-lg shadow-md">
                                <span class="flex items-center">
                                    <!-- Icon notifikasi (optional) -->
                                    <svg class="w-5 h-5 mr-2 text-yellow-500" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 0v4m0-4h4m-4 0H8"></path>
                                    </svg>
                                    <span class="font-medium text-yellow-800">Belum Waktunya Check Out</span>
                                </span>
                                <!-- Close Button -->
                                <button class="text-yellow-600 hover:text-yellow-800 focus:outline-none"
                                    onclick="this.closest('div').remove()">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        @endif
                    @endif
                    @if ($tombol['checkout'] == false && $tombol['checkin'] == false)
                        <div
                            class="flex items-center justify-between p-4 mb-4 text-sm text-gray-800 bg-yellow-100 border border-yellow-400 rounded-lg shadow-md">
                            <span class="flex items-center">
                                <!-- Icon notifikasi (optional) -->
                                <svg class="w-5 h-5 mr-2 text-yellow-500" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 0v4m0-4h4m-4 0H8"></path>
                                </svg>
                                <span class="font-medium text-yellow-800">Anda Sudah Hadir Hari ini</span>
                            </span>
                            <!-- Close Button -->
                            <button class="text-yellow-600 hover:text-yellow-800 focus:outline-none"
                                onclick="this.closest('div').remove()">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    @endif
                    <div id="ShowDataNotification" class="hidden">
                        <div
                            class="flex items-center justify-between p-4 mb-4 text-sm text-gray-800 bg-yellow-100 border border-yellow-400 rounded-lg shadow-md">
                            <span class="flex items-center">
                                <!-- Icon notifikasi (optional) -->
                                <svg class="w-5 h-5 mr-2 text-yellow-500" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 0v4m0-4h4m-4 0H8"></path>
                                </svg>
                                <span id="response-message" class="font-medium text-yellow-800"></span>
                            </span>
                            <!-- Close Button -->
                            <button class="text-yellow-600 hover:text-yellow-800 focus:outline-none"
                                onclick="this.closest('div').remove()">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div id="notification" class="mt-4 p-4 bg-yellow-100 text-yellow-800 rounded-lg shadow-md hidden">
                        <p>Izinkan kami untuk mengakses lokasi Anda agar dapat memberikan informasi lebih akurat.
                        </p>
                    </div>

                    <div id="location" class="mt-4 text-lg text-gray-700">
                        <!-- Lokasi akan ditampilkan di sini -->
                    </div>

                    <div id="message-container" class="mt-4">
                        <!-- Pesan akan ditampilkan di sini -->
                    </div>
                </div>
            </div>

        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const CheckInAbsensi = document.getElementById('CheckInAbsensi');
            const CheckOutAbsensi = document.getElementById('CheckOutAbsensi');
            const locationDisplay = document.getElementById('location');
            const notification = document.getElementById('notification');
            const userId = {{ Auth::user()->id }};

            // Fungsi untuk meminta izin dan mengambil lokasi
            function getLocation(action) {
                notification.style.display = 'block';
                console.log('getlocation');
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;

                        notification.style.display = 'none'; // Sembunyikan notifikasi jika izin diberikan
                        console.log(action);
                        Absensi(latitude, longitude, action);

                    }, function(error) {
                        locationDisplay.innerHTML = "<p>Terjadi kesalahan saat mengambil lokasi: " + error
                            .message + "</p>";
                        notification.style.display = 'none'; // Sembunyikan notifikasi jika terjadi error
                    });
                } else {
                    locationDisplay.innerHTML = "<p>Geolocation tidak didukung oleh browser Anda.</p>";
                    notification.style.display = 'none'; // Sembunyikan notifikasi jika geolocation tidak didukung
                }
            }

            // Fungsi untuk mengirim data lokasi ke server menggunakan AJAX
            function Absensi(lat, lon, status) {
                $.ajax({
                    url: '/save-Absensi',
                    method: 'POST',
                    data: {
                        status: status,
                        latitude: lat,
                        longitude: lon,
                        "_token": "{{ csrf_token() }}" // Pastikan csrf token tersedia
                    },
                    success: function(response) {
                        document.getElementById('ShowDataNotification').style.display = 'block';
                        document.getElementById('response-message').textContent = response.success;

                        // Jika ingin membuat notifikasi seperti sebelumnya
                        showNotification(response.success);
                        // Jika ingin menampilkan success message
                        $('#message-container').html('<div class="alert alert-success">' + response
                            .success + '</div>');
                    },
                    error: function(xhr, status, error) {
                        console.error('Terjadi kesalahan:', error);
                    }
                });
            }



            // Cek apakah elemen CheckInAbsensi ada di halaman sebelum menambahkan event listener
            if (CheckInAbsensi) {
                CheckInAbsensi.addEventListener('click', function() {
                    const confirmation = confirm("Apakah Anda yakin ingin melakukan check-in?");
                    if (confirmation) {
                        notification.style.display = 'block';
                        CheckInAbsensi.disabled = true;
                        getLocation('checkin');
                    } else {
                        alert("Proses dibatalkan.");
                    }

                });
            }

            // Cek apakah elemen CheckOutAbsensi ada di halaman sebelum menambahkan event listener
            if (CheckOutAbsensi) {
                CheckOutAbsensi.addEventListener('click', function() {
                    const confirmation = confirm("Apakah Anda yakin ingin melakukan check-out?");
                    if (confirmation) {

                        notification.style.display = 'block';
                        CheckOutAbsensi.disabled = true;
                        getLocation('checkout');
                    } else {
                        alert("Proses dibatalkan.");
                    }

                });
            }
        });
    </script>

</x-layout>
