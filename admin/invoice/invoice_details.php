<?php
 $assets_url = '../../v4.0.1/theme';
?>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="<?=$assets_url?>/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?=$assets_url?>/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="<?=$assets_url?>/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?=$assets_url?>/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<link href="<?=$assets_url?>/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link href="<?=$assets_url?>/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
<link href="<?=$assets_url?>/assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css"/>
<link href="<?=$assets_url?>/assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL PLUGIN STYLES -->
<!-- BEGIN PAGE STYLES -->
<link href="<?=$assets_url?>/assets/admin/pages/css/tasks.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE STYLES -->
<!-- BEGIN THEME STYLES -->
<!-- DOC: To use 'rounded corners' style just load 'components-rounded.css' stylesheet instead of 'components.css' in the below style tag -->
<link href="<?=$assets_url?>/assets/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="<?=$assets_url?>/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="<?=$assets_url?>/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="<?=$assets_url?>/assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="<?=$assets_url?>/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>

<link rel="stylesheet" href="<?=$assets_url?>/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" />

 
 
<div class="portlet box blue">
   <div class="portlet-title">
        <div class="caption"><i class="fa fa-globe"></i><b>Invoice Details</b>
        </div>
        <div class="tools">
            <a href="javascript:;" class="reload"></a>
            <a href="javascript:;" class="remove"></a>
        </div>
    </div>             
    <div class="portlet-body">
     <div class="table-responsive">	
        <table class="table">
           <tr>
           <td> 
             <div class="portlet-body">
              <div class="table-responsive">	
                  <table class="table">
                 <?php
                         unset($info);
						 unset($data);               
                        $info["table"] = "invoice";
                        $info["fields"] = array("invoice.*"); 
                        $info["where"]   = "1  AND id='".$_REQUEST['id']."'";
                        $arr =  $db->select($info);
                        
                 ?>
                    <tr>
                      <td>Customers</td><td>
                            <?php
                                unset($info2);        
                                $info2['table']    = "customers";	
                                $info2['fields']   = array("customer_name");	   	   
                                $info2['where']    =  "1 AND id='".$arr[0]['customers_id']."' LIMIT 0,1";
                                $res2  =  $db->select($info2);
                                echo $res2[0]['customer_name'];	
                            ?>
                       </td>
                     </tr>
                     <tr>  
                       <td>Item Service</td><td>
                           <?php
                              include("item_invoice.php");
                           ?>
                       </td>
                       </tr>
                       <tr>
                       <td>Date Of Service</td><td><?=$arr[0]['date_of_service']?></td>
                       </tr>
                       <tr>
                        <td>Tech Users</td><td>
                            <?php
                                unset($info2);        
                                $info2['table']    = users;	
                                $info2['fields']   = array("email");	   	   
                                $info2['where']    =  "1 AND id='".$arr[0]['tech_users_id']."' LIMIT 0,1";
                                $res2  =  $db->select($info2);
                                echo $res2[0]['email'];	
                            ?>
                       </td>
                      </tr>
                      <tr> 
                      <td>Description</td><td><?=$arr[0]['description']?></td>
                      </tr>
                      <tr>
                      <td>Internal Notes Tech</td><td><?=$arr[0]['internal_notes_tech']?></td>
                      </tr>
                      <tr>
                      <td>Total Cost</td><td><?=$arr[0]['total_cost']?></td>
                      </tr>
                      <tr>
                      <td>Amount Paid</td><td><?=$arr[0]['amount_paid']?></td>
                      </tr>
                      <tr>
                      <td>Pictures</td><td valign="top">
                            <table  cellspacing="3" cellpadding="3" class="table"> 
                               <tr><td>
                                <?php
                                    $info["table"] = "invoice_pictures";
                                    $info["fields"] = array("invoice_pictures.*"); 
                                    $info["where"]   = "1    AND invoice_id='".$arr[0]['id']."' ";
                                    $arrpictures =  $db->select($info);
                                    
                                    for($j=0;$j<count($arrpictures);$j++)
                                    {
                                        if(is_file('../../'.$arrpictures[$j]['file_picture'])
                                            && file_exists('../../'.$arrpictures[$j]['file_picture']))
                                            {
                                ?>
                                    <img src="../../<?=$arrpictures[$j]['file_picture']?>" style="width:100px;">
                                    <a href="index.php?cmd=delete_picture&id=<?=$arrpictures[$j]['id']?>" class="btn btn-sm red filter-cancel"  onClick=" return confirm('Are you sure to delete this item ?');"><i class="fa fa-times"></i>Delete</a>
                                    <br>
                                <?php
                                            }
                                      }
                                ?>
                                   </td>
                                <tr>				
                             </table>	
                      </td>
                     
                    </tr>
              
                </table>
                </div>
             </div>				
        </td>
        </tr>
        </table>
        </div>
    </div>
</div>
