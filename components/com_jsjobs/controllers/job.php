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

class JSJobsControllerJob extends JSController {

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
    function subcategoriesbycatid(){
        $catid = JRequest::getVar('catid');
        $showall = JRequest::getVar('showall');
        if($showall=='true'){
            $showall = true;
        }else{
            $showall = false;
        }
        $result = $this->getModel('Job','JSJobsModel')->subCategoriesByCatId($catid , $showall);
        echo $result;
        JFactory::getApplication()->close();
    }

    function savejob() { //save job
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        $uid = JRequest::getString('uid', 'none');
        $Itemid = JRequest::getVar('Itemid');
        $job = $this->getmodel('Job', 'JSJobsModel');

        $return_data = $job->storeJob();
        if ($return_data == 1) {
            JSJOBSActionMessages::setMessage(SAVED, 'job','message');
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=myjobs&Itemid=' . $Itemid;
        } else if ($return_data == 2) {
            JSJOBSActionMessages::setMessage(REQUIRED_FIELDS, 'job','warning');
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=formjob&Itemid=' . $Itemid;
        } else if ($return_data == 11) { // start date not in oldate
            JSJOBSActionMessages::setMessage('Start date not old date', 'job','warning');
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=formjob&Itemid=' . $Itemid;
        } else if ($return_data == 12) {
            JSJOBSActionMessages::setMessage('Start date can not be less than stop date', 'job','warning');
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=formjob&Itemid=' . $Itemid;
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'job','error');
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=myjobs&Itemid=' . $Itemid;
        }
        $this->setRedirect(JRoute::_($link , false));
    }

    function deletejob() { //delete job
        $user = JFactory::getUser();
        $uid = $user->id;
        $Itemid = JRequest::getVar('Itemid');
        $common = $this->getmodel('Common', 'JSJobsModel');
        $jobid = $common->parseId(JRequest::getVar('bd'));
        $vis_email = JRequest::getVar('email');
        $vis_jobid = $common->parseId(JRequest::getVar('bd'));
        $job = $this->getmodel('Job', 'JSJobsModel');
        $return_value = $job->deleteJob($jobid, $uid, $vis_email, $vis_jobid);
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'job','warning');
        } elseif ($return_value == 2) {
            JSJOBSActionMessages::setMessage(IN_USE, 'job','warning');
        } elseif ($return_value == 3) {
            JSJOBSActionMessages::setMessage(NOT_YOUR, 'job','warning');
        } else {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'job','warning');
        }
        if (($vis_email == '') || ($jobid == ''))
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=myjobs&Itemid=' . $Itemid;
        else
            $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=myjobs&email=' . $vis_email . '&bd=' . $vis_jobid . '&Itemid=' . $Itemid;
        $this->setRedirect(JRoute::_($link , false));
    }

    function mailtocandidate() {
        $user = JFactory::getUser();
        $uid = $user->id;
        $email = JRequest::getVar('email');
        $jobapplyid = JRequest::getVar('jobapplyid');
        $jobapply = $this->getmodel('Jobapply', 'JSJobsModel');
        $returnvalue = $jobapply->getMailForm($uid, $email, $jobapplyid);
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    function sendtocandidate() {
        $val = json_decode(JRequest::getVar('val'), true);
        $emailtemplate = $this->getmodel('Emailtemplate', 'JSJobsModel');
        $returnvalue = $emailtemplate->sendToCandidate($val);
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    function quickview() {
        $jobid = JRequest::getVar('jobid', false);
        //$jobid = $this->getModel('Common', 'JSJobsModel')->parseId($jobid);
        $result = $this->getModel('Quickview', 'JSJobsModel')->getJobQuickViewById($jobid);
        echo $result;
        JFactory::getApplication()->close();
    }

    function getnextjobs() {
        $result = $this->getModel('Job', 'JSJobsModel')->getNextJobs();
        echo $result;
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
    