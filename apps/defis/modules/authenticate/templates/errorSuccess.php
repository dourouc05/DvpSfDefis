<?php include_once(MOD_ROOT . '/helpers.php'); ?>
<?php slot('title', $slotTitle)?>
<?php slot('lng', $slotLng)?>
<div class="contentWrapper" style="text-align: justify; ">
	<?php echo sqlLinks(format($useyourdvpaccount)); ?>
	<?php echo sqlLinks(format($erroneous)); ?>
</div>