module.exports = {
  extends: ['stylelint-config-standard', 'stylelint-config-prettier'],
  plugins: [],
  rules: {
    'at-rule-no-unknown': null,
    'function-no-unknown': null,
    'max-nesting-depth': 7,
    'number-max-precision': 10,
    'no-descending-specificity': null,
    'no-duplicate-selectors': null,
    'font-family-no-missing-generic-family-keyword': null,
    'max-empty-lines': 1,
    'no-missing-end-of-source-newline': true,
    'declaration-colon-space-after': 'always',
    'comment-empty-line-before': [
      'always',
      {
        except: ['first-nested'],
      },
    ],
    'selector-id-pattern': null,
    'selector-class-pattern': null,
    'alpha-value-notation': 'number',
    'color-function-notation': 'legacy',
    'declaration-block-no-redundant-longhand-properties': null,
    indentation: [
      'tab',
      {
        except: ['value'],
      },
    ],
  },
};
