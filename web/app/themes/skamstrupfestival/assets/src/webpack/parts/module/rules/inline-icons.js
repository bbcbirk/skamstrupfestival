module.exports = (env, argv) => {
  const path = require('path');
  const utils = require('../../../utils/core')(env, argv);
  const inlineIconsRules = [];

  inlineIconsRules.push(
    // inline-icons
    {
      test: /\.(svg)$/,
      use: [
        {
          loader: 'svg-sprite-loader',
          options: {
            extract: true,
            spriteFilename: (svgPath) => {
              let inlineIconsSubDirectory = svgPath.match(/(inline-icons\/)(.*)(?=\/)/g);

              if (inlineIconsSubDirectory) {
                inlineIconsSubDirectory = inlineIconsSubDirectory[0].slice(13); // strips 'inline-icons/'
              }

              const spriteName = 'inline-icons/' + (inlineIconsSubDirectory ? inlineIconsSubDirectory + '-' : '') + 'sprite' + svgPath.substr(-4);

              return utils.removeDiacritics(spriteName);
            },
            symbolId: (filePath) => {
              // get filename, remove extention, convert special characters to readable alternatives, convert spaces to underscores
              return utils.removeDiacritics(
                path
                  .basename(filePath)
                  .substr(0, path.basename(filePath).length - 4)
                  .replace(/ +/g, '_')
                  .toLowerCase()
              );
            },
          },
        },
        {
          loader: 'svgo-loader',
          options: {
            plugins: [
              'removeNonInheritableGroupAttrs',
              'collapseGroups',
              {
                name: 'removeAttrs',
                params: {
                  attrs: '(fill|stroke)',
                },
              },
            ],
          },
        },
      ],
      include: [path.resolve(process.cwd(), 'inline-icons')],
      exclude: [path.resolve(process.cwd(), 'icons'), path.resolve(process.cwd(), 'img'), path.resolve(process.cwd(), 'fonts')],
    }
  );

  return inlineIconsRules;
};
