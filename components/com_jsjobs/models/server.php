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

class JSJobsModelServer extends JSModel {

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

    function getDataFromLocalServer($updateTime = 1, $limitstart, $limit) {
        $db = JFactory::getDbo();
        $session = JFactory::getSession();
        if ($updateTime == 1) {
            $update_request1 = "UPDATE #__js_job_jobs_temp_time as time1 ,(select max(id) AS id from #__js_job_jobs_temp_time ) time2 set is_request =0  where time1.id = time2.id";
            $db->setQuery($update_request1);
            $db->query();
        }
        $query = "SELECT jobtemp.*,jobtemp.aliasid AS jobaliasid FROM `#__js_job_jobs_temp` AS jobtemp ORDER BY  jobtemp.id DESC";
        $db->setQuery($query, $limitstart, $limit);
        $jobs = $db->loadObjectList();
        $total = $session->get('totalserverjobs');
        $return['jobs'] = $jobs;
        $return['total'] = $total;
        return $return;
    }

    function getIDDefaultCountry($defaultcountrycode) {
        $db = $this->getDBO();
        $query = "SELECT id FROM `#__js_job_countries` WHERE code = " . $db->quote($defaultcountrycode);
        $db->setQuery($query);
        $default_country_id = $db->loadResult();
        return $default_country_id;
    }

