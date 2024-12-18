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

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addjeniscutis">

                    <i class="mdi mdi-plus"></i>Jenis Cuti</button>

                <x-modaldinamis id="addjeniscutis" tittle="Add Jenis Cuti" size="modal-lg">
                    <form action="/data/jeniscutis/tambah" method="post">
                        @csrf
                        <x-formdinamis tittle="Jenis Cuti" tipe="text" send="jenis"> </x-formdinamis>
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

                            <th>Jenis Cuti</th>
                            <th>Aksi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jeniscutis as $item)
                            @if ($item->id != '999')
                                <tr>

                                    <td data-label="Jenis Cuti">{{ $item['jenis'] }}</td>
                                    <td class="actions-cell">
                                        <div class="buttons center nowrap">

                                            <button type="button" class="button small green" data-bs-toggle="modal"
                                                data-bs-target="#editjeniscuti{{ $item['id'] }}">
                                                <span class="icon"><i class="mdi mdi-pen"></i></span>
                                            </button>

                                            <button class="button small red " id="delete-record"
                                                data-id="{{ $item['id'] }}" data-urlsaya="data/jeniscutis/delete">
                                                <span class="icon"><i class="mdi mdi-trash-can"></i></span>
                                            </button>

                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach

                    </tbody>
                </table>

            </div>

    </section>

    {{-- area untuk pop up modal --}}
    @foreach ($jeniscutis as $item)
        <x-modaldinamis id="editjeniscuti{{ $item['id'] }}" tittle="Edit Jenis Cuti" size="modal-lg">
            <form action="/data/jeniscutis/edit/{{ $item['id'] }}" method="post">
                @csrf
                <x-formdinamis tittle="Jenis Cuti" tipe="text" send="jenis" value="{{ $item['jenis'] }}">
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
