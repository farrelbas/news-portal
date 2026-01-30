<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Newsers</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    @include('Public.Template.head')
    <style>
        .latest-news-carousel .owl-stage {
            display: flex;
        }

        .latest-news-carousel .owl-item {
            display: flex;
            height: auto;
        }

        .latest-news-carousel .latest-news-item {
            display: flex;
            flex: 1;
        }
    </style>
</head>

<body>
    @include('Public.Template.navbar')

    <div class="container-fluid features mb-3">
        <div class="container py-5">
            <div class="row g-4">
                @foreach ($categories as $category)
                    @php
                        $news = $category->news->first();
                    @endphp

                    @if ($news)
                        <div class="col-md-6 col-lg-6 col-xl-3">
                            <div class="row g-4 align-items-center features-item">
                                <div class="col-4">
                                    <div class="rounded-circle position-relative">
                                        <div class="overflow-hidden rounded-circle ratio ratio-1x1">
                                            <img src="{{ asset('news_picture/' . $news->news_picture) }}"
                                                class="img-zoomin img-fluid w-100 h-100 object-fit-cover"
                                                alt="{{ $news->news_title }}">
                                        </div>

                                        <span
                                            class="rounded-circle border border-2 border-white bg-primary btn-sm-square text-white position-absolute"
                                            style="top: 10%; right: -10px;">
                                            {{ $news->news_views ?? 0 }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-8">
                                    <div class="features-content d-flex flex-column">
                                        <p class="text-uppercase mb-2">
                                            {{ $category->news_category_name }}
                                        </p>

                                        <a href="{{ url('news/' . $news->id_news) }}" class="h6">
                                            {{ Str::limit($news->news_title, 50) }}
                                        </a>

                                        <small class="text-body d-block">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ \Carbon\Carbon::parse($news->news_inserted_at)->translatedFormat('d F Y') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="container-fluid latest-news">
        <div class="container py-5">
            <h2 class="mb-4">Latest News</h2>
            <div class="latest-news-carousel owl-carousel">
                @foreach ($latest_news as $news)
                    <div class="latest-news-item h-100" style="height: 100% ! important">
                        <div class="bg-light rounded h-100 d-flex flex-column">
                            <div class="rounded-top overflow-hidden ratio ratio-16x9">
                                <img src="{{ asset('news_picture/' . $news->news_picture) }}"
                                    class="img-fluid w-100 h-100 object-fit-cover img-zoomin"
                                    alt="{{ strip_tags($news->news_title) }}">
                            </div>

                            <div class="latest-news-content d-flex flex-column p-4">
                                <a href="{{ url('news/' . $news->id_news) }}" class="h4 news-title">
                                    {{ Str::limit(strip_tags($news->news_title)) }}
                                </a>

                                <div class="mt-auto d-flex justify-content-between">
                                    <span class="small text-body">
                                        {{ $news->category->news_category_name ?? '-' }}
                                    </span>

                                    <small class="text-body">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        {{ \Carbon\Carbon::parse($news->news_inserted_at)->translatedFormat('d M Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="container-fluid populer-news">
        <div class="container py-5">
            <div class="tab-class mb-4">
                <div class="d-flex flex-column flex-md-row justify-content-md-between border-bottom mb-4">
                    <h1 class="mb-4">What's New</h1>
                    <ul class="nav nav-pills d-inline-flex text-center">
                        @foreach ($categories as $index => $category)
                            <li class="nav-item mb-3">
                                <a class="d-flex py-2 bg-light rounded-pill me-2 {{ $index == 0 ? 'active' : '' }}"
                                    data-bs-toggle="pill" href="#tab-{{ $category->id_news_category }}">
                                    <span class="text-dark" style="width: 100px;">
                                        {{ $category->news_category_name }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="tab-content mb-4">
                    @foreach ($categories as $index => $category)
                        @php
                            $newsList = $category->news ?? collect();
                            $mainNews = $newsList->first();
                            $sideNews = $newsList->skip(1)->take(7);
                        @endphp

                        @if ($mainNews)
                            <div id="tab-{{ $category->id_news_category }}"
                                class="tab-pane fade p-0 {{ $index == 0 ? 'show active' : '' }}">
                                <div class="row g-4 align-items-stretch">
                                    <div class="col-lg-8 d-flex">
                                        <div class="w-100 d-flex flex-column">
                                            <div class="position-relative rounded overflow-hidden ratio ratio-16x9">
                                                <img src="{{ asset('news_picture/' . $mainNews->news_picture) }}"
                                                    class="img-zoomin img-fluid w-100 h-100 object-fit-cover"
                                                    alt="{{ strip_tags($mainNews->news_title) }}">
                                            </div>

                                            <div class="my-3">
                                                <a href="{{ url('news/' . $mainNews->id_news) }}" class="h4">
                                                    {{ strip_tags($mainNews->news_title) }}
                                                </a>
                                            </div>

                                            <p class="text-body">
                                                {{ Str::limit(strip_tags($mainNews->news_description), 200) }}
                                            </p>

                                            <div class="d-flex justify-content-start">
                                                <p class="text-dark link-hover me-3">
                                                    <i class="fa fa-tag"></i>
                                                    {{ $category->news_category_name }}
                                                </p>
                                                <p class="text-dark link-hover me-3">
                                                    <i class="fa fa-eye"></i>
                                                    {{ $mainNews->news_views }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 d-flex">
                                        <div class="row g-4 w-100">
                                            @foreach ($sideNews as $news)
                                                <div class="col-12">
                                                    <div class="row g-3 align-items-center">
                                                        <div class="col-5">
                                                            <div class="overflow-hidden rounded ratio ratio-16x9">
                                                                <img src="{{ asset('news_picture/' . $news->news_picture) }}"
                                                                    class="img-zoomin img-fluid w-100 h-100 object-fit-cover"
                                                                    alt="{{ strip_tags($news->news_title) }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-7">
                                                            <div class="features-content d-flex flex-column h-100">
                                                                <p class="text-uppercase mb-1 small">
                                                                    {{ $category->news_category_name }}
                                                                </p>

                                                                <a href="{{ url('news/' . $news->id_news) }}"
                                                                    class="h6 mb-1">
                                                                    {{ Str::limit(strip_tags($news->news_title), 60) }}
                                                                </a>

                                                                <small class="text-body mt-auto">
                                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                                    {{ \Carbon\Carbon::parse($news->news_inserted_at)->translatedFormat('d M Y') }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
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
