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

class JSJobsModelEmailtemplate extends JSModel {

    var $_config = null;
    var $_defaultcurrency = null;
    var $_client_auth_key = null;
    var $_siteurl = null;

    function __construct() {
        parent::__construct();
        $this->_client_auth_key = $this->getJSModel('jobsharing')->getClientAuthenticationKey();
        $this->_siteurl = JURI::root();
        $this->_defaultcurrency = $this->getJSModel('currency')->getDefaultCurrency();
        $user = JFactory::getUser();
        $this->_uid = $user->id;
    }

    function getTemplate($tempfor) {
        $db = JFactory::getDBO();
        switch ($tempfor) {
            case 'ew-cm' : $tempatefor = 'company-new';
                break;
            case 'cm-ap' : $tempatefor = 'company-approval';
                break;
            case 'cm-rj' : $tempatefor = 'company-rejecting';
                break;
            case 'ew-ob' : $tempatefor = 'job-new';
                break;
            case 'ew-ob-em' : $tempatefor = 'job-new-employer';
                break;
            case 'ob-ap' : $tempatefor = 'job-approval';
                break;
            case 'ob-rj' : $tempatefor = 'job-rejecting';
                break;
            case 'ap-rs' : $tempatefor = 'applied-resume_status';
                break;
            case 'ew-rm' : $tempatefor = 'resume-new';
                break;
            case 'rm-ap' : $tempatefor = 'resume-approval';
                break;
            case 'rm-rj' : $tempatefor = 'resume-rejecting';
                break;
            case 'ba-ja' : $tempatefor = 'jobapply-jobapply';
                break;
            case 'ew-md' : $tempatefor = 'department-new';
                break;
            case 'ew-rp' : $tempatefor = 'employer-buypackage';
                break;
            case 'ew-js' : $tempatefor = 'jobseeker-buypackage';
                break;
            case 'ms-sy' : $tempatefor = 'message-email';
                break;
            case 'jb-at' : $tempatefor = 'job-alert';
                break;
            case 'jb-at-vis' : $tempatefor = 'job-alert-visitor';
                break;
            case 'jb-to-fri' : $tempatefor = 'job-to-friend';
                break;
            case 'jb-pkg-pur' : $tempatefor = 'jobseeker-packagepurchase';
                break;
            case 'emp-pkg-pur' : $tempatefor = 'employer-packagepurchase';
                break;
            case 'cm-dl' : $tempatefor = 'company-delete';
                break;
            case 'ob-dl' : $tempatefor = 'job-delete';
                break;
            case 'rm-dl' : $tempatefor = 'resume-delete';
                break;
            case 'js-ja' : $tempatefor = 'jobapply-jobseeker';
                break;
            case 'ew-rm-vis' : $tempatefor = 'resume-new-vis';
                break;

        }
        $query = "SELECT * FROM `#__js_job_emailtemplates` WHERE templatefor = " . $db->Quote($tempatefor);
        $db->setQuery($query);
        $template = $db->loadObject();
        return $template;
    }

    function getEmailTemplateOptionsForView(){
        $db = JFactory::getDBO();
        $query = "SELECT * FROM `#__js_job_emailtemplates_config`";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        $options = array();
        foreach ($rows as $row) {
            $options[$row->emailfor] = $row;
        }
        return $options;        
    }

    function updateEmailTemplateOption($emailfor , $for){
        switch ($for) {
            case '1': $settingfor = 'employer'; break;
            case '2': $settingfor = 'jobseeker'; break;
            case '3': $settingfor = 'admin'; break;
            case '4': $settingfor = 'jobseeker_visitor'; break;
            case '5': $settingfor = 'employer_visitor'; break;
        }
        if(! isset($settingfor))
            return false;

        if( empty($emailfor))
            return false;

        $db = JFactory::getDBO();
        $query = "UPDATE `#__js_job_emailtemplates_config` SET `$settingfor` = ( 1 -  `$settingfor`) WHERE `emailfor` = '$emailfor'";
        $db->setQuery($query);
        $db->query();
        return SAVED;
    }

    function getEmailOption($emailfor , $for){
        if(empty($emailfor))
            return false;
        $array = array('employer', 'jobseeker', 'admin', 'jobseeker_visitor', 'employer_visitor');
        if( ! in_array($for, $array))
            return false;

        $db = JFactory::getDBO();
        $query = "SELECT `$for` FROM `#__js_job_emailtemplates_config` WHERE `emailfor` = '$emailfor'";
        $db->setQuery($query);
        $result = $db->loadResult();
        return $result;
    }

    function storeEmailTemplate() {
        JRequest::checkToken() or die( 'Invalid Token' );
        $row = $this->getTable('emailtemplate');

        $data = JRequest::get('post');
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);  // Sanitize entire array to string
        $data['body'] = $this->getJSModel('common')->getHtmlInput('body');

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

