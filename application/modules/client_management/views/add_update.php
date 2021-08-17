<form action="<?php echo base_url()."income_category/add_edit"; ?>" method="post" role="form" id="form" enctype="multipart/form-data" style="padding: 0px 10px">
 <?php if(isset($data->client_management_id)){?><input type="hidden"  name="id" value="<?php echo isset($data->client_management_id) ?$data->client_management_id : "";?>"> <?php } ?>
 <div class="box-body"><div class="form-group form-float">
  <div class="form-line"><input type="text" class="form-control" id="name" name="name" required value="<?php echo isset($data->name)?$data->name:"";?>"  >
    <label for="name" class="form-label"><?php echo lang('client_name'); ?> <span class="text-red">*</span></label>
  </div>
</div>
<div class="form-group form-float">
  <div class="form-line"><textarea class="form-control" id="description" name="description" required ><?php echo isset($data->description)?$data->description:"";?></textarea>
    <label for="client_management_description" class="form-label"><?php echo lang('description'); ?> <span class="text-red">*</span></label>
  </div>
</div>
  <div class="form-group form-float">
    <div class="form-line"><input type="text" class="form-control" id="company_name" name="company_name" required value="<?php echo isset($data->company_name)?$data->company_name:"";?>"  >
      <label for="company_name" class="form-label"><?php echo lang('company_name'); ?> <span class="text-red">*</span></label>
    </div>
  </div>

  <div class="form-group form-float">
    <div class="form-line"><input type="text" class="form-control" id="company_gst" name="company_gst"  value="<?php echo isset($data->company_gst)?$data->company_gst:"";?>"  >
      <label for="company_gst" class="form-label"><?php echo ('Company GST'); ?> </label>
    </div>
  </div>

  <div class="form-group form-float">
    <div class="form-line"><textarea class="form-control" id="address" name="address" required ><?php echo isset($data->address)?$data->address:"";?></textarea>
      <label for="client_management_address" class="form-label"><?php echo lang('address'); ?> <span class="text-red">*</span></label>
    </div></div>
    <div class="form-group form-float">
      <div class="form-line">
        <select name="status" id="status" class="form-control" required>
         <option value="active" <?php if($data->status=='active') echo 'selected'; ?>> <?php echo lang('active'); ?></option>
         <option value="inactive" <?php if($data->status=='inactive') echo 'selected'; ?>> <?php echo lang('inactive'); ?></option>
       </select>
       <label for="status" class="form-label"><?php echo lang('status'); ?> <span class="text-red">*</span></label>
     </div>
   </div>


   <?php //get_custom_fields('income_category', isset($data->income_category_id)?$data->income_category_id:NULL); ?>
 </div>
 <!-- /.box-body -->
 <div class="box-footer">
  <input type="submit" value="<?php echo lang('save'); ?>" name="save" class="btn btn-primary btn-color">
</div>
</form>
<script>
  $.AdminBSB.input.activate();
</script>