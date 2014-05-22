var exists = false;

var options = { 
	    
	    beforeSubmit:function(formData, jqForm, options) 
	    {	
	    	if(validate()){
		    	$('#uploadBtn').attr('disabled', true); // disable upload button
		   	 	$("#output").html('<div><img src="/public/images/ajax-loader.gif" alt="Please Wait"/> <span>Uploading...</span></div>');
		    }else
		    	return false;
	    	
	    	//return false;
	    },
	    success: function(data) 
	    {	
	    	$("#output").html("");
			//$('#UploadForm').resetForm();  
			$('#metaData').val(''); 
			$('#docType').val('0'); 
			$('#filename').replaceWith('<input id="filename" type="file" name="filename">');	
			$("#metaDataRow").hide();
			$('#uploadBtn').removeAttr('disabled'); //enable submit button		
			$('#elm1').tinymce().execCommand('mceInsertContent',false, data);			
	    },
	    error: function()
	    {
	        $("#output").html("<font color='red'> ERROR: unable to upload files</font>");
			//$('#uploadBtn').attr('disabled', false);
			$('#uploadBtn').removeAttr('disabled');
	    }
 
    }; 


var PP = {		
		
	playbook : 
	{
		init : function() {		
			
			$("#metaDataRow").hide();

			var previous;

		    $("#folder").one('focus', function () {
		        // Store the current value on focus and on change
		        previous = this.value;
		    }).change(function() {
		        // Do something with the previous value after the change
		       // alert(previous);
		        
		        if(previous != ''){ 
					 var res = confirm("You will lose all your data once you change the template, as it will be overridden with the new template content. Are you sure")					
					 if(res == true)
						_getTemplateData();						
				}else
					_getTemplateData();	
		        
		        // Make sure the previous value is updated
		        previous = this.value;
				
		    });
		    
			//create guide form validation
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
			
			$('#uploadBtn').click(function() {         	
				$("#uploadForm").ajaxSubmit(options);
				return false; 
			}); 
			
			$('#saveGuide').click(function() {  
			
				if(!validatePlaybook())
					return false;
				
				$("#action").val("saveGuide");
				$('#uploadForm').attr({action: "/author/create-guide"});
				$("#uploadForm").submit(); 
				
			}); 
			
			$('#preview').click(function() {  	
				
				window.open('/request/preview', '_blank');
				
			}); 
			
			$('#sendGuide').click(function() { 
				
				if(!validatePlaybook())
					return false;
					
				$("#action").val("sendGuide");
				$('#uploadForm').attr({action: "/author/create-guide"});
				$("#uploadForm").submit(); 

			});
			
			$( "#name" ).blur(function() {
			
				if($("#name").val()!=""){	
					
					if($("#documentname").val()!=$("#name").val())
					{	
					duplicateDoc($( "#name" ).val());	
					}else
						{
						$("#duplicate").html("<font color='green'> Name is available</font>");
						duplicateDoc(exists = false);
						}
				}				
			});
				
		},
		_delete : function(row, document_id) { 
			
			if(typeof(remove)==='undefined') remove = "y";
			 
			$.ajax({
				type: "POST",
				url: "/author/delete-guide",
				data: $.param({'doc_id': document_id, 'type': 'p'}),
				beforeSend: function() {
					 return confirm("Are you sure?");
					 $('#deleteBtn').attr('disabled', ''); 
					 //$("#output").html('<div style="padding:10px"><img src="/ppeditor/public/images/ajax-loader.gif" alt="Please Wait"/> <span>Uploading...</span></div>'				
				},
				success: function(data){  
					if(data == "success") {
						if(remove == 'y'){
							row.closest('tr').remove(); 						
						}
					}
				},
				error: function (xhr, status, error) {
					alert('Status: ' + status + ' Error: ' + error);
				}
			});
			
		}

	},
	adminEdit:
	{
		
		init : function() {		
		
		$("#metaDataRow").hide();
	
		/*if($("#edit").val() == '0'){ 
			_getTemplateData();	
		}*/
		
		$( "#folder" ).change(function() {
			
			if($("#folder").val() != ''){ 
				 var res = confirm("You will lose all your data once you change the template, as it will be overridden with the new template content. Are you sure")
				
				 if(res == true)
					_getTemplateData();
				
			}
		});	
		
		//create guide form validation
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
		
		$('#uploadBtn').click(function() {         	
			$("#uploadForm").ajaxSubmit(options);
			return false; 
		}); 
		
		$('#saveGuide').click(function() {  
		
			if(!validatePlaybook())
				return false;
			
			$("#action").val("saveGuide");
			//$('form').get(0).setAttribute('action', '/author/create-guide');	
			$('#uploadForm').attr({action: "/admin/edit-document"});
			$("#uploadForm").submit(); 
			
		}); 
		
		$('#preview').click(function() {  		
			window.open('/request/preview', 'new');			
		}); 
	
		/*$( "#name" ).blur(function() {
			duplicateDoc($( "#name" ).val());			  
		});*/
			
	}
		
	},
	
	editRequest : 
	{
		init : function() {		
			
		    $("#assign").change(function() {
		    	
		    	if(this.value != ''){
		    		
		    		if($('#Status').val() == "1")
		    			$('#Status').val('5');
		    	}
		       
		    });
		
		}
	},

	message : 
	{
		init : function() {		
		
			$('#submit').click(function() {  
			
				if(!$("#message").val()){					 
					 alert("Please enter message");
					 return false; 			 
				 }

			});
			
			$('#cancel').click(function() {  
				
				var href = $(".back").parent().attr('href');//alert(href);
				//window.location.href = '/author/requests';
				window.location.href = href;
				return false;

			});		
			
		}
		
		
	},
	
	config : 
	{
		init : function() {		
		
			$('#submit').click(function() {  
			
				if(!$("#OpsSpecialistName").val()){					 
					 alert("Please enter Ops Specialist Name");
					 return false; 			 
				 }
				if(!$("#OpsSpecialistEmailId").val()){					 
					 alert("Please enter Ops Specialist EmailId");
					 return false; 			 
				 }
				if(!IsEmail($("#OpsSpecialistEmailId").val()))
				{
					alert("Please enter valid Ops Specialist EmailId");
					return false;
				}
				if(!$("#TechAgencyLeadName").val()){					 
					 alert("Please enter Tech Agency Lead Name");
					 return false; 			 
				 }
				if(!$("#TechAgencyLeadEmailId").val()){					 
					 alert("Please enter Tech Agency Lead EmailId");
					 return false; 			 
				 }
				if(!IsEmail($("#TechAgencyLeadEmailId").val()))
				{
					alert("Please enter valid Tech Agency Lead EmailId");
					return false;
				}
				if(!$("#TechAgencyDeveloperName").val()){					 
					 alert("Please enter Tech Agency Developer Name");
					 return false; 			 
				 }
				if(!$("#TechAgencyDeveloperEmailId").val()){					 
					 alert("Please enter Tech Agency Developer EmailId");
					 return false; 			 
				 }
				if(!IsEmail($("#TechAgencyDeveloperEmailId").val()))
				{
					alert("Please enter valid Tech Agency Developer EmailId");
					return false;
				}

			});
									
		}
		
		
	},
	
	
	sendtota : 
	{
		init : function() {		
		
			$('#submit').click(function() {  
			
				if(!$("#message").val()){					 
					 alert("Please enter message");
					 return false; 			 
				 }

			});
									
		}
		
		
	},
	
	sendmsg : 
	{
		init : function() {		
		
			$('#submit').click(function() {  
			
				if(!$("#message").val()){					 
					 alert("Please enter message");
					 return false; 			 
				 }

			});
									
		}
		
		
	},
	
	sendRequest : 
	{
		init : function() {		
		
			$('#submit').click(function() {  
			
				if(!$("#message").val()){					 
					 alert("Please enter message");
					 return false; 			 
				 }

			});
			
			/*$('#cancel').click(function() {  
			
				window.location.href = '/author/documents';
				return false;

			});	*/
			
		}
		
		
	},
	template : 
	{
		init : function() {		
		
			$('#submit').click(function() {  
				
				if(!validateTemplate())
					return false;
				else
					$("#createtemplate").submit(); 

			}); 
						
			$('#cancel').click(function() {  
			
				window.location.href = '/admin/templates';
				return false;

			});
			
			$('#preview').click(function() {  
				
				window.open('/request/preview', '_blank');
				
			}); 
			
		},
		
		_tempdelete : function(row, template_id) { 
			
			if(typeof(remove)==='undefined') remove = "y";
			 
			$.ajax({
				type: "POST",
				url: "/admin/delete-temp",
				data: $.param({'temp_id': template_id}),
				beforeSend: function() {
					
					 return confirm("Are you sure?");
					 $('#deleteBtn').attr('disabled', ''); // disable upload button
					 //$("#output").html('<div style="padding:10px"><img src="/ppeditor/public/images/ajax-loader.gif" alt="Please Wait"/> <span>Uploading...</span></div>'				
				},
				success: function(data){  
					if(data == "success") {
						if(remove == 'y'){
							row.closest('tr').remove(); 						
						}
					}
				},
				error: function (xhr, status, error) {
					alert('Status: ' + status + ' Error: ' + error);
				}
			});
			
		}
	
	
	},
	document : 
	{
		init : function() {		
		
			$('#submit').click(function() {  
			
				if(!validateDocument())
					return false;

			}); 
			
			$('#cancel').click(function() {  
			
				window.location.href = '/author/documents';
				return false;

			});
		
		},		
		_delete : function() {		
		
			$('#submit').click(function() {  
			
				if(!$("#message").val()){					 
					 alert("Please enter message");
					 return false; 			 
				 }

			});
			
			$('#cancel').click(function() {  
			
				window.location.href = '/author/documents';
				return false;

			});		
		
		}	
		
		
	}
}

