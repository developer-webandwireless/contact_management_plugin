$(document).ready(function() {
					 
	//var typesArray = {'website-lead': 'Website Lead',  'phone' : 'Phone', 'email' : 'Email'};

	/*function queryParams() {
    return {
        type: 'owner',
        sort: 'updated',
        direction: 'desc',
        per_page: 5,
        page: 1
    };
}*/


//datepicker
$(function() {
	$("#datepicker").datepicker({ dateFormat: "yy-mm-dd" }).val()

 });
/***** delete Action   *********/
$(".deleteContact").click(function () { 
					
					var contactData = JSON.parse($(this).closest('tr').attr('data-contact-record'));
					console.log(contactData);

					var mymodal = $('#confirm_delete_modal');
					mymodal.find('.modal-body').html('Are you sure you want to delete contact <strong>'+ contactData.name + '</strong>');
					$('#delete_confirm_button').data('id', contactData.id);	//set the data attribute on the modal button
	
	
});


$('#delete_confirm_button').click(function(){
	//alert('here');
    var ID = $(this).data('id');
	//var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>',
    $.ajax({
        url: ajaxurl,
        type: "post",
        data:{"action": "delete_action", "id": ID},
        success: function (data) {
          $("#confirm_delete_modal").modal('hide');
		  //$("#deleted").modal('show');
		  console.log( data);

		  $('#contacts-table tr[data-attr-id="'+ID+'"]').fadeOut("slow", function() {
						$(this).remove();
			});
			   
		/*$("#success-alert").show();
                window.setTimeout(function () { 
                            $("#success-alert").fadeOut(); 
		}, 2000);  */             
        }
      });

});




/***** view Action   *********/
$(".viewContact").click(function () { 
					
					var contactData = JSON.parse($(this).closest('tr').attr('data-contact-record'));
					var mymodal = $('#view_modal');
					mymodal.find('.modal-title').html('<strong>'+ contactData.name + '</strong>');
					
					mymodal.find('#contact-name').text(contactData.name);
					mymodal.find('#contact-email').text(contactData.email);
					mymodal.find('#contact-phone').text(contactData.phone);
					mymodal.find('#contact-type').text(contactData.type);

	
	
});

/***** Update Action   *********/
$(".updateContact").click(function () { 

					$("label.error").hide();
					$(".error").removeClass("error");
  
					var contactData = JSON.parse($(this).closest('tr').attr('data-contact-record'));
					var mymodal = $('#update_modal');

					console.log( contactData);

					mymodal.find('#input_contact_id').val(contactData.id);
					mymodal.find('#input_contact_name').val(contactData.name);
					mymodal.find('#input_contact_email').val(contactData.email);
					mymodal.find('#input_contact_phone').val(contactData.phone);
					
					mymodal.find('#select_contact_type option[value = ' + contactData.type + ']').attr('selected','selected');

					//mymodal.find().val(contactData.type);
					//mymodal.find('#input_contact_date_added').val(contactData.date_added);
					$("#datepicker").datepicker("setDate", contactData.date_added);

	
});

$('#form-update-contact').validate({
		rules:{
			input_contact_name:{
				required: true,
				minlength: 2
			},
			input_contact_email:{
				required: false,
				email: true
			},
			input_contact_phone:{
				required: false,
				number: true
			},

		},
		
		messages:{
			input_contact_name:{
				required: "Please enter your name",
				minlength: "your name must consist of at least 2 characters"
			},
			input_contact_email:{
				email: "Invalid email!"
			},			
			input_contact_phone:{
				email: "Invalid phone number."
			}
			
		},
		submitHandler: function(form) {
			console.log($(form).serialize());	
			$.ajax({
				url: "../wp-admin/admin-ajax.php",
				type: "post",
                data: $(form).serialize(),
				dataType: 'JSON',
				success: function(data) { 
					 $("#update_modal").modal('hide');
					console.log(data);
					var rowSelect = $("#contacts-table").find("[data-attr-id = '" + data.id + "']");
					 rowSelect.find('td:nth-child(1)').text(data.name);
					 rowSelect.find('td:nth-child(2)').text(data.email);
					 rowSelect.find('td:nth-child(3)').text(data.phone);
					 
					 for (var key in typesArray) {
							if (key === data.type){
								console.log("key " + key + " has value " + typesArray[key]);
								rowSelect.find('td:nth-child(4)').text(typesArray[key]);
								return false; 
							}
						
					}

					 rowSelect.find('td:nth-child(4)').text(data.type);
					 rowSelect.find('td:nth-child(5)').text(data.date_added);

			},
			error: function(errorThrown){
               console.log(errorThrown);
          
		  }
		});
	}
});

/***** Create new contact Action   *********/

$('#form-create-contact').validate({
		rules:{
			input_contact_name:{
				required: true,
				minlength: 2
			},
			input_contact_email:{
				required: false,
				email: true
			},
			input_contact_phone:{
				required: false,
				number: true
			},

		},
		
		messages:{
			input_contact_name:{
				required: "Please enter your name",
				minlength: "your name must consist of at least 2 characters"
			},
			input_contact_email:{
				email: "Invalid email!"
			},			
			input_contact_phone:{
				email: "Invalid phone number."
			}
			
		},
		submitHandler: function(form) {
			//console.log($(form).serialize());	
			$.ajax({
				url: ajaxurl,
				type: "post",
                data: $(form).serialize(),
				dataType: 'JSON',
				success: function(data) { 
					 $("#new_contact_modal").modal('hide');
					console.log(data);
					location.reload();
				},
			error: function(errorThrown){
               console.log(errorThrown);
          
		  }
		});
	}

});

});