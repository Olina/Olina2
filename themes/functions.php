<?php
/**
* Helpers for theming, available for all themes in their template files and functions.php.
* This file is included right before the themes own functions.php

/**
* Prepend the base_url.
*/
function base_url($url) 
{
	return COlina::Instance()->request->base_url . trim($url, '/');
}

/**
* Create a url to an internal resource.
*/
function create_url($url=null) 
{
	return COlina::Instance()->request->CreateUrl($url);
}

/**
* Prepend the theme_url, which is the url to the current theme directory.
*/
function theme_url($url) 
{
	$olina = COlina::Instance();
	return "{$olina->request->base_url}themes/{$olina->config['theme']['name']}/{$url}";
}


/**
* Return the current url.
*/
function current_url() 
{
	return COlina::Instance()->request->current_url;
}

/**
* Print debuginformation from the framework.
*/
function get_debug() 
{
	// Only if debug is wanted.
	$olina = Colina::Instance();
	if(empty($olina->config['debug'])) 
	{
		return;
	}
  
	// Get the debug output
	$html = null;
	if(isset($olina->config['debug']['db-num-queries']) && $olina->config['debug']['db-num-queries'] && isset($olina->db)) 
	{
		$flash = $olina->session->GetFlash('database_numQueries');
		$flash = $flash ? "$flash + " : null;
		$html .= "<p>Database made $flash" . $olina->db->GetNumQueries() . " queries.</p>";
	}
	if(isset($olina->config['debug']['db-queries']) && $olina->config['debug']['db-queries'] && isset($olina->db)) 
	{
		$flash = $olina->session->GetFlash('database_queries');
		$queries = $olina->db->GetQueries();
		if($flash) 
		{
			$queries = array_merge($flash, $queries);
		}
		$html .= "<p>Database made the following queries.</p><pre>" . implode('<br/><br/>', $queries) . "</pre>";
	}
	if(isset($olina->config['debug']['timer']) && $olina->config['debug']['timer']) 
	{
		$html .= "<p>Page was loaded in " . round(microtime(true) - $olina->timer['first'], 5)*1000 . " msecs.</p>";
	}
	if(isset($olina->config['debug']['lydia']) && $olina->config['debug']['lydia']) 
	{
		$html .= "<hr><h3>Debuginformation</h3><p>The content of COlina:</p><pre>" . htmlent(print_r($olina, true)) . "</pre>";
	}
	if(isset($olina->config['debug']['session']) && $olina->config['debug']['session']) 
	{
		$html .= "<hr><h3>SESSION</h3><p>The content of COlina->session:</p><pre>" . htmlent(print_r($olina->session, true)) . "</pre>";
		$html .= "<p>The content of \$_SESSION:</p><pre>" . htmlent(print_r($_SESSION, true)) . "</pre>";
	}
	return $html;
}

/**
* Render all views.
*/
function render_views() 
{
	return COlina::Instance()->views->Render();
}

/**
* Get messages stored in flash-session.
*/
function get_messages_from_session() 
{
	$messages = COlina::Instance()->session->GetMessages();
	$html = null;
	if(!empty($messages)) 
	{
		foreach($messages as $val) 
		{
			$valid = array('info', 'notice', 'success', 'warning', 'error', 'alert');
			$class = (in_array($val['type'], $valid)) ? $val['type'] : 'info';
			$html .= "<div class='$class'>{$val['message']}</div>\n";
		}
	}
	return $html;
}
