const removeBodyOverlay = ($) => {
  'use strict';

  const hamburger = $('.hamburger');
  const navMobile = $('.nav-mobile');
  const searchButton = $('.header-search .header-search__button');

  $('.body-overlay').click(function (e) {
    e.preventDefault();

    // remove body overlay
    $('.body-overlay').removeClass('body-overlay--is-active');
    $('.site-header').removeClass('header-search--is-active');

    if ($('.header-search__form-wrap').hasClass('header-search--is-open')) {
      $('.header-search__form-wrap').removeClass('header-search--is-open');
    }

    // Remove mobile menu
    if (navMobile.hasClass('nav-mobile--open')) {
      navMobile.removeClass('nav-mobile--open');
      hamburger.removeClass('active');
    }

    // Remove search button active state
    if (searchButton.hasClass('active')) {
      searchButton.removeClass('active');
    }

    // Close any open submenus.
    $('.menu__item--has-children > a').removeClass('menu__link--is-active').next().removeClass('menu__sub-menu--is-visible');
  });
};

export default removeBodyOverlay;
