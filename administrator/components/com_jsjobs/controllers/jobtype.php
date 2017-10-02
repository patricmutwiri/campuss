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

class JSJobsControllerJobtype extends JSController {

    function __construct() {
        parent::__construct();
        $this->registerTask('add', 'edit');
    }

    function editjobtype() {
        JRequest::setVar('layout', 'formjobtype');
        JRequest::setVar('view', 'jobtype');
        JRequest::setVar('c', 'jobtype');
        $this->display();
    }

    function savejobtype() {
        $redirect = $this->storejobtype('saveclose');
    }

    function savejobtypesave() {
        $redirect = $this->storejobtype('save');
    }

    function savejobtypeandnew() {
        $redirect = $this->storejobtype('saveandnew');
    }

    function storejobtype($callfrom) {
        $jobtype_model = $this->getmodel('Jobtype', 'JSJobsModel');
        $return_value = $jobtype_model->storeJobType();
        $link = 'index.php?option=com_jsjobs&c=jobtype&view=jobtype&layout=jobtypes';
        if (is_array($return_value)) {
            if ($return_value['issharing'] == 1) {
                if ($return_value['return_value'] == false) { // jobsharing return value 
                    JSJOBSActionMessages::setMessage(SAVED, 'jobtype','message');
                    if ($return_value['rejected_value'] != "")
                        JSJOBSActionMessages::setMessage(SHARING_IMPROPER_NAME, 'jobtype','warning');
                    if ($return_value['authentication_value'] != "")
                        JSJOBSActionMessages::setMessage(SHARING_AUTH_FAIL, 'jobtype','warning');
                    if ($return_value['server_responce'] != "")
                        JSJOBSActionMessages::setMessage(SHARING_SYNCHRONIZE_ERROR, 'jobtype','warning');
                    $this->setRedirect($link);
                }elseif ($return_value == true) { // jobsharing return value 
                    $redirect = 1;
                }
            } elseif ($return_value['issharing'] == 0) {
                if ($return_value[1] == 1) {
                    $redirect = 1;
                }
            }
            if ($redirect == 1) {
                JSJOBSActionMessages::setMessage(SAVED, 'jobtype','message');
                if ($callfrom == 'saveclose') {
                    $link = 'index.php?option=com_jsjobs&c=jobtype&view=jobtype&layout=jobtypes';
                } elseif ($callfrom == 'save') {
                    $link = 'index.php?option=com_jsjobs&c=jobtype&view=jobtype&layout=formjobtype&cid[]=' . $return_value[2];
                } elseif ($callfrom == 'saveandnew') {
                    $link = 'index.php?option=com_jsjobs&c=jobtype&view=jobtype&layout=formjobtype';
                }
                $this->setRedirect($link);
            } elseif ($return_value == false) {
                JSJOBSActionMessages::setMessage(SAVE_ERROR, 'jobtype','error');
                $this->setRedirect($link);
            }
        } else {
            if ($return_value == 3) {
                JSJOBSActionMessages::setMessage(ALREADY_EXIST, 'jobtype','message');
                JRequest::setVar('view', 'jobtype');
                JRequest::setVar('hidemainmenu', 1);
                JRequest::setVar('layout', 'formjobtype');
                $this->display();
            }  elseif ($return_value == 2) {
                JSJOBSActionMessages::setMessage(REQUIRED_FIELDS, 'job','error');
                $link = 'index.php?option=com_jsjobs&c=jobtype&view=jobtype&layout=formjobtype&cid[]='.JRequest::getVar('id');
                $this->setRedirect($link);
            }else {
                JSJOBSActionMessages::setMessage(SAVE_ERROR, 'jobtype','error');
                $this->setRedirect($link);
            }
        }
    }

    function remove() {
        $jobtype_model = $this->getmodel('Jobtype', 'JSJobsModel');
        $returnvalue = $jobtype_model->deleteJobType();
        if ($returnvalue == 1)
            JSJOBSActionMessages::setMessage(DELETED, 'jobtype','message');
        else
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'jobtype','error');
        $this->setRedirect('index.php?option=com_jsjobs&c=jobtype&view=jobtype&layout=jobtypes');
    }

    function cancel() {
        JSJOBSActionMessages::setMessage(OPERATION_CANCELLED, 'jobtype','notice');
        $this->setRedirect('index.php?option=com_jsjobs&c=jobtype&view=jobtype&layout=jobtypes');
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory::getDocument();
        $viewName = JRequest::getVar('view', 'jobtype');
        $layoutName = JRequest::getVar('layout', 'jobtype');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $jobtype_model = $this->getModel('Jobtype', 'JSJobsModel');
        if (!JError::isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($jobtype_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($jobtype_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>