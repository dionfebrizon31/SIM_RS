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

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addabsensi">

                    <i class="mdi mdi-plus"></i>jabatan</button>

                <x-modaldinamis id="addabsensi" tittle="Add Jabatan" size="modal-lg">
                    <form action="/data/absensi/tambah" method="post">
                        @csrf
                        <div class="mb-3 flex items-center gap-4">
                            <label class="text-sm font-semibold flex-shrink-0 sm:w-1/3">Divisi</label>

                        </div>
                        <!-- Input untuk 'Other' -->


                        <x-formdinamis tittle="Name Jabatan" tipe="text" send="name"> </x-formdinamis>
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

            </section>

            <div class="card-content">
                <table>
                    <thead>
                        <tr>
                            <th>divisi</th>
                            <th>Checkin</th>
                            <th>Latest</th>
                            <th>Checkout</th>


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

                                <td data-label="Nama" class="border-r border-gray-400 px-4 py-2">{{ $item->user->name }}
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
                            {{-- <td class="actions-cell">
                                <div class="buttons center nowrap">
                                    <a href="detail-jabatan/{{ $item->id }}" class="button small green">
                                        <span class="icon"><i class="mdi mdi-eye"></i></span>
                                    </a>
                                    <button type="button" class="button small green" data-bs-toggle="modal"
                                        data-bs-target="#editabsensi{{ $item['id'] }}">
                                        <span class="icon"><i class="mdi mdi-pen"></i></span>
                                    </button>

                                    <button class="button small red " id="delete-record" data-id="{{ $item['id'] }}"
                                        data-urlsaya="data/absensi/delete">
                                        <span class="icon"><i class="mdi mdi-trash-can"></i></span>
                                    </button>

                                </div>
                            </td> --}}
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
