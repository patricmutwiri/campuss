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
jimport('joomla.application.component.model');
jimport('joomla.html.html');

class JSJobsModelJob extends JSModel {

    var $_config = null;
    var $_defaultcurrency = null;
    var $_client_auth_key = null;
    var $_siteurl = null;
    var $_application = null;
    var $_searchoptions = null;
    var $_job = null;
    var $_job_editor = null;
    var $_defaultcountry = null;

    function __construct() {
        parent::__construct();
        $this->_client_auth_key = $this->getJSModel('jobsharing')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $this->_defaultcurrency = $this->getJSModel('currency')->getDefaultCurrency();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function getTopJobs() {
        $db = JFactory::getDBO();
        $result = array();
        $query = "SELECT job.id,job.title AS jobtitle,company.name AS companyname,cat.cat_title AS cattile,job.stoppublishing,
        salaryfrom.rangestart AS salaryfrom, salaryto.rangestart AS salaryto,currency.symbol 
        FROM `#__js_job_jobs` AS job
        JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
        JOIN `#__js_job_companies` AS company ON job.companyid = company.id
        LEFT JOIN `#__js_job_salaryrange` AS salaryfrom ON job.salaryrangefrom = salaryfrom.id
        LEFT JOIN `#__js_job_salaryrange` AS salaryto ON job.salaryrangeto = salaryto.id
        LEFT JOIN `#__js_job_currencies` AS currency ON currency.id = job.currencyid ORDER BY job.created desc LIMIT 5";
        $db->setQuery($query);
        $jobs = $db->loadObjectList();
        return $jobs;
    }

    function getMultiCityData($jobid) {
        if (!is_numeric($jobid))
            return false;
        $db = $this->getDBO();
        $query = "select mjob.*,city.id AS cityid,city.cityName AS cityname ,state.name AS statename,country.name AS countryname
                from #__js_job_jobcities AS mjob
                LEFT join #__js_job_cities AS city on mjob.cityid=city.id  
                LEFT join #__js_job_states AS state on city.stateid=state.id  
                LEFT join #__js_job_countries AS country on city.countryid=country.id 
                WHERE mjob.jobid=" . $jobid;
        $db->setQuery($query);
        $data = $db->loadObjectList();
        if (is_array($data) AND ! empty($data)) {
            $i = 0;
            $multicitydata = "";
            foreach ($data AS $multicity) {
                $last_index = count($data) - 1;
                if ($i == $last_index)
                    $multicitydata.=$multicity->cityname;
                else
                    $multicitydata.=$multicity->cityname . " ,";
                $i++;
            }
            if ($multicitydata != "") {
                $mc = JText::_('Multi City');
                $multicity = (strlen($multicitydata) > 35) ? $mc . substr($multicitydata, 0, 35) . '...' : $multicitydata;
                return $multicity;
            } else
                return;
        }
    }

    function getJobbyIdForView($job_id) {
        $db = $this->getDBO();
        if (is_numeric($job_id) == false)
            return false;

        $query = "SELECT job.*, cat.cat_title , company.name as companyname, jobtype.title AS jobtypetitle
                , jobstatus.title AS jobstatustitle, shift.title as shifttitle
                , department.name AS departmentname
                , salaryfrom.rangestart AS salaryfrom, salaryto.rangestart AS salaryto, salarytype.title AS salarytype
                , education.title AS educationtitle ,mineducation.title AS mineducationtitle, maxeducation.title AS maxeducationtitle
                , experience.title AS experiencetitle ,minexperience.title AS minexperiencetitle, maxexperience.title AS maxexperiencetitle
                ,currency.symbol 
                
        FROM `#__js_job_jobs` AS job
        JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
        JOIN `#__js_job_companies` AS company ON job.companyid = company.id
        JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id
        LEFT JOIN `#__js_job_jobstatus` AS jobstatus ON job.jobstatus = jobstatus.id
        LEFT JOIN `#__js_job_departments` AS department ON job.departmentid = department.id
        LEFT JOIN `#__js_job_salaryrange` AS salaryfrom ON job.salaryrangefrom = salaryfrom.id
        LEFT JOIN `#__js_job_salaryrange` AS salaryto ON job.salaryrangeto = salaryto.id
        LEFT JOIN `#__js_job_salaryrangetypes` AS salarytype ON job.salaryrangetype = salarytype.id
        LEFT JOIN `#__js_job_heighesteducation` AS education ON job.educationid = education.id
        LEFT JOIN `#__js_job_heighesteducation` AS mineducation ON job.mineducationrange = mineducation.id
        LEFT JOIN `#__js_job_heighesteducation` AS maxeducation ON job.maxeducationrange = maxeducation.id
        LEFT JOIN `#__js_job_experiences` AS experience ON job.experienceid = experience.id
        LEFT JOIN `#__js_job_experiences` AS minexperience ON job.minexperiencerange = minexperience.id
        LEFT JOIN `#__js_job_experiences` AS maxexperience ON job.maxexperiencerange = maxexperience.id
        LEFT JOIN `#__js_job_shifts` AS shift ON job.shift = shift.id
        LEFT JOIN `#__js_job_currencies` AS currency ON currency.id = job.currencyid    
        WHERE  job.id = " . $job_id;
        $db->setQuery($query);
        $this->_application = $db->loadObject();
        $this->_application->multicity = $this->getJSModel('jsjobs')->getMultiCityDataForView($job_id, 1);

        $result[0] = $this->_application;
        $result[2] = '';
        $result[3] = $this->getJSModel('fieldordering')->getFieldsOrderingforForm(2); // company fields

        return $result;
    }

    function getJobbyId($c_id, $uid) {
        if ($uid)
            if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
                return false;
        if (is_numeric($c_id) == false)
            return false;
        $fieldsordering = $this->getJSModel('fieldordering')->getFieldsOrderingforForm(2); // job fields       
        $company_required = '';
        $department_required = '';
        $cat_required = '';
        $subcategory_required = '';
        $jobtype_required = '';
        $jobstatus_required = '';
        $education_required = '';
        $jobshift_required = '';
        $jobsalaryrange_required = '';
        $experience_required = '';
        $age_required = '';
        $gender_required = '';
        $careerlevel_required = '';
        $workpermit_required = '';
        $requiredtravel_required = '';
        $sendemail_required = '';
        foreach ($fieldsordering AS $fo) {
            switch ($fo->field) {
                case "company":
                    $company_required = ($fo->required ? 'required' : '');
                    break;
                case "department":
                    $department_required = ($fo->required ? 'required' : '');
                    break;
                case "jobcategory":
                    $cat_required = ($fo->required ? 'required' : '');
                    break;
                case "subcategory":
                    $subcategory_required = ($fo->required ? 'required' : '');
                    break;
                case "jobtype":
                    $jobtype_required = ($fo->required ? 'required' : '');
                    break;
                case "jobstatus":
                    $jobstatus_required = ($fo->required ? 'required' : '');
                    break;
                case "heighesteducation":
                    $education_required = ($fo->required ? 'required' : '');
                    break;
                case "jobshift":
                    $jobshift_required = ($fo->required ? 'required' : '');
                    break;
                case "jobsalaryrange":
                    $jobsalaryrange_required = ($fo->required ? 'required' : '');
                    break;
                case "experience":
                    $experience_required = ($fo->required ? 'required' : '');
                    break;
                case "age":
                    $age_required = ($fo->required ? 'required' : '');
                    break;
                case "gender":
                    $gender_required = ($fo->required ? 'required' : '');
                    break;
                case "careerlevel":
                    $careerlevel_required = ($fo->required ? 'required' : '');
                    break;
                case "workpermit":
                    $workpermit_required = ($fo->required ? 'required' : '');
                    break;
                case "requiredtravel":
                    $requiredtravel_required = ($fo->required ? 'required' : '');
                    break;
                case "sendemail":
                    $sendemail_required = ($fo->required ? 'required' : '');
                    break;
            }
        }
        $db = JFactory::getDBO();

        $query = "SELECT job.*, cat.cat_title, salary.rangestart, salary.rangeend
            FROM `#__js_job_jobs` AS job
            JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
            LEFT JOIN `#__js_job_salaryrange` AS salary ON job.jobsalaryrange = salary.id
            LEFT JOIN `#__js_job_currencies` AS currency ON currency.id = job.currencyid 
            WHERE job.id = " . $c_id;

        $db->setQuery($query);
        $this->_job = $db->loadObject();

        $status = array(
            '0' => array('value' => 0, 'text' => JText::_('Pending')),
            '1' => array('value' => 1, 'text' => JText::_('Approve')),
            '2' => array('value' => -1, 'text' => JText::_('Reject')),);
        $companies = $this->getJSModel('company')->getCompanies($uid);
        $departments = $this->getJSModel('department')->getDepartment($uid);
        $categories = $this->getJSModel('category')->getCategories(JText::_('Select Category'), '');

        if (isset($this->_job)) {

            $lists['companies'] = JHTML::_('select.genericList', $companies, 'companyid', 'class="inputbox ' . $company_required . '" ' . 'onChange="getdepartments(\'departmentid\', this.value)"', 'value', 'text', $this->_job->companyid);
            $lists['departments'] = JHTML::_('select.genericList', $this->getJSModel('department')->getDepartmentsByCompanyId($this->_job->companyid, ''), 'departmentid', 'class="inputbox ' . $department_required . '" ' . '', 'value', 'text', $this->_job->departmentid);
            $lists['jobcategory'] = JHTML::_('select.genericList', $categories, 'jobcategory', 'class="inputbox ' . $cat_required . '"' . 'onChange="fj_getsubcategories(\'subcategoryid\', this.value)"', 'value', 'text', $this->_job->jobcategory);
            $lists['subcategory'] = JHTML::_('select.genericList', $this->getJSModel('subcategory')->getSubCategoriesforCombo($this->_job->jobcategory, JText::_('Sub Category'), ''), 'subcategoryid', 'class="inputbox ' . $subcategory_required . '"' . '', 'value', 'text', $this->_job->subcategoryid);
            $lists['jobtype'] = JHTML::_('select.genericList', $this->getJSModel('jobtype')->getJobType(''), 'jobtype', 'class="inputbox ' . $jobtype_required . '"' . '', 'value', 'text', $this->_job->jobtype);
            $lists['jobstatus'] = JHTML::_('select.genericList', $this->getJSModel('jobstatus')->getJobStatus(''), 'jobstatus', 'class="inputbox ' . $jobstatus_required . '"' . '', 'value', 'text', $this->_job->jobstatus);
            $lists['educationminimax'] = JHTML::_('select.genericList', $this->getJSModel('common')->getMiniMax(''), 'educationminimax', 'class="inputbox" ' . '', 'value', 'text', $this->_job->educationminimax);
            $lists['education'] = JHTML::_('select.genericList', $this->getJSModel('highesteducation')->getHeighestEducation(''), 'educationid', 'class="inputbox ' . $education_required . '"' . '', 'value', 'text', $this->_job->educationid);
            $lists['minimumeducationrange'] = JHTML::_('select.genericList', $this->getJSModel('highesteducation')->getHeighestEducation(JText::_('Minimum')), 'mineducationrange', 'class="inputbox ' . $education_required . '"' . '', 'value', 'text', $this->_job->mineducationrange);
            $lists['maximumeducationrange'] = JHTML::_('select.genericList', $this->getJSModel('highesteducation')->getHeighestEducation(JText::_('Maximum')), 'maxeducationrange', 'class="inputbox ' . $education_required . '"' . '', 'value', 'text', $this->_job->maxeducationrange);

            $lists['shift'] = JHTML::_('select.genericList', $this->getJSModel('shift')->getShift(''), 'shift', 'class="inputbox ' . $jobshift_required . '"' . '', 'value', 'text', $this->_job->shift);
            $lists['salaryrangefrom'] = JHTML::_('select.genericList', $this->getJSModel('salaryrange')->getSalaryRange(JText::_('From')), 'salaryrangefrom', 'class="inputbox validate-salaryrangefrom ' . $jobsalaryrange_required . '"' . '', 'value', 'text', $this->_job->salaryrangefrom);
            $lists['salaryrangeto'] = JHTML::_('select.genericList', $this->getJSModel('salaryrange')->getSalaryRange(JText::_('To')), 'salaryrangeto', 'class="inputbox validate-salaryrangeto ' . $jobsalaryrange_required . '" ' . '', 'value', 'text', $this->_job->salaryrangeto);
            $lists['salaryrangetypes'] = JHTML::_('select.genericList', $this->getJSModel('salaryrangetype')->getSalaryRangeTypes(''), 'salaryrangetype', 'class="inputbox " ' . '', 'value', 'text', $this->_job->salaryrangetype);

            $lists['experienceminimax'] = JHTML::_('select.genericList', $this->getJSModel('common')->getMiniMax(''), 'experienceminimax', 'class="inputbox" ' . '', 'value', 'text', $this->_job->experienceminimax);
            $lists['experience'] = JHTML::_('select.genericList', $this->getJSModel('experience')->getExperiences(JText::_('Select')), 'experienceid', 'class="inputbox ' . $experience_required . '" ' . '', 'value', 'text', $this->_job->experienceid);
            $lists['minimumexperiencerange'] = JHTML::_('select.genericList', $this->getJSModel('experience')->getExperiences(JText::_('Minimum')), 'minexperiencerange', 'class="inputbox ' . $experience_required . '"' . '', 'value', 'text', $this->_job->minexperiencerange);
            $lists['maximumexperiencerange'] = JHTML::_('select.genericList', $this->getJSModel('experience')->getExperiences(JText::_('Maximum')), 'maxexperiencerange', 'class="inputbox ' . $experience_required . '"' . '', 'value', 'text', $this->_job->maxexperiencerange);

            $lists['agefrom'] = JHTML::_('select.genericList', $this->getJSModel('age')->getAges(JText::_('From')), 'agefrom', 'class="inputbox validate-checkagefrom ' . $age_required . '"' . '', 'value', 'text', $this->_job->agefrom);
            $lists['ageto'] = JHTML::_('select.genericList', $this->getJSModel('age')->getAges(JText::_('To')), 'ageto', 'class="inputbox validate-checkageto ' . $age_required . '"' . '', 'value', 'text', $this->_job->ageto);

            $lists['gender'] = JHTML::_('select.genericList', $this->getJSModel('common')->getGender(JText::_('Does Not Matter')), 'gender', 'class="inputbox ' . $gender_required . '"' . '', 'value', 'text', $this->_job->gender);

            $lists['careerlevel'] = JHTML::_('select.genericList', $this->getJSModel('careerlevel')->getCareerLevels(JText::_('Select')), 'careerlevel', 'class="inputbox ' . $careerlevel_required . '"' . '', 'value', 'text', $this->_job->careerlevel);
            $lists['workpermit'] = JHTML::_('select.genericList', $this->getJSModel('country')->getCountries(JText::_('Select')), 'workpermit', 'class="inputbox ' . $workpermit_required . '" ' . '', 'value', 'text', $this->_job->workpermit);
            $lists['requiredtravel'] = JHTML::_('select.genericList', $this->getJSModel('common')->getRequiredTravel(JText::_('Select')), 'requiredtravel', 'class="inputbox ' . $requiredtravel_required . '" ' . '', 'value', 'text', $this->_job->requiredtravel);

            $lists['status'] = JHTML::_('select.genericList', $status, 'status', 'class="inputbox required" ' . '', 'value', 'text', $this->_job->status);
            $lists['sendemail'] = JHTML::_('select.genericList', $this->getJSModel('common')->getSendEmail(), 'sendemail', 'class="inputbox ' . $sendemail_required . '" ' . '', 'value', 'text', $this->_job->sendemail);
            $lists['currencyid'] = JHTML::_('select.genericList', $this->getJSModel('currency')->getCurrency(), 'currencyid', 'class="inputbox " ' . '', 'value', 'text', $this->_job->currencyid);
            $multi_lists = $this->getJSModel('common')->getMultiSelectEdit($this->_job->id, 1);
        } else {

            $defaultCategory = $this->getJSModel('common')->getDefaultValue('categories');
            $defaultJobtype = $this->getJSModel('common')->getDefaultValue('jobtypes');
            $defaultJobstatus = $this->getJSModel('common')->getDefaultValue('jobstatus');
            $defaultShifts = $this->getJSModel('common')->getDefaultValue('shifts');
            $defaultEducation = $this->getJSModel('common')->getDefaultValue('heighesteducation');
            $defaultSalaryrange = $this->getJSModel('common')->getDefaultValue('salaryrange');
            $defaultSalaryrangeType = $this->getJSModel('common')->getDefaultValue('salaryrangetypes');
            $defaultAge = $this->getJSModel('common')->getDefaultValue('ages');
            $defaultExperiences = $this->getJSModel('common')->getDefaultValue('experiences');
            $defaultCareerlevels = $this->getJSModel('common')->getDefaultValue('careerlevels');
            $defaultCurrencies = $this->getJSModel('common')->getDefaultValue('currencies');


            if (!isset($this->_config)) {
                $this->_config = $this->getJSModel('configuration')->getConfig();
            }
            $lists['companies'] = JHTML::_('select.genericList', $companies, 'companyid', 'class="inputbox ' . $company_required . '" ' . 'onChange="getdepartments(\'departmentid\', this.value)"' . '', 'value', 'text', '');
            if (isset($companies[0]['value']))
                $lists['departments'] = JHTML::_('select.genericList', $this->getJSModel('department')->getDepartmentsByCompanyId($companies[0]['value'], ''), 'departmentid', 'class="inputbox ' . $department_required . '"' . '', 'value', 'text', '');
            $lists['jobcategory'] = JHTML::_('select.genericList', $categories, 'jobcategory', 'class="inputbox ' . $cat_required . '"' . 'onChange="fj_getsubcategories(\'subcategoryid\', this.value)"', 'value', 'text', $defaultCategory);
            $lists['subcategory'] = JHTML::_('select.genericList', $this->getJSModel('subcategory')->getSubCategoriesforCombo($defaultCategory, JText::_('Sub Category'), ''), 'subcategoryid', 'class="inputbox ' . $subcategory_required . '"' . '', 'value', 'text', '');
            $lists['jobtype'] = JHTML::_('select.genericList', $this->getJSModel('jobtype')->getJobType(''), 'jobtype', 'class="inputbox ' . $jobtype_required . '"' . '', 'value', 'text', $defaultJobtype);
            $lists['jobstatus'] = JHTML::_('select.genericList', $this->getJSModel('jobstatus')->getJobStatus(''), 'jobstatus', 'class="inputbox ' . $jobstatus_required . '"' . '', 'value', 'text', $defaultJobstatus);

            $lists['educationminimax'] = JHTML::_('select.genericList', $this->getJSModel('common')->getMiniMax(''), 'educationminimax', 'class="inputbox" ' . '', 'value', 'text', '');
            $lists['education'] = JHTML::_('select.genericList', $this->getJSModel('highesteducation')->getHeighestEducation(''), 'educationid', 'class="inputbox ' . $education_required . '"' . '', 'value', 'text', $defaultEducation);
            $lists['minimumeducationrange'] = JHTML::_('select.genericList', $this->getJSModel('highesteducation')->getHeighestEducation(JText::_('Minimum')), 'mineducationrange', 'class="inputbox ' . $education_required . '"' . '', 'value', 'text', $defaultEducation);
            $lists['maximumeducationrange'] = JHTML::_('select.genericList', $this->getJSModel('highesteducation')->getHeighestEducation(JText::_('Maximum')), 'maxeducationrange', 'class="inputbox ' . $education_required . '"' . '', 'value', 'text', $defaultEducation);
            $lists['shift'] = JHTML::_('select.genericList', $this->getJSModel('shift')->getShift(''), 'shift', 'class="inputbox ' . $jobshift_required . '"' . '', 'value', 'text', $defaultShifts);

            $lists['salaryrangefrom'] = JHTML::_('select.genericList', $this->getJSModel('salaryrange')->getSalaryRange(JText::_('From')), 'salaryrangefrom', 'class="inputbox validate-salaryrangefrom ' . $jobsalaryrange_required . '" ' . '', 'value', 'text', $defaultSalaryrange);
            $lists['salaryrangeto'] = JHTML::_('select.genericList', $this->getJSModel('salaryrange')->getSalaryRange(JText::_('To')), 'salaryrangeto', 'class="inputbox validate-salaryrangeto ' . $jobsalaryrange_required . '" ' . '', 'value', 'text', $defaultSalaryrange);
            $lists['salaryrangetypes'] = JHTML::_('select.genericList', $this->getJSModel('salaryrangetype')->getSalaryRangeTypes(''), 'salaryrangetype', 'class="inputbox" ' . '', 'value', 'text', $defaultSalaryrangeType);


            $lists['experienceminimax'] = JHTML::_('select.genericList', $this->getJSModel('common')->getMiniMax(''), 'experienceminimax', 'class="inputbox" ' . '', 'value', 'text', '');
            $lists['experience'] = JHTML::_('select.genericList', $this->getJSModel('experience')->getExperiences(JText::_('Select')), 'experienceid', 'class="inputbox ' . $experience_required . '" ' . '', 'value', 'text', $defaultExperiences);
            $lists['minimumexperiencerange'] = JHTML::_('select.genericList', $this->getJSModel('experience')->getExperiences(JText::_('Minimum')), 'minexperiencerange', 'class="inputbox ' . $experience_required . '"' . '', 'value', 'text', $defaultExperiences);
            $lists['maximumexperiencerange'] = JHTML::_('select.genericList', $this->getJSModel('experience')->getExperiences(JText::_('Maximum')), 'maxexperiencerange', 'class="inputbox ' . $experience_required . '"' . '', 'value', 'text', $defaultExperiences);

            $lists['agefrom'] = JHTML::_('select.genericList', $this->getJSModel('age')->getAges(JText::_('From')), 'agefrom', 'class="inputbox validate-checkagefrom ' . $age_required . '"' . '', 'value', 'text', $defaultAge);
            $lists['ageto'] = JHTML::_('select.genericList', $this->getJSModel('age')->getAges(JText::_('To')), 'ageto', 'class="inputbox validate-checkageto ' . $age_required . '"' . '', 'value', 'text', $defaultAge);

            $lists['gender'] = JHTML::_('select.genericList', $this->getJSModel('common')->getGender(JText::_('Does Not Matter')), 'gender', 'class="inputbox ' . $gender_required . '" ' . '', 'value', 'text', '');
            $lists['careerlevel'] = JHTML::_('select.genericList', $this->getJSModel('careerlevel')->getCareerLevels(JText::_('Select')), 'careerlevel', 'class="inputbox ' . $careerlevel_required . '"' . '', 'value', 'text', $defaultCareerlevels);
            $lists['workpermit'] = JHTML::_('select.genericList', $this->getJSModel('country')->getCountries(JText::_('Select')), 'workpermit', 'class="inputbox ' . $workpermit_required . '" ' . '', 'value', 'text', $this->_defaultcountry);
            $lists['requiredtravel'] = JHTML::_('select.genericList', $this->getJSModel('common')->getRequiredTravel(JText::_('Select')), 'requiredtravel', 'class="inputbox ' . $requiredtravel_required . '"' . '', 'value', 'text', '');

            $lists['status'] = JHTML::_('select.genericList', $status, 'status', 'class="inputbox required" ' . '', 'value', 'text', 1);
            $lists['sendemail'] = JHTML::_('select.genericList', $this->getJSModel('common')->getSendEmail(), 'sendemail', 'class="inputbox ' . $sendemail_required . '"' . '', 'value', 'text', '$this->_job->sendemail', '');
            $lists['currencyid'] = JHTML::_('select.genericList', $this->getJSModel('currency')->getCurrency(), 'currencyid', 'class="inputbox " ' . '', 'value', 'text', $defaultCurrencies);
        }

        $result[0] = $this->_job;
        $result[1] = $lists;
        $result[2] = $this->getJSModel('fieldordering')->getFieldsOrderingforView(2); // job fields, refid
        $result[3] = $fieldsordering;
        if (isset($multi_lists) && $multi_lists != "")
            $result[4] = $multi_lists;
        return $result;
    }



    function getAllJobs($datafor, $companyname, $jobtitle, $jobcategory, $jobtype, $location, $dateto, $datefrom, $status, $isgfcombo, $sortby, $js_sortby, $limitstart, $limit) {
        
        if($js_sortby==1){
            $sortby = " job.title $sortby "; 
        }elseif($js_sortby==2){
            $sortby = " jobtype.title $sortby ";
        }elseif($js_sortby==3){
            $sortby = " company.name $sortby ";
        }elseif($js_sortby==4){
            $sortby = " cat.cat_title $sortby ";
        }elseif($js_sortby==5){
            $sortby = " city.cityname $sortby "; //Location
        }elseif($js_sortby==6){
            $sortby = " job.status $sortby ";
        }elseif($js_sortby==7){
            $sortby = " job.created $sortby ";
        }elseif($js_sortby==8){
            $sortby = " job.hits $sortby ";
        }else{
            $sortby = " job.created DESC ";
        }

        $db = JFactory::getDBO();
        if($datafor == 1){ // 1 for Jobs, 2 for Jobs queue
            $status_opr = (is_numeric($status)) ? ' = '.$status : ' <> 0 ';
            $fquery = " WHERE job.status".$status_opr;
        }else{ // For Jobs Queue
            $fquery = " WHERE job.status = 0 ";
        }
        if($companyname)
            $fquery .= " AND LOWER(company.name) LIKE ".$db->Quote('%'.$companyname.'%');
        if($jobtitle)
            $fquery .= " AND LOWER(job.title) LIKE ".$db->Quote('%'.$jobtitle.'%');
        if($location)
            $fquery .= " AND LOWER(city.cityName) LIKE ".$db->Quote('%'.$location.'%');
        if ($jobcategory){
            if(is_numeric($jobcategory))
                $fquery .= " AND job.jobcategory = ".$jobcategory;
        }
        if ($jobtype){
            if(is_numeric($jobtype))
                $fquery .= " AND job.jobtype = ".$jobtype;
        }

        if($dateto !='' AND $datefrom !=''){
            $fquery .= " AND DATE(job.created) <= ".$db->Quote(date('Y-m-d',strtotime($dateto)))." AND DATE(job.created) >= ".$db->Quote(date('Y-m-d',strtotime($datefrom)));
        }else{
            if($dateto)
                $fquery .= " AND DATE(job.created) <= ".$db->Quote(date('Y-m-d',strtotime($dateto)));
            if($datefrom)
                $fquery .= " AND DATE(job.created) >= ".$db->Quote(date('Y-m-d',strtotime($datefrom)));
        }

        $lists = array();
        $lists['companyname'] = $companyname;
        $lists['jobtitle'] = $jobtitle;
        $lists['jobcategory'] = JHTML::_('select.genericList', $this->getJSModel('category')->getCategories(JText::_('Select Category'), ''), 'jobcategory', 'class="inputbox" ', 'value', 'text', $jobcategory);
        $lists['jobtype'] = JHTML::_('select.genericList', $this->getJSModel('jobtype')->getJobType(JText::_('Select Job Type')), 'jobtype', 'class="inputbox" ', 'value', 'text', $jobtype);
        $lists['location'] = $location;
        $lists['dateto'] = $dateto;
        $lists['datefrom'] = $datefrom;
        if($datafor == 1)
            $lists['status'] = JHTML::_('select.genericList', $this->getJSModel('common')->getApprove(JText::_('Select Status'),'') , 'status', 'class="inputbox" ' , 'value', 'text', $status);
        else
            $lists['status'] = $status;

        $result = array();
        $query = "SELECT COUNT(job.id) FROM `#__js_job_jobs` AS job
                LEFT JOIN `#__js_job_companies` AS company ON job.companyid = company.id 
                LEFT JOIN `#__js_job_cities` AS city ON city.id = (SELECT cityid FROM `#__js_job_jobcities` WHERE jobid = job.id ORDER BY id DESC LIMIT 1) ";
        $query .= $fquery;
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT job.id,job.title,job.created,job.status,job.isgoldjob,job.isfeaturedjob,job.city,job.startpublishing,job.stoppublishing,
                cat.cat_title, jobtype.title AS jobtypetitle, company.id AS companyid, company.name AS companyname,company.logofilename AS companylogo,
                (SELECT COUNT(ja.id) FROM `#__js_job_jobapply` AS ja WHERE ja.jobid = job.id ) AS totalresume
                FROM `#__js_job_jobs` AS job 
                JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
                JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id 
                LEFT JOIN `#__js_job_companies` AS company ON job.companyid = company.id
                LEFT JOIN `#__js_job_cities` AS city ON city.id = (SELECT cityid FROM `#__js_job_jobcities` WHERE jobid = job.id ORDER BY id DESC LIMIT 1) ";

        $query .=$fquery;
        $query .= " ORDER BY $sortby ";
        $db->setQuery($query, $limitstart, $limit);
        $this->_application = $db->loadObjectList();
        
        $jobs = array();
        foreach ($this->_application as $d) {
            $d->location = $this->getJSModel('city')->getLocationDataForView($d->city);
            $jobs[] = $d;
        }
        $this->_application = $jobs;
        $result[0] = $this->_application;
        $result[1] = $total;
        $result[2] = $lists;
        return $result;
    }


    function storeJob() {
        JRequest::checkToken() or die( 'Invalid Token' );
        $row = $this->getTable('job');
        $data = JRequest::get('post');
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);  // Sanitize entire array to string
        $db = $this->getDBO();

        if (isset($this_config) == false)
            $this->_config = $this->getJSModel('configuration')->getConfig('');
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'date_format')
                $dateformat = $conf->configvalue;
            if ($conf->configname == 'system_timeout')
                $systemtimeout = $conf->configvalue;
        }
        if ($dateformat == 'm/d/Y') {
            $arr = explode('/', $data['startpublishing']);
            $data['startpublishing'] = $arr[2] . '/' . $arr[0] . '/' . $arr[1];
            $arr = explode('/', $data['stoppublishing']);
            $data['stoppublishing'] = $arr[2] . '/' . $arr[0] . '/' . $arr[1];
        } elseif ($dateformat == 'd-m-Y' OR $dateformat == 'Y-m-d') {
            $arr = explode('-', $data['startpublishing']);
            $data['startpublishing'] = $arr[2] . '-' . $arr[1] . '-' . $arr[0];
            $arr = explode('-', $data['stoppublishing']);
            $data['stoppublishing'] = $arr[2] . '-' . $arr[1] . '-' . $arr[0];
        }

        $data['startpublishing'] = JHTML::_('date',strtotime($data['startpublishing']),"Y-m-d H:i:s" );
        $data['stoppublishing'] = JHTML::_('date',strtotime($data['stoppublishing']),"Y-m-d H:i:s" );
        
        if (!empty($data['alias']))
            $jobalias = $this->getJSModel('common')->removeSpecialCharacter($data['alias']);
        else
            $jobalias = $this->getJSModel('common')->removeSpecialCharacter($data['title']);

        $jobalias = strtolower(str_replace(' ', '-', $jobalias));
        $data['alias'] = $jobalias;

        $data['description'] = $this->getJSModel('common')->getHtmlInput('description');
        $data['qualifications'] = $this->getJSModel('common')->getHtmlInput('qualifications');
        $data['prefferdskills'] = $this->getJSModel('common')->getHtmlInput('prefferdskills');
        $data['agreement'] = $this->getJSModel('common')->getHtmlInput('agreement');
        $data['uid'] = $this->getJSModel('company')->getUidByCompanyId($data['companyid']); // Uid must be the same as the company owner id
        if ($data['id'] == '') {
            $data['jobid'] = $this->getJobId();
            $data['created'] = date('Y-m-d H:i:s');
        }

    //custom field code start
        $customflagforadd = false;
        $customflagfordelete = false;
        $custom_field_namesforadd = array();
        $custom_field_namesfordelete = array();
        $userfield = $this->getJSModel('fieldordering')->getUserfieldsfor(2);
        $params = '';
        $forfordelete = '';
        
        foreach ($userfield AS $ufobj) {
            $vardata = '';
            if($ufobj->userfieldtype == 'file'){
                if(isset($data[$ufobj->field.'_1']) && $data[$ufobj->field.'_1'] == 0){
                    $vardata = $data[$ufobj->field.'_2'];
                }else{
                    $vardata = $_FILES[$ufobj->field]['name'];
                }
                $customflagforadd=true;
                $custom_field_namesforadd[]=$ufobj->field;
            }else{
                $vardata = isset($data[$ufobj->field]) ? $data[$ufobj->field] : '';
            }
            if(isset($data[$ufobj->field.'_1']) && $data[$ufobj->field.'_1'] == 1){
                $customflagfordelete = true;
                $forfordelete = $ufobj->field;
                $custom_field_namesfordelete[]= $data[$ufobj->field.'_2'];
            }
            if($vardata != ''){
                //had to comment this so that multpli field should work properly
                // if($ufobj->userfieldtype == 'multiple'){
                //     $vardata = explode(',', $vardata[0]); // fixed index
                // }
                if(is_array($vardata)){
                    $vardata = implode(', ', $vardata);
                }
                $params[$ufobj->field] = htmlspecialchars($vardata);
            }
        }
        if($data['id'] != ''){
           if(is_numeric($data['id'])){
               $db = JFactory::getdbo();
               $query = "SELECT params FROM `#__js_job_jobs` WHERE id = ".$data['id'];
               $db->setQuery($query);
               $oParams = $db->loadResult();                
               if(!empty($oParams)){
                   $oParams = json_decode($oParams,true);
                   $unpublihsedFields = $this->getJSModel('fieldordering')->getUnpublishedFieldsFor(2);
                   foreach($unpublihsedFields AS $field){
                       if(isset($oParams[$field->field])){
                           $params[$field->field] = $oParams[$field->field];
                       }
                   }
               }
           }
       }

        if (!empty($params)) {
            if($customflagfordelete == true){
                unset($params[$forfordelete]); // sice file is deleted so we remove the data
            }

            $params = json_encode($params);
        }
        $data['params'] = $params;
    //custom field code end


        if (!$row->bind($data)) {
            $this->setError($this->_db->getErrorMsg());
            echo $this->_db->getErrorMsg();
            return false;
        }
        if (!$row->check()) {
            $this->setError($this->_db->getErrorMsg());
            return 2;
        }

        if (!$row->store()) {
            $this->setError($this->_db->getErrorMsg());
            echo $this->_db->getErrorMsg();
            return false;
        }
        if ($data['city'])
            $storemulticity = $this->storeMultiCitiesJob($data['city'], $row->id);
        if (isset($storemulticity) AND ( $storemulticity == false))
            return false;

        // new
        //removing custom field 
        if($customflagfordelete == true){
            foreach ($custom_field_namesforadd as $key) {
                $res = $this->getJSModel('common')->uploadOrDeleteFileCustom($row->id,$key ,1,2);
            }
        }
        //storing custom field attachments
        if($customflagforadd == true){
            foreach ($custom_field_namesforadd as $key) {
                if ($_FILES[$key]['size'] > 0) { // logo
                    $res = $this->getJSModel('common')->uploadOrDeleteFileCustom($row->id,$key ,0,2);
                }
            }
        }
        // End attachments


        if ($this->_client_auth_key != "") {
            $query = "SELECT job.* FROM `#__js_job_jobs` AS job  
                        WHERE job.id = " . $row->id;

            $db->setQuery($query);
            $data_job = $db->loadObject();
            if ($data['id'] != "" AND $data['id'] != 0)
                $data_job->id = $data['id']; // for edit case
            $data_job->job_id = $row->id;
            $data_job->authkey = $this->_client_auth_key;
            $data_job->task = 'storejob';
            $jsjobsharingobject = $this->getJSModel('jobsharing');
            $return_value = $jsjobsharingobject->storeJobSharing($data_job);
            $jobtemp = $this->getJSModel('common')->getJobtempModelFrontend();
            $jobtemp->updateJobTemp();
            $jsjobslogobject = $this->getJSModel('log');
            $jsjobslogobject->logStoreJobSharing($return_value);
        }
        return true;
    }

    function storeMultiCitiesJob($city_id, $jobid) { // city id comma seprated 
        if (is_numeric($jobid) === false)
            return false;
        $db = JFactory::getDBO();
        $query = "SELECT cityid FROM #__js_job_jobcities WHERE jobid = " . $jobid;
        $db->setQuery($query);
        $old_cities = $db->loadObjectList();

        $id_array = explode(",", $city_id);
        $row = $this->getTable('jobcities');
        $error = array();

        foreach ($old_cities AS $oldcityid) {
            $match = false;
            foreach ($id_array AS $cityid) {
                if ($oldcityid->cityid == $cityid) {
                    $match = true;
                    break;
                }
            }
            if ($match == false) {
                $query = "DELETE FROM #__js_job_jobcities WHERE jobid = " . $jobid . " AND cityid=" . $oldcityid->cityid;
                $db->setQuery($query);
                if (!$db->query()) {
                    $err = $this->setError($this->_db->getErrorMsg());
                    $error[] = $err;
                }
            }
        }
        foreach ($id_array AS $cityid) {
            $insert = true;
            foreach ($old_cities AS $oldcityid) {
                if ($oldcityid->cityid == $cityid) {
                    $insert = false;
                    break;
                }
            }
            if ($insert) {
                $row->id = "";
                $row->jobid = $jobid;
                $row->cityid = $cityid;
                if (!$row->store()) {
                    $err = $this->setError($this->_db->getErrorMsg());
                    $error[] = $err;
                }
            }
        }
        if (!empty($error))
            return false;

        return true;
    }

    function deleteJob() {
        $db = JFactory::getDBO();
        $cids = JRequest::getVar('cid', array(0), '', 'array');
        $row = $this->getTable('job');
        $deleteall = 1;
        foreach ($cids as $cid) {
            $serverjodid = 0;
            if ($this->_client_auth_key != "") {
                $query = "SELECT job.serverid AS id FROM `#__js_job_jobs` AS job WHERE job.id = " . $cid;
                $db->setQuery($query);
                $s_job_id = $db->loadResult();
                $serverjodid = $s_job_id;
            }
            if ($this->jobCanDelete($cid) == true) {
                $query = "SELECT job.uid, job.title, company.name AS companyname, company.contactname, company.contactemail,CONCAT(job.alias,'-',job.id) AS aliasid
                            FROM `#__js_job_jobs` AS job
                            JOIN `#__js_job_companies` AS company ON job.companyid = company.id
                    WHERE job.id = " . $cid;
                $db->setQuery($query);
                $job = $db->loadObject();

                $contactname = $job->contactname;
                $companyname = $job->companyname;
                $contactemail = $job->contactemail;
                $title = $job->title;

                $session = JFactory::getSession();
                $session->set('contactname', $contactname);
                $session->set('companyname', $companyname);
                $session->set('contactemail', $contactemail);
                $session->set('title', $title);
                
                if (!$row->delete($cid)) {
                    $this->setError($row->getErrorMsg());
                    return false;
                }
                $query = "DELETE FROM `#__js_job_jobcities` WHERE jobid = " . $cid;
                $db->setQuery($query);
                if (!$db->query()) {
                    return false;
                }
                
                $this->getJSModel('emailtemplate')->sendDeleteMail( $cid , 2);
                if ($serverjodid != 0) {
                    $data = array();
                    $data['id'] = $serverjodid;
                    $data['referenceid'] = $cid;
                    $data['uid'] = $this->_uid;
                    $data['authkey'] = $this->_client_auth_key;
                    $data['siteurl'] = $this->_siteurl;
                    $data['task'] = 'deletejob';
                    $jsjobsharingobject = $this->getJSModel('jobsharing');
                    $return_value = $jsjobsharingobject->deleteJobSharing($data);
                    $jobtemp = $this->getJSModel('common')->getJobtempModelFrontend();
                    $jobtemp->updateJobTemp();
                    $jsjobslogobject = $this->getJSModel('log');
                    $jsjobslogobject->logDeleteJobSharing($return_value);
                }
            } else
                $deleteall++;
        }
        return $deleteall;
    }

    function jobCanDelete($jobid) {
        if (is_numeric($jobid) == false)
            return false;
        $db = $this->getDBO();
        $query = "SELECT
                    ( SELECT COUNT(id) FROM `#__js_job_jobapply` WHERE jobid = " . $jobid . ")
                    AS total ";
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total > 0)
            return false;
        else
            return true;
    }

    function jobEnforceDelete($jobid, $uid) {
        if ($uid)
            if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
                return false;
        if (is_numeric($jobid) == false)
            return false;
        $serverjodid = 0;
        if ($this->_client_auth_key != "") {
            $query = "SELECT job.serverid AS id FROM `#__js_job_jobs` AS job WHERE job.id = " . $jobid;
            $db->setQuery($query);
            $s_job_id = $db->loadResult();
            $serverjodid = $s_job_id;
        }

        $db = $this->getDBO();

        $query = "SELECT job.uid, job.title, company.name AS companyname, company.contactname, company.contactemail,CONCAT(job.alias,'-',job.id) AS aliasid
                    FROM `#__js_job_jobs` AS job
                    JOIN `#__js_job_companies` AS company ON job.companyid = company.id
            WHERE job.id = " . $jobid;
        $db->setQuery($query);
        $job = $db->loadObject();

        $contactname = $job->contactname;
        $companyname = $job->companyname;
        $contactemail = $job->contactemail;
        $title = $job->title;

        $session = JFactory::getSession();
        $session->set('contactname', $contactname);
        $session->set('companyname', $companyname);
        $session->set('contactemail', $contactemail);
        $session->set('title', $title);



        $query = "DELETE  job,apply,jobcity
                    FROM `#__js_job_jobs` AS job
                    LEFT JOIN `#__js_job_jobapply` AS apply ON job.id=apply.jobid
                    LEFT JOIN `#__js_job_jobcities` AS jobcity ON job.id=jobcity.jobid
                    WHERE job.id = " . $jobid;

        $db->setQuery($query);
        if (!$db->query()) {
            return 2; //error while delete job
        }
        
        $this->getJSModel('emailtemplate')->sendDeleteMail( $jobid , 2);
        
        if ($serverjodid != 0) {
            $data = array();
            $data['id'] = $serverjodid;
            $data['referenceid'] = $jobid;
            $data['uid'] = $this->_uid;
            $data['authkey'] = $this->_client_auth_key;
            $data['siteurl'] = $this->_siteurl;
            $data['enforcedeletejob'] = 1;
            $data['task'] = 'deletejob';
            $jsjobsharingobject = $this->getJSModel('jobsharing');
            $return_value = $jsjobsharingobject->deleteJobSharing($data);
            $jsjobslogobject = $this->getJSModel('log');
            $jsjobslogobject->logDeleteJobSharingEnforce($return_value);
        }
        return 1;
    }

    function checkCall() {
        $db = JFactory::getDBO();
        $query = "UPDATE `#__js_job_config` SET configvalue = configvalue+1 WHERE configname = " . $db->quote('jsjobupdatecount');
        $db->setQuery($query);
        $db->query();
        $query = "SELECT configvalue AS jsjobupdatecount FROM `#__js_job_config` WHERE configname = " . $db->quote('jsjobupdatecount');
        $db->setQuery($query);
        $result = $db->loadResult();
        if ($result >= 100)
            $this->getJSModel('jsjobs')->getConcurrentrequestdata();
    }

    function jobApprove($job_id) {
        if (is_numeric($job_id) == false)
            return false;
        $db = JFactory::getDBO();

        $query = "UPDATE #__js_job_jobs SET status = 1 WHERE id = " . $db->Quote($job_id);
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        $this->getJSModel('emailtemplate')->sendMail(2, 1, $job_id);
        
        //$this->sendJobAlertJobseeker($job_id);
        if ($this->_client_auth_key != "") {
            $data_job_approve = array();
            $query = "SELECT serverid FROM #__js_job_jobs WHERE id = " . $job_id;
            $db->setQuery($query);
            $serverjobid = $db->loadResult();
            $data_job_approve['id'] = $serverjobid;
            $data_job_approve['job_id'] = $job_id;
            $data_job_approve['authkey'] = $this->_client_auth_key;
            $fortask = "jobapprove";
            $server_json_data_array = json_encode($data_job_approve);
            $jsjobsharingobject = $this->getJSModel('jobsharing');
            $return_server_value = $jsjobsharingobject->serverTask($server_json_data_array, $fortask);
            $return_value = json_decode($return_server_value, true);
            $jsjobslogobject = $this->getJSModel('log');
            $jsjobslogobject->logJobApprove($return_value);
        }
        return true;
    }

    function jobReject($job_id) {
        if (is_numeric($job_id) == false)
            return false;
        $db = JFactory::getDBO();

        $query = "UPDATE #__js_job_jobs SET status = -1 WHERE id = " . $db->Quote($job_id);
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        $this->getJSModel('emailtemplate')->sendMail(2, -1, $job_id);
        if ($this->_client_auth_key != "") {
            $data_job_reject = array();
            $query = "SELECT serverid FROM #__js_job_jobs WHERE id = " . $job_id;
            $db->setQuery($query);
            $serverjobid = $db->loadResult();
            $data_job_reject['id'] = $serverjobid;
            $data_job_reject['job_id'] = $job_id;
            $data_job_reject['authkey'] = $this->_client_auth_key;
            $fortask = "jobreject";
            $server_json_data_array = json_encode($data_job_reject);
            $jsjobsharingobject = new JSJobsModelJobSharing;
            $return_server_value = $jsjobsharingobject->serverTask($server_json_data_array, $fortask);
            return json_decode($return_server_value, true);
        } else {
            return true;
        }
    }

    function getJobId() {
        $db = $this->getDBO();
        $query = "Select jobid from `#__js_job_jobs`";
        do {

            $jobid = "";
            $length = 9;
            $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ!@#";
            // we refer to the length of $possible a few times, so let's grab it now
            $maxlength = strlen($possible);
            // check for length overflow and truncate if necessary
            if ($length > $maxlength) {
                $length = $maxlength;
            }
            // set up a counter for how many characters are in the password so far
            $i = 0;
            // add random characters to $password until $length is reached
            while ($i < $length) {
                // pick a random character from the possible ones
                $char = substr($possible, mt_rand(0, $maxlength - 1), 1);
                // have we already used this character in $password?

                if (!strstr($jobid, $char)) {
                    if ($i == 0) {
                        if (ctype_alpha($char)) {
                            $jobid .= $char;
                            $i++;
                        }
                    } else {
                        $jobid .= $char;
                        $i++;
                    }
                }
            }
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            foreach ($rows as $row) {
                if ($jobid == $row->jobid)
                    $match = 'Y';
                else
                    $match = 'N';
            }
        }while ($match == 'Y');
        return $jobid;
    }
}
?>