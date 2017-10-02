<?php
/**
 * @version 0.1 $Id: mod_dms.php 0 2008-10-10
 * @package Joomla
 * @author daryl
 * @copyright (C) 2008 RMIS
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');// no direct access

require_once (JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_dms'.DS.'defines.php');
require_once (JPATH_ROOT.DS.'components'.DS.'com_dms'.DS.'models'.DS.'bod'.DS.'docHandler.php');
require_once (JPATH_ROOT.DS.'modules'.DS.'mod_dms'.DS.'helper.php');

require_once('components'.DS.'com_dms'.DS.'classes'.DS.'dms_params.class.php');
require_once('components'.DS.'com_dms'.DS.'helpers'.DS.'helper.php');
require_once (JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_dms'.DS.'legacyHelper.php');
require_once('components'.DS.'com_dms'.DS.'models'.DS.'bod.php');

$helper = new modDmsHelper($params);
require(JModuleHelper::getLayoutPath('mod_dms'));
?>
