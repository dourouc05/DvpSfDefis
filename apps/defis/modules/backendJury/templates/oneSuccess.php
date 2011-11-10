<?php include_once(MOD_ROOT . '/helpers.php'); ?>
<?php slot('title', $slotTitle)?>
<?php slot('lng', $slotLng)?>
<div class="contentWrapperVeryLarge" style="text-align: justify; ">
	<form method="POST" action="<?php echo url_for('evalOne', array('id' => $victim)); ?>">
		<p>
			<?php echo link_to($sVictim, 'presentation', array('id' => $victim)); ?>
		</p>
		<p>
			<?php echo link_to('La liste.', '@eval'); ?>
		</p>
		<table class="criteria">
			<thead>
				<tr class="criteria_header">
					<th><?php echo $tAcriteria; ?></th>
					<th><?php echo $tAtotal; ?></th>
					<th style="width: 60px"><?php echo $tAmy; ?></th>
					<th style="width: 80px"><?php echo $tAcomm; ?></th>
				</tr>
			</thead>
			<?php foreach($cotation as $el): ?>
			<?php if($el['title'] && $el['content']): ?>
			<?php
			switch($el['content'][0]['crit']->getType())
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
					<th colspan="2">
						<?php 
						$total = null;
						foreach($el['content'] as $cnt)
						{	
							if(@$cnt['cote'])
							{
								switch($cnt['crit']->getType())
								{
								case 'normal': 
								case 'bonus': 
									$total += $cnt['cote'][0]['note'];
									break;
								case 'malus': 
									$total -= $cnt['cote'][0]['note'];
									break;
								case 'opt': 
									if($total < $cnt['cote'][0]['note'])
										$total = $cnt['cote'][0]['note'];
									break;
								}
							}
						}
						echo $total;
						?>
						/
						<?php
						$total = 0;
						foreach($el['content'] as $cnt)
						{
							switch($cnt['crit']->getType())
							{
							case 'normal': 
							case 'bonus': 
							case 'malus': 
								$total += $cnt['crit']->getMaximum();
								break;
							case 'opt': 
								$total = $cnt['crit']->getMaximum();
								break;
							}
						}
						echo $total;
						?>
					</th>
				</tr>
				<?php foreach($el['content'] as $cnt): ?>
				<tr class="criteria_content">
					<td><label for="<?php echo $cnt['crit']->getId(); ?>"><?php echo $cnt['crit']->getName(); ?></label></td>
					<td>
					<?php
					switch($cnt['crit']->getType())
					{
					case 'normal': 
						echo $cnt['crit']->getMaximum();
						break;
					case 'opt': 
						echo '(' . $cnt['crit']->getMaximum() . ')';
						break;
					case 'bonus': 
						echo '+ ' . $cnt['crit']->getMaximum();
						break;
					case 'malus': 
						echo '- ' . $cnt['crit']->getMaximum();
						break;
					}
					?>
					</td>
					<td>
					<?php
					switch($cnt['crit']->getType())
					{
					case 'opt': 
						echo '(';
						break;
					case 'bonus': 
						echo '+ ';
						break;
					case 'malus': 
						echo '- ';
						break;
					}
					?>
						<input size="3" type="text" id="<?php echo $cnt['crit']->getId(); ?>" name="<?php echo $cnt['crit']->getId(); ?>" value="<?php echo (@$cnt['cote'][0]['note']) ? ($cnt['cote'][0]['note']) : '0'; ?>"/>
					<?php
					switch($cnt['crit']->getType())
					{
					case 'opt': 
						echo ')';
						break;
					}
					?>
					</td>
					<td>
						<textarea name="<?php echo $cnt['crit']->getId(); ?>_comm" cols="50" rows="2"><?php echo (@$cnt['cote'][0]['comm']) ? ($cnt['cote'][0]['comm']) : ''; ?></textarea>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
			<?php endif; ?>
			<?php endforeach; ?>
		</table>
		<input type="submit"/>
		<input type="hidden" name="victim"  value="<?php echo $victim; ?>"/>
		<input type="hidden" name="hangman" value="<?php echo $hangman; ?>"/>
		<input type="hidden" name="challen" value="<?php echo $ch; ?>"/>
		<input type="hidden" name="sentttt" value="true"/>
	</form>
</div>