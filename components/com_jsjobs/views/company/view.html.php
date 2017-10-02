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
        require_once(JPATH_COMPONENT . '/views/common.php');
        $viewtype = 'html';

        if ($layout == 'mycompanies') {        // my companies
            
            $page_title .= ' - ' . JText::_('My Companies');
            $mycompany_allowed = $this->getJSModel('permissions')->checkPermissionsFor("MY_COMPANY");
            if ($mycompany_allowed == VALIDATE) {
                $result = $this->getJSModel('company')->getMyCompanies($uid, $limit, $limitstart);
                $companies = $result[0];
                $this->assignRef('companies', $companies);
                $this->assignRef('fieldsordering', $result[2]);
                if ($result[1] <= $limitstart)
                    $limitstart = 0;
                $pagination = new JPagination($result[1], $limitstart, $limit);
                $this->assignRef('pagination', $pagination);
            }
            $this->assignRef('mycompany_allowed', $mycompany_allowed);
        }elseif ($layout == 'view_company') {                // view company
            $companyid = $this->getJSModel('common')->parseId(JRequest::getVar('cd', ''));
            $result = $this->getJSModel('company')->getCompanybyId($companyid);
            $company = $result[0];
            $company_title = isset($company->name) ? $company->name : '';
            $company_description = isset($company->description) ? $company->description : '';
            $document->setMetaData('title', $company_title, true);
            $document->setDescription($company_description);
            $this->assignRef('company', $company);
            $this->assignRef('userfields', $result[2]);
            $this->assignRef('fieldsordering', $result[3]);
            $nav = JRequest::getVar('nav', '');
            $this->assignRef('nav', $nav);
            $jobcat = JRequest::getVar('cat', '');
            $this->assignRef('jobcat', $jobcat);
            if (isset($company)) {
                $page_title .= ' - ' . $company->name;
            }
        } elseif ($layout == 'formcompany') {           // form company
            $page_title .= ' - ' . JText::_('Company Information');

            $companyid = $this->getJSModel('common')->parseId(JRequest::getVar('cd', ''));
            if (!isset($companyid))
                $companyid = '';
            $result = $this->getJSModel('company')->getCompanybyIdforForm($companyid, $uid, '', '', '');
            $this->assignRef('company', $result[0]);
            $this->assignRef('lists', $result[1]);
            $this->assignRef('userfields', $result[2]);
            $this->assignRef('fieldsordering', $result[3]);
            $this->assignRef('canaddnewcompany', $result[4]);
            $this->assignRef('packagedetail', $result[5]);
            if (isset($result[6]))
                $this->assignRef('multiselectedit', $result[6]);
            JHTML::_('behavior.formvalidation');
        } elseif ($layout == 'company_info') {            // job Details
            //--//
            $companyid = JRequest::getVar('cd');
            $result = $this->getJSModel('company')->getCompanyInfoById($companyid);
            $this->assignRef('info', $result[0]);
            $this->assignRef('jobs', $result[1]);
            $this->assignRef('company', $result[2]);
        } elseif ($layout == 'listallcompanies') {            // List all companies
            $page_title .= ' - ' . JText::_('All Companies');
            $city = $mainframe->getUserStateFromRequest($option . 'city', 'city', '', 'string');
            $result = $this->getJSModel('company')->getAllCompaniesList($city, $limit, $limitstart);
            $this->assignRef('companies', $result[0]);
            $this->assignRef('lists', $result[2]);
            $this->assignRef('fieldsordering', $result[3]);
            if ($result[1] <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($result[1], $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
        }
        require_once('company_breadcrumbs.php');
        $document->setTitle($page_title);
        $this->assignRef('userrole', $userrole);
        $this->assignRef('config', $config);
        $this->assignRef('socailsharing', $socialconfig);
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

    function getJobListSorting($sort) {
        $sortlinks['title'] = $this->getSortArg("title", $sort);
        $sortlinks['category'] = $this->getSortArg("category", $sort);
        $sortlinks['jobtype'] = $this->getSortArg("jobtype", $sort);
        $sortlinks['jobstatus'] = $this->getSortArg("jobstatus", $sort);
        $sortlinks['company'] = $this->getSortArg("company", $sort);
        $sortlinks['salaryto'] = $this->getSortArg("salaryto", $sort);
        $sortlinks['salaryrange'] = $this->getSortArg("salaryrange", $sort);
        $sortlinks['country'] = $this->getSortArg("country", $sort);
        $sortlinks['created'] = $this->getSortArg("created", $sort);
        $sortlinks['apply_date'] = $this->getSortArg("apply_date", $sort);

        return $sortlinks;
    }

    function getSortArg($type, $sort) {
        $mat = array();
        if (preg_match("/(\w+)(asc|desc)/i", $sort, $mat)) {
            if ($type == $mat[1]) {
                return ( $mat[2] == "asc" ) ? "{$type}desc" : "{$type}asc";
            } else {
                return $type . $mat[2];
            }
        }
        return "iddesc";
    }

    function getJobListOrdering($sort) {
        global $sorton, $sortorder;
        switch ($sort) {
            case "titledesc": $ordering = "job.title DESC";
                $sorton = "title";
                $sortorder = "DESC";
                break;
            case "titleasc": $ordering = "job.title ASC";
                $sorton = "title";
                $sortorder = "ASC";
                break;
            case "categorydesc": $ordering = "cat.cat_title DESC";
                $sorton = "category";
                $sortorder = "DESC";
                break;
            case "categoryasc": $ordering = "cat.cat_title ASC";
                $sorton = "category";
                $sortorder = "ASC";
                break;
            case "jobtypedesc": $ordering = "job.jobtype DESC";
                $sorton = "jobtype";
                $sortorder = "DESC";
                break;
            case "jobtypeasc": $ordering = "job.jobtype ASC";
                $sorton = "jobtype";
                $sortorder = "ASC";
                break;
            case "jobstatusdesc": $ordering = "job.jobstatus DESC";
                $sorton = "jobstatus";
                $sortorder = "DESC";
                break;
            case "jobstatusasc": $ordering = "job.jobstatus ASC";
                $sorton = "jobstatus";
                $sortorder = "ASC";
                break;
            case "companydesc": $ordering = "job.company DESC";
                $sorton = "company";
                $sortorder = "DESC";
                break;
            case "companyasc": $ordering = "job.company ASC";
                $sorton = "company";
                $sortorder = "ASC";
                break;
            case "salarytoasc": $ordering = "salary.rangestart ASC";
                $sorton = "salaryrange";
                $sortorder = "ASC";
                break;
            case "salarytodesc": $ordering = "salary.rangestart DESC";
                $sorton = "salaryrange";
                $sortorder = "DESC";
                break;
            case "salaryrangedesc": $ordering = "salary.rangeend DESC";
                $sorton = "salaryrange";
                $sortorder = "DESC";
                break;
            case "salaryrangeasc": $ordering = "salary.rangestart ASC";
                $sorton = "salaryrange";
                $sortorder = "ASC";
                break;
            case "countrydesc": $ordering = "country.name DESC";
                $sorton = "country";
                $sortorder = "DESC";
                break;
            case "countryasc": $ordering = "country.name ASC";
                $sorton = "country";
                $sortorder = "ASC";
                break;
            case "createddesc": $ordering = "job.created DESC";
                $sorton = "created";
                $sortorder = "DESC";
                break;
            case "createdasc": $ordering = "job.created ASC";
                $sorton = "created";
                $sortorder = "ASC";
                break;
            case "apply_datedesc": $ordering = "apply.apply_date DESC";
                $sorton = "apply_date";
                $sortorder = "DESC";
                break;
            case "apply_dateasc": $ordering = "apply.apply_date ASC";
                $sorton = "apply_date";
                $sortorder = "ASC";
                break;
            default: $ordering = "job.id DESC";
        }
        return $ordering;
    }

}

?>
