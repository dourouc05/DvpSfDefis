<?php include_once(MOD_ROOT . '/helpers.php'); ?>
<?php slot('title', $slotTitle)?>
<?php slot('lng', $slotLng)?>
<div class="contentWrapperVeryLarge" style="text-align: justify; ">
	<div style="float: right">
		<?php echo utf8_encode(file_get_contents('http://www.developpez.com/ws/badge?user=' . $pres->getMember())); ?>
	</div>
	<div style="margin: 5px; padding: 5px; border: 1px dotted lightgrey; ">
		<div style="float: left; ">
			<?php echo link_to($see, 'oneChallenge', array('number' => $pres->getChallenge())); ?>
		</div>
		<br/>
		<h1><?php echo $pres->getTitle(); ?></h1>
		<blockquote style="border: 1px dashed grey; width: 300px; padding: 5px; -moz-border-radius: 1em; -webkit-border-radius: 1em; border-radius: 1em; ">
			<?php echo format($pres->getShortdescription()); ?>
		</blockquote>
		<?php echo format($pres->getDescription()); ?>
		<?php if(count($evals) > 0): ?>
		<?php
		$global = array();
		$global['total']['score'] = 0; 
		$global['total']['jures'] = 0; 
		$global['total']['total'] = 0;
		?>
		<h2>Évaluation de la candidature</h2>
		<?php foreach($evals as $id => $eval): ?>
			<h3>Par le juré <?php echo $tableJures[$id]; ?></h3>
				<table class="criteria">
					<thead>
						<tr class="criteria_header">
							<th><?php echo $tAcriteria; ?></th>
							<th><?php echo $tAtotal; ?></th>
							<th>Résultat obtenu</th>
							<th>Commentaires</th>
						</tr>
						<tr class="criteria_header">
							<th colspan="3">&nbsp;</th>
							<?php 
							// calcul du total global pour ce juré
							$total = 0;
							foreach($cotation as $el)
							{
								if(@$el['content'])
								{
									$subtotal = 0;
									foreach($el['content'] as $cnt)
									{
										switch($cnt->getType())
										{
										case 'normal': 
											$subtotal += $cnt->getMaximum();
											break; 
										case 'opt': 
											$subtotal = $cnt->getMaximum();
											break;
										}
									}
								$total += $subtotal;
								}
							}
							// calcul du score obtenu
							$thistotal = 0;
							foreach($cotation as $el)
							{
								if(@$el['content'])
								{
									$thissubtotal = 0;
									foreach($el['content'] as $cnt)
									{
										switch($cnt->getType())
										{
										case 'normal': 
										case 'bonus': 
										case 'malus': 
											$thissubtotal += @$eval[@$cnt->getId()]['note'];
											break;
										case 'opt': 
											if($thissubtotal < @$eval[@$cnt->getId()]['note'])
												$thissubtotal = @$eval[@$cnt->getId()]['note'];
											break;
										}
									}
									$thistotal += $thissubtotal;
								}
							}
							$global['total']['score'] += $thistotal; 
							++$global['total']['jures']; 
							$global['total']['total'] = $total;
							?>
							<th><?php echo $thistotal; ?> / <?php echo $total; ?></th>
						</tr>
					</thead>
					<?php $i = -1; ?>
					<?php foreach($cotation as $el): ?>
					<?php if(@$el['title'] && @$el['content'] && @$el['content'][0] && @$eval[@$el['content'][0]['id']]): ?>
					<?php
					++$i;
					if(!@$global['cnt'][$i]['got'])    $global['cnt'][$i]['got'] = 0;
					if(!@$global['cnt'][$i]['jures'])  $global['cnt'][$i]['jures'] = 0;
					?>
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
							<th colspan="4">
								<?php $title = $el['title']->getName() . ' ' . $titleAdd; ?>
								<?php echo $title; ?>
								<?php $global['cnt'][$i]['title'] = $title; ?>
							</th>
						</tr>
						<tr class="criteria_subheader">
							<th colspan="3">
								&nbsp;
							</th>
							<th>
								<?php 
								$total = 0;
								foreach($el['content'] as $cnt)
								{
									switch($cnt->getType())
									{
									case 'normal': 
									case 'bonus': 
									case 'malus': 
										$total += @$eval[@$cnt->getId()]['note'];
										break;
									case 'opt': 
										if($total < @$eval[@$cnt->getId()]['note'])
											$total = @$eval[@$cnt->getId()]['note'];
										break;
									}
								}
								echo (($el['content'][0]->getType() == 'bonus') ? '+ ' : '') . (($el['content'][0]->getType() == 'malus') ? '- ' : '') . abs($total); 
								if($total != 0) // 0 à une catégorie == j'ai rien mis
								{
									$global['cnt'][$i]['got'] += $total; 
									++$global['cnt'][$i]['jures']; 
								}
								?>
								/
								<?php
								$total = 0;
								foreach($el['content'] as $cnt)
								{
									switch($cnt->getType())
									{
									case 'normal': 
									case 'bonus': 
										$total += $cnt->getMaximum();
										break; 
									case 'malus': 
										$total -= $cnt->getMaximum();
										break;
									case 'opt': 
										$total = $cnt->getMaximum();
										break;
									}
								}
								echo $total;
								$global['cnt'][$i]['max'] = $total; 
								?>
							</th>
						</tr>
						<?php $j = 0; ?>
						<?php foreach($el['content'] as $crit => $cnt): ?>
						<?php if(@$eval[$cnt->getId()]['note'] || @$eval[$cnt->getId()]['comment']): ?>
						<?php
						++$j;
						if(!@$global['cnt'][$i]['cnt'][$j]['got'])    $global['cnt'][$i]['cnt'][$j]['got'] = 0;
						if(!@$global['cnt'][$i]['cnt'][$j]['jures'])  $global['cnt'][$i]['cnt'][$j]['jures'] = 0;
						?>
						<tr class="criteria_content">
							<td>
								&nbsp;&nbsp;
								<?php $naam = $cnt->getName(); ?>
								<?php echo $naam; ?>
								<?php $global['cnt'][$i]['cnt'][$j]['title'] = $naam; ?>
							</td>
							<td style="text-align: center; ">
							<?php
							$toprint = $cnt->getMaximum();
							$global['cnt'][$i]['cnt'][$j]['type'] = $cnt->getType(); 
							switch($cnt->getType())
							{
							case 'normal': 
								echo $toprint;
								break;
							case 'opt': 
								echo '(' . $toprint . ')';
								break;
							case 'bonus': 
								echo '+ ' . $toprint;
								break;
							case 'malus': 
								echo '- ' . $toprint;
								break;
							}
							$global['cnt'][$i]['cnt'][$j]['max'] = $toprint; 
							?>
							</td>
							<td style="text-align: center; ">
							<?php
							$toprint = (@$eval[$cnt->getId()]['note']) ? $eval[$cnt->getId()]['note'] : '0';
							switch($cnt->getType())
							{
							case 'normal': 
								echo $toprint;
								break;
							case 'opt': 
								echo '(' . $toprint . ')';
								break;
							case 'bonus': 
								echo '+ ' . $toprint;
								break;
							case 'malus': 
								echo '- ' . abs($toprint);
								break;
							}
							$global['cnt'][$i]['cnt'][$j]['got'] += $toprint; 
							++$global['cnt'][$i]['cnt'][$j]['jures']; 
							?>
							</td>
							<td style="text-align: center; ">
								<?php echo format(@$eval[$cnt->getId()]['comment']); ?>
							</td>
						</tr>
						<?php endif; ?>
						<?php endforeach; ?>
					</tbody>
					<?php endif; ?>
					<?php endforeach; ?>
				</table>
				</table>
		<?php endforeach; ?>
		<?php /*****************************************************************************************************************************************************************************************************************/ ?>
			<h3>En résumé</h3>
				<table class="criteria">
					<thead>
						<tr class="criteria_header">
							<th><?php echo $tAcriteria; ?></th>
							<th><?php echo $tAtotal; ?></th>
							<th>Résultat obtenu</th>
						</tr>
						<tr class="criteria_header">
							<th colspan="3"><?php echo round($global['total']['score'] / $global['total']['jures'], 2); ?> / <?php echo $global['total']['total']; ?></th>
						</tr>
					</thead>
					<?php foreach($global['cnt'] as $i => $el): ?>
					<tbody>
						<tr class="criteria_subheader">
							<th colspan="3"><?php echo $el['title']; ?></th>
						</tr>
						<tr class="criteria_subheader">
							<th colspan="3">
								<?php 
								echo ($el['got'] / (($el['jures']) ? $el['jures'] : 1));
								?>
								/
								<?php
								echo $el['max'];
								?>
							</th>
						</tr>
						<?php foreach($el['cnt'] as $crit => $cnt): ?>
						<tr class="criteria_content">
							<td>&nbsp;&nbsp;<?php echo $cnt['title']; ?></td>
							<td style="text-align: center; ">
							<?php
							$toprint = $cnt['max'];
							switch($cnt['type'])
							{
							case 'normal': 
								echo $toprint;
								break;
							case 'opt': 
								echo '(' . $toprint . ')';
								break;
							case 'bonus': 
								echo '+ ' . $toprint;
								break;
							case 'malus': 
								echo '- ' . $toprint;
								break;
							}
							?>
							</td>
							<td style="text-align: center; ">
							<?php
							$toprint = round($cnt['got'] / $cnt['jures'], 2);
							switch($cnt['type'])
							{
							case 'normal': 
								echo $toprint;
								break;
							case 'opt': 
								echo '(' . $toprint . ')';
								break;
							case 'bonus': 
								echo '+ ' . $toprint;
								break;
							case 'malus': 
								echo '- ' . abs($toprint);
								break;
							}
							?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
					<?php endforeach; ?>
				</table>
		<?php endif; ?>
	</div>
</div>