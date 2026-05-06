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

  const setupAnimations = () => {
    if (reduceMotion || document.body.classList.contains('xxx-reduced-motion')) {
      document.querySelectorAll('.xxx-animate').forEach((node) => node.classList.add('is-visible'));
      return;
    }

    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          obs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.15, rootMargin: '0px 0px -30px 0px' });

    document.querySelectorAll('.xxx-animate').forEach((node) => observer.observe(node));
  };

  const setupFormData = () => {
    document.querySelectorAll('.wpcf7 form').forEach((form) => {
      const wrapper = form.closest('.js-lead-form') || form.closest('.wpcf7');
      const formType = wrapper?.dataset.formType || 'general';
      const serviceField = form.querySelector('.js-service-type select, select.js-service-type');

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

  setupAnimations();
  setupFormData();
})();
