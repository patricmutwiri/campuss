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

class JSJobsControllerCity extends JSController {

    function __construct() {
        parent::__construct();
        $this->registerTask('add', 'edit');
    }

    function editjobcity() {
        JRequest::setVar('layout', 'formcity');
        JRequest::setVar('view', 'city');
        JRequest::setVar('c', 'city');
        $this->display();
    }

    function deletecity() {
        $session = JFactory::getSession();
        $countryid = $session->get('countryid');
        $stateid = $session->get('stateid');
        $city_model = $this->getmodel('City', 'JSJobsModel');
        $return_value = $city_model->deleteCity();
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'city','message');

        } else {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'city','error');
        }
        $link = 'index.php?option=com_jsjobs&c=city&view=city&layout=cities&ct=' . $countryid . '&sd=' . $stateid;
        $this->setRedirect($link, $msg);
    }

    function publishcities() {
        $session = JFactory::getSession();
        $country = $session->get('countryid');
        $stateid = $session->get('stateid');
        $city_model = $this->getmodel('City', 'JSJobsModel');
        $return_value = $city_model->publishcities();
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(PUBLISHED, 'city','message');
        } else {
            JSJOBSActionMessages::setMessage(PUBLISH_ERROR, 'city','error');
        }

        $link = 'index.php?option=com_jsjobs&c=city&view=city&layout=cities&sd=' . $stateid . '&ct=' . $country;
        $this->setRedirect($link);
    }

    function unpublishcities() {
        $session = JFactory::getSession();
        $country = $session->get('countryid');
        $stateid = $session->get('stateid');
        $city_model = $this->getmodel('City', 'JSJobsModel');
        $return_value = $city_model->unpublishcities();
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(UN_PUBLISHED, 'city','message');
        } else {
            JSJOBSActionMessages::setMessage(UN_PUBLISH_ERROR, 'city','error');
        }

        $link = 'index.php?option=com_jsjobs&c=city&view=city&layout=cities&sd=' . $stateid . '&ct=' . $country;
        $this->setRedirect($link);
    }

    function savecity() {
        $session = JFactory::getSession();
        $countryid = $session->get('countryid');
        $stateid = $session->get('stateid');
        $data = JRequest::get('post');
        if ($data['stateid'])
            $stateid = $data['stateid'];

        $city_model = $this->getmodel('City', 'JSJobsModel');
        $return_value = $city_model->storeCity($countryid, $stateid);
        $link = 'index.php?option=com_jsjobs&c=city&view=city&layout=cities&ct=' . $countryid . '&sd=' . $stateid;
        if (is_array($return_value)) {
            if ($return_value['return_value'] == false) { // jobsharing return value 
                JSJOBSActionMessages::setMessage(SAVED, 'city','message');
                if ($return_value['rejected_value'] != "")
                    JSJOBSActionMessages::setMessage(SHARING_IMPROPER_NAME, 'city','warning');
                if ($return_value['authentication_value'] != "")
                    JSJOBSActionMessages::setMessage(SHARING_AUTH_FAIL, 'city','warning');
                if ($return_value['server_responce'] != "")
                    JSJOBSActionMessages::setMessage(SHARING_SYNCHRONIZE_ERROR, 'city','warning');
                $this->setRedirect($link);
            }elseif ($return_value['return_value'] == true) { // jobsharing return value 
                JSJOBSActionMessages::setMessage(SAVED, 'city','message');
                $this->setRedirect($link);
            }
        } else {
            if ($return_value == 1) {
                JSJOBSActionMessages::setMessage(SAVED, 'city','message');
                $this->setRedirect($link);
            } elseif ($return_value == 3) {
                JSJOBSActionMessages::setMessage(ALREADY_EXIST, 'city','message');
                JRequest::setVar('view', 'city');
                JRequest::setVar('hidemainmenu', 1);
                JRequest::setVar('layout', 'formcity');
                $this->display();
            }elseif ($return_value == 2) {
                JSJOBSActionMessages::setMessage(REQUIRED_FIELDS, 'job','error');
                $link = 'index.php?option=com_jsjobs&c=city&view=city&layout=formcity'.JRequest::getVar('id');
                $this->setRedirect($link);
            } else {
                JSJOBSActionMessages::setMessage(DELETE_ERROR, 'city','message');
                $this->setRedirect($link);
            }
        }
    }

    function cancel() {
        JSJOBSActionMessages::setMessage(OPERATION_CANCELLED, 'city','notice');
        $session = JFactory::getSession();
        $countrycode = $session->get('countryid');
        $this->setRedirect('index.php?option=com_jsjobs&c=city&view=city&layout=cities&ct=' . $countrycode);
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory::getDocument();
        $viewName = JRequest::getVar('view', 'city');
        $layoutName = JRequest::getVar('layout', 'city');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $city_model = $this->getModel('City', 'JSJobsModel');
        if (!JError::isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($city_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($city_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>