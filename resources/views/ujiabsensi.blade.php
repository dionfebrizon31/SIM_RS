<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geolocation dengan Notifikasi</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }

        #notification {
            background-color: #ff9800;
            color: white;
            padding: 15px;
            border-radius: 5px;
            display: none;
            margin-top: 20px;
        }

        #location {
            margin-top: 20px;
        }

        #getLocationButton {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #getLocationButton:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>

    <h1>Temukan Lokasi Anda</h1>
    <button id="getLocationButton">Dapatkan Lokasi</button>
    <div id="notification">
        <p>Izinkan kami untuk mengakses lokasi Anda agar dapat memberikan informasi lebih akurat.</p>
    </div>
    <div id="location">
        <!-- Lokasi akan ditampilkan di sini -->
    </div>
    <div id="message-container"></div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <script>
        const getLocationButton = document.getElementById('getLocationButton');
        const locationDisplay = document.getElementById('location');
        const notification = document.getElementById('notification');

        // Fungsi untuk menampilkan lokasi
        function displayLocation(lat, lon) {
            locationDisplay.innerHTML = `
        <p><strong>Latitude:</strong> ${lat}</p>
        <p><strong>Longitude:</strong> ${lon}</p>
        `;
            // Kirim data lokasi ke server
            sendLocationToServer(lat, lon);
        }

        // Fungsi untuk meminta izin dan mengambil lokasi
        function getLocation() {
            // Tampilkan notifikasi untuk meminta izin
            notification.style.display = 'block';

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    displayLocation(latitude, longitude);
                    notification.style.display = 'none'; // Sembunyikan notifikasi jika izin diberikan
                }, function(error) {
                    locationDisplay.innerHTML = "<p>Terjadi kesalahan saat mengambil lokasi: " + error.message +
                        "</p>";
                    notification.style.display = 'none'; // Sembunyikan notifikasi jika terjadi error
                });
            } else {
                locationDisplay.innerHTML = "<p>Geolocation tidak didukung oleh browser Anda.</p>";
                notification.style.display = 'none'; // Sembunyikan notifikasi jika geolocation tidak didukung
            }
        }

        // Fungsi untuk mengirim data lokasi ke server menggunakan AJAX
        function sendLocationToServer(lat, lon) {
            $.ajax({
                url: '/save-location',
                method: 'POST',
                data: {
                    latitude: lat,
                    longitude: lon,
                    "_token": "{{ csrf_token() }}" // Pastikan csrf token tersedia
                },
                success: function(response) {
                    console.log('Data berhasil dikirim ke server:', response.success);
                    $('#message-container').html('<div class="alert alert-success">' + response.success +
                        '</div>');
                },
                error: function(xhr, status, error) {
                    console.error('Terjadi kesalahan:', error);
                }
            });
        }

        // Event listener untuk tombol
        getLocationButton.addEventListener('click', function() {
            // Menampilkan notifikasi jika tombol diklik
            notification.style.display = 'block';
            getLocation();
        });
    </script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>

</html>
