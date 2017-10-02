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
 
defined('_JEXEC') or die('Restricted access');


$language = JFactory::getLanguage();
$language->load('com_jsjobs', JPATH_ADMINISTRATOR, null, true);
  // requires the default controller 
require_once (JPATH_COMPONENT.'/JSApplication.php');
require_once (JPATH_ADMINISTRATOR.'/components/com_jsjobs/views/appconstants.php');
require_once (JPATH_ADMINISTRATOR.'/components/com_jsjobs/views/actionmessages.php');
require_once (JPATH_COMPONENT.'/controller.php');

// Language base JS text
JText::script('Are you sure ?');
// END JS text

$document = JFactory::getDocument();
$document->addScript('components/com_jsjobs/js/common.js');
function getCustomFieldClass() {
    include_once JPATH_COMPONENT_ADMINISTRATOR.'/include/classes/customfields.php';
    $obj = new customfields();
    return $obj;
}

//checking for the resume id in session for page refresh problem
$session = JFactory::getSession();
if($session->has('jsjobs_resumeid_for_form')){
    $layout = JRequest::getVar('layout',null);
    if($layout != null && $layout != 'formresume'){ // reset the session id
        $session->clear('jsjobs_resumeid_for_form');
    }
}
/*
  Checking if a controller was set, if so let's included it
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
    $path = JPATH_COMPONENT.'/controllers/' . $c.'.php';
    jimport('joomla.filesystem.file');

    if (JFile::exists($path)) {
        require_once ($path);
    } else {
        JError::raiseError('500', JText::_('Unknown Controller: <br>' . $c.':' . $path));
    }
}
$controllername = 'JSJobsController'.$c;
$controller = new $controllername();
$controller->execute($task);
$controller->redirect();
?>
