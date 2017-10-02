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

class JSJobsModelEmployer extends JSModel {

    var $_client_auth_key = null;
    var $_siteurl = null;
    var $_uid = null;

    function __construct() {
        parent::__construct();
        $this->_client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function getMultiCityDataForView($id, $for) {
        if (!is_numeric($id))
            return false;
        $db = $this->getDBO();
        $query = "select mcity.id AS id,country.name AS countryName,city.cityName AS cityName,state.name AS stateName";
        switch ($for) {
            case 1:
                $query.=" FROM `#__js_job_jobcities` AS mcity";
                $query.=" LEFT JOIN `#__js_job_jobs` AS job ON mcity.jobid=job.id";
                break;
            case 2:
                $query.=" FROM `#__js_job_companycities` AS mcity";
                $query.=" LEFT JOIN `#__js_job_companies` AS company ON mcity.companyid=company.id";
                break;
        }
        $query.=" LEFT JOIN `#__js_job_cities` AS city ON mcity.cityid=city.id
                    LEFT JOIN `#__js_job_states` AS state ON city.stateid=state.id
                    LEFT JOIN `#__js_job_countries` AS country ON city.countryid=country.id";
        switch ($for) {
            case 1:
                $query.=" where mcity.jobid=" . $id;
                break;
            case 2:
                $query.=" where mcity.companyid=" . $id;
                break;
        }
        $query.=" ORDER BY country.name";
        $db->setQuery($query);
        $cities = $db->loadObjectList();
        $mloc = array();
        $mcountry = array();
        $finalloc = "";
        foreach ($cities AS $city) {
            $mcountry[] = $city->countryName;
        }
        $country_total = array_count_values($mcountry);
        $i = 0;
        foreach ($country_total AS $key => $val) {
            foreach ($cities AS $city) {
                if ($key == $city->countryName) {
                    $i++;
                    if ($val == 1) {
                        $finalloc.="[" . $city->cityName . "," . $key . " ] ";
                        $i = 0;
                    } elseif ($i == $val) {
                        $finalloc.=$city->cityName . "," . $key . " ] ";
                        $i = 0;
                    } elseif ($i == 1)
                        $finalloc.= "[" . $city->cityName . ",";
                    else
                        $finalloc.=$city->cityName . ",";
                }
            }
        }
        return $finalloc;
    }

    function getMyStats_Employer($uid) {
        if (is_numeric($uid) == false)
            return false;
        if (($uid == 0) || ($uid == ''))
            return false;

        if (!isset($this->_config)) {
            $this->_config = $this->getJSModel('configurations')->getConfig('');
        }
        $ispackagerequired = 1;
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'newlisting_requiredpackage')
                $newlisting_required_package = $conf->configvalue;
        }
        if ($newlisting_required_package == 0) {
            $ispackagerequired = 0;
        }


        $db = $this->getDBO();
        $results = array();

        // companies
        $query = "SELECT package.companiesallow,package.jobsallow
                    FROM #__js_job_paymenthistory AS payment
                    JOIN #__js_job_employerpackages AS package ON (package.id = payment.packageid AND payment.packagefor=1)
                    WHERE payment.uid = " . $uid . "
                    AND DATE_ADD(payment.created,INTERVAL package.packageexpireindays DAY) >= CURDATE()
                    AND payment.transactionverified = 1 AND payment.status = 1";
        $db->setQuery($query);
        $packages = $db->loadObjectList();
        if (empty($packages)) {
            $query = "SELECT package.id, package.resumeallow,package.title AS packagetitle, package.packageexpireindays, payment.id AS paymentid
                        , (TO_DAYS( CURDATE() ) - To_days( payment.created ) ) AS packageexpiredays
                       FROM `#__js_job_employerpackages` AS package
                       JOIN `#__js_job_paymenthistory` AS payment ON (payment.packageid = package.id AND payment.packagefor=1)
                       WHERE payment.uid = " . $uid . " 
                       AND payment.transactionverified = 1 AND payment.status = 1 ORDER BY payment.created DESC";

            $query = "SELECT package.id, package.companiesallow,package.jobsallow
                    FROM #__js_job_paymenthistory AS payment
                    JOIN #__js_job_employerpackages AS package ON (package.id = payment.packageid AND payment.packagefor=1)
                    WHERE payment.uid = " . $uid . "
                    AND DATE_ADD(payment.created,INTERVAL package.packageexpireindays DAY) >= CURDATE()
                    AND payment.transactionverified = 1 AND payment.status = 1";
            $db->setQuery($query);
            $packagedetail = $db->loadObjectList();

            $results[12] = false;
            $results[13] = $packagedetail;

            $query = "SELECT package.resumeallow,package.coverlettersallow
                    FROM #__js_job_employerpackages AS package
                    JOIN #__js_job_paymenthistory AS payment ON (package.id = payment.packageid AND payment.packagefor=1)
                    WHERE payment.uid = " . $uid . "
                    AND payment.transactionverified = 1 AND payment.status = 1";
            $query = "SELECT package.id, package.companiesallow,package.jobsallow
                    FROM #__js_job_paymenthistory AS payment
                    JOIN #__js_job_employerpackages AS package ON (package.id = payment.packageid AND payment.packagefor=1)
                    WHERE payment.uid = " . $uid . "
                    AND DATE_ADD(payment.created,INTERVAL package.packageexpireindays DAY) >= CURDATE()
                    AND payment.transactionverified = 1 AND payment.status = 1";
            $db->setQuery($query);
            $packages = $db->loadObjectList();
        }
        $companiesunlimited = 0;
        $unlimitedjobs = 0;
        $unlimitedfeaturedcompaines = 0;
        $unlimitedgoldcompanies = 0;
        $unlimitedgoldjobs = 0;
        $unlimitedfeaturedjobs = 0;
        $jobsallow = 0;
        $companiesallow = 0;
        $goldcompaniesallow = 0;
        $goldjobsallow = 0;
        $featuredcompainesallow = 0;
        $featuredjobsallow = 0;
        if (!empty($packages)) {
            foreach ($packages AS $package) {
                if ($companiesunlimited == 0) {
                    if ($package->companiesallow != -1) {
                        $companiesallow = $companiesallow + $package->companiesallow;
                    } else
                        $companiesunlimited = 1;
                }
                if ($unlimitedjobs == 0) {
                    if ($package->jobsallow != -1) {
                        $jobsallow = $jobsallow + $package->jobsallow;
                    } else
                        $unlimitedjobs = 1;
                }
            }
        }

