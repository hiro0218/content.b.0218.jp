module.exports = ctx => ({
  parser: require('postcss-safe-parser'),
  plugins: [
    require('postcss-import'),
    require('postcss-css-variables'),
    require('autoprefixer')({
      grid: true,
      cascade: false,
    }),
    require('postcss-zindex'),
    require('postcss-flexbugs-fixes'),
    require('postcss-preset-env')({
      stage: 3,
    }),
    require('css-mqpacker'),
    require('cssnano')({
      preset: ['default', {
        autoprefixer: false,
      }],
    }),
  ],
});
