<form  method="post" role="form" id="form" enctype="multipart/form-data" style="padding: 0px 10px">
   <?php if(isset($data->invoice_id)){
      $clientData = json_decode($data->clientInfo);
     ?><input type="hidden" id="editInvoiceId"  name="id" value="<?php echo isset($data->invoice_id) ?$data->invoice_id : "";?>">
   <?php } ?>
   <div class="box-body">
     <div class="form-group form-float">
       <div class="form-line">
       <input type="text" name="created_at" id="invoice_date" data-date-format="yyyy-mm-d" value="<?php if(isset($data->invoice_date)){ echo $data->invoice_date;} ?>" autocomplete="off">
       <label for="customer_option_select" class="form-label"><?php echo 'Invoice Date'; ?></label>
     </div>
     </div>
      <div class="form-group form-float">
        <div class="form-line focused">
        <select id='choose-currency' name="invoice_currency" class="form-control">
           <option value="">Select Currency</option>
           <?php
           if(!empty($currency)){
             foreach($currency as $key=>$value){
               $select = (isset($data->invoice_currency) && $data->invoice_currency == $key)?'selected':'';
               echo '<option value="'.$key.'" '.$select.'>'.$value.'</option>';
             }
           }
           ?>
        </select>
        <label for="customer_option_select" class="form-label"><?php echo 'Currency Option'; ?></label>
      </div>
      </div>
       <div class="form-group form-float">
         <div class="form-line">
            <select id='choose-customer' name="customer_option" class="form-control">
              <option value="0">Select Layout</option>
               <option value="1" <?php if(isset($data->invoice_id) && $data->customer_option==1){ echo 'selected'; } ?> >Make Custom</option>
               <option value="2" <?php if(isset($data->invoice_id) && $data->customer_option==2){ echo 'selected'; } ?>>Choose From the List</option>
            </select>
            <label for="customer_option_select" class="form-label"><?php echo 'Customer Option'; ?></label>
         </div>
      </div>
      <div class="form-group form-float customer-list-added " <?php if(isset($data->invoice_id) && $data->customer_option==2){ ?>  style="display: block;" <?php } ?>>
         <div class="form-line"><label class="form-label"><?php echo lang('client'); ?> </label>
            <?php echo selectBoxDynamic("client_id","client_management","name",isset($data->client_id) ?$data->client_id : "","status", "active","","name","asc");?>
         </div>
      </div>

      <div class="custom-entry-customer-main" style="text-align: -webkit-auto; <?php if(isset($data->invoice_id) && $data->customer_option==1){ echo 'display: block;'; } ?>">
          <div class="form-group">
            <label for="usr">Name:</label>
            <input type="text" value="<?php if(isset($clientData) && count($clientData) > 0){ echo $clientData->client_name;} ?>" class="form-control custom-client-field" id="client_name" required>
          </div>
          <div class="form-group">
            <label for="gst">GST Number:</label>
            <input type="text" value="<?php if(isset($clientData) && count($clientData) > 0){ echo $clientData->gst_num;} ?>" class="form-control custom-client-field" id="gst_num">
          </div>
          <div class="form-group">
            <label for="cmyName">Company Name:</label>
            <input type="text" value="<?php if(isset($clientData) && count($clientData) > 0){ echo $clientData->company_name;} ?>" class="form-control custom-client-field" id="company_name" required>
          </div>
          <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" value="<?php if(isset($clientData) && count($clientData) > 0){ echo $clientData->company_address;} ?>" class="form-control custom-client-field" id="company_address" required>
          </div>
      </div>
      <div class="input_fields_wrap">
         <!-- <div class="project_invoice_headrer col-md-12">
              <div class="type_of_invoice form-group form-float">
                 <select class="invoice_work_type">
                    <option value=0" class="project_rate_hourly">
                       Select Type of Payment
                    </option>
                    <option value="1" class="project_rate_hourly">
                       Hourly
                    </option>
                    <option value="2" class="project_rate_monthly">
                       Monthly
                    </option>
                    <option value="3" class="project_rate_atonce">
                       At Once
                    </option>
                 </select>
              </div>
              <div class="hourly-holder-main">
                <div>
                   <label class="hourly-holder-label">Price Per Hour: </label>
                  <input type="text" class="perHourRate">
               </div>
               <div>
                   <label class="hourly-holder-label">Hours: </label>
                   <input type='button' value='-' class='qtyminus' field='quantity' />
                   <input type='text' name='quantity' value='0' class='qty qty_per_hours' />
                   <input type='button' value='+' class='qtyplus' field='quantity' />
               </div>
            </div>
            <div class="total-price-calculated-hourly">
               <label class="total-price-calculated-hourly-label">Total Price Calculated on Hourly Rate: </label>
               <input type="text" class="totalPriceOfHours" readonly="readonly">
            </div>
         </div> -->
         <div class="col-md-12 form-group form-float">
           <a href="#" class="add_field_button">Add Work Item</a>
         </div>
      </div>
      <?php
      if(isset($data->invoice_id) && trim($data->datajsonhour)!=""){
        $hourlyData = json_decode($data->datajsonhour);
        foreach($hourlyData as $key=>$hourlyValue){
          ?>
          <div class='project_invoice_headrer col-md-12'>
            <div class='close-item'>x</div>
              <div class='type_of_invoice form-group form-float'>
                <select class='invoice_work_type'>
                  <option value='0' class='project_rate_hourly'>Select Type of Payment</option>
                  <option value='1' class='project_rate_hourly' selected>Hourly</option>
                  <option value='2' class='project_rate_monthly'>Monthly</option>
                  <option value='3' class='project_rate_atonce'>At Once</option>
                </select>
              </div>
              <div class='project_invoice_headrer_parent' style="display:block">
                <div class='task-description'>
                  <div class='task_descrip_label_div'>
                    <label class='task_descrip_label'>Task Description :</label>
                  </div>
                  <div class='task-desc-textarea-div'><textarea class='task-desc-textarea'><?php echo $hourlyValue->itemDiscription;?></textarea></div>
                </div>
                <div class='hourly-holder-main'>
                  <div><label class='hourly-holder-label'>Price Per Hour: </label><input type='text' value="<?php echo $hourlyValue->perHourRate;?>" class='perHourRate'></div>
                  <div>
                    <label class='hourly-holder-label'>Hours: </label>
                    <input type='button' value='-' class='qtyminus' field='quantity' />
                    <input type='text' name='quantity' id='dynamically_box<?php echo $key;?>' value="<?php echo $hourlyValue->qty_per_hours;?>" class='qty qty_per_hours' />
                    <input type='button' value='+' class='qtyplus' field='quantity' />
                  </div>
                  </div>
                  <div class='total-price-calculated-hourly'>
                    <label class='total-price-calculated-hourly-label'>Total Price Calculated on Hourly Rate: </label>
                    <input type='text' class='totalPriceOfHours' value="<?php echo $hourlyValue->totalPrice;?>" readonly='readonly'>
                  </div>
                </div>

              <div class="monthly-main-class">
                <div class="task-description">
                  <div class="task_descrip_label_div">
                    <label class="task_descrip_label">Task Description :</label>
                  </div>
                  <div class="task-desc-textarea-div">
                    <textarea class="task-desc-textarea"></textarea>
                  </div>
                </div>
                <div class="monthly-main-class-subhold">
                  <div class="monthly_charge_text_holder">
                    <label class="monthly_charge_text_holder_label">Monthly Charges :</label>
                    <input class="monthly_charge_text" type="text" name="monthly_charge">
                  </div>
                  <div class="numberOfMonthsHolder"><label class="numberOfMonthsHolderLabel">Number of Months :</label>
                    <select class="1-100">
                      <?php
                        for($i=1;$i<=100;$i++){
                          ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                          <?php
                        }
                       ?>
                    </select>
                  </div>
                </div>
                <div class="monthly_total_calc">
                    <label class="monthly_total_calc_label">Total Monthly Charges :</label>
                    <input class="monthly_charge_text_total" type="text" readonly="readonly" name="monthly_charge_total">
                  </div>
              </div>

              <div class="task-at-once">
                <div class="task-description">
                  <div class="task_descrip_label_div">
                    <label class="task_descrip_label">Task Description :</label>
                  </div>
                  <div class="task-desc-textarea-div">
                    <textarea class="task-desc-textarea"></textarea>
                  </div>
                </div>
                <div class="at_oncemain_label_containor">
                  <div class="at-once-main_label">
                    <label class="at-once-main_label_title">Enter Cost :</label>
                  </div>
                  <div class="at-once-main_div">
                    <input type="text" name="at-once" class="at-once">
                  </div>
                </div>
              </div>
          </div>
          <?php
        }
      }

      if(isset($data->invoice_id) && trim($data->datajsonmonth)!=""){
        $monthlyData = json_decode($data->datajsonmonth);
        foreach($monthlyData as $key=>$monthlyValue){
          ?>
          <div class='project_invoice_headrer col-md-12'>
            <div class='close-item'>x</div>
              <div class='type_of_invoice form-group form-float'>
                <select class='invoice_work_type'>
                  <option value='0' class='project_rate_hourly'>Select Type of Payment</option>
                  <option value='1' class='project_rate_hourly'>Hourly</option>
                  <option value='2' class='project_rate_monthly' selected>Monthly</option>
                  <option value='3' class='project_rate_atonce'>At Once</option>
                </select>
              </div>
              <div class='project_invoice_headrer_parent'>
                <div class='task-description'>
                  <div class='task_descrip_label_div'>
                    <label class='task_descrip_label'>Task Description :</label>
                  </div>
                  <div class='task-desc-textarea-div'><textarea class='task-desc-textarea'></textarea></div>
                </div>
                <div class='hourly-holder-main'>
                  <div><label class='hourly-holder-label'>Price Per Hour: </label><input type='text' value="" class='perHourRate'></div>
                  <div>
                    <label class='hourly-holder-label'>Hours: </label>
                    <input type='button' value='-' class='qtyminus' field='quantity' />
                    <input type='text' name='quantity' id='dynamically_box<?php echo $key;?>' value="" class='qty qty_per_hours' />
                    <input type='button' value='+' class='qtyplus' field='quantity' />
                  </div>
                  </div>
                  <div class='total-price-calculated-hourly'>
                    <label class='total-price-calculated-hourly-label'>Total Price Calculated on Hourly Rate: </label>
                    <input type='text' class='totalPriceOfHours' value="" readonly='readonly'>
                  </div>
                </div>

              <div class="monthly-main-class" style="display:block">
                <div class="task-description">
                  <div class="task_descrip_label_div">
                    <label class="task_descrip_label">Task Description :</label>
                  </div>
                  <div class="task-desc-textarea-div">
                    <textarea class="task-desc-textarea"><?php echo $monthlyValue->itemDiscription; ?></textarea>
                  </div>
                </div>
                <div class="monthly-main-class-subhold">
                  <div class="monthly_charge_text_holder">
                    <label class="monthly_charge_text_holder_label">Monthly Charges :</label>
                    <input class="monthly_charge_text" type="text" value="<?php echo $monthlyValue->monthly_charge_text;?>" name="monthly_charge">
                  </div>
                  <div class="numberOfMonthsHolder"><label class="numberOfMonthsHolderLabel">Number of Months :</label>
                    <select class="1-100">
                      <?php
                        for($i=1;$i<=100;$i++){
                          ?>
                            <option value="<?php echo $i; ?>" <?php if($monthlyValue->no_of_months == $i){ echo 'selected'; } ?>><?php echo $i; ?></option>
                          <?php
                        }
                       ?>
                    </select>
                  </div>
                </div>
                <div class="monthly_total_calc">
                    <label class="monthly_total_calc_label">Total Monthly Charges :</label>
                    <input class="monthly_charge_text_total" type="text" readonly="readonly" value="<?php echo $monthlyValue->monthly_charge_text_total;?>" name="monthly_charge_total">
                  </div>
              </div>

              <div class="task-at-once">
                <div class="task-description">
                  <div class="task_descrip_label_div">
                    <label class="task_descrip_label">Task Description :</label>
                  </div>
                  <div class="task-desc-textarea-div">
                    <textarea class="task-desc-textarea"></textarea>
                  </div>
                </div>
                <div class="at_oncemain_label_containor">
                  <div class="at-once-main_label">
                    <label class="at-once-main_label_title">Enter Cost :</label>
                  </div>
                  <div class="at-once-main_div">
                    <input type="text" name="at-once" class="at-once">
                  </div>
                </div>
              </div>
          </div>
          <?php
        }
      }


      if(isset($data->invoice_id) && trim($data->datajsonatonce)!=""){
        $atonceData = json_decode($data->datajsonatonce);
        foreach($atonceData as $key=>$atonceValue){
          ?>
          <div class='project_invoice_headrer col-md-12'>
            <div class='close-item'>x</div>
              <div class='type_of_invoice form-group form-float'>
                <select class='invoice_work_type'>
                  <option value='0' class='project_rate_hourly'>Select Type of Payment</option>
                  <option value='1' class='project_rate_hourly'>Hourly</option>
                  <option value='2' class='project_rate_monthly'>Monthly</option>
                  <option value='3' class='project_rate_atonce' selected>At Once</option>
                </select>
              </div>
              <div class='project_invoice_headrer_parent'>
                <div class='task-description'>
                  <div class='task_descrip_label_div'>
                    <label class='task_descrip_label'>Task Description :</label>
                  </div>
                  <div class='task-desc-textarea-div'><textarea class='task-desc-textarea'></textarea></div>
                </div>
                <div class='hourly-holder-main'>
                  <div><label class='hourly-holder-label'>Price Per Hour: </label><input type='text' value="" class='perHourRate'></div>
                  <div>
                    <label class='hourly-holder-label'>Hours: </label>
                    <input type='button' value='-' class='qtyminus' field='quantity' />
                    <input type='text' name='quantity' id='dynamically_box<?php echo $key;?>' value="" class='qty qty_per_hours' />
                    <input type='button' value='+' class='qtyplus' field='quantity' />
                  </div>
                  </div>
                  <div class='total-price-calculated-hourly'>
                    <label class='total-price-calculated-hourly-label'>Total Price Calculated on Hourly Rate: </label>
                    <input type='text' class='totalPriceOfHours' value="" readonly='readonly'>
                  </div>
                </div>

              <div class="monthly-main-class">
                <div class="task-description">
                  <div class="task_descrip_label_div">
                    <label class="task_descrip_label">Task Description :</label>
                  </div>
                  <div class="task-desc-textarea-div">
                    <textarea class="task-desc-textarea"><?php echo $monthlyValue->itemDiscription; ?></textarea>
                  </div>
                </div>
                <div class="monthly-main-class-subhold">
                  <div class="monthly_charge_text_holder">
                    <label class="monthly_charge_text_holder_label">Monthly Charges :</label>
                    <input class="monthly_charge_text" type="text" value="<?php echo $monthlyValue->monthly_charge_text;?>" name="monthly_charge">
                  </div>
                  <div class="numberOfMonthsHolder"><label class="numberOfMonthsHolderLabel">Number of Months :</label>
                    <select class="1-100">
                      <?php
                        for($i=1;$i<=100;$i++){
                          ?>
                            <option value="<?php echo $i; ?>" <?php if($monthlyValue->no_of_months == $i){ echo 'selected'; } ?>><?php echo $i; ?></option>
                          <?php
                        }
                       ?>
                    </select>
                  </div>
                </div>
                <div class="monthly_total_calc">
                    <label class="monthly_total_calc_label">Total Monthly Charges :</label>
                    <input class="monthly_charge_text_total" type="text" readonly="readonly" value="<?php echo $monthlyValue->monthly_charge_text_total;?>" name="monthly_charge_total">
                  </div>
              </div>

              <div class="task-at-once" style="display:block">
                <div class="task-description">
                  <div class="task_descrip_label_div">
                    <label class="task_descrip_label">Task Description :</label>
                  </div>
                  <div class="task-desc-textarea-div">
                    <textarea class="task-desc-textarea"><?php echo $atonceValue->itemDiscription;?></textarea>
                  </div>
                </div>
                <div class="at_oncemain_label_containor">
                  <div class="at-once-main_label">
                    <label class="at-once-main_label_title">Enter Cost :</label>
                  </div>
                  <div class="at-once-main_div">
                    <input type="text" name="at-once" value="<?php echo $atonceValue->charge_atonce;?>" class="at-once">
                  </div>
                </div>
              </div>
          </div>
          <?php
        }
      }
      ?>
      <!-- <div class="total-price-items-main"><a href="#" class="total-price-items">Get Total Price without tax</a></div> -->
      <!-- <div class="total-price-items-show-main">
        <div class="total-price-items-show-main-label-div">
          <label class="total-price-items-show-main-lable">Total Work Price Without Tax :</label>
        </div>
         <div class="total_work_price_div">
          <input type="text" name="total_work_price" class="total_work_price">
        </div>
      </div> -->
   <div class="project-add-items-holder">
      <!-- <div class="form-group form-float project_description_main">
         <div class="form-line"><input type="text" class="form-control" id="project_description" name="project_description" required value="<?php echo isset($data->project_description)?$data->project_description:"";?>"  >
            <label for="project_description" class="form-label"><?php echo lang('project_description'); ?> <span class="text-red">*</span></label>
         </div>
      </div> -->

      <!-- <div class="form-group form-float">
         <div class="form-line">
            <select name="payment_type" id="payment_type" class="form-control" required>
               <option value="flat" <?php if($data->payment_type == 'flat') echo 'selected';?>><?php echo lang('flat');?></option>
               <option value="installment" <?php if($data->payment_type == 'installment') echo 'selected';?> ><?php echo lang('installment');?></option>
            </select>
            <label for="payment_type" class="form-label"><?php echo lang('payment_type'); ?> <span class="text-red">*</span></label>
         </div>
      </div> -->
      <div class="form-group form-float">
         <div class="form-line">

            <select id='tax-apply-option' name="taxPercent" class="form-control">
               <option value="0">NO</option>
               <option value="1">YES</option>
            </select>
            <label for="taxPercent" class="form-label"><?php echo 'Apply Tax'; ?></label>
         </div>
      </div>
      <div class="form-group form-float" id="taxBoxPercentContainor">

         <div class="form-line"><input type="number" step="any" class="form-control" id="taxBoxPercent" name="taxBoxPercent">
            <label for="taxPercent" class="form-label"><?php echo 'Percent of Tax to Apply'; ?></label>
         </div>
      </div>
     <!--  <div class="form-group form-float">
         <div class="form-line"><input type="number" step="any" class="form-control" id="amount" name="amount" required value="<?php echo isset($data->amount)?$data->amount:"";?>"  >
            <label for="amount" class="form-label"><?php echo lang('amount'); ?> <span class="text-red">*</span></label>
         </div>
      </div> -->
   </div>
   <!-- <div class="form-group form-float">
      <div class="form-line"><input type="number" step="any" class="form-control" id="amount" name="total_amount">
         <label for="totalAmount" class="form-label"><?php echo('Total Amount') ?> </label>
      </div>
   </div> -->
   <?php //get_custom_fields('income', isset($data->income_id)?$data->income_id:NULL); ?>
