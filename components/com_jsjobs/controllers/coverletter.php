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

class JSJobsControllerCoverLetter extends JSController {

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

    function savecoverletter() { //save cover letter
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        $uid = JRequest::getString('uid', 'none');
        $Itemid = JRequest::getVar('Itemid');
        $coverletter = $this->getmodel('Coverletter', 'JSJobsModel');
        $return_value = $coverletter->storeCoverLetter();

        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(SAVED, 'coverletter','message');
            $link = 'index.php?option=com_jsjobs&c=coverletter&view=coverletter&layout=mycoverletters&Itemid=' . $Itemid;
        } else if ($return_value == 2) {
            JSJOBSActionMessages::setMessage(REQUIRED_FIELDS, 'coverletter','error');
            $link = 'index.php?option=com_jsjobs&c=coverletter&view=coverletter&layout=formcoverletter&Itemid=' . $Itemid;
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'coverletter','error');
            $link = 'index.php?option=com_jsjobs&c=coverletter&view=coverletter&layout=formcoverletter&Itemid=' . $Itemid;
        }
        $this->setRedirect($link);
    }

    function deletecoverletter() { //delete cover letter
        $user = JFactory::getUser();
        $uid = $user->id;
        $Itemid = JRequest::getVar('Itemid');
        $id = JRequest::getVar('cl', '');
        $common = $this->getmodel('Common', 'JSJobsModel');
        $coverletterid = $common->parseId($id);
        $coverletter = $this->getmodel('Coverletter', 'JSJobsModel');
        $return_value = $coverletter->deleteCoverLetter($coverletterid, $uid);
        $jobsharing = $this->getModel('jobsharingsite', 'JSJobsModel');
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'coverletter','message');
        } elseif ($return_value == 2) {
            JSJOBSActionMessages::setMessage(NOT_YOUR, 'coverletter','error');
        } elseif ($return_value == 3) {
            JSJOBSActionMessages::setMessage(IN_USE, 'coverletter','warning');
        } else {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'coverletter','error');
        }
        $link = 'index.php?option=com_jsjobs&c=coverletter&view=coverletter&layout=mycoverletters&Itemid=' . $Itemid;
        $this->setRedirect(JRoute::_($link , false));
    }

    function getcoverletter() {
        $cletterid = JRequest::getVar('cletterid');
        $coverletter = $this->getmodel('Coverletter', 'JSJobsModel');
        $returnvalue = $coverletter->getCoverLetterForAppliedJob($cletterid);
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
    