import './bootstrap';
import './search';
import 'flowbite';
import ShoppingCart from './cart';
import AOS from 'aos';
import 'aos/dist/aos.css';

document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true,
        offset: 100,
    });

    try {
        window.cart = new ShoppingCart();
        console.log('Shopping cart initialized');
        // Baris ini mengirim sinyal bahwa cart sudah siap
        document.dispatchEvent(new CustomEvent('cart-ready'));
    } catch (error) {
        console.error('Error initializing cart:', error);
    }

    const applyBtn = document.getElementById("applyCouponButton");
    const couponInput = document.getElementById("couponInput");
    const feedback = document.getElementById("couponFeedback");

    applyBtn?.addEventListener("click", function () {
        const code = couponInput.value.trim();

        if (!code) {
            feedback.textContent = "Please enter a coupon code.";
            feedback.classList.remove("hidden");
            return;
        }

        fetch("/check-coupon", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ code })
        })
        .then(res => res.json())
        .then(data => {
            if (!data.success) {
                feedback.textContent = data.message;
                feedback.classList.remove("hidden");
                return;
            }
            // console.log(data.data.id);

            feedback.classList.add("hidden");

            // Example: apply discount to summary
            const subtotalText = document.querySelector('[data-summary="subtotal"]');
            const totalText = document.querySelector('[data-summary="total"]');
            const shippingText =  document.querySelector('[data-summary="shipping"]');

            let subtotal = parseInt(subtotalText.dataset.original || subtotalText.textContent.replace(/[^\d]/g, ''));
            subtotalText.dataset.original = subtotal; // store original if not stored

            let shipping = parseInt(shippingText.dataset.original || shippingText.textContent.replace(/[^\d]/g, ''));
            subtotal = subtotal + shipping;

            let discountAmount = 0;
            if (data.data.type === 'percent') {
                discountAmount = subtotal * (data.data.value / 100);
            } else {
                discountAmount = data.data.value;
            }

            const newTotal = Math.max(subtotal - discountAmount, 0);

            totalText.textContent = "Rp " + newTotal.toLocaleString("id-ID");
            totalText.classList.add("text-green-600");

            // ... existing inside .then(data => { ... })
            const originalTotalText = document.getElementById("originalTotalText");
            const couponId = document.getElementById("couponId");
            const discountAmountText = document.getElementById("discountAmountText");

            originalTotalText.classList.remove("hidden");
            discountAmountText.classList.remove("hidden");

            originalTotalText.textContent = "Rp " + subtotal.toLocaleString("id-ID");
            discountAmountText.textContent = "- Rp " + discountAmount.toLocaleString("id-ID");
            couponId.textContent = data.data.id;
        })
        .catch(err => {
            feedback.textContent = "Error applying coupon.";
            feedback.classList.remove("hidden");
            console.error(err);
        });
    });
});
