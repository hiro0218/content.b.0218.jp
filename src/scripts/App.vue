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
      return titleChunk && !titleChunk.includes(WP.site.name) ? `${titleChunk} - ${WP.site.name}` : `${WP.site.name}`;
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

<style scoped>
.main {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.main-container {
  flex: 1 0 auto;
}
</style>
