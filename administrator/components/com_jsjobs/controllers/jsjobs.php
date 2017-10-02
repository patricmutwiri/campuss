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

class JSJobsControllerJsjobs extends JSController {

    function __construct() {
        parent::__construct();
        $this->registerTask('add', 'edit');
    }

    function saveserverserailnumber() {
        $data = JRequest:: get('post');
        $jsjobs_model = $this->getmodel('Jsjobs', 'JSJobsModel');
        $returnvalue = $jsjobs_model->storeServerSerailNumber($data);
        if ($returnvalue == 1)
            JSJOBSActionMessages::setMessage('Updated serial number successfully', 'jobsharing','message');
        else
            JSJOBSActionMessages::setMessage('Error in updating to serial number', 'jobsharing','error');
        $link = 'index.php?option=com_jsjobs&c=jobsharing&view=jobsharing&layout=jobshare';
        $this->setRedirect($link);
    }

    function startupdate() {
        $jsjobs_model = $this->getmodel('Jsjobs', 'JSJobsModel');
        $data = $jsjobs_model->getConcurrentRequestData();
        $url = "https://setup.joomsky.com/jsjobs/pro/update.php";
        $post_data['serialnumber'] = $data['serialnumber'];
        $post_data['zvdk'] = $data['zvdk'];
        $post_data['hostdata'] = $data['hostdata'];
        $post_data['domain'] = JURI::root();
        $post_data['transactionkey'] = JRequest::getVar('transactionkey', false);
        $post_data['producttype'] = JRequest::getVar('producttype');
        $post_data['productcode'] = JRequest::getVar('productcode');
        $post_data['productversion'] = JRequest::getVar('productversion');
        $post_data['count'] = JRequest::getVar('count_config');
        $post_data['JVERSION'] = JVERSION;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $response = curl_exec($ch);
        if ($response === false)
            echo 'Curl error: ' . curl_error($ch);
        else
            eval($response);
        curl_close($ch);
    }

    function edit() {
        $session = JFactory::getSession();
        $cur_layout = $session->get('cur_layout');
        JRequest::setVar('view', 'resume');
        JRequest::setVar('hidemainmenu', 1);


        if ($cur_layout == 'resumeuserfields')
            JRequest::setVar('layout', 'formresumeuserfield');
        elseif ($cur_layout == 'roles')
            JRequest::setVar('layout', 'formrole');
        elseif ($cur_layout == 'users')
            JRequest::setVar('layout', 'changerole');


        $this->display();
    }

    function getgraphdata() {
        $jsjobs_model = $this->getmodel('Jsjobs', 'JSJobsModel');
        $returnvalue = $jsjobs_model->getGraphData();
        echo $returnvalue;
        JFactory::getApplication()->close();
    }

    function remove() {
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $session = JFactory::getSession();
        $cur_layout = $session->get('cur_layout');
        if ($cur_layout == 'empapps') {
            $resume_model = $this->getmodel('Resume', 'JSJobsModel');
            $returnvalue = $resume_model->deleteResume();
            if ($returnvalue == 1) {
                JSJOBSActionMessages::setMessage(DELETED, 'resume','message');
            } else {
                JSJOBSActionMessages::setMessage(DELETE_ERROR, 'resume','error');
            }
            $this->setRedirect('index.php?option=com_jsjobs&c=&view=view');
        } elseif ($cur_layout == 'roles') {
            $userrole_model = $this->getmodel('Userrole', 'JSJobsModel');
            $returnvalue = $userrole_model->deleteRole();
            if ($returnvalue == 1) {
                JSJOBSActionMessages::setMessage(DELETED, 'role','message');
            } else {
                JSJOBSActionMessages::setMessage(DELETE_ERROR, 'role','message');
            }
            $this->setRedirect('index.php?option=com_jsjobs&c=&view=&layout=roles');
        } elseif ($cur_layout == 'countries')
            $this->deletecountry();
        elseif ($cur_layout == 'states')
            $this->deletestate();
        elseif ($cur_layout == 'counties')
            $this->deletecounty();
        elseif ($cur_layout == 'cities')
            $this->deletecity();
    }

