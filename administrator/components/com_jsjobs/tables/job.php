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

class TableJob extends JTable {

    /** @var int Primary key */
    var $id = null;
    var $uid = null;
    var $companyid = null;
    var $jobid = null;
    var $title = null;
    var $alias = null;
    var $jobcategory = null;
    var $jobtype = null;
    var $jobstatus = null;
    var $jobsalaryrange = null;
    var $hidesalaryrange = 0;
    var $description = null;
    var $qualifications = null;
    var $prefferdskills = null;
    var $applyinfo = null;
    var $company = null;
    var $country = null;
    var $state = null;
    var $county = null;
    var $city = null;
    var $zipcode = null;
    var $address1 = null;
    var $address2 = null;
    var $companyurl = null;
    var $contactname = null;
    var $contactphone = null;
    var $contactemail = null;
    var $showcontact = null;
    var $noofjobs = null;
    var $reference = null;
    var $duration = null;
    var $heighestfinisheducation = null;
    var $created = null;
    var $created_by = null;
    var $modified = null;
    var $modified_by = null;
    var $hits = null;
    var $experience = null;
    var $startpublishing = null;
    var $stoppublishing = null;
    var $departmentid = null;
    var $shift = null;
    var $sendemail = 0;
    var $metadescription = null;
    var $metakeywords = null;
    var $ordering = null;
    var $status = null;
    var $educationminimax = null;
    var $educationid = null;
    var $mineducationrange = null;
    var $maxeducationrange = null;
    var $iseducationminimax = null;
    var $degreetitle = null;
    var $careerlevel = null;
    var $experienceminimax = null;
    var $experienceid = null;
    var $minexperiencerange = null;
    var $maxexperiencerange = null;
    var $isexperienceminimax = null;
    var $experiencetext = null;
    var $workpermit = null;
    var $requiredtravel = null;
    var $agefrom = null;
    var $ageto = null;
    var $salaryrangefrom = null;
    var $salaryrangeto = null;
    var $salaryrangetype = null;
    var $gender = null;
    var $agreement = null;
    var $video = null;
    var $map = null;
    var $packageid = null;
    var $paymenthistoryid = null;
    var $subcategoryid = null;
    var $currencyid = null;
    var $isgoldjob = 2;
    var $isfeaturedjob = 2;
    var $notifications = null;
    var $joblink = null;
    var $jobapplylink = 0;
    var $raf_gender = 0;
    var $raf_degreelevel = 0;
    var $raf_experience = 0;
    var $raf_age = 0;
    var $raf_education = 0;
    var $raf_category = 0;
    var $raf_subcategory = 0;
    var $raf_location = 0;
    var $params = null;
    

    function __construct(&$db) {
        parent::__construct('#__js_job_jobs', 'id', $db);
    }

    /**
     * Validation
     * 
     * @return boolean True if buffer is valid
     * 
     */
    /*
      function bind( $array, $ignore = '' )
      {
      if (key_exists( 'jobcategory', $array ) && is_array( $array['jobcategory'] )) {
      $array['jobcategory'] = implode( ',', $array['jobcategory'] );
      }
      return parent::bind( $array, $ignore );
      }
     */

    function check() {
        if (trim($this->title) == '') {
            $this->_error = JText::_("Title cannot be empty");
            return false;
        } elseif (trim($this->description) == '') {
            $this->_error = JText::_("Description cannot be empty");
            return false;
        }

        return true;
    }

}

?>
