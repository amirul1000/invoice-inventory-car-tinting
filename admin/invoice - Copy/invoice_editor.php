<?php
 include("../template/header.php");
?>
<script language="javascript" src="invoice.js"></script>
<script type="text/javascript" src="../../js/jquery.js"></script>
<link rel="stylesheet" href="../../datepicker/jquery-ui.css">
<script src="../../datepicker/jquery-1.10.2.js"></script>
<script src="../../datepicker/jquery-ui.js"></script>


<a href="index.php?cmd=list" class="btn green"><i class="fa fa-arrow-circle-left"></i> List</a> <br><br>
  <div class="portlet box blue">
      <div class="portlet-title">
          <div class="caption"><i class="fa fa-globe"></i><b><?=ucwords(str_replace("_"," ","invoice"))?></b>
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

								 <form name="frm_invoice" method="post"  enctype="multipart/form-data" onSubmit="return checkRequired();">			
								  <div class="portlet-body">
						         <div class="table-responsive">	
					                <table class="table">
										 <tr>
							 <td>Customers</td>
							 <td><?php
	$info['table']    = "customers";
	$info['fields']   = array("*");   	   
	$info['where']    =  "1=1 ORDER BY id DESC";
	$rescustomers  =  $db->select($info);
?>
<select  name="customers_id" id="customers_id"   class="form-control-static">
	<option value="">--Select--</option>
	<?php
	   foreach($rescustomers as $key=>$each)
	   { 
	?>
	  <option value="<?=$rescustomers[$key]['id']?>" <?php if($rescustomers[$key]['id']==$customers_id){ echo "selected"; }?>><?=$rescustomers[$key]['customer_name']?></option>
	<?php
	 }
	?> 
</select></td>
					  </tr><tr>
						 <td>Date Of Service</td>
						 <td>
						    <input type="text" name="date_of_service" id="date_of_service"  value="<?=$date_of_service?>" class="datepicker form-control-static">
						 </td>
				     </tr><tr>
							 <td>Tech Users</td>
							 <td><?php
	$info['table']    = "users";
	$info['fields']   = array("*");   	   
	$info['where']    =  "1=1 ORDER BY id DESC";
	$resusers  =  $db->select($info);
?>
<select  name="tech_users_id" id="tech_users_id"   class="form-control-static">
	<option value="">--Select--</option>
	<?php
	   foreach($resusers as $key=>$each)
	   { 
	?>
	  <option value="<?=$resusers[$key]['id']?>" <?php if($resusers[$key]['id']==$tech_users_id){ echo "selected"; }?>><?=$resusers[$key]['email']?></option>
	<?php
	 }
	?> 
</select></td>
					  </tr><tr>
						 <td valign="top">Description</td>
						 <td>
						    <textarea name="description" id="description"  class="form-control-static" style="width:200px;height:100px;"><?=$description?></textarea>
						 </td>
				     </tr><tr>
						 <td valign="top">Internal Notes Tech</td>
						 <td>
						    <textarea name="internal_notes_tech" id="internal_notes_tech"  class="form-control-static" style="width:200px;height:100px;"><?=$internal_notes_tech?></textarea>
						 </td>
				     </tr><tr>
						 <td>Total Cost</td>
						 <td>
						    <input type="text" name="total_cost" id="total_cost"  value="<?=$total_cost?>" class="form-control-static">
						 </td>
				     </tr><tr>
						 <td>Amount Paid</td>
						 <td>
						    <input type="text" name="amount_paid" id="amount_paid"  value="<?=$amount_paid?>" class="form-control-static">
						 </td>
				     </tr>
										 <tr> 
											 <td align="right"></td>
											 <td>
												<input type="hidden" name="cmd" value="add">
												<input type="hidden" name="id" value="<?=$Id?>">			
												<input type="submit" name="btn_submit" id="btn_submit" value="submit" class="btn red">
											 </td>     
										 </tr>
										</table>
										</div>
										</div>
								</form>
							  </td>
							 </tr>
							</table>
			      </div>
			</div>
  </div>
  <script>
	$( ".datepicker" ).datepicker({
		dateFormat: "yy-mm-dd", 
		changeYear: true,
		changeMonth: true,
		showOn: 'button',
		buttonText: 'Show Date',
		buttonImageOnly: true,
		buttonImage: '../../images/calendar.gif',
	});
</script>  			
<?php
 include("../template/footer.php");
?>

