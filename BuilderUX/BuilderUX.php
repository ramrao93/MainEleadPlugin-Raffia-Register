<?php

/*** @package BuilderUX

 * @version 1.1

Plugin Name: BuilderUX

Plugin URI: 

Description:

Version: 1

*/

function BuilderUX_activate() 
{

    // add options, build db tables, etc

        global $wpdb;

        $table_name = $wpdb->prefix ."BuilderUX";

        $table_namedata = $wpdb->prefix ."BuilderUXdata";
		
		$table_builder_lead_settings = $wpdb->prefix ."builder_lead_settings";

        $sqlinsert = 'insert into '. $table_namedata. '(fieldname,leadname,labelname) values("FirstName","FirstName","First Name"),

                               ("LastName","LastName","Last Name"),("Phone","Phone","Phone"),("Email","Email","Email Address"),

                               ("StreetAddress","StreetAddress","Street Address"),("City","City","City"),

                               ("state","State","State"),("PostalCode","PostalCode","Postal Code"),

                               ("Demo1txt","Demo1txt","Demo1txt"),("Community","Community","Community"),

                              	("BuilderName","BuilderName","BuilderName"),

                               ("ValidateByEmail","ValidateByEmail","ValidateByEmail")';

							   
        $sqlinsert1 = 'insert into '. $table_builder_lead_settings. '(guid,wsdl) values( "BA466E0E-388C-4789-9E6B-7DF2369BF4D2","http://sandbox.salessimplicity.net/sb_wci/svcEleads/eleads.asmx?WSDL")';
    

        if ( $wpdb->get_var('SHOW TABLES LIKE "' . $table_name.'"') != $table_name )

        {

                $sql = 'CREATE TABLE ' . $table_name . '( 

                                templateid varchar(255) NOT NULL,

                                showtext LONGTEXT,

                                requiredtext LONGTEXT,

                                labeltext LONGTEXT,

                                hiddentext LONGTEXT,

                                defaultext LONGTEXT,

                                selectiontext LONGTEXT,

                                typetext LONGTEXT,

                                iscustomize LONGTEXT,

                                redirect_page LONGTEXT,

                                error_page LONGTEXT,

                                classtext LONGTEXT,

                                fieldtype LONGTEXT,

                                guid LONGTEXT,

                                wsdl LONGTEXT,

                                title varchar(255),

                                header_text LONGTEXT,

								sequence LONGTEXT,

                                button_text varchar(255), 

                                button_format int(2),

								coloumn_style int(11),

                                date_last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

                                PRIMARY KEY (templateid))';



                 $sql2 = 'CREATE TABLE ' . $table_namedata . '( 

                                fieldname varchar(255) not null,

                                leadname varchar(255),

                                labelname varchar(255),

								sequence LONGTEXT,

                                date_last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

                                PRIMARY KEY  (fieldname) )';
								
								
				$sql3 = 'CREATE TABLE ' .$table_builder_lead_settings .'( 

                                id int(11) not null AUTO_INCREMENT,
								
								guid TEXT,
								
								wsdl TEXT,
                                 
                                PRIMARY KEY  (id))';
												                  

                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

                dbDelta($sql);

                dbDelta($sql2);

				dbDelta($sql3);
				
                $wpdb->query($sqlinsert);
				$wpdb->query($sqlinsert1);

                add_option('BuilderUX_database_version','1.0');


           } else {

              // check if fields are present

           try {

                $wpdb->query($sqlinsert);

           } catch(Execption $e){

           }
        }

}
function BuilderUX_deactivate() {
  // add options, build db tables, etc
}
register_activation_hook(__FILE__,"BuilderUX_activate");
register_deactivation_hook(__FILE__,"BuilderUX_deactivate");
add_action('init', 'register_my_script');
add_action('wp_footer', 'print_my_script');

function register_my_script() {

    wp_register_script('my-script', 'https://ajax.googleapis.com/ajax/libs/jquery/1.10.0/jquery.min.js', array('jquery'), '1.0', true);

    wp_register_script('soap', plugins_url('/js/jquery.soap.js', __FILE__), array('jquery'), '1.0', true);

    wp_register_script( 'validate-script', plugins_url( '/js/jquery.validate.min.js', __FILE__ ),'','','true' );

    wp_register_script( 'builder-ux', plugins_url( '/js/builderux.js', __FILE__ ),'','','true' );

	wp_register_style( 'custom-css', plugins_url( '/css/builderux.css', __FILE__ ),'','','all' );
	
	wp_register_style( 'custom-form-css', plugins_url( '/css/regi_form.css', __FILE__ ),'','','all' );

}
function print_my_script() {

    global $add_my_script;

    if (! $add_my_script)
    return;

    wp_print_scripts('my-script');

    wp_print_scripts('soap');

    wp_print_scripts('validate-script');

    wp_print_scripts('builder-ux');

	wp_print_styles('custom-css');
	
	wp_print_styles('custom-form-css');
}

function builderux_css(){

   wp_register_style( 'custom-css', plugins_url( '/css/builderux.css', __FILE__ ) );
   
   wp_enqueue_style( 'custom-css' );

}

add_action( 'wp_enqueue_scripts', 'builderux_css' );

function builderux_css_and_js() {

wp_register_style('builderux_css_and_js', plugins_url('css/bootstrap.min.css',__FILE__ ));

wp_enqueue_style('builderux_css_and_js');


// wp_register_script( 'BuilderUX_css_and_js', plugins_url('js/your_script.js',__FILE__ ));
// wp_enqueue_script('BuilderUX_css_and_js');

}
add_action('admin_print_styles', 'builderux_css_and_js');

if (isset($_GET['page']) && ($_GET['page'] == 'BuilderUX-plugin')) 
{ 

    // if we are on the plugin page, enable the script

    add_action('admin_print_styles', 'builderux_css_and_js');

}

