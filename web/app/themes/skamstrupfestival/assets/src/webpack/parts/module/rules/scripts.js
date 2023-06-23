module.exports = (env, argv) => {
  const scriptRules = [];

  scriptRules.push(
    // js
    {
      test: /\.js$/,
      use: [
        {
          loader: 'esbuild-loader',
          options: {
            loader: 'jsx',
            target: 'es2015',
          },
        },
      ],
    },

    // jsx
    {
      test: /\.jsx$/,
      use: [
        {
          loader: 'esbuild-loader',
          options: {
            loader: 'jsx',
            target: 'es2015',
          },
        },
      ],
    },

    // tsx|ts
    {
      test: /\.tsx|ts$/,
      loader: 'esbuild-loader',
      options: {
        loader: 'tsx',
        target: 'es2015',
      },
    }
  );

  return scriptRules;
};
