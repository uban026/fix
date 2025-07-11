@extends('layouts.layouts-landing')

@section('title', 'Service')
@section('service', 'active')
@section('link_css')
    <style>
        .service-bg {
            background-image: url('/assets/img/service/background.png');
            background-size: cover;
            background-position: center;
            background-blend-mode: darken;
            background-color: rgba(255, 255, 255, 0.5);
        }
    </style>
@endsection
@section('content')

    <section class="py-32 service-bg from-yellow-100 to-white" data-aos="fade-in">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row items-center justify-between">
            <div class="mb-8 lg:mb-0" data-aos="fade-right" data-aos-delay="200">
                <h1 class="text-4xl sm:text-5xl font-bold leading-tight mb-4">Spesialis Percetakan Bertema Pop Culture</h1>
                <p class="text-lg sm:text-xl mb-6 text-gray-700">Kami hadir untuk para pecinta anime, J-Pop, K-Pop, K-Drama,
                    dan budaya populer lainnya! Cetak produk favoritmu atau custom desain impianmu sekarang juga.</p>
                <a href="https://wa.me/6281281856266" target="_blank"
                    class="inline-block px-6 py-3 bg-yellow-500 text-white font-semibold rounded hover:bg-yellow-600 transition btn-hover-animation">
                    Konsultasi & Custom Sekarang
                </a>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-aos="fade-down">
                <h2 class="text-3xl font-bold">Layanan Spesial Kami</h2>
                <p class="mt-2 text-gray-600">Berikut adalah produk unggulan bertema Pop Culture dan Custom Design</p>
            </div>

            <div data-aos="fade-up"
                class="flex flex-col md:flex-row items-center gap-6 mb-10 bg-gray-50 p-6 rounded-lg shadow hover:shadow-md transition card-hover-animation">
                <div class="md:w-1/2">
                    <h3 class="font-semibold text-yellow-700 text-lg mb-2">Kaos Anime dan K-pop</h3>
                    <p class="text-sm text-gray-600">Cetak kaos eksklusif bertema anime favoritmu, mulai dari karakter
                        klasik hingga trending!</p>
                </div>
                <div class="md:w-1/2 text-center">
                    <img src="{{ asset('assets/img/kaos_anime.jpg') }}" class="w-48 h-auto mx-auto" alt="Anime Shirt">
                </div>
            </div>

            <div data-aos="fade-up" data-aos-delay="100"
                class="flex flex-col md:flex-row-reverse items-center gap-6 mb-10 bg-gray-50 p-6 rounded-lg shadow hover:shadow-md transition card-hover-animation">
                <div class="md:w-1/2">
                    <h3 class="font-semibold text-yellow-700 text-lg mb-2">Lanyard Anime dan K-Pop</h3>
                    <p class="text-sm text-gray-600">Lanyard idolamu dengan desain unik, cocok untuk acara konser,
                        komunitas, atau koleksi pribadi.</p>
                </div>
                <div class="md:w-1/2 text-center">
                    <img src="{{ asset('assets/img/lanyard_kpop.jpg') }}" class="w-48 h-auto mx-auto" alt="Kpop Lanyard">
                </div>
            </div>

            <div data-aos="fade-up" data-aos-delay="200"
                class="flex flex-col md:flex-row items-center gap-6 mb-10 bg-gray-50 p-6 rounded-lg shadow hover:shadow-md transition card-hover-animation">
                <div class="md:w-1/2">
                    <h3 class="font-semibold text-yellow-700 text-lg mb-2">ID Card K-Drama</h3>
                    <p class="text-sm text-gray-600">ID Card eksklusif untuk fans K-Drama, bisa untuk komunitas, fan
                        meeting, atau souvenir.</p>
                </div>
                <div class="md:w-1/2 text-center">
                    <img src="{{ asset('assets/img/id_card.jpg') }}" class="w-48 h-auto mx-auto" alt="ID Card K-Drama">
                </div>
            </div>

            <div data-aos="fade-up" data-aos-delay="300"
                class="flex flex-col md:flex-row-reverse items-center gap-6 mb-10 bg-gray-50 p-6 rounded-lg shadow hover:shadow-md transition card-hover-animation">
                <div class="md:w-1/2">
                    <h3 class="font-semibold text-yellow-700 text-lg mb-2">Custom Design</h3>
                    <p class="text-sm text-gray-600">Punya desain sendiri? Serahkan pada kami! Kami siap mencetak sesuai
                        keinginanmu dengan kualitas terbaik.</p>
                </div>
                <div class="md:w-1/2 text-center">
                    <img src="{{ asset('assets/img/custom.png') }}" class="w-48 h-auto mx-auto" alt="ID Card K-Drama">
                </div>
            </div>

            <div data-aos="fade-up" data-aos-delay="400"
                class="flex flex-col md:flex-row items-center gap-6 mb-10 bg-gray-50 p-6 rounded-lg shadow hover:shadow-md transition card-hover-animation">
                <div class="md:w-1/2">
                    <h3 class="font-semibold text-yellow-700 text-lg mb-2">Pemesanan Grup</h3>
                    <p class="text-sm text-gray-600">Cocok untuk komunitas, event cosplay, fanbase, atau acara kampus.
                        Dapatkan harga spesial!</p>
                </div>
                <div class="md:w-1/2 text-center">
                    <img src="{{ asset('assets/img/group.jpg') }}" class="w-48 h-auto mx-auto" alt="Group Order">
                </div>
            </div>

            <div data-aos="fade-up" data-aos-delay="500"
                class="flex flex-col md:flex-row-reverse items-center gap-6 mb-10 bg-gray-50 p-6 rounded-lg shadow hover:shadow-md transition card-hover-animation">
                <div class="md:w-1/2">
                    <h3 class="font-semibold text-yellow-700 text-lg mb-2">Merchandise Pop Culture</h3>
                    <p class="text-sm text-gray-600">Pin, sticker, tote bag, mug, dan banyak lagi! Semuanya bertema anime,
                        K-Pop, J-Pop, dan lainnya.</p>
                </div>
                <div class="md:w-1/2 text-center">
                    <img src="{{ asset('assets/img/merchandise.jpg') }}" class="w-48 h-auto mx-auto" alt="ID Card K-Drama">
                </div>
            </div>
        </div>
    </section>


    <section class="bg-yellow-500 py-16 text-white text-center" data-aos="zoom-in">
        <h2 class="text-3xl font-bold mb-4">Wujudkan Desainmu Hari Ini!</h2>
        <p class="mb-6 text-lg">Percayakan kebutuhan cetakmu pada kami, dan ekspresikan dirimu lewat produk yang unik dan
            berkualitas.</p>
        <a href="https://wa.me/6281281856266" target="_blank"
            class="inline-block px-6 py-3 bg-white text-yellow-600 font-semibold rounded hover:bg-yellow-100 transition btn-hover-animation">Hubungi
            Kami</a>
    </section>

@endsection