function BuilderUX_option_page()
{
       global $wpdb;
	   
	   $table_builder_lead_settings = $wpdb->prefix ."builder_lead_settings";
	   
       $other_settings = $wpdb->get_row('SELECT * FROM '.$table_builder_lead_settings.'');
	   	   
	   $guid = $other_settings->guid;
	   
	   $wsdl = $other_settings->wsdl;	
	     
	   	      
       //$guid = "BA466E0E-388C-4789-9E6B-7DF2369BF4D2";

       //$wsdl = "http://sandbox.salessimplicity.net/sb_wci/svcEleads/eleads.asmx?WSDL";
      

       $table_name = $wpdb->prefix ."BuilderUX";

       $table_namedata = $wpdb->prefix ."BuilderUXdata";


        $title = "";

        $redirect_page = "";

        $button_text = "Submit";

        $header_text = "";

        $error_page = "";
		

    if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST'){

	$option_name = 'guid';

    $new_value = $guid ;

	if ( get_option( $option_name ) != $new_value ) {

    update_option( $option_name, $new_value );

    } else {

    $deprecated = '';

    $autoload = 'no';

    add_option( $option_name, $new_value, $deprecated, $autoload );

    }

    $option_name = 'wsdl';

    $new_value = $wsdl ;

    if ( get_option( $option_name ) != $new_value ) {

    update_option( $option_name, $new_value );

    } else {

    $deprecated = '';

    $autoload = 'no';

    add_option( $option_name, $new_value, $deprecated, $autoload );

    }

if($_POST['redirect_page']){

$option_name = 'redirect_page_status_'.$_POST["templatename"];

    $new_value = 'on';

    if ( get_option( $option_name ) != $new_value ) {

    update_option( $option_name, $new_value );

    } else {

    $deprecated = '';

    $autoload = 'no';

    add_option( $option_name, $new_value, $deprecated, $autoload );

    }

}else{

$option_name = 'redirect_page_status_'.$_POST["templatename"];

    $new_value = 'off';

    if ( get_option( $option_name ) != $new_value ) {

    update_option( $option_name, $new_value );

    } else {

    $deprecated = '';

    $autoload = 'no';

    add_option( $option_name, $new_value, $deprecated, $autoload );

    }

}

    $mypost = $_POST["builder"];

    if(isset($mypost["fieldname"]) && $mypost["fieldname"]) {

          $newdata = array(

			  'fieldname'=>$mypost["fieldname"],

			  'leadname'=>$mypost["leadname"],

			  'labelname'=>$mypost["labelname"]

			);

           $wpdb->INSERT($table_namedata,$newdata,array('%s'));

        }

        $form_field_show = $_POST["form-field-show"];
    
            if(count($form_field_show) > 0) {


                $form_field_required = $_POST["form-field-required"];

                $form_field_selected = $_POST["form-field-selected"];

				$form_field_sequence= $_POST["form-field-sequence"];

                $form_field_label = $_POST["form-field-label"];

                $form_field_hide = $_POST["form-field-hide"];

                $form_field_default = $_POST["form-field-default"];

                $form_field_class = $_POST["form-field-class"];  

                $form_field_type = $_POST["form-field-type"];

                $form_field_customize = $_POST["form-field-customize"];

				

				$form_field_sequence = array_filter($_POST["form-field-sequence"], create_function('$a','return preg_match("#\S#", $a);'));

				

                //print_r($form_field_default);

				

				/*echo '<pre>';

				print_r($_POST);

				echo '</pre>';*/

				

                $newdata = array(

                    'templateid'=> $_POST["templatename"],

					'sequence'=>json_encode($form_field_sequence),

                    'showtext'=> json_encode($form_field_show),

                    'requiredtext'=> json_encode($form_field_required),

                    'labeltext'=> json_encode($form_field_label),

                    'selectiontext'=> json_encode($form_field_selected),

                    'defaultext' => json_encode($form_field_default),

                    'hiddentext' => json_encode($form_field_hide),

                    'iscustomize'=> json_encode($form_field_customize),

                    'title' => $_POST["builder"]["title"],

                    'classtext' => json_encode($form_field_class),

                    'fieldtype' => json_encode($form_field_type),

                    'header_text' => $_POST['builder']['header_text'],

                    'button_text' => $_POST['builder']['button_text'],

					'coloumn_style' => $_POST['builder']['coloumn_style'],

                    'guid' => $guid,

                    'wsdl' => $wsdl,

                    'redirect_page' => $_POST['builder']['redirect_page'],

                    'error_page' => $_POST['builder']['error_page'],

                    'button_format' => $_POST['builder']['button']

                );

				//print_r($newdata);

				

//$redirect_page_status = $_POST['']

 try { 

    $wpdb->replace($table_name,$newdata,array('%s'));

    if($wpdb->insert_id == 0) {

            $wpdb->update($table_name,$newdata,array('templateid'=> $_POST["templatename"]));

			 
			// echo'<pre>';

			// print_r( $wpdb);

			// echo'</pre>';

			 

        }

 } catch (Exception $Ex){

        print_r($Ex);

 }

// echo '<pre>';print_r($_POST);echo '</pre>';

if(isset($_POST['thankyoutext'])){

$thankyoutext = $_POST['thankyoutext'];

$option_name = 'thankyoutext_'.$_POST["templatename"];

$new_value = $thankyoutext ;

if ( get_option( $option_name ) != $new_value ) {

update_option( $option_name, $new_value );

} else {

$deprecated = '';

$autoload = 'no';

add_option( $option_name, $new_value, $deprecated, $autoload );

}

}

                //json_encode($form_field_selected);

                $myselection = $wpdb->get_row("SELECT * FROM " . $table_name." where templateid ='". $_POST["templatename"]."'");

           

		    

                $template_name = $myselection->templateid;

				

				$option_name = 'thankyoutext_'.$template_name;

				$thankyoutext = get_option( $option_name );

        

                $showtext = json_decode($myselection->showtext,true);

                $requiredtext = json_decode($myselection->requiredtext,true);

				$sequence_value = json_decode($myselection->sequence,true);

                $labeltext = json_decode($myselection->labeltext,true);

                $selectiontext = json_decode($myselection->selectiontext,true);

                $classtext = json_decode($myselection->classtext,true);

                $typetext = json_decode($myselection->fieldtype,true);

                $customizetext = json_decode($myselection->iscustomize,true);

                $button_text = $myselection->button_text;

				$coloumn_style = $myselection->coloumn_style;

                $title = $myselection->title;

                $header_text = $myselection->header_text;

                $guid = $myselection->guid;

                $hiddentext = json_decode($myselection->hiddentext,true);

                $defaultext = json_decode($myselection->defaultext,true);

                $wsdl = $myselection->wsdl;

                $redirect_page = $myselection->redirect_page;

                $error_page = $myselection->error_page;

                //$button = $myselection->button_format;

              //  echo '<pre>';print_r($customizetext);echo'</pre>';

                $button = 3;

                $redirect_pagestatus = get_option('redirect_page_status_'.$_POST["templatename"]);

                if($redirect_pagestatus == 'on'){

                        $show_checkbox = 'checked="checked"'; $c_status = 'block';

                        $display_type_red ='style="display:block;"';

                        $display_type_thnk ='style="display:none;"';

                        }else{

                        $show_checkbox = ''; $c_status = 'none';

                        $display_type_red ='style="display:none;"';

                        $display_type_thnk ='style="display:block;"';

                }

            }

    } /** -- end of if post **/



    if (strtoupper($_SERVER['REQUEST_METHOD']) == 'GET'){

    

            $delete = $_GET["delete"];

            if($delete){

                $id = $_GET["id"];

                

                $wpdb->delete( $table_name, array( 'templateid' => $id ), array( '%s' ) );



            } 



                $fid = $_GET["fid"]; 

            if($fid)

                    $wpdb->delete( $table_namedata, array( 'fieldname' => $fid ), array( '%s' ) );



                $id = $_GET["id"];

            if($id && !$delete) {

                    $myselection = $wpdb->get_row("SELECT * FROM " . $table_name." where templateid ='". $id."'");

               

			        // echo '<pre>';print_r($myselection);echo'</pre>';

                    $template_name = $myselection->templateid;

					

					$option_name = 'thankyoutext_'.$template_name;

					$thankyoutext = get_option( $option_name );

                

                    $showtext = json_decode($myselection->showtext,true);

                    $requiredtext = json_decode($myselection->requiredtext,true);

					$sequence_value = json_decode($myselection->sequence,true);

                    $labeltext = json_decode($myselection->labeltext,true);

                    $selectiontext = json_decode($myselection->selectiontext,true);

                    $classtext = json_decode($myselection->classtext,true);

                    $typetext = json_decode($myselection->fieldtype,true);

                    $customizetext = json_decode($myselection->iscustomize,true);

                    $button_text = $myselection->button_text;

					$coloumn_style = $myselection->coloumn_style;

                    $title = $myselection->title;

                    $header_text = $myselection->header_text;

                    $guid = $myselection->guid;

                    $hiddentext = json_decode($myselection->hiddentext,true);

                    $defaultext = json_decode($myselection->defaultext,true);

                    $wsdl = $myselection->wsdl;

                    $redirect_page = $myselection->redirect_page;

                    $error_page = $myselection->error_page;

                    $button = $myselection->button_format;

                    

					//echo '<pre>';print_r($customizetext);echo'</pre>';

            }

                $redirect_pagestatus = get_option('redirect_page_status_'.$template_name);

                if($redirect_pagestatus == 'on'){

                        $show_checkbox = 'checked'; $c_status = 'block';

                        $display_type_red ='style="display:block;"';

                        $display_type_thnk ='style="display:none;"';

                }else{

                        $show_checkbox = ''; $c_status = 'none';

                        $display_type_red ='style="display:none;"';

                        $display_type_thnk ='style="display:block;"';

                }

       

     } /** end of if get **/

    ?>



    <div class="wrap">



    <?php screen_icon(); ?>



    <h2>BuilderUX</h2>



    <p>Welcome BuilderUX Plugin.</p>



    <div class="row">

        <div class="col-md-7">

        <form class="form-horizontal" id="validation-form" method='POST'>

            <div class="left">

                    <button class="btn btn-success" type="submit">Save Template</button>

             </div>

    <p>

            

            <div class="col-md-4">Template Name</div>

            <div class="col-md-8">

            <div class="form-group">

            <input type="text" id="filenamex" name="templatename" value="<?php echo $template_name; ?>"  class="form-control" required="required"></div></div>

            <div class="col-md-4">Redirect Page</div>   

              <div class="col-md-8">

            <div class="form-group active"><input type="checkbox" id="filenamex" name="redirect_page"  class="form-control redirect_page"  <?php echo $show_checkbox; ?>> 

                </div></div>

        <div class="col-md-4 rdp" <?php echo $display_type_red; ?>>Redirect Page URL</div>   

              <div class="col-md-8 rdp" <?php echo $display_type_red; ?>>

            <div class="form-group"><input type="text" id="filenamex" name="builder[redirect_page]" value="<?php echo $redirect_page ?>"  class="form-control redirect_pager">  

                </div></div>

            <div class="col-md-4 rdpt" <?php echo $display_type_thnk; ?>>Thank you Text</div>   

              <div class="col-md-8 rdpt" <?php echo $display_type_thnk; ?>>

            <div class="form-group"><input type="text" id="filenamex" name="thankyoutext" class="thankyoutext form-control" value="<?php echo $thankyoutext ?>">  

                </div></div>

       <!--<div class="col-md-4">Error Page</div>   

              <div class="col-md-8">

            <div class="form-group"><input type="text" id="filenamex" name="builder[error_page]" value="<?php echo $error_page ?>"  class="form-control" required="required">  

                </div></div>

