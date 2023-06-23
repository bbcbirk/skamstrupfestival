/**
 * js
 */
require('../../js/base');

/**
 * css
 */
require('../../css/base.css');

/*
 * Static assets chunk
 */
const resolvers = {};
resolvers.index = function (cb) {
  'use strict';

  require.ensure([], function () {
    // fonts
    const fontsContext = cb(require.context('../../fonts', true, /\.(woff(2)?|ttf|otf|eot|svg)$/));
    if (fontsContext.length >= 0) {
      fontsContext.keys().forEach(function (key) {
        fontsContext(key);
      });
    }

    // img
    const imgContext = cb(require.context('../../img', true, /\.(png|gif|jpe?g|svg)$/));
    if (imgContext.length >= 0) {
      imgContext.keys().forEach(function (key) {
        imgContext(key);
      });
    }
  });
};
