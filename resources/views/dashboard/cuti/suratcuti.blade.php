<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Cuti {{ $cuti->users->name }}</title>
    <!-- Tambahkan Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="font-family: Arial, sans-serif; background-color: #ffffff; margin: 0; padding: 0;">
    <!-- Kontainer utama -->
    <?php $header; ?>
    <div class="container mt-4" style="margin: 0; padding: 0;">
        <!-- Kop Surat -->
        <div class="header d-flex justify-content-between align-items-center" style="margin: 0; padding: 0;">
            <div>
                <h1 style="font-size: 24px; color: #3182ce; margin: 0;">RS. Sehat Selalu</h1>
                <p style="font-size: 12px; color: #718096; margin: 0;">Jl. Sehat No. 123, Kota Sehat</p>
                <p style="font-size: 12px; color: #718096; margin: 0;">Telp. (021) 123456789</p>
            </div>
            <div class="text-end">
                <p style="font-size: 12px; color: #718096; margin: 0;">Tanggal: {{ $cuti->updated_at->format('d F Y') }}
                </p>
            </div>
        </div>

        <!-- Garis pemisah -->
        <hr style="border: 1px solid #e2e8f0; margin: 0;">

        <!-- Isi Surat -->
        <div class="content mt-3" style="margin: 0; padding: 0;">
            <!-- Tujuan Surat -->
            <div style="margin-top: 10px">
                <p style="margin: 0; padding: 0;">Kepada Yth,</p>
                <p style="margin: 0; padding: 0;">RSUD</p>
                <p style="margin: 0; padding: 0;">di Tempat</p>
            </div>

            <!-- Pembuka Surat -->
            <p style="margin-bottom: 10px; padding: 0;">Dengan hormat,</p>
            <p style="margin: 0; padding: 0;">Saya yang bertanda tangan di bawah ini:</p>
            <table class="table info-table" style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                <tr>
                    <td style="padding: 4px 0; border: none;">Nama</td>
                    <td style="padding: 4px 0; border: none;"><strong>: {{ $cuti->users->name }}</strong></td>
                </tr>
                <tr>
                    <td style="padding: 4px 0; border: none;">NIP</td>
                    <td style="padding: 4px 0; border: none;"><strong>: {{ $cuti->users->nip }}</strong></td>
                </tr>
                <tr>
                    <td style="padding: 4px 0; border: none;">Divisi</td>
                    <td style="padding: 4px 0; border: none;"><strong>: {{ $cuti->users->jabatans->divisi }}</strong>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 4px 0; border: none;">Jabatan:</td>
                    <td style="padding: 4px 0; border: none;"><strong>: {{ $cuti->users->jabatans->name }}</strong>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 4px 0; border: none;">Alamat:</td>
                    <td style="padding: 4px 0; border: none;"><strong>: {{ $cuti->users->alamat }}</strong></td>
                </tr>
            </table>


            <p style="margin: 0; padding: 0;text-align: justify">Dengan ini mengajukan permohonan Cuti Tahunan untuk
                <strong style="font-weight: bold">{{ $jumlahHari }} ({{ $texthari }}) hari
                    kerja</strong>, terhitung mulai tanggal <strong style="font-weight: bold">
                    {{ \Carbon\Carbon::parse($cuti->awalcuti)->translatedFormat('d F Y') }}</strong>
                sampai dengan
                <strong style="font-weight: bold">
                    {{ \Carbon\Carbon::parse($cuti->akhircuti)->translatedFormat('d F Y') }}</strong>. Selama
                menjalankan cuti, alamat saya
                adalah di <strong>{{ $cuti->users->alamat }} </strong>.
            </p>
            <p style="margin-top: 10px; padding: 0;">Demikian permohonan ini saya buat untuk dapat dipertimbangkan
                sebagaimana
                mestinya.</p>

            <div class="signature" style="margin-top: 10px;">
                <p style="margin-bottom: 80px; text-align: right; margin-right: 20px">Hormat saya,</p>
                <p style="margin-bottom: 5px; text-align: right; margin-right: 40px">{{ $cuti->users->name }}</p>
            </div>

            <!-- Tabel Catatan Pejabat -->
            <div class="mt-4">
                <h2 style="font-size: 18px; font-weight: bold; margin: 0;">Catatan Pejabat</h2>
                <table class="table table-bordered" style="width: 100%; border-collapse: collapse; margin-top: 0;">
                    <thead>
                        <tr>
                            <th
                                style="border: 1px solid #cbd5e0; background-color: #edf2f7; padding: 8px; text-align: left;">
                                CATATAN PEJABAT KEPEGAWAIAN</th>
                            <th
                                style="border: 1px solid #cbd5e0; background-color: #edf2f7; padding: 8px; text-align: left;">
                                CATATAN PERTIMBANGAN ATASAN LANGSUNG</th>
                            <th
                                style="border: 1px solid #cbd5e0; background-color: #edf2f7; padding: 8px; text-align: left;">
                                KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN IZIN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border: 1px solid #cbd5e0;">
                            <td style="border: 1px solid #cbd5e0; padding: 8px; text-align: left;" colspan="2">
                                Cuti yang telah diambil dalam tahun yang bersangkutan: {{ $countlibur }}
                            </td>
                            <td style="border: 1px solid #cbd5e0; text-align: center; vertical-align: middle;"
                                rowspan="6">
                                {{ $cuti->status }}
                            </td>
                        </tr>
                        <tr style="border: 1px solid #cbd5e0;">
                            <td
                                style="border: 1px solid #cbd5e0; padding: 8px; text-align: left; font-weight: {{ $cuti->jeniscutis->jenis == 'Tahunan' ? 'bold' : 'normal' }};">
                                1. Cuti Tahunan
                            </td>
                            <td style="border: 1px solid #cbd5e0; padding: 8px; text-align: left;">
                                1. Kepala Ruangan
                            </td>

                        </tr>
                        <tr style="border: 1px solid #cbd5e0;">
                            <td
                                style="border: 1px solid #cbd5e0; padding: 8px; text-align: left;font-weight: {{ $cuti->jeniscutis->jenis == 'bersalin' ? 'bold' : 'normal' }}">
                                2. Cuti Bersalin
                            </td>
                            <td style="border: 1px solid #cbd5e0; padding: 8px; text-align: left;">
                                2. Kasi Keperawatan
                            </td>
                            <!-- Menggunakan rowspan di kolom terakhir untuk menggabungkan sel pada baris ini dan berikutnya -->

                        </tr>
                        <tr style="border: 1px solid #cbd5e0;">
                            <td
                                style="border: 1px solid #cbd5e0; padding: 8px; text-align: left;font-weight: {{ $cuti->jeniscutis->jenis == 'sakit' ? 'bold' : 'normal' }}">
                                3. Cuti Sakit
                            </td>
                            <td style="border: 1px solid #cbd5e0; padding: 8px; text-align: left;">
                                3. Kabid Pelayanan
                            </td>
                        </tr>
                        <tr style="border: 1px solid #cbd5e0;">
                            <td
                                style="border: 1px solid #cbd5e0; padding: 8px; text-align: left;font-weight: {{ $cuti->jeniscutis->jenis == 'urgent' ? 'bold' : 'normal' }}">
                                4. Izin Alasan Penting
                            </td>
                            <td style="border: 1px solid #cbd5e0; padding: 8px; text-align: left;"></td>
                            {{-- <td style="border: 1px solid #cbd5e0; padding: 8px; text-align: left;"></td> --}}
                        </tr>
                        @if (!in_array($cuti->jeniscutis->jenis, ['Tahunan', 'Bersalin', 'Sakit', 'Izin Alasan Penting']))
                            <tr style="border: 1px solid #cbd5e0;">
                                <td
                                    style="border: 1px solid #cbd5e0; padding: 8px; text-align: left;font-weight: {{ $cuti->jeniscutis->jenis == 'urgent' ? 'bold' : 'normal' }}">
                                    5. Cuti Catatan {{ $cuti->jeniscutis->jenis }}
                                </td>
                                <td style="border: 1px solid #cbd5e0; padding: 8px; text-align: left;">
                                    {{ $cuti->keterangan }}
                                </td>
                                {{-- <td style="border: 1px solid #cbd5e0; padding: 8px; text-align: left;"></td> --}}
                            </tr>
                        @else
                            <tr style="border: 1px solid #cbd5e0;">
                                <td
                                    style="border: 1px solid #cbd5e0; padding: 8px; text-align: left;font-weight: {{ $cuti->jeniscutis->jenis == 'urgent' ? 'bold' : 'normal' }}">
                                    5. Cuti Catatan
                                </td>
                                <td style="border: 1px solid #cbd5e0; padding: 8px; text-align: left;"></td>
                                {{-- <td style="border: 1px solid #cbd5e0; padding: 8px; text-align: left;"></td> --}}
                            </tr>
                        @endif



                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tambahkan Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
