<?php

/**
 * @Copyright Copyright (C) 2009-2010 Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:     Buruj Solutions
 + Contact:     http://www.burujsolutions.com , info@burujsolutions.com
 * Created on:  Nov 22, 2010
 ^
 + Project:     JS Jobs
 ^ 
 */

/*
 * Make sure entry is initiated by Joomla!
 */
defined('_JEXEC') or die('Restricted access');
// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_jsjobs')) {
  return JError::raiseWarning(404, JText::_('Jerror Alertnoauthor'));
}

$version = new JVersion;
$joomla = $version->getShortVersion();
$jversion = substr($joomla, 0, 3);
if (!defined('JVERSION')) {
    define('JVERSION', $jversion);
}

/*
 * Require our default controller - used if 'c' is not assigned
 * - c is the controller to use (should probably rename to 'controller')
 */

require_once (JPATH_COMPONENT . '/JSApplication.php');
require_once (JPATH_COMPONENT . '/views/appconstants.php');
require_once (JPATH_COMPONENT . '/views/layout.php');
require_once (JPATH_COMPONENT . '/views/actionmessages.php');
require_once (JPATH_COMPONENT . '/controller.php');

// Language base JS text
JText::script('Are you sure ?');
// END JS text

require_once (JPATH_COMPONENT . '/include/classes/customfields.php');
function getCustomFieldClass() {
    include_once JPATH_COMPONENT_ADMINISTRATOR.'/include/classes/customfields.php';
    $obj = new customfields();
    return $obj;
}

// include admin JS
$document = JFactory::getDocument();
if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('../components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}
$document->addScript(JURI::root().'administrator/components/com_jsjobs/include/js/common.js');

// include admin css
$document->addStyleSheet('components/com_jsjobs/include/installer.css');
$document->addStyleSheet(JURI::root().'administrator/components/com_jsjobs/include/css/bootstrap.min.css');
$document->addStyleSheet(JURI::root().'administrator/components/com_jsjobs/include/css/admin.css');
$document->addStyleSheet(JURI::root().'administrator/components/com_jsjobs/include/css/menu.css');
$language = JFactory::getLanguage();
if($language->isRtl()){
  $document->addStyleSheet(JURI::root().'administrator/components/com_jsjobs/include/css/admin_rtl.css');
}
/*
 * Checking if a controller was set, if so let's included it
 */
$task = JRequest::getCmd('task');
$c = '';
if (strstr($task, '.')) {
    $array = explode('.', $task);
    $c = $array[0];
    $task = $array[1];
} else {
    $c = JRequest::getCmd('c', 'jsjobs');
    $task = JRequest::getCmd('task', 'display');
}
if ($c != '') {
    $path = JPATH_COMPONENT . '/controllers/' . $c . '.php';
    //echo 'Path'.$path;
    jimport('joomla.filesystem.file');
    /*
     * Checking if the file exists and including it if it does
     */
    if (JFile::exists($path)) {
        require_once ($path);
    } else {
        JError::raiseError('500', JText::_('Unknown Controller: <br>' . $c . ':' . $path));
    }
}
/*
 * Define the name of the controller class we're going to use
 * Instantiate a new instance of the controller class
 * Execute the task being called (default to 'display')
 * If it's set, redirect to the URI
 */
$c = 'JSJobsController' . $c;
$controller = new $c ();
$controller->execute($task);
$controller->redirect();
?>
