<?php
namespace Kiku\Modules;

// basic tags
function basic_tags() {
    echo PHP_EOL;

    // description
    if ( is_home() && !is_paged() ) {
        echo '<meta name="description" content="' . BLOG_DESCRIPTION . '">'. PHP_EOL;
    }

    // author page
    echo '<link itemprop="author" href="'. BLOG_URL .'about/" />'. PHP_EOL;
}
add_action( 'wp_head',  __NAMESPACE__ . '\\basic_tags', 11 );

function ogp_tags() {
    $og_tag = [];
    $og_tag['og:locale'] = get_locale();

    echo PHP_EOL;

    if ( is_home() || is_front_page() ) {
        $og_tag['og:type']        = 'blog';
        $og_tag['og:title']       = BLOG_NAME;
        $og_tag['og:url']         = BLOG_URL;
        $og_tag['og:description'] = BLOG_DESCRIPTION;

    } else if ( is_singular() ) {
        $og_tag['og:type']        = 'article';
        $og_tag['og:title']       = get_the_title();
        $og_tag['og:url']         = get_permalink();
        $og_tag['og:description'] = \Kiku\Util::get_excerpt_content();

        // get date
        $pub = get_the_date('c');
        $mod = get_the_modified_date('c');

        // published
        $og_tag['article:published_time'] = $pub;
        // modified
        if ( $mod != $pub ) {
            $og_tag['article:modified_time'] = $mod;
            $og_tag['og:updated_time']       = $mod;
        }

    } else if ( is_404() ) {
        $og_tag['og:type']   = 'object';
        $og_tag['og:title']  = "Page Not Found - ". BLOG_NAME;
    }

    $template = '<meta property="%s" content="%s" />'. PHP_EOL;
    foreach ( $og_tag as $tag_property => $tag_content ) {
        $tag_content = array_unique( (array)$tag_content );
        foreach ( $tag_content as $tag_content_single ) {
            if ( empty( $tag_content_single ) ) {  // Don't ever output empty tags
                continue;
            }
            echo sprintf( $template, esc_attr( $tag_property ), esc_attr( $tag_content_single ) );
        }
    }
}
add_action( 'wp_head',  __NAMESPACE__ . '\\ogp_tags', 12 );

// DNS Prefetch
function dns_prefetch_tags() {
    echo PHP_EOL;
    echo '<meta http-equiv="x-dns-prefetch-control" content="on">'. PHP_EOL;
    $generate_dns = [
        "cdnjs.cloudflare.com",
        "stats.wp.com",
        "www.google-analytics.com",
        "ecx.images-amazon.com",
        "stats.g.doubleclick.net",
        "ajax.googleapis.com",
        "fonts.googleapis.com",
        "pixel.wp.com"
    ];
    $tag_template = '<link rel="dns-prefetch" href="//%s">' . PHP_EOL;

    foreach ( $generate_dns as $domain ) {
        echo sprintf( $tag_template, $domain );
    }
}
add_action( 'wp_head',  __NAMESPACE__ . '\\dns_prefetch_tags', 13 );

// mics tags
function mics_tags() {
    echo PHP_EOL;
    echo '<meta name="google" content="notranslate" />'. PHP_EOL;
    echo '<meta name="format-detection" content="telephone=no">'. PHP_EOL;
    echo '<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE">'. PHP_EOL;
}
add_action( 'wp_head',  __NAMESPACE__ . '\\mics_tags', 20 );