import handleMobileNavigationScroll from '../components/header/handle-mobile-navigation-scroll';
import headerStickyMenu from '../components/header/header-sticky-menu';
import removeBodyOverlay from '../components/header/remove-body-overlay';
import toggleMobileNavigation from '../components/header/toggle-mobile-navigation';
import toggleMobileSubMenu from '../components/header/toggle-mobile-sub-menu';
import toggleSearch from '../components/header/toggle-search';
import toggleSubMenu from '../components/header/toggle-sub-menu';
import heroVideoSettings from '../components/hero/hero-video-settings';
import handlers from '../basic/handlers';

export const init = (event) => {
  /**
   * Wrap all initialized code in anonymous function and pass jQuery as an argument.
   * jQuery is defined as being globally available in the `eslintrc` configuration.
   * The correct order of enqueueing the javascript assets is handled in the `enqueue.php` file of the theme.
   */
  (($) => {
    DEBUG &&
      console.log({
        msg: 'init.js has loaded.',
      });

    /**
     * define default theme colors as empty object
     */
    const skamstrupfestivalSettings = {};

    if (typeof window?.skamstrupfestivalSettings?.colors === 'object') {
      skamstrupfestivalSettings.colors = window.skamstrupfestivalSettings.colors;
    }

    DEBUG &&
      console.log({
        msg: 'skamstrupfestivalSettings are loaded.',
        skamstrupfestivalSettings: skamstrupfestivalSettings,
      });

    /**
     * Ensure that jQuery is loaded, before running the scripts that depend on it.
     */
    if (typeof $ === 'function') {
      DEBUG &&
        console.log({
          msg: 'jquery@' + ($.fn && $.fn.jquery && $.fn.jquery) + ' is loaded.',
          $: $,
          version: $.fn && $.fn.jquery && $.fn.jquery,
        });

      // run theme scripts
      handlers($);
      handleMobileNavigationScroll($);
      headerStickyMenu($);
      removeBodyOverlay($);
      toggleMobileNavigation($);
      toggleMobileSubMenu($);
      toggleSearch($);
      toggleSubMenu($);

      // Hero
      if ($('.hero.hero--with-video').length) {
        heroVideoSettings();
      }
    }
  })(jQuery);
};

export default init;
