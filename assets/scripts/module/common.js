import Zooming from 'zooming';

module.exports = {
  getSingularType() {
    var type = null;
    var classNames = document.body.className.toLowerCase().replace(/-/g, '_').split(/\s+/);

    classNames.forEach((className) => {
      switch (className) {
        case 'single':
        type = 'posts';
        break;
        case 'page':
        type = 'pages';
        break;
      }
      if (!type) {
        return false;
      }
    });

    return type;
  },
  setThumbnailImage() {
    var tmbContainer = document.getElementsByClassName('entry-image');
    var length = tmbContainer.length;
    if (length === 0) {
      return;
    }

    for (var i = 0; i < length; i += 1) {
      var container = tmbContainer[i];
      var imageUrl = container.dataset.thumbnailImage;
      if (!imageUrl) {
        continue;
      }

      var sheet = container.getElementsByClassName('image-sheet')[0];

      function _loadImage(element, url) {
        return function () {
          // set background image
          element.style.backgroundImage = 'url(' + url + ')';
          // remove no image icon
          var icon = element.getElementsByClassName('icon')[0];
          icon.remove();
        };
      }

      var img = new Image();
      img.onload = _loadImage(sheet, imageUrl);
      img.src = imageUrl;
    }
  },
  addExternalLink(entry) {
    var self = this;
    var icon = document.createElement('i');
    icon.appendChild(document.createTextNode('open_in_new'));
    icon.classList.add('material-icons', 'external-link');

    [].forEach.call(entry.getElementsByTagName('a'), function (element) {
      self.setExternalLinkIcon(element, icon);
    });
  },
  setExternalLinkIcon(element, icon) {
    if (typeof element.origin === 'undefined') {
      return;
    }

    var href = element.getAttribute('href');
    // exclude javascript and anchor
    if ((href.substring(0, 10).toLowerCase() === 'javascript') || (href.substring(0, 1) === '#')) {
      return;
    }

    // check hostname
    if (element.hostname === location.hostname) {
      return;
    }

    // set target and rel
    element.setAttribute('target', '_blank');
    element.setAttribute('rel', 'nofollow');

    // set icon when childNode is text
    if (element.hasChildNodes()) {
      if (element.childNodes[0].nodeType === 3) {
        element.appendChild(icon.cloneNode(true));
      }
    }
  },
  zoomImage(element) {
    var zoom = new Zooming();
    var entryImg = element.getElementsByTagName('img');
    var length = entryImg.length;

    // entry has no img
    if (length === 0) {
      return;
    }

    for (var i = 0; i < length; i += 1) {
      // parentNode is <a> Tag
      if (entryImg[i].getAttribute('data-zoom-disabled') === 'true' || entryImg[i].parentNode.nodeName.toUpperCase() === 'A') {
        continue;
      }
      // set cursor zoom-in
      entryImg[i].style.cursor = 'zoom-in';
      zoom.listen(entryImg[i]);
    }
  },
  /**
   * delay()(function(){console.log("hello1");}, 5000);
   */
  delay() {
    var timer = 0;
    return function (callback, delay) {
      clearTimeout(timer);
      timer = setTimeout(callback, delay);
    };
  },
  getStyleSheetValue(element, property) {
    if (!element || !property) {
      return null;
    }

    var style = window.getComputedStyle(element);
    var value = style.getPropertyValue(property);

    return value;
  }
};
