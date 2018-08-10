<?php

class Route
{
  public function get_routes()
  {
    $routes = [];

    // transient で一時的にキャッシュしたデータをロード
    $key = CACHE_PREFIX . "routes";
    $routes = get_transient($key);

    if ($routes === false) {
      $posts = $this->get_post_routes();
      $terms = $this->get_term_routes();

      $routes = array_merge($posts, $terms);

      set_transient($key, $routes, MINUTE_IN_SECONDS * 15);
    }

    return $routes;
  }

  private function get_post_routes()
  {
    $routes = [];
    $query = new WP_Query([
      'post_type' => ['post', 'page'],
      'post_status' => 'publish',
      'posts_per_page' => -1,
    ]);

    if ($query->have_posts()) {
      while ($query->have_posts()) {
        $query->the_post();
        $post_id = get_the_ID();
        $post_type = get_post_type();

        $routes[$post_type][] = [
          'path' => '/' . basename(get_permalink()),
          'meta' => [
            'id' => $post_id,
          ],
        ];
      }
    }
    wp_reset_postdata();

    return $routes;
  }

  private function get_term_routes()
  {
    $routes = [];
    $query = new WP_Term_Query([
      'taxonomy' => ['category', 'post_tag'],
    ]);

    foreach ($query->get_terms() as $term) {
      $routes[$term->taxonomy][] = [
        'path' => Util::base_path(get_term_link($term)),
        'meta' => [
          'id' => $term->term_id,
          'title' => $term->name,
        ],
      ];
    }

    return $routes;
  }
}

$Route = new Route();
