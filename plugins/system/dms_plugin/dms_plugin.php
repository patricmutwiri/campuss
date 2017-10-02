<?php
/**
 * @version 1.0 $Id: dms_plugin.php 0 2008-08-26 
 * @package Joomla
 * @subpackage DMS
 * @author daryl
 * @copyright (C) 2013 RMIS www.rmisos.net
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );
if (!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

if (file_exists(JPATH_ROOT.DS.'components'.DS.'com_dms'.DS.'helpers'.DS.'helper.php')) {
	require_once (JPATH_ROOT.DS.'components'.DS.'com_dms'.DS.'helpers'.DS.'helper.php');
}
class plgSystemDms_plugin extends JPlugin {

	function plgSystemDms_plugin(& $subject) {
		parent::__construct($subject);

		//load the translation
		$this->loadLanguage( );
	}

	function onAfterRender() {
		$mainframe = JFactory::getApplication();
		$option = JRequest::getCmd('option');
		$view	= JRequest::getCmd('view');

		if ($mainframe->getClientId() === 1) return;

		// Get Plugin info
		$plugin =& JPluginHelper::getPlugin('content', 'dms_plugin');

		$document	=& JFactory::getDocument();
		$doctype	= $document->getType();
		// Only render for HTML output
		if ( $doctype !== 'html' ) { return; }

		$body = JResponse::getBody();
		
		if ($s = strpos($body, '<div id="dms"')) {
			require_once (JPATH_BASE.DS.'administrator'.DS.'components'.DS.'com_dms'.DS.'defines.php');
			require_once (JPATH_BASE.DS.'components'.DS.'com_dms'.DS.'dms.html.php');
			if (DMSHelper::isAuthor()) {
				$dpopup = HTML_dms::makeDockBox();
			} else {
				$dpopup = '';
			}
		/*	$body = preg_replace('/<body[ a-zA-Z0-9="\':.\(\);]?>/', "<body>\n".$dpopup."\n", $body);*/
			$parts = preg_split('/<body[ a-zA-Z0-9="\':.\(\);]?>/', $body);
			$body = $parts[0]."<body>\n".$dpopup."\n".$parts[1];
			JResponse::setBody($body);
		}
		
		//wz_drapdrop elements
		if ($s = strpos($body, 'id="dmstree_form"')) {
			$session =& JFactory::getSession();
			$docs = $session->get('dms_docs');
			$cm = '';
			$ddhtml = '<script type="text/javascript">'."\n".'<!--'."\n".'SET_DHTML(';
			foreach($docs as $doc) {
				$ddhtml .= $cm.'"doc_'.$doc->doc_id.'"';
				$cm = ', ';
			}
			$ddhtml .= ');'."\n".'//-->'."\n";
			$ddhtml .= "function my_DropFunc() { 
					parent.docks.dropInFolder(dd);
					setTimeout('reloadafterdrop()', 500);
				}\n
				function reloadafterdrop() {
					window.location.href = window.location.href;
				}";
			$list = $session->get('dms_list');
			$ddhtml .= 'var dms_folders = [ "dotdot"';
			if (count($list['folders'])) {
				$cm = ', ';
				foreach($list['folders'] as $folder) {
					$ddhtml .= $cm.'"'.$folder->name.'"';
				}
			}
			$ddhtml .= ' ];'."\n";
			$ddhtml .= '</script>'."\n";
			$body = str_replace('</body>', "\n".$ddhtml."\n".'</body>', $body);
			JResponse::setBody($body);
		}	
	}
}
