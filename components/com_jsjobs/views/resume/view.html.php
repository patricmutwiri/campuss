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

class JSJobsViewResume extends JSView {

    function display($tpl = null) {
        require_once(JPATH_COMPONENT . '/views/common.php');
        $viewtype = 'html';

        if ($layout == 'formresume') {            // form resume
            $page_title .= ' - ' . JText::_('Resume Form');
            $resumeid = $this->getJSModel('common')->parseId(JRequest::getVar('rd', ''));
            if($resumeid == ''){
                $resumeid = $session->get('jsjobs_resumeid_for_form','');
            }
            $resume_model = $this->getJSModel('resume');
            $result = $resume_model->getResumebyId($resumeid, $uid);
            if(empty($result[0]) && $resumeid != ''){ // user logout
                $this->getJSModel('permissions');
                $result[4] = VISITOR_NOT_ALLOWED_JOBSEEKER_PRIVATE_AREA;
            }
            $validresume = true;
            if(is_numeric($resumeid)){
                $validresume = $resume_model->checkResumeExists($resumeid);
            }
            $this->assignRef('validresume',$validresume);

            $session = JFactory::getSession();
            if (!$uid) {
                $visitor = $session->get('jsjob_jobapply');
                $this->assignRef('visitor', $visitor);
            }
            $isadmin = 0;
            $resumecountresult = $resume_model->getResumeDataCountById($resumeid);
            $this->assignRef('resumecountresult',$resumecountresult);
            $this->assignRef('resume', $result[0]);
            $this->assignRef('fieldsordering', $result[3]);
            $this->assignRef('canaddnewresume', $result[4]);
            $this->assignRef('packagedetail', $result[5]);
            $this->assignRef('isadmin', $isadmin);
            $nav = JRequest::getVar('nav', '');
            $this->assignRef('nav', $nav);
            JHTML::_('behavior.formvalidation');
            if (!$uid) {
                $result1 = $this->getJSModel('common')->getCaptchaForForm();
                $this->assignRef('captcha', $result1);
            }
        } elseif ($layout == 'resumesearch') {           // resume search
            $page_title .= ' - ' . JText::_('Resume Search  ');
            $result = $this->getJSModel('resume')->getResumeSearchOptions();
            $this->assignRef('searchoptions', $result[0]);
            $this->assignRef('searchresumeconfig', $result[1]);
            $this->assignRef('canview', $result[2]);
        } elseif ($layout == 'myresumes') {            // my resumes
            $page_title .= ' - ' . JText::_('My Resumes');
            $myresume_allowed = $this->getJSModel('permissions')->checkPermissionsFor("MY_RESUME");
            if ($myresume_allowed == VALIDATE) {
                $sort = JRequest::getVar('sortby', '');
                if (isset($sort)) {
                    if ($sort == '') {
                        $sort = 'createddesc';
                    }
                } else {
                    $sort = 'createddesc';
                }
                $sortby = $this->getResumeListOrdering($sort);
                $result = $this->getJSModel('resume')->getMyResumesbyUid($uid, $sortby, $limit, $limitstart);
                $this->assignRef('resumes', $result[0]);
                $this->assignRef('resumestyle', $result[2]);
                if ($result[1] <= $limitstart)
                    $limitstart = 0;
                $pagination = new JPagination($result[1], $limitstart, $limit);
                $this->assignRef('pagination', $pagination);
                $sortlinks = $this->getResumeListSorting($sort);
                $sortlinks['sorton'] = $sorton;
                $sortlinks['sortorder'] = $sortorder;
                $this->assignRef('sortlinks', $sortlinks);
                $this->assignRef('fieldsordering', $result[3]);
            }
            $this->assignRef('myresume_allowed', $myresume_allowed);
        } elseif ($layout == 'my_resumesearches') {            // my resume searches
            $page_title .= ' - ' . JText::_('Resume Save Searches');
            $myresumesearch_allowed = $this->getJSModel('permissions')->checkPermissionsFor("RESUME_SAVE_SEARCH");
            if ($myresumesearch_allowed == VALIDATE) {
                $result = $this->getJSModel('resume')->getMyResumeSearchesbyUid($uid, $limit, $limitstart);
                $this->assignRef('jobsearches', $result[0]);
                if ($result[1] <= $limitstart)
                    $limitstart = 0;
                $pagination = new JPagination($result[1], $limitstart, $limit);
                $this->assignRef('pagination', $pagination);
            }
            $this->assignRef('myresumesearch_allowed', $myresumesearch_allowed);
        } elseif ($layout == 'resumebycategory') {      // Resume By Categories
            $result = $this->getJSModel('resume')->getResumeByCategory($uid);
            $this->assignRef('categories', $result[0]);
            $this->assignRef('canview', $result[1]);
        } elseif ($layout == 'resume_bycategory') {                // Resume By Categories

            $page_title .= ' - ' . JText::_('Resume By Categories');
            $sort = JRequest::getVar('sortby', '');
            if (isset($sort)) {
                if ($sort == '') {
                    $sort = 'create_datedesc';
                }
            } else {
                $sort = 'create_datedesc';
            }
            $jobcategory = $this->getJSModel('common')->parseId(JRequest::getVar('cat', ''));
            $job_subcategory = $this->getJSModel('common')->parseId(JRequest::getVar('resumesubcat', ''));

            $sortby = $this->getResumeListOrdering($sort);

            $result = $this->getJSModel('resume')->getResumeByCategoryId($uid, $jobcategory , $job_subcategory, $sortby, $limit, $limitstart);
            $options = $this->get('Options');
            
            if(is_numeric($jobcategory) AND $jobcategory > 0){
                $catorsubcat = 'cat';
            }elseif(is_numeric($job_subcategory) AND $job_subcategory > 0){
                $catorsubcat = 'resumesubcat';
            }

            $this->assignRef('catorsubcat', $catorsubcat);

            $sortlinks = $this->getResumeListSorting($sort);
            $sortlinks['sorton'] = $sorton;
            $sortlinks['sortorder'] = $sortorder;
            if ($result[1] <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($result[1], $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            $this->assignRef('resumes', $result[0]);
            $this->assignRef('searchresumeconfig', $result[2]);
            $this->assignRef('categoryname', $result[3]);
            $this->assignRef('catid', $result[4]);
            $this->assignRef('subcategories', $result[5]);
            $this->assignRef('fieldsordering', $result[6]);

            $this->assignRef('sortlinks', $sortlinks);
        }elseif ($layout == 'resume_bysubcategory') {                // Resume By Categories
            $page_title .= ' - ' . JText::_('Resume By Subcategory');
            $sort = JRequest::getVar('sortby', '');
            if (isset($sort)) {
                if ($sort == '') {
                    $sort = 'create_datedesc';
                }
            } else {
                $sort = 'create_datedesc';
            }
            $jobsubcategory = $this->getJSModel('common')->parseId(JRequest::getVar('resumesubcat', ''));
            $sortby = $this->getResumeListOrdering($sort);

            $result = $this->getJSModel('resume')->getResumeBySubCategoryId($uid, $jobsubcategory, $sortby, $limit, $limitstart);
            $options = $this->get('Options');
            $sortlinks = $this->getResumeListSorting($sort);
            $sortlinks['sorton'] = $sorton;
            $sortlinks['sortorder'] = $sortorder;
            if ($result[1] <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($result[1], $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            if (isset($result[0]))
                $this->assignRef('resume', $result[0]);
            if (isset($result[2]))
                $this->assignRef('subcategorytitle', $result[2]);
            $this->assignRef('fieldsordering', $result[3]);
            $this->assignRef('resumesubcategory', $jobsubcategory);
            $this->assignRef('sortlinks', $sortlinks);
        }elseif ($layout == 'viewresumesearch') {            // view resume seach
            $page_title .= ' - ' . JText::_('View Resume Search');
            $id = JRequest::getVar('rs', '');
            $save_searched_fields = $this->getJSModel('resumesearch')->getResumeSearchebyId($id);
            

            if ($save_searched_fields->searchparams != null) {
                $search = json_decode($save_searched_fields->searchparams);
            }

            if (isset($search)) {
                $mainframe->setUserState($option . 'title', isset($search->title) ? $search->title : '' );
                $mainframe->setUserState($option . 'name', isset($search->name) ? $search->name : '' );
                $mainframe->setUserState($option . 'searchcity', isset($search->searchcity) ? $search->searchcity : '' );
                $mainframe->setUserState($option . 'zipcode', isset($search->zipcode) ? $search->zipcode : '' );
                $mainframe->setUserState($option . 'keywords', isset($search->keywords) ? $search->keywords : '' );

                $mainframe->setUserState($option . 'nationality', isset($search->nationality) ? $search->nationality : '' );
                $mainframe->setUserState($option . 'jobcategory', isset($search->jobcategory) ? $search->jobcategory : '' );
                $mainframe->setUserState($option . 'jobsubcategory', isset($search->jobsubcategory) ? $search->jobsubcategory : '' );
                $mainframe->setUserState($option . 'jobsalaryrange', isset($search->jobsalaryrange) ? $search->jobsalaryrange : '' );
                $mainframe->setUserState($option . 'jobtype', isset($search->jobtype) ? $search->jobtype : '' );
                $mainframe->setUserState($option . 'heighestfinisheducation', isset($search->heighestfinisheducation) ? $search->heighestfinisheducation : '' );
                $mainframe->setUserState($option . 'gender', isset($search->gender) ? $search->gender : '' );
                $mainframe->setUserState($option . 'iamavailable', isset($search->iamavailable) ? $search->iamavailable : '' );
                $mainframe->setUserState($option . 'currency', isset($search->currency) ? $search->currency : '' );
                $mainframe->setUserState($option . 'experiencemin', isset($search->experiencemin) ? $search->experiencemin : '' );
                $mainframe->setUserState($option . 'experiencemax', isset($search->experiencemax) ? $search->experiencemax : '' );
            }

            // custom field
            if ($save_searched_fields->params != null) {
                $params = json_decode($save_searched_fields->params);    
                $data = getCustomFieldClass()->userFieldsData(3);
                foreach ($data as $uf) {
                    $fname = $uf->field;
                    $value = isset($params->$fname) ? $params->$fname : '';
                    $mainframe->setUserState( $option.$fname, $value);

                }
            }
            // custmo End
            $mainframe->redirect(JRoute::_('index.php?option=com_jsjobs&c=resume&view=resume&layout=resume_searchresults&Itemid=' . $itemid ,false));
        }elseif ($layout == 'resume_searchresults') {                // resume search results
            $page_title .= ' - ' . JText::_('Resume Search Result');
            
            $jsfrom = JRequest::getVar('jsfrom');
            if($jsfrom == 'cpbox'){
                // empty main frame
                $mainframe->setUserState($option . 'title', '' );
                $mainframe->setUserState($option . 'name', '' );
                $mainframe->setUserState($option . 'searchcity', '' );
                $mainframe->setUserState($option . 'zipcode', '' );
                $mainframe->setUserState($option . 'keywords', '' );
                $mainframe->setUserState($option . 'nationality', '' );
                $mainframe->setUserState($option . 'jobcategory', '' );
                $mainframe->setUserState($option . 'jobsubcategory', '' );
                $mainframe->setUserState($option . 'jobsalaryrange', '' );
                $mainframe->setUserState($option . 'jobtype', '' );
                $mainframe->setUserState($option . 'heighestfinisheducation', '' );
                $mainframe->setUserState($option . 'gender', '' );
                $mainframe->setUserState($option . 'iamavailable', '' );
                $mainframe->setUserState($option . 'currency', '' );
                $mainframe->setUserState($option . 'experiencemin', '' );
                $mainframe->setUserState($option . 'experiencemax', '' );
                // custom field
                $data = getCustomFieldClass()->userFieldsData(3);
                foreach ($data as $uf) {
                    $fname = $uf->field;
                    $mainframe->setUserState( $option.$fname, '');
                }
                // custmo End

            }
            
            $sort = JRequest::getVar('sortby', '');
            if (isset($sort)) {
                if ($sort == '') {
                    $sort = 'create_datedesc';
                }
            } else {
                $sort = 'create_datedesc';
            }
            $sortby = $this->getResumeListOrdering($sort);
            if ($limit != '') {
                $session->set('limit',$limit);
            } else if ($limit == '') {
                $limit = $session->get('limit');
            }

            $for_save_search = array();
            $for_save_search['title'] = $title = $mainframe->getUserStateFromRequest($option . 'title', 'title', '', 'string');
            $for_save_search['name'] = $name = $mainframe->getUserStateFromRequest($option . 'name', 'name', '', 'string');
            $for_save_search['iamavailable'] = $iamavailable = JRequest::getVar('iamavailable');
            $for_save_search['searchcity'] = $searchcity = $mainframe->getUserStateFromRequest($option . 'searchcity', 'searchcity', '', 'string');
            $for_save_search['zipcode'] = $zipcode = $mainframe->getUserStateFromRequest($option . 'zipcode', 'zipcode', '', 'string');
            $for_save_search['keywords'] = $keywords = $mainframe->getUserStateFromRequest($option . 'keywords', 'keywords', '', 'string');
            
            $for_save_search['nationality'] = $nationality = $mainframe->getUserStateFromRequest($option . 'nationality', 'nationality', '', 'string');
            $for_save_search['jobcategory'] = $jobcategory = $mainframe->getUserStateFromRequest($option . 'jobcategory', 'jobcategory', '', 'string');
            $for_save_search['jobsubcategory'] = $jobsubcategory = $mainframe->getUserStateFromRequest($option . 'jobsubcategory', 'jobsubcategory', '', 'string');
            $for_save_search['jobsalaryrange'] = $jobsalaryrange = $mainframe->getUserStateFromRequest($option . 'jobsalaryrange', 'jobsalaryrange', '', 'string');
            $for_save_search['jobtype'] = $jobtype = $mainframe->getUserStateFromRequest($option . 'jobtype', 'jobtype', '', 'string');
            $for_save_search['heighestfinisheducation'] = $education = $mainframe->getUserStateFromRequest($option . 'heighestfinisheducation', 'heighestfinisheducation', '', 'string');
            $for_save_search['gender'] = $gender = $mainframe->getUserStateFromRequest($option . 'gender', 'gender', '', 'string');
            $for_save_search['currency'] = $currency = $mainframe->getUserStateFromRequest($option . 'currency', 'currency', '', 'string');
            $for_save_search['experiencemin'] = $experiencefrom = $mainframe->getUserStateFromRequest($option . 'experiencemin', 'experiencemin', '', 'string');
            $for_save_search['experiencemax'] = $experienceto = $mainframe->getUserStateFromRequest($option . 'experiencemax', 'experiencemax', '', 'string');
            $for_save_search['jobstatus'] = $jobstatus = '';
            $forsavesearch = array();
            foreach ($for_save_search as $key => $value) {
                if( ! empty($value) ){
                    $forsavesearch[$key] = $value;
                }
            }

            $result = $this->getJSModel('resume')->getResumeSearch($uid, $title, $name, $nationality, $gender, $iamavailable, $jobcategory, $jobsubcategory, $jobtype, $jobstatus, $currency, $jobsalaryrange, $education, $experiencefrom,$experienceto, $sortby, $limit, $limitstart, $zipcode, $keywords, $searchcity);
            if ($result != false) {
                $options = $this->get('Options');
                $sortlinks = $this->getResumeListSorting($sort);
                $sortlinks['sorton'] = $sorton;
                $sortlinks['sortorder'] = $sortorder;
                $forsavesearch['params'] = $result[5];
                if ($result[1] <= $limitstart)
                    $limitstart = 0;
                $pagination = new JPagination($result[1], $limitstart, $limit);
                $flag = JRequest::getVar('isresumesearch');
                $this->assignRef('issearchform', $flag);
                $this->assignRef('pagination', $pagination);
                $this->assignRef('resumes', $result[0]);
                $this->assignRef('searchresumeconfig', $result[2]);
                $this->assignRef('canview', $result[3]);
                $this->assignRef('fieldsordering', $result[4]);
                $this->assignRef('sortlinks', $sortlinks);
                $this->assignRef('forsavesearch', $forsavesearch);
                $true = true;
                $this->assignRef('result', $true);
            }else {
                $this->assignRef('result', $result);
            }
        } else if (($layout == 'resume_download') || ($layout == 'resume_view')) { // resume view & download
            $empid = $_GET['rq'];
            $application = $this->getJSModel('employer')->getEmpApplicationbyid($empid);
        } elseif (($layout == 'view_resume') or ( $layout == 'resume_print')) {          // view resume
            if (isset($_GET['id']))
                $empid = $_GET['id'];
            else
                $empid = '';
            if ($empid != '') {
                $application = $this->getJSModel('employer')->getEmpApplicationbyid($empid);
            } else {
                $resumeid = $this->getJSModel('common')->parseId(JRequest::getVar('rd', ''));
                $myresume = JRequest::getVar('nav', '');
                $jobid = $this->getJSModel('common')->parseId(JRequest::getVar('bd', ''));
                $folderid = JRequest::getVar('fd', '');
                $catid = JRequest::getVar('cat', '');
                $printresume = JRequest::getVar('print', '');
                $resumesubcat = JRequest::getVar('resumesubcat', '');
                if ($jobid == '0')
                    $jobid = '';
                $sortvalue = $sort = JRequest::getVar('sortby', false);
                if ($sort != false)
                    $sort = $this->getEmpListOrdering($sort);
                $tabaction = JRequest::getVar('ta', false);
                $show_only_section_that_have_value = $this->getJSModel('configurations')->getConfigValue('show_only_section_that_have_value');

                $result = $this->getJSModel('resume')->getResumeViewbyId($uid, $jobid, $resumeid, $myresume, $sort, $tabaction);
                $validresume = $this->getJSModel('resume')->checkResumeExists($resumeid);
                
                $this->assignRef('validresume', $validresume);
                $this->assignRef('resume', $result['personal']);
                $this->assignRef('addresses', $result['addresses']);
                $this->assignRef('institutes', $result['institutes']);
                $this->assignRef('employers', $result['employers']);
                $this->assignRef('references', $result['references']);
                $this->assignRef('languages', $result['languages']);
                if(isset($result['filename'])){ // only for job sharing case
                    $this->assignRef('resumefiles',$result['filename']);
                }
                $this->assignRef('fieldsordering', $result['fieldsordering']);
                $this->assignRef('userfields', $result['userfields']);
                $this->assignRef('show_only_section_that_have_value', $show_only_section_that_have_value);
                $this->assignRef('canview', $result['canview']);
                $this->assignRef('cvids', $result['cvids']);
                $this->assignRef('tabaction', $tabaction);
                $this->assignRef('printresume', $printresume);
                $nav = JRequest::getVar('nav', '');
                $this->assignRef('nav', $nav);
                $jobaliasid = JRequest::getVar('bd', '');
                if (!$jobid)
                    $jobid = 0;
                $this->assignRef('bd', $jobid);
                $this->assignRef('jobaliasid', $jobaliasid);
                $this->assignRef('resumeid', $resumeid);
                $this->assignRef('sortby', $sortvalue);
                $this->assignRef('fd', $folderid);
                $this->assignRef('ms', $myresume);
                $this->assignRef('catid', $catid);
                $this->assignRef('subcatid', $resumesubcat);
            }
        }
        require_once('resume_breadcrumbs.php');
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

    function getResumeListSorting($sort) {
        $sortlinks['application_title'] = $this->getSortArg("application_title", $sort);
        $sortlinks['jobtype'] = $this->getSortArg("jobtype", $sort);
        $sortlinks['salaryrange'] = $this->getSortArg("salaryrange", $sort);
        $sortlinks['created'] = $this->getSortArg("created", $sort);

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

    function getResumeListOrdering($sort) {
        global $sorton, $sortorder;
        switch ($sort) {
            case "application_titledesc": $ordering = "resume.application_title DESC";
                $sorton = "application_title";
                $sortorder = "DESC";
                break;
            case "application_titleasc": $ordering = "resume.application_title ASC";
                $sorton = "application_title";
                $sortorder = "ASC";
                break;
            case "jobtypedesc": $ordering = "resume.jobtype DESC";
                $sorton = "jobtype";
                $sortorder = "DESC";
                break;
            case "jobtypeasc": $ordering = "resume.jobtype ASC";
                $sorton = "jobtype";
                $sortorder = "ASC";
                break;
            case "salaryrangedesc": $ordering = "salary.rangeend DESC";
                $sorton = "salaryrange";
                $sortorder = "DESC";
                break;
            case "salaryrangeasc": $ordering = "salary.rangestart ASC";
                $sorton = "salaryrange";
                $sortorder = "ASC";
                break;
            case "createddesc": $ordering = "resume.created DESC";
                $sorton = "created";
                $sortorder = "DESC";
                break;
            case "createdasc": $ordering = "resume.created ASC";
                $sorton = "created";
                $sortorder = "ASC";
                break;
            default: $ordering = "resume.id DESC";
        }
        return $ordering;
    }

    function getEmpListOrdering($sort) {
        global $sorton, $sortorder;
        switch ($sort) {
            case "namedesc": $ordering = "app.first_name DESC";
                $sorton = "name";
                $sortorder = "DESC";
                break;
            case "nameasc": $ordering = "app.first_name ASC";
                $sorton = "name";
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
            case "jobtypedesc": $ordering = "app.jobtype DESC";
                $sorton = "jobtype";
                $sortorder = "DESC";
                break;
            case "jobtypeasc": $ordering = "app.jobtype ASC";
                $sorton = "jobtype";
                $sortorder = "ASC";
                break;
            case "jobsalaryrangedesc": $ordering = "salary.rangestart DESC";
                $sorton = "jobsalaryrange";
                $sortorder = "DESC";
                break;
            case "jobsalaryrangeasc": $ordering = "salary.rangestart ASC";
                $sorton = "jobsalaryrange";
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
            case "emaildesc": $ordering = "app.email_address DESC";
                $sorton = "email";
                $sortorder = "DESC";
                break;
            case "emailasc": $ordering = "app.email_address ASC";
                $sorton = "email";
                $sortorder = "ASC";
                break;
            case "availabledesc": $ordering = "app.iamavailable DESC";
                $sorton = "available";
                $sortorder = "DESC";
                break;
            case "availableasc": $ordering = "app.iamavailable ASC";
                $sorton = "available";
                $sortorder = "ASC";
                break;
            case "educationdesc": $ordering = "app.heighestfinisheducation DESC";
                $sorton = "education";
                $sortorder = "DESC";
                break;
            case "educationasc": $ordering = "app.heighestfinisheducation ASC";
                $sorton = "education";
                $sortorder = "ASC";
                break;
            default: $ordering = "job.id DESC";
        }
        return $ordering;
    }

}

?>
