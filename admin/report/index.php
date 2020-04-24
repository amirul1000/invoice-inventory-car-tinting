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
		 case "customer_name":
		       $info["table"] = "customers";
				$info["fields"] = array("customers.*"); 
				$info["where"]   = "1 ORDER BY customer_name ASC";
				$arr =  $db->select($info);
				echo json_encode($arr);
		       break;
	     case "search":
				/*	unset($info);
					unset($data);
				$info["table"] = "company";
				$info["fields"] = array("company.*"); 
				$info["where"]   = "1";
				$rescompany =  $db->select($info);
				
				$whrstr = "";
				if(!empty($_REQUEST['customer_name']))
				{
					$whrstr .= "AND customers_id='".$_REQUEST['customer_name']."'";
				}
				if(!empty($_REQUEST['service']))
				{
					$whrstr .= "AND service_id='".$_REQUEST['service']."'";
				}
				if(!empty($_REQUEST['tech_users_id']))
				{
					$whrstr .= "AND tech_users_id='".$_REQUEST['tech_users_id']."'";
				}
				if(!empty($_REQUEST['from_date_of_service']) && !empty($_REQUEST['to_date_of_service']))
				{
					$whrstr .= "AND date_of_service BETWEEN '".$_REQUEST['from_date_of_service']."' AND '".$_REQUEST['to_date_of_service']."'";
				}
				else if(!empty($_REQUEST['from_date_of_service']))
				{
					$whrstr .= "AND date_of_service = '".$_REQUEST['from_date_of_service']."'";
				}
				
					unset($info);
					unset($data);		  
				$info["table"] = "item_invoice LEFT JOIN invoice ON(item_invoice.invoice_id=invoice.id)";
				$info["fields"] = array("item_invoice.*,invoice.*"); 
				$info["where"]   = "1   $whrstr ORDER BY invoice.date_of_service DESC";
				//$info["debug"]   =	true;				
				
				$arr =  $db->select($info);
				
				$total = 0;
				for($i=0;$i<count($arr);$i++)
				{
					$total +=$arr[$i]['item_cost'];
				}
 */
				// get the HTML
				ob_start();
				include(dirname(__FILE__).'/report_pdf.php');
				$html = ob_get_clean();
		     
		      if($_REQUEST['btn_submit'] == 'Pdf')
			  {
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
			  }
			  else
			  {
		        include("report_view.php");	
			  }
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
				include("report_view.php");
				break; 
    
	     default :    
		       include("report_view.php");		         
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
?>
