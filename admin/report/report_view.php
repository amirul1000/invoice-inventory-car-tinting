<?php
 include("../template/header.php");
?>
<script language="javascript" src="invoice.js"></script>
<script type="text/javascript" src="../../js/jquery.js"></script>
<link rel="stylesheet" href="../../datepicker/jquery-ui.css">
<script src="../../datepicker/jquery-1.10.2.js"></script>
<script src="../../datepicker/jquery-ui.js"></script>

<link rel="stylesheet" href="../../css/SpryValidationTextField.css">
<script src="../../js/SpryValidationTextField.js"></script> 



<link href="../../EasyAutocomplete-1.3.4/dist/easy-autocomplete.css" rel="stylesheet" type="text/css">
<!--<script src="../../EasyAutocomplete-1.3.4/lib/jquery-1.11.2.min.js"></script>-->
<script src="../../EasyAutocomplete-1.3.4/dist/jquery.easy-autocomplete.min.js" type="text/javascript" ></script>

<a href="index.php?cmd=list" class="btn green"><i class="fa fa-arrow-circle-left"></i> List</a> <br><br>
 <div class="container"> 
	   <div class="portlet-body">	         
              <form name="frm_invoice" method="post"  enctype="multipart/form-data" onSubmit="return checkRequired();">			
                    <div class="row" style="background: #d0aaaa;color: #FFF;">
                       <h3>Search</h3>
                    </div>   
                         <div class="row" style="border:1px solid;">
                                 <div class="row">
                                    <div class="col-sm-6 col-md-3">
                                     <label class="col-sm-12 col-md-6 control-label">Customer Name</label>
                                     </div>
                                    <div class="col-sm-6 col-md-3">
                                    <?php
                                    $info['table']    = "customers";
                                    $info['fields']   = array("*");   	   
                                    $info['where']    =  "1=1 ORDER BY customer_name ASC";
                                    $resusers  =  $db->select($info);
                                    ?>
                                    <input type="text" name="customer_name" id="customer_name"  value="<?=$_REQUEST['customer_name']?>">
                                   
                                       <script>
                                            $(document).ready(function() {
                                                $('#customer_name')
                                                            .selectize({
                                                                    plugins: ['remove_button'],
                                                                    persist: true,
                                                                    create: true,
                                                                    closeAfterSelect: true,
                                                                    maxItems: null,
                                                                    hideSelected: true,
                                                                    openOnFocus: true,
                                                                    closeAfterSelect: true,
                                                                    maxOptions: 100,
                                                                    selectOnTab: true,
                                                                    valueField: 'id',
                                                                    placeholder: 'Customer Name ...',
                                                                    labelField: 'title',
                                                                    searchField: 'title',
                                                                    onInitialize: function() {
                                                                        this.trigger('change', this.getValue(), true);
                                                                    },
                                                                    onChange: function(value, isOnInitialize) {
                                                                           
                                                                            if(value=="")
                                                                            {
                                                                                return;
                                                                            }
                                                                            
                                                                        $.ajax({  
                                                                          url: 'index.php?cmd=customer_detail&id='+value,
                                                                          success: function(data) {
                                                                                  var obj = eval(data);  
                                                                                  if(obj.length>0)
                                                                                  {
																					  
                                                                                  }
                                                                              }
                                                                            });
                                                                    },	
                                                                    options: [
                                                                               
                                                                                                                                          
                                                                            ],
                                                                            create: true
                                                                        }); 
                                                                        
                                                                        
                                                                        
                                                function load_customer_name()
                                                    {
                                                            var xhr; 
                                                        
                                                            searchbar = $('#customer_name');  
                                                            var $select = searchbar.selectize();
                                                            var control = $select[0].selectize;
                                                            //control.clear(); 
                                                            //control.clearOptions(); 
                                                           
                            
                                                            //$("#spinner3").html('<img src="../../images/indicator.gif" alt="Wait" />');               
                                                           
                                                            xhr && xhr.abort();
                                                                xhr = $.ajax({
                                                                    url: 'index.php?cmd=customer_name',
                                                                    success: function(results) {
                                                                           var data_source = eval(results);                                    
                                                                            for ( var i = 0 ; i < data_source.length ; i++ ) 
                                                                            {   
                                                                                control.addOption({
                                                                                                id: data_source[i].id,
                                                                                                title: data_source[i].customer_name,
                                                                                                url: ''
                                                                                            });
                                                                            }
                                                                           
                                                                           // $("#spinner3").html('');
                            
                                                                    },
                                                                    error: function() {
                                                                         callback();
                                                                    }
                                                                })
                                                    }
                            
                                               load_customer_name(); 
                                               
                                            });
                                         </script>   
                                </div>   
                                    <div class="col-sm-12 col-md-3">
                                    <label class="col-sm-12 col-md-6 control-label">Service</label>
                                 </div>
                                    <div class="col-sm-12 col-md-3">
                                 <?php
                                    $info['table']    = "service";
                                    $info['fields']   = array("*");   	   
                                    $info['where']    =  "1=1 ORDER BY id DESC";
                                    $resservice  =  $db->select($info);
                                ?>
                                <select  name="service" id="service_id" class="form-control-static">
                                    <option value="">--Select--</option>
                                    <?php
                                       foreach($resservice as $key=>$each)
                                       { 
                                    ?>
                                      <option value="<?=$resservice[$key]['id']?>" <?php if($resservice[$key]['id']==$_REQUEST['service']){ echo "selected"; }?>><?=$resservice[$key]['service_name']?></option>
                                    <?php
                                     }
                                    ?> 
                                </select>
                                </div>   
                                 </div>
                                 <div class="row">                             
                                     <div class="col-sm-12 col-md-3">
                                       <label class="col-sm-12 col-md-6 control-label">Tech Users</label>
                                    </div>       
                                     <div class="col-sm-6 col-md-3">
                                        <?php
                                        $info['table']    = "users";
                                        $info['fields']   = array("*");   	   
                                        $info['where']    =  "1=1 ORDER BY first_name ASC";
                                        $resusers  =  $db->select($info);
                                        ?>
                                        <input type="text" name="tech_users_id" id="tech_users_id"  value="<?=$_REQUEST['tech_users_id']?>">
                                       
                                           <script>
                                                $(document).ready(function() {
                                                    $('#tech_users_id')
                                                                .selectize({
                                                                        plugins: ['remove_button'],
                                                                        persist: false,
                                                                        create: true,
                                                                        closeAfterSelect: true,
                                                                        maxItems: null,
                                                                        hideSelected: true,
                                                                        openOnFocus: true,
                                                                        closeAfterSelect: true,
                                                                        maxOptions: 100,
                                                                        selectOnTab: true,
                                                                        valueField: 'id',
                                                                        placeholder: 'tech users ...',
                                                                        labelField: 'title',
                                                                        searchField: 'title',
                                                                        options: [
                                                                                    <?php
                                                                                    for($i=0;$i<count($resusers);$i++)
                                                                                     {
                                                                                    ?>
                                                                                     {id: '<?=$resusers[$i]['id']?>', title: '<?=$resusers[$i]['first_name']?> <?=$resusers[$i]['first_name']?>', url: ''},
                                                                                    <?php
                                                                                     }
                                                                                    ?> 
                                                                                                                                              
                                                                                ],
                                                                                create: true
                                                                            });             
                                                
                                                
                                                });
                                             </script>   
                                    </div>
                                     
                                 </div>
                                 <div class="row">                             
                                    <div class="col-sm-12 col-md-3">
                                        <label class="col-sm-12 col-md-6 control-label">From Date Of Service</label>
                                    </div>
                                     <div class="col-sm-12 col-md-3">
                                       <input type="text" name="from_date_of_service" id="from_date_of_service"  value="<?=$_REQUEST['from_date_of_service']?>" class="datepicker form-control-static">
                                    </div>
                                    
                                     <div class="col-sm-12 col-md-3">
                                        <label class="col-sm-12 col-md-6 control-label">To Date Of Service</label>
                                    </div>
                                     <div class="col-sm-12 col-md-3">
                                       <input type="text" name="to_date_of_service" id="to_date_of_service"  value="<?=$_REQUEST['to_date_of_service']?>" class="datepicker form-control-static">
                                    </div>
                                 </div>
                          </div> 
                
                         <div class="row"> 
                            <div class="col-sm-6 col-md-6">
                            <input type="hidden" name="cmd" value="search">
                            <input type="submit" name="btn_submit" id="btn_submit" value="submit" class="btn green"> 
                            <input type="submit" name="btn_submit" id="btn_submit" value="Pdf" class="btn green">                                       
                        </div>  
              </div>  
          
           </form>
		</div>
  </div>
  
    <?php
	  if($_POST)
	  {
	   
  		echo $html;
   
	  }
	?>  
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
	

	
	/*function autoFill(cmd,id)
	{
		 var options = {
				url: function(phrase) {
					return "index.php?cmd="+cmd;
				},
	
				getValue: "name",
			};
		$("#"+id).easyAutocomplete(options);
	}*/
