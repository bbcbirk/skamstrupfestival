module.exports = (env, argv) => {
  const path = require('path');

  const devServer = {
    hot: true,
    watchFiles: ['./js/**/*', './css/**/*'],
    static: {
      directory: path.join(process.cwd(), '..', '..', '..', '..', '..'), // path to the Wordpress `index.php` file.
    },
  };

  return devServer;
};
