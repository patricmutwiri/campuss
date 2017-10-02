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

class JSJobsModelResume extends JSModel {

    var $_config = null;
    var $_defaultcurrency = null;
    var $_client_auth_key = null;
    var $_siteurl = null;
    var $_empoptions = null;
    var $_application = null;

    function __construct() {
        parent::__construct();
        $this->_client_auth_key = $this->getJSModel('jobsharing')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $this->_defaultcurrency = $this->getJSModel('currency')->getDefaultCurrency();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }
    function getResumeViewbyId($id) {
        if (is_numeric($id) == false)
            return false;
        $db = $this->getDBO();
        $query = "SELECT app.id
                , reference_city.name AS reference_city2 , reference_state.name AS reference_state2 , reference_country.name AS reference_country
                , reference1_city.name AS reference1_city2 , reference1_state.name AS reference1_state2 , reference1_country.name AS reference1_country
                , reference2_city.name AS reference2_city2 , reference2_state.name AS reference2_state2 , reference2_country.name AS reference2_country
                , reference3_city.name AS reference3_city2 , reference3_state.name AS reference3_state2 , reference3_country.name AS reference3_country

                FROM `#__js_job_resume` AS app
                LEFT JOIN `#__js_job_cities` AS reference_city ON app.reference_city = reference_city.id
                LEFT JOIN `#__js_job_states` AS reference_state ON reference_city.stateid = reference_state.id
                LEFT JOIN `#__js_job_countries` AS reference_country ON reference_city.countryid = reference_country.id
                LEFT JOIN `#__js_job_cities` AS reference1_city ON app.reference1_city = reference1_city.id
                LEFT JOIN `#__js_job_states` AS reference1_state ON reference1_city.stateid = reference1_state.id
                LEFT JOIN `#__js_job_countries` AS reference1_country ON reference1_city.countryid = reference1_country.id
                LEFT JOIN `#__js_job_cities` AS reference2_city ON app.reference2_city = reference2_city.id
                LEFT JOIN `#__js_job_states` AS reference2_state ON reference2_city.stateid = reference2_state.id
                LEFT JOIN `#__js_job_countries` AS reference2_country ON reference2_city.countryid = reference2_country.id
                LEFT JOIN `#__js_job_cities` AS reference3_city ON app.reference3_city = reference3_city.id
                LEFT JOIN `#__js_job_states` AS reference3_state ON reference3_city.stateid = reference3_state.id
                LEFT JOIN `#__js_job_countries` AS reference3_country ON reference3_city.countryid = reference3_country.id

                WHERE app.id = " . $id;
        $db->setQuery($query);
        $resume = $db->loadObject();
        return $resume;
    }


