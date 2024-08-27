<?php

  //retrieving smtp settinngs
  
  $result = mysqli_query($conn, "SELECT * FROM mailer_settings WHERE id=1");
  $settings = mysqli_fetch_assoc($result);
  
  if($settings){
    $smtp_id = $settings['id'];
    $smtp_host = $settings['smtp_host'];
    $smtp_port = $settings['smtp_port'];
    $smtp_password = $settings['smtp_password'];
    $smtp_username = $settings['smtp_username'];
    $from_email = $settings['from_email'];
    $from_name = $settings['from_name'];
  
  }
  
  $receiving_email_address = $smtp_username;

  if( file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php' )) {
    include( $php_email_form );
  } else {
    die( 'Unable to load the "PHP Email Form" Library!');
  }

  $contact = new PHP_Email_Form;
  $contact->ajax = true;
  
  $contact->to = $receiving_email_address;
  $contact->from_name = $_POST['name'];
  $contact->from_email = $_POST['email'];
  $contact->subject = $_POST['subject'];

  
  $contact->smtp = array(
    'host' => $smtp_host,
    'username' => $smtp_username,
    'password' => $smtp_password,
    'port' => $smtp_port
  );
  

  $contact->add_message( $_POST['name'], 'From');
  $contact->add_message( $_POST['email'], 'Email');
  $contact->add_message( $_POST['message'], 'Message', 10);

  echo $contact->send();
?>
