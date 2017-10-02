<?php
/**
 * @version     $Id: default.php 19013 2012-11-28 04:48:47Z thailv $
 * @package     JSNUniform
 * @subpackage  Modules
 * @author      JoomlaShine Team <support@joomlashine.com>
 * @copyright   Copyright (C) 2015 JoomlaShine.com. All Rights Reserved.
 * @license     GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.joomlashine.com
 * Technical Support:  Feedback - http://www.joomlashine.com/contact-us/get-support.html
 */
defined('_JEXEC') or die('Restricted access');
$formName = md5(date("Y-m-d H:i:s") . $module->id);
$showTitle = false;
$showDes = false;

if ($params->get('show_form_title') == 1)
{
	$showTitle = true;
}
if ($params->get('show_form_description') == 1)
{
	$showDes = true;
}
if (JSNUniformHelper::checkStateForm($params->get('form_id')))
{
	echo JSNUniformHelper::generateHTMLPages($params->get('form_id'), $formName, '', $params->get('uniform_top_content'), $params->get('uniform_bottom_content'), $showTitle, $showDes, true);
}



