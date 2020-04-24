<?php
 include("../template/header.php");
?>
<script language="javascript" src="item_invoice.js"></script>
<script type="text/javascript" src="../../js/jquery.js"></script>
<link rel="stylesheet" href="../../datepicker/jquery-ui.css">
<script src="../../datepicker/jquery-1.10.2.js"></script>
<script src="../../datepicker/jquery-ui.js"></script>


<a href="index.php?cmd=list" class="btn green"><i class="fa fa-arrow-circle-left"></i> List</a> <br><br>
  <div class="portlet box blue">
      <div class="portlet-title">
          <div class="caption"><i class="fa fa-globe"></i><b><?=ucwords(str_replace("_"," ","item_invoice"))?></b>
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

								 <form name="frm_item_invoice" method="post"  enctype="multipart/form-data" onSubmit="return checkRequired();">			
								  <div class="portlet-body">
						         <div class="table-responsive">	
					                <table class="table">
										 <tr>
							 <td>Invoice</td>
							 <td><?php
	$info['table']    = "invoice";
	$info['fields']   = array("*");   	   
	$info['where']    =  "1=1 ORDER BY id DESC";
	$resinvoice  =  $db->select($info);
?>
<select  name="invoice_id" id="invoice_id"   class="form-control-static">
	<option value="">--Select--</option>
	<?php
	   foreach($resinvoice as $key=>$each)
	   { 
	?>
	  <option value="<?=$resinvoice[$key]['id']?>" <?php if($resinvoice[$key]['id']==$invoice_id){ echo "selected"; }?>><?=$resinvoice[$key]['date_of_service']?></option>
	<?php
	 }
	?> 
</select></td>
					  </tr><tr>
							 <td>Service</td>
							 <td><?php
	$info['table']    = "service";
	$info['fields']   = array("*");   	   
	$info['where']    =  "1=1 ORDER BY id DESC";
	$resservice  =  $db->select($info);
?>
<select  name="service_id" id="service_id"   class="form-control-static">
	<option value="">--Select--</option>
	<?php
	   foreach($resservice as $key=>$each)
	   { 
	?>
	  <option value="<?=$resservice[$key]['id']?>" <?php if($resservice[$key]['id']==$service_id){ echo "selected"; }?>><?=$resservice[$key]['service_name']?></option>
	<?php
	 }
	?> 
</select></td>
					  </tr><tr>
						 <td>Item Cost</td>
						 <td>
						    <input type="text" name="item_cost" id="item_cost"  value="<?=$item_cost?>" class="form-control-static">
						 </td>
				     </tr><tr>
						 <td>Make</td>
						 <td>
						    <input type="text" name="make" id="make"  value="<?=$make?>" class="form-control-static">
						 </td>
				     </tr><tr>
						 <td>Model</td>
						 <td>
						    <input type="text" name="model" id="model"  value="<?=$model?>" class="form-control-static">
						 </td>
				     </tr><tr>
						 <td>Color</td>
						 <td>
						    <input type="text" name="color" id="color"  value="<?=$color?>" class="form-control-static">
						 </td>
				     </tr><tr>
						 <td>Year</td>
						 <td>
						    <input type="text" name="year" id="year"  value="<?=$year?>" class="form-control-static">
						 </td>
				     </tr><tr>
						 <td>Vin</td>
						 <td>
						    <input type="text" name="vin" id="vin"  value="<?=$vin?>" class="form-control-static">
						 </td>
				     </tr><tr>
						 <td>Tag</td>
						 <td>
						    <input type="text" name="tag" id="tag"  value="<?=$tag?>" class="form-control-static">
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

