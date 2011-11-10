<?php include_once(MOD_ROOT . '/helpers.php'); ?>
<?php slot('title', $slotTitle)?>
<?php slot('lng', $slotLng)?>
<div class="contentWrapperLarge" style="text-align: justify; ">
	<h1><?php echo $title; ?></h1>
	<p>
		<?php echo sqlLinks(format($intro)); ?>
	</p>
	<ul>
		<?php foreach($jury as $m): ?>
			<li>
				<?php echo link_to($m['pseudo'], 'http://www.developpez.net/forums/u' . $m['id'] . '/' . $m['pseudo'] . '/'); ?>
			</li>
		<?php endforeach; ?>
	</ul>
</div>