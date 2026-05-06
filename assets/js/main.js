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

    const words = splitHeroTitle();
    const title = hero.querySelector('#hero-title');
    const kicker = hero.querySelector('.fire-kicker');
    const lead = hero.querySelector('.fire-hero__lead');
    const actions = qsa('.fire-hero__actions .fire-btn', hero);
    const badges = qsa('.fire-hero__badges span', hero);
    const visual = hero.querySelector('.fire-hero__visual');
    const visualImage = hero.querySelector('.fire-hero__visual img');
    const seal = hero.querySelector('.fire-hero__seal');
    const metrics = qsa('.fire-hero__metrics > div', hero);
    const atmosphere = qsa('.fire-hero__smoke, .fire-hero__sparks, .fire-hero__glow', hero);
    const halo = hero.querySelector('.fire-hero__halo');

    gsap.set(atmosphere, { autoAlpha: 0 });
    gsap.set([kicker, lead].filter(Boolean), { autoAlpha: 0, y: 26 });
    gsap.set(words.length ? words : title, { autoAlpha: 0, y: 34, rotateX: -12 });
    gsap.set(actions, { autoAlpha: 0, y: 22, scale: 0.96 });
    gsap.set(badges, { autoAlpha: 0, y: 16, scale: 0.94 });
    gsap.set(visual, { autoAlpha: 0, x: 54, y: 24, scale: 0.92, rotate: 1.5 });
    gsap.set(visualImage, { transformOrigin: '50% 70%' });
    gsap.set([seal, ...metrics].filter(Boolean), { autoAlpha: 0, y: 24, scale: 0.96 });
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
        rotate: 0,
        duration: 0.95,
      }, '-=1.15')
      .to(seal, {
        autoAlpha: 1,
        y: 0,
        scale: 1,
        duration: 0.56,
      }, '-=0.36')
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

      gsap.to('.fire-hero__visual img', {
        y: -36,
        ease: 'none',
        scrollTrigger: {
          trigger: hero,
          start: 'top top',
          end: 'bottom top',
          scrub: 0.9,
        },
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
    const halo = hero?.querySelector('.fire-hero__halo');

    if (!hero || !glow || !halo) return;

    const glowX = gsap.quickTo(glow, 'x', { duration: 0.75, ease: 'power3.out' });
    const glowY = gsap.quickTo(glow, 'y', { duration: 0.75, ease: 'power3.out' });
    const haloX = gsap.quickTo(halo, 'x', { duration: 0.6, ease: 'power3.out' });
    const haloY = gsap.quickTo(halo, 'y', { duration: 0.6, ease: 'power3.out' });

    hero.addEventListener('pointermove', (event) => {
      const rect = hero.getBoundingClientRect();
      const x = (event.clientX - rect.left) / rect.width - 0.5;
      const y = (event.clientY - rect.top) / rect.height - 0.5;

      glowX(x * 34);
      glowY(y * 26);
      haloX(x * 20);
      haloY(y * 16);
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
