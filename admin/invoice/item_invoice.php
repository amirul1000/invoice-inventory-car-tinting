<table class="table">
    <tr bgcolor="#ABCAE0">
        <td>Service</td>
        <td>Item Cost</td>
        <td>Make</td>
        <td>Model</td>
        <td>Color</td>
        <td>Year</td>
        <td>Vin</td>
        <td>Tag</td>                                
    </tr>
 <?php
        
          unset($info);
		  unset($data);
        $info["table"] = "item_invoice";
        $info["fields"] = array("item_invoice.*"); 
        $info["where"]   = "1   AND invoice_id='".$arr[0]['id']."' ";
                            
        
        $res =  $db->select($info);
        
        for($j=0;$j<count($res);$j++)
        {
 ?>
    <tr>
      <td>
            <?php
                unset($info2);        
                $info2['table']    = "service";	
                $info2['fields']   = array("service_name");	   	   
                $info2['where']    =  "1 AND id='".$res[$j]['service_id']."' LIMIT 0,1";
                $res2  =  $db->select($info2);
                echo $res2[0]['service_name'];	
            ?>
      </td>
      <td><?=$res[$j]['item_cost']?></td>
      <td><?=$res[$j]['make']?></td>
      <td><?=$res[$j]['model']?></td>
      <td><?=$res[$j]['color']?></td>
      <td><?=$res[$j]['year']?></td>
      <td><?=$res[$j]['vin']?></td>
      <td><?=$res[$j]['tag']?></td>
    </tr>
<?php
          }
?>
</table>						