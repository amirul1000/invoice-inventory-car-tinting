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

<link rel="stylesheet" href="../../css/toastr.css">
<script src="../../js/toastr.js"></script>


<link href="../../EasyAutocomplete-1.3.4/dist/easy-autocomplete.css" rel="stylesheet" type="text/css">
<!--<script src="../../EasyAutocomplete-1.3.4/lib/jquery-1.11.2.min.js"></script>-->
<script src="../../EasyAutocomplete-1.3.4/dist/jquery.easy-autocomplete.min.js" type="text/javascript" ></script>

<a href="index.php?cmd=list" class="btn green"><i class="fa fa-arrow-circle-left"></i> List</a> <br><br>
  <div class="container"> <!--portlet box blue">-->
      <div class="row">
         <div class="panel-heading">
            <h3 style="color: #fff;
    background-color: #000;
    border-color: #ddd;
    text-align: center;
    width: 139px;
    float: right;
    padding: 9px 10px;
    border-top-left-radius: 15px;
    border-top-right-radius: 12px;"><strong>Invoice</strong></h3>
        </div>
      </div>
	   <div class="portlet-body">	         
              <form name="frm_invoice" method="post"  enctype="multipart/form-data" onSubmit="return checkRequired();">			
                    <div class="row" style="background: #d0aaaa;color: #FFF;">
                       <h3>CUSTOMER</h3>
                    </div>   
                         <div class="row" style="border:1px solid;">
                                 <div class="row">
                                     <div class="col-sm-6 col-md-3">
                                   <label class="col-sm-12 col-md-3 control-label">Customer Name</label>
                                  </div>
                                     <div class="col-sm-6 col-md-3">
                                    <?php
                                    $info['table']    = "customers";
                                    $info['fields']   = array("*");   	   
                                    $info['where']    =  "1=1 ORDER BY customer_name ASC";
                                    $resusers  =  $db->select($info);
                                    ?>
                                    <input type="text" name="customer_name" id="customer_name"  value="<?=$customer_name?>">
                                   
                                       <script>
                                            $(document).ready(function() {
                                                $('#customer_name')
                                                            .selectize({
                                                                    plugins: ['remove_button'],
                                                                    persist: true,
                                                                    create: true,
                                                                    closeAfterSelect: true,
                                                                    maxItems: 1,
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
                                                                                $("#customer_name_2").val(value);
                                                                                $("#address").val('');
                                                                                $("#city").val('');
																				$("#state").val('');
																				$("#zip").val('');
                                                                                $("#contact").val('');
																				$("#phone_no").val('');
																				$("#email").val('');
                                                                                $("#customers_id").val('');
                                                                    
                                                                                return;
                                                                            }
                                                                            else
                                                                            {
                                                                              $("#customer_name_2").val(value); 
																			  $("#address").focus();	
                                                                            }
                                                                            
                                                                        $.ajax({  
                                                                          url: 'index.php?cmd=customer_detail&id='+value,
                                                                          success: function(data) {
                                                                                  var obj = eval(data);  
                                                                                  if(obj.length>0)
                                                                                  {
                                                                                      $("#customer_name_2").val(obj[0].customer_name);
                                                                                      $("#address").val(obj[0].address);
                                                                                      $("#city").val(obj[0].city);
																					  $("#state").val(obj[0].state);
																					  $("#zip").val(obj[0].zip);
                                                                                      $("#contact").val(obj[0].contact);
																					  $("#phone_no").val(obj[0].phone_no);
																					  $("#email").val(obj[0].email);
                                                                                      $("#customers_id").val(obj[0].id);
                                                                                      
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
                                 
                                     <div class="col-sm-6 col-md-3">
                                        <label class="col-sm-12 col-md-3 control-label">Address</label>
                                     </div>
                                     <div class="col-sm-6 col-md-3">  
                                        <input type="text" name="address" id="address"  value="<?=$address?>" class="form-control-static">
                                        <script>
                                          var options = {
                                                    url: function(phrase) {
                                                        return "index.php?cmd=address";
                                                    },
                                        
                                                    getValue: "name",
                                                };
                                            $("#address").easyAutocomplete(options);
                                       </script>
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-sm-6 col-md-3">
                                        <label class="col-sm-12 col-md-3 control-label">City</label>
                                      </div>
                                      <div class="col-sm-6 col-md-3">  
                                        <input type="text" name="city" id="city"  value="<?=$city?>" class="form-control-static">
                                        <script>
                                          var options = {
                                                    url: function(phrase) {
                                                        return "index.php?cmd=city";
                                                    },
                                        
                                                    getValue: "name",
                                                };
                                            $("#city").easyAutocomplete(options);
                                       </script>
                                     </div>
                                     <div class="col-sm-6 col-md-3">
                                    <label class="col-sm-12 col-md-3 control-label">State</label>
                                  </div>
                                     <div class="col-sm-6 col-md-3">  
                                    <input type="text" name="state" id="state"  value="<?=$state?>" class="form-control-static">
                                    <script>
									  var options = {
												url: function(phrase) {
													return "index.php?cmd=state";
												},
									
												getValue: "name",
											};
										$("#state").easyAutocomplete(options);
                                   </script>
                                 </div>
                             </div> 
                             <div class="row">
                                   <div class="col-sm-6 col-md-3">
                                    <label class="col-sm-12 col-md-3 control-label">Zip</label>
                                  </div>
                                   <div class="col-sm-6 col-md-3">  
                                    <input type="text" name="zip" id="zip"  value="<?=$zip?>" class="form-control-static">
                                    <script>
									  var options = {
												url: function(phrase) {
													return "index.php?cmd=zip";
												},
									
												getValue: "name",
											};
										$("#zip").easyAutocomplete(options);
                                   </script>
                                 </div>                              
                                   <div class="col-sm-6 col-md-3">
                                    <label class="col-sm-12 col-md-3 control-label">Contact Name</label>
                                 </div>   
                                   <div class="col-sm-6 col-md-3">
                                    <input type="text" name="contact" id="contact"  value="<?=$contact?>" class="form-control-static">
                                    <script>
									  var options = {
												url: function(phrase) {
													return "index.php?cmd=contact";
												},
									
												getValue: "name",
											};
										$("#contact").easyAutocomplete(options);
                                   </script>
                                 </div>
                             </div>
                             <div class="row">
                                   <div class="col-sm-6 col-md-3">
                                    <label class="col-sm-12 col-md-3 control-label">Phone no</label>
                                  </div>
                                   <div class="col-sm-6 col-md-3">  
                                    <input type="text" name="phone_no" id="phone_no"  value="<?=$phone_no?>" class="form-control-static">
                                    <script>
									  var options = {
												url: function(phrase) {
													return "index.php?cmd=phone_no";
												},
									
												getValue: "name",
											};
										$("#phone_no").easyAutocomplete(options);
                                   </script>
                                 </div>                              
                                  
                                 <div class="col-sm-6 col-md-3">
                                    <label class="col-sm-12 col-md-3 control-label">Email</label>
                                  </div>
                                   <div class="col-sm-6 col-md-3">  
                                    <input type="text" name="email" id="email"  value="<?=$email?>" class="form-control-static">
                                    <script>
									  var options = {
												url: function(phrase) {
													return "index.php?cmd=email";
												},
									
												getValue: "name",
											};
										$("#email").easyAutocomplete(options);
                                   </script>
                                 </div>                   
                                 
                                </div>
                          </div>  
                    
                       
                   <br>
                  <div class="row" style="background: #d0aaaa;color: #FFF;">
                       <h3>ITEMS</h3>
                  </div>    
                    <div id="item">
                      <div class="row" style="border:1px solid;">
                             <div class="col-sm-12 col-md-6">
                                <label class="col-sm-12 col-md-3 control-label">Service</label>
                             </div>
                             <div class="col-sm-12 col-md-6">
                             <?php
                                $info['table']    = "service";
                                $info['fields']   = array("*");   	   
                                $info['where']    =  "1=1 ORDER BY id DESC";
                                $resservice  =  $db->select($info);
                            ?>
                            <select  name="service_id[]" id="service_id_0" onChange="setCost(this.value,this.id);"   class="form-control-static">
                                <option value="">--Select--</option>
                                <?php
                                   foreach($resservice as $key=>$each)
                                   { 
                                ?>
                                  <option value="<?=$resservice[$key]['id']?>" <?php if($resservice[$key]['id']==$arr_item_invoice[0]['service_id']){ echo "selected"; }?>><?=$resservice[$key]['service_name']?></option>
                                <?php
                                 }
                                ?> 
                            </select>
                            </div>
                          
                             <div class="col-sm-12 col-md-6">
                                <label class="col-sm-12 col-md-3 control-label">Item Cost</label>
                              </div>
                             <div class="col-sm-12 col-md-6"> 
                                <input type="text" name="item_cost[]" id="item_cost_0"  value="<?=$arr_item_invoice[0]['item_cost']?>" onBlur="update_cost();" class="form-control-static">
                             </div>
                          
                             <div class="col-sm-12 col-md-6">
                                <label class="col-sm-12 col-md-3 control-label">Make</label>
                               </div>
                             <div class="col-sm-12 col-md-6">
                                <input type="text" name="make[]" id="make_0"  value="<?=$arr_item_invoice[0]['make']?>" class="form-control-static">
							    <script>
                                  var options = {
											url: function(phrase) {
												return "index.php?cmd=make";
											},
								
											getValue: "name",
										};
                                    $("#make_0").easyAutocomplete(options);
                                </script>
                             </div>
                            <div class="col-sm-12 col-md-6">
                             <label class="col-sm-12 col-md-3 control-label">Model</label>
                               </div>
                             <div class="col-sm-12 col-md-6">
                                <input type="text" name="model[]" id="model_0"  value="<?=$arr_item_invoice[0]['model']?>" class="form-control-static">
                                <script>
                                    var options = {
											url: function(phrase) {
												return "index.php?cmd=model";
											},
								
											getValue: "name",
										};
                                    $("#model_0").easyAutocomplete(options);
                                </script>
                             </div>
                            
                            <div class="col-sm-12 col-md-6">
                                <label class="col-sm-12 col-md-3 control-label">Color</label>
                               </div>
                             <div class="col-sm-12 col-md-6">
                                <input type="text" name="color[]" id="color_0"  value="<?=$arr_item_invoice[0]['color']?>" class="form-control-static">
                                <script>
                                    var options = {
											url: function(phrase) {
												return "index.php?cmd=color";
											},
								
											getValue: "name",
										};
                                    $("#color_0").easyAutocomplete(options);
                                </script>
                             </div>
                             <div class="col-sm-12 col-md-6">
                                <label class="col-sm-12 col-md-3 control-label">Year</label>
                              </div>
                             <div class="col-sm-12 col-md-6">
                                <input type="text" name="year[]" id="year_0"  value="<?=$arr_item_invoice[0]['year']?>" class="form-control-static">
                                <script>
                                    var options = {
											url: function(phrase) {
												return "index.php?cmd=year";
											},
								
											getValue: "name",
										};
                                    $("#year_0").easyAutocomplete(options);
                                </script>
                             </div>
                             
                             <div class="col-sm-12 col-md-6">
                                <label class="col-sm-12 col-md-3 control-label">Vin</label>
                               </div>
                             <div class="col-sm-12 col-md-6">
                                <input type="text" name="vin[]" id="vin_0"  value="<?=$arr_item_invoice[0]['vin']?>" class="form-control-static">
                                <script>
                                    var options = {
											url: function(phrase) {
												return "index.php?cmd=vin";
											},
								
											getValue: "name",
										};
                                    $("#vin_0").easyAutocomplete(options);
                                </script>
                             </div>
                             <div class="col-sm-12 col-md-6">
                                <label class="col-sm-12 col-md-3 control-label">Tag</label>
                               </div>
                             <div class="col-sm-12 col-md-6">
                                <input type="text" name="tag[]" id="tag_0"  value="<?=$arr_item_invoice[0]['tag']?>" class="form-control-static">
                                <script>
                                    var options = {
											url: function(phrase) {
												return "index.php?cmd=tag";
											},
								
											getValue: "name",
										};
                                    $("#tag_0").easyAutocomplete(options);
                                </script>
                             </div>
                  </div> 
                    </div> 
                <div id="item_more">
                
                         <?php
						    for($i=1;$i<count($arr_item_invoice);$i++)
							{
						 ?>
                              <div class="row" style="border:1px solid;">
                                 <div class="col-sm-12 col-md-6">
                                    <label class="col-sm-12 col-md-3 control-label">Service</label>
                                 </div>
                                 <div class="col-sm-12 col-md-6">
                                 <?php
                                    $info['table']    = "service";
                                    $info['fields']   = array("*");   	   
                                    $info['where']    =  "1=1 ORDER BY id DESC";
                                    $resservice  =  $db->select($info);
                                ?>
                                <select  name="service_id[]" id="service_id_<?=$i?>" onChange="setCost(this.value,this.id);"   class="form-control-static">
                                    <option value="">--Select--</option>
                                    <?php
                                       foreach($resservice as $key=>$each)
                                       { 
                                    ?>
                                      <option value="<?=$resservice[$key]['id']?>" <?php if($resservice[$key]['id']==$arr_item_invoice[$i]['service_id']){ echo "selected"; }?>><?=$resservice[$key]['service_name']?></option>
                                    <?php
                                     }
                                    ?> 
                                </select>
                                </div>
                              
                                 <div class="col-sm-12 col-md-6">
                                    <label class="col-sm-12 col-md-3 control-label">Item Cost</label>
                                  </div>
                                 <div class="col-sm-12 col-md-6"> 
                                    <input type="text" name="item_cost[]" id="item_cost_<?=$i?>"  value="<?=$arr_item_invoice[$i]['item_cost']?>" onBlur="update_cost();" class="form-control-static">
                                 </div>
                              
                                 <div class="col-sm-12 col-md-6">
                                    <label class="col-sm-12 col-md-3 control-label">Make</label>
                                   </div>
                                 <div class="col-sm-12 col-md-6">
                                    <input type="text" name="make[]" id="make_<?=$i?>"  value="<?=$arr_item_invoice[$i]['make']?>" class="form-control-static">
                                     <script>
									  var options = {
												url: function(phrase) {
													return "index.php?cmd=make";
												},
									
												getValue: "name",
											};
										$("#make_<?=$i?>").easyAutocomplete(options);
									</script>
                                 </div>
                                <div class="col-sm-12 col-md-6">
                                 <label class="col-sm-12 col-md-3 control-label">Model</label>
                                   </div>
                                 <div class="col-sm-12 col-md-6">
                                    <input type="text" name="model[]" id="model_<?=$i?>"  value="<?=$arr_item_invoice[$i]['model']?>" class="form-control-static">
                                    <script>
									  var options = {
												url: function(phrase) {
													return "index.php?cmd=model";
												},
									
												getValue: "name",
											};
										$("#model_<?=$i?>").easyAutocomplete(options);
									</script>
                                 </div>
                                
                                <div class="col-sm-12 col-md-6">
                                    <label class="col-sm-12 col-md-3 control-label">Color</label>
                                   </div>
                                 <div class="col-sm-12 col-md-6">
                                    <input type="text" name="color[]" id="color_<?=$i?>"  value="<?=$arr_item_invoice[$i]['color']?>" class="form-control-static">
                                    <script>
									  var options = {
												url: function(phrase) {
													return "index.php?cmd=color";
												},
									
												getValue: "name",
											};
										$("#color_<?=$i?>").easyAutocomplete(options);
									</script>
                                 </div>
                                 <div class="col-sm-12 col-md-6">
                                    <label class="col-sm-12 col-md-3 control-label">Year</label>
                                  </div>
                                 <div class="col-sm-12 col-md-6">
                                    <input type="text" name="year[]" id="year_<?=$i?>"  value="<?=$arr_item_invoice[$i]['year']?>" class="form-control-static">
                                    <script>
									  var options = {
												url: function(phrase) {
													return "index.php?cmd=year";
												},
									
												getValue: "name",
											};
										$("#year_<?=$i?>").easyAutocomplete(options);
									</script>
                                 </div>
                                 
                                 <div class="col-sm-12 col-md-6">
                                    <label class="col-sm-12 col-md-3 control-label">Vin</label>
                                   </div>
                                 <div class="col-sm-12 col-md-6">
                                    <input type="text" name="vin[]" id="vin_<?=$i?>"  value="<?=$arr_item_invoice[$i]['vin']?>" class="form-control-static">
                                    <script>
									  var options = {
												url: function(phrase) {
													return "index.php?cmd=vin";
												},
									
												getValue: "name",
											};
										$("#vin_<?=$i?>").easyAutocomplete(options);
									</script>
                                 </div>
                                 <div class="col-sm-12 col-md-6">
                                    <label class="col-sm-12 col-md-3 control-label">Tag</label>
                                   </div>
                                 <div class="col-sm-12 col-md-6">
                                    <input type="text" name="tag[]" id="tag_<?=$i?>"  value="<?=$arr_item_invoice[$i]['tag']?>" class="form-control-static">
                                    <script>
									  var options = {
												url: function(phrase) {
													return "index.php?cmd=tag";
												},
									
												getValue: "name",
											};
										$("#tag_<?=$i?>").easyAutocomplete(options);
									</script>
                                 </div>
                      </div>
                         <?php
							}
						 ?>	
                
                </div>    
               <button name="btn_submit" id="btn_submit" onClick="addMore(event);" class="btn red">Add More</button>                 
                 <br><br>
                  <div class="row" style="background: #d0aaaa;color: #FFF;">
                       <h3>GENERAL INFO</h3>
                  </div>      
                  <div class="panel"> 
                      <div class="row" style="border:1px solid;"> 
                        <div class="row"> 
                            <div class="col-sm-12 col-md-6">
                                <label class="col-sm-12 col-md-6 control-label">Date Of Service</label>
                            </div>
                            <div class="col-sm-12 col-md-6">
                               <input type="text" name="date_of_service" id="date_of_service"  value="<?=$date_of_service?>" class="datepicker form-control-static">
                            </div>
                        </div>
                        <div class="row">      
                            <div class="col-sm-12 col-md-6">
                               <label class="col-sm-12 col-md-6 control-label">Tech Users</label>
                            </div>       
                            <div class="col-sm-6 col-md-6">
                                <?php
                                $info['table']    = "users";
                                $info['fields']   = array("*");   	   
                                $info['where']    =  "1=1 ORDER BY first_name ASC";
                                $resusers  =  $db->select($info);
                                ?>
                                <input type="text" name="tech_users_id" id="tech_users_id"  value="<?=$tech_users_id?>">
                               
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
                            <div class="col-sm-12 col-md-6">
                              <label class="col-sm-12 col-md-6 control-label">Description</label>
                            </div>
                            <div class="col-sm-6 col-md-6">
                              <textarea name="description" id="description"  class="form-control-static" style="width:200px;height:100px;"><?=$description?></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                               <label class="col-sm-12 col-md-6 control-label">Internal Notes Tech</label>
                            </div>          
                            <div class="col-sm-12 col-md-6">
                              <textarea name="internal_notes_tech" id="internal_notes_tech"  class="form-control-static" style="width:200px;height:100px;"><?=$internal_notes_tech?></textarea>
                            </div>
                        </div>                                            
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                               <label class="col-sm-12 col-md-3 control-label">Total Cost</label>
                            </div>          
                            <div class="col-sm-12 col-md-6">
                               <input type="text" name="total_cost" id="total_cost"  value="<?=$total_cost?>" class="form-control-static">
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                              <label class="col-sm-12 col-md-3 control-label">Amount Paid</label>
                            </div>          
                            <div class="col-sm-12 col-md-6">
                              <input type="text" name="amount_paid" id="amount_paid"  value="<?=$amount_paid?>" class="form-control-static">
                            </div> 
                        </div>
                        
                        </div>   
                   </div> 
                  <div class="row" style="background: #d0aaaa;color: #FFF;">
                       <h3>Upload Files</h3>
                  </div>    
                 <div class="panel"> 
                   <div class="row" style="border:1px solid;"> 
                     <div id="item_file">
                         <div class="row">
                             <input type="file" name="file_picture[]"   value="<?=$file_picture?>" style="margin-left:100px;" class="form-control-static">
                         </div>
                     </div>
                     <div id="item_more_file">
                     
                     </div>
                     <button name="btn_submit" id="btn_submit" onClick="addMoreFile(event);" class="btn red">Add More</button>
                   </div>
                 </div> 
                  <div class="panel">
                        <!-- CSS -->
						<style>
                        #my_camera{
                            width: 320px;
                            height: 240px;
                            border: 1px solid black;
                        }
                        </style>
                    
                        <!-- -->
                        <div id="my_camera"></div>
                        <input type=button value="Configure" onClick="configure()">
                        <input type=button value="Take Snapshot" onClick="take_snapshot()">
                        <input type=button value="Save Snapshot" onClick="saveSnap()">
                        
                        <div id="results"  ></div>
                        
                        <!-- Script -->
                        <script type="text/javascript" src="../../capture_picture/webcamjs/webcam.min.js"></script>
                    
                        <!-- Code to handle taking the snapshot and displaying it locally -->
                        <script language="JavaScript">
                            
                            // Configure a few settings and attach camera
                            function configure(){
                                Webcam.set({
                                    width: 320,
                                    height: 240,
                                    image_format: 'jpeg',
                                    jpeg_quality: 90
                                });
                                Webcam.attach( '#my_camera' );
                            }
                            // A button for taking snaps
                            
                    
                            // preload shutter audio clip
                            var shutter = new Audio();
                            shutter.autoplay = false;
                            shutter.src = navigator.userAgent.match(/Firefox/) ? '../../capture_picture/shutter.ogg' : '../../capture_picture/shutter.mp3';
                    
                            function take_snapshot() {
                                // play sound effect
                                shutter.play();
                    
                                // take snapshot and get image data
                                Webcam.snap( function(data_uri) {
                                    // display results in page
                                    document.getElementById('results').innerHTML = 
                                        '<img id="imageprev" src="'+data_uri+'"/>';
                                } );
                    
                                Webcam.reset();
                            }
                    
                            function saveSnap(){
                                // Get base64 value from <img id='imageprev'> source
                                var base64image =  document.getElementById("imageprev").src;
                    
                                 Webcam.upload( base64image, '../../capture_picture/upload.php', function(code, text) {
                                     console.log('Save successfully');
                                     //console.log(text);
									 toastr.options.timeOut = 3000;
									 toastr.success('Save successfully');
									
                                });
                    
                            }
                        </script>
                  </div>
                 <div class="row"> 
                    <div class="col-sm-6 col-md-6">
                    <input type="hidden" name="cmd" value="add">
                    <input type="hidden" name="customer_name_2" id="customer_name_2" value="<?=$customer_name_2?>">
                    <input type="hidden" name="customers_id" id="customers_id" value="<?=$customers_id?>">	
                    <input type="hidden" name="id" value="<?=$Id?>">			
                    <input type="submit" name="btn_submit" id="btn_submit" value="submit" class="btn green">                                        
                </div>  
              </div>  
          
           </form>
		</div>
  </div>
  <script>
    var current = 0;
    <?php
	if(count($arr_item_invoice))
	{
	?>
		var current = <?=count($arr_item_invoice)-1?>;
	<?php
	}
	?>
     
     function addMore(e)
	 {
		e.preventDefault();
		var item = $("#item").html();		
		current = parseInt(current) + 1;
		item = item.replace(/service_id_0/gi, "service_id_"+current);
		item = item.replace(/item_cost_0/gi, "item_cost_"+current);
		item = item.replace(/make_0/gi, "make_"+current);
		item = item.replace(/model_0/gi, "model_"+current);
		item = item.replace(/color_0/gi, "color_"+current);
		item = item.replace(/year_0/gi, "year_"+current);
		item = item.replace(/vin_0/gi, "vin_"+current);
		item = item.replace(/tag_0/gi, "tag_"+current);
		
		$("#item_more").append(item);
		
		 return false;
	 }
	 
	function addMoreFile(e)
	 {
		 e.preventDefault();
		 
		 var item_file = $("#item_file").html();	
		 $("#item_more_file").append(item_file);
		 
		 return false;
	 }
	 
	$( ".datepicker" ).datepicker({
		dateFormat: "yy-mm-dd", 
		changeYear: true,
		changeMonth: true,
		showOn: 'button',
		buttonText: 'Show Date',
		buttonImageOnly: true,
		buttonImage: '../../images/calendar.gif',
	});
	
//$(document).ready(function() {	
	function setCost(value,id)
	{
		index = id.replace("service_id_","");
		$.ajax({  
			  url: 'index.php?cmd=service_detail&id='+value+'&customers_id='+$("#customers_id").val(),
			  success: function(data) {
					  var obj = eval(data);  
					  if(obj.length>0)
					  {
						  $("#item_cost_"+index).val(obj[0].cost);
						  
						  $("#make_"+index).val(obj[0].make);
						  $("#model_"+index).val(obj[0].model);
						  $("#color_"+index).val(obj[0].color);
						  $("#year_"+index).val(obj[0].year);
						  $("#vin_"+index).val(obj[0].vin);
						  $("#tag_"+index).val(obj[0].tag);
						  
					  }
					  //////////update cost/////////////
					  update_cost();
				  }
				});
	}
	
	//////////update cost/////////////
	function update_cost()
	{
		total_cost = 0;	
	   for(i=0;i<=current;i++)
	   {
		   total_cost = parseFloat(total_cost) + parseFloat($("#item_cost_"+i).val());
	   }
				  
	  $("#total_cost").val(total_cost);
	  $("#amount_paid").val(total_cost);
	}
	
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
