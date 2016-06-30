<?php

include(dirname(dirname(dirname(dirname(__FILE__)))).'/wp-load.php');

$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

//$tempid = $_POST['template'];

$data =  $_POST['form_data'];

//$searcharray=array();
parse_str($_POST['form_data'], $searcharray);

//print_r($searcharray);

     global $wpdb;

        $table_name = $wpdb->prefix ."BuilderUX";

        $table_namedata = $wpdb->prefix ."BuilderUXdata";

    global $add_my_script;


    $add_my_script = true;


    global $wpdb;


  $table_name = $wpdb->prefix ."BuilderUX";

  $mypost = $searcharray["builder"];

    
  $form_field_show = $searcharray["form-field-show"];

  $form_field_default = $searcharray["form-field-default"];

 $newdata = array(

                   // 'templateid'=> $_POST["template"],

                    'showtext'=> json_encode($form_field_show),

                    'defaultext' => json_encode($form_field_default),

                  // 'guid' => $searcharray["builder"]['guid'],

                   // 'wsdl' => $searcharray["builder"]['wsdl'],

                );

 $guid = $searcharray["builder"]['guid'];

 $wsdl = $searcharray["builder"]['wsdl'];

//$template = $_POST["templatename"];



$field_showtext = json_encode($form_field_show);

$field_defaulttext = json_encode($form_field_default);

//print_r($field_showtext);

//$wpdb->replace($table_name,$newdata,array('%s'));

$myselection = $wpdb->get_results("SELECT * FROM " . $table_name);

//print_r($myselection);

if(empty($myselection)){

$option_name = 'buildername';

$new_value = $form_field_default['BuilderName'];

 

if ( get_option( $option_name ) != $new_value ) {

update_option( $option_name, $new_value );

} else {

$deprecated = '';

$autoload = 'no';

add_option( $option_name, $new_value, $deprecated, $autoload );

}





}else{

foreach($myselection as $result_row){

$template = $result_row->templateid;

$showtext = json_decode($result_row->showtext,true);

$showtext['BuilderName'] = $form_field_show['BuilderName'];

$showtext['Community'] = $form_field_show['Community'];

$showtext['ValidateByEmail'] = $form_field_show['ValidateByEmail'];

$showtext = json_encode($showtext);



$defaultext =  json_decode($result_row->defaultext,true);

$defaultext['BuilderName'] = $form_field_default['BuilderName'];

$defaultext['Community'] = $form_field_default['Community'];

$defaultext['ValidateByEmail'] = $form_field_default['ValidateByEmail'];

$defaultext = json_encode($defaultext);

$defaultext;

//$redirect_page = $_POST['redirect_page'];

$update = "UPDATE `$table_name` 

SET `showtext` = '$showtext', 

`defaultext` = '$defaultext'";

$option_name = 'buildername';

$option_guid = 'guid';

$option_wsdl= 'wsdl';


$new_value = $form_field_default['BuilderName'];

if ( get_option( $option_name ) != $new_value ) {

update_option( $option_name, $new_value );

} else {

$deprecated = '';

$autoload = 'no';

add_option( $option_name, $new_value, $deprecated, $autoload );

}

mysqli_query($con, $update) or die(mysqli_error());

$table_builder_lead_settings = $wpdb->prefix ."builder_lead_settings";

$update2 = "UPDATE `".$table_builder_lead_settings."` SET `guid` = '$guid', `wsdl` = '$wsdl'";
 
mysqli_query($con, $update2);


$update3 = "UPDATE `".$table_name."` SET `guid` = '$guid', `wsdl` = '$wsdl'";

mysqli_query($con, $update3);

}

}