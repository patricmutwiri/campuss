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

class JSJobsControllerUserrole extends JSController {

    function __construct() {
        parent::__construct();
        $this->registerTask('add', 'edit');
    }

    function saverole() {
        $userrole_model = $this->getModel('Userrole', 'JSJobsModel');
        $return_value = $userrole_model->storeRole();
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(SAVED, 'userrole','message');
            $link = 'index.php?option=com_jsjobs&task=view&layout=roles';
            $this->setRedirect($link);
        } elseif ($return_value == 2) {
            JSJOBSActionMessages::setMessage(REQUIRED_FIELDS, 'job','error');
            $link = 'index.php?option=com_jsjobs&task=view&layout=roles';
            $this->setRedirect($link);
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'userrole','error');
            $link = 'index.php?option=com_jsjobs&task=view&layout=roles';
            $this->setRedirect($link);
        }
        $link = 'index.php?option=com_jsjobs&c=application&layout=roles';
    }

    function saveuserrole() {
        $userrole_model = $this->getModel('Userrole', 'JSJobsModel');
        $return_value = $userrole_model->storeUserRole();
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(SAVED, 'userrole','message');
            $link = 'index.php?option=com_jsjobs&c=userrole&view=userrole&layout=users';
            $this->setRedirect($link);
        } elseif ($return_value == 2) {
            JSJOBSActionMessages::setMessage(REQUIRED_FIELDS, 'job','error');
            $link = 'index.php?option=com_jsjobs&c=userrole&view=userrole&layout=users';
            $this->setRedirect($link);
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'userrole','error');
            $link = 'index.php?option=com_jsjobs&c=userrole&view=userrole&layout=users';
            $this->setRedirect($link);
        }
    }

    function listuserdataforpackage() {
        $val = JRequest::getVar('val');
        $userrole_model = $this->getModel('Userrole', 'JSJobsModel');
        $returnvalue = $userrole_model->listUserDataForPackage($val);
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    function edit() {
        JRequest::setVar('layout', 'changerole');
        JRequest::setVar('view', 'userrole');
        JRequest::setVar('c', 'userrole');
        $this->display();
    }

    function cancel() {
        JSJOBSActionMessages::setMessage(OPERATION_CANCELLED, 'userrole','notice');
        $this->setRedirect('index.php?option=com_jsjobs&c=userrole&view=userrole&layout=users');
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory::getDocument();
        $viewName = JRequest::getVar('view', 'userrole');
        $layoutName = JRequest::getVar('layout', 'userrole');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $userrole_model = $this->getModel('Userrole', 'JSJobsModel');
        $user_model = $this->getModel('User', 'JSJobsModel');
        if (!JError::isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($userrole_model) && !JError::isError($user_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($userrole_model);
            $view->setModel($user_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>