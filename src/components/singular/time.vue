<template>
  <ul v-cloak v-if="date" class="c-list chained">
    <li class="date-published">
      <span class="icon-update"/><time :datetime="date | dateToISOString" itemprop="datePublished">{{ date | formatDate }}</time>
    </li>
    <li v-if="!isSameDay()" class="date-modified">
      <time :datetime="modified | dateToISOString" itemprop="dateModified">{{ modified | formatDate }}</time>
    </li>
    <li v-if="canEdit">
      <a :href="editPostUrl">Edit</a>
    </li>
  </ul>
</template>

<script>
export default {
  name: 'Time',
  props: {
    date: {
      type: String,
      default: '',
      required: true,
    },
    modified: {
      type: String,
      default: '',
      required: false,
    },
  },
  computed: {
    canEdit: function() {
      return WP.is_logined && this.$route.meta.type !== 'preview';
    },
    editPostUrl: function() {
      return `/wp-admin/post.php?post=${this.$route.meta.id}&action=edit`;
    },
  },
  methods: {
    isSameDay: function() {
      return new Date(this.date).toDateString() === new Date(this.modified).toDateString();
    },
  },
};
</script>

<style lang="scss" scoped>
.icon-update {
  margin-right: 0.25rem;
}

ul {
  color: $grey-500;
}

a {
  color: inherit;

  &:hover,
  &:focus {
    color: inherit;
    text-decoration: underline;
  }
}
</style>
