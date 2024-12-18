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

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addjabatans">Add
                    Karywan</button>

                <x-modaldinamis id="addjabatans" tittle="Add Jabatan" size="modal-lg">
                    <form action="/data/jabatans/tambah" method="post">
                        @csrf
                        <x-formdinamis tittle="Nama" tipe="text" send="name"> </x-formdinamis>
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
                            <th>Nama Jabatan</th>
                            <th>Aksi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jobdesks as $item)
                            <tr>
                                <td data-label="namajabatan">{{ $item['deskripsi'] }}</td>

                                <td class="actions-cell">
                                    <div class="buttons right nowrap">
                                        <button type="button" class="button small green" data-bs-toggle="modal"
                                            data-bs-target="#editjabatans{{ $item['id'] }}">
                                            <span class="icon"><i class="mdi mdi-eye"></i></span>
                                        </button>
                                        <button class="button small red " id="delete-record"
                                            data-id="{{ $item['id'] }}" data-urlsaya="data/jabatans/delete">
                                            <span class="icon"><i class="mdi mdi-trash-can"></i></span>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <div class="table-pagination">
                    <div class="flex items-center justify-between">
                        <div class="buttons">
                            <button type="button" class="button active">1</button>
                            <button type="button" class="button">2</button>
                            <button type="button" class="button">3</button>
                        </div>
                        <small>Page 1 of 3</small>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- area untuk pop up modal --}}
    @foreach ($jobdesks as $item)
        <x-modaldinamis id="editjabatans{{ $item['id'] }}" tittle="edit karyawan" size="modal-lg">
            <form action="/data/jabatans/edit/{{ $item['id'] }}" method="post">
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
