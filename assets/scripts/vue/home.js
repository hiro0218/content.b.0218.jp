/* global WP */
import 'whatwg-fetch';
import Vue from 'vue';
import ago from 's-ago';
import common from '../module/common';

module.exports = {
  view(api_url) {
    var app = new Vue({
      el: '.main-container',
      data: {
        loaded: false,
        posts: [],
      },
      created: function () {
        this.fetchPostData();
      },
      watch: {
        loaded: function (data) {
          // After displaying DOM
          this.$nextTick(function() {
            common.setThumbnailImage();
          });
        }
      },
      methods: {
        fetchAPI: function(url) {
          var self = this;
          return fetch(url, {
            method: 'GET'
          }).then(function(response) {
            return response.json();
          });
        },
        fetchPostData: function () {
          var self = this;
          self.fetchAPI(api_url)
          .then(function(jsons) {
            for (var key in jsons) {
              var json = jsons[key];
              var post = {
                title: null,
                link: null,
                excerpt: null,
                thumbnail: null,
                date: {
                  timeAgo: null,
                },
              };
              post.title = json.title.rendered;
              post.excerpt = json.excerpt.rendered;
              post.link = json.link;
              post.thumbnail = json.thumbnail;
              post.date.timeAgo = ago(new Date(json.modified));
              self.posts.push(post);
            }
            if (self.posts) {
              self.loaded = true;
            }
          });
        },
      },
    });
  },
};