        //companies
        $query = "SELECT COUNT(company.id) FROM #__js_job_companies AS company WHERE  uid = " . $uid;
        $db->setQuery($query);
        $totalcompanies = $db->loadResult();

        //jobs
        $query = "SELECT COUNT(id) FROM #__js_job_jobs WHERE uid = " . $uid;
        $db->setQuery($query);
        $totaljobs = $db->loadResult();

        //publishedjob
        $query = "SELECT COUNT(id) FROM #__js_job_jobs WHERE uid = " . $uid . " AND stoppublishing > CURDATE() ";
        $db->setQuery($query);
        $publishedjob = $db->loadResult();

        //expiredjob
        $query = "SELECT COUNT(id) FROM #__js_job_jobs WHERE uid = " . $uid . " AND stoppublishing < CURDATE() ";
        $db->setQuery($query);
        $expiredjob = $db->loadResult();




        if ($companiesunlimited == 0)
            $results[0] = $companiesallow;
        elseif ($companiesunlimited == 1)
            $results[0] = -1;
        $results[1] = $totalcompanies;

        if ($unlimitedjobs == 0)
            $results[2] = $jobsallow;
        elseif ($unlimitedjobs == 1)
            $results[2] = -1;
        $results[3] = $totaljobs;
        $results[14] = $publishedjob;
        $results[15] = $expiredjob;

        $results[4] = 0;
        $results[4] = -1;
        $results[5] = 0;

        $results[6] = 0;
        $results[7] = 0;

        $results[8] = 0;
        $results[9] = 0;
        $results[16] = 0;
        $results[17] = 0;

        $results[10] = 0;
        $results[11] = 0;
        $results[18] = 0;
        $results[19] = 0;

        $results[20] = $ispackagerequired;
        $results[21] = 0;
        $results[22] = 0;
        return $results;
    }

    function getMultiSelectEdit($id, $for) {
        if (!is_numeric($id))
            return false;
        $db = JFactory::getDbo();
        $config = $this->getJSModel('configurations')->getConfigByFor('default');
        $query = "SELECT city.id AS id, concat(city.cityName";
        switch ($config['defaultaddressdisplaytype']) {
            case 'csc'://City, State, Country
                $query .= " ,', ', (IF(state.name is not null,state.name,'')),IF(state.name is not null,', ',''),country.name)";
                break;
            case 'cs'://City, State
                $query .= " ,', ', (IF(state.name is not null,state.name,'')))";
                break;
            case 'cc'://City, Country
                $query .= " ,', ', country.name)";
                break;
            case 'c'://city by default select for each case
                $query .= ")";
                break;
        }
        $query .= " AS name ";
        switch ($for) {
            case 1:
                $query .= " FROM `#__js_job_jobcities` AS mcity";
                break;
            case 2:
                $query .= " FROM `#__js_job_companycities` AS mcity";
                break;
        }
        $query .=" JOIN `#__js_job_cities` AS city on city.id=mcity.cityid
		  JOIN `#__js_job_countries` AS country on city.countryid=country.id
		  LEFT JOIN `#__js_job_states` AS state on city.stateid=state.id";
        switch ($for) {
            case 1:
                $query .= " WHERE mcity.jobid = $id AND country.enabled = 1 AND city.enabled = 1";
                break;
            case 2:
                $query .= " WHERE mcity.companyid = $id AND country.enabled = 1 AND city.enabled = 1";
                break;
            case 3:
                $query .= " WHERE mcity.alertid = $id AND country.enabled = 1 AND city.enabled = 1";
                break;
        }

        $db->setQuery($query);
        $result = $db->loadObjectList();
        $json_array = json_encode($result);
        if (empty($json_array))
            return null;
        else
            return $json_array;
    }

    function userCanRegisterAsEmployer() {
        $roleconfig = $this->getJSModel('configurations')->getConfigByFor('default');
        if ($roleconfig['showemployerlink'] == 1){
            return true;
        }else{
            return false;
        }
    }

}
?>
    
