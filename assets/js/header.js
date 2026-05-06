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
    const header = document.querySelector('[data-premium-header]');

    if (!header) {
      return;
    }

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const hasGsap = typeof window.gsap !== 'undefined';
    const gsap = hasGsap ? window.gsap : null;
    const overlay = document.querySelector('[data-site-overlay]');
    const miniCart = document.querySelector('[data-mini-cart]');
    const mobileDrawer = document.querySelector('[data-mobile-drawer]');
    const cartToggles = Array.from(document.querySelectorAll('[data-cart-toggle]'));
    const cartClose = document.querySelector('[data-cart-close]');
    const menuToggle = document.querySelector('[data-menu-toggle]');
    const menuClose = document.querySelector('[data-menu-close]');

    const show = (element) => {
      if (!element) return;
      element.hidden = false;
    };

    const hide = (element) => {
      if (!element) return;
      element.hidden = true;
    };

    const setOverlay = (visible) => {
      if (!overlay) return;
      if (visible) show(overlay);
      if (gsap && !reducedMotion) {
        gsap.to(overlay, {
          autoAlpha: visible ? 1 : 0,
          duration: 0.24,
          ease: 'power2.out',
          onComplete: () => {
            if (!visible) hide(overlay);
          },
        });
      } else {
        overlay.style.opacity = visible ? '1' : '0';
        if (!visible) hide(overlay);
      }
    };

    const animatePanel = (panel, open, direction) => {
      if (!panel) return;
      const inner = panel.firstElementChild;
      if (open) {
        panel.setAttribute('aria-hidden', 'false');
      }

      if (gsap && !reducedMotion && inner) {
        gsap.to(inner, {
          x: open ? 0 : direction,
          autoAlpha: open ? 1 : 0,
          duration: open ? 0.42 : 0.28,
          ease: open ? 'power3.out' : 'power2.in',
          onComplete: () => {
            if (!open) panel.setAttribute('aria-hidden', 'true');
          },
        });
      } else if (!open) {
        panel.setAttribute('aria-hidden', 'true');
      }
    };

    const closeCart = () => {
      document.body.classList.remove('xxx-cart-open');
      cartToggles.forEach((toggle) => toggle.setAttribute('aria-expanded', 'false'));
      animatePanel(miniCart, false, 36);
      if (!document.body.classList.contains('xxx-nav-open')) setOverlay(false);
    };

    const closeMenu = () => {
      document.body.classList.remove('xxx-nav-open');
      if (menuToggle) menuToggle.setAttribute('aria-expanded', 'false');
      animatePanel(mobileDrawer, false, -36);
      if (!document.body.classList.contains('xxx-cart-open')) setOverlay(false);
    };

    const openCart = () => {
      closeMenu();
      document.body.classList.add('xxx-cart-open');
      cartToggles.forEach((toggle) => toggle.setAttribute('aria-expanded', 'true'));
      setOverlay(true);
      animatePanel(miniCart, true, 0);
    };

    const openMenu = () => {
      closeCart();
      document.body.classList.add('xxx-nav-open');
      if (menuToggle) menuToggle.setAttribute('aria-expanded', 'true');
      setOverlay(true);
      animatePanel(mobileDrawer, true, 0);
    };

    if (gsap && !reducedMotion) {
      gsap.set([overlay, miniCart && miniCart.firstElementChild, mobileDrawer && mobileDrawer.firstElementChild].filter(Boolean), { autoAlpha: 0 });
      gsap.from(header, { y: -22, autoAlpha: 0, duration: 0.62, ease: 'power3.out' });
    }

    const syncHeader = () => {
      header.classList.toggle('scrolled', window.scrollY > 18);
    };
    syncHeader();
    window.addEventListener('scroll', syncHeader, { passive: true });

    cartToggles.forEach((toggle) => {
      toggle.addEventListener('click', () => {
        if (document.body.classList.contains('xxx-cart-open')) {
          closeCart();
        } else {
          openCart();
        }
      });
    });

    if (cartClose) cartClose.addEventListener('click', closeCart);
    if (menuToggle) {
      menuToggle.addEventListener('click', () => {
        if (document.body.classList.contains('xxx-nav-open')) {
          closeMenu();
        } else {
          openMenu();
        }
      });
    }
    if (menuClose) menuClose.addEventListener('click', closeMenu);
    if (overlay) {
      overlay.addEventListener('click', () => {
        closeCart();
        closeMenu();
      });
    }

    document.addEventListener('keyup', (event) => {
      if (event.key === 'Escape') {
        closeCart();
        closeMenu();
      }
    });

    document.querySelectorAll('.xxx-mobile-navigation .menu-item-has-children').forEach((item) => {
      const button = document.createElement('button');
      button.type = 'button';
      button.className = 'xxx-mobile-sub-toggle';
      button.setAttribute('aria-label', 'Abrir submenu');
      item.appendChild(button);
      button.addEventListener('click', () => {
        item.classList.toggle('is-open');
      });
    });

    if (window.jQuery) {
      window.jQuery(document.body).on('added_to_cart removed_from_cart wc_fragments_refreshed', () => {
        const count = document.querySelector('[data-cart-count]');
        if (count && gsap && !reducedMotion) {
          gsap.fromTo(count, { scale: 0.72 }, { scale: 1, duration: 0.38, ease: 'back.out(2)' });
        }
      });
    }
  });
})();
