module.exports = (env, argv) => {
  const path = require('path');

  const isDevelopment = argv && argv.mode && argv.mode === 'development';

  const iconsRules = [];

  iconsRules.push(
    // icons
    {
      test: /\.(svg)$/,
      use: [
        {
          loader: 'file-loader',
          options: {
            name(file) {
              return file.slice(process.cwd().length + 1); // get relative path of font-file and remove preceding slash
            },
          },
        },
        {
          loader: 'svgo-loader',
          options: {
            js2svg: {
              pretty: isDevelopment && isDevelopment,
            },
          },
        },
      ],
      include: [path.resolve(process.cwd(), 'icons')],
      exclude: [path.resolve(process.cwd(), 'inline-icons'), path.resolve(process.cwd(), 'img'), path.resolve(process.cwd(), 'fonts')],
    }
  );

  return iconsRules;
};
