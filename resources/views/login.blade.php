<!DOCTYPE html>
<html lang="en" class="form-screen">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Admin One Tailwind CSS Admin Dashboard</title>

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

    <!-- Global site tag (gtag.js) - Google Analytics -->

    @vite('resources/css/main.css')
    @vite(['resources/js/app.js'])
</head>

<body>
    <div id="app">
        <section class="section main-section">
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">
                        <span class="icon"><i class="mdi mdi-lock"></i></span>
                        Login
                    </p>

                </header>
                @if (session('gagal'))
                    <div class="notification red">
                        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
                            <div>
                                <span class="icon"><i class="mdi mdi-buffer"></i></span>
                                {{ session('gagal') }}
                            </div>
                            <button type="button"
                                class="button small textual --jb-notification-dismiss">Dismiss</button>
                        </div>
                    </div>
                @endif
                <div class="card-content">
                    <form action="/login" method="post">
                        @csrf
                        <div class="field spaced">
                            <label class="label">Login</label>
                            <div class="control icons-left">
                                <input class="input" type="text" name="username" placeholder="username"
                                    autocomplete="username">
                                <span class="icon is-small left"><i class="mdi mdi-account"></i></span>
                            </div>
                            <p class="help">
                                Please enter your login
                            </p>
                        </div>

                        <div class="field spaced">
                            <label class="label">Password</label>
                            <p class="control icons-left">
                                <input class="input" type="password" name="password" placeholder="Password">
                                <span class="icon is-small left"><i class="mdi mdi-asterisk"></i></span>
                            </p>
                            <p class="help">
                                Please enter your password
                            </p>
                        </div>
                        <hr>
                        <div class="field grouped">
                            <div class="control">
                                <button type="submit" class="button blue">
                                    Login
                                </button>
                            </div>
                            <div class="control">
                                <a href="index.html" class="button">
                                    Back
                                </a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </section>
    </div>
    <!-- Scripts below are for demo only -->
    <script type="text/javascript" src="js/main.min.js?v=1628755089081"></script>

    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=658339141622648&ev=PageView&noscript=1" /></noscript>
    <!-- Icons below are for demo only. Feel free to use any icon pack. Docs: https://bulma.io/documentation/elements/icon/ -->
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css">
</body>

</html>
