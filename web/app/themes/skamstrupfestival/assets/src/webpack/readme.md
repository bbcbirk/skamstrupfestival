# Readme


## Webpack setup

This setup uses webpack to compile and transpile the frontend assets.

It also uses a few predefined npm scripts, which can be found in the `assets/src/package.json` file.


### project structure

```
├── webpack
│   ├── deps-constrain.txt
│   ├── entries
│   │   ├── base-admin.js
│   │   ├── base-login.js
│   │   └── base.js
│   ├── parts
│   │   ├── dev-server.js
│   │   ├── module
│   │   │   ├── module.js
│   │   │   └── rules
│   │   │       ├── fonts.js
│   │   │       ├── icons.js
│   │   │       ├── images.js
│   │   │       ├── inline-icons.js
│   │   │       ├── scripts.js
│   │   │       └── styles.js
│   │   ├── optimization.js
│   │   ├── output.js
│   │   └── plugins.js
│   ├── project.config.js
│   ├── readme.md
│   └── utils
│       ├── autosize.js
│       ├── cl.js
│       ├── core.js
│       └── rem.js
└── webpack.config.js
```

This project structure is the result of a few iterations and has been migrated through a few previous versions of webpack.

It has mostly been inspired by reading through the [official webpack documentation](https://webpack.js.org/concepts/), especially their section explaining the [default webpack configuration](https://webpack.js.org/configuration).

It has also been inspired, in part, by this great resource for [learning about webpack](https://survivejs.com/webpack/developing/composing-configuration/).

Basically the structure of the webpack files should kind of mimic the structure of the default webpack configuration object.

In addition to core webpack configuration it also comes with a few handy utils and some custom postcss plugins, to ease frontend development.


### Project assumptions
This project assumes that all developers use the npm scripts for tasks such as installing the npm dependencies, `npm run deps:install` and linting assets, `npm run lint:fix`.

For example running `npm run deps:install` will automatically update all packages to the latest stable version, except any packages that are specifically targeted on a line in the `deps-constrain.txt` file in the `<package-name>@<version>` format. I.e. `react@17.0.2`, which are installed in their exact targeted version.

It assumes that each developer keeps their local node version up to date, using either [nvm](https://github.com/nvm-sh/nvm) or [nvm-windows](https://github.com/coreybutler/nvm-windows).

In case the latest version of node at some point is no longer compatible with the setup, it must be locked to the latest working one, using `npm run node:version:lock`.
