<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- start: PAGE CONTENT -->

<section class="content">

	<div class="container-fluid">

		<!-- Main content -->

		<div class="row">

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

				<div class="card">

					<div class="header">

						<h2><?php echo lang('invoice') ?></h2>

						<?php print_r($totalPaid);?>

						<ul class="header-dropdown">

							<?php if(CheckPermission("invoice", "own_create")){ ?>

								<button type="button" class="btn-sm  btn btn-primary waves-effect amDisable modalButton" data-src="" data-width="555" ><i class="material-icons">add</i><?php echo lang('create_invoice') ?></button>

							<?php }?>

						</ul>

					</div>

					<!-- /.box-header -->

					<div class="body table-responsive">



						<div class="row fRow">

							<div class="col-md-3 table-date-range">

								<label for="date-range" class="control-label"><?php echo lang('select_date_range'); ?></label>

								<input type="text" class="form-control daterange-filter daterange-picker" name="daterange" placeholder="<?php echo lang('select_date'); ?>" value="" />

							</div>

						</div>

						<table id="example_invoice" class="table table-bordered table-striped table-hover delSelTable example_invoice">

							<thead>

								<tr>

									<th>

										<input type="checkbox" class="selAll" id="basic_checkbox_1mka" />

										<label for="basic_checkbox_1mka"></label>

									</th>

									<th><?php echo lang('invoice_no') ?></th>

									<th><?php echo lang('date') ?></th>
									<th><?php echo lang('invoice date') ?></th>

									<th><?php echo lang('client') ?></th>

									<th><?php echo lang('added_by'); ?></th>

									<th><?php echo lang('action'); ?></th>

								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>

					</div>

					<!-- /.box-body -->

				</div>

				<!-- /.box -->

			</div>

			<!-- /.col -->

		</div>

		<!-- /.row -->

		<!-- /.Main-content -->

	</div>

</section>

<!-- /.content-wrapper -->



<div class="modal fade" id="nameModal_invoice"  role="dialog"><!-- Modal Crud Start-->

	<div class="modal-dialog">

		<div class="modal-content" >

			<div class="modal-header">

				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

				<h4 class="box-title"><?php echo lang('invoice'); ?></h4>

			</div>

			<div class="modal-body"></div>

		</div>

	</div>

</div><!--End Modal Crud -->



<div class="modal fade" id="nameModal_payment"  role="dialog"><!-- Modal Crud Start-->

	<div class="modal-dialog">

		<div class="modal-content" >

			<div class="modal-header">

				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

				<h4 class="box-title"><?php echo lang('add_payment'); ?></h4>

			</div>

			<div class="modal-body"></div>

		</div>

	</div>

</div><!--End Modal Crud -->

<div class="modal fade" id="nameModal_pdf"  role="dialog"><!-- Modal Crud Start-->

	<div class="modal-dialog">

		<div class="modal-content" >

			<div class="modal-header">

				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

				<!-- <h4 class="box-title"><?php ; ?></h4> -->

			</div>

			<div class="modal-body"></div>

		</div>

	</div>

</div><!--End Modal Crud -->



