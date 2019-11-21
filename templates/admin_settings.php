<div class="wrap">
	<h3>Product Feed settings</h3>
	<form action="" method="post">
		<input type="hidden" name="garp_erp_api_settings_submit" value="set" />
		<table class="widefat fixed border bordered" cellspacing="0">
			<thead>
				<tr>
					<th width="20%">Setting Name</th>
					<th width="80%">Setting Value</th>
				</tr>
			</thead>
			<tbody>				
				<tr>
					<td>Number of products to show</td>
					<td><input style="width: 100%" type="number" min="0" name="number_of_products_to_show" value="<?php echo $number_of_products_to_show ?>" /></td>
				</tr>
				<tr>
					<td align="center" colspan="2"><button class="button button-primary" type="submit">Submit</button></td>
				</tr>
			</tbody>
		</table>
	</form>	
</div>