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

                    {{ $tittle }} | {{ $jabatans->name }}
                </p>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addjobdesk">Add
                    Karywan</button>

                <x-modaldinamis id="addjobdesk" tittle="Add Job Deskripsi" size="modal-lg">
                    <form action="/data/jobdesks/tambah/{{ $jabatans->id }}" method="post">
                        @csrf
                        <x-formdinamis tittle="Nama" tipe="text" send="name"> </x-formdinamis>
                        <div class="mb-3 row">
                            <label for="deskripsi" class="col-sm-2 col-form-label">deskripsi</label>
                            <div class="col-sm-10">
                                <textarea name="deskripsi" class="form-control"></textarea>
                            </div>
                        </div>
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
                            <th>Nama Pekerjaan</th>
                            <th>Deskripsi Pekerjaan</th>
                            <th>Aksi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($jobdesks as $item)
                            <tr>

                                <td data-label="nama">{{ $item['name'] }}</td>
                                <td data-label="deskripsi">{{ Str::limit($item['deskripsi'], 10) }}</td>

                                <td class="actions-cell">
                                    <div class="buttons center nowrap">

                                        <button type="button" class="button small green" data-bs-toggle="modal"
                                            data-bs-target="#editjobdesk{{ $item['id'] }}">
                                            <span class="icon"><i class="mdi mdi-pen"></i></span>
                                        </button>

                                        <button class="button small red " id="delete-record"
                                            data-id="{{ $item['id'] }}" data-urlsaya="/data/jobdesks/delete">
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
    @foreach ($jobdesks as $item)
        <x-modaldinamis id="editjobdesk{{ $item['id'] }}" tittle="edit Jobdesk" size="modal-lg">
            <form action="/data/jobdesks/edit/{{ $item['id'] }}" method="post">
                @csrf
                <x-formdinamis tittle="Nama" tipe="text" send="name" value="{{ $item['name'] }}">
                </x-formdinamis>
                <div class="mb-3 row">
                    <label for="deskripsi" class="col-sm-2 col-form-label">deskripsi</label>
                    <div class="col-sm-10">
                        <textarea name="deskripsi" class="form-control">{{ $item['deskripsi'] }}</textarea>
                    </div>
                </div>
                <input type="hidden" name="idjob" value="{{ $jabatans->id }}" readonly>
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
