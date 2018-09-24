import copy from 'fast-copy';

class API {
  constructor() {
    this.settings = {
      baseURL: '/wp-json/wp/v2',
      headers: { 'X-WP-Nonce': WP.nonce },
      params: {},
    };
    this.api = axios.create(this.settings);
  }

  getAdvertise() {
    return this.api.get('/wp-json/kiku/v1/advertise', {
      baseURL: '/',
      params: '',
    });
  }

  getArchive() {
    return this.api.get('/wp-json/kiku/v1/archive', {
      baseURL: '/',
      params: '',
    });
  }

  getPostList({ meta, params }) {
    const defaultParams = copy(this.settings.params);

    return this.api.get('/posts/?list', {
      params: Object.assign(
        defaultParams,
        { orderby: 'modified' },
        WP.per_page && { per_page: WP.per_page },
        WP.categories_exclude && { categories_exclude: WP.categories_exclude },
        meta.type === 'post_tag' && meta.id && { tags: meta.id },
        meta.type === 'category' && meta.id && { categories: meta.id },
        meta.type === 'search' && { search: params.search_query },
        params.page_number && { page: params.page_number },
      ),
    });
  }

  getPosts(post_id, preview) {
    let path = `/posts/${post_id}`;
    if (preview) {
      path += '/revisions';
    } else {
      path += '?_embed';
    }

    return this.api.get(path).then(res => {
      if (preview) {
        res.data = res.data[0];
      }
      return res;
    });
  }

  getPages(post_id, preview) {
    let path = `/pages/${post_id}`;
    if (preview) {
      path += '/revisions';
    } else {
      path += '?_embed';
    }

    return this.api.get(path).then(res => {
      if (preview) {
        res.data = res.data[0];
      }
      return res;
    });
  }
}

export default new API();
