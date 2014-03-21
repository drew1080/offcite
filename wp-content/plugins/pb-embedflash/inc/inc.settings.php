<?php
/*
Part of pb-embedFlash v1.5
© Pascal Berkhahn, <novayuna@googlemail.com>, http://pascal-berkhahn.de
*/
if (!function_exists('get_option')) { echo "Please don't load this file directly."; exit; }

define('PBEF_REGEXP', '%\[flash ([\w$-.+!*\'()@:?=&/;#\%~]+)(?:[[:space:]](.*?))?\]%i');
$pbef_options = pbef_options();
$pbef_jwmp_extensions = array(1 => 'flv', 'mp3', 'png', 'jpg', 'gif', 'xml');
$pbef_hosters = array // let's build a multidimensional array containing information about video host platforms
( //  Note: the pattern will be completed with the pb_buildpattern function (to prevent general user mistypings)
	array
	( // YouTube
		'youtube\.com/watch\?v=([\w-]+)', // part of the regular expression pattern
		'http://www.youtube.com/v/###ID###', // video href
		425, // width
		355, // height
		'YouTube', // name of the hoster for extern=1: "Watch it at..."; used for preview image, too
		'http://i.ytimg.com/vi/###ID###/0.jpg' // preview image for Flashbox
	), array ( /* Google Video */ 'video\.google\..+?/videoplay\?docid=([-]?[0-9]+)', 'http://video.google.com/googleplayer.swf?docId=###ID###', 400, 326, 'Google Video', ''
	), array ( /* Revver */ 'one\.revver\.com/watch/([0-9]+)', 'http://flash.revver.com/player/1.0/player.swf?mediaId=###ID###&amp;affiliateId=0&amp;allowFullScreen=true', 480, 392, 'Revver', ''
	), array ( /* Revver */ 'revver\.com/video/([0-9]+)', 'http://flash.revver.com/player/1.0/player.swf?mediaId=###ID###&amp;width=480&amp;height=392', 480, 392, 'Revver', ''
	), array ( /* SevenLoad (en, de) */ 'sevenload\.com/videos/(\w+)', 'http://de.sevenload.com/pl/###ID###/425x350/swf', 425, 350, 'SevenLoad', ''
	), array ( /* Vimeo */ 'vimeo\.com/(?:clip:)?([0-9]+)', 'http://www.vimeo.com/moogaloop.swf?clip_id=###ID###&amp;server=www.vimeo.com&amp;fullscreen=1&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0', 400, 302, 'Vimeo', ''
	), array ( /* GUBA */ 'guba\.com/watch/([0-9]+)', 'http://www.guba.com/f/root.swf?video_url=http://free.guba.com/uploaditem/###ID###/flash.flv&amp;isEmbeddedPlayer=true', 375, 360, 'GUBA', ''
	), array ( /* ClipFish */ 'clipfish\.de/player\.php\?videoid=([a-zA-z0-9=]+)', 'http://www.clipfish.de/videoplayer.swf?as=0&amp;videoid=###ID###&amp;r=1', 464, 380, 'ClipFish', ''
	), array ( /* MetaCafe */ 'metacafe\.com/watch/([0-9]+/.+?)', 'http://www.metacafe.com/fplayer/###ID###.swf', 400, 345, 'MetaCafe', ''
	), array ( /* MyVideo */ 'myvideo\.de/watch/([0-9]+)', 'http://www.myvideo.de/movie/###ID###', 470, 406, 'MyVideo', ''
	), array ( /* Veoh */ 'veoh.com/videos/(\w+)', 'http://www.veoh.com/videodetails2.swf?permalinkId=###ID###&amp;id=anonymous&amp;player=videodetailsembedded&amp;videoAutoPlay=0', 540, 438, 'Veoh', ''
	), array ( /* ifilm */ 'ifilm.com/video/([0-9]+)', 'http://www.ifilm.com/efp?flvbaseclip=###ID###', 448, 365, 'ifilm', ''
	), array ( /* MySpace Videos */ 'vids\.myspace\.com/index\.cfm\?.+?videoid=([0-9]+)', 'http://lads.myspace.com/videos/vplayer.swf?m=###ID###&amp;type=video', 430, 346, 'MySpace Videos', ''
	), array ( /* Brightcove */ 'brightcove\.tv/title\.jsp\?title=([0-9]+)', 'http://www.brightcove.tv/playerswf?initVideoId=###ID###&amp;servicesURL=http://www.brightcove.tv&amp;viewerSecureGatewayURL=https://www.brightcove.tv&amp;cdnURL=http://admin.brightcove.com&amp;autoStart=false', 486, 412, 'Brightcove', ''
	), array ( /* aniBOOM */ 'aniboom\.com/Player\.aspx\?v=([0-9]+)', 'http://api.aniboom.com/embedded.swf?videoar=###ID###', 448, 372, 'aniBOOM', ''
	), array ( /* vSocial */ 'vsocial\.com/video/\?d=([0-9]+)', 'http://static.vsocial.com/flash/ups.swf?d=###ID###&amp;a=0', 400, 410, 'vSocial', ''
	), array ( /* GameVideos */ 'gamevideos\.com/video/id/([0-9]+)', 'http://www.gamevideos.com:80/swf/gamevideos11.swf?embedded=1&amp;fullscreen=1&amp;autoplay=0&amp;src=http://www.gamevideos.com:80/video/videoListXML%3Fid%3D###ID###%26adPlay%3Dfalse', 405, 420, 'GameVideos', 'http://download.gamevideos.com/###ID###/thumbnail.jpg'
	//), array ( /* VideoTube */ 'videotube\.de/watch/([0-9]+)', 'http://www.videotube.de/ci/flash/videotube_player_4.swf?videoId=###ID###&amp;host=www.videotube.de', 480, 400, 'VideoTube', ''
	), array ( /* AOL UnCut */ 'uncutvideo\.aol\.com/videos/(?:.+/)?(\w+)', 'http://uncutvideo.aol.com/v0.750/en-US/uc_videoplayer.swf?&amp;aID=1###ID###&amp;site=http://uncutvideo.aol.com/', 415, 347, 'AOL UnCut', ''
	), array ( /* grouper */ 'grouper\.com/video/MediaDetails\.aspx\?id=([0-9]+)', 'http://grouper.com/mtg/mtgPlayer.swf?v=1.7&amp;ap=0&amp;mu=0&amp;rf=-1&amp;vfver=8&amp;extid=-1&amp;extsite=-1&amp;id=###ID###', 400, 325, 'grouper', ''
	// some problems... - Grab the video-source from the html code the hosters offer (extern=1 not working) - using fallback to apply at least width & height
	), array ( /* BLIP.tv - videoID/Name not in URL */ 'blip\.tv/file/get/(\w+)\.flv', 'http://blip.tv/file/get/###ID###.flv', 320, 240, '', ''
	), array ( /* Yahoo! (com, de) - itemID instead of videoID in URL */ 'us\.i1\.yimg\.com/cosmos\.bcst\.yahoo\.com/player/media/swf/FLVVideoSolo\.swf\?vid=([0-9]+)', 'http://us.i1.yimg.com/cosmos.bcst.yahoo.com/player/media/swf/FLVVideoSolo.swf?vid=###ID###', 425, 350, '', ''
	), array ( /* Garage TV - videoID is encrypted in URL */ 'garagetv\.be/v/(.+)/v\.aspx', 'http://www.garagetv.be/v/###ID###/v.aspx', 430, 398, '', ''
	), array ( /* Break.com - videoID not in URL/Permalink */ 'embed\.break\.com/(\w+)', 'http://embed.break.com/###ID###', 425, 350, '', ''
	), array ( /*  dailymotion - videoID is encrypted in URL */ 'dailymotion\.com/swf/(\w+)', 'http://www.dailymotion.com/swf/###ID###', 400, 310, '', ''
	)
);

