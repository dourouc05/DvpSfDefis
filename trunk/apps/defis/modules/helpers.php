<?php

function format($text)
{
	$text = myHtmlEraser($text);
	return str_replace(array('<warning>', '</warning>', '<info>', '</info>'), array('<table class="infobulle" style="width: 98%; text-align: left; border:0;"><tr><td style="width: 40px; vertical-align: top;" class="colonne"><img src="http://www.developpez.be/images/kitwarning.gif" alt="warning"/></td><td class="colonne">', '</td></tr></table>', '<table class="infobulle" style="width: 98%; text-align: left; border:0;"><tr><td style="width: 40px; vertical-align: top;" class="colonne"><img src="http://www.developpez.be/images/kitinfo.gif" alt="info"/></td><td class="colonne">', '</td></tr></table>'), simple_format_text($text));
}

function sqlLinks($text, $vars = array())
{
	// on ne peut pas utiliser les helpers de liens comme link_to dans une bdd, donc on triche
	// "<!@challenge#défi actuel!>" correspond à un appel de "echo link_to('défi actuel', '@challenge');"
	// "!$forum#Retrouvez ce défi sur le forum.!>" correspond à un appel de "echo link_to(__('Retrouvez ce défi sur le forum.'), $forum);", $forum étant une variable
	
	// $text == texte1 <!href#name!> texte2 <!href#name!> texte3
	$subtext = explode('<!', $text);
	if(count($subtext) == 1)
		return $text;
	
	$text = array_shift($subtext);
	// $text == texte1
	foreach($subtext as $part)
	{
		// $part == href#name!> texte2
		$part = explode('!>', $part, 2);
		// $part == array(href#name, texte2)
		$link = explode('#', $part[0], 2); 
		$part = $part[1]; 
		// link == array(href, name), href pouvant être une variable de $vars... 
		// part == texte2
		if($link[0][0] == '$')
		{
			$link[0] = substr($link[0], 1); // on élimine le $
			$link[0] = $vars[$link[0]]; // et on recherche la variable adéquate dans le tableau
		}
		if($link[0] != 'none')
			$text .= link_to($link[1], $link[0]); 
		$text .= $part; 
	}
	return $text;
}

function myHtmlEraser($text)
{
	return str_replace(array('&lt;', '&gt;', '&quot;', '&amp;'), array('<', '>', '"', '&'), $text);
}
