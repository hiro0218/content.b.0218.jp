<template>
  <header class="header-navigation">
    <div class="l-flex content-between container">
      <div class="title">
        <router-link :to="site.url | formatBaseLink">{{ site.name }}</router-link>
      </div>
      <search class="menu-item" />
    </div>
  </header>
</template>

<script>
import search from '@components/search.vue';

export default {
  name: 'Header',
  components: {
    search,
  },
  props: {
    site: {
      type: Object,
      default: () => {},
      require: true,
    },
  },
  data() {
    return {
      eleHeader: null,
      classes: {
        unpinned: 'unpin',
      },
      lastKnownScrollY: 0,
      ticking: false,
    };
  },
  mounted: function() {
    this.eleHeader = document.querySelector('.header-navigation');
    document.addEventListener('scroll', this.handleScroll, !document.documentMode ? { passive: false } : false);
  },
  methods: {
    onScroll() {
      this.ticking = false;
      let currentScrollY = window.pageYOffset;
      if (currentScrollY < 0) return;

      if (currentScrollY < this.lastKnownScrollY) {
        this.eleHeader.classList.remove(this.classes.unpinned);
      } else {
        this.eleHeader.classList.add(this.classes.unpinned);
      }

      this.lastKnownScrollY = currentScrollY;
    },
    handleScroll() {
      if (!this.ticking) {
        requestAnimationFrame(this.onScroll);
      }
      this.ticking = true;
    },
  },
};
</script>

<style lang="scss" scoped>
.header-navigation {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  height: $header-nav-height;
  background: #fff;
  box-shadow: 0 2px 2px -2px rgba(0, 0, 0, 0.25);
  will-change: transform;
  transition: transform 0.25s $animation-curve-fast-out-slow-in;
  z-index: 10;

  &.unpin {
    box-shadow: none;
    transform: translateY($header-nav-height * -1);
  }

  .title {
    color: $grey-900;
    font-size: 1rem;
    letter-spacing: 0.125rem;
    white-space: nowrap;

    a {
      display: block;
      height: $header-nav-height;
      line-height: $header-nav-height;
      color: inherit;
    }
  }

}
</style>
