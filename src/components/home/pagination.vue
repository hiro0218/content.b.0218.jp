<template>
  <nav v-if="requestHeader.total > 0 && requestHeader.totalpages > 1">
    <uib-pagination
      v-model="pagination"
      :total-items="requestHeader.total"
      :items-per-page="per_page"
      :boundary-links="true"
      :rotate="true"
      :max-size="4"
      class="l-flex content-center"
      first-text=""
      next-text=""
      previous-text=""
      last-text=""
      @change="changePage"/>
  </nav>
</template>

<script>
import { mapState } from 'vuex';

export default {
  name: 'Pagination',
  data() {
    return {
      pagination: {
        currentPage: parseInt(this.$route.params.page_number || 1, 10),
      },
      per_page: WP.per_page,
    };
  },
  computed: mapState(['requestHeader']),
  watch: {
    '$route.path': function() {
      this.pagination.currentPage = parseInt(this.$route.params.page_number || 1, 10);
    },
  },
  methods: {
    changePage: function() {
      let basePath = this.getBasePath();
      let pageNumber = this.pagination.currentPage || 1;
      let pagePath = `page/${pageNumber}`;
      let path = `${basePath}/`;

      if (pagePath !== 'page/1') {
        path = `${basePath}/${pagePath}/`;
      }

      this.$router.push({
        path: path,
        params: { page_number: pageNumber },
      });
    },
    getBasePath: function() {
      if (!this.$route.meta.type) {
        return '';
      }

      let pathArray = this.$route.path.split('/');
      let basePath = [pathArray[0], pathArray[1], pathArray[2]].join('/');

      return basePath;
    },
  },
};
</script>

<style lang="scss" scoped>
.pagination /deep/ {
  margin: 3rem 0;
  padding: 0;
  flex-wrap: wrap;
  user-select: none;

  li + li {
    margin-left: 0.5rem;
  }

  a {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 3rem;
    min-height: 3rem;
    border-radius: $radius-base;
    color: $grey-600;

    &:hover {
      outline: 0;
      background: $grey-200;
    }
  }

  .active a {
    background: $grey-600;
    color: $white;
    cursor: default;
  }

  .disabled a {
    opacity: 0.5;
    cursor: not-allowed;

    @include mobile {
      display: none;
    }

    &:hover {
      background: none;
    }
  }

  .pagination-first a,
  .pagination-prev a,
  .pagination-next a,
  .pagination-last a {
    &::before {
      display: inline-block;
      content: '';
      background-repeat: no-repeat;
      background-size: contain;
      width: 1rem;
      height: 1rem;
    }
  }

  .pagination-first a {
    &::before {
      background-image: url('~@images/icon/first_page.svg');
    }
  }

  .pagination-prev a {
    &::before {
      background-image: url('~@images/icon/chevron_left.svg');
    }
  }

  .pagination-next a {
    &::before {
      background-image: url('~@images/icon/chevron_right.svg');
    }
  }

  .pagination-last a {
    &::before {
      background-image: url('~@images/icon/last_page.svg');
    }
  }
}
</style>