</div>
<!-- /.box-body -->
<div class="box-footer">
   <input type="submit" value="<?php echo lang('save'); ?>" name="save" class="btn btn-primary btn-color">
</div>
</form>
<script>
   $.AdminBSB.input.activate();
</script>

<script type="text/javascript">
$("#invoice_date").datepicker({autoclose: true,orientation:"down",changeMonth: true,changeYear: true});
   $(document).ready(function(){
      var max_fields      = 10; //maximum input boxes allowed
      var wrapper       = $(".input_fields_wrap"); //Fields wrapper
      var add_button      = $(".add_field_button"); //Add button ID

      var x = 1; //initlal text box count
      $(add_button).click(function(e){ //on add input button click
         e.preventDefault();
         if(x < max_fields){ //max input box allowed
            x++; //text box increment
            var html = "<div class='project_invoice_headrer col-md-12'>"+
                        "<div class='type_of_invoice form-group form-float'>"+
                           "<select class='invoice_work_type'>"+
                              "<option value=0' class='project_rate_hourly'>Select Type of Payment</option>"+
                              "<option value='1' class='project_rate_hourly'>Hourly</option>"+
                              "<option value='2' class='project_rate_monthly'>Monthly</option>"+
                              "<option value='3' class='project_rate_atonce'>At Once</option>"
                          " </select>"+
                        "</div>"+
                        "<div class='hourly-holder-main'>"+
                          "<div>"+
                              "<label class='hourly-holder-label'>Price Per Hour: </label>"+
                              "<input type='text' class='perHourRate'>"+
                          "</div>"+
                          "<div>"+
                               "<label class='hourly-holder-label'>Hours: </label>"+
                               "<input type='button' value='-' class='qtyminus' field='quantity' />"+
                               "<input type='text' name='quantity' value='0' class='qty qty_per_hours' />"+
                               "<input type='button' value='+' class='qtyplus' field='quantity' />"+
                         " </div>"+
                        "</div>"+
                        "<div class='total-price-calculated-hourly'>"+
                          "<label class='total-price-calculated-hourly-label'>Total Price Calculated on Hourly Rate: </label>"+
                          "<input type='text' class='totalPriceOfHours' readonly='readonly'>"+
                        "</div>"+
                    "</div>";
              var addAtonce = '<div class="task-at-once"><div class="task-description"><div class="task_descrip_label_div"><label class="task_descrip_label">Task Description :</label></div><div class="task-desc-textarea-div"><textarea class="task-desc-textarea"></textarea></div></div><div class="at_oncemain_label_containor"> <div class="at-once-main_label"><label class="at-once-main_label_title">Enter Cost :</label></div><div class="at-once-main_div"><input type="text" name="at-once" class="at-once"></div></div></div>';
              var addMonthly = '<div class="monthly-main-class"><div class="task-description"><div class="task_descrip_label_div"><label class="task_descrip_label">Task Description :</label></div><div class="task-desc-textarea-div"><textarea class="task-desc-textarea"></textarea></div></div><div class="monthly-main-class-subhold"><div class="monthly_charge_text_holder"><label class="monthly_charge_text_holder_label">Monthly Charges :</label><input class="monthly_charge_text" type="text" name="monthly_charge"></div><div class="numberOfMonthsHolder"><label class="numberOfMonthsHolderLabel">Number of Months :</label><select class="1-100"></select></div></div><div class="monthly_total_calc"><label class="monthly_total_calc_label">Total Monthly Charges :</label><input class="monthly_charge_text_total" type="text" readonly="readonly" name="monthly_charge_total"></div></div>';
            $(wrapper).append("<div class='project_invoice_headrer col-md-12'><div class='close-item'>x</div><div class='type_of_invoice form-group form-float'><select class='invoice_work_type'><option value=0' class='project_rate_hourly'>Select Type of Payment</option><option value='1' class='project_rate_hourly'>Hourly</option><option value='2' class='project_rate_monthly'>Monthly</option><option value='3' class='project_rate_atonce'>At Once</option></select></div><div class='project_invoice_headrer_parent'><div class='task-description'><div class='task_descrip_label_div'><label class='task_descrip_label'>Task Description :</label></div><div class='task-desc-textarea-div'><textarea class='task-desc-textarea'></textarea></div></div><div class='hourly-holder-main'><div><label class='hourly-holder-label'>Price Per Hour: </label><input type='text' class='perHourRate'></div><div><label class='hourly-holder-label'>Hours: </label><input type='button' value='-' class='qtyminus' field='quantity' /><input type='text' name='quantity' id='dynamically_box"+x+"' value='0' class='qty qty_per_hours' /><input type='button' value='+' class='qtyplus' field='quantity' /></div></div><div class='total-price-calculated-hourly'><label class='total-price-calculated-hourly-label'>Total Price Calculated on Hourly Rate: </label><input type='text' class='totalPriceOfHours' readonly='readonly'></div></div>"+addMonthly+addAtonce+"</div>"); //add input box
         }
      });
      $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
         e.preventDefault(); $(this).parent('div').remove(); x--;
      })
      $('#tax-apply-option').change(function(e){
         if($('#tax-apply-option').val() == 0){
            $('#taxBoxPercentContainor').hide();
         }else{
            $('#taxBoxPercentContainor').show();
         }
      });
      var url = "<?php echo base_url()."invoice/add_edit"; ?>";

      $('body').off('submit', '#form');

      $('body').on('submit', '#form', function(ev) {
         ev.preventDefault();
       // data manipulation will go here for all items add_edit
        var mainDataHourly = [];
          var mainDataMonthly = [];
          var mainDataAtOnce = [];

        $('.project_invoice_headrer').each(function () {
           var hourlyData = {};
           hourlyData['itemDiscription'] = $(this).find('.task-desc-textarea').val();
           hourlyData['totalPrice'] = $(this).find('.totalPriceOfHours').val();
           hourlyData['perHourRate'] = $(this).find('.perHourRate').val();
           hourlyData['qty_per_hours'] = $(this).find('.qty_per_hours').val();
           if (hourlyData['totalPrice'] != '') {
            mainDataHourly.push(hourlyData);
           }

        });

        $('.monthly-main-class').each(function () {
           var hourlyData = {};
           hourlyData['itemDiscription'] = $(this).find('.task-desc-textarea').val();
           hourlyData['monthly_charge_text'] = $(this).find('.monthly_charge_text').val();
           hourlyData['no_of_months'] = $(this).find('.1-100').val();
           hourlyData['monthly_charge_text_total'] = $(this).find('.monthly_charge_text_total').val();
           if (hourlyData['monthly_charge_text_total'] != '') {
             mainDataMonthly.push(hourlyData);
           }
        });
        $('.task-at-once').each(function () {
           var hourlyData = {};
           hourlyData['itemDiscription'] = $(this).find('.task-desc-textarea').val();
           // hourlyData['monthly_charge_text'] = $(this).find('.monthly_charge_text').val();
           // hourlyData['no_of_months'] = $(this).find('.1-100').val();
           hourlyData['charge_atonce'] = $(this).find('.at-once').val();
           if (hourlyData['charge_atonce'] != '') {
            mainDataAtOnce.push(hourlyData);
           }
        });
        var clientArray = [];
        if ($('#choose-customer').val() == 1) {
        	var client_name = $('#client_name').val();
        	var gst_num = $('#gst_num').val();
        	var company_name = $('#company_name').val();
        	var company_address = $('#company_address').val();
        	var obj = new Object();
		    obj.client_name = client_name;
		    obj.gst_num  = gst_num;
		    obj.company_name = company_name;
		    obj.company_address = company_address;
		    var clientInfo= JSON.stringify(obj);
		    console.log(clientInfo);
        }else{
        	var clientInfo = '';
        }
        // data manipulation ends here
        var client_id = $('#client_id').val();
        var project_description = $('#project_description').val();
        var payment_type = $('#payment_type').val();
        var taxPercent = $('#tax-apply-option').val();
        var taxBoxPercent = $('#taxBoxPercent').val();
        var amount = $('#amount').val();
        var invoice_currency =$('#choose-currency').val();
        var created_at =$('#invoice_date').val();
        var customer_option = $('#choose-customer').val();
        if($("#editInvoiceId").length > 0){
          var invoiceId = $("input[name='id']").val();
          var data = {"customer_option":customer_option,"id":invoiceId,"invoice_currency":invoice_currency,"created_at":created_at, "mainDataHourly" : mainDataHourly, "mainDataMonthly" : mainDataMonthly, "mainDataAtOnce" : mainDataAtOnce, "client_id" : client_id, "project_description" : project_description, "payment_type" : payment_type, "taxPercent" : taxPercent, "taxBoxPercent" : taxBoxPercent, "amount" : amount, "clientInfo" : clientInfo};
        }
        else{
          var data = {"customer_option":customer_option,"invoice_currency":invoice_currency,"created_at":created_at, "mainDataHourly" : mainDataHourly, "mainDataMonthly" : mainDataMonthly, "mainDataAtOnce" : mainDataAtOnce, "client_id" : client_id, "project_description" : project_description, "payment_type" : payment_type, "taxPercent" : taxPercent, "taxBoxPercent" : taxBoxPercent, "amount" : amount, "clientInfo" : clientInfo};
        }
        // console.log(data);
        // return false;
        $.ajax({
            url: '<?php echo base_url().'invoice/add_edit' ?>',
            type : "POST",
            dataType : "json",
            data : data,
            success : function(data) {
              //console.log(data);
            // do something
            $('#example_invoice').DataTable().ajax.reload();
         }
       });
         $('.close').click();
      });
      $(document).on('keyup','.perHourRate',function(e){
          var perHourValue = $(this).closest('.hourly-holder-main').find('.qty_per_hours').val();
          var perHourRatePrice = $(this).val();
          var totalPricePerHour = perHourRatePrice*perHourValue;
          $(this).closest('.project_invoice_headrer').find('.totalPriceOfHours').val(totalPricePerHour);
      });
      $(document).on('keyup','.qty_per_hours',function(e){
          var perHourValue = $(this).val();
          var perHourRatePrice =  $(this).closest('.hourly-holder-main').find('.perHourRate').val();

          var totalPricePerHour = perHourRatePrice*perHourValue;
          $(this).closest('.project_invoice_headrer').find('.totalPriceOfHours').val(totalPricePerHour);
      });
      $(document).on('click','.close-item',function(e){
        // alert('s');
        $(this).closest('.project_invoice_headrer ').hide();
      });

      $(document).on('keyup','.monthly_charge_text',function(e){
          var perMonthValue = $(this).closest('.monthly-main-class-subhold').find('.1-100').val();
          var perMonthRatePrice = $(this).val();
          var totalPricePerMonth = perMonthRatePrice*perMonthValue;
          $(this).closest('.monthly-main-class').find('.monthly_charge_text_total').val(totalPricePerMonth);
      });
      // $(document).on('keyup','.qty_per_hours',function(e){
      //     var perHourValue = $(this).val();
      //     var perHourRatePrice =  $(this).closest('.hourly-holder-main').find('.perHourRate').val();

      //     var totalPricePerHour = perHourRatePrice*perHourValue;
      //     $(this).closest('.project_invoice_headrer').find('.totalPriceOfHours').val(totalPricePerHour+' /-');
      // });
      $(document).on('change','.1-100',function(e){
          var perHourValue = $(this).val();
          // var perHourRatePrice =  $(this).closest('.hourly-holder-main').find('.perHourRate').val();
          var perMonthValue = $(this).closest('.monthly-main-class-subhold').find('.monthly_charge_text').val();

          var totalPricePerMonth = perMonthValue*perHourValue;
         $(this).closest('.monthly-main-class').find('.monthly_charge_text_total').val(totalPricePerMonth);
      });
      // $('.qtyminus').click(function() {
      //     var perHourValue = $('.qty_per_hours').val();
      //     var perHourRatePrice = $('.perHourRate').val();
      //     var totalPricePerHour = perHourRatePrice*perHourValue;
      //     alert(totalPricePerHour);
      // });
      // $('.qtyplus').click(function() {
      //     var perHourValue = $('.qty_per_hours').val();
      //     var perHourRatePrice = $('.perHourRate').val();
      //     var totalPricePerHour = perHourRatePrice*perHourValue;
      //     alert(totalPricePerHour);
      // });
