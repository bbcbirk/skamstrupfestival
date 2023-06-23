module.exports = (env, argv) => {
  const { ESBuildMinifyPlugin } = require('esbuild-loader');
  const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');

  const isDevelopment = argv && argv.mode && argv.mode === 'development';

  const optimization = {};

  optimization.minimizer = [];

  optimization.minimizer.push(
    new ESBuildMinifyPlugin({
      target: 'es2015',
      pure: [
        !isDevelopment && 'console.log', // strips console logs for production builds
      ],
    })
  );

  !isDevelopment && optimization.minimizer.push(new CssMinimizerPlugin());

  return optimization;
};