        return true;
    }


    function sendMail($for, $action, $id ) {

        //action, 1 = job approved, 2 = job reject 6, resume approved, 7 resume reject
        $db = JFactory::getDBO();
        $app = JApplication::getInstance('site');
        $router = $app->getRouter();
        $siteAddress = JURI::root();

        if ($for == 1) { //company
            $result = $this->getEmailOption('company_status' , 'employer');
            if($result != 1)
                return '';
            if ($action == 1) { // company approved
                $templatefor = 'company-approval';
            } elseif ($action == -1) { //company reject
                $templatefor = 'company-rejecting';
            }
        } elseif ($for == 2) { //job
            $result = $this->getEmailOption('job_status' , 'employer');
            if($result != 1)
                return '';
            if ($action == 1) { // job approved
                $templatefor = 'job-approval';
            } elseif ($action == -1) { // job reject
                $templatefor = 'job-rejecting';
            }
        } elseif ($for == 3) { // resume
            $result = $this->getEmailOption('resume_status' , 'jobseeker');
            if($result != 1)
                return '';
            if ($action == 1) { //resume approved
                $templatefor = 'resume-approval';
            } elseif ($action == -1) { // resume reject
                $templatefor = 'resume-rejecting';
            }
        } elseif ($for == 4) {// visitor job
            return '';
        }
        
        $query = "SELECT template.* FROM `#__js_job_emailtemplates` AS template WHERE template.templatefor = " . $db->Quote($templatefor);
        $db->setQuery($query);
        $template = $db->loadObject();
        $msgSubject = $template->subject;
        $msgBody = $template->body;
        if ($for == 1) { //company
            if(!is_numeric($id)) return false;
            $query = "SELECT company.name, company.contactname, company.contactemail,CONCAT(company.alias,'-',company.id) AS aliasid 
                FROM `#__js_job_companies` AS company
                WHERE company.id = " . $id;

            $db->setQuery($query);
            $company = $db->loadObject();

            $Name = $company->contactname;
            $Email = $company->contactemail;
            $companyName = $company->name;

            $msgSubject = str_replace('{COMPANY_NAME}', $companyName, $msgSubject);
            $msgSubject = str_replace('{EMPLOYER_NAME}', $Name, $msgSubject);
            $msgBody = str_replace('{COMPANY_NAME}', $companyName, $msgBody);
            $msgBody = str_replace('{EMPLOYER_NAME}', $Name, $msgBody);
            if ($action == 1) {
                $newUrl = JURI::root().'index.php?option=com_jsjobs&c=company&view=company&layout=view_company&vm=1&cd=' . $company->aliasid;
                //$newUrl = $router->build($newUrl);
                $parsed_url = $newUrl;
                $parsed_url = str_replace('/administrator', '', $parsed_url);
                $companylink = '<br><a href="' . $parsed_url . '" target="_blank" >' . JText::_('Company') . '</a>';
                $msgBody = str_replace('{COMPANY_LINK}', $companylink, $msgBody);
            }else{
                $msgBody = str_replace('{COMPANY_LINK}', '', $msgBody);
                }
        } elseif ($for == 2) { //job
            if(!is_numeric($id)) return false;
            $query = "SELECT job.uid, job.title, company.contactname, company.contactemail,CONCAT(job.alias,'-',job.id) AS aliasid
                        FROM `#__js_job_jobs` AS job
                        JOIN `#__js_job_companies` AS company ON job.companyid = company.id
                WHERE job.id = " . $id;
            $db->setQuery($query);
            $job = $db->loadObject();

            $Name = $job->contactname;
            $Email = $job->contactemail;
            $jobTitle = $job->title;
            $msgSubject = str_replace('{JOB_TITLE}', $jobTitle, $msgSubject);
            $msgSubject = str_replace('{EMPLOYER_NAME}', $Name, $msgSubject);
            $msgBody = str_replace('{JOB_TITLE}', $jobTitle, $msgBody);
            $msgBody = str_replace('{EMPLOYER_NAME}', $Name, $msgBody);
            if ($action == 1) {
                $newUrl = JURI::root().'index.php?option=com_jsjobs&c=job&view=job&layout=view_job&vj=1&bd=' . $job->aliasid;
            } else {
                $newUrl = JURI::root().'index.php?option=com_jsjobs&c=job&view=job&layout=myjobs';
            }
            //$newUrl = $router->build($newUrl);
            $parsed_url = $newUrl;
            $parsed_url = str_replace('/administrator', '', $parsed_url);
            $joblink = '<br><a href="' . $parsed_url . '" target="_blank" >' . JText::_('Job') . '</a>';
            $msgBody = str_replace('{JOB_LINK}', $joblink, $msgBody);
        } elseif ($for == 3) { // resume
            if(!is_numeric($id)) return false;
            $query = "SELECT app.application_title, app.first_name, app.middle_name, app.last_name, app.email_address,CONCAT(app.alias,'-',app.id) AS aliasid 
                        FROM `#__js_job_resume` AS app
                        WHERE app.id = " . $id;

            $db->setQuery($query);
            $app = $db->loadObject();

            $Name = $app->first_name;
            if ($app->middle_name)
                $Name .= " " . $app->middle_name;
            if ($app->last_name)
                $Name .= " " . $app->last_name;
            $Email = $app->email_address;
            $resumeTitle = $app->application_title;
            $msgSubject = str_replace('{RESUME_TITLE}', $resumeTitle, $msgSubject);
            $msgSubject = str_replace('{JOBSEEKER_NAME}', $Name, $msgSubject);
            $msgBody = str_replace('{RESUME_TITLE}', $resumeTitle, $msgBody);
            $msgBody = str_replace('{JOBSEEKER_NAME}', $Name, $msgBody);
            if ($action == 1) {
                $newUrl = JURI::root().'index.php?option=com_jsjobs&c=resume&view=resume&layout=view_resume&vm=1&rd=' . $app->aliasid.'&nav=1';
            } else {
                $newUrl = JURI::root().'index.php?option=com_jsjobs&c=resume&view=resume&layout=myresumes';
            }
            //$newUrl = $router->build($newUrl);
            $parsed_url = $newUrl;
            $parsed_url = str_replace('/administrator', '', $parsed_url);
            $resumelink = '<br><a href="' . $parsed_url . '" target="_blank" >' . JText::_('Resume') . '</a>';
            $msgBody = str_replace('{RESUME_LINK}', $resumelink, $msgBody);
        } elseif ($for == 4) {

        }

        if (!$this->_config)
            $this->_config = $this->getJSModel('configuration')->getConfig();
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'mailfromname')
                $senderName = $conf->configvalue;
            if ($conf->configname == 'mailfromaddress')
                $senderEmail = $conf->configvalue;
        }

        $message = JFactory::getMailer();
        if(!empty($Email)){
            $message->addRecipient($Email); //to email
            $message->setSubject($msgSubject);
            $message->setBody($msgBody);
            $sender = array($senderEmail, $senderName);
            $message->setSender($sender);
            $message->IsHTML(true);
            $sent = $message->send();
        }
        return true;
    }

    function sendDeleteMail( $id , $for) {

        $db = JFactory::getDBO();

        if ($for == 1) { //company
            $result = $this->getEmailOption('company_delete' , 'employer');
            if($result != 1)
                return '';
            $templatefor = 'company-delete';
        } elseif ($for == 2) { //job
            $result = $this->getEmailOption('job_delete' , 'employer');
            if($result != 1)
                return '';
            $templatefor = 'job-delete';
        } elseif ($for == 3) { // resume
            $result = $this->getEmailOption('resume_delete' , 'jobseeker');
            if($result != 1)
                return '';
            $templatefor = 'resume-delete';
        }
        
        $query = "SELECT template.* FROM `#__js_job_emailtemplates` AS template	WHERE template.templatefor = " . $db->Quote($templatefor);
        $db->setQuery($query);
        $template = $db->loadObject();
        $msgSubject = $template->subject;
        $msgBody = $template->body;
        if ($for == 1) { //company

            $session = JFactory::getSession();
            $Name = $session->get('contactname');
            $Email = $session->get('contactemail');
            $companyName = $session->get('name');

            $msgSubject = str_replace('{COMPANY_NAME}', $companyName, $msgSubject);
            $msgBody = str_replace('{COMPANY_NAME}', $companyName, $msgBody);
            $msgBody = str_replace('{COMPANY_OWNER_NAME}', $Name, $msgBody);

        } elseif ($for == 2) { //job

            $session = JFactory::getSession();
            $Name = $session->get('contactname');
            $companyname = $session->get('companyname');
            $Email = $session->get('contactemail');
            $jobTitle = $session->get('title');

            $msgSubject = str_replace('{JOB_TITLE}', $jobTitle, $msgSubject);
            $msgBody = str_replace('{JOB_TITLE}', $jobTitle, $msgBody);
            $msgBody = str_replace('{EMPLOYER_NAME}', $Name, $msgBody);
            $msgBody = str_replace('{COMPANY_NAME}', $companyname, $msgBody);

        } elseif ($for == 3) { // resume

            $session = JFactory::getSession();
            $Name = $session->get('name');
            $Email = $session->get('email_address');
            $resumeTitle = $session->get('application_title');

            $msgSubject = str_replace('{RESUME_TITLE}', $resumeTitle, $msgSubject);
            $msgBody = str_replace('{RESUME_TITLE}', $resumeTitle, $msgBody);
            $msgBody = str_replace('{JOBSEEKER_NAME}', $Name, $msgBody);
        }

        if (!$this->_config)
            $this->_config = $this->getJSModel('configuration')->getConfig();
        foreach ($this->_config as $conf) {
            if ($conf->configname == 'mailfromname')
                $senderName = $conf->configvalue;
            if ($conf->configname == 'mailfromaddress')
                $senderEmail = $conf->configvalue;
        }

        $message = JFactory::getMailer();
        if(!empty($Email)){
            $message->addRecipient($Email); //to email
            $message->setSubject($msgSubject);
            $message->setBody($msgBody);
            $sender = array($senderEmail, $senderName);
            $message->setSender($sender);
            $message->IsHTML(true);
            $sent = $message->send();
        }
        return true;
    }
}
?>