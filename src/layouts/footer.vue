<template>
  <footer class="footer footer-navigation">
    <div class="l-flex content-between container">
      <nav v-if="site.primary_navigation" class="footer-menu">
        <ul>
          <li v-for="(menu, index) in site.primary_navigation" :key="index">
            <router-link :to="menu.url | formatBaseLink">{{ menu.title }}</router-link>
          </li>
        </ul>
      </nav>
      <div class="footer-copytight">
        <span>© {{ site.copyright }} <a :href="site.url">{{ site.name }}</a></span>
      </div>
    </div>
  </footer>
</template>

<script>
export default {
  name: 'Footer',
  props: {
    site: {
      type: Object,
      default: () => {},
      require: true,
    },
  },
};
</script>

<style lang="scss" scoped>
a {
  color: inherit;
  &:hover {
    text-decoration: underline;
  }
}

li {
  display: inline-block;

  & + li {
    margin-left: 1rem;
  }
}

.footer-navigation {
  padding: 3rem 0;
  background: $grey-300;
  color: $grey-600;
  font-size: var(--font-size-sm);

  .container {
    @include mobile {
      flex-direction: column;
      height: 4rem;
    }
  }
}
</style>
