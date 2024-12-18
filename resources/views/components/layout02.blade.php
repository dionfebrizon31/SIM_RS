<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body>
    <!-- header -->
    <header class="bg-transparent absolute top-0 left-0 w-full flex items-center z-10">
        <div class="container">
            <div class="flex items-center justify-between relative">
                <div class="px-4">
                    <a href="#home" class="font-bold text-lg text-sky-400 block py-6">Home</a>

                </div>
                <div class="flex items-center px-4">
                    <button id="hamburger" name=" hamburger" type="button" class="block absolute right-4 lg:hidden">
                        <span class="hamburger-line transition duration-300 ease-in-out origin-top-left"></span>
                        <span class="hamburger-line transition duration-300 ease-in-out "></span>
                        <span class="hamburger-line  transition duration-300 ease-in-out origin-top-left"></span>
                    </button>
                    {{-- // area mobbile --}}

                    <nav id="nav-menu"
                        class="hidden absolute py-5 bg-white shadow-lg rounded-lg max-w-[250px] w-full right-4 top-full lg:block lg:static lg:bg-transparent lg:max-w-full lg:shadow-none lg:rounded-none">

                        <ul class="block lg:flex">
                            <li class="group mb-2">
                                <a href="#"
                                    class="text-base text-dark py-2 mx-8 group-hover:text-primary">Home</a>
                            </li>
                            <li class="group mb-2">
                                <a href="#"
                                    class="text-base text-dark py-2 mx-8 group-hover:text-primary ">Home</a>
                            </li>

                            @if (Auth::guard('visitor')->check() && Auth::guard('visitor')->user()->role == 'users')
                                <li class="group mb-2 relative">
                                    <!-- Nama pengguna, akan memunculkan dropdown ketika di-hover -->
                                    <a href="#" class="text-base text-dark py-2 mx-8 group-hover:text-primary">
                                        {{ Auth::guard('visitor')->user()->name }}
                                    </a>

                                    <!-- Dropdown Menu -->
                                    <ul
                                        class="absolute left-0 hidden group-hover:block bg-white shadow-lg rounded-lg mt-2 w-48">
                                        <li>
                                            <a href="#" class="block py-2 px-4 text-dark hover:bg-gray-100">Profil
                                                Saya</a>
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="block py-2 px-4 text-dark hover:bg-gray-100">Pengaturan</a>
                                        </li>
                                        <li>
                                            <a href="/logout"
                                                class="block py-2 px-4 text-dark hover:bg-gray-100">Keluar</a>
                                        </li>
                                    </ul>
                                </li>
                            @else
                                <li class="group mb-2">
                                    <a href="/visitor-login"
                                        class="text-base text-dark py-2 mx-8 group-hover:text-primary ">Login</a>
                                </li>
                            @endif

                        </ul>


                    </nav>
                    {{-- end area mobile --}}


                </div>
            </div>
        </div>
    </header>

    {{ $slot }}


</body>

</html>
