<?php slot('title', $slotTitle)?>
<?php slot('lng', $slotLng)?>
<div class="contentWrapper" style="text-align: justify; ">
<?php if($showForm): ?>
	<form action="<?php echo url_for('@deposit') ?>" method="POST" enctype="multipart/form-data">
		<table cellpadding="0" cellspacing="5px" border="0" align="center">
			<tr>
				<td><label for="file_name"><?php echo $sFile; ?></label></td>
				<td><input type="file" name="file_name" id="file_name" size="30"/></td>
			</tr>
			<tr>
				<td><input type="checkbox" name="agree" id="agree" /></td>
				<td><label for="agree"><?php echo link_to($sRulesread, 'rules'); ?></label></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" name="upload" value="<?php echo $sSend; ?>"></td>
			</tr>
		</table>
	</form>
	<table>
		<tr>
			<td>
				<img src="http://www.developpez.be/images/kitinfo.gif" alt="info"/>
			</td>
			<td>
				<?php echo $sMaxsize; ?> 2 Mio. 
			</td>
		</tr>
	</table>
	<table>
		<tr>
			<td>
				<img src="http://www.developpez.be/images/kitwarning.gif" alt="warning"/>
			</td>
			<td>
				<?php echo $sWarning; ?>
			</td>
		</tr>
	</table>
<?php else: ?>
	<?php if($error): ?>
		<?php if($already): ?>
			<table>
				<tr>
					<td>
						<img src="http://www.developpez.be/images/kitwarning.gif" alt="warning"/>
					</td>
					<td>
						<?php echo $sAlreadysent; ?>
					</td>
				</tr>
			</table>
		<?php elseif($rules): ?>
			<table>
				<tr>
					<td>
						<img src="http://www.developpez.be/images/kitwarning.gif" alt="warning"/>
					</td>
					<td>
						<?php echo $sAcceptmyrulesordieyoumoron; ?> 
					</td>
				</tr>
			</table>
		<?php else: ?>
			<table>
				<tr>
					<td>
						<img src="http://www.developpez.be/images/kitwarning.gif" alt="warning"/>
					</td>
					<td>
						<?php echo $sError; ?>
					</td>
				</tr>
			</table>
		<?php endif; ?>
	<?php else: ?>
		<table>
			<tr>
				<td>
					<img src="http://www.developpez.be/images/kitinfo.gif" alt="info"/>
				</td>
				<td>
					<p>
						<?php echo $sFilesent; ?>
					</p>
					<p>
						<?php echo $sThanks; ?>
					</p>
				</td>
			</tr>
		</table>
	<?php endif; ?>
<?php endif; ?>
</div>