$(document).ready(function()
{
	 
	$( "label.required" ).after( "<span style='color:red'> * </span>" );	
  
});

function IsEmail(email) {
	  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	  return regex.test(email);
	}
		
function validatePlaybook(){ 

	if(!$("#name").val()){					 
		alert("Please enter name");
		return false;	
	}
	if($("#name").val()!=""){	
		if(exists == true)
		 return false;
			
	}
	if($("#folder").val() == "" && ($("#edit").val() == '0')){					 
		alert("Please select master template:");		
		return false;			
	}	
	if(!$("#elm1").val()){					 
		 alert("Please enter message for TA");
		 return false;					 
	}
	return true;			
}

function validateDocument(){

	if(!$("#name").val()){					 
		 alert("Please enter document name");
		 return false;				 
	}
	if($("#folder").val() == ""){					 
		 alert("Please select folder");		
		return false;		
	}	
	if(!$("#uploadedfile").val()){					 
		 alert("Please upload file");
		return false;
	}
	if(!$("#metaData").val()){					 
		 alert("Please enter meta keywords"); 	
		return false;
	}
	if($("#metaData").val()){	
		if(!_countMeta(15))
			return false;
	}
	if(!$("#message").val()){					 
		 alert("Please enter message for TA"); 	
		return false;
	}

	return true;
		
}