    function getJobsFromServerAndFill($variables) {
        $db = JFactory::getDbo();
        $session = JFactory::getSession();

        $JConfig = new JConfig();
        $db_prefix = $JConfig->dbprefix;

        $query = "SELECT jobtemptime.* FROM `#__js_job_jobs_temp_time` AS jobtemptime";
        $db->setQuery($query);
        $time_data = $db->loadObject();
        if (empty($time_data)) {
            $lastcalltime = date("Y-m-d H:i:s");
            $expiretime = date("Y-m-d H:i:s", strtotime("+5 min"));
            $insert_time_query = 'INSERT INTO `#__js_job_jobs_temp_time` (lastcalltime,expiretime,is_request)
                                    VALUES(' . $db->quote($lastcalltime) . ',' . $db->quote($expiretime) . ',0)';
            $db->setQuery($insert_time_query);
            $db->query();

            $temp_job = $this->getTable('jobtemp');
            $fortask = "insertnewestjobsfromserver";
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $data['limitstart'] = 0;
            $data['limit'] = 100;
            $data['authkey'] = $this->_client_auth_key;
            $data['siteurl'] = $this->_siteurl;

            $encodedata = json_encode($data);
            $return_server_value = $jsjobsharingobject->serverTask($encodedata, $fortask);
            if ((is_array($return_server_value)) AND ( !empty($return_server_value))) {
                if (isset($return_server_value['isjobinsert']) AND $return_server_value['isjobinsert'] == -1) { // auth fail 
                    $logarray['uid'] = $this->_uid;
                    $logarray['referenceid'] = $return_server_value['referenceid'];
                    $logarray['eventtype'] = $return_server_value['eventtype'];
                    $logarray['message'] = $return_server_value['message'];
                    $logarray['event'] = "get newest jobs";
                    $logarray['messagetype'] = "Error";
                    $logarray['datetime'] = date('Y-m-d H:i:s');
                    $jsjobsharingobject->write_JobSharingLog($logarray);
                    // Authentication Failed get local Jobs
                    $return = $this->getJSModel('job')->getLocalJobs($variables);
                    return $return;
                } else {
                    $session->set('totalserverjobs', $return_server_value['total']);
                    foreach ($return_server_value['newestjobsforinsert'] AS $sjobs) {

                        $sjobs['localid'] = '';
                        if (!$temp_job->bind($sjobs)) {
                            $this->setError($this->_db->getErrorMsg());
                        }
                        if (!$temp_job->check()) {
                            $this->setError($this->_db->getErrorMsg());
                        }
                        if (!$temp_job->store()) {
                            $this->setError($this->_db->getErrorMsg());
                        }
                    }
                }
            }
            // Get data from local table
            $return = $this->getDataFromLocalServer(1, $variables['limitstart'], $variables['limit']);
            return $return;
        } else {

            $lastcalltime = $time_data->lastcalltime;
            $expiretime = $time_data->expiretime;
        }
        $now_stamp = date("Y-m-d H:i:s");
        if ($now_stamp > $expiretime) {

            $update_request = "UPDATE #__js_job_jobs_temp_time as time1 ,(select max(id) AS id from #__js_job_jobs_temp_time ) time2 set is_request =is_request+1  where time1.id = time2.id";
            $db->setQuery($update_request);
            $db->query();
            $query1 = "SELECT jobtemptime.* FROM `#__js_job_jobs_temp_time` AS jobtemptime";
            $db->setQuery($query1);
            $time_data1 = $db->loadObject();
            if ($time_data1->is_request > 1) {
                // Get data from local table
                $return = $this->getDataFromLocalServer(1, $variables['limitstart'], $variables['limit']);
                return $return;
            }

            $temp_job = $this->getTable('jobtemp');
            $fortask = "insertnewestjobsfromserver";
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $data['limitstart'] = 0;
            $data['limit'] = 100;
            $data['authkey'] = $this->_client_auth_key;
            $data['siteurl'] = $this->_siteurl;
            $encodedata = json_encode($data);
            $return_server_value = $jsjobsharingobject->serverTask($encodedata, $fortask);
            if ((is_array($return_server_value)) AND ( !empty($return_server_value))) {

                if (isset($return_server_value['isjobinsert']) AND $return_server_value['isjobinsert'] == -1) { // auth fail 
                    $logarray['uid'] = $this->_uid;
                    $logarray['referenceid'] = $return_server_value['referenceid'];
                    $logarray['eventtype'] = $return_server_value['eventtype'];
                    $logarray['message'] = $return_server_value['message'];
                    $logarray['event'] = "get newest jobs";
                    $logarray['messagetype'] = "Error";
                    $logarray['datetime'] = date('Y-m-d H:i:s');
                    $jsjobsharingobject->write_JobSharingLog($logarray);
                    $update_request1 = "UPDATE #__js_job_jobs_temp_time as time1 ,(select max(id) AS id from #__js_job_jobs_temp_time ) time2 set is_request =0  where time1.id = time2.id";
                    $db->setQuery($update_request1);
                    $db->query();
                    // Authentication Failed get local Jobs
                    $return = $this->getJSModel('job')->getLocalJobs($variables);
                    return $return;
                } else {
                    $session->set('totalserverjobs', $return_server_value['total']);
                    $job_temp_in_use = 0;
                    $open_table_query = 'SHOW OPEN TABLES WHERE In_use > 0';
                    $db->setQuery($open_table_query);
                    $open_tble_data = $db->loadObjectList();
                    if (!empty($open_tble_data)) {
                        foreach ($open_tble_data AS $table) {
                            if (($table->Table == $db_prefix . "js_job_jobs_temp") AND ( $table->In_use > 0)) {
                                $job_temp_in_use = 1;
                                break;
                            }
                        }
                    }
                    if ($job_temp_in_use == 1) {
                        $i = 2;
                        while ($i <= 10) {
                            sleep($i);
                            $open_table_query1 = 'SHOW OPEN TABLES WHERE In_use = 0';
                            $db->setQuery($open_table_query1);
                            $open_tble_data1 = $db->loadObjectList();
                            if (!empty($open_tble_data1)) {
                                foreach ($open_tble_data1 AS $table1) {
                                    if (($table1->Table == $db_prefix . "js_job_jobs_temp") AND ( $table1->In_use = 0)) {
                                        $job_temp_in_use = 2;
                                        break;
                                    }
                                }
                            }
                            $i = $i + 2;
                        }
                        if ($job_temp_in_use != 2) {
                            $return = $this->getJobsFromServerFilter($variables);
                            return $return;
                        }
                    }
                    $lockquery = 'LOCK TABLES ' . $db_prefix . 'js_job_jobs_temp WRITE';
                    $db->setQuery($lockquery);
                    $db->query();
                    $query = "DELETE FROM `#__js_job_jobs_temp`";
                    $db->setQuery($query);
                    $db->query();
                    foreach ($return_server_value['newestjobsforinsert'] AS $sjobs) {
                        $sjobs['localid'] = '';
                        if (!$temp_job->bind($sjobs)) {
                            $this->setError($this->_db->getErrorMsg());
                        }
                        if (!$temp_job->check()) {
                            $this->setError($this->_db->getErrorMsg());
                        }
                        if (!$temp_job->store()) {
                            $this->setError($this->_db->getErrorMsg());
                        }
                    }
                    $unlickquery = 'UNLOCK TABLES';
                    $db->setQuery($unlickquery);
                    $db->query();
                    $lastcalltime1 = date("Y-m-d H:i:s");
                    $expiretime1 = date("Y-m-d H:i:s", strtotime("+5 min"));
                    $temp_time = "DELETE FROM `#__js_job_jobs_temp_time`";
                    $db->setQuery($temp_time);
                    $db->query();
                    $insert_time_query1 = "INSERT INTO `#__js_job_jobs_temp_time` (lastcalltime,expiretime,is_request)
									VALUES(" . $db->quote($lastcalltime1) . "," . $db->quote($expiretime1) . ",0)";
                    $db->setQuery($insert_time_query1);
                    $db->query();
                    // Get data from local Server
                    $return = $this->getDataFromLocalServer(1, $variables['limitstart'], $variables['limit']);
                    return $return;
                }
            }
        } else {
            // Get data from local Server
            $return = $this->getDataFromLocalServer(0, $variables['limitstart'], $variables['limit']);
            return $return;
        }
    }

