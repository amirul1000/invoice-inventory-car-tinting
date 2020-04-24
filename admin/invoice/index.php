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
				if(empty($_REQUEST['id']))
				{
					$data['invoice_no']     = save_invoice_no($db);
				}
				$data['customers_id']   = save_customer($db);
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
					 $Id = $db->lastInsert(true);
				}
				else
				{
					$Id            = $_REQUEST['id'];
					$info['where'] = "id=".$Id;
					$db->update($info);
				}
				
				/////////////save files /////////
					/*unset($info);
					unset($data);
				$info['table']    = "invoice_pictures";
				$info['where']    = "id='$Id'";
					$db->delete($info);*/
					
				for($i=0;$i<count($_FILES['file_picture']['name']);$i++)
				{
					if(strlen($_FILES['file_picture']['name'][$i])>0 && $_FILES['file_picture']['size'][$i]>0)
					{
							
							unset($info);
							unset($data);
						$info['table']    = "invoice_pictures";
						$data['invoice_id']   = $Id;
					
						
						if(!file_exists("../../invoice_pictures_images"))
						{ 
						   mkdir("../../invoice_pictures_images",0755);	
						}
						if(empty($_REQUEST['id']))
						{
						  $file=getMaxId($db)."_".str_replace(" ","_",strtolower(trim($_FILES['file_picture']['name'][$i])));
						}
						else
						{
						  $file=trim($_REQUEST['id'])."_".str_replace(" ","_",strtolower(trim($_FILES['file_picture']['name'][$i])));
						}
						$filePath="../../invoice_pictures_images/".$file;
						move_uploaded_file($_FILES['file_picture']['tmp_name'][$i],$filePath);
						$data['file_picture']="invoice_pictures_images/".trim($file);
						
						$info['data']     =  $data;
					    $db->insert($info);
					}
					
				}
				
				//camera
				for($i=1;$i<=count($_SESSION['camera']);$i++)
				{
						  unset($info);
						  unset($data);
						$info['table']    = "invoice_pictures";
						$data['invoice_id']   = $Id;
					    $data['file_picture']= $_SESSION['camera'][$i];
						$info['data']     =  $data;
					    $db->insert($info);
				}
				unset($_SESSION['camera']);
				////////////save item////////////
				
					unset($info);
					unset($data);
				$info['table']    = "item_invoice";
				$info['where']    = "invoice_id='$Id'";
					$db->delete($info);
					
				for($i=0;$i<count($_REQUEST['service_id']);$i++)
				{
					   unset($info);
					   unset($data);
					$info['table']    = "item_invoice";
					$data['invoice_id']   = $Id;
					$data['service_id']   = $_REQUEST['service_id'][$i];
					$data['item_cost']   = $_REQUEST['item_cost'][$i];
					$data['make']   = $_REQUEST['make'][$i];
					$data['model']   = $_REQUEST['model'][$i];
					$data['color']   = $_REQUEST['color'][$i];
					$data['year']   = $_REQUEST['year'][$i];
					$data['vin']   = $_REQUEST['vin'][$i];
					$data['tag']   = $_REQUEST['tag'][$i];
					$info['data']     =  $data;
						 $db->insert($info);
				}
				
				include("invoice_list.php");						   
				break;    
		case "edit":      
				$Id               = $_REQUEST['id'];
				if( !empty($Id ))
				{
					  unset($info);
					  unset($data);
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
					
					/////////////Customer///////////////
					  unset($info);
					  unset($data);
					$info['table']    = "customers";
					$info['fields']   = array("*");   	   
					$info['where']    =  "id=".$customers_id;
				   
					$res  =  $db->select($info);
				   
					$customer_id        = $res[0]['id'];  
					$customer_name    = $res[0]['customer_name'];
					$customer_name_2    = $res[0]['customer_name'];
					$address    = $res[0]['address'];
					$city    = $res[0]['city'];
					$state    = $res[0]['state'];
					$zip    = $res[0]['zip'];
					$contact    = $res[0]['contact'];
					$phone_no    = $res[0]['phone_no'];
					$email    = $res[0]['email'];
					//////////////////item invoice///////////////////
					$info["table"] = "item_invoice";
					$info["fields"] = array("item_invoice.*"); 
					$info["where"]   = "1  AND invoice_id='".$_REQUEST['id']."'";
					$arr_item_invoice =  $db->select($info);
					
				 }
						   
				include("invoice_editor.php");						  
				break;
						   
         case 'delete': 
				$Id               = $_REQUEST['id'];
				  unset($info);
				  unset($data);  
				$info['table']    = "invoice";
				$info['where']    = "id='$Id'";
				if($Id)
				{
					$db->delete($info);
					
					//item invoice
					$info['table']    = "item_invoice";
					$info['where']    = "invoice_id='$Id'";
						$db->delete($info);
						
					//delete
					$info['table']    = "invoice_pictures";
					$info['where']    = "invoice_id='$Id'";
						$db->delete($info);
						
				}
				include("invoice_list.php");						   
				break; 
		case "delete_picture":
					$info['table']    = "invoice_pictures";
					$info['where']    = "id='".$_REQUEST['id']."'";
						$db->delete($info);     
		       include("invoice_list.php");						   
				break; 	
		 case "customer_name":
		       $info["table"] = "customers";
				$info["fields"] = array("customers.*"); 
				$info["where"]   = "1 ORDER BY customer_name ASC";
				$arr =  $db->select($info);
				echo json_encode($arr);
		       break;
		 case "customer_detail":
				$info["table"] = "customers";
				$info["fields"] = array("customers.*"); 
				$info["where"]   = "1  AND id='".$_REQUEST['id']."' ORDER BY customer_name ASC";
				$arr =  $db->select($info);
				echo json_encode($arr);
		       break;
			   
			   
		case "address":
				$info["table"] = "customers";
				$info["fields"] = array("distinct(address) as address"); 
				$info["where"]   = "1 ORDER BY address ASC";
				$arr =  $db->select($info);
				
				for($i=0;$i<count($arr);$i++)
				{
					$found_addresss[] = $arr[$i]['address'];
				}
				
				
				$json = '[';
				foreach($found_addresss as $key => $address) {
					$json .= '{"name": "' . $address . '"}';
		
					if ($address !== end($found_addresss)) {
						$json .= ',';	
					}
				}
				$json .= ']';
				
		        header('Content-Type: application/json');
				echo $json;
		       break;
			   
		case "city":
				$info["table"] = "customers";
				$info["fields"] = array("distinct(city) as city"); 
				$info["where"]   = "1 ORDER BY city ASC";
				$arr =  $db->select($info);
				
				for($i=0;$i<count($arr);$i++)
				{
					$found_citys[] = $arr[$i]['city'];
				}
				
				
				$json = '[';
				foreach($found_citys as $key => $city) {
					$json .= '{"name": "' . $city . '"}';
		
					if ($city !== end($found_citys)) {
						$json .= ',';	
					}
				}
				$json .= ']';
				
		        header('Content-Type: application/json');
				echo $json;
		       break;
			   
		case "state":
				$info["table"] = "customers";
				$info["fields"] = array("distinct(state) as state"); 
				$info["where"]   = "1 ORDER BY state ASC";
				$arr =  $db->select($info);
				
				for($i=0;$i<count($arr);$i++)
				{
					$found_states[] = $arr[$i]['state'];
				}
				
				
				$json = '[';
				foreach($found_states as $key => $state) {
					$json .= '{"name": "' . $state . '"}';
		
					if ($state !== end($found_states)) {
						$json .= ',';	
					}
				}
				$json .= ']';
				
		        header('Content-Type: application/json');
				echo $json;
		       break;
			   
		case "zip":
				$info["table"] = "customers";
				$info["fields"] = array("distinct(zip) as zip"); 
				$info["where"]   = "1 ORDER BY zip ASC";
				$arr =  $db->select($info);
				
				for($i=0;$i<count($arr);$i++)
				{
					$found_zips[] = $arr[$i]['zip'];
				}
				
				
				$json = '[';
				foreach($found_zips as $key => $zip) {
					$json .= '{"name": "' . $zip . '"}';
		
					if ($zip !== end($found_zips)) {
						$json .= ',';	
					}
				}
				$json .= ']';
				
		        header('Content-Type: application/json');
				echo $json;
		       break;
			   
		case "contact":
				$info["table"] = "customers";
				$info["fields"] = array("distinct(contact) as contact"); 
				$info["where"]   = "1 ORDER BY contact ASC";
				$arr =  $db->select($info);
				
				for($i=0;$i<count($arr);$i++)
				{
					$found_contacts[] = $arr[$i]['contact'];
				}
				
				
				$json = '[';
				foreach($found_contacts as $key => $contact) {
					$json .= '{"name": "' . $contact . '"}';
		
					if ($contact !== end($found_contacts)) {
						$json .= ',';	
					}
				}
				$json .= ']';
				
		        header('Content-Type: application/json');
				echo $json;
		       break;
		 case "phone_no":
				$info["table"] = "customers";
				$info["fields"] = array("distinct(phone_no) as phone_no"); 
				$info["where"]   = "1 ORDER BY phone_no ASC";
				$arr =  $db->select($info);
				
				for($i=0;$i<count($arr);$i++)
				{
					$found_contacts[] = $arr[$i]['phone_no'];
				}
				
				
				$json = '[';
				foreach($found_contacts as $key => $contact) {
					$json .= '{"name": "' . $contact . '"}';
		
					if ($contact !== end($found_contacts)) {
						$json .= ',';	
					}
				}
				$json .= ']';
				
		        header('Content-Type: application/json');
				echo $json;
		       break;	
		  case "email":
				$info["table"] = "customers";
				$info["fields"] = array("distinct(email) as email"); 
				$info["where"]   = "1 ORDER BY email ASC";
				$arr =  $db->select($info);
				
				for($i=0;$i<count($arr);$i++)
				{
					$found_emails[] = $arr[$i]['email'];
				}
				
				
				$json = '[';
				foreach($found_emails as $key => $contact) {
					$json .= '{"name": "' . $contact . '"}';
		
					if ($contact !== end($found_emails)) {
						$json .= ',';	
					}
				}
				$json .= ']';
				
		        header('Content-Type: application/json');
				echo $json;
		       break;	   	      
		 case "service_detail":
		           unset($info);
				   unset($data);
				$info['table']    = "service";
				$info['fields']   = array("*");   	   
				$info['where']    = "1  AND id='".$_REQUEST['id']."'";
				$arr  =  $db->select($info);
				
				if(!empty($_REQUEST['customers_id']))
				{
					  unset($info);
					  unset($data);
					$info['table']    = "invoice";
					$info['fields']   = array("*");   	   
					$info['where']    =  "customers_id=".$_REQUEST['customers_id']." ORDER BY id DESC LIMIT 0,1";
					$res1  =  $db->select($info);
					
					if(count($res1)>0)
					{
						 unset($info);
						 unset($data);
						$info['table']    = "item_invoice";
						$info['fields']   = array("*");   	   
						$info['where']    =  "invoice_id=".$res1[0]['id']." ORDER BY id DESC LIMIT 0,1";
						$res2  =  $db->select($info);
					}
					
				}
				
				$arr2[0]['id'] = $arr[0]['id'];
				$arr2[0]['service_name'] = $arr[0]['service_name'];
				$arr2[0]['cost']         = $arr[0]['cost'];
				
				$arr2[0]['make']         = $res2[0]['make'];
				$arr2[0]['model']        = $res2[0]['model'];
				$arr2[0]['color']        = $res2[0]['color'];
				$arr2[0]['year']         = $res2[0]['year'];
				$arr2[0]['vin']          = $res2[0]['vin'];
				$arr2[0]['tag']          = $res2[0]['tag'];
				
				echo json_encode($arr2);
		       break; 
		 case "make":
		        $info["table"] = "item_invoice";
				$info["fields"] = array("distinct(make) as make"); 
				$info["where"]   = "1";
				$arr =  $db->select($info);
				
				for($i=0;$i<count($arr);$i++)
				{
					$found_makes[] = $arr[$i]['make'];
				}
				
				
				$json = '[';
				foreach($found_makes as $key => $make) {
					$json .= '{"name": "' . $make . '"}';
		
					if ($make !== end($found_makes)) {
						$json .= ',';	
					}
				}
				$json .= ']';
				
		        header('Content-Type: application/json');
				echo $json;
		      break;	
	     case "model":
		        $info["table"] = "item_invoice";
				$info["fields"] = array("distinct(model) as model"); 
				$info["where"]   = "1";
				$arr =  $db->select($info);
				
				for($i=0;$i<count($arr);$i++)
				{
					$found_models[] = $arr[$i]['model'];
				}
				
				
				$json = '[';
				foreach($found_models as $key => $model) {
					$json .= '{"name": "' . $model . '"}';
		
					if ($model !== end($found_models)) {
						$json .= ',';	
					}
				}
				$json .= ']';
				
		        header('Content-Type: application/json');
				echo $json;
		      break;	   
		 case "color":
		        $info["table"] = "item_invoice";
				$info["fields"] = array("distinct(color) as color"); 
				$info["where"]   = "1";
				$arr =  $db->select($info);
				
				for($i=0;$i<count($arr);$i++)
				{
					$found_colors[] = $arr[$i]['color'];
				}
				
				
				$json = '[';
				foreach($found_colors as $key => $color) {
					$json .= '{"name": "' . $color . '"}';
		
					if ($color !== end($found_colors)) {
						$json .= ',';	
					}
				}
				$json .= ']';
				
		        header('Content-Type: application/json');
				echo $json;
		      break;	   
		case "year":
		        $info["table"] = "item_invoice";
				$info["fields"] = array("distinct(year) as year"); 
				$info["where"]   = "1";
				$arr =  $db->select($info);
				
				for($i=0;$i<count($arr);$i++)
				{
					$found_years[] = $arr[$i]['year'];
				}
				
				
				$json = '[';
				foreach($found_years as $key => $year) {
					$json .= '{"name": "' . $year . '"}';
		
					if ($year !== end($found_years)) {
						$json .= ',';	
					}
				}
				$json .= ']';
				
		        header('Content-Type: application/json');
				echo $json;
		      break;
		 case "vin":
		        $info["table"] = "item_invoice";
				$info["fields"] = array("distinct(vin) as vin"); 
				$info["where"]   = "1";
				$arr =  $db->select($info);
				
				for($i=0;$i<count($arr);$i++)
				{
					$found_vins[] = $arr[$i]['vin'];
				}
				
				
				$json = '[';
				foreach($found_vins as $key => $vin) {
					$json .= '{"name": "' . $vin . '"}';
		
					if ($vin !== end($found_vins)) {
						$json .= ',';	
					}
				}
				$json .= ']';
				
		        header('Content-Type: application/json');
				echo $json;
		      break;	   
			case "tag":
		        $info["table"] = "item_invoice";
				$info["fields"] = array("distinct(tag) as tag"); 
				$info["where"]   = "1";
				$arr =  $db->select($info);
				
				for($i=0;$i<count($arr);$i++)
				{
					$found_tags[] = $arr[$i]['tag'];
				}
				
				
				$json = '[';
				foreach($found_tags as $key => $tag) {
					$json .= '{"name": "' . $tag . '"}';
		
					if ($tag !== end($found_tags)) {
						$json .= ',';	
					}
				}
				$json .= ']';
				
		        header('Content-Type: application/json');
				echo $json;
		      break;	     	  	  	  		     
		 case "print":
		                unset($info);
						unset($data);
					  $info["table"] = "company";
					  $info["fields"] = array("company.*"); 
					  $info["where"]   = "1";
					  $rescompany =  $db->select($info);
                      // get the HTML
					    ob_start();
					    include(dirname(__FILE__).'/print_template.php');
					    $html = ob_get_clean();
						
					
		           
						include("../../mpdf60/mpdf.php");					
							$mpdf=new mPDF('','A4'); 
						
						//$mpdf=new mPDF('c','A4','','',32,25,27,25,16,13); 
						//$mpdf->mirrorMargins = true;

                       $mpdf->SetDisplayMode('fullpage');
						//==============================================================
						$mpdf->autoScriptToLang = true;
						$mpdf->baseScript = 1;	// Use values in classes/ucdn.php  1 = LATIN
						$mpdf->autoVietnamese = true;
						$mpdf->autoArabic = true;
						
						$mpdf->autoLangToFont = true;
						
						$mpdf->setAutoBottomMargin = 'stretch'; 
						
						/* This works almost exactly the same as using autoLangToFont:
							$stylesheet = file_get_contents('../lang2fonts.css');
							$mpdf->WriteHTML($stylesheet,1);
						*/
						$mpdf->SetWatermarkImage('../../'.$rescompany[0]['file_report_background'], 0.20, 'F');
						$mpdf->showWatermarkImage = true;
						
						$stylesheet = file_get_contents('../../mpdf60/lang2fonts.css');
						$mpdf->WriteHTML($stylesheet,1);
						
						$mpdf->WriteHTML($html);
						//$mpdf->AddPage();
						
						
												
						$mpdf->Output($filePath);
						$mpdf->Output();
						//$mpdf->Output( $filePath,'S');
						exit;	
				  break;
		 case "send_email":
		            //https://www.codexworld.com/send-email-with-attachment-php/
		            //recipient
					
					  /* unset($info2);        
					$info2['table']    = "customers";	
					$info2['fields']   = array("*");	   	   
					$info2['where']    =  "1 AND id='".$_REQUEST['customers_id']."' LIMIT 0,1";
					$res2  =  $db->select($info2);
					
					$to = $res2[0]['email'];
					
					//sender
					$from = 'sender@cartinting.com';
					$fromName = 'Car Tinting';
					
					//email subject
					$subject = 'Invoic from Car Tinting'; 
					
					//attachment file path
					$file = "Invoic.pdf";
					
					    unset($info);
						unset($data);
					  $info["table"] = "company";
					  $info["fields"] = array("company.*"); 
					  $info["where"]   = "1";
					  $rescompany =  $db->select($info);
                      // get the HTML
					    ob_start();
					    include(dirname(__FILE__).'/print_template.php');
					    $html = ob_get_clean();
						
					
		           
						include("../../mpdf60/mpdf.php");					
							$mpdf=new mPDF('','A4'); 
						
						//$mpdf=new mPDF('c','A4','','',32,25,27,25,16,13); 
						//$mpdf->mirrorMargins = true;

                       $mpdf->SetDisplayMode('fullpage');
						//==============================================================
						$mpdf->autoScriptToLang = true;
						$mpdf->baseScript = 1;	// Use values in classes/ucdn.php  1 = LATIN
						$mpdf->autoVietnamese = true;
						$mpdf->autoArabic = true;
						
						$mpdf->autoLangToFont = true;
						
						$mpdf->setAutoBottomMargin = 'stretch'; 
						
						
						$mpdf->SetWatermarkImage('../../'.$rescompany[0]['file_report_background'], 0.20, 'F');
						$mpdf->showWatermarkImage = true;
						
						$stylesheet = file_get_contents('../../mpdf60/lang2fonts.css');
						$mpdf->WriteHTML($stylesheet,1);
						
						$mpdf->WriteHTML($html);
						//$mpdf->AddPage();
						
						
												
						//$mpdf->Output($filePath);
						//$mpdf->Output();
						$mpdf->Output( $file,'S');
					
					//email body content
					$htmlContent = $html;
					
					
					//header for sender info
					$headers = "From: $fromName"." <".$from.">";
					
					//boundary 
					$semi_rand = md5(time()); 
					$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
					
					//headers for attachment 
					$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
					
					//multipart boundary 
					$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
					"Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n"; 
					
					//preparing attachment
					if(!empty($file) > 0){
						if(is_file($file)){
							$message .= "--{$mime_boundary}\n";
							$fp =    @fopen($file,"rb");
							$data =  @fread($fp,filesize($file));
					
							@fclose($fp);
							$data = chunk_split(base64_encode($data));
							$message .= "Content-Type: application/octet-stream; name=\"".basename($file)."\"\n" . 
							"Content-Description: ".basename($file)."\n" .
							"Content-Disposition: attachment;\n" . " filename=\"".basename($file)."\"; size=".filesize($file).";\n" . 
							"Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
						}
					}
					$message .= "--{$mime_boundary}--";
					$returnpath = "-f" . $from;
					
					//send email
					$mail = @mail($to, $subject, $message, $headers, $returnpath); 
					
					//email sending status
					//echo $mail?"<h1>Mail sent.</h1>":"<h1>Mail sending failed.</h1>";
		          */
				  
				      unset($info2);        
					$info2['table']    = "customers";	
					$info2['fields']   = array("*");	   	   
					$info2['where']    =  "1 AND id='".$_REQUEST['customers_id']."' LIMIT 0,1";
					$res2  =  $db->select($info2);
					
					$first_name = $res2[0]['first_name'];
					$last_name = $res2[0]['last_name'];
					$to = $res2[0]['email'];
					
					//sender
					$from = 'shadybiztintin@yahoo.com';
					$fromName = 'ShadyBiz Tinting';
					
				
					
					 // get the HTML
				  ob_start();
				  include(dirname(__FILE__).'/print_template.php');
				  $html = ob_get_clean();
					
					
			      
				  $subject = 'Invoice from ShadyBiz Tinting'; 
					
				  $body = "Dear $first_name $last_name,<br>
							   $html
							 
							 Thanks,<br>
							 ShadyBiz Tinting Team";
					//send email
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'From: ShadyBiz Tinting <shadybiztinting@yahoo.com>' . "\r\n";
					
					
					$status = mail($to, $subject, $body, $headers);
					
					if($status == 1)
					{
						$message ="An email has been sent to  E-mail address";	
					}
					else
					{
						$message ="Email sent error";	
					}
				   include("invoice_list.php");  
				  break;		  
	     case "details":
		            include("invoice_details.php");  
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
		       include("invoice_editor.php");		         
	   }

