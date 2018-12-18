<template>
  <Layout>
    <h1 v-html="$page.wordPressPage.title" />
    <div v-html="$page.wordPressPage.content" />
  </Layout>
</template>

<page-query>
query Page {
  wordPressPage (path: "/pages/about") {
    title
    content
  }
}
</page-query>

<script>
export default {}
</script>
