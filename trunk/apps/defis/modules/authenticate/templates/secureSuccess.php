<?php include_once(MOD_ROOT . '/helpers.php'); ?>
<?php slot('title', $slotTitle)?>
<?php slot('lng', $slotLng)?>
<div class="contentWrapper" style="text-align: justify; ">
	<form method="post" action="http://www.developpez.net/forums/anologin.php">
		<table width="300" cellpadding="0" cellspacing="5px" border="0" align="center">
			<tr>
				<td colspan="2">
					<?php echo sqlLinks(format($trNAu)); ?>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<?php echo sqlLinks(format($trDvp)); ?>
				</td>
			</tr>
			<tr>
				<td align="right"><?php echo $trPsd; ?></td>
				<td><input type="text" name="pseudo"></td>
			</tr>
			<tr>
				<td align="right"><?php echo $trPwd; ?></td>
				<td><input type="password" name="motdepasse"></td>
			</tr>
			<tr>
				<td colspan="2" style="text-align: center">
					<input type="hidden" name="retour" value="<?php echo url_for('@connect', true); ?>">
					<input type="submit" name="connecter" value="<?php echo $trLog; ?>">
				</td>
			</tr>
		</table>
	</form>
</div>