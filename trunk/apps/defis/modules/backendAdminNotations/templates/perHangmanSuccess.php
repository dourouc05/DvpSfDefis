<?php include_once(MOD_ROOT . '/helpers.php'); ?>
<?php slot('title', $slotTitle)?>
<?php slot('lng', $slotLng)?>
<div class="contentWrapper" style="text-align: justify; ">
	<h1>Liste des évaluations de <?php echo $uname; ?></h1>
	<ul>
	<?php foreach($jurys as $j): ?>
		<li><?php echo link_to($j['pseudo'], 'evalOneAdm', array('id' => $id, 'hang' => $j['id'])); ?></li>
	<?php endforeach; ?>
	</ul>
</div>