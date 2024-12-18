<!DOCTYPE html>
<html lang="en" class="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Admin One Tailwind CSS Admin Dashboard</title>

    <!-- Tailwind is included -->
    <link rel="stylesheet" href="css/main.css?v=1628755089081">

    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png" />
    {{-- <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png" /> --}}
    <link rel="mask-icon" href="safari-pinned-tab.svg" color="#00b4b6" />

    <meta name="description" content="Admin One - free Tailwind dashboard">

    <meta property="og:url" content="https://justboil.github.io/admin-one-tailwind/">
    <meta property="og:site_name" content="JustBoil.me">
    <meta property="og:title" content="Admin One HTML">
    <meta property="og:description" content="Admin One - free Tailwind dashboard">
    <meta property="og:image" content="https://justboil.me/images/one-tailwind/repository-preview-hi-res.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1920">
    <meta property="og:image:height" content="960">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:title" content="Admin One HTML">
    <meta property="twitter:description" content="Admin One - free Tailwind dashboard">
    <meta property="twitter:image:src" content="https://justboil.me/images/one-tailwind/repository-preview-hi-res.png">
    <meta property="twitter:image:width" content="1920">
    <meta property="twitter:image:height" content="960">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-130795909-1');
    </script>
    @vite('resources/css/main.css')
    @vite(['resources/js/app.js'])


</head>

<body>

    <div id="app">
        <x-navbar></x-navbar>

        <x-aside> {{ $tittle }}</x-aside>

        {{ $slot }}


        <x-modalpopup></x-modalpopup>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <!-- Scripts below are for demo only -->
    <script type="text/javascript" src="js/main.min.js?v=1628755089081"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <script type="text/javascript" src="js/chart.sample.min.js"></script>



    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=658339141622648&ev=PageView&noscript=1" /></noscript>

    <!-- Icons below are for demo only. Feel free to use any icon pack. Docs: https://bulma.io/documentation/elements/icon/ -->
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css">
    {{-- bostrapp --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    {{-- areaaa js sweet alert --}}
    <!-- Pastikan jQuery di-load terlebih dahulu -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '658339141622648');
        fbq('track', 'PageView');
    </script>

    <script>
        $(document).ready(function() {
            // Menggunakan event delegation untuk menangani klik pada tombol delete
            $(document).on('click', '#delete-record', function() {
                var id = $(this).data('id'); // Mengambil data-id dari tombol yang diklik
                var urlsaya = $(this).data('urlsaya');
                if (!urlsaya) {
                    urlsaya = "deletedata"
                }
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this! ID: " + id,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: urlsaya + '/' + id, // Gantilah dengan URL yang sesuai
                            type: 'DELETE',
                            data: {
                                "_token": "{{ csrf_token() }}" // Pastikan csrf token tersedia
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Deleted!',
                                    'Your record has been deleted.',
                                    'success'
                                );
                                location
                                    .reload(); // Reload halaman untuk melihat perubahan
                            },
                            error: function() {
                                Swal.fire(
                                    'Error!',
                                    'There was a problem deleting the record.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });

            // Menggunakan event delegation untuk menangani klik pada tombol delete
            $(document).on('change', '#Edit-RecordSelect', function() {
                var id = $(this).data('id'); // Mengambil data-id dari tombol yang diklik
                var urledit = $(this).data('urledit');
                var status = $(this).val();

                $.ajax({
                    url: urledit, // Gantilah dengan URL yang sesuai
                    type: 'POST',
                    dataType: 'json', // Format data yang diharapkan
                    data: {
                        "id": id,
                        "status": status,
                        "_token": "{{ csrf_token() }}" // Pastikan csrf token tersedia
                    },

                    success: function(response) {
                        console.log("Response from server:", response);
                        Swal.fire(
                            response.title,
                            response.text,
                            'success'
                        );
                        setTimeout(function() {
                            location.reload();
                        }, 800);
                    },
                    error: function() {
                        console.log("Response from server:", response);
                        Swal.fire(
                            'Error!',
                            'There was a problem deleting the record.',
                            'error'
                        );
                    }
                });


            });


            $(document).ready(function() {
                // Menggunakan event delegation untuk menangani klik pada tombol delete
                $(document).on('click', '#Edit-Cutis', function() {
                    var id = $(this).data('id'); // Mengambil data-id dari tombol yang diklik
                    var urledit = $(this).data('urledit');
                    var status = $(this).val();


                    // Menampilkan token CSRF untuk debugging

                    // Pastikan urledit dan id ada
                    if (!urledit || !id) {
                        Swal.fire(
                            'Error!',
                            'Data tidak lengkap.',
                            'error'
                        );
                        return;
                    }
                    $.ajax({
                        url: urledit, // Gantilah dengan URL yang sesuai
                        type: 'POST',
                        dataType: 'json', // Format data yang diharapkan
                        data: {
                            "id": id,
                            "status": status,
                            "_token": "{{ csrf_token() }}" // Pastikan csrf token tersedia
                        },

                        success: function(response) {
                            Swal.fire(
                                response.title,
                                response.text,
                                'success'
                            );
                            setTimeout(function() {
                                location.reload();
                            }, 800);
                        },
                        error: function() {
                            Swal.fire(
                                'Error!',
                                'There was a problem Editing Cuti the record.',
                                'error'
                            );
                        }
                    });
                });
            });
        });
    </script>

    <script>
        function gantiTeks() {
            // Mengambil elemen teks dengan ID 'mytext'
            const teksElement = document.getElementById("mytext");

            // Mengambil status checkbox
            const checkbox = document.getElementById("status");

            // Mengecek apakah checkbox dicentang atau tidak
            if (checkbox.checked) {
                teksElement.innerText = "Public";
            } else {
                teksElement.innerText = "Private";
            }
        }

        function gantikanTeks($idpost) {
            // Mengambil elemen teks dengan ID 'mytext'
            const teksElement = document.getElementById("mytext" + $idpost);

            // Mengambil status checkbox
            const checkbox = document.getElementById("status" + $idpost);

            // Mengecek apakah checkbox dicentang atau tidak
            if (checkbox.checked) {
                teksElement.innerText = "Public";
            } else {
                teksElement.innerText = "Private";
            }
        }
    </script>


</body>

</html>
