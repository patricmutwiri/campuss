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

class JSJobsControllerResumesearch extends JSController {

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

    function saveresumesearch() { //save resume search
        $uid = JRequest::getString('uid', 'none');
        $Itemid = JRequest::getVar('Itemid');
        $searchdata = JRequest::get('post');
        $user = JFactory::getUser();
        $searcharray = json_decode(JSModel::getJSModel('common')->b64ForDecode($searchdata['searchcriteria']), true);

        $data['uid'] = $user->id;
        $data['searchname'] = isset($searchdata['searchname']) ? $searchdata['searchname'] : "";
        $data['created'] = date('Y-m-d H:i:s');
        $data['params'] = isset($searcharray['params']) ? json_encode($searcharray['params']) : "";
        $data['searchparams'] = json_encode($searcharray);
        $data['status'] = 1;
        
        $resumesearch = $this->getmodel('Resumesearch', 'JSJobsModel');
        $return_value = $resumesearch->storeResumeSearch($data);

        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(SAVED, 'search','message');
        } elseif ($return_value == 3) {
            JSJOBSActionMessages::setMessage('Limit exceed or admin block this', 'search','notice');
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'search','error');
        }
        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=resume_searchresults&Itemid=' . $Itemid;
        $this->setRedirect(JRoute::_($link , false));
    }

    function deleteresumesearch() { //delete resume search
        $session = JFactory::getSession();
        $user = JFactory::getUser();
        $uid = $user->id;
        $Itemid = JRequest::getVar('Itemid');
        $data = JRequest::get('post');
        $link = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=my_resumesearches&Itemid=' . $Itemid;
        $searchid = JRequest::getVar('rs');
        $resumesearch = $this->getmodel('Resumesearch', 'JSJobsModel');
        $return_value = $resumesearch->deleteResumeSearch($searchid, $uid);

        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'search','message');
        } elseif ($return_value == 2) {
            JSJOBSActionMessages::setMessage(NOT_YOUR, 'search','notice');
        } else {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'search','error');
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
    