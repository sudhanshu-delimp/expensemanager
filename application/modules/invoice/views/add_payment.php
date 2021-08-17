<div class="payment-history">
  <span><?php //echo lang('payment_history'); ?></span>
  <div class="invoice_row">
     <table class="table table-bordered">
        <thead>
          <tr>
              <th> <?php echo lang('invoice_no'); ?></th>
      <th><?php echo lang('total_amount'); ?></th>
      <th><?php echo lang('due_amount'); ?></th>
    </tr>
    </thead>
    <tbody class="data_row">
      <tr>
              <td>
      <?php echo $data->invoice_no ?></td>
      <td><?php echo $data->amount ?></td>
      <td><?php echo $data->due_amount ?></td>
      </tr>
  </tbody>
</table>
  <?php if(count($payment)){?>
  <div class="payment_row">
      <table class="table table-bordered">
        <thead>
           <tr>
              <th>Sr. No.</th>
              <th>Amount</th>
              <th>Payment Data</th>
           </tr>
        </thead>

      <?php $i=1;
      foreach($payment as $pay){?>
        <tbody>
          <tr>
              <td><?php echo $i++;?></td>
              <td><?php echo $pay->amount?></td>
              <td><?php echo $pay->payment_date;?></td>
          </tr>
        </tbody>
      <?php }?>
      </table>
  </div>
<?php } ?>
</div>
<?php if($data->due_amount){?>
<form action="<?php echo base_url()."invoice/add_payment"; ?>" method="post" role="form" id="payment_form" enctype="multipart/form-data" style="padding: 0px 10px">
 <?php if(isset($data->invoice_id)){?><input type="hidden"  name="invoice_id" value="<?php echo isset($data->invoice_id) ?$data->invoice_id : "";?>"> <?php } ?>
 <div class="box-body">
  <div class="form-group form-float">
<div class="form-line"><input type="date" class="form-control" id="payment_date" name="payment_date" required value="<?php echo date("Y-m-d",strtotime("now"));?>"  >
<label for="payment_date" class="form-label"><?php echo lang('payment_date'); ?> <span class="text-red">*</span></label>
</div></div>
<div class="form-group form-float">
<div class="form-line"><input type="number" step="any" class="form-control" id="amount" name="amount" required value="<?php echo $data->due_amount ?>">
<label for="amount" class="form-label"><?php echo lang('amount'); ?> <span class="text-red">*</span></label>
</div></div>
<div class="form-group form-float">
<div class="form-line"><input type="text" step="any" class="form-control" id="payment_note" name="payment_note" required value="">
<label for="amount" class="form-label"><?php echo lang('payment_note'); ?> <span class="text-red">*</span></label>
</div></div>

        		</div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                  	 <input type="submit" value="<?php echo lang('save'); ?>" name="save" class="btn btn-primary btn-color">
                  </div>
               </form>
             <?php }?>
            <script>
  				$.AdminBSB.input.activate();
			</script>
