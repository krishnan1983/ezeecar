/**
* @author Resalat Haque
* @link http://www.w3bees.com
*/


$(document).ready(function() {
	
	//var obj = jQuery.parseJSON( '{ "name": "John" }' );
	//alert( obj.name === "John" )
	
	
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
		//dataType:  'script',

		/* reset before submitting */
		beforeSend: function() {
			/*status.fadeOut();
			bar.width('0%');
			percent.html('0%');*/
			$('#SubmitButton').attr('disabled', ''); // disable upload button
			$("#output").html('<div style="padding:10px"><img src="/ppeditor/public/images/ajax-loader.gif" alt="Please Wait"/> <span>Uploading...</span></div>');

		},

		/* progress bar call back*/
		/*uploadProgress: function(event, position, total, percentComplete) {
			var pVel = percentComplete + '%';
			bar.width(pVel);
			percent.html(pVel);
		},*/

		/* complete call back */
		success: function(data) {  
			
			$("#output").html("");
			//$('#UploadForm').resetForm();  // reset form	
			$('#SubmitButton').removeAttr('disabled'); //enable submit button		
			$('#elm1').tinymce().execCommand('mceInsertContent',false, data);
			
		}

	});
});