<script type="text/javascript">

	jQuery(document).ready(function() {

		var url = "<?php echo base_url();?>";

		var table = $("#example_invoice").DataTable({

			"dom": 'lfBrtip',

			"buttons": ['excel','print','pdf'],

			"processing": true,

			"serverSide": true,

			"ajax": {

				"url" : url + "invoice/ajx_data",

				<?php if(isset($submodule) && $submodule != '') { ?>

					"data": function ( d ) {

						d.submodule = '<?php echo $submodule; ?>';

					}

				<?php } ?>

			},

			"sPaginationType": "full_numbers",

			"language": {

				"search": "_INPUT_",

				"searchPlaceholder": "<?php echo lang('search'); ?>",

				"paginate": {

					"next": '<i class="fa fa-angle-right"></i>',

					"previous": '<i class="fa fa-angle-left"></i>',

					"first": '<i class="fa fa-angle-double-left"></i>',

					"last": '<i class="fa fa-angle-double-right"></i>'

				}

			},

			"iDisplayLength": 10,

			"aLengthMenu": [[10, 25, 50, 100,500,-1], [10, 25, 50,100,500,"<?php echo lang('all'); ?>"]],

			"columnDefs" : [

			{

				"orderable": false,

				"targets": [0]

			}<?php if(!CheckPermission("invoice", "all_delete") && !CheckPermission("invoice", "own_delete")){ ?>

				,{

					"targets": [0],

					"visible": false,

					"searchable": false

				}

			<?php } ?>

			],

			"order": [[1, 'desc']],

		});



		$(".daterange-filter").on("change", function() {

			table.destroy();

			var dateRange = $(this).val();

			table = $("#example_invoice").DataTable({

				"dom": 'lfBrtip',

				"buttons": ['excel','print','pdf'],

				"processing": true,

				"serverSide": true,

				"ajax": {

					"url" : url + "invoice/ajx_data",

					"data": function ( d ) {

						d.dateRange = dateRange;

						d.columnName = "invoice_date";

						<?php if(isset($submodule) && $submodule != '') { ?>

							d.submodule = '<?php echo $submodule; ?>';

						<?php } ?>

					}

				},

				"sPaginationType": "full_numbers",

				"language": {

					"search": "_INPUT_",

					"searchPlaceholder": "<?php echo lang('search'); ?>",

					"paginate": {

						"next": '<i class="fa fa-angle-right"></i>',

						"previous": '<i class="fa fa-angle-left"></i>',

						"first": '<i class="fa fa-angle-double-left"></i>',

						"last": '<i class="fa fa-angle-double-right"></i>'

					}

				},

				"iDisplayLength": 10,

				"aLengthMenu": [[10, 25, 50, 100,500,-1], [10, 25, 50,100,500,"<?php echo lang('all'); ?>"]],

				"columnDefs" : [

				{

					"searchable": false,
					"orderable": false,
					"className": 'select-checkbox',
					"targets": 0

				}<?php if(CheckPermission("invoie", "all_delete") && !CheckPermission("invoie", "own_delete")){ ?>

					,{

						"targets": [0],

						"visible": false,

						"searchable": false

					}

				<?php } ?>

				],

				"order": [[1, 'desc']],

			});

		});





		$('body').off('submit', '#form');

		$('body').on('submit', '#form', function(ev) {

			ev.preventDefault();

			$('#nameModal_invoice').find('input[name="save"]').after('<span class="mka-loading"><img src="<?php echo mka_base().'assets/images/widget-loader-lg.gif'; ?>" alt="" /><span>');

			var formData = new FormData($(this)[0]);

			$.ajax({

				url: '<?php echo base_url().'invoice/add_edit' ?>',

				method: 'POST',

				async: false,

				data: formData,

				cache: false,

				contentType: false,

				processData: false

			}).done(function(mka) {

				if(mka > 0) {

					$('#nameModal_invoice').modal('hide');

					setTimeout(function() {

						if($('.submodule-main-div').length > 0) {

							$('.custom-tab').each(function() {

								if($(this).hasClass('active')) {

									$(this).trigger('click');

								}

							})

						} else {
                             var datatbale_name = $("#example_invoice").DataTable() ;
                            datatbale_name.ajax.reload(null, false );
							//$('#example_invoice').DataTable().ajax.reload();

							showNotification('<?php echo lang('your_action_has_been_completed_successfully'); ?>.', 'success');

						}

					}, 300);

				}

			});

		});



		$('body').off('click', '.yes-btn');

		$('body').on('click', '.yes-btn', function(e) {

			e.preventDefault();

			$.post($(this).attr('href'), function(data) {

				$('tbody').find('tr').each(function() {

					$ob = $(this);

					$dom_val = $ob.find('td').first().find('input').val();

					$('#cnfrm_delete').modal('hide');

					$.each(data, function(index, val) {

						if($dom_val == val) {

							$('#example_invoice').DataTable().ajax.reload();

						}

					});

				});

				showNotification('<?php echo lang('records_deleted_successfully'); ?>.', 'success');

			}, 'json');

		});




		// $('input[name="daterange"]').daterangepicker({
	  //    opens: 'right'
	  //  }, function(start, end, label) {
	  //    console.log("A new date selection was made: " + start.format('DD-MM-YYYY') + ' to ' + end.format('DD-MM-YYYY'));
	  //  });

		$(".daterange-picker").daterangepicker(
		{
			locale: {
				format: "DD-MM-YYYY"
			},
			startDate: "<?php echo $sDate = "01-".date("m-Y"); ?>",
			endDate: "<?php echo date("d-m-Y", strtotime($sDate. " + 60 day")); ?>"
		});
	} );



