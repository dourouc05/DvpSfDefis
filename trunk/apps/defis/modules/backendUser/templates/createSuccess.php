<?php slot('title', $slotTitle)?>
<?php slot('lng', $slotLng)?>
<?php include_partial('backendAdminPresentations/assets') ?>
<div class="contentWrapperLarge" style="width: 475px; ">
<script type="text/javascript" src="http://tinymce.moxiecode.com/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">//<![CDATA[
tinyMCE.init({
mode: 'textareas',
theme: 'advanced',
languages: 'fr'
});
//]]></script>
<style type="text/css">table{border-width: 0px;}table td{border-width: 0px;padding: 3px;}</style>
<h1>Créer ma présentation</h1>
	<form method="post" action="<?php echo url_for('@myPresentation'); ?>">
		<table>
			<tr>
				<td colspan="2">
					<label for="presentation_title">Le titre de votre candidature</label> : 
					<input size="50" type="text" name="presentation_title" id="presentation_title" />
				</td>
			</tr>
			<tr>
				<td style="width: 50px; " colspan="2">
					<label for="presentation_forum">Lien vers la discussion forum</label> : 
					<input type="text" name="presentation_forum" size="150" id="presentation_forum" />
				</td>
			</tr>
			<tr>
				<td>
					<label for="presentation_description">Description de votre présentation</label>
				</td>
				<td>
					<textarea rows="15" cols="500" name="presentation_description" id="presentation_description"></textarea>
				</td>
			</tr>
			<tr>
				<td>
					<label for="presentation_shortdescription">Description très courte de votre présentation, elle sera affichée en page d'accueil des défis</label>
				</td>
				<td>
					<textarea rows="15" cols="200" name="presentation_shortdescription" id="presentation_shortdescription"></textarea>
				</td>
			</tr>
		</table>
		<input type="hidden" name="sent"value="true" />
		<input type="submit" value="Enregistrer" />
	</form>
</div>