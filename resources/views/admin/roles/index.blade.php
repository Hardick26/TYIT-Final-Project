<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EPTS - Manage Roles</title>
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
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h1 class="h3">Manage Roles</h1>
                        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                            Add new
                        </a>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    Show 
                                    <select class="form-select mx-2" style="width: auto;">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                    entries
                                </div>
                                <div class="search-box">
                                    <input type="text" class="form-control" placeholder="Search...">
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Role Title</th>
                                            <th>Role Slug</th>
                                            <th>Status</th>
                                            <th>Date Created</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($roles as $index => $role)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $role->title }}</td>
                                            <td>{{ $role->slug }}</td>
                                            <td>
                                                <span class="badge bg-success">Enable</span>
                                            </td>
                                            <td>{{ $role->created_at->diffForHumans() }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-sm" style="background-color: #17a2b8; color: white; margin-right: 5px;">
                                                        <i class="align-middle" data-feather="edit-2"></i>
                                                    </a>
                                                    <a href="{{ route('admin.roles.show', $role->id) }}" class="btn btn-sm" style="background-color: #28a745; color: white; margin-right: 5px;">
                                                        <i class="align-middle" data-feather="eye"></i>
                                                    </a>
                                                    <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm" style="background-color: #dc3545; color: white;" onclick="return confirm('Are you sure you want to delete this role?')">
                                                            <i class="align-middle" data-feather="trash-2"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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