<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EPTS - View Role</title>
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
                    <div class="mb-3">
                        <h1 class="h3 d-inline align-middle">View Role Details</h1>
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-primary float-end">
                            Back to Roles
                        </a>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Role Name:</label>
                                <p>{{ $role->title }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Role Slug:</label>
                                <p>{{ $role->slug }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Status:</label>
                                <p>
                                    <span class="badge bg-success">Enable</span>
                                </p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Created At:</label>
                                <p>{{ $role->created_at->format('Y-m-d H:i:s') }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Last Updated:</label>
                                <p>{{ $role->updated_at->format('Y-m-d H:i:s') }}</p>
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