-->          <!--<div class="col-md-4">Title</div>        

                <div class="col-md-8">

                   <div class="form-group"><input type="text" id="filenamex" name="builder[title]" value="<?php echo $title ?>"  class="form-control">  

            </div></div>

            <div class="col-md-4">Header Text</div>

                <div class="col-md-8">    

                     <div class="form-group"><textarea name="builder[header_text]"  cols=40 rows=5  class="form-control"><?php echo $header_text ?></textarea>  

                </div></div>

                -->

            <div class="col-md-4">Button Text</div>                

                <div class="col-md-8">

                      <div class="form-group"><input type="text" name="builder[button_text]"  value="<?php echo $button_text ?>"  class="form-control">      

                </div></div>

                

            <div class="col-md-4">Column Style</div>                

                <div class="col-md-8">

                      <div class="form-group">

                      

                      <?php if($coloumn_style==12){ $selected_single_col = 'selected="selected"'; } else if($id==0){   $selected_single_col = 'selected="selected"';  } 

					  

					 if($coloumn_style==6){ $selected_two_col = 'selected="selected"'; }else {$selected_two_col = '';}

					  

					  ?>

                      <select name="builder[coloumn_style]" id="coloumn_style">

                        <option value="12" <?php echo $selected_single_col; ?>>Single Column</option>

                      	<option value="6" <?php echo $selected_two_col; ?>>Two Column</option>

                      </select>

                       

                </div></div>

                

                

            <div class="col-md-11 custom_admin" style="display:block;">

            <div class="col-md-4" style="display:none;">Guid</div>

                <div class="col-md-8" style="display:none;">

                       <div class="form-group"><input enabled='false' type="text" id="filenamex" name="builder[guid]" value="<?php echo $guid; ?>"  class="form-control" required="required">  

                 </div></div>

                

               <div class="col-md-4" style="display:none;">WSDL</div>

               <div class="col-md-8" style="display:none;">

                       <div class="form-group"><input enabled='false' type="text" id="filenamex" name="builder[wsdl]" value="<?php echo $wsdl; ?>"  class="form-control" required="required">  

               </div></div>

       <!-- <div class="col-md-4">

            Button Format

        </div>

        <div class="col-md-8">

                <div class="row">

                        <div class="col-md-12">

                              <?php

                                if($button==1) 

                                    echo '<input type="radio" name="builder[button]" value="1" checked>';

                                else

                                     echo '<input type="radio" name="builder[button]" value="1">';

                              ?> 

                              <div class="btn-group" role="group" aria-label="...">

                                  <button type="button" class="btn btn-default">Customize Button</button>

                                  <button type="button" class="btn btn-default"></button>

                                  <button type="button" class="btn btn-default">Submit Button</button>

                               </div>

                        </div>

                        <div class="col-md-12">

                              <?php

                                if($button==2) 

                                    echo '<input type="radio" name="builder[button]" value="2" checked>';

                                else

                                     echo '<input type="radio" name="builder[button]" value="2">';

                              ?> 

                              <div class="row">

                                  <div class="col-md-12">

                                      <div class="btn-group" role="group" aria-label="...">

                                          <button type="button" class="btn btn-default">Customize Button</button>

                                          

                                      </div>

                                   </div>

                              </div>

                              <div class="row">

                                     <div class="col-md-12">

                                           <div class="btn-group" role="group" aria-label="...">

                                              <button type="button" class="btn btn-default">Submit Button</button>

                                              

                                           </div>

                                      </div>

                               </div>

                        </div>

                        <div class="col-md-12">

                              <?php

                                if($button==3) 

                                    echo '<input type="radio" name="builder[button]" value="3" checked>';

                                else

                                     echo '<input type="radio" name="builder[button]" value="3">';

                              ?> 

                              <div class="btn-group text-right" role="group" aria-label="...">

                                  <button type="button" class="btn btn-default">Right Align Button</button>

                                  

                               </div>

                        </div>

                </div>

        </div>-->



        </p>

        <?php

           

                $myfieldsGlobal =  $wpdb->get_results('SELECT * FROM ' . $table_namedata);

                /***** -- loading the community -- **/

                $client = new SoapClient($wsdl);

                $result = $client->GetSubdivInfoStyle1(array('sGUID' => $guid));
                          

                $xmlx = preg_replace('/(<\?xml[^?]+?)utf-16/i', '$1utf-8', $result->GetSubdivInfoStyle1Result);  

                $xmlx = new SimpleXMLElement($xmlx, LIBXML_NOCDATA);

				if($xmlx) {

                    foreach( (array) $xmlx as $key => $adatax){

                        $outx[$key] = ( is_object($adatax) ) ? xml2array ( $adatax ) : $adatax;

                    }

                }

                          
                if(count($myfieldsGlobal) > 0) {

                    foreach($myfieldsGlobal as $f){

                    if (($f->leadname=="BuilderName"))

                    {

                        echo "<div class='row' style='display:none;'><div class='col-md-2'>$f->leadname</div>  

                    <div class='small_row'><input type='checkbox' style='visibility: hidden' name='form-field-hide[$f->leadname]' checked></div>";

                            if(isset($showtext[$f->leadname]))

                                    echo "<td><input  type='checkbox' name='form-field-show[$f->leadname]' checked></td>";

                        else

                             echo "<div class='col-md-1'><td><input rel='1' type='checkbox' name='form-field-show[$f->leadname]'></td></div>";  

                    echo "<select style='visibility: hidden' name='form-field-type[$f->leadname]'>";

                        echo  "<option value='input' selected>Input</option>";

                        echo "</select>";

                        echo "<input type='text' rel='lalit' value='".(get_option('buildername') ?  get_option('buildername') : $defaultext[$f->leadname])."' name='form-field-default[$f->leadname]'><br/></div>";

                    }

                    if (($f->leadname=="Community") || ($f->leadname=="CommunityNumber"))

                    {

                        

                        echo "<div class='row'><div class='col-md-2'>$f->leadname</div>    

                            <div class='small_row'><input type='checkbox' style='visibility: hidden' name='form-field-hide[$f->leadname]' checked></div>";

                            if(isset($showtext[$f->leadname]))

                                    echo "<td><input type='checkbox' name='form-field-show[$f->leadname]' checked></td>";

                           else

                              echo "<div class='col-md-1'><td><input type='checkbox' name='form-field-show[$f->leadname]'></td></div>";  

                        echo "<select style='visibility: hidden' name='form-field-type[$f->leadname]'>";

                        echo  "<option value='input' selected>Input</option>";

                        echo "</select>";



                        //echo "<input type='text' value='".(get_option('Community') ?  get_option('Community') : $defaultext[$f->leadname])."' name='form-field-default[$f->leadname]'><br/></div>";

                        echo "<select name='form-field-default[$f->leadname]'>";

                                         foreach($outx as $key => $value) {

                                            foreach($value as $k => $data) {

                                                $strval = stripslashes(str_replace(" ","-",$data->MarketingName));

                                                    $selected = ""; 

                                                if($defaultext["Community"] == $data->SubdivisionNumber)


                                                    $selected = "selected";



                                                echo "<option value='".$data->SubdivisionNumber."' $selected>";

                                                    echo $data->MarketingName;

                                                echo "</option>";

                                            }

                                          }

                        echo "</select> <br></div>";                    

                    }

                    elseif ( ($f->leadname=="ValidateByEmail"))                    

                    {

                        echo "<div class='row'><div class='col-md-2'>$f->leadname</div> ";

                            if(isset($showtext[$f->leadname]))

                                    echo "<div class='col-md-1'><td><input type='checkbox' name='form-field-show[$f->leadname]' checked></td></div>";

                        else

                        echo "<div class='col-md-1'><td><input type='checkbox' name='form-field-show[$f->leadname]'></td></div>";  

                        echo "<div class='col-md-1'><input type='checkbox' style='visibility: hidden' name='form-field-hide[$f->leadname]' checked></div>";

                        echo "<select style='visibility: hidden' name='form-field-type[$f->leadname]'>";

                        echo  "<option value='input' selected>Input</option>";

                        echo "</select>";

                        echo "<div class='small_row'><input type='text' style='visibility: hidden' value='yes' name='form-field-default[$f->leadname]'><br/></div></div>";

                        

                    }

                    }

                }

    ?>

    </div>

<table class="table table-striped table-bordered table-hover custom_table">

<tr class="table_tr">

    <td>Enable</td>

    <td>Sequence</td>

    <td>Hidden</td>

    <td>Required</td>

<!--            <td>Under Customize</td>-->

    <td>Lead Field</td>

    <td>Label</td>

    <td>Selection</td>          

    <td>Field Type</td>

    <td>Default Value</td>

<!--            <td>DIV CLASS</td>-->

    <td>Remove</td>

