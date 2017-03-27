<div class="container"  style="margin-top: 40px; ">
<div class="center-block"  id="custom-login" style="min-width: 500px; text-align: center;">

<h3> You need to Login to acces this area</h3>
<?php 
  //$login_page  = home_url( '/manage-contacts' );
 //echo  'url =  '. $_SERVER['REQUEST_URI'] .' '.$login_page;
 //echo  'url =  '. $current_url .' '.$login_page;
	
$login  = (isset($_GET['login']) ) ? $_GET['login'] : 0;
if ( $login === "failed" ) {
  echo '<p class="error"><strong>ERROR:</strong> Invalid username and/or password.</p>';
} elseif ( $login === "empty" ) {
  echo '<p class="error"><strong>ERROR:</strong> Username and/or Password is empty.</p>';
} elseif ( $login === "false" ) {
  echo '<p class="error"><strong>ERROR:</strong> You are logged out.</p>';
}
?>
<?php
$args = array(
    'redirect' => home_url(), 
    'id_username' => 'user',
    'id_password' => 'pass',
   ) 
;?>

<?php  wp_login_form(); 

?>
</div></div>