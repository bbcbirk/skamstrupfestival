module.exports = (env, argv) => {
  const output = require('./parts/output')(env, argv);
  const getInflix = require('./utils/core')(env, argv).getInflix;

  const isDevelopment = argv && argv.mode && argv.mode === 'development';

  /*
   * expose `env` to the variables from the `.env` file
   */
  require('dotenv').config();

  const config = {};

  /*
   * declare entries
   */
  config.entries = {};

  config.entries[`base${getInflix()}`] = './webpack/entries/base';
  config.entries[`base-admin${getInflix()}`] = './webpack/entries/base-admin';
  config.entries[`base-login${getInflix()}`] = './webpack/entries/base-login';

  config.rootEmSize = 16; // root em size. used by some of our custom postcss-functions for calculation.

  config.output = output;

  config.devtool = isDevelopment ? 'source-map' : false;

  config.stats = {
    errorDetails: true,
  };

  return config;
};
