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
    const page = document.querySelector('.xxx-shop-page');

    if (!page) {
      return;
    }

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const hasGsap = typeof window.gsap !== 'undefined';
    const hasScrollTrigger = hasGsap && typeof window.ScrollTrigger !== 'undefined';
    const toArray = (selector, scope = page) => Array.prototype.slice.call(scope.querySelectorAll(selector));

    if (!hasGsap || reducedMotion) {
      toArray('.xxx-shop-animate').forEach((element) => element.classList.add('is-visible'));
      return;
    }

    const gsap = window.gsap;
    const hero = page.querySelector('.xxx-shop-hero');
    const categories = page.querySelector('.xxx-shop-categories');
    const productsPanel = page.querySelector('.xxx-shop-products');
    const productCards = toArray('ul.products li.product', productsPanel || page);

    gsap.set([hero, categories, productsPanel].filter(Boolean), { autoAlpha: 0, y: 34 });
    gsap.set(productCards, { autoAlpha: 0, y: 28, scale: 0.985 });

    const timeline = gsap.timeline({ defaults: { ease: 'power3.out' } });
    if (hero) {
      timeline.to(hero, { autoAlpha: 1, y: 0, duration: 0.72 });
    }
    if (categories) {
      timeline.to(categories, { autoAlpha: 1, y: 0, duration: 0.48 }, '-=0.28');
    }
    if (productsPanel) {
      timeline.to(productsPanel, { autoAlpha: 1, y: 0, duration: 0.58 }, '-=0.24');
    }
    if (productCards.length) {
      timeline.to(productCards, { autoAlpha: 1, y: 0, scale: 1, duration: 0.54, stagger: 0.055 }, '-=0.28');
    }

    gsap.to('.xxx-shop-ambient--one', {
      xPercent: -5,
      yPercent: 4,
      scale: 1.06,
      duration: 8,
      repeat: -1,
      yoyo: true,
      ease: 'sine.inOut',
    });

    gsap.to('.xxx-shop-ambient--two', {
      xPercent: 4,
      yPercent: -5,
      scale: 1.08,
      duration: 10,
      repeat: -1,
      yoyo: true,
      ease: 'sine.inOut',
    });

    if (hasScrollTrigger && hero) {
      gsap.registerPlugin(window.ScrollTrigger);
      gsap.to('.xxx-shop-hero__panel', {
        y: -26,
        ease: 'none',
        scrollTrigger: {
          trigger: hero,
          start: 'top top',
          end: 'bottom top',
          scrub: 0.9,
        },
      });
    }

    if (!window.matchMedia('(max-width: 820px)').matches) {
      productCards.forEach((card) => {
        gsap.set(card, { transformPerspective: 900, transformOrigin: '50% 50%' });
        const y = gsap.quickTo(card, 'y', { duration: 0.24, ease: 'power2.out' });
        const rotateY = gsap.quickTo(card, 'rotationY', { duration: 0.34, ease: 'power3.out' });

        card.addEventListener('pointerenter', () => y(-7));
        card.addEventListener('pointermove', (event) => {
          if (event.pointerType === 'touch') {
            return;
          }

          const rect = card.getBoundingClientRect();
          const x = (event.clientX - rect.left) / Math.max(rect.width, 1) - 0.5;
          rotateY(x * 2.5);
        });
        card.addEventListener('pointerleave', () => {
          y(0);
          rotateY(0);
        });
      });
    }
  });
})();
