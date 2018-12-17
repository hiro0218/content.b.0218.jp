<template>
  <Layout>
    <h1>Welcome to my blog :)</h1>
    <Pager :info="$page.allWordPressPost.pageInfo" />
    <ul>
      <li v-for="{ node } in $page.allWordPressPost.edges" :key="node.id">
        <h2 v-html="node.title" />
        <RouterLink :to="node.path">
          Read more
        </RouterLink>
      </li>
    </ul>
  </Layout>
</template>

<page-query>
query Home ($page: Int) {
  allWordPressPost (perPage: 10, page: $page) @paginate {
    pageInfo {
      totalPages
      currentPage
    }
    edges {
      node {
        id
        title
        slug
        path
      }
    }
  }
}
</page-query>

<script>
import { Pager } from 'gridsome'

export default {
  components: {
    Pager,
  },
}
</script>
