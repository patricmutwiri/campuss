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

class JSJobsControllerExportResume extends JSController {

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

    function exportallresume() {
        $jobaliasid = JRequest::getVar('bd');
        $common = $this->getmodel('Common', 'JSJobsModel');
        $jobid = $common->parseId($jobaliasid);

        $export = $this->getmodel('Export', 'JSJobsModel');
        $return_value = $export->setAllExport($jobid);
        if ($return_value == true) {
            // Push the report now!
            $msg = JText ::_('Resume Export');
            $name = 'export-resumes';
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=" . $name . ".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            header("Lacation: excel.htm?id=yes");
            print $return_value;
            die();
        } else {
            JSJOBSActionMessages::setMessage('Error in exporting resume', 'resume','error');
        }
        $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=job_appliedapplications&bd=' . $jobaliasid;
        $this->setRedirect(JRoute::_($link , false));
    }

    /* END EXPORT RESUMES */
    function exportresume() {
        $common_model = $this->getModel('Common', 'JSJobsModel');
        $jobaliasid = JRequest::getVar('bd');
        $jobid = $common_model->parseId($jobaliasid);
        $resumealiasid = JRequest::getVar('rd');
        $resumeid = $common_model->parseId($resumealiasid);
        $export_model = $this->getModel('Export', 'JSJobsModel');

        $return_value = $export_model->setExport($jobid, $resumeid);
        if ($return_value == true) {
            // Push the report now!
            $msg = JText ::_('Resume Export');
            $name = 'export-resume';
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=" . $name . ".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            header("Lacation: excel.htm?id=yes");
            print($return_value);
            die();
        } else {
            $msg = JText ::_('Error in exporting resume');
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
    