    function getEmpAppbyId($c_id) {
        if (is_numeric($c_id) == false)
            return false;
        $db = JFactory::getDBO();
        $query = "SELECT * FROM #__js_job_resume WHERE id = " . $c_id;

        $db->setQuery($query);
        $this->_application = $db->loadObject();

        $result[0] = $this->_application;
        $result[2] = $this->getJSModel('fieldordering')->getFieldsOrderingforView(3); // job fields , ref id
        //$result[3] = $this->getJSModel('fieldordering')->getFieldsOrderingforForm(3); // resume fields
        return $result;
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
        $canview = 1;

        if ($canview == 1) {

            $query = "UPDATE `#__js_job_jobapply` SET resumeview = 1 WHERE jobid = " . $jobid . " AND cvid = " . $resumeid;
            $db->setQuery($query);
            $db->query();

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

            $db->setQuery($query);
            $resume = $db->loadObject();

            $fieldsordering = $this->getJSModel('fieldordering')->getFieldsOrderingforForm(3); // resume fields ordering
            if (isset($resume)) {
                $trclass = array('row0', 'row1');
                $i = 0; // for odd and even rows
                $return_value = "<div id='js_job_app_actions'>\n";
                $return_value .= "<img src='components/com_jsjobs/include/images/act_no.png' onclick='closethisactiondiv2();' class='image_close'>";
                foreach ($fieldsordering AS $field) {
                    switch ($field->field) {
                        case 'heighesteducation':
                            if ($field->published == 1) {
                                $return_value .= "<div id='resumedetail_data' class='js-col-xs-12 js-col-md-6'>\n";
                                $return_value .= "<span id='resumedetail_data_title' >" . JText::_('Education') . "</span>\n";
                                $return_value .= "<span id='resumedetail_data_value' >" . $resume->educationtitle . "</span>\n";
                                $return_value .= "</div>\n";
                            }
                            break;
                        case 'institute_institute':
                            if ($field->published == 1) {
                                $return_value .= "<div id='resumedetail_data' class='js-col-xs-12 js-col-md-6'>\n";
                                $return_value .= "<span id='resumedetail_data_title' >" . JText::_('Institute') . "</span>\n";
                                $return_value .= "<span id='resumedetail_data_value' >" . $resume->institute . "</span>\n";
                                $return_value .= "</div>\n";
                            }
                            break;
                        case 'institute_study_area':
                            if ($field->published == 1) {
                                $return_value .= "<div id='resumedetail_data' class='js-col-xs-12 js-col-md-6'>\n";
                                $return_value .= "<span id='resumedetail_data_title' >" . JText::_('Study Area') . "</span>\n";
                                $return_value .= "<span id='resumedetail_data_value' >" . $resume->institute_study_area . "</span>\n";
                                $return_value .= "</div>\n";
                            }
                            break;
                        case 'totalexperience':
                            if ($field->published == 1) {
                                $return_value .= "<div id='resumedetail_data' class='js-col-xs-12 js-col-md-6'>\n";
                                $return_value .= "<span id='resumedetail_data_title' >" . JText::_('Experience') . "</span>\n";
                                $return_value .= "<span id='resumedetail_data_value' >" . $resume->total_experience . "</span>\n";
                                $return_value .= "</div>\n";
                            }
                            break;
                        case 'Iamavailable':
                            if ($field->published == 1) {
                                $return_value .= "<div id='resumedetail_data' class='js-col-xs-12 js-col-md-6'>\n";
                                $return_value .= "<span id='resumedetail_data_title' >" . JText::_('I Am Available') . "</span>\n";
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
                                $return_value .= "<span id='resumedetail_data_title' >" . JText::_('Current Salary') . "</span>\n";
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




    function getAllEmpApps($datafor, $resumetitle, $resumename, $resumecategory, $resumetype, $desiredsalary, $location, $dateto, $datefrom, $status, $isgfcombo, $sortby, $js_sortby, $limitstart, $limit) {
        
        if($js_sortby==1){
            $sortby = " resume.application_title $sortby "; 
        }elseif($js_sortby==2){
            $sortby = " resume.first_name $sortby ";
        }elseif($js_sortby==3){
            $sortby = " cat.cat_title $sortby ";
        }elseif($js_sortby==4){
            $sortby = " jobtype.title $sortby ";
        }elseif($js_sortby==5){
            $sortby = " city.cityname $sortby "; //Location
        }elseif($js_sortby==6){
            $sortby = " resume.status $sortby ";
        }elseif($js_sortby==7){
            $sortby = " resume.created $sortby ";
        }elseif($js_sortby==8){
            $sortby = " resume.hits $sortby ";
        }else{
            $sortby = " resume.created DESC ";
        }

        /*
            $isgfcombo
            1 - for gold
            2 - for featured
            3 - for gold & featured
            4 - for all
        */
        $db = JFactory::getDBO();
        if($datafor==1){ // 1 for resumes, 2 for resumes queue
            $status_opr = (is_numeric($status)) ? ' = '.$status : ' <> 0 ';
            $fquery = " WHERE resume.status".$status_opr;
            switch ($isgfcombo) {
                case '1':
                    $fquery .= " AND resume.isgoldresume = 1  AND DATE(resume.endgolddate) >= CURDATE()";
                break;
                case '2':
                    $fquery .= " AND resume.isfeaturedresume = 1  AND DATE(resume.endfeaturedate) >= CURDATE()";
                break;
                case '3':
                    $fquery .= " AND resume.isgoldresume = 1 AND resume.isfeaturedresume = 1  AND DATE(resume.endgolddate) >= CURDATE() AND DATE(resume.endfeaturedate) >= CURDATE() ";
                break;
                case '4':
                    // get all
                break;
            }
        }else{ // For resumes Queue
            switch ($isgfcombo) {
                case '1':
                    $fquery = " WHERE resume.isgoldresume = 0 ";
                break;
                case '2':
                    $fquery = " WHERE resume.isfeaturedresume = 0 ";
                break;
                case '3':
                    $fquery = " WHERE (resume.isgoldresume = 0 AND resume.isfeaturedresume = 0 ) ";
                break;
                case '4':
                    $fquery = " WHERE (resume.status = 0 OR resume.isgoldresume = 0 OR resume.isfeaturedresume = 0 ) ";
                break;
                default:
                    $fquery = " WHERE (resume.status = 0 OR resume.isgoldresume = 0 OR resume.isfeaturedresume = 0 ) ";
                break;
            }
        }

        if($resumetitle)
            $fquery .= " AND LOWER(resume.application_title) LIKE ".$db->Quote('%'.$resumetitle.'%');
        if($resumename){
            $fquery .= " AND (";
            $fquery .= " LOWER(resume.first_name) LIKE " . $db->Quote('%' . $resumename . '%');
            $fquery .= " OR LOWER(resume.last_name) LIKE " . $db->Quote('%' . $resumename . '%');
            $fquery .= " OR LOWER(resume.middle_name) LIKE " . $db->Quote('%' . $resumename . '%');
            $fquery .= " )";
        }
        if($location)
            $fquery .= " AND LOWER(city.cityName) LIKE ".$db->Quote('%'.$location.'%');
        if ($resumecategory){
            if(is_numeric($resumecategory))
                $fquery .= " AND resume.job_category = ".$resumecategory;
        }
        if ($resumetype){
            if(is_numeric($resumetype))
                $fquery .= " AND resume.jobtype = ".$resumetype;
        }
        if ($desiredsalary){
            if(is_numeric($desiredsalary))
                $fquery .= " AND resume.desired_salary = ".$desiredsalary;
        }

        if($dateto !='' AND $datefrom !=''){
            $fquery .= " AND DATE(resume.created) <= ".$db->Quote(date('Y-m-d' , strtotime($dateto)))." AND DATE(resume.created) >= ".$db->Quote(date('Y-m-d' , strtotime($datefrom)));
        }else{
            if($dateto)
                $fquery .= " AND DATE(resume.created) <= ".$db->Quote(date('Y-m-d' , strtotime($dateto)));
            if($datefrom)
                $fquery .= " AND DATE(resume.created) >= ".$db->Quote(date('Y-m-d' , strtotime($datefrom)));
        }

        $lists = array();
        $lists['resumetitle'] = $resumetitle;
        $lists['resumename'] = $resumename;
        $lists['resumecategory'] = JHTML::_('select.genericList', $this->getJSModel('category')->getCategories(JText::_('Select Category'), ''), 'resumecategory', 'class="inputbox" '. '', 'value', 'text', $resumecategory);
        $lists['resumetype'] = JHTML::_('select.genericList',array(0 => array('value' => '', 'text' => JText::_('Select Job Type')), 1 => array('value' => 1 , 'text' => JText::_('Full-time')), 2 => array('value' => 2 , 'text' => JText::_('Part-time')), 3 => array('value' => 3 , 'text' => JText::_('Internship'))),'resumetype', 'class="inputbox" ', 'value', 'text', $resumetype);
        $lists['desiredsalary'] = JHTML::_('select.genericList', $this->getJSModel('salaryrange')->getJobSalaryRange(JText::_('Select Salary Range'), ''), 'desiredsalary', 'class="inputbox" ', 'value', 'text', $desiredsalary);
        $lists['location'] = $location;
        $lists['dateto'] = $dateto;
        $lists['datefrom'] = $datefrom;
        if($datafor==1)
            $lists['status'] = JHTML::_('select.genericList', $this->getJSModel('common')->getApprove(JText::_('Select Status'),'') , 'status', 'class="inputbox" ' , 'value', 'text', $status);
        else
            $lists['status'] = $status;

        $result = array();
        $query = "SELECT COUNT(resume.id)
                    FROM #__js_job_resume AS resume
                    LEFT JOIN #__js_job_categories AS cat ON resume.job_category = cat.id
                    LEFT JOIN #__js_job_jobtypes AS jobtype ON resume.jobtype = jobtype.id
                    LEFT JOIN #__js_job_salaryrange AS dsalary ON resume.desired_salary = dsalary.id
                    LEFT JOIN `#__js_job_cities` AS city ON city.id = (SELECT address_city FROM `#__js_job_resumeaddresses` WHERE resumeid = resume.id ORDER BY id DESC LIMIT 1) ";
                
        $query .= $fquery;                
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = "SELECT resume.id, resume.application_title,resume.first_name, resume.last_name, resume.jobtype,resume.photo,
                resume.jobsalaryrange, resume.created, resume.status, cat.cat_title, dsalary.rangestart, dsalary.rangeend , dcurrency.symbol ,dsalaryrangetype.title AS srangetypetitle,
                jobtype.title AS jobtypetitle,resume.isgoldresume,resume.isfeaturedresume, resume.startgolddate, resume.startfeatureddate, resume.endgolddate, resume.endfeaturedate,
                city.id AS resumecity
            FROM #__js_job_resume AS resume
            LEFT JOIN #__js_job_categories AS cat ON resume.job_category = cat.id
            LEFT JOIN #__js_job_jobtypes AS jobtype ON resume.jobtype = jobtype.id
            LEFT JOIN #__js_job_salaryrange AS dsalary ON resume.desired_salary = dsalary.id
            LEFT JOIN #__js_job_salaryrangetypes AS dsalaryrangetype ON resume.djobsalaryrangetype = dsalaryrangetype.id
            LEFT JOIN #__js_job_currencies AS dcurrency ON dcurrency.id = resume.dcurrencyid
            LEFT JOIN `#__js_job_cities` AS city ON city.id = (SELECT address_city FROM `#__js_job_resumeaddresses` WHERE resumeid = resume.id ORDER BY id DESC LIMIT 1) ";
        $query .=$fquery;
        $query .= " GROUP BY resume.id ORDER BY $sortby ";
        
        $db->setQuery($query, $limitstart, $limit);
        $this->_application = $db->loadObjectList();

        $resumes = array();
        foreach ($this->_application as $d) {
            $d->location = $this->getJSModel('city')->getLocationDataForView($d->resumecity);
            $d->salary = $this->getJSModel('common')->getSalaryRangeView($d->symbol,$d->rangestart,$d->rangeend,JText::_($d->srangetypetitle));
            $resumes[] = $d;
        }

        $this->_application = $resumes;

        $result[0] = $this->_application;
        $result[1] = $total;
        $result[2] = $lists;
        return $result;
    }

    function storeResume() {
        $row = $this->getTable('resume');
        $data = JRequest::get('post');
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);  // Sanitize entire array to string
        if (!$this->_config)
            $this->_config = $this->getJSModel('configuration')->getConfig('');
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'date_format')
                $dateformat = $conf->configvalue;
        }
        if ($dateformat == 'm/d/Y') {
            $arr = explode('/', $data['date_start']);
            $data['date_start'] = $arr[2] . '/' . $arr[0] . '/' . $arr[1];
            $arr = explode('/', $data['date_of_birth']);
            $data['date_of_birth'] = $arr[2] . '/' . $arr[0] . '/' . $arr[1];
        } elseif ($dateformat == 'd-m-Y') {
            $arr = explode('-', $data['date_start']);
            $data['date_start'] = $arr[2] . '-' . $arr[1] . '-' . $arr[0];
            $arr = explode('-', $data['date_of_birth']);
            $data['date_of_birth'] = $arr[2] . '-' . $arr[1] . '-' . $arr[0];
        }
        $data['date_start'] = date('Y-m-d H:i:s', strtotime($data['date_start']));
        $data['date_of_birth'] = date('Y-m-d H:i:s', strtotime($data['date_of_birth']));
        $data['resume'] = $this->getJSModel('common')->getHtmlInput('resume');
        if (isset($data['deleteresumefile']) && ($data['deleteresumefile'] == 1)) {
            $data['filename'] = '';
            $data['filecontent'] = '';
        }
        if (isset($data['deletephoto']) && ($data['deletephoto'] == 1)) {
            $data['photo'] = '';
        }
        if (!empty($data['alias']))
            $resumealias = $this->getJSModel('common')->removeSpecialCharacter($data['alias']);
        else
            $resumealias = $this->getJSModel('common')->removeSpecialCharacter($data['application_title']);

        $resumealias = strtolower(str_replace(' ', '-', $resumealias));
        $data['alias'] = $resumealias;

        if (!$row->bind($data)) {
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
        $filemismatch = 0;
        $resumereturnvalue = $this->uploadResume($row->id);
        if (empty($resumereturnvalue) OR $resumereturnvalue == 6) {
            if ($returnvalue == 6)
                $filemismatch = 1;;
        }else {
            $upload_resume_file_real_path = $resumereturnvalue;
        }
        $returnvalue = $this->uploadPhoto($row->id);
        $photomismatch = 0;
        if (empty($returnvalue) OR $returnvalue == 6) {
            if ($returnvalue == 6)
                $photomismatch = 1;
        }else {
            $upload_pic_real_path = $returnvalue;
        }
        if ($this->_client_auth_key != "") {
            $resume_picture = array();
            $resume_file = array();

            $db = $this->getDBO();
            $query = "SELECT resume.* FROM `#__js_job_resume` AS resume  
                        WHERE resume.id = " . $row->id;

            $db->setQuery($query);
            $data_resume = $db->loadObject();
            if ($resumedata['id'] != "" AND $resumedata['id'] != 0)
                $data_resume->id = $resumedata['id']; // for edit case
            if ($_FILES['photo']['size'] > 0)
                $resume_picture['picfilename'] = $upload_pic_real_path;
            if ($_FILES['resumefile']['size'] > 0)
                $resume_file['resume_file'] = $upload_resume_file_real_path;

            $data_resume->resume_id = $row->id;
            $data_resume->authkey = $this->_client_auth_key;
            $data_resume->task = 'storeresume';
            $jsjobsharingobject = $this->getJSModel('jobsharing');
            $jsjobslogobject = $this->getJSModel('log');
            $return_value = $jsjobsharingobject->storeResumeSharing($data_resume);
            if ($return_value['isresumestore'] == 0)
                $jsjobslogobject->logStoreResumeSharing($return_value);
            $status_resume_pic = "";
            if ($photomismatch != 1) {
                if ($_FILES['photo']['size'] > 0)
                    $return_value_resume_pic = $jsjobsharingobject->storeResumePicSharing($data_resume, $resume_picture);
                if (isset($return_value_resume_pic)) {
                    if ($return_value_resume_pic['isresumestore'] == 0 OR $return_value_resume_pic == false)
                        $status_resume_pic = -1;
                    else
                        $status_resume_pic = 1;
                }
            }

            $status_resume_file = "";
            if ($filemismatch != 1) {
                if ($_FILES['resumefile']['size'] > 0)
                    $return_value_resume_file = $jsjobsharingobject->storeResumeFileSharing($data_resume, $resume_file);
                if (isset($return_value_resume_file)) {
                    if ($return_value_resume_file['isresumestore'] == 0 OR $return_value_resume_file == false)
                        $status_resume_file = -1;
                    else
                        $status_resume_file = 1;
                }
            }
            if (($status_resume_pic == -1 AND $status_resume_file == -1) OR ( $filemismatch == 1 AND $photomismatch == 1)) {
                $return_value['message'] = "Resume saved but error in uploading resume file and picture";
            } elseif (($status_resume_pic == -1) OR ( $photomismatch == 1)) {
                $return_value['message'] = "Resume saved but error in uploading picture";
            } elseif (($status_resume_file == -1) OR ( $filemismatch == 1)) {
                $return_value['message'] = "Resume saved but error in uploading file";
            }
            $jsjobslogobject->logStoreResumeSharing($return_value);
        }

        if (($filemismatch == 1) OR ( $photomismatch == 1))
            return 6;
        return true;
    }

    function uploadResume($id) {
        if (is_numeric($id) == false)
            return false;
        $row = $this->getTable('resume');
        global $resumedata;
        $db = JFactory::getDBO();
        $str = JPATH_BASE;
        $base = substr($str, 0, strlen($str) - 14); //remove administrator
        $resumequery = "SELECT * FROM `#__js_job_resume` WHERE uid = " . $db->Quote($u_id);
        $iddir = 'resume_' . $id;
        if (!isset($this->_config))
            $this->_config = $this->getJSModel('configuration')->getConfig();
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'data_directory')
                $datadirectory = $conf->configvalue;
            if ($conf->configname == 'document_file_type')
                $document_file_types = $conf->configvalue;
        }
        $path = $base . '/' . $datadirectory;

        if ($_FILES['resumefile']['size'] > 0) {
            $file_name = $_FILES['resumefile']['name']; // file name
            $file_tmp = $_FILES['resumefile']['tmp_name']; // actual location
            $file_size = $_FILES['resumefile']['size']; // file size
            $file_type = $_FILES['resumefile']['type']; // mime type of file determined by php
            $file_error = $_FILES['resumefile']['error']; // any error!. get reason here

            if (!empty($file_tmp)) { // only MS office and text file is accepted.
                $check_document_extension = $this->getJSModel('common')->checkDocumentFileExtensions($file_name, $file_tmp, $document_file_types);
                if ($check_document_extension == 6) {
                    $row->load($id);
                    $row->filename = "";
                    $row->filetype = "";
                    $row->filesize = "";
                    if (!$row->store()) {
                        $this->setError($this->_db->getErrorMsg());
                    }
                    return $check_document_extension;
                } else {
                    $row->load($id);
                    $row->filename = filter_var($file_name,FILTER_SANITIZE_STRING);
                    $row->filetype = filter_var($file_type,FILTER_SANITIZE_STRING);
                    $row->filesize = $file_size;
                    if (!$row->store()) {
                        $this->setError($this->_db->getErrorMsg());
                    }
                }

                if (!file_exists($path)) { // creating main directory
                    $this->getJSModel('common')->makeDir($path);
                }
                $path = $path . '/data';
                if (!file_exists($path)) { // creating data directory
                    $this->getJSModel('common')->makeDir($path);
                }
                $path = $path . '/jobseeker';
                if (!file_exists($path)) { // creating jobseeker directory
                    $this->getJSModel('common')->makeDir($path);
                }
                $userpath = $path . '/' . $iddir;
                if (!file_exists($userpath)) { // create user directory
                    $this->getJSModel('common')->makeDir($userpath);
                }
                $userpath = $path . '/' . $iddir . '/resume';
                if (!file_exists($userpath)) { // create user directory
                    $this->getJSModel('common')->makeDir($userpath);
                }
                $files = glob($userpath . '/*.*');
                array_map('unlink', $files);  //delete all file in user directory

                move_uploaded_file($file_tmp, $userpath . '/' . $file_name);
                return $userpath . '/' . $file_name;
                return 1;
            } else {
                if ($resumedata['deleteresumefile'] == 1) {
                    $path = $path . '/data/jobseeker';
                    $userpath = $path . '/' . $iddir . '/resume';
                    $files = glob($userpath . '/*.*');
                    array_map('unlink', $files);
                    $row->load($id);
                    $row->filename = "";
                    $row->filetype = "";
                    $row->filesize = "";
                    if (!$row->store()) {
                        $this->setError($this->_db->getErrorMsg());
                    }
                } else {
                    
                }
                return 1;
            }
        }
    }

    function uploadPhoto($id) {
        if (is_numeric($id) == false)
            return false;
        $row = $this->getTable('resume');
        global $resumedata;
        $db = JFactory::getDBO();
        $str = JPATH_BASE;
        $base = substr($str, 0, strlen($str) - 14); //remove administrator
        if (!isset($this->_config))
            $this->_config = $this->getJSModel('configuration')->getConfig();
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'data_directory')
                $datadirectory = $conf->configvalue;
            if ($conf->configname == 'image_file_type')
                $image_file_types = $conf->configvalue;
        }
        $path = $base . '/' . $datadirectory;

        $resumequery = "SELECT * FROM `#__js_job_resume` WHERE uid = " . $db->Quote($u_id);
        $iddir = 'resume_' . $id;
        if ($_FILES['photo']['size'] > 0) {
            $file_name = $_FILES['photo']['name']; // file name
            $file_tmp = $_FILES['photo']['tmp_name']; // actual location
            $file_size = $_FILES['photo']['size']; // file size
            $file_type = $_FILES['photo']['type']; // mime type of file determined by php
            $file_error = $_FILES['photo']['error']; // any error!. get reason here
            if (!empty($file_tmp)) {
                $check_image_extension = $this->getJSModel('common')->checkImageFileExtensions($file_name, $file_tmp, $image_file_types);
                if ($check_image_extension == 6) {
                    $row->load($id);
                    $row->photo = "";
                    if (!$row->store()) {
                        $this->setError($this->_db->getErrorMsg());
                    }
                    return $check_image_extension;
                } else {
                    $row->load($id);
                    $row->photo = filter_var($file_name,FILTER_SANITIZE_STRING);
                    if (!$row->store()) {
                        $this->setError($this->_db->getErrorMsg());
                    }
                }
            }

            if (!file_exists($path)) { // creating main directory
                $this->getJSModel('common')->makeDir($path);
            }
            $path = $path . '/data';
            if (!file_exists($path)) { // creating data directory
                $this->getJSModel('common')->makeDir($path);
            }
            $path = $path . '/jobseeker';
            if (!file_exists($path)) { // creating jobseeker directory
                $this->getJSModel('common')->makeDir($path);
            }
            $userpath = $path . '/' . $iddir;
            if (!file_exists($userpath)) { // create user directory
                $this->getJSModel('common')->makeDir($userpath);
            }
            $userpath = $path . '/' . $iddir . '/photo';
            if (!file_exists($userpath)) { // create user directory
                $this->getJSModel('common')->makeDir($userpath);
            }
            $files = glob($userpath . '/*.*');
            array_map('unlink', $files);  //delete all file in user directory

            move_uploaded_file($file_tmp, $userpath . '/' . $file_name);

            $ext = $this->getJSModel('common')->getExtension($file_name);
            $ext = strtolower($ext);

            $imagetypes = array(
                'ani','bmp','cal','fax','gif','img','jbg','jpe','jpeg','jpg','mac','pbm','pcd','pcx','pct','pgm','png','ppm','psd','ras','tga','tiff','wmf','tif'
            );        
                /*
            if(in_array($ext,$imagetypes)){
                $mimetype = mime_content_type($userpath . '/' . $file_name);
                $flag = false;
                foreach($imagetypes AS $type){
                    if($mimetype == "image/$type"){
                        $flag = true;
                    }
                }
                if($flag == false){
                    @unlink($userpath.'/'.$file_name);
                    $query = "UPDATE `#__js_job_resume` SET photo = '' WHERE id = ".$id;
                    $db = JFactory::getDBO();
                    $db->setQuery($query);
                    $db->query();
                }
            }
                */


            return $userpath . '/' . $file_name;
            return 1;
        } else {
            if ($resumedata['deleteresumefile'] == 1) {
                $path = $path . '/data/jobseeker';
                $userpath = $path . '/' . $iddir . '/photo';
                $files = glob($userpath . '/*.*');
                array_map('unlink', $files);
                $row->load($id);
                $row->photo = "";
                if (!$row->store()) {
                    $this->setError($this->_db->getErrorMsg());
                }
            } else {
                
            }
            return 1;
        }
    }

