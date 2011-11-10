<?php include_once(MOD_ROOT . '/helpers.php'); ?>
<?php slot('title', $slotTitle)?>
<?php slot('lng', $slotLng)?>
<div class="contentWrapperLarge" style="text-align: justify; ">
	<?php echo format($intro); ?>
</div>
<div class="clearSpace"></div>
<?php if(! $unavailable): ?>
<?php $i = 0; ?>
<?php foreach($presentations as $pr): ?>
<div class="contentWrapper" style="align: right; ">
	<table>
		<tr>
			<td style="width: 295px;" rowspan="2" valign="middle"><?php echo link_to($pres, 'presentationView', array('id' => $pr['id'])); ?></td>
			<td style="width: 5px;" rowspan="2">&nbsp;</td>
			<td style="width: 200px;">
				<?php echo utf8_encode(file_get_contents('http://www.developpez.com/ws/badge?user=' . $pr['u'])); ?>
			</td>
			<td style="width: 5px;" rowspan="2">&nbsp;</td>
			<td style="width: 295px;" rowspan="2" valign="middle"><?php echo link_to($forum, $pr['fo']); ?></td>
		</tr>
		<tr>
			<td><?php echo format($pr['desc']); ?></td>
		</tr>
	</table>
</div>
<div class="clearSpace"></div>
<?php ++$i; ?>
<?php endforeach; ?>
<?php else: ?>
<div class="contentWrapper">
	<?php echo format($sUnavailable); ?>
</div>
<?php endif; ?>