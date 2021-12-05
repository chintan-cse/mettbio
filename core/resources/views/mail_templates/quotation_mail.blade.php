<!DOCTYPE html>
<html>
<head>
<!-- If you delete this tag, the sky will fall on your head -->
<meta charset="utf-8">
<title>Mailer</title>
<style>
body{color: #4e4d4d; background-color: #f9f9f9; margin: 0; padding: 0; overflow-x: hidden; font-family: sans-serif;}
table {width: 100%; table-layout: fixed;  word-wrap:break-word}
td, th {padding:10px;}
th {background: #F9F9F9; border-bottom: solid 1px #ccc; font-size: 13px;}
.bordered-table td {border-bottom: solid 1px #ccc;}

</style>
</head>

<body>

<!-- BODY -->
<table border="0" cellspacing="0" cellpadding="0" align="center" width="100%;" style="border: solid 1px #ccc;">
	<tr align="center">
		<td style="background: #ffffff; padding: 20px; border-bottom:1px solid #ccc; width: 100%;">
			<img src="{{ asset('images/logo.jpg') }}" width="120" style="display:inline-block;">
			<p style="margin: 0; margin-top: 2px;"><b>Precision Glass Industries</b></p>
			<p style="margin: 0;">2330 Peyton Road | Houston TX 77302</p>
			<p style="margin: 0;">P:281-671-5221 | F:281-783-2720</p>
		</td>
	</tr>
	<tr align="center">
		<td style="padding:0px; width: 100%; box-sizing: border-box; background: #f9f9f9; padding-bottom: 0;">
			<table width="100%" border="0" cellspacing="10" cellpadding="10">
			  <tbody>
			  	<tr align="center">
				  <td style="border: solid 1px #ccc;text-align: center; background: #fff; padding: 0;">
					<table width="100%" border="0" cellpadding="0" cellspacing="0">
					  <tbody>
                        <tr><td width="50%" style="color: #434549;">Job Reference: <span><b style="color: #0d4e61;">{{$quotedata->ref_no}}</b></span></td>
                            <td width="50%" style="color: #434549;">PO Name: <span><b style="color: #0d4e61;">{{$quotedata->po_name}}</b></span></td></tr>
						
                        <tr><td width="50%" style="color: #434549;">Phone Number: <span><b style="color: #0d4e61;">{{$quotedata->quote_phonenumber}}</b></span></td>
                            <td width="50%" style="color: #434549;">Delivery Date: <span><b style="color: #0d4e61;">@if(isset($quotedata->deliverydate) && $quotedata->deliverydate != "") {{ date('m/d/Y', strtotime($quotedata->deliverydate)) }} @endif</b></span></td></tr>
						
                        <tr><td width="50%" style="color: #434549;">Address: <span><b style="color: #0d4e61;">{{$quotedata->quote_address}}</b></span></td>
                            <td width="50%" style="color: #434549;">Delivery Method: <span><b style="color: #0d4e61;">@if(isset($quotedata->quote_deliverymethod->name) && $quotedata->quote_deliverymethod->name != "") {{$quotedata->quote_deliverymethod->name}} @endif</b></span></td></tr>
						
					  </tbody>
					</table>
				  </td>
				</tr>
				</tbody>
				</table>
				</td>
	</tr>
	<tr>
		<td style="width: 100%; box-sizing: border-box; background: #f9f9f9; padding-left: 10px; padding-right: 10px;">
			Precision Glass Industries is pleased to present this quote for the glass products identified. Below specifications are suggested based on glass and glazing industry standards, but are not intended to be complete. A qualified Architect or an Engineer should verify suitability of the product, and its specifications for the project being considered. Precision Glass Industries is not responsible for the specifications to be suitable for the intended application.
		</td>
	</tr>
	
	<tr align="center">
		<td style="padding:10px; width: 100%; box-sizing: border-box; background: #f9f9f9; padding-bottom: 0;">
			<table width="100%" border="0" cellpadding="10" style="border-collapse: collapse;">
			  <tbody>
				
				<tr align="center">
				  <td style="border: solid 1px #ccc; border-bottom: none;text-align: center; background: #fff; padding: 0;">
				  	<table width="100%" border="0"   class="bordered-table" style="border-collapse: collapse;">
					  <tbody>
						<tr>
							<th style="color: #0d4e61;">Glass Type</th>
							<th style="color: #0d4e61;">Qty</th>
							<th style="color: #0d4e61;">Width (in)</th>
							<th style="color: #0d4e61;">Height (in)</th>
							<th style="color: #0d4e61;">Hinge</th>
							<th style="color: #0d4e61;">Hole</th>
							<th style="color: #0d4e61;">Clips</th>
							<th style="color: #0d4e61;">Miter</th>
							<th style="color: #0d4e61;">Out of Square</th>
                            <th style="color: #0d4e61;">Six Shield</th>
						</tr>
						</tbody>
						</table>
						</td>
				</tr>
				</tbody>
				</table>
				</td>
	</tr>
						@foreach($panel_outputs as $value)
							@foreach($value as $data)
							<tr align="center">
								<td style="padding:10px; width: 100%; box-sizing: border-box; background: #f9f9f9; padding-bottom: 0; padding-top: 0;">
									<table width="100%" border="0" style="border-collapse: collapse;">
									  <tbody>
										
										<tr align="center">
										  <td style="border: solid 1px #ccc;text-align: center; background: #fff; padding: 0;">
											  <table width="100%" border="" cellpadding="10" cellspacing="10"  class="bordered-table" style="border-collapse: collapse;">
											  <tbody>
								<tr style="border-bottom: solid 1px #ccc;">
									<td style="text-align: center;">{{$data['glasstype']}}</td>
									<td style="text-align: center;">{{count($value)}}</td>
									<td style="text-align: center;">{{$data['width']}}</td>
									<td style="text-align: center;">{{$data['height']}}</td>
									<td style="text-align: center;">
										@if($data['hinges'] && $data['hinges'] != "")
											{{$data['hinges']}}
										@else
											--
										@endif
									</td>
									<td style="text-align: center;">
										@if($data['holes'] && $data['holes'] != "")
											{{$data['holes']}}
										@else
											--
										@endif
									</td>
									<td style="text-align: center;">
										@if($data['clips'] && $data['clips'] != "")
											{{$data['clips']}}
										@else
											--
										@endif
									</td>
									<td style="text-align: center;">
										@if($data['milter'] && $data['milter'] != "")
											@if($data['milter'] == 'no')
												No
											@else
												{{$data['milter']}}
											@endif
										@else
											--
										@endif
									</td>
									<td style="text-align: center;">
										@if($data['outofsquare'] && $data['outofsquare'] != "")
											{{$data['outofsquare']}}
										@else
											--
										@endif
									</td>
									<td style="text-align: center;">
										@if($data['sixshield'] && $data['sixshield'] != "")
											Yes
										@else
											No
										@endif
									</td>
								</tr>
							</tbody>
						</table>
						</td>
				</tr>
				</tbody>
				</table>
				</td>
	</tr>
							@endforeach
						@endforeach

						<tr align="center">
							<td style="padding:10px; width: 100%; border:0; box-sizing: border-box; background: #f9f9f9; padding-bottom: 0; padding-top: 0;">
								<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
								  <tbody>
									  <tr align="center">
									  <td style="border: solid 1px #ccc;text-align: center; background: #fff; padding: 0;">
										<table width="100%" border="0" cellpadding="10" cellspacing="10" class="bordered-table" style="border-collapse: collapse;">
										  <tbody>

						@if(isset($extrapanel_outputs) && !empty($extrapanel_outputs))
							@foreach($extrapanel_outputs as $extravalue)
									
									<tr style="border-bottom: solid 1px #ccc;">
										<td style="text-align: center;">{{$extravalue['glasstype']}}</td>
										<td style="text-align: center;">1</td>
										<td style="text-align: center;">{{$extravalue['width']}}</td>
										<td style="text-align: center;">{{$extravalue['height']}}</td>
										<td style="text-align: center;">
											@if($extravalue['hinges'] && $extravalue['hinges'] != "")
												{{$extravalue['hinges']}}
											@else
												--
											@endif
										</td>
										<td style="text-align: center;">
											@if($extravalue['holes'] && $extravalue['holes'] != "")
												{{$extravalue['holes']}}
											@else
												--
											@endif
										</td>
										<td style="text-align: center;">
											@if($extravalue['clips'] && $extravalue['clips'] != "")
												{{$extravalue['clips']}}
											@else
												--
											@endif
										</td>
										<td style="text-align: center;">
											@if($extravalue['milter'] && $extravalue['milter'] != "")
												@if($extravalue['milter'] == 'no')
													No
												@else
													{{$extravalue['milter']}}
												@endif
											@else
												--
											@endif
										</td>
										<td style="text-align: center;">
											@if($extravalue['outofsquare'] && $extravalue['outofsquare'] != "")
												{{$extravalue['outofsquare']}}
											@else
												--
											@endif
										</td>
										<td style="text-align: center;">
											@if($extravalue['sixshield'] && $extravalue['sixshield'] != "")
												Yes
											@else
												No
											@endif
										</td>
									</tr>
							@endforeach
						@endif
					  </tbody>
					</table>
				  </td>
				</tr>
				</tbody>
				</table>
				</td>
	</tr>
	<tr align="center">
		<td style="padding:0px; width: 100%; box-sizing: border-box; background: #f9f9f9; padding-bottom: 0;">
			<table width="100%" border="0" cellspacing="10" cellpadding="10">
			  <tbody>
				<tr align="center">
					<td style="padding: 0; border-left: solid 1px #ccc; border-right: solid 1px #ccc; border-top: solid 1px #ccc; border-bottom: solid 1px #ccc; overflow: auto;">
						<table width="100%" border="0" cellspacing="10" cellpadding="10" class="bordered-table inlinerow" style="border-collapse: collapse;" bgcolor="#fff">
						  <tbody style="overflow: auto;">
							@if(isset($hardware_details) && !empty($hardware_details))
								<tr>
								  <th align="left" style="color: #0d4e61;">Hardware</th>
								  <th style="color: #0d4e61;">Quantity</th>
								</tr>
								@foreach($hardware_details as $hardware)
									<tr>
									  <td>{{$hardware['hardwareitemname']}}</td>
									  <td align="center">{{$hardware['hardwarequantity']}}</td>
									</tr>
								@endforeach
							@endif
						  </tbody>
						</table>

					</td>
				</tr>
				</tbody>
				</table>
				</td>
			</tr>
			<tr align="center">
				<td style="padding:0px; width: 100%; box-sizing: border-box; background: #f9f9f9; padding-bottom: 0;">
					<table width="100%" border="0" cellspacing="10" cellpadding="10">
					  <tbody>
				<tr align="center">
					<td style="padding: 0; border-left: solid 1px #ccc; border-right: solid 1px #ccc; border-top: solid 1px #ccc; border-bottom: solid 1px #ccc; overflow: auto;">
						<table width="100%" border="0" cellspacing="10" cellpadding="10" class="bordered-table inlinerow" style="border-collapse: collapse;" bgcolor="#fff">
							<tbody style="overflow: auto;">
								<tr>
                                
									<td align="right" style="color: #0d4e61; background: #f9f9f9; width: 65%;"></td>
									<td align="center" style="color: #0d4e61; background: #f9f9f9;"><strong>Total Price :- &nbsp;</strong><strong>${{$finalprice}}</strong></td>
								  </tr>
							</tbody>
						</table>
					</td>
				</tr>
				
			  </tbody>
			</table>

		</td>
	</tr>
	<tr>
		<td style="padding: 10px; padding-top: 0px; padding-bottom: 20px;">
			<table width="100%" border="0" cellspacing="10" cellpadding="10" bgcolor="#fff" style="border: 1px solid #ccc; padding: 20px 0;">
			  <tbody>
				<tr>
					<td style="padding: 0 10px;"><span><b style="color: #0d4e61;">Notes:</b></span>{{$note}}</td>
				  </tr>
				<tr>
				  <td style="padding: 0 10px;"><span><b style="color: #0d4e61;">Comments:</b></span> All quotes are valid for 30 days unless specified. Turnaround time for quotes is typically within 1 working day. Please contact your account manager for any urgent requests for quotes. If you purchase less than the amount stated in quote, Precision Glass Industries reserves the right to increase the prices quoted in this letter. Precision Glass Industries is prepared to sell at least the quantities listed above to you, but if your needs become significantly greater please contact us to confirm availability.</td>
				</tr>
				<tr><td style="padding: 0 10px;"><span><b style="color: #0d4e61;">Terms and Conditions:</b></span></tr>
					<tr><td style="padding: 0 10px;">
						<ul style="margin: 0;">
							<li>Price includes local delivery (75- mile radius) unless noted otherwise.</li>
							<li>For any unit measuring more than 50 square feet, a pricing upcharge will be added. Any unit greater than 50 square feet will have no warranty.</li>
							<li>For oversized units please request a quote from PGI or your Account Manager</li>
							<li>Oversized units will have increased amount of distortion and waves</li>
							<li>Minimum charge for 3 square feet/Lite for all products</li>
						</ul>
					</td></tr>
				<tr>
					<td style="padding:0 10px;"><span><b style="color: #0d4e61;">Damaged Glass:</b></span> Glass received damaged at delivery will be remade at no charge.</td>
				</tr>
				<tr>
					<td style="padding:0 10px;"><span><b style="color: #0d4e61;">Customer Supplied Glass:</b></span> For Customer supplied glass, we are not responsible for damage of any kind during fabrication.</td>
				</tr>
				<tr>
					<td style="padding:0 10px;"><span><b style="color: #0d4e61;">Wrong size glass:</b></span> If the glass measures as ordered, there will be a charge associated to remake it. In the event we have made a mistake, we will remake the glass at no charge. The glass must be sent back to us for credit. Prices are quoted based on information submitted for quote and may change if actual job requirements vary.</td>
				</tr>
				<tr>
					<td style="padding:0 10px;"><span><b style="color: #0d4e61;">Payment Terms:</b></span> Payment terms will be as provided on Precision Glass Industries invoice and/or order confirmation. Precision Glass Industries may change payment terms at any time on reasonable notice.</td>
				</tr>
				<tr>
					<td style="padding:0 10px;"><span><b style="color: #0d4e61;">Patterns and Out of Square Units:</b></span> Any unit that is out of square, has a rake head, or any other non-90-degree corner, will be assessed an additional charge of $20 per unit.</td>
				</tr>
				<tr>
					<td style="padding:0 10px; font-style: italic;">This Quote does not constitute an offer. A binding contract will arise only when PGI confirms the customer’s order or begins execution of the customer’s order. By submitting a purchase order in response to this quote, customer agrees to all of the provisions of the terms and conditions located at <a href="http://quotes.precisionglassindustries.com/terms_and_conditions" target="_blank">Precision Glass Industries T&C</a> and represents and warrants to PGI that it has carefully reviewed this entire form, including the disclaimer of warranties.</td>
				</tr>
				<tr>
					<td style="padding:0 10px;">Please feel free to <a href="http://precisionglass.wpengine.com/contact/" target="_blank" class="">contact us</a> with any questions you might have. On behalf of everyone at Precision Glass Industries, we thank you for this opportunity to bid your project.</td>
				</tr>
			  </tbody>
			</table>

		</td>
	</tr>
</table>
<!-- /BODY -->

</body>
</html>