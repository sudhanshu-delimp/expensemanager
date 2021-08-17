<!-- start: PAGE CONTENT -->
    <section class="content">
		<div class="container-fluid">
		<!-- Main content -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
						<div class="header">
                           <h2><?php echo lang('client_management') ?></h2>
                              <ul class="header-dropdown">
                                 <?php if(CheckPermission("client_management", "own_create")){ ?>
                                 <button type="button" class="btn-sm  btn btn-primary waves-effect amDisable modalButton" data-src="" data-width="555" ><i class="material-icons">add</i><?php echo lang('add_client') ?></button>
                              <?php }?>
                              </ul>
                            </div>
                 	 <!-- /.box-header -->
                     <div class="body table-responsive">
<table id="example_client_management" class="table table-bordered table-striped table-hover delSelTable example_client_management">
								  <thead>
								 	<tr>
										<th>
											<input type="checkbox" class="selAll" id="basic_checkbox_1mka" />
                    						<label for="basic_checkbox_1mka"></label>
                    					</th>
<th><?php echo lang('client_name') ?></th>
<th><?php echo lang('description') ?></th>
<th><?php echo lang('status') ?></th>
<th><?php echo lang('added_by') ?></th>

									
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

<div class="modal fade" id="nameModal_client_management"  role="dialog"><!-- Modal Crud Start-->
	<div class="modal-dialog">
		<div class="modal-content" >
			<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				  <h4 class="box-title"><?php echo lang('client_management'); ?></h4>
			</div>
			<div class="modal-body"></div>
		</div>
	</div>
</div><!--End Modal Crud -->

<script type="text/javascript">
jQuery(document).ready(function() { 
	var url = "<?php echo base_url();?>";
var table = $("#example_client_management").DataTable({
    		
        "processing": true,
        "serverSide": true,
        "ajax": {
        	"url" : url + "client_management/ajx_data",
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
					}<?php if(!CheckPermission("client_management", "all_delete") && !CheckPermission("client_management", "own_delete")){ ?>
					,{
            "targets": [0],
            "visible": false,
            "searchable": false
          }
          <?php } ?>
				],
				"order": [[1, 'asc']],
    });

		$(".daterange-filter").on("change", function() {
      table.destroy();
      var dateRange = $(this).val();
      table = $("#example_client_management").DataTable({
      	
        "processing": true,
        "serverSide": true,
      	"ajax": {
          "url" : url + "client_management/ajx_data",
          "data": function ( d ) {
                d.dateRange = dateRange;
                d.columnName = "";
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
					}<?php if(!CheckPermission("client_management", "all_delete") && !CheckPermission("client_management", "own_delete")){ ?>
					,{
            "targets": [0],
            "visible": false,
            "searchable": false
          }
          <?php } ?>
				],
				"order": [[1, 'asc']],
      });
    });

	
	$('body').off('submit', '#form');
	$('body').on('submit', '#form', function(ev) {
		var client_name = $('#name').val();
		var str = client_name.trim();
		if(str==''){
			alert('Please fill the client name.');
			return false;
		}
		ev.preventDefault();
		$('#nameModal_client_management').find('input[name="save"]').after('<span class="mka-loading"><img src="<?php echo mka_base().'assets/images/widget-loader-lg.gif'; ?>" alt="" /><span>');
		var formData = new FormData($(this)[0]);

		$.ajax({
			url: '<?php echo base_url().'client_management/checkClientName' ?>',
			method: 'POST',
			async: false,
			data: formData,
			cache: false,
        	contentType: false,
        	processData: false
		}).done(function(mka) {
			if(mka=='false'){
               alert('This client name already exist.');
               return false;
			}else{
                   $.ajax({
					url: '<?php echo base_url().'client_management/add_edit' ?>',
					method: 'POST',
					async: false,
					data: formData,
					cache: false,
		        	contentType: false,
		        	processData: false
				}).done(function(mka) {
					if(mka > 0) {
						$('#nameModal_client_management').modal('hide');
						setTimeout(function() {
							if($('.submodule-main-div').length > 0) {
						            $('.custom-tab').each(function() {
						            	if($(this).hasClass('active')) {
						            		$(this).trigger('click');
						            	}
						            })
							} else {
						        $('#example_client_management').DataTable().ajax.reload();
						        showNotification('<?php echo lang('your_action_has_been_completed_successfully'); ?>.', 'success');
							}
						}, 300);
					}
				});
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
						$('#example_client_management').DataTable().ajax.reload();
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
	<?php if(CheckPermission("client_management", "all_delete") || CheckPermission("client_management", "own_delete")){ ?>
		cjhk = 1;
	<?php } ?>
	setTimeout(function() {
		var add_width = $('.dataTables_filter').width()+$('.box-body .dt-buttons').width()+10;
		//$('.table-date-range').css('right',add_width+'px');

		if(cjhk == 1) {
			$('.dataTables_info').before('<button data-del-url="<?php echo base_url() ?>client_management/delete/" rel="delSelTable" class="btn btn-default btn-sm delSelected pull-left"> <i class="material-icons col-red">delete</i> </button><br><br>');	
		}
	}, 300);


	$("body").on("click",".modalButton", function(e) {  
		var loading = '<img src="<?php echo mka_base() ?>assets/images/loading.gif" />';
		$("#nameModal_client_management").find(".modal-body").html(loading);
		$("#nameModal_client_management").find(".modal-body").attr("style","text-align: center");    
		$.ajax({
			url : "<?php echo base_url()."client_management/get_modal";?>",
			method: "post", 
			data : {
			id: $(this).attr("data-src")
			}
			}).done(function(data) {
			$("#nameModal_client_management").find(".modal-body").removeAttr("style");  
			$("#nameModal_client_management").find(".modal-body").html(data);
			$("#nameModal_client_management").modal("show");
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