//       jQuery(document).on('click','.qtyplus',function(){
//   jQuery(this).closest('.hourly-holder-main').hide();
// });



    $(document).on('change','.invoice_work_type',function(e){
      // making per hour null on change
         $(this).closest('.project_invoice_headrer').find('.task-desc-textarea').val('');
         $(this).closest('.project_invoice_headrer').find('.perHourRate').val('');
         $(this).closest('.project_invoice_headrer').find('.qty_per_hours').val('');
         $(this).closest('.project_invoice_headrer').find('.totalPriceOfHours').val('');
        // making monthly boxes null on change
         $(this).closest('.project_invoice_headrer').find('.task-desc-textarea').val('');
         $(this).closest('.project_invoice_headrer').find('.monthly_charge_text').val('');
         $(this).closest('.project_invoice_headrer').find('.1-100').val('');
         $(this).closest('.project_invoice_headrer').find('.monthly_charge_text_total').val('');
         // making pay at once boxes null
         $(this).closest('.project_invoice_headrer').find('.task-desc-textarea').val('');
         $(this).closest('.project_invoice_headrer').find('.at-once').val('');

      if($(this).val() == 0){
         $(this).closest('.project_invoice_headrer').find('.project_invoice_headrer_parent').hide();
         $(this).closest('.project_invoice_headrer').find('.monthly-main-class').hide();
         $(this).closest('.project_invoice_headrer').find('.task-at-once').hide();
      }
      if($(this).val() == 1){
         $(this).closest('.project_invoice_headrer').find('.project_invoice_headrer_parent').show();
         $(this).closest('.project_invoice_headrer').find('.monthly-main-class').hide();
         $(this).closest('.project_invoice_headrer').find('.task-at-once').hide();
         // $('.project_invoice_headrer_parent').show();
      }
      if($(this).val() == 2){
         $(this).closest('.project_invoice_headrer').find('.project_invoice_headrer_parent').hide();
         $(this).closest('.project_invoice_headrer').find('.monthly-main-class').show();
          $(this).closest('.project_invoice_headrer').find('.task-at-once').hide();
         var $select = $(".1-100");
          for (i=1;i<=100;i++){
              $select.append($('<option></option>').val(i).html(i))
          }
      }
      if($(this).val() == 3){
        $(this).closest('.project_invoice_headrer').find('.monthly-main-class').hide();
         $(this).closest('.project_invoice_headrer').find('.project_invoice_headrer_parent').hide();
         $(this).closest('.project_invoice_headrer').find('.task-at-once').show();

      }
    });

    // manipulation of all items takes here after click in get total price


     // $(document).on('click','.total-price-items',function(e){
         function getCollectionFilteredData(){




     // });
     return mainDataAtOnce;

 }

   });
