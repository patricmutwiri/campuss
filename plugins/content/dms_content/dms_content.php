<?php
/**
 * @version 1.0 $Id: dms_content.php 0 2008-08-26 
 * @package Joomla
 * @subpackage DMS
 * @author daryl
 * @copyright (C) 2013 RMIS www.rmisos.net
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );
if (!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

require_once (JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_dms'.DS.'defines.php');
require_once (JPATH_ROOT.DS.'components'.DS.'com_dms'.DS.'models'.DS.'bod'.DS.'docHandler.php');
require_once (JPATH_ROOT.DS.'modules'.DS.'mod_dms'.DS.'helper.php');
class PlgContentDms_content extends JPlugin {

	public function onContentBeforeDisplay( $context, $article, $params, $limitstart ) {
		$this->onPrepareContent( $article, $params, $limitstart );
	}
	public function onPrepareContent( &$article, &$params, $limitstart ) {
		$mainframe = JFactory::getApplication();

		$document = JFactory::getDocument();
		$document->addStyleSheet('components/com_dms/assets/css/dms.css');

		$munch = new dms_article($article->text);
		$article->text = $munch->compile();

		//var_dump($article->text);die;
	}
	public function onContentPrepare($context, &$row, &$params, $page = 0) {
		$mainframe = JFactory::getApplication();

		$document = JFactory::getDocument();
		//$document->addStyleSheet('components/com_dms/assets/css/dms.css');

		$plugin = JPluginHelper::getPlugin('content', 'dms_content');
		if (DMSHelper::is17()) {
			$pars = new JRegistry( $plugin->params );
		} else {
			$pars = new JParameter( $plugin->params );
		}

		$munch = new dms_article($row->text, $pars);
		$row->text = $munch->compile();
	}
}

class dms_article {
	var $article = null;
	var $replace = array();
	var $params;
	function __construct($html, $params) {
		$this->article = $html;
		$this->params = $params;
	}
	function compile() {
		if (empty($this->article)) return '';
		dms_muncher::clear();
		dms_muncher::$params = $this->params;
		$muncher = 'return dms_muncher::mun($matches[0]);';
		$txt = preg_replace_callback('/\[com_dms:\w{1,}.*]/', create_function('$matches', $muncher), $this->article);
		
		return $txt;
	}
	function dump() {
		$this->article;
	}
}

class dms_muncher {
	private static $words = array();
	public static $params;
	function mun($word, $text="Download") {
		list($com, $data) = explode(':', $word, 2);
		$data = substr($data, 0, strlen($data)-1);
		list($id, $label) = explode(':', $data, 2);
		$doc = new docHandler($id);
		if (!empty($label)) $text = $label;
		$url = $doc->getAquireURL();
		//$url = JURI::base().'index.php?option=com_dms&task=bod.aquire&did='.$id;
		if ($cssclass = self::$params->get('css_class')) {
			$cssclass = ' class="'.$cssclass.'"';
		}
		$word = '<a'.$cssclass.' href="'.$url.'">'.$text.'</a>';

		if (array_search($word, self::$words) === false)
			self::$words[] = $word;
		return $word;
	}
	function words() {
		return self::$words;
	}
	function clear() {
		self::$words = array();
	}
}
