@extends('layouts.layouts-landing')

@section('title', 'About Us')
@section('about', 'active')

@section('content')
    <div class="bg-white py-12 sm:py-20" data-aos="fade-in">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="fade-down" data-aos-delay="200">
            <h1 class="text-3xl sm:text-5xl font-extrabold text-gray-900">Tentang <span
                    class="text-yellow-600">Herchitchat</span></h1>
            <p class="mt-4 text-gray-600 sm:text-lg max-w-2xl mx-auto">
                Kami adalah platform e-commerce yang menyediakan produk berkualitas tinggi dengan harga terjangkau dan
                pelayanan pelanggan terbaik.
            </p>
        </div>
    </div>

    <div class="bg-yellow-50 py-12" data-aos="fade-up">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div data-aos="fade-right" data-aos-delay="200">
                <img src="{{ asset('assets/img/about-design.png') }}" alt="Our Story"
                    class="rounded-lg shadow-lg w-full h-auto object-cover">
            </div>
            <div data-aos="fade-left" data-aos-delay="200">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">Cerita Kami</h2>
                <p class="text-gray-700 text-justify leading-relaxed">
                    Herchitchat didirikan dengan satu tujuan: membantu masyarakat menemukan produk terbaik tanpa harus
                    menguras dompet. Kami percaya bahwa belanja online harus menjadi pengalaman yang menyenangkan, mudah,
                    dan memuaskan.
                    <br><br>
                    Berawal dari tim kecil yang penuh semangat dan dedikasi, kini kami terus berkembang dengan menghadirkan
                    berbagai kategori produk, dari kebutuhan harian hingga barang eksklusif.
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white py-12" data-aos="fade-up">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-8">Nilai yang Kami Junjung</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="p-6 bg-gray-100 rounded-xl shadow-md card-hover-animation" data-aos="zoom-in"
                    data-aos-delay="100">
                    <h3 class="text-lg font-semibold text-yellow-700 mb-2">Kualitas</h3>
                    <p class="text-sm text-gray-700">Kami hanya menghadirkan produk yang telah melewati proses seleksi
                        ketat.</p>
                </div>
                <div class="p-6 bg-gray-100 rounded-xl shadow-md card-hover-animation" data-aos="zoom-in"
                    data-aos-delay="200">
                    <h3 class="text-lg font-semibold text-yellow-700 mb-2">Kepercayaan</h3>
                    <p class="text-sm text-gray-700">Kepercayaan pelanggan adalah prioritas utama kami dalam setiap
                        transaksi.</p>
                </div>
                <div class="p-6 bg-gray-100 rounded-xl shadow-md card-hover-animation" data-aos="zoom-in"
                    data-aos-delay="300">
                    <h3 class="text-lg font-semibold text-yellow-700 mb-2">Inovasi</h3>
                    <p class="text-sm text-gray-700">Kami terus berinovasi agar pengalaman belanja Anda makin mudah dan
                        menyenangkan.</p>
                </div>
                <div class="p-6 bg-gray-100 rounded-xl shadow-md card-hover-animation" data-aos="zoom-in"
                    data-aos-delay="400">
                    <h3 class="text-lg font-semibold text-yellow-700 mb-2">Layanan</h3>
                    <p class="text-sm text-gray-700">Tim kami siap membantu Anda dengan cepat, ramah, dan profesional.</p>
                </div>
            </div>
        </div>
    </div>


    <div class="bg-yellow-500 py-12 text-white text-center" data-aos="zoom-in">
        <h2 class="text-2xl sm:text-3xl font-bold mb-4">Gabung bersama kami dalam menciptakan pengalaman belanja yang luar
            biasa!</h2>
        <a href="{{ route('product') }}"
            class="inline-block mt-4 px-6 py-3 bg-white text-yellow-600 font-semibold rounded-lg shadow hover:bg-gray-100 transition-colors btn-hover-animation">
            Mulai Belanja Sekarang
        </a>
    </div>
@endsection
