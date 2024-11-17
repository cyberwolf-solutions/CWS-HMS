{{-- @extends('layouts.super-master') --}}


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Thimbiri Wewa Resort Wilpattu" name="description" />
    <meta content="CyberWolf Solutions (Pvt) Ltd." name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
    {{-- @include('layouts.topbar') --}}

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
                <div class="row ">
                    <div class="col-12 ">



                        <div class="page-title-box d-sm-flex mt-1 align-items-center justify-content-between"
                            style="background-color: transparent">
                            <div>
                                <h3 class="mb-sm-0">{{ $title }}</h3>

                                {{-- <ol class="breadcrumb m-0 mt-2">
                   

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

                            <div class="page-title-right">
                                {{-- Add Buttons Here --}}
                                @can('create users')
                                    <a href="{{ route('super-ucreate') }}" class="btn btn-primary btn-icon"
                                        data-bs-toggle="tooltip" title="Create">
                                        <i class="ri-add-line"></i>
                                    </a>
                                @endcan



                            </div>


                        </div>
                    </div>
                </div>

                <div class="row px-3 mt-3 gy-2">
                    @foreach ($data as $item)
                        <div class="col-md-6">
                            <div class="card bg-dark text-start rounded-4 py-3">
                                <div class="card-body bg-dark">
                                    <div class="row position-relative">
                                        <div class="col-3">
                                            <img class="card-img-top img-fluid rounded-circle"
                                                src="{{ $item->avatar != '' ? asset('storage/logos/' . $item->avatar) : asset('build/images/users/user-dummy-img.jpg') }}"
                                                alt="Image" />
                                        </div>
                                        <div class="col-9">
                                            <div class="position-absolute end-0 pe-3">
                                                <button type="button" class="btn btn-dark" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="ri-more-fill"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    @can('edit users')
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('users.edit', [$item->id]) }}">Edit</a>
                                                        </li>
                                                    @endcan
                                                    @can('change_password users')
                                                        <li><a class="dropdown-item change_password"
                                                                data-id="{{ $item->id }}"
                                                                href="javascript:void(0)">Change Password</a></li>
                                                    @endcan
                                                    @can('change_status users')
                                                        @if ($item->getRoleNames()[0] != 'Super Admin')
                                                            @if ($item->id != Auth::user()->id)
                                                                @can('change_status users')
                                                                    <li><a class="dropdown-item  @if ($item->is_active) link-danger @else link-success @endif post_confirm"
                                                                            href="javascript:void(0)"
                                                                            data-url="{{ route('users.status', ['id' => $item->id, 'status' => $item->is_active]) }}"
                                                                            data-title="Are you want to deactive this user!">
                                                                            @if ($item->is_active)
                                                                                Deactive
                                                                            @else
                                                                                Active
                                                                            @endif
                                                                        </a></li>
                                                                @endcan
                                                            @endif
                                                        @endif
                                                    @endcan
                                                </ul>
                                            </div>
                                            <span class="card-title fs-2 fw-semibold"
                                                style="color: #bbb">{{ $item->name }} </span>
                                            <br>
                                            <span class="card-text" style="color: #d7d6d6">{{ $item->email }}</span>
                                            <br>
                                            <span class="card-text"
                                                style="color: #d7d6d6">{{ $item->getRoleNames()->first() }}</span>
                                            <br>
                                            <span class="card-text small">
                                                @if ($item->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Deactive</span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{-- <div class="col-md-6">
            <div class="card text-center rounded-4 py-2">
                <div class="card-body">
                    <h4 class="fs-2 fw-semibold">Create New </h4>
                    <button type="button" class="btn btn-primary fs-3 btn-icon btn-sm">
                        <i class="ri-add-fill"></i>
                    </button>
                    <br>
                    <p>Click here to create a new user</p>
                </div>
            </div>
        </div> --}}
                </div>
                <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Reset Password</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="body">
                                <form method="POST" action="{{ route('reset-password') }}" class="ajax-form">
                                    @csrf
                                    <input type="hidden" name="id" id="id">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="password" class="form-label">New Password</label>
                                                <input id="password" type="password" class="form-control "
                                                    name="password" required="" autocomplete="new-password">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="password_confirmation" class="form-label">Confirm New
                                                    Password</label>
                                                <input id="password-confirm" type="password" class="form-control"
                                                    name="password_confirmation" required=""
                                                    autocomplete="new-password">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="button" value="Cancel" class="btn btn-light"
                                            data-bs-dismiss="modal">
                                        <input type="submit" value="Update" class="btn btn-primary">
                                    </div>

                                </form>
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
