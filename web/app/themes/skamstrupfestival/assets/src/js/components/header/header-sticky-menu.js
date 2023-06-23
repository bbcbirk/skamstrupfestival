/**
 * Plugin for sticky menu on scroll up.
 * Based on https://osvaldas.info/examples/auto-hide-sticky-header/?reactive-plus.
 */
export const headerStickyMenu = ($) => {
  'use strict';

  const elSelector = '.site-header';
  const elClassScroll = 'site-header--scrolling';
  const elClassScrollUp = 'site-header--scrolling-up';
  const elClassScrollDown = 'site-header--scrolling-down';
  const elClassScrollPastHeader = 'site-header--scrolling-past-header';
  const $element = $(elSelector);
  const $header = $(elSelector);
  const $window = $(window);
  let elHeaderHeight = 0;

  if ($header) {
    elHeaderHeight = $header.height();
  }

  if (!$element.length) {
    return true;
  }

  if ($window.scrollTop() !== 0) {
    $element.addClass('header--has-background');
  }

  let elHeight = 0;
  let elTop = 0;
  let wScrollCurrent = 0;
  let wScrollBefore = 0;
  let wScrollDiff = 0;
  let pageTop = 0;

  function headerHasAdminbar() {
    if ($('body').hasClass('admin-bar')) {
      const adminbarHeight = $('#wpadminbar').height();

      elTop = adminbarHeight;
      pageTop = adminbarHeight;
    }
  }

  $(document).ready(function () {
    headerHasAdminbar();
  });
  $(window).on('resize', headerHasAdminbar);

  $element.toggleClass('is-scrolling-over-post-content', $('.hero').length > 0 && $window.scrollTop() > $('.hero').offset().top + $('.hero').height() - elHeaderHeight);
  $element.toggleClass('is-scrolling-over-post-content', $('.post-header').length > 0 && $window.scrollTop() > $('.post-header').offset().top + $('.post-header').height() - elHeaderHeight);

  $window.on('scroll', function () {
    elHeight = $element.outerHeight();
    wScrollCurrent = $window.scrollTop();
    wScrollDiff = wScrollBefore - wScrollCurrent; // scroll difference. Negative if scrolled down, positive if scrolled up
    elTop = parseInt($element.css('top')) + wScrollDiff; // current position plus scroll change

    $element.toggleClass(elClassScroll, wScrollCurrent > 0); // toggles scrolling classname
    $element.toggleClass(elClassScrollUp, wScrollCurrent > 0 && wScrollDiff > 0); // toggles scrolling up classname
    $element.toggleClass(elClassScrollDown, wScrollDiff < 0); // toggles scrolling down classname
    $element.toggleClass(elClassScrollPastHeader, wScrollCurrent > elHeaderHeight); // toggles scrolling past header classname
    $element.toggleClass('is-scrolling-over-post-content', $('.hero').length > 0 && wScrollCurrent > $('.hero').offset().top + $('.hero').height() - elHeaderHeight);
    $element.toggleClass('is-scrolling-over-post-content', $('.post-header').length > 0 && wScrollCurrent > $('.post-header').offset().top + $('.post-header').height() - elHeaderHeight);

    if (wScrollDiff < 0 && wScrollCurrent > elHeaderHeight) {
      if ($element.find('.menu__sub-menu') && $element.find('.menu__sub-menu--is-visible')) {
        // remove body overlay
        $('.body-overlay').removeClass('body-overlay--is-active');
        $('.site-header').removeClass('header-search--is-active');
        // Close any open submenus.
        $('.menu__item--has-children > a').removeClass('menu__link--is-active').next().removeClass('menu__sub-menu--is-visible');
      }
    }

    if (wScrollCurrent <= 0) {
      $element.css('top', pageTop); // scrolled to the very top; element sticks to the top
      $element.removeClass('header--has-background');
      $element.addClass('header--fade-out-background');
    } else if (wScrollDiff > 0) {
      $element.css('top', elTop > pageTop ? pageTop : elTop); // scrolled up; element slides in
      $element.addClass('header--has-background');
      $element.removeClass('header--fade-out-background');
      $('.site-header').removeClass('header-search--is-active');
      $('.header-search__field').blur();
      $('.header-search .header-search__button').removeClass('active');
      $('.header-search__form-wrap').removeClass('header-search--is-open');
    } else if (wScrollDiff < 0) {
      $element.css('top', Math.abs(elTop) > elHeight ? -elHeight : elTop); // scrolled down; element slides out
      $element.removeClass('header--has-background');
      $('.site-header').removeClass('header-search--is-active');
      $('.header-search__field').blur();
      $('.header-search .header-search__button').removeClass('active');
      $('.header-search__form-wrap').removeClass('header-search--is-open');
    }

    wScrollBefore = wScrollCurrent;
  });
};

export default headerStickyMenu;
