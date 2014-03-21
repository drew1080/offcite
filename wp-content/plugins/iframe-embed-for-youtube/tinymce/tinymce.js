function init() {
	tinyMCEPopup.resizeToInnerSize();
}

function insertIEFYLink() {
	
	var tagtext;
	
		var videourl = document.getElementById('videourl').value;
		if (videourl != '' )
			tagtext = "[yframe url='" + videourl + "']";
		else
			tinyMCEPopup.close();
	
	if(window.tinyMCE) {
		//TODO: For QTranslate we should use here 'qtrans_textarea_content' instead 'content'
		window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tagtext);
		//Peforms a clean up of the current editor HTML. 
		//tinyMCEPopup.editor.execCommand('mceCleanup');
		//Repaints the editor. Sometimes the browser has graphic glitches. 
		tinyMCEPopup.editor.execCommand('mceRepaint');
		tinyMCEPopup.close();
	}
	return;
}
