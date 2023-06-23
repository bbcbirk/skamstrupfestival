module.exports = (env, argv) => {
  const config = require('./webpack/project.config')(env, argv);
  const devServer = require('./webpack/parts/dev-server')(env, argv);
  const webpackModule = require('./webpack/parts/module/module')(env, argv);
  const plugins = require('./webpack/parts/plugins')(env, argv);
  const optimization = require('./webpack/parts/optimization')(env, argv);

  const entries = config && config.entries;
  const output = config && config.output;
  const devtool = config && config.devtool;
  const stats = config && config.stats;

  return {
    devtool: devtool,
    entry: entries,
    output: output,
    devServer: devServer,
    plugins: plugins,
    optimization: optimization,
    module: webpackModule,
    stats: stats,
  };
};