    function deleteResume() {
        $db = $this->getDBO();
        $cids = JRequest::getVar('cid', array(0), '', 'array');
        $row = $this->getTable('resume');
        $deleteall = 1;
        foreach ($cids as $cid) {
            $juid = 0; // jobseeker uid
            $serverresumeid = 0;
            if ($this->_client_auth_key != "") {
                $query = "SELECT resume.serverid AS id,resume.uid AS uid FROM `#__js_job_resume` AS resume WHERE resume.id = " . $cid;
                $db->setQuery($query);
                $data = $db->loadObject();
                $serverresumeid = $data->id;
                $juid = $data->uid;
            }
            if ($this->resumeCanDelete($cid) == true) {
                $query = "SELECT app.application_title, app.first_name, app.middle_name, app.last_name, app.email_address,CONCAT(app.alias,'-',app.id) AS aliasid 
                            FROM `#__js_job_resume` AS app
                            WHERE app.id = " . $cid;

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

                if (!$row->delete($cid)) {
                    $this->setError($row->getErrorMsg());
                    return false;
                }else{ // resume has been deleted so we delete record from their child tables
                    $db = JFactory::getDBO();
                    $query = "DELETE * FROM `#__js_job_resumeaddresses` WHERE resumeid = ".$cid;
                    $db->setQuery($query);$db->query();
                    $query = "DELETE * FROM `#__js_job_resumeemployers` WHERE resumeid = ".$cid;
                    $db->setQuery($query);$db->query();
                    $query = "DELETE * FROM `#__js_job_resumeinstitutes` WHERE resumeid = ".$cid;
                    $db->setQuery($query);$db->query();
                    $query = "DELETE * FROM `#__js_job_resumelanguages` WHERE resumeid = ".$cid;
                    $db->setQuery($query);$db->query();
                    $query = "DELETE * FROM `#__js_job_resumereferences` WHERE resumeid = ".$cid;
                    $db->setQuery($query);$db->query();
                }
                $this->getJSModel('emailtemplate')->sendDeleteMail( $cid , 3);
                if ($serverresumeid != 0) {
                    $data = array();
                    $data['id'] = $serverresumeid;
                    $data['referenceid'] = $cid;
                    $data['uid'] = $juid;
                    $data['authkey'] = $this->_client_auth_key;
                    $data['siteurl'] = $this->_siteurl;
                    $data['task'] = 'deleteresume';
                    $jsjobsharingobject = $this->getJSModel('jobsharing');
                    $return_value = $jsjobsharingobject->deleteResumeSharing($data);
                    $jsjobslogobject = $this->getJSModel('log');
                    $jsjobslogobject->logDeleteResumeSharing($return_value);
                }
            } else
                $deleteall++;
        }
        return $deleteall;
    }

