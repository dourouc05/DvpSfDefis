<?php include_once(MOD_ROOT . '/helpers.php'); ?>
<div style="height: 2px;"></div>
<table width="50" cellpadding="0" cellspacing="0" border="0" align="center" valign="bottom" style="font-size: x-small; width: 75%; height: 26px;">
<?php if($auth): ?>
<?php slot('connected', $auth); ?>
<?php slot('jury', $jury); ?>
<?php slot('admin', $admin); ?>
	<tr>
		<td colspan="2" style="text-align: center"><?php echo $trWel . link_to($pseudo, 'http://www.developpez.net/forums/u' . $id . '/'. $pseudo . '/'); ?>. </td>
	</tr>
	<tr>
		<td colspan="2" style="text-align: center"><?php echo link_to($trPrf, 'oneProfile', array('id' => $id, 'pseudo' => $pseudo)); ?></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align: center"><?php echo link_to($trLgo, '@logout'); ?></td>
	</tr>
<?php else: ?>
	<tr>
		<td colspan="2" style="text-align: center"><?php echo link_to($wishConnect, 'login'); ?></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align: center"><?php echo link_to($wishCreate, 'http://www.developpez.net/forums/register.php'); ?></td>
	</tr>
<?php endif; ?>
</table>