﻿/*	This popup script is a part of pb-embedFlash for Wordpress.
	Copyright (c) 2008 Pascal-berkhahn
*/
function pb_embedFlash_mediamanager(a,b,c){if(c==undefined){c=null}if(a=='media_import'){document.getElementById('mediaimport').style['left']=(getWindowWidth()-480)/2+'px';document.getElementById('mediaimport').style['top']=(getWindowHeight()-120)/2+'px';document.getElementById('mediaimport').style['display']='block'}if(a=='media_import_submit'){a='media_import';pb_embedFlash_ajax_mm('media_import',document.getElementById('media-add-id').value,'','','','','','','','','','',document.getElementById('media-import-items').options[document.getElementById('media-import-items').selectedIndex].value,'','')}if(a=='media_add'){pb_embedFlash_mediamanager('clear_media','','');document.getElementById('mediabox-title').innerHTML=document.getElementById('title-media-add').value;document.getElementById('mediabox').style['left']=(getWindowWidth()-480)/2+'px';document.getElementById('mediabox').style['top']=(getWindowHeight()-375)/2+'px';document.getElementById('mediabox').style['display']='block'}else if(a=='media_edit'){pb_embedFlash_mediamanager('clear_media','','');document.getElementById('media-edit-id').value=b;document.getElementById('media-url').value=document.getElementById('media-'+b+'-url-title').href;document.getElementById('media-title').value=document.getElementById('media-'+b+'-url-title').innerHTML;document.getElementById('media-author').value=document.getElementById('media-'+b+'-author').innerHTML;document.getElementById('media-album').value=document.getElementById('media-'+b+'-album').innerHTML;document.getElementById('media-attributes').value=document.getElementById('media-'+b+'-attributes').innerHTML;if(document.getElementById('media-'+b+'-image')){document.getElementById('media-image').value=document.getElementById('media-'+b+'-image').src}else{document.getElementById('media-image').value=''}if(document.getElementById('media-'+b+'-link')){document.getElementById('media-link').value=document.getElementById('media-'+b+'-link').href}else{document.getElementById('media-link').value=''}if(document.getElementById('media-'+b+'-captions')){document.getElementById('media-captions').value=document.getElementById('media-'+b+'-captions').href}else{document.getElementById('media-captions').value=''}if(document.getElementById('media-'+b+'-audio')){document.getElementById('media-audio').value=document.getElementById('media-'+b+'-audio').href}else{document.getElementById('media-audio').value=''}document.getElementById('media-type').selectedIndex=0;if(document.getElementById('media-'+b+'-type')){var i=0;var d=document.getElementById('media-'+b+'-type').innerHTML;while(document.getElementById('media-type').options[i]){if(d==document.getElementById('media-type').options[i].value){document.getElementById('media-type').selectedIndex=i;break}i++}}document.getElementById('mediabox-title').innerHTML=document.getElementById('title-media-edit').value;document.getElementById('mediabox').style['left']=(getWindowWidth()-480)/2+'px';document.getElementById('mediabox').style['top']=(getWindowHeight()-375)/2+'px';document.getElementById('mediabox').style['display']='block'}else if(a=='media_submit'){if(document.getElementById('media-edit-id').value){a='media_edit_submit';b=document.getElementById('media-edit-id').value}else{a='media_add';b=document.getElementById('media-add-id').value}pb_embedFlash_ajax_mm(a,b,encodeURIComponent(document.getElementById('media-url').value),encodeURIComponent(document.getElementById('media-title').value),encodeURIComponent(document.getElementById('media-image').value),encodeURIComponent(document.getElementById('media-author').value),encodeURIComponent(document.getElementById('media-type').value),encodeURIComponent(document.getElementById('media-link').value),encodeURIComponent(document.getElementById('media-album').value),encodeURIComponent(document.getElementById('media-captions').value),encodeURIComponent(document.getElementById('media-audio').value),encodeURIComponent(document.getElementById('media-attributes').value),'',document.getElementById('orderby').value,document.getElementById('order').value);pb_embedFlash_mediamanager('clear_media','','')}else if(a=='media_del'){pb_embedFlash_ajax_mm(a,b,'','','','','','','','','','','','','')}else if(a=='playlists_add'){pb_embedFlash_mediamanager('clear_playlists','','');document.getElementById('playlistsbox-title').innerHTML=document.getElementById('title-playlists-add').value;document.getElementById('playlistsbox').style['left']=(getWindowWidth()-480)/2+'px';document.getElementById('playlistsbox').style['top']=(getWindowHeight()-165)/2+'px';document.getElementById('playlistsbox').style['display']='block'}else if(a=='playlists_edit'){document.getElementById('playlists-edit-id').value=b;document.getElementById('playlists-title').value=document.getElementById('playlists-'+b+'-title').innerHTML;document.getElementById('playlists-attributes').value=document.getElementById('playlists-'+b+'-attributes').innerHTML;document.getElementById('playlistsbox-title').innerHTML=document.getElementById('title-playlists-edit').value;document.getElementById('playlistsbox').style['left']=(getWindowWidth()-480)/2+'px';document.getElementById('playlistsbox').style['top']=(getWindowHeight()-165)/2+'px';document.getElementById('playlistsbox').style['display']='block'}else if(a=='playlists_submit'){if(document.getElementById('playlists-edit-id').value){a='playlists_edit_submit';b=document.getElementById('playlists-edit-id').value}else{a='playlists_add';b=document.getElementById('playlists-add-id').value}pb_embedFlash_ajax_mm(a,b,'',encodeURIComponent(document.getElementById('playlists-title').value),'','','','','','','',encodeURIComponent(document.getElementById('playlists-attributes').value),'','','')}else if(a=='playlists_del'){pb_embedFlash_ajax_mm(a,b,'','','','','','','','','','','','','')}else if(a=='media_items_add'){pb_embedFlash_ajax_mm(a,getElementSelectionValue('media_items-'+b+'-select'),'','','','','','','','','','',b,'','')}else if(a=='media_items_del'){pb_embedFlash_ajax_mm(a,b,'','','','','','','','','','',c,'','')}else if(a=='media_items_up'||a=='media_items_down'){pb_embedFlash_ajax_mm(a,b,'','','','','','','','','','',c,'','')}else if(a=='clear_media'){document.getElementById('mediabox').style['display']='none';document.getElementById('media-edit-id').value='';document.getElementById('media-url').value='';document.getElementById('media-title').value='';document.getElementById('media-image').value='';document.getElementById('media-author').value='';document.getElementById('media-link').value='';document.getElementById('media-type').selectedIndex=0;document.getElementById('media-captions').value='';document.getElementById('media-audio').value='';document.getElementById('media-album').value='';document.getElementById('media-attributes').value=''}else if(a=='clear_playlists'){document.getElementById('playlistsbox').style['display']='none';document.getElementById('playlists-edit-id').value='';document.getElementById('playlists-title').value='';document.getElementById('playlists-attributes').value=''}else if(a=='clear_import'){document.getElementById('mediaimport').style['display']='none';document.getElementById('media-import-items').selectedIndex=0}}function getElementSelectionValue(a){if(document.getElementById(a)){return document.getElementById(a).options[document.getElementById(a).selectedIndex].value}else return false}function getWindowWidth(){var a=0;if(typeof(window.innerWidth)=='number'){a=window.innerWidth}else if(document.documentElement&&document.documentElement.clientWidth){a=document.documentElement.clientWidth}else if(document.body&&document.body.clientWidth){a=document.body.clientWidth}return a}function getWindowHeight(){var a=0;if(typeof(window.innerHeight)=='number'){a=window.innerHeight}else if(document.documentElement&&document.documentElement.clientHeight){a=document.documentElement.clientHeight}else if(document.body&&document.body.clientHeight){a=document.body.clientHeight}return a}function parseUri(d){var o=parseUri.options,m=o.parser[o.strictMode?"strict":"loose"].exec(d),uri={},i=14;while(i--)uri[o.key[i]]=m[i]||"";uri[o.q.name]={};uri[o.key[12]].replace(o.q.parser,function(a,b,c){if(b)uri[o.q.name][b]=c});return uri};parseUri.options={strictMode:false,key:["source","protocol","authority","userInfo","user","password","host","port","relative","path","directory","file","query","anchor"],q:{name:"queryKey",parser:/(?:^|&)([^&=]*)=?([^&]*)/g},parser:{strict:/^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,loose:/^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/)?((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/}};