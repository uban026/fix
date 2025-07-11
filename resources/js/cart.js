// resources/js/cart.js

class ShoppingCart {
    constructor() {
        this.items = this.getCartFromStorage();
        this.SHIPPING_COST = 20000;
        this.init();
    }

    init() {
        if (window.location.pathname.includes('cart')) {
            this.updateCartUI();
        }
        this.updateCartCount();
        this.attachEventListeners();
    }

    getCartFromStorage() {
        try {
            return JSON.parse(localStorage.getItem('shopping_cart')) || [];
        } catch (e) {
            console.error('Error reading cart from storage:', e);
            return [];
        }
    }

    saveCartToStorage() {
        try {
            localStorage.setItem('shopping_cart', JSON.stringify(this.items));
            this.updateCartCount();
        } catch (error) {
            console.error('Error saving cart:', error);
            this.showNotification('Gagal menyimpan keranjang', 'error');
        }
    }

    addItem(product, size = null) {
        if (!product?.id) return;

        try {
            const cartId = size ? `${product.id}-${size}` : product.id.toString();
            const existingItem = this.items.find(item => item.cartId === cartId);

            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                this.items.push({
                    cartId: cartId,
                    id: parseInt(product.id),
                    name: product.name,
                    price: parseFloat(product.price),
                    image: product.image,
                    category: product.category,
                    quantity: 1,
                    size: size
                });
            }

            this.saveCartToStorage();
            if (window.location.pathname.includes('cart')) {
                this.updateCartUI();
            }
            this.showNotification(`${product.name} ${size ? `(Ukuran: ${size})` : ''} berhasil ditambahkan!`);
        } catch (error) {
            console.error('Error adding item:', error);
            this.showNotification('Gagal menambahkan produk', 'error');
        }
    }

    removeItem(cartId) {
        this.items = this.items.filter(item => item.cartId !== cartId);
        this.saveCartToStorage();
        this.updateCartUI();
        this.showNotification('Produk berhasil dihapus dari keranjang');
    }

    updateQuantity(cartId, changeAmount) {
        const item = this.items.find(item => item.cartId === cartId);
        if (!item) return;

        const newQuantity = item.quantity + changeAmount;
        if (newQuantity < 1) {
            this.removeItem(cartId);
        } else {
            item.quantity = newQuantity;
            this.saveCartToStorage();
            this.updateCartUI();
        }
    }

    updateCartCount() {
        const cartCount = document.getElementById('cart-count');
        if (!cartCount) return;
        const totalItems = this.items.reduce((sum, item) => sum + item.quantity, 0);
        cartCount.textContent = totalItems;
        cartCount.style.display = totalItems > 0 ? 'flex' : 'none';
    }

    updateCartUI() {
        const cartContainer = document.querySelector('.cart-items');
        if (!cartContainer) return;

        cartContainer.innerHTML = '';

        if (this.items.length === 0) {
            cartContainer.innerHTML = `
                <div class="p-6 text-center text-gray-500">
                    <p class="mb-4">Keranjang belanja Anda kosong</p>
                    <a href="/" class="text-yellow-600 hover:text-yellow-700">Lanjutkan Belanja</a>
                </div>`;
            this.updateOrderSummary(0, 0);
            return;
        }

        this.items.forEach(item => {
            cartContainer.appendChild(this.createCartItemElement(item));
        });
        
        // Hanya tambahkan form jika user sudah login
        if (document.querySelector('[data-logged-in="true"]')) {
            const shippingForm = this.createShippingForm();
            cartContainer.appendChild(shippingForm);
            shippingForm.classList.add('hidden'); // Sembunyikan form secara default
        }

        const subtotal = this.calculateSubtotal();
        this.updateOrderSummary(subtotal, this.SHIPPING_COST);
    }

    createCartItemElement(item) {
        const div = document.createElement('div');
        div.className = 'p-6 border-b border-gray-200';
        const sizeInfo = item.size ? `<p class="text-sm text-gray-500">Ukuran: ${item.size}</p>` : '';

        div.innerHTML = `
            <div class="flex items-center gap-4">
                <img src="${item.image}" alt="${item.name}" class="w-20 h-20 object-cover rounded-lg">
                <div class="flex-1">
                    <h3 class="font-medium">${item.name}</h3>
                    ${sizeInfo}
                    <div class="flex items-center gap-2 mt-2">
                        <button data-action="decrease" data-cart-id="${item.cartId}" class="p-1 rounded-full bg-gray-200 hover:bg-gray-300">-</button>
                        <span>${item.quantity}</span>
                        <button data-action="increase" data-cart-id="${item.cartId}" class="p-1 rounded-full bg-gray-200 hover:bg-gray-300">+</button>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-semibold">${this.formatPrice(item.price * item.quantity)}</p>
                    <button data-action="remove" data-cart-id="${item.cartId}" class="text-red-500 hover:underline text-sm mt-1">Hapus</button>
                </div>
            </div>
        `;
        return div;
    }

    calculateSubtotal() {
        return this.items.reduce((total, item) => total + (item.price * item.quantity), 0);
    }

    updateOrderSummary(subtotal, shipping) {
        const subtotalEl = document.querySelector('[data-summary="subtotal"]');
        const shippingEl = document.querySelector('[data-summary="shipping"]');
        const totalEl = document.querySelector('[data-summary="total"]');
        const checkoutBtn = document.querySelector('[data-action="checkout"]');

        if(subtotalEl) subtotalEl.textContent = this.formatPrice(subtotal);
        if(shippingEl) shippingEl.textContent = this.formatPrice(shipping);
        if(totalEl) totalEl.textContent = this.formatPrice(subtotal + shipping);
        
        if (checkoutBtn) {
            const isDisabled = this.items.length === 0;
            checkoutBtn.disabled = isDisabled;
            checkoutBtn.classList.toggle('bg-gray-300', isDisabled);
            checkoutBtn.classList.toggle('cursor-not-allowed', isDisabled);
            checkoutBtn.classList.toggle('bg-yellow-600', !isDisabled);
            checkoutBtn.classList.toggle('hover:bg-yellow-700', !isDisabled);
        }
    }

    formatPrice(price) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(price);
    }

    showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white`;
        notification.textContent = message;
        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 3000);
    }

    attachEventListeners() {
        document.body.addEventListener('click', e => {
            const target = e.target;
            const action = target.dataset.action;
            
            const addToCartBtn = target.closest('.add-to-cart');
            if (addToCartBtn) {
                e.preventDefault();
                const productCard = addToCartBtn.closest('.product-card, .product-card-v2');
                if (productCard) {
                    const product = {
                        id: productCard.dataset.id,
                        name: productCard.dataset.name,
                        price: productCard.dataset.price,
                        image: productCard.dataset.image,
                        category: productCard.dataset.category
                    };
                    this.addItem(product);
                }
                return;
            }
            
            if (target.matches('[data-action="checkout"]')) {
                e.preventDefault();
                if (this.items.length === 0) return;
                const shippingForm = document.getElementById('shippingForm');
                const payButton = document.getElementById('payButton');
                if (shippingForm && payButton) {
                    shippingForm.classList.remove('hidden');
                    target.classList.add('hidden');
                    payButton.classList.remove('hidden');
                }
                return;
            }
            
            if (target.id === 'payButton') {
                e.preventDefault();
                this.processPayment();
                return;
            }
            
            if (action && target.dataset.cartId) {
                const cartId = target.dataset.cartId;
                if (action === 'increase') this.updateQuantity(cartId, 1);
                if (action === 'decrease') this.updateQuantity(cartId, -1);
                if (action === 'remove') this.removeItem(cartId);
            }
        });
    }

    createShippingForm() {
        const div = document.createElement('div');
        div.id = 'shippingForm';
        div.className = 'p-6 border-t border-gray-200 mt-4';

        const userData = document.getElementById('userData');
        const name = userData?.dataset.name || '';
        const phone = userData?.dataset.phone || '';
        const address = userData?.dataset.address || '';

        div.innerHTML = `
            <h2 class="text-lg font-medium text-gray-900 mb-4">Informasi Pengiriman</h2>
            <form id="checkoutForm" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" name="name" value="${name}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                    <input type="tel" name="phone" value="${phone}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Alamat Pengiriman</label>
                    <textarea name="shipping_address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500" required>${address}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                    <textarea name="notes" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500" placeholder="Instruksi khusus untuk pengiriman"></textarea>
                </div>
            </form>
        `;
        return div;
    }

    async processPayment() {
        const form = document.getElementById('checkoutForm');
        if (!form || !form.checkValidity()) {
            form?.reportValidity();
            return;
        }

        const formData = new FormData(form);
        const coupon_id = document.getElementById('couponId')?.textContent.trim() || '1';
        const payButton = document.getElementById('payButton');

        if (payButton) {
            payButton.disabled = true;
            payButton.textContent = 'Processing...';
        }

        try {
            const response = await fetch('/checkout/process', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                },
                body: JSON.stringify({
                    name: formData.get('name'),
                    coupon_id: coupon_id,
                    phone: formData.get('phone'),
                    shipping_address: formData.get('shipping_address'),
                    notes: formData.get('notes'),
                    cart: this.items
                })
            });

            if (!response.ok) {
                const error = await response.json();
                throw new Error(error.message || 'Payment processing failed');
            }

            const data = await response.json();
            if (data.status !== 'success' || !data.snap_token) {
                throw new Error(data.message || 'Invalid payment response');
            }

            this.handlePayment(data.snap_token, data.order_id, payButton);
        } catch (error) {
            console.error('Payment error:', error);
            this.showNotification(error.message || 'Gagal memproses pembayaran', 'error');
            if (payButton) {
                payButton.disabled = false;
                payButton.textContent = 'Pay Now';
            }
        }
    }

    handlePayment(snapToken, orderId, payButton) {
        window.snap.pay(snapToken, {
            onSuccess: async (result) => {
                await this.updateTransactionStatus(orderId, result, 'paid');
                this.items = [];
                this.saveCartToStorage();
                window.location.href = '/orders';
            },
            onPending: async (result) => {
                await this.updateTransactionStatus(orderId, result, 'pending');
                this.items = [];
                this.saveCartToStorage();
                window.location.href = '/orders';
            },
            onError: async (result) => {
                await this.updateTransactionStatus(orderId, result, 'cancelled');
                this.showNotification('Pembayaran gagal', 'error');
                if (payButton) {
                    payButton.disabled = false;
                    payButton.textContent = 'Pay Now';
                }
            },
            onClose: async () => {
                if (payButton) {
                    payButton.disabled = false;
                    payButton.textContent = 'Pay Now';
                }
            }
        });
    }

    async updateTransactionStatus(orderId, result, status) {
        try {
            await fetch('/payments/update-status', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                },
                body: JSON.stringify({
                    order_id: orderId,
                    transaction_id: result?.transaction_id || "-",
                    payment_type: result?.payment_type || "-",
                    status
                })
            });
        } catch (error) {
            console.error('Error updating transaction status:', error);
            this.showNotification('Gagal mengupdate status transaksi', 'error');
        }
    }
}

export default ShoppingCart;