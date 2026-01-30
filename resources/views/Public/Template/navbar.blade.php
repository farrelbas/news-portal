<div id="spinner"
    class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
    <div class="spinner-grow text-primary" role="status"></div>
</div>

<div class="container-fluid sticky-top px-0">
    <div class="container-fluid bg-light">
        <div class="container px-0">
            <nav class="navbar navbar-light navbar-expand-xl">
                <a href="index.html" class="navbar-brand mt-3">
                    <p class="text-primary display-6 mb-2" style="line-height: 0;">Newsers</p>
                    <small class="text-body fw-normal" style="letter-spacing: 12px;">Newspaper</small>
                </a>
                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>
                <div class="collapse navbar-collapse bg-light py-3" id="navbarCollapse">
                    <div class="d-flex flex-nowrap border-top pt-3 pt-xl-0 ms-auto">
                        @if ($weather)
                            <img src="https://openweathermap.org/img/wn/{{ $weather['icon'] }}@2x.png"
                                class="img-fluid me-2" style="width:40px" alt="weather">

                            <div class="d-flex align-items-center">
                                <strong class="fs-4 text-secondary">
                                    {{ $weather['temp'] }}°C
                                </strong>
                                <div class="d-flex flex-column ms-2" style="width: 160px;">
                                    <span class="text-body">{{ $weather['city'] }}</span>
                                    <small>{{ $weather['date'] }}</small>
                                </div>
                            </div>
                        @endif

                        <a href="{{ route('login') }}">
                            <button class="btn border border-primary btn-md-square rounded-circle bg-white my-auto">
                                <i class="fas fa-user text-primary"></i>
                            </button>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