//Protect same image name
 function getMaxId($db)
 {	  
    $sql    = "SHOW TABLE STATUS LIKE 'invoice'";
	$result = $db->execQuery($sql);
	$row    = $db->resultArray();
	return $row[0]['Auto_increment'];	   
 } 	
 
 /*
   save csutomer 
 */ 
 function save_customer($db)
 {
	 
	$info['table']    = "customers";
	$data['customer_name']   = $_REQUEST['customer_name_2'];
	$data['address']   = $_REQUEST['address'];
	$data['city']   = $_REQUEST['city'];
	$data['state']   = $_REQUEST['state'];
	$data['zip']   = $_REQUEST['zip'];
	$data['contact']   = $_REQUEST['contact'];
	$data['phone_no']   = $_REQUEST['phone_no'];
	$data['email']   = $_REQUEST['email'];
	$info['data']     =  $data;
	
	if(empty($_REQUEST['customers_id']))
	{
		 $db->insert($info);
		 $Id = $db->lastInsert(true);
	}
	else
	{
		$Id            = $_REQUEST['customers_id'];
		$info['where'] = "id=".$Id;
		
		$db->update($info);
	}
	
	return $Id;
 }
 
 function save_invoice_no($db)
 {
	 
	  unset($info);
	  unset($data);
	$info['table']    = "invoice";
	$info['fields']   = array("*");   	   
	$info['where']    =  "1 ORDER BY id DESC LIMIT 0,1";
	$res  =  $db->select($info);
	$invoice_no = $res[0]['invoice_no'];
	if(empty($invoice_no))
	{
		return date("YM")."-01";
	}
	$arr = explode("-",$invoice_no);
	$no = $arr[1];
	
	if(is_numeric((int)$no))
	{
		$no = $no +1;
	}
	else
	{
		$no = 1;
	}
	if($no <10)
	{
		$no = "0".$no;
	}
	$invoice_no = date("Ym")."-".$no;
	
	return $invoice_no;
					
    /*$sql    = "SELECT UUID()";
	$result = $db->execQuery($sql);
	$row    = $db->resultArray();
	return substr(str_replace("-","",$row[0]['UUID()']),0,10);	*/ 
 }
?>
