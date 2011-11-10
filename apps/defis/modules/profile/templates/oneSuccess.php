<?php include_once(MOD_ROOT . '/helpers.php'); ?>
<?php slot('title', $slotTitle)?>
<?php slot('lng', $slotLng)?>
<div class="contentWrapperTight" style="text-align: justify; ">
	<?php if(! $unknown): ?>
	<h1><?php echo $uname; ?></h1>
	<?php endif; ?>
	<?php echo utf8_encode(file_get_contents('http://www.developpez.com/ws/badge?user=' . $id)); ?>
</div>
<div class="clearSpace"></div>
<?php if(! $unknown): ?>
<div class="contentWrapperLarge" style="text-align: justify; ">
<?php if($now): ?>
	<h2><?php echo link_to($sPartCurr, 'presentation', array('id' => $now['id'])); ?></h2>
	<h3><?php echo $now['title']; ?></h3>
	<?php echo format($now['shortdescription']); ?>
<?php endif; ?>
<?php if(count($participations) > 0): ?>
	<h2><?php echo $sPartOlds; ?></h2>
	<ul>
	<?php foreach($participations as $p): ?>
		<li>
			<p>
				<h3><?php echo $p['title']; ?></h3>
			</p>
			<?php echo format($p['shortdescription']); ?>
		</li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>
<?php if ($authd && $mine): ?>
	<h2><?php echo $sAddress; ?></h2>
		<p>
			<?php echo $sAverto; ?>
		</p>
		<?php if($mem->getAddressName()): ?>
		<p>
			<?php echo $mem->getAddressName(); ?><br/>
			<?php echo $mem->getAddressStreet(); ?>,
			<?php echo $mem->getAddressNumber(); ?><br/>
			<?php echo $mem->getAddressPostcode(); ?>
			<?php echo $mem->getAddressCity(); ?><br/>
			<?php echo $mem->getAddressCountry(); ?><br/>
		</p>
		<?php endif; ?>
		<p>
			<?php echo link_to($sEdit, 'editProfile', array('id' => $id, 'pseudo' => $mem->getUsername())); ?>
		</p>
<?php endif; ?>
</div>
<?php endif; ?>





