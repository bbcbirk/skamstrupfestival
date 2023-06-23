module.exports = (env, argv) => {
  const path = require('path');

  const fontsRules = [];

  fontsRules.push(
    // fonts
    {
      test: /\.(woff(2)?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
      use: [
        {
          loader: 'file-loader',
          options: {
            name(file) {
              return file.slice(process.cwd().length + 1); // get relative path of font-file and remove preceding slash
            },
          },
        },
      ],
      include: [path.resolve(process.cwd(), 'fonts')],
      exclude: [path.resolve(process.cwd(), 'icons'), path.resolve(process.cwd(), 'inline-icons'), path.resolve(process.cwd(), 'img')],
    }
  );

  return fontsRules;
};
