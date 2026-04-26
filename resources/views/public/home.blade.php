@extends('layouts.public')

@section('title', 'Portal Karya Seniman Sumbawa Besar')

@push('styles')
<style>
    .carousel-item {
        height: 470px;
    }

    @media (max-width: 767px) {
        .carousel-item {
            height: 250px;
        }
    }

    .carousel-caption {
        background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
        left: 0;
        right: 0;
        bottom: 0;
        padding: 40px 30px 30px;
    }

    .carousel-caption h2 {
        font-size: 28px;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
    }

    @media (max-width: 767px) {
        .carousel-caption h2 {
            font-size: 18px;
        }
    }

    .carousel-indicators [data-bs-target] {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: rgba(255,255,255,0.5);
    }

    .carousel-indicators .active {
        background-color: #fff;
    }
</style>
@endpush

@section('content')
    <!-- Carousel -->
    <div id="mainCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
        @php
            $slideCount = $sliders->count() > 0 ? $sliders->count() : 5;
        @endphp

        @if($slideCount > 1)
        <div class="carousel-indicators">
            @for($i = 0; $i < $slideCount; $i++)
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="{{ $i }}" class="{{ $i == 0 ? 'active' : '' }}" aria-current="{{ $i == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $i + 1 }}"></button>
            @endfor
        </div>
        @endif

        <div class="carousel-inner rounded" style="overflow: hidden;">
            @if($sliders->count() > 0)
                @foreach($sliders as $index => $slider)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <img src="{{ asset('storage/'.$slider->gambar) }}" class="d-block w-100 h-100 object-fit-cover" alt="{{ $slider->judul }}">
                    <div class="carousel-caption d-none d-md-block text-start">
                        <h2 class="fw-bold font-display">{{ $slider->judul }}</h2>
                        @if($slider->subjudul)
                        <p>{{ $slider->subjudul }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            @else
                <!-- Default Slides -->
                <div class="carousel-item active">
                    <img src="{{ asset('istana-dalam-loka.jpg') }}" class="d-block w-100 h-100 object-fit-cover" alt="Istana Dalam Loka">
                    <div class="carousel-caption d-none d-md-block text-start">
                        <h2 class="fw-bold font-display">Istana Dalam Loka</h2>
                        <p>Objek Wisata "Simbol Kebudayaan Sumbawa"</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://images.unsplash.com/photo-1596402184320-417e02b5d485?w=1200" class="d-block w-100 h-100 object-fit-cover" alt="Pangkenang">
                    <div class="carousel-caption d-none d-md-block text-start">
                        <h2 class="fw-bold font-display">Pangkenang Lonas Panempu</h2>
                        <p>Pakaian yang digunakan Oleh Remaja</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://images.unsplash.com/photo-1565557623262-b51c2513a641?w=1200" class="d-block w-100 h-100 object-fit-cover" alt="Sepat">
                    <div class="carousel-caption d-none d-md-block text-start">
                        <h2 class="fw-bold font-display">Sepat</h2>
                        <p>Makanan Khas Tradisional Tana Samawa</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://images.unsplash.com/photo-1587595431973-160d0d94add1?w=1200" class="d-block w-100 h-100 object-fit-cover" alt="Bala Kuning">
                    <div class="carousel-caption d-none d-md-block text-start">
                        <h2 class="fw-bold font-display">Bala Kuning</h2>
                        <p>Objek Wisata Kebudayaan Sumbawa</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://images.unsplash.com/photo-1518495973542-4542c0a2417a?w=1200" class="d-block w-100 h-100 object-fit-cover" alt="Biso Tian">
                    <div class="carousel-caption d-none d-md-block text-start">
                        <h2 class="fw-bold font-display">Biso Tian</h2>
                        <p>Adat Masa Kehamilan di Tana Samawa</p>
                    </div>
                </div>
            @endif
        </div>

        @if($slideCount > 1)
        <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        @endif
    </div>
@endsection
