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
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <h3 class="mb-4 mt-3">Add Role</h3>

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
                                
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="row mt-2 bg-dark">
                    <div class="card bg-dark">
                        <div class="card-body bg-dark">
                            <form method="POST" class="ajax-form"
                                action="{{ $is_edit ? route('roles.update', $data->id) : route('super.rolestore') }}">
                                @csrf
                                @if ($is_edit)
                                    @method('PATCH')
                                @endif
                                <div class="row">
                                    <div class="col-md-12 mb-3 required">
                                        <label for="" style="color: #ddd" class="form-label">Role Name</label>
                                        <input type="text" name="name" id="" class="form-control"
                                            value="{{ $is_edit ? $data->name : '' }}" placeholder="Enter role name" />
                                    </div>
                                </div>
                                <div class="row">
                                    <p style="color: #ddd">Assign Permissions to Role</p>
                                    <div class="form-group col-12">
                                        <div class="table-responsive">
                                            <table class="table dt-responsive nowrap align-middle">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th class="bg-dark" width="25%">Module</th>
                                                        <th class="bg-dark">Permission</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $main = [
                                                            'users',
                                                            'roles',
                                                            'employees',
                                                            'customers',
                                                            'suppliers',
                                                            'products',
                                                            'categories',
                                                            'units',
                                                            'purchases',
                                                            'pos',
                                                            'kitchen',
                                                            'bar',
                                                            'tables',
                                                            // 'table arrangements',
                                                            'meals',
                                                            'ingredients',
                                                            'modifiers',
                                                            'rooms',
                                                            'bookings',
                                                            'orders',
                                                            'report',
                                                            'settings',
                                                        ];
                                                    @endphp
                                                    @foreach ($main as $moduleName)
                                                        <tr>
                                                            <td scope="row">
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input me-2 all"
                                                                        type="checkbox" id="{{ $moduleName }}"
                                                                        data-id="{{ $moduleName }}">
                                                                    <label class="form-check-label"
                                                                        for="{{ $moduleName }}">
                                                                        {{ ucfirst($moduleName) }}
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                @foreach ($permissions as $permission)
                                                                    @php
                                                                        $words = explode(' ', $permission->name);
                                                                        $action = array_shift($words); // Get the action word
                                                                        $permissionModuleName = implode(' ', $words); // Get the module name
                                                                    @endphp
                                                                    @if ($permissionModuleName === $moduleName)
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input me-2"
                                                                                type="checkbox"
                                                                                id="{{ $action . $moduleName }}"
                                                                                name="permissions[]"
                                                                                value="{{ $permission->name }}"
                                                                                data-id="{{ $moduleName }}"
                                                                                {{ $is_edit && in_array($permission->name, $data->permissions->pluck('name')->toArray()) ? 'checked' : '' }}>
                                                                            <label class="form-check-label"
                                                                                for="{{ $action . $moduleName }}">
                                                                                @php
                                                                                    $action = explode('_', $action);
                                                                                    $action = implode(' ', $action);
                                                                                @endphp
                                                                                {{ ucfirst($action) }}
                                                                            </label>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-light me-2"
                                            onclick="window.location='{{ route('roles.index') }}'">Cancel</button>
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


@section('script')
    <script>
        $(document).ready(function() {
            $('.all').change(function() {
                var id = $(this).data('id');
                var checkboxes = $('input[type="checkbox"][data-id="' + id + '"]');
                if ($(this).prop('checked')) {
                    checkboxes.each(function() {
                        $(this).prop('checked',
                            true); // Uncheck the checkbox if it's already checked
                    });
                } else {
                    checkboxes.each(function() {
                        $(this).prop('checked',
                            false); // Check the checkbox if it's not already checked
                    });

                }
            });
        });
    </script>
@endsection
