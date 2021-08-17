<form action="<?php echo base_url()."income_category/add_edit"; ?>" method="post" role="form" id="form" enctype="multipart/form-data" style="padding: 0px 10px">
 <?php if(isset($data->income_category_id)){?><input type="hidden"  name="id" value="<?php echo isset($data->income_category_id) ?$data->income_category_id : "";?>"> <?php } ?>
 <div class="box-body"><div class="form-group form-float">
<div class="form-line"><input type="text" class="form-control" id="income_category_category_name" name="income_category_category_name" required value="<?php echo isset($data->income_category_category_name)?$data->income_category_category_name:"";?>"  >
<label for="income_category_category_name" class="form-label"><?php echo lang('category_name'); ?> <span class="text-red">*</span></label>
</div></div>

        		<?php get_custom_fields('income_category', isset($data->income_category_id)?$data->income_category_id:NULL); ?>
        		</div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                  	 <input type="submit" value="<?php echo lang('save'); ?>" name="save" class="btn btn-primary btn-color">
                  </div>
               </form>
            <script>
  				$.AdminBSB.input.activate();
			</script>