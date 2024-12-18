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
                @php
                    $showButton = false;
                @endphp

                @foreach ($cutis as $user)
                    @if (Auth::user()->id == $user->users_id && $user->status != 'pending')
                        @php
                            $showButton = true; // Jika kondisi terpenuhi, set $showButton jadi true
                            break; // Stop iterasi setelah kondisi terpenuhi
                        @endphp
                    @endif
                @endforeach
                {{-- {{ dd(Auth::user()->id) }} --}}
                @if ($showButton == true)
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addcutis">
                        <i class="mdi mdi-plus"></i>Cuti
                    </button>
                @endif
                <x-modaldinamis id="addcutis" tittle="Add Jenis Cuti" size="modal-lg">
                    <form action="/data/cutis/tambah" method="post">
                        @csrf
                        <div class="mb-3 flex items-center gap-4">
                            <label class="text-sm font-semibold flex-shrink-0 sm:w-1/3">Add Cuti</label>
                            <div class="flex-1">
                                <select name="jeniscuti"
                                    class="form-select w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-500">
                                    <option value="" disabled selected>Pilih opsi</option>
                                    @foreach ($jeniscutis as $items)
                                        <option value="{{ $items->id }}">
                                            {{ $items->jenis }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <x-formdinamis tittle="Keterangan" tipe="text" send="keterangan"> </x-formdinamis>
                        <x-formdinamis tittle="Awal Cuti" tipe="date" send="tglawal"> </x-formdinamis>
                        <x-formdinamis tittle="Akhir Cuti" tipe="date" send="tglakhir"> </x-formdinamis>


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
                            <th>Nomor</th>
                            <th>Jenis Cuti</th>
                            <th>Keterangan</th>
                            <th>Tanggal Pelaksanaan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 0;
                        @endphp
                        @foreach ($cutis as $item)

                            @php
                                $no++;
                            @endphp
                            @if ($item->id != '0')
                                @if (
                                    (Auth::check() && Auth::user()->id == $item->users_id) ||
                                        auth::user()->role == 'manager' ||
                                        auth::user()->role == 'admins')
                                    <tr>
                                        <td data-label="No">{{ $no }}</td>
                                        <td data-label="Jenis Cuti">{{ $item->jeniscutis->jenis }}</td>
                                        <td data-label="Keterangan">{{ $item->keterangan }}</td>
                                        <td data-label="Tanggal Pelaksanaan">
                                            {{ \Carbon\Carbon::parse($item->awalcuti)->translatedFormat('d F Y') }} s/d
                                            {{ \Carbon\Carbon::parse($item->akhircuti)->translatedFormat('d F Y') }}
                                        </td>
                                        {{-- <td data-label="Status">{{ $item->status }}</td> --}}
                                        {{-- cass="button small red " id="delete-record"
                                                        data-id="{{ $item['id'] }}"
                                                        data-urlsaya="data/jeniscutis/delete"> --}}
                                        <td data-label="Status Cuti">
                                            <select name="status" data-urledit="data/cutis/edit/{{ $item['id'] }}"
                                                data-id="{{ $item['id'] }}" id="Edit-RecordSelect"
                                                class="form-select  
                                              
                                                {{ $item->status == 'approved' ? 'bg-green-400 shadow-md' : '' }}
                                                {{ $item->status == 'pending' ? 'bg-yellow-400 shadow-md' : '' }}
                                                {{ $item->status == 'reject' ? 'bg-red-400 shadow-md' : '' }}
                                                 
                                                w-full border-none  focus:ring-0 focus:outline-none
                                                {{ Auth::user()->role == 'staff' ? 'pointer-events-none' : '' }}">
                                                <option value="" disabled selected>Pilih opsi</option>
                                                <option value="approved" class=""
                                                    {{ $item->status == 'approved' ? 'selected' : '' }}
                                                    {{ Auth::user()->role == 'staff' ? 'disabled' : '' }}>
                                                    approved
                                                </option>
                                                <option value="pending"
                                                    {{ $item->status == 'pending' ? 'selected' : '' }}
                                                    {{ Auth::user()->role == 'staff' ? 'disabled' : '' }}>
                                                    pending
                                                </option>
                                                <option value="reject"
                                                    {{ $item->status == 'reject' ? 'selected' : '' }}
                                                    {{ Auth::user()->role == 'staff' ? 'disabled' : '' }}>
                                                    reject
                                                </option>
                                            </select>
                                        </td>


                                        <td class="actions-cell">
                                            <div class="buttons center nowrap">

                                                @if ($item->status == 'approved' || auth::user()->role == 'admins' || Auth::user()->role == 'manager')
                                                    <a href="{{ url('suratcuti/' . $item->users->slugname) }}"
                                                        class="button small green">
                                                        <span class="icon"><i class="mdi mdi-printer"></i></span>
                                                    </a>
                                                @endif

                                                @if ($item->status == 'pending')
                                                    @if (auth::user()->role == 'staff')
                                                        <!-- Staff bisa lihat dan edit jika status pending -->
                                                        <a href="{{ url('cuti-detail/' . $item->id) }}"
                                                            class="button small green">
                                                            <span class="icon"><i class="mdi mdi-eye"></i></span>
                                                        </a>
                                                        <button type="button" class="button small green"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editcuti{{ $item['id'] }}">
                                                            <span class="icon"><i class="mdi mdi-pen"></i></span>
                                                        </button>
                                                    @elseif (auth::user()->role == 'manager' || auth::user()->role == 'admins')
                                                        <!-- Manager dan Admin bisa lihat dan edit, serta cetak -->
                                                        <a href="cuti-detail/{{ $item->id }}"
                                                            class="button small green">
                                                            <span class="icon"><i class="mdi mdi-eye"></i></span>
                                                        </a>
                                                    @endif
                                                @elseif (auth::user()->role == 'manager' || auth::user()->role == 'admins')
                                                    <!-- Manager dan Admin bisa lihat dan cetak, tidak bisa hapus -->
                                                    <a href="cuti-detail/{{ $item->id }}"
                                                        class="button small green">
                                                        <span class="icon"><i class="mdi mdi-eye"></i></span>
                                                    </a>
                                                @endif

                                                @if (auth::user()->role == 'admins')
                                                    <!-- Manager dan Admin tidak bisa hapus -->
                                                    @if ($item->status == 'pending')
                                                        <button class="button small red" id="delete-record"
                                                            data-id="{{ $item['id'] }}"
                                                            data-urlsaya="data/jeniscutis/delete">
                                                            <span class="icon"><i
                                                                    class="mdi mdi-trash-can"></i></span>
                                                        </button>
                                                    @endif
                                                @endif


                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>
    </section>

    {{-- area untuk pop up modal --}}
    @foreach ($cutis as $item)
        @if ($item->id != '0')
            @if (
                (Auth::check() && Auth::user()->id == $item->users_id) ||
                    auth::user()->role == 'manager' ||
                    auth::user()->role == 'admins')
                <x-modaldinamis id="editcuti{{ $item['id'] }}" tittle="Edit Cuti {{ $item['id'] }}"
                    size="modal-lg">
                    <form action="/data/cutis/editdata/{{ $item['id'] }}" method="post">
                        @csrf
                        <div class="mb-3 flex items-center gap-4">
                            <label class="text-sm font-semibold flex-shrink-0 sm:w-1/3">Jenis Cuti</label>
                            <div class="flex-1">
                                <select name="jeniscuti"
                                    class="form-select w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-500">
                                    <option value="" disabled selected>Pilih opsi</option>
                                    @foreach ($jeniscutis as $items)
                                        <option value="{{ $items->id }}" {{ $items->jenis ? 'selected' : '' }}>
                                            {{ $items->jenis }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <x-formdinamis tittle="Keterangan" tipe="text" send="keterangan"
                            value="{{ $item->keterangan }}">
                        </x-formdinamis>
                        <x-formdinamis tittle="Awal Cuti" tipe="date" send="tglawal"
                            value="{{ $item->awalcuti }}">

                        </x-formdinamis>
                        <x-formdinamis tittle="Akhir Cuti" tipe="date" send="tglakhir"
                            value="{{ $item->akhircuti }}">
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
            @endif
        @endif
    @endforeach

</x-layout>