</tr>

    <?php

   

        // echo $table_namedata;

        $myfields =  $wpdb->get_results('SELECT * FROM ' . $table_namedata);

        if(count($myfields) > 0) {

            foreach($myfields as $f){



          //echo $f->Sequence;

    

            if ( ($f->leadname=="BuilderName") || ($f->leadname=="Community") || ($f->leadname=="CommunityNumber") || ($f->leadname=="ValidateByEmail"))

            {

                

            }

            else

            {



                echo "<tr>";

            

                if(isset($showtext[$f->leadname]))

                            echo "<td><input type='checkbox' class='chkeckbox-enable' id='chk_".$f->leadname."' name='form-field-show[$f->leadname]' checked 1></td>";

                else

                     echo "<td><input type='checkbox' class='chkeckbox-enable' id='chk_".$f->leadname."' name='form-field-show[$f->leadname]'></td>";  

                     

                        //code

                       echo "<td><input type='text' class='input-sequence' id='seq_".$f->leadname."' value='".$sequence_value[$f->leadname]."' name='form-field-sequence[$f->leadname]'>

                       <div class='errmsg err_".$f->leadname."' style='display:none;'></div>

                       </td>";

                   

                if(isset($hiddentext[$f->leadname]) || ($f->leadname=="BuilderName") || ($f->leadname=="Community") || ($f->leadname=="CommunityNumber") || ($f->leadname=="ValidateByEmail"))

                     echo "<td><input type='checkbox' name='form-field-hide[$f->leadname]' checked></td>";

                else

                    echo "<td><input type='checkbox' name='form-field-hide[$f->leadname]'></td>";             

                if(isset($requiredtext[$f->leadname]))

                    echo "<td><input type='checkbox' name='form-field-required[$f->leadname]' checked></td>";

                else

                    echo "<td><input type='checkbox' name='form-field-required[$f->leadname]'></td>";

                
               // if(isset($customizetext[$f->leadname]))

               //     echo "<td><input type='checkbox' name='form-field-customize[$f->leadname]' checked></td>";

               // else

               //     echo "<td><input type='checkbox' name='form-field-customize[$f->leadname]'></td>";         



                    echo "<td>".$f->leadname."</td>";

                if(isset($labeltext[$f->leadname]))

                       echo "<td><input type='text' value='".$labeltext[$f->leadname]."' name='form-field-label[$f->leadname]'></td>";

                else

                        echo "<td><input type='text' value='".$f->labelname."' name='form-field-label[$f->leadname]'></td>";

               

                    echo "<td></td>";

                    echo "<td><select name='form-field-type[$f->leadname]'>";

                                echo "<option value=''>-- Select Type --</option>";

                           if($typetext[$f->leadname]=='email') 

                                echo  "<option value='email' selected>Email</option>";

                           else

                                 echo  "<option value='email'>Email</option>";

            

                           if(($typetext[$f->leadname]=='input') ||!isset($typetext[$f->leadname]))

                                echo  "<option value='input' selected>Input</option>";

                           else

                                 echo  "<option value='input'>Input</option>";

                           //if($typetext[$f->leadname]=='select')

                           //     echo "<option value='select' selected>Select</option>";

                           //else

                           //    echo "<option value='select'>Select</option>"; 

                           if($typetext[$f->leadname]=='textarea')

                                echo "<option value='textarea' selected>Textarea</option>";

                           else

                                 echo "<option value='textarea'>Textarea</option>";

                         //  if($typetext[$f->leadname]=='radio')

                         //       echo "<option value='radio' selected >Radio</option>";

                         //   else

                         //       echo "<option value='radio'>Radio</option>";

                         //   if(isset($typetext[$f->leadname]) && $typetext[$f->leadname]=='checkbox') 

                         //           echo  "<option value='checkbox' selected>Checkbox</option>";

                         //   else

                         //           echo  "<option value='checkbox'>Checkbox</option>"; 

                    echo "</select></td>";

                    echo "<td><input type='text' value='".$defaultext[$f->leadname]."' name='form-field-default[$f->leadname]'></td>";

                 //   echo "<td><input type='text' value='".$classtext[$f->leadname]."' name='form-field-class[$f->leadname]'></td>

                     echo "    <td><a class='btn btn-danger rem_btn' href='".$_SERVER["REQUEST_URI"]."&fid=$f->fieldname'>".$f->fieldname."<a></td>

                    </tr>";

                }

            }

        }

        /** --- add the wsdl data --- **/

//print_r($labeltext);

                

if($wsdl) {

		try {

			$client = new SoapClient($wsdl);

			$result = $client->GetDemosXML(array('SubscriptionGUID' => $guid));

			$xml = simplexml_load_string($result->GetDemosXMLResult, 'SimpleXMLElement', LIBXML_NOCDATA);

			$results = array();

			

			// echo '<pre>';print_r($xml);echo '</pre>'; 

			foreach($xml as $data){

				foreach ( (array) $data as $index => $node )

						$out[$index] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node;               

				

				$results[$out["SystemName"]]["display"] = $out["Display"];

				$results[$out["SystemName"]]["selection"][] = $out["Description"];

			}



			   // echo '<pre>';print_r($selectiontext);echo'</pre>';

			   

			   // Code community section

				  echo "<tr>";

				  if(isset($showtext[$key])) 

					 echo "<td><input type='checkbox' class='chkeckbox-enable' id='chk_".$key."'  name='form-field-show[$key]' checked></td>";

				else

					echo "<td><input type='checkbox' class='chkeckbox-enable' id='chk_".$key."'  name='form-field-show[$key]'></td>";

				 

				  echo "<td><input type='text' class='input-sequence' id='seq_".$key."'  name='form-field-sequence[$key]' value='".$sequence_value[$key]."' >

			   <div class='errmsg err_".$key."' style='display:none;'></div></td>";

				  if(isset($requiredtext[$key]))

						echo "<td><input type='checkbox' name='form-field-required[$key]' checked></td>";   

				else

					echo "<td><input type='checkbox' name='form-field-required[$key]'></td>";



				if(isset($customizetext[$key]))

					echo "<td><input type='checkbox' name='form-field-customize[$key]' checked></td>";

				else

					echo "<td><input type='checkbox' name='form-field-customize[$key]'></td>";

				  echo "<td>Community</td>";

				   echo "<td><input type='text' value='Community' name='form-field-label[$key]'></td>";

					 echo "<td>";

				   foreach($outx as $key => $value){

					   foreach($value as $k => $data) {

						   $strval = stripslashes(str_replace(" ","-",$data->MarketingName));

							$selected = ""; 

						   if($defaultext["Community"] == $data->SubdivisionNumber)

						   $selected = "selected";

						   $communityname_number = $data->MarketingName.'*'.$data->SubdivisionNumber;

						   if(!empty($selectiontext['Subdivision'])){

						   if (in_array($communityname_number, $selectiontext['Subdivision'])){

						   echo '<input type="checkbox" name="form-field-selected[Subdivision][]" value="'.$communityname_number.'" checked="checked">'.$data->MarketingName.'';

							echo '<br/>';

						   }else{

								echo '<input type="checkbox" name="form-field-selected[Subdivision][]" value="'.$communityname_number.'">'.$data->MarketingName.'';

								 echo '<br/>';

							   }

							}else{

								 echo '<input type="checkbox" name="form-field-selected[Subdivision][]" value="'.$communityname_number.'">'.$data->MarketingName.'';

								 echo '<br/>';

								}

						   }

					   

					   }

					echo "</td>";

					 

					  echo "<td><select name='form-field-type[$key]'>";

							 echo "<option value=''>-- Select Type --</option>";

				   
   if($typetext[$key]=='select')
                                                echo "<option value='select' selected>Select</option>";
                                           else  if(($typetext[$key]=='radio')||!isset($typetext[$key]))
                                                echo "<option value='radio' selected >Radio</option>";
											else  if(($typetext[$key]=='checkbox')||!isset($typetext[$key]))
                                                echo "<option value='checkbox' selected >Checkbox</option>";	
                                            else
                                                echo "<option value='radio'>Radio</option>";
												echo "<option value='checkbox'>Checkbox</option>";
                                                echo "</select></td>";
									 
								    echo "</tr>";
                
				//  End community section 										  

			foreach($results as $key => $myxml) {

				echo "<tr>";

				if(isset($showtext[$key])) 

						echo "<td><input type='checkbox' class='chkeckbox-enable' id='chk_".$key."'  name='form-field-show[$key]' checked></td>";

				else

					echo "<td><input type='checkbox' class='chkeckbox-enable' id='chk_".$key."'  name='form-field-show[$key]'></td>";

					

					//echo "<td></td>";

					

			   //sequence

			   echo "<td><input type='text' class='input-sequence' id='seq_".$key."'  name='form-field-sequence[$key]' value='".$sequence_value[$key]."' >

			   <div class='errmsg err_".$key."' style='display:none;'></div>

			   </td>";

			   

				

				if(isset($requiredtext[$key]))

						echo "<td><input type='checkbox' name='form-field-required[$key]' checked></td>";   

				else

					echo "<td><input type='checkbox' name='form-field-required[$key]'></td>";



				if(isset($customizetext[$key]))

					echo "<td><input type='checkbox' name='form-field-customize[$key]' checked></td>";

				else

					echo "<td><input type='checkbox' name='form-field-customize[$key]'></td>";  



					echo "<td>".$key."</td>";

					  if(isset($labeltext[$key]) && $labeltext[$key]!="")

						echo "<td><input type='text' value='".$labeltext[$key]."' name='form-field-label[$key]'></td>";

					else

	echo "<td><input type='text' value='".$myxml["display"]."' name='form-field-label[$key]'></td>";

					echo "<td>";

					

					$j = 0;

					

					foreach($myxml["selection"] as $key1 => $value) {

							

							$j = $j+1;

							

							$strval = str_replace(" ","-",$value);

							

							if(isset($selectiontext[$key][$strval."-".$j]))

								echo "<input type='checkbox' name=form-field-selected[$key][$strval-".$j."] value='$value' checked >&nbsp;".$value."<br>"; 

							else

								echo "<input type='checkbox' name=form-field-selected[$key][$strval-".$j."] value='$value' >&nbsp;".$value."<br>"; 

			

					}

					

					echo "</td>"; 

					echo "<td><select name='form-field-type[$key]'>";

							 echo "<option value=''>-- Select Type --</option>";

						//   if($typetext[$key]=='input') 

						//        echo  "<option value='input' selected>Input</option>";

						//   else

						//         echo  "<option value='input'>Input</option>";

						  if($typetext[$key]=='select')

								echo "<option value='select' selected>Select</option>";

						   else

							   echo "<option value='select'>Select</option>"; 

						//   if($typetext[$key]=='textarea')

						//        echo "<option value='textarea' selected>Textarea</option>";

						//   else

						//         echo "<option value='textarea'>Textarea</option>";

						   if(($typetext[$key]=='radio')||!isset($typetext[$key]))

								echo "<option value='radio' selected >Radio</option>";

							else

								echo "<option value='radio'>Radio</option>";

						   if(isset($typetext[$key]) && $typetext[$key]=='checkbox') 

						         echo  "<option value='checkbox' selected>Checkbox</option>";

						    else

						        echo  "<option value='checkbox'>Checkbox</option>";   

								echo "</select></td>";

				echo "</tr>";

			} /** -- end for -- **/

		} catch (Exception $e){

		}

}
?>
</table>
     <div class="left">
         <button class="btn btn-success" type="submit">Save Template</button>
     </div>

  </form>