    function deleteEmpApp() {
        $cids = JRequest::getVar('cid', array(0), 'post', 'array');
        $row = $this->getTable('empapp');

        foreach ($cids as $cid) {
            if (!$row->delete($cid)) {
                $this->setError($row->getErrorMsg());
                return false;
            }
        }

        return true;
    }

    function resumeCanDelete($resumeid) {
        if (is_numeric($resumeid) == false)
            return false;
        $db = $this->getDBO();
        $query = "SELECT
                    ( SELECT COUNT(id) FROM `#__js_job_jobapply` WHERE cvid = " . $resumeid . ")
                    AS total ";
        $db->setQuery($query);
        $total = $db->loadResult();

        if ($total > 0)
            return false;
        else
            return true;
    }

    function resumeEnforceDelete($resumeid, $uid) {
        if ($uid)
            if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
                return false;
        if (is_numeric($resumeid) == false)
            return false;
        $db = $this->getDBO();
        $juid = 0; // jobseeker uid
        $serverresumeid = 0;
        if ($this->_client_auth_key != "") {
            $query = "SELECT resume.serverid AS id,resume.uid AS uid FROM `#__js_job_resume` AS resume WHERE resume.id = " . $resumeid;
            $db->setQuery($query);
            $data = $db->loadObject();
            $serverresumeid = $data->id;
            $juid = $data->uid;
        }
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


        $query = "DELETE  resume,apply,address,emp,inst,lang,ref
                    FROM `#__js_job_resume` AS resume
                    LEFT JOIN `#__js_job_jobapply` AS apply ON resume.id=apply.cvid
                    LEFT JOIN `#__js_job_resumeaddresses` AS address ON resume.id = address.resumeid
                    LEFT JOIN `#__js_job_resumeemployers` AS emp ON resume.id = emp.resumeid
                    LEFT JOIN `#__js_job_resumeinstitutes` AS inst ON resume.id = inst.resumeid
                    LEFT JOIN `#__js_job_resumelanguages` AS lang ON resume.id = lang.resumeid
                    LEFT JOIN `#__js_job_resumereferences` AS ref ON resume.id = ref.resumeid
                    WHERE resume.id = " . $resumeid;

        $db->setQuery($query);
        if (!$db->query()) {
            return 2; //error while delete resume
        }
        $this->getJSModel('emailtemplate')->sendDeleteMail( $resumeid , 3);
        if ($serverresumeid != 0) {
            $data = array();
            $data['id'] = $serverresumeid;
            $data['referenceid'] = $cid;
            $data['uid'] = $juid;
            $data['authkey'] = $this->_client_auth_key;
            $data['siteurl'] = $this->_siteurl;
            $data['enforcedeleteresume'] = 1;
            $data['task'] = 'deleteresume';
            $jsjobsharingobject = $this->getJSModel('jobsharing');
            $return_value = $jsjobsharingobject->deleteResumeSharing($data);
            $jsjobslogobject = $this->getJSModel('log');
            $jsjobslogobject->logDeleteResumeSharingEnforce($return_value);
        }
        return 1;
    }


