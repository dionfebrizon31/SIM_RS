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
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addpostingan">Add
                    Karywan</button>

                <x-modaldinamis id="addpostingan" tittle="Postingan" size="modal-lg">
                    <form action="/data/posts/tambah" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="field">
                            <label class="label">Public / Private</label>
                            <div class="field-body">
                                <div class="field">
                                    <label class="switch">
                                        <input type="checkbox" onclick="gantiTeks()" name="status" id="status"
                                            value="false">
                                        <span class="check"></span>
                                        <span class="control-label" id="mytext">Private</span>
                                    </label>
                                </div>
                            </div>
                        </div>



                        <x-formdinamis tittle="tittle" tipe="text" send="title"> </x-formdinamis>
                        <div class="mb-3 flex items-center gap-4">
                            <!-- Label: Lebar 1/3 pada layar lebih besar -->
                            <label class="text-sm font-semibold flex-shrink-0 sm:w-1/3">deskripsi</label>
                            <!-- Input field: Lebar 2/3 pada layar lebih besar -->
                            <div class="flex-1">
                                <textarea name="deskripsi" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-500"></textarea>
                            </div>
                        </div>

                        <div class="col-span-3 relative flex justify-center items-center">
                            <div class="mb-3 flex flex-col items-center space-y-4">
                                <!-- Label untuk Upload File -->
                                <label for="uploadFile" id="Labelupload"
                                    class="text-sm font-semibold text-gray-700">Upload File</label>

                                <!-- Preview Gambar -->
                                <img id="previewImage" src="{{ asset('images/No_available.png') }}" alt="Preview Gambar"
                                    class="w-48 h-48 object-cover border border-gray-300 rounded-md mb-4">
                                <!-- Custom Button Choose File -->
                                <label for="uploadFile"
                                    class="w-full inline-block py-2 px-4 bg-blue-500 text-white text-center rounded-md cursor-pointer">
                                    Choose File
                                </label>

                                <!-- Hidden Input File yang sebenarnya -->
                                <input type="file" id="uploadFile" accept="image/*" class="hidden w-full"
                                    name="gambar">
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
                            <th>gambar</th>
                            <th>judul</th>
                            <th>deskripsi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($posts as $post)
                            <tr>
                                <td class="image-column mb-2">
                                    <div class="flex justify-start items-start">
                                        <img id="previewImage" src="{{ url('storage/postingan/' . $post->gambar) }}"
                                            alt="Preview Gambar"
                                            class="w-24 h-24 object-cover border border-gray-300 rounded-md">
                                    </div>
                                </td>


                                <td data-label="title">{{ Str::limit($post['title'], 20) }}</td>
                                <td data-label="deskripsi">{{ Str::limit($post['deskripsi'], 10) }}</td>
                                <td data-label="status">{{ $post['status'] }}</td>

                                <td class="actions-cell">
                                    <div class="buttons center nowrap">

                                        <button type="button" class="button small green" data-bs-toggle="modal"
                                            data-bs-target="#editpostingan{{ $post['id'] }}">
                                            <span class="icon"><i class="mdi mdi-pen"></i></span>
                                        </button>

                                        <button class="button small red " id="delete-record"
                                            data-id="{{ $post['id'] }}" data-urlsaya="/data/posts/delete">
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
    @foreach ($posts as $post)
        <x-modaldinamis id="editpostingan{{ $post['id'] }}" tittle="edit postingan" size="modal-lg">
            <form action="/data/posts/edit/{{ $post['id'] }}" method="post">
                @csrf
                <div class="col-span-3 relative flex justify-center items-center">
                    <div class="mb-3 flex flex-col items-center space-y-4">
                        <!-- Label untuk Upload File -->
                        <label for="uploadFile" id="Labelupload" class="text-sm font-semibold text-gray-700">Upload
                            File</label>

                        <!-- Preview Gambar -->
                        <img id="previewImage" src="{{ url('storage/postingan/' . $post->gambar) }}"
                            alt="Preview Gambar"
                            class="w-48 h-48 object-cover border border-gray-300 rounded-md mb-4">
                        <!-- Custom Button Choose File -->
                        <label for="uploadFile"
                            class="w-full inline-block py-2 px-4 bg-blue-500 text-white text-center rounded-md cursor-pointer">
                            Choose File
                        </label>

                        <!-- Hidden Input File yang sebenarnya -->
                        <input type="file" id="uploadFile" accept="image/*" class="hidden w-full"
                            name="gambar">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Public / Private</label>
                    <div class="field-body">
                        <div class="field">
                            <label class="switch">
                                <input type="checkbox" onclick="gantikanTeks({{ $post['id'] }})" name="status"
                                    id="status{{ $post['id'] }}" value="true"
                                    {{ $post['status'] == 'public' ? 'checked' : '' }}>
                                <span class="check"></span>
                                <span class="control-label"
                                    id="mytext{{ $post['id'] }}">{{ $post['status'] == 'public' ? 'Public' : 'Private' }}</span>
                            </label>
                        </div>
                    </div>
                </div>
                <x-formdinamis tittle="title" tipe="text" send="title" value="{{ $post['title'] }}">
                </x-formdinamis>
                <div class="mb-3 flex items-center gap-4">
                    <!-- Label: Lebar 1/3 pada layar lebih besar -->
                    <label class="text-sm font-semibold flex-shrink-0 sm:w-1/3">deskripsi</label>
                    <!-- Input field: Lebar 2/3 pada layar lebih besar -->
                    <div class="flex-1">
                        <textarea name="deskripsi" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-500">{{ $post['deskripsi'] }}</textarea>
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
    @endforeach

    <script>
        // Ambil elemen input file dan elemen img
        const uploadFileInput = document.getElementById('uploadFile');
        const previewImage = document.getElementById('previewImage');
        const Labelupload = document.getElementById('Labelupload');

        function showImagePreview(file) {
            const imageURL = URL.createObjectURL(file);
            previewImage.src = imageURL;
            previewImage.style.display = 'block';
        }
        // Event listener untuk input file
        uploadFileInput.addEventListener('change', function(event) {
            // Ambil file yang diupload
            const file = event.target.files[0];

            // Cek apakah file ada dan apakah itu gambar
            if (file && file.type.startsWith('image/')) {
                showImagePreview(file);

            } else {
                // Jika file bukan gambar, sembunyikan elemen img
                previewImage.style.display = 'none';
                alert('Harap upload file gambar!');
            }
        });
    </script>

</x-layout>
