(function () {
  'use strict';

  const ready = (callback) => {
    if (document.readyState !== 'loading') {
      callback();
      return;
    }

    document.addEventListener('DOMContentLoaded', callback, { once: true });
  };

  ready(() => {
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const hasGsap = typeof window.gsap !== 'undefined';
    const gsap = hasGsap ? window.gsap : null;
    const $ = window.jQuery || null;
    let updateTimer = null;

    const getCart = () => document.querySelector('[data-premium-cart]');

    const animateIn = () => {
      if (!gsap || reducedMotion) return;
      const cart = getCart();
      if (!cart) return;

      gsap.from(cart.querySelectorAll('.xxx-cart-animate'), {
        y: 28,
        autoAlpha: 0,
        duration: 0.62,
        ease: 'power3.out',
        stagger: 0.08,
        clearProps: 'transform,opacity,visibility',
      });
    };

    const setUpdating = (updating) => {
      const cart = getCart();
      if (cart) {
        cart.classList.toggle('is-updating', updating);
      }
    };

    const triggerFragmentsRefresh = () => {
      if ($) {
        $(document.body).trigger('wc_fragment_refresh');
      }
    };

    const submitCartUpdate = () => {
      const form = document.querySelector('.woocommerce-cart-form');
      if (!form) return;

      const updateButton = form.querySelector('button[name="update_cart"]');
      if (!updateButton) return;

      updateButton.disabled = false;
      updateButton.removeAttribute('disabled');
      setUpdating(true);
      updateButton.click();
    };

    const scheduleCartUpdate = () => {
      window.clearTimeout(updateTimer);
      updateTimer = window.setTimeout(submitCartUpdate, 450);
    };

    const clampValue = (input, nextValue) => {
      const min = input.getAttribute('min') === '' ? 0 : Number(input.getAttribute('min') || 0);
      const maxAttr = input.getAttribute('max');
      const max = maxAttr ? Number(maxAttr) : Infinity;
      return Math.max(min, Math.min(max, nextValue));
    };

    document.addEventListener('click', (event) => {
      const minus = event.target.closest('[data-cart-qty-minus]');
      const plus = event.target.closest('[data-cart-qty-plus]');
      if (!minus && !plus) return;

      const control = event.target.closest('[data-cart-quantity]');
      const input = control ? control.querySelector('input.qty') : null;
      if (!input || input.disabled || input.readOnly) return;

      const current = Number(input.value || 0);
      const next = clampValue(input, current + (plus ? 1 : -1));
      if (Number(input.value) === next) return;

      input.value = next;
      input.dispatchEvent(new Event('change', { bubbles: true }));

      if (gsap && !reducedMotion) {
        gsap.fromTo(control, { scale: 0.985 }, { scale: 1, duration: 0.28, ease: 'back.out(2)' });
      }
    });

    document.addEventListener('change', (event) => {
      if (!event.target.matches('.woocommerce-cart-form input.qty')) return;
      scheduleCartUpdate();
    });

    document.addEventListener('mouseover', (event) => {
      const item = event.target.closest('.xxx-cart-item');
      if (!item || !gsap || reducedMotion) return;

      gsap.to(item, {
        y: -3,
        duration: 0.22,
        ease: 'power2.out',
        overwrite: true,
      });
    });

    document.addEventListener('mouseout', (event) => {
      const item = event.target.closest('.xxx-cart-item');
      if (!item || !gsap || reducedMotion) return;
      if (item.contains(event.relatedTarget)) return;

      gsap.to(item, {
        y: 0,
        duration: 0.24,
        ease: 'power2.out',
        overwrite: true,
      });
    });

    if ($) {
      $(document.body).on('updated_cart_totals updated_wc_div wc_cart_emptied', () => {
        setUpdating(false);
        triggerFragmentsRefresh();
        animateIn();
      });

      $(document.body).on('checkout_error', () => {
        setUpdating(false);
      });
    }

    animateIn();
  });
})();
