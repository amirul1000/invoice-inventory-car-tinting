<?php
 include("../template/header.php");
?>
 <div class="portlet box blue">
           <div class="portlet-title">
                <div class="caption"><i class="fa fa-globe"></i><b><?=ucwords(str_replace("_"," ","Profile"))?></b>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="reload"></a>
                    <a href="javascript:;" class="remove"></a>
                </div>
            </div>             
            
						<div class="portlet-body">
				      <div class="table-responsive">	
				          <table class="table">
						 <?php
								
								if($_SESSION["search"]=="yes")
								  {
									$whrstr = " AND ".$_SESSION['field_name']." LIKE '%".$_SESSION["field_value"]."%'";
								  }
								  else
								  {
									$whrstr = "";
								  }
								  
								  $whrstr .= "AND id='".$_SESSION['users_id']."'";
						 
								$rowsPerPage = 10;
								$pageNum = 1;
								if(isset($_REQUEST['page']))
								{
									$pageNum = $_REQUEST['page'];
								}
								$offset = ($pageNum - 1) * $rowsPerPage;  
						 
						 
											  
								$info["table"] = "users";
								$info["fields"] = array("users.*"); 
								$info["where"]   = "1   $whrstr ORDER BY id DESC  LIMIT $offset, $rowsPerPage";
									
								$arr =  $db->select($info);
								
								
						 ?>
							  <tr><td>Email</td><td><?=$arr[0]['email']?></td></tr>
                              <tr><td>Title</td><td><?=$arr[0]['title']?></td></tr>
                              <tr><td>First Name</td><td><?=$arr[0]['first_name']?></td></tr>
                              <tr><td>Last Name</td><td><?=$arr[0]['last_name']?></td></tr>
                              <!--<tr><td>File Picture</td><td>
                                 <?php
								    if(is_file('../../'.$arr[0]['file_picture'])&&file_exists('../../'.$arr[0]['file_picture']))
									{
								 ?>
                                  <img src="../../<?=$arr[0]['file_picture']?>" style="width:100px;height:100px;">
                                  <?php
									}
								  ?>	
                              </td></tr>
                              <tr><td>Address</td><td><?=$arr[0]['address']?></td></tr>
                              <tr><td>City</td><td><?=$arr[0]['city']?></td></tr>
                              <tr><td>State</td><td><?=$arr[0]['state']?></td></tr>
                              <tr><td>Zip</td><td><?=$arr[0]['zip']?></td></tr>
                              <tr><td>Created At</td><td><?=$arr[0]['created_at']?></td></tr>
                              <tr><td>Updated At</td><td><?=$arr[0]['updated_at']?></td></tr>-->
                              <tr><td>User Type</td><td><?=$arr[0]['user_type']?></td></tr>
                              <tr><td>Status</td><td><?=$arr[0]['status']?></td></tr>
							  <tr><td>Action</td><td nowrap >
								  <a href="index.php?cmd=edit&id=<?=$arr[0]['id']?>"  class="btn default btn-xs purple"><i class="fa fa-edit"></i>Edit</a>
								  <!--<a href="index.php?cmd=delete&id=<?=$arr[0]['id']?>" class="btn btn-sm red filter-cancel"  onClick=" return confirm('Are you sure to delete this item ?');"><i class="fa fa-times"></i>Delete</a> -->
							 </td></tr>
						
						</table>
						</div>
					 </div>				
				
		</div>
<?php
include("../template/footer.php");
?>









