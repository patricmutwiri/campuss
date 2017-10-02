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

class JSJobsViewJobseekerpackages extends JSView {

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        if ($layoutName == 'formjobseekerpackage') {          // job seeker
            if (isset($_GET['cid'][0]))
                $c_id = $_GET['cid'][0];
            else
                $c_id = '';
            if ($c_id == '') {
                $cids = JRequest::getVar('cid', array(0), 'post', 'array');
                $c_id = $cids[0];
            }
            if (is_numeric($c_id) == true)
                $result = $this->getJSModel('jobseekerpackages')->getJobSeekerPackagebyId($c_id);
            if (isset($result[0]->id))
                $isNew = false;
            $text = $isNew ? JText::_('Add') : JText::_('Edit');
            JToolBarHelper::title(JText::_('Job Seeker Package') . ': <small><small>[ ' . $text . ' ]</small></small>');
            $this->assignRef('package', $result[0]);
            $this->assignRef('lists', $result[1]);
            $this->assignRef('paymentconfigs', $result[2]);
            $this->assignRef('paymentmethodlink', $paymentmethodlink);
            JToolBarHelper::save('jobseekerpackages.savejobseekerpackage');
            if ($isNew)
                JToolBarHelper::cancel('jobseekerpackages.cancel');
            else
                JToolBarHelper::cancel('jobseekerpackages.cancel', 'Close');
        }elseif ($layoutName == 'jobseekerpackages') {        //job seeker packages
            JToolBarHelper::title(JText::_('Job Seeker Packages'));
            JToolBarHelper::addNew('jobseekerpackages.add');
            JToolBarHelper::editList('jobseekerpackages.edit');
            JToolBarHelper::deleteList(JText::_('Are You Sure?'), 'jobseekerpackages.remove');
            $form = 'com_jsjobs.jobseekerpackage.list.';
            $searchtitle = $mainframe->getUserStateFromRequest($form . 'searchtitle', 'searchtitle', '', 'string');
            $searchprice = $mainframe->getUserStateFromRequest($form . 'searchprice', 'searchprice', '', 'string');
            $searchstatus = $mainframe->getUserStateFromRequest($form . 'searchstatus', 'searchstatus', '', 'string');            
            $result = $this->getJSModel('jobseekerpackages')->getJobSeekerPackages($searchtitle, $searchprice, $searchstatus, $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            $this->assignRef('lists',$result[2]);
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
        }
//        layout end

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

}

?>
