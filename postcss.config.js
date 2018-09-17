const cssnanoConfig = {
  autoprefixer: false,
  colormin: true,
  convertValues: true,
  cssDeclarationSorter: true,
  discardComments: { removeAll: true },
  discardDuplicates: true,
  discardEmpty: true,
  discardOverridden: true,
  mergeLonghand: true,
  mergeRules: true,
  minifyFontValues: true,
  minifySelectors: true,
  uniqueSelectors: true,
  svgo: true,
};

module.exports = ctx => ({
  parser: require('postcss-safe-parser'),
  plugins: [
    require('postcss-import'),
    require('postcss-css-variables'),
    require('autoprefixer')({
      grid: true,
      cascade: false,
    }),
    require('cssnano')({
      preset: ['default', cssnanoConfig],
    }),
    require('postcss-nesting'),
    require('postcss-zindex'),
    require('postcss-flexbugs-fixes'),
    require('postcss-preset-env')({
      stage: 3,
    }),
    require('css-mqpacker'),
    ctx.env === 'production' && require('csswring'),
  ],
});
