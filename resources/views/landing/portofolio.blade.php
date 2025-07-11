@extends('layouts.layouts-landing')

@section('title', 'Portofolio')
@section('portofolio', 'active')

@section('content')

    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-aos="fade-down">
                <h2 class="text-3xl font-bold text-gray-800">Portofolio Kami</h2>
                <p class="mt-2 text-gray-600">Berikut adalah beberapa produk kami yang telah kami hasilkan dengan desain
                    unik.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @php
                    $portfolioItems = [
                        ['image' => 'assets/img/kaos_anime.jpg', 'title' => 'Kaos Anime'],
                        ['image' => 'assets/img/portofolio/lanyard_nct.jpg', 'title' => 'Lanyard NCT'],
                        ['image' => 'assets/img/portofolio/lanyard_nct_dream.jpg', 'title' => 'Lanyard NCT Dream'],
                        ['image' => 'assets/img/portofolio/Lanyard_ENHYPEN.jpg', 'title' => 'Lanyard Enhypen'],
                        ['image' => 'assets/img/portofolio/lanyard_bts.jpg', 'title' => 'Lanyard BTS'],
                        ['image' => 'assets/img/portofolio/kaos_yoasobi.jpg', 'title' => 'Kaos Yoasobi'],
                        ['image' => 'assets/img/portofolio/kaos_squid_game.jpg', 'title' => 'Kaos Squid Game'],
                        [
                            'image' => 'assets/img/portofolio/Kaos_reg_aespa_armageddon.jpg',
                            'title' => 'Kaos Reg Aespa Armageddon',
                        ],
                        [
                            'image' => 'assets/img/portofolio/kaos_kaki_kdrama_1988.jpg',
                            'title' => 'Kaos Kaki KDrama 1988',
                        ],
                        ['image' => 'assets/img/portofolio/kaos_jennie.jpg', 'title' => 'Kaos Jennie'],
                        ['image' => 'assets/img/portofolio/kaos_baby_monster.jpg', 'title' => 'Kaos Baby Monster'],
                        ['image' => 'assets/img/portofolio/crop_top_black_pink.jpg', 'title' => 'Crop Top Black Pink'],
                    ];
                @endphp

                @foreach ($portfolioItems as $index => $item)
                    <div data-aos="fade-up" data-aos-delay="{{ ($index % 4) * 100 }}">
                        <div class="relative group card-hover-animation overflow-hidden rounded-lg">
                            <img src="{{ asset($item['image']) }}" alt="{{ $item['title'] }}"
                                class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-110">
                            <div
                                class="absolute inset-0 bg-black opacity-0 group-hover:opacity-60 transition-opacity duration-300">
                            </div>
                            <div
                                class="absolute inset-0 flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <p class="text-lg text-yellow-400 font-semibold">{{ $item['title'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
