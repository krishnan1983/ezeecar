$(document).ready(function()
{
	 
    var options = { 
   		
	    /*beforeSerialize: function($form, options) { 
	        // return false to cancel submit  
	    	
	    	var queryString = $('#uploadForm .specialFields').fieldSerialize();
	    	
	    },*/	    
	    beforeSubmit:function(formData, jqForm, options) 
	    {	
	    	if(validate()){
		    	$('#uploadBtn').attr('disabled', ''); // disable upload button
		   	 	$("#output").html('<div><img src="/public/images/ajax-loader.gif" alt="Please Wait"/> <span>Uploading...</span></div>');
		    }else
		    	return false;
	    	
	    	return false;
	    },
	    //data: { key1: 'value1', key2: 'value2' },
	    success: function(data) 
	    {	
	    	$("#output").html("");
			$('#UploadForm').resetForm();  
			$('#uploadBtn').removeAttr('disabled'); //enable submit button		
			$('#elm1').tinymce().execCommand('mceInsertContent',false, data);			
	    },
	    error: function()
	    {
	        $("#output").html("<font color='red'> ERROR: unable to upload files</font>");
	 
	    }
 
    }; 
    
    $('#uploadBtn').click(function() {         	
    	$("#uploadForm").ajaxSubmit(options);
        return false; 
    }); 
    
    $('#saveGuide').click(function() {     	
    	$("#uploadForm").submit(); 
        //return false; 
    }); 
    
    // bind to the form's submit event 
    $('#sendGuide').click(function() { 
    	$("#uploadForm").submit(); 
        //return false; 
    }); 
    
    
    $("#metaDataRow").hide();
	
	_getTemplateData();	
	
	$( "#TemplateId" ).change(function() {
		_getTemplateData();
	});		
	
	$( "#docType" ).change(function(e) {
		
		$doctype =  $("#docType").val();
		if($doctype == 0){								
			alert("Please select a type");
			 e.preventDefault();
		}
		else if($doctype == 2){				
			$("#metaDataRow").show();
		}else {
			
			$("#metaDataRow").hide();
		}
			
	});
	
	$( "#docType" ).change(function(e) {
		
		$doctype =  $("#docType").val();
		if($doctype == 0){								
			alert("Please select a type");
			 e.preventDefault();
		}
		else if($doctype == 2){				
			$("#metaDataRow").show();
		}else {
			
			$("#metaDataRow").hide();
		}
			
	});

});

function validate() 
{
	 var formValid = true; 
		
	 if(!$("#filename").val()){					 
		 alert("Please upload document firsts");
		 formValid = false; 					 
	 }
	 var docType = $("#docType").val();
	 if(docType == 0){					 
		 alert("Please select type");
		 formValid = false; 					 
	 }
	 if(docType == "2"){ 					 					
		 if (!$('#metaData').val()){
			 alert("Enter Meta keywords separated by , (exp. processguide, playbook). Max 15 keywords");						 
			 formValid = false; 					 
	 	}else{ 			 		
	 		if(!_countMeta(15))
	 			 formValid = false; 		
	 	}					 
	 }		 	 
	 //console.log(formValid);
	 if(formValid === false)
		 return false;
 		
	 return true;
}

_countMeta = function(count){ 
	
	var value = $('#metaData').val();
	var words = value.split(",");

    if(words.length > count){
        alert("Max 15 keywords are permitted");
        return false;
    }
    return true;
	
}

_getTemplateData = function(){ 
	
	$TemplateId =  $("#TemplateId").val(); 
	dataParams = "TemplateId="+$TemplateId;
	$.ajax({
		type: "POST",
		url: "/author/template-content",
		data: dataParams,
		beforeSend: function() {
			$('.status').fadeOut();
		},
		success: function(response) {
			$('.status').hide();
			$('#elm1').html(response);
		}
	});

}