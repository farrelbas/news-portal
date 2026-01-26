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
                                        <form method="GET" action="{{ route('news') }}">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="search"
                                                    value="{{ request('search') }}" placeholder="Search news">

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
                                                    Title
                                                </th>
                                                <th>
                                                    Description
                                                </th>
                                                <th>
                                                    Category
                                                </th>
                                                <th>
                                                    Picture
                                                </th>
                                                <th>
                                                    Date
                                                </th>
                                                <th>
                                                    Available
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
                                            @forelse ($data_news as $key => $row)
                                                <tr>
                                                    <td>{{ $data_news->firstItem() + $key }}</td>
                                                    <td>{{ Str::limit(strip_tags($row->news_title), 50) }}</td>
                                                    <td>{{ Str::limit(strip_tags($row->news_description), 50) }}</td>
                                                    <td>{{ $row->news_category_name }}</td>
                                                    <td>
                                                        @if ($row->news_picture)
                                                            <img src="{{ asset('news_picture/' . $row->news_picture) }}"
                                                                width="60">
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ date('d M Y', strtotime($row->news_start_date)) }}
                                                        -
                                                        {{ date('d M Y', strtotime($row->news_end_date)) }}
                                                    </td>

                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $row->news_public ? 'success' : 'danger' }}">
                                                            {{ $row->news_public ? 'Yes' : 'No' }}
                                                        </span>
                                                    </td>
                                                    <td>{{ date('d F Y H:i', strtotime($row->news_last_updated)) }}
                                                    </td>
                                                    <td>{{ $row->user_fullname }}</td>
                                                    <td class="text-nowrap">
                                                        <button class="btn btn-sm rounded-pill btn-icon btn-warning"
                                                            onclick='show_modal(@json($row))'>
                                                            <i class="bx bx-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm rounded-pill btn-icon btn-danger ms-2"
                                                            onclick='show_modal_delete(@json($row))'>
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="10" class="text-center">Data not found</td>
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
                                        {!! $data_news->firstItem() !!} to
                                        {!! $data_news->lastItem() !!} of {!! $data_news->total() !!} entries
                                    </div>
                                    <div class="col-md-6 d-flex flex-column align-items-md-end" id="showing_page">
                                        {!! $data_news->appends(request()->all())->links() !!}
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
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <form id="form_news" onsubmit="return save_data();" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id_news" name="id_news">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <!-- CATEGORY -->
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Category</label>
                            <div class="col-sm-9">
                                <select id="id_news_category" name="id_news_category" class="form-control" required>
                                    <option value="">-- Choose Category --</option>
                                    @foreach ($news_category as $cat)
                                        <option value="{{ $cat->id_news_category }}">
                                            {{ $cat->news_category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- TITLE -->
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">News Title</label>
                            <div class="col-sm-9">
                                <textarea id="news_title" name="news_title" required></textarea>
                            </div>
                        </div>

                        <!-- DESCRIPTION -->
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">News Description</label>
                            <div class="col-sm-9">
                                <textarea id="news_description" name="news_description" required></textarea>
                            </div>
                        </div>

                        <!-- PICTURE -->
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">News Picture</label>
                            <div class="col-sm-9">

                                <!-- PREVIEW -->
                                <div class="mb-2">
                                    <img id="preview_news_picture" src="" class="img-thumbnail"
                                        style="max-height:150px; display:none;">
                                </div>

                                <input type="file" class="form-control" name="news_picture" id="news_picture"
                                    accept="image/*">
                            </div>
                        </div>

                        <!-- START DATE -->
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Start Date</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" name="news_start_date" required>
                            </div>
                        </div>

                        <!-- END DATE -->
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">End Date</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" name="news_end_date" required>
                            </div>
                        </div>

                        <!-- PUBLISH -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="news_public" name="news_public"
                                    value="1" checked>
                                <label class="form-check-label">
                                    Publish
                                </label>
                            </div>
                        </div>
                    </div>

                    <div id="form_alert" class="alert alert-danger d-none" role="alert"></div>

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
                    <h5 class="modal-title" id="modalCenterTitle">Delete News</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <input type="hidden" id="id_news_delete">

                <div class="modal-body">
                    Are you sure want to delete
                    <strong id="news_title_delete" class="text-danger"></strong> ?
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

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    function initEditor() {

        if (CKEDITOR.instances.news_title) {
            CKEDITOR.instances.news_title.destroy(true);
        }
        if (CKEDITOR.instances.news_description) {
            CKEDITOR.instances.news_description.destroy(true);
        }

        CKEDITOR.replace('news_title');
        CKEDITOR.replace('news_description');
    }

    $('#news_picture').on('change', function() {
        let file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#preview_news_picture')
                    .attr('src', e.target.result)
                    .show();
            };
            reader.readAsDataURL(file);
        }
    });

    function show_modal(data = null) {

        $('#form_news')[0].reset();
        $('#id_news').val('');
        $('#preview_news_picture').hide().attr('src', '');
        $('#form_alert').addClass('d-none').html('');

        $('#news_picture').prop('required', true);

        $('#news_public').prop('checked', true);
        $('#modalCenterTitle').text(data ? 'Edit News' : 'Add News');

        $('#modal_add').modal('show');

        $('#modal_add').one('shown.bs.modal', function() {

            if ($('#id_news_category').hasClass('select2-hidden-accessible')) {
                $('#id_news_category').select2('destroy');
            }

            $('#id_news_category').select2({
                dropdownParent: $('#modal_add'),
                width: '100%',
                placeholder: 'Choose category',
                allowClear: true
            });

            $('#id_news_category').val('').trigger('change');

            initEditor();

            if (data) {
                $('#id_news').val(data.id_news);

                $('#news_picture').prop('required', false);

                setTimeout(() => {
                    CKEDITOR.instances.news_title.setData(data.news_title || '');
                    CKEDITOR.instances.news_description.setData(data.news_description || '');
                }, 100);

                $('input[name="news_start_date"]').val(data.news_start_date);
                $('input[name="news_end_date"]').val(data.news_end_date);

                $('#id_news_category')
                    .val(data.id_news_category)
                    .trigger('change');

                $('#news_public').prop('checked', data.news_public == 1);

                if (data.news_picture) {
                    $('#preview_news_picture')
                        .attr('src', "{{ asset('news_picture') }}/" + data.news_picture)
                        .show();
                }
            }
        });
    }

    function validateForm() {

        let errors = [];
        let title = CKEDITOR.instances.news_title.getData().trim();
        let desc = CKEDITOR.instances.news_description.getData().trim();

        if (title == '') {
            errors.push('News Title is required.');
        }

        if (desc === '') {
            errors.push('News Description is required.');
        }

        if (errors.length > 0) {
            $('#form_alert')
                .removeClass('d-none')
                .html(errors.join('<br>'));
            return false;
        }

        $('#form_alert').addClass('d-none').html('');
        return true;
    }

    function save_data() {

        if (!validateForm()) {
            return false;
        }

        let formData = new FormData(document.getElementById('form_news'));

        formData.set('news_title', CKEDITOR.instances.news_title.getData());
        formData.set('news_description', CKEDITOR.instances.news_description.getData());
        formData.set('news_public', $('#news_public').is(':checked') ? 1 : 0);

        $.ajax({
            url: "{{ route('news.store') }}",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                if (res.status) {
                    location.reload();
                }
            }
        });

        return false;
    }

    function stripHtml(html) {
        if (!html) return '';
        return html.replace(/<[^>]*>?/gm, '').trim();
    }

    function show_modal_delete(data = null) {
        let cleanTitle = stripHtml(data.news_title);

        $('#id_news_delete').val(data.id_news);
        $('#news_title_delete').text(cleanTitle);

        $('#model_delete').modal('show');
    }

    function delete_data() {
        $.ajax({
            url: "{{ route('news.delete') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id_news: $('#id_news_delete').val()
            },
            success: function(res) {
                if (res.status) location.reload();
            }
        });
    }
</script>

</html>
