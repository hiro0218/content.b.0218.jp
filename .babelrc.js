module.exports = {
  presets: [
    [
      '@babel/preset-env',
      {
        modules: false,
        useBuiltIns: 'usage',
      }
    ]
  ],
  plugins: [
    ['@babel/plugin-transform-for-of'],
    ['@babel/plugin-proposal-object-rest-spread'],
    ['@babel/plugin-syntax-dynamic-import']
  ]
};
