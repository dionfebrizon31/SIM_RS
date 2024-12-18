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

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addkaryawan">Add
                    Karywan</button>

                <x-modaldinamis id="addkaryawan" tittle="Add karyawan" size="modal-lg">
                    <form action="/data/User/tambah" method="post" enctype="multipart/form-data">
                        @csrf


                        <div class="col-span-3 relative flex justify-center items-center">
                            <div class="mb-3 flex flex-col items-center space-y-4">
                                <!-- Label untuk Upload File -->
                                <label for="uploadFile-1" id="Labelupload-1" data-id="-1"
                                    class="text-sm font-semibold text-gray-700">Upload File</label>

                                <!-- Preview Gambar -->
                                <img id="previewImage-1" data-id="-1" src="{{ asset('images/No_available.png') }}"
                                    alt="Preview Gambar"
                                    class="w-48 h-48 object-cover border border-gray-300 rounded-md mb-4">
                                <!-- Custom Button Choose File -->
                                <label for="uploadFile-1" data-id="-1"
                                    class="w-full inline-block py-2 px-4 bg-blue-500 text-white text-center rounded-md cursor-pointer">
                                    Choose File
                                </label>

                                <!-- Hidden Input File yang sebenarnya -->
                                <input type="file" id="uploadFile-1" data-id="-1" accept="image/*"
                                    class="hidden w-full" name="gambar">
                            </div>
                        </div>


                        <x-formdinamis tittle="Email" tipe="email" send="email"> </x-formdinamis>
                        <x-formdinamis tittle="Nama" tipe="text" send="name"> </x-formdinamis>
                        <x-formdinamis tittle="Username" tipe="text" send="username"> </x-formdinamis>
                        <x-formdinamis tittle="Password" tipe="password" send="password"> </x-formdinamis>
                        <x-formdinamis tittle="Nip" tipe="text" send="nip"> </x-formdinamis>
                        <x-formdinamis tittle="Nomor Hp" tipe="text" send="nohp"> </x-formdinamis>
                        <x-formdinamis tittle="Alamat" tipe="text" send="alamat"> </x-formdinamis>
                        <x-formdinamis tittle="Tanggal Masuk" tipe="date" send="tglmasuk"> </x-formdinamis>

                        <div class="mb-3 flex items-center gap-4">
                            <!-- Label: Lebar 1/3 pada layar lebih besar -->
                            <label class="text-sm font-semibold flex-shrink-0 sm:w-1/3">Level role</label>
                            <!-- Input field: Lebar 2/3 pada layar lebih besar -->
                            <div class="flex-1">
                                <select name="role"
                                    class="form-select w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-500">
                                    <option value="" disabled selected>Pilih opsi</option>
                                    <option value="staff">Staff</option>
                                    <option value="manager">Manager</option>
                                    <option value="admins">Administrator</option>

                                </select>
                            </div>
                        </div>
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
                                        <option value="{{ $item->id }}">{{ $item->divisi }} | {{ $item->name }}
                                        </option>
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

                            <th class="image-cell"></th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Nomor</th>
                            <th>Alamat</th>
                            <th>Jabatan</th>
                            <th>Created</th>
                            <th>Aksi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($User as $item)
                            <tr>

                                <td class="image-cell">
                                    <div class="image">
                                        <img src="{{ url('penyimpanan/' . $item->jabatans->divisi . '/' . $item->username . '/' . $item->gambar) }}"
                                            class="rounded-full">
                                    </div>
                                </td>
                                <td data-label="namalengkap">{{ $item['name'] }}</td>
                                <td data-label="email">{{ $item['email'] }}</td>
                                <td data-label="username">{{ $item['username'] }}</td>
                                <td data-label="Nohp">{{ $item['nohp'] }}</td>
                                <td data-label="alamat">{{ Str::limit($item['alamat'], 10) }}</td>
                                @if ($item->jabatan_id > -1)
                                    <td data-label="jabatans">--</td>
                                @else
                                    <td data-label="jabatans">{{ $item->jabatans->name }}</td>
                                @endif

                                <td data-label="Created">
                                    <small class="text-gray-500"
                                        title="Oct 25, 2021">{{ $item['created_at'] }}</small>
                                </td>
                                <td class="actions-cell">
                                    <div class="buttons right nowrap">
                                        @if ($item->jabatans->id != '0')
                                            <a href="/detail-jabatan/{{ $item->jabatans->id }}"
                                                class="button small green">
                                                <span class="icon"><i class="mdi mdi-eye"></i></span>
                                            </a>
                                        @endif
                                        <button type="button" class="button small green" data-bs-toggle="modal"
                                            data-bs-target="#editkaryawan{{ $item['id'] }}">
                                            <span class="icon"><i class="mdi mdi-pen"></i></span>
                                        </button>

                                        <button class="button small red " id="delete-record"
                                            data-id="{{ $item['id'] }}" data-urlsaya="data/User/delete">
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
    @foreach ($User as $item)
        <x-modaldinamis id="editkaryawan{{ $item['id'] }}" tittle="edit karyawan" size="modal-lg">
            <form action="/data/User/edit/{{ $item['id'] }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="col-span-3 relative flex justify-center items-center">
                    <div class="mb-3 flex flex-col items-center space-y-4">
                        <!-- Label untuk Upload File -->
                        <label for="uploadFile{{ $item['id'] }}" id="Labelupload{{ $item['id'] }}"
                            data-id="{{ $item['id'] }}" class="text-sm font-semibold text-gray-700">Upload
                            File</label>

                        <!-- Preview Gambar -->
                        <img id="previewImage{{ $item['id'] }}" data-id="{{ $item['id'] }}"
                            src="{{ url('penyimpanan/' . $item->jabatans->divisi . '/' . $item->username . '/' . $item->gambar) }}"
                            alt="Preview Gambar"
                            class="w-48 h-48 object-cover border border-gray-300 rounded-md mb-4">

                        <!-- Custom Button Choose File -->
                        <label for="uploadFile{{ $item['id'] }}" data-id="{{ $item['id'] }}"
                            class="w-full inline-block py-2 px-4 bg-blue-500 text-white text-center rounded-md cursor-pointer">
                            Choose File
                        </label>

                        <!-- Hidden Input File yang sebenarnya -->
                        <input type="file" id="uploadFile{{ $item['id'] }}" data-id="{{ $item['id'] }}"
                            accept="image/*" class="hidden w-full" name="gambar">
                    </div>
                </div>
                <x-formdinamis tittle="Email" tipe="email" send="email" value="{{ $item['email'] }}">
                </x-formdinamis>
                <x-formdinamis tittle="Nama" tipe="text" send="name" value="{{ $item['name'] }}">
                </x-formdinamis>
                <x-formdinamis tittle="Username" tipe="text" send="username" value="{{ $item['username'] }}">
                </x-formdinamis>
                <x-formdinamis tittle="Nip" tipe="text" send="nip" value="{{ $item['nip'] }}">
                </x-formdinamis>
                <x-formdinamis tittle="Nomor Hp" tipe="text" send="nohp" value="{{ $item['nohp'] }}">
                </x-formdinamis>
                <x-formdinamis tittle="Alamat" tipe="text" send="alamat" value="{{ $item['alamat'] }}">
                </x-formdinamis>
                <x-formdinamis tittle="Tanggal Masuk" tipe="date" send="tglmasuk"
                    value="{{ old('tglmasuk', $item->tglmasuk ? \Carbon\Carbon::parse($item->tglmasuk)->format('Y-m-d') : '') }}">
                </x-formdinamis>


                <!-- Level Selection -->
                <div class="mb-3 flex items-center gap-4">
                    <label class="text-sm font-semibold flex-shrink-0 sm:w-1/3">Level</label>
                    <div class="flex-1">
                        <select name="jabatans"
                            class="form-select w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-500">
                            <option value="" disabled selected>Pilih opsi</option>
                            <option value="admins " {{ $item->role ? 'selected' : '' }}>
                                Administrator</option>
                            <option value="manager" {{ $item->role ? 'selected' : '' }}>Manager
                            </option>
                            <option value="staff" {{ $item->role ? 'selected' : '' }}>staff
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Department Selection -->
                <div class="mb-3 flex items-center gap-4">
                    <label class="text-sm font-semibold flex-shrink-0 sm:w-1/3">Department</label>
                    <div class="flex-1">
                        <select name="jabatans"
                            class="form-select w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-500">
                            <option value="" disabled {{ is_null($item->jabatans_id) ? 'selected' : '' }}>
                                Pilih
                                opsi</option>
                            <option value="0">Tidak ada</option>
                            @foreach ($jabatans as $jabatan)
                                @if ($jabatan->id == '0')
                                    @continue
                                @endif
                                <option value="{{ $jabatan->id }}"
                                    {{ $item->jabatans_id == $jabatan->id ? 'selected' : '' }}>
                                    {{ $jabatan->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <input type="hidden" name="role" value="User">

                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="reset" class="btn btn-danger">Reset</button>
                </div>

            </form>
        </x-modaldinamis>
    @endforeach
    <script>
        // Fungsi untuk menangani perubahan pada input file
        function handleFileUpload(event) {
            const id = event.target.dataset.id; // Ambil data-id yang unik
            const previewImage = document.getElementById('previewImage' + id); // Dapatkan elemen preview gambar

            const file = event.target.files[0]; // Ambil file yang diupload

            // Cek apakah file ada dan apakah itu gambar
            if (file && file.type.startsWith('image/')) {
                const imageURL = URL.createObjectURL(file); // Buat URL untuk file gambar
                previewImage.src = imageURL; // Set gambar preview
                previewImage.style.display = 'block'; // Tampilkan gambar preview
            } else {
                previewImage.style.display = 'none'; // Sembunyikan gambar preview jika file bukan gambar
                alert('Harap upload file gambar!');
            }
        }

        // Menambahkan event listener untuk input file setelah DOM selesai dimuat
        document.addEventListener('DOMContentLoaded', function() {
            // Pilih semua input file yang memiliki data-id
            const fileInputs = document.querySelectorAll('input[type="file"][data-id]');

            // Tambahkan event listener pada setiap input file
            fileInputs.forEach(function(input) {
                input.addEventListener('change',
                    handleFileUpload); // Pasang event listener untuk setiap input file
            });
        });
    </script>




</x-layout>
