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
                                        <form method="GET" action="{{ route('news-category') }}">
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
                                                    News Category Name
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
                                            @forelse ($data_news_category as $key => $row)
                                                <tr>
                                                    <td>{{ $data_news_category->firstItem() + $key }}</td>
                                                    <td>{{ $row->news_category_name }}</td>
                                                    <td>
                                                        {{ date('d F Y', strtotime($row->news_category_last_updated)) }}
                                                    </td>
                                                    <td>{{ $row->user_fullname }}</td>
                                                    <td>
                                                        <button type="button"
                                                            class="btn btn-sm rounded-pill btn-icon btn-warning"
                                                            onclick="show_modal({{ $row->id_news_category }}, '{{ $row->news_category_name }}')"
                                                            data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                            data-bs-placement="bottom" data-bs-html="true"
                                                            data-bs-original-title="Edit News Category">
                                                            <span class="tf-icons bx bx-edit"></span>
                                                        </button>
                                                        <button type="button"
                                                            class="btn btn-sm rounded-pill btn-icon btn-danger ms-2"
                                                            onclick="show_modal_delete({{ $row->id_news_category }}, '{{ $row->news_category_name }}')"
                                                            data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                            data-bs-placement="bottom" data-bs-html="true"
                                                            data-bs-original-title="Delete News Category">
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
                                        {!! $data_news_category->firstItem() !!} to
                                        {!! $data_news_category->lastItem() !!} of {!! $data_news_category->total() !!} entries
                                    </div>
                                    <div class="col-md-6 d-flex flex-column align-items-md-end" id="showing_page">
                                        {!! $data_news_category->appends(request()->all())->links() !!}
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
                <form id="form_news_category" novalidate onsubmit="return save_data();">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">News Category Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="news_category_name"
                                    name="news_category_name" placeholder="Insert level name" required>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="id_news_category_form" name="id_news_category">

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
                    <h5 class="modal-title" id="modalCenterTitle">Delete News Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure want to delete
                    <strong id="news_category_name_delete" class="text-danger"></strong> ?
                </div>

                <input type="hidden" id="id_news_category_delete">

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
    function show_modal(id = '', name = '') {
        $('#form_news_category')[0].reset();

        $('#id_news_category_form').val(id);
        $('#news_category_name').val(name);

        $('#modalCenterTitle').text(id ? 'Edit News Category' : 'Add News Category');

        $('#modal_add').modal('show');
    }

    function save_data() {
        let form = document.getElementById('form_news_category');

        if (!form.checkValidity()) {
            form.reportValidity();
            return false;
        }

        $.ajax({
            url: "{{ route('news-category.store') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id_news_category: $('#id_news_category_form').val(),
                news_category_name: $('#news_category_name').val()
            },
            success: function(res) {
                if (res.status) location.reload();
            }
        });

        return false;
    }

    function show_modal_delete(id, name) {
        $('#id_news_category_delete').val(id);
        $('#news_category_name_delete').text(name);
        $('#model_delete').modal('show');
    }

    function delete_data() {
        $.ajax({
            url: "{{ route('news-category.delete') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id_news_category: $('#id_news_category_delete').val()
            },
            success: function(res) {
                if (res.status) location.reload();
            }
        });
    }
</script>


</html>
