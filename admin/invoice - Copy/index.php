<?php
       session_start();
       include("../../common/lib.php");
	   include("../../lib/class.db.php");
	   include("../../common/config.php");
	   
	    if(empty($_SESSION['users_id'])) 
	   {
	     Header("Location: ../login/");
	   }
	  
	   $cmd = $_REQUEST['cmd'];
	   switch($cmd)
	   {
	     
		  case 'add': 
				$info['table']    = "invoice";
				$data['customers_id']   = $_REQUEST['customers_id'];
                $data['date_of_service']   = $_REQUEST['date_of_service'];
                $data['tech_users_id']   = $_REQUEST['tech_users_id'];
                $data['description']   = $_REQUEST['description'];
                $data['internal_notes_tech']   = $_REQUEST['internal_notes_tech'];
                $data['total_cost']   = $_REQUEST['total_cost'];
                $data['amount_paid']   = $_REQUEST['amount_paid'];
                
				
				$info['data']     =  $data;
				
				if(empty($_REQUEST['id']))
				{
					 $db->insert($info);
				}
				else
				{
					$Id            = $_REQUEST['id'];
					$info['where'] = "id=".$Id;
					
					$db->update($info);
				}
				
				include("invoice_list.php");						   
				break;    
		case "edit":      
				$Id               = $_REQUEST['id'];
				if( !empty($Id ))
				{
					$info['table']    = "invoice";
					$info['fields']   = array("*");   	   
					$info['where']    =  "id=".$Id;
				   
					$res  =  $db->select($info);
				   
					$Id        = $res[0]['id'];  
					$customers_id    = $res[0]['customers_id'];
					$date_of_service    = $res[0]['date_of_service'];
					$tech_users_id    = $res[0]['tech_users_id'];
					$description    = $res[0]['description'];
					$internal_notes_tech    = $res[0]['internal_notes_tech'];
					$total_cost    = $res[0]['total_cost'];
					$amount_paid    = $res[0]['amount_paid'];
					
				 }
						   
				include("invoice_editor.php");						  
				break;
						   
         case 'delete': 
				$Id               = $_REQUEST['id'];
				
				$info['table']    = "invoice";
				$info['where']    = "id='$Id'";
				
				if($Id)
				{
					$db->delete($info);
				}
				include("invoice_list.php");						   
				break; 
						   
         case "list" :    	 
			  if(!empty($_REQUEST['page'])&&$_SESSION["search"]=="yes")
				{
				  $_SESSION["search"]="yes";
				}
				else
				{
				   $_SESSION["search"]="no";
					unset($_SESSION["search"]);
					unset($_SESSION['field_name']);
					unset($_SESSION["field_value"]); 
				}
				include("invoice_list.php");
				break; 
        case "search_invoice":
				$_REQUEST['page'] = 1;  
				$_SESSION["search"]="yes";
				$_SESSION['field_name'] = $_REQUEST['field_name'];
				$_SESSION["field_value"] = $_REQUEST['field_value'];
				include("invoice_list.php");
				break;  								   
						
	     default :    
		       include("invoice_list.php");		         
	   }

//Protect same image name
 function getMaxId($db)
 {	  
   $sql    = "SHOW TABLE STATUS LIKE 'invoice'";
	$result = $db->execQuery($sql);
	$row    = $db->resultArray();
	return $row[0]['Auto_increment'];	   
 } 	 
?>
