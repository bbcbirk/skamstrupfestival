module.exports = (env, argv) => {
  const config = require('./webpack/project.config')(env, argv);
  const autosize = require('./webpack/utils/autosize');
  const cl = require('./webpack/utils/cl');
  const rem = require('./webpack/utils/rem');

  return {
    plugins: [
      [
        'postcss-functions',
        {
          functions: {
            autosize: (viewMin, viewMax, sizeMin, sizeMax) => {
              let rootEmSize = (config && config.rootEmSize) || 16;
              rootEmSize = parseInt(rootEmSize);

              return autosize(viewMin, viewMax, sizeMin, sizeMax, rootEmSize);
            },
            cl: cl,
            rem: (pxSize) => {
              let rootEmSize = (config && config.rootEmSize) || 16;
              rootEmSize = parseInt(rootEmSize);
              pxSize = pxSize || 18;

              return rem(pxSize, rootEmSize);
            },
          },
        },
      ],
      [
        'postcss-import',
        {
          path: ['./css/helpers', './css/basics', '../dist', './node_modules'],
        },
      ],
      'postcss-color-mod-function',
      'postcss-simple-vars',
      'postcss-mixins',
      ['autoprefixer', {}],
      'postcss-nested',
      [
        'postcss-preset-env',
        {
          stage: 4,
          features: {
            'custom-media-queries': true,
            'nesting-rules': true,
          },
        },
      ],
    ],
  };
};
