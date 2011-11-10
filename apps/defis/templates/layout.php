<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php $lng = get_slot('lng', 'fr'); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $lng; ?>" lang="<?php echo $lng; ?>">
	<head>
		<?php include_http_metas() ?>
		<?php include_metas() ?>
		<title><?php include_slot('title'); ?></title>
		<link rel="shortcut icon" href="http://qt.developpez.com/favicon.ico" />
		<?php include_stylesheets() ?>
		<?php include_javascripts() ?>
	</head>
	<body dir="ltr">
		<div id="portal-top">
			<div id="topHeader">
				<div id="topHeaderWrapper">
					<ul id="topHeaderActions">
						<li><?php echo link_to(loadString('index_topheadfer_defi', $lng), '@homepage'); ?></li>
						<li><?php echo link_to(loadString('index_topheadfer_forum', $lng), 'http://www.developpez.net/forums/f376/c-cpp/bibliotheques/qt/'); ?></li>
						<li><?php echo link_to(loadString('index_topheadfer_faq', $lng), 'http://qt.developpez.com/faq/'); ?></li>
						<li><?php echo link_to(loadString('index_topheadfer_doc', $lng), 'http://qt.developpez.com/doc/'); ?></li>
						<li><?php echo link_to(loadString('index_topheadfer_tutos', $lng), 'http://qt.developpez.com/cours/'); ?></li>
						<li><?php echo link_to(loadString('index_topheadfer_binaires', $lng), 'http://qt.developpez.com/binaires/'); ?></li>
						<li><?php echo link_to(loadString('index_topheadfer_tv', $lng), 'http://qt.developpez.tv/'); ?></li>
					</ul>
				</div>
				<img id="portal-logo" src="http://qt.developpez.com/defis/images/qt.png" alt="<?php echo loadString('index_alt_logo_rub', $lng); ?>" height="100px"/>
			</div>
			<div id="global-navigation-wrapper">
				<ul id="portal-globalnav">
					<li
						<?php if($sf_params->get('module') == 'frontend'
						      || $sf_params->get('module') == 'authenticate'
						      || $sf_params->get('module') == 'backendAdmin'
						      || $sf_params->get('module') == 'backendJury'
						      || $sf_params->get('module') == 'backendUser'
						      || $sf_params->get('module') == 'challenge'
						      || $sf_params->get('module') == 'frontend'): ?>
						class="selected"
						<?php endif; ?>
						>
						<?php echo link_to(loadString('index_topheader_btn_defi', $lng), '@homepage'); ?>
						</li>
					<li
						<?php if($sf_params->get('module') == 'presentation'): ?>
						class="selected"
						<?php endif; ?>
						>
						<?php echo link_to(loadString('index_topheader_btn_pres', $lng), '@indexPresentations'); ?>
						</li>
					<li
						<?php if($sf_params->get('module') == 'rules'): ?>
						class="selected"
						<?php endif; ?>
						>
						<?php echo link_to(loadString('index_topheader_btn_rles', $lng), '@rules'); ?>
						</li>
					<li
						<?php if($sf_params->get('module') == 'deposit'): ?>
						class="selected"
						<?php endif; ?>
						>
						<?php echo link_to(loadString('index_topheader_btn_dept', $lng), '@deposit'); ?>
						</li>
				</ul>
			</div>
			<div id="global-navigation-wrapper">
				<p id="portal-globalnav" style="margin-left: 150px; color: grey; font-size: small">
					<?php include_component('authenticate', 'box') ?>
				</p>
			</div>
		</div>
		<div id="region-content" class="documentContent">
			<div id="content">
				<div class="clearSpace"></div>
				<?php if(stripos($sf_params->get('module'), 'admin') !== false): ?>
				<div class="contentWrapperVeryLarge" style="text-align: justify; ">
				<?php endif; ?>
				<?php echo $sf_content ?>
				<?php if(stripos($sf_params->get('module'), 'admin') !== false): ?>
				</div>
				<?php endif; ?>
				<div class="clearSpace"></div>
			</div>
		</div>
		<div id="footerWrapper">
			<div id="footerNavigation">
				<div class="footerContent">
					<ul>
						<li class="title"><?php echo link_to(loadString('index_bottom_defi_title', $lng), '@homepage'); ?></li>
						<li><?php echo link_to(loadString('index_bottom_defi_desc', $lng), '@challengeView'); ?></li>
						<li><?php echo link_to(loadString('index_bottom_defi_rules', $lng), '@rules'); ?></li>
						<li><?php echo link_to(loadString('index_bottom_defi_deposit', $lng), '@deposit'); ?></li>
						<li><?php echo link_to(loadString('index_bottom_defi_old', $lng), '@oldChallenges'); ?></li>
					</ul>
					<ul>
						<li class="title"><a><?php echo loadString('index_bottom_contact_title', $lng); ?></a></li>
						<li><?php echo link_to(loadString('index_bottom_contact_jury', $lng), '@jury'); ?></li>
						<li><?php echo link_to(loadString('index_bottom_contact_forum', $lng), 'http://www.developpez.net/forums/f1378/c-cpp/bibliotheques/qt/defis-qt/'); ?></li>
						<li><script type="text/javascript">
<!--
Ch=new Array(4);Res=new Array(4);Ch[0]='le_club_des_developeur';Ch[1]='ÙÆÈÏàä';Ch[2]='¬×ÄÇÍØÖÈÓÓ';Ch[3]='ÐÊÕÈØäÒÏÉß¡ÂÓÒ';
for(y=1;y<4;y++){Res[y]="";for(x=0;x<Ch[y].length;x++)Res[y]+=String.fromCharCode(Ch[y].charCodeAt(x)-Ch[0].charCodeAt(x));}
var st = '<a href="'+Res[1]+':qt'+Res[2]+'-'+Res[3]+'">Mail<\/a>';document.write(st);
//-->
</script></li>
						<li><?php echo link_to(loadString('index_bottom_contact_pm', $lng), 'http://www.developpez.net/forums/private.php?do=newpm&u=254882'); ?></li>
					</ul>
					<?php if(has_slot('connected')): ?>
					<ul>
						<li class="title"><a><?php echo loadString('index_bottom_mem_title', $lng); ?></a></li>
						<li><?php echo link_to(loadString('index_bottom_mem_candid', $lng), '@myPresentation'); ?></li>
						<?php if(has_slot('jury')): ?>
						<li><?php echo link_to(loadString('index_bottom_mem_jury', $lng), '@eval'); ?></li>
						<?php endif; ?>
						<?php if(has_slot('jury') && ! has_slot('admin')):?>
						<li><?php echo link_to(loadString('index_bottom_mem_admin', $lng), '@presentation'); ?></li>
						<?php endif; ?>
						<?php if(has_slot('admin')): ?>
						<li><?php echo link_to(loadString('index_bottom_mem_admin', $lng), '@admin'); ?></li>
						<?php endif; ?>
					</ul>
					<?php endif; ?>
				</div>
			</div>
			<div style="text-align: right">
				<img src="http://qt.developpez.com/defis/images/nokia.png" alt="<?php echo loadString('index_bottom_alt_logo_nokia', $lng); ?>"/>
				<img src="http://qt.developpez.com/defis/images/qt.png" alt="<?php echo loadString('index_bottom_alt_logo_qt', $lng); ?>" height="88px"/>
			</div>
		</div>
	</body>
</html>
