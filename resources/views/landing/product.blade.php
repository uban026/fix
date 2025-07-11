@extends('layouts.layouts-landing')

@section('title', 'Produk')
@section('product', 'active')

@section('content')

    <div class="bg-gray-50 py-12 sm:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-aos="fade-down">
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Semua Produk</h1>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-500">Temukan item pop culture favoritmu di sini.</p>
            </div>

            <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                <aside class="lg:col-span-3 mb-8 lg:mb-0">
                    <div class="filter-section sticky top-24" data-aos="fade-right">
                        <h2 class="text-xl font-bold mb-6">Filter</h2>
                        <form action="{{ route('product') }}" method="GET" class="space-y-6">
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700">Cari Produk</label>
                                <div class="mt-1 relative">
                                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                                        placeholder="Nama produk..."
                                        class="w-full px-4 py-2 rounded-md border border-gray-300 focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500">
                                </div>
                            </div>

                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                                <select id="category" name="category"
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm rounded-md">
                                    <option value="">Semua Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="sort" class="block text-sm font-medium text-gray-700">Urutkan</label>
                                <select id="sort" name="sort"
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm rounded-md">
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru
                                    </option>
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga:
                                        Terendah</option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>
                                        Harga: Tertinggi</option>
                                </select>
                            </div>

                            <div>
                                <button type="submit"
                                    class="w-full py-3 px-4 bg-yellow-500 text-white font-bold rounded-lg hover:bg-yellow-600 transition-colors btn-hover-animation">
                                    Terapkan Filter
                                </button>
                            </div>
                        </form>
                    </div>
                </aside>

                <main class="lg:col-span-9">
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
                        @forelse ($products as $product)
                            <div class="product-card-v2 group" data-aos="fade-up"
                                data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                                <div class="product-image-wrapper">
                                    <a href="/detail/{{ $product->slug }}">
                                        <img src="{{ $product->getPrimaryImage() }}" alt="{{ $product->name }}"
                                            class="w-full h-72 object-cover">
                                        <div class="product-overlay">
                                            <span class="view-details-btn">Lihat Detail</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="p-4">
                                    <h3 class="text-lg font-bold text-gray-900 truncate">
                                        <a href="/detail/{{ $product->slug }}">{{ $product->name }}</a>
                                    </h3>
                                    <p class="text-sm text-gray-500 mt-1">{{ $product->category->name }}</p>
                                    <div class="mt-4 flex items-center justify-between">
                                        <p class="text-xl font-bold text-yellow-600">{{ $product->formatted_price }}</p>
                                        {{-- Tombol "tambah ke keranjang" dihilangkan --}}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12 bg-white rounded-lg shadow-md" data-aos="zoom-in">
                                <h3 class="text-2xl font-bold text-gray-900">Oops! Produk tidak ditemukan.</h3>
                                <p class="mt-2 text-gray-500">Coba ubah kata kunci pencarian atau filter Anda.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-10">
                        {{ $products->links() }}
                    </div>
                </main>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script type="module" src="{{ asset('js/app.js') }}"></script>
@endpush
