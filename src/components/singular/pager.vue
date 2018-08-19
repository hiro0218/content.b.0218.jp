<template>
  <nav v-if="Object.keys(pager).length !== 0" class="pager-container">
    <div class="l-flex content-between container">
      <router-link v-if="pager.prev" :to="pager.prev.url" :title="pager.prev.title" class="prev">
        <div class="arrow icon-container">
          <div class="icon-arrow-back"/>
        </div>
        <div class="label">previous</div>
        <div class="title">{{ pager.prev.title }}</div>
      </router-link>
      <router-link v-if="pager.next" :to="pager.next.url" :title="pager.next.title" class="next">
        <div class="arrow icon-container">
          <div class="icon-arrow-forward"/>
        </div>
        <div class="label">next</div>
        <div class="title">{{ pager.next.title }}</div>
      </router-link>
    </div>
  </nav>
</template>

<script>
export default {
  name: 'Pager',
  props: {
    pager: {
      type: Object,
      default: () => {},
      required: true,
    },
  },
};
</script>

<style lang="scss" scoped>
.pager-container {
  padding: 2rem 0;
  background: $grey-100;
}

.l-flex {
  flex-wrap: wrap;
  align-items: stretch;
}

.prev,
.next {
  display: grid;
  grid-row-gap: 0.25rem;
  grid-column-gap: .5rem;
  width: calc(50% - 1rem);

  &:hover,
  &:focus {
    opacity: 0.6;
  }

  &:only-child {
    flex-grow: 1;
  }

  @include mobile {
    flex: none;
    width: 100%;
  }
}

.prev {
  grid-template-columns: 2rem 1fr;
  text-align: left;
}

.next {
  grid-template-columns: 1fr 2rem;
  text-align: right;
}

.arrow {
  display: flex;
  align-items: center;

  .prev & {
    grid-area: 1 / 1 / 3 / 2;
  }
  .next & {
    grid-area: 3 / 3 / 1 / 2;
  }
}

.label {
  color: $grey-500;
  font-weight: bold;
  text-transform: capitalize;
}

.title {
  color: $grey-600;
  word-break: break-all;
  transition: color 0.3s $animation-curve-fast-out-slow-in;
}
</style>
