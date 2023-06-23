const toggleSearch = ($) => {
  'use strict';

  $('.header-search__form-wrap').removeClass('header-search--is-open');

  const searchButton = $('.header-search .header-search__button');

  searchButton.click(function (e) {
    e.preventDefault();

    let toOpen = true;

    if ($('.header-search__form-wrap').hasClass('header-search--is-open')) {
      toOpen = false;
    }

    // Remove class active from search icon
    searchButton.removeClass('active');

    // Remove class active from hamburger
    $('.hamburger').removeClass('active');

    // remove mobile menu
    if ($('.nav-mobile').hasClass('nav-mobile--open')) {
      $('.nav-mobile').removeClass('nav-mobile--open');
    }

    // remove body overlay
    $('.body-overlay').removeClass('body-overlay--is-active');
    $('.site-header').removeClass('header-search--is-active');

    // remove body overlay
    $('.body-overlay').removeClass('body-overlay--is-active');
    $('.site-header').removeClass('header-search--is-active');

    // close search field
    $('.header-search__form-wrap').removeClass('header-search--is-open');
    $('.header-search__field').blur();

    // Open if needed.
    if (toOpen) {
      $('.header-search__form-wrap').toggleClass('header-search--is-open');

      $('.header-search__field').focus();

      // Add class active to search icon
      searchButton.addClass('active');

      // add body overlay
      $('.body-overlay').toggleClass('body-overlay--is-active');
      $('.site-header').toggleClass('header-search--is-active');
      $('.site-header').removeClass('header--fade-out-background');

      // Close any open submenus.
      $('.menu__item--has-children > a').removeClass('menu__link--is-active').next().removeClass('menu__sub-menu--is-visible');
    }
  });
};

export default toggleSearch;
