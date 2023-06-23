module.exports = (env, argv) => {
  const MiniCssExtractPlugin = require('mini-css-extract-plugin');
  const SvgSpritePlugin = require('svg-sprite-loader/plugin');
  const StylelintPlugin = require('stylelint-webpack-plugin');
  const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
  const ESLintPlugin = require('eslint-webpack-plugin');
  const webpack = require('webpack');

  const DEBUG = process && process.env && process.env.DEBUG ? process.env.DEBUG : '';
  const SERVE = env && env.SERVE ? env.SERVE : '';
  const url = process && process.env && process.env.URL ? process.env.URL : '';

  const plugins = [];

  plugins.push(
    new MiniCssExtractPlugin({
      filename: `css/[name].css`,
    }),
    new StylelintPlugin({
      files: ['css'],
      failOnError: true,
      failOnWarning: true,
    }),
    new ESLintPlugin({
      files: ['js'],
      failOnError: true,
      failOnWarning: true,
    }),
    /*
     * Intantiate plugins related to svg sprite generation.
     */
    new SvgSpritePlugin({
      plainSprite: true,
    })
  );

  DEBUG &&
    plugins.push(
      new webpack.DefinePlugin({
        DEBUG: DEBUG, // exposes DEBUG variable to the src js (also needs to be defined as a global in the .eslintrc file.
      })
    );

  SERVE &&
    plugins.push(
      new BrowserSyncPlugin(
        // BrowserSync options
        {
          host: 'localhost',
          port: 1337,
          proxy: url,
        },
        // plugin options
        {
          // prevent BrowserSync from reloading the page
          // and let Webpack Dev Server take care of this
          reload: false,
        }
      )
    );

  return plugins;
};
