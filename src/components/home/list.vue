<template>
  <div>
    <div v-if="requestHeader.total === 0" class="alert alert-warning">
      No results found.
    </div>
    <div class="entry-list">
      <router-link v-for="(post) in postLists" :to="post.link" :key="post.id">
        <article class="c-card">
          <div class="card-image">
            <template v-if="post.thumbnail">
              <img :data-src="post.thumbnail" class="entry-thumbnail" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==">
            </template>
            <template v-else>
              <div class="no-image"/>
            </template>
          </div>
          <header class="card-header">
            <h2 class="entry-title" v-html="$options.filters.escapeBrackets(post.title.rendered)"/>
          </header>
          <footer class="card-footer">{{ post.date | formatDate }}</footer>
        </article>
      </router-link>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import { loadImages } from '@scripts/utils';

export default {
  name: 'EntryList',
  computed: {
    ...mapState({
      requestHeader: 'requestHeader',
      postLists: 'postLists',
    }),
  },
  watch: {
    postLists: function() {
      this.lazyload();
    },
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
a {
  display: block;
  color: $grey-800;
  overflow: hidden;

  &:hover,
  &:focus {
    opacity: 0.6;
  }
}

.entry-list {
  display: grid;
  grid-gap: 2rem;
  grid-template-columns: repeat(3, 1fr);

  @include tablet-only {
    grid-template-columns: repeat(2, 1fr);
  }

  @include mobile {
    grid-template-columns: repeat(1, 1fr);
  }
}

.c-card {
  height: 100%;

  .card-header {
    flex: 1;
    margin-bottom: 1rem;
  }

  .card-footer {
    font-size: $font-size-xs;
  }
}

.card-image {
  .no-image {
    width: 4.5rem;
    height: 4.5rem;
    margin: auto;
  }
}

.entry-title {
  margin: 0;
  font-size: var(--heading3-font-size);
  font-weight: normal;
}
</style>
