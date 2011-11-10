<?php slot('title', $slotTitle)?>
<?php slot('lng', $slotLng)?>
<?php if($updated): ?>
<div class="contentWrapperTight" style="text-align: justify; ">
	<?php echo $sUpdated; ?>
</div>
<?php endif; ?>
<div class="contentWrapper" style="text-align: justify; ">
	<form action="<?php echo url_for('editProfile', array('id' => $id, 'pseudo' => $pseudo)); ?>" method="POST">
		<table style="width: 100%">
			<tfoot>
				<tr>
					<td colspan="2">
						<input type="submit" value="<?php echo $sSend; ?>" />
						<input type="hidden" name="id" value="<?php echo $id; ?>" id="id" />
					</td>
				</tr>
			</tfoot>
			<tbody>
				<tr>
					<th><label for="name"><?php echo $sName; ?></label></th>
					<td><input type="text" name="name" id="name" value="<?php echo $mem->getAddressName(); ?>"/></td>
				</tr>
				<tr>
					<th><label for="street"><?php echo $sStreet; ?></label></th>
					<td><input type="text" name="street" id="street" value="<?php echo $mem->getAddressStreet(); ?>"/></td>
				</tr>
				<tr>
					<th><label for="number"><?php echo $sNumber; ?></label></th>
					<td><input type="text" name="number" id="number" value="<?php echo $mem->getAddressNumber(); ?>"/></td>
				</tr>
				<tr>
					<th><label for="postcode"><?php echo $sPostcode; ?></label></th>
					<td><input type="text" name="postcode" id="postcode" value="<?php echo $mem->getAddressPostcode(); ?>"/></td>
				</tr>
				<tr>
					<th><label for="city"><?php echo $sCity; ?></label></th>
					<td><input type="text" name="city" id="city" value="<?php echo $mem->getAddressCity(); ?>"/></td>
				</tr>
				<tr>
					<th><label for="country"><?php echo $sCountry; ?></label></th>
					<td><input type="text" name="country" id="country" value="<?php echo $mem->getAddressCountry(); ?>"/>
				</tr>
			</tbody>
		</table>
	</form>
	<table class="infobulle" style="width: 98%; text-align: left; border:0;"><tr><td style="width: 40px; vertical-align: top;" class="colonne"><img src="http://www.developpez.be/images/kitinfo.gif" alt="info"/></td><td class="colonne">
		<?php echo $sWarningNoFormat; ?>
	</td></tr></table>
</div>