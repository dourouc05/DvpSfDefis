<?php
include_once(MOD_ROOT . '/helpers.php');
$vars = array('forum' => 'none'); 
?>
<?php slot('title', $slotTitle)?>
<?php slot('lng', $slotLng)?>
<div class="contentWrapperLarge" style="text-align: justify; ">
	<h1><?php echo $oldT; ?></h1>
	<?php echo sqlLinks(format($presC), $vars); ?>
	<?php foreach($defis as $number => $defi): ?>
		<h2><?php echo link_to($defi['name'], url_for('@oneChallenge?number=' . $number)); ?></h2>
		<?php echo format($defi['desc']); ?>
	<?php endforeach; ?>
</div>