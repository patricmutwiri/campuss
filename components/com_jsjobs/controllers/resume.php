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

JHTML::_('behavior.calendar');
jimport('joomla.application.component.controller');

class JSJobsControllerResume extends JSController {

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

    function subcategoriesbycatidresume(){
        $catid = JRequest::getVar('catid');
        $showall = JRequest::getVar('showall');
        if($showall=='true'){
            $showall = true;
        }else{
            $showall = false;
        }
        $result = $this->getModel('Resume','JSJobsModel')->subCategoriesByCatIdresume($catid , $showall);
        echo $result;
        JFactory::getApplication()->close();
    }


    function deleteresumesection(){
        $resumeid = JRequest::getVar('resumeid');
        $isadmin = JRequest::getVar('isadmin');
        $sectionid = JRequest::getVar('sectionid');
        $section = JRequest::getVar('section');
        $resume = $this->getModel('Resume', 'JSJobsModel');
        $return_value = $resume->deleteSectionById($resumeid,$sectionid,$isadmin,$section);
        echo $return_value;
        JFactory::getApplication()->close();
    }

    function saveresume() {
        $session = JFactory::getSession();
        $user = JFactory::getUser();
        $uid = $user->id;
        $return_value = array();

        if ($uid) {
            $resume = $this->getmodel('Resume', 'JSJobsModel');
            $return_value = $resume->storeResume('');
        } else {
            $visitor = $session->get('jsjob_jobapply');
            $resume = $this->getmodel('Resume', 'JSJobsModel');
            $return_value = $resume->storeResume($visitor['bd']);
        }
        if (is_array($return_value)) {
            $resumeid = $return_value[1];
            echo $resumeid . "," . $return_value[0];
        } elseif ($return_value == false) {
            echo "0,4";
        } else { // incorrect captcha detected
            echo $return_value . ",8";
        }
        JFactory::getApplication()->close();
    }

    function saveresumesection() {
        $session = JFactory::getSession();
        $user = JFactory::getUser();
        $uid = $user->id;

        $resume = $this->getmodel('Resume', 'JSJobsModel');
        $return_value = $resume->storeResumeSection();

        if ($return_value == false) {
            echo 0;
        } else {
            $retuenid = $return_value;
            echo $retuenid;
        }
        JFactory::getApplication()->close();
    }

    function getresume() { // used and created by muhiaudin for new resume form view
        $extension = 'com_jsjobs'; // optional
        $basePath = JPATH_ADMINISTRATOR; // optional
        $lang = 'en-GB'; // optional
        $isadmin = JRequest::getVar('isadmin');
        if($isadmin == 1){
            $lang = JComponentHelper::getParams('com_languages')->get('administrator','en-GB');
        }else{
            $lang = JComponentHelper::getParams('com_languages')->get('site','en-GB');    
        }
        // Sprachdatei laden
        JFactory::getLanguage()->load($extension, $basePath, $lang);
        $resumeModel = $this->getmodel('Resume', 'JSJobsModel');
        $isadmin = JRequest::getVar('isadmin');
        $data = $resumeModel->getResumeSection($isadmin);
        // resume form layout class
        require_once JPATH_COMPONENT . '/views/resume/resumeformlayout.php';
        $resumeformlayout = new JSJobsResumeformlayout();
        $resume = $resumeformlayout->getResumeLayout($data);
        echo $resume;
        JFactory::getApplication()->close();
    }

    function getresumefiles() {
        $resumeid = JRequest::getVar('resumeid');
        $data_directory = $this->getmodel('configurations')->getConfigValue('data_directory');
        $files = array();
        $resumeModel = $this->getmodel('Resume', 'JSJobsModel');
        $files = $resumeModel->getResumeFilesByResumeId($resumeid);
        // resume form layout class
        require_once JPATH_COMPONENT . '/views/resume/resumeformlayout.php';
        $resumeformlayout = new JSJobsResumeformlayout();
        $data = $resumeformlayout->getResumeFilesLayout($files, $data_directory);
        echo $data;
        JFactory::getApplication()->close();
    }

    function getallresumefiles() {
        $resumeModel = $this->getmodel('Resume', 'JSJobsModel');
        $link = $resumeModel->getAllResumeFiles();
        JFactory::getApplication()->close();
    }

    function deleteresumefiles() {
        $resumeModel = $this->getmodel('Resume', 'JSJobsModel');
        $return_value = $resumeModel->deleteResumeFile();
        if (!empty($return_value) && $return_value == 1) {
            $msg = JText::_('File Deleted');
        } else {
            $msg = JText::_('Operation Aborted');
        }
        echo $msg;
        JFactory::getApplication()->close();
    }

    function deleteresume() { //delete resume
        $session = JFactory::getSession();
        $user = JFactory::getUser();
        $uid = $user->id;
        $Itemid = JRequest::getVar('Itemid');
        $common = $this->getmodel('Common', 'JSJobsModel');
        $resumeid = $common->parseId(JRequest::getVar('rd', ''));
        $resume = $this->getmodel('Resume', 'JSJobsModel');
        $return_value = $resume->deleteResume($resumeid, $uid);
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'resume','message');
        } elseif ($return_value == 2) {
            JSJOBSActionMessages::setMessage(IN_USE, 'resume','message');
        } elseif ($return_value == 3) {
            JSJOBSActionMessages::setMessage(NOT_YOUR, 'resume','message');
        } else {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'resume','message');
        }
        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=myresumes&Itemid=' . $Itemid;
        $this->setRedirect(JRoute::_($link , false));
    }

    function getresumedetail() {
        $user = JFactory::getUser();
        $uid = $user->id;
        $jobid = JRequest::getVar('jobid');
        $resumeid = JRequest::getVar('resumeid');
        $resume = $this->getmodel('Resume', 'JSJobsModel');
        $returnvalue = $resume->getResumeDetail($uid, $jobid, $resumeid);
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
    