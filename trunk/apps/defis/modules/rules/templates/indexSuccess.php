<?php include_once(MOD_ROOT . '/helpers.php'); ?>
<?php slot('title', $slotTitle)?>
<?php slot('lng', $slotLng)?>
<div class="contentWrapperLarge" style="text-align: justify; ">
	<h1><?php echo $title; ?></h1>
	<?php echo format($content); ?>
</div>