    function empappApprove($app_id) {
        if (is_numeric($app_id) == false)
            return false;
        $db = JFactory::getDBO();

        $query = "UPDATE #__js_job_resume SET status = 1 WHERE id = " . $db->Quote($app_id);
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        $this->getJSModel('emailtemplate')->sendMail(3, 1, $app_id);
        if ($this->_client_auth_key != "") {
            $data_resume_approve = array();
            $query = "SELECT serverid FROM #__js_job_resume WHERE id = " . $app_id;
            $db->setQuery($query);
            $serverresumeid = $db->loadResult();
            $data_resume_approve['id'] = $serverresumeid;
            $data_resume_approve['resume_id'] = $app_id;
            $data_resume_approve['authkey'] = $this->_client_auth_key;
            $fortask = "resumeapprove";
            $server_json_data_array = json_encode($data_resume_approve);
            $jsjobsharingobject = $this->getJSModel('jobsharing');
            $return_server_value = $jsjobsharingobject->serverTask($server_json_data_array, $fortask);
            $return_value = json_decode($return_server_value, true);
            $jsjobslogobject = $this->getJSModel('log');
            $jsjobslogobject->logEmpappApprove($return_value);
        }
        return true;
    }

    function empappReject($app_id) {
        if (is_numeric($app_id) == false)
            return false;
        $db = JFactory::getDBO();

        $query = "UPDATE #__js_job_resume SET status = -1 WHERE id = " . $db->Quote($app_id);
        $db->setQuery($query);
        if (!$db->query()) {
            return false;
        }
        $this->getJSModel('emailtemplate')->sendMail(3, -1, $app_id);
        if ($this->_client_auth_key != "") {
            $data_resume_reject = array();
            $query = "SELECT serverid FROM #__js_job_resume WHERE id = " . $app_id;
            $db->setQuery($query);
            $serverresumeid = $db->loadResult();
            $data_resume_reject['id'] = $serverresumeid;
            $data_resume_reject['resume_id'] = $app_id;
            $data_resume_reject['authkey'] = $this->_client_auth_key;
            $fortask = "resumereject";
            $server_json_data_array = json_encode($data_resume_reject);
            $jsjobsharingobject = $this->getJSModel('jobsharing');
            $return_server_value = $jsjobsharingobject->serverTask($server_json_data_array, $fortask);
            $return_value = json_decode($return_server_value, true);
            $jsjobslogobject = $this->getJSModel('jobsharing');
            $jsjobslogobject->logEmpappReject($return_value);
        }
        return true;
    }

