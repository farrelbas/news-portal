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
                                        <div class="input-group">
                                            <input type="text" class="form-control" id=""
                                                placeholder="Search level name">
                                            <button class="btn btn-outline-primary" type="sumbit" id="">
                                                <i class="bx bx-search-alt"></i>
                                            </button>
                                        </div>
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
                                                    Level Name
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
                                            @forelse ($data_level as $key => $row)
                                                <tr>
                                                    <td>{{ $data_level->firstItem() + $key }}</td>
                                                    <td>{{ $row->level_name }}</td>
                                                    <td>{{ date('d F Y', strtotime($row->level_last_updated)) }}</td>
                                                    <td>{{ $row->user_fullname }}</td>
                                                    <td>
                                                        <button type="button"
                                                            class="btn btn-sm rounded-pill btn-icon btn-warning"
                                                            onclick="show_modal()" data-bs-toggle="tooltip"
                                                            data-bs-offset="0,4" data-bs-placement="bottom"
                                                            data-bs-html="true" data-bs-original-title="Edit Level">
                                                            <span class="tf-icons bx bx-edit"></span>
                                                        </button>
                                                        <button type="button"
                                                            class="btn btn-sm rounded-pill btn-icon btn-danger ms-2"
                                                            onclick="show_modal_delete({{ json_encode($row) }})"
                                                            data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                            data-bs-placement="bottom" data-bs-html="true"
                                                            data-bs-original-title="Delete Level">
                                                            <span class="tf-icons bx bx-trash"></span>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">
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
                                            <button type="button" class="btn btn-maroon dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                {{ request('sortir') == null ? '10' : request('sortir') }}
                                            </button>
                                            <ul class="dropdown-menu" id="listSortir">
                                                <li class="listAttr" value="10"><a
                                                        class="dropdown-item {{ request('sortir') == 10 || !request('sortir') ? 'active' : '' }}">10</a>
                                                </li>
                                                <li class="listAttr" value="20"><a
                                                        class="dropdown-item {{ request('sortir') == 20 ? 'active' : '' }}"
                                                        href="#">20</a></li>
                                                <li class="listAttr" value="50"><a
                                                        class="dropdown-item {{ request('sortir') == 50 ? 'active' : '' }}"
                                                        href="#">50</a></li>
                                                <li class="listAttr" value="100"><a
                                                        class="dropdown-item {{ request('sortir') == 100 ? 'active' : '' }}"
                                                        href="#">100</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-5 align-middle d-flex flex-column align-items-md-start mt-2"
                                        id="showing_page">
                                        Showing
                                        {!! $data_level->firstItem() !!} to
                                        {!! $data_level->lastItem() !!} of {!! $data_level->total() !!} entries
                                    </div>
                                    <div class="col-md-6 d-flex flex-column align-items-md-end" id="showing_page">
                                        {!! $data_level->appends(request()->all())->links() !!}
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
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">Level Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="level_name" name="level_name"
                                placeholder="Insert level name">
                        </div>
                    </div>
                </div>

                <input type="hidden" id="id_level" name="id_level">

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary" onclick="save_data()">
                        Save
                    </button>
                </div>
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
                    Are you sure want to delete this level?
                </div>

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
    function show_modal() {
        $('#modal_add').modal('show');
    };
</script>

</html>
