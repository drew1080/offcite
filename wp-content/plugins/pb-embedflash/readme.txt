=== pb-embedFlash ===
Contributors: pasber
Donate link: http://pascal-berkhahn.de/impressum/donation-spende/
Tags: flash, post, video, widget, sidebar, media, player, swf, flv, swfobject, shadowbox, popup, playlist, manager
Requires at least: 2.7
Tested up to: 2.7
Stable tag: 1.5.1

A filter for WordPress that displays any flash content in valid XHTML code offering the possibility to specify attributes and parameters individually. With admin panel, widget, TinyMCE popup and media & playlist manager!
 
== Description == 

** I'm sorry to announce that I'm not continuing this project anymore. I stopped blogging for several reasons and so this plugin dies with it. If somebody wants to rebirth it: feel free! I'm really sorry! **


**pb-embedFlash** is a filter for WordPress to display **any flash content** in **valid XHTML 1.0 Strict** code offering the possibility to specify attributes and parameters individually. It's easy to use but the final appearance of your embedded files can be modified heavily.

With *admin panel*, *sidebar widget*, *TinyMCE popup* and **media & playlist manager**!

**See the Installation tab for more information about the usage.**

This plugin comes with currently four ways of displaying your flash content:

* `<object>` tag
* SWFObject (JavaScript)
* Shadowbox (JavaScript, by [Michael J. I. Jackson](http://mjijackson.com/shadowbox/))
* Popup window (JavaScript)

**pb-embedFlash** primarily supports, but is not limited to...

* .swf
* .flv, .mp3, .png, .jpg, .gif and .xml playlist via JW FLV Media Player
* YouTube
* Google Video
* Revver
* SevenLoad
* Vimeo
* GUBA
* ClipFish
* MetaCafe
* MyVideo
* Veoh
* ifilm
* MySpace Videos
* Brightcove
* aniBOOM
* vSocial
* GameVideos
* VideoTube
* AOL UnCut
* grouper

Unfortunately, Blip.tv, Garage TV, Break.com, dailymotion and Yahoo! do not put the videoID into the browser URL; therefore you have grab the path to the video file from the embedding-HTML-code they offer.  

If your favorite video hoster is not listed as supported by this plugin, *you still can use it* by copying the link to the video out of the embedding code. Please give me a note if a video hoster is missing or not fully supported, thanks.   

== Installation ==
= Installation =

1. Unpack the zip archive.
2. Upload the folder `pb-embedflash` to *wp-content/plugins/*.
3. Activate the plugin in your admin panel.

= Update =

pb-embedFlash supports the automatic update function integrated in WordPress since version 2.5. To do it by your own, follow this:

1. Deactivate the plugin. This is important!
2. Delete the old files and folders.
3. Install the new version.

= Usage =

To embed flash files into your posts, please insert the URL into following code: `[flash URL VALUES]`. URL is the full address with heading http://. Possible VALUES are listed beneath.

**If you want to embed movies from YouTube, Google Video, etc., simply post the full address of the item's site.**  
Example: `[flash http://www.youtube.com/watch?v=SOME_CHARACTERS]` or `[flash http://video.google.com/videoplay?docid=SOME_NUMBERS]`.  
Width and height are set to the respective settings of the supported hoster automatically.  
**You don't need to cut sth. out of an address or HTML code!**

**flv support** is realized with [Jeroen Wijering's FLV Media Player](http://www.jeroenwijering.com/?item=JW_FLV_Media_Player), included within the plugin archive. Just use [flash URL VALUES], the flv file is detected automatically. (You have to buy a license to use that player commercially.)  

You can also embed media (`[flash medium=ID VALUES]`) and playlists (`[flash playlist=ID VALUES]`) from the media manager.
(Attention! Each flashvar overwrites his counterpart in following order: admin panel settings < media & playlist settings < flash tag settings.)


**!!! The following documentation of possible values is eased heavily by the TinyMCE popup (since v1.5) !!!**

VALUES can be one or more of these:  

* If you want to override the default values for width and hight, use the following code: `w=WIDTH h=HEIGHT`. WIDTH and HEIGHT are in pixels as number-only without unit.  

* If you want to override the default value for the class, use the following code: `class=CLASS`. CLASS is the class to be used. If you don't specify a class, the default class "embedflash" will be used.  

* To specify the style for the `<object>` without defining a class, use the following code: `style={STYLE}`. STYLE must be valid CSS code. Please ensure that you put it into {} brackets!  

* You can also display a link to the file with a specified text: `extern={TEXT|LINK}` or `extern={TEXT}`. TEXT is the text to show as link, LINK will be the target. If no LINK is given, it defaults to URL. Please ensure that you put it into {} brackets!  
Example #1: `extern={Go to YouTube}` will output: `<a href="URL" title="Go to YouTube">Go to YouTube</a>`.  
Example #2: `extern={Visit the author's website|http://domain.com/?site=home}` will output: `<a href="http://domain.com/?site=home" title="Visit the author's website">Visit the author's website</a>`  
If you are embedding a video from a hoster supported by this plugin, you can add a "Watch it at ..." link by adding `extern=1` instead.  

* If you want to specify additional parameters to the `<object>` tag, use the following code: `o={PARAMETERS}`. PARAMETERS can be one ore mutiple valid parameters for the `<object>` tag except 'data', 'width', 'height', 'class' and 'style'. Please ensure that you put it into {} brackets!  
Example: `o={tabindex="2" name="flashmovie"}` will be outputted as: `<object ... tabindex="2" name="flashmovie" ... />`  

* If you want to specify additional `<param>` tags, use the following code: `p={NAME-1;VALUE-1|NAME-2;VALUE-2|...|NAME-N;VALUE-N}`. Both NAME and VALUE have to be specified. You can add quite infinite `<param>` tags by seperating the different couples with the "|" character. Please ensure that you put it into {} bracktes!  
Example: `p={menu;false|quality;high}` will be outputted as: `<param name="menu" value="false" /><param name="quality" value="high" />`  

* You can also specify some flashvars for Jeroen Wijering's Media Player: `f={FLASHVARS}`.  
Example: `f={autostart=true&repeat=true}`. Please ensure that you connect the flashvars with ampersands (&), that you avoid whitespaces and that you put it into {} bracktes! Visit [Jeroen Wijering's website](http://www.jeroenwijering.com/?item=Supported_Flashvars) for a list of flashvars you can use.  

* `f={VARIABLES}` can also be used to give parameters with the URL for other players than JW FLV Media Player, e.g. to enable the fullscreen mode in YouTube videos.  
Example: `f={fs=1}`. Again, multiple values are connected with ampersands (&) and don't forget the {} brackets!  

* For Shadowbox and the popup window, you can specify `linktext={}` (some text or an image) and `caption={}` (text displayed inside the box).  
Example: `linktext={<img src="img/thumb/movie.gif" alt="Shadowbox" />} caption={Great movie!}`. Please ensure that you put both into {} brackets!  

* To easily use an image as link to Shadowbox or the popup window, you can specify the source of an image in `preview={URL|WIDTH|HEIGHT}`. Both WIDTH and HEIGHT are optional. The alt attribute of the image tag is set to the image filename (e.g. movie.gif).
Example: `preview={http://domain.tld/img/thumb/movie.gif|200|100}`. Please ensure that you put it into {} brackets!  

* If loading preview images from YouTube and GameVideos has been disabled by default, you can still use it by adding `preview=force`. The alt attribute of the image tag is set to "preview image".  
You can set the width and height by `pw=` and `ph=`.  

* To easily overwrite the default mode of embedding your flash content, you can specify `mode`.  
Examples: `mode=0` will use the object tag, `mode=1` refers to SWFObject, `mode=2` to SWFObject on IE only, `mode=3` to Shadowbox and `mode=4` refers to the popup window.  

== Frequently Asked Questions ==
= Need help? =
Please post your questions in a [new topic](http://wordpress.org/tags/pb-embedflash?forum_id=10#postform).

= How do I enable the YouTube player's fullscreen mode? =
To enable the fullscreen mode you need to add "f={fs=1}" to the flash tag.

= How can I disable the fullscreen feature of JW FLV Media Player? =
Simply add "f={usefullscreen=false}" to the flash tag.
[Read more](http://www.jeroenwijering.com/?item=Supported_Flashvars) about supported flashvars or use [the wizard](http://www.jeroenwijering.com/?page=wizard&example=91).

= Can I use your plugin in template files, e.g. to add flash files to my blog's header easily? =
Yes, you can call the function `pb_embedFlash_plugin()` in template files. Give it the flash tag you would normally use in posts. Attention: The function *returns* a value that you have to *echo*.

	if(function_exists('pb_embedFlash_plugin'))
	{
		echo pb_embedFlash_plugin('[flash ...]');
	}


= What is Shadowbox? =
Shadowbox is an overlay that displays likely any content (flash, videos, images, galleries, websites) - like Lightbox does for images. [More about Shadowbox](http://mjijackson.com/shadowbox/).
You can use Shadowbox as a replacement for Lightbox, it's fully compatible to the rel="lightbox" syntax, including Lightbox-style galleries.

= Why do you use Shadowbox in your plugin? =
Unlike other *box scripts, Shadowbox offers the possibility to choose what JavaScript framework should be used - so there is no crossover problem with JavaScript frameworks that brings down your website. If you already use a plugin on your blog that uses e.g. jQuery, Shadowbox just uses it, too.
So I added some options to the admin panel that let you choose what framework Shadowbox should use and whether you want to load the framework with Shadowbox. You can also decide to always load Shadowbox on your blog, e.g. as Lightbox replacement or to use the other features outside of pb-embedFlash.

= How can I switch to object tag, SWFObject, Shadowbox or popup window? =
You can decide to use one of them in the admin panel (**Settings/pb-embedFlash**) or on per-flash basis via the `mode` option.

== Screenshots ==

1. All you need is the [flash ...] tag, e.g. to add a video from YouTube ...

2. ... or your own flash file or movie with the help of the TinyMCE popup.

3. [Flashvars](http://www.jeroenwijering.com/?item=Supported_Flashvars) supported by [Jeroen Wijering's FLV Media Player](http://www.jeroenwijering.com/?item=JW_FLV_Media_Player) are available in the TinyMCE popup, too.

4. This is the widget configuration.

5. The second gameplay trailer of StarCraft II in Shadowbox.

6. This is the head of the admin panel (**Settings/pb-embedFlash**).

7. You can change the main options, ...

8. ... messages displayed on missing JavaScript or on search results, ....

9. ... Shadowbox settings and ...

10. ... the default flashvars for JW FLV Media Player.

11. Manage your media ...

12. ... and playlists easily.

== Issues ==

No issues known yet.


== Change log ==

**1.5.1** (*2008-12-12*)

* reworked the admin panel to look fine in WordPress 2.7

**1.5.0.3** (*2008-12-06*)

* added possibility to use f={} on other players than JW FLV Media Player (e.g. f={fs=1} will enable fullscreen option for the YouTube player)

**1.5.0.2** (*2008-11-20*)

* fixed broken HTML code

**1.5** (*2008-11-19*)

* added AJAX featured media & playlist manager
* added import media from WordPress multimedia manager
* added popup button for TinyMCE
* added sidebar widgets
* added Shadowbox
* added popup window for flash content
* added possibility to choose the embedding mode individually
* added the new version 3.16 of JW FLV Media Player
* added new flashvars
* added 20px to the player's height for the control bar
* improved admin panel
* renewed translation
* changes to automatic detection of video hoster platforms
* code rework

**1.4** (*2008-01-18*)

* added an options page to the admin panel
* set `allowfullscreen=true` as default for JW FLV Media Player

**1.3** (*2008-01-12*)

* added workaround for the "Click to activate" issue by using SWFObject on IE browsers.
* added the new version 3.13 of JW FLV Media Player

**1.2.3** (*2007-12-08*)

* improved extension detection
* added alternative text to feeds
* updated language files

**1.2.2** (*2007-05-23*)

* bugfixes and some code rework

**1.2.1** (*2007-05-15*)

* bugfixes

**1.2** (*2007-05-08*)

* added automatic detection of YouTube, Google Video, Revver, SevenLoad, Vimeo, GUBA, ClipFish, MetaCafe, MyVideo, Veoh, ifilm, MySpace Videos, Brightcove, aniBOOM, vSocial, GameVideos, VideoTube, AOL UnCut and grouper links. (Blip.tv, Garage TV, Break.com, AOL Video, dailymotion and Yahoo! don't put the videoIDs into the URL, you have to grab the video file path from the embedding code they offer)
* added language support via .mo files
* added extern=1 to generate a link to the video hosters easily
* changed the usage of the extern={} value
* reworked all regular expression patterns
* switched to Jeroen Wijering's FLV Media Player (also plays .mp3 music and displays .png, .jpg and .gif files; read the [documentation](http://www.jeroenwijering.com/extras/readme.html#playlists) for playlist creation)

**1.1.1** (*2007-05-03*)

* fixed style={} so that it works how documented

**1.1** (*2007-05-03*)

* added flvplayer.swf
* added .flv support via Jeroen Wijering's FLV Player
* added f={} to use flashvars for Jeroen Wijering's FLV Player

**1.0** (*2007-03-25*) - Initial release.