//});	
</script>  	
 <script>
	/*$( ".datepicker" ).datepicker({
		dateFormat: "yy-mm-dd", 
		changeYear: true,
		changeMonth: true,
		showOn: 'button',
		buttonText: 'Show Date',
		buttonImageOnly: true,
		buttonImage: '../../images/calendar.gif',
	});*/
	$('body').on('keydown', 'input, select, textarea', function(e) {
    var self = $(this)
      , form = self.parents('form:eq(0)')
      , focusable
      , next
      ;
    if (e.keyCode == 13) {
        focusable = form.find('input,a,select,button,textarea').filter(':visible');
        next = focusable.eq(focusable.index(this)+1);
        if (next.length) {
            next.focus();
        } else {
            form.submit();
        }
        return false;
    }
});
</script> 
 					
<?php
 include("../template/footer.php");
?>
<style>

table {
    max-width: 100%;
    background-color: #fff;
   border-bottom-left-radius: 14px;
    border-bottom-right-radius: 14px;
}
</style>


<script type="text/javascript" src="../../js/selectize.js"></script>
<link rel='stylesheet' href='../../css/selectize.css'>
<link rel='stylesheet' href='../../css/selectize.default.css'>
<style type="text/css">
    .selectize-input {
      width: 100% !important;
      height: 62px !important;
    }
</style>