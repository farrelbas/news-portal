<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ $title }}</title>

    <meta name="description" content="" />

    @include('Admin.Template.head')
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @include('Admin.Template.sidebar')
            <div class="layout-page">
                @include('Admin.Template.navbar')
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $title }}</h5>
                                <div class="d-flex justify-content-between mt-4">
                                    <div class="col col-sm-2">
                                        <button type="button" class="btn btn-primary" onclick="show_modal('')">
                                            Add
                                        </button>
                                    </div>
                                    <div class="col col-sm-3">
                                        <form method="GET" action="{{ route('user') }}">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="search"
                                                    value="{{ request('search') }}" placeholder="Search level name">

                                                <button class="btn btn-outline-primary" type="submit">
                                                    <i class="bx bx-search-alt"></i>
                                                </button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                                <div class="table-responsive mt-4">
                                    <table class="table table-hover">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th>
                                                    No
                                                </th>
                                                <th>
                                                    User Fullname
                                                </th>
                                                <th>
                                                    Username
                                                </th>
                                                <th>
                                                    User Email
                                                </th>
                                                <th>
                                                    Level
                                                </th>
                                                <th>
                                                    Last Updated
                                                </th>
                                                <th>
                                                    Updated By
                                                </th>
                                                <th>
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            @forelse ($data_user as $key => $row)
                                                <tr>
                                                    <td>{{ $data_user->firstItem() + $key }}</td>
                                                    <td>{{ $row->user_fullname }}</td>
                                                    <td>{{ $row->username }}</td>
                                                    <td>{{ $row->user_email }}</td>
                                                    <td>{{ $row->level_name }}</td>
                                                    <td>{{ date('d F Y', strtotime($row->user_last_updated)) }}</td>
                                                    <td>{{ $row->inserted_by_name }}</td>
                                                    <td class="text-nowrap">
                                                        <button type="button"
                                                            class="btn btn-sm rounded-pill btn-icon btn-warning"
                                                            onclick="show_modal({{ $row->id_user }}, {{ $row->id_level }}, '{{ $row->user_fullname }}', '{{ $row->username }}', '{{ $row->user_email }}')"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                            title="Edit User">
                                                            <span class="tf-icons bx bx-edit"></span>
                                                        </button>

                                                        <button type="button"
                                                            class="btn btn-sm rounded-pill btn-icon btn-danger ms-2"
                                                            onclick="show_modal_delete({{ $row->id_user }}, '{{ $row->user_fullname }}')"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                            title="Delete User">
                                                            <span class="tf-icons bx bx-trash"></span>
                                                        </button>
                                                    </td>

                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">
                                                        Data not found
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>

                                    </table>
                                </div>
                                <div class="row mt-4 mb-2">
                                    <div class="col-md-1 align-middle d-flex flex-column align-items-md-start">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary dropdown-toggle"
                                                data-bs-toggle="dropdown">
                                                {{ request('sortir', 10) }}
                                            </button>

                                            <ul class="dropdown-menu">
                                                @foreach ([10, 20, 50, 100] as $s)
                                                    <li>
                                                        <a class="dropdown-item {{ request('sortir') == $s ? 'active' : '' }}"
                                                            href="{{ request()->fullUrlWithQuery(['sortir' => $s]) }}">
                                                            {{ $s }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>

                                        </div>
                                    </div>
                                    <div class="col-md-5 align-middle d-flex flex-column align-items-md-start mt-2"
                                        id="showing_page">
                                        Showing
                                        {!! $data_user->firstItem() !!} to
                                        {!! $data_user->lastItem() !!} of {!! $data_user->total() !!} entries
                                    </div>
                                    <div class="col-md-6 d-flex flex-column align-items-md-end" id="showing_page">
                                        {!! $data_user->appends(request()->all())->links() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('Admin.Template.footer')
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <div class="modal fade" id="modal_add" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="form_user" onsubmit="return save_data();">
                    @csrf
                    <input type="hidden" id="id_user">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Fullname</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="user_fullname" name="user_fullname"
                                    placeholder="Insert fullname" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Username</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Insert username" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Email</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="user_email" name="user_email"
                                    placeholder="Insert email" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Password</label>
                            <div class="col-sm-8">
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Level</label>
                            <div class="col-sm-8">
                                <select id="id_level" name="id_level" class="form-control" required>
                                    <option value="">-- Choose Level --</option>
                                    @foreach ($data_level as $lvl)
                                        <option value="{{ $lvl->id_level }}">{{ $lvl->level_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="model_delete" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Delete Level</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure want to delete
                    <strong id="user_name_delete" class="text-danger"></strong> ?
                </div>

                <input type="hidden" id="id_user_delete">

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary" onclick="delete_data()">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>

@include('Admin.Template.js')

<script>
    function show_modal(id = '', level = '', name = '', username = '', email = '') {
        $('#form_user')[0].reset();

        $('#id_user').val(id);
        $('#id_level').val(level);
        $('#user_fullname').val(name);
        $('#username').val(username);
        $('#user_email').val(email);
        $('#password').val('');

        if (id == '' || id == null) {
            $('#password').prop('required', true);
            $('#modalCenterTitle').text('Add User');
        } else {
            $('#password').prop('required', false);
            $('#modalCenterTitle').text('Edit User');
        }

        $('#modal_add').modal('show');
    }

    function save_data() {
        $.ajax({
            url: "{{ route('user.store') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id_user: $('#id_user').val(),
                id_level: $('#id_level').val(),
                user_fullname: $('#user_fullname').val(),
                username: $('#username').val(),
                user_email: $('#user_email').val(),
                password: $('#password').val()
            },
            success: function(res) {
                if (res.status) location.reload();
            }
        });

        return false;
    }

    function show_modal_delete(id, name) {
        $('#id_user_delete').val(id);
        $('#user_name_delete').text(name);
        $('#model_delete').modal('show');
    }

    function delete_data() {
        $.ajax({
            url: "{{ route('user.delete') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id_user: $('#id_user_delete').val()
            },
            success: function(res) {
                if (res.status) location.reload();
            }
        });
    }
</script>

</html>
