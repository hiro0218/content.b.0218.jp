<template>
  <section v-cloak v-if="related.length !== 0" class="related">
    <h2 class="related-heading">
      Related Posts
    </h2>
    <div class="related-container">
      <template v-for="entry in related">
        <div :key="entry.id" class="c-card">
          <RouterLink :to="entry.url">
            <div class="card-image">
              <template v-if="entry.image">
                <img :data-src="entry.image" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==">
              </template>
              <template v-else>
                <div class="no-image" />
              </template>
            </div>
            <div class="card-header" v-html="$options.filters.escapeBrackets(entry.title)" />
          </RouterLink>
        </div>
      </template>
    </div>
  </section>
</template>

<script>
import { loadImages } from '@scripts/utils';

export default {
  name: 'Related',
  props: {
    related: {
      type: Array,
      default: () => [],
      required: false,
    },
  },
  watch: {
    related: function() {
      this.lazyload();
    },
  },
  mounted: function() {
    this.lazyload();
  },
  methods: {
    lazyload: function() {
      this.$nextTick(() => {
        let images = document.querySelectorAll('[data-src]');
        loadImages(images);
      });
    },
  },
};
</script>

<style lang="scss" scoped>
.related {
  margin: 2rem 0;
}

.related-heading {
  font-weight: normal;
  text-align: center;
}

.related-container {
  display: flex;
  overflow-x: scroll;

  a {
    display: block;
    width: 15rem;
    color: $grey-800;
    overflow: hidden;

    &:hover,
    &:focus {
      opacity: 0.6;
    }
  }
}

.c-card {
  & + & {
    margin-left: 2rem;
  }
}

.card-image {
  .no-image {
    width: 4.5rem;
    height: 4.5rem;
    margin: auto;
  }
}
</style>