    function getJobsFromServerFilter($variables) {
        $db = JFactory::getDbo();
        $selectdistance = " ";
        if ($variables['txtfilterlongitude'] != '' && $variables['txtfilterlatitude'] != '' && $variables['txtfilterradius'] != '') {
            $radiussearch = " acos((SIN( PI()* " . $variables['txtfilterlatitude'] . " /180 )*SIN( PI()*t.latitude/180 ))+(cos(PI()* " . $variables['txtfilterlatitude'] . " /180)*COS( PI()*t.latitude/180) *COS(PI()*t.longitude/180-PI()* " . $variables['txtfilterlongitude'] . " /180)))* " . $variables['radiuslength'] . " <= " . $variables['txtfilterradius'];
        }

        $wherequery = '';
        $server_address = array();
        if ($variables['city_filter'] != '') {
            $server_citiy_id = $this->getJSModel('common')->getServerid('cities', $variables['city_filter']);
            $server_address['multicityid'] = $server_citiy_id;
            $server_country_id = $this->getJSModel('jobsharingsite')->getSeverCountryid($variables['city_filter']);
            if ($server_country_id == false)
                $cmbfiltercountry = '';
            else
                $cmbfiltercountry = $server_country_id;
        }elseif ($variables['jobstate'] != '') { // calling from module & plugin
            $server_address['defaultsharingstate'] = $this->getJSModel('common')->getServerid('states', $variables['jobstate']);
        } elseif ($variables['jobcountry'] != '') { // calling from module & plugin
            $server_address['filtersharingcountry'] = $this->getJSModel('common')->getServerid('countries', $variables['jobcountry']);
            $cmbfiltercountry = $server_address['filtersharingcountry'];
        } else {
            $default_sharing_loc = $this->getJSModel('configurations')->getDefaultSharingLocation($server_address, $variables['cmbfilter_country']);
            if (isset($default_sharing_loc['defaultsharingcity']) AND ( $default_sharing_loc['defaultsharingcity'] != '')) {
                $variables['city_filter'] = $default_sharing_loc['defaultsharingcity'];
                $server_address['multicityid'] = $default_sharing_loc['defaultsharingcity'];
                $server_country_id = $this->getJSModel('jobsharingsite')->getSeverDefaultCountryid($variables['city_filter']);
                if ($server_country_id == false)
                    $cmbfiltercountry = '';
                else
                    $cmbfiltercountry = $server_country_id;
            } elseif (isset($default_sharing_loc['defaultsharingstate']) AND ( $default_sharing_loc['defaultsharingstate'] != '')) {
                $server_address['defaultsharingstate'] = $default_sharing_loc['defaultsharingstate'];
            } elseif (isset($default_sharing_loc['filtersharingcountry']) AND ( $default_sharing_loc['filtersharingcountry'] != '')) {
                $server_address['filtersharingcountry'] = $default_sharing_loc['filtersharingcountry'];
                $cmbfiltercountry = $default_sharing_loc['filtersharingcountry'];
            } elseif (isset($default_sharing_loc['defaultsharingcountry']) AND ( $default_sharing_loc['defaultsharingcountry'] != '')) {
                $server_address['defaultsharingcountry'] = $default_sharing_loc['defaultsharingcountry'];
                $cmbfiltercountry = $default_sharing_loc['defaultsharingcountry'];
            }
        }

        if ($variables['filterjobtype'] != '' && $variables['filterjobtype'] != 0) {
            $serverjobtype = $this->getJSModel('common')->getServerid('jobtypes', $variables['filterjobtype']);
            if(!$serverjobtype)
                $serverjobtype = $variables['filterjobtype'];
            $wherequery .= " AND t.jobtype = " . $serverjobtype;
        }
        if ($variables['filterjobcategory'] != '' && $variables['filterjobcategory'] != 0) {
            $serverjobcategory = $this->getJSModel('common')->getServerid('categories', $variables['filterjobcategory']);
            $wherequery .= " AND t.jobcategory = " . $serverjobcategory;
        }
        if ($variables['filterjobsubcategory'] != '' && $variables['filterjobsubcategory'] != 0) {
            $serverjobsubcategory = $this->getJSModel('common')->getServerid('subcategories', $variables['filterjobsubcategory']);
            $wherequery .= " AND t.subcategoryid = " . $serverjobsubcategory;
        }
        if (isset($radiussearch))
            $wherequery .= " AND $radiussearch";
        $fortask = "listjobs";
        $jsjobsharingobject = $this->getJSModel('jobsharingsite');
        $data['limitstart'] = $variables['limitstart'];
        $data['limit'] = $variables['limit'];
        $data['server_address'] = $server_address;
        $data['wherequery'] = $wherequery;
        $data['authkey'] = $this->_client_auth_key;
        $data['siteurl'] = $this->_siteurl;
        $encodedata = json_encode($data);
        $return_server_value = $jsjobsharingobject->serverTask($encodedata, $fortask);
        if (isset($return_server_value['listnewestjobs']) AND $return_server_value['listnewestjobs'] == -1) { // auth fail 
            $logarray['uid'] = $this->_uid;
            $logarray['referenceid'] = $return_server_value['referenceid'];
            $logarray['eventtype'] = $return_server_value['eventtype'];
            $logarray['message'] = $return_server_value['message'];
            $logarray['event'] = "List Newest Jobs";
            $logarray['messagetype'] = "Error";
            $logarray['datetime'] = date('Y-m-d H:i:s');
            $jsjobsharingobject->write_JobSharingLog($logarray);
            // Authentication Failed get local Jobs
            $this->_applications = array();
            $total = 0;
        } else {
            $parsedata = array();
            if(!empty($return_server_value['newestjobs']))
            foreach ($return_server_value['newestjobs'] AS $data) {
                $parsedata[] = (object) $data;
            }
            $total = $return_server_value['total'];
        }

        $return['jobs'] = $parsedata;
        $return['total'] = $total;

        return $return;
    }

    function getSharingCountries($title) {
        if (!$this->_countries) {
            $db = JFactory::getDBO();
            $query = "SELECT serverid as id,name FROM `#__js_job_countries` WHERE enabled = 1";
            if ($this->_client_auth_key != "")
                $query.=" AND serverid!='' AND serverid!=0";
            $query.=" ORDER BY name ASC ";
            //echo '<br>sql '.$query;
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
        else
            $countries[] = array('value' => JText::_(''), 'text' => JText::_('Select Country'));

        foreach ($this->_countries as $row) {
            $countries[] = array('value' => $row->id, 'text' => JText::_($row->name));
        }
        return $countries;
    }

}
?>    


