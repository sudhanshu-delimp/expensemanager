<?php
$dataArray =  (array) $data;

$clientArray =  (array) $client;

$taxPercentAge = $dataArray['taxBoxPercent'];

$clientInfo = $dataArray['clientInfo'];
$dataClientInfo = json_decode($clientInfo);
$arrayClientInfo = (array)$dataClientInfo;

$datajsonatonce =  (array) $dataArray['datajsonatonce'];
$datajsonatonce = json_decode(reset($datajsonatonce));

$datajsonmonth =  (array) $dataArray['datajsonmonth'];
$datajsonmonth1 = json_decode(reset($datajsonmonth));

$datajsonhourArray =  (array) $dataArray['datajsonhour'];
$datajsonhourArray1 = json_decode(reset($datajsonhourArray));
$addHourPriceTotal=0;
$addMonthPriceTotal=0;
$addAtOncehPriceTotal=0;
$invoice_currency = $dataArray['invoice_currency'];

$da = strtotime($dataArray['invoice_date']);
 $dat = date('Y-m-d', $da);

if (!empty($arrayClientInfo)) {

}else{

}
?>

<div class="invoice-pdf-main-containor" style="">
	<div class="invoice-pdf-imag">
		<img src="https://www.delimp.com/wp-content/uploads/2019/03/delimp_logosmall.png">
	</div>
	<div class="invoice-pdf-title">
		<h2 class="text-center">Invoice</h2>
		<h3><?php echo $client1; ?></h3>
	</div>
	<div class="invoice-info-main">
		<table>
			<thead>
				<tr>
					<th>From:</th>
					<th style="text-align: right;">To:</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><p>Delimp Technology Pvt. Ltd.</p>
						<p>A15, Sector 3</p>
						<p>Noida-201301</p>
						<p><?php echo 'India' ?></p><p>GST No: 07AAHCD0070H1ZY</p></td>

						<?php if (!empty($arrayClientInfo)) { ?>
							<td style="text-align: right;">
								<?php if (!empty($arrayClientInfo['client_name'])) { ?>
								<p><?php echo $arrayClientInfo['client_name']; ?></p>
								<?php } ?>

								<?php if (!empty($arrayClientInfo['company_name'])) { ?>
								<p><?php echo $arrayClientInfo['company_name']; ?></p>
								<?php } ?>

								<?php if (!empty($arrayClientInfo['company_address'])) { ?>
								<p><?php echo $arrayClientInfo['company_address']; ?></p>
								<?php } ?>

								<?php if (!empty($arrayClientInfo['gst_num'])) { ?>
								<p>GST No: <?php echo $arrayClientInfo['gst_num']; ?></p>
								<?php } ?>
							</td>
						<?php }else{ ?>
						<td style="text-align: right;">
							<p><?php echo $clientArray['name']; ?></p>
							<p><?php echo $clientArray['company_name']; ?></p>
							<p>GST No: <?php echo $clientArray['company_gst']; ?></p>
						</td>
						<?php } ?>
						</tr>
					</tbody>
				</table>

			</div>
				<div class="invoice-date-holder">
					<p><b>Date: <?php echo $dat; ?></b> <br>
					<b><?php echo $dataArray['invoice_no']; ?></b></p>
				</div>
				<div>
	<?php
		?>
		<div class="hourly-rate-description table-design-col">
			<!-- <h2>Hourly Work</h2> -->
			<table class="invoice-data-table" style="width:100%">
				<thead>
					<tr style="background:#27a9e1;color: #fff;padding: 5px 0px ;">
						<th style="width: 40%" class="description">Description</th>
						<th style="width: 20%"class="pr-he">Price</th>
						<th style="width: 20%"class="no-pri">Qty/Hours</th>
						<th style="width: 20%"class="tot-pri">Amount</th>
					</tr>
				</thead>
				<?php if ($datajsonhourArray1) { ?>
				<?php
				foreach ($datajsonhourArray1 as $datajsonhourArray1Data) {
					$datajsonhourArray1DataObj = (array) $datajsonhourArray1Data;
					$addHourPriceTotal =$addHourPriceTotal + $datajsonhourArray1DataObj['totalPrice'];
					?>
					<tbody>
						<tr>
							<td style="padding: 10px 15px 5px;"><?php echo $datajsonhourArray1DataObj['itemDiscription'] ?></td>
							<td style="padding: 5px 15px;"><?php echo $invoice_currency.' '.$datajsonhourArray1DataObj['perHourRate'] ?></td>
							<td style="padding: 5px 15px;"><?php echo $datajsonhourArray1DataObj['qty_per_hours'] ?></td>
							<td style="padding: 5px 15px;"><?php echo $invoice_currency.' '.$datajsonhourArray1DataObj['totalPrice'] ?></td>
						</tr>
					</tbody>
				<?php }
				?>
				<?php }

				?>
				<?php if ($datajsonmonth1) {
					?>
					<!-- <h2>Monthly Work</h2> -->

					<?php foreach ($datajsonmonth1 as $datajsonmonthData) {
						$datajsonmonthData = (array) $datajsonmonthData;
						$addMonthPriceTotal =$addMonthPriceTotal + $datajsonmonthData['monthly_charge_text_total'];
						?>
						<br>
						<tr class="info-invoice-data-holder" style="margin-top: 20px;">
							<td style="padding: 10px 15px 5px;" class="formt-list"><?php echo $datajsonmonthData['itemDiscription'] ?></td>
							<td style="padding: 5px 15px;" class="formt-list"><?php echo $invoice_currency.' '.$datajsonmonthData['monthly_charge_text'] ?></td>
							<td style="padding: 5px 15px;" class="formt-list"><?php echo $datajsonmonthData['no_of_months'] ?></td>
							<td style="padding: 5px 15px;" class="formt-list"><?php echo $invoice_currency.' '.$datajsonmonthData['monthly_charge_text_total'] ?></td>
						</tr>
					<?php } ?>
				<?php 	}
					?>
					<!-- <br><br><br><br> -->

				<?php if ($datajsonatonce) { ?>
					<!-- <h2>Price At Once</h2> -->

					<?php foreach ($datajsonatonce as $datajsonatonceData) {
						$datajsonatonceData = (array) $datajsonatonceData;
						$addAtOncehPriceTotal = $addAtOncehPriceTotal + $datajsonatonceData['charge_atonce'];
						?>
						<tr class="info-invoice-data-holder">
							<td style="padding: 10px 15px 5px;"><?php echo $datajsonatonceData['itemDiscription'] ?></td>
							<td> </td>
							<td> </td>
							<td style="padding: 5px 15px;"><?php echo $invoice_currency.' '.$datajsonatonceData['charge_atonce'] ?></td>
						</tr>
					<?php } ?>
				<?php } ?>
			</table>
		</div>
	<?php  ?>


	<?php
	$totalAmountCalWithoutTax = $addHourPriceTotal + $addMonthPriceTotal + $addAtOncehPriceTotal;
	$taxAmountTotal = round(($taxPercentAge*$totalAmountCalWithoutTax/100),2);
	$totalAmountCalWithTax = $taxAmountTotal + $totalAmountCalWithoutTax;

	?>
