<?php 

class Contact{
	//private $name;
	//private $email;

	public $table_name ; 
	public $wpdb ; 


public function __construct($wpdb){
	$this->table_name = $wpdb->prefix . 'contacts';
	$this->wpdb = $wpdb;

}

public function getContacts($order = 'date_added')
{		
		//	echo 'table name = '. $this->table_name;
		$rows = $this->wpdb->get_results( "SELECT * FROM {$this->table_name} ORDER BY {$order} DESC"  );
		$i=0;
		foreach ($rows as $row) {
			$contacts[$i]['id'] = $row->id;
			$contacts[$i]['name'] = $row->name ;
			$contacts[$i]['email'] = $row->email ;
			$contacts[$i]['phone'] = $row->phone ;
			$contacts[$i]['type'] = $row->type ;
			$contacts[$i]['date_added'] = $row->date_added ;
			$i++;
			
		}
		return $contacts;
}


public function getContact($id){
	//select * from contacts where id =  $id
	$row = $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM {$this->table_name} WHERE id = %d", $id));
			
			$contact['id'] = $row->id;
			$contact['name'] = $row->name ;
			$contact['email'] = $row->email ;
			$contact['phone'] = $row->phone ;
			$contact['type'] = $row->type ;
			$contact['date_added'] = $row->date_added ;
			
			return $contact;
}

public function updateContact($id, $name, $email, $phone, $type, $date_added)
{
	//update contacts name = $name, email = $email
	$this->wpdb->update($this->table_name, 
						array('name'=>$name, 'email'=>$email, 'phone'=>$phone, 'date_added'=>$date_added, 'type'=>$type), array('id'=>$id));
}

public function addContact($name, $email, $phone, $type){
	//insert into contacts
	$date =  date('Y-m-d');
	$this->wpdb->insert( $this->table_name, 
						array('name'=>$name, 'email'=>$email, 'phone'=>$phone, 'date_added' => $date, 'type'=>$type) );
	$lastInsertId = $this->wpdb->insert_id; 
	return $lastInsertId;
	
}


public function deleteContact($id){
	//delete from contact
	$this->wpdb->query( "DELETE FROM {$this->table_name} WHERE id = {$id}" );
	
}


}

?>