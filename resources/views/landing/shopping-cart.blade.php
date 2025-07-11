@extends('layouts.layouts-landing')

@section('title', 'Shopping Cart')

@section('content')
@auth
<div id="userData" data-name="{{ auth()->user()->name }}" data-phone="{{ auth()->user()->phone }}"
    data-address="{{ auth()->user()->address }}" class="hidden">
</div>
@endauth

<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Notifications --}}
        @if (session('warning'))
        <div class="mb-4 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700">
            Please login first to proceed with checkout
        </div>
        @endif

        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Shopping Cart</h1>
            <a href="/" class="text-yellow-600 hover:text-yellow-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Continue Shopping
            </a>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Cart Items Container -->
            <div class="flex-1">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden cart-items"
                    data-logged-in="{{ auth()->check() ? 'true' : 'false' }}">
                    <!-- Cart items will be populated by JavaScript -->
                </div>
            </div>

            <!-- Order Summary -->
            <div class="w-full lg:w-96">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-lg font-medium text-gray-900">Order Summary</h2>
                    <dl class="mt-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <dt class="text-sm text-gray-600">Subtotal</dt>
                            <dd class="text-sm font-medium text-gray-900" data-summary="subtotal">Rp 0</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-sm text-gray-600">Shipping</dt>
                            <dd class="text-sm font-medium text-gray-900" data-summary="shipping">Rp 0</dd>
                        </div>
                        <div class="border-t border-gray-200 pt-4 space-y-2">
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-gray-600">Original Total</dt>
                                <dd class="text-sm font-medium text-gray-500 line-through hidden"
                                    id="originalTotalText">Rp 0</dd>

                            </div>
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-green-700">Discount</dt>
                                <dd class="text-sm font-medium text-green-700 hidden" id="discountAmountText">- Rp 0
                                </dd>
                            </div>
                            <div class="flex items-center justify-between">
                                <dt class="text-base font-medium text-gray-900">Total</dt>
                                <dd class="text-base font-medium text-gray-900" data-summary="total">Rp 0</dd>
                            </div>
                        </div>
                        <span id="couponId">1</span>

                    </dl>
                    <!-- Coupon Input -->
                    <div class="mt-6">
                        <label for="coupon" class="block text-sm font-medium text-gray-700">Coupon Code</label>
                        <div class="mt-1 flex">
                            <input type="text" name="coupon" id="couponInput"
                                class="flex-1 border rounded-l-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                placeholder="Enter coupon code">
                            <button type="button" id="applyCouponButton"
                                class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-r-md">Apply</button>
                        </div>
                        <p id="couponFeedback" class="text-sm mt-2 text-red-600 hidden"></p>
                    </div>


                    @if (auth()->check())
                    <button data-action="checkout"
                        class="mt-6 w-full bg-gray-300 cursor-not-allowed text-white py-3 px-4 rounded-lg">
                        Proceed to Checkout
                    </button>
                    <button id="payButton"
                        class="mt-6 w-full bg-yellow-600 hover:bg-yellow-700 text-white py-3 px-4 rounded-lg hidden">
                        Pay Now
                    </button>
                    @else
                    <a href="{{ route('login') }}"
                        class="mt-6 w-full bg-yellow-600 hover:bg-yellow-700 text-white py-3 px-4 rounded-lg text-center block">
                        Login to Checkout
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ config('midtrans.payment_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
@endpush
