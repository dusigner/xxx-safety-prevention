(function () {
  const header = document.getElementById('site-header');
  const menuToggle = document.querySelector('.mobile-menu-toggle');
  const menu = document.querySelector('.main-navigation');
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  const toggleHeader = () => {
    if (!header) return;
    header.classList.toggle('scrolled', window.scrollY > 20);
  };

  const closeMenu = () => {
    if (!menu || !menuToggle) return;
    menu.classList.remove('is-open');
    menuToggle.setAttribute('aria-expanded', 'false');
  };

  const showWithoutMotion = () => {
    document.querySelectorAll('.xxx-animate').forEach((node) => node.classList.add('is-visible'));
  };

  const setupFallbackAnimations = () => {
    if (!('IntersectionObserver' in window)) {
      showWithoutMotion();
      return;
    }

    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          obs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.16, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.xxx-animate').forEach((node) => observer.observe(node));
  };

  const setupGsapAnimations = () => {
    if (reduceMotion || document.body.classList.contains('xxx-reduced-motion')) {
      showWithoutMotion();
      return;
    }

    const gsapAvailable = window.gsap && window.ScrollTrigger;
    if (!gsapAvailable) {
      setupFallbackAnimations();
      return;
    }

    const { gsap, ScrollTrigger } = window;
    gsap.registerPlugin(ScrollTrigger);

    gsap.set('.xxx-animate', { autoAlpha: 0, y: 28 });
    gsap.set('.premium-hero .hero-copy > *, .fire-hero__copy > *', { autoAlpha: 0, y: 28 });
    gsap.set('.hero-media-wrap, .hero-visual-stack, .fire-hero__visual', { autoAlpha: 0, x: 34, scale: 0.96 });
    gsap.set('.hero-floating-card', { autoAlpha: 0, y: 18, scale: 0.96 });

    const heroTimeline = gsap.timeline({ defaults: { ease: 'power3.out' } });
    heroTimeline
      .to('.premium-hero .hero-copy > *, .fire-hero__copy > *', {
        autoAlpha: 1,
        y: 0,
        duration: 0.75,
        stagger: 0.09
      })
      .to('.hero-media-wrap, .hero-visual-stack, .fire-hero__visual', {
        autoAlpha: 1,
        x: 0,
        scale: 1,
        duration: 0.9
      }, '-=0.55')
      .to('.hero-floating-card', {
        autoAlpha: 1,
        y: 0,
        scale: 1,
        duration: 0.52,
        stagger: 0.08
      }, '-=0.35');

    gsap.utils.toArray('.xxx-animate').forEach((node) => {
      gsap.to(node, {
        autoAlpha: 1,
        y: 0,
        duration: 0.68,
        ease: 'power3.out',
        scrollTrigger: {
          trigger: node,
          start: 'top 84%',
          once: true
        }
      });
    });

    gsap.utils.toArray('.card-grid, .reason-grid, .product-grid, .steps-grid, .service-showcase-grid, .product-cards, .testimonial-layout, .segment-cards, .timeline-steps, .fire-services__grid, .fire-product-list, .fire-process__steps, .fire-why__grid, .fire-testimonials__grid, .fire-trust__grid').forEach((grid) => {
      const items = grid.children;
      if (!items.length) return;

      gsap.fromTo(items, {
        autoAlpha: 0,
        y: 26
      }, {
        autoAlpha: 1,
        y: 0,
        duration: 0.62,
        stagger: 0.08,
        ease: 'power3.out',
        scrollTrigger: {
          trigger: grid,
          start: 'top 82%',
          once: true
        }
      });
    });

    gsap.to('.hero-fire', {
      yPercent: 12,
      scale: 1.08,
      ease: 'none',
      scrollTrigger: {
        trigger: '.premium-hero',
        start: 'top top',
        end: 'bottom top',
        scrub: 0.7
      }
    });

    gsap.to('.hero-smoke--one', {
      yPercent: -8,
      xPercent: 3,
      ease: 'none',
      scrollTrigger: {
        trigger: '.premium-hero',
        start: 'top top',
        end: 'bottom top',
        scrub: 0.9
      }
    });

    gsap.to('.hero-smoke--two', {
      yPercent: 10,
      xPercent: -4,
      ease: 'none',
      scrollTrigger: {
        trigger: '.premium-hero',
        start: 'top top',
        end: 'bottom top',
        scrub: 1
      }
    });

    gsap.to('.hero-particles', {
      yPercent: 18,
      ease: 'none',
      scrollTrigger: {
        trigger: '.premium-hero',
        start: 'top top',
        end: 'bottom top',
        scrub: 1.2
      }
    });

    gsap.to('.fire-hero__smoke--a', {
      yPercent: -8,
      xPercent: 4,
      ease: 'none',
      scrollTrigger: {
        trigger: '.fire-hero',
        start: 'top top',
        end: 'bottom top',
        scrub: 1
      }
    });

    gsap.to('.fire-hero__smoke--b', {
      yPercent: 10,
      xPercent: -5,
      ease: 'none',
      scrollTrigger: {
        trigger: '.fire-hero',
        start: 'top top',
        end: 'bottom top',
        scrub: 1.1
      }
    });

    gsap.to('.fire-hero__sparks', {
      yPercent: 16,
      ease: 'none',
      scrollTrigger: {
        trigger: '.fire-hero',
        start: 'top top',
        end: 'bottom top',
        scrub: 1.3
      }
    });

    gsap.to('.fire-hero__visual img', {
      y: -34,
      ease: 'none',
      scrollTrigger: {
        trigger: '.fire-hero',
        start: 'top top',
        end: 'bottom top',
        scrub: 0.9
      }
    });

    gsap.to('.hero-media', {
      y: -28,
      ease: 'none',
      scrollTrigger: {
        trigger: '.premium-hero',
        start: 'top top',
        end: 'bottom top',
        scrub: 0.8
      }
    });

    gsap.utils.toArray('.image-card, .service-cinema-card, .product-cinema-card, .fire-service, .fire-products__image, .fire-segments__image').forEach((card) => {
      const image = card.querySelector('img');
      if (!image) return;

      gsap.fromTo(image, {
        scale: 1.08,
        yPercent: 4
      }, {
        scale: 1,
        yPercent: 0,
        duration: 1.1,
        ease: 'power3.out',
        scrollTrigger: {
          trigger: card,
          start: 'top 86%',
          once: true
        }
      });
    });

    gsap.utils.toArray('.js-count').forEach((counter) => {
      const target = Number(counter.dataset.count || counter.textContent);
      const state = { value: 0 };

      gsap.to(state, {
        value: target,
        duration: 1.4,
        ease: 'power2.out',
        scrollTrigger: {
          trigger: counter,
          start: 'top 88%',
          once: true
        },
        onUpdate: () => {
          counter.textContent = Math.round(state.value);
        }
      });
    });
  };

  const setupFormData = () => {
    document.querySelectorAll('.wpcf7 form, .fallback-quote-form').forEach((form) => {
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
        campaign_source: new URLSearchParams(window.location.search).get('utm_source') || ''
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

  toggleHeader();
  window.addEventListener('scroll', toggleHeader, { passive: true });

  if (menuToggle && menu) {
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
  }

  setupGsapAnimations();
  setupFormData();
})();
