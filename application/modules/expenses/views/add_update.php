<form action="<?php echo base_url()."expenses/add_edit"; ?>" method="post" role="form" id="form" enctype="multipart/form-data" style="padding: 0px 10px">
 <?php if(isset($data->expenses_id)){?><input type="hidden"  name="id" value="<?php echo isset($data->expenses_id) ?$data->expenses_id : "";?>"> <?php } ?>
 <div class="box-body"><div class="form-group form-float">
<div class="form-line"><input type="date" class="form-control" id="expenses_date" name="expenses_date" required value="<?php echo isset($data->expenses_date)?date("Y-m-d",strtotime($data->expenses_date)):date("Y-m-d",strtotime("now"));?>"  >
<label for="expenses_date" class="form-label"><?php echo lang('date'); ?> <span class="text-red">*</span></label>
</div></div>
<div class="form-group form-float">
<div class="form-line"><input type="text" class="form-control" id="expenses_description" name="expenses_description" required value="<?php echo isset($data->expenses_description)?$data->expenses_description:"";?>"  >
<label for="expenses_description" class="form-label"><?php echo lang('description'); ?> <span class="text-red">*</span></label>
</div></div>
<div class="form-group form-float">
<div class="form-line"><input type="number" step="any" class="form-control" id="expenses_amount" name="expenses_amount" required value="<?php echo isset($data->expenses_amount)?$data->expenses_amount:"";?>"  >
<label for="expenses_amount" class="form-label"><?php echo lang('amount'); ?> <span class="text-red">*</span></label>
</div></div>
<div class="form-group form-float">
<div class="form-line"><label class="form-label"><?php echo lang('category'); ?> </label>
<?php echo selectBoxDynamic("expenses_category","expense_category","expense_category_category_name",isset($data->expenses_category) ?$data->expenses_category : "", "");?>
</div></div>
<div class="form-group form-float">
<?php  
                        if( isset($data->expenses_upload_receipt) && !empty($data->expenses_upload_receipt)){ $req ="";}else{$req ="";}
						if(isset($data->expenses_upload_receipt))
						{
							$old_uploads = explode("," , $data->expenses_upload_receipt);
							foreach ($old_uploads as $old_upload) {
							?>
							<div class="wpb_old_files">
							<input type="hidden"  name="wpb_old_expenses_upload_receipt[]" value="<?php echo isset($old_upload) ?$old_upload : "";?>" class="check_old">
							<a href="<?php echo base_url().'assets/images/'.$old_upload ?>" download> <?php echo $old_upload; ?> </a> <span><i class="fa fa-close remove_old" onclick="del_file(<?php echo $i;?>)"></i></span></div>
						<?php 
							}
						} 
						?>
						<input type="file" data="" placeholder="Upload Receipt" class="file-upload check_new" id="expenses_upload_receipt" name="expenses_upload_receipt[]" <?php echo $req; ?>  value="" onchange='validate_fileType(this.value,&quot;expenses_upload_receipt&quot;,&quot;pdf,jpg,png,jpeg,docx,doc,xlsx,xls&quot;);' ><p id="error_expenses_upload_receipt"></p>
</div>

        		<?php get_custom_fields('expenses', isset($data->expenses_id)?$data->expenses_id:NULL); ?>
        		</div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                  	 <input type="submit" value="<?php echo lang('save'); ?>" name="save" class="btn btn-primary btn-color">
                  </div>
               </form>
            <script>
  				$.AdminBSB.input.activate();
			</script>