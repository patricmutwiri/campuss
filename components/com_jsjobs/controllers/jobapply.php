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

class JSJobsControllerJobApply extends JSController {

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

    function applyjob() {
        $visitorapplyjob = 0;
        if (!JFactory::getUser()->guest || $visitorapplyjob == '0') {
            $jobid = JRequest::getVar('jobid', false);
            $result = $this->getModel('Jobapply', 'JSJobsModel')->applyJob($jobid);
            $array[0] = 'popup';
            $array[1] = $result;
            print_r(json_encode($array));
        } else {
            $link = JRoute::_('index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=job_apply&bd=' . JRequest::getVar('jobid', false) . '&Itemid=' . JRequest::getVar('Itemid', false) ,false);
            $array[0] = 'redirect';
            $array[1] = $link;
            print_r(json_encode($array));
        }
        JFactory::getApplication()->close();
    }

    function jobapply() {
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        $uid = JRequest::getString('uid', 'none');
        $Itemid = JRequest::getVar('Itemid');
        $jobapply = $this->getmodel('Jobapply', 'JSJobsModel');
        $return_value = $jobapply->jobapply();
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage('Application successfully applied', 'jobapply','message');
            $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=myappliedjobs&uid=' . $uid . '&Itemid=' . $Itemid;
        } else if ($return_value == 3) {
            JSJOBSActionMessages::setMessage('You already apply to this job', 'jobapply','warning');
            $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=myappliedjobs&Itemid=' . $Itemid;
        } else if ($return_value == 10) {
            $textvar = JText::_('You can not apply to this job').'.'.JText::_('Your job apply limit exceeds');
            JSJOBSActionMessages::setMessage($textvar, 'jobapply','warning');
            $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=myappliedjobs&Itemid=' . $Itemid;
        } else {
            JSJOBSActionMessages::setMessage('Error in applying job', 'jobapply','error');
            $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=myappliedjobs&uid=' . $uid . '&Itemid=' . $Itemid;
        }
        $this->setRedirect(JRoute::_($link , false));
    }

    function jobapplyajax() {
        $uid = JRequest::getString('uid', 'none');
        $jobapply = $this->getmodel('Jobapply', 'JSJobsModel');
        $return_value = $jobapply->jobapply();
        if ($return_value == 1) {
            $msg = JText::_('Application successfully applied');
        } else if ($return_value == 3) {
            $msg = JText::_('You already apply to this job');
        } else if ($return_value == 10) {
            $msg = JText::_('You can not apply to this job. Your job apply limit exceeds');
        } else {
            $msg = JText::_('Error in applying job');
        }
        echo $msg;
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


