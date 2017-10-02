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

jimport('joomla.application.component.view');
jimport('joomla.html.pagination');

class JSJobsViewJob extends JSView {

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
        if ($layoutName == 'formjob') { // form job
            if (isset($_GET['cid'][0]))
                $c_id = $_GET['cid'][0];
            else
                $c_id = '';
            if ($c_id == '') {
                $cids = JRequest::getVar('cid', array(0), 'post', 'array');
                $c_id = $cids[0];
            }
            if (is_numeric($c_id) == true)
                $result = $this->getJSModel('job')->getJobbyId($c_id, $uid);
            $this->assignRef('job', $result[0]);
            $this->assignRef('lists', $result[1]);
            $this->assignRef('userfields', $result[2]);
            $this->assignRef('fieldsordering', $result[3]);
            $callfrom = JRequest::getVar('callfrom','jobs');
            $this->assignRef('callfrom',$callfrom);
            if (isset($result[4]))
                $this->assignRef('multiselectedit', $result[4]);

            if (isset($result[0]->id))
                $isNew = false;
            $text = $isNew ? JText::_('Add') : JText::_('Edit');
            JToolBarHelper::title(JText::_('Job') . ': <small><small>[ ' . $text . ' ]</small></small>');

            JToolBarHelper::save('job.savejob');
            if ($isNew)
                JToolBarHelper::cancel('job.cancel');
            else
                JToolBarHelper::cancel('job.cancel', 'Close');
        }elseif ($layoutName == 'jobqueue') { // job queue
            JToolBarHelper::title(JText::_('Jobs Approval Queue'));
            $form = 'com_jsjobs.jobqueue.list.';
            $datafor = 2;
            $companyname = $mainframe->getUserStateFromRequest($form . 'companyname', 'companyname','','string');
            $jobtitle = $mainframe->getUserStateFromRequest($form . 'jobtitle', 'jobtitle','','string');
            $jobcategory = $mainframe->getUserStateFromRequest($form . 'jobcategory', 'jobcategory','','string');
            $jobtype = $mainframe->getUserStateFromRequest($form . 'jobtype', 'jobtype','','string');
            $location = $mainframe->getUserStateFromRequest($form . 'location', 'location','','string');
            $dateto = $mainframe->getUserStateFromRequest($form . 'dateto', 'dateto','','string');
            $datefrom = $mainframe->getUserStateFromRequest($form . 'datefrom', 'datefrom','','string');
            $status = '';
            $isgfcombo = $mainframe->getUserStateFromRequest($form . 'isgfcombo', 'isgfcombo','','string');
            $sortby = JRequest::getVar('sortby','asc');
            $my_click = JRequest::getVar('my_click');
            if($my_click==1){
                $sortby = $this->getSortArg($sortby);
            }
            $js_sortby = JRequest::getVar('js_sortby');

            $result = $this->getJSModel('job')->getAllJobs($datafor, $companyname, $jobtitle, $jobcategory, $jobtype, $location, $dateto, $datefrom, $status, $isgfcombo, $sortby, $js_sortby, $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            $lists = $result[2];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            $this->assignRef('lists', $lists);
            $this->assignRef('js_sortby', $js_sortby);
            $this->assignRef('sort', $sortby);
        }elseif ($layoutName == 'jobs') { //jobs
            JToolBarHelper::title(JText::_('Jobs'));
            JToolBarHelper::addNew('job.add');
            JToolBarHelper::editList('job.edit');
            JToolBarHelper::deleteList(JText::_('Are You Sure?'), 'job.remove');
            JToolBarHelper::cancel('job.cancel');
            $form = 'com_jsjobs.jobs.list.';

            $datafor = 1;
            $companyname = $mainframe->getUserStateFromRequest($form . 'companyname', 'companyname','','string');
            $jobtitle = $mainframe->getUserStateFromRequest($form . 'jobtitle', 'jobtitle','','string');
            $jobcategory = $mainframe->getUserStateFromRequest($form . 'jobcategory', 'jobcategory','','string');
            $jobtype = $mainframe->getUserStateFromRequest($form . 'jobtype', 'jobtype','','string');
            $location = $mainframe->getUserStateFromRequest($form . 'location', 'location','','string');
            $dateto = $mainframe->getUserStateFromRequest($form . 'dateto', 'dateto','','string');
            $datefrom = $mainframe->getUserStateFromRequest($form . 'datefrom', 'datefrom','','string');
            $status = $mainframe->getUserStateFromRequest($form . 'status', 'status','','string');
            $isgfcombo = $mainframe->getUserStateFromRequest($form . 'isgfcombo', 'isgfcombo','','string');
            $sortby = JRequest::getVar('sortby','asc');
            $my_click = JRequest::getVar('my_click');
            if($my_click==1){
                $sortby = $this->getSortArg($sortby);
            }
            $js_sortby = JRequest::getVar('js_sortby');

            $result = $this->getJSModel('job')->getAllJobs($datafor, $companyname, $jobtitle, $jobcategory, $jobtype, $location, $dateto, $datefrom, $status, $isgfcombo, $sortby, $js_sortby, $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            $lists = $result[2];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            $this->assignRef('lists', $lists);
            $this->assignRef('js_sortby', $js_sortby);
            $this->assignRef('sort', $sortby);
        }

        $this->assignRef('config', $config);
        $this->assignRef('application', $application);
        $this->assignRef('items', $items);
        $this->assignRef('theme', $theme);
        $this->assignRef('option', $option);
        $this->assignRef('uid', $uid);
        $this->assignRef('msg', $msg);
        $this->assignRef('isjobsharing', $_client_auth_key);

        parent::display($tpl);
    }
        function getSortArg($sort) {
        if ($sort == 'asc')
            return "desc";
        else
            return "asc";
    }    

}
?>