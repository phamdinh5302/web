@extends('layout')
@section('content')
    <div class="row container" id="wrapper">
        <div class="halim-panel-filter">
            <div id="ajax-filter" class="panel-collapse collapse" aria-expanded="true" role="menu">
                <div class="ajax"></div>
            </div>
        </div>
        {{-- <div class="col-xs-12 carausel-sliderWidget">
            <section id="halim-advanced-widget-4">
                <div class="section-heading">
                    <a href="danhmuc.php" title="Phim Chiếu Rạp">
                        <span class="h-text">Phim Chiếu Rạp</span>
                    </a>
                    <ul class="heading-nav pull-right hidden-xs">
                        <li class="section-btn halim_ajax_get_post" data-catid="4" data-showpost="12"
                            data-widgetid="halim-advanced-widget-4" data-layout="6col"><span data-text="Chiếu Rạp"></span>
                        </li>
                    </ul>
                </div>
                <div id="halim-advanced-widget-4-ajax-box" class="halim_box">
                    <article class="col-md-2 col-sm-4 col-xs-6 thumb grid-item post-38424">
                        <div class="halim-item">
                            <a class="halim-thumb" href="{{ route('movie') }}" title="GÓA PHỤ ĐEN">
                                <figure><img class="lazy img-responsive"
                                        src="https://lumiere-a.akamaihd.net/v1/images/p_blackwidow_disneyplus_21043-1_63f71aa0.jpeg"
                                        alt="GÓA PHỤ ĐEN" title="GÓA PHỤ ĐEN"></figure>
                                <span class="status">HD</span><span class="episode"><i class="fa fa-play"
                                        aria-hidden="true"></i>Vietsub</span>
                                <div class="icon_overlay"></div>
                                <div class="halim-post-title-box">
                                    <div class="halim-post-title ">
                                        <p class="entry-title">GÓA PHỤ ĐEN</p>
                                        <p class="original_title">Black Widow</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </article>

                </div>
            </section>
            <div class="clearfix"></div>
        </div> --}}
        <div id="halim_related_movies-2xx" class="wrap-slider">
            <div class="section-bar clearfix">
                <h3 class="section-title"><span>PHIM HOT</span></h3>
            </div>
            <div id="halim_related_movies-2" class="owl-carousel owl-theme related-film">

                @foreach ($phimhot as $key => $hot)
                    <article class="thumb grid-item post-38498">
                        <div class="halim-item">
                            <a class="halim-thumb" href="{{ route('movie', $hot->slug) }}" title="{{ $hot->title }}">
                                <figure><img class="lazy img-responsive" src="{{ asset('uploads/movie/' . $hot->image) }}"
                                        alt="anh" title="{{ $hot->title }}">
                                </figure>
                                <span class="status">
                                    @switch($hot->resolution)
                                        @case(0)
                                            HD
                                            @break
                                        @case(1)
                                            SD
                                            @break
                                        @case(2)
                                            HDCam
                                            @break
                                        @case(3)
                                            Cam
                                            @break
                                        @case(4)
                                            FulHD
                                            @break
                                        @default
                                    @endswitch
                                </span>
                                <span class="episode"><i class="fa fa-play"aria-hidden="true"></i>
                                    {{-- {{$hot->episode_count}}/{{$hot->sotap}}|  --}}
                                    @if ($hot->subtitle==0)
                                        Vietsub
                                    @elseif($hot->subtitle==1)
                                        Thuyết minh
                                    @else
                                        Trailer
                                    @endif
                                    @if ($hot->season!=0)
                                        Season {{ $hot->season }}
                                    @endif
                                </span>
                                <div class="icon_overlay"></div>
                                <div class="halim-post-title-box" >
                                    <div class="halim-post-title ">
                                        <p class="entry-title">{{ $hot->title }}</p>
                                        <p class="original_title">{{ $hot->name_eng }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </article>
                @endforeach

            </div>
            <script>
                $(document).ready(function($) {
                    var owl = $('#halim_related_movies-2');
                    owl.owlCarousel({
                        loop: true,
                        margin: 5,
                        autoplay: true,
                        autoplayTimeout: 3000,
                        autoplayHoverPause: true,
                        nav: true,
                        navText: ['<i class="fa fa-angle-double-left" style="font-size:24px"></i>',
                            '<i class="fa fa-angle-double-right" style="font-size:24px"></i>'
                        ],
                        responsiveClass: true,
                        responsive: {
                            0: {
                                items: 2
                            },
                            480: {
                                items: 3
                            },
                            600: {
                                items: 4
                            },
                            1000: {
                                items: 6
                            }
                        }
                    })
                });
            </script>
        </div>
        <main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
            @foreach ($category_home as $key => $cate_home)
                <section id="halim-advanced-widget-2">
                    <div class="section-heading">
                        <a href="" title="{{ $cate_home->title }}">
                            <span class="h-text">{{ $cate_home->title }}</span>
                        </a>
                    </div>
                    <div id="halim-advanced-widget-2-ajax-box" class="halim_box">
                        @foreach ($cate_home->movie->take(12) as $key => $mov)
                            <article class="col-md-3 col-sm-3 col-xs-6 thumb grid-item post-37606 " style="padding: 5px 5px">
                                <div class="halim-item ">
                                    <a class="halim-thumb" href="{{ route('movie', $mov->slug) }}" title="{{ $mov->title }}">
                                        <figure><img class="lazy img-responsive "
                                                src="{{ asset('uploads/movie/' . $mov->image) }}" alt="{{ $mov->title }}"
                                                title="{{ $mov->title }}">
                                        </figure>
                                        <span class="status">
                                            @switch($mov->resolution)
                                                @case(0)
                                                    HD
                                                    @break
                                                @case(1)
                                                    SD
                                                    @break
                                                @case(2)
                                                    HDCam
                                                    @break
                                                @case(3)
                                                    Cam
                                                    @break
                                                @case(4)
                                                    FulHD
                                                    @break
                                                @default
                                            @endswitch
                                        </span>
                                        <span class="episode"><i class="fa fa-play"aria-hidden="true"></i>
                                            {{$mov->episode_count}}/{{$mov->sotap}}| 
                                            @if ($mov->subtitle==0)
                                                Vietsub
                                            @elseif($mov->subtitle==1)
                                                Thuyết minh
                                            @else
                                                Trailer
                                            @endif
                                        </span>
                                        <div class="icon_overlay"></div>
                                        <div class="halim-post-title-box">
                                            <div class="halim-post-title ">
                                                <p class="entry-title">{{ $mov->title }}</p>
                                                <p class="original_title">{{ $mov->name_eng }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
                <div class="clearfix"></div>
            @endforeach

        </main>
        {{-- sidebar --}}
        @include('pages.include.sidebar')
    </div>
@endsection
