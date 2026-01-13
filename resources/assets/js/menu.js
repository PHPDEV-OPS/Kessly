/**
 * Menu Toggle Functionality
 */

'use strict';

// Toggle menu function
window.toggleMenu = function(event) {
  if (event) {
    event.preventDefault();
  }
  
  const layout = document.querySelector('.layout-wrapper');
  const overlay = document.querySelector('.layout-overlay');
  
  if (!layout) return;
  
  // Toggle menu open/close
  if (layout.classList.contains('layout-menu-expanded')) {
    layout.classList.remove('layout-menu-expanded');
    if (overlay) overlay.classList.remove('active');
  } else {
    layout.classList.add('layout-menu-expanded');
    if (overlay) overlay.classList.add('active');
  }
};

// Close menu when clicking overlay
document.addEventListener('DOMContentLoaded', function() {
  const overlay = document.querySelector('.layout-overlay');
  
  if (overlay) {
    overlay.addEventListener('click', function() {
      const layout = document.querySelector('.layout-wrapper');
      if (layout) {
        layout.classList.remove('layout-menu-expanded');
        overlay.classList.remove('active');
      }
    });
  }
  
  // Close menu on mobile when clicking a menu item
  const menuLinks = document.querySelectorAll('.menu-item .menu-link');
  menuLinks.forEach(link => {
    link.addEventListener('click', function() {
      if (window.innerWidth < 1200) {
        const layout = document.querySelector('.layout-wrapper');
        const overlay = document.querySelector('.layout-overlay');
        
        if (layout) layout.classList.remove('layout-menu-expanded');
        if (overlay) overlay.classList.remove('active');
      }
    });
  });
});
