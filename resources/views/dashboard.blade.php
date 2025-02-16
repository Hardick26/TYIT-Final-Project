<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EPTS - Dashboard</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/light.css') }}" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        @include('partials.sidebar')

        <div class="main">
            @include('partials.navbar')

            <main class="content">
                <div class="container-fluid p-0">
                    <h1 class="h3 mb-3">Dashboard</h1>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Welcome!</h5>
                                </div>
                                <div class="card-body">
                                    {{ __("You're logged in!") }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            @include('partials.footer')
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            feather.replace();
        });
    </script>
</body>
</html>