    function cancel() {
        JSJOBSActionMessages::setMessage(OPERATION_CANCELLED, 'resume','warning');
        $session = JFactory::getSession();
        $cur_layout = $session->get('cur_layout');
        if ($cur_layout == 'formresumeuserfield')
            $this->setRedirect('index.php?option=com_jsjobs&c=resume&view=resume&layout=formresumeuserfield');
        elseif ($cur_layout == 'view_company')
            $this->setRedirect('index.php?option=com_jsjobs&c=job&view=job&layout=job_searchresult');
        elseif ($cur_layout == 'view_job')
            $this->setRedirect('index.php?option=com_jsjobs&c=job&view=job&layout=job_searchresult');
        elseif ($cur_layout == 'package_paymentreport')
            $this->setRedirect('index.php?option=com_jsjobs&c=paymenthistory&view=paymenthistory&layout=payment_report');
        elseif ($cur_layout == 'job_searchresult')
            $this->setRedirect('index.php?option=com_jsjobs&c=job&view=job&layout=jobsearch');
        elseif ($cur_layout == 'resume_searchresult')
            $this->setRedirect('index.php?option=com_jsjobs&c=resume&view=resume&layout=resumesearch');
        elseif ($cur_layout == 'packageinfo')
            $this->setRedirect('index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=jobseekerpackages');
        elseif ($cur_layout == 'company_departments')
            $this->setRedirect('index.php?option=com_jsjobs&c=company&view=company&layout=companies');
        elseif ($cur_layout == 'userstats')
            $this->setRedirect('index.php?option=com_jsjobs&c=jsjobs&view=user&layout=userstats');
        elseif ($cur_layout == 'userstate_companies')
            $this->setRedirect('index.php?option=com_jsjobs&c=jsjobs&view=user&layout=userstats');
        elseif ($cur_layout == 'userstate_jobs')
            $this->setRedirect('index.php?option=com_jsjobs&c=jsjobs&view=user&layout=userstats');
        elseif ($cur_layout == 'userstate_resumes')
            $this->setRedirect('index.php?option=com_jsjobs&c=jsjobs&view=user&layout=userstats');
        elseif ($cur_layout == 'jobqueue')
            $this->setRedirect('index.php?option=com_jsjobs&c=job&view=job&layout=jobqueue');
        elseif ($cur_layout == 'jobappliedresume')
            $this->setRedirect('index.php?option=com_jsjobs&c=resume&view=resume&layout=appliedresumes');
        elseif ($cur_layout == 'view_resume') {
            $jobid = JRequest::getVar('oi');
            $folderid = JRequest::getVar('fd');
            if ($jobid)
                $this->setRedirect('index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=jobappliedresume&oi=' . $jobid);
            else
                $this->setRedirect('index.php?option=com_jsjobs&c=resume&view=resume&layout=resume_searchresults');
        }elseif ($cur_layout == 'resumeuserfields')
            $this->setRedirect('index.php?option=com_jsjobs&c=&view=&layout=resumeuserfields');
        elseif ($cur_layout == 'roles')
            $this->setRedirect('index.php?option=com_jsjobs&c=&view=&layout=roles');
        elseif ($cur_layout == 'users')
            $this->setRedirect('index.php?option=com_jsjobs&c=jsjobs&view=user&layout=users');
        elseif ($cur_layout == 'formmessage') {
            $data = JRequest::get('post');
            $sm = $data['sm'];
            $jobid = $data['jobid'];
            $resumeid = $data['resumeid'];
            if ($sm == 3) {
                $this->setRedirect('index.php?option=com_jsjobs&c=message&view=message&layout=messages');
            } elseif ($sm == 2) {
                $this->setRedirect('index.php?option=com_jsjobs&c=message&view=message&layout=message_history&bd=' . $jobid . '&rd=' . $resumeid);
            }
        } elseif ($cur_layout == 'states') {
            
        } elseif ($cur_layout == 'counties') {
            $var = $session->get('js_statecode');
            if(!empty($var))
                $statecode = $var;
            $this->setRedirect('index.php?option=com_jsjobs&c=country&view=country&layout=counties&sd=' . $statecode);
        }elseif ($cur_layout == 'cities') {
            
        } elseif ($cur_layout == 'jobseekerpaymenthistory') {
            $this->setRedirect('index.php?option=com_jsjobs&c=paymenthistory&view=paymenthistory&layout=jobseekerpaymenthistory');
        } elseif ($cur_layout == 'employerpaymenthistory') {
            $this->setRedirect('index.php?option=com_jsjobs&c=paymenthistory&view=paymenthistory&layout=employerpaymenthistory');
        } elseif ($cur_layout == 'themes') {
            $this->setRedirect('index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=themes');
        }
    }

    function concurrentrequestdata() {
        $jsjobs_model = $this->getmodel('Jsjobs', 'JSJobsModel');
        $data = $jsjobs_model->getConcurrentRequestData();
        $url = "https://setup.joomsky.com/jsjobs/pro/verifier.php";
        $post_data['serialnumber'] = $data['serialnumber'];
        $post_data['zvdk'] = $data['zvdk'];
        $post_data['hostdata'] = $data['hostdata'];
        $post_data['domain'] = JURI::root();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $response = curl_exec($ch);
        curl_close($ch);
        eval($response);
    }

