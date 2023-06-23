const toggleMobileSubMenu = ($) => {
  'use strict';

  const menuParent = $('.menu-mobile__item--has-children');

  if (menuParent.hasClass('menu-mobile__item--current-ancestor')) {
    $('.menu-mobile__item--current-ancestor').addClass('menu-mobile__item--has-children--is-active');
  }

  menuParent.children('a').click(function (e) {
    e.preventDefault();

    const classActive = $(this).parent().hasClass('menu-mobile__item--has-children--is-active');

    menuParent.removeClass('menu-mobile__item--has-children--is-active');
    menuParent.children('.menu-mobile__sub-menu').slideUp(100);

    if (!classActive) {
      $(this).parent().addClass('menu-mobile__item--has-children--is-active');
      $('.menu-mobile__sub-menu', $(this).parent()).slideDown(100);
    }
  });
};

export default toggleMobileSubMenu;
