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

class JSJobsModelJobSeeker extends JSModel {

    var $_uid = null;
    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() {
        parent::__construct();
        $this->_client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function getMyStats_JobSeeker($uid) {
        if (is_numeric($uid) == false)
            return false;
        if (($uid == 0) || ($uid == ''))
            return false;

        $db = $this->getDBO();
        $results = array();
        if (!isset($this->_config)) {
            $this->_config = $this->getJSModel('configurations')->getConfig('');
        }
        $ispackagerequired = 1;
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'js_newlisting_requiredpackage')
                $newlisting_required_package = $conf->configvalue;
        }
        if ($newlisting_required_package == 0) {
            $ispackagerequired = 0;
        }
        // resume
        $query = "SELECT package.resumeallow,package.coverlettersallow
                    FROM #__js_job_jobseekerpackages AS package
                    JOIN #__js_job_paymenthistory AS payment ON (package.id = payment.packageid AND payment.packagefor=2 )
                    WHERE payment.uid = " . $uid . "
                    AND DATE_ADD(payment.created,INTERVAL package.packageexpireindays DAY) >= CURDATE()
                    AND payment.transactionverified = 1 AND payment.status = 1";
        $db->setQuery($query);
        $packages = $db->loadObjectList();
        if (empty($packages)) {
            $query = "SELECT package.id, package.resumeallow,package.title AS packagetitle, package.packageexpireindays, payment.id AS paymentid
                        , (TO_DAYS( CURDATE() ) - To_days( payment.created ) ) AS packageexpiredays
                       FROM `#__js_job_jobseekerpackages` AS package
                       JOIN `#__js_job_paymenthistory` AS payment ON (payment.packageid = package.id AND payment.packagefor=2 )
                       WHERE payment.uid = " . $uid . " 
                       AND payment.transactionverified = 1 AND payment.status = 1 ORDER BY payment.created DESC";
            $db->setQuery($query);
            $packagedetail = $db->loadObjectList();

            $results[8] = false;
            $results[9] = $packagedetail;

            $query = "SELECT package.resumeallow,package.coverlettersallow
                    FROM #__js_job_jobseekerpackages AS package
                    JOIN #__js_job_paymenthistory AS payment ON (package.id = payment.packageid AND payment.packagefor=2)
                    WHERE payment.uid = " . $uid . "
                    AND payment.transactionverified = 1 AND payment.status = 1";
            $db->setQuery($query);
            $packages = $db->loadObjectList();
        }
        $unlimitedresume = 0;
        $unlimitedfeaturedresume = 0;
        $unlimitedgoldresume = 0;
        $unlimitedcoverletters = 0;
        $resumeallow = 0;
        $featuredresumeallow = 0;
        $goldresumeallow = 0;
        $coverlettersallow = 0;

        foreach ($packages AS $package) {
            if ($unlimitedresume == 0) {
                if ($package->resumeallow != -1) {
                    $resumeallow = $resumeallow + $package->resumeallow;
                } else
                    $unlimitedresume = 1;
            }
            if ($unlimitedcoverletters == 0) {
                if ($package->coverlettersallow != -1) {
                    $coverlettersallow = $coverlettersallow + $package->coverlettersallow;
                } else
                    $unlimitedcoverletters = 1;
            }
        }

        //resume
        $query = "SELECT COUNT(id) FROM #__js_job_resume WHERE  uid = " . $uid;
        $db->setQuery($query);
        $totalresume = $db->loadResult();

        //cover letter
        $query = "SELECT COUNT(id) FROM #__js_job_coverletters WHERE uid = " . $uid;
        $db->setQuery($query);
        $totalcoverletters = $db->loadResult();


        if ($unlimitedresume == 0)
            $results[0] = $resumeallow;
        elseif ($unlimitedresume == 1)
            $results[0] = -1;

        $results[1] = $totalresume;


        if ($unlimitedcoverletters == 0)
            $results[6] = $coverlettersallow;
        elseif ($unlimitedcoverletters == 1)
            $results[6] = -1;
        $results[7] = $totalcoverletters;
        $results[10] = $ispackagerequired;

        return $results;
    }

}
?>    
