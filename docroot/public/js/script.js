/**
* @author Resalat Haque
* @link http://www.w3bees.com
*/


$(document).ready(function() {
	/* variables */
	//var preview = $('img');
	var status = $('.status');
	var percent = $('.percent');
	var bar = $('.bar');

	/* only for image preview */
	/*$("#image").change(function(){
		preview.fadeOut();

		var oFReader = new FileReader();
		oFReader.readAsDataURL(document.getElementById("image").files[0]);

		oFReader.onload = function (oFREvent) {
			preview.attr('src', oFREvent.target.result).fadeIn();
		};
	});*/

	/* submit form with ajax request */
	$('form').ajaxForm({

		/* set data type json */
		dataType:  'json',

		/* reset before submitting */
		beforeSend: function() {
			status.fadeOut();
			bar.width('0%');
			percent.html('0%');
		},

		/* progress bar call back*/
		uploadProgress: function(event, position, total, percentComplete) {
			var pVel = percentComplete + '%';
			bar.width(pVel);
			percent.html(pVel);
		},

		/* complete call back */
		complete: function(data) { //alert(data.responseJSON);
			//preview.fadeOut(800);
			//var responseObj = $.parseJSON(data);
			//alert(data.status);
			//status.html(data.responseJSON.status).fadeIn();
			//status.html(data.status).fadeIn();
			
			//$('.elm1').tinymce().execCommand('mceInsertContent',false,'<img src="'+data.responseJSON.file+'"/>');
			
			//$('#elm1').tinymce().execCommand('mceInsertContent',false,'<img src="/'+data.responseJSON.file+'"/>');
			
			$('#elm1').tinymce().execCommand('mceInsertContent',false, data.responseJSON.file);
			
			
			
			//<p><a href="/sites/default/files/attachments/Web_OTS/INTERNAL-TRANSITION-DuracellPowerma.docx" target="_self"><img src="/misc/download_images/word.png" width="30" height="30" />INTERNAL-TRANSITION-DuracellPowerma.docx</a></p>-->
			
			//tinymce.execCommand('mceInsertContent',false,'<img src="/'+data.responseJSON.file+'"/>');
		}

	});
	
	
	
});