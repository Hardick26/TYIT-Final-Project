<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EPTS - Task Management</title>
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
                        <h1 class="h3">Manage Tasks</h1>
                        <a href="{{ route('tasks.create') }}" class="btn btn-primary">
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
                                <div class="search-box d-flex">
                                    <input type="text" 
                                           class="form-control" 
                                           id="searchInput" 
                                           placeholder="Search..."
                                           value="{{ request('search') }}"
                                           style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                                    <button type="button" 
                                            id="searchButton" 
                                            class="btn btn-primary" 
                                            style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                        <i data-feather="search"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Title</th>
                                            <th>Assigned To</th>
                                            <th>Due Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tasks as $index => $task)
                                        <tr>
                                            <td>{{ ($tasks->currentPage() - 1) * $tasks->perPage() + $index + 1 }}</td>
                                            <td>{{ $task->title }}</td>
                                            <td>{{ $task->assignedTo->name ?? 'Not Assigned' }}</td>
                                            <td>{{ $task->due_date ? date('d M Y', strtotime($task->due_date)) : 'No Due Date' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $task->status == 'completed' ? 'success' : ($task->status == 'in_progress' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm" style="background-color: #17a2b8; color: white; margin-right: 5px;">
                                                        <i class="align-middle" data-feather="edit-2"></i>
                                                    </a>
                                                    <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-sm" style="background-color: #28a745; color: white; margin-right: 5px;">
                                                        <i class="align-middle" data-feather="eye"></i>
                                                    </a>
                                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm" style="background-color: #dc3545; color: white;" onclick="return confirm('Are you sure you want to delete this task?')">
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

                            <div class="mt-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        Showing {{ $tasks->firstItem() ?? 0 }} to {{ $tasks->lastItem() ?? 0 }} of {{ $tasks->total() ?? 0 }} entries
                                    </div>
                                    <div class="pagination-container">
                                        @if ($tasks->hasPages())
                                            <div class="pagination-wrapper">
                                                <div class="d-flex gap-1">
                                                    @if ($tasks->onFirstPage())
                                                        <span class="btn btn-outline-secondary btn-sm disabled">Previous</span>
                                                    @else
                                                        <a href="{{ $tasks->previousPageUrl() }}" class="btn btn-outline-secondary btn-sm">Previous</a>
                                                    @endif

                                                    @foreach ($tasks->getUrlRange(1, $tasks->lastPage()) as $page => $url)
                                                        @if ($page == $tasks->currentPage())
                                                            <span class="btn btn-primary btn-sm">{{ $page }}</span>
                                                        @else
                                                            <a href="{{ $url }}" class="btn btn-outline-secondary btn-sm">{{ $page }}</a>
                                                        @endif
                                                    @endforeach

                                                    @if ($tasks->hasMorePages())
                                                        <a href="{{ $tasks->nextPageUrl() }}" class="btn btn-outline-secondary btn-sm">Next</a>
                                                    @else
                                                        <span class="btn btn-outline-secondary btn-sm disabled">Next</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
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

        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const searchButton = document.getElementById('searchButton');
            feather.replace(); // Make sure the search icon renders

            // Search function
            function performSearch() {
                const searchValue = searchInput.value;
                const currentUrl = new URL(window.location.href);
                
                if (searchValue) {
                    currentUrl.searchParams.set('search', searchValue);
                } else {
                    currentUrl.searchParams.delete('search');
                }
                
                window.location.href = currentUrl.toString();
            }

            // Button click event
            searchButton.addEventListener('click', performSearch);

            // Enter key press event
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    performSearch();
                }
            });
        });
    </script>

    <style>
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
        border-radius: 0.2rem;
    }
    .gap-1 {
        gap: 0.25rem !important;
    }
    .pagination-wrapper .disabled {
        pointer-events: none;
        color: #6c757d;
        border-color: #6c757d;
        opacity: 0.65;
    }
    </style>
</body>
</html> 
