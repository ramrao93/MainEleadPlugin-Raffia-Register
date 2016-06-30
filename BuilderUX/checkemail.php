<?php

        $email = $_GET["Email"];

        $communitynumber = $_GET["CommunityNumber"];
		
       // $checkmail = "https://ssnet.homesbyavi.com/ssnet/buxCheckEmail/buxCheckEmail.asmx?wsdl";

        $opt =  array(

            'trace'         => 1,

            'exceptions'   => 0,

            'style'         => SOAP_DOCUMENT,

            'use'         => SOAP_LITERAL,

            'soap_version'   => SOAP_1_1,

            'encoding'      => 'UTF-8'

         );

        $vSoapClient = new SoapClient($checkmail,$opt);

        $arr = array('Email' => $email,'Subdivision' => $communitynumber); 

        $vSendCustomerObject = $vSoapClient->HasLeadIn($arr);

        $resultx = $vSoapClient->__getLastResponse();

        if($resultx=='True') {

            echo "1";

        } else {

            echo "0";

        }
?>