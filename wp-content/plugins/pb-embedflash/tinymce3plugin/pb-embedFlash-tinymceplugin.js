function init()
{
	tinyMCEPopup.resizeToInnerSize();
} 

function getElementSelection(itm)
{
	if (document.getElementById(itm))
	{
		return document.getElementById(itm).options[document.getElementById(itm).selectedIndex].value;
	} else return;
}

function insertFlashCode()
{
	var URL = document.getElementById('flashURL').value;

	if ((URL != '' && URL != null)
		|| (document.getElementById('optMMPlaylists').checked == true && getElementSelection('selMMPlaylists') != 0)
		|| (document.getElementById('optMMMedia').checked == true && getElementSelection('selMMMedia') != 0)
	)
	{
		var Width = document.getElementById('flashWidth').value;
		var Height = document.getElementById('flashHeight').value;

		var Preview = document.getElementById('flashPreview').value;
		var PreviewWidth = document.getElementById('flashPreviewWidth').value;
		var PreviewHeight = document.getElementById('flashPreviewHeight').value;
		var Linktext = document.getElementById('flashLinktext').value;
		var Caption = document.getElementById('flashCaption').value;

		var optImage = document.getElementById('optImage').value;
		var optId = document.getElementById('optId').value;
		var optBackcolor = document.getElementById('optBackcolor').value;
		var optFrontcolor = document.getElementById('optFrontcolor').value;
		var optLightcolor = document.getElementById('optLightcolor').value;
		var optScreencolor = document.getElementById('optScreencolor').value;
		var optLogo = document.getElementById('optLogo').value;
		var optDisplayheight = document.getElementById('optDisplayheight').value;
		var optDisplaywidth = document.getElementById('optDisplaywidth').value;
		var optAudio = document.getElementById('optAudio').value;
		var optBufferlength = parseInt(document.getElementById('optBufferlength').value);
		var optCaptions = document.getElementById('optCaptions').value;
		var optFallback = document.getElementById('optFallback').value;
		var optRotatetime = parseInt(document.getElementById('optRotatetime').value);
		var optVolume = parseInt(document.getElementById('optVolume').value);
		var optCallback = document.getElementById('optCallback').value;
		var optLink = document.getElementById('optLink').value;
		var optLinktarget = document.getElementById('optLinktarget').value;
		var optJavascriptid = document.getElementById('optJavascriptid').value;
		var optRecommendations = document.getElementById('optRecommendations').value;
		var optStreamscript = document.getElementById('optStreamscript').value;
	
		var exp = /^\d+(%|px)?$/;

		var flashCode = '[flash ';
		if (document.getElementById('optMMPlaylists').checked == true) { flashCode += 'playlist='+getElementSelection('selMMPlaylists'); }
		else if (document.getElementById('optMMMedia').checked == true) { flashCode += 'medium='+getElementSelection('selMMMedia'); }
		else { flashCode += URL; }

		if (exp.test(Width) == true) { flashCode += ' w='+Width; }
		if (exp.test(Height) == true) { flashCode += ' h='+Height; }
		if (document.getElementById('flashForcePreview').checked == true) {
			flashCode += ' preview=force';
		} else {
			if (Preview != '' && Preview != null) {
				flashCode += ' preview={'+Preview;			
				if (exp.test(PreviewWidth) == true && exp.test(PreviewHeight) == true) {
					flashCode += '|'+PreviewWidth+'|'+PreviewHeight 
				}
				flashCode += '}';	
			}
			if (Linktext != '' && Linktext != null) { flashCode += ' linktext={'+Linktext+'}'; }
		}
		var Mode = getElementSelection('selMode');
		if (Mode != '') { flashCode += ' mode='+Mode; }
		if (Caption != '' && Caption != null) { flashCode += ' caption={'+Caption+'}'; }

		var Vars = '';
		if (optImage != '' && optImage != null) { 				Vars += '&image='+optImage; }
		if (optId != '' && optId != null) { 					Vars += '&id='+optId; }
		if (document.getElementById('optSearchbar').checked == true) { 		Vars += '&searchbar='+getElementSelection('selSearchbar'); } // def: true
		if (optBackcolor != '' && optBackcolor != null) { 		Vars += '&backcolor='+optBackcolor; }
		if (optFrontcolor != '' && optFrontcolor != null) { 	Vars += '&frontcolor='+optFrontcolor; }
		if (optLightcolor != '' && optLightcolor != null) { 	Vars += '&lightcolor='+optLightcolor; }
		if (optScreencolor != '' && optScreencolor != null) { 	Vars += '&screencolor='+optScreencolor; }
		if (optLogo != '' && optLogo != null) { 				Vars += '&logo='+optLogo; }
		if (document.getElementById('optOverstretch').checked == true) { 	Vars += '&overstretch='+getElementSelection('selOverstretch'); } // def: false
		if (document.getElementById('optShoweq').checked == true) { 		Vars += '&showeq='+getElementSelection('selShoweq'); } // def: false
		if (document.getElementById('optShowicons').checked == true) { 		Vars += '&showicons='+getElementSelection('selShowicons'); } // def: true
		if (document.getElementById('optTransition').checked == true) { 	Vars += '&transition='+getElementSelection('selTransition'); } // def: random
		if (document.getElementById('optShownavigation').checked == true) { Vars += '&shownavigation='+getElementSelection('selShownavigation'); } // def: true
		if (document.getElementById('optShowstop').checked == true) { 		Vars += '&showstop='+getElementSelection('selShowstop'); } // def: false
		if (document.getElementById('optShowdigits').checked == true) { 	Vars += '&showdigits='+getElementSelection('selShowdigits'); } // def: true
		if (document.getElementById('optShowdownload').checked == true) { 	Vars += '&showdownload='+getElementSelection('selShowdownload'); } // def: false
		if (document.getElementById('optUsefullscreen').checked == true) { 	Vars += '&usefullscreen='+getElementSelection('selUsefullscreen'); } // def: true
		if (document.getElementById('optAutoscroll').checked == true) { 	Vars += '&autoscroll='+getElementSelection('selAutoscroll'); } // def: false
		if (exp.test(optDisplayheight) == true) { 				Vars += '&displayheight='+optDisplayheight; }
		if (exp.test(optDisplaywidth) == true) { 				Vars += '&displaywidth='+optDisplaywidth; }
		if (document.getElementById('optThumbsinplaylist').checked == true) { Vars += '&thumbsinplaylist='+getElementSelection('selThumbsinplaylist'); } // def: false
		if (optAudio != '' && optAudio != null) { 				Vars += '&audio='+optAudio; }
		if (document.getElementById('optAutostart').checked == true) { 	Vars += '&autostart='+getElementSelection('selAutostart'); } // def: false
		if (exp.test(optBufferlength) == true) { 						Vars += '&bufferlength='+optBufferlength; }
		if (optCaptions != '' && optCaptions != null) { 				Vars += '&captions='+optCaptions; }
		if (optFallback != '' && optFallback != null) { 				Vars += '&fallback='+optFallback; }
		if (document.getElementById('optRepeat').checked == true) { 	Vars += '&repeat='+getElementSelection('selRepeat'); } // def: false
		if (exp.test(optRotatetime) == true) { 							Vars += '&rotatetime='+optRotatetime; }
		if (document.getElementById('optShuffle').checked == true) { 	Vars += '&shuffle='+getElementSelection('selShuffle'); } // def: true
		if (document.getElementById('optSmoothing').checked == true) { 	Vars += '&smoothing='+getElementSelection('selSmoothing'); } // def: true
		if (optVolume>=0 && optVolume<=100) { 							Vars += '&volume='+optVolume; }
		if (optCallback != '' && optCallback != null) { 				Vars += '&callback='+optCallback; }
		if (document.getElementById('optEnablejs').checked == true) { 	Vars += '&enablejs='+getElementSelection('selEnablejs'); } // def: true
		if (optLink != '' && optLink != null) { 						Vars += '&link='+optLink; }
		if (document.getElementById('optLinkfromdisplay').checked == true) { Vars += '&linkfromdisplay='+getElementSelection('selLinkfromdisplay'); } // def: false
		if (optLinktarget != '' && optLinktarget != null) { 			Vars += '&linktarget='+optLinktarget; }
		if (optJavascriptid != '' && optJavascriptid != null) { 		Vars += '&javascriptid='+optJavascriptid; }
		if (optRecommendations != '' && optRecommendations != null) { 	Vars += '&recommendations='+optRecommendations; }
		if (optStreamscript != '' && optStreamscript != null) { 		Vars += '&streamscript='+optStreamscript; }
		if (document.getElementById('optType').checked == true) { 		Vars += '&type='+getElementSelection('selType'); } // def: false

		if (Vars != '') { flashCode += ' f={'+Vars.substr(1)+'}'; }
		flashCode += ']';

		if (window.tinyMCE)
		{
			window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, flashCode);
			//Peforms a clean up of the current editor HTML. 
			//tinyMCEPopup.editor.execCommand('mceCleanup');
			//Repaints the editor. Sometimes the browser has graphic glitches. 
			tinyMCEPopup.editor.execCommand('mceRepaint');
		}
	}
	tinyMCEPopup.close();
} // insertFlashCode