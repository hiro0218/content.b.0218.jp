<template>
  <a v-if="product" :href="product.DetailPageURL" class="product-container" target="_blank">
    <div class="product-image">
      <img :src="product.LargeImage" data-zoom-disabled="true">
    </div>
    <div class="product-info">
      <span class="title">{{ product.Title }}</span>
      <span class="url">https://amazon.co.jp/</span>
    </div>
  </a>
</template>

<script>
export default {
  name: 'Amazon',
  props: {
    product: {
      type: Object,
      default: null,
      required: false,
    },
  },
};
</script>

<style lang="scss" scoped>
.product-container {
  display: flex;
  align-items: center;
  margin: 1rem 0;
  height: 11rem;
  border: 1px solid $grey-200;
  border-radius: var(--border-radius-base);
  color: $grey-800;
  &:hover {
    opacity: 0.6;
  }
}

.product-image {
  display: flex;
  width: 15rem;
  height: 100%;
  background: $grey-50;

  img {
    margin: auto;
    max-width: 85%;
    max-height: 85%;
    height: auto;
  }
}

.product-info {
  display: flex;
  flex-basis: 100%;
  flex-direction: column;
  padding: 1rem;
  .title {
    margin-bottom: 0.25rem;
    line-height: 1.5;
  }
  .url {
    color: $grey-600;
    font-size: $font-size-xs;
  }
}
</style>