</script>

<script type="text/javascript">
   jQuery(document).ready(function(){
    // This button will increment the value
    $(document).on('click','.qtyplus',function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).prev('.qty_per_hours').attr('id');
        // Get its current value
        var currentVal = parseInt($('#'+fieldName+'').val());
        // If is not undefined
        if (!isNaN(currentVal)) {
            // Increment
            $('#'+fieldName+'').val(currentVal + 1);
         } else {
            // Otherwise put a 0 there
            $('#'+fieldName+'').val(0);
         }
        var perHourValue = $(this).prev('.qty_per_hours').val();
        // var perHourRatePrice = $(this).prev('.perHourRate').val();
        var perHourRatePrice = $(this).closest('.hourly-holder-main').find('.perHourRate').val();
        var totalPricePerHour = perHourRatePrice*perHourValue;
        $(this).closest('.project_invoice_headrer').find('.totalPriceOfHours').val(totalPricePerHour+' /-');
      });
    // This button will decrement the value till 0
    $(document).on('click','.qtyminus',function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).next('.qty_per_hours').attr('id');
        // Get its current value
        var currentVal = parseInt($('#'+fieldName+'').val());
        // If it isn't undefined or its greater than 0
        if (!isNaN(currentVal) && currentVal > 0) {
            // Decrement one
            $('#'+fieldName+'').val(currentVal - 1);
         } else {
            // Otherwise put a 0 there
            $('#'+fieldName+'').val(0);
         }
        var perHourValue = $(this).next('.qty_per_hours').val();

        var perHourRatePrice = $(this).closest('.hourly-holder-main').find('.perHourRate').val();

        var totalPricePerHour = perHourRatePrice*perHourValue;
        $(this).closest('.project_invoice_headrer').find('.totalPriceOfHours').val(totalPricePerHour+' /-');
      });
    $('#choose-customer').change(function(e){
        if($('#choose-customer').val() == 1){
          $('.custom-entry-customer-main').show();
          $('.customer-list-added').hide();
          $(".custom-entry-customer-main input[type=text]").removeAttr('disabled');
        }
        if($('#choose-customer').val() == 2){
          $('.custom-entry-customer-main').hide();
          $('.customer-list-added').show();
          $(".custom-entry-customer-main input[type=text]").attr('disabled','disabled');
        }
        if($('#choose-customer').val() == 0){
          $('.custom-entry-customer-main').hide();
          $('.customer-list-added').hide();
        }
    });
 });