if(isset($_GET['pbef_resource']) && !empty($_GET['pbef_resource']))
{
	# base64 encoding performed http://www.greywyvern.com/code/php/binary2base64
	$pbef_resources = array(
		'paypal.png' =>
			'R0lGODlhUAAfAPcAAOr3/P///wAAACI2TZSnvenp6bu7uzNmlxs3ZCVKdhs2Y+7x9GeDotDX3hs2ZD5vnTNmlqa3yjJmlk56pSxGcODv9WJ1lE'.
			'Fxn6S+1Pf5+9Lh6z1VeidBbDlqmihDbrnQ4cHR3mN5mJmluoaasytGcJ+70p20zIKhvzJlllxxksfb6B45Zq7H2+j1+zxtnPz9/URbgEl2olWB'.
			'qqa4yiE8aFiCquf1+p6qvWuQtOTy+Ed1oebs8oSlw9Tm8Ozx9dvp8b/V5Nfo8jJYgVRpi42vyhw3ZN/t9DpSeTFLc12Grm6Stam/1HqbuzVnmc'.
			'rR3EtjhyhDbWSNstnp8tre5vn6+5apvsfN2XiJo6/B0dfl7rLL3W5/nIadtsLK1sTT4bXG1ay9zp2vw9Xf6VptjlJpjO3v87zE0U1kiObz+UZ1'.
			'oTdpmdbk7SpFbzdPd/H1+DRnlz5vnEhhhTtsmx45ZUtukuLl61FmiHWJpVB8pipEbuPn7Nfh68/e6PP19yU/alqDq0hdgnabvJa0zniOqfr7/V'.
			'qFrJekuCE9aSE7aIufttLk78nd6myTtrfH1iI9aePw92Z5l8zb5i5Hcdjh6T1Xfdbn8TZQeGmOsrPE056wxMDG01uIsNzq8t7s8+Hp8O/z99PY'.
			'4cXZ5z9vnf3+/i5Gb7zT45SnvD9Yfm+VuOLx+P7+/pKtyMXV4TtUe6zF11VqjLfI1k9nikFYfluEq7rN3NHj7nyMpm+BnURzoEd3pLLD03idvb'.
			'bI2rbO36C4zsjW43KHpMTL12h6mIibtIaVrIyfttXj7ZKmvH2evWd9m8DW5T5unTJml7jK26axwr/P3JKxy5WwybC6yra/zUZ1opmswEV0oGCI'.
			'rmqRtc/h7WqRtmqStR05ZR86ZsrZ5M7d53WYuSpDblBlh3OEoDNNdXWGodjm79nq83OZu1OAqay2xoictIqetcjc6aGtv8ve68Ta6CVAazRomd'.
			'Ld6DhqmTZqmtfm7r7U4zRNdq3B1a3C1a/D1rbH1ef0+qS4yqzG2iH5BAAAAAAALAAAAABQAB8AAAj/AAn4I0CwoMGDCBMqXMiwIUMGdLgAmEix'.
			'osWLGDNq3MixoxAuAUKKHEmypMmTKFOqXJmAQYCO7DzI5OCBBJkwHTW22PYAzoOfaVAB4VgpHZxNtO6EsBigQMuVAQAhQKBgKlUEN6CaNOICxY'.
			'GvByQcECUmJS8IB7QFCCaN5IIGTzmuCUf1jq51bBA4OIPm25cZMyI0MgIgUoQIxiiaOwzGlbwDLjB84FHvK48W7bSw2KzMxkQeX4lkfPtUpZki'.
			'CCiUCXlFrx0zeaw6UABjiqGpV0K+GKN3i4kmBy6JnIVCwgks9MAeeIPjU4AkX72cJO2S4zoFCshMRHNmqoURCE7F/4kTDzswMA4QxJqYCTupLN'.
			'iYHYA2MduFr4K2uUiCrYaaryVUcN8DtYwGl0sqpTDVGcGow1t60+gBSkhU2DJbOaDQgMAGVPRxxGw3EJKLZb/4MsFXF+ywhw8h+XDNV/uIAdwf'.
			'o0x34EsaVUCOVVVV1c0wAGhgSghPtJIXAok8QoECUNgzAnYw9HNPZWGJFRY1vQCgAhHYyBCDHF+pUAIEKOyiEXUqObGCXivQ4Ecb4zgRgDNLIu'.
			'DIERoi0EUAGyjAzQ2SKDCHJgFgAFYHHSxTwyqevHDCG1/hgsdX1mTAxFf6oITmRqZUhQ8srPBRwUQgzIEACWF0YgwJCOTxAwAKOv/AAVXJTITO'.
			'V1GosIgUaExUwgEQyHBPDlqgxYgNJ6oRypk3pnRLVVuUdJsCQ4TkDnavhESMbBTUEQAhkx7QTEngABtNABkg85UJO4A5gXM2xqWRJVVVcdExUy'.
			'HyBCVVITDIRNU4kB4CxUwED1jvXBTIVw8UkgZYpfyD60ZopiQLEht4S1IZQww8hjhItLFnAGpOBUMfIXkRgw5KZFDSPCceIAcTf+hQgxsY6BBD'.
			'PiltqlEW87yKUQVfYAICAJxosAZFzxyiQBFYUGRDED2kktE5H3ygCABS9EBYDj1IwVHFWpUdEiRTCWP22iX5nNPbE0WglwfewG23gaWxrZIqFk'.
			'DKEY4IegcegNt3F2544WQLrvjiJhFutwACTAR55ABMHjnkklc+ueSbY1654YmbLUBIo48eQOkjQU766SKh3rrppq/tONyUf/755rfnnjnul9t+'.
			'd+hrw646662z7rrxqSPP9uw5Ud47RbXbjnntz2euOejN6j187KdPTrzqlpPuvfB6M3/4+ehbRBodgxfg/vvwxy///PTXb//99C+ARQJCTMKPAQ'.
			'AMoAAHSMACGvCACEzgAQkwgAQkYAAQjKAEJ0jBClrwghjMoAYDAgA7',
		'wordpress.png' =>
			'iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAFfKj/FAAAAB3RJTUUH1wYQEiwG00adjQAAAAlwSFlzAAALEgAACxIB0t1+/AAAAARnQU1BAA'.
			'Cxjwv8YQUAAABOUExURZwMDN7n93ut1kKExjFjnHul1tbn75S93jFrnP///1qUxnOl1sbe71KMxjFrpWOUzjl7tYy13q3G5+fv95y93muczu/3'.
			'9zl7vff3//f//9Se9dEAAAABdFJOUwBA5thmAAAAs0lEQVR42iWPUZLDIAxDRZFNTMCllJD0/hddktWPRp6x5QcQmyIA1qG1GuBUIArwjSRITk'.
			'iylXNxHjtweqfRFHJ86MIBrBuW0nIIo96+H/SSAb5Zm14KnZTm7cQVc1XSMTjr7IdAVPm+G5GS6YZHaUv6M132RBF1PopTXiuPYplcmxzWk2C7'.
			'2CfZTNaU09GCM3TWw9porieUwZt9yP6tHm5K5L2Uun6xsuf/WoTXwo7yQPwBXo8H/8TEoKYAAAAASUVO'.
			'RK5CYII=',
		'author.png' =>
			'iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAgY0hSTQAAeiYAAICEAAD6AA'.
			'AAgOgAAHUwAADqYAAAOpgAABdwnLpRPAAAABh0RVh0U29mdHdhcmUAUGFpbnQuTkVUIHYzLjIyt5EXfQAAAilJREFUOE+dkttqU2EQhSfZXoTc'.
			'+wg+Rx7DIgGxlDaIYhEj2lYbij3g8UJsA96IB9CkHsCi0pqYpNqcbM1BQzBYKaZppbGNjdXUm+WaxJ00YhH8YbFnz17zMfPPtuRr+yCyLP9ztr'.
			'FXJFezI/FdcGtRMLrQkMazVUGceVPq+VMvqgbk7Q87Xn0TDM8LzBMpDeLOktTzOzWn7wSbueebBKS2bAh9FQwlW4DQ8iDG84KxNw1pfL/IDlgc'.
			'pdQfpp5WrJBk1YaZDYEn0QJoJ+/W/aj+LNWl8YMPTlxMWTG/KYhRWvOwTMBcxYbHZcFAvB3QnGdHECx6cDVrRW5LECDg7goB4XUbJlcEp6L/Bi'.
			'jrXsGJRxwn+EVwo0jAzJoNtz8J3C/bAek1H8azDkxQ6bKv2Uem7MeljODJZ4H3IwE3lwycywl6QoLKdqlpPL/gwECKo1Eam0c9rrDg8nvB6ZQF'.
			'cn3RwJm0oCtAQK0FGHvtwEluRqVxE0BPV1Bwll30xgnwFgz08efpITWx6m8a46s+jCQcGEk6oLF51KPePq73SJSAa3kD/QQc5yVOZJx/u/y2nH'.
			'rUqzWuCAFXcgbcXOEQid0BKyYLnl0h+k096tWazgABF7IGDs9yViaGeWEuGrzpTsRKfmxwXpXGmtNv6lGv1hycJmA0ZaCbG1D1cpXumOBoRHBo'.
			'WrB/qiGNNXeCrR+jp+7nPRx4RkB/zE6Tpa6O30/zfben6euY2oNfh7u45PDiyLMAAAAASUVORK5CYII%3D'
	); // $resources = array
	if(array_key_exists($_GET['pbef_resource'],$pbef_resources)) {
		$content = base64_decode($pbef_resources[ $_GET['pbef_resource'] ]);
		$lastMod = filemtime(__FILE__);
		$client = ( isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : false );
		// Checking if the client is validating his cache and if it is current.
		if (isset($client) && (strtotime($client) == $lastMod)) {
			// Client's cache IS current, so we just respond '304 Not Modified'.
			header('Last-Modified: '.gmdate('D, d M Y H:i:s', $lastMod).' GMT', true, 304);
			exit;
		} else {
			// Image not cached or cache outdated, we respond '200 OK' and output the image.
			header('Last-Modified: '.gmdate('D, d M Y H:i:s', $lastMod).' GMT', true, 200);
			header('Content-Length: '.strlen($content));
			header('Content-Type: image/' . substr(strrchr($_GET['resource'], '.'), 1) );
			echo $content;
			exit;
		}	
	}
}
?>