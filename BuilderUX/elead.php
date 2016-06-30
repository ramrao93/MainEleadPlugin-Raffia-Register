<?php

	session_start();

	/*----------------------  new test -------------------*/

	 //$var= "Testing for the demo change";	

	/*-----------------------------------------------------*/

   // $builder = $_POST["builder"];
  

  $builder=array();
 

  $builder = $_POST["builder"];

  
  //print_r($builder);

  	$filename = $builder["guid"].".txt";

	$buildername = $builder["Buildername"];

	$redirect_page = $builder["page"];

	$wsdl = $builder["sss"];

	$guid = $builder["guid"];

	$UpdateAllDemographics = $builder["UpdateAllDemographics"];

	$error_page = $builder["error_page"];

	$camefromurl = $_SERVER["HTTP_REFERER"];		

	$all ='';

	
	//echo 'filename='.$filename.'buildername='.$buildername.'$redirect_page='.$redirect_page.'$wsdl='.$wsdl.'$guid='.$guid.'$UpdateAllDemographics='.$UpdateAllDemographics.'$error_page='.$error_page.'$camefromurl='.$camefromurl;

	 //if($resultx=='True') {

//            header('Location: '.$error_page);

//        return true;

//    }


        $required = explode(",",$builder['x_fieldrequired']);

		$required = array_filter($required, create_function('$a','return preg_match("#\S#", $a);'));


        $pass = count($required) ? count($required) : 0;

        if($pass < 1)
        {
          $pass = 0;
		}
		
         $passed = 0;


        if(count($required) > 0)
		{
			foreach($required as $key => $value) {
	
				if($value!=''){
	
					if(isset($builder[$value]) && trim($builder[$value]) != "") {
	
						$passed = $passed+1;
	
					} 
	
				} else {
	
					$passed = $passed+1;
	
				}
	
			}
		}

       /* foreach($required as $key => $value) {

            if($value!=''){

                if(isset($builder[$value]) && trim($builder[$value]) != ""){

                    $passed = $passed+1;

                } 

            } else {

                $passed = $passed+1;

            }

        }*/

		 
        if( isset($builder['session']) && $builder['session'] != ""  && $builder['x_firstname']=="" && $pass==$passed)  
		{

 	       //unlink($builder["p"]);
			
            $client = new SoapClient($wsdl);

            $demos = array();

                    foreach($builder as $key => $value){

                        $mykey = substr($key, 0, 4);

                        if(strtoupper($mykey)=='DEMO')

                             $demos[] = $key.'='.$value; 

                    }

                if (getenv('HTTP_CLIENT_IP'))

                    $ipaddress = getenv('HTTP_CLIENT_IP');

                else if(getenv('HTTP_X_FORWARDED_FOR'))

                    $ipaddress = getenv('HTTP_X_FORWARDED_FOR');

                else if(getenv('HTTP_X_FORWARDED'))

                    $ipaddress = getenv('HTTP_X_FORWARDED');

                else if(getenv('HTTP_FORWARDED_FOR'))

                    $ipaddress = getenv('HTTP_FORWARDED_FOR');

                else if(getenv('HTTP_FORWARDED'))

                   $ipaddress = getenv('HTTP_FORWARDED');

                else if(getenv('REMOTE_ADDR'))

                    $ipaddress = getenv('REMOTE_ADDR');

                else

                    $ipaddress = 'UNKNOWN';     



                foreach($builder as $key => $value) {

                    if($key != 'session' && $key != 'guid' && $key != 'sss' && $key != 'page')

                        $lead[$key] = $value; 

                    if($key == 'StreetAddress')

                        $lead['Address1'] = $value? $value :"None";

                    if($key == 'StreetAddress2')

                        $lead['Address2'] = $value? $value : "None";

                    if($key == 'EmailAddress')

                        $lead['Email'] = $value;

                }

                $lead["IPAddress"] = $ipaddress;

                $lead["Comments"] = "None";

                $lead["Demos"] = $demos;

                $lead["CameFromURL"] = $camefromurl;

				$lead["BuilderName"] = $buildername;

				$lead["UpdateAllDemographics"] = $UpdateAllDemographics;
				

				// Selected community

				if(isset($builder['Subdivision'])){

					 $afterexlode = explode("*",$builder['Subdivision']);

					 $community_name = $afterexlode[0];

					 $community_number = $afterexlode[1];

				     $lead["Community"] = $community_name;// community name

				     $lead["CommunityNumber"] = $community_number;// community number

				}				 
				
                $lead=(object)$lead; 

				$result = $client->SubmitLead(array('sGUID' => $guid,'Contact' => $lead));
 				 
           		$all == false;

        } else {
			
        }

?>