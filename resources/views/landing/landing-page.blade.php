@extends('layouts.layouts-landing')

@section('title', 'Home')
@section('home', 'active')

@section('content')

    <section id="hero-section" class="hero-bg hero-bg-animation relative overflow-hidden bg-white animate-fadeIn">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row items-center justify-between">
            <div class="lg:w-1/2 mb-8 lg:mb-0 text-left lg:text-left" data-aos="fade-right">
                <h1 class="text-4xl sm:text-5xl font-bold leading-tight mb-4">Beli produk Pop Culture jadi ataupun Custom
                </h1>
                <p class="text-lg sm:text-xl mb-6">Kami melayani berbagai kebutuhan cetak Anda seperti kaos, lanyard
                    dll bertema anime, J-Pop, K-Pop, K-Drama, dan budaya populer dengan harga yang terjangkau, proses yang
                    cepat, dan kualitas yang bagus</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-start lg:justify-start">
                    <a href="{{ route('home') }}"
                        class="btn-hover-animation btn-breathing-animation inline-flex items-center justify-center px-6 py-3 bg-white text-yellow-500 border-2 border-yellow-10 font-semibold rounded hover:bg-yellow-50 transition">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Beli Produk
                    </a>
                    <a href="https://wa.me/6281281856266" target="_blank"
                        class="btn-hover-animation inline-flex items-center justify-center px-6 py-3 bg-yellow-500 text-white font-semibold rounded hover:bg-yellow-600 transition">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M20.52 3.48A11.93 11.93 0 0 0 2.04 21.04L.02 24l3.05-.99a11.94 11.94 0 0 0 17.45-19.53zM12 21a8.94 8.94 0 0 1-4.53-1.21l-.32-.2-2.7.87.9-2.63-.22-.33A8.93 8.93 0 1 1 21 12a8.93 8.93 0 0 1-9 9zm4.74-6.26c-.26-.13-1.54-.76-1.78-.84s-.41-.13-.58.13-.66.84-.81 1.01-.3.2-.56.07a7.15 7.15 0 0 1-2.11-1.3 7.87 7.87 0 0 1-1.45-1.81c-.15-.26 0-.4.11-.54.12-.12.26-.3.39-.45s.17-.26.26-.43a.53.53 0 0 0-.03-.51c-.08-.13-.58-1.39-.79-1.91s-.42-.43-.58-.44h-.49a.94.94 0 0 0-.69.32 2.87 2.87 0 0 0-.9 2.14 5 5 0 0 0 1.06 2.54c.15.2 2 3.09 4.87 4.34A10.59 10.59 0 0 0 17 17a2.95 2.95 0 0 0 .79-2.14c0-.32-.29-.46-.55-.59z" />
                        </svg>
                        Mau Custom Produk
                    </a>
                </div>
            </div>
            <div class="lg:w-1/2" data-aos="fade-left">
                <img src="{{ asset('assets/img/hero.png') }}" alt="Printing illustration" style="width: 516px;"
                    class="w-full h-auto">
            </div>
        </div>
    </section>

    <section class="py-16 bg-gray-50" data-aos="fade-up">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Kenapa Memilih Kami?</h2>
                <p class="mt-2 text-gray-600">Kami berkomitmen memberikan layanan terbaik untuk setiap pelanggan.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl shadow-md p-6 text-center transition hover:shadow-lg card-hover-animation"
                    data-aos="zoom-in" data-aos-delay="100">
                    <div
                        class="w-16 h-16 mx-auto mb-4 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center">
                        <img src="{{ asset('assets/icon/price.png') }}" width="32" alt="">
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-800">Harga Murah</h3>
                    <p class="text-gray-600 text-sm">Kami menawarkan harga yang sangat kompetitif tanpa mengorbankan
                        kualitas.</p>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6 text-center transition hover:shadow-lg card-hover-animation"
                    data-aos="zoom-in" data-aos-delay="200">
                    <div
                        class="w-16 h-16 mx-auto mb-4 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center">
                        <img src="{{ asset('assets/icon/quality.png') }}" width="32" alt="">
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-800">Berkualitas</h3>
                    <p class="text-gray-600 text-sm">Kami menggunakan bahan dan proses terbaik untuk hasil cetak yang tajam
                        dan tahan lama.</p>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6 text-center transition hover:shadow-lg card-hover-animation"
                    data-aos="zoom-in" data-aos-delay="300">
                    <div
                        class="w-16 h-16 mx-auto mb-4 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center">
                        <img src="{{ asset('assets/icon/fast.png') }}" width="32" alt="">
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-800">Proses Cepat</h3>
                    <p class="text-gray-600 text-sm">Khusus untuk custom design, kami menjamin proses cepat tanpa mengurangi
                        kualitas.</p>
                </div>
            </div>
        </div>
    </section>



    <section class="py-16 bg-gray-100" data-aos="fade-up">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold">Layanan Kami</h2>
                <p class="mt-2 text-gray-600">Berbagai jenis layanan percetakan untuk kebutuhan personal maupun bisnis</p>
            </div>
            <div class="flex justify-center">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                    <div class="bg-white rounded-lg shadow p-6 text-center card-hover-animation" data-aos="zoom-in"
                        data-aos-delay="100">
                        <img src="{{ asset('assets/img/kaos.png') }}" class="w-24 h-24 mx-auto mb-4" alt="Flyer">
                        <h3 class="font-semibold text-yellow-700 text-lg mb-2">Kaos</h3>
                        <p class="text-sm text-gray-600">Kaos individu, kegiatan, organisasi Anda dengan berbagai macam
                            bahan kain dan hasil cetak tajam.</p>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6 text-center card-hover-animation" data-aos="zoom-in"
                        data-aos-delay="200">
                        <img src="{{ asset('assets/img/lanyard.png') }}" class="w-24 h-24 mx-auto mb-4" alt="Invitation">
                        <h3 class="font-semibold text-yellow-700 text-lg mb-2">Lanyard</h3>
                        <p class="text-sm text-gray-600">Lanyard berbagai model dan ukuran untuk kegiatan anda dengan
                            kualitas premium dan hasil cetak yang tajam.</p>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6 text-center card-hover-animation" data-aos="zoom-in"
                        data-aos-delay="300">
                        <img src="{{ asset('assets/img/id_card.png') }}" class="w-24 h-24 mx-auto mb-4" alt="Banner">
                        <h3 class="font-semibold text-yellow-700 text-lg mb-2">ID Card</h3>
                        <p class="text-sm text-gray-600">Menyediakan berbagai model dan ukuran ID Card dengan kualitas
                            premium.</p>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6 text-center card-hover-animation" data-aos="zoom-in"
                        data-aos-delay="400">
                        <img src="{{ asset('assets/img/custom.png') }}" class="w-24 h-24 mx-auto mb-4" alt="Banner">
                        <h3 class="font-semibold text-yellow-700 text-lg mb-2">Custom</h3>
                        <p class="text-sm text-gray-600">Membuat dan mencetak berbagai kebutuhan seperti banner, pin,
                            spanduk, gelas, dan lainnya.</p>
                    </div>
                </div>
            </div>

        </div>
    </section>


    <section class="bg-yellow-500 py-12 text-white text-center" data-aos="fade-in">
        <h2 class="text-3xl font-bold mb-4">Siap Cetak Sekarang?</h2>
        <p class="mb-6 text-lg">Pesan produk cetak dengan mudah dan cepat, langsung dari rumah Anda.</p>
        <a href="{{ route('product') }}"
            class="inline-block px-6 py-3 bg-white text-yellow-500 font-semibold rounded hover:bg-yellow-100 transition btn-hover-animation">Lihat
            Semua Produk</a>
    </section>


@endsection
