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

class JSJobsControllerJobsearch extends JSController {

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

    function savejobsearch() { //save job search

        $searchname = JRequest::getVar('searchname',null,'post');
        $Itemid = JRequest::getVar('Itemid');
        $filtered_vars = JRequest::getVar('searchcriteria',null,'post');
        $filtered_vars = json_decode(JSModel::getJSModel('common')->b64ForDecode($filtered_vars),true);

        
        $data['uid'] = JFactory::getUser()->id;
        $data['searchname'] = $searchname;
        $data['params'] = isset($filtered_vars['params']) ? json_encode($filtered_vars['params']) : "";
        $data['searchparams'] = json_encode($filtered_vars);
        $data['created'] = date('Y-m-d H:i:s');
        $data['status'] = 1;

        $jobsearch = $this->getmodel('Jobsearch', 'JSJobsModel');
        $return_value = $jobsearch->storeJobSearch($data);

        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(SAVED, 'search','message');
        } elseif ($return_value == 3) {
            JSJOBSActionMessages::setMessage('Limit exceed or admin block this', 'search','error');
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'search','error');
        }
        $link = 'index.php?option=com_jsjobs&c=job&view=job&layout=jobs&Itemid='.$Itemid;
        $this->setRedirect(JRoute::_($link , false));
    }

    function deletejobsearch() { //delete job search
        $user = JFactory::getUser();
        $uid = $user->id;
        $Itemid = JRequest::getVar('Itemid');
        $data = JRequest::get('post');
        $link = 'index.php?option=com_jsjobs&c=jobsearch&view=jobsearch&layout=my_jobsearches&Itemid=' . $Itemid;
        $searchid = JRequest::getVar('js');
        $jobsearch = $this->getmodel('Jobsearch', 'JSJobsModel');
        $return_value = $jobsearch->deleteJobSearch($searchid, $uid);

        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'search','message');
        } elseif ($return_value == 2) {
            JSJOBSActionMessages::setMessage(NOT_YOUR, 'search','error');
        } else {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'search','error');
        }
        $this->setRedirect(JRoute::_($link , false));
    }

    function display($cachable = false, $urlparams = false) {
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
