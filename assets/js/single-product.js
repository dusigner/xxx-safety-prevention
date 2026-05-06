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
    const root = document.querySelector('.xxx-product-page');

    if (!root) {
      return;
    }

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const hasGsap = typeof window.gsap !== 'undefined';
    const hasScrollTrigger = hasGsap && typeof window.ScrollTrigger !== 'undefined';

    const toArray = (selector, scope = root) => Array.prototype.slice.call(scope.querySelectorAll(selector));

    const splitProductTitle = () => {
      const title = root.querySelector('.product_title');

      if (!title || title.dataset.xxxSplitTitle === 'true') {
        return title ? toArray('.xxx-product-title-word', title) : [];
      }

      const words = title.textContent.trim().split(/\s+/).filter(Boolean);

      if (!words.length) {
        return [];
      }

      title.textContent = '';
      words.forEach((word, index) => {
        const span = document.createElement('span');
        span.className = 'xxx-product-title-word';
        span.textContent = word;
        title.appendChild(span);

        if (index < words.length - 1) {
          title.appendChild(document.createTextNode(' '));
        }
      });

      title.dataset.xxxSplitTitle = 'true';
      return toArray('.xxx-product-title-word', title);
    };

    const initProductGallery = () => {
      const gallery = root.querySelector('[data-product-gallery]');

      if (!gallery) {
        return;
      }

      const panels = toArray('[data-product-gallery-panel]', gallery);
      const thumbs = toArray('[data-product-gallery-thumb]', gallery);
      let activeIndex = panels.findIndex((panel) => panel.classList.contains('is-active'));

      if (!panels.length || !thumbs.length) {
        return;
      }

      if (activeIndex < 0) {
        activeIndex = 0;
      }

      thumbs.forEach((thumb, index) => {
        thumb.setAttribute('aria-pressed', index === activeIndex ? 'true' : 'false');
      });

      const setActive = (nextIndex) => {
        const current = panels[activeIndex];
        const next = panels[nextIndex];

        if (!next || nextIndex === activeIndex) {
          return;
        }

        thumbs.forEach((thumb, index) => {
          thumb.classList.toggle('is-active', index === nextIndex);
          thumb.setAttribute('aria-pressed', index === nextIndex ? 'true' : 'false');
        });

        if (hasGsap && !reducedMotion) {
          window.gsap.killTweensOf([current, next]);
          next.classList.add('is-active');
          window.gsap.set(next, { autoAlpha: 0, x: 28, scale: 0.985 });
          window.gsap.to(current, {
            autoAlpha: 0,
            x: -22,
            scale: 0.985,
            duration: 0.32,
            ease: 'power2.out',
            onComplete: () => current.classList.remove('is-active'),
          });
          window.gsap.to(next, {
            autoAlpha: 1,
            x: 0,
            scale: 1,
            duration: 0.54,
            ease: 'power3.out',
          });
        } else {
          current.classList.remove('is-active');
          next.classList.add('is-active');
        }

        activeIndex = nextIndex;
      };

      thumbs.forEach((thumb, index) => {
        thumb.addEventListener('click', () => setActive(index));
      });
    };

    const initProductAccordions = () => {
      const wrapper = root.querySelector('[data-product-accordions]');

      if (!wrapper) {
        return;
      }

      const panels = Array.prototype.slice.call(wrapper.children).filter((child) => child.matches('.xxx-product-panel'));

      panels.forEach((panel) => {
        panel.addEventListener('toggle', () => {
          if (!panel.open) {
            return;
          }

          panels.forEach((sibling) => {
            if (sibling !== panel) {
              sibling.open = false;
            }
          });

          const content = panel.querySelector('.xxx-product-panel__content');

          if (hasGsap && !reducedMotion && content) {
            window.gsap.fromTo(
              content,
              { autoAlpha: 0, y: -8 },
              { autoAlpha: 1, y: 0, duration: 0.38, ease: 'power2.out' }
            );
          }
        });
      });
    };

    const initMobileBuy = () => {
      const bar = root.querySelector('[data-mobile-buy]');

      if (!bar) {
        return;
      }

      const link = bar.querySelector('a[href^="#"]');

      if (!link) {
        return;
      }

      link.addEventListener('click', (event) => {
        const target = document.querySelector(link.getAttribute('href'));

        if (!target) {
          return;
        }

        event.preventDefault();
        target.scrollIntoView({ behavior: reducedMotion ? 'auto' : 'smooth', block: 'start' });
      });
    };

    const initHeroAnimations = () => {
      if (!hasGsap || reducedMotion) {
        return;
      }

      const gsap = window.gsap;
      const media = root.querySelector('.xxx-product-media-sticky');
      const heroCopy = root.querySelector('.xxx-product-hero-copy');
      const summary = root.querySelector('.xxx-product-summary-card');
      const galleryViewport = root.querySelector('.xxx-product-gallery__viewport');
      const titleWords = splitProductTitle();
      const summaryFlow = toArray(
        '.woocommerce-product-rating, .price, .woocommerce-product-details__short-description, form.cart, .product_meta',
        summary || root
      );
      const trustItems = toArray('.xxx-product-trust__item', summary || root);

      gsap.set(toArray('.xxx-product-animate'), { autoAlpha: 0, y: 34 });
      gsap.set(titleWords, { autoAlpha: 0, y: 28, rotateX: 12 });
      gsap.set(summaryFlow, { autoAlpha: 0, y: 18 });
      gsap.set(trustItems, { autoAlpha: 0, y: 16 });

      const timeline = gsap.timeline({ defaults: { ease: 'power3.out' } });

      if (media) {
        timeline.to(media, { autoAlpha: 1, y: 0, duration: 0.88 }, 0);
      }

      if (galleryViewport) {
        timeline.fromTo(
          galleryViewport,
          { scale: 0.965, rotateY: -3 },
          { scale: 1, rotateY: 0, duration: 1.05 },
          0.05
        );
      }

      if (heroCopy) {
        timeline.to(heroCopy, { autoAlpha: 1, y: 0, duration: 0.58 }, 0.22);
      }

      if (summary) {
        timeline.to(summary, { autoAlpha: 1, y: 0, duration: 0.72 }, 0.34);
      }

      if (titleWords.length) {
        timeline.to(titleWords, { autoAlpha: 1, y: 0, rotateX: 0, duration: 0.68, stagger: 0.045 }, 0.44);
      }

      if (summaryFlow.length) {
        timeline.to(summaryFlow, { autoAlpha: 1, y: 0, duration: 0.54, stagger: 0.07 }, 0.78);
      }

      if (trustItems.length) {
        timeline.to(trustItems, { autoAlpha: 1, y: 0, duration: 0.44, stagger: 0.055 }, 1.02);
      }

      gsap.to('.xxx-product-ambient--one', {
        xPercent: -5,
        yPercent: 4,
        scale: 1.08,
        duration: 8,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut',
      });

      gsap.to('.xxx-product-ambient--two', {
        xPercent: 4,
        yPercent: -3,
        scale: 1.06,
        duration: 10,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut',
      });

      gsap.to('.xxx-product-gallery__glow', {
        scale: 1.08,
        autoAlpha: 0.88,
        duration: 3.6,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut',
      });

      gsap.to('.xxx-product-gallery__floor', {
        x: 14,
        scaleX: 1.05,
        duration: 4.8,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut',
      });

      gsap.to('.xxx-product-gallery__panel img', {
        y: -10,
        duration: 4.6,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut',
      });
    };

    const initScrollReveals = () => {
      if (!hasGsap || !hasScrollTrigger || reducedMotion) {
        return;
      }

      const gsap = window.gsap;
      gsap.registerPlugin(window.ScrollTrigger);

      const introEls = [
        root.querySelector('.xxx-product-media-sticky'),
        root.querySelector('.xxx-product-hero-copy'),
        root.querySelector('.xxx-product-summary-card'),
      ].filter(Boolean);

      toArray('.xxx-product-animate')
        .filter((element) => !introEls.includes(element))
        .forEach((element) => {
          gsap.to(element, {
            autoAlpha: 1,
            y: 0,
            duration: 0.76,
            ease: 'power3.out',
            scrollTrigger: {
              trigger: element,
              start: 'top 82%',
              once: true,
            },
          });

          const staggerItems = toArray('article, .xxx-product-panel, li.product', element);

          if (staggerItems.length) {
            gsap.from(staggerItems, {
              autoAlpha: 0,
              y: 22,
              duration: 0.52,
              stagger: 0.07,
              ease: 'power2.out',
              scrollTrigger: {
                trigger: element,
                start: 'top 82%',
                once: true,
              },
            });
          }
        });
    };

    const initParallax = () => {
      if (!hasGsap || !hasScrollTrigger || reducedMotion) {
        return;
      }

      const gsap = window.gsap;
      const viewport = root.querySelector('.xxx-product-gallery__viewport');

      if (viewport) {
        gsap.to(viewport, {
          yPercent: -4,
          ease: 'none',
          scrollTrigger: {
            trigger: root,
            start: 'top top',
            end: 'bottom top',
            scrub: 0.8,
          },
        });
      }

      gsap.to('.xxx-product-ambient--one', {
        yPercent: 14,
        ease: 'none',
        scrollTrigger: {
          trigger: root,
          start: 'top top',
          end: 'bottom top',
          scrub: 1,
        },
      });

      gsap.to('.xxx-product-ambient--two', {
        yPercent: -10,
        ease: 'none',
        scrollTrigger: {
          trigger: root,
          start: 'top top',
          end: 'bottom top',
          scrub: 1,
        },
      });
    };

    const initCounters = () => {
      if (!hasGsap || !hasScrollTrigger || reducedMotion) {
        return;
      }

      toArray('[data-product-counter]').forEach((counter) => {
        const value = parseFloat(counter.dataset.productCounter || '0');

        if (Number.isNaN(value)) {
          return;
        }

        const state = { value: 0 };
        window.gsap.to(state, {
          value,
          duration: 1.1,
          ease: 'power2.out',
          scrollTrigger: {
            trigger: counter,
            start: 'top 88%',
            once: true,
          },
          onUpdate: () => {
            counter.textContent = Math.round(state.value).toLocaleString('pt-BR');
          },
        });
      });
    };

    const initHoverEffects = () => {
      if (!hasGsap || reducedMotion || window.matchMedia('(max-width: 820px)').matches) {
        return;
      }

      const gsap = window.gsap;
      const viewport = root.querySelector('.xxx-product-gallery__viewport');
      const glow = root.querySelector('.xxx-product-gallery__glow');

      if (viewport) {
        gsap.set(viewport, { transformPerspective: 1000, transformOrigin: '50% 50%' });

        const rotateX = gsap.quickTo(viewport, 'rotationX', { duration: 0.5, ease: 'power3.out' });
        const rotateY = gsap.quickTo(viewport, 'rotationY', { duration: 0.5, ease: 'power3.out' });
        const glowX = glow ? gsap.quickTo(glow, 'x', { duration: 0.7, ease: 'power3.out' }) : null;
        const glowY = glow ? gsap.quickTo(glow, 'y', { duration: 0.7, ease: 'power3.out' }) : null;

        viewport.addEventListener('pointermove', (event) => {
          if (event.pointerType === 'touch') {
            return;
          }

          const rect = viewport.getBoundingClientRect();
          const x = (event.clientX - rect.left) / rect.width - 0.5;
          const y = (event.clientY - rect.top) / rect.height - 0.5;

          rotateY(x * 5);
          rotateX(y * -4);

          if (glowX && glowY) {
            glowX(x * 28);
            glowY(y * 22);
          }
        });

        viewport.addEventListener('pointerleave', () => {
          rotateX(0);
          rotateY(0);

          if (glowX && glowY) {
            glowX(0);
            glowY(0);
          }
        });
      }

      toArray('.xxx-product-summary-card, .xxx-product-trust__item, .xxx-product-differentials article, .xxx-product-panel').forEach((card) => {
        gsap.set(card, { transformPerspective: 900, transformOrigin: '50% 50%' });

        const y = gsap.quickTo(card, 'y', { duration: 0.28, ease: 'power2.out' });
        const rotateY = gsap.quickTo(card, 'rotationY', { duration: 0.38, ease: 'power3.out' });

        card.addEventListener('pointerenter', () => y(-4));
        card.addEventListener('pointermove', (event) => {
          if (event.pointerType === 'touch') {
            return;
          }

          const rect = card.getBoundingClientRect();
          const x = (event.clientX - rect.left) / rect.width - 0.5;
          rotateY(x * 3);
        });
        card.addEventListener('pointerleave', () => {
          y(0);
          rotateY(0);
        });
      });
    };

    initProductGallery();
    initProductAccordions();
    initMobileBuy();
    initHeroAnimations();
    initScrollReveals();
    initParallax();
    initCounters();
    initHoverEffects();
  });
})();
