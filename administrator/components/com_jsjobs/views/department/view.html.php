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

class JSJobsViewDepartment extends JSView {

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        if ($layoutName == 'formdepartment') {
            if (isset($_GET['cid'][0]))
                $c_id = $_GET['cid'][0];
            else
                $c_id = '';
            if ($c_id == '') {
                $cids = JRequest::getVar('cid', array(0), 'post', 'array');
                $c_id = $cids[0];
            }
            if (is_numeric($c_id) == true)
                $result = $this->getJSModel('department')->getDepartmentById($c_id, $uid);
            if (isset($result[0]->id))
                $isNew = false;
            $text = $isNew ? JText::_('Add') : JText::_('Edit');
            JToolBarHelper::title(JText::_('Department') . ': <small><small>[ ' . $text . ' ]</small></small>');
            $this->assignRef('department', $result[0]);
            $this->assignRef('lists', $result[1]);
            $this->assignRef('uid', $uid);
            JToolBarHelper::save('department.savedepatrment');
            if ($isNew)
                JToolBarHelper::cancel('department.cancel');
            else
                JToolBarHelper::cancel('department.cancel', 'Close');
        }elseif ($layoutName == 'departmentqueue') { 
            JToolBarHelper::title(JText::_('Department Queue'));
            $searchcompany = $mainframe->getUserStateFromRequest($option . 'searchcompany', 'searchcompany', '', 'string');
            $searchdepartment = $mainframe->getUserStateFromRequest($option . 'searchdepartment', 'searchdepartment', '', 'string');
            $result = $this->getJSModel('department')->getDepartments( 2, $searchcompany, $searchdepartment, '', $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            $lists = $result[2];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            $this->assignRef('lists', $lists);
        }elseif ($layoutName == 'departments') { 
            JToolBarHelper::title(JText::_('Departments'));
            JToolBarHelper::addNew('department.add');
            JToolBarHelper::editList('department.edit');
            JToolBarHelper::deleteList(JText::_("Are You Sure?"), 'department.remove');
            $companyid = JRequest::getVar('md');
            $searchcompany = $mainframe->getUserStateFromRequest($option . 'searchcompany', 'searchcompany', '', 'string');
            $searchdepartment = $mainframe->getUserStateFromRequest($option . 'searchdepartment', 'searchdepartment', '', 'string');
            $searchstatus = $mainframe->getUserStateFromRequest($option . 'searchstatus', 'searchstatus', '', 'string');
            $result = $this->getJSModel('department')->getDepartments( 1, $searchcompany, $searchdepartment, $searchstatus, $limitstart, $limit , $companyid);
            $items = $result[0];
            $total = $result[1];
            $lists = $result[2];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            $this->assignRef('lists', $lists);
            $this->assignRef('companyid', $companyid);
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

}

?>
