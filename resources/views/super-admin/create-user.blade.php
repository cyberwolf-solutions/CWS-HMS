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
    {{-- @include('layouts.topbar') --}}

    <div id="loader" class="position-absolute d-none"
        style="z-index: 9999;top:0;left:0;user-select: none;background-color:#0000007b;width:100vmax;height:100%;display: flex;
justify-content: center;
align-items: center;">
        @include('layouts.loader')
    </div>
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
                        <h3 class="mb-4 mt-3">Add User</h3>

                        {{-- <div class="page-title-box d-sm-flex align-items-center bg-dark justify-content-between">
                            <div>
                                <h3 class="mb-sm-0">{{ $title }}</h3>
            
                                <ol class="breadcrumb m-0 mt-2">
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
                                </ol>
                            </div>
            
                            <div class="page-title-right">
                                Add Buttons Here
                                <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip"
                                    title="Create">
                                    <i class="ri-add-line fs-5"></i>
                                </a>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="row mt-2" style="border-radius: 10px;margin-left:1px;margin-right:1px">
                    <div class="card bg-dark">
                        <div class="card-body bg-dark">
                            <form method="POST" class="ajax-form"
                                action="{{ $is_edit ? route('users.update', $data->id) : route('super-usertore') }}">
                                @csrf
                                @if ($is_edit)
                                    @method('PATCH')
                                @endif
                                <div class="row">
                                    <div class="col-md-6 mb-3 required">
                                        <label for="" class="form-label" style="color: #ddd">Name</label>
                                        <input type="text" name="name" id="" class="form-control"
                                            value="{{ $is_edit ? $data->name : '' }}" placeholder="Enter your name" />
                                    </div>
                                    <div class="col-md-6 mb-3 required">
                                        <label for="" class="form-label" style="color: #ddd">Email</label>
                                        <input type="email" name="email" id="" class="form-control"
                                            value="{{ $is_edit ? $data->email : '' }}" placeholder="Enter your email" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3 required" style="color: #ddd">
                                        <label for="" class="form-label">Role</label>
                                        <select class="form-control js-example-basic-single" name="role"
                                            id="">
                                            <option value="" selected>Select...</option>
                                            @foreach ($roles as $role)
                                                @if ($role->name == 'Super Admin' && ($is_edit && $data->getRoleNames()[0] != 'Super Admin'))
                                                    @continue
                                                @endif
                                                <option value="{{ $role->id }}"
                                                    {{ $is_edit && $data->hasRole($role->name) ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if (!$is_edit)
                                        <div class="col-md-6 mb-3 required" style="color: #ddd">
                                            <label for="" class="form-label">Password</label>
                                            <input type="password" name="password" id="" class="form-control"
                                                @if ($is_edit) readonly @endif
                                                placeholder="Enter your password" />
                                        </div>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3 required">
                                        <label for="" class="form-label" style="color: #ddd">Branch</label>
                                        <select class="form-control js-example-basic-single" name="branch"
                                            id="">
                                            <option value="" selected>Select...</option>
                                            @foreach ($branch as $branchs)
                                                @if ($branchs->name == 'Super Admin' && ($is_edit && $data->getRoleNames()[0] != 'Super Admin'))
                                                    @continue
                                                @endif
                                                <option value="{{ $branchs->id }}" {{-- {{ ($is_edit && $data->hasRole($role->name) ? 'selected' : '') }} --}}>
                                                    {{ $branchs->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>


                                <div class="row mb-3">
                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-light me-2"
                                            onclick="window.location='{{ route('users.index') }}'">Cancel</button>
                                        <button class="btn btn-primary">{{ $is_edit ? 'Update' : 'Create' }}</button>
                                    </div>
                                </div>
                            </form>
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
