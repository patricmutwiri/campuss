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

class JSJobsControllerExport extends JSController {

    function __construct() {
        parent::__construct();
        $this->registerTask('add', 'edit');
    }

    function exportallresume() {
        $jobid = JRequest::getVar('bd');
        require_once (JPATH_ROOT.'/components/com_jsjobs/models/export.php');
        $export_model = new JSJobsModelExport();
        $return_value = $export_model->setAllExport($jobid);
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
            JFactory::getApplication()->close();
        } else {
            //echo $return_value ;
            JSJOBSActionMessages::setMessage('Error in exporting resume', 'resume','message');
        }
        $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=jobappliedresume&oi=' . $jobid;
        $this->setRedirect($link);
    }

    function exportresume() {
        $jobid = JRequest::getVar('bd');
        $resumeid = JRequest::getVar('rd');
        require_once (JPATH_ROOT.'/components/com_jsjobs/models/export.php');
        $export_model = new JSJobsModelExport();
        $return_value = $export_model->setExport($jobid, $resumeid);
        if ($return_value == true) {
            $msg = JText ::_('Resume Export');
            // Push the report now!
            $this->name = 'export-resume';
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=" . $this->name . ".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            header("Lacation: excel.htm?id=yes");
            print $return_value;
            JFactory::getApplication()->close();
        } else {
            JSJOBSActionMessages::setMessage('Error in exporting resume', 'settings','message');
        }
        $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=jobappliedresume&oi=' . $jobid;
        $this->setRedirect($link);
    }

    /* END EXPORT RESUMES */

    function display($cachable = false, $urlparams = false) {
        $document = JFactory::getDocument();
        $viewName = JRequest::getVar('view', 'export');
        $layoutName = JRequest::getVar('layout', 'export');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $model = $this->getModel('jsjobs', 'JSJobsModel');
        if (!JError::isError($model)) {
            $view->setModel($model, true);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>