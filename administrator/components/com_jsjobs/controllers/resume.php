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

class JSJobsControllerResume extends JSController {

    function __construct() {
        parent::__construct();
        $this->registerTask('add', 'edit');
    }

    function getresumedetail() {
        $user = JFactory::getUser();
        $uid = $user->id;
        $jobid = JRequest::getVar('jobid');
        $resumeid = JRequest::getVar('resumeid');
        //require_once(JPATH_ROOT.'/components/com_jsjobs/models/resume.php');
        //$resume_model = new JSJobsModelResume();
        $resume_model = $this->getmodel('Resume', 'JSJobsModel');
        $returnvalue = $resume_model->getResumeDetail($uid, $jobid, $resumeid);
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    /* STRAT EXPORT RESUMES */

    function resumeenforcedelete() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $cid = JRequest::getVar('cid', array(), '', 'array');
        $resumeid = $cid[0];
        $user = JFactory::getUser();
        $uid = $user->id;
        $resume_model = $this->getmodel('Resume', 'JSJobsModel');
        $return_value = $resume_model->resumeEnforceDelete($resumeid, $uid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'resume','message');
        } elseif ($return_value == 2) {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'resume','error');
        } elseif ($return_value == 3) {
            JSJOBSActionMessages::setMessage(NOT_YOUR, 'resume','warning');
        }
        $layout = JRequest::getVar('callfrom','empapps');
        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout='.$layout;
        
        $this->setRedirect($link);
    }

    function resumeapprove() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $appid = JRequest::getVar('id');
        
        $resume_model = $this->getmodel('Resume', 'JSJobsModel');
        $return_value = $resume_model->empappApprove($appid);

        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(APPROVED, 'resume','message');
        } else
            JSJOBSActionMessages::setMessage(APPROVE_ERROR, 'resume','error');
        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=appqueue';
        $this->setRedirect($link);
    }

    function resumereject() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $appid = JRequest::getVar('id');

        $resume_model = $this->getmodel('Resume', 'JSJobsModel');
        $return_value = $resume_model->empappReject($appid);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(REJECTED, 'resume','message');
        } else
            JSJOBSActionMessages::setMessage(REJECT_ERROR, 'resume','error');
        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=appqueue';
        $this->setRedirect($link);
    }

    function saveresume() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $resume_model = $this->getmodel('Resume', 'JSJobsModel');
        $return_value = $resume_model->storeResume();
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(SAVED, 'resume','message');
            $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=empapps';
            $this->setRedirect($link);
        } elseif ($return_value == 2) {
            JSJOBSActionMessages::setMessage(REQUIRED_FIELDS, 'resume','error');
            $link = 'index.php?option=com_jsjobs&c=&view=&layout=formemp';
            $this->setRedirect($link);
        } elseif ($return_value == 6) { // file type mismatch
            JSJOBSActionMessages::setMessage(FILE_TYPE_ERROR, 'resume','warning');
            $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=empapps';
            $this->setRedirect($link);
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'resume','error');
            $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=empapps';
            $this->setRedirect($link);
        }
    }

    function remove() { 
        $resume_model = $this->getmodel('Resume', 'JSJobsModel');
        $returnvalue = $resume_model->deleteResume();
        if ($returnvalue == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'resume','message');
        } else {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'resume','error');
        }
        $layout = JRequest::getVar('callfrom','empapps');
        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout='.$layout;
        $this->setRedirect($link);
    }

    function cancel() {
        JSJOBSActionMessages::setMessage(OPERATION_CANCELLED, 'resume','notice');
        $this->setRedirect('index.php?option=com_jsjobs&c=resume&view=resume&layout=empapps');
    }

    function edit() {
        JRequest::setVar('layout', 'formresume');
        JRequest::setVar('view', 'resume');
        JRequest::setVar('c', 'resume');
        $layout = JRequest::getVar('callfrom','empapps');
        JRequest::setVar('callfrom', $layout);
        $this->display();
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory::getDocument();
        $viewName = JRequest::getVar('view', 'resume');
        $layoutName = JRequest::getVar('layout', 'resume');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        if (!JError::isError($jobsharing_model) && !JError::isError($configuration_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }
}
?>