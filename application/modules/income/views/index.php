<!-- start: PAGE CONTENT -->
    <section class="content">
		<div class="container-fluid">
		<!-- Main content -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
						<div class="header">
                           <h2><?php echo lang('income') ?></h2>
                              <ul class="header-dropdown">
                                 <?php if(CheckPermission("income", "own_create")){ ?>
                                 <button type="button" class="btn-sm  btn btn-primary waves-effect amDisable modalButton" data-src="" data-width="555" ><i class="material-icons">add</i><?php echo lang('add_income') ?></button>
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
<table id="example_income" class="table table-bordered table-striped table-hover delSelTable example_income">
								  <thead>
								 	<tr>
										<th>
											<input type="checkbox" class="selAll" id="basic_checkbox_1mka" />
                    						<label for="basic_checkbox_1mka"></label>
                    					</th>
<th><?php echo lang('date') ?></th>
<th><?php echo lang('client') ?></th>
<th><?php echo lang('description') ?></th>
<th><?php echo lang('send_date') ?></th>
<th><?php echo lang('currency_type') ?></th>
<th><?php echo lang('amount') ?></th>
<th><?php echo lang('category') ?></th>
<th><?php echo lang('added_by'); ?></th>
									<?php  $cf = get_cf('income');
					                    if(is_array($cf) && !empty($cf)) {
					                      foreach ($cf as $cfkey => $cfvalue) {
					                        //echo '<th>'.lang(get_lang($cfvalue->rel_crud).'_'.get_lang($cfvalue->name)).'</th>';
                                   echo '<th>'.$cfvalue->name.'</th>';
                                }
					                    }
						            ?>

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

<div class="modal fade" id="nameModal_income"  role="dialog"><!-- Modal Crud Start-->
	<div class="modal-dialog">
		<div class="modal-content" >
			<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">??</span></button>
				  <h4 class="box-title"><?php echo lang('income'); ?></h4>
			</div>
			<div class="modal-body"></div>
		</div>
	</div>
</div><!--End Modal Crud -->

<script type="text/javascript">
jQuery(document).ready(function() {
	var url = "<?php echo base_url();?>";
var table = $("#example_income").DataTable({
    		"dom": 'lfBrtip',
					  "buttons": ['excel','print'],
        "processing": true,
        "serverSide": true,
        "ajax": {
        	"url" : url + "income/ajx_data",
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
					}<?php if(!CheckPermission("income", "all_delete") && !CheckPermission("income", "own_delete")){ ?>
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
      table = $("#example_income").DataTable({
      	"dom": 'lfBrtip',
					  "buttons": ['excel','print'],
        "processing": true,
        "serverSide": true,
      	"ajax": {
          "url" : url + "income/ajx_data",
          "data": function ( d ) {
                d.dateRange = dateRange;
                d.columnName = "income_date";
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
						"orderable": false,
						"targets": [0]
					}<?php if(!CheckPermission("income", "all_delete") && !CheckPermission("income", "own_delete")){ ?>
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
		$('#nameModal_income').find('input[name="save"]').after('<span class="mka-loading"><img src="<?php echo mka_base().'assets/images/widget-loader-lg.gif'; ?>" alt="" /><span>');
		var formData = new FormData($(this)[0]);
		$.ajax({
			url: '<?php echo base_url().'income/add_edit' ?>',
			method: 'POST',
			async: false,
			data: formData,
			cache: false,
        	contentType: false,
        	processData: false
		}).done(function(mka) {
			if(mka > 0) {
				$('#nameModal_income').modal('hide');
				setTimeout(function() {
					if($('.submodule-main-div').length > 0) {
				            $('.custom-tab').each(function() {
				            	if($(this).hasClass('active')) {
				            		$(this).trigger('click');
				            	}
				            })
					} else {
				       // $('#example_income').DataTable().ajax.reload();
				        var  datatbale_name = $("#example_income").DataTable() ;
                         datatbale_name.ajax.reload(null, false );
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
						$('#example_income').DataTable().ajax.reload();
					}
				});
			});
			showNotification('<?php echo lang('records_deleted_successfully'); ?>.', 'success');
		}, 'json');
	});



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
	<?php if(CheckPermission("income", "all_delete") || CheckPermission("income", "own_delete")){ ?>
		cjhk = 1;
	<?php } ?>
	setTimeout(function() {
		var add_width = $('.dataTables_filter').width()+$('.box-body .dt-buttons').width()+10;
		//$('.table-date-range').css('right',add_width+'px');

		if(cjhk == 1) {
			$('.dataTables_info').before('<button data-del-url="<?php echo base_url() ?>income/delete/" rel="delSelTable" class="btn btn-default btn-sm delSelected pull-left"> <i class="material-icons col-red">delete</i> </button><br><br>');
		}
	}, 300);


	$("body").on("click",".modalButton", function(e) {
		var loading = '<img src="<?php echo mka_base() ?>assets/images/loading.gif" />';
		$("#nameModal_income").find(".modal-body").html(loading);
		$("#nameModal_income").find(".modal-body").attr("style","text-align: center");
		$.ajax({
			url : "<?php echo base_url()."income/get_modal";?>",
			method: "post",
			data : {
			id: $(this).attr("data-src")
			}
			}).done(function(data) {
			$("#nameModal_income").find(".modal-body").removeAttr("style");
			$("#nameModal_income").find(".modal-body").html(data);
			$("#nameModal_income").modal("show");
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
});
} ) ( jQuery );
</script>
