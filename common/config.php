<?php 

   $host     = "n3c83941519983.db.3941519.hostedresource.com:3309"; 
   $database = "n3c83941519983";
   $user     = "n3c83941519983";
   $password = "Dy@r!MacHa5|=";
   
   
   $host     = "localhost"; 
   $database = "car_tinting";
   $user     = "root";
   $password = "secret";
   
   $db  = new Db($host,$user,$password,$database);
   
   if($db->linkid=='')
   {
	 echo "Could not connect with server! .Database Connection Error";   
   	 exit;
   }
   
   $GLOBALS['DB'] = $db;
   
   $user     = "";
   $password = "";

?>
