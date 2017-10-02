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
jimport('joomla.application.component.controller');

class JSJobsControllerJobsharing extends JSController {

    function __construct() {
        parent::__construct();
        $this->registerTask('add', 'edit');
    }

    function unsubscribejobsharing() {
        $user = JFactory::getUser();
        $uid = $user->id;
        $fortask = "unsubscribejobsharing";
        $data = JRequest::get('post');
        $auth_key = $data['authkey'];
        $ip = $data['ip'];
        $domain = $data['domain'];
        $siteurl = $data['siteurl'];
        $data_array = array("ip" => $ip, "domainname" => $domain, 'siteurl' => $siteurl, 'authkey' => $auth_key);
        $jsondata = json_encode($data_array);
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $return_server_value = $jobsharing->unSubscribeJobSharingServer($jsondata, $fortask);
        $returnvalue = $jobsharing->unsubscribeUpdatekey();
        $event = "unsubscribejobsharing";
        $eventtype = "unsubscribejobsharing";
        $data_log = array();
        $data_log['uid'] = $uid;
        $data_log['event'] = $event;
        $data_log['eventtype'] = $eventtype;
        $data_log['datetime'] = date('Y-m-d H:i:s');
        if ($returnvalue == 1) {
            $this->getSharingModel('jobshortlist')->updateShortlistIDs(0);
            $data_log['messagetype'] = 'Sucessfully';
            $data_log['message'] = "Job Sharing Service UnSubscribe Successfully";
            $jobsharing->writeJobSharingLog($data_log);
            JSJOBSActionMessages::setMessage('Job sharing service unsubscribe successfully', 'jobsharing','message');
        } else {
            $data_log['messagetype'] = 'Error';
            $data_log['message'] = "Error Job Sharing Service UnSubscribe";
            $jobsharing->writeJobSharingLog($data_log);
            JSJOBSActionMessages::setMessage('Error in unsubscribe job sharing service', 'jobsharing','error');
        }
        $link = 'index.php?option=com_jsjobs&c=jobsharing&view=jobsharing&layout=jobshare';
        $this->setRedirect($link);
    }

    function requestjobsharing() {
        JRequest::checkToken() or die( 'Invalid Token' );
        $user = JFactory::getUser();
        $uid = $user->id;
        $session = JFactory::getSession();
        $fortask = "requestjobsharing";
        $data = JRequest::get('post');
        $auth_key = $data['authenticationkey'];
        $ip = $data['ip'];
        $domain = $data['domain'];
        $siteurl = $data['siteurl'];
        $auth_key = $data['authenticationkey'];
        $cms = 'joomla';
        $clientversion = $this->getModel('Configuration', 'JSJobsModel')->getConfigValue('versioncode');
        $data_array = array("ip" => $ip, "domainname" => $domain, 'siteurl' => $siteurl, 'authkey' => $auth_key,'cms'=>$cms,'jobsversion'=>$clientversion);
        $jsondata = json_encode($data_array);
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $returnvalue = $jobsharing->storeRequestJobSharing($jsondata, $fortask);
        $event = "requestjobsharing";
        $eventtype = "requestjobsharing";
        $data_log = array();
        $data_log['uid'] = $uid;
        $data_log['event'] = $event;
        $data_log['eventtype'] = $eventtype;
        $data_log['datetime'] = date('Y-m-d H:i:s');
        if (isset($returnvalue['status']) AND $returnvalue['status'] == 'authkeynotexists') {
            $data_log['messagetype'] = 'Error';
            $data_log['message'] = "Admin request for the JobSharingService and the key is" . ' "' . $auth_key . '"';
            $jobsharing->writeJobSharingLog($data_log);
            $textvar = JText::_('Your key is incorrect or does not exists').','.JText::_('Please enter correct key');
            JSJOBSActionMessages::setMessage($textvar, 'jobsharing','warning');
            $link = 'index.php?option=com_jsjobs&c=jobsharing&view=jobsharing&layout=jobshare';
            $this->setRedirect($link);
        } elseif (isset($returnvalue['status']) AND $returnvalue['status'] == 'authkeyexists') {
            $return_value = explode('/', $returnvalue['value']);
            $authkey = $return_value[1];
            $this->getJSController('synchronize')->startSynchronizeProcess($authkey);
            $data_log['messagetype'] = 'Sucessfully';
            $data_log['message'] = "Job Sharing Service Subscribe Successfully";
            $jobsharing->writeJobSharingLog($data_log);
        } elseif (isset($returnvalue['status']) AND $returnvalue['status'] == 'Curlerror') {
            $data_log['messagetype'] = 'Error';
            $data_log['message'] = "Curl Not Responce ";
            $jobsharing->writeJobSharingLog($data_log);
            JSJOBSActionMessages::setMessage('CURL is not responding', 'jobsharing','warning');
            $link = 'index.php?option=com_jsjobs&c=jobsharing&view=jobsharing&layout=jobshare';
            $this->setRedirect($link);
        }
    }

    function updateclientauthenticationkey($clientkey) {
        $user = JFactory::getUser();
        $uid = $user->id;
        $key = $clientkey;
        $event = "requestjobsharing";
        $eventtype = "requestjobsharing";
        $messagetype = "Sucessfully";
        $data = array();
        $data['uid'] = $uid;
        $data['event'] = $event;
        $data['eventtype'] = $eventtype;
        $data['message'] = "Admin request for the JobSharingService and the key is" . ' "' . $key . '"';
        $data['messagetype'] = $messagetype;
        $data['datetime'] = date('Y-m-d H:i:s');
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $returnvalue = $jobsharing->updateClientAuthenticationKey($messagetype, $key);
        $jobsharing->writeJobSharingLog($data);
        if ($returnvalue == 1) {
            $result = JText::_('Job Sharing Service Has Been Activated Your Activation Key Is') . " '" . $key . "'";
            return $result;
        } elseif ($returnvalue == 0) {
            JSJOBSActionMessages::setMessage('You activation key is generate \''.$key.'\', but not update please try again late', 'jobsharing','notice');
        } elseif ($returnvalue == 2) {
            JSJOBSActionMessages::setMessage('Problem generate activation key', 'jobsharing','warning');
        } elseif ($returnvalue == 3) {
            JSJOBSActionMessages::setMessage('Error '.$key, 'jobsharing','error');
        }
        $link = 'index.php?option=com_jsjobs&c=jobsharing&view=jobsharing&layout=jobshare';
        $this->setRedirect($link);
    }

    function defaultaddressdatajobsharing() {
        $data = JRequest::getVar('data');
        $val = JRequest::getVar('val');
        $hasstate = JRequest::getVar('state', '');
        $jobsharing_model = $this->getmodel('Jobsharing', 'JSJobsModel');
        $returnvalue = $jobsharing_model->DefaultListAddressDataSharing($data, $val, $hasstate);
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory::getDocument();
        $viewName = JRequest::getVar('view', 'jobsharing');
        $layoutName = JRequest::getVar('layout', 'jobsharing');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $sharingservicelog_model = $this->getModel('Sharingservicelog', 'JSJobsModel');
        if (!JError::isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($sharingservicelog_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($sharingservicelog_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>
