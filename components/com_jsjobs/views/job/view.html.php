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
        require_once(JPATH_COMPONENT . '/views/common.php');
        $viewtype = 'html';

        if ($layout == 'formjob') {            // form job
            $page_title .= ' - ' . JText::_('Job Information');
            $jobid = $this->getJSModel('common')->parseId(JRequest::getVar('bd', ''));
            $user = JFactory::getUser();
            $result = $this->getJSModel('job')->getJobforForm($jobid, $uid, '', $user->guest);
            if (is_array($result)) {
                $this->assignRef('job', $result[0]);
                $this->assignRef('lists', $result[1]);
                $this->assignRef('userfields', $result[2]);
                $this->assignRef('fieldsordering', $result[3]);
                $this->assignRef('canaddnewjob', $result[4]);
                $this->assignRef('packagedetail', $result[5]);
                $this->assignRef('packagecombo', $result[6]);
                $this->assignRef('isuserhascompany', $result[7]);
                if (isset($result[8]))
                    $this->assignRef('multiselectedit', $result[8]);
                JHTML::_('behavior.formvalidation');
            }elseif ($result == 3) {
                $validate = $this->getJSModel('permissions')->checkPermissionsFor("ADD_JOB"); // can add
                $this->assignRef('canaddnewjob', $validate);
                $this->assignRef('isuserhascompany', $result);
            }
        } elseif ($layout == 'formjob_visitor') {
            if (isset($_GET['email']))
                $companyemail = $_GET['email'];
            $companyemail = JRequest::getVar('email', '');
            if (!isset($companyemail))
                $companyemail = '';

            $vis_jobid = $this->getJSModel('common')->parseId(JRequest::getVar('bd', ''));
            if (!isset($vis_jobid))
                $vis_jobid = '';
            $result = $this->getJSModel('company')->getCompanybyIdforForm('', $uid, 1, $companyemail, $vis_jobid);
            $this->assignRef('company', $result[0]);
            $this->assignRef('companylists', $result[1]);
            $this->assignRef('companyuserfields', $result[2]);
            $this->assignRef('companyfieldsordering', $result[3]);
            $this->assignRef('canaddnewcompany', $result[4]);
            $this->assignRef('companypackagedetail', $result[5]);
            if (isset($result[6]))
                $this->assignRef('vmultiselecteditcompany', $result[6]);
            $result = $this->getJSModel('job')->getJobforForm('', $uid, $vis_jobid, 1);
            $this->assignRef('job', $result[0]);
            $this->assignRef('lists', $result[1]);
            $this->assignRef('userfields', $result[2]);
            $this->assignRef('fieldsordering', $result[3]);
            $this->assignRef('canaddnewjob', $result[4]);
            $this->assignRef('packagedetail', $result[5]);
            $this->assignRef('packagedetail', $result[5]);
            if (isset($result[8]))
                $this->assignRef('vmultiselecteditjob', $result[8]);
            JHTML::_('behavior.formvalidation');
            $result1 = $this->getJSModel('common')->getCaptchaForForm();
            $this->assignRef('captcha', $result1);
        }elseif ($layout == 'myjobs') {        // my jobs
            $page_title .= ' - ' . JText::_('My Jobs');
            $myjobs_allowed = $this->getJSModel('permissions')->checkPermissionsFor("MY_JOB");
            if ($myjobs_allowed == VALIDATE) {
                $sort = JRequest::getVar('sortby', '');
                //visitor jobid
                $vis_email = JRequest::getVar('email', '');
				$jobid = JRequest::getVar('bd', '');
                if (isset($sort)) {
                    if ($sort == '')
                        $sort = 'createddesc';
                } else {
                    $sort = 'createddesc';
                }
                $sortby = $this->getJobListOrdering($sort);
                $result = $this->getJSModel('job')->getMyJobs($uid, $sortby, $limit, $limitstart, $vis_email, $jobid);

                $sortlinks = $this->getJobListSorting($sort);
                $sortlinks['sorton'] = $sorton;
                $sortlinks['sortorder'] = $sortorder;
                $this->assignRef('jobs', $result[0]);
                $this->assignRef('fieldsordering', $result[2]);
                if (isset($result[1])) {
                    if ($result[1] <= $limitstart)
                        $limitstart = 0;
                    $pagination = new JPagination($result[1], $limitstart, $limit);
                    $this->assignRef('pagination', $pagination);
                }
                $this->assignRef('sortlinks', $sortlinks);
            }
            $this->assignRef('myjobs_allowed', $myjobs_allowed);
        }elseif ($layout == 'view_job') { // view job
            $jobid = $this->getJSModel('common')->parseId(JRequest::getVar('bd', ''));
            $result = $this->getJSModel('job')->getJobbyId($jobid);
            $job = $result[0];
            $job_title = isset($job->title) ? $job->title : '';
            $job_description = isset($job->description) ? $job->description : '';
            $document->setMetaData('title', $job_title, true);
            $document->setDescription($job_description);
            $this->assignRef('job', $result[0]);
            $this->assignRef('userfields', $result[2]);
            $this->assignRef('fieldsordering', $result[3]);
            $this->assignRef('fieldsorderingcompany', $result[4]);
            $this->assignRef('listjobconfig', $result[5]);
            $nav = JRequest::getVar('nav', '');
            $this->assignRef('nav', $nav);
            $catid = JRequest::getVar('cat', '');
            $this->assignRef('catid', $catid);
            $jobsubcatid = JRequest::getVar('jobsubcat', '');
            $this->assignRef('jobsubcatid', $jobsubcatid);
            if (isset($job)) {
                $page_title .= ' - ' . $job->title;
                $document->setDescription($job->metadescription);
                $document->setMetadata('keywords', $job->metakeywords);
            }
        } elseif ($layout == 'jobsearch') { // job search 
            $page_title .= ' - ' . JText::_('Search Job');
            $myjobsearch_allowed = $this->getJSModel('permissions')->checkPermissionsFor("JOB_SEARCH");
            if ($myjobsearch_allowed == VALIDATE) {
                $result = $this->getJSModel('jobsearch')->getSearchOptions($uid);
                $this->assignRef('searchoptions', $result[0]);
                $this->assignRef('searchjobconfig', $result[1]);
                $this->assignRef('canview', $result[2]);
            }
            $this->assignRef('myjobsearch_allowed', $myjobsearch_allowed);
        } elseif ($layout == 'jobs') {
            // we have to reset old states on every call 
            $mainframe = JFactory::getApplication();
            $option = 'com_jsjobs';
            $mainframe->setUserState($option.'company',array());
            $mainframe->setUserState($option.'category',array());
            $mainframe->setUserState($option.'jobsubcategory',array());
            $mainframe->setUserState($option.'careerlevel',array());
            $mainframe->setUserState($option.'shift',array());
            $mainframe->setUserState($option.'jobtype',array());
            $mainframe->setUserState($option.'jobstatus',array());
            $mainframe->setUserState($option.'workpermit',array());
            $mainframe->setUserState($option.'education',array());

            $mainframe->setUserState($option . 'metakeywords','');
            $mainframe->setUserState($option . 'jobtitle','');
            $mainframe->setUserState($option . 'gender','');
            $mainframe->setUserState($option . 'agestart','');
            $mainframe->setUserState($option . 'ageend','');
            $mainframe->setUserState($option . 'currencyid','');
            $mainframe->setUserState($option . 'srangestart','');
            $mainframe->setUserState($option . 'srangeend','');
            $mainframe->setUserState($option . 'srangetype','');
            $mainframe->setUserState($option . 'experiencemin','');
            $mainframe->setUserState($option . 'experiencemax','');
            $mainframe->setUserState($option . 'city','');
            $mainframe->setUserState($option . 'requiredtravel','');
            $mainframe->setUserState($option . 'duration','');
            $mainframe->setUserState($option . 'zipcode','');
            $mainframe->setUserState($option . 'startpublishing','');
            $mainframe->setUserState($option . 'stoppublishing','');
            $mainframe->setUserState($option . 'longitude','');
            $mainframe->setUserState($option . 'latitude','');
            $mainframe->setUserState($option . 'radius','');
            $mainframe->setUserState($option . 'radiuslengthtype','');

            // custmo field
            $data = getCustomFieldClass()->userFieldsData(2);
            foreach ($data as $uf) {
                switch ($uf->userfieldtype) {
                    case 'multiple':
                    case 'checkbox':
                        $mainframe->setUserState( $option.$uf->field, array());
                        break;
                    default:
                        $mainframe->setUserState( $option.$uf->field, '');
                    break;
                }
            }
            // custmo End

            $page_title .= ' - ' . JText::_('Newest Jobs');
            $result = $this->getJSModel('job')->getJobs();

            $issearchform = JRequest::getVar('issearchform',null,'post');
            if($issearchform !== null){
                $this->assignRef('issearchform', $issearchform);
            }
        
            $search = JRequest::getVar('search',null,'get');
            if($search != null){
                $search = 1;
                $this->assignRef('isfromsavesearch', $search);
            }

            
            $this->assignRef('jobs', $jobs);
            $this->assignRef('pagination', $pagination);
            
            $this->assignRef('fieldsordering', $result[2]); // forsearch form
            
            $this->assignRef('fieldsforview', $result[6]); // for listview
         
            $this->assignRef('jobs_filters', $result[3]);  // filtered vars
            
            $this->assignRef('search_combo', $result[4]);  // combo boxes
            $this->assignRef('multicities', $result[5]);  // multicities

            $searchjobconfig = $this->getJSModel('configurations')->getConfigByFor('searchjob');

            $this->assignRef('searchjobconfig',$searchjobconfig);

            $jobs = $result[0];
            if ($result[1] <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($result[1], $limitstart, $limit);

        }elseif ($layout == 'listjobtypes') {
            $page_title .= ' - ' . JText::_('Job By Types');
            $result = $this->getJSModel('job')->getJobTypes();
            $this->assignRef('jobtypes', $result);
        }
        require_once('job_breadcrumbs.php');
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

    function getJobListSorting($sort) {
        $sortlinks['title'] = $this->getSortArg("title", $sort);
        $sortlinks['category'] = $this->getSortArg("category", $sort);
        $sortlinks['jobtype'] = $this->getSortArg("jobtype", $sort);
        $sortlinks['jobstatus'] = $this->getSortArg("jobstatus", $sort);
        $sortlinks['company'] = $this->getSortArg("company", $sort);
        $sortlinks['salaryrange'] = $this->getSortArg("salaryto", $sort);
        $sortlinks['country'] = $this->getSortArg("country", $sort);
        $sortlinks['created'] = $this->getSortArg("created", $sort);
        $sortlinks['apply_date'] = $this->getSortArg("apply_date", $sort);

        return $sortlinks;
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
            case "companydesc": $ordering = "company.name DESC";
                $sorton = "company";
                $sortorder = "DESC";
                break;
            case "companyasc": $ordering = "company.name ASC";
                $sorton = "company";
                $sortorder = "ASC";
                break;
            case "salarytoasc": $ordering = "job.salaryrangefrom ASC";
                $sorton = "salaryrange";
                $sortorder = "ASC";
                break;
            case "salarytodesc": $ordering = "job.salaryrangefrom DESC";
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
