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

class JSJobsModelSharingResume extends JSModel {

    protected $_db = null;
    protected $_client_auth_key = null;
    protected $_siteurl = null;
    protected $_sharingsitemodel = null;

    function __construct() {
        parent::__construct();
        $this->_db = JFactory::getDbo();
        $this->_client_auth_key = $this->getJSModel('common')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        require_once(JPATH_ROOT.'/components/com_jsjobs/models/jobsharingsite.php');
        $this->_sharingsitemodel = new JSJobsModelJobSharingSite;
    }

    function getLocalJobid($jobid) {
        if (!is_numeric($jobid))
            return false;
        $query = "SELECT id FROM `#__js_job_jobs` WHERE serverid = " . $jobid;
        $this->_db->setQuery($query);
        $server_jobid = $this->_db->loadResult();
        if ($server_jobid) // if the jobid is not found then return the job id which is passed as argument
            $jobid = $server_jobid;
        return $jobid;
    }

    function getServerResumeid($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT serverid FROM `#__js_job_resume` WHERE id = " . $id;
        $this->_db->setQuery($query);
        $server_id = $this->_db->loadResult();
        if ($server_id) // if the id is not found then return the job id which is passed as argument
            $id = $server_id;
        return $id;
    }

    function getLocalResumeid($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT id FROM `#__js_job_resume` WHERE serverid = " . $id;
        $this->_db->setQuery($query);
        $server_resumeid = $this->_db->loadResult();
        if ($server_resumeid)
            $id = $server_resumeid;
        return $id;
    }

    function getResumeViewbyId($jobid, $id, $uid) {
        if (!is_numeric($id))
            return false;
        if ($jobid) {
            if (!is_numeric($jobid))
                return false;
            $query = "SELECT serverid FROM `#__js_job_jobs` WHERE id = " . $jobid;
            $this->_db->setQuery($query);
            $_jobid = $this->_db->loadResult();
        }
        $data_resumedetail = array();
        $data_resumedetail['uid'] = $uid;
        $data_resumedetail['jobid'] = $jobid;
        $data_resumedetail['resumeid'] = $id;
        $data_resumedetail['authkey'] = $this->_client_auth_key;
        $data_resumedetail['siteurl'] = $this->_siteurl;
        $fortask = "getresumeviewbyid";        
        $encodedata = json_encode($data_resumedetail);
        $return_server_value = $this->_sharingsitemodel->serverTask($encodedata, $fortask);
        if (isset($return_server_value['resumeviewbyid']) AND $return_server_value['resumeviewbyid'] == -1) { // auth fail 
            $logarray['uid'] = $this->_uid;
            $logarray['referenceid'] = $return_server_value['referenceid'];
            $logarray['eventtype'] = $return_server_value['eventtype'];
            $logarray['message'] = $return_server_value['message'];
            $logarray['event'] = "Resume View";
            $logarray['messagetype'] = "Error";
            $logarray['datetime'] = date('Y-m-d H:i:s');
            $this->_sharingsitemodel->write_JobSharingLog($logarray);
            $result['personal'] = (object) $return_server_value['personal'];
            $result['addresses'] = (object) $return_server_value['addresses'];
            $result['institutes'] = (object) $return_server_value['institutes'];
            $result['employers'] = (object) $return_server_value['employers'];
            $result['languages'] = (object) $return_server_value['languages'];
            $result['filenames'] = (object) $return_server_value['filenames'];
            $result['canview'] = 1; // can view
            $resumeuserfields = $return_server_value[6];
            $result['userfields'] = json_decode($resumeuserfields['userfields']);
            if(isset($return_server_value[5])){
//                $result['cvids'] = $return_server_value[5];
            }            
        } else {
            $result['personal'] = (object) $return_server_value['personal'];
            $result['addresses'] = (object) $return_server_value['addresses'];
            $result['institutes'] = (object) $return_server_value['institutes'];
            $result['employers'] = (object) $return_server_value['employers'];
            $result['languages'] = (object) $return_server_value['languages'];
            $result['references'] = (object) $return_server_value['references'];
            $result['filename'] = (object) $return_server_value['filename'];
            $result['canview'] = 1; // can view
            if(isset($return_server_value[6])){
                $resumeuserfields = $return_server_value[6];
                $result['userfields'] = json_decode($resumeuserfields['userfields']);
            }
            if(isset($return_server_value[5])){
//                $result['cvids'] = $return_server_value[5];
            }            
        }
        return $result;
    }

