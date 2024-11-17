<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Branch</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    @include('layouts.head-css')
  
  <style>
        body {
            background-color:#1d1d1d;
            color: #fff;
        }

        .sidebar {
            background-color: #20262a;
            min-height: 100vh;
            padding: 15px;
        }

        .sidebar a {
            color: #bbb;
            padding: 10px;
            display: block;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #383e48;
            color: #fff;
        }

        .content-area {
            padding: 20px;
            background-color: #1d1d1d;
        }

        .stats-card {
            background-color: #20262a;
            border: none;
            padding: 20px;
            color: #fff;
        }

        .form-control {
            background-color: #1d1d1d;
            border: none;
            color: #fff;
        }

        .form-control::placeholder {
            color: #ddd;
        }

        .form-control:focus {
            background-color:  #20262a;
            color: #fff;
            border-color: #304147;
        }

        .btn-primary {
            background-color: #008cba;
            border: none;
        }

        .btn-danger {
            background-color: #e74c3c;
            border: none;
        }

        .btn-success {
            background-color: #27ae60;
            border: none;
        }

        .table th,
        .table td {
            color: #fff;
        }

        .pagination .page-link {
            background-color: #3a3f51;
            border: none;
            color: #fff;
        }
        .pagination .page-item .page-link {
    background-color: #3a3f51;
    color: #fff;
    border: none;
}

.pagination .page-item.active .page-link {
    background-color: #008cba;
    color: #fff;
    border: none;
}

.pagination .page-item .page-link:hover {
    background-color: #5a5e73;
    color: #fff;
}

.pagination .page-item.disabled .page-link {
    color: #bbb;
    background-color: #2a2d3a;
}

    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3" style="  background-color: #1d1d1d;">

                {{-- <h4 class="text-center text-white">Super Admin Panel</h4>
                <a href="{{ route('super-index') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="{{ route('super-user1') }}"><i class="fas fa-user"></i> User Management</a>
                <a href="{{ route('super-branch') }}"><i class="fas fa-users"></i> Branch Management</a>
                <a href="{{ route('super-role') }}"><i class="fas fa-file-alt"></i> Role Management</a> --}}

                @include('layouts.admin-sidebar')

            </div>

            <!-- Content Area -->
            <div class="col-md-9 content-area">
                <h3 class="mb-4">Add Branch</h3>

                <!-- Add Branch Form -->
                <div class="card mb-4 bg-dark">
                    <div class="card-body">
                        <form method="POST" class="ajax-form" action="{{ route('super-branchcreate') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="branchName" style="color: #ddd" class="form-label">Branch Name</label>
                                    <input name="bname" type="text" class="form-control" id="branchName"
                                    >
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="branchCode" style="color: #ddd" class="form-label">Branch Code</label>
                                    <input name="bcode" type="text" class="form-control" id="branchCode"
                                      >
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="description" style="color: #ddd" class="form-label">Description</label>
                                    <input name="description" type="text" class="form-control" id="branchDescription"
                                      >
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="location" style="color: #ddd" class="form-label">Location</label>
                                    <input name="location" type="text" class="form-control" id="branchLocation"
                                      >
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contact" style="color: #ddd" class="form-label">Contact</label>
                                    <input name="contact" type="number" class="form-control" id="branchContact"
                                  >
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" style="color: #ddd" class="btn btn-light">Submit</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Branch List Table -->
                <h4>Branch List</h4>
              

                <!-- Branches Table -->
                <div class="row mt-4 bg-dark" style="border-radius: 10px;margin-left:1px;margin-right:1px">
                    <div class="col-md-12">
                        <div class="card bg-dark" style="border-style: none">
                            <div class="card-body bg-dark">
                                <h5 class="card-title">Branches</h5>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label>Show
                                            <select name="entries" class="form-select form-select-sm"
                                                style="width: auto; display: inline;">
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                            </select> entries
                                        </label>
                                    </div>
                                    {{-- <div class="col-md-6 text-end">
                      <input type="text" class="form-control form-control-sm" placeholder="Search">
                  </div> --}}
                                </div>
                                <table class="table table-dark table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Branch Name</th>
                                            <th>Branch Code</th>
                                            <th>Branch Description</th>
                                            <th>Branch Location</th>
                                            <th>Branch Contact</th>
                                            <th>Status</th>
                                            <th>Login</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($branches as $branch)
                                            <tr>
                                                <td>{{ $branch->id }}</td>
                                                <td>{{ $branch->name }}</td>
                                                <td>{{ $branch->code }}</td>
                                                <td>{{ $branch->description }}</td>
                                                <td>{{ $branch->location }}</td>
                                                <td>{{ $branch->contact }}</td>
                                                <td>
                                                    @if ($branch->trashed())
                                                        <!-- Assuming you're using soft deletes for status -->
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @else
                                                        <span class="badge bg-success">Active</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.impersonate.branch', $branch->id) }}"
                                                        class="text-info">
                                                        <i class="fas fa-sign-in-alt"></i>
                                                    </a>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <!-- Pagination -->
                        {{-- <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-end">
                                {{ $branches->links() }}
                            </ul>
                        </nav> --}}
                        <!-- Pagination -->
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center flex-wrap">
        <!-- Previous Page Link -->
        @if ($branches->onFirstPage())
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1">Previous</a>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $branches->previousPageUrl() }}">Previous</a>
            </li>
        @endif

        <!-- Page Number Links -->
        @foreach ($branches->getUrlRange(1, $branches->lastPage()) as $page => $url)
            @if ($page == $branches->currentPage())
                <li class="page-item active">
                    <span class="page-link">{{ $page }}</span>
                </li>
            @elseif ($page == 1 || $page == $branches->lastPage() || abs($branches->currentPage() - $page) <= 1)
                <li class="page-item">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @elseif ($page == $branches->currentPage() - 2 || $page == $branches->currentPage() + 2)
                <li class="page-item disabled">
                    <span class="page-link">...</span>
                </li>
            @endif
        @endforeach

        <!-- Next Page Link -->
        @if ($branches->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $branches->nextPageUrl() }}">Next</a>
            </li>
        @else
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1">Next</a>
            </li>
        @endif
    </ul>
</nav>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
@include('layouts.vendor-scripts')
