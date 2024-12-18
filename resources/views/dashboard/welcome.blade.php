<x-layout>
    <x-slot:tittle>{{ $tittle }}</x-slot>

    <section class="section main-section">
        <div class="card has-table">
            <div class="card-content">

                {{-- area pc --}}
                <div class=" hidden md:block  flex-wrap">
                    <div class="mx-8">
                        <h1 class="font-bold text-xl mt-4 mb-4 ml-[250px]">Your Profile</h1>
                        <div class="flex ml-[250px]">
                            <img src="https://avatars.dicebear.com/v2/initials/rebecca-bauch.svg"
                                class="rounded-full w-32 h-32">
                        </div>
                        <div class="grid grid-cols-2  gap-y-1 font-medium mx-16 mt-2 mb-4">
                            <!-- Row 1 (Kiri-Kanan) -->
                            <p>Nomor Induk Pegawai </p>
                            <p class="-ml-20">: {{ Auth::user()->nip }}</p>
                            <!-- Row 1 (Kiri-Kanan) -->
                            <p>Nama Lengkap </p>
                            <p class="-ml-20">: {{ Auth::user()->name }}</p>
                            <!-- Row 1 (Kiri-Kanan) -->
                            <p>Email</p>
                            <p class="-ml-20">: {{ Auth::user()->email }}</p>
                            <!-- Row 1 (Kiri-Kanan) -->
                            <p>Nomor HP</p>
                            <p class="-ml-20">: {{ Auth::user()->nohp }}</p>
                            <!-- Row 1 (Kiri-Kanan) -->
                            <p>Alamat</p>
                            <p class="-ml-20">: {{ Auth::user()->alamat }}</p>

                        </div>
                    </div>

                </div>

                {{-- area mobile --}}
                <div class="block md:hidden mb-4">
                    <div class="w-full mx-8 flex justify-center items-center">
                        <table class="mx-auto">
                            <tbody>
                                <tr class="mr-6 ">
                                    <td class="image-cell">
                                        <div class="image">
                                            <img src="https://avatars.dicebear.com/v2/initials/rebecca-bauch.svg"
                                                class="rounded-full">
                                        </div>
                                    </td>
                                    <!-- Row 1 (Kiri-Kanan) -->
                                    <td data-label="Nomor Induk Pegawai" class="ml-2 justify-self-start">:
                                        {{ Auth::user()->nip }}</td>
                                    <!-- Row 1 (Kiri-Kanan) -->
                                    <td data-label="Nama Lengkap" class="ml-2 justify-self-start ">:
                                        {{ Auth::user()->name }}</td>
                                    <!-- Row 1 (Kiri-Kanan) -->
                                    <td data-label="Email" class="ml-2 justify-self-start">: {{ Auth::user()->email }}
                                    </td>
                                    <!-- Row 1 (Kiri-Kanan) -->
                                    <td data-label="Nomor HP" class="ml-2 justify-self-start">: {{ Auth::user()->nohp }}
                                    </td>
                                    <!-- Row 1 (Kiri-Kanan) -->
                                    <td data-label="Alamat" class="ml-2 justify-self-start">:
                                        {{ Auth::user()->alamat }}</td>


                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </section>


</x-layout>
