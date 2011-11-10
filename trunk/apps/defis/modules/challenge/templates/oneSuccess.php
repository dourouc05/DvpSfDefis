<?php
include_once(MOD_ROOT . '/helpers.php');
$vars = array('forum' => $forum); 
?>
<?php slot('title', $slotTitle)?>
<?php slot('lng', $slotLng)?>
<div class="contentWrapperLarge" style="text-align: justify; ">
	<h1><?php echo $name; ?></h1>
		<h2><?php echo $presT; ?></h2>
			<?php echo sqlLinks(format($presC), $vars); ?>
		<h2><?php echo $name; ?></h2>
			<?php echo format($desc); ?>
		<h2><?php echo $cnsgT; ?></h2>
			<?php echo format($instr); ?>
			<h3><?php echo $cnsgBehT; ?></h3>
				<?php echo format($behaviour); ?>
			<h3><?php echo $cnsgFlsT; ?></h3>
				<?php echo format($files); ?>
			<h3><?php echo $cnsgEnvT; ?></h3>
				<?php echo format($env); ?>
		<h2><?php echo $evalT; ?></h2>
			<h3><?php echo $evalCritT; ?></h3>
				<?php echo format($criteria); ?>
			<h3><?php echo $evalGrillT; ?></h3>
				<table class="criteria">
					<thead>
						<tr class="criteria_header">
							<th><?php echo $tAcriteria; ?></th>
							<th><?php echo $tAtotal; ?></th>
						</tr>
					</thead>
					<?php foreach($cotation as $el): ?>
					<?php if($el['title'] && $el['content']): ?>
					<?php
					switch($el['content'][0]->getType())
					{
					case 'opt': 
						$titleAdd = $tAoptional; 
						break;
					default: 
						$titleAdd = null; 
						break;
					}
					?>
					<tbody>
						<tr class="criteria_subheader">
							<th colspan="2">
								<?php echo $el['title']->getName() . ' ' . $titleAdd; ?>
							</th>
						</tr>
						<?php foreach($el['content'] as $cnt): ?>
						<tr class="criteria_content">
							<td><?php echo $cnt->getName(); ?></td>
							<td>
							<?php
							switch($cnt->getType())
							{
							case 'normal': 
								echo $cnt->getMaximum();
								break;
							case 'opt': 
								echo '(' . $cnt->getMaximum() . ')';
								break;
							case 'bonus': 
								echo '+ ' . $cnt->getMaximum();
								break;
							case 'malus': 
								echo '- ' . $cnt->getMaximum();
								break;
							}
							?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
					<?php endif; ?>
					<?php endforeach; ?>
				</table>
</div>