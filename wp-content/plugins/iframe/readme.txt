=== Iframe ===
Contributors: webvitaly
Plugin URI: http://web-profile.com.ua/wordpress/plugins/iframe/
Tags: iframe, embed, youtube, vimeo, google-map, google-maps
Author URI: http://web-profile.com.ua/wordpress/
Requires at least: 3.0
Tested up to: 3.3.1
Stable tag: 2.2

Embed iframe with [iframe src="http://vimeo.com/123" width="100%" height="480"] shortcode.

== Description ==

Iframes are needed to embed video from youtube or to embed Google Map or just to embed content from external page.
WordPress removes iframe when you switch from "HTML" to "Visual" tab because of the security reasons.
So you can embed iframe code using this shortcode `[iframe src="http://player.vimeo.com/video/3261363" width="100%" height="480"]`.

= Usage (allowed parameters) =
* **src** - source of the iframe `[iframe src="http://player.vimeo.com/video/3261363"]` (empty by default src="");
* **width** - width in pixels or in percents `[iframe width="100%" src="http://player.vimeo.com/video/3261363"]` or `[iframe width="640" src="http://player.vimeo.com/video/3261363"]` (by default width="100%");
* **height** - height in pixels `[iframe height="480" src="http://player.vimeo.com/video/3261363"]` (by default height="480");
* **scrolling** - parameter `[iframe scrolling="yes"]` (by default scrolling="no");
* **frameborder** - parameter `[iframe frameborder="0"]` (by default frameborder="0");
* **marginheight** - parameter `[iframe marginheight="0"]` (removed by default);
* **marginwidth** - parameter `[iframe marginwidth="0"]` (removed by default);
* **allowtransparency** - allows to set transparency of the iframe `[iframe allowtransparency="true"]` (removed by default);
* **id** - allows to add the id of the iframe `[iframe id="my-id"]` (removed by default);
* **class** - allows to add the class of the iframe `[iframe class="my-class"]` (by default class="iframe-class");
* **style** - allows to add the css styles of the iframe `[iframe style="margin-left:-30px;"]` (removed by default);
* **same_height_as** - allows to set the height of iframe same as target element `[iframe same_height_as="body"]`, `[iframe same_height_as="div.sidebar"]`, `[iframe same_height_as="div#content"]`, `[iframe same_height_as="window"]` - iframe will have the height of the viewport (visible area), `[iframe same_height_as="document"]` - iframe will have the height of the document, `[iframe same_height_as="content"]` - auto-height feature, so the height of the iframe will be the same as embedded content (works only with the same domain) (removed by default);
* **any_other_param** - allows to add new parameter of the iframe `[iframe any_other_param="any_value"]`;
* **any_other_empty_param** - allows to add new empty parameter of the iframe (like "allowfullscreen" on youtube) `[iframe any_other_empty_param=""]`;

[Iframe plugin page](http://web-profile.com.ua/wordpress/plugins/iframe/)

[CMS WordPress](http://web-profile.com.ua/wordpress/)

== Changelog ==

= 2.2 =
* fixed bug (Notice: Undefined index: same_height_as);

= 2.1 =
* added (frameborder="0") by default;

= 2.0 =
* plugin core rebuild (thanks to Gregg Tavares);
* remove not setted params except the defaults;
* added support for all params, which user will set;
* added support for empty params (like "allowfullscreen" on youtube);

= 1.8 =
* Added style parameter;

= 1.7 =
* Fixing minor bugs;

= 1.6.0 =
* Added auto-height feature (thanks to Willem Veelenturf);

= 1.5.0 =
* Using native jQuery from include directory;
* Improved "same_height_as" parameter;

= 1.4.0 =
* Added "same_height_as" parameter;

= 1.3.0 =
* Added "id" and "class" parameters;

= 1.2.0 =
* Added "output=embed" fix to Google Map;

= 1.1.0 =
* Parameter allowtransparency added (thanks to Kent);

= 1.0.0 =
* Initial release;

== Installation ==

1. Install and activate the plugin on the Plugins page;
2. Add shortcode `[iframe src="http://player.vimeo.com/video/3261363" width="100%" height="480"]` to page or post content;
