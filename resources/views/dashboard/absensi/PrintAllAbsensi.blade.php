<html>

<head>
    <title>Tabel Absensi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            border-radius: 10px;

            padding: 20px;
            width: 100%;
            max-width: 1200px;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .date-info {
            color: green;
            margin-bottom: 20px;
        }

        .date-info span {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #28a745;
            color: white;
        }

        .status-hadir {
            background-color: #d4edda;
            color: #155724;
        }

        .status-izin {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-absen {
            background-color: #f8d7da;
            color: #721c24;
        }

        .bg-success {
            background-color: #28a745 !important;
        }

        .bg-warning {
            background-color: #ffc107 !important;
        }

        .bg-danger {
            background-color: #dc3545 !important;
        }

        .text-white {
            color: white !important;
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="card-content">
            <table>
                <thead>
                    <tr>
                        <th>User ID</th> <!-- Kolom untuk User ID -->
                        @foreach ($datesRange as $tanggal)
                            <th colspan="2" style="text-align: center">{{ $tanggal }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        <th>NamaKaryawan</th> <!-- Kolom untuk Divisi -->
                        @foreach ($datesRange as $tanggal)
                            <th>checkin</th>
                            <th>checkout</th>
                            <!-- Menampilkan Tanggal -->
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Users as $userId => $userData)
                        <tr>
                            <td>{{ $userData['nama'] }}</td> <!-- Menampilkan Nama User -->
                            @foreach ($datesRange as $tanggal)
                                <!-- Loop untuk setiap tanggal -->
                                @php
                                    // Ambil data absensi untuk user dan tanggal tertentu
                                    $status = $userData['absensi'][$tanggal] ?? [
                                        'checkin' => 'Alfa',
                                        'checkout' => 'Alfa',
                                    ];
                                @endphp
                                <!-- Menampilkan Checkin -->
                                <td
                                    class="
                                    @if ($status['checkin'] == 'Alfa' && $status['latest'] != 'Alfa') text-white bg-warning
                                    @elseif ($status['latest'] == 'Alfa' && $status['checkin'] != 'Alfa')
                                         text-white bg-success 
                                    @else
                                         text-white bg-danger @endif
                                ">
                                    @if ($status['checkin'] == 'Alfa')
                                        {{ $status['latest'] }}
                                    @elseif ($status['latest'] == 'Alfa')
                                        {{ $status['checkin'] }}
                                    @else
                                        Alfa
                                    @endif
                                </td>
                                <!-- Menampilkan Checkout -->
                                <td>{{ $status['checkout'] ?? 'Alfa' }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</body>

</html>
