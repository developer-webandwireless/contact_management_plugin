<?php 
/* @package manage-contacts */
/* A simple contact management plugin to keep track of the lead*/
/*
Plugin Name: Contact Management	
Description: A simple app to keep track of your contacts in the databse
Author: Rajal Bhave
Version: 0.1
*/

require_once('contact.class.php');

class ManageContacts extends WP_Widget{
	
	
	public function __construct(){
		$params = array(
		'name' => 'Contact Management',
		'description' => 'A simple app to keep track of your leads'
		);
		parent::__construct('ManageContacts', '', $params);
		
	}
	
/*
 * Creates all WordPress pages needed by the plugin.
 */
public static function plugin_activated() {
    // Information needed for creating the plugin's pages
        // Check that the page doesn't exist already
        $query = new WP_Query( 'pagename=manage-contacts' );
        if ( ! $query->have_posts() ) {
            // Add the page using the data from the array above
            wp_insert_post(
                array(
                    'post_content'   => '[manage_contacts]',
                    'post_name'      => 'manage-contacts',
                    'post_title'     => 'Manage Contacts',
                    'post_status'    => 'publish',
                    'post_type'      => 'page',
                    'ping_status'    => 'closed',
                    'comment_status' => 'closed',
                )
            );
        }
    
}

}
	
/*
 * Creates WordPress tables.
 */
function contacts_table_install() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'contacts';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id bigint(20)  AUTO_INCREMENT,
		name varchar(250) NOT NULL,
		email varchar(100) NOT NULL,
		phone bigint(20)  NOT NULL,
		message text NOT NULL, 
		date_added date NOT NULL, 
		type varchar(250) NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
	//echo $wpdb->last_error;  

}
	
function manageContacts(){
	if(is_user_logged_in()){
		global $wpdb;

		$contact = new Contact($wpdb);
		$contacts = $contact -> getContacts();
		$contact_type_array = array('website-lead' => 'Website Lead', 'phone' => 'Phone', 'email' => 'Email');
		include 'allContacts.php' ;
		//	$form_html = '';
	}else{
				//wp_redirect( home_url( '/login/' ) );
				include 'contactsLogin.php' ;
				
	}
}


//create shortcode
add_shortcode('manage_contacts','manageContacts');

/*
 *   Styles and scripts
 */
 //Bootstrap style

wp_register_style( 'bootstrap.min', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' );
wp_enqueue_style('bootstrap.min');


//Google Jquery
wp_register_script( 'jquery.min', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js' );
wp_enqueue_script('jquery.min');

//Bootstrap Scripts
wp_register_script( 'bootstrap.min', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js' );
wp_enqueue_script('bootstrap.min');

//validation script
wp_register_script('jquery-validation', 'https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js');
wp_enqueue_script('jquery-validation');

//datepicker css
wp_register_style('css-ui', 'http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css');
wp_enqueue_style('css-ui');

//datepicker script
wp_register_script('jquery-ui', 'http://code.jquery.com/ui/1.10.3/jquery-ui.js');
wp_enqueue_script('jquery-ui');

//data table stylesheet
wp_register_style( 'datatables.min', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.1/bootstrap-table.min.css' );
wp_enqueue_style('datatables.min');


/*//data table script
wp_register_script( 'datatables.min', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.1/bootstrap-table.min.js' );
wp_enqueue_script('datatables.min');

//data table script2
wp_register_script( 'datatables.min', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.1/locale/bootstrap-table-zh-CN.min.js' );
wp_enqueue_script('datatables.min');*/


//custom stylesheet
wp_register_style('custom_style', plugins_url('/style.css', __FILE__));
wp_enqueue_style('custom_style');


//custom javascript
wp_register_script('custom_script', plugins_url('/jquery.js', __FILE__));
wp_enqueue_script('custom_script');

//register widget with WordPress
add_action('widgets_init', 'register_contacts');
function register_contacts(){
	register_widget('ManageContacts');
}
		
// Create the custom pages at plugin activation
register_activation_hook( __FILE__, array( 'ManageContacts', 'plugin_activated' ) );

// Create contacts plugin at plugin activation
register_activation_hook( __FILE__, 'contacts_table_install' );

//Add admin_ajax file
add_action('wp_head', 'contactsplugin_ajaxurl');
function contactsplugin_ajaxurl() {

   echo '<script type="text/javascript">
           var ajaxurl = "' . admin_url('admin-ajax.php') . '";
         </script>';
}


	
?>