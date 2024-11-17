<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Bootstrap CSS -->
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> --}}

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Bootstrap Datepicker CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

    <!-- Bootstrap Datepicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    @include('layouts.head-css')

    {{-- @include('layouts.head-css') --}}
    <style>
        body {
            background-color: #1d1d1d;
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

        .t {
            background-color: #20262a;
            border: none;
        }

        .table th,
        .table td {
            color: #fff;
        }

        .back-button {
            position: fixed;
            /* Stays in place when scrolling */
            top: 20px;
            /* Adjust the distance from the top */
            left: 20px;
            /* Adjust the distance from the left */
            z-index: 1000;
            /* Ensures it stays on top of other elements */
            font-size: 20px;
            /* Adjust the size of the icon */
            color: #ffffff;
            /* Icon color */
        }

        .back-button:hover {
            color: #8a8a8a;
            /* Icon color on hover */
        }
    </style>
</head>

<body>

    <div id="loader" class="position-absolute d-none"
    style="z-index: 9999;top:0;left:0;user-select: none;background-color:#0000007b;width:100vmax;height:100%;display: flex;
justify-content: center;
align-items: center;">
    @include('layouts.loader')
</div>
    {{-- @include('layouts.topbar') --}}
    <div class="container-fluid">
        {{-- <a href="{{ route('home') }}" class="back-button">
            <i class="fa fa-arrow-left"></i> <!-- Back icon from Font Awesome -->
        </a> --}}


        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3" style="  background-color: #1d1d1d;">
                {{-- <h4 class="text-center text-white">Nmae & logo</h4>
                <a href="{{ route('super-index') }}"><i class="fas fa-tachometer-alt"></i> Dashboardaaaa</a>
                <a href="{{ route('super-user1') }}"><i class="fas fa-user"></i> User Management</a>
                <a href="{{ route('super-branch') }}"><i class="fas fa-users"></i> Branch Management</a>
                <a href="{{ route('super-role') }}"><i class="fas fa-file-alt"></i> Role Management</a> --}}
                @include('layouts.admin-sidebar')

            </div>

            <!-- Content Area -->
            <div class="col-md-9 content-area">
                <div class="d-flex justify-content-between align-items-center">
                    <h3>Dashboard</h3>
                    <div class="profile">
                        <i class="fas fa-user-circle"></i> SuperAdmin | Main Branch
                    </div>
                </div>



                <div class="d-flex justify-content-between align-items-center mt-3">
                    <p>Here’s what’s happening with your company today.</p>
                    <div class="form-group">
                        {{-- <label for="date-picker"><i class="fas fa-calendar-alt"></i> Select Date:</label> --}}
                        <div class="input-group date" id="date-picker">
                            <input type="text" class="form-control" placeholder="Select a date" />
                            <div class="input-group-append">
                                <span class="input-group-text"
                                    style="height: 100%; border-left-top: none; border-bottom: none;"><i
                                        class="fas fa-calendar-alt"></i></span>
                                {{-- <span class="input-group-text" style="height: 100%;"><i class="fas fa-calendar-alt"></i></span> --}}
                            </div>
                        </div>
                    </div>


                </div>
                <!-- Stats Cards -->
                <div class="row mt-4">
                    <div class="col-3 mt-2">
                        <div class="card stats-card">
                            <div class="row">
                                <div class="col-6">
                                    <span style="color: #c1c0c0">Branches</span>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h5><i class="fas fa-users" style="color: red"></i></h5>
                                </div>
                            </div>
                            <h2>{{ $totalBranches }}</h2>
                        </div>
                    </div>
                    <div class="col-3 mt-2">
                        <div class="card stats-card">
                            <div class="row">
                                <div class="col-6">
                                    <span style="color: #c1c0c0">Users</span>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h5><i class="fas fa-user-tag" style="color: red"></i></h5>
                                </div>
                            </div>
                            <h2>{{ $totalUsers }}</h2>
                        </div>
                    </div>
                    <div class="col-3 mt-2">
                        <div class="card stats-card">
                            <div class="row">
                                <div class="col-6">
                                    <span style="color: #c1c0c0">Roles</span>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h5><i class="fas fa-chart-line" style="color: red"></i></h5>
                                </div>
                            </div>
                            <h2>{{ $totalBranches }}</h2>
                        </div>
                    </div>
                    <div class="col-3 mt-2">
                        <div class="card stats-card">
                            <div class="row">
                                <div class="col-6">
                                    <span style="color: #c1c0c0">Roles</span>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h5><i class="fas fa-chart-line" style="color: red"></i></h5>
                                </div>
                            </div>
                            <h2>{{ $totalBranches }}</h2>
                        </div>
                    </div>
                    <div class="col-3 mt-4">
                        <div class="card stats-card">
                            <div class="row">
                                <div class="col-6">
                                    <span style="color: #c1c0c0">Roles</span>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h5><i class="fas fa-users" style="color: red"></i></h5>
                                </div>
                            </div>
                            <h2>{{ $totalBranches }}</h2>
                        </div>
                    </div>
                    <div class="col-3 mt-4">
                        <div class="card stats-card">
                            <div class="row">
                                <div class="col-6">
                                    <span style="color: #c1c0c0">Roles</span>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h5><i class="fas fa-user-tag" style="color: red"></i></h5>
                                </div>
                            </div>
                            <h2>{{ $totalBranches }}</h2>
                        </div>
                    </div>
                    <div class="col-3 mt-4">
                        <div class="card stats-card">
                            <div class="row">
                                <div class="col-6">
                                    <span style="color: #c1c0c0">Roles</span>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h5><i class="fas fa-chart-line" style="color: red"></i></h5>
                                </div>
                            </div>
                            <h2>{{ $totalBranches }}</h2>
                        </div>
                    </div>
                    <div class="col-3 mt-4">
                        <div class="card stats-card">
                            <div class="row">
                                <div class="col-6">
                                    <span style="color: #c1c0c0">Roles</span>
                                </div>
                                <div class="col-6" style="text-align: right;">
                                    <h5><i class="fas fa-chart-line" style="color: red"></i></h5>
                                </div>
                            </div>
                            <h2>{{ $totalBranches }}</h2>
                        </div>
                    </div>
                </div>

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
                                            {{-- <th>Status</th> --}}
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
                                                {{-- <td>
                                @if ($branch->trashed())
                                    <!-- Assuming you're using soft deletes for status -->
                                    <span class="badge bg-danger">Inactive</span>
                                @else
                                    <span class="badge bg-success">Active</span>
                                @endif
                            </td> --}}
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
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-end">
                                {{ $branches->links() }}
                            </ul>
                        </nav>
                    </div>
                </div>



                <!-- Recent Activity Section -->
                <div class="row mt-4" style="border-radius: 10px;margin-left:1px;margin-right:1px">
                    <div class="col-md-12">
                        <div class="card bg-dark" style="border-style: none">
                            <div class="card-body bg-dark">
                                <h5 class="card-title">Recent Activity</h5>
                                <ul class="list-group">
                                    <li class="list-group-item bg-dark text-white">
                                        <i class="fas fa-user"></i> SuperAdmin accessed from Chrome
                                    </li>
                                    <!-- Add more activities as needed -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Area -->

                <!-- Top Greeting and User Info -->





                <!-- Yearly Report Section -->
                <div class="row mt-4 bg-dark" style="border-radius: 10px;margin-left:1px;margin-right:1px">
                    <div class="col-md-12 bg-dark">
                        <div class="card bg-dark">
                            <div class="card-body bg-dark">
                                <h5 class="card-title">Yearly Report</h5>
                                <p>Infinity</p>
                                <!-- You can add graphs or more detailed reports here -->
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Bootstrap JS -->
        <script>
            const options = {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            };
            const currentDate = new Date().toLocaleDateString('en-US', options);
            document.getElementById('current-date').innerText = currentDate;
        </script>
        <script>
            $(document).ready(function() {
                $('#date-picker').datepicker({
                    format: 'mm/dd/yyyy', // Change this format as needed
                    autoclose: true,
                    todayHighlight: true
                });
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
@include('layouts.vendor-scripts')
