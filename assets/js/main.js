(function () {
  const state = {
    reduceMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches,
  };

  const qsa = (selector, scope = document) => Array.from(scope.querySelectorAll(selector));

  const isReducedMotion = () => (
    state.reduceMotion || document.body.classList.contains('xxx-reduced-motion')
  );

  const escapeHtml = (value) => value
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');

  const initHeader = () => {
    const header = document.getElementById('site-header');
    if (!header) return;

    const toggleHeader = () => {
      header.classList.toggle('scrolled', window.scrollY > 20);
    };

    toggleHeader();
    window.addEventListener('scroll', toggleHeader, { passive: true });
  };

  const initMenu = () => {
    const menuToggle = document.querySelector('.mobile-menu-toggle');
    const menu = document.querySelector('.main-navigation');

    if (!menuToggle || !menu) return;

    const closeMenu = () => {
      menu.classList.remove('is-open');
      menuToggle.setAttribute('aria-expanded', 'false');
    };

    menuToggle.addEventListener('click', () => {
      const expanded = menuToggle.getAttribute('aria-expanded') === 'true';
      menuToggle.setAttribute('aria-expanded', String(!expanded));
      menu.classList.toggle('is-open');
    });

    document.addEventListener('keyup', (event) => {
      if (event.key === 'Escape') closeMenu();
    });

    document.addEventListener('click', (event) => {
      if (!menu.contains(event.target) && !menuToggle.contains(event.target)) {
        closeMenu();
      }
    });
  };

  const initImageFallbacks = () => {
    qsa('img[data-img-fallback]').forEach((image) => {
      const fallback = image.dataset.imgFallback;
      if (!fallback) return;

      const applyFallback = () => {
        if (image.dataset.fallbackApplied === 'true') {
          image.classList.add('is-broken');
          return;
        }

        image.dataset.fallbackApplied = 'true';
        image.src = fallback;
      };

      image.addEventListener('error', applyFallback, { passive: true });

      if (image.complete && image.naturalWidth === 0) {
        applyFallback();
      }
    });
  };

  const showWithoutMotion = () => {
    qsa('.xxx-animate').forEach((node) => node.classList.add('is-visible'));
    qsa('.js-count').forEach((counter) => {
      counter.textContent = counter.dataset.count || counter.textContent;
    });
  };

  const initFallbackReveals = () => {
    if (isReducedMotion() || !('IntersectionObserver' in window)) {
      showWithoutMotion();
      return;
    }

    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('is-visible');
        obs.unobserve(entry.target);
      });
    }, { threshold: 0.16, rootMargin: '0px 0px -40px 0px' });

    qsa('.xxx-animate').forEach((node) => observer.observe(node));
  };

  const splitHeroTitle = () => {
    const title = document.getElementById('hero-title');
    if (!title || title.dataset.gsapSplit === 'true') {
      return title ? qsa('.gsap-word', title) : [];
    }

    const text = title.textContent.trim();
    if (!text) return [];

    title.dataset.gsapSplit = 'true';
    title.innerHTML = text
      .split(/(\s+)/)
      .map((part) => (/\s+/.test(part) ? part : `<span class="gsap-word">${escapeHtml(part)}</span>`))
      .join('');

    return qsa('.gsap-word', title);
  };

  const initHeroAnimations = (gsap) => {
    const hero = document.querySelector('.fire-hero');
    if (!hero) return;

    const compactMotion = window.matchMedia('(max-width: 720px)').matches;
    const words = splitHeroTitle();
    const title = hero.querySelector('#hero-title');
    const kicker = hero.querySelector('.fire-kicker');
    const lead = hero.querySelector('.fire-hero__lead');
    const actions = qsa('.fire-hero__actions .fire-btn', hero);
    const badges = qsa('.fire-hero__badges span', hero);
    const visual = hero.querySelector('.fire-hero__visual');
    const stage = hero.querySelector('.fire-hero__stage');
    const mainProduct = hero.querySelector('.fire-hero__product--main');
    const rearProduct = hero.querySelector('.fire-hero__product--rear');
    const detailProduct = hero.querySelector('.fire-hero__product--detail');
    const products = qsa('.fire-hero__product', hero);
    const glassItems = qsa('.fire-hero__glass', hero);
    const metrics = qsa('.fire-hero__metrics > div', hero);
    const atmosphere = qsa('.fire-hero__smoke, .fire-hero__sparks, .fire-hero__glow, .fire-hero__heat, .fire-hero__haze, .fire-hero__ash, .fire-hero__light', hero);
    const halo = hero.querySelector('.fire-hero__halo');
    const beam = hero.querySelector('.fire-hero__beam');
    const floor = hero.querySelector('.fire-hero__floor');

    gsap.set(atmosphere, { autoAlpha: 0 });
    gsap.set([kicker, lead].filter(Boolean), { autoAlpha: 0, y: 26 });
    gsap.set(words.length ? words : title, { autoAlpha: 0, y: 34, rotateX: -12 });
    gsap.set(actions, { autoAlpha: 0, y: 22, scale: 0.96 });
    gsap.set(badges, { autoAlpha: 0, y: 16, scale: 0.94 });
    gsap.set(visual, { autoAlpha: 0, x: compactMotion ? 0 : 42, y: 24, scale: 0.96 });
    gsap.set(stage, { transformOrigin: '50% 62%', transformPerspective: 1100 });
    gsap.set(products, { autoAlpha: 0, y: 40, scale: 0.9, transformOrigin: '50% 70%' });
    gsap.set(mainProduct, { x: compactMotion ? 0 : 38, rotation: -4 });
    gsap.set(rearProduct, { x: compactMotion ? -14 : -36, rotation: -12 });
    gsap.set(detailProduct, { x: compactMotion ? 16 : 32, rotation: 9 });
    gsap.set([beam, floor, ...glassItems, ...metrics].filter(Boolean), { autoAlpha: 0, y: 24, scale: 0.96 });
    gsap.set(halo, { scale: 0.84, autoAlpha: 0 });

    const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });
    tl
      .to(atmosphere, {
        autoAlpha: (index, target) => (target.classList.contains('fire-hero__glow') ? 1 : 0.85),
        duration: 1.15,
        stagger: 0.08,
      })
      .to(halo, {
        autoAlpha: 1,
        scale: 1,
        duration: 1.1,
      }, '-=0.85')
      .to(kicker, {
        autoAlpha: 1,
        y: 0,
        duration: 0.58,
      }, '-=0.68')
      .to(words.length ? words : title, {
        autoAlpha: 1,
        y: 0,
        rotateX: 0,
        duration: 0.72,
        stagger: words.length ? 0.026 : 0,
      }, '-=0.38')
      .to(lead, {
        autoAlpha: 1,
        y: 0,
        duration: 0.66,
      }, '-=0.34')
      .to(actions, {
        autoAlpha: 1,
        y: 0,
        scale: 1,
        duration: 0.54,
        stagger: 0.08,
      }, '-=0.28')
      .to(badges, {
        autoAlpha: 1,
        y: 0,
        scale: 1,
        duration: 0.48,
        stagger: 0.06,
      }, '-=0.32')
      .to(visual, {
        autoAlpha: 1,
        x: 0,
        y: 0,
        scale: 1,
        duration: 0.7,
      }, '-=1.15')
      .to([beam, floor].filter(Boolean), {
        autoAlpha: 1,
        y: 0,
        scale: 1,
        duration: 0.72,
        stagger: 0.08,
      }, '-=0.58')
      .to(rearProduct, {
        autoAlpha: compactMotion ? 0.42 : 0.66,
        x: 0,
        y: 0,
        scale: 1,
        rotation: -7,
        duration: 0.9,
      }, '-=0.42')
      .to(mainProduct, {
        autoAlpha: 1,
        x: 0,
        y: 0,
        scale: 1,
        rotation: -1.2,
        duration: 0.95,
      }, '-=0.72')
      .to(detailProduct, {
        autoAlpha: compactMotion ? 0.62 : 0.84,
        x: 0,
        y: 0,
        scale: 1,
        rotation: 5,
        duration: 0.78,
      }, '-=0.62')
      .to(glassItems, {
        autoAlpha: 1,
        y: 0,
        scale: 1,
        duration: 0.58,
        stagger: 0.08,
      }, '-=0.40')
      .to(metrics, {
        autoAlpha: 1,
        y: 0,
        scale: 1,
        duration: 0.58,
        stagger: 0.08,
      }, '-=0.28');

    gsap.to(halo, {
      scale: 1.06,
      autoAlpha: 0.9,
      duration: 2.8,
      ease: 'sine.inOut',
      repeat: -1,
      yoyo: true,
    });

    [
      { node: mainProduct, y: compactMotion ? -7 : -14, rotation: -0.4, duration: 5.8 },
      { node: rearProduct, y: compactMotion ? -4 : -9, rotation: -8.2, duration: 6.6 },
      { node: detailProduct, y: compactMotion ? -5 : -11, rotation: 6.2, duration: 5.2 },
    ].forEach(({ node, x = 0, y = 0, rotation, duration }) => {
      if (!node) return;

      gsap.to(node, {
        x,
        y,
        rotation,
        duration,
        delay: 1.6,
        ease: 'sine.inOut',
        repeat: -1,
        yoyo: true,
      });
    });

    [beam, floor].filter(Boolean).forEach((node, index) => {
      gsap.to(node, {
        scale: index === 0 ? 1.04 : 1.03,
        autoAlpha: index === 0 ? 0.72 : 0.88,
        duration: index === 0 ? 6.8 : 7.4,
        delay: 1.4,
        ease: 'sine.inOut',
        repeat: -1,
        yoyo: true,
      });
    });

    gsap.to('.fire-hero__heat', {
      x: compactMotion ? 8 : 18,
      y: compactMotion ? -6 : -12,
      scale: 1.05,
      autoAlpha: compactMotion ? 0.48 : 0.72,
      duration: 7.5,
      delay: 1.2,
      ease: 'sine.inOut',
      repeat: -1,
      yoyo: true,
    });

    gsap.to('.fire-hero__haze--back', {
      x: compactMotion ? -8 : -22,
      y: compactMotion ? 6 : 14,
      duration: 9,
      delay: 1.2,
      ease: 'sine.inOut',
      repeat: -1,
      yoyo: true,
    });

    gsap.to('.fire-hero__haze--front', {
      x: compactMotion ? 8 : 26,
      y: compactMotion ? -4 : -10,
      duration: 8.4,
      delay: 1.2,
      ease: 'sine.inOut',
      repeat: -1,
      yoyo: true,
    });

    gsap.to('.fire-hero__light--a', {
      xPercent: compactMotion ? 2 : 6,
      autoAlpha: compactMotion ? 0.08 : 0.18,
      duration: 5.6,
      delay: 1.2,
      ease: 'sine.inOut',
      repeat: -1,
      yoyo: true,
    });

    if (!compactMotion) {
      gsap.to('.fire-hero__ash', {
        backgroundPosition: '68px 18px, 18px 102px',
        duration: 18,
        delay: 1.2,
        ease: 'none',
        repeat: -1,
      });
    }
  };

  const initScrollReveals = (gsap, ScrollTrigger) => {
    const groupedSelectors = [
      '.fire-services__grid',
      '.fire-product-list',
      '.fire-process__steps',
      '.fire-why__grid',
      '.fire-testimonials__grid',
      '.fire-trust__grid',
    ].join(', ');

    qsa(groupedSelectors).forEach((grid) => {
      const items = Array.from(grid.children);
      if (!items.length) return;

      items.forEach((item) => {
        item.dataset.gsapGrouped = 'true';
      });

      gsap.fromTo(items, {
        autoAlpha: 0,
        y: 34,
        scale: 0.985,
      }, {
        autoAlpha: 1,
        y: 0,
        scale: 1,
        duration: 0.72,
        stagger: 0.09,
        ease: 'power3.out',
        scrollTrigger: {
          trigger: grid,
          start: 'top 84%',
          once: true,
        },
      });
    });

    qsa('.xxx-animate')
      .filter((node) => node.dataset.gsapGrouped !== 'true' && !node.closest('.fire-hero'))
      .forEach((node) => {
        gsap.fromTo(node, {
          autoAlpha: 0,
          y: 38,
          clipPath: 'inset(0 0 16% 0)',
        }, {
          autoAlpha: 1,
          y: 0,
          clipPath: 'inset(0 0 0% 0)',
          duration: 0.78,
          ease: 'power3.out',
          scrollTrigger: {
            trigger: node,
            start: 'top 84%',
            once: true,
          },
        });
      });

    qsa('.fire-section__head h2, .fire-segments__copy h2, .fire-contact__copy h2').forEach((title) => {
      gsap.fromTo(title, {
        autoAlpha: 0,
        y: 28,
      }, {
        autoAlpha: 1,
        y: 0,
        duration: 0.72,
        ease: 'power3.out',
        scrollTrigger: {
          trigger: title,
          start: 'top 88%',
          once: true,
        },
      });
    });

    ScrollTrigger.refresh();
  };

  const initParallax = (gsap) => {
    const hero = document.querySelector('.fire-hero');

    if (hero) {
      gsap.to('.fire-hero__smoke--a', {
        yPercent: -10,
        xPercent: 4,
        ease: 'none',
        scrollTrigger: {
          trigger: hero,
          start: 'top top',
          end: 'bottom top',
          scrub: 1,
        },
      });

      gsap.to('.fire-hero__smoke--b', {
        yPercent: 12,
        xPercent: -5,
        ease: 'none',
        scrollTrigger: {
          trigger: hero,
          start: 'top top',
          end: 'bottom top',
          scrub: 1.15,
        },
      });

      gsap.to('.fire-hero__sparks', {
        yPercent: 18,
        backgroundPosition: '60px 120px, 18px 96px',
        ease: 'none',
        scrollTrigger: {
          trigger: hero,
          start: 'top top',
          end: 'bottom top',
          scrub: 1.25,
        },
      });

      gsap.to('.fire-hero__ash', {
        yPercent: 12,
        ease: 'none',
        scrollTrigger: {
          trigger: hero,
          start: 'top top',
          end: 'bottom top',
          scrub: 1.4,
        },
      });

      gsap.to('.fire-hero__heat', {
        yPercent: -8,
        scale: 1.08,
        ease: 'none',
        scrollTrigger: {
          trigger: hero,
          start: 'top top',
          end: 'bottom top',
          scrub: 1.1,
        },
      });

      gsap.to('.fire-hero__stage', {
        yPercent: -4,
        rotateX: 2,
        ease: 'none',
        scrollTrigger: {
          trigger: hero,
          start: 'top top',
          end: 'bottom top',
          scrub: 0.9,
        },
      });

      [
        { selector: '.fire-hero__product--rear', yPercent: -8 },
        { selector: '.fire-hero__product--main', yPercent: -5 },
        { selector: '.fire-hero__product--detail', yPercent: -12 },
        { selector: '.fire-hero__glass', yPercent: -10 },
      ].forEach(({ selector, yPercent }) => {
        gsap.to(selector, {
          yPercent,
          ease: 'none',
          scrollTrigger: {
            trigger: hero,
            start: 'top top',
            end: 'bottom top',
            scrub: 0.9,
          },
        });
      });
    }

    qsa('.fire-products__image, .fire-segments__image').forEach((frame) => {
      const image = frame.querySelector('img');
      if (!image) return;

      gsap.fromTo(image, {
        yPercent: -5,
        scale: 1.08,
      }, {
        yPercent: 5,
        scale: 1.14,
        ease: 'none',
        scrollTrigger: {
          trigger: frame,
          start: 'top bottom',
          end: 'bottom top',
          scrub: 0.9,
        },
      });
    });
  };

  const initCounters = (gsap) => {
    qsa('.js-count').forEach((counter) => {
      const target = Number(counter.dataset.count || counter.textContent);

      if (!gsap || isReducedMotion() || Number.isNaN(target)) {
        counter.textContent = Number.isNaN(target) ? counter.textContent : String(target);
        return;
      }

      const stateValue = { value: 0 };
      gsap.to(stateValue, {
        value: target,
        duration: 1.45,
        ease: 'power2.out',
        scrollTrigger: {
          trigger: counter,
          start: 'top 88%',
          once: true,
        },
        onUpdate: () => {
          counter.textContent = String(Math.round(stateValue.value));
        },
      });
    });
  };

  const initHoverEffects = (gsap) => {
    if (isReducedMotion() || !window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
      return;
    }

    const tiltTargets = [
      '.fire-service',
      '.fire-product-list article',
      '.fire-why__grid article',
      '.fire-testimonials blockquote',
      '.fire-contact__form',
    ].join(', ');

    qsa(tiltTargets).forEach((card) => {
      card.addEventListener('pointermove', (event) => {
        const rect = card.getBoundingClientRect();
        const x = (event.clientX - rect.left) / rect.width;
        const y = (event.clientY - rect.top) / rect.height;
        const depth = card.classList.contains('fire-service') ? 5 : 3;

        gsap.to(card, {
          rotationX: (0.5 - y) * depth,
          rotationY: (x - 0.5) * depth,
          y: -5,
          transformPerspective: 900,
          transformOrigin: 'center',
          duration: 0.35,
          ease: 'power2.out',
          overwrite: 'auto',
        });
      });

      card.addEventListener('pointerleave', () => {
        gsap.to(card, {
          rotationX: 0,
          rotationY: 0,
          y: 0,
          duration: 0.45,
          ease: 'power2.out',
          overwrite: 'auto',
        });
      });
    });

    qsa('.fire-btn').forEach((button) => {
      button.addEventListener('pointerenter', () => {
        gsap.to(button, { scale: 1.025, duration: 0.2, ease: 'power2.out' });
      });
      button.addEventListener('pointerleave', () => {
        gsap.to(button, { scale: 1, duration: 0.24, ease: 'power2.out' });
      });
    });

    const hero = document.querySelector('.fire-hero');
    const glow = hero?.querySelector('.fire-hero__glow');

    if (!hero || !glow) return;

    const glowX = gsap.quickTo(glow, 'x', { duration: 0.75, ease: 'power3.out' });
    const glowY = gsap.quickTo(glow, 'y', { duration: 0.75, ease: 'power3.out' });
    const depthLayers = qsa('[data-depth]', hero)
      .filter((layer) => !layer.classList.contains('fire-hero__product'))
      .map((layer) => ({
        depth: Number(layer.dataset.depth || 8),
        x: gsap.quickTo(layer, 'x', { duration: 0.65, ease: 'power3.out' }),
        y: gsap.quickTo(layer, 'y', { duration: 0.65, ease: 'power3.out' }),
      }));

    hero.addEventListener('pointermove', (event) => {
      const rect = hero.getBoundingClientRect();
      const x = (event.clientX - rect.left) / rect.width - 0.5;
      const y = (event.clientY - rect.top) / rect.height - 0.5;

      glowX(x * 34);
      glowY(y * 26);

      depthLayers.forEach((layer) => {
        layer.x(x * layer.depth);
        layer.y(y * layer.depth * 0.72);
      });
    }, { passive: true });
  };

  const initGsapAnimations = () => {
    if (isReducedMotion()) {
      showWithoutMotion();
      return;
    }

    if (!window.gsap || !window.ScrollTrigger) {
      initFallbackReveals();
      initCounters();
      return;
    }

    const { gsap, ScrollTrigger } = window;
    gsap.registerPlugin(ScrollTrigger);

    initHeroAnimations(gsap, ScrollTrigger);
    initScrollReveals(gsap, ScrollTrigger);
    initParallax(gsap, ScrollTrigger);
    initCounters(gsap);
    initHoverEffects(gsap);
  };

  const initFormData = () => {
    qsa('.wpcf7 form, .fallback-quote-form').forEach((form) => {
      const wrapper = form.closest('.js-lead-form') || form.closest('.wpcf7');
      const formType = wrapper?.dataset.formType || 'general';
      const serviceField = form.querySelector('.js-service-type select, select.js-service-type, select[name="servico"]');

      if (wrapper) {
        wrapper.dataset.formType = formType;
        wrapper.dataset.sourcePage = document.body.dataset.page || document.body.className;
      }

      const hiddenMap = {
        source_page: document.title,
        current_url: window.location.href,
        form_type: formType,
        campaign_source: new URLSearchParams(window.location.search).get('utm_source') || '',
      };

      Object.entries(hiddenMap).forEach(([name, value]) => {
        let input = form.querySelector(`input[name="${name}"]`);
        if (!input) {
          input = document.createElement('input');
          input.type = 'hidden';
          input.name = name;
          form.appendChild(input);
        }
        input.value = value;
      });

      if (serviceField && wrapper) {
        wrapper.dataset.service = serviceField.value || '';
        serviceField.addEventListener('change', () => {
          wrapper.dataset.service = serviceField.value || '';
        });
      }
    });

    document.addEventListener('wpcf7mailsent', (event) => {
      const form = event.target;
      const wrapper = form.closest('.js-lead-form') || form.closest('.wpcf7');
      const payload = {
        formId: event.detail.contactFormId,
        formType: wrapper?.dataset.formType || 'general',
        service: wrapper?.dataset.service || '',
        sourcePage: wrapper?.dataset.sourcePage || document.title,
      };

      window.dispatchEvent(new CustomEvent('xxx:lead_submitted', { detail: payload }));
      if (payload.formType === 'quote' || form.classList.contains('js-ai-quote-form')) {
        window.dispatchEvent(new CustomEvent('xxx:quote_requested', { detail: payload }));
      }
    });
  };

  const init = () => {
    initHeader();
    initMenu();
    initImageFallbacks();
    initGsapAnimations();
    initFormData();
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init, { once: true });
  } else {
    init();
  }
})();