</script>


<style type="text/css">
#taxBoxPercentContainor{
   display: none;
}
.add_field_button{
   float: right;
   color: white;
   background: gray;
   padding: 2%;
   text-transform: uppercase;
   text-decoration: none;
}
.project-add-items-holder{
   clear: both;
}
.qty_per_hours{
       width: 20%;
    text-align: center;
}
.type_of_invoice,.hourly-holder-main{
   display: flex;
}
.hourly-holder-main{
   text-align: -webkit-auto;
}
.perHourRate{
       width: 18%;
    text-align: center;
}
.type_of_invoice {
  width: 100%;
    border-bottom: 1px solid #8080806b;
}
.project_invoice_headrer{
  padding: 0;
}
.invoice_work_type{
  border: none;
    color: #808080a6;
    width: 100%;
    font-size: 13px;
    font-weight: bold;
}
.totalPriceOfHours{
      border: none;
}
.hourly-holder-label{
      font-weight: 100;
    color: #808080ab;
}
.total-price-calculated-hourly{
      text-align: -webkit-auto;
}
.total-price-calculated-hourly-label{
  font-weight: 100;
  color: #808080a3;
}
.close-item{
      float: right;
    margin-bottom: 8px;
    font-size: 18px;
    font-weight: 700;
    cursor: pointer;
}
.project_invoice_headrer_parent{
  display: none;
  line-height: 35px;
}
.monthly-main-class{
  display: none;
line-height: 35px;
}
.monthly_charge_text_holder{
  float: left;
}
.monthly_charge_text_holder: label{
  color: #80808099;
  font-weight: 100;
}
.numberOfMonthsHolderLabel , .monthly_charge_text_holder_label, .monthly_total_calc_label, .task_descrip_label, .at-once-main_label_title{
  color: #80808099;
  font-weight: 100;
}
.monthly_total_calc{
  float: left;
  margin-top: 3px;
}
.monthly_charge_text_total{
  border: none;
}
.task-description{
      display: -webkit-box;
}
.task-desc-textarea{
      width: 346px;
}
.task-at-once{
  display:none;
  line-height: 35px;
    margin-bottom: 26px;
}
.at_oncemain_label_containor{
      display: -webkit-box;
}
.project_description_main{
  margin-top: 19px;
}
.project_invoice_headrer {
      border-bottom: 1px solid #80808063;
}
.project_invoice_headrer {
  margin-bottom: 16px;
}
.total-price-items-show-main{
    display: -webkit-box;
    margin-top: 30px;
}
.total-price-items{
      color: white;
    background: gray;
    padding: 2%;
    text-transform: uppercase;
    text-decoration: none;
}
.custom-client-field{
  border: 1px solid #8080806b !important;
  border-radius: 4px !important;
}
.custom-entry-customer-main{
  display: none;
}
.customer-list-added{
  display: none;
}
</style>
