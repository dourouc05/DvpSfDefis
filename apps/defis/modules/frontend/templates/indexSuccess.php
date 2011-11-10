<?php include_once(MOD_ROOT . '/helpers.php'); ?>
<?php slot('title', $slotTitle)?>
<?php slot('lng', $slotLng)?>
<div class="headerWrapper" style="text-align: center; ">
	<h1><?php echo $title; ?></h1>
	<table style="margin: auto; " >
		<tr>	
			<td>
				<?php echo link_to(image_tag($i1, array('alt' => $l1, 'style' => 'width: 200px;')), 'challengeView'); ?><br/>
				<?php echo $l1; ?>
			</td>
			<td>
				<?php echo link_to(image_tag($i3, array('alt' => $l2, 'style' => 'width: 200px;')), 'indexPresentations'); ?><br/>
				<?php echo $l2; ?>
			</td>
			<td>
				<?php echo link_to(image_tag($i3, array('alt' => $l3, 'style' => 'width: 200px;')), 'http://www.developpez.net/forums/f1378/c-cpp/bibliotheques/qt/defis-qt/'); ?><br/>
				<?php echo $l3; ?>
			</td>
		</tr>
	</table>
</div>
<div class="clearSpace"></div>
<table style="margin: auto; ">
	<tr>
	<?php if($pres): ?>
		<td>
			<div class="contentWrapper">
				<h2>Présentations des candidats au hasard</h2>
				<ul style="text-align: justify; ">
				<?php foreach($pres as $pr): ?>
					<li>
						<p>
							<strong><?php echo link_to($pr['title'], 'presentationView', array('id' => $pr['id'])); ?></strong>, <?php echo $by . ' ' . link_to($pr['username'], 'oneProfile', array('id' => $pr['uid'], 'pseudo' => $pr['username'])); ?>
						</p>
						<?php echo format($pr['shortdescription']); ?>
					</li>
				<?php endforeach; ?>
				</ul>
			</div>
		</td>
	<?php endif; ?>
	<?php if(count(@$forum) != 0): ?>
		<td>
			<div class="contentWrapper">
				<h2>En direct du forum</h2>
				<ul style="text-align: justify; ">
				<?php foreach($forum as $f): ?>
					<li>
						<strong><a href="<?php echo $f['url']; ?>"><?php echo  myHtmlEraser($f['titre']); ?></a></strong>, <?php echo $by . ' ' .  myHtmlEraser($f['posteur']); ?>
					</li>
				<?php endforeach; ?>
				</ul>
			</div>
		</td>
	<?php endif; ?>
	</tr>
</table>