    function getEmpOptions() {
        if (!$this->_empoptions) {
            $this->_empoptions = array();

            $gender = array(
                '0' => array('value' => 1, 'text' => JText::_('Male')),
                '1' => array('value' => 2, 'text' => JText::_('Female')),);

            $status = array(
                '0' => array('value' => 0, 'text' => JText::_('Pending')),
                '1' => array('value' => 1, 'text' => JText::_('Approve')),
                '2' => array('value' => -1, 'text' => JText::_('Reject')),);

            $job_type = $this->getJSModel('jobtype')->getJobType('');
            $heighesteducation = $this->getJSModel('highesteducation')->getHeighestEducation('');
            $job_categories = $this->getJSModel('category')->getCategories('', '');
            $job_salaryrange = $this->getJSModel('salaryrange')->getJobSalaryRange('', '');
            $countries = $this->getJSModel('country')->getCountries('');
            if (isset($this->_application)) {
                $job_subcategories = $this->getJSModel('subcategory')->getSubCategoriesforCombo($this->_application->job_category, '', $this->_application->job_subcategory);
            } else {
                $job_subcategories = $this->getJSModel('subcategory')->getSubCategoriesforCombo($job_categories[0]['value'], '', '');
            }

            if (isset($this->_application)) {
                $this->_empoptions['nationality'] = JHTML::_('select.genericList', $countries, 'nationality', 'class="inputbox" ' . '', 'value', 'text', $this->_application->nationality);
                $this->_empoptions['gender'] = JHTML::_('select.genericList', $gender, 'gender', 'class="inputbox" ' . '', 'value', 'text', $this->_application->gender);

                $this->_empoptions['job_category'] = JHTML::_('select.genericList', $job_categories, 'job_category', 'class="inputbox" ' . 'onChange="fj_getsubcategories(\'fj_subcategory\', this.value)"', 'value', 'text', $this->_application->job_category);
                $this->_empoptions['job_subcategory'] = JHTML::_('select.genericList', $job_subcategories, 'job_subcategory', 'class="inputbox" ' . '', 'value', 'text', $this->_application->job_subcategory);

                $this->_empoptions['jobtype'] = JHTML::_('select.genericList', $job_type, 'jobtype', 'class="inputbox" ' . '', 'value', 'text', $this->_application->jobtype);
                $this->_empoptions['heighestfinisheducation'] = JHTML::_('select.genericList', $heighesteducation, 'heighestfinisheducation', 'class="inputbox" ' . '', 'value', 'text', $this->_application->heighestfinisheducation);
                $this->_empoptions['jobsalaryrange'] = JHTML::_('select.genericList', $job_salaryrange, 'jobsalaryrange', 'class="inputbox" ' . '', 'value', 'text', $this->_application->jobsalaryrange);
                $this->_empoptions['status'] = JHTML::_('select.genericList', $status, 'status', 'class="inputbox required" ' . '', 'value', 'text', $this->_application->status);
                $this->_empoptions['currencyid'] = JHTML::_('select.genericList', $this->getJSModel('currency')->getCurrency(), 'currencyid', 'class="inputbox required" ' . '', 'value', 'text', $this->_application->currencyid);
                $address_city = ($this->_application->address_city == "" OR $this->_application->address_city == 0 ) ? -1 : $this->_application->address_city;
                $this->_empoptions['address_city'] = $this->getJSModel('city')->getAddressDataByCityName('', $address_city);
                $address1_city = ($this->_application->address1_city == "" OR $this->_application->address1_city == 0 ) ? -1 : $this->_application->address1_city;
                $this->_empoptions['address1_city'] = $this->getJSModel('city')->getAddressDataByCityName('', $address1_city);
                $address2_city = ($this->_application->address2_city == "" OR $this->_application->address2_city == 0 ) ? -1 : $this->_application->address2_city;
                $this->_empoptions['address2_city'] = $this->getJSModel('city')->getAddressDataByCityName('', $address2_city);
                $institute_city = ($this->_application->institute_city == "" OR $this->_application->institute_city == 0 ) ? -1 : $this->_application->institute_city;
                $this->_empoptions['institute_city'] = $this->getJSModel('city')->getAddressDataByCityName('', $institute_city);
                $institute1_city = ($this->_application->institute1_city == "" OR $this->_application->institute1_city == 0 ) ? -1 : $this->_application->institute1_city;
                $this->_empoptions['institute1_city'] = $this->getJSModel('city')->getAddressDataByCityName('', $institute1_city);
                $institute2_city = ($this->_application->institute2_city == "" OR $this->_application->institute2_city == 0 ) ? -1 : $this->_application->institute2_city;
                $this->_empoptions['institute2_city'] = $this->getJSModel('city')->getAddressDataByCityName('', $institute2_city);
                $institute3_city = ($this->_application->institute3_city == "" OR $this->_application->institute3_city == 0 ) ? -1 : $this->_application->institute3_city;
                $this->_empoptions['institute3_city'] = $this->getJSModel('city')->getAddressDataByCityName('', $institute3_city);
                $employer_city = ($this->_application->employer_city == "" OR $this->_application->employer_city == 0 ) ? -1 : $this->_application->employer_city;
                $this->_empoptions['employer_city'] = $this->getJSModel('city')->getAddressDataByCityName('', $employer_city);
                $employer1_city = ($this->_application->employer1_city == "" OR $this->_application->employer1_city == 0 ) ? -1 : $this->_application->employer1_city;
                $this->_empoptions['employer1_city'] = $this->getJSModel('city')->getAddressDataByCityName('', $employer1_city);
                $employer2_city = ($this->_application->employer2_city == "" OR $this->_application->employer2_city == 0 ) ? -1 : $this->_application->employer2_city;
                $this->_empoptions['employer2_city'] = $this->getJSModel('city')->getAddressDataByCityName('', $employer2_city);
                $employer3_city = ($this->_application->employer3_city == "" OR $this->_application->employer3_city == 0 ) ? -1 : $this->_application->employer3_city;
                $this->_empoptions['employer3_city'] = $this->getJSModel('city')->getAddressDataByCityName('', $employer3_city);
                $reference_city = ($this->_application->reference_city == "" OR $this->_application->reference_city == 0 ) ? -1 : $this->_application->reference_city;
                $this->_empoptions['reference_city'] = $this->getJSModel('city')->getAddressDataByCityName('', $reference_city);
                $reference1_city = ($this->_application->reference1_city == "" OR $this->_application->reference1_city == 0 ) ? -1 : $this->_application->reference1_city;
                $this->_empoptions['reference1_city'] = $this->getJSModel('city')->getAddressDataByCityName('', $reference1_city);
                $reference2_city = ($this->_application->reference2_city == "" OR $this->_application->reference2_city == 0 ) ? -1 : $this->_application->reference2_city;
                $this->_empoptions['reference2_city'] = $this->getJSModel('city')->getAddressDataByCityName('', $reference2_city);
                $reference3_city = ($this->_application->reference3_city == "" OR $this->_application->reference3_city == 0 ) ? -1 : $this->_application->reference3_city;
                $this->_empoptions['reference3_city'] = $this->getJSModel('city')->getAddressDataByCityName('', $reference3_city);
            } else {
                $this->_empoptions['nationality'] = JHTML::_('select.genericList', $countries, 'nationality', 'class="inputbox" ' . '', 'value', 'text', '');
                $this->_empoptions['gender'] = JHTML::_('select.genericList', $gender, 'gender', 'class="inputbox" ' . '', 'value', 'text', '');

                $this->_empoptions['job_category'] = JHTML::_('select.genericList', $job_categories, 'job_category', 'class="inputbox" ' . 'onChange="fj_getsubcategories(\'fj_subcategory\', this.value)"', 'value', 'text', '');
                $this->_empoptions['job_subcategory'] = JHTML::_('select.genericList', $job_subcategories, 'job_subcategory', 'class="inputbox" ' . '', 'value', 'text', '');


                $this->_empoptions['jobtype'] = JHTML::_('select.genericList', $job_type, 'jobtype', 'class="inputbox" ' . '', 'value', 'text', '');
                $this->_empoptions['heighestfinisheducation'] = JHTML::_('select.genericList', $heighesteducation, 'heighestfinisheducation', 'class="inputbox" ' . '', 'value', 'text', '');
                $this->_empoptions['jobsalaryrange'] = JHTML::_('select.genericList', $job_salaryrange, 'jobsalaryrange', 'class="inputbox" ' . '', 'value', 'text', '');
                $this->_empoptions['status'] = JHTML::_('select.genericList', $status, 'status', 'class="inputbox required" ' . '', 'value', 'text', '');
                $this->_empoptions['currencyid'] = JHTML::_('select.genericList', $this->getJSModel('currency')->getCurrency(), 'currencyid', 'class="inputbox required" ' . '', 'value', 'text', '');
            }
        }
        return $this->_empoptions;
    }

    function getUserStatsResumes($resumeuid, $limitstart, $limit) {
        if (is_numeric($resumeuid) == false)
            return false;
        $db = JFactory::getDBO();
        $result = array();

        $query = 'SELECT COUNT(resume.id) FROM #__js_job_resume AS resume WHERE resume.uid = ' . $resumeuid;
        $db->setQuery($query);
        $total = $db->loadResult();
        if ($total <= $limitstart)
            $limitstart = 0;

        $query = 'SELECT resume.id,resume.application_title,resume.first_name,resume.last_name,cat.cat_title,resume.created,resume.status
                    FROM #__js_job_resume AS resume
                    LEFT JOIN #__js_job_categories AS cat ON cat.id=resume.job_category
                    WHERE resume.uid = ' . $resumeuid;
        $query .= ' ORDER BY resume.first_name';
        $db->setQuery($query, $limitstart, $limit);
        $result[0] = $db->loadObjectList();
        $result[1] = $total;
        return $result;
    }

    
}
?>