module.exports = (env, argv) => {
  const path = require('path');
  const MiniCssExtractPlugin = require('mini-css-extract-plugin');
  const isDevelopment = argv && argv.mode && argv.mode === 'development';

  const stylesRules = [];

  stylesRules.push(
    // css
    {
      test: /\.css$/,
      use: [
        {
          loader: MiniCssExtractPlugin.loader,
          options: {},
        },
        {
          loader: 'css-loader',
          options: {
            importLoaders: 2, // => postcss-loader, sass-loader
            sourceMap: isDevelopment && isDevelopment,
            url: false,
          },
        },
        {
          loader: 'postcss-loader',
          options: {
            sourceMap: isDevelopment && isDevelopment,
            postcssOptions: {
              config: path.resolve(process.cwd(), 'postcss.config.js'),
            },
          },
        },
      ],
    }
  );

  return stylesRules;
};
