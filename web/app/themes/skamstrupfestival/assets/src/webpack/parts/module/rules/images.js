module.exports = (env, argv) => {
  const path = require('path');
  const isDevelopment = argv && argv.mode && argv.mode === 'development';
  const imagesRules = [];

  imagesRules.push(
    // img
    {
      test: /\.(gif|png|jpe?g)$/i,
      use: [
        {
          loader: 'url-loader',
          options: {
            limit: 10 * 1024,
          },
        },
        {
          loader: 'file-loader',
          options: {
            name(file) {
              return file.slice(process.cwd().length + 1); // get relative path of font-file and remove preceding slash
            },
          },
        },
      ],
      include: [path.resolve(process.cwd(), 'img')],
      exclude: [path.resolve(process.cwd(), 'inline-icons'), path.resolve(process.cwd(), 'icons'), path.resolve(process.cwd(), 'fonts')],
    },

    {
      test: /\.(svg)$/i,
      use: [
        {
          loader: 'url-loader',
          options: {
            limit: 10 * 1024,
          },
        },
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
      include: [path.resolve(process.cwd(), 'img')],
      exclude: [path.resolve(process.cwd(), 'inline-icons'), path.resolve(process.cwd(), 'icons'), path.resolve(process.cwd(), 'fonts')],
    }
  );

  return imagesRules;
};
