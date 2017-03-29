<div class="container"  style="margin-top: 40px; margin-bottom: 20px;">

<h3>View, Add, Update and Delete contact details.</h3>
<div class="col col-xs-6 ">
		<!--a class="" href="#"><span class="flagContact"></span></a-->
	<select class="form-control input-sm" style="width: auto; display: inline;">
		<option selected disabled value="">Bulk Action</option>
		<option value="1">Flag</option>
		<option value="2">Delete</option>
	</select>     
 <button type="button" class="btn btn-small" style="margin-right: 10px;"> Apply </button>

</div>

<div class="col col-xs-6 text-right">
 
 <div class="col col-md-6 ">
 <input type="text" id="input_search" name="input_search" class="form-control" placeholder="Search..." style="width: auto;">
 </div>
 <div class="col col-md-6 ">
    <button type="button" class="btn btn-primary newContact"
		data-toggle="modal" data-target="#new_contact_modal" >Create New Contact</button>
</div>
</div>
<!--div class="alert alert-success collapse" id="success-alert" style="">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <strong> Contact Deleted ! </strong>
</div-->
</div>

<div class="container">
<div class="table-responsive">
 <table id="contacts-table" class="table table-striped table-bordered dataTable" >
		<!--data-toggle="table" data-query-params="queryParams" 
		data-pagination="true" data-sort-order="asc"
		data-search="true" --> 
        <thead>  
          <tr>  
			<th>&nbsp;<input type="checkbox" name="name1" />&nbsp;</th>
			<th>Name</th>
			<th >Email</th> 
			<th >Phone </th>
			<th >Type </th>
			<th >Date Added </th>
			<th colspan ="4" class="action"> Action</th>


          </tr>  
        </thead>  
        <tbody>  
          
			<?php
						$i = 1;   
						foreach ($contacts as $contact_record) {
							//echo "<pre>"; var_dump($contact_record);echo "</pre>"; 
							//echo json_encode($contact_record);
							$contactData =  htmlentities(json_encode($contact_record));
						
							echo "<tr data-attr-id = '". $contact_record['id']."' data-contact-record = '". $contactData."'>";
							echo '<th>&nbsp;<input type="checkbox" name="name1" />&nbsp;</th>';
							echo '<td>'.  $contact_record['name'] . ' </td>'; 
							echo '<td>'.  $contact_record['email'] . ' </td>'; 
							echo '<td>'.  $contact_record['phone'] . ' </td>'; 
							
							foreach ($contact_type_array as $key => $value) {
								
								if ( strcmp($key, $contact_record['type']) == 0) {
									$contact_type = $value; break;
								}
								else $contact_type = $contact_record['type'];
							}
							echo '<td>'.  $contact_type . '</td>';
							
							$newDate = date("d - M - Y", strtotime($contact_record['date_added']));
							
							echo '<td>'. $newDate . '</td>';
														
							$flag= plugin_dir_url( __FILE__ )."images/flag-icon.png";
							$flag_fill= plugin_dir_url( __FILE__ )."images/flag-icon-fill.png";

							echo '<td class="action"><a class="flagContact" href="#">
								
								<img  src="'.$flag.'" class="flagImg '.(($contact_record['flag']!= 0)?'hide"':'"').'/>
								<img  src="'.$flag_fill.'" class="flagImg '.(($contact_record['flag']== 0)?'hide"':'"').'/>
							</a></td>';

							echo '<td class="action"><a										
								 class="viewContact glyphicon glyphicon-plus" href="#"
								 data-toggle="modal" data-target="#view_modal"></a></td>';
							
							echo '<td class="action"><a 
							class="updateContact glyphicon glyphicon-pencil" href="#"
							data-toggle="modal" data-target="#update_modal" ></a></td>';
							
							echo '<td class="action"><a 
							class="deleteContact glyphicon glyphicon-trash" href="#"  
							data-toggle="modal" data-target="#confirm_delete_modal" ></a></td></tr>';
							
							$i++;
						}
			?>
        </tbody>  
      </table> 