</div>
				<div class="full-div-item-totals">
					<div class="subtotal-holder-tax text-right" style="line-height: 10px;">
						<div class="subtotal-amount-details" style='padding-right: 30px;'>
							<div class='col-md-6'><p class="cal-amount-proj">Sub Total:  <?php echo $invoice_currency.' '.$totalAmountCalWithoutTax ?></p></div>
							<!-- <div class='col-md-6'></div> -->
						</div>
						<div class="tax-amount-details" style='padding-right: 30px;'>
							<div class='col-md-6'> <p class="cal-amount-proj">Tax <?php echo'('. $taxPercentAge.'%):'?> <?php echo $invoice_currency.' '.$taxAmountTotal ?></p></div>
							<!-- <div class='col-md-6'></div> -->
						</div>
					</div>
					<div class="total-amount-details" style='padding-right: 30px;'>
						<div class='col-md-6'><p class="cal-amount-proj">Total: <?php echo $invoice_currency.' '.$totalAmountCalWithTax ?></p></div>
						<!-- <div class='col-md-6'></div> -->
					</div>
				</div>
				<div class="footer-bank-details">
					<div style="line-height: 9px;">
						<h4>Bank Detail</h4>
						<p>Account Name: Delimp Technology Private Limited</p>
						<p>Account Number: 347605500141</p>
						<p>Bank Name: ICICI Bank</p>
						<p>Branch: Central Market, Lajpat Nagar </p>
						<p>IFSC Code: ICIC0003476</p>
						<p>Swift Code: ICICINBBCTS</p>
					</div>
				</div>
				<br>
				<div class="contact-details" >
					<table>
						<tr>
							<td>
								<div class="ph-icon" style="float: left;margin-right: 15px;display: inline-block;">
									<img src="http://delimp.co.in/delimp_expense/assets/images/ph-icon.png" alt="" style="width: 30px;border: 1px solid;padding: 5px;">
								</div>
							</td>

							<td>
								<div class="ph-number" style="float: left;display: inline-block;">
									<p style="margin: 0;">+1 323 744 7666</p>
									<p style="margin: 0;">+91 750 360 5712</p>
								</div>
							</td>
						</tr>
					</table>

					<table>
						<tr>
							<td>
								<div class="ph-icon" style="float: left;margin-right: 15px;display: inline-block;">
									<img src="http://delimp.co.in/delimp_expense/assets/images/world.png" alt="" style="width: 30px;border: 1px solid;padding: 5px;">
								</div>
							</td>

							<td>
								<div class="ph-number" style="float: left;display: inline-block;">
									<p style="margin: 0;">www.delimp.com</p>
									<p style="margin: 0;">hr@delimp.com</p>
								</div>
							</td>
						</tr>
					</table>
				</div>

			</div>

			<style>


			/*.invoice-info-main {*/
				/*    display:block;*/
				/*    position: relative;*/

				/*}*/

				/*.invoice-info-main:before {*/
					/*    display:block;*/
					/*        position: absolute;*/
					/*        width:200px;*/
					/*        height:200px;*/
					/*        background:#000;*/

					/*}*/
					.cal-amount-proj{
						font-size: 14px !important;
						font-weight: 700 !important;
					}
					.text-center {
						text-align:center;
					}

					.row {
						display: -webkit-flex;
						display: -ms-flexbox;
						display: flex;
						-webkit-flex-wrap: wrap;
						-ms-flex-wrap: wrap;
						flex-wrap: wrap;
						margin-right: -15px;
						margin-left: -15px;
					}
					.col-md-6 {
						width:calc(100% / 2 - 10px);
					}
					.invoice-info-main table {
						width: 100%;
					}
					.invoice-info-main table thead th {
						text-align: left;
					}
					.invoice-info-main table  th {
						width: 50%;
						padding-left: 0px;
					}
					.invoice-info-main table tbody td {
						vertical-align: baseline;
						}.invoice-data-table thead th {
							text-align: left;
							padding: 10px 15px;
						}
						.table-design-col tr {
							border: 0;
							column-span: initial;
						}
						.table-design-col tr th.description {
							width: 50%;
						}
						.table-design-col tr th.pr-he {
							width: 13%;
						}
						.table-design-col tr th.no-pri {
							width: 13%;
						}
						.table-design-col thead {
							background: rgb(9, 122, 161);
							color: #fff;
							padding: 8px 0px;
						}
						.table-design-col table {
							border-collapse: collapse;
						}
						.table-design-col table tbody td {
							padding: 0 15px;
						}
						.table-design-col-2 tbody {
							background: rgb(9, 122, 161);
							color: #fff;
							padding: 8px 0px;
						}
						.table-design-col-2 table {
							border-collapse: collapse;
						}
						.table-design-col-2 tbody th {
							text-align: left;
							padding: 10px 15px;
						}
						.table-design-col-2 tbody th:last-child {
							width: 40%;
						}
						.table-design-col-2 tbody th:first-child {
							width: 60%;
						}
						body{
	/*background-image: url(../delimp_expense/assets/images/invice-bg.png);
	width: 100%;
	background-size: 100% 100%;
	background-repeat: no-repeat;
	position: relative;
	background-position: top right;*/
	background-image:    url(../delimp_expense/assets/images/invice-bg.png);
	background-size:    contain;
	background-repeat:   no-repeat;
	background-position: center center;
}
/*.invoice-data-table{
		border: 1px solid #8080804d;
		}*/
		.total-amount-details{
			margin:10px 0;
			text-align: right;
		}
		.text-right{
			text-align: right;
		}
		.subtotal-holder-tax{
			border-bottom: 3px solid #27a9e1;
			border-top: 3px solid #27a9e1;
			margin-top: 23px;
			line-height: 29px;
			padding: 20px 0;
		}
		.subtotal-holder-tax span,.total-amount-details span{
			display: inline-block;
			font-size: 20px;
			margin: 20px;
			display: inline-block;
		}
		.footer-bank-details p{
			font-size: 12px;
			font-weight: 400;
		}

	</style>

