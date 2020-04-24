<?php
        unset($info);
		unset($data);
	$info["table"] = "company";
	$info["fields"] = array("company.*"); 
	$info["where"]   = "1";
	$rescompany =  $db->select($info);
?>

<table class="table" align="center" width="100%">    
    <tr>
        <td width="30%">
           <img src="../../<?=$rescompany[0]['file_company_logo']?>" style="width:100px;">
        </td>
        <td align="center">      
          <h3><?=$rescompany[0]['company_name']?></h3>
          <?=$rescompany[0]['address']?><br>
          <?=$rescompany[0]['city']?>,<?=$rescompany[0]['state']?>,<?=$rescompany[0]['zip']?>,<?=$rescompany[0]['country']?><br>
        </td>
        <td  width="30%">
        </td>
    </tr>
</table>
<?php
  	    $arr_customer = explode(",",$_REQUEST['customer_name']);   
		foreach($arr_customer as $key=>$value){ 	
			     
				$whrstr = "";
				if(!empty($_REQUEST['customer_name']))
				{
					$whrstr .= "AND customers_id='".$value."'";
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
 
?>

<br><br><br>
 <!--mpdf
					
                    <htmlpageheader name="firstpage" style="display:none">
                    </htmlpageheader>
                    
                    <htmlpageheader name="otherpages" style="display:none;">
                        <span style="float:left;">Invoice no:<?=$arr[0]['invoice_no']?></span>
						<span  style="padding:5px;"> &nbsp; &nbsp; &nbsp;
						 &nbsp; &nbsp; &nbsp;</span>
                        <span style="float:right;"></span>         
                    </htmlpageheader>  
                    
                    <sethtmlpageheader name="firstpage" value="on" show-this-page="1" />
                    <sethtmlpageheader name="otherpages" value="on" />
                    
                    
                      <htmlpagefooter name="myfooter"  style="display:none">                          
                   		 <div align="center">
                         	    <?=$rescompany[0]['report_footer']?> 
                                   <br><span style="padding:10px;">Page {PAGENO} of {nbpg}</span> 
                         </div>
					
					</htmlpagefooter>
					
					<sethtmlpagefooter name="myfooter" value="on" />
                    
                    
                    <style>
                    
                    
                    @page :first {
                    header: firstpage;
                    }
                    
                    @page {
                    header: otherpages;
                    }
                    
                    @page {
                    footer: myfooter;
                    }
                    </style>
                    
                  mpdf--> 
                  
             
                  
<table class="table">
        <tr bgcolor="#ABCAE0">
            <td>Customers</td>
            <td>Invoice No</td>
            <td>Date Of Service</td>
            <td>Tech Users</td>
            <td>Service</td>
            <td>Item Cost</td>    
        </tr>
		 <?php
            
                for($i=0;$i<count($arr);$i++)
                {
                
                   $rowColor;
        
                    if($i % 2 == 0)
                    {
                        
                        $row="#C8C8C8";
                    }
                    else
                    {
                        
                        $row="#FFFFFF";
                    }
                
         ?>
            <tr bgcolor="<?=$row?>" onmouseover=" this.style.background='#ECF5B6'; " onmouseout=" this.style.background='<?=$row?>'; ">
               <td>
                    <?php
                        unset($info2);        
                        $info2['table']    = "customers";	
                        $info2['fields']   = array("customer_name");	   	   
                        $info2['where']    =  "1 AND id='".$arr[$i]['customers_id']."' LIMIT 0,1";
                        $res2  =  $db->select($info2);
                        echo $res2[0]['customer_name'];	
                    ?>
               </td>
               <td><?=$arr[$i]['invoice_no']?></td>
               <td><?=$arr[$i]['date_of_service']?></td>
               <td>
                    <?php
                        unset($info2);        
                        $info2['table']    = "users";	
                        $info2['fields']   = array("*");	   	   
                        $info2['where']    =  "1 AND id='".$arr[$i]['tech_users_id']."' LIMIT 0,1";
                        $res2  =  $db->select($info2);
                        echo $res2[0]['first_name']." ".$res2[0]['last_name'];	
                    ?>
               </td>
               <td>
                    <?php
                        unset($info2);        
                        $info2['table']    = "service";	
                        $info2['fields']   = array("service_name");	   	   
                        $info2['where']    =  "1 AND id='".$arr[$i]['service_id']."' LIMIT 0,1";
                        $res2  =  $db->select($info2);
                        echo $res2[0]['service_name'];	
                    ?>
               </td>
              <td><?=$arr[$i]['item_cost']?></td>
            </tr>
        <?php
                  }
        ?>
        <tr><td colspan="5" align="right">Sub Total</td><td><b>$<?=$total?></b></td></tr>    
</table>

<?php
	}
?>		