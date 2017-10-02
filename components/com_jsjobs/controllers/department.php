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

jimport('joomla.application.component.controller');

class JSJobsControllerDepartment extends JSController {

    var $_router_mode_sef = null;

    function __construct() {
        $app = JFactory::getApplication();
        $user = JFactory::getUser();
        if ($user->guest) { // redirect user if not login
            $link = 'index.php?option=com_user';
            $this->setRedirect($link);
        }
        $router = $app->getRouter();
        if ($router->getMode() == JROUTER_MODE_SEF) {
            $this->_router_mode_sef = 1; // sef true
        } else {
            $this->_router_mode_sef = 2; // sef false
        }
        parent::__construct();
    }

    function savedepartment() { //save department
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        $uid = JRequest::getString('uid', 'none');
        $Itemid = JRequest::getVar('Itemid');
        $department = $this->getmodel('Department', 'JSJobsModel');
        $return_value = $department->storeDepartment();
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(SAVED, 'department','message');
        } else if ($return_value == 2) {
            JSJOBSActionMessages::setMessage(REQUIRED_FIELDS, 'department','error');
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'department','error');
        }
        $link = 'index.php?option=com_jsjobs&c=department&view=department&layout=mydepartments&Itemid=' . $Itemid;
        $this->setRedirect(JRoute::_($link , false));
    }

    function deletedepartment() { //delete department
        $user = JFactory::getUser();
        $uid = $user->id;
        $Itemid = JRequest::getVar('Itemid');
        $common = $this->getmodel('Common', 'JSJobsModel');
        $departmentid = $common->parseId(JRequest::getVar('pd', ''));
        $department = $this->getmodel('Department', 'JSJobsModel');
        $return_value = $department->deleteDepartment($departmentid, $uid);
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'department','message');
        } elseif ($return_value == 2) {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'department','error');
        } elseif ($return_value == 3) {
            JSJOBSActionMessages::setMessage(NOT_YOUR, 'department','error');
        } else {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'department','error');
        }
        $link = 'index.php?option=com_jsjobs&c=department&view=department&layout=mydepartments&Itemid=' . $Itemid;
        $this->setRedirect(JRoute::_($link , false));
    }

    function listdepartments() {
        $val = JRequest::getVar('val');
        $depatments = $this->getmodel('Department', 'JSJobsModel');
        $returnvalue = $depatments->listDepartments($val);
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    function display($cachable = false, $urlparams = false) { // correct employer controller display function manually.
        $document = JFactory::getDocument();
        $viewName = JRequest::getVar('view', 'default');
        $layoutName = JRequest::getVar('layout', 'default');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>