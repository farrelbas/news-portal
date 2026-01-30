<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Newsers</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    @include('Public.Template.head')

</head>

<body>
    @include('Public.Template.navbar')

    <div class="container-fluid">
        <div class="container py-5">
            <ol class="breadcrumb justify-content-start mb-4">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.general') }}">Home</a>
                </li>
                <li class="breadcrumb-item active text-dark">
                    {{ $news->news_title }}
                </li>
            </ol>

            <div class="mb-4">
                <h1 class="display-5">
                    {{ strip_tags($news->news_title) }}
                </h1>
            </div>

            <div class="position-relative rounded overflow-hidden mb-3">
                <img src="{{ asset('news_picture/' . $news->news_picture) }}" class="img-zoomin img-fluid rounded w-50"
                    alt="{{ strip_tags($news->news_title) }}">
            </div>

            <div class="d-flex flex-wrap mb-3">
                <span class="text-dark me-3">
                    <i class="fa fa-tag"></i> {{ $news->category->news_category_name }}
                </span>

                <span class="text-dark me-3">
                    <i class="fa fa-eye"></i> {{ $news->news_views }} views
                </span>

                <span class="text-dark">
                    <i class="fa fa-calendar-alt"></i>
                    {{ \Carbon\Carbon::parse($news->news_inserted_at)->translatedFormat('d F Y') }}
                </span>
            </div>

            <p class="my-4">
                {!! $news->news_description !!}
            </p>
        </div>
    </div>

    @include('Public.Template.copy-right')

    <a href="#" class="btn btn-primary border-2 border-white rounded-circle back-to-top"><i
            class="fa fa-arrow-up"></i></a>

</body>

@include('Public.Template.js')

</html>
