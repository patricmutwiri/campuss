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

class JSJobsModelCountries extends JSModel {

    var $_uid = null;
    var $_client_auth_key = null;
    var $_siteurl = null;
    var $_countries = null;

    function __construct() {
        parent::__construct();
        $this->_client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function getJobsCountry($showonlycountryhavejobs = 0, $theme, $noofrecord = 20) {
        $db = $this->getDBO();
        $dateformat = $this->getJSModel('configurations')->getConfigValue('date_format');
        $this->getJSModel('common')->setTheme();
        $havingquery = '';
        if ($showonlycountryhavejobs == 1) {
            $havingquery = " HAVING totaljobsbycountry > 0 ";
        }

        $countryid = "country.id AS countryid,";
        $query = "SELECT $countryid country.name AS countryname,COUNT(DISTINCT job.id) AS totaljobsbycountry
                    FROM `#__js_job_countries` AS country
                    LEFT JOIN `#__js_job_cities` AS city ON country.id = city.countryid 
                    LEFT JOIN `#__js_job_jobcities` AS mcity ON mcity.cityid = city.id
                    LEFT JOIN `#__js_job_jobs` AS job ON (job.id = mcity.jobid AND job.status =1 AND job.stoppublishing>=CURDATE() )
                    WHERE country.enabled = 1 
                    GROUP BY countryname $havingquery ORDER BY totaljobsbycountry DESC, countryname ASC ";
        $db->setQuery($query, 0, $noofrecord);
        $result[0] = $db->loadObjectList();
        $result[2] = $dateformat;
        return $result;
    }

    function getCountries($title) {
        if (!$this->_countries) {
            $db = JFactory::getDBO();
            $query = "SELECT id,name FROM `#__js_job_countries` WHERE enabled = 1";
            if ($this->_client_auth_key != "")
                $query.=" AND serverid!='' AND serverid!=0";
            $query.=" ORDER BY name ASC ";
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            if ($db->getErrorNum()) {
                echo $db->stderr();
                return false;
            }
            $this->_countries = $rows;
        }
        $countries = array();
        if ($title)
            $countries[] = array('value' => JText::_(''), 'text' => $title);
        foreach ($this->_countries as $row) {
            $countries[] = array('value' => $row->id, 'text' => JText::_($row->name));
        }
        return $countries;
    }

    function getCountryIdByName($name) { // new function coded
        $db = JFactory::getDBO();
        $query = "SELECT id FROM `#__js_job_countries` WHERE REPLACE(LOWER(name), ' ', '') = REPLACE(LOWER(" . $db->Quote($name) . "), ' ', '') AND enabled = 1";
        $db->setQuery($query);
        $countryid = $db->loadResult();
        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }
        return $countryid;
    }
}
?>