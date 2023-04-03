jQuery(document).ready(function($) {		
	"use strict";		
	
	//IE8 PNG FIX
		var i;
		for (i in document.images) {
			if (document.images[i].src) {
				var imgSrc = document.images[i].src;
				if (imgSrc.substr(imgSrc.length-4) === '.png' || imgSrc.substr(imgSrc.length-4) === '.PNG') {
					document.images[i].style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled='true',sizingMethod='crop',src='" + imgSrc + "')";
				}
			}
		}
		
});