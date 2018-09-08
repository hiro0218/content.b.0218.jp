<template>
  <section class="entry-term">
    <div v-cloak v-if="categories.length !== 0" class="entry-category">
      <span class="label">category:</span>
      <ul class="c-list chained">
        <li v-for="(category, index) in categories" :key="index">
          <span v-if="index == 0" class="icon-folder"/><router-link :to="category.link | formatBaseLink">{{ category.name }}</router-link>
        </li>
      </ul>
    </div>
    <div v-cloak v-if="tags.length !== 0" class="entry-tag">
      <span class="label">tag:</span>
      <ul>
        <li v-for="(tag, index) in tags" :key="index">
          <router-link :to="tag.link | formatBaseLink" itemprop="keywords">{{ tag.name }}</router-link>
        </li>
      </ul>
    </div>
  </section>
</template>

<script>
export default {
  name: 'Term',
  props: {
    categories: {
      type: Array,
      default: () => [],
      required: false,
    },
    tags: {
      type: Array,
      default: () => [],
      required: false,
    },
  },
};
</script>

<style lang="scss" scoped>
.c-list.chained {
  flex-wrap: wrap;
  justify-content: flex-start;
}

.entry-term {
  margin-bottom: 1rem;
}

.label {
  min-width: 4rem;
  margin-right: 0.5rem;
  font-size: $font-size-xs;
  text-transform: capitalize;
  color: $grey-800;
}

.entry-category,
.entry-tag {
  display: flex;
  ul {
    font-size: $font-size-xs;
    line-height: 2rem;
  }
  li {
    display: inline-flex;
    align-items: center;
  }
}

.entry-category {
  color: $grey-500;

  a {
    color: inherit;
    &:hover {
      color: inherit;
      text-decoration: underline;
    }
  }
}

.entry-tag {
  li {
    margin: 0 0.5rem 0.5rem 0;
    &:last-child {
      margin-right: 0;
    }
  }

  a {
    padding: 0 0.65rem;
    border-radius: $radius-sm;
    background: $grey-100;
    color: $grey-600;
    &:hover {
      background: $grey-200;
    }
  }
}

.icon-folder {
  margin-right: 0.25rem;
}
</style>
