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
    gsap.set('.premium-hero .hero-copy > *', { autoAlpha: 0, y: 24 });
    gsap.set('.hero-media-wrap', { autoAlpha: 0, x: 28, scale: 0.97 });

    const heroTimeline = gsap.timeline({ defaults: { ease: 'power3.out' } });
    heroTimeline
      .to('.premium-hero .hero-copy > *', {
        autoAlpha: 1,
        y: 0,
        duration: 0.75,
        stagger: 0.09
      })
      .to('.hero-media-wrap', {
        autoAlpha: 1,
        x: 0,
        scale: 1,
        duration: 0.9
      }, '-=0.55');

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

    gsap.utils.toArray('.card-grid, .reason-grid, .product-grid, .steps-grid').forEach((grid) => {
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