( function($) {

	$(document).ready(function(){

		var  cjhk = 0;

		<?php if(CheckPermission("invoice", "all_delete") || CheckPermission("invoice", "own_delete")){ ?>

			cjhk = 1;

		<?php } ?>

		setTimeout(function() {

			var add_width = $('.dataTables_filter').width()+$('.box-body .dt-buttons').width()+10;

		//$('.table-date-range').css('right',add_width+'px');



		if(cjhk == 1) {

			$('.dataTables_info').before('<button data-del-url="<?php echo base_url() ?>invoice/delete/" rel="delSelTable" class="btn btn-default btn-sm delSelected pull-left"> <i class="material-icons col-red">delete</i> </button><br><br>');

		}

	}, 300);





		$("body").on("click",".modalButton", function(e) {

			var loading = '<img src="<?php echo mka_base() ?>assets/images/loading.gif" />';

			$("#nameModal_invoice").find(".modal-body").html(loading);

			$("#nameModal_invoice").find(".modal-body").attr("style","text-align: center");

			$.ajax({

				url : "<?php echo base_url()."invoice/get_modal";?>",

				method: "post",

				data : {

					id: $(this).attr("data-src")

				}

			}).done(function(data) {

				$("#nameModal_invoicee").find(".modal-body").removeAttr("style");

				$("#nameModal_invoice").find(".modal-body").html(data);

				$("#nameModal_invoice").modal("show");

				$(".form_check").each(function() {

					$p_obj = $(this);

					$res = 1;

					if($p_obj.find(".check_box").hasClass("required")) {

						if($p_obj.find(".check_box").is(":checked")) {

							$res = "0";

						}

					}

					if($res == 0) {

						$(".check_box").prop("required", false);

					}

				})

			})

		});

		$("body").on("click",".download_pdfF", function(e) {
			$.ajax({
				url : "<?php echo base_url()."invoice/get_pdf";?>",
				method: "post",
				data : {
					id: $(this).attr("data-src")
				}
			}).done(function(data) {
			// $("#nameModal_pdf").find(".modal-body").removeAttr("style");
			// $("#nameModal_pdf").find(".modal-body").html(data);
			// $("#nameModal_pdf").modal("show");
			$(".form_check").each(function() {
				$p_obj = $(this);
				$res = 1;
				if($p_obj.find(".check_box").hasClass("required")) {
					if($p_obj.find(".check_box").is(":checked")) {
						$res = "0";
					}
				}
				if($res == 0) {
					$(".check_box").prop("required", false);
				}
			})
		})
		});


		$("body").on("click",".add_payment", function(e) {

			var loading = '<img src="<?php echo mka_base() ?>assets/images/loading.gif" />';

			$("#nameModal_payment").find(".modal-body").html(loading);

			$("#nameModal_payment").find(".modal-body").attr("style","text-align: center");

			$.ajax({

				url : "<?php echo base_url()."invoice/get_payment_modal";?>",

				method: "post",

				data : {

					id: $(this).attr("data-src")

				}

			}).done(function(data) {

				$("#nameModal_payment").find(".modal-body").removeAttr("style");

				$("#nameModal_payment").find(".modal-body").html(data);

				$("#nameModal_payment").modal("show");

				$(".form_check").each(function() {

					$p_obj = $(this);

					$res = 1;

					if($p_obj.find(".check_box").hasClass("required")) {

						if($p_obj.find(".check_box").is(":checked")) {

							$res = "0";

						}

					}

					if($res == 0) {

						$(".check_box").prop("required", false);

					}

				})

			})

		});



		/*********submit payment data ********/

		$('body').off('submit', '#payment_form');

		$('body').on('submit', '#payment_form', function(ev) {

			ev.preventDefault();

			$('#nameModal_payment').find('input[name="save"]').after('<span class="mka-loading"><img src="<?php echo mka_base().'assets/images/widget-loader-lg.gif'; ?>" alt="" /><span>');

			var formData = new FormData($(this)[0]);

			$.ajax({

				url: '<?php echo base_url().'invoice/add_payment' ?>',

				method: 'POST',

				async: false,

				data: formData,

				cache: false,

				contentType: false,

				processData: false

			}).done(function(mka) {

				if(mka > 0) {

					$('#nameModal_payment').modal('hide');

					setTimeout(function() {

						if($('.submodule-main-div').length > 0) {

							$('.custom-tab').each(function() {

								if($(this).hasClass('active')) {

									$(this).trigger('click');

								}

							})

						} else {

							$('#example_invoice').DataTable().ajax.reload();

							showNotification('<?php echo lang('your_action_has_been_completed_successfully'); ?>.', 'success');

						}

					}, 300);

				}

			});

		});

	});

} ) ( jQuery );

</script>
