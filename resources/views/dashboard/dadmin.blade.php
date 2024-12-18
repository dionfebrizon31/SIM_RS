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

        @if (session('status'))
            <div class="notification green">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
                    <div>
                        <span class="icon"><i class="mdi mdi-buffer"></i></span>
                        {{ session('status') }}
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

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAdmins">Add
                    Admin</button>

                <x-modaldinamis id="addAdmins" tittle="Add Admin" size="modal-lg">
                    <form action="/data/admins/tambah" method="post">
                        @csrf
                        <x-formdinamis tittle="email" tipe="email" send="email"> </x-formdinamis>
                        <x-formdinamis tittle="Nama" tipe="text" send="name"> </x-formdinamis>
                        <x-formdinamis tittle="username" tipe="text" send="username"> </x-formdinamis>
                        <x-formdinamis tittle="password" tipe="password" send="password"> </x-formdinamis>
                        <div class="mb-3 flex items-center gap-4">
                            <!-- Label: Lebar 1/3 pada layar lebih besar -->
                            <label class="text-sm font-semibold flex-shrink-0 sm:w-1/3">Department</label>
                            <!-- Input field: Lebar 2/3 pada layar lebih besar -->
                            <div class="flex-1">
                                <select name="jabatans"
                                    class="form-select w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-500">
                                    <option value="" disabled selected>Pilih opsi</option>
                                    <option value="0">Tidak ada</option>
                                    @foreach ($jabatans as $item)
                                        @if ($item->id == '0')
                                            @continue
                                        @endif
                                        <option value="{{ $item->id }} ">
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
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
                            <th class="checkbox-cell">
                                <label class="checkbox">
                                    <input type="checkbox">
                                    <span class="check"></span>
                                </label>
                            </th>
                            <th class="image-cell">Picture</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Nomor</th>
                            <th>Alamat</th>
                            <th>jabatans</th>
                            <th>Created</th>
                            <th>Aksi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $item)
                            @if ($item['role'] == 'admins')
                                <tr>
                                    <td class="checkbox-cell">
                                        <label class="checkbox">
                                            <input type="checkbox">
                                            <span class="check"></span>
                                        </label>
                                    </td>
                                    <td class="image-cell">
                                        <div class="image">
                                            <img src="https://avatars.dicebear.com/v2/initials/rebecca-bauch.svg"
                                                class="rounded-full">
                                        </div>
                                    </td>
                                    <td data-label="namalengkap">{{ $item['name'] }}</td>
                                    <td data-label="email">{{ $item['email'] }}</td>
                                    <td data-label="username">{{ $item['username'] }}</td>
                                    <td data-label="Nohp">{{ $item['nomorhp'] }}</td>
                                    <td data-label="alamat">{{ $item['alamat'] }}</td>
                                    <td data-label="alamat">{{ $item->jabatans->name }}</td>


                                    <td data-label="Created">
                                        <small class="text-gray-500"
                                            title="Oct 25, 2021">{{ $item['created_at'] }}</small>
                                    </td>
                                    <td class="actions-cell">
                                        <div class="buttons right nowrap">
                                            <button type="button" class="button small green" data-bs-toggle="modal"
                                                data-bs-target="#editadmin{{ $item['id'] }}">
                                                <span class="icon"><i class="mdi mdi-eye"></i></span>
                                            </button>

                                            <button class="button small red " id="delete-record"
                                                data-id="{{ $item['id'] }}" data-urlsaya="data/admins/delete">
                                                <span class="icon"><i class="mdi mdi-trash-can"></i></span>
                                            </button>

                                        </div>
                                    </td>
                                </tr>
                            @endif
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
    @foreach ($users as $item)
        <x-modaldinamis id="editadmin{{ $item['id'] }}" tittle="edit karyawan" size="modal-lg">
            <form action="/data/admins/edit/{{ $item['id'] }}" method="post">
                @csrf
                <x-formdinamis tittle="email" tipe="email" send="email" value="{{ $item['email'] }}">
                </x-formdinamis>
                <x-formdinamis tittle="Nama" tipe="text" send="name" value="{{ $item['name'] }}">
                </x-formdinamis>
                <x-formdinamis tittle="username" tipe="text" send="username" value="{{ $item['username'] }}">
                </x-formdinamis>
                <x-formdinamis tittle="Nomor Hp" tipe="text" send="nohp" value="{{ $item['nomorhp'] }}">
                </x-formdinamis>
                <x-formdinamis tittle="Alamat" tipe="text" send="alamat" value="{{ $item['alamat'] }}">
                </x-formdinamis>
                <div class="mb-3 flex items-center gap-4">
                    <!-- Label: Lebar 1/3 pada layar lebih besar -->
                    <label class="text-sm font-semibold flex-shrink-0 sm:w-1/3">Department</label>
                    <!-- Input field: Lebar 2/3 pada layar lebih besar -->
                    <div class="flex-1">
                        <select name="jabatans"
                            class="form-select w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-500">
                            <option value="" disabled selected>Pilih opsi</option>
                            <option value="0">Tidak ada</option>
                            @foreach ($jabatans as $item)
                                @if ($item->id == '0')
                                    @continue
                                @endif
                                <option
                                    value="{{ $item->id }}  {{ $item->id == $item->jabatans_id ? 'selected' : '' }}">
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <input type="hidden" name="role" value="admins">


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
