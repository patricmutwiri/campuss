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

class JSJobsControllerFilter extends JSController {

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

    function savefilter() { //save filter
        global $mainframe;

        $fileter = $this->getModel('Filter', 'JSJobsModel');


        $session = JFactory::getSession();
        $uid = JRequest::getString('uid', 'none');

        $Itemid = JRequest::getVar('Itemid');
        $data = JRequest::get('post');
        $link = $data['formaction'];
        $return_value = $fileter->storeFilter();

        if ($return_value == 1) {
            $session->clear('jsuserfilter');
            JSJOBSActionMessages::setMessage(SAVED, 'filter','message');
        }else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'filter','error');
        }
        $this->setRedirect(JRoute::_($link , false));
    }

    function deletefilter() { //delete filter
        $uid = JRequest::getString('uid', 'none');
        $Itemid = JRequest::getVar('Itemid');
        $data = JRequest::get('post');
        $link = $data['formaction'];
        $fileter = $this->getmodel('Filter', 'JSJobsModel');
        $return_value = $fileter->deleteUserFilter();
        $session = JFactory::getSession();
        if ($return_value == 1) {
            $session->clear('jsuserfilter');
            JSJOBSActionMessages::setMessage(DELETED, 'filter','message');
        } else {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'filter','error');
        }
        $this->setRedirect(JRoute::_($link , false));
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
    