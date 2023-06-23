module.exports = (env, argv) => {
  const scripts = require('./rules/scripts')(env, argv);
  const styles = require('./rules/styles')(env, argv);
  const fonts = require('./rules/fonts')(env, argv);
  const images = require('./rules/images')(env, argv);
  const icons = require('./rules/icons')(env, argv);
  const inlineIcons = require('./rules/inline-icons')(env, argv);

  const webpackModule = {};

  webpackModule.rules = [];

  webpackModule.rules = [...scripts, ...styles, ...fonts, ...images, ...icons, ...inlineIcons];

  return webpackModule;
};
