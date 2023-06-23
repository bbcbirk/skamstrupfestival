# README
This setup uses webpack for building frontend assets and watching source files for changes.

It also uses [eslint](https://eslint.org/), [stylelint](https://stylelint.io/) and [prettier](https://prettier.io/) for linting and formatting the source code in accordance with our styleguides.

Lastly, it uses [pa11y](https://github.com/pa11y) to scan individual pages for accessibility issues.

**important note**
It is important to use the provided npm scripts for installing and updating (and fixing broken installations), since this ensures that all developers are using it the same way.

This means that *every developer* must use i.e. `npm run deps:install` to install the project dependencies, rather than using the normal `npm install`.

## NPM / NODE JS
This project has been setup using the latest stable version of node and npm.
At the time of writing this:

```
npm: 8.13.2
node: 18.4.0
```

Ideally developers should update their node and npm versions to the latest stable versions (also beyond the above listed ones),
before working on this project.

Using [nvm](https://github.com/nvm-sh/nvm):

```
nvm install-latest-npm; \
nvm install node
```
At some point, we might reach the highest possible version of node compatible with this setup.
In this case, please refer to the `npm run node:version:lock`.

## NPM install/update/constrain/fix broken install
Running either install or update will also update the local browserslist database.
It is important that all developers use these commands to install the project dependencies, at this ensures that we update the project dependencies on a regular basis.

**install**

```
npm run deps:install # install project dependencies. Also updates all non constrained packages to the latest stable version.
```

**update**

```
npm run deps:update # Updates all non constrained packages to the latest stable version.
```

**constrain**
Occationally it may be necessary to constrain certain packages.
Most often this will likely be due to newly introduced peer dependencies after running a project package update.
In other cases it might be because we are forced to use a legacy version of a package.

In order to constrain a certain package, add an entry as a separate line in the `webpack/deps-constrain.txt` file in the following format:

```
<package-name>@<package-version>
```

For example:

```
react-select@1.1.0
```

Then the following script can be run:

```
npm run deps:constrain
```

**fix**

```
npm run deps:fix # fix broken dependencies (by checking out working package.json and package-lock.json files from the latest master)
```

## Building dist files and watching source files for changes

```
npm run build     # Building dist files for prod
npm run build:dev # Building dist files for dev (mostly used for debugging webpack)
npm run watch     # Watching source files for changes (and building for development)
```

## Formatting and linting

```
npm run lint           # lint css and js (stylelint and eslint)
npm run lint:css       # lint css (stylelint)
npm run lint:css:fix   # lint css fix (stylelint)
npm run lint:fix       # lint css and js and fix (stylelint and eslint)
npm run lint:js        # lint js (eslint)
npm run lint:js:fix    # lint js fix (eslint)
npm run format         # format css and js (prettier)
npm run format:css     # format css (prettier)
npm run format:css:fix # format css fix (prettier)
npm run format:fix     # format css and js and fix (prettier)
npm run format:js      # format js (prettier)
npm run format:js:fix  # format js fix (prettier)
```

In addition to the above listed npm scripts, it is recommended to setup your text editor/IDE to work with `stylelint`, `prettier`, `eslint` and `editorconfig.`.

Resources are available for most popular text editors/IDEs.

- [stylelint - editor integration](https://stylelint.io/user-guide/integrations/editor)
- [prettier - editor integration](https://prettier.io/docs/en/editors.html)
- [eslint - editor integration](https://eslint.org/docs/latest/user-guide/integrations)
- [editorconfig - editor integration](https://editorconfig.org/#pre-installed)

## A11y (accessibility) and WCAG compliance

```
npm run a11y:url <custom-url>

# Example
npm run a11y:url https://example.org
```

Will run the accessibility test against the provided url argument.

## Debugging and project config
Project specific configuration can be setup in the `webpack/project.config.js` file.

Additionally some environment specific variables can be setup in the `.env` file, to toggle features such as debugging.

## Postcss and custom postcss-functions
In this setup we use [postcss-function](https://github.com/andyjansson/postcss-functions/#postcss-functions) to setup custom functions for ease of use.
These are defined in the `postcss.config.js` file.
