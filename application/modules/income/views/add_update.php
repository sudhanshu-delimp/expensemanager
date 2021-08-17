<form action="<?php echo base_url()."income/add_edit"; ?>" method="post" role="form" id="form" enctype="multipart/form-data" style="padding: 0px 10px">
 <?php if(isset($data->income_id)){?><input type="hidden"  name="id" value="<?php echo isset($data->income_id) ?$data->income_id : "";?>"> <?php } ?>
 <div class="box-body"><div class="form-group form-float">
<div class="form-line"><input type="date" class="form-control" id="income_date" name="income_date" required value="<?php echo isset($data->income_date)?date("Y-m-d",strtotime($data->income_date)):date("Y-m-d",strtotime("now"));?>"  >
<label for="income_date" class="form-label"><?php echo lang('date'); ?> <span class="text-red">*</span></label>
</div></div>
<div class="form-group form-float">
<div class="form-line"><input type="date" class="form-control" id="send_date" name="send_date" required value="<?php echo isset($data->send_date)?date("Y-m-d",strtotime($data->send_date)):date("Y-m-d",strtotime("now"));?>"  >
<label for="expenses_date" class="form-label"><?php echo lang('send_date'); ?> <span class="text-red">*</span></label>
</div></div>
<div class="form-group form-float">
<div class="form-line"><input type="date" class="form-control" id="receive_date" name="receive_date"  value="<?php echo isset($data->receive_date)?date("Y-m-d",strtotime($data->receive_date)):date("Y-m-d",strtotime("now"));?>"  >
<label for="expenses_date" class="form-label"><?php echo lang('receive_date'); ?> </label>
</div></div>
<div class="form-group form-float">
<div class="form-line"><label class="form-label"><?php echo lang('client'); ?> </label>
<?php echo selectBoxDynamic("client_id","client_management","name",isset($data->client_id) ?$data->client_id : "", "required","status", "active","name","ASC");?>
</div></div>
<div class="form-group form-float">
<div class="form-line"><input type="text" class="form-control" id="income_description" name="income_description" required value="<?php echo isset($data->income_description)?$data->income_description:"";?>"  >
<label for="income_description" class="form-label"><?php echo lang('description'); ?> <span class="text-red">*</span></label>
</div></div>
<div class="form-group form-float">
<div class="form-line"><select name="currency_type" id="currency_type" class="form-control" required>  
  <option value="USD" <?php if($data->currency_type == 'USD') echo 'selected';?>>USD</option>
  <option value="INR" <?php if($data->currency_type == 'INR') echo 'selected';?> >INR</option>
  <option value="GBP" <?php if($data->currency_type == 'GBP') echo 'selected';?> >GBP</option>
</select>
<label for="currency_type" class="form-label"><?php echo lang('currency_type'); ?> <span class="text-red">*</span></label>
</div></div>
<div class="form-group form-float">
<div class="form-line"><input type="number" step="any" class="form-control" id="income_amount" name="income_amount" required value="<?php echo isset($data->income_amount)?$data->income_amount:"";?>"  >
<label for="income_amount" class="form-label"><?php echo lang('amount'); ?> <span class="text-red">*</span></label>
</div></div>
<div class="form-group form-float">
<div class="form-line"><input type="number" step="any" class="form-control" id="inr_amount" name="inr_amount" value="<?php echo isset($data->inr_amount)?$data->inr_amount:"";?>"  >
<label for="inr_amount" class="form-label"><?php echo lang('inr_amount'); ?></label>
</div></div>
<div class="form-group form-float">
<div class="form-line"><label class="form-label"><?php echo lang('category'); ?> </label>
<?php echo selectBoxDynamic("income_category","income_category","income_category_category_name",isset($data->income_category) ?$data->income_category : "", "");?>
</div></div>

        		<?php get_custom_fields('income', isset($data->income_id)?$data->income_id:NULL); ?>
        		</div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                  	 <input type="submit" value="<?php echo lang('save'); ?>" name="save" class="btn btn-primary btn-color">
                  </div>
               </form>
            <script>
  				$.AdminBSB.input.activate();
			</script>