    function deleteResume($resumeid) {
        if (!is_numeric($resumeid))
            return false;
        $serverresumeid = 0;
        $query = "SELECT resume.serverid AS id FROM `#__js_job_resume` AS resume WHERE resume.id = " . $resumeid;
        $this->_db->setQuery($query);
        $serverresumeid = $this->_db->loadResult();
        if ($serverresumeid != 0) {
            $data = array();
            $data['id'] = $serverresumeid;
            $data['referenceid'] = $resumeid;
            $data['uid'] = $this->_uid;
            $data['authkey'] = $this->_client_auth_key;
            $data['siteurl'] = $this->_siteurl;
            $data['task'] = 'deleteresume';
            $return_value = $this->_sharingsitemodel->delete_ResumeSharing($data);
            $job_log_object = $this->getJSModel('log');
            $job_log_object->log_Delete_ResumeSharing($return_value);
        }
        return;
    }

    function storeResume($resumeid,$jobid,$resumedata) {
        if(!is_numeric($resumeid)) return false;
        if($jobid) if(!is_numeric($jobid)) return false;
        
        $job_log_object = $this->getJSModel('log');

        $resume_picture = array();
        $resume_file = array();

        $query = "SELECT resume.* FROM `#__js_job_resume` AS resume WHERE resume.id = " . $resumeid;
        $this->_db->setQuery($query);
        $data_resume = $this->_db->loadObject();
        if ($resumedata['id'] != "" AND $resumedata['id'] != 0)
            $data_resume->id = $resumedata['id']; // for edit case
        else
            $data_resume->id = ''; // for new case
        if (isset($_FILES['photo']) && $_FILES['photo']['size'] > 0)
            $resume_picture['picfilename'] = $_FILES['photo']['name'];
        if (isset($_FILES['resumefile']) && $_FILES['resumefile']['size'] > 0)
            $resume_file['resume_file'] = $_FILES['resumefile']['name'];

        $data_resume->resume_id = $resumeid;
        $data_resume->authkey = $this->_client_auth_key;
        $data_resume->task = 'storeresume';
        $return_value = $this->_sharingsitemodel->store_ResumeSharing($data_resume);
        if ($return_value['isresumestore'] == 0)
            $job_log_object->log_Store_ResumeSharing($return_value);
        $status_resume_pic = "";
        if (isset($file_size_increase) && $file_size_increase != 1) {
            if (isset($photomismatch) && $photomismatch != 1) {
                if ($_FILES['photo']['size'] > 0)
                    $return_value_resume_pic = $this->_sharingsitemodel->store_ResumePicSharing($data_resume, $resume_picture);
                if (isset($return_value_resume_pic)) {
                    if ($return_value_resume_pic['isresumestore'] == 0 OR $return_value_resume_pic == false)
                        $status_resume_pic = -1;
                    else
                        $status_resume_pic = 1;
                }
            }
        }
        $status_resume_file = "";
        if (isset($filemismatch) && $filemismatch != 1) {
            if (isset($_FILES['resumefile']) && $_FILES['resumefile']['size'] > 0)
                $return_value_resume_file = $this->_sharingsitemodel->store_ResumeFileSharing($data_resume, $resume_file);
            if (isset($return_value_resume_file)) {
                if ($return_value_resume_file['isresumestore'] == 0 OR $return_value_resume_file == false)
                    $status_resume_file = -1;
                else
                    $status_resume_file = 1;
            }
        }

        if (($status_resume_pic == -1 AND $status_resume_file == -1) OR ( isset($filemismatch) && $filemismatch == 1 AND $photomismatch == 1)) {// file type mismatch 
            $return_value['message'] = JText::_("Resume saved but error in uploading resume file and picture");
        } elseif (($status_resume_pic == -1) OR ( isset($photomismatch) && $photomismatch == 1)) {// file type mismatch 
            $return_value['message'] = JText::_("Resume saved but error in uploading picture");
        } elseif (($status_resume_file == -1) OR ( isset($filemismatch) && $filemismatch == 1)) { // file type mismatch 
            $return_value['message'] = JText::_("Resume saved but error in uploading file");
        }
        if ($jobid) { // for visitor case 
            if ($return_value['isresumestore'] == 1) {
                if ($return_value['status'] == "Resume Edit") {
                    $serverresumestatus = "ok";
                } elseif ($return_value['status'] == "Resume Add") {
                    $serverresumestatus = "ok";
                } elseif ($return_value['status'] == "Edit Resume Userfield") {
                    $serverresumestatus = "ok";
                } elseif ($return_value['status'] == "Add Resume Userfield") {
                    $serverresumestatus = "ok";
                }
                $user = JFactory::getUser();
                $uid = $user->id;
                $logarray['uid'] = $uid;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = "Visitor Resume";
                $logarray['messagetype'] = "Sucessfully";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $this->_sharingsitemodel->write_JobSharingLog($logarray);
                $this->_sharingsitemodel->Update_ServerStatus($serverresumestatus, $logarray['referenceid'], $return_value['serverid'], $logarray['uid'], 'resume');
                $resume_update = 1;
            } elseif ($return_value['isresumestore'] == 0) {
                if ($return_value['status'] == "Data Empty") {
                    $serverresumestatus = JText::_("Data Not Post On Server");
                } elseif ($return_value['status'] == "Resume Saving Error") {
                    $serverresumestatus = JText::_("Error Resume Saving");
                } elseif ($return_value['status'] == "Auth Fail") {
                    $serverresumestatus = JText::_("Authentication Fail");
                } elseif ($return_value['status'] == "Error in saving resume user fields") {
                    $serverresumestatus = JText::_("Error in saving resume user fields");
                } elseif ($return_value['status'] == "Improper Resume name") {
                    $serverresumestatus = JText::_("Improper Resume Name");
                }
                $user = JFactory::getUser();
                $logarray['uid'] = $user->id;
                $logarray['referenceid'] = $return_value['referenceid'];
                $logarray['eventtype'] = $return_value['eventtype'];
                $logarray['message'] = $return_value['message'];
                $logarray['event'] = JText::_("Visitor Resume");
                $logarray['messagetype'] = JText::_("Error");
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $serverid = 0;
                $this->_sharingsitemodel->write_JobSharingLog($logarray);
                $this->_sharingsitemodel->Update_ServerStatus($serverresumestatus, $logarray['referenceid'], $serverid, $logarray['uid'], 'resume');
                $resume_update = 0;
            }
            if ($resume_update == 1) {
                /* Code is shift in jobapply controller
                if ($jobid)
                    $returnvalue = $this->getJSModel('jobapply')->visitorJobApply($jobid, $row->id);
                */
                return $return_value;
            }else {
                return false;
            }
        } else {
            $job_log_object->log_Store_ResumeSharing($return_value);
        }
        return;
    }

