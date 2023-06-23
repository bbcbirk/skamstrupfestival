/**
 * Toggle submenus in the main menu.
 */
const toggleSubMenu = ($) => {
  'use strict';

  $('.menu__item--has-children > a, .menu-secondary__item--has-children > a').click(function (e) {
    e.preventDefault();

    let toOpen = true;

    // If this submenu is already open we just need to close any open submenus.
    if ($(this).hasClass('menu__link--is-active')) {
      toOpen = false;
    }

    // Close any open submenus.
    $('.menu__item--has-children > a, .menu-secondary__item--has-children > a').removeClass('menu__link--is-active').next().removeClass('menu__sub-menu--is-visible');

    // remove body overlay
    $('.body-overlay').removeClass('body-overlay--is-active');
    $('.menu-secondary__item--has-children').toggleClass('menu-secondary__item--has-children--is-active');

    // Open if needed.
    if (toOpen) {
      $(this).toggleClass('menu__link--is-active');
      $(this).next().toggleClass('menu__sub-menu--is-visible');

      // add body overlay
      $('.body-overlay').toggleClass('body-overlay--is-active');

      // close search field
      $('.header-search__form-wrap').removeClass('header-search--is-open');
      $('.header-search .header-search__button').removeClass('active');
    }
  });
};

export default toggleSubMenu;