<!-- <style type="text/css">
	.invoice-pdf-title h2{
		text-align: center;
		text-transform: uppercase;
	}
	.invoice-info-left{
		line-height: 8px;
		float: left;
	}
	.invoice-info-right{
		line-height: 8px;
		float: right;
	}
	.invoice-pdf-main-containor{
		    display: grid;
	}
	.invoice-info-main{
		margin-bottom: 6px;
	}
	.invoice-date-holder{
		line-height: 8px;
	}
	.hourly-heading-invoice, .mounthly-heading-invoice, .atonce-heading-invoice{
		background: #2196F3;
	    color: white;
	    text-transform: uppercase;
	    line-height: 25px
	}
	.info-invoice-data-holder{
		background: #00000014;
	}
	.invoice-data-table{
		border: 1px solid #8080804d;
	}
	.full-div-item-totals{

	}
	.subtotal-holder-tax{
		border-bottom: 3px solid blue;
	    border-top: 3px solid blue;
	    margin-top: 23px;
	    line-height: 29px;
	}
	.total-amount-details{
		margin-top: 11px;
	}
	.footer-bank-details p{
		    margin: 0;
    line-height: 16px;
    font-size: 13px;
    color: black;
	}
	.footer-bank-details h4{
		text-decoration: underline;
    text-transform: uppercase;
    font-size: 16px;
    color: black;
	}
</style> -->
