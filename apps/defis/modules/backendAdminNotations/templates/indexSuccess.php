<?php include_once(MOD_ROOT . '/helpers.php'); ?>
<?php slot('title', $slotTitle)?>
<?php slot('lng', $slotLng)?>
<div class="contentWrapper" style="text-align: justify; ">
	<h1>Liste des candidatures à évaluer</h1>
	<ul>
	<?php foreach($mem as $m): ?>
		<li><?php echo link_to($m['pseudo'], 'evalPerHangmanAdm', array('id' => $m['id'])); ?></li>
	<?php endforeach; ?>
	</ul>
</div>