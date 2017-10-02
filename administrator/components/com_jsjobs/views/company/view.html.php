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

class JSJobsViewCompany extends JSView {

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
        if ($layoutName == 'formcompany') {  //form company
            if (isset($_GET['cid'][0]))
                $c_id = $_GET['cid'][0];
            else
                $c_id = '';

            if ($c_id == '') {
                $cids = JRequest::getVar('cid', array(0), 'post', 'array');
                $c_id = $cids[0];
            }
            if (is_numeric($c_id) == true)
                $result = $this->getJSModel('company')->getCompanybyId($c_id);
            $this->assignRef('company', $result[0]);
            $this->assignRef('lists', $result[1]);
            $this->assignRef('userfields', $result[2]);
            $callfrom = JRequest::getvar('callfrom','companies');
            $this->assignRef('callfrom', $callfrom);
            $this->assignRef('fieldsordering', $result[3]);
            if (isset($result[4]))
                $this->assignRef('multiselectedit', $result[4]);
            $this->assignRef('uid', $uid);
            if (isset($result[0]->id))
                $isNew = false;
            $text = $isNew ? JText::_('Add') : JText::_('Edit');
            JToolBarHelper::title(JText::_('Company') . ': <small><small>[ ' . $text . ' ]</small></small>');
            JToolBarHelper::save('company.savecompany');
            if ($isNew)
                JToolBarHelper::cancel('company.cancel');
            else
                JToolBarHelper::cancel('company.cancel', 'Close');
        }elseif ($layoutName == 'companies') { //companies
            JToolBarHelper::title(JText::_('Companies'));
            JToolBarHelper::addNew('company.add');
            JToolBarHelper::editList('company.edit');
            JToolBarHelper::deleteList(JText::_('Are You Sure?'), 'company.remove');
            JToolBarHelper::cancel('company.cancel');            
            $datafor = 1;
            $form = 'com_jsjobs.companies.list.';
            $companyname = $mainframe->getUserStateFromRequest($form . 'companyname', 'companyname', '', 'string');
            $jobcategory = $mainframe->getUserStateFromRequest($form . 'jobcategory', 'jobcategory', '', 'string');
            $dateto = $mainframe->getUserStateFromRequest($form . 'dateto', 'dateto', '', 'string');
            $datefrom = $mainframe->getUserStateFromRequest($form . 'datefrom', 'datefrom', '', 'string');
            $status = $mainframe->getUserStateFromRequest($form . 'status', 'status', '', 'string');
            $isgfcombo = $mainframe->getUserStateFromRequest($form . 'isgfcombo', 'isgfcombo', '', 'string');
            $sortby = JRequest::getVar('sortby','asc');
            $my_click = JRequest::getVar('my_click');
            if($my_click==1){
                $sortby = $this->getSortArg($sortby);
            }
            $js_sortby = JRequest::getVar('js_sortby');
            $result = $this->getJSModel('company')->getAllCompanies($datafor, $companyname, $jobcategory, $dateto, $datefrom, $status, $isgfcombo, $sortby, $js_sortby, $limitstart, $limit);
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
        }elseif ($layoutName == 'companiesqueue') { //companies queue
            JToolBarHelper::title(JText::_('Companies Approval Queue'));
            $form = 'com_jsjobs.companiesqueue.list.';
            $datafor = 2;
            $companyname = $mainframe->getUserStateFromRequest($form . 'companyname', 'companyname', '', 'string');
            $jobcategory = $mainframe->getUserStateFromRequest($form . 'jobcategory', 'jobcategory', '', 'string');
            $dateto = $mainframe->getUserStateFromRequest($form . 'dateto', 'dateto', '', 'string');
            $datefrom = $mainframe->getUserStateFromRequest($form . 'datefrom', 'datefrom', '', 'string');
            $status = '';
            $isgfcombo = $mainframe->getUserStateFromRequest($form . 'isgfcombo', 'isgfcombo', '', 'string');
            $sortby = JRequest::getVar('sortby','asc');
            $my_click = JRequest::getVar('my_click');
            if($my_click==1){
                $sortby = $this->getSortArg($sortby);
            }
            $js_sortby = JRequest::getVar('js_sortby');
            $result = $this->getJSModel('company')->getAllCompanies($datafor, $companyname, $jobcategory, $dateto, $datefrom, $status, $isgfcombo, $sortby, $js_sortby, $limitstart, $limit);
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