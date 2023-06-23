/**
 * Stop scroll of main body when swiping on mobile navigation.
 */
const handleMobileNavigationScroll = ($) => {
  'use strict';

  const navMobile = $('nav-mobile').first();
  let overflow;

  $(window).on('load resize', function () {
    overflow = navMobile.scrollHeight - $('#fixed').height();
  });

  navMobile.on('touchmove', function () {
    if (overflow) {
      return true;
    }

    return false;
  });
};

export default handleMobileNavigationScroll;
