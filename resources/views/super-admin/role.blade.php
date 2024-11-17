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
    @include('layouts.head-css')

    {{-- @include('layouts.head-css') --}}
    <style>
        body {
            background-color: #1d1d1d;
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
            background-color: #20262a;
            color: #fff;
            border-color: #304147;
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
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box mt-1 d-sm-flex align-items-center justify-content-between"
                            style="background-color: transparent;border-style:none">
                            <div>
                                <h3 class="mb-sm-0">{{ $title }}</h3>

                                {{-- <ol class="breadcrumb m-0 mt-2">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            
                                    @foreach ($breadcrumbs as $breadcrumb)
                                        <li class="breadcrumb-item {{ $breadcrumb['active'] ? 'active' : '' }}">
                                            @if (!$breadcrumb['active'])
                                                <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a>
                                            @else
                                                {{ $breadcrumb['label'] }}
                                            @endif
                                        </li>
                                    @endforeach
                                </ol> --}}
                            </div>

                            <div class="page-title-right mt-2 mt-md-0">
                                {{-- Add Buttons Here --}}
                                {{-- <a class="btn btn-primary me-2 align-middle text-center btn-icon" data-bs-toggle="collapse"
                                    href="#collapseExample" role="button" aria-expanded="true" aria-controls="collapseExample">
                                    <i class="mdi mdi-filter-outline fs-5" data-bs-toggle="tooltip" title="Filters"></i>
                                </a> --}}
                                {{-- <a href="#" class="btn btn-primary btn-sm me-2" data-bs-toggle="tooltip" title="Export">
                                    <i class="mdi mdi-export fs-5"></i>
                                </a> --}}
                                @can('create roles')
                                    <a href="{{ route('super-rcreate') }}"
                                        class="btn btn-primary text-center align-middle btn-icon" data-bs-toggle="tooltip"
                                        title="Create">
                                        <i class="ri-add-line fs-5"></i>
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>

                <div class="collapse" id="collapseExample">
                    <div class="card mb-0 bg-dark">
                        <div class="card-body">

                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="card bg-dark">
                        <div class="card-body bg-dark">
                            <div class="table-responsive">
                                <table class="table align-middle bg-dark" id="example">
                                    <thead class="table-light bg-dark">
                                        <th class="bg-dark">Role</th>
                                        <th class="bg-dark" width="70%">Permissions</th>
                                        <th class="bg-dark" width="10%">Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $item)
                                            @if ($item->name == 'Super Admin')
                                                @continue
                                            @endif
                                            <tr>
                                                <td>{{ $item->name }}</td>
                                                <td>
                                                    @foreach ($item->permissions as $permission)
                                                        <span class="badge bg-primary-subtle fw-normal rounded-pill m-1"
                                                            style="color: #1d1d1d">{{ $permission->name }}</span>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @can('edit roles')
                                                        <a href="{{ route('roles.edit', [$item->id]) }}"
                                                            class="btn btn-secondary btn-sm small btn-icon">
                                                            <i class="bi bi-pencil-square" data-bs-toggle="tooltip"
                                                                title="Edit"></i>
                                                        </a>
                                                    @endcan
                                                    @can('delete roles')
                                                        <a href="javascript:void(0)"
                                                            data-url="{{ route('roles.destroy', [$item->id]) }}"
                                                            class="btn btn-danger btn-sm small btn-icon delete_confirm">
                                                            <i class="bi bi-trash" data-bs-toggle="tooltip"
                                                                title="Delete"></i>
                                                        </a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>





@include('layouts.vendor-scripts')

@section('script')
    <script>
        $(document).on('click', '.change_password', function(e) {
            e.preventDefault();
            var id = $(this).data('id')
            $('#id').val(id);
            $('#passwordModal').modal('show');
        });
    </script>
@endsection
