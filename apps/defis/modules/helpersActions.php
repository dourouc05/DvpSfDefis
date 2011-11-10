<?php

function loadString($string, $lng = 'fr')
{
	$data = cacheGet($string, $lng);
	if(! $data)
	{
		$q = Doctrine_Query::create()
			->from('string s')
			->where('s.ids = ?', $string)
			->andWhere('s.lang = ?', $lng);
		$r = $q->fetchOne();
		$data = $r->getContent();
		cacheSave($data, $string, $lng);
	}
	return $data;
}

function loadTitle($string, $lng = 'fr')
{
	$data = cacheGet('title_' . $string, $lng);
	if(! $data)
	{
		$data = loadString('title_prefix', $lng) . ' ' . loadString($string, $lng); 
		cacheSave($data, 'title_' . $string, $lng);
	}
	return $data;
}

function cacheGet($id, $lng = 'fr')
{
	$file = CACHE_ROOT . '/i18n/defis/' . $lng . '/' . $id;
	
    clearstatcache();
    if ((file_exists($file)))
	{
		if(@filemtime($file) > 3600)
			return file_get_contents($file);
		else
			@unlink($file);
    }
    return false;
}

function cacheSave($data, $id, $lng = 'fr')
{
	file_put_contents(CACHE_ROOT . '/i18n/defis/' . $lng . '/' . $id, $data);
}

function tern($true, $false)
{
	return ($true) ? $true : $false; 
}

function ternT($array, $lng, $property)
{
	return ($array[$lng][$property]) ? $array[$lng][$property] : $array['fr'][$property]; 
}

if ( false === function_exists('lcfirst') )
{
    function lcfirst( $str ) 
    {
		return (string)(strtolower(substr($str,0,1)).substr($str,1));
	} 
}

function getJuryHiddenId($challenge, $jury)
{
	$q = Doctrine_Query::create()
		->from('juryman j')
		->where('j.challenge = ?', $challenge)
		->andWhere('j.profile = ?', $jury);
	$r = $q->fetchOne();
	return $r->getId();
}