/**
 * Toggle the mobile navigation on hamburger click.
 */
const toggleMobileNavigation = ($) => {
  'use strict';

  const hamburger = $('.hamburger');

  hamburger.click(function () {
    $('.nav-mobile').toggleClass('nav-mobile--open');
    hamburger.toggleClass('active');

    // Remove / add body overlay
    if ($('.nav-mobile').hasClass('nav-mobile--open')) {
      $('.body-overlay').addClass('body-overlay--is-active');
    } else {
      $('.body-overlay').removeClass('body-overlay--is-active');
    }

    // Remove search if visible
    $('.header-search__form-wrap').removeClass('header-search--is-open');
    $('.header-search .header-search__button').removeClass('active');
    $('.header-search__field').blur();
  });

  hamburger.mousedown(function (e) {
    e.preventDefault();
  });
};

export default toggleMobileNavigation;
