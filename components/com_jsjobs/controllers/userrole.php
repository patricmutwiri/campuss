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

class JSJobsControllerUserRole extends JSController {

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

    function savenewinjsjobs() { //save new in jsjobs
        $session = JFactory::getSession();
        $uid = JRequest::getString('uid', 'none');
        $Itemid = JRequest::getVar('Itemid');
        $data = JRequest::get('post');

        $usertype = $data['usertype'];
        $userrole = $this->getmodel('Userrole', 'JSJobsModel');
        $return_value = $userrole->storeNewinJSJobs();
        $session = JFactory::getSession();
        $session->set('jsjobconfig_dft', '');
        $session->set('jsjobcur_usr', '');

        if ($usertype == 1) { // employer
            $link = 'index.php?option=com_jsjobs&c=jsjobs&view=employer&layout=controlpanel&Itemid=' . $Itemid;
        } elseif ($usertype == 2) {// job seeker
            $link = 'index.php?option=com_jsjobs&c=jsjobs&view=jobseeker&layout=controlpanel&Itemid=' . $Itemid;
        }

        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(SAVED, 'settings','message');
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'settings','error');
        }
        $this->setRedirect(JRoute::_($link , false));
    }

    function checkuserdetail() {
        $val = JRequest::getVar('val');
        $for = JRequest::getVar('fr');
        $common = $this->getmodel('Common', 'JSJobsModel');
        $returnvalue = $common->checkUserDetail($val, $for);
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
    