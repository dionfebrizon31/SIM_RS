<!DOCTYPE html>
<html lang="en" class="form-screen">

<head>

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


    <!-- Icons below are for demo only. Feel free to use any icon pack. Docs: https://bulma.io/documentation/elements/icon/ -->
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css">
</body>

</html>
