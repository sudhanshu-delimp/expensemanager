<!-- Content Wrapper. Contains page content -->
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
      		<h2><?php echo lang('dashboard'); ?></h2>
    	</div>
	  		<div class="row clearfix">
		    		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			          	<div class="info-box bg-pink hover-expand-effect EditDeshbord" data-deshbid_id=218  data-deshbid_type=info_box style="background-color: #00c0ef !important;">
			            	<div class="icon">
				                <span class="glyphicon glyphicon-star-empty"></span>
				            </div>
			            	<div class="content">
			            		<div class="text">Total Income</div>
			            		<div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20"><?php echo isset($Total_Income_data[0]->mka)?$Total_Income_data[0]->mka:'0'; ?></div>
			            	</div> 
			            <!-- /.info-box-content -->
			          	</div>
			          <!-- /.info-box -->
			        </div>
		    		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			          	<div class="info-box bg-pink hover-expand-effect EditDeshbord" data-deshbid_id=219  data-deshbid_type=info_box style="background-color: #f77d73 !important;">
			            	<div class="icon">
				                <span class="glyphicon glyphicon-fire"></span>
				            </div>
			            	<div class="content">
			            		<div class="text">Total Expense</div>
			            		<div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20"><?php echo isset($Total_Expense_data[0]->mka)?$Total_Expense_data[0]->mka:'0'; ?></div>
			            	</div> 
			            <!-- /.info-box-content -->
			          	</div>
			          <!-- /.info-box -->
			        </div>
		    		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			          	<div class="info-box bg-pink hover-expand-effect EditDeshbord" data-deshbid_id=220  data-deshbid_type=info_box style="background-color: #a49ae0 !important;">
			            	<div class="icon">
				                <span class="glyphicon glyphicon-bookmark"></span>
				            </div>
			            	<div class="content">
			            		<div class="text">Expense Today</div>
			            		<div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20"><?php echo isset($Expense_Today_data[0]->mka)?$Expense_Today_data[0]->mka:'0'; ?></div>
			            	</div> 
			            <!-- /.info-box-content -->
			          	</div>
			          <!-- /.info-box -->
			        </div></div>
			        <div class="row  clearfix"><div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
  <?php /*<div class="card mka-das-table EditDeshbord" data-deshbid_type="list_box" data-deshbid_id="221">
      <div class="header">
          <h2>Last Expenses</h2>
      </div>
      <!-- /.box-header -->
      <div class="body" style="display: block;">
          <div class="table-responsive">
            <table class="table table-hover dashboard-task-infos">
                <thead>
                  <tr>
                    <th>Date</th>
						<th>Description</th>
						<th>Amount</th>
						<th>Category</th>
						
                  </tr>
                </thead>
                <tbody>
                  <?php 
	              	if(is_array($last_expenses_list) && !empty($last_expenses_list)) { 
	              		foreach ($last_expenses_list as $key => $value) {
	              	?>
		              <tr><td><?php echo $value->expenses_date; ?></td>
							<td><?php echo $value->expenses_description; ?></td>
							<td><?php echo $value->expenses_amount; ?></td>
							<td><?php echo $value->expense_category_category_name; ?></td>
							</tr>
		            <?php } } else { ?>
		            	<tr>
							<td colspan="<?php echo count($last_expenses_list); ?>"> <span>No Result Found.</span> </td>
						</tr>
					<?php } ?>
		            
                </tbody>
            </table>
          </div>
        <!-- /.table-responsive -->
      </div> 
      <!-- /.box-body -->
     <!--  <div class="box-footer clearfix" style="display: block;">
       <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
       <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
     </div> -->
      <!-- /.box-footer -->
  </div>*/?>
</div><div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <!-- BAR CHART -->
    <div class="card mka-das-table EditDeshbord" data-deshbid_type="bar_chart" data-deshbid_id="222">
      <div class="header">
        <h2>Monthly Expenses</h2>
      </div>
      <div class="body">
        <div class="chart">
          <canvas class="bar_chart" style="height:230px"></canvas>
        </div>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
</div>


<script>
  $(function () {
    for (var i = 0; i < $('.bar_chart').length; i++) {
      new Chart(document.getElementsByClassName("bar_chart")[i].getContext("2d"), getChartJs('bar'));  
    }
  });

  function getChartJs(type) {
    var config = {
            type: 'bar',
            data: {
                labels: ["<?php echo lang('january'); ?>", "<?php echo lang('february'); ?>", "<?php echo lang('march'); ?>", "<?php echo lang('april'); ?>", "<?php echo lang('may'); ?>", "<?php echo lang('june'); ?>", "<?php echo lang('july'); ?>", "<?php echo lang('august'); ?>", "<?php echo lang('september'); ?>", "<?php echo lang('october'); ?>", "<?php echo lang('november'); ?>", "<?php echo lang('december'); ?>"],
                datasets: [
							{
								label : "Bar 1",
								data : [<?php echo $Bar_1 ?>],
								backgroundColor : '#039ae4'
							},
							]
            },
            options: {
                responsive: true,
                legend: false
            }
        }
    return config;
  }
</script></div></div>
</section>
		