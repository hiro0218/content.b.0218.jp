<template>
  <section class="entry-content" v-html="content"/>
</template>

<script>
export default {
  name: 'EntryContent',
  props: {
    content: {
      type: String,
      default: () => '',
      require: true,
    },
  },
};
</script>

<style lang="scss" scoped>
.entry-content /deep/ {
  margin-bottom: 1rem;

  h1, h2, h3, h4, h5, h6 {
    position: relative;
  }

  .anchor {
    position: absolute;
    right: calc(100% + 0.25rem);
    top: 0;
    bottom: 0;
    margin: auto;
    border: 0;
    color: $grey-400;
    user-select: none;
    @include until($desktop) {
      position: static;
      margin-left: 0.25rem;
    }
  }

  img {
    margin-bottom: 2rem;
  }

  li + li {
    margin-top: 0.25rem;
  }

  > hr {
    height: 2rem;
    margin: 2rem 0;
    border: 0;
    color: $grey-600;
    font-size: $font-size-h2;
    text-align: center;

    &::before {
      content: '***';
    }
  }
}
</style>