<br/>

   </div>

        <div class="col-md-5 side_data">

            <div class="row">

        <div class="">

            <form class="form-horizontal" id="validation-form" method='POST'>

             <input type="hidden" name="templatename" value="<?php echo $template_name ?>" >  

        <div class="form-group">

                    <label for="form-field-phone" class="col-sm-3 control-label no-padding-right">Field Name</label>

                        <div class="col-sm-9">

                                <span class="input-icon input-icon-right">

                                    <input type="text" id="filenamex" name="builder[fieldname]" value=""  class="input-large" required="required">  

                                </span>

                        </div>

                </div>

                <div class="form-group">

                    <label for="form-field-phone" class="col-sm-3 control-label no-padding-right">Label Name</label>

                        <div class="col-sm-9">

                                <span class="input-icon input-icon-right">

                                    <input type="text" id="filenamex" name="builder[labelname]" value=""  class="input-large" required="required">  

                                </span>

                        </div>

                </div>

                <div class="form-group">

                    <label for="form-field-phone" class="col-sm-3 control-label no-padding-right">Lead Name</label>

                        <div class="col-sm-9">

                                <span    class="input-icon input-icon-right">

                                    <input type="text" id="filenamex" name="builder[leadname]" value=""  class="input-large" required="required">  

                                </span>

                        </div>

                </div>

                <div class="text-center">

                    <button class="btn btn-primary" type="submit">Add Field</button>

                </div>

            </form>

            </div>

        

            </div>  

            <div class="hr hr-18 dotted hr-double"></div>

            

            

            

<script>

jQuery(function(){

//jQuery('.redirect_page').removeAttr('checked');

var temp_height = jQuery('.template_list').height();

//console.log(temp_height);

var new_height = parseInt(temp_height)+200;

jQuery('.custom_table').css('margin-top',new_height);

jQuery('.redirect_page').on('click',function(){

  var thisCheck = jQuery(this);

  if ( thisCheck.is(':checked') ) {

    jQuery('.rdp').show();

    jQuery('.rdpt').hide();

  }else{

    <?php

$redirect_pagest = get_option('redirect_page_status_'.$template_name);

 if($redirect_pagest == 'on'){ ?>

        jQuery('.redirect_pager').attr('value','<?php echo $redirect_page; ?>');

    <?php }else{ ?>

    jQuery('.redirect_pager').attr('value','');

        <?php } ?>

    jQuery('.rdp').hide();

    jQuery('.rdpt').show();

    }   

});



	jQuery(".chkeckbox-enable").click(function(){

		

		var id = jQuery(this).attr('id'); 	

		var arrfield = id.split('_');

		var selected = arrfield[1];

		var sequence = jQuery("#seq_"+selected).val();

		

		if(jQuery(this).is(":checked"))	

		{

			if(jQuery.trim(sequence)=='')

			{

				jQuery("#seq_"+selected).addClass('input-err');

				jQuery("#seq_"+selected).focus();	

				jQuery(".err_"+selected).html("Please fill out this field");

				jQuery(".err_"+selected).show();

			}

			else

			{

				jQuery("#seq_"+selected).blur();

				jQuery("#seq_"+selected).removeClass('input-err');

				jQuery(".err_"+selected).html("");

				jQuery(".err_"+selected).hide();	

			}			

		}

		else

		{

			jQuery("#seq_"+selected).removeClass('input-err');	

			jQuery("#seq_"+selected).blur();

			jQuery(".err_"+selected).html("");

			jQuery(".err_"+selected).hide();

		}

	});

	

	jQuery(".input-sequence").blur(function(){

		var id = jQuery(this).attr('id');	

		var arrfield = id.split('_');

		var selected = arrfield[1];

		var sequence = jQuery(this).val();

		

		if(jQuery.trim(sequence)=="" && jQuery("#chk_"+selected).is(":checked"))

		{

			jQuery("#seq_"+selected).addClass('input-err');

			jQuery("#seq_"+selected).focus();	

			jQuery(".err_"+selected).html("Please fill out this field");

			jQuery(".err_"+selected).show();

		}

		else

		{

			jQuery(".err_"+selected).html("");

			jQuery(".err_"+selected).hide();	

			jQuery("#seq_"+selected).blur();

			jQuery("#seq_"+selected).removeClass('input-err');

		}	

	});



});

</script>

            <div class="row template_list">

                <h4 class="text-centre">Template List</h4>

                <?php

                    

                     $templateids =  $wpdb->get_results('SELECT templateid FROM ' . $table_name);

                     echo "<div class='col-md-4'>";

                        echo "Template Name";

                        echo "</div>";

                        echo "<div class='col-md-6'>";

                        echo "Use this short code anywhere you want this form to be used.";

                        echo "</div>";

                       

                     foreach($templateids as $data){         

                        echo "<div class='col-md-6'>";

                        echo "<a href='". $_SERVER["REQUEST_URI"]."&id=$data->templateid'><span class='fa fa-edit'></span>$data->templateid</a>";

                        echo "</div>";

                         echo "<div class='col-md-6 template_tag'>";

                         echo "<input Type='text' size='30' value='[BuilderUX-template id=\"$data->templateid\"]'\>";

                        echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href='". $_SERVER["REQUEST_URI"]."&delete=1&id=$data->templateid'><span class='fa fa-edit'></span>Delete</a>";

                        echo "</div>";



                    }

                ?>

            </div>

        </div>

    </div>

           



    </div>

<?php

   

}







function BuilderUX_plugin_menu()



{



    add_menu_page('BuilderUX Settings','BuilderUX Elead Plugin', 'manage_options', 'BuilderUX-plugin', 'BuilderUX_option_page');

    add_submenu_page( 'BuilderUX-plugin', 'BuilderUX General Config', 'General Configuration', 'manage_options', 'BuilderUX-general-config','builderux_config');

}

add_action('admin_menu', 'BuilderUX_plugin_menu');

function BuilderUX_shortcodes(){

    add_shortcode('BuilderUX-template', 'BuilderUX_template');

}

