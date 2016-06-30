//var dialog = jQuery( "#dialog-builder" );
var mysubdivision = "";
var myemail = "";
var beback = false;
var submitform = false;


/*dialog.dialog({
      autoOpen: false,
      height: 300,
      width: 400,
      modal: true,
      buttons: {
        "Save": savebeback,
        Cancel: function() {
          dialog.dialog( "close" );
        }
      },
      close: function() {
        dialog.dialog( "close" );
      }
});*/

function addjs(js) {
	var headID = document.getElementsByTagName("head")[0];         
	var newScript = document.createElement('script');
	newScript.type = 'text/javascript';
	newScript.src = js;
	headID.appendChild(newScript);
}

function checkemail(){
	
	var email = $('input[name="builder[Email]"]').val();
	var Subdivision = $("input[name='builder[CommunityNumber]']").val();
	var url = $('input[name="builder[checkemail]"]').val()+"?Email="+email+"&CommunityNumber="+Subdivision;
	var ret = 1;
	$.ajax({
        type: "GET",
        url: url,
        async: false
    }).done(function (data) {
    	console.log(data);
    	if(data=='1') {
    		alert('Thank you for coming back ....');
    		ret = 1;
    	} else {
    		ret = 0;
    	}
    });
    if(ret)
    	return false;
    else
    	return true;
}

function getEmail(Email,Subdivision){
	var url = $('input[name="builder[checkemail]"]').val()+"?Email="+Email+"&CommunityNumber="+Subdivision;
	console.log(Email);
	console.log(Subdivision);
	console.log(url);
	$.ajax({
        type: "GET",
        url: url,
        async: false
    }).done(function (data) {
    	console.log(data);
    	return data;
    } )
}
function reveal(myobject){

    id = myobject.id;	
     
	jQuery('#customize'+id).slideToggle('500', "linear", function () {
		// Animation complete.
		 if (jQuery('#customize').is(':visible'))
				jQuery('#customize').css('display','inline-block');
		
	});
}
var forms = document.getElementsByTagName('form');
for (var i = 0; i < forms.length; i++) {
       
        forms[i].noValidate = false;
        if(forms[i].name=="builder-contact-form") {
            formid = forms[i].id;
          
                jQuery("#"+formid).validate();
            
        }
};

function validateForm(formid) {

    $('#'+formid).validate();
}

/*function checkbeback(e){	
		
    if(e.value!=""){
				
        var data = {
            action: 'my_beback',
            subdivision: jQuery("#"+e.id).attr("rel"),
            email: e.value

        };

        mysubdivision = jQuery("#"+e.id).attr("rel");	
		
		myemail = e.value;
		   
        jQuery.post(MyAjax.ajaxurl,data,function(response)
	    {
            console.log("response" + response);
			if(response == "True" || response == "true") {
				beback=true;
                dialog.dialog("open");
                return true;
            } else if(response=="" || response=='False' || response == 'false') {
                beback=false;
       	        if(submitform)
                    jQuery("#builder-contact-form-"+myformid).submit();
            } else {
                  console.log(response);
                  submitform = false;
                  beback = false;
            }
        }); 
    }
}

function savebeback(){   
    var data = {
            action: 'my_beback_save',
            subdivision: mysubdivision,
            email: myemail,
            notes: jQuery("#bebacknote").val()
    };
		
    jQuery.post(MyAjax.ajaxurl,data,function(response){
        alert("BeBack Note Submitted...");
        jQuery(".builder-contact-form").trigger("reset");
        jQuery("bebacknote").val("");
        submitform = false;
    });
	
    dialog.dialog("close");
}*/