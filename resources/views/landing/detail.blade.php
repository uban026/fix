@extends('layouts.layouts-landing')

@section('title', $query->name)

@section('content')

    <main class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Menggunakan x-data dari Alpine.js untuk state management galeri gambar, kuantitas, dan ukuran terpilih --}}
            <div class="product-card" x-data="{
                mainImage: '{{ $query->getPrimaryImage() }}',
                quantity: 1,
                selectedSize: null
            }" data-id="{{ $query->id }}" data-name="{{ $query->name }}"
                data-price="{{ $query->price }}" data-image="{{ $query->getPrimaryImage() }}"
                data-category="{{ $query->category->name }}">

                <div class="flex flex-col lg:flex-row gap-8">
                    <div class="lg:w-1/2">
                        <div class="bg-white rounded-lg shadow-sm p-4">
                            <img :src="mainImage" alt="{{ $query->name }}"
                                class="w-full h-96 object-cover rounded-lg">
                        </div>
                        {{-- Thumbnails --}}
                        @if (is_array($query->image) && count($query->image) > 1)
                            <div class="flex space-x-2 mt-4">
                                @foreach ($query->getAllImages() as $image)
                                    <div class="w-20 h-20 flex-shrink-0">
                                        <img src="{{ $image }}" @click="mainImage = '{{ $image }}'"
                                            alt="Thumbnail"
                                            class="w-full h-full object-cover rounded-md cursor-pointer border-2 hover:border-yellow-500"
                                            :class="{ 'border-yellow-500': mainImage === '{{ $image }}' }">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="lg:w-1/2">
                        <div class="bg-white rounded-lg shadow-sm p-6 flex flex-col h-full">
                            <div>
                                <a href="#"
                                    class="text-sm font-medium text-yellow-600 hover:text-yellow-700">{{ $query->category->name }}</a>
                                <h1 class="text-3xl font-bold text-gray-900 mt-2">{{ $query->name }}</h1>

                                {{-- Status Stok --}}
                                <div class="mt-3">
                                    @if ($query->stock > 0)
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            In Stock
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                            Out of Stock
                                        </span>
                                    @endif
                                </div>

                                <p class="mt-4 text-3xl font-bold text-gray-900">{{ $query->formatted_price }}</p>

                                @if (!empty($query->sizes))
                                    <div class="mt-6">
                                        <h3 class="text-sm font-medium text-gray-900">Pilih Ukuran</h3>
                                        <fieldset class="mt-2">
                                            <div class="flex items-center space-x-3">
                                                @foreach ($query->sizes as $size)
                                                    <label @click="selectedSize = '{{ $size }}'"
                                                        :class="{ 'ring-2 ring-yellow-500 bg-yellow-50': selectedSize === '{{ $size }}' }"
                                                        class="border rounded-md py-2 px-4 flex items-center justify-center text-sm font-medium uppercase bg-white shadow-sm text-gray-900 cursor-pointer hover:bg-gray-50 focus:outline-none">
                                                        <input type="radio" name="size_option"
                                                            value="{{ $size }}" class="sr-only">
                                                        <span>{{ $size }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </fieldset>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-auto pt-6">
                                {{-- Pemilih Kuantitas --}}
                                <div class="mt-6">
                                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                                    <div class="mt-1 flex items-center">
                                        <button @click="quantity = Math.max(1, quantity - 1)"
                                            class="px-3 py-2 border rounded-l-md bg-gray-100 hover:bg-gray-200">-</button>
                                        <input type="number" x-model.number="quantity" id="quantity-input" min="1"
                                            max="{{ $query->stock }}"
                                            class="w-16 text-center border-t border-b focus:ring-yellow-500 focus:border-yellow-500"
                                            readonly>
                                        <button @click="quantity = Math.min({{ $query->stock }}, quantity + 1)"
                                            class="px-3 py-2 border rounded-r-md bg-gray-100 hover:bg-gray-200">+</button>
                                    </div>
                                </div>

                                {{-- Tombol Tambah ke Keranjang --}}
                                <div class="mt-6">
                                    <button id="add-to-cart-btn"
                                        @if (!empty($query->sizes)) :disabled="!selectedSize || {{ $query->stock <= 0 }}" @else :disabled="{{ $query->stock <= 0 }}" @endif
                                        class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 disabled:bg-gray-400 disabled:cursor-not-allowed transition-colors">
                                        <i class="fa fa-shopping-cart mr-2"></i>
                                        Tambah ke Keranjang
                                    </button>
                                    @if (!empty($query->sizes))
                                        <p x-show="!selectedSize" class="text-red-500 text-sm mt-2" x-cloak>Silakan pilih
                                            ukuran terlebih dahulu.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div x-data="{ tab: 'description' }" class="mt-10 bg-white rounded-lg shadow-sm p-6">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8">
                            <a href="#" @click.prevent="tab = 'description'"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                                :class="{ 'border-yellow-500 text-yellow-600': tab === 'description', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'description' }">
                                Deskripsi
                            </a>
                            <a href="#" @click.prevent="tab = 'details'"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                                :class="{ 'border-yellow-500 text-yellow-600': tab === 'details', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'details' }">
                                Detail Produk
                            </a>
                        </nav>
                    </div>
                    <div class="mt-6">
                        {{-- Konten Deskripsi --}}
                        <div x-show="tab === 'description'" class="prose max-w-none text-gray-600" x-cloak>
                            {!! nl2br(e($query->description)) !!}
                        </div>
                        {{-- Konten Detail --}}
                        <div x-show="tab === 'details'" x-cloak>
                            <dl class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3">
                                <div>
                                    <dt class="font-medium text-gray-900">Kategori</dt>
                                    <dd class="mt-2 text-sm text-gray-500">{{ $query->category->name }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-900">Stok Tersedia</dt>
                                    <dd class="mt-2 text-sm text-gray-500">{{ $query->stock }} unit</dd>
                                </div>
                                @if (!empty($query->sizes))
                                    <div>
                                        <dt class="font-medium text-gray-900">Ukuran</dt>
                                        <dd class="mt-2 text-sm text-gray-500">{{ implode(', ', $query->sizes) }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    </div>
                </div>
                </section>

                <section class="mt-16">
                    <h2 class="text-2xl font-bold mb-6 text-center text-gray-900">
                        PRODUK LAIN YANG SERUPA
                    </h2>
                    <div class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 lg:grid-cols-4">
                        @forelse ($products as $product)
                            <a href="/detail/{{ $product->slug }}">
                                <div
                                    class="group relative bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300">
                                    <div class="aspect-w-1 aspect-h-1 bg-gray-200 overflow-hidden">
                                        <img src="{{ $product->getPrimaryImage() }}" alt="{{ $product->name }}"
                                            class="w-full h-48 sm:h-64 object-cover group-hover:opacity-75 transition-opacity">
                                    </div>
                                    <div class="p-4">
                                        <h3 class="text-sm font-medium text-gray-900">
                                            {{ $product->name }}
                                        </h3>
                                        <p class="mt-2 text-lg font-semibold text-yellow-600">
                                            {{ $product->formatted_price }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="col-span-full text-center py-8">
                                <p class="text-gray-500">Tidak ada produk serupa.</p>
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>
    </main>

@endsection


@push('scripts')
    {{-- Hapus pemanggilan <script src="{{ asset(...) }}"> yang salah dari sini --}}
    {{-- Cukup gunakan skrip di bawah ini --}}

    <script>
        // Dengarkan event 'cart-ready' yang dikirim dari app.js
        // Ini memastikan kode di dalamnya hanya berjalan setelah keranjang belanja siap
        document.addEventListener('cart-ready', function() {
            const addToCartButton = document.getElementById('add-to-cart-btn');

            if (addToCartButton) {
                addToCartButton.addEventListener('click', function() {
                    // Sekarang dijamin window.cart sudah ada
                    if (!window.cart) {
                        console.error('Objek keranjang tidak tersedia.');
                        return;
                    }

                    const productCard = this.closest('.product-card');
                    const product = {
                        id: productCard.dataset.id,
                        name: productCard.dataset.name,
                        price: productCard.dataset.price,
                        image: productCard.dataset.image,
                        category: productCard.dataset.category
                    };

                    const quantityInput = document.getElementById('quantity-input');
                    const quantity = parseInt(quantityInput.value, 10);

                    const selectedSizeInput = document.querySelector('input[name="size_option"]:checked');
                    const size = selectedSizeInput ? selectedSizeInput.value : null;

                    const hasSizeOptions = productCard.querySelectorAll('input[name="size_option"]')
                        .length > 0;

                    if (hasSizeOptions && !size) {
                        alert('Silakan pilih ukuran terlebih dahulu!');
                        return;
                    }

                    if (quantity > 0) {
                        // Panggil method addItem dari window.cart
                        window.cart.addItem(product, size);
                    }
                });
            }
        });
    </script>
@endpush