function BuilderUX_template($args, $content) {

    global $add_my_script;

    $add_my_script = true;

    global $wpdb;

    $table_name = $wpdb->prefix ."BuilderUX";

    $tempid = $args['id'];


    if($tempid.trim("")!==""){

		$data  = $wpdb->get_row("SELECT * FROM " . $table_name." where templateid ='". $tempid."'" );

	     //$data  = $wpdb->get_row("SELECT `sequence` FROM " . $table_name." where templateid ='". $tempid."'" ); 

		//echo '<pre>';print_r(json_decode($data->selectiontext,true));echo '<pre>';

		//echo '<pre>';print_r($data);echo '</pre>'; 

		$showtext_showtext = json_decode($data->showtext,true);				

		$showtext_sequence = json_decode($data->sequence,true);		

		//echo '<pre>';print_r($showtext_showtext);echo '</pre>'; 

		//echo '<pre>';print_r($showtext_sequence);echo '</pre>'; 

			 		
	   if(count($showtext_sequence) > 0) {
		   
		$showtext =  array_filter($showtext_sequence, create_function('$a','return preg_match("#\S#", $a);'));		
     
		asort($showtext);

        $guid = $data->guid;

        $wsdl = $data->wsdl;

        $error_page = $data->error_page;

        $redirect_page = $data->redirect_page;

        $requiredtext =json_decode($data->requiredtext,true);

		$sequence_value = json_decode($data->sequence,true);

        $labeltext = json_decode($data->labeltext,true);

        $selectiontext = json_decode($data->selectiontext,true);

        $hiddentext = json_decode($data->hiddentext,true);

        $defaultext = json_decode($data->defaultext,true);

        $classtext = json_decode($data->classtext,true);

        $typetext = json_decode($data->fieldtype,true);

        $customizetext = json_decode($data->iscustomize,true);

        $button_text = $data->button_text;

		$coloumn_style = $data->coloumn_style;

        $title = $data->title;

        $header_text = $data->header_text;

        $thisid = uniqid();

        //$button = $data->button_format;

		
	

		if($coloumn_style=="")

		{

			$coloumn_style = 12;		

		}

		

        $button = 3;

        $blndemo = false;

        $redirect_pagestatus = get_option('redirect_page_status_'.$tempid);

                if($redirect_pagestatus == 'on'){

            $front_rd .= "<input type='hidden' name='builder[page]' id='redirect_url' value='".$redirect_page."'>";

                        }else{

            $front_rd .= "<input type='hidden' name='builder[page]' id='redirect_url' value=''>";       

                }


	   }
    

    }

	//echo '<pre>';print_r($labeltext);echo '</pre>';



    //$length = 10;

    //$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    //$charactersLength = strlen($characters);

    //$randomString = '';

    //for ($i = 0; $i < $length; $i++) {

     //   $randomString .= $characters[rand(0, $charactersLength - 1)];

    //}

    

    //$filename = $randomString.".txt";

    //$myfile = fopen($filename, "w");

    //$txt = "guid\n";

    //fwrite($myfile, $txt);

    //fclose($myfile);


    if (strtoupper($_SERVER['REQUEST_METHOD']) != 'POST' && count($showtext_sequence) > 0)
	{
		
		//print_r($labeltext);
	//	exit;
		
		$elad_path = plugins_url('BuilderUX/elead.php');

        $front .= "<div id='msgBox' style='display:none'> Welcome Back ...</div>";

        //$front .= "<h3>".$title."</h3>";

        //$front .= "<p>".$header_text."</p>";

        $front .= "<form role=form class='contact-form' id='builder-contact-form'  action='".plugins_url('BuilderUX/elead.php')."' method='POST'>";

        $front .= "<input type='hidden' name='builder[session]' value='".$thisid."'>";

        $front .= "<input type='hidden' name='builder[guid]' value='".$guid."'>";

        $front .= "<input type='hidden' name='builder[p]' value='".realpath($filename)."'>";

        $front .= "<input type='hidden' name='builder[sss]' value='".$wsdl."'>";

        $front .= $front_rd;

        $front .= "<input type='hidden' name='builder[error_page]' value='".$error_page."'>";

        $front .= "<input type='hidden' name='builder[x_firstname]'>";

		$front .= "<input type='hidden' name='builder[Buildername]' value='".get_option('buildername')."'>";

		$front .= "<input type='hidden' name='builder[UpdateAllDemographics]' value='#1'>";

        $front .= "<div id='fooDiv' style='display:none'>";

        $front .= "<label>please enter your name here</label>";

        $front .= "<input type='text' name='builder[x_firstname]'>";

        $front .= "</div>";

        $front .= "<div class='container'>";

        $front .= "<div class='row'>"; 		
		
		$front .= "<div class='col-xs-12'>";
		
		$front .= "<div class='col-xs-6 header_top'><img src='".plugins_url("img/raffia-logo1.png",__FILE__ )."'/></div>";
				
		$front .= "<div class='col-xs-6 header_top'><span class='regi_date'>Date: </span> <input type='text' class='form-control input_date' /> <br /> 
		
		           <span class='regi_community'> Community Representative :</span>  <input type='text' class='form-control input_community' /> 		
		
		           </div>";
		
		$front .= "</div>";
		

	if(get_option( 'thankyoutext_'.$tempid)) {
	
	$thankyoutext = get_option('thankyoutext_'.$tempid);
	
	}  

    if(isset($showtext)) { 

        foreach($showtext as $key => $value){

              if(isset($requiredtext[$key]) && $requiredtext[$key])

                  $requiredf .= ",".$key;

          }

        $front .= "<input type='hidden' name='builder[x_fieldrequired]' value='".$requiredf."'>";
		   
        foreach($showtext as $key => $value) {


            if(!isset($customizetext[$key])) {


                if ($typetext[$key]=='select'){

                    if($blndemo==false) {

                        $front .= "<br><div id='customize' class='input-select col-md-12 col-xs-".$coloumn_style."'>"; 

                        $front .= "<p class='text-center'><em>The following information will help us to customize the communications you receive.</em></p>";

                    }

                     $front .= "<div class='col-xs-".$coloumn_style." col-md-".$coloumn_style."'>";

                     $front .= "<div class='form-group'>";

					$front .= "<label for='name' class='sr-only'>".$labeltext[$key]."</label>";

					$blndemo = true;

					$front .= "<select name='builder[".$key."]' class='form-control'>";

					$front .= "<option value=''>".$labeltext[$key]."</option>";

					foreach($selectiontext[$key] as $selkey => $valuesel){

						 $front .= "<option value='".$valuesel."'>".$valuesel."</option>";    

					}

					$front .= "</select></div></div></div>";



                } else if($typetext[$key] == 'input' || $typetext[$key] == 'email') {

                    if($requiredtext[$key]) {

                        $required = "required";

                        $star = "*";

                    } else {

                        $required = "";

                        $star ="";

                    }



                    if(isset($classtext[$key]) && $classtext[$key] != "")

                        $divclass = $classtext[$key];

                    else

                        $divclass = "col-md-".$coloumn_style." col-xs-".$coloumn_style." custwidth";

                   

                     if(isset($hiddentext[$key])) {

                 

                    $front .= "<div class='".$divclass."' style='display:none;'>";

                                $front .= "<div class='form-group'>";

                                $front .= "<label for='".$key."' class='sr-only'>".$labeltext[$key]."xx</label>";

                        $front .= "<input rel='1' type='hidden' class='field-sm form-control' id='author' value='".$defaultext[$key]."'  placeholder='".$labeltext[$key]."' required name='builder[".$key."]'>";

                        $front .= "</div></div>";   

                    } else {

                        $front .= "<div class='".$divclass."'>";

                         $front .= "<div class='form-group'>";

                         $front = $front."<input rel='2'  type='".$typetext[$key]."' class='form-control' id='".$key."'  placeholder='".$labeltext[$key].$star."' $required name='builder[".$key."]'>";

                           $front .= "</div></div>";      

                    }

                   // $front .= "</div></div>";

                } else if ($typetext[$key] == 'radio') {

                     $front .= "<div class='col-xs-".$coloumn_style." col-md-".$coloumn_style."'>";

                                $front .= "<div class='form-group'>";
									
								 	
	
							if($key=='Subdivision'){

									   $front .= "<div class='col-md-".$coloumn_style."'><label for='name'>".$labeltext[$key]."</label></div>";	
								
									   foreach($selectiontext[$key] as $selkey => $valuesel){

										    $afterexlode = explode("*",$valuesel);

				                            $community_name = $afterexlode[0];

				                            $community_number = $afterexlode[1];

										   

                                        $front .= "<div class='col-md-6'><input type='radio' name='builder[".$key."]' value='$valuesel'>&nbsp;<small> $community_name</small></div>";

                                  }

							  }else{

								  $front .= "<div class='col-md-".$coloumn_style."'><label for='name'>".$labeltext[$key]."</label></div>";	

										

                                  foreach($selectiontext[$key] as $selkey => $valuesel){

                                        $front .= "<div class='col-md-6'><input type='radio' name='builder[".$key."]' value='$valuesel'>&nbsp;<small>$valuesel</small></div>";

                                  }

								}

                                       

                     $front .= "</div></div><div class='col-md-12'><hr></div>";

                } //textarea starts				

				else if ($typetext[$key] == 'textarea') {

                     $front .= "<div class='col-xs-".$coloumn_style." col-md-".$coloumn_style."'>";

                                $front .= "<div class='form-group'>";

                                $front .= "<textarea  rel='2' class='form-control' id='".$key."'  placeholder='".$labeltext[$key].$star."' $required name='builder[".$key."]'></textarea>";
	

                     $front .= "</div></div>";
					 
					

                } //textarea ends

				else if($typetext[$key]=='checkbox') {
					 
				  if($labeltext[$key] == 'Are you working with an outside Realtor?') {
						
					$front .= "<div class='checkbox-div-realtor'>";
									 
					$front .= "<div class='col-xs-".$coloumn_style." col-md-".$coloumn_style."'><span><label for='".$tempid.$key."'>".$labeltext[$key]."</label></span></div>";

                    $front .= "<ul>";

                    foreach($selectiontext[$key] as $selkey => $valuesel) {

                        $front .= "<li><input type='checkbox' name='builder[".$key."][]' value='$valuesel'>&nbsp;<small>$valuesel</small></li>";
                    }
					
					$front .= "</ul>";
					
					$front .= "<div class='agent_block'>
					          <input type='text' class='form-control' name='agent_name' /> <br /> 
					          <span class='titles'> (Agent) </span> 
							  </div>
							  <div class='agent_block'>
							  <input type='text' class='form-control' name='company_name' /> <br />
							  <span class='titles'> (Company) </span> 
							  </div>
							  <p> If Yes, by signing this form I/We herby approve of WCI providing my/our personal information
							   to said Realtor, including copy of any purchase contract entered into.</p>
							   <div class='agent_block'>
							   <input type='text' class='form-control' name='signature' /><br />
							   <span class='titles'> (Signature) </span></div>";
							    
					$front .= "</div>";
					
				}
					
				else {
					
					$front .= "<div class='checkbox-div'>";
								
                    $front .= "<div class='col-xs-".$coloumn_style." col-md-".$coloumn_style."'><span><label for='".$tempid.$key."'>".$labeltext[$key]."</label></span></div>";

                    $front .= "<ul>";

                    foreach($selectiontext[$key] as $selkey => $valuesel) {

                        $front .= "<li><input type='checkbox' name='builder[".$key."][]' value='$valuesel'>&nbsp;<small>$valuesel</small></li>";

                    }

                 $front .= "</ul></div>";

                }     
              }  
		   
		   }                 

        } //** end of for loop **//

        //for customize
       
          foreach($showtext as $key => $value) {
               
              if(isset($customizetext[$key])) {
              
                 $ctr = 0;

                 if($blndemo==false) {

                         $front .= "<br><div id='customize' class='input-select col-md-12 col-xs-".$coloumn_style."'>";

                         $front .= "  <p class='text-center'><em>The following information will help us to customize the communications you receive.</em></p>";

                  }

                  $blndemo = true;

                  if ($typetext[$key]=='select'){

                     

                     

                      $front .= "<div class='col-xs-".$coloumn_style." col-md-".$coloumn_style."'><div class='col-md-12 hr'></div>";

                                  $front .= "<div class='form-group'>";

                                          $front .= "<label for='name' class='sr-only'>".$labeltext[$key]."</label>";

                                  

                                  $front .= "<select name='builder[".$key."]' class='form-control'>";

                                  $front .= "<option value=''>".$labeltext[$key]."</option>";

                                  foreach($selectiontext[$key] as $selkey => $valuesel){

                                       $front .= "<option value='".$valuesel."'>".$valuesel."</option>";    

                                  }

                      $front .= "</select></div></div>";



                  } else if($typetext[$key] == 'input' || $typetext[$key] == 'email') {

                      if($requiredtext[$key]) {

                          $required = "required";

                          $star = "*";

                      } else {

                          $required = "";

                          $star ="";

                      }

                    if(isset($classtext[$key]) && $classtext[$key] != "")

                      $divclass = $classtext[$key];

                    else

                      $divclass = "col-md-6 col-xs-6";

                      $front .= "<div class='".$divclass."'>";

                                  $front .= "<div class='form-group'>";

                                  $front .= "<label for='".$key."' class='sr-only'>".$labeltext[$key]."</label>";


                      if(isset($hiddentext[$key])) {

                          $front .= "<input type='hidden' class='field-sm form-control' id='author' value='".$defaultext[$key]."'  placeholder='".$labeltext[$key]."' required name='builder[".$key."]'>";

                      } else {

                           $front = $front."<input type='".$typetext[$key]."' class='form-control' id='".$key."'  placeholder='".$labeltext[$key].$star."' $required name='builder[".$key."]'>";
                      }

                      $front .= "</div></div>";

                  } else if ($typetext[$key] == 'radio') {

                          if($ctr==0) {    

                              $front .= "<div class='col-xs-".$coloumn_style." col-md-".$coloumn_style."'><div class='col-md-12 hr'></div>";

                          } else {

                                $front .= "<div class='col-xs-".$coloumn_style." col-md-".$coloumn_style."'>";

                          }
						         

                                  $front .= "<div class='form-group'>";

								
								    if($key=='Subdivision'){
										
									 
										$front .= "<div class='col-md-".$coloumn_style."'><label for='name'>".$labeltext[$key]."</label></div>";

										foreach($selectiontext[$key] as $selkey => $valuesel){

												 $afterexlode = explode("*",$valuesel);

												 $community_name = $afterexlode[0];

												 $community_number = $afterexlode[1];

											    $front .= "<div class='col-md-6'><input type='radio' name='builder[".$key."]' value='$valuesel'>&nbsp;<small>$community_name</small></div>";

										 }

									 }

									else{

                                          $front .= "<div class='col-md-".$coloumn_style."'><label for='name'>".$labeltext[$key]."</label></div>";

                                    foreach($selectiontext[$key] as $selkey => $valuesel){

                                          $front .= "<div class='col-md-6'><input type='radio' name='builder[".$key."]' value='$valuesel'>&nbsp;<small>$valuesel</small></div>";

                                    }

								}

									

									

                       $front .= "</div></div>";

                  } else  if ($typetext[$key] == 'Textarea'){

                      if($requiredtext[$key]) {

                          $required = "required";

                          $star = "*";

                      } else {

                          $required = "";

                          $star ="";

                      }



                      if(isset($classtext[$key]) && $classtext[$key] != "")

                          $divclass = $classtext[$key];

                      else

                          $divclass = "col-md-6 col-xs-6";

                      

                      $front .= "<div class='".$divclass."'>";

                                  $front .= "<div class='form-group'>";

                                  $front .= "<label for='".$key."' class='sr-only'>".$labeltext[$key]."</label>";

                      if(isset($hiddentext[$key])) {

                          $front .= "<input type='hidden' class='field-sm form-control' id='author' value='".$defaultext[$key]."'  placeholder='".$labeltext[$key]."' required name='builder[".$key."]'>";

                      } else {

                           $front = $front."<textarea class='form-control' id='".$key."'  placeholder='".$labeltext[$key].$star."' $required name='builder[".$key."]'></textarea>";

                               

                      }

                      $front .= "</div></div>";

                  }     

              }

          

              $ctr = 1;

                      

          } //** end of for loop **//

    }   

		 $front .='</div>'; 
		 
		 $front .='<div class="acknowledge">
		 
				  <span class="center-title">
				  
				  ACKNOWLEDGMENTS AND DISCLOSURES 
				  
				  <hr class="divide"/>
				  
				  CLOSED STATE ACKNOWLEDGMENT
					
				  </span>	
				  
				  <p> 
					   If you are a resident of <b> Alaska, Arizona, California, Connecticut, Hawaii, Idaho, Iowa, Kansas, Kentucky, Massachusetts, Minnesota, Mississippi, Nebraska, Nevada, New Hampshire, New Jersey, New York, North Dakota, Ohio, Oklahoma, Oregon, Rhode Island, South Carolina, South Dakota, Utah, Washington, West Virginia, Puerto Rico or Canada (except Ontario)("Home State") </b>, please complete the following acknowledgment and certification. 
				  
				  </p> 
				  
				 The undersigned hereby represents and warrants the following:	
				  
				  <p>
					   <ul>
						
						  <li>1. I/We was/were residing at the address provided in this Registration form immediately prior to my/our visit to the WCI Sales Center noted above ("Sales Center"); </ol>
						  <li>2. I/We was/were not solicited by WCI to visit the Sales Center while I/we was/were in the Home State and visited said Sales Center voluntarily; </ol>
						  <li>3. I/We was/were not solicited by WCI while in the Home State </ol>
						  <li>4. Marketing and sales materials concerning WCI Property were provided by WCI to me/us within the State of Florida; and </ol>
						  <li>5. This Acknowledgment & Certification is given freely and without duress by my/our signature below. </ol>
						  <li>6. I/We grant permission for WCI or its agent to send a post-visit survey for the purposes of gathering market research data to the email address provided on this registration form. </ol>
											   
					   <ul>	
					   			   
				   </p>
				   
				   <span class="center_text">
				   
				       NO BROKERAGE RELATIONSHIP NOTICE <br /> FLORIDA LAW REQUIRES THAT REAL ESTATE LICENSEES WHO HAVE NO BROKERAGE <br /> RELATIONSHIP WITH A POTENTIAL SELLER OR BUYER DISCLOSE THEIR DUTIES TO SELLERS AND BUYERS. 
					   
				   </span>
				  <p>
				  As a real estate licensee who has no brokerage relationship with you, WCI Realty, Inc. owes to you the following duties: 
				  <br />
				  <ul>
					  <li> 1. Dealing honestly and fairly; </li>
					  <li> 2. Disclosing all known facts that materially affect the value of residential real property which are not readily observable to the buyer and </li> 
					  <li> 3. Accounting for all funds entrusted to the licensee. </li>
                  </li>				  				  
				  </p>		  
				  
				  <div class="sign_block">
				     <div class="sign1">
					    <input type="text" class="form-control" /> <br /> 
						<span> sign </span> 
					 </div>
					 
					 <div class="sign2">
					     <input type="text" class="form-control" /> <br /> 
						<span> sign </span> 
					 </div>
				  </div>		
				  
				  <div class="date_block">
                 
					<div class="nm">Print Name: <input type="text" class="form-control nm_field" /></div>
					<div class="dt">Date: <input type="text" class="form-control dt_field" /></div>  
		   		 		 	 
					<div class="nm">Print Name: <input type="text" class="form-control nm_field" /></div> 
					<div class="dt">Date: <input type="text" class="form-control dt_field" /></div>  
				
									    
				 </div>			  	
				 </div>';
		  
		          $front .=  "<div class='text-center footer_text'>
		                     <img class='left_bottom_logo' src='".plugins_url("img/wci-bottom-small-logo.png",__FILE__ )."' /> 
		                      <div class='center_text_footer'> WCI REALTY, INC. IS ACTING AS THE SELLER'S AGENT WITH REGARD TO THE SALE OF WCI HOMES, 
							  HOMESITES AND CONDOMINIUMS IN THE STATE OF FLORIDA. WCI Communities, LLC ('WCI') respects the privacy of our customers.
							  We keep our customers' best interests at heart and place a high priority on protecting the Personal Information you provide. 
							  To view the complete WCI Privacy Policy visit wcicommunities.com.</div>
                              <img class='right_bottom_logo' src='".plugins_url("img/equal-bottom-logo.png",__FILE__ )."' />
							  </div>";

		 $front .=  "<div class='form-group text-right'>

					<label><small>*required fields</small></label><div>				   

				   <button class='btn' type='submit'>".$button_text."</button>

				   <div class='updater_gif' style='float: right;display:none;    margin-left: 15px;'><img style='width:20%;' src=".plugins_url("BuilderUX/img/giphy.gif")." /></div>

			</div></div>";



$front .= "</form></div>";



		if($thankyoutext!='')

		{

			$str_alert = "alert('$thankyoutext');";

		}

	



        $front .= "<script>";

        $front .= "var forms = document.getElementsByTagName('form');

            for (var i = 0; i < forms.length; i++) {

                    forms[i].noValidate = true;

                        forms[i].addEventListener('submit', function(event) {

                        //Prevent submission if checkValidity on the form returns false.

                        if (!event.target.checkValidity()) {

                                event.preventDefault();

                                //alert('Please fill the required fields');

                                //checkform();

                                //$('#builder-contact-form').validate();

                        }else{

                             event.preventDefault();

                            $('.updater_gif').show();

                            var form_submit_data = $('#builder-contact-form').serialize();

                                $.ajax({

                                url:'$elad_path',

                                data:form_submit_data,

                                type:'POST',

                                success:function(){

                                $('.updater_gif').hide();

                                if($('#redirect_url').val()==''){

                                  //  document.getElementById('builder-contact-form').reset();  

									    $str_alert

										}else{

                                        window.location = $('#redirect_url').val();

                                    }

                                }

                                });                         

                            return true;    

                            }

                    }, false);

            }";

        $front .= "

                  

                         var e = document.getElementById('fooDiv');

                         e.parentNode.removeChild(e);

                  ";

                 

       

        $front .= "</script>";



        return $front;  

    } else {

    

       

    }



}

    
 

