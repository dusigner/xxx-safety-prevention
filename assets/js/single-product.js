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

      const viewport = gallery.querySelector('[data-product-gallery-viewport]');
      const panels = toArray('[data-product-gallery-panel]', gallery);
      const thumbs = toArray('[data-product-gallery-thumb]', gallery);
      const dots = toArray('[data-product-gallery-dot]', gallery);
      const prev = gallery.querySelector('[data-product-gallery-prev]');
      const next = gallery.querySelector('[data-product-gallery-next]');
      let activeIndex = panels.findIndex((panel) => panel.classList.contains('is-active'));
      let isAnimating = false;

      if (!panels.length) {
        return;
      }

      if (activeIndex < 0) {
        activeIndex = 0;
      }

      const normalizeIndex = (index) => {
        if (index < 0) {
          return panels.length - 1;
        }

        if (index >= panels.length) {
          return 0;
        }

        return index;
      };

      const updateControls = (index) => {
        thumbs.forEach((thumb, thumbIndex) => {
          thumb.classList.toggle('is-active', thumbIndex === index);
          thumb.setAttribute('aria-pressed', thumbIndex === index ? 'true' : 'false');
        });

        dots.forEach((dot, dotIndex) => {
          dot.classList.toggle('is-active', dotIndex === index);
        });
      };

      const updateState = (index) => {
        panels.forEach((panel, panelIndex) => {
          panel.classList.toggle('is-active', panelIndex === index);
          panel.setAttribute('aria-hidden', panelIndex === index ? 'false' : 'true');
        });

        updateControls(index);
      };

      const setActive = (nextIndex, preferredDirection) => {
        nextIndex = normalizeIndex(nextIndex);
        const current = panels[activeIndex];
        const next = panels[nextIndex];
        const direction = preferredDirection || (nextIndex > activeIndex ? 1 : -1);

        if (!next || nextIndex === activeIndex || isAnimating) {
          return;
        }

        if (hasGsap && !reducedMotion) {
          isAnimating = true;
          const currentShell = current.querySelector('[data-product-zoom-surface]');
          const nextShell = next.querySelector('[data-product-zoom-surface]');
          const currentImage = currentShell ? currentShell.querySelector('img') : null;
          const nextImage = nextShell ? nextShell.querySelector('img') : null;

          updateControls(nextIndex);
          window.gsap.killTweensOf([current, next, currentShell, nextShell, currentImage, nextImage]);
          window.gsap.set([currentImage, nextImage].filter(Boolean), { x: 0, y: 0, scale: 1, transformOrigin: '50% 50%' });
          next.classList.add('is-active');
          next.setAttribute('aria-hidden', 'false');
          window.gsap.set(next, { autoAlpha: 0, x: direction * 42, scale: 0.985 });
          window.gsap.set(nextShell, { x: direction * 22, y: 0, scale: 0.985 });

          const timeline = window.gsap.timeline({
            defaults: { ease: 'power3.out' },
            onComplete: () => {
              current.classList.remove('is-active');
              current.setAttribute('aria-hidden', 'true');
              window.gsap.set(current, { clearProps: 'x,scale,autoAlpha' });
              window.gsap.set(currentShell, { clearProps: 'x,y,scale' });
              activeIndex = nextIndex;
              updateState(activeIndex);
              isAnimating = false;
            },
          });

          timeline.to(current, {
            autoAlpha: 0,
            x: direction * -34,
            scale: 0.985,
            duration: 0.34,
          }, 0);
          timeline.to(currentShell, {
            x: direction * -18,
            scale: 0.96,
            duration: 0.34,
          }, 0);
          timeline.to(next, {
            autoAlpha: 1,
            x: 0,
            scale: 1,
            duration: 0.62,
          }, 0.07);
          timeline.to(nextShell, {
            x: 0,
            scale: 1,
            duration: 0.68,
          }, 0.07);
        } else {
          activeIndex = nextIndex;
          updateState(activeIndex);
        }
      };

      updateState(activeIndex);

      if (prev) {
        prev.addEventListener('click', () => setActive(activeIndex - 1, -1));
      }

      if (next) {
        next.addEventListener('click', () => setActive(activeIndex + 1, 1));
      }

      if (viewport && panels.length > 1) {
        viewport.addEventListener('keydown', (event) => {
          if (event.key === 'ArrowLeft') {
            event.preventDefault();
            setActive(activeIndex - 1, -1);
          }

          if (event.key === 'ArrowRight') {
            event.preventDefault();
            setActive(activeIndex + 1, 1);
          }
        });
      }

      if (viewport && hasGsap && !reducedMotion && prev && next && !window.matchMedia('(max-width: 720px)').matches) {
        const arrows = [prev, next];
        window.gsap.set(arrows, { autoAlpha: 0, scale: 0.92 });

        viewport.addEventListener('pointerenter', () => {
          window.gsap.to(arrows, { autoAlpha: 1, scale: 1, duration: 0.32, stagger: 0.035, ease: 'power2.out' });
        });

        viewport.addEventListener('pointerleave', () => {
          window.gsap.to(arrows, { autoAlpha: 0, scale: 0.92, duration: 0.25, ease: 'power2.out' });
        });
      }

      let dragState = null;

      const resetDraggedPanel = () => {
        const current = panels[activeIndex];
        const currentShell = current ? current.querySelector('[data-product-zoom-surface]') : null;

        if (hasGsap && !reducedMotion && current) {
          window.gsap.to([current, currentShell], { x: 0, scale: 1, duration: 0.32, ease: 'power2.out' });
        } else if (current) {
          current.style.transform = '';
        }
      };

      if (viewport && panels.length > 1) {
        viewport.addEventListener('pointerdown', (event) => {
          const isTouchLike = event.pointerType === 'touch' || window.matchMedia('(max-width: 720px)').matches;

          if (!isTouchLike || isAnimating) {
            return;
          }

          dragState = {
            pointerId: event.pointerId,
            startX: event.clientX,
            startY: event.clientY,
            deltaX: 0,
            isDragging: false,
          };

          viewport.setPointerCapture(event.pointerId);
        });

        viewport.addEventListener('pointermove', (event) => {
          if (!dragState || event.pointerId !== dragState.pointerId) {
            return;
          }

          const deltaX = event.clientX - dragState.startX;
          const deltaY = event.clientY - dragState.startY;

          if (!dragState.isDragging && Math.abs(deltaX) < 8) {
            return;
          }

          if (Math.abs(deltaY) > Math.abs(deltaX) && !dragState.isDragging) {
            return;
          }

          event.preventDefault();
          dragState.isDragging = true;
          dragState.deltaX = deltaX;
          viewport.classList.add('is-dragging');

          const current = panels[activeIndex];
          const currentShell = current ? current.querySelector('[data-product-zoom-surface]') : null;
          const progress = Math.min(Math.abs(deltaX) / Math.max(viewport.offsetWidth, 1), 0.22);

          if (hasGsap && !reducedMotion && current) {
            window.gsap.set(current, { x: deltaX * 0.42 });
            window.gsap.set(currentShell, { x: deltaX * 0.12, scale: 1 - progress * 0.22 });
          }
        });

        viewport.addEventListener('pointerup', (event) => {
          if (!dragState || event.pointerId !== dragState.pointerId) {
            return;
          }

          const threshold = Math.min(92, viewport.offsetWidth * 0.18);
          const deltaX = dragState.deltaX;

          viewport.classList.remove('is-dragging');
          dragState = null;

          if (Math.abs(deltaX) > threshold) {
            setActive(activeIndex + (deltaX < 0 ? 1 : -1), deltaX < 0 ? 1 : -1);
            return;
          }

          resetDraggedPanel();
        });

        viewport.addEventListener('pointercancel', () => {
          viewport.classList.remove('is-dragging');
          dragState = null;
          resetDraggedPanel();
        });
      };

      thumbs.forEach((thumb, index) => {
        thumb.addEventListener('click', () => setActive(index, index > activeIndex ? 1 : -1));
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
        timeline.to(media, { autoAlpha: 1, y: 0, duration: 0.88, clearProps: 'transform' }, 0);
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

      gsap.to('.xxx-product-gallery__image-shell', {
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
        const imageZoomHandlers = new WeakMap();
        const getActiveZoomImage = () => viewport.querySelector('.xxx-product-gallery__panel.is-active [data-product-zoom-surface] img');
        const getImageZoomHandlers = (image) => {
          if (!image) {
            return null;
          }

          if (!imageZoomHandlers.has(image)) {
            imageZoomHandlers.set(image, {
              x: gsap.quickTo(image, 'x', { duration: 0.62, ease: 'power3.out' }),
              y: gsap.quickTo(image, 'y', { duration: 0.62, ease: 'power3.out' }),
              scale: gsap.quickTo(image, 'scale', { duration: 0.62, ease: 'power3.out' }),
            });
          }

          return imageZoomHandlers.get(image);
        };
        const clamp = (value, min, max) => Math.min(Math.max(value, min), max);
        const getImageOrigin = (image, event) => {
          const rect = image.getBoundingClientRect();
          const originX = clamp(((event.clientX - rect.left) / Math.max(rect.width, 1)) * 100, 0, 100);
          const originY = clamp(((event.clientY - rect.top) / Math.max(rect.height, 1)) * 100, 0, 100);

          return { originX, originY, rect };
        };

        viewport.addEventListener('pointermove', (event) => {
          if (event.pointerType === 'touch') {
            return;
          }

          const rect = viewport.getBoundingClientRect();
          const x = (event.clientX - rect.left) / rect.width - 0.5;
          const y = (event.clientY - rect.top) / rect.height - 0.5;
          const zoomImage = getActiveZoomImage();
          const zoom = getImageZoomHandlers(zoomImage);

          rotateY(x * 5);
          rotateX(y * -4);
          viewport.style.setProperty('--gallery-light-x', `${Math.round((x + 0.5) * 100)}%`);
          viewport.style.setProperty('--gallery-light-y', `${Math.round((y + 0.5) * 100)}%`);

          if (zoom && zoomImage) {
            const imageOrigin = getImageOrigin(zoomImage, event);
            const imageCenterX = imageOrigin.originX / 100 - 0.5;
            const imageCenterY = imageOrigin.originY / 100 - 0.5;

            gsap.set(zoomImage, {
              transformOrigin: `${imageOrigin.originX}% ${imageOrigin.originY}%`,
            });
            zoom.x(imageCenterX * -18);
            zoom.y(imageCenterY * -14);
            zoom.scale(1.86);
          }

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

          viewport.style.removeProperty('--gallery-light-x');
          viewport.style.removeProperty('--gallery-light-y');
          toArray('[data-product-zoom-surface] img', viewport).forEach((image) => {
            const zoom = getImageZoomHandlers(image);

            if (zoom) {
              zoom.x(0);
              zoom.y(0);
              zoom.scale(1);
            }

            gsap.set(image, { transformOrigin: '50% 50%' });
          });
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
