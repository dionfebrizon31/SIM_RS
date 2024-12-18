<x-layout>
    <x-slot:tittle>{{ $tittle }}</x-slot>
    <section class="section main-section">
        @if (session('gagal'))
            <div class="notification red">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
                    <div>
                        <span class="icon"><i class="mdi mdi-buffer"></i></span>
                        {{ session('gagal') }}
                    </div>
                    <button type="button" class="button small textual --jb-notification-dismiss">Dismiss</button>
                </div>
            </div>
        @endif

        @if (session('sukses'))
            <div class="notification green">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
                    <div>
                        <span class="icon"><i class="mdi mdi-buffer"></i></span>
                        {{ session('sukses') }}
                    </div>
                    <button type="button" class="button small textual --jb-notification-dismiss">Dismiss</button>
                </div>
            </div>
        @endif
        <div class="card has-table">

            <section class="card-header">
                <p class="card-header-title">
                    <span class="icon"><i class="mdi mdi-account-multiple"></i></span>
                    {{ $tittle }}
                </p>

                <a href="/print-all-absensi" type="button" class="btn btn-primary">

                    <i class="mdi mdi-printer"></i>Print</a>



            </section>

            <div class="card-content">
                <table class="border border-gray-400 px-4 py-2">
                    <thead>
                        <tr class="border border-gray-400 px-4 py-2">
                            <th>divisi</th>
                            <th>Checkin</th>
                            <th>Latest</th>
                            <th>Checkout</th>
                            <th>aksi</th>


                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $checkinCount = 0; // Penghitung untuk check-in
                            $LatestCount = 0; // Penghitung untuk check-in
                            $checkoutCount = 0; // Penghitung untuk check-out
                            $userStatusCount = [];
                            $lastUserId = null; // Variabel untuk menyimpan user_id terakhir
                        @endphp
                        @foreach ($absensi as $itemss)
                            @php
                                // Jika user_id belum ada dalam array, inisialisasi array untuk statusnya
                                if (!isset($userStatusCount[$itemss->user_id])) {
                                    $userStatusCount[$itemss->user_id] = [
                                        'checkin' => 0,
                                        'checkout' => 0,
                                        'latest' => 0,
                                    ];
                                }
                                // Hitung jumlah berdasarkan status
                                if ($itemss->status == 'checkin') {
                                    $userStatusCount[$itemss->user_id]['checkin']++;
                                } elseif ($itemss->status == 'checkout') {
                                    $userStatusCount[$itemss->user_id]['checkout']++;
                                } elseif ($itemss->status == 'latest') {
                                    $userStatusCount[$itemss->user_id]['latest']++;
                                }
                            @endphp
                        @endforeach


                        @foreach ($userStatusCount as $userId => $statusCounts)
                            <tr class="border border-gray-400 px-4 py-2">
                                <td data-label="Checkin" class="border border-gray-400 px-4 py-2">
                                    {{ $absensi->firstWhere('user_id', $userId)->user->name }}
                                </td>

                                <td data-label="Checkin" class="border border-gray-400 px-4 py-2">
                                    {{ $statusCounts['checkin'] }}
                                </td>
                                <td data-label="Checkin" class="border border-gray-400 px-4 py-2">
                                    {{ $statusCounts['latest'] }}
                                </td>
                                <td data-label="Checkin" class="border border-gray-400 px-4 py-2">
                                    {{ $statusCounts['checkout'] }}
                                </td>


                                <td class="actions-cell">
                                    <div class="buttons center nowrap">
                                        <a href="detail-jabatan/{{ $userId }}" class="button small green">
                                            <span class="icon"><i class="mdi mdi-eye"></i></span>
                                        </a>
                                        <button type="button" class="button small green" data-bs-toggle="modal"
                                            data-bs-target="#editabsensi{{ $userId }}">
                                            <span class="icon"><i class="mdi mdi-pen"></i></span>
                                        </button>

                                        <button class="button small red " id="delete-record"
                                            data-id="{{ $userId }}" data-urlsaya="data/absensi/delete">
                                            <span class="icon"><i class="mdi mdi-trash-can"></i></span>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>
    </section>

    {{-- area untuk pop up modal --}}
    @foreach ($absensi as $item)
        <x-modaldinamis id="editabsensi{{ $item['id'] }}" tittle="edit absensi" size="modal-lg">
            <form action="/data/absensi/edit/{{ $item['id'] }}" method="post">
                @csrf
                <x-formdinamis tittle="Nama" tipe="text" send="name" value="{{ $item['name'] }}">
                </x-formdinamis>
                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-success">
                        Submit
                    </button>
                    <button type="reset" class="btn btn-danger">
                        Reset
                    </button>
                </div>

            </form>
        </x-modaldinamis>
    @endforeach


</x-layout>