add_action('init', 'BuilderUX_shortcodes');



function builderux_config(){

       global $wpdb;
	   
	   $table_name = $wpdb->prefix ."BuilderUX";

       $table_namedata = $wpdb->prefix ."BuilderUXdata";
 
	   $table_builder_lead_settings = $wpdb->prefix ."builder_lead_settings";
	   
	  
       $other_settings = $wpdb->get_row('SELECT * FROM '.$table_builder_lead_settings.'');
	   
	 	   
	   $guid = $other_settings->guid;
	   
	   $wsdl = $other_settings->wsdl;	  
		

       //$guid = "BA466E0E-388C-4789-9E6B-7DF2369BF4D2";
       //$wsdl = "http://sandbox.salessimplicity.net/sb_wci/svcEleads/eleads.asmx?WSDL";
     
     
      global $add_my_script;

      $add_my_script = true;


     /* $tempid = $args['id'];

 
     /*if($tempid.trim("")!==""){


        $data  = $wpdb->get_row("SELECT * FROM " . $table_name." where templateid ='". $tempid."'");

		$showtext = json_decode($data->showtext,true);

        $guid = $data->guid;

        $wsdl = $data->wsdl;

        $error_page = $data->error_page;

        $redirect_page = $data->redirect_page;

        $requiredtext =json_decode($data->requiredtext,true);

		$sequence_value = json_decode($data->sequence,true); 

        $labeltext = json_decode($data->labeltext,true);

        $selectiontext = json_decode($data->selectiontext,true);

        $hiddentext = json_decode($data->hiddentext,true);

        $defaultext = json_decode($data->defaultext,true);

        $classtext = json_decode($data->classtext,true);

        $typetext = json_decode($data->fieldtype,true);

        $customizetext = json_decode($data->iscustomize,true);

        $button_text = $data->button_text;

		$coloumn_style = $data->coloumn_style;

        $title = $data->title;

        $header_text = $data->header_text;

        $thisid = uniqid();

        //$button = $data->button_format;

        $button = 3;

        $blndemo = false;


    }*/



//echo 'test';

?>


<link rel='stylesheet' id='builderux_css_and_js-css'  href='<?php echo plugins_url('BuilderUX/css/bootstrap.min.css?ver=4.3.1'); ?>' type='text/css' media='all' />
<script>

jQuery(function(){

    jQuery('#template_selector').on('change',function(){

        var template = jQuery( "#template_selector" ).val();

        console.log(template);

        if(template == 0){jQuery('.custom_admindata').hide();

        }else{

        jQuery.ajax({

        url:'<?php echo plugins_url('BuilderUX/config.php'); ?>',

        type:'POST',

        data:{'template':template},

        success:function(data){ 

        //console.log(data);    

        jQuery('.custom_admindata').html(data);

        jQuery('.custom_admindata').show();

        }   

        }); 

        }

        });

    

});

</script>

<script>

jQuery(function(){

jQuery('#update_template').on('click',function(){

var template = jQuery( "#template_selector" ).val();

var guid = jQuery( "#guid" ).val();

var wsdl = jQuery( "#wsdl" ).val();

var form_data = jQuery('#template_config').serialize();

/*var thankyoutext = jQuery('.thankyoutext').val();

var redirect_page = jQuery('.redirect_pager').val();*/

//jQuery('.updater_gif').show();

    jQuery.ajax({

        url:'<?php echo plugins_url('BuilderUX/configupdate.php'); ?>',

        type:'POST',

        dataType: 'JSON',

        data:{'form_data':form_data},

        success:function(data){

        //console.log(data);
		
		alert('Updated Successfully!');

        }   

       });

     });  

});

</script>

<?php echo $_POST['template']; ?>

<div class="row">

</div>

<div class="row">

            <div class="col-md-9 custom_admindata">

 <div class="col-md-4">Guid</div>

<form id="template_config" method="post">

                <div class="col-md-8">

                       <div class="form-group"><input type="text" id="guid" name="builder[guid]" value="<?php echo $guid; ?>"  class="form-control" required="required" />  

                 </div></div>

                

               <div class="col-md-4">WSDL</div>

               <div class="col-md-8">

                       <div class="form-group"><input type="text" id="wsdl" name="builder[wsdl]" value="<?php echo $wsdl; ?>"  class="form-control" required="required" />  

               </div></div>

        </p>

        <?php
		         

           $myfieldsGlobal =  $wpdb->get_results('SELECT * FROM `'.$table_namedata.'`');
		  	      
		  // print_r($myfieldsGlobal);

               if(count($myfieldsGlobal) > 0) {

                    foreach($myfieldsGlobal as $f){

                    if ( ($f->leadname=="BuilderName") )

                    {

                       echo "<div class='row'><div class='col-md-2'>$f->leadname</div>  

                       <div class='small_row'><input type='checkbox' style='visibility: hidden' name='form-field-hide[$f->leadname]' checked></div>";
					
					
                        if(isset($showtext[$f->leadname]))

                        echo "<td><input  type='checkbox' name='form-field-show[$f->leadname]' checked></td>";

                        else

                        echo "<div class='col-md-2'><td><input rel='13' id='builder_chk' type='checkbox' name='form-field-show[$f->leadname]' checked></td></div>";  

                        echo "<select style='visibility: hidden' name='form-field-type[$f->leadname]'>";

                        echo  "<option value='input' selected>Input</option>";

                        echo "</select>";

                        echo "<div class='col-md-2' style='margin-left:0.4%'><input type='text' value='".(get_option('buildername') ?  get_option('buildername') : $defaultext[$f->leadname])."' name='form-field-default[$f->leadname]'><br/></div></div>";

                        echo '<div class="left"><button class="btn btn-success" id="update_template" name="temp_update" type="button">Update</button> </div></form><br/><div class="updater_gif"><img src='.plugins_url('BuilderUX/img/giphy.gif').' /></div>'; 

        }

      }

    }

    ?>

<?php

}

?>