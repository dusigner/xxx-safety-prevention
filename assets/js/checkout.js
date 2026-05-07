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
    const checkout = document.querySelector('[data-premium-checkout]');
    if (!checkout) return;

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const gsap = typeof window.gsap !== 'undefined' ? window.gsap : null;
    const $ = window.jQuery || null;

    const setUpdating = (updating) => {
      checkout.classList.toggle('is-updating', updating);
    };

    const animateIn = () => {
      if (!gsap || reducedMotion) return;

      gsap.from(checkout.querySelectorAll('.xxx-checkout-animate'), {
        y: 26,
        autoAlpha: 0,
        duration: 0.58,
        ease: 'power3.out',
        stagger: 0.08,
        clearProps: 'transform,opacity,visibility',
      });
    };

    document.addEventListener('focusin', (event) => {
      const field = event.target.closest('.form-row');
      if (!field || !checkout.contains(field) || !gsap || reducedMotion) return;

      gsap.to(field, {
        y: -1,
        duration: 0.18,
        ease: 'power2.out',
        overwrite: true,
      });
    });

    document.addEventListener('focusout', (event) => {
      const field = event.target.closest('.form-row');
      if (!field || !checkout.contains(field) || !gsap || reducedMotion) return;

      gsap.to(field, {
        y: 0,
        duration: 0.18,
        ease: 'power2.out',
        overwrite: true,
      });
    });

    document.addEventListener('mouseover', (event) => {
      const button = event.target.closest('#place_order, .xxx-checkout-page button, .xxx-checkout-page .button');
      if (!button || !checkout.contains(button) || !gsap || reducedMotion) return;

      gsap.to(button, {
        y: -2,
        duration: 0.2,
        ease: 'power2.out',
        overwrite: true,
      });
    });

    document.addEventListener('mouseout', (event) => {
      const button = event.target.closest('#place_order, .xxx-checkout-page button, .xxx-checkout-page .button');
      if (!button || !checkout.contains(button) || button.contains(event.relatedTarget) || !gsap || reducedMotion) return;

      gsap.to(button, {
        y: 0,
        duration: 0.22,
        ease: 'power2.out',
        overwrite: true,
      });
    });

    if ($) {
      $(document.body).on('update_checkout', () => {
        setUpdating(true);
      });

      $(document.body).on('updated_checkout checkout_error payment_method_selected', () => {
        setUpdating(false);
        if (gsap && !reducedMotion) {
          gsap.fromTo(
            checkout.querySelector('.xxx-checkout-summary__inner'),
            { y: 8, autoAlpha: 0.82 },
            { y: 0, autoAlpha: 1, duration: 0.32, ease: 'power2.out' }
          );
        }
      });
    }

    animateIn();
  });
})();
