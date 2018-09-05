<template>
  <div :class="{ 'fadeOut': !isLoading }" class="loading-container">
    <div class="loading"/>
  </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
  name: 'Loading',
  computed: {
    elementHTML: () => document.querySelector('html'),
    ...mapState(['isLoading']),
  },
  watch: {
    isLoading: function(bool) {
      this.elementHTML.classList.toggle('lock-scroll', this.isLoading);
    },
  },
};
</script>

<style>
.lock-scroll {
  height: 100%;
  overflow: hidden;
}

.loading-container {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  background: rgba(255,255,255, 0.5);
  z-index: 15;
}

.loading {
  position: fixed;
  top: calc((100% - 4rem) / 2);
  left: calc((100% - 4rem) / 2);
  z-index: 20;
  width: 4rem;
  height: 4rem;
  background-image: url('~@images/loading-spin.svg');
  background-repeat: no-repeat;
  background-size: cover;
}
</style>