</div>	  
</div>


 <!--  CREATE CONTACT MODAL -->
  <!-- Modal -->
  <div class="modal fade" id="new_contact_modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Create new contact</h4>
        </div>
		<form id="form-create-contact"  name="form-create-contact" method="post" action="#">
		 <fieldset> 
        <div class="modal-body">
				<table class="table table-borderless" id="update-contact-table">
						<tr>
							<td class="table-label"> <label for ="input_contact_name">Name : </label> </td>
							<td >
							<input type="text" id="input_contact_name" name="input_contact_name" class="form-control" required/> </td>
						</tr>
						<tr>
							<td class="table-label"><label for ="input_contact_email"> Email : </label></td>
							<td > <input type="text" id="input_contact_email" name="input_contact_email" class="form-control"/> </td>
						</tr>
						<tr>
							<td class="table-label"><label for ="input_contact_phone"> Phone : </label></td>
							<td > <input type="text" id="input_contact_phone" name="input_contact_phone" class="form-control"/> </td>
						</tr>
						<tr>
							<td class="table-label"><label for ="select_contact_type"> Type : </label></td>
							<td > 
							<select  id="select_contact_type" name="select_contact_type" class="form-control">
							<?php foreach ($contact_type_array as $key => $value) {?>
								<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
							<?php } ?>
							</select>
							</td>
						</tr>

				</table>
        </div>
        <div class="modal-footer">
					<input type="hidden" name="action" value="add_action"/>
					<input  type="submit"  class="btn btn-primary" id ="create_contact_button" name="create_contact_button" value="Add"/>
		            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
		 </fieldset> </form>
      </div>
      
    </div>
  </div>


 <!--  DELETE MODAL CONFIRM-->
  <!-- Modal -->
  <div class="modal fade" id="confirm_delete_modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Delete Contact</h4>
        </div>
        <div class="modal-body">
<!--  are you sure you want to delete -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		  <button type="button" class="btn btn-primary" id ="delete_confirm_button">Confirm</button>
        </div>
      </div>
      
    </div>
  </div>


 
 <!--  VIEW CONTACT  MODAL-->
  <!-- Modal -->
  <div class="modal fade" id="view_modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>

        <div class="modal-body">
				<table class="table table-borderless" id="view-contact-table">
						<tr>
							<td class="table-label"> Name : </td>
							<td id="contact-name">  </td>
						</tr>
						<tr>
							<td class="table-label"> Email : </td>
							<td  id="contact-email">  </td>
						</tr>
						<tr>
							<td class="table-label"> Phone : </td>
							<td  id="contact-phone">  </td>
						</tr>
						<tr>
							<td class="table-label"> Type : </td>
							<td  id="contact-type">  </td>
						</tr>

				</table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>


 <!--  UPDATE CONTACT MODAL -->
  <!-- Modal -->
  <div class="modal fade" id="update_modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Update Contact Details</h4>
        </div>
		<form id="form-update-contact"  name="form-update-contact" method="post" action="#">
        <div class="modal-body">
				<table class="table table-borderless" id="update-contact-table">
						<tr>
							<td class="table-label">  <label for ="input_contact_name">Name : </label> </td>
							<td > <input type="text" id="input_contact_name" name="input_contact_name" class="form-control"/> </td>
						</tr>
						<tr>
							<td class="table-label"> <label for ="input_contact_email">Email : </label> </td>
							<td > <input type="text" id="input_contact_email" name="input_contact_email" class="form-control"/> </td>
						</tr>
						<tr>
							<td class="table-label"> <label for ="input_contact_phone"> Phone : </label> </td>
							<td > <input type="text" id="input_contact_phone" name="input_contact_phone" class="form-control"/> </td>
						</tr>
						<tr>
							<td class="table-label"><label for ="select_contact_type"> Type : </label></td>
							<td > 
							<select  id="select_contact_type" name="select_contact_type" class="form-control">
							<?php foreach ($contact_type_array as $key => $value) {?>
								<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
							<?php } ?>
							</select>
							</td>
						</tr>
						<tr>
							<td class="table-label"> <label for ="input_contact_date_added"> Date Added : </td>
							<td > <input type="text"  id="datepicker"  name="input_contact_date_added" class="form-control"/> </td>
						</tr>

						
				</table>
				
        </div>
        <div class="modal-footer">
					<input type="hidden" id="input_contact_id" name="input_contact_id" class="form-control"/>
					<input type="hidden" name="action" value="update_action"/>
					<input  type="submit"  class="btn btn-primary" id ="update_contact_button" name="update_contact_button" value="Update"/>
		            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

        </div>
		</form>
      </div>
      
    </div>
  </div>


 