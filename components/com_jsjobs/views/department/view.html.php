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
        require_once(JPATH_COMPONENT . '/views/common.php');
        $viewtype = 'html';

        if ($layout == 'mydepartments') {        // my departments
            $page_title .= ' - ' . JText::_('My Departments');
            $mydepartment_allowed = $this->getJSModel('permissions')->checkPermissionsFor("MY_DEPARTMENT");
            if ($mydepartment_allowed == VALIDATE) {
                $result = $this->getJSModel('department')->getMyDepartments($uid, $limit, $limitstart);
                $departments = $result[0];
                $totalresults = $result[1];
                $this->assignRef('departments', $departments);
                if ($result[1] <= $limitstart)
                    $limitstart = 0;
                $pagination = new JPagination($result[1], $limitstart, $limit);
                $this->assignRef('pagination', $pagination);
            }
            $this->assignRef('mydepartment_allowed', $mydepartment_allowed);
        }elseif ($layout == 'view_department') {                // view company
            $departmentid = $this->getJSModel('common')->parseId(JRequest::getVar('pd', ''));
            $department = $this->getJSModel('department')->getDepartmentbyId($departmentid);
            $this->assignRef('department', $department);
            if (isset($department)) {
                $page_title .= ' - ' . $department->name;
            }
        } elseif ($layout == 'formdepartment') {         //form department
            $page_title .= ' - ' . JText::_('Department Information');
            $formdepartment_allowed = $this->getJSModel('permissions')->checkPermissionsFor("ADD_DEPARTMENT");
            if ($formdepartment_allowed == VALIDATE) {
                $departmentid = $this->getJSModel('common')->parseId(JRequest::getVar('pd', ''));
                $result = $this->getJSModel('department')->getDepartmentByIdForForm($departmentid, $uid);
                $this->assignRef('department', $result[0]);
                $this->assignRef('lists', $result[1]);
                JHTML::_('behavior.formvalidation');
            }
            $this->assignRef('formdepartment_allowed', $formdepartment_allowed);
        }
        require_once('department_breadcrumbs.php');
        $document->setTitle($page_title);
        $this->assignRef('userrole', $userrole);
        $this->assignRef('config', $config);
        $this->assignRef('option', $option);
        $this->assignRef('params', $params);
        $this->assignRef('viewtype', $viewtype);
        $this->assignRef('employerlinks', $employerlinks);
        $this->assignRef('jobseekerlinks', $jobseekerlinks);
        $this->assignRef('uid', $uid);
        $this->assignRef('id', $id);
        $this->assignRef('Itemid', $itemid);
        $this->assignRef('isjobsharing', $_client_auth_key);

        parent::display($tpl);
    }

}

?>