function validateTemplate(){

	if(!$("#templatename").val()){					 
		 alert("Please enter template name");
		 return false;				 
	}
	if($("#templatetype").val() == "0"){					 
		 alert("Please select Type");		
		return false;		
	}	
	if(!$("#elm1").val()){					 
		 alert("Please enter content");
		return false;
	}
	
	return true;
		
}

function validate() 
{	
	var docType = $("#docType").val();
	 if(docType == 0){					 
		 alert("Please select type");
		return false;		
	 }
	 if(docType == "2"){ 					 					
		 if (!$('#metaData').val()){
			 alert("Enter Meta keywords separated by comma (exp. process guide, playbook). Max 15 keywords");						 
			return false;
	 	}else{ 			 		
	 		if(!_countMeta(15))
				return false;		
	 	}					 
	 }	
	 
	 if(!$("#filename").val()){					 
		 alert("Please upload file");
		return false;
	 }
	
	 return true;
}

_countMeta = function(count){ 
	
	var value = $('#metaData').val();
	var words = value.split(",");

    if(words.length > count){
        alert(" Max 15 keywords are permitted");
        return false;
    }
    return true;
	
}

_getTemplateData = function(){ 
	
	$folder =  $("#folder").val(); 
	if($folder!=""){
		dataParams = "folder="+$folder;
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
	}else
		$('#elm1').html("");

}

function duplicateDoc(name){ 

	$.ajax({	
	
		type: "POST",
		url: "/author/duplicate",
		data: $.param({'docName': name}),
		beforeSend: function() {				
			 $("#duplicate").html('<div><img src="/public/images/ajax-loader.gif" alt="Please Wait"/> <span>Uploading...</span></div>');
		},
		success: function(data){  
		
			if(data > 0){
				$("#duplicate").html("<font color='red'> Name already exists, please try another name</font>");
				exists = true;
				//set_exists(true);
				
			}else{
			
				$("#duplicate").html("<font color='green'> Name is available</font>");
				//set_exists(false);
				exists = false;
				
				}
		},
		error: function (xhr, status, error) {
			//alert('Status: ' + status + ' Error: ' + error);
		}
	});

}