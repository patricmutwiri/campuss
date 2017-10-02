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
$option = JRequest::getVar('option', 'com_jsjobs');

class JSJobsModelResume extends JSModel {

    var $_uid = null;
    var $_client_auth_key = null;
    var $_siteurl = null;
    var $_application = null;
    var $_empoptions = null;

    function __construct() {
        parent::__construct();
        $this->_client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function resumesearch($sh_gender, $sh_nationality, $sh_category, $sh_subcategory, $sh_jobtype, $sh_heighesteducation, $sh_salaryrange, $plugin) {
        $db = JFactory::getDBO();
        $result = array();
        // Gender *********************************************
        if ($sh_gender == 1) {
            $genders = array(
                '0' => array('value' => '', 'text' => JText::_('Select Gender')),
                '1' => array('value' => 1, 'text' => JText::_('Male')),
                '2' => array('value' => 2, 'text' => JText::_('Female')),);
            $gender = JHTML::_('select.genericList', $genders, 'gender', 'class="inputbox" style="width:160px;" ' . '', 'value', 'text', '');
        }
        // Natinality *********************************************
        if ($sh_nationality == 1) {
            $query = "SELECT * FROM `#__js_job_countries` WHERE enabled = 1 ORDER BY name ASC ";
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            if (isset($rows)) {
                $countries = array();
                $countries[] = array('value' => JText::_(''), 'text' => JText::_('Select Country'));
                foreach ($rows as $row) {
                    $countries[] = array('value' => $row->id, 'text' => JText::_($row->name));
                }
            }
            $nationality = JHTML::_('select.genericList', $countries, 'nationality', 'class="inputbox" style="width:160px;" ' . '', 'value', 'text', '');
        }
        // Categories *********************************************
        if ($sh_category == 1) {
            $query = "SELECT * FROM `#__js_job_categories` WHERE isactive = 1 ORDER BY cat_title ";
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            if (isset($rows)) {
                $jobcategories = array();
                $jobcategories[] = array('value' => JText::_(''), 'text' => JText::_('Select Category'));
                foreach ($rows as $row)
                    $jobcategories[] = array('value' => JText::_($row->id), 'text' => JText::_($row->cat_title));
            }
            if (isset($plugin) && $plugin == 1)
                $job_categories = JHTML::_('select.genericList', $jobcategories, 'jobcategory', 'class="inputbox" style="width:160px;" ' . 'onChange="plgfj_getsubcategories(\'plgresumefj_subcategory\', this.value)"', 'value', 'text', '');
            else
                $job_categories = JHTML::_('select.genericList', $jobcategories, 'jobcategory', 'class="inputbox" style="width:160px;" ' . 'onChange="modfj_getsubcategories(\'modresumefj_subcategory\', this.value)"', 'value', 'text', '');
        }
        // Sub Categories *********************************************
        if ($sh_subcategory == 1) {
            $jobsubcategories = array();
            $jobsubcategories[] = array('value' => JText::_(''), 'text' => JText::_('Select Sub Category'));
            $job_subcategories = JHTML::_('select.genericList', $jobsubcategories, 'jobsubcategory', 'class="inputbox" style="width:160px;" ' . '', 'value', 'text', '');
        }
        //Job Types *********************************************
        if ($sh_jobtype == 1) {
            $query = "SELECT id, title FROM `#__js_job_jobtypes` WHERE isactive = 1 ORDER BY id ASC ";
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            if (isset($rows)) {
                $jobtype = array();
                $jobtype[] = array('value' => JText::_(''), 'text' => JText::_('Select Job Type'));
                foreach ($rows as $row)
                    $jobtype[] = array('value' => JText::_($row->id), 'text' => JText::_($row->title));
            }
            $job_type = JHTML::_('select.genericList', $jobtype, 'jobtype', 'class="inputbox" style="width:160px;" ' . '', 'value', 'text', '');
        }
        //Job Heighest Education  *********************************************
        if ($sh_heighesteducation == 1) {
            $query = "SELECT id, title FROM `#__js_job_heighesteducation` WHERE isactive = 1 ORDER BY id ASC ";
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            if (isset($rows)) {
                $heighesteducation = array();
                $heighesteducation[] = array('value' => JText::_(''), 'text' => JText::_('Select Highest Education'));
                foreach ($rows as $row)
                    $heighesteducation[] = array('value' => JText::_($row->id), 'text' => JText::_($row->title));
            }
            $heighest_finisheducation = JHTML::_('select.genericList', $heighesteducation, 'heighestfinisheducation', 'class="inputbox" style="width:160px;" ' . '', 'value', 'text', '');
        }
        // Salary Rnage *********************************************
        if ($sh_salaryrange == 1) {
            $query = "SELECT * FROM `#__js_job_salaryrange` ORDER BY 'id' ";
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            if (isset($rows)) {
                $jobsalaryrange = array();
                $jobsalaryrange[] = array('value' => JText::_(''), 'text' => JText::_('Select Salary Range'));
                foreach ($rows as $row) {
                    $salrange = $row->rangestart . ' - ' . $row->rangeend;
                    $jobsalaryrange[] = array('value' => JText::_($row->id), 'text' => JText::_($salrange));
                }
            }
            $salary_range = JHTML::_('select.genericList', $jobsalaryrange, 'jobsalaryrange', 'class="inputbox" style="width:50%;" ' . '', 'value', 'text', '');
            // currencies 
            $currencycombo = $this->getJSModel('currency')->getCurrencyCombo();
        }
        $experiences = $this->getJSModel('experience')->getExperiences(JText::_('Select Minimum Experience'));
        $experiences1 = $this->getJSModel('experience')->getExperiences(JText::_('Select Maximum Experience'));
        $experiencemin = JHTML::_('select.genericList', $experiences, 'experiencemin', 'class="inputbox jsjobs-cbo" style="width:49%;margin-right:1%;float:left;"' . '', 'value', 'text', '');
        $experiencemax = JHTML::_('select.genericList', $experiences1, 'experiencemax', 'class="inputbox jsjobs-cbo" style="width:49.5%;"' . '', 'value', 'text', '');
        
        if (isset($gender))
            $result[0] = $gender;
        if (isset($nationality))
            $result[1] = $nationality;
        if (isset($job_categories))
            $result[2] = $job_categories;
        if (isset($job_type))
            $result[3] = $job_type;
        if (isset($heighest_finisheducation))
            $result[4] = $heighest_finisheducation;
        if (isset($salary_range))
            $result[5] = $salary_range;
        if (isset($currencycombo))
            $result[6] = $currencycombo;
        if (isset($job_subcategories))
            $result[7] = $job_subcategories;
        return $result;
    }

    function getTopResumes($noofresumes, $theme) {
        if($noofresumes)
            if(!is_numeric($noofresumes)) return false;

        $db = JFactory::getDBO();
        $dateformat = $this->getJSModel('configurations')->getConfigValue('date_format');
        $data_directory = $this->getJSModel('configurations')->getConfigValue('data_directory');
        $this->getJSModel('common')->setTheme();

        $id = "resume.id AS id";
        $alias = ",CONCAT(resume.alias,'-',resume.id) AS resumealiasid ";
        $query = "SELECT resume.packageid,resume.id AS resumeid,subcat.title AS subcat_title,
         $id, resume.application_title AS applicationtitle, CONCAT(resume.first_name, resume.last_name) AS name 
        , resume.gender, resume.iamavailable AS available, resume.photo, resume.heighestfinisheducation
        , resume.total_experience AS experiencetitle, resume.created AS created , cat.cat_title, jobtype.title AS jobtypetitle
        , country.name AS countryname, state.name AS statename,  city.cityName AS cityname, nationality.name AS nationalityname
        $alias,(SELECT address.address_city FROM `#__js_job_resumeaddresses` AS address WHERE address.resumeid = resume.id LIMIT 1) AS cityId
         
        FROM `#__js_job_resume` AS resume 
            LEFT JOIN `#__js_job_categories` AS cat ON resume.job_category = cat.id 
            LEFT JOIN `#__js_job_subcategories` AS subcat ON resume.job_subcategory = subcat.id 
            LEFT JOIN `#__js_job_jobtypes` AS jobtype ON resume.jobtype = jobtype.id 
            LEFT JOIN `#__js_job_currencies` AS currency ON currency.id = resume.currencyid 
            LEFT JOIN `#__js_job_heighesteducation` AS highesteducation ON highesteducation.id = resume.heighestfinisheducation
            LEFT JOIN `#__js_job_salaryrange` AS salrange ON salrange.id = resume.jobsalaryrange
            LEFT JOIN `#__js_job_countries` AS nationality ON nationality.id=resume.nationality 
            WHERE resume.status = 1 
            ORDER BY resume.hits DESC LIMIT {$noofresumes}";
        $db->setQuery($query);
       $datalocal=$db->loadObjectList();
        foreach ($datalocal as $d) {
            $d->cityname = $this->getJSModel('cities')->getLocationDataForView($d->city);
        }

        $result[0] = $datalocal;
        $result[2] = $dateformat;
        $result[3] = $data_directory;
        return $result;
    }

    function getNewestResumes($noofresumes, $theme) {
        if($noofresumes)
            if(!is_numeric($noofresumes)) return false;

        $db = JFactory::getDBO();
        $dateformat = $this->getJSModel('configurations')->getConfigValue('date_format');
        $data_directory = $this->getJSModel('configurations')->getConfigValue('data_directory');
        $this->getJSModel('common')->setTheme();

        $id = "resume.id AS id";
        $alias = ",CONCAT(resume.alias,'-',resume.id) AS resumealiasid ";
        $query = "SELECT resume.packageid,resume.id AS resumeid,subcat.title AS subcat_title,
         $id, resume.application_title AS applicationtitle, CONCAT(resume.first_name,' ',resume.last_name) AS name 
        , resume.gender, resume.iamavailable AS available, resume.photo, resume.heighestfinisheducation
        , resume.total_experience AS experiencetitle, resume.created AS created, cat.cat_title, jobtype.title AS jobtypetitle
        , nationality.name AS nationalityname,city.id AS city
        $alias,(SELECT address.address_city FROM `#__js_job_resumeaddresses` AS address WHERE address.resumeid = resume.id LIMIT 1) AS cityId
         
        FROM `#__js_job_resume` AS resume 
            LEFT JOIN `#__js_job_categories` AS cat ON resume.job_category = cat.id 
            LEFT JOIN `#__js_job_subcategories` AS subcat ON resume.job_subcategory = subcat.id 
            LEFT JOIN `#__js_job_jobtypes` AS jobtype ON resume.jobtype = jobtype.id 
            LEFT JOIN `#__js_job_countries` AS nationality ON nationality.id=resume.nationality 

            LEFT JOIN `#__js_job_heighesteducation` AS education ON resume.heighestfinisheducation = education.id 
            LEFT JOIN `#__js_job_salaryrange` AS salary ON resume.jobsalaryrange = salary.id 
            LEFT JOIN `#__js_job_currencies` AS currency ON currency.id = resume.currencyid 
            LEFT JOIN `#__js_job_cities` AS city ON city.id = (SELECT id FROM `#__js_job_resumeaddresses` WHERE resumeid = resume.id LIMIT 1)

            WHERE resume.status = 1 ORDER BY resume.created DESC LIMIT {$noofresumes}";
        $db->setQuery($query);
        $datalocal=$db->loadObjectList();
        foreach ($datalocal as $d) {
            $d->cityname = $this->getJSModel('cities')->getLocationDataForView($d->city);
        }

        $result[0] = $datalocal;
        $result[2] = $dateformat;
        $result[3] = $data_directory;

        return $result;
    }

    function getResumeListsForForm($resumeid, $uid) { // created and used by muhiaudin
        $resumelists = array();
        $gender = array(
            '0' => array('value' => 1, 'text' => JText::_('Male')),
            '1' => array('value' => 2, 'text' => JText::_('Female')),);
        $driving_license = array(
            '0' => array('value' => '', 'text' => JText::_('Select Driving License')),
            '1' => array('value' => 1, 'text' => JText::_('Yes')),
            '2' => array('value' => 2, 'text' => JText::_('No')));

        $resumedata = $this->getResumeBySection($resumeid, 'personal', 1);
        $application = $resumedata[0];
        $fieldOrdering = $resumedata[1];

        $nationality_required = '';
        $license_country_required = '';
        $gender_required = '';
        $driving_license_required = '';
        $category_required = '';
        $subcategory_required = '';
        $salary_required = '';
        $workpreference_required = '';
        $education_required = '';
        $expsalary_required = '';
        foreach ($fieldOrdering AS $fo) {
            switch ($fo->field) {
                case "nationality":
                    $nationality_required = ($fo->required ? 'required' : '');
                    break;
                case "license_country":
                    $license_country_required = ($fo->required ? 'required' : '');
                    break;
                case "gender":
                    $gender_required = ($fo->required ? 'required' : '');
                    break;
                case "driving_license":
                    $driving_license_required = ($fo->required ? 'required' : '');
                    break;
                case "job_category":
                    $category_required = ($fo->required ? 'required' : '');
                    break;
                case "job_subcategory":
                    $subcategory_required = ($fo->required ? 'required' : '');
                    break;
                case "salary":
                    $salary_required = ($fo->required ? 'required' : '');
                    break;
                case "jobtype":
                    $workpreference_required = ($fo->required ? 'required' : '');
                    break;
                case "heighestfinisheducation":
                    $education_required = ($fo->required ? 'required' : '');
                    break;
                case "desired_salary":
                    $expsalary_required = ($fo->required ? 'required' : '');
                    break;
                case "total_experience":
                    $experienceid_required = ($fo->required ? 'required' : '');
                    break;
            }
        }

        $defaultCategory = $this->getJSModel('common')->getDefaultValue('categories');
        $defaultJobtype = $this->getJSModel('common')->getDefaultValue('jobtypes');
        $defaultEducation = $this->getJSModel('common')->getDefaultValue('heighesteducation');
        $defaultSalaryrange = $this->getJSModel('common')->getDefaultValue('salaryrange');
        $defaultSalaryrangeType = $this->getJSModel('common')->getDefaultValue('salaryrangetypes');
        $defaultCurrencies = $this->getJSModel('common')->getDefaultValue('currencies');
        $defaultExperiences = $this->getJSModel('common')->getDefaultValue('experiences');

        $job_type = $this->getJSModel('jobtype')->getJobType('');
        $heighesteducation = $this->getJSModel('highesteducation')->getHeighestEducation('');
        $job_categories = $this->getJSModel('category')->getCategories('');
        $job_salaryrange = $this->getJSModel('salaryrange')->getJobSalaryRange('', '');
        $job_salaryrangetype = $this->getJSModel('salaryrangetype')->getJobSalaryRangeType(JText::_('Select Range Type'));
        $countries = $this->getJSModel('countries')->getCountries('');
        $experiences = $this->getJSModel('experience')->getExperiences(JText::_('Select Experience'));
        if (isset($application)) {
            $job_subcategories = $this->getJSModel('subcategory')->getSubCategoriesforCombo($application->job_category, '', $application->job_subcategory);
        } else {
            $job_subcategories = $this->getJSModel('subcategory')->getSubCategoriesforCombo($defaultCategory, '', '');
        }
        if (isset($application)) {
            $resumelists['nationality'] = JHTML::_('select.genericList', $countries, 'nationality', 'class="inputbox ' . $nationality_required . ' jsjobs-cbo" ' . '', 'value', 'text', $application->nationality);
            $resumelists['license_country'] = JHTML::_('select.genericList', $countries, 'license_country', 'class="inputbox ' . $license_country_required . ' jsjobs-cbo" ' . '', 'value', 'text', $application->license_country);
            $resumelists['gender'] = JHTML::_('select.genericList', $gender, 'gender', 'class="inputbox ' . $gender_required . ' jsjobs-cbo" ' . '', 'value', 'text', $application->gender);
            $resumelists['driving_license'] = JHTML::_('select.genericList', $driving_license, 'driving_license', 'class="inputbox ' . $driving_license_required . ' jsjobs-cbo" ' . '', 'value', 'text', $application->driving_license);

            $resumelists['job_category'] = JHTML::_('select.genericList', $job_categories, 'job_category', 'class="inputbox ' . $category_required . ' jsjobs-cbo" ' . 'onChange="return fj_getsubcategories(\'job_subcategory\', this.value)"', 'value', 'text', $application->job_category);
            if(!empty($job_subcategories))
                $resumelists['job_subcategory'] = JHTML::_('select.genericList', $job_subcategories, 'job_subcategory', 'class="inputbox ' . $subcategory_required . ' jsjobs-cbo" ' . '', 'value', 'text', $application->job_subcategory);
            else
                $resumelists['job_subcategory'] = JHTML::_('select.genericList', array(), 'job_subcategory', 'class="inputbox ' . $subcategory_required . ' jsjobs-cbo" ' . '', 'value', 'text', $application->job_subcategory);

            $resumelists['jobtype'] = JHTML::_('select.genericList', $job_type, 'jobtype', 'class="inputbox ' . $workpreference_required . ' jsjobs-cbo" ' . '', 'value', 'text', $application->jobtype);
            $resumelists['heighestfinisheducation'] = JHTML::_('select.genericList', $heighesteducation, 'heighestfinisheducation', 'class="inputbox ' . $education_required . ' jsjobs-cbo" ' . '', 'value', 'text', $application->heighestfinisheducation);
            $resumelists['jobsalaryrange'] = JHTML::_('select.genericList', $job_salaryrange, 'jobsalaryrange', 'class="inputbox ' . $salary_required . ' jsjobs-cbo" ' . '', 'value', 'text', $application->jobsalaryrange);
            $resumelists['desired_salary'] = JHTML::_('select.genericList', $job_salaryrange, 'desired_salary', 'class="inputbox ' . $expsalary_required . ' jsjobs-cbo" ' . '', 'value', 'text', $application->desired_salary);
            $resumelists['jobsalaryrangetypes'] = JHTML::_('select.genericList', $job_salaryrangetype, 'jobsalaryrangetype', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', $application->jobsalaryrangetype);
            $resumelists['djobsalaryrangetypes'] = JHTML::_('select.genericList', $job_salaryrangetype, 'djobsalaryrangetype', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', $application->djobsalaryrangetype);
            $resumelists['currencyid'] = JHTML::_('select.genericList', $this->getJSModel('currency')->getCurrency(), 'currencyid', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', $application->currencyid);
            $resumelists['dcurrencyid'] = JHTML::_('select.genericList', $this->getJSModel('currency')->getCurrency(), 'dcurrencyid', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', $application->dcurrencyid);
            $resumelists['experienceid'] = JHTML::_('select.genericList', $experiences, 'experienceid', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', $application->experienceid);
        } else {
            $resumelists['license_country'] = JHTML::_('select.genericList', $countries, 'license_country', 'class="inputbox ' . $license_country_required . ' jsjobs-cbo" ' . '', 'value', 'text', '');
            $resumelists['nationality'] = JHTML::_('select.genericList', $countries, 'nationality', 'class="inputbox ' . $nationality_required . ' jsjobs-cbo" ' . '', 'value', 'text', '');
            $resumelists['gender'] = JHTML::_('select.genericList', $gender, 'gender', 'class="inputbox ' . $gender_required . ' jsjobs-cbo" ' . '', 'value', 'text', '');
            $resumelists['driving_license'] = JHTML::_('select.genericList', $driving_license, 'driving_license', 'class="inputbox ' . $driving_license_required . ' jsjobs-cbo" ' . '', 'value', 'text', '');

            $resumelists['job_category'] = JHTML::_('select.genericList', $job_categories, 'job_category', 'class="inputbox ' . $category_required . ' jsjobs-cbo" ' . 'onChange="fj_getsubcategories(\'job_subcategory\', this.value)"', 'value', 'text', $defaultCategory);
            $resumelists['job_subcategory'] = JHTML::_('select.genericList', $job_subcategories, 'job_subcategory', 'class="inputbox ' . $subcategory_required . ' jsjobs-cbo" ' . '', 'value', 'text', '');

            $resumelists['jobtype'] = JHTML::_('select.genericList', $job_type, 'jobtype', 'class="inputbox ' . $workpreference_required . ' jsjobs-cbo" ' . '', 'value', 'text', $defaultJobtype);
            $resumelists['heighestfinisheducation'] = JHTML::_('select.genericList', $heighesteducation, 'heighestfinisheducation', 'class="inputbox ' . $education_required . ' jsjobs-cbo" ' . '', 'value', 'text', $defaultEducation);
            $resumelists['jobsalaryrange'] = JHTML::_('select.genericList', $job_salaryrange, 'jobsalaryrange', 'class="inputbox ' . $salary_required . ' jsjobs-cbo" ' . '', 'value', 'text', $defaultSalaryrange);
            $resumelists['jobsalaryrangetypes'] = JHTML::_('select.genericList', $job_salaryrangetype, 'jobsalaryrangetype', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', $defaultSalaryrangeType);
            $resumelists['djobsalaryrangetypes'] = JHTML::_('select.genericList', $job_salaryrangetype, 'djobsalaryrangetype', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', $defaultSalaryrangeType);


            $resumelists['desired_salary'] = JHTML::_('select.genericList', $job_salaryrange, 'desired_salary', 'class="inputbox ' . $expsalary_required . ' jsjobs-cbo" ' . '', 'value', 'text', $defaultSalaryrange);
            $resumelists['currencyid'] = JHTML::_('select.genericList', $this->getJSModel('currency')->getCurrency(), 'currencyid', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', $defaultCurrencies);
            $resumelists['dcurrencyid'] = JHTML::_('select.genericList', $this->getJSModel('currency')->getCurrency(), 'dcurrencyid', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', $defaultCurrencies);
            $resumelists['experienceid'] = JHTML::_('select.genericList', $experiences, 'experienceid', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', $defaultExperiences);
        }
        return $resumelists;
    }

    function getEmpOptions() {
        if (!$this->_empoptions) {
            $this->_empoptions = array();
            $gender = array(
                '0' => array('value' => 1, 'text' => JText::_('Male')),
                '1' => array('value' => 2, 'text' => JText::_('Female')),);
            $fieldOrdering = $this->getJSModel('customfields')->getFieldsOrdering(3, false); // resume fields
            $nationality_required = '';
            $gender_required = '';
            $category_required = '';
            $subcategory_required = '';
            $salary_required = '';
            $workpreference_required = '';
            $education_required = '';
            $expsalary_required = '';
            foreach ($fieldOrdering AS $fo) {
                switch ($fo->field) {
                    case "nationality":
                        $nationality_required = ($fo->required ? 'required' : '');
                        break;
                    case "gender":
                        $gender_required = ($fo->required ? 'required' : '');
                        break;
                    case "category":
                        $category_required = ($fo->required ? 'required' : '');
                        break;
                    case "subcategory":
                        $subcategory_required = ($fo->required ? 'required' : '');
                        break;
                    case "salary":
                        $salary_required = ($fo->required ? 'required' : '');
                        break;
                    case "jobtype":
                        $workpreference_required = ($fo->required ? 'required' : '');
                        break;
                    case "heighesteducation":
                        $education_required = ($fo->required ? 'required' : '');
                        break;
                    case "desiredsalary":
                        $expsalary_required = ($fo->required ? 'required' : '');
                        break;
                }
            }



            $defaultCategory = $this->getJSModel('common')->getDefaultValue('categories');
            $defaultJobtype = $this->getJSModel('common')->getDefaultValue('jobtypes');
            $defaultEducation = $this->getJSModel('common')->getDefaultValue('heighesteducation');
            $defaultSalaryrange = $this->getJSModel('common')->getDefaultValue('salaryrange');
            $defaultSalaryrangeType = $this->getJSModel('common')->getDefaultValue('salaryrangetypes');
            $defaultCurrencies = $this->getJSModel('common')->getDefaultValue('currencies');

            $job_type = $this->getJSModel('jobtype')->getJobType('');
            $heighesteducation = $this->getJSModel('highesteducation')->getHeighestEducation('');
            $job_categories = $this->getJSModel('category')->getCategories('');
            $job_salaryrange = $this->getJSModel('salaryrange')->getJobSalaryRange('', '');
            $job_salaryrangetype = $this->getJSModel('salaryrangetype')->getJobSalaryRangeType(JText::_('Select Range Type'));
            $countries = $this->getJSModel('countries')->getCountries('');
            if (isset($this->_application)) {
                $job_subcategories = $this->getJSModel('subcategory')->getSubCategoriesforCombo($this->_application->job_category, '', $this->_application->job_subcategory);
            } else {
                $job_subcategories = $this->getJSModel('subcategory')->getSubCategoriesforCombo($defaultCategory, '', '');
            }
            if (isset($this->_application)) {
                $this->_empoptions['nationality'] = JHTML::_('select.genericList', $countries, 'nationality', 'class="inputbox ' . $nationality_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_application->nationality);
                $this->_empoptions['gender'] = JHTML::_('select.genericList', $gender, 'gender', 'class="inputbox ' . $gender_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_application->gender);

                $this->_empoptions['job_category'] = JHTML::_('select.genericList', $job_categories, 'job_category', 'class="inputbox ' . $category_required . ' jsjobs-cbo" ' . 'onChange="fj_getsubcategories(\'fj_subcategory\', this.value)"', 'value', 'text', $this->_application->job_category);
                $this->_empoptions['job_subcategory'] = JHTML::_('select.genericList', $job_subcategories, 'job_subcategory', 'class="inputbox ' . $subcategory_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_application->job_subcategory);

                $this->_empoptions['jobtype'] = JHTML::_('select.genericList', $job_type, 'jobtype', 'class="inputbox ' . $workpreference_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_application->jobtype);
                $this->_empoptions['heighestfinisheducation'] = JHTML::_('select.genericList', $heighesteducation, 'heighestfinisheducation', 'class="inputbox ' . $education_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_application->heighestfinisheducation);
                $this->_empoptions['jobsalaryrange'] = JHTML::_('select.genericList', $job_salaryrange, 'jobsalaryrange', 'class="inputbox ' . $salary_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_application->jobsalaryrange);
                $this->_empoptions['desired_salary'] = JHTML::_('select.genericList', $job_salaryrange, 'desired_salary', 'class="inputbox ' . $expsalary_required . ' jsjobs-cbo" ' . '', 'value', 'text', $this->_application->desired_salary);
                $this->_empoptions['jobsalaryrangetypes'] = JHTML::_('select.genericList', $job_salaryrangetype, 'jobsalaryrangetype', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', $this->_application->jobsalaryrangetype);
                $this->_empoptions['djobsalaryrangetypes'] = JHTML::_('select.genericList', $job_salaryrangetype, 'djobsalaryrangetype', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', $this->_application->djobsalaryrangetype);
                $this->_empoptions['currencyid'] = JHTML::_('select.genericList', $this->getJSModel('currency')->getCurrency(), 'currencyid', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', $this->_application->currencyid);
                $this->_empoptions['dcurrencyid'] = JHTML::_('select.genericList', $this->getJSModel('currency')->getCurrency(), 'dcurrencyid', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', $this->_application->dcurrencyid);
            } else {
                $this->_empoptions['nationality'] = JHTML::_('select.genericList', $countries, 'nationality', 'class="inputbox ' . $nationality_required . ' jsjobs-cbo" ' . '', 'value', 'text', '');
                $this->_empoptions['gender'] = JHTML::_('select.genericList', $gender, 'gender', 'class="inputbox ' . $gender_required . ' jsjobs-cbo" ' . '', 'value', 'text', '');

                $this->_empoptions['job_category'] = JHTML::_('select.genericList', $job_categories, 'job_category', 'class="inputbox ' . $category_required . ' jsjobs-cbo" ' . 'onChange="fj_getsubcategories(\'fj_subcategory\', this.value)"', 'value', 'text', $defaultCategory);
                $this->_empoptions['job_subcategory'] = JHTML::_('select.genericList', $job_subcategories, 'job_subcategory', 'class="inputbox ' . $subcategory_required . ' jsjobs-cbo" ' . '', 'value', 'text', '');

                $this->_empoptions['jobtype'] = JHTML::_('select.genericList', $job_type, 'jobtype', 'class="inputbox ' . $workpreference_required . ' jsjobs-cbo" ' . '', 'value', 'text', $defaultJobtype);
                $this->_empoptions['heighestfinisheducation'] = JHTML::_('select.genericList', $heighesteducation, 'heighestfinisheducation', 'class="inputbox ' . $education_required . ' jsjobs-cbo" ' . '', 'value', 'text', $defaultEducation);
                $this->_empoptions['jobsalaryrange'] = JHTML::_('select.genericList', $job_salaryrange, 'jobsalaryrange', 'class="inputbox ' . $salary_required . ' jsjobs-cbo" ' . '', 'value', 'text', $defaultSalaryrange);
                $this->_empoptions['jobsalaryrangetypes'] = JHTML::_('select.genericList', $job_salaryrangetype, 'jobsalaryrangetype', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', $defaultSalaryrangeType);
                $this->_empoptions['djobsalaryrangetypes'] = JHTML::_('select.genericList', $job_salaryrangetype, 'djobsalaryrangetype', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', $defaultSalaryrangeType);


                $this->_empoptions['desired_salary'] = JHTML::_('select.genericList', $job_salaryrange, 'desired_salary', 'class="inputbox ' . $expsalary_required . ' jsjobs-cbo" ' . '', 'value', 'text', $defaultSalaryrange);
                $this->_empoptions['currencyid'] = JHTML::_('select.genericList', $this->getJSModel('currency')->getCurrency(), 'currencyid', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', $defaultCurrencies);
                $this->_empoptions['dcurrencyid'] = JHTML::_('select.genericList', $this->getJSModel('currency')->getCurrency(), 'dcurrencyid', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', $defaultCurrencies);
            }
        }
        return $this->_empoptions;
    }

    function getMyResumesbyUid($u_id, $sortby, $limit, $limitstart) {
        $db = $this->getDBO();
        if (is_numeric($u_id) == false)
            return false;
        $result = array();
        $resumeconfig = $this->getJSModel('configurations')->getConfigByFor('searchresume');
        $query = "SELECT COUNT(id) FROM `#__js_job_resume` WHERE uid  = " . $u_id;
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT resume.params,resume.id,resume.first_name,resume.created,resume.application_title,resume.email_address,resume.photo,resume.last_name,resume.endgolddate,resume.endfeaturedate,
                    resume.status, category.cat_title, jobtype.title AS jobtypetitle, salary.rangestart, salary.rangeend 
                    ,city.id AS cityid,edu.title AS educationtitle
                    , currency.symbol  ,CONCAT(resume.alias,'-',resume.id) AS resumealiasid 
                    ,salarytype.title AS salarytype ,exp.title AS exptitle,resume.total_experience,
                    (SELECT raddress.address FROM `#__js_job_resumeaddresses` AS raddress WHERE raddress.resumeid = resume.id limit 1) AS location
                    FROM `#__js_job_resume` AS resume 
                    LEFT JOIN `#__js_job_categories` AS category ON resume.job_category = category.id 
                    LEFT JOIN `#__js_job_salaryrange` AS salary ON resume.jobsalaryrange = salary.id 
                    LEFT JOIN `#__js_job_jobtypes` AS jobtype ON resume.jobtype = jobtype.id 
                    LEFT JOIN `#__js_job_salaryrangetypes` AS salarytype ON resume.jobsalaryrangetype = salarytype.id 
                    LEFT JOIN `#__js_job_cities` AS city ON city.id = (SELECT address.address_city FROM `#__js_job_resumeaddresses` AS address WHERE address.resumeid = resume.id LIMIT 1 )
                    LEFT JOIN `#__js_job_currencies` AS currency ON currency.id = resume.currencyid 
                    LEFT JOIN `#__js_job_experiences` AS exp ON exp.id = resume.experienceid 
                    LEFT JOIN `#__js_job_heighesteducation` AS edu ON edu.id = resume.heighestfinisheducation 

                    WHERE resume.uid  = " . $u_id . " ORDER BY " . $sortby;
        $db->setQuery($query);
        $db->setQuery($query, $limitstart, $limit);
        $this->_applications = $db->loadObjectList();

        $localwork = $this->_applications;
        $newarray = array();
        foreach ($localwork as $row ) {
            $row->location = $this->getJSModel('cities')->getLocationDataForView($row->cityid);
            $newarray[] = $row;
        }
        $this->_applications = $newarray;
        $fieldsordering = $this->getJSModel('customfields')->getFieldsOrdering(3);
        $fieldsordering = $this->getJSModel('customfields')->parseFieldsOrderingForView($fieldsordering);

        $result[0] = $this->_applications;
        $result[1] = $total;
        $result[2] = $resumeconfig;
        $result[3] = $fieldsordering;

        return $result;
    }

    function getResumebyId($id, $u_id) { // used by muhiaudin for new resume form
        $db = $this->getDBO();
        if (is_numeric($u_id) == false)
            return false;
        if (($id != '') && ($id != 0)) {
            if (is_numeric($id) == false)
                return false;
            $query = "SELECT * FROM `#__js_job_resume` WHERE id = " . $id . " AND uid  = " . $u_id;
            $db->setQuery($query);
            $this->_application = $db->loadObject();
            $result[0] = $this->_application;
        }
        if ($u_id != "" AND $u_id != 0)
            $result[3] = $this->getJSModel('customfields')->getFieldsOrdering(3); // resume fields
        else
            $result[3] = $this->getJSModel('customfields')->getFieldsOrdering(16); // resume visitor fields

        $session = JFactory::getSession();
        $visitor = $session->get('jsjob_jobapply');

        if ($id || $visitor) { // not new
            if (!defined('VALIDATE')) {
                define('VALIDATE', 'VALIDATE');
            }
            $result[4] = VALIDATE;
        } else { // new
            $result[4] = $this->getJSModel('permissions')->checkPermissionsFor('ADD_RESUME');
            $result[5] = $this->getPackageDetailByUid($u_id);
        }
        return $result;
    }

    // created and used by muhiaudin for resume form
    function getResumeSection($isadmin = 0) { // to get data for resumeform and resume_view layouts
        $resumeid = (int) JRequest::getVar('resumeid');
        $sectionid = (int) JRequest::getVar('sectionid'); // address id, employer id, reference id etc
        $sectionName = JRequest::getVar('sectionName');
        $sectionType = JRequest::getVar('sectiontype');
        switch ($sectionName) {
            case 'personal': $section = 1;
                break;
            case 'address': $section = 2;
                break;
            case 'institute': $section = 3;
                break;
            case 'employer': $section = 4;
                break;
            case 'skills': $section = 5;
                break;
            case 'editor': $section = 6;
                break;
            case 'reference': $section = 7;
                break;
            case 'language': $section = 8;
                break;
        }

        $user = JFactory::getUser();
        $uid = $user->id;
        $packagedetail = $this->getPackageDetailByUid($uid);
        $session = JFactory::getSession();
        $config = $session->get('jsjobconfig_dft');
        if(empty($config)){
            $config = $this->getJSModel('configurations')->getConfigByFor('default');
        }
        $data = array();

        if ($sectionName == 'personal') {
            $resumeData = $this->getResumeBySection($resumeid, 'personal', $section);
            $sectionData = $resumeData[0];
            $fieldsordering = $resumeData[1];
            $resumelists = $this->getResumeListsForForm($resumeid, $uid);
            $maxPhotoSize = $this->getJSModel('configurations')->getConfigValue('resume_photofilesize');
            $allowedPhotoTypes = $this->getJSModel('configurations')->getConfigValue('image_file_type');
            if (($uid == "" || $uid == 0) && $isadmin == 0) {
                $captcha = $this->getJSModel('common')->getCaptchaForForm();
            } else {
                $captcha = null;
            }
            $currentFromData = null;
            $sectionMaxForms = '';
            $sectionExistingRecords = '';
        } else {
            $currentFromData = array();
            $sectionData = array();
            $sectionExistingRecords = 0;
            $sectionMaxForms = 0;

            if ($sectionName == "skills" OR $sectionName == "editor") {
                $sectionResult = $this->getResumeBySection($resumeid, $sectionName, $section);
                $sectionData = $sectionResult[0];
                $fieldsordering = $sectionResult[1];
            } else {
                if ($sectionType == "view") {
                    $sectionResult = $this->getResumeBySection($resumeid, $sectionName, $section);
                    $sectionData = $sectionResult[0];
                    $fieldsordering = $sectionResult[1];
                    $sectionExistingRecords = $sectionResult[2];
                } else {
                    if ($sectionid != -1) {
                        $sectionResult = $this->getResumeSectionById($sectionid, $resumeid, $sectionName, $section);
                        $currentFromData = $sectionResult[0];
                        $fieldsordering = $sectionResult[1];
                    } else {
                        $sectionResult = $this->getResumeBySection($resumeid, $sectionName, $section);
                        $sectionData = $sectionResult[0];
                        $fieldsordering = $sectionResult[1];
                        $sectionExistingRecords = $sectionResult[2];
                    }
                }
                if ($sectionName == 'address') {
                    $sectionMaxForms = $this->getJSModel('configurations')->getConfigValue('max_resume_' . $sectionName . 'es');
                } else {
                    $sectionMaxForms = $this->getJSModel('configurations')->getConfigValue('max_resume_' . $sectionName . 's');
                }
            }
            $resumelists = null;
            $maxPhotoSize = '';
            $allowedPhotoTypes = '';
            $captcha = null;
        }

        $data[0] = $sectionData;
        $data[1] = $currentFromData;
        $data[2] = $resumelists;
        $data[3] = $maxPhotoSize;
        $data[4] = $allowedPhotoTypes;
        $data[5] = $fieldsordering;
        $data[6] = $sectionMaxForms;
        $data[7] = $sectionExistingRecords;
        $data[8] = $packagedetail;
        $data[9] = $captcha;
        $data[10] = $config;
        
        return $data;
    }

    function getResumeSectionById($sectionid, $resumeid, $sectionName, $section) { // created and used by muhiaudin for resume form
        if (empty($resumeid) && !is_numeric($resumeid)) {
            return false;
        }
        if (empty($sectionid) && !is_numeric($sectionid)) {
            return false;
        }
        if (empty($sectionName)) {
            return false;
        }

        $db = $this->getDBO();
        $query = "";
        if ($sectionName == "personal") {
            $query = "SELECT resume.*, cat.cat_title AS categorytitle, subcat.title AS subcategorytitle 
                        ,salary.rangestart AS rangestart, salary.rangeend AS rangeend ,dsalary.rangestart AS drangestart, dsalary.rangeend AS drangeend 
                        ,jobtype.title AS jobtypetitle 
                        ,heighesteducation.title AS heighesteducationtitle 
                        ,nationality_country.name AS nationalitycountry 
                        ,currency.symbol AS symbol ,dcurrency.symbol AS dsymbol 
                        ,salarytype.title AS salarytype ,dsalarytype.title AS djobsalaryrangetype
                        FROM `#__js_job_resume` AS resume 
                        LEFT JOIN `#__js_job_categories` AS cat ON resume.job_category = cat.id 
                        LEFT JOIN `#__js_job_subcategories` AS subcat ON resume.job_subcategory = subcat.id 
                        LEFT JOIN `#__js_job_jobtypes` AS jobtype ON resume.jobtype = jobtype.id 
                        LEFT JOIN `#__js_job_heighesteducation` AS heighesteducation ON resume.heighestfinisheducation = heighesteducation.id 
                        LEFT JOIN `#__js_job_countries` AS nationality_country ON resume.nationality = nationality_country.id 
                        LEFT JOIN `#__js_job_salaryrange` AS salary ON resume.jobsalaryrange = salary.id 
                        LEFT JOIN `#__js_job_salaryrangetypes` AS salarytype ON resume.jobsalaryrangetype = salarytype.id 
                        LEFT JOIN `#__js_job_currencies` AS currency ON resume.currencyid = currency.id 
                        LEFT JOIN `#__js_job_salaryrange` AS dsalary ON resume.djobsalaryrange = dsalary.id 
                        LEFT JOIN `#__js_job_salaryrangetypes` AS dsalarytype ON resume.djobsalaryrangetype = dsalarytype.id 
                        LEFT JOIN `#__js_job_currencies` AS dcurrency ON resume.dcurrencyid = dcurrency.id 
                        WHERE resume.id = " . $resumeid;
        } elseif ($sectionName == 'language') {
            $query = "SELECT * FROM `#__js_job_resumelanguages` WHERE id = " . $sectionid . " AND resumeid = " . $resumeid;
        } else if ($sectionName == 'resume') { // to get resume editor and skills values from resume table
            $query = "SELECT * FROM `#__js_job_resume` WHERE id = " . $resumeid;
        } else if ($sectionName == 'address') {
            $query = "SELECT address.*, 
                        cities.id AS cityid, 
                        cities.cityName AS city, 
                        states.name AS state, 
                        countries.name AS country 
                        FROM `#__js_job_resumeaddresses` AS address 
                        LEFT JOIN `#__js_job_cities` AS cities ON address.address_city = cities.id 
                        LEFT JOIN `#__js_job_states` AS states ON cities.stateid = states.id 
                        LEFT JOIN `#__js_job_countries` AS countries ON cities.countryid = countries.id 
                        WHERE address.id = " . $sectionid . " AND address.resumeid = " . $resumeid;
        } else {
            $query = "SELECT " . $sectionName . ".*, 
                        cities.id AS cityid, 
                        cities.cityName AS city, 
                        states.name AS state, 
                        countries.name AS country 
                        FROM `#__js_job_resume" . $sectionName . "s` AS " . $sectionName . " 
                        LEFT JOIN `#__js_job_cities` AS cities ON " . $sectionName . "." . $sectionName . "_city = cities.id 
                        LEFT JOIN `#__js_job_states` AS states ON cities.stateid = states.id 
                        LEFT JOIN `#__js_job_countries` AS countries ON cities.countryid = countries.id 
                        WHERE " . $sectionName . ".id = " . $sectionid . " AND resumeid = " . $resumeid;
        }
        $db->setQuery($query);
        $result[0] = $db->loadObject();
        $result[1] = $this->getJSModel('customfields')->getResumeFieldsOrderingBySection($section); // fieldsordering for one section only
        return $result;
    }

    function getResumeBySection($resumeid, $sectionName, $section) { // created and used by muhiaudin for resume form
        $db = $this->getDBO();
        if (!is_numeric($resumeid) OR empty($resumeid)) {
            return false;
        }
        if (empty($sectionName)) {
            return false;
        }
        $query = "";
        if ($resumeid == -1) { // in case of new form
            $result[0] = null;
        } else {
            $total = 0;
            if ($sectionName == 'personal') {
                $query = "SELECT resume.*, licensecountry.name AS licensecountryname, exp.title AS experiencetitle, cat.cat_title AS categorytitle, subcat.title AS subcategorytitle 
                            ,salary.rangestart AS rangestart, salary.rangeend AS rangeend ,dsalary.rangestart AS drangestart, dsalary.rangeend AS drangeend 
                            ,jobtype.title AS jobtypetitle 
                            ,heighesteducation.title AS heighesteducationtitle 
                            ,nationality_country.name AS nationalitycountry 
                            ,currency.symbol AS symbol ,dcurrency.symbol AS dsymbol 
                            ,salarytype.title AS salarytype ,dsalarytype.title AS dsalarytype 
                            FROM `#__js_job_resume` AS resume 
                            LEFT JOIN `#__js_job_categories` AS cat ON resume.job_category = cat.id 
                            LEFT JOIN `#__js_job_subcategories` AS subcat ON resume.job_subcategory = subcat.id 
                            LEFT JOIN `#__js_job_jobtypes` AS jobtype ON resume.jobtype = jobtype.id 
                            LEFT JOIN `#__js_job_heighesteducation` AS heighesteducation ON resume.heighestfinisheducation = heighesteducation.id 
                            LEFT JOIN `#__js_job_countries` AS nationality_country ON resume.nationality = nationality_country.id 
                            LEFT JOIN `#__js_job_countries` AS licensecountry ON resume.license_country = licensecountry.id 
                            LEFT JOIN `#__js_job_salaryrange` AS salary ON resume.jobsalaryrange = salary.id 
                            LEFT JOIN `#__js_job_salaryrangetypes` AS salarytype ON resume.jobsalaryrangetype = salarytype.id 
                            LEFT JOIN `#__js_job_currencies` AS currency ON resume.currencyid = currency.id 
                            LEFT JOIN `#__js_job_salaryrange` AS dsalary ON resume.desired_salary = dsalary.id 
                            LEFT JOIN `#__js_job_salaryrangetypes` AS dsalarytype ON resume.djobsalaryrangetype = dsalarytype.id 
                            LEFT JOIN `#__js_job_currencies` AS dcurrency ON resume.dcurrencyid = dcurrency.id 
                            LEFT JOIN `#__js_job_experiences` AS exp ON resume.experienceid = exp.id 
                            WHERE resume.id = " . $resumeid;
                $db->setQuery($query);
                $resume = $db->loadObject();
            } elseif ($sectionName == 'skills' OR $sectionName == 'editor') {
                $query = "SELECT * FROM `#__js_job_resume` WHERE id = " . $resumeid;
                $db->setQuery($query);
                $resume = $db->loadObject();
            } elseif ($sectionName == 'language') {
                $query = "SELECT COUNT(id) FROM `#__js_job_resumelanguages` WHERE resumeid  = " . $resumeid;
                $db->setQuery($query);
                $total = $db->loadResult();
                $query = "SELECT * FROM `#__js_job_resumelanguages` WHERE resumeid = " . $resumeid;
                $db->setQuery($query);
                $resume = $db->loadObjectList();
            } elseif ($sectionName == 'address') {
                $query = "SELECT COUNT(id) FROM `#__js_job_resumeaddresses` WHERE resumeid  = " . $resumeid;
                $db->setQuery($query);
                $total = $db->loadResult();
                $query = "SELECT address.*, 
                            cities.id AS cityid, 
                            cities.cityName AS city, 
                            states.name AS state, 
                            countries.name AS country 
                            FROM `#__js_job_resumeaddresses` AS address 
                            LEFT JOIN `#__js_job_cities` AS cities ON address.address_city = cities.id 
                            LEFT JOIN `#__js_job_states` AS states ON cities.stateid = states.id 
                            LEFT JOIN `#__js_job_countries` AS countries ON cities.countryid = countries.id 
                            WHERE address.resumeid = " . $resumeid;
                $db->setQuery($query);
                $resume = $db->loadObjectList();
            } else {
                $query = "SELECT COUNT(id) FROM `#__js_job_resume" . $sectionName . "s` WHERE resumeid  = " . $resumeid;
                $db->setQuery($query);
                $total = $db->loadResult();
                $query = "SELECT " . $sectionName . ".*, 
                            cities.id AS cityid, 
                            cities.cityName AS city, 
                            states.name AS state, 
                            countries.name AS country 
                            FROM `#__js_job_resume" . $sectionName . "s` AS " . $sectionName . " 
                            LEFT JOIN `#__js_job_cities` AS cities ON " . $sectionName . "." . $sectionName . "_city = cities.id 
                            LEFT JOIN `#__js_job_states` AS states ON cities.stateid = states.id 
                            LEFT JOIN `#__js_job_countries` AS countries ON cities.countryid = countries.id 
                            WHERE " . $sectionName . ".resumeid = " . $resumeid;
                $db->setQuery($query);
                $resume = $db->loadObjectList();
            }
            $db->setQuery($query);
            $result[0] = $resume;
            $result[2] = $total;
        }
        $result[1] = $this->getJSModel('customfields')->getResumeFieldsOrderingBySection($section); // 1 for personal section
        return $result;
    }

    function getPackageDetailByUid($uid) {
        if (!is_numeric($uid))
            return false;
        $pacakges[0] = 0;
        $pacakges[1] = 0;
        $db = $this->getDbo();
        $query = "SELECT package.id, payment.id AS paymentid
                   FROM `#__js_job_jobseekerpackages` AS package
                   JOIN `#__js_job_paymenthistory` AS payment ON ( payment.packageid = package.id AND payment.packagefor=2)
                   WHERE payment.uid = " . $uid . " 
                   AND payment.transactionverified = 1 AND payment.status = 1 ORDER BY payment.created DESC";
        $db->setQuery($query);
        $packagedetail = $db->loadObjectList();
        if (!empty($packagedetail)) { // user have pacakge
            foreach ($packagedetail AS $package) {
                $pacakges[0] = $package->id;
                $pacakges[1] = $package->paymentid;
            }
            return $pacakges;
        } else { // user have no package
            return $pacakges;
        }
    }

    function canAddNewResume($uid) {
        if (!is_numeric($uid))
            return false;
        $db = $this->getDbo();
        $query = "SELECT package.id, package.resumeallow, package.packageexpireindays, payment.id AS paymentid, payment.created
                    FROM `#__js_job_jobseekerpackages` AS package
                    JOIN `#__js_job_paymenthistory` AS payment ON (payment.packageid = package.id AND payment.packagefor=2)
                    WHERE payment.uid = " . $uid . "
                    AND DATE_ADD(payment.created,INTERVAL package.packageexpireindays DAY) >= CURDATE()
                    AND payment.transactionverified = 1 AND payment.status = 1";
        $db->setQuery($query);
        $valid_packages = $db->loadObjectList();
        if (empty($valid_packages)) { // User have no valid package
            // check if user have any package or not
            $query = "SELECT package.id, package.resumeallow,package.title AS packagetitle, package.packageexpireindays, payment.id AS paymentid
                        , (TO_DAYS( CURDATE() ) - To_days( payment.created ) ) AS packageexpiredays
                       FROM `#__js_job_jobseekerpackages` AS package
                       JOIN `#__js_job_paymenthistory` AS payment ON ( payment.packageid = package.id AND payment.packagefor=2)
                       WHERE payment.uid = " . $uid . " 
                       AND payment.transactionverified = 1 AND payment.status = 1 ORDER BY payment.created DESC";
            $db->setQuery($query);
            $packagedetail = $db->loadObjectList();
            if (empty($packagedetail)) { // User have no package
                return NO_PACKAGE;
            } else { // User have packages but are expired
                return EXPIRED_PACKAGE;
            }
        } else { // user have valid package
            // check is it allow to add new resume
            $unlimited = 0;
            $resumeallow = 0;
            foreach ($valid_packages AS $resume) {
                if ($unlimited == 0) {
                    if ($resume->resumeallow != -1) {
                        $resumeallow = $resume->resumeallow + $resumeallow;
                    } else {
                        $unlimited = 1;
                    }
                }
            }
            if ($unlimited == 0) { // user doesn't have unlimited resume package
                if ($resumeallow == 0) {
                    return RESUME_LIMIT_EXCEEDS;
                }
                //get total resume count
                $query = "SELECT COUNT(resume.id) AS totalresumes FROM `#__js_job_resume` AS resume WHERE resume.uid = " . $uid;
                $db->setQuery($query);
                $totalresume = $db->loadResult();
                if ($resumeallow <= $totalresume) {
                    return RESUME_LIMIT_EXCEEDS;
                } else {
                    return VALIDATE;
                }
            } else { // user have unlimited resume package
                return VALIDATE;
            }
        }
    }

    function getMyResumes($u_id) {

        $db = $this->getDBO();
        if ($u_id)
            if ((is_numeric($u_id) == false) || ($u_id == 0) || ($u_id == ''))
                return false;

        $totalresume = 0;

        $query = "SELECT id, application_title, created, status 
        FROM `#__js_job_resume` WHERE status = 1 AND uid = " . $u_id;
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }
        $resumes = array();
        foreach ($rows as $row) {
            $resumes[] = array('value' => $row->id, 'text' => $row->application_title);
            $totalresume++;
        }
        $myresymes = JHTML::_('select.genericList', $resumes, 'cvid', 'class="inputbox required" ' . '', 'value', 'text', '');
        $mycoverletters = $this->getJSModel('coverletter')->getMyCoverLetters($u_id);
        $result[0] = $myresymes;
        $result[1] = $totalresume;
        $result[2] = $mycoverletters[0];
        $result[3] = $mycoverletters[1];
        return $result;
    }


    function getResumeViewbyId($uid, $jobid, $id, $myresume, $sort = false, $tabaction = false) {
        if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == '')) return false;
        if ($jobid) if (is_numeric($jobid) == false) return false;
        if($id)
            if(!is_numeric($id)) return false;
        
        if (JFactory::getApplication()->isAdmin()) {
            $isadmin = 1;
        } else {
            $isadmin = 0;
        }

        $db = $this->getDBO();
        if ($myresume == 2 || $myresume == 7 || $myresume == 6){
            $resume_issharing_data = 1;
        } else{
            $resume_issharing_data = 0;
        }

        if ($myresume == 7) { //folderresumeview
            $jobid = 0;
        }
        if ($resume_issharing_data == 1) {
            if ($this->_client_auth_key != "") {
                if ($jobid) {
                    $jobid = $this->getSharingAdminModel('resume')->getLocalJobid($jobid); // get the local job id if not local send back the orignal id
                }
                //$id = $this->getSharingAdminModel('resume')->getLocalResumeid($id); // We don't need the id swap we just know call is local or sharing
            }
        }

        if ($myresume == 1) {
            if(!is_numeric($id)) return false;
            $query = "SELECT COUNT(id) FROM `#__js_job_resume` WHERE uid = " . $uid . " AND id = " . $id;
            $db->setQuery($query);
            $total = $db->loadResult();
            if ($total == 0)
                $canview = 0;
            else
                $canview = 1;
        }else {
            if (!isset($this->_config)) {
                if ($isadmin == 0) {
                    $this->_config = $this->getJSModel('configurations')->getConfig('');
                } else {
                    if (!JFactory::getApplication()->isSite()) {
                        $this->_config = $this->getJSModel('configuration')->getConfig('');
                    } else {
                        $this->_config = $this->getJSModel('configurations')->getConfig('');
                    }
                }
            }
             // we comment b/c we don't need when applied resume
            foreach ($this->_config as $conf) {
                if ($conf->configname == 'newlisting_requiredpackage')
                    $newlisting_required_package = $conf->configvalue;
            }

            if ($newlisting_required_package == 0) {
                $unlimited = 1;
            } else {
                
                $query = "SELECT package.viewresumeindetails, package.packageexpireindays, package.resumesearch, payment.created
                            FROM `#__js_job_employerpackages` AS package
                            JOIN `#__js_job_paymenthistory` AS payment ON (payment.packageid = package.id AND payment.packagefor=1)
                            WHERE payment.uid = " . $uid . "
                            AND DATE_ADD(payment.created,INTERVAL package.packageexpireindays DAY) >= CURDATE()
                            AND payment.status = 1";
                $db->setQuery($query);
                $jobs = $db->loadObjectList();
                $unlimited = 0;
                $canview = 0;
                $resumesearch = 0;
                $viewresumeindetails = 0;
                foreach ($jobs AS $job) {
                    if ($unlimited == 0) {
                        if ($job->viewresumeindetails != -1) {
                            $viewresumeindetails = $viewresumeindetails + $job->viewresumeindetails;
                            $resumesearch = $resumesearch + $job->resumesearch;
                        } else
                            $unlimited = 1;
                    }
                }
            }                
            if ($unlimited == 0) {
                if ($viewresumeindetails == 0)
                    $canview = 0; //can not add new job
                if ($jobid != '') {
                    $query = "SELECT SUM(apply.resumeview) AS totalview FROM `#__js_job_jobapply` AS apply WHERE apply.jobid = " . $jobid;
                    $db->setQuery($query);
                    $totalview = $db->loadResult();
                    if ($viewresumeindetails > $totalview)
                        $canview = 1; //can not add new job
                    else
                        $canview = 0;
                    if ($myresume == 3)
                        $canview = 1; // search resume
                }else {
                    if ($resumesearch > 0)
                        $canview = 1;
                    else
                        $canview = 0;
                }
            }elseif ($unlimited == 1)
                $canview = 1; // unlimited
        }
        if ($canview == 0) { // check already view this resume
            if ($jobid != '') {
                if(!is_numeric($id)) return false;
                $query = "SELECT resumeview FROM `#__js_job_jobapply` AS apply WHERE apply.jobid = " . $jobid . " AND cvid = " . $id;
                $db->setQuery($query);
                $apply = $db->loadObject();
                if ($apply->resumeview == 1)
                    $canview = 1; //already view this resume
                else
                    $canview = 0;
            } else
                $canview = 0;
        }
        if ($canview == 1 || $isadmin == 1) {
            if (is_numeric($id) == false)
                return false;
            if ($this->_client_auth_key != "" && $resume_issharing_data == 1) {
                $result = $this->getSharingAdminModel('resume')->getResumeViewbyId($jobid,$id,$uid);
            } else {
                $query = "SELECT resume.id, resume.params, resume.experienceid, exp.title AS experiencetitle, resume.license_no, licensecountry.name AS licensecountryname, resume.driving_license, resume.uid, resume.created, resume.last_modified, resume.published, resume.hits 
                            , resume.application_title, resume.keywords, resume.alias, resume.first_name, resume.last_name 
                            , resume.middle_name, resume.gender, resume.email_address, resume.home_phone, resume.work_phone 
                            , resume.cell, resume.nationality, resume.iamavailable, resume.searchable, resume.photo 
                            , resume.job_category, resume.jobsalaryrange, resume.jobsalaryrangetype, resume.jobtype 
                            , resume.heighestfinisheducation, resume.status, resume.resume, resume.date_start, resume.desired_salary 
                            , resume.djobsalaryrangetype, resume.dcurrencyid, resume.can_work, resume.available, resume.unavailable 
                            , resume.total_experience, resume.skills, resume.driving_license, resume.license_no, resume.license_country 
                            , resume.packageid, resume.paymenthistoryid, resume.currencyid, resume.job_subcategory 
                            , resume.date_of_birth, resume.video, resume.isgoldresume, resume.isfeaturedresume, resume.serverstatus 
                            , resume.serverid, heighesteducation.title AS heighesteducationtitle
                            , nationality_country.name AS nationalitycountry 
                            , currency.symbol,dcurrency.symbol AS dsymbol, cat.cat_title AS categorytitle, subcat.title AS subcategorytitle, salary.rangestart 
                            , salary.rangeend, dsalary.rangeend AS drangeend, dsalary.rangestart AS drangestart, jobtype.title AS jobtypetitle
                            , CONCAT(resume.alias,'-',resume.id) AS resumealiasid 
                            , salarytype.title AS salarytype, dsalarytype.title AS dsalarytype
                            
                            FROM `#__js_job_resume` AS resume
                            LEFT JOIN `#__js_job_categories` AS cat ON resume.job_category = cat.id
                            LEFT JOIN `#__js_job_subcategories` AS subcat ON resume.job_subcategory = subcat.id
                            LEFT JOIN `#__js_job_jobtypes` AS jobtype ON resume.jobtype = jobtype.id
                            LEFT JOIN `#__js_job_heighesteducation` AS heighesteducation ON resume.heighestfinisheducation = heighesteducation.id
                            LEFT JOIN `#__js_job_countries` AS nationality_country ON resume.nationality = nationality_country.id
                            LEFT JOIN `#__js_job_salaryrange` AS salary ON resume.jobsalaryrange = salary.id
                            LEFT JOIN  `#__js_job_salaryrangetypes` AS salarytype ON resume.jobsalaryrangetype = salarytype.id
                            LEFT JOIN `#__js_job_countries` AS licensecountry ON resume.license_country = licensecountry.id
                            LEFT JOIN `#__js_job_countries` AS countries ON resume.nationality = nationality_country.id
                            LEFT JOIN `#__js_job_salaryrange` AS dsalary ON resume.desired_salary = dsalary.id
                            LEFT JOIN  `#__js_job_salaryrangetypes` AS dsalarytype ON resume.djobsalaryrangetype = dsalarytype.id
                            LEFT JOIN `#__js_job_currencies` AS dcurrency ON dcurrency.id = resume.dcurrencyid
                            LEFT JOIN `#__js_job_currencies` AS currency ON currency.id = resume.currencyid
                            LEFT JOIN `#__js_job_experiences` AS exp ON exp.id = resume.experienceid

                            WHERE resume.id = " . $id;

                $db->query();

                $db->setQuery($query);
                $resume = $db->loadObject();
                $result['personal'] = $resume;

                $query = "SELECT address.id,address.params, address.resumeid, address.address 
                            , address.address_city AS address_cityid, address.address_zipcode 
                            , address.longitude, address.latitude, address.created 
                            , countries.name AS address_countryname, cities.name AS address_cityname 
                            , states.name AS address_statename 
                            
                            FROM `#__js_job_resumeaddresses` AS address
                            LEFT JOIN `#__js_job_cities` AS cities ON cities.id = address.address_city
                            LEFT JOIN `#__js_job_states` AS states ON states.id = cities.stateid
                            LEFT JOIN `#__js_job_countries` AS countries ON countries.id = cities.countryid

                            WHERE address.resumeid = " . $id;

                $db->query();

                $db->setQuery($query);
                $resume = $db->loadObjectList();
                $result['addresses'] = $resume;

                $query = "SELECT institute.id, institute.params, institute.resumeid, institute.institute 
                            , institute.institute_address, institute.institute_city AS institute_cityid 
                            , institute.institute_certificate_name, institute.institute_study_area, institute.created 
                            , countries.name AS institute_countryname, cities.name AS institute_cityname 
                            , states.name AS institute_statename 
                            
                            FROM `#__js_job_resumeinstitutes` AS institute
                            LEFT JOIN `#__js_job_cities` AS cities ON institute.institute_city = cities.id
                            LEFT JOIN `#__js_job_states` AS states ON cities.stateid = states.id
                            LEFT JOIN `#__js_job_countries` AS countries ON cities.countryid = countries.id

                            WHERE institute.resumeid = " . $id;

                $db->query();

                $db->setQuery($query);
                $resume = $db->loadObjectList();
                $result['institutes'] = $resume;

                $query = "SELECT employer.id, employer.params, employer.resumeid, employer.employer, employer.employer_address 
                            , employer.employer_city AS employer_cityid, employer.employer_position 
                            , employer.employer_resp, employer.employer_pay_upon_leaving, employer.employer_supervisor 
                            , states.name AS employer_statename, employer.created, employer.last_modified 
                            , countries.name AS employer_countryname, cities.name AS employer_cityname 
                            , employer.employer_from_date, employer.employer_to_date 
                            , employer.employer_leave_reason, employer.employer_zip 
                            , employer.employer_phone
                            
                            FROM `#__js_job_resumeemployers` AS employer
                            LEFT JOIN `#__js_job_cities` AS cities ON employer.employer_city = cities.id
                            LEFT JOIN `#__js_job_states` AS states ON cities.stateid = states.id
                            LEFT JOIN `#__js_job_countries` AS countries ON cities.countryid = countries.id

                            WHERE employer.resumeid = " . $id;

                $db->query();

                $db->setQuery($query);
                $resume = $db->loadObjectList();
                $result['employers'] = $resume;

                $query = "SELECT reference.id, reference.params, reference.resumeid, reference.reference 
                            , reference.reference_name, reference.reference_zipcode 
                            , reference.reference_city AS reference_cityid, reference.reference_address 
                            , reference.reference_phone, reference.reference_relation 
                            , reference.reference_years, reference.created, reference.last_modified 
                            , countries.name AS reference_countryname, cities.name AS reference_cityname 
                            , states.name AS reference_statename 
                            
                            FROM `#__js_job_resumereferences` AS reference
                            LEFT JOIN `#__js_job_cities` AS cities ON reference.reference_city = cities.id
                            LEFT JOIN `#__js_job_states` AS states ON cities.stateid = states.id
                            LEFT JOIN `#__js_job_countries` AS countries ON cities.countryid = countries.id

                            WHERE reference.resumeid = " . $id;

                $db->query();

                $db->setQuery($query);
                $resume = $db->loadObjectList();
                $result['references'] = $resume;

                $query = "SELECT language.id, language.params, language.resumeid, language.language 
                            , language.language_reading, language.language_writing 
                            , language.language_understanding, language.language_where_learned 
                            , language.created, language.last_modified 
                            FROM `#__js_job_resumelanguages` AS language WHERE language.resumeid = " . $id;

                $db->query();

                $db->setQuery($query);
                $resume = $db->loadObjectList();
                $result['languages'] = $resume;

                if ($jobid != '') {
                    $query = "UPDATE `#__js_job_jobapply` SET resumeview = 1 WHERE jobid = " . $jobid . " AND cvid = " . $id;
                    $db->setQuery($query);
                    $db->query();
                }

                $query = "UPDATE `#__js_job_resume` SET hits = hits + 1 WHERE id = " . $id;
                $db->setQuery($query);
                if (!$db->query()) {
                    //return false;
                }
                $result['canview'] = 1; // can view
                $fieldfor = 3;

                // get the next resume ids for view the next resume when employer come to view the resume
                $cvids = false;
                if ($sort != false && $tabaction != false) {
                    $query = "SELECT apply.cvid 
                                FROM `#__js_job_jobapply` AS apply 
                                JOIN `#__js_job_jobs` AS job ON job.id = apply.jobid
                                JOIN `#__js_job_resume` AS app ON app.id = apply.cvid
                                JOIN `#__js_job_categories` AS cat ON app.job_category = cat.id
                                LEFT JOIN `#__js_job_salaryrange` AS salary ON app.jobsalaryrange = salary.id
                                WHERE apply.jobid = " . $jobid . " AND apply.action_status = " . $tabaction . " ORDER BY " . $sort;
                    $db->setQuery($query);
                    $cvids = $db->loadObjectList();
                }
                $result['cvids'] = $cvids; // for emplyer resume navigations

                $result['userfields'] = '';
            }
        } else {
            $result['canview'] = 0; // can not view
        }
        if (JFactory::getApplication()->isSite() OR $isadmin == 0) {
            $result['fieldsordering'] = $this->getJSModel('customfields')->getFieldsOrderingForResumeView(3); // resume fields
        } else {
            $result['fieldsordering'] = $this->getJSModel('fieldordering')->getFieldsOrderingForResumeView(3); // resume fields
        }
        return $result;
    }

    function deleteResume($resumeid, $uid) {
        $db = $this->getDBO();
        $row = $this->getTable('resume');
        $data = JRequest::get('post');
        if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == '')) return false;
        if (is_numeric($resumeid) == false) return false;
        $returnvalue = $this->resumeCanDelete($resumeid, $uid);
        if ($returnvalue == 1) {

            $query = "SELECT app.application_title, app.first_name, app.middle_name, app.last_name, app.email_address,CONCAT(app.alias,'-',app.id) AS aliasid 
                        FROM `#__js_job_resume` AS app
                        WHERE app.id = " . $resumeid;

            $db->setQuery($query);
            $app = $db->loadObject();

            $name = $app->first_name;
            if ($app->middle_name)
                $name .= " " . $app->middle_name;
            if ($app->last_name)
                $name .= " " . $app->last_name;
            $Email = $app->email_address;
            $resumeTitle = $app->application_title;

            $session = JFactory::getSession();
            $session->set('name',$name);
            $session->set('email_address',$Email);
            $session->set('application_title',$resumeTitle);


            if (!$row->delete($resumeid)) {
                $this->setError($row->getErrorMsg());
                return false;
            }
            $this->getJSModel('emailtemplate')->sendDeleteMail( $resumeid , 3);
            if ($this->_client_auth_key != "") {
                $this->getSharingAdminModel('resume')->deleteResume($resumeid);
            }
        } else
            return $returnvalue;

        return true;
    }

    function resumeCanDelete($resumeid, $uid) {
        if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
            return false;
        if(!is_numeric($resumeid)) return false;
        $db = $this->getDBO();
        $query = "SELECT COUNT(resume.id) FROM `#__js_job_resume` AS resume WHERE resume.id = " . $resumeid . " AND resume.uid = " . $uid;
        $db->setQuery($query);
        $resumetotal = $db->loadResult();
        if ($resumetotal > 0) { // this resume is same user
            $query = "SELECT 
                        ( SELECT COUNT(id) FROM `#__js_job_jobapply` WHERE cvid = " . $resumeid . ") 
                        AS total ";
            $db->setQuery($query);
            $total = $db->loadResult();
            if ($total > 0)
                return 2;
            else
                return 1;
        } else
            return 3; //    this resume is not of this user     
    }

    function storeResume($jobid = null) { // Saves ajax form and return row id if true
        $db = $this->getDBO();
        $resumedata = JRequest::get('post');
        $postLength = $this->getJSModel("common")->checkPostMaxSize();
        if ($postLength == 0) {
            return false;
        }
        $row = $this->getTable('resume');
        $resumedata['published'] = 1;
        $resumedata['hits'] = 0;

        if (!isset($this->_config))
            $this->_config = $this->getJSModel('configurations')->getConfig('');               
        
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'empautoapprove')
                if (!$resumedata['id'])
                    $resumedata['status'] = $conf->configvalue;
            if ($conf->configname == 'resume_photofilesize')
                $photofilesize = $conf->configvalue;
            if ($conf->configname == 'date_format')
                $dateformat = $conf->configvalue;
            if ($conf->configname == 'date_format')
                $dateformat = $conf->configvalue;
            if ($conf->configname == 'data_directory')
                $datadirectory = $conf->configvalue;
            if ($conf->configname == 'document_file_type')
                $document_file_types = $conf->configvalue;
            if ($conf->configname == 'document_max_files')
                $maxFiles = $conf->configvalue;
        }

        //spam checking
        if ($resumedata['datafor'] == 'personal') {
            $config = $this->getJSModel('configurations')->getConfigByFor('default');
            if ($resumedata['uid'] == 0 && $config['resume_captcha'] == 1 && $resumedata['isadmin'] == 0) {
                /*if ($config['captchause'] == 0) {
                    JPluginHelper::importPlugin('captcha');
                    if (JVERSION < 3)
                        $dispatcher = JDispatcher::getInstance();
                    else
                        $dispatcher = JEventDispatcher::getInstance();
                    $res = $dispatcher->trigger('onCheckAnswer', $data['recaptcha_response_field']);
                    if (!$res[0]) {
                        $captcha = $this->getJSModel('common')->getCaptchaForForm();
                        return $captcha;
                    }
                } else {*/
                    if (!$this->getJSModel('common')->performChecks()) {
                        $captcha = $this->getJSModel('common')->getCaptchaForForm();
                        return $captcha;
                    }
                //}
            }
        }

        // resume date format validation
        if (isset($resumedata['date_start']) || isset($resumedata['date_of_birth'])) {
            /*
            if ($dateformat == 'm/d/Y') {
                if ($resumedata['date_start'] != '') {
                    $arr = explode('/', $resumedata['date_start']);
                    $data['date_start'] = $arr[2] . '/' . $arr[0] . '/' . $arr[1];
                }
                if ($resumedata['date_of_birth'] != '') {
                    $arr = explode('/', $resumedata['date_of_birth']);
                    $resumedata['date_of_birth'] = $arr[2] . '/' . $arr[0] . '/' . $arr[1];
                }
            } elseif ($dateformat == 'd-m-Y') {
                if ($resumedata['date_start'] != '') {
                    $arr = explode('-', $resumedata['date_start']);
                    $resumedata['date_start'] = $arr[2] . '-' . $arr[1] . '-' . $arr[0];
                }
                if ($resumedata['date_of_birth'] != '') {
                    $arr = explode('-', $resumedata['date_of_birth']);
                    $resumedata['date_of_birth'] = $arr[2] . '-' . $arr[1] . '-' . $arr[0];
                }
            }
            */
            // resume date you can start validation
            if ($resumedata['date_start'] != '') {
                $resumedata['date_start'] = date('Y-m-d H:i:s', strtotime($resumedata['date_start']));
            }
            // resume date of birth validation
            if ($resumedata['date_of_birth'] != '') {
                $resumedata['date_of_birth'] = date('Y-m-d H:i:s', strtotime($resumedata['date_of_birth']));
            }
        }

        // resume alias
        if (!empty($resumedata['alias'])) {
            $resumealias = $this->getJSModel('common')->removeSpecialCharacter($resumedata['alias']);
        } else {
            if (isset($resumedata['application_title'])) {
                $resumealias = $this->getJSModel('common')->removeSpecialCharacter($resumedata['application_title']);
                $resumealias = strtolower(str_replace(' ', '-', $resumealias));
                $resumedata['alias'] = $resumealias;
            }
        }
        if ($resumedata['datafor'] == 'personal') {
            if (!isset($resumedata['searchable'])) {
                $search_able = 0;
                $db = JFactory::getDbo();
                $query = " SELECT published,isvisitorpublished FROM `#__js_job_fieldsordering` WHERE field = 'searchable' AND fieldfor = 3";
                $db->setQuery($query);
                $searchable = $db->loadObject();
                $user = JFactory::getUser();
                if($user->guest){
                    if($searchable->isvisitorpublished == 0)
                        $search_able = 1;
                }else{
                    if($searchable->published == 0)
                        $search_able = 1;
                }
                $resumedata['searchable'] = $search_able;
            }
            if (!isset($resumedata['iamavailable'])) {
                $resumedata['iamavailable'] = 0;
            }
        }

        $returnData = array();
        $returnData[0] = 0;

        $resumedata = filter_var_array($resumedata, FILTER_SANITIZE_STRING);  // Sanitize entire array to string
        // resume editor
        $isresuemeditor = false;
        if (isset($resumedata['resume'])) {
            $resumedata['resume'] = JRequest::getVar('resume', '', 'post', 'string', JREQUEST_ALLOWHTML);
            $isresuemeditor = true;
        }

        // custom field code start
        if(is_numeric($resumedata['id'])){
            $query = "SELECT params FROM `#__js_job_resume` WHERE id = ".$resumedata['id'];
            $db->setQuery($query);
            $params_befor = $db->loadResult();

            if ($resumedata['datafor'] == 'personal') {
                $section = 1;
            }elseif($resumedata['datafor'] == 'skills'){
                $section = 5;
            }elseif($resumedata['datafor'] == 'resume'){
                $section = 6;
            }
        }else{
            $section = 1;
        }

        $return_cf = $this->getDataForParams($section , $resumedata);
        $params_new = $return_cf['params'];
        $filefordelete = '';
        if($resumedata['id'] != ''){
            if(is_numeric($resumedata['id'])){
                $params_new = json_decode($params_new, true);
                $db = JFactory::getdbo();
                $query = "SELECT params FROM `#__js_job_resume` WHERE id = ".$resumedata['id'];
                $db->setQuery($query);
                $oParams = $db->loadResult();                
                if(!empty($oParams)){
                    $oParams = json_decode($oParams,true);
                    $unpublihsedFields = $this->getJSModel('customfields')->getUnpublishedFieldsFor(3,1);
                    foreach($unpublihsedFields AS $field){
                        if(isset($oParams[$field->field]) && !empty($oParams[$field->field])){
                            $params_new[$field->field] = $oParams[$field->field];
                        }
                    }
                    $sectionfields = $this->getJSModel('customfields')->getUserfieldsfor(3,$section);
                    foreach($sectionfields AS $cfield){
                        if(isset($oParams[$cfield->field]))
                            unset($oParams[$cfield->field]);
                    }
                    // save -*-adnan-*- life
                    foreach($oParams AS $key => $value){
                        $params_new[$key] = $value;
                    }
                }
                if($params_new){
                    $params_new = json_encode($params_new);
                }
            }
        }
        $resumedata['params'] = $params_new;
        //Patch for resume only
        if($resumedata['params'] == null || $resumedata['params'] == 'null'){
            $resumedata['params'] = '';
        }
        if (!$row->bind($resumedata)) {
            $this->setError($this->_db->getErrorMsg());
            $returnData[0] = 2;
        }

        if (!$row->check()) {
            $this->setError($this->_db->getErrorMsg());
            $returnData[0] = 2;
        }

        if (!$row->store()) {
            $this->setError($this->_db->getErrorMsg());
            $returnData[0] = 2;
        }

        // resume photo
        $file_size_increase = 0;
        if (isset($_FILES['photo']) && !empty($_FILES['photo']['name'])) {
            if ($_FILES['photo']['size'] > 0) {
                $uploadfilesize = $_FILES['photo']['size'];
                $uploadfilesize = $uploadfilesize / 1024; //kb
                if ($uploadfilesize > $photofilesize) { // logo
                    $file_size_increase = 1;  //return 7 file size error    
                }
            }
            if ($file_size_increase != 1) {
                $returnvalue = $this->uploadPhoto((int) $row->id);
                if ($returnvalue == 0) {
                    $returnData[0] = 3;
                } else {
                    $returnData[0] = 1;
                }
            }
        }

        if ($resumedata['id'] == '') {
            // vis and user
            $this->getJSModel('emailtemplate')->sendMailNewResume($row->id, $resumedata['uid']);
            //onlye admin
            $this->getJSModel('adminemail')->sendMailtoAdmin($row->id, $resumedata['uid'], 3);
        }
        //Job sharing option
        if ($this->_client_auth_key != "") {
            $this->getSharingAdminModel('resume')->storeResume($row->id,$jobid,$resumedata);
        }

        //removing custom field 
        if($return_cf['customflagfordelete'] == true){
            foreach ($return_cf['custom_field_namesforadd'] as $key) {
                $params = json_decode($resumedata['params'],true);
                unset($params[$key]);
                $res = $this->getJSModel('common')->uploadOrDeleteFileCustom($row->id,$key ,1,3);
                $resumedata['params'] = json_encode($params);
            }
        }
        //storing custom field attachments
        if($return_cf['customflagforadd'] == true){
            foreach ($return_cf['custom_field_namesforadd'] as $key) {
                if ( isset($_FILES[$key]) AND $_FILES[$key]['size'] > 0) { // logo
                    $res = $this->getJSModel('common')->uploadOrDeleteFileCustom($row->id,$key ,0,3);
                }
            }
        }
        // End attachments

        // Current resume id save in session b/c of page refresh problem occurred
        $session = JFactory::getSession();
        $session->set('jsjobs_resumeid_for_form',$row->id);
        /* shift to proper location only send email when visitor press the apply button 
        if ($jobid)
            $this->getJSModel('jobapply')->visitorJobApply($jobid, $row->id);
        */
        //resume files
        $filereturnvalue = $this->uploadResumeFiles($row->id);
        $returnData[0] = $filereturnvalue;
        $returnData[1] = $row->id;
        return $returnData;
    }

    function storeResumeSection() { // Saves ajax form and return row id if true
        global $addressdata;
        $formdata = JRequest::get('post');
        $formdata = filter_var_array($formdata, FILTER_SANITIZE_STRING);  // Sanitize entire array to string
        $datafor = $formdata['datafor'];

        if ($datafor == "address") {
            $tableName = 'resume' . $datafor . 'es';
        } else {
            $tableName = 'resume' . $datafor . 's';
        }

        switch ($datafor) {
            case 'personal': $section = 1;
                $table = 'resume';
                break;
            case 'address': $section = 2;
                $table = 'resumeaddresses';
                break;
            case 'institute': $section = 3;
                $table = 'resumeinstitutes';
                break;
            case 'employer': $section = 4;
                $table = 'resumeemployers';
                break;
            case 'skills': $section = 5;
                $table = 'resume';
                break;
            case 'editor': $section = 6;
                $table = 'resume';
                break;
            case 'reference': $section = 7;
                $table = 'resumereferences';
                break;
            case 'language': $section = 8;
                $table = 'resumelanguages';
                break;
        }
        $row = $this->getTable($tableName);

// custom field code start

        $return_cf = $this->getDataForParams($section , $formdata);
        $params = '';
        $par = json_decode($return_cf['params'],true);
        if(is_array($par)){
            foreach($par AS $key => $value){
                $params[$key] = $value;
            }
        }

        if($formdata['id'] != ''){
            if(is_numeric($formdata['id'])){
                $db = JFactory::getdbo();
                $query = "SELECT params FROM `#__js_job_".$table."` WHERE id = ".$formdata['id'];
                $db->setQuery($query);
                $oParams = $db->loadResult();                
                if(!empty($oParams)){
                    $oParams = json_decode($oParams,true);
                    $unpublihsedFields = $this->getJSModel('customfields')->getUnpublishedFieldsFor(3,1);
                    foreach($unpublihsedFields AS $field){
                        if(isset($oParams[$field->field])){
                            $params[$field->field] = $oParams[$field->field];
                        }
                    }
                }
            }
        }
        if($params){
            $formdata['params'] = json_encode($params);
        }else{
            $formdata['params'] = '';
        }
        //Patch for resume only
        if($formdata['params'] == null || $formdata['params'] == 'null'){
            $formdata['params'] = '';
        }
// custom field code end

        if (!$row->bind($formdata)) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        if (!$row->check()) {
            $this->setError($this->_db->getErrorMsg());
            return 2;
        }

        if (!$row->store()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        // new
        //removing custom field 
        if($return_cf['customflagfordelete'] == true){
            foreach ($return_cf['custom_field_namesforadd'] as $key) {
                $params = json_decode($formdata['params'],true);
                unset($params[$key]);
                $res = $this->getJSModel('common')->uploadOrDeleteFileCustom($row->id,$key ,1,3 , $datafor);
                $formdata['params'] = json_encode($params);
            }
        }
        //storing custom field attachments
        if($return_cf['customflagforadd'] == true){
            foreach ($return_cf['custom_field_namesforadd'] as $key) {
                if ( isset($_FILES[$key]) AND $_FILES[$key]['size'] > 0) { // logo
                    $res = $this->getJSModel('common')->uploadOrDeleteFileCustom($row->id,$key ,0,3 , $datafor);
                }
            }
        }
        // End attachments


        //Job sharing option
        if ($this->_client_auth_key != "") {
            $this->getSharingAdminModel('resume')->storeResumeSection($tableName,$row->id);
        }

        return $row->resumeid;
    }

    function uploadResumeFiles($resumeid) { // created by muhiaudin for new resume form files upload
        if (is_numeric($resumeid) == false)
            return false;
        $db = JFactory::getDBO();

        $iddir = 'resume_' . $resumeid;
        if (!isset($this->_config))
            $this->_config = $this->getJSModel('configurations')->getConfig('');

        foreach ($this->_config as $conf) {
            if ($conf->configname == 'data_directory')
                $datadirectory = $conf->configvalue;
            if ($conf->configname == 'document_file_type')
                $document_file_types = $conf->configvalue;
            if ($conf->configname == 'document_max_files')
                $maxFiles = $conf->configvalue;
            if ($conf->configname == 'document_file_size')
                $maxFileSize = $conf->configvalue;
        }

        // main files loop
        if (!isset($_FILES['resumefiles'])) {
            return 1; // means no files were selected to upload
        }
        for ($i = 0; $i < count($_FILES['resumefiles']['name']); $i++) {
            // to check total uploaded files
            $query = "SELECT COUNT(id) FROM `#__js_job_resumefiles` WHERE resumeid = " . $resumeid;
            $db->setQuery($query);
            $totalUploaded = $db->loadResult();
            if ($maxFiles <= $totalUploaded) {
                return 7;
            }
            if ($_FILES['resumefiles']['size'][$i] > 0) {
                $file_name = $_FILES['resumefiles']['name'][$i];
                $file_tmp = $_FILES['resumefiles']['tmp_name'][$i];
                $file_size = $_FILES['resumefiles']['size'][$i];
                $file_type = $_FILES['resumefiles']['type'][$i];
                $file_error = $_FILES['resumefiles']['error'][$i];

                if (!empty($file_tmp)) { // only MS office and text file is accepted.
                    $check_document_extension = $this->getJSModel('common')->checkDocumentFileExtensions($file_name, $file_tmp, $document_file_types);
                    if ($check_document_extension != 1 || $file_size > ($maxFileSize * 1024)) {
                    } else {
                        $fileMatch = 1;
                        $currentFileName = $this->getJSModel('common')->getDocumentName($file_name);
                        $currentFileExt = $this->getJSModel('common')->getExtension($file_name);

                        do {
                            $fileMatch = 1;
                            $query = "SELECT filename FROM `#__js_job_resumefiles` WHERE resumeid = " . $resumeid;
                            $db = $this->getDBO();
                            $db->setQuery($query);
                            $uploadedFileNames = $db->loadObjectList();
                            foreach ($uploadedFileNames as $file) {
                                $uploadedFileName = $this->getJSModel('common')->getDocumentName($file->filename);
                                if ($currentFileName == $uploadedFileName) {
                                    if (substr($uploadedFileName, strlen($uploadedFileName) - 3, 1) == "(") {
                                        $fileIndex = substr($uploadedFileName, strlen($uploadedFileName) - 2, 1) + 1;
                                        $currentFileName = substr($uploadedFileName, 0, strlen($uploadedFileName) - 4) . " (" . $fileIndex . ")";
                                        $file_name = $currentFileName . "." . $currentFileExt;
                                    } else {
                                        $currentFileName = $currentFileName . " (1)";
                                        $file_name = $currentFileName . "." . $currentFileExt;
                                    }
                                    $fileMatch = 0;
                                }
                            }
                        } while ($fileMatch == 0);

                        $path = JPATH_BASE . '/' . $datadirectory;
                        if (!file_exists($path)) {
                            $this->getJSModel('common')->makeDir($path);
                        }
                        $path = $path . '/data';
                        if (!file_exists($path)) {
                            $this->getJSModel('common')->makeDir($path);
                        }
                        $path = $path . '/jobseeker';
                        if (!file_exists($path)) {
                            $this->getJSModel('common')->makeDir($path);
                        }
                        $userpath = $path . '/' . $iddir;
                        if (!file_exists($userpath)) {
                            $this->getJSModel('common')->makeDir($userpath);
                        }
                        $userpath = $path . '/' . $iddir . '/resume';
                        if (!file_exists($userpath)) {
                            $this->getJSModel('common')->makeDir($userpath);
                        }

                        if (!move_uploaded_file($file_tmp, $userpath . '/' . $file_name)) {
                            return 6;
                        } else {
                            $fileRowData = array();
                            $fileRowData['id'] = null;
                            $fileRowData['resumeid'] = $resumeid;
                            $fileRowData['filename'] = $file_name;
                            $fileRowData['filetype'] = $file_type;
                            $fileRowData['filesize'] = $file_size;
                            $fileRowData['created'] = date('Y-m-d H:i:s');
                            $fileRowData['last_modified'] = date('Y-m-d H:i:s');

                            $row = $this->getTable('resumefiles');
                            $fileRowData = filter_var_array($fileRowData, FILTER_SANITIZE_STRING);  // Sanitize entire array to string
                            if (!$row->bind($fileRowData)) {
                                $this->setError($this->_db->getErrorMsg());
                                return 5;
                            }
                            if (!$row->check()) {
                                $this->setError($this->_db->getErrorMsg());
                                return 5;
                            }
                            if (!$row->store()) {
                                $this->setError($this->_db->getErrorMsg());
                                return 5;
                            }
                        }
                    }
                }
            }
        }
        return 1;
    }

    function getResumeFilesByResumeId($resumeid) { // by resumeid because files are stored in seperate table
        if (!is_numeric($resumeid)) return false;
        $totalFilesQry = "SELECT COUNT(id) FROM `#__js_job_resumefiles` WHERE resumeid=" . $resumeid;
        $db = $this->getDBO();
        $db->setQuery($totalFilesQry);
        $filesFound = $db->loadResult();
        if ($filesFound > 0) {
            $query = "SELECT * FROM `#__js_job_resumefiles` WHERE resumeid = " . $resumeid;
            $db = $this->getDBO();
            $db->setQuery($query);
            $files = $db->loadObjectList();
            return $files;
        } else {
            return false;
        }
    }

    function getAllResumeFiles() {
        $resumeid = JRequest::getVar('resumeid', 'com_jsjobs');
        $sr = JRequest::getVar('sr',0);// check wheather resume is local or server
        if($this->_client_auth_key != '' && $sr == 1){ // sharing is enable
            $this->getSharingAdminModel('resume')->getAllResumeFiles($resumeid);
        }else{
            require_once('administrator/components/com_jsjobs/include/lib/pclzip.lib.php');
            $datadirectory = $this->getJSModel('configurations')->getConfigValue('data_directory');
            $path = JPATH_BASE . '/' . $datadirectory;
            if (!file_exists($path)) {
                $this->getJSModel('common')->makeDir($path);
            }
            $path .= '/zipdownloads';
            if (!file_exists($path)) {
                $this->getJSModel('common')->makeDir($path);
            }
            $randomfolder = $this->getRandomFolderName($path);
            $path .= '/' . $randomfolder;
            if (!file_exists($path)) {
                $this->getJSModel('common')->makeDir($path);
            }
            $archive = new PclZip($path . '/allresumefiles.zip');
            $directory = JPATH_BASE . '/' . $datadirectory . '/data/jobseeker/resume_' . $resumeid . '/resume/';
            $scanned_directory = array_diff(scandir($directory), array('..', '.'));
            $filelist = '';
            foreach ($scanned_directory AS $file) {
                $filelist .= $directory . '/' . $file . ',';
            }
            $filelist = substr($filelist, 0, strlen($filelist) - 1);
            $v_list = $archive->create($filelist, PCLZIP_OPT_REMOVE_PATH, $directory);
            if ($v_list == 0) {
                die("Error : '" . $archive->errorInfo() . "'");
            }
            $file = $path . '/allresumefiles.zip';
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            @unlink($file);
            $path = JPATH_BASE . '/' . $datadirectory;
            $path .= 'zipdownloads';
            $path .= '/' . $randomfolder;
            @unlink($path . '/index.html');
            rmdir($path);
            exit();
        }
    }

    function getRandomFolderName($path) {
        $match = '';
        do {
            $rndfoldername = "";
            $length = 5;
            $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
            $maxlength = strlen($possible);
            if ($length > $maxlength) {
                $length = $maxlength;
            }
            $i = 0;
            while ($i < $length) {
                $char = substr($possible, mt_rand(0, $maxlength - 1), 1);
                if (!strstr($rndfoldername, $char)) {
                    if ($i == 0) {
                        if (ctype_alpha($char)) {
                            $rndfoldername .= $char;
                            $i++;
                        }
                    } else {
                        $rndfoldername .= $char;
                        $i++;
                    }
                }
            }
            $folderexist = $path . '/' . $rndfoldername;
            if (file_exists($folderexist))
                $match = 'Y';
            else
                $match = 'N';
        }while ($match == 'Y');

        return $rndfoldername;
    }

    function deleteResumeFile() { // used by muhiaudin
        $id = JRequest::getVar('fileid');
        $resumeid = JRequest::getVar('resumeid');
        $resumeModel = $this->getJSModel('Resume', 'JSJobsModel');
        if (!is_numeric($id) && empty($id))
            return false;
        $row = $this->getTable('resumefiles');
        $row->load($id);
        $iddir = 'resume_' . $resumeid;

        $query = "SELECT COUNT(id) FROM `#__js_job_resumefiles` WHERE id=" . $id;
        $db = $this->getDBO();
        $db->setQuery($query);
        $fileFound = $db->loadResult();
        if ($fileFound == 1) {
            $query = "SELECT filename FROM `#__js_job_resumefiles` WHERE id = " . $id;
            $db = $this->getDBO();
            $db->setQuery($query);
            $filename = $db->loadObject();

            if (!isset($this->_config))
                $this->_config = $this->getJSModel('configurations')->getConfig('');

            foreach ($this->_config as $conf) {
                if ($conf->configname == 'data_directory')
                    $datadirectory = $conf->configvalue;
                if ($conf->configname == 'document_file_type')
                    $document_file_types = $conf->configvalue;
            }
            $path = JPATH_BASE . '/' . $datadirectory . '/data/jobseeker';
            $userpath = $path . '/' . $iddir . '/resume/' . $filename->filename;
            if (file_exists($userpath)) {
                if (!unlink($userpath)) {
                    return false;
                }
            }
            if (!$row->delete($id)) {
                $this->setError($this->_db->getErrorMsg());
                return false;
            }
        } else {
            return false;
        }
        return true;
    }

    function uploadPhoto($id) {
        if (is_numeric($id) == false)
            return false;

        $row = $this->getTable('resume');

        global $resumedata;
        $db = JFactory::getDBO();
        $iddir = 'resume_' . $id;
        $config = $this->getJSModel('configurations')->getConfig('');

        foreach ($this->_config as $conf) {
            if ($conf->configname == 'data_directory')
                $datadirectory = $conf->configvalue;
            if ($conf->configname == 'image_file_type')
                $image_file_types = $conf->configvalue;
        }

        if ($_FILES['photo']['size'] > 0) {
            $file = $_FILES['photo'];
            $file_name = $_FILES['photo']['name'];
            $file_tmp = $_FILES['photo']['tmp_name'];
            $file_size = $_FILES['photo']['size'];
            $file_type = $_FILES['photo']['type'];
            $file_error = $_FILES['photo']['error'];

            $path = JPATH_BASE . '/' . $datadirectory;
            if (!file_exists($path)) {
                $this->getJSModel('common')->makeDir($path);
            }
            $path = $path . '/data';
            if (!file_exists($path)) {
                $this->getJSModel('common')->makeDir($path);
            }
            $path = $path . '/jobseeker';
            if (!file_exists($path)) {
                $this->getJSModel('common')->makeDir($path);
            }
            $userpath = $path . '/' . $iddir;
            if (!file_exists($userpath)) {
                $this->getJSModel('common')->makeDir($userpath);
            }
            $userpath = $path . '/' . $iddir . '/photo';
            if (!file_exists($userpath)) {
                $this->getJSModel('common')->makeDir($userpath);
            }

            $files = glob($userpath . '/*.*');
            array_map('unlink', $files);
            $file_name = explode('.', $file_name);
            $file_name = $file_name[0];
            require_once 'administrator/components/com_jsjobs/include/lib/class.upload.php';
            $handle = new upload($_FILES['photo']);
            if ($handle->uploaded) {
                $handle->file_new_name_body = $file_name;
                $handle->image_resize = true;
                $handle->image_x = 200;
                $handle->image_y = 200;
                $handle->image_ratio_fill = true;
                $handle->process($userpath);
                if ($handle->processed) {
                    $handle->clean();
                    $result = $handle->file_dst_name;
                } else {
                    $result = false;
                }
            }
            if ($result != false) {
                if (!empty($file_tmp)) {
                    $check_image_extension = $this->getJSModel('common')->checkImageFileExtensions($result, $file_tmp, $image_file_types);
                    if ($check_image_extension == 6) {
                        return false;
                    } else {
                        $row->load($id);
                        $row->photo = filter_var($result,FILTER_SANITIZE_STRING);
                        if (!$row->store()) {
                            $this->setError($this->_db->getErrorMsg());
                            return false;
                        }
                    }
                }
            }
        } else {
            return false;
        }
        return true;
    }

    function getResumeDetail($uid, $jobid, $resumeid) {
        if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
            return false;
        if (is_numeric($jobid) == false)
            return false;
        if (is_numeric($resumeid) == false)
            return false;

        $db = $this->getDBO();
        $db = JFactory::getDBO();
        $canview = 0;
        $return_value = "";
        /*
        if ($this->_client_auth_key != "") {
            $jobid = $this->getSharingAdminModel('resume')->getLocalJobid($jobid);
            $resumeid = $this->getSharingAdminModel('resume')->getLocalResumeid($resumeid);
        }
        */
        $query = "SELECT apply.resumeview FROM `#__js_job_jobapply` AS apply WHERE apply.jobid = " . $jobid . " AND apply.cvid = " . $resumeid;
        $db->setQuery($query);
        $alreadyview = $db->loadObject();

        if (isset($alreadyview->resumeview) && $alreadyview->resumeview == 1)
            $canview = 1; //already view this resume
        if ($canview == 0) {
            if (!isset($this->_config)) {
                if(JFactory::getApplication()->isAdmin()){
                    $this->_config = $this->getJSModel('configuration')->getConfig('');
                }else{
                    $this->_config = $this->getJSModel('configurations')->getConfig('');
                }
            }
            foreach ($this->_config as $conf) {
                if ($conf->configname == 'newlisting_requiredpackage')
                    $newlisting_required_package = $conf->configvalue;
            }

            if ($newlisting_required_package == 0) {
                $canview = 1;
            } else {
                $query = "SELECT package.viewresumeindetails, package.packageexpireindays, payment.created
                            FROM `#__js_job_employerpackages` AS package
                            JOIN `#__js_job_paymenthistory` AS payment ON (payment.packageid = package.id AND payment.packagefor=1 )
                            WHERE payment.uid = " . $uid . "
                            AND DATE_ADD(payment.created,INTERVAL package.packageexpireindays DAY) >= CURDATE()";
                
                $db->setQuery($query);
                $jobs = $db->loadObjectList();
                $unlimited = 0;
                $viewresumeindetails = 0;
                foreach ($jobs AS $job) {
                    if ($unlimited == 0) {
                        if ($job->viewresumeindetails != -1) {
                            $viewresumeindetails = $viewresumeindetails + $job->viewresumeindetails;
                        } else
                            $unlimited = 1;
                    }
                }
                if ($unlimited == 0) {
                    if ($viewresumeindetails == 0)
                        $canview = 0; //can not add new job
                    $query = "SELECT SUM(apply.resumeview) AS totalview FROM `#__js_job_jobapply` AS apply WHERE apply.jobid = " . $jobid;
                    $db->setQuery($query);
                    $totalview = $db->loadResult();
                    if ($viewresumeindetails <= $totalview) $canview = 0; //can not add new job
                    else $canview = 1;
                }elseif ($unlimited == 1)
                    $canview = 1; // unlimited
            }
        }
        if ($canview == 1) {

            $query = "UPDATE `#__js_job_jobapply` SET resumeview = 1 WHERE jobid = " . $jobid . " AND cvid = " . $resumeid;
            $db->setQuery($query);
            $db->query();

            if ($this->_client_auth_key != "") {
                $resume = $this->getSharingAdminModel('resume')->getResumeDetail($jobid,$resumeid,$uid);
            } else {
                $query = "SELECT  app.iamavailable
                        , app.id AS appid, app.first_name, app.last_name, app.email_address 
                        , app.jobtype,app.gender,institute.institute,institute.institute_study_area ,cities.stateid ,address.address_city
                        , app.total_experience, app.jobsalaryrange
                        , salary.rangestart, salary.rangeend,education.title AS educationtitle
                        , currency.symbol
                        FROM `#__js_job_resume` AS app 
                        LEFT JOIN `#__js_job_resumeaddresses` AS  address  ON app.id=address.resumeid 
                        LEFT JOIN `#__js_job_resumeinstitutes` AS  institute  ON app.id=institute.resumeid 
                        LEFT JOIN `#__js_job_cities` AS  cities  ON address.address_city=cities.id 
                        LEFT JOIN `#__js_job_heighesteducation` AS  education  ON app.heighestfinisheducation=education.id 
                        LEFT OUTER JOIN  `#__js_job_salaryrange` AS salary  ON  app.jobsalaryrange=salary.id 
                        LEFT JOIN `#__js_job_currencies` AS  currency  ON app.currencyid=currency.id 
                        WHERE app.id = " . $resumeid;

                // ,app.address_county,county.name AS countyname LEFT JOIN `#__js_job_counties` AS county ON app.address_county  = county.id
                $db->setQuery($query);
                $resume = $db->loadObject();
                $query = "SELECT apply.id FROM `#__js_job_jobapply` AS apply
                        WHERE apply.jobid = " . $jobid . " AND apply.cvid = " . $resumeid;
                $db->setQuery($query);
                $jobapplyid = $db->loadResult();
            }
            if(JFactory::getApplication()->isAdmin()){
                require_once(JPATH_ROOT.'/components/com_jsjobs/models/customfields.php');
                $obj = new JSJobsModelCustomFields();
                $fieldsordering = $obj->getFieldsOrdering(3, false); // resume fields ordering
            }else{
                $fieldsordering = $this->getJSModel('customfields')->getFieldsOrdering(3, false); // resume fields ordering
            }
            if (isset($resume)) {
                $trclass = array('odd', 'even');
                $i = 0; // for odd and even rows
                $jobapplyid = !isset($jobapplyid) ? '' : $jobapplyid;
                $return_value = "<div id='resumedetail'>\n";
                if($jobapplyid != '')
                $return_value .= "<img id='jobsappcloseaction' src='".JURI::root()."components/com_jsjobs/images/act_no.png' onclick='jobsAppCloseAction($jobapplyid);'>";
                foreach ($fieldsordering AS $field) {
                    switch ($field->field) {
                        case 'heighestfinishededucation':
                            if ($field->published == 1) {
                                $return_value .= "<div id='resumedetail_data' class='js-col-xs-12 js-col-md-6'>\n";
                                $return_value .= "<span id='resumedetail_data_title' >" . JText::_('Education') . ": </span>\n";
                                $return_value .= "<span id='resumedetail_data_value' >" . $resume->educationtitle . "</span>\n";
                                $return_value .= "</div>\n";
                            }
                            break;
                        case 'institute':
                            if ($field->published == 1) {
                                $institute = isset($resume->institute) ? $resume->institute : $resume->educationtitle;
                                $return_value .= "<div id='resumedetail_data' class='js-col-xs-12 js-col-md-6'>\n";
                                $return_value .= "<span id='resumedetail_data_title' >" . JText::_('Institute') . ": </span>\n";
                                $return_value .= "<span id='resumedetail_data_value' >" . $institute . "</span>\n";
                                $return_value .= "</div>\n";
                            }
                            break;
                        case 'institute_study_area':
                            if ($field->published == 1 && isset($resume->institute_study_area)) {
                                $return_value .= "<div id='resumedetail_data' class='js-col-xs-12 js-col-md-6'>\n";
                                $return_value .= "<span id='resumedetail_data_title' >" . JText::_('Study Area') . ": </span>\n";
                                $return_value .= "<span id='resumedetail_data_value' >" . $resume->institute_study_area . "</span>\n";
                                $return_value .= "</div>\n";
                            }
                            break;
                        case 'total_experience':
                            if ($field->published == 1) {
                                $return_value .= "<div id='resumedetail_data' class='js-col-xs-12 js-col-md-6'>\n";
                                $return_value .= "<span id='resumedetail_data_title' >" . JText::_('Experience') . ": </span>\n";
                                $return_value .= "<span id='resumedetail_data_value' >" . $resume->total_experience . "</span>\n";
                                $return_value .= "</div>\n";
                            }
                            break;
                        case 'iamavailable':
                            if ($field->published == 1) {
                                $return_value .= "<div id='resumedetail_data' class='js-col-xs-12 js-col-md-6'>\n";
                                $return_value .= "<span id='resumedetail_data_title' >" . JText::_('I Am Available') . ": </span>\n";
                                if ($resume->iamavailable == 1)
                                    $return_value .= "<span id='resumedetail_data_value' >" . JText::_('Yes') . "</span>\n";
                                else
                                    $return_value .= "<span id='resumedetail_data_value' >" . JText::_('No') . "</span>\n";
                                $return_value .= "</div>\n";
                            }
                            break;
                        case 'salary':
                            if ($field->published == 1) {
                                $return_value .= "<div id='resumedetail_data' class='js-col-xs-12 js-col-md-6'>\n";
                                $return_value .= "<span id='resumedetail_data_title' >" . JText::_('Current Salary') . ": </span>\n";
                                //$currentsalary=$resume->symbol . $resume->rangestart . ' - ' . $resume->symbol.' '. $resume->rangeend; 
                                //$currentsalary="4000";
                                $return_value .= "<span id='resumedetail_data_value' >" . $resume->symbol . $resume->rangestart . ' - ' . $resume->symbol . ' ' . $resume->rangeend . "</span>\n";
                                $return_value .= "</div>\n";
                            }
                            break;
                    }
                }

                $return_value .= "</div>\n";
            }
        } else {
            $return_value = "<div id='resumedetail'>\n";
            $return_value .= "<tr><td>\n";
            $return_value .= "<table cellpadding='0' cellspacing='0' border='0' width='100%'>\n";
            $return_value .= "<tr class='odd'>\n";
            $return_value .= "<td ><b>" . JText::_('You can not view resume in detail') . "</b></td>\n";
            $return_value .= "<td width='20'><input type='button' class='button' onclick='clsjobdetail(\"resumedetail_$resume->appid\")' value=" . JText::_('Close') . "> </td>\n";
            $return_value .= "</tr>\n";
            $return_value .= "</table>\n";
            $return_value .= "</div>\n";
        }

        return $return_value;
    }



    function getResumeSearch($uid, $title, $name, $nationality, $gender, $iamavailable, $jobcategory, $jobsubcategory, $jobtype, $jobstatus, $currency, $jobsalaryrange, $education, $experiencefrom,$experienceto, $sortby, $limit, $limitstart, $zipcode, $keywords, $searchcity) {
        if($nationality)
            if(!is_numeric($nationality)) return false;
        $db = $this->getDBO();

        if (is_numeric($uid) == false)
            return false;        
        if (($uid == 0) || ($uid == ''))
            return false;
        if (!isset($this->_config)) {
            $this->_config = $this->getJSModel('configurations')->getConfig('');
        }
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'newlisting_requiredpackage')
                $newlisting_required_package = $conf->configvalue;
        }
        if ($newlisting_required_package == 0) {
            $cansearch = -1;
        } else {
            $query = "SELECT  package.resumesearch
                        FROM `#__js_job_employerpackages` AS package
                        JOIN `#__js_job_paymenthistory` AS payment ON (payment.packageid = package.id AND payment.packagefor=1)
                        WHERE payment.uid = " . $uid . "
                        AND DATE_ADD(payment.created,INTERVAL package.packageexpireindays DAY) >= CURDATE()
                        AND payment.transactionverified = 1 AND payment.status = 1";
            $db->setQuery($query);
            $results = $db->loadObjectList();
            $cansearch = 0;
            foreach ($results AS $result) {
                if ($result->resumesearch != -1) {
                    $cansearch += $result->resumesearch;
                }
            }
            if ($cansearch == 0) {
                $result = false;
                return $result;
            }
        }

        if ($gender != '')
            if (is_numeric($gender) == false)
                return false;
        if ($iamavailable != '')
            if (is_numeric($iamavailable) == false)
                return false;
        if ($jobcategory != '')
            if (is_numeric($jobcategory) == false)
                return false;
        if ($jobsubcategory != '')
            if (is_numeric($jobsubcategory) == false)
                return false;
        if ($jobtype != '')
            if (is_numeric($jobtype) == false)
                return false;
        if ($jobsalaryrange != '')
            if (is_numeric($jobsalaryrange) == false)
                return false;
        if ($education != '')
            if (is_numeric($education) == false)
                return false;
        if ($currency != '')
            if (is_numeric($currency) == false)
                return false;
        if ($zipcode != '')
            if (is_numeric($zipcode) == false)
                return false;
        if ($experiencefrom != '')
            if (is_numeric($experiencefrom) == false)
                return false;
        if ($experienceto != '')
            if (is_numeric($experienceto) == false)
                return false;

        if ($newlisting_required_package == 0) {
            $canview = 1;
        } else {

            $query = "SELECT package.saveresumesearch, package.packageexpireindays, payment.created
            FROM `#__js_job_employerpackages` AS package
            JOIN `#__js_job_paymenthistory` AS payment ON (payment.packageid = package.id AND payment.packagefor=1)
            WHERE payment.uid = " . $uid . "
            AND DATE_ADD(payment.created,INTERVAL package.packageexpireindays DAY) >= CURDATE()";
            $db->setQuery($query);
            $jobs = $db->loadObjectList();
            $canview = 0;
            foreach ($jobs AS $job) {
                if ($job->saveresumesearch == 1) {
                    $canview = 1;
                    break;
                } else
                    $canview = 0;
            }
        }

        $result = array();
        $searchresumeconfig = $this->getJSModel('configurations')->getConfigByFor('searchresume');
        $wherequery = '';

        //Custom field search        
        $data = getCustomFieldClass()->userFieldsData(3);
        $valarray = array();
        $option = 'com_jsjobs';
        $mainframe = JFactory::getApplication();
        if( ! empty($data) ){
            foreach ($data as $uf) {
                switch ($uf->userfieldtype) {
                    case 'text':
                        $valarray[$uf->field] = $mainframe->getUserStateFromRequest($option . $uf->field , $uf->field, '' , 'string');
                            $mainframe->getUserStateFromRequest($option . 'title', 'title', '', 'string');
                        if( ! empty($valarray[$uf->field]) )
                            $wherequery .= ' AND resume.params REGEXP \'"' . $uf->field . '":"[^"]*' . htmlspecialchars($valarray[$uf->field]) . '.*"\' ';
                        break;
                    case 'file':
                        $valarray[$uf->field] = $mainframe->getUserStateFromRequest($option . $uf->field , $uf->field, '' , 'string');
                        if( ! empty($valarray[$uf->field]) )
                            $wherequery .= ' AND resume.params REGEXP \'"' . $uf->field . '":"[^"]*' . htmlspecialchars($valarray[$uf->field]) . '.*"\' ';
                        break;
                    case 'combo':
                        $valarray[$uf->field] = $mainframe->getUserStateFromRequest($option . $uf->field , $uf->field, '' , 'string');
                        if( ! empty($valarray[$uf->field]) ){
                            $wherequery .= ' AND resume.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                        }
                        break;
                    case 'depandant_field':
                        $valarray[$uf->field] = $mainframe->getUserStateFromRequest($option . $uf->field , $uf->field, '' , 'string');
                        if( ! empty($valarray[$uf->field]) )
                            $wherequery .= ' AND resume.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                        break;
                    case 'radio':
                        $valarray[$uf->field] = $mainframe->getUserStateFromRequest($option . $uf->field , $uf->field, '' , 'string');
                        if( ! empty($valarray[$uf->field]) )
                            $wherequery .= ' AND resume.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                        break;
                    case 'checkbox':
                        $finalvalue = '';
                        $valarray[$uf->field] = $mainframe->getUserStateFromRequest($option . $uf->field , $uf->field, '' , 'string');
                        if( ! empty($valarray[$uf->field]) ){
                            foreach($valarray[$uf->field] AS $value){
                                $finalvalue .= $value.'.*';
                            }
                            $wherequery .= ' AND resume.params REGEXP \'"' . $uf->field . '":"[^"]*' . htmlspecialchars($finalvalue) . '.*"\' ';
                        }
                        break;
                    case 'date':
                        $valarray[$uf->field] = $mainframe->getUserStateFromRequest($option . $uf->field , $uf->field, '' , 'string');
                        if( ! empty($valarray[$uf->field]) )
                            $wherequery .= ' AND resume.params LIKE \'%"' . $uf->field . '":"' . htmlspecialchars($valarray[$uf->field]) . '"%\' ';
                        break;
                    case 'textarea':
                        $valarray[$uf->field] = $mainframe->getUserStateFromRequest($option . $uf->field , $uf->field, '' , 'string');
                        if( ! empty($valarray[$uf->field]) )
                            $wherequery .= ' AND resume.params REGEXP \'"' . $uf->field . '":"[^"]*' . htmlspecialchars($valarray[$uf->field]) . '.*"\' ';
                        break;
                    case 'multiple':
                        $finalvalue = '';
                        $valarray[$uf->field] = $mainframe->getUserStateFromRequest($option . $uf->field , $uf->field, '' , 'string');
                        if( ! empty($valarray[$uf->field]) ){
                            foreach($valarray[$uf->field] AS $value){
                                if($value)
                                    $finalvalue .= $value.'.*';
                            }
                            if($finalvalue)
                                $wherequery .= ' AND resume.params REGEXP \'"' . $uf->field . '":"[^"].*'.htmlspecialchars($finalvalue).'.*"\'';
                        }
                    break;
                }
            }
        }
        // End customfiled

        if ($title != '') { // For title  Search
            $titlekeywords = explode(' ', $title);
            $length = count($titlekeywords);
            if ($length <= 5) {// For Limit keywords to 5
                $i = $length;
            } else {
                $i = 5;
            }
            for ($j = 0; $j < $i; $j++) {
                $titlekeys[] = " resume.application_title Like ".$db->Quote('%'.$titlekeywords[$j].'%');
            }
        }
        if (isset($titlekeys))
            $wherequery .= " AND ( " . implode(' OR ', $titlekeys) . " )";

        if ($keywords != '') { // For title  Search
            $keywords = explode(' ', $keywords);
            $length = count($keywords);
            if ($length <= 5) {// For Limit keywords to 5
                $i = $length;
            } else {
                $i = 5;
            }
            for ($j = 0; $j < $i; $j++) {
                $keys[] = " resume.keywords Like ".$db->Quote('%'.$keywords[$j].'%');
            }
        }
        if (isset($keys))
            $wherequery .= " AND ( " . implode(' OR ', $keys) . " )";

        if ($name != '') {
            $wherequery .= " AND (";
            $wherequery .= " LOWER(resume.first_name) LIKE " . $db->Quote('%' . $name . '%');
            $wherequery .= " OR LOWER(resume.last_name) LIKE " . $db->Quote('%' . $name . '%');
            $wherequery .= " OR LOWER(resume.middle_name) LIKE " . $db->Quote('%' . $name . '%');
            $wherequery .= " )";
        }

        if ($nationality != '')
            $wherequery .= " AND resume.nationality = " . $nationality;
        if ($gender != '')
            $wherequery .= " AND resume.gender = " . $gender;
        if ($iamavailable != '')
            $wherequery .= " AND resume.iamavailable = " . $iamavailable;
        if ($jobcategory != '')
            $wherequery .= " AND resume.job_category = " . $jobcategory;
        if ($jobsubcategory != '')
            $wherequery .= " AND resume.job_subcategory = " . $jobsubcategory;
        if ($jobtype != '')
            $wherequery .= " AND resume.jobtype = " . $jobtype;
        if ($jobsalaryrange != '')
            $wherequery .= " AND resume.jobsalaryrange = " . $jobsalaryrange;
        if ($education != '')
            $wherequery .= " AND resume.heighestfinisheducation = " . $education;
        if ($currency != '')
            $wherequery .= " AND resume.currencyid = " . $currency;
        
        if ($experiencefrom != ''){
            $wherequery .= " AND exp.id  >= ".$experiencefrom;
        }
        
        if ($experienceto != ''){
            $wherequery .= " AND exp.id  <= ".$experienceto;
        }


        $query = "SELECT count(resume.id) 
                    FROM `#__js_job_resume` AS resume 
                    LEFT JOIN `#__js_job_categories` AS cat ON resume.job_category = cat.id
                    LEFT JOIN `#__js_job_experiences` AS exp ON exp.id = resume.experienceid";
        if($searchcity != ''){
            $query .= " JOIN `#__js_job_resumeaddresses` AS address ON (address.resumeid = resume.id AND address.address_city = ".$searchcity.") ";
        }
        if($zipcode != ''){
            $query .= " JOIN `#__js_job_resumeaddresses` AS address1 ON (address1.resumeid = resume.id AND address1.address_zipcode = ".$zipcode.") ";
        }
        $query .= " WHERE resume.status = 1 AND resume.searchable = 1  ";
        $query .= $wherequery;
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT  resume.*,edu.title AS educationtitle, cat.cat_title, jobtype.title AS jobtypetitle
                    , salary.rangestart, salary.rangeend , country.name AS countryname
                    , city.cityName AS cityname,state.name AS statename
                    , currency.symbol as symbol 
                    ,CONCAT(resume.alias,'-',resume.id) AS resumealiasid
                    ,salarytype.title AS salarytype,exp.title AS exptitle
                    FROM `#__js_job_resume` AS resume ";
        if($searchcity != ''){
            $query .= " JOIN `#__js_job_resumeaddresses` AS address ON (address.resumeid = resume.id AND address.address_city = ".$searchcity.") ";
        }
        if($zipcode != ''){
            $query .= " JOIN `#__js_job_resumeaddresses` AS address1 ON (address1.resumeid = resume.id AND address1.address_zipcode = ".$zipcode.") ";
        }

        $query .= " LEFT JOIN `#__js_job_categories` AS cat ON resume.job_category = cat.id
                    LEFT JOIN `#__js_job_jobtypes` AS jobtype ON resume.jobtype = jobtype.id
                    LEFT JOIN `#__js_job_salaryrange` AS salary ON resume.jobsalaryrange = salary.id
                    LEFT JOIN `#__js_job_salaryrangetypes` AS salarytype ON resume.jobsalaryrangetype = salarytype.id
                    LEFT JOIN `#__js_job_cities` AS city ON city.id = (SELECT address.address_city FROM `#__js_job_resumeaddresses` AS address WHERE address.resumeid = resume.id LIMIT 1)
                    LEFT JOIN `#__js_job_countries` AS country ON city.countryid = country.id
                    LEFT JOIN `#__js_job_states` AS state ON city.stateid = state.id
                    LEFT JOIN `#__js_job_experiences` AS exp ON exp.id = resume.experienceid
                    LEFT JOIN `#__js_job_currencies` AS currency ON currency.id = resume.currencyid 
                    LEFT JOIN `#__js_job_heighesteducation` AS edu ON edu.id = resume.heighestfinisheducation ";
        $query .=" WHERE resume.status = 1 AND resume.searchable = 1";

        $query .= $wherequery;
        $query .= " GROUP BY resume.id ";
        $query .= " ORDER BY  " . $sortby;

        $db->setQuery($query, $limitstart, $limit);
        
        $result[0] = $db->loadObjectList();
        $result[1] = $total;
        $result[2] = $searchresumeconfig;
        $result[3] = $canview;
        $fieldsordering = $this->getJSModel('customfields')->getFieldsOrdering(3);
        $fieldsordering = $this->getJSModel('customfields')->parseFieldsOrderingForView($fieldsordering);
        $result[4] = $fieldsordering;
        $result[5] = $valarray;

        return $result;
    }

    function getResumeBySubCategoryId($uid, $jobsubcategory, $sortby, $limit, $limitstart) {
        $db = $this->getDBO();

        if (is_numeric($uid) == false)
            return false;
        if (is_numeric($jobsubcategory) == false)
            return false;
        if (($uid == 0) || ($uid == ''))
            return false;
        $result = array();

        $query = "SELECT count(resume.id) 
                    FROM `#__js_job_resume` AS resume
                    LEFT JOIN `#__js_job_subcategories` AS subcat ON resume.job_subcategory=subcat.id
                    WHERE subcat.id = " . $jobsubcategory . " AND resume.status = 1 AND resume.searchable = 1  ";

        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;
        if ($total != 0) {

            $query = "SELECT  resume.*,cat.id as cat_id,cat.cat_title, subcat.title as subcategory,jobtype.title AS jobtypetitle
                        , salary.rangestart, salary.rangeend , country.name AS countryname
                        , city.cityName AS cityname,state.name AS statename
                        , currency.symbol as symbol 
                        ,CONCAT(subcat.alias,'-',subcat.id) AS aliasid
                        ,CONCAT(resume.alias,'-',resume.id) AS resumealiasid
                        ,salarytype.title AS salarytype,exp.title AS exptitle
                        ,resume.total_experience
                        FROM `#__js_job_resume` AS resume
                        LEFT JOIN `#__js_job_categories` AS cat ON resume.job_category = cat.id
                        LEFT JOIN `#__js_job_subcategories` AS subcat ON resume.job_subcategory =" . $jobsubcategory . " 
                        LEFT JOIN `#__js_job_jobtypes` AS jobtype ON resume.jobtype = jobtype.id
                        LEFT JOIN `#__js_job_salaryrange` AS salary ON resume.jobsalaryrange = salary.id
                        LEFT JOIN  `#__js_job_salaryrangetypes` AS salarytype ON resume.jobsalaryrangetype = salarytype.id
                        LEFT JOIN `#__js_job_cities` AS city ON city.id = (SELECT address.address_city FROM `#__js_job_resumeaddresses` AS address WHERE address.resumeid = resume.id LIMIT 1)
                        LEFT JOIN `#__js_job_countries` AS country ON city.countryid = country.id
                        LEFT JOIN `#__js_job_states` AS state ON city.stateid = state.id
                        LEFT JOIN `#__js_job_currencies` AS currency ON currency.id = resume.currencyid 
                        LEFT JOIN `#__js_job_experiences` AS exp ON exp.id = resume.experienceid ";
            $query .= " WHERE subcat.id = " . $jobsubcategory . " AND resume.status = 1 AND resume.searchable = 1";
            $query .= " ORDER BY  " . $sortby;

            $db->setQuery($query, $limitstart, $limit);
            $resumebysubcategorydata = $db->loadObjectList();
        } else {
            $query = "SELECT cat.id as cat_id, cat.cat_title, subcat.title as subcategory
                        FROM `#__js_job_categories` AS cat
                        JOIN `#__js_job_subcategories` AS subcat ON subcat.categoryid = cat.id
                        WHERE subcat.id = " . $jobsubcategory;
            $db->setQuery($query);
            $subcategorydata = $db->loadObject();
        }

        $fieldsordering = $this->getJSModel('customfields')->getFieldsOrdering(3);
        $fieldsordering = $this->getJSModel('customfields')->parseFieldsOrderingForView($fieldsordering);

        if (isset($resumebysubcategorydata))
            $result[0] = $resumebysubcategorydata;
        if (isset($subcategorydata))
            $result[2] = $subcategorydata;
        $result[1] = $total;
        $result[3] = $fieldsordering;
        return $result;
    }

    function getResumeByCategoryId($uid, $jobcategory, $job_subcategory, $sortby, $limit, $limitstart) {
        $db = $this->getDBO();
        if (is_numeric($uid) == false)
            return false;
        if (($uid == 0) || ($uid == ''))
            return false;

        if(is_numeric($jobcategory) AND $jobcategory > 0){
            $isresumebycategory = true;
        }elseif(is_numeric($job_subcategory) AND $job_subcategory > 0){
            $isresumebycategory = false;
        }else{
            return false;
        }

        $searchresumeconfig = $this->getJSModel('configurations')->getConfigByFor('searchresume');

        if($isresumebycategory){
            $select_cols = ' cat.cat_title, cat.cat_title AS categorytitle , CONCAT(cat.alias,"-",cat.id) AS aliasid ';
            $in_join = ' JOIN `#__js_job_categories` AS cat ON cat.id = resume.job_category ';
            $wherequery = 'cat.id = ' . $jobcategory;
        }else{
            $select_cols = ' subcat.title AS categorytitle,subcat.title AS subcat_title , CONCAT(subcat.alias,"-",subcat.id) AS aliasid ';
            $in_join = ' JOIN `#__js_job_subcategories` AS subcat ON subcat.id = resume.job_subcategory ';
            $wherequery = ' subcat.id = ' . $job_subcategory;
        }

        $result = array();
        $query = "SELECT count(resume.id) 
                        FROM `#__js_job_resume` AS resume
                        ".$in_join."
                        WHERE ".$wherequery." AND resume.status = 1 AND resume.searchable = 1  ";
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;


        $query = "SELECT resume.params,resume.id ,resume.first_name ,resume.last_name ,resume.application_title 
                        ,resume.photo ,resume.email_address ,resume.total_experience ,resume.created
                        , jobtype.title AS jobtypetitle
                        , salary.rangestart, salary.rangeend , country.name AS countryname
                        , city.cityName AS cityname,state.name AS statename
                        , currency.symbol as symbol, education.title AS educationtitle
                        , ".$select_cols."
                        ,CONCAT(resume.alias,'-',resume.id) AS resumealiasid
                        ,salarytype.title AS salarytype

                        FROM `#__js_job_resume` AS resume
                        ".$in_join."
                        LEFT JOIN `#__js_job_jobtypes` AS jobtype ON resume.jobtype = jobtype.id
                        LEFT JOIN `#__js_job_salaryrange` AS salary ON resume.jobsalaryrange = salary.id
                        LEFT JOIN `#__js_job_salaryrangetypes` AS salarytype ON resume.jobsalaryrangetype = salarytype.id
                        LEFT JOIN `#__js_job_cities` AS city ON city.id = (SELECT address.address_city FROM `#__js_job_resumeaddresses` AS address WHERE address.resumeid = resume.id LIMIT 1)
                        LEFT JOIN `#__js_job_countries` AS country ON city.countryid = country.id
                        LEFT JOIN `#__js_job_states` AS state ON city.stateid = state.id
                        LEFT JOIN `#__js_job_currencies` AS currency ON currency.id = resume.currencyid 
                        LEFT JOIN `#__js_job_heighesteducation` AS education ON education.id = resume.heighestfinisheducation ";
        $query .= " WHERE ".$wherequery." AND resume.status = 1 AND resume.searchable = 1";
        $query .= " ORDER BY  " . $sortby;

        $db->setQuery($query, $limitstart, $limit);
        $resume = $db->loadObjectList();

        if($isresumebycategory){   //for categroy title
            
            $query = "SELECT cat_title FROM `#__js_job_categories` WHERE id = " . $jobcategory;
            $db->setQuery($query);
            $cat_title = $db->loadResult();
            
        }else{ // subcategory title
            $query = "SELECT title FROM `#__js_job_subcategories` WHERE id = " . $job_subcategory;
            $db->setQuery($query);
            $cat_title = $db->loadResult();
            $jobcategory = $job_subcategory;
        }


        $fieldsordering = $this->getJSModel('customfields')->getFieldsOrdering(3);
        $fieldsordering = $this->getJSModel('customfields')->parseFieldsOrderingForView($fieldsordering);

        $result[0] = $resume;
        $result[1] = $total;
        $result[2] = $searchresumeconfig;
        $result[3] = $cat_title;
        $result[4] = $jobcategory;
        $result[5] = isset($resumesubcategory) ? $resumesubcategory : false;
        $result[6] = $fieldsordering;
        return $result;
    }

    function getMyResumeSearchesbyUid($u_id, $limit, $limitstart) {
        $db = $this->getDBO();
        if ((is_numeric($u_id) == false) || ($u_id == 0) || ($u_id == ''))
            return false;
        $result = array();
        $query = "SELECT COUNT(id) FROM `#__js_job_resumesearches` WHERE uid  = " . $u_id;
        $db->setQuery($query);
        $total = $db->loadResult();

        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT search.* 
                    FROM `#__js_job_resumesearches` AS search
                    WHERE search.uid  = " . $u_id;
        $db->setQuery($query);
        $db->setQuery($query, $limitstart, $limit);

        $result[0] = $db->loadObjectList();
        $result[1] = $total;

        return $result;
    }

    function canSearchResume($uid) {
        if (!is_numeric($uid))
            return false;
        $db = $this->getDBO();
        $query = "SELECT package.resumesearch, package.packageexpireindays, payment.created
                    FROM `#__js_job_employerpackages` AS package
                    JOIN `#__js_job_paymenthistory` AS payment ON (payment.packageid = package.id AND payment.packagefor=1)
                    WHERE payment.uid = " . $uid . "
                    AND DATE_ADD(payment.created,INTERVAL package.packageexpireindays DAY) >= CURDATE()
                    AND payment.transactionverified = 1 AND payment.status = 1";

        $db->setQuery($query);
        $valid_packages = $db->loadObjectList();
        if (empty($valid_packages)) { // user have no valid package
            $query = "SELECT package.resumesearch, package.packageexpireindays, payment.created
                        FROM `#__js_job_employerpackages` AS package
                        JOIN `#__js_job_paymenthistory` AS payment ON (payment.packageid = package.id AND payment.packagefor=1)
                        WHERE payment.uid = " . $uid . "
                        AND payment.transactionverified = 1 AND payment.status = 1";

            $db->setQuery($query);
            $packages = $db->loadObjectList();
            if (empty($pacakges)) {
                return NO_PACKAGE;
            } else {
                return EXPIRED_PACKAGE;
            }
        } else { // user have valid pacakge
            $canview = RESUME_SEARCH_NOT_ALLOWED_IN_PACAKGE;
            foreach ($valid_packages AS $job) {
                if ($job->resumesearch == 1) {
                    $canview = VALIDATE;
                    break;
                }
            }
            return $canview;
        }
    }

    function getResumeSearchOptions() {
        $db = $this->getDBO();
        $canview = $this->getJSModel('permissions')->checkPermissionsFor("RESUME_SEARCH");
        if ($canview == VALIDATE) {
            $searchresumeconfig = $this->getJSModel('configurations')->getConfigByFor('searchresume');
            $gender = array(
                '0' => array('value' => '', 'text' => JText::_('Select Gender')),
                '1' => array('value' => 1, 'text' => JText::_('Male')),
                '2' => array('value' => 2, 'text' => JText::_('Female')),);
            $defaultCategory = $this->getJSModel('common')->getDefaultValue('categories');
            $defaultJobtype = $this->getJSModel('common')->getDefaultValue('jobtypes');
            $defaultEducation = $this->getJSModel('common')->getDefaultValue('heighesteducation');
            $defaultSalaryrange = $this->getJSModel('common')->getDefaultValue('salaryrange');
            $defaultCurrencies = $this->getJSModel('common')->getDefaultValue('currencies');
            $defaultexp = $this->getJSModel('common')->getDefaultValue('experiences');



            $nationality = $this->getJSModel('countries')->getCountries(JText::_('Select Nationality'));
            $job_type = $this->getJSModel('jobtype')->getJobType(JText::_('Select Job Type'));
            $heighesteducation = $this->getJSModel('highesteducation')->getHeighestEducation(JText::_('Select Highest Education'));
            $job_categories = $this->getJSModel('category')->getCategories(JText::_('Select Category'));
            $job_subcategories = $this->getJSModel('subcategory')->getSubCategoriesforCombo($defaultCategory, JText::_('Select Sub Category'), '');
            $job_salaryrange = $this->getJSModel('salaryrange')->getJobSalaryRange(JText::_('Select Salary Range'), '');
            $currencies = $this->getJSModel('currency')->getCurrency(JText::_('Select Currency'));
            $experiences = $this->getJSModel('experience')->getExperiences(JText::_('Select Minimum Experience'));
            $experiences1 = $this->getJSModel('experience')->getExperiences(JText::_('Select Maximum Experience'));

            $searchoptions['nationality'] = JHTML::_('select.genericList', $nationality, 'nationality', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', '');
            $searchoptions['jobcategory'] = JHTML::_('select.genericList', $job_categories, 'jobcategory', 'class="inputbox jsjobs-cbo" ' . 'onChange="fj_getsubcategories(\'fj_subcategory\', this.value)"', 'value', 'text', '');
            $searchoptions['jobsubcategory'] = JHTML::_('select.genericList', $job_subcategories, 'jobsubcategory', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', '');
            $searchoptions['jobsalaryrange'] = JHTML::_('select.genericList', $job_salaryrange, 'jobsalaryrange', 'class="inputbox jsjobs-cbo" style="width:100%;"' . '', 'value', 'text', '');
            $searchoptions['jobtype'] = JHTML::_('select.genericList', $job_type, 'jobtype', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', '');
            $searchoptions['heighestfinisheducation'] = JHTML::_('select.genericList', $heighesteducation, 'heighestfinisheducation', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', '');
            $searchoptions['gender'] = JHTML::_('select.genericList', $gender, 'gender', 'class="inputbox jsjobs-cbo" ' . '', 'value', 'text', '');
            $searchoptions['currency'] = JHTML::_('select.genericList', $currencies, 'currency', 'class="inputbox jsjobs-cbo" style="width:99%;margin-left:1%;"' . '', 'value', 'text', '');
            $searchoptions['experiencemin'] = JHTML::_('select.genericList', $experiences, 'experiencemin', 'class="inputbox jsjobs-cbo" style="width:49.5%;"' . '', 'value', 'text', '');
            $searchoptions['experiencemax'] = JHTML::_('select.genericList', $experiences1, 'experiencemax', 'class="inputbox jsjobs-cbo" style="width:49.5%;"' . '', 'value', 'text', '');
            $result = array();
            $result[0] = $searchoptions;
            $result[1] = $searchresumeconfig;
            $result[2] = $canview;
        } else {
            $result[2] = $canview;
        }
        return $result;
    }

    function getResumeByCategory($uid) {
        $db = $this->getDbo();
        $canview = $this->getJSModel('permissions')->checkPermissionsFor("RESUME_SEARCH");
        if ($canview == VALIDATE) {
            $query = "SELECT DISTINCT cat.id AS catid, cat.cat_title AS cattitle, 
                        (SELECT COUNT(id) FROM `#__js_job_resume` WHERE job_category = cat.id  AND status=1 AND searchable=1 ) AS total
                        ,CONCAT(cat.alias,'-',cat.id) AS aliasid
                        FROM `#__js_job_categories` AS cat
                        WHERE cat.isactive = 1";

            $db->setQuery($query);
            $result = $db->loadObjectList();
            $return[0] = $result;
            $return[1] = $canview;
            return $return;
        } else {
            $return[0] = null;
            $return[1] = $canview;
            return $return;
        }
    }

    function subCategoriesByCatIdresume($catid, $showall){
        if(!is_numeric($catid))
            return false;
        $db = $this->getDBO();
        if (!isset($this->_config)) {
            $this->_config = $this->getJSModel('configurations')->getConfig('');
        }
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'subcategory_limit')
                $shownoofsubcats = $conf->configvalue;
        }
        if(!is_numeric($shownoofsubcats)){
            return "";
        }

        $tempshownoofsubcats = $shownoofsubcats + 1;

        $curdate = date('Y-m-d H:i:s');
        $inquery = " (SELECT COUNT(resume.id) 
                FROM `#__js_job_resume`  AS resume 
                WHERE cat.id = resume.job_subcategory AND resume.status = 1 AND resume.searchable = 1 ) AS catinjobs ";
        
        $query = "SELECT cat.id AS subcatid , title ,CONCAT(cat.alias,'-',cat.id) AS subcategoryaliasid , ";
        $query .= $inquery;
        $query .= "FROM `#__js_job_subcategories` AS cat 
                    WHERE cat.status = 1 AND cat.categoryid = ".$catid;
        if($showall)
            $query .= " ORDER BY cat.title ";
        else
            $query .= " ORDER BY cat.title LIMIT ".$tempshownoofsubcats;
        
        $db->setQuery($query);
        $this->_applications = $db->loadObjectList();
        $Itemid = JRequest::getVar('itemid');
        $html = '';
        if($showall){
            $db->setQuery("SELECT cat_title FROM `#__js_job_categories` WHERE id= $catid");
            $ct = $db->loadResult();
            $html = '<div id="jsjobs_subcatpopups">
                        <span class="popup-title">
                            <span class="title">'.$ct.'</span>
                            <img src="'.JURI::root().'components/com_jsjobs/images/popup-close.png" onClick="hidepopup();" id="popup_cross" />
                        </span>
                        <div id="jsjobs_scroll_area">';
            foreach ($this->_applications as $obj) {
                $lnk = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=resume_bycategory&resumesubcat=' . $obj->subcategoryaliasid . '&Itemid=' . $Itemid;
                $html .= '<a id="jsjobs-subcat-popup-a" href="'.JRoute::_($lnk ,false).'">
                            <span class="jsjobs-cat-title"> '.JText::_($obj->title).'</span>
                            <span class="jsjobs-cat-counter">('.$obj->catinjobs.')</span>
                           </a>';
            }
            $html .= "</div></div>";
        }else{
            $total_results = count($this->_applications);
            if($total_results==0)
                return "";
            $html = "<div class='jsjobs_subcat_wrapper'>";
            for ($i=0; $i < $total_results-1; $i++) {
                $obj = $this->_applications[$i];
                $lnk = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=resume_bycategory&resumesubcat=' . $obj->subcategoryaliasid . '&Itemid=' . $Itemid;
                $html .= "<a id='jsjobs-subcat-block-a' href=\"".JRoute::_($lnk ,false)."\">
                            <span class='jsjobs-cat-title'> ".JText::_($obj->title)."</span>
                            <span class='jsjobs-cat-counter'>(".$obj->catinjobs.")</span>
                          </a>";
            }
            if($shownoofsubcats < $total_results)
                $html .= "<span id='showmore_p' onClick='showpopup(".$catid.");'>".JText::_('Show More')."</span></div>";
            else
                $html .= "</div>";
        }
        return $html;

    }

    
    function getResumeDataCountById($resumeid){
        if(!is_numeric($resumeid)) return false;
        $db = JFactory::getDbo();
        //Query for address
        $query = "SELECT COUNT(id) FROM `#__js_job_resumeaddresses` WHERE resumeid = $resumeid";
        $db->setQuery($query);
        $result['address_count'] = $db->loadResult();
        //Query for Education
        $query = "SELECT COUNT(id) FROM `#__js_job_resumeinstitutes` WHERE resumeid = $resumeid";
        $db->setQuery($query);
        $result['insititute_count'] = $db->loadResult();
        //Query for Employer
        $query = "SELECT COUNT(id) FROM `#__js_job_resumeemployers` WHERE resumeid = $resumeid";
        $db->setQuery($query);
        $result['employers_count'] = $db->loadResult();
        //Query for Refereneces
        $query = "SELECT COUNT(id) FROM `#__js_job_resumereferences` WHERE resumeid = $resumeid";
        $db->setQuery($query);
        $result['references_count'] = $db->loadResult();
        //Query for Languages
        $query = "SELECT COUNT(id) FROM `#__js_job_resumelanguages` WHERE resumeid = $resumeid";
        $db->setQuery($query);
        $result['languages_count'] = $db->loadResult();
        //Query for Skills
        $query = "SELECT skills FROM `#__js_job_resume` WHERE id = $resumeid";
        $db->setQuery($query);
        $skill = $db->loadResult();
        if(!empty($skill)){
            $result['skills_count'] = 1;
        }else{
            $result['skills_count'] = 0;
        }
        //Query for Resume
        $query = "SELECT resume FROM `#__js_job_resume` WHERE id = $resumeid";
        $db->setQuery($query);
        $resume = $db->loadResult();
        if(!empty($resume)){
            $result['resume_count'] = 1;
        }else{
            $result['resume_count'] = 0;
        }
        
        return $result;
    }

    function deleteSectionById($resumeid,$sectionid,$isadmin,$section){
        if(!is_numeric($resumeid)) return false;
        if(!is_numeric($sectionid)) return false;
        $db = JFactory::getDbo();
        if($isadmin == 0){ // user is not admin check perform
            $user = JFactory::getUser();
            if($user->guest){ // in case of guest check from the session id
                $session = JFactory::getSession();
                if($session->has('jsjobs_resumeid_for_form')){
                    if($resumeid != $session->get('jsjobs_resumeid_for_form')){
                        return 2; // not your resume
                    }
                }
            }else{ // check the current uid with the resumeid
                $query = "SELECT COUNT(id) FROM `#__js_job_resume` WHERE id = $resumeid AND uid = $user->id";
                $db->setQuery($query);
                $result = $db->loadResult();
                if($result == 0){
                    return 2; // not your resume
                }
            }
        }
        $tablename = null;
        switch ($section) {
            case 'language': $tablename = '#__js_job_resumelanguages';break;
            case 'reference': $tablename = '#__js_job_resumereferences';break;
            case 'employer': $tablename = '#__js_job_resumeemployers';break;
            case 'institute': $tablename = '#__js_job_resumeinstitutes';break;
            case 'address': $tablename = '#__js_job_resumeaddresses';break;
        }

        if($tablename != null){
            $query = "DELETE FROM `$tablename` WHERE id = $sectionid";
            $db->setQuery($query);
            if($db->query()){
                return 1;
            }else{
                return 3;
            }
        }
    }

// custom field code start
    function getDataForParams($section, $data) {
        if (JFactory::getApplication()->isSite() OR $isadmin == 0) {
            $userfieldforjob = $this->getJSModel('customfields')->getUserfieldsfor(3 ,$section);
        } else {
            $userfieldforjob = $this->getJSModel('fieldordering')->getUserfieldsfor(3 ,$section);
        }

        $customflagforadd = false;
        $customflagfordelete = false;
        $custom_field_namesforadd = array();
        $custom_field_namesfordelete = array();
        $params = '';
        foreach ($userfieldforjob AS $ufobj) {
            $vardata = '';
            if($ufobj->userfieldtype == 'file'){
                if(isset($data[$ufobj->field.'_1']) && $data[$ufobj->field.'_1'] == 0){
                    $vardata = $data[$ufobj->field.'_2'];
                }else{
                    $vardata = isset($_FILES[$ufobj->field]['name']) ? $_FILES[$ufobj->field]['name'] : '';
                }
                $customflagforadd = true;
                $custom_field_namesforadd[]=$ufobj->field;
            }else{
                $vardata = isset($data[$ufobj->field]) ? $data[$ufobj->field] : '';
            }
            if(isset($data[$ufobj->field.'_1']) && $data[$ufobj->field.'_1'] == 1){
                $customflagfordelete = true;
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
        if (!empty($params)) {
            $params = json_encode($params);
        }

        $return = array();
        $return['params'] = $params;
        $return['customflagforadd'] = $customflagforadd;
        $return['customflagfordelete'] = $customflagfordelete;
        $return['custom_field_namesforadd'] = $custom_field_namesforadd;
        $return['custom_field_namesfordelete'] = $custom_field_namesfordelete;

        return $return;
    }
    
    function getUserFieldsForSection( $section ) {
        if (JFactory::getApplication()->isSite() OR $isadmin == 0) {
            $userfieldforjob = $this->getJSModel('customfields')->getUserfieldsfor(3 ,$section);
        } else {
            $userfieldforjob = $this->getJSModel('fieldordering')->getUserfieldsfor(3 ,$section);
        }
        return $userfieldforjob;
    }
// custom field code End    

    function checkResumeExists($resumeid){
        if(!is_numeric($resumeid)) return false;
        $db = $this->getDBO();      
        $query = "SELECT COUNT(id) FROM `#__js_job_resume` WHERE id = ".$resumeid;
        $db->setQuery($query);
        $result = $db->loadResult();
        if($result == 1){
            return true;
        }else{
            return false;
        }
    }
}
?>
    
