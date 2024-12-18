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

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addjabatans">

                    <i class="mdi mdi-plus"></i>jabatan</button>

                <x-modaldinamis id="addjabatans" tittle="Add Jabatan" size="modal-lg">
                    <form action="/data/jabatans/tambah" method="post">
                        @csrf
                        <div class="mb-3 flex items-center gap-4">
                            <label class="text-sm font-semibold flex-shrink-0 sm:w-1/3">Divisi</label>
                            <div class="flex-1">
                                <select name="divisi1" id="divisiselected"
                                    class="form-select w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-500"
                                    onchange="handleDivisiChange(this, 'otherInputDiv')">
                                    <option value="" disabled selected>Pilih opsi</option>

                                    @php
                                        // Membuat array untuk menyimpan divisi yang sudah ditampilkan
                                        $divisiDitampilkan = [];
                                    @endphp

                                    @foreach ($jabatans as $item)
                                        @if ($item->id == '0')
                                            @continue
                                        @endif

                                        @if (!in_array($item->divisi, $divisiDitampilkan))
                                            <option value="{{ $item->divisi }}">
                                                {{ $item->divisi }}
                                            </option>
                                            @php
                                                // Menambahkan divisi ke array yang sudah ditampilkan
                                                $divisiDitampilkan[] = $item->divisi;
                                            @endphp
                                        @endif
                                    @endforeach
                                    <option value="">other</option>
                                </select>
                            </div>
                        </div>
                        <!-- Input untuk 'Other' -->
                        <div id="otherInputDiv" class="mb-3 flex items-center gap-4" style="display: none;">
                            <label for="otherInput" class="text-sm font-semibold flex-shrink-0 sm:w-1/3">Divisi
                                Lainnya</label>
                            <div class="flex-1">
                                <input type="text" id="otherInput" name="divisi2"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                                    placeholder="Masukkan nama divisi lainnya">
                            </div>
                        </div>

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
                            <th>Nama Jabatan</th>
                            <th>Aksi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jabatans as $item)
                            @if ($item->id != '999')
                                <tr>
                                    <td data-label="divisi">{{ $item['divisi'] }}</td>
                                    <td data-label="namajabatan">{{ $item['name'] }}</td>
                                    <td class="actions-cell">
                                        <div class="buttons center nowrap">
                                            <a href="detail-jabatan/{{ $item->id }}" class="button small green">
                                                <span class="icon"><i class="mdi mdi-eye"></i></span>
                                            </a>
                                            <button type="button" class="button small green" data-bs-toggle="modal"
                                                data-bs-target="#editjabatans{{ $item['id'] }}">
                                                <span class="icon"><i class="mdi mdi-pen"></i></span>
                                            </button>

                                            <button class="button small red " id="delete-record"
                                                data-id="{{ $item['id'] }}" data-urlsaya="data/jabatans/delete">
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
        </div>
    </section>

    {{-- area untuk pop up modal --}}
    @foreach ($jabatans as $item)
        <x-modaldinamis id="editjabatans{{ $item['id'] }}" tittle="edit Jabatans" size="modal-lg">
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


    <script>
        // Fungsi untuk menangani perubahan pilihan, dengan parameter id dan otherchange
        function handleDivisiChange(selectElement, otherInputDivId) {
            // Ambil elemen select dan div input teks menggunakan parameter yang diteruskan
            const divisiSelect = selectElement; // Elemen select yang memicu onchange
            const otherInputDiv = document.getElementById(otherInputDivId); // Elemen div input teks

            // Cek apakah opsi "Other" dipilih
            if (divisiSelect.value === '') {
                // Tampilkan input text untuk "Other"
                otherInputDiv.style.display = 'flex'; // Gunakan 'flex' agar sesuai dengan layout
            } else {
                // Sembunyikan input text jika selain "Other"
                otherInputDiv.style.display = 'none';
            }
        }
    </script>
</x-layout>
