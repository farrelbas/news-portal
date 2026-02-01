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

    <div class="container-fluid py-5">
        <div class="container py-5">
            <ol class="breadcrumb justify-content-start mb-4">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.general') }}">Home</a>
                </li>
                <li class="breadcrumb-item active text-dark">
                    {{ strip_tags($news->news_title) }}
                </li>
            </ol>
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="mb-4">
                        <h1 class="display-5">
                            {{ strip_tags($news->news_title) }}
                        </h1>
                    </div>
                    <div class="position-relative rounded overflow-hidden mb-3">
                        <img src="{{ asset('news_picture/' . $news->news_picture) }}"
                            class="img-zoomin img-fluid rounded w-50" alt="{{ strip_tags($news->news_title) }}">
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
                <div class="col-lg-4">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="p-3 rounded border">
                                <h4 class="my-4">Related News</h4>
                                <div class="row g-4">

                                    @forelse ($related_news as $related)
                                        <div class="col-12">
                                            <div class="row g-4 align-items-center features-item">

                                                <div class="col-4">
                                                    <div class="rounded-circle position-relative">
                                                        <div class="overflow-hidden rounded-circle ratio ratio-1x1">
                                                            <img src="{{ asset('news_picture/' . $related->news_picture) }}"
                                                                class="img-zoomin img-fluid rounded-circle w-100 h-100 object-fit-cover"
                                                                alt="{{ strip_tags($related->news_title) }}">
                                                        </div>

                                                        <span
                                                            class="rounded-circle border border-2 border-white bg-primary btn-sm-square text-white position-absolute"
                                                            style="top: 10%; right: -10px;">
                                                            {{ $related->news_views }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="col-8">
                                                    <div class="features-content d-flex flex-column">

                                                        <p class="text-uppercase mb-2">
                                                            {{ $news->category->news_category_name }}
                                                        </p>

                                                        <a href="{{ url('news/' . $related->id_news) }}"
                                                            class="h6">
                                                            {{ Str::limit(strip_tags($related->news_title), 60) }}
                                                        </a>

                                                        <small class="text-body d-block">
                                                            <i class="fas fa-calendar-alt me-1"></i>
                                                            {{ \Carbon\Carbon::parse($related->news_inserted_at)->translatedFormat('d F Y') }}
                                                        </small>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    @empty
                                        <p class="text-muted">No related news</p>
                                    @endforelse

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('Public.Template.copy-right')

    <a href="#" class="btn btn-primary border-2 border-white rounded-circle back-to-top"><i
            class="fa fa-arrow-up"></i></a>

</body>

@include('Public.Template.js')

</html>
