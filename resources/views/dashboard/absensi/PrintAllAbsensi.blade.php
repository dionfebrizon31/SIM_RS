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
    </style>
</head>

<body>
    <div class="container">
        @php

            $processedDates = [];
        @endphp
        <div class="card-content">
            <table>
                <thead>
                    <tr>
                        <th>divisi</th>
                        @foreach ($absensi as $item)
                            @php
                                // Ambil hanya bagian tanggal (Y-m-d) dari absensi_at
                                $tanggalOnly = \Carbon\Carbon::parse($item->absensi_at)->format('Y-m-d');

                                // Jika tanggal sudah ada dalam processedDates, skip
                                if (in_array($tanggalOnly, $processedDates)) {
                                    continue;
                                }

                                // Tampilkan kolom untuk tanggal yang belum diproses
                                echo '<th>' . $tanggalOnly . '</th>';

                                // Tandai tanggal sebagai sudah diproses
                                $processedDates[] = $tanggalOnly;
                            @endphp
                        @endforeach
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $checkinCount = 0; // Penghitung untuk check-in
                        $LatestCount = 0; // Penghitung untuk check-in
                        $checkoutCount = 0; // Penghitung untuk check-out
                        $lastUserId = null; // Variabel untuk menyimpan user_id terakhir
                    @endphp
                    @foreach ($absensi as $item)
                        <br>
                        @if ($lastUserId != $item->user_id && $lastUserId == null)
                            {{-- 1 --}}
                            @php
                                $lastUserId = $item->user_id;
                                if ($item->status == 'checkin') {
                                    $checkinCount++; // Menambah penghitung check-in
                                } elseif ($item->status == 'checkout') {
                                    $checkoutCount++; // Menambah penghitung check-out
                                } elseif ($item->status == 'latest') {
                                    $LatestCount++; // Menambah penghitung latest
                                }
                            @endphp
                            <tr>
                                <td data-label="Nama" class="border-r border-gray-400 px-4 py-2">
                                    {{ $item->user->name }}
                                    {{ $item->id }}</td>
                                <td data-label="Status" class="border-r border-gray-400 px-4 py-2">{{ $item->status }}
                                    {{ $item->id }}</td>
                                @php
                                    continue;
                                @endphp
                            @elseif ($lastUserId == $item->user_id)
                                {{-- 234 --}}
                                @php
                                    $lastUserId = $item->user_id;
                                    if ($item->status == 'checkin') {
                                        $checkinCount++; // Menambah penghitung check-in
                                    } elseif ($item->status == 'checkout') {
                                        $checkoutCount++; // Menambah penghitung check-out
                                    } elseif ($item->status == 'latest') {
                                        $LatestCount++; // Menambah penghitung latest
                                    }
                                @endphp
                                <td data-label="Status" class="border-r border-gray-400 px-4 py-2">{{ $item->status }}
                                    {{ $item->id }}</td>
                                @php
                                    continue;

                                @endphp
                            @else
                                {{-- 5 6 --}}
                            <tr>
                                @php
                                    $lastUserId = $item->user_id;
                                    if ($item->status == 'checkin') {
                                        $checkinCount++; // Menambah penghitung check-in
                                    } elseif ($item->status == 'checkout') {
                                        $checkoutCount++; // Menambah penghitung check-out
                                    } elseif ($item->status == 'latest') {
                                        $LatestCount++; // Menambah penghitung latest
                                    }
                                @endphp
                                <td data-label="Nama" class="border-r border-gray-400 px-4 py-2">
                                    {{ $item->user->name }}
                                    {{ $item->id }}</td>
                                <td data-label="Status" class="border-r border-gray-400 px-4 py-2">
                                    {{ $item->status }}
                                    {{ $item->id }}</td>
                                @php
                                    continue;

                                @endphp

                            </tr>
                        @endif
                        <td data-label="Checkin" class="border-r border-gray-400 px-4 py-2">
                            {{ $checkinCount }}</td>
                        <td data-label="Latest" class="border-r border-gray-400 px-4 py-2">{{ $LatestCount }}</td>
                        <td data-label="Checkout" class="border-r border-gray-400 px-4 py-2">{{ $checkoutCount }}
                        </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
    </div>
</body>

</html>