    function storeResumeSection($tablename,$rowid) {

        $job_log_object = $this->getJSModel('log');

        $query = "SELECT resume.* FROM `#__js_job_$tablename` AS resume WHERE resume.id = " . $rowid;
        $this->_db->setQuery($query);
        $data_resume = $this->_db->loadObject();

        $data_resume->id = '';
        $data_resume->resumeid = $this->getServerResumeid($data_resume->resumeid);
        switch($tablename){
            case 'resumeaddresses':
                $data_resume->resumeaddress_id = $rowid;
                $data_resume->address_city = $this->_sharingsitemodel->getServerid('cities', $data_resume->address_city);
            break;
            case 'resumeinstitutes':
                $data_resume->resumeinstitute_id = $rowid;
                $data_resume->institute_city = $this->_sharingsitemodel->getServerid('cities', $data_resume->institute_city);
            break;
            case 'resumeemployers':
                $data_resume->resumeemployer_id = $rowid;
                $data_resume->employer_city = $this->_sharingsitemodel->getServerid('cities', $data_resume->employer_city);
            break;
            case 'resumereferences':
                $data_resume->resumereference_id = $rowid;
                $data_resume->reference_city = $this->_sharingsitemodel->getServerid('cities', $data_resume->reference_city);
            break;
            case 'resumelanguages':
                $data_resume->resumelanguage_id = $rowid;
            break;
        }
        $data_resume->authkey = $this->_client_auth_key;
        $data_resume->task = 'store'.$tablename;
        $data_resume = (array) $data_resume;
        $return_value = $this->_sharingsitemodel->store_ResumeSectionSharing($data_resume);
        if ($return_value['isresumestore'] == 0)
            $job_log_object->log_Store_ResumeSharing($return_value);
        return;
    }

