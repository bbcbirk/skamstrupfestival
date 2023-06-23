module.exports = (env, argv) => {
  const path = require('path');

  const output = {
    path: path.resolve(process.cwd(), '..', 'dist'),
    filename: (pathData) => {
      return `js/[name].js`;
    },
    chunkFilename: `js/[id].js`,
  };

  return output;
};
