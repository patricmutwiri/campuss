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

class JSJobsControllerSalaryrangetype extends JSController {

    function __construct() {
        parent::__construct();
        $this->registerTask('add', 'edit');
    }

    function editjobsalaryrangrtype() {
        JRequest::setVar('layout', 'formsalaryrangetype');
        JRequest::setVar('view', 'salaryrangetype');
        JRequest::setVar('c', 'salaryrangetype');
        $this->display();
    }

    function savejobsalaryrangetype() {
        $redirect = $this->savesalaryrangetype('saveclose');
    }

    function savejobsalaryrangetypesave() {
        $redirect = $this->savesalaryrangetype('save');
    }

    function savejobsalaryrangetypeandnew() {
        $redirect = $this->savesalaryrangetype('saveandnew');
    }

    function savesalaryrangetype($callfrom) {
        $salaryrangetype_model = $this->getmodel('Salaryrangetype', 'JSJobsModel');
        $return_value = $salaryrangetype_model->storeSalaryRangeType();
        $link = 'index.php?option=com_jsjobs&c=salaryrangetype&view=salaryrangetype&layout=salaryrangetype';
        if (is_array($return_value)) {
            if ($return_value['issharing'] == 1) {
                if ($return_value['return_value'] == false) { // jobsharing return value 
                    JSJOBSActionMessages::setMessage(SAVED, 'salaryrangetype','message');
                    if ($return_value['rejected_value'] != "")
                        JSJOBSActionMessages::setMessage(SHARING_IMPROPER_NAME, 'salaryrangetype','warning');
                    if ($return_value['authentication_value'] != "")
                        JSJOBSActionMessages::setMessage(SHARING_AUTH_FAIL, 'salaryrangetype','warning');
                    if ($return_value['server_responce'] != "")
                        JSJOBSActionMessages::setMessage(SHARING_SYNCHRONIZE_ERROR, 'salaryrangetype','warning');
                    $this->setRedirect($link);
                }elseif ($return_value['return_value'] == true) { // jobsharing return value 
                    $redirect = 1;
                }
            } elseif ($return_value['issharing'] == 0) {
                if ($return_value[1] == 1) {
                    $redirect = 1;
                }
            }
            if ($redirect == 1) {
                JSJOBSActionMessages::setMessage(SAVED, 'salaryrangetype','message');
                if ($callfrom == 'saveclose') {
                    $link = 'index.php?option=com_jsjobs&c=salaryrangetype&view=salaryrangetype&layout=salaryrangetype';
                } elseif ($callfrom == 'save') {
                    $link = 'index.php?option=com_jsjobs&c=salaryrangetype&view=salaryrangetype&layout=formsalaryrangetype&cid[]=' . $return_value[2];
                } elseif ($callfrom == 'saveandnew') {
                    $link = 'index.php?option=com_jsjobs&c=salaryrangetype&view=salaryrangetype&layout=formsalaryrangetype';
                }
                $this->setRedirect($link);
            } elseif ($return_value == false) {
                JSJOBSActionMessages::setMessage(SAVE_ERROR, 'salaryrangetype','error');
                $this->setRedirect($link);
            }
        } else {
            if ($return_value == 3) {
                JSJOBSActionMessages::setMessage(ALREADY_EXIST, 'salaryrangetype','notice');
                JRequest::setVar('view', 'salaryrangetype');
                JRequest::setVar('hidemainmenu', 1);
                JRequest::setVar('layout', 'formsalaryrangetype');
                $this->display();
            }elseif ($return_value == 2) {
                JSJOBSActionMessages::setMessage(REQUIRED_FIELDS, 'job','error');
                $link = 'index.php?option=com_jsjobs&c=salaryrangetype&view=salaryrangetype&layout=formsalaryrangetype&cid[]='.JRequest::getVar('id');
                $this->setRedirect($link);
            } else {
                JSJOBSActionMessages::setMessage(SAVE_ERROR, 'salaryrangetype','error');
                $this->setRedirect($link);
            }
        }
    }

    function cancel() {
        JSJOBSActionMessages::setMessage(OPERATION_CANCELLED, 'salaryrangetype','notice');
        $this->setRedirect('index.php?option=com_jsjobs&c=salaryrangetype&view=salaryrangetype&layout=salaryrangetype');
    }

    function remove() {
        $salaryrangetype_model = $this->getmodel('Salaryrangetype', 'JSJobsModel');
        $returnvalue = $salaryrangetype_model->deleteSalaryRangeType();
        if ($returnvalue == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'salaryrangetype','message');
        } else {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'salaryrangetype','error');
        }
        $this->setRedirect('index.php?option=com_jsjobs&c=salaryrangetype&view=salaryrangetype&layout=salaryrangetype');
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory::getDocument();
        $viewName = JRequest::getVar('view', 'salaryrangetype');
        $layoutName = JRequest::getVar('layout', 'salaryrangetype');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $salaryrangetype_model = $this->getModel('Salaryrangetype', 'JSJobsModel');
        if (!JError::isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($salaryrangetype_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($salaryrangetype_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>