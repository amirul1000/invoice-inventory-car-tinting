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
				$info['table']    = "item_invoice";
				$data['invoice_id']   = $_REQUEST['invoice_id'];
                $data['service_id']   = $_REQUEST['service_id'];
                $data['item_cost']   = $_REQUEST['item_cost'];
                $data['make']   = $_REQUEST['make'];
                $data['model']   = $_REQUEST['model'];
                $data['color']   = $_REQUEST['color'];
                $data['year']   = $_REQUEST['year'];
                $data['vin']   = $_REQUEST['vin'];
                $data['tag']   = $_REQUEST['tag'];
                
				
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
				
				include("item_invoice_list.php");						   
				break;    
		case "edit":      
				$Id               = $_REQUEST['id'];
				if( !empty($Id ))
				{
					$info['table']    = "item_invoice";
					$info['fields']   = array("*");   	   
					$info['where']    =  "id=".$Id;
				   
					$res  =  $db->select($info);
				   
					$Id        = $res[0]['id'];  
					$invoice_id    = $res[0]['invoice_id'];
					$service_id    = $res[0]['service_id'];
					$item_cost    = $res[0]['item_cost'];
					$make    = $res[0]['make'];
					$model    = $res[0]['model'];
					$color    = $res[0]['color'];
					$year    = $res[0]['year'];
					$vin    = $res[0]['vin'];
					$tag    = $res[0]['tag'];
					
				 }
						   
				include("item_invoice_editor.php");						  
				break;
						   
         case 'delete': 
				$Id               = $_REQUEST['id'];
				
				$info['table']    = "item_invoice";
				$info['where']    = "id='$Id'";
				
				if($Id)
				{
					$db->delete($info);
				}
				include("item_invoice_list.php");						   
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
				include("item_invoice_list.php");
				break; 
        case "search_item_invoice":
				$_REQUEST['page'] = 1;  
				$_SESSION["search"]="yes";
				$_SESSION['field_name'] = $_REQUEST['field_name'];
				$_SESSION["field_value"] = $_REQUEST['field_value'];
				include("item_invoice_list.php");
				break;  								   
						
	     default :    
		       include("item_invoice_list.php");		         
	   }

//Protect same image name
 function getMaxId($db)
 {	  
   $sql    = "SHOW TABLE STATUS LIKE 'item_invoice'";
	$result = $db->execQuery($sql);
	$row    = $db->resultArray();
	return $row[0]['Auto_increment'];	   
 } 	 
?>