    function storeResumeRating($is_own_resume,$is_own_job,$jobid,$resumeid,$uid,$newrating,$rowid){
        $job_log_object = $this->getJSModel('log');
        if ($is_own_resume == 1 AND $is_own_job == 1) { // own Resume Rating 
            if ($jobid != "" AND $jobid != 0) {
                $query = "select job.serverid AS serverid From #__js_job_jobs AS job WHERE job.id=" . $jobid;
                $this->_db->setQuery($query);
                $job_serverid = $this->_db->loadResult();
                if ($job_serverid)
                    $jobid = $job_serverid;
                else
                    $jobid = 0;
            }
            /* B/c we have the resume server id not the local resume id
            if ($resumeid != "" AND $resumeid != 0) {
                $query = "select resume.serverid AS serverid From #__js_job_resume AS resume WHERE resume.id=" . $resumeid;
                $this->_db->setQuery($query);
                $resume_serverid = $this->_db->loadResult();
                if ($resume_serverid)
                    $resumeid = $resume_serverid;
                else
                    $resumeid = 0;
            }
            */
            $data['uid'] = $uid;
            $data['jobid'] = $jobid;
            $data['resumeid'] = $resumeid;
            $data['rating'] = $newrating;
            $data['resumerating_id'] = $rowid;
            $data['created'] = date('Y-m-d H:i:s');
            $data['authkey'] = $this->_client_auth_key;
            $data['task'] = 'storeownresumerating';
            $isownresumerating = 1;
            $data['isownresumerating'] = $isownresumerating;
            $return_value = $this->_sharingsitemodel->store_ResumeRatingSharing($data);
            $job_log_object->log_Store_ResumeRatingSharing($return_value);
        }else {  // server job apply on job sharing 
            $data['uid'] = $uid;
            $data['jobid'] = $jobid;
            $data['resumeid'] = $resumeid;
            $data['rating'] = $newrating;
            $data['authkey'] = $this->_client_auth_key;
            $data['created'] = date('Y-m-d H:i:s');
            $data['task'] = 'storeserverjobapply';
            $isownresumerating = 0;
            $data['isownresumerating'] = $isownresumerating;
            $return_value = $this->_sharingsitemodel->store_ResumeRatingSharing($data);
            $job_log_object->log_Store_ResumeRatingSharing($return_value);
        }
        return;        
    }

    function getResumeDetail($jobid,$localresumeid,$uid){
        $query = "SELECT serverid FROM `#__js_job_jobs` WHERE id = " . $jobid;
        $this->_db->setQuery($query);
        $_jobid = $this->_db->loadResult();
        $jobid = $_jobid;
        /*
        if ($localresumeid) {
            $query = "SELECT serverid FROM `#__js_job_resume` WHERE id = " . $localresumeid;
            $this->_db->setQuery($query);
            $_resumeid = $this->_db->loadResult();
            $resumeid = $_resumeid;
        }
        */
        $data_resumedetail = array();
        $data_resumedetail['uid'] = $uid;
        $data_resumedetail['jobid'] = $jobid;
        $data_resumedetail['resumeid'] = $localresumeid;
        $data_resumedetail['authkey'] = $this->_client_auth_key;
        $data_resumedetail['siteurl'] = $this->_siteurl;
        $fortask = "getresumedetail";
        $encodedata = json_encode($data_resumedetail);
        $return_server_value = $this->_sharingsitemodel->serverTask($encodedata, $fortask);
        if (isset($return_server_value['resumedetails']) AND $return_server_value['resumedetails'] == -1) { // auth fail 
            $logarray['uid'] = $this->_uid;
            $logarray['referenceid'] = $return_server_value['referenceid'];
            $logarray['eventtype'] = $return_server_value['eventtype'];
            $logarray['message'] = $return_server_value['message'];
            $logarray['event'] = "Resume Details";
            $logarray['messagetype'] = "Error";
            $logarray['datetime'] = date('Y-m-d H:i:s');
            $this->_sharingsitemodel->write_JobSharingLog($logarray);
            //$resume = (object) array('name'=>'','decription'=>'','created'=>'');
        } else {
            $resume = (object) $return_server_value['relationjsondata'];
            $jobapplyid = $return_server_value['jobapplyid'];
        }
        return $resume;
    }

    function getResumeSectionByResumeidAndSectionName($resumeid,$resumesection){
        if(!is_numeric($resumeid)) return false;
        $query = "SELECT * FROM `#__js_job_".$resumesection."` WHERE resumeid = $resumeid";
        $this->_db->setQuery($query);
        $results = $this->_db->loadObjectList();
        return $results;
    }

    function getAllResumeFiles($resumeid){
        $fortask = "getallresumefiles";
        $encodedata = '&resumeid='.$resumeid;
        $return_server_value = $this->_sharingsitemodel->serverTask($encodedata, $fortask);
        if (isset($return_server_value['resumefiles']) AND $return_server_value['resumefiles'] == -1) { // auth fail 
            $logarray['uid'] = $this->_uid;
            $logarray['referenceid'] = $return_server_value['referenceid'];
            $logarray['eventtype'] = $return_server_value['eventtype'];
            $logarray['message'] = $return_server_value['message'];
            $logarray['event'] = "Download Resume all files";
            $logarray['messagetype'] = "Error";
            $logarray['datetime'] = date('Y-m-d H:i:s');
            $this->_sharingsitemodel->write_JobSharingLog($logarray);
        }
    }
}