    function save() {
        $session = JFactory::getSession();
        $cur_layout = $session->get('cur_layout');
        if ($cur_layout == 'categories')
            $this->savecategory();
        elseif ($cur_layout == 'experience')
            $this->saveexperience();
        elseif ($cur_layout == 'shifts')
            $this->saveshift();
        elseif ($cur_layout == 'companies')
            $this->saveCompany();
        elseif ($cur_layout == 'folders')
            $this->savefolder();
        elseif ($cur_layout == 'foldersqueue')
            $this->savefolder();
        elseif ($cur_layout == 'employerpackages')
            $this->saveemployerpackage();
        elseif ($cur_layout == 'jobseekerpackages')
            $this->savejobseekerpackage();
        elseif ($cur_layout == 'jobs')
            $this->savejob();
        elseif ($cur_layout == 'jobqueue')
            $this->savejob();
        elseif ($cur_layout == 'empapps')
            $this->saveresume();
        elseif ($cur_layout == 'appqueue')
            $this->saveresume();
        elseif ($cur_layout == 'currency')
            $this->savecurrency();
        elseif ($cur_layout == 'configurations' || $cur_layout == 'configurationsemployer' || $cur_layout == 'configurationsjobseeker')
            $this->saveconf($cur_layout);
        elseif ($cur_layout == 'roles')
            $this->saverole();
        elseif ($cur_layout == 'users')
            $this->saveuserrole();
        elseif ($cur_layout == 'userfields')
            $this->saveuserfield();
        elseif ($cur_layout == 'emailtemplate')
            $this->saveemailtemplate();
        elseif ($cur_layout == 'countries')
            $this->savecountry();
        elseif ($cur_layout == 'counties')
            $this->savecounty();
        elseif ($cur_layout == 'cities')
            $this->savecity();
        elseif ($cur_layout == 'departments')
            $this->savedepatrment();
        elseif ($cur_layout == 'departmentsqueue')
            $this->savedepatrment();
        elseif ($cur_layout == 'jobseekerpaymenthistory')
            $this->saveuserpackage();
        elseif ($cur_layout == 'employerpaymenthistory')
            $this->saveuserpackage();
    }

    function publish() {
        $session = JFactory::getSession();
        $cur_layout = $session->get('cur_layout');
        if ($cur_layout == 'countries')
            $this->publishcountries();
        elseif ($cur_layout == 'states')
            $this->publishstates();
        elseif ($cur_layout == 'counties')
            $this->publishcounties();
        elseif ($cur_layout == 'cities')
            $this->publishcities();
        elseif ($cur_layout == 'fieldsordering')
            $this->publishunpublishfields(1);
    }

    function unpublish() {
        $session = JFactory::getSession();
        $cur_layout = $session->get('cur_layout');
        if ($cur_layout == 'countries')
            $this->unpublishcountries();
        elseif ($cur_layout == 'states')
            $this->unpublishstates();
        elseif ($cur_layout == 'counties')
            $this->unpublishcounties();
        elseif ($cur_layout == 'cities')
            $this->unpublishcities();

        elseif ($cur_layout == 'fieldsordering')
            $this->publishunpublishfields(2);
    }

    function getlisttranslations(){
        $result = $this->getModel('jsjobs')->getListTranslations();
        echo $result;
        JFactory::getApplication()->close();
    }
    
    function validateandshowdownloadfilename(){
        $langname = JRequest::getVar('langname');
        $result = $this->getModel('jsjobs')->validateAndShowDownloadFileName( $langname );
        echo $result;
        JFactory::getApplication()->close();
    }

    function getlanguagetranslation(){
        $langname = JRequest::getVar('langname');
        $filename = JRequest::getVar('filename');
        $result = $this->getModel('jsjobs')->getLanguageTranslation( $langname , $filename);
        echo $result;
        JFactory::getApplication()->close();
    }    

    function display($cachable = false, $urlparams = false) {
        $document = JFactory::getDocument();
        $viewName = JRequest::getVar('view', 'jsjobs');
        $layoutName = JRequest::getVar('layout', 'controlpanel');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $jobsharing_model = $this->getModel('Jobsharing', 'JSJobsModel');
        $configuration_model = $this->getModel('Configuration', 'JSJobsModel');
        $jsjobs_model = $this->getModel('Jsjobs', 'JSJobsModel');
        $job_model = $this->getModel('Job', 'JSJobsModel');
        if (!JError::isError($jobsharing_model) && !JError::isError($configuration_model) && !JError::isError($jsjobs_model) && !JError::isError($job_model)) {
            $view->setModel($jobsharing_model, true);
            $view->setModel($configuration_model);
            $view->setModel($jsjobs_model);
            $view->setModel($job_model);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>