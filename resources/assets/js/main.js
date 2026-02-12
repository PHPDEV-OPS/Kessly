/**
 * Main
 */

'use strict';

let menu, animate;

(function () {
  // Initialize user agent style
  document.addEventListener('DOMContentLoaded', function () {
    if (navigator.userAgent.match(/iPhone|iPad|iPod/i)) {
      document.body.classList.add('ios');
    }
  });

  // Accordion active class
  const accordionActiveFunction = function (e) {
    if (e.type == 'show.bs.collapse' || e.type == 'show.bs.collapse') {
      e.target.closest('.accordion-item').classList.add('active');
      e.target.closest('.accordion-item').previousElementSibling?.classList.add('previous-active');
    } else {
      e.target.closest('.accordion-item').classList.remove('active');
      e.target.closest('.accordion-item').previousElementSibling?.classList.remove('previous-active');
    }
  };

  const initWaves = () => {
    if (typeof Waves !== 'undefined') {
      Waves.init();
      Waves.attach(".btn[class*='btn-']:not(.position-relative):not([class*='btn-outline-'])", ['waves-light']);
      Waves.attach("[class*='btn-outline-']:not(.position-relative)");
      Waves.attach('.pagination .page-item .page-link');
      Waves.attach('.dropdown-menu .dropdown-item');
      Waves.attach('[data-bs-theme="light"] .list-group .list-group-item-action');
      Waves.attach('.nav-tabs:not(.nav-tabs-widget) .nav-item .nav-link');
      Waves.attach('.nav-pills .nav-item .nav-link', ['waves-light']);
    }
  };

  const toggleHandler = (event) => {
    event.preventDefault();
    window.Helpers.toggleCollapsed();
  };

  const initMenu = () => {
    // Initialize menu
    let layoutMenuEl = document.querySelectorAll('#layout-menu');
    layoutMenuEl.forEach(function (element) {
      if(element.menuInstance) {
        element.menuInstance.destroy(); 
      }
      menu = new Menu(element, {
        orientation: 'vertical',
        closeChildren: false
      });
      // Change parameter to true if you want scroll animation
      window.Helpers.scrollToActive((animate = false));
      window.Helpers.mainMenu = menu;
    });

    // Initialize menu togglers and bind click on each
    let menuToggler = document.querySelectorAll('.layout-menu-toggle');
    menuToggler.forEach(item => {
      item.removeEventListener('click', toggleHandler); 
      item.addEventListener('click', toggleHandler);
    });
  };

  const initMenuToggleHover = () => {
    let delay = function (elem, callback) {
      let timeout = null;
      elem.onmouseenter = function () {
        if (!window.Helpers.isSmallScreen()) {
          timeout = setTimeout(callback, 300);
        } else {
          timeout = setTimeout(callback, 0);
        }
      };

      elem.onmouseleave = function () {
        let toggle = document.querySelector('.layout-menu-toggle');
        if(toggle) toggle.classList.remove('d-block');
        clearTimeout(timeout);
      };
    };

    if (document.getElementById('layout-menu')) {
      delay(document.getElementById('layout-menu'), function () {
        if (!window.Helpers.isSmallScreen()) {
          let toggle = document.querySelector('.layout-menu-toggle');
          if(toggle) toggle.classList.add('d-block');
        }
      });
    }
  };

  const initScrollShadow = () => {
    let menuInnerContainer = document.getElementsByClassName('menu-inner'),
      menuInnerShadow = document.getElementsByClassName('menu-inner-shadow')[0];
    if (menuInnerContainer.length > 0 && menuInnerShadow) {
      menuInnerContainer[0].addEventListener('ps-scroll-y', function () {
        if (this.querySelector('.ps__thumb-y').offsetTop) {
          menuInnerShadow.style.display = 'block';
        } else {
          menuInnerShadow.style.display = 'none';
        }
      });
    }
  };

  const initMisc = () => {
    initScrollShadow();

    // Init BS Tooltip
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Accordion active class
    const accordionList = [].slice.call(document.querySelectorAll('.accordion'));
    accordionList.map(function (accordionEl) {
      accordionEl.removeEventListener('show.bs.collapse', accordionActiveFunction);
      accordionEl.removeEventListener('hide.bs.collapse', accordionActiveFunction);
      accordionEl.addEventListener('show.bs.collapse', accordionActiveFunction);
      accordionEl.addEventListener('hide.bs.collapse', accordionActiveFunction);
    });

    // Auto update layout based on screen size
    if (window.Helpers) {
      window.Helpers.setAutoUpdate(true);
      window.Helpers.initPasswordToggle();
      window.Helpers.initSpeechToText();
    }
  };

  const init = () => {
    initWaves();
    initMenu();
    initMenuToggleHover();
    initMisc();

    // Manage menu expanded/collapsed logic
    if (window.Helpers && !window.Helpers.isSmallScreen()) {
        // We comment this out because it might force collapse on navigation.
        // If the user wants to persist the sidebar state, they should rely on the state 
        // stored in localStorage or the cookie by the template customizer.
        // window.Helpers.setCollapsed(true, false);
    }
  };

  // Initial Run
  init();

  // Livewire Support
  document.addEventListener('livewire:navigated', () => {
    init();
  });

})();
