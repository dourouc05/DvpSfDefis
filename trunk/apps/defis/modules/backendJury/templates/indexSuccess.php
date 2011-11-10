<?php include_once(MOD_ROOT . '/helpers.php'); ?>
<?php slot('title', $slotTitle)?>
<?php slot('lng', $slotLng)?>
<div class="contentWrapper" style="text-align: justify; ">
	<h1><?php echo $sTitle; ?></h1>
	<ul>
	<?php foreach($mem as $m): ?>
		<li><?php echo link_to($m['pseudo'], 'evalOne', array('id' => $m['id'])); ?></li>
	<?php endforeach; ?>
	</ul>
</div>