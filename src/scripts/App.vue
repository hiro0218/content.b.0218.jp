<template>
  <main class="main">
    <layout-header :site="site"/>
    <section class="main-container">
      <router-view/>
    </section>
    <layout-footer :site="site"/>
    <loading/>
  </main>
</template>

<script>
import copy from 'fast-copy';
import layoutHeader from '@/layouts/header.vue';
import layoutFooter from '@/layouts/footer.vue';
import loading from '@components/loading.vue';

export default {
  metaInfo: {
    titleTemplate: titleChunk => {
      return titleChunk ? `${titleChunk} - ${WP.site.name}` : `${WP.site.name}`;
    },
  },
  components: {
    layoutHeader,
    layoutFooter,
    loading,
  },
  computed: {
    site: () => copy(WP.site),
  },
  created: function() {
    this.$store.dispatch('requestAdvertise');
  },
};
</script>

<style lang="scss" scoped>
.main {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

// nav min-height from bulma = 3.5rem
// for header's position:fixed
.main-container {
  flex: 1 0 auto;
  min-height: calc(100vh - #{$header-nav-height});
  margin-top: $header-nav-height; // for header
}
</style>
