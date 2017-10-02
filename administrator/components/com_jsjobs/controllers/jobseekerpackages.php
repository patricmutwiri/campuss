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

class JSJobsControllerJobseekerpackages extends JSController {

    function __construct() {
        parent::__construct();
        $this->registerTask('add', 'edit');
    }

    function savejobseekerpackage() {
        $jobseekerpackages_model = $this->getmodel('Jobseekerpackages', 'JSJobsModel');
        $return_value = $jobseekerpackages_model->storeJobSeekerPackage();
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(SAVED, 'package','message');
            $link = 'index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=jobseekerpackages';
            $this->setRedirect($link);
        } else if ($return_value == 2) {
            JSJOBSActionMessages::setMessage(REQUIRED_FIELDS, 'package','error');
            $link = 'index.php?option=com_jsjobs&task=jobseekerpackages.edit&cid[]='.JRequest::getVar('id');
            $this->setRedirect($link);
        } else {
            JSJOBSActionMessages::setMessage(SAVE_ERROR, 'package','error');
            $link = 'index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=jobseekerpackages';
            $this->setRedirect($link);
        }
    }

    function edit() {
        JRequest::setVar('layout', 'formjobseekerpackage');
        JRequest::setVar('view', 'jobseekerpackages');
        JRequest::setVar('c', 'jobseekerpackages');
        $this->display();
    }

    function remove() {
        $jobseekerpackages_model = $this->getmodel('Jobseekerpackages', 'JSJobsModel');
        $returnvalue = $jobseekerpackages_model->deleteJobSeekerPackage();
        if ($returnvalue == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'package','message');
        } else {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'package','error');
        }
        $this->setRedirect('index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=jobseekerpackages');
    }

    function cancel() {
        JSJOBSActionMessages::setMessage(OPERATION_CANCELLED, 'package','notice');
        $this->setRedirect('index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=jobseekerpackages');
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory::getDocument();
        $viewName = JRequest::getVar('view', 'jobseekerpackages');
        $layoutName = JRequest::getVar('layout', 'jobseekerpackages');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $jobseekerpackages_model = $this->getModel('Jobseekerpackages', 'JSJobsModel');
        if (!JError::isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($jobseekerpackages_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($jobseekerpackages_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>