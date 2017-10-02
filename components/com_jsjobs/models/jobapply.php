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

class JSJobsModelJobApply extends JSModel {

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

    function applyJob($jobid) {
        if (!is_numeric($jobid))
            return false;
        $validate = $this->getJSModel('permissions')->checkPermissionsFor('APPLY_JOB');
        if ($validate == VALIDATE) {
            $uid = JFactory::getUser()->id;
            $db = $this->getDbo();
            $query = "SELECT COUNT(id) FROM `#__js_job_resume` WHERE status = 1 AND uid = " . $uid;
            $db->setQuery($query);
            $result = $db->loadResult();
            
            if ($result > 0) {
                $fieldsordering = $this->getJSModel('customfields')->getFieldsOrdering(2);
                $fieldsordering = $this->getJSModel('customfields')->parseFieldsOrderingForView($fieldsordering);
                $jobresult = $this->getJobbyIdforJobApply($jobid);
                $result = $this->getJSModel('resume')->getMyResumes($uid);
                if( ! $result[3]){ // if coverletters
                    $result[2] = '<a id="pop_cvltr" href="index.php?option=com_jsjobs&c=coverletter&view=coverletter&layout=formcoverletter&Itemid='.JRequest::getVar('Itemid').'">'.JText::_('Add Cover Letter').'</a>';
                }
                $html = '
                        <div id="js_main_wrapper">
                            <div class="js_job_form_field_wrapper">
                              <div id="waiting-wrapper">
                              </div>
                                <div class="jsjobs_jobapply_wrapper">
                                    <div class="js-col-xs-12 js-col-md-6">
                                        <div class="jsjobapply_title">
                                            ' . JText::_('My Resume') . '
                                        </div>
                                        <div class="jsjobapply_value">
                                            ' . $result[0] . '
                                        </div>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-6">
                                        <div class="jsjobapply_title">
                                            ' . JText::_('My Cover Letter') . '
                                        </div>
                                        <div class="jsjobapply_value">
                                            ' . $result[2] . '
                                        </div>
                                    </div>
                                </div>
                                <div class="js_job_form_button">
                                    <input type="hidden" id="jobapply_jobid" class="jobid" value="' . $jobid . '" />
                                    <input type="hidden" id="jobapply_uid" value="' . $uid . '" />
                                    <input type="submit" class="js_job_form_button" id="js_job_applynow_button" value="' . JText::_('Apply Now') . '" />
                                    <input type="submit" class="js_job_form_button" id="js_job_applynow_close" value="' . JText::_('Close') . '" />
                                </div>
                            </div>
                        <div id="js_jobapply_main_wrapper"> </div>
                        <span class="jsjobs_job_in_formation">' . JText::_('Job Information') . '</span>';
                if (isset($fieldsordering['jobtitle']) && $fieldsordering['jobtitle'] == 1) {
                    $html .= '
                            <div class="js_job_data_jobapply">
                                <span class="js_job_data_apply_title"> ' . JText::_('Title') . ':   </span>
                                <span class="js_job_data_apply_value">' . $jobresult[0]->title . '</span>
                            </div>';
                }
                if (isset($fieldsordering['company']) && $fieldsordering['company'] == 1) {
                    $html .= '                           
                            <div class="js_job_data_jobapply">
                                <span class="js_job_data_apply_title"> ' . JText::_('Company') . ':   </span>
                                <span class="js_job_data_apply_value">' . $jobresult[0]->companyname . '</span>
                            </div>';
                }
                if (isset($fieldsordering['jobstatus']) && $fieldsordering['jobstatus'] == 1) {
                    $html .= '
                            <div class="js_job_data_jobapply">
                                <span class="js_job_data_apply_title"> ' . JText::_('Job Status') . ':   </span>
                                <span class="js_job_data_apply_value">' . $jobresult[0]->jobstatustitle . '</span>
                            </div>';
                }
                if (isset($fieldsordering['city']) && $fieldsordering['city'] == 1) {
                    $html .= '
                            <div class="js_job_data_jobapply">
                                <span class="js_job_data_apply_title"> ' . JText::_('Location') . ':   </span>
                                <span class="js_job_data_apply_value">' . $jobresult[0]->multicity . '</span>
                            </div>';
                }
                $html .= '
                        <div class="js_job_data_jobapply">
                            <span class="js_job_data_apply_title"> ' . JText::_('Posted') . ':   </span>
                            <span class="js_job_data_apply_value">' . date($this->getJSModel('configurations')->getConfigValue('date_format'), strtotime($jobresult[0]->created)) . '</span>
                        </div>
                        </div>
                        <script type="text/javascript">
                            jQuery("input#js_job_applynow_button").click(function(e){
                                jQuery("div#waiting-wrapper").show();
                                var jobid = jQuery("input#jobapply_jobid").val();
                                var uid = jQuery("input#jobapply_uid").val();
                                var cvid = jQuery("select#cvid").val();
                                var coverletterid = jQuery("select#coverletterid").val();
                                jQuery.post("'.JURI::root().'index.php?option=com_jsjobs&task=jobapply.jobapplyajax",{jobid:jobid,cvid:cvid,coverletterid:coverletterid,uid:uid},function(data){
                                   if(data){
                                       jQuery("div#js_jobapply_main_wrapper").html(data);
                                       jQuery("div#waiting-wrapper").hide();
                                       jQuery("div#js_jobapply_main_wrapper").slideDown();
                                   } 
                                });
                            });
                            jQuery("input#js_job_applynow_close").click(function(e){
                                jQuery("div#js_jobs_main_popup_area").slideUp("slow");
                                setTimeout(function () {
                                    jQuery("div#js_jobs_main_popup_back").hide();
                                    jQuery("div#jspopup_work_area").html("");
                                }, 700);
                            });
                        </script>
                        ';
                return $html;
            } else {
                $messagepath = JPATH_COMPONENT.'/views/messages.php';
                require_once($messagepath);
                $jsjobsmessages = new JSJobsMessages();
                $addres_link = '<a href="index.php?option=com_jsjobs&view=resume&layout=formresume&Itemid='.JRequest::getVar('Itemid').'">'.('Add Resume').'</a>';
                $html = $jsjobsmessages->getAccessDeniedMsg_return( JText::_('You do not have any resume'),JText::_('Please add resume to apply job'),$addres_link);
                return $html;
            }
        } else {
            $links = '';
            switch ($validate) {
                case NO_PACKAGE:
                    $text1 = JText::_('You do not have package');
                    $text2 = JText::_('Package is required to perform this action, please get package');
                    $links = '<a class="js_job_message_button" href="'.JRoute::_('index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=packages&Itemid=' . JRequest::getVar('Itemid') ,false) . '" >' . JText::_('Packages') . '</a>';
                    break;
                case EXPIRED_PACKAGE:
                    $text1 = JText::_('Your current package is expired');
                    $text2 = JText::_('Package is required to perform this action and your current package is expired, please get new package');
                    $links = '<a class="js_job_message_button" href="'.JRoute::_('index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=packages&Itemid=' . JRequest::getVar('Itemid') ,false) . '" >' . JText::_('Packages') . '</a>';
                    break;
                case JOB_APPLY_LIMIT_EXCEEDS:
                    $text1 = JText::_('Your job apply limit is exceeded');
                    $text2 = JText::_('Your job apply limit exceeded, you can not apply to this job');
                    $links = '<a class="js_job_message_button" href="'.JRoute::_('index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=packages&Itemid=' . JRequest::getVar('Itemid') ,false) . '" >' . JText::_('Packages') . '</a>';
                    break;
                case VISITOR_NOT_ALLOWED_JOBSEEKER_PRIVATE_AREA:
                    $jobaliasid = $this->getJSModel('common')->removeSpecialCharacter($jobid);
                    $link = "index.php?option=com_jsjobs&c=job&view=job&layout=view_job&nav=15&bd=" . $jobaliasid . "&Itemid=" . JRequest::getVar('Itemid');
                    $redirectUrl = $this->getJSModel('common')->b64ForEncode($link);
                    $redirectUrl = urlencode($redirectUrl);
                    $redirectUrl = '&return=' . $redirectUrl;
                    $joomlaLoginUrl = 'index.php?option=com_users&view=login';
                    $finalUrl = $joomlaLoginUrl . $redirectUrl;
                    $link2 = JRoute::_('index.php?option=com_jsjobs&c=common&view=common&layout=userregister&userrole=1&Itemid=' . JRequest::getVar('Itemid') ,false);

                    $text1 = JText::_('You are not logged in');
                    $text2 = JText::_('Please login to access private area');
                    $links = '<a href="' . $finalUrl . '" >' . JText::_('Login') . '</a>';
                    break;
                case EMPLOYER_NOT_ALLOWED_JOBSEEKER_PRIVATE_AREA:
                    $text1 = JText::_('Employer not allow');
                    $text2 = JText::_('Employer is not allowed in job seeker private area');
                    break;
            }

            $messagepath = JPATH_COMPONENT.'/views/messages.php';
            require_once($messagepath);
            $jsjobsmessages = new JSJobsMessages();

            $html = $jsjobsmessages->getAccessDeniedMsg_return( $text1, $text2 , $links);
            
            return $html;
        }
    }

    function getJobAppliedResume($needle_array, $u_id, $jobid, $tab_action, $sortby, $limit, $limitstart) {
        $db = $this->getDBO();
        if (is_numeric($u_id) == false)
            return false;
        if (is_numeric($jobid) == false)
            return false;
        $result = array();
        if ($this->_client_auth_key != "") {
            $fortask = "getjobappliedresume";
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $data['uid'] = $u_id;
            $data['jobid'] = $jobid;
            $data['sortby'] = $sortby;
            $data['limitstart'] = $limitstart;
            $data['limit'] = $limit;
            $data['authkey'] = $this->_client_auth_key;
            $data['siteurl'] = $this->_siteurl;
            $data['tab_action'] = $tab_action;
            if (!empty($needle_array)) {
                $needle_array = json_decode($needle_array, true);
                $data['tab_action'] = "";
            }
            $server_needle_query = "";
            if (isset($needle_array['title']) AND $needle_array['title'] != '')
                $server_needle_query.=" AND job_resume.application_title LIKE '%" . str_replace("'", "", $db->Quote($needle_array['title'])) . "%'";
            if (isset($needle_array['name']) AND $needle_array['name'] != '')
                $server_needle_query.=" AND LOWER(job_resume.first_name) LIKE " . $db->Quote('%' . $needle_array['name'] . '%');
            if (isset($needle_array['nationality']) AND $needle_array['nationality'] != '')
                $server_needle_query .= " AND job_resume.nationality = " . $needle_array['nationality'];
            if (isset($needle_array['gender']) AND $needle_array['gender'] != '')
                $server_needle_query .= " AND job_resume.gender = " . $needle_array['gender'];
            if (isset($needle_array['jobtype']) AND $needle_array['jobtype'] != '') {
                $server_jobtype_id = $this->getJSModel('common')->getServerid('jobtypes', $needle_array['jobtype']);
                $server_needle_query .= " AND job_resume.jobtype = " . $server_jobtype_id;
            }
            if (isset($needle_array['currency']) AND $needle_array['currency'] != '') {
                $server_currency_id = $this->getJSModel('common')->getServerid('currencies', $needle_array['currency']);
                $server_needle_query .= " AND job_resume.currencyid = " . $server_currency_id;
            }
            if (isset($needle_array['jobsalaryrange']) AND $needle_array['jobsalaryrange'] != '') {
                $server_jobsalaryrange = $this->getJSModel('common')->getServerid('salaryrange', $needle_array['jobsalaryrange']);
                $server_needle_query .= " AND job_resume.jobsalaryrange = " . $server_jobsalaryrange;
            }
            if (isset($needle_array['heighestfinisheducation']) AND $needle_array['heighestfinisheducation'] != '') {
                $server_heighestfinisheducation = $this->getJSModel('common')->getServerid('heighesteducation', $needle_array['heighestfinisheducation']);
                $server_needle_query .= " AND job_resume.heighestfinisheducation = " . $server_heighestfinisheducation;
            }
            if (isset($needle_array['iamavailable']) AND $needle_array['iamavailable'] != '') {
                $available = ($needle_array['iamavailable'] == "yes") ? 1 : 0;
                $server_needle_query .= " AND job_resume.iamavailable = " . $available;
            }
            if (isset($needle_array['jobcategory']) AND $needle_array['jobcategory'] != '') {
                $server_jobcategory = $this->getJSModel('common')->getServerid('categories', $needle_array['jobcategory']);
                $server_needle_query .= " AND job_resume.job_category = " . $server_jobcategory;
            }
            if (isset($needle_array['jobsubcategory']) AND $needle_array['jobsubcategory'] != '') {
                $server_jobsubcategory = $this->getJSModel('common')->getServerid('subcategories', $needle_array['jobsubcategory']);
                $server_needle_query .= " AND job_resume.job_subcategory = " . $server_jobsubcategory;
            }
            if (isset($needle_array['experience']) AND $needle_array['experience'] != '') {
                $server_needle_query .= " AND job_resume.total_experience LIKE " . $db->Quote($needle_array['experience']);
            }
            if (!empty($server_needle_query)) {
                $data['server_needle_query'] = $server_needle_query;
            }
            $encodedata = json_encode($data);
            $return_server_value = $jsjobsharingobject->serverTask($encodedata, $fortask);
            if (isset($return_server_value['jobappliedresume']) AND $return_server_value['jobappliedresume'] == -1) { // auth fail 
                $logarray['uid'] = $this->_uid;
                $logarray['referenceid'] = $return_server_value['referenceid'];
                $logarray['eventtype'] = $return_server_value['eventtype'];
                $logarray['message'] = $return_server_value['message'];
                $logarray['event'] = "Job Applied Resume";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jsjobsharingobject->write_JobSharingLog($logarray);
                $this->_applications = array();
                $total = 0;
                $jobtitle = "";
            } else {
                $parse_data = array();
                foreach ($return_server_value['relationjsondata'] AS $rel_data) {
                    $parse_data[] = (object) $rel_data;
                }
                $this->_applications = $parse_data;
                $total = $return_server_value['total'];
                $jobtitle = $return_server_value['jobtitle'];
                // resume count -> named as appCounts starts here 
                $resumeCountPerTab = $return_server_value['resumeCountPerTab'];
            }
        } else {
            if (!empty($needle_array)) {
                $needle_array = json_decode($needle_array, true);
                $tab_action = "";
            }
            $query = "SELECT COUNT(job.id)
            FROM `#__js_job_jobs` AS job
               , `#__js_job_jobapply` AS apply  
               , `#__js_job_resume` AS app  
               
            WHERE apply.jobid = job.id AND apply.cvid = app.id AND apply.jobid = " . $jobid;
            if ($tab_action)
                $query.=" AND apply.action_status=" . $tab_action;
            if (isset($needle_array['title']) AND $needle_array['title'] != '')
                $query.=" AND app.application_title LIKE '%" . str_replace("'", "", $db->Quote($needle_array['title'])) . "%'";
            if (isset($needle_array['name']) AND $needle_array['name'] != '')
                $query.=" AND LOWER(app.first_name) LIKE " . $db->Quote('%' . $needle_array['name'] . '%');
            if (isset($needle_array['nationality']) AND $needle_array['nationality'] != '')
                $query .= " AND app.nationality = " . $needle_array['nationality'];
            if (isset($needle_array['gender']) AND $needle_array['gender'] != '')
                $query .= " AND app.gender = " . $needle_array['gender'];
            if (isset($needle_array['jobtype']) AND $needle_array['jobtype'] != '')
                $query .= " AND app.jobtype = " . $needle_array['jobtype'];
            if (isset($needle_array['currency']) AND $needle_array['currency'] != '')
                $query .= " AND app.currencyid = " . $needle_array['currency'];
            if (isset($needle_array['jobsalaryrange']) AND $needle_array['jobsalaryrange'] != '')
                $query .= " AND app.jobsalaryrange = " . $needle_array['jobsalaryrange'];
            if (isset($needle_array['heighestfinisheducation']) AND $needle_array['heighestfinisheducation'] != '')
                $query .= " AND app.heighestfinisheducation = " . $needle_array['heighestfinisheducation'];
            if (isset($needle_array['iamavailable']) AND $needle_array['iamavailable'] != '') {
                $available = ($needle_array['iamavailable'] == "yes") ? 1 : 0;
                $query .= " AND app.iamavailable = " . $available;
            }
            if (isset($needle_array['jobcategory']) AND $needle_array['jobcategory'] != '')
                $query .= " AND app.job_category = " . $needle_array['jobcategory'];
            if (isset($needle_array['jobsubcategory']) AND $needle_array['jobsubcategory'] != '')
                $query .= " AND app.job_subcategory = " . $needle_array['jobsubcategory'];
            if (isset($needle_array['experience']) AND $needle_array['experience'] != '')
                $query .= " AND app.total_experience LIKE " . $db->Quote($needle_array['experience']);

            $db->setQuery($query);
            $total = $db->loadResult();

            // resume count -> named as appCounts starts here 
            $resumeCountPerTab = array();
            $resumeCountPerTab['inbox'] = $this->resumeCountPerTab(1, $jobid);
            $resumeCountPerTab['shortlist'] = $this->resumeCountPerTab(5, $jobid);
            $resumeCountPerTab['spam'] = $this->resumeCountPerTab(2, $jobid);
            $resumeCountPerTab['hired'] = $this->resumeCountPerTab(3, $jobid);
            $resumeCountPerTab['rejected'] = $this->resumeCountPerTab(4, $jobid);

            if ($total <= $limitstart)
                $limitstart = 0;

            $query = "SELECT job.hits AS jobview , (SELECT COUNT(id) FROM `#__js_job_jobapply` WHERE jobid = job.id) AS totalapply
                        FROM `#__js_job_jobs` AS job
                        WHERE job.id = " . $jobid;

            $db->setQuery($query);
            $stats = $db->loadobject();
            $query = "SELECT DISTINCT apply.comments,apply.id AS jobapplyid ,job.id,job.agefrom,job.ageto, cat.cat_title ,apply.apply_date, apply.resumeview, jobtype.title AS jobtypetitle,app.iamavailable
                        , app.id AS appid, app.first_name, app.last_name, app.email_address, app.jobtype,app.gender
                        , app.total_experience
                        , addresses.address_city,app.id as resumeid
                        , salary.rangestart, salary.rangeend,education.title AS educationtitle
                        , currency.symbol AS symbol
                        ,dcurrency.symbol AS dsymbol ,dsalary.rangestart AS drangestart, dsalary.rangeend AS drangeend  
                        ,app.photo AS photo,app.application_title AS applicationtitle
                        ,CONCAT(app.alias,'-',app.id) resumealiasid, CONCAT(job.alias,'-',job.id) AS jobaliasid
                        ,cletter.id AS cletterid, cletter.title AS clettertitle,  cletter.description AS cletterdescription 
                        , salarytype.title AS salarytype, dsalarytype.title AS dsalarytype
                        ,exp.title AS exptitle ,app.total_experience,city.id AS cityid
                        FROM `#__js_job_jobs` AS job
                        JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id
                        JOIN `#__js_job_jobapply` AS apply  ON apply.jobid = job.id 
                        JOIN `#__js_job_resume` AS app ON apply.cvid = app.id 
                        JOIN `#__js_job_categories` AS cat ON app.job_category = cat.id

                        LEFT JOIN `#__js_job_resumeaddresses` AS addresses ON app.id = addresses.resumeid
                        LEFT JOIN `#__js_job_resumeemployers` AS employers ON app.id = employers.resumeid
                        LEFT JOIN `#__js_job_resumereferences` AS reference ON app.id = reference.resumeid
                        LEFT JOIN `#__js_job_resumelanguages` AS languages ON app.id = languages.resumeid
                        LEFT JOIN `#__js_job_heighesteducation` AS  education  ON app.heighestfinisheducation=education.id
                        LEFT OUTER JOIN  `#__js_job_salaryrange` AS salary  ON  app.jobsalaryrange=salary.id
                        LEFT OUTER JOIN  `#__js_job_salaryrange` AS dsalary ON app.desired_salary=dsalary.id 
                        LEFT JOIN  `#__js_job_salaryrangetypes` AS salarytype ON app.jobsalaryrangetype = salarytype.id
                        LEFT JOIN  `#__js_job_salaryrangetypes` AS dsalarytype ON app.djobsalaryrangetype = dsalarytype.id
                        LEFT JOIN `#__js_job_currencies` AS currency ON currency.id = app.currencyid
                        LEFT JOIN `#__js_job_currencies` AS dcurrency ON dcurrency.id = app.dcurrencyid 
                        LEFT JOIN `#__js_job_coverletters` AS cletter ON apply.coverletterid = cletter.id 
                        LEFT JOIN `#__js_job_experiences` AS exp ON exp.id = app.experienceid 
                        LEFT JOIN `#__js_job_cities` AS city ON city.id = (SELECT address_city FROM `#__js_job_resumeaddresses` WHERE resumeid = app.id ORDER BY id DESC LIMIT 1) 
            WHERE apply.jobid = " . $jobid;
            if ($tab_action)
                $query.=" AND apply.action_status=" . $tab_action;
            if (isset($needle_array['title']) AND $needle_array['title'] != '')
                $query.=" AND app.application_title LIKE '%" . str_replace("'", "", $db->Quote($needle_array['title'])) . "%'";
            if (isset($needle_array['name']) AND $needle_array['name'] != '')
                $query.=" AND LOWER(app.first_name) LIKE " . $db->Quote('%' . $needle_array['name'] . '%');
            if (isset($needle_array['nationality']) AND $needle_array['nationality'] != '')
                $query .= " AND app.nationality = " . $needle_array['nationality'];
            if (isset($needle_array['gender']) AND $needle_array['gender'] != '')
                $query .= " AND app.gender = " . $needle_array['gender'];
            if (isset($needle_array['jobtype']) AND $needle_array['jobtype'] != '')
                $query .= " AND app.jobtype = " . $needle_array['jobtype'];
            if (isset($needle_array['currency']) AND $needle_array['currency'] != '')
                $query .= " AND app.currencyid = " . $needle_array['currency'];
            if (isset($needle_array['jobsalaryrange']) AND $needle_array['jobsalaryrange'] != '')
                $query .= " AND app.jobsalaryrange = " . $needle_array['jobsalaryrange'];
            if (isset($needle_array['heighestfinisheducation']) AND $needle_array['heighestfinisheducation'] != '')
                $query .= " AND app.heighestfinisheducation = " . $needle_array['heighestfinisheducation'];
            if (isset($needle_array['iamavailable']) AND $needle_array['iamavailable'] != '') {
                $available = ($needle_array['iamavailable'] == "yes") ? 1 : 0;
                $query .= " AND app.iamavailable = " . $available;
            }
            if (isset($needle_array['jobcategory']) AND $needle_array['jobcategory'] != '')
                $query .= " AND app.job_category = " . $needle_array['jobcategory'];
            if (isset($needle_array['jobsubcategory']) AND $needle_array['jobsubcategory'] != '')
                $query .= " AND app.job_subcategory = " . $needle_array['jobsubcategory'];
            if (isset($needle_array['experience']) AND $needle_array['experience'] != '')
                $query .= " AND app.total_experience LIKE " . $db->Quote($needle_array['experience']);

            $query.=" GROUP BY app.id ORDER BY  " . $sortby;
            $db->setQuery($query, $limitstart, $limit);
            $this->_applications = $db->loadObjectList();
            $query = "SELECT title FROM `#__js_job_jobs` WHERE id = " . $jobid;
            $db->setQuery($query);
            $jobtitle = $db->loadResult();
        }

        $result[0] = $this->_applications;
        $result[1] = $total;
        $result[2] = $jobtitle;
        $result[3] = $resumeCountPerTab;

        $fieldsordering = $this->getJSModel('customfields')->getFieldsOrdering(3);
        $fieldsordering = $this->getJSModel('customfields')->parseFieldsOrderingForView($fieldsordering);
        $result[4] = $fieldsordering;
        $result[5] = $stats;
        return $result;
    }

    function resumeCountPerTab($tabNumber = '', $jobid) {
        if($tabNumber)
            if(!is_numeric($tabNumber)) return false;
        if($jobid)
            if(!is_numeric($jobid)) return false;

        $db = $this->getDBO();
        $tabCount = 0;
        if ($tabNumber == 0) {
            return false;
        }
        $query = "SELECT COUNT(app.id)
                    FROM `#__js_job_jobs` AS job
                       , `#__js_job_jobapply` AS apply  
                       , `#__js_job_resume` AS app
                    WHERE apply.jobid = job.id AND apply.cvid = app.id AND apply.jobid = " . $jobid .
                " AND apply.action_status = " . $tabNumber;
        $db->setQuery($query);
        $tabCount = $db->loadResult();
        return $tabCount;
    }

    function getJobbyIdforJobApply($job_id) {
        $db = $this->getDBO();
        if (is_numeric($job_id) == false)
            return false;
        if ($this->_client_auth_key != "") {

            $fortask = "getjobapplybyidforjobapply";
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $data['jobid'] = $job_id;
            $data['authkey'] = $this->_client_auth_key;
            $data['siteurl'] = $this->_siteurl;
            $encodedata = json_encode($data);
            $return_server_value = $jsjobsharingobject->serverTask($encodedata, $fortask);
            if (isset($return_server_value['jobapplybyid']) AND $return_server_value['jobapplybyid'] == -1) { // auth fail 
                $logarray['uid'] = $this->_uid;
                $logarray['referenceid'] = $return_server_value['referenceid'];
                $logarray['eventtype'] = $return_server_value['eventtype'];
                $logarray['message'] = $return_server_value['message'];
                $logarray['event'] = "Job Apply By Id";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jsjobsharingobject->write_JobSharingLog($logarray);
                $this->_application = array();
            } else {
                $this->_application = (object) $return_server_value['relationjsondata'];
            }
        } else {

            $query = "SELECT job.title,job.created,job.city, cat.cat_title , company.name as companyname, company.url
                        , jobtype.title AS jobtypetitle
                        , jobstatus.title AS jobstatustitle, shift.title as shifttitle
                        , salary.rangestart, salary.rangeend, education.title AS heighesteducationtitle
                        ,CONCAT(company.alias,'-',company.id) AS companyaliasid
                        ,salarytype.title AS salarytype
                        FROM `#__js_job_jobs` AS job
                        JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
                        JOIN `#__js_job_companies` AS company ON job.companyid = company.id
                        JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id
                        LEFT JOIN `#__js_job_jobstatus` AS jobstatus ON job.jobstatus = jobstatus.id
                        LEFT JOIN `#__js_job_salaryrange` AS salary ON job.jobsalaryrange = salary.id
                        LEFT JOIN `#__js_job_salaryrangetypes` AS salarytype ON job.salaryrangetype = salarytype.id
                        LEFT JOIN `#__js_job_heighesteducation` AS education ON job.heighestfinisheducation = education.id
                        LEFT JOIN `#__js_job_shifts` AS shift ON job.shift = shift.id
                        WHERE  job.id = " . $job_id;
            $db->setQuery($query);
            $this->_application = $db->loadObject();
            $this->_application->multicity = $this->getJSModel('cities')->getLocationDataForView($this->_application->city);
        }

        $result[0] = $this->_application;
        $result[1] = $this->getJSModel('configurations')->getConfigByFor('listjob'); // company fields

        return $result;
    }

    function getMyAppliedJobs($u_id, $sortby, $limit, $limitstart) {
        $db = $this->getDBO();
        if ($u_id)
            if ((is_numeric($u_id) == false) || ($u_id == 0) || ($u_id == ''))
                return false;
        $result = array();

        if ($this->_client_auth_key != "") {
            $fortask = "myappliedjobs";
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $data['uid'] = $u_id;
            $data['sortby'] = $sortby;
            $data['limitstart'] = $limitstart;
            $data['limit'] = $limit;
            $data['authkey'] = $this->_client_auth_key;
            $data['siteurl'] = $this->_siteurl;
            $encodedata = json_encode($data);
            $return_server_value = $jsjobsharingobject->serverTask($encodedata, $fortask);
            if (isset($return_server_value['getmyappliedjobs']) AND $return_server_value['getmyappliedjobs'] == -1) { // auth fail 
                $logarray['uid'] = $this->_uid;
                $logarray['referenceid'] = $return_server_value['referenceid'];
                $logarray['eventtype'] = $return_server_value['eventtype'];
                $logarray['message'] = $return_server_value['message'];
                $logarray['event'] = "Applied Jobs";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jsjobsharingobject->write_JobSharingLog($logarray);
                $this->_applications = array();
                $total = 0;
            } else {
                $parse_data = array();
                if (is_array($return_server_value))
                    foreach ($return_server_value['relationjsondata'] AS $rel_data) {
                        $parse_data[] = (object) $rel_data;
                    }
                $this->_applications = $parse_data;
                $total = $return_server_value['total'];
            }
        } else {
            $query = "SELECT COUNT(job.id) FROM `#__js_job_jobs` AS job, `#__js_job_jobapply` AS apply  
            WHERE apply.jobid = job.id AND apply.uid = " . $u_id;
            $db->setQuery($query);
            $total = $db->loadResult();
            if ($total <= $limitstart)
                $limitstart = 0;

            $query = "SELECT job.params,job.id,job.title,job.jobcategory,job.created, cat.cat_title, apply.apply_date, jobtype.title AS jobtypetitle, jobstatus.title AS jobstatustitle
                        , salary.rangestart,salaryto.rangeend, salaryto.rangeend AS salaryto,company.logofilename as companylogo
                        ,company.id AS companyid, company.name AS companyname, company.url,salarytype.title AS salaytype
                        ,job.noofjobs
                        ,job.city
                        ,CONCAT(job.alias,'-',job.id) AS jobaliasid
                        ,CONCAT(company.alias,'-',companyid) AS companyaliasid
                        ,cur.symbol,apply.action_status AS resumestatus
                        ,resume.application_title AS applicationtitle , CONCAT(resume.alias ,'-',resume.id) AS resumealiasid
                        ,coverletter.title AS coverlettertitle,coverletter.id AS coverletterid
                        FROM `#__js_job_jobs` AS job
                        JOIN `#__js_job_companies` AS company ON job.companyid = company.id 
                        JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id 
                        JOIN `#__js_job_jobapply` AS apply ON apply.jobid = job.id 
                        JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id 
                        JOIN `#__js_job_resume` AS resume ON resume.id = apply.cvid
                        LEFT JOIN `#__js_job_coverletters` AS coverletter ON coverletter.id = apply.coverletterid
                        LEFT JOIN `#__js_job_jobstatus` AS jobstatus ON job.jobstatus = jobstatus.id 
                        LEFT JOIN `#__js_job_salaryrange` AS salary ON job.salaryrangefrom = salary.id
                        LEFT JOIN `#__js_job_salaryrange` AS salaryto ON job.salaryrangeto = salaryto.id
                        LEFT JOIN `#__js_job_salaryrangetypes` AS salarytype ON job.salaryrangetype = salarytype.id
                        LEFT JOIN `#__js_job_currencies` AS cur ON cur.id = job.currencyid
                        WHERE apply.uid = " . $u_id . " ORDER BY  " . $sortby;

            $db->setQuery($query, $limitstart, $limit);
            $this->_applications = $db->loadObjectList();
            foreach ($this->_applications AS $jobdata) {
                $jobdata->location = $this->getJSModel('cities')->getLocationDataForView($jobdata->city);
            }
        
        }

        $fieldsordering = $this->getJSModel('customfields')->getFieldsOrdering(2);
        $fieldsordering = $this->getJSModel('customfields')->parseFieldsOrderingForView($fieldsordering);

        $result[0] = $this->_applications;
        $result[1] = $total;
        $result[2] = $fieldsordering;

        return $result;
    }

    function jobapply() {
        $row = $this->getTable('jobapply');
        $data = JRequest::get('post');
        $data['apply_date'] = date('Y-m-d H:i:s');
        $db = JFactory::getDBO();
        if ($this->_client_auth_key != "") {
            $query = "SELECT id FROM `#__js_job_jobs` WHERE serverid = " . $data['jobid'];
            $db->setQuery($query);
            $result = $db->loadResult();
            if ($result) { //localy store
                $localjobid = $result; // result as local job id
                $data['jobid'] = $localjobid;
                $val_return = (int) $this->validateJobApply($data, $localjobid);
                if ($val_return == 3)
                    return 3;

                // new function store data with row object 
                $row = $this->storeRowObject($data, $row, $localjobid);
                if ($row == false)
                    return false;

                // local jobapply id 
                $data['jobapply_id'] = $row->id;
            }
            // send to server 
            $job_log_object = $this->getJSModel('log');
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $query = "select resume.serverid AS resumeserverid 
                            From `#__js_job_resume` AS resume
                            WHERE resume.id=" . $data['cvid'];
            //echo 'query'.$query;
            $db->setQuery($query);
            $resume_serverid = $db->loadResult();
            if ($resume_serverid)
                $data['cvid'] = $resume_serverid;
            else
                $data['cvid'] = 0;
            if (isset($localjobid) && $localjobid != '') {
                $query = "select job.serverid AS jobserverid 
                                From `#__js_job_jobs` AS job
                                WHERE job.id=" . $localjobid;
                //echo 'query'.$query;
                $db->setQuery($query);
                $job_serverid = $db->loadResult();
                if ($job_serverid)
                    $data['jobid'] = $job_serverid;
            }
            if ($data['coverletterid'] != "" AND $data['coverletterid'] != 0) {
                $query = "select coverletter.serverid AS coverletterserverid  From `#__js_job_coverletters` AS coverletter WHERE coverletter.id=" . $data['coverletterid'];
                $db->setQuery($query);
                $coverletter_serverid = $db->loadResult();
                if ($coverletter_serverid)
                    $data['coverletterid'] = $coverletter_serverid;
                else
                    $data['coverletterid'] = 0;
            } else
                $data['coverletterid'] = 0;
            $data['isownjob'] = (isset($localjobid)) ? 1 : 0;
            $data['task'] = ($data['isownjob'] == 1) ? 'storeownjobapply' : 'storeserverjobapply';
            $data['jobapply_id'] = isset($data['jobapply_id']) ? $data['jobapply_id'] : 0;
            // store on server direct 
            $data['authkey'] = $this->_client_auth_key;
            $data['task'] = 'storeownjobapply';
            $return_value = $jsjobsharingobject->store_JobapplySharing($data);
            $job_log_object->log_Store_JobapplySharing($return_value);
        } else {
            $val_return = (int) $this->validateJobApply($data, $data['jobid']);
            if ($val_return == 3)
                return 3;
            $row = $this->storeRowObject($data, $row, $data['jobid']);
            if ($row == false)
                return false;
        }
        return true;
    }

    function validateJobApply(&$data, $localjobid) {
        $db = $this->getDbo();
        if(!is_numeric($localjobid)) return false;
        $query = "SELECT job.raf_gender AS filter_gender,
                            job.raf_education AS filter_education,  
                            job.raf_category AS filter_category,job.raf_subcategory AS filter_subcategory, 
                            job.raf_location AS filter_location 
                            FROM `#__js_job_jobs` AS job 
                WHERE job.id = " . $localjobid;
        $db->setQuery($query);
        $apply_filter_values = $db->loadObject();
        $data['action_status'] = 1;
        if ($apply_filter_values) {
            $jobquery = "SELECT job.gender,job.educationid,job.jobcategory,job.subcategoryid,job.city
                    FROM `#__js_job_jobs` AS job 
                    WHERE job.id = " . $localjobid;
            $db->setQuery($jobquery);
            $job = $db->loadObject();

            $resumequery = "SELECT resume.gender,resume.heighestfinisheducation,resume.job_category,resume.job_subcategory,address.address_city
                    FROM `#__js_job_resume` AS resume
                    LEFT JOIN `#__js_job_resumeaddresses` AS address ON resume.id = address.resumeid
                    WHERE resume.id = " . $data['cvid'];
            $db->setQuery($resumequery);
            $resume = $db->loadObject();
            if ($apply_filter_values->filter_gender == 1) {
                if ($job->gender == $resume->gender)
                    $data['action_status'] = 1;
                else
                    $data['action_status'] = 2;
            }
            if ($data['action_status'] != 2) {
                if ($apply_filter_values->filter_education == 1) {
                    if ($job->educationid == $resume->heighestfinisheducation)
                        $data['action_status'] = 1;
                    else
                        $data['action_status'] = 2;
                }
            }
            if ($data['action_status'] != 2) {
                if ($apply_filter_values->filter_category == 1) {
                    if ($job->jobcategory == $resume->job_category)
                        $data['action_status'] = 1;
                    else
                        $data['action_status'] = 2;
                }
            }
            if ($data['action_status'] != 2) {
                if ($apply_filter_values->filter_subcategory == 1) {
                    if ($job->subcategoryid == $resume->job_subcategory)
                        $data['action_status'] = 1;
                    else
                        $data['action_status'] = 2;
                }
            }
            if ($data['action_status'] != 2) {
                if ($apply_filter_values->filter_location == 1) {
                    $joblocation = explode(',', $job->city);
                    if (in_array($resume->address_city, $joblocation)) {
                        $data['action_status'] = 1;
                    } else
                        $data['action_status'] = 2;
                }
            }
        }
        $result = $this->jobApplyValidation($data['uid'], $localjobid);
        if ($result == true) {
            return 3;
        }
        return true;
    }

    function canApplyJob($uid) {
        if (!is_numeric($uid))
            return false;
        $db = $this->getDbo();
        $query = "SELECT package.applyjobs "
                . "FROM `#__js_job_paymenthistory` AS paymenthistory "
                . "JOIN `#__js_job_jobseekerpackages` AS package ON package.id = paymenthistory.packageid "
                . "WHERE paymenthistory.uid = " . $uid . " AND paymenthistory.transactionverified = 1 
                    AND DATE_ADD(paymenthistory.created,INTERVAL package.packageexpireindays DAY) >= CURDATE()";
        $db->setQuery($query);
        $result = $db->loadObjectList();
        if (empty($result)) {
            $query = "SELECT package.applyjobs "
                    . "FROM `#__js_job_paymenthistory` AS paymenthistory "
                    . "JOIN `#__js_job_jobseekerpackages` AS package ON package.id = paymenthistory.packageid "
                    . "WHERE paymenthistory.uid = " . $uid . " AND paymenthistory.transactionverified = 1 ";
            $db->setQuery($query);
            $result = $db->loadObjectList();
            if (empty($result)) { // User have no package
                return NO_PACKAGE;
            } else { // User have packages but are expired
                return EXPIRED_PACKAGE;
            }
        } else {
            $countapplyjob = 0;
            foreach ($result AS $package) {
                if ($package->applyjobs == '-1') {
                    return VALIDATE;
                } else {
                    $countapplyjob += $package->applyjobs;
                }
            }
            $query = "SELECT COUNT(id) FROM `#__js_job_jobapply` WHERE uid = " . $uid;
            $db->setQuery($query);
            $totalappliedjob = $db->loadResult();
            if ($countapplyjob > $totalappliedjob)
                return VALIDATE;
            else
                return JOB_APPLY_LIMIT_EXCEEDS;
        }
    }

    function jobApplyValidation($u_id, $jobid) {
        if ((is_numeric($u_id) == false) || ($u_id == 0) || ($u_id == ''))
            return false;
        if (is_numeric($jobid) == false)
            return false;
        $db = JFactory::getDBO();

        $query = "SELECT COUNT(id) FROM `#__js_job_jobapply` 
        WHERE uid = " . $u_id . " AND jobid = " . $jobid;
        //echo '<br>sql '.$query;
        $db->setQuery($query);
        $result = $db->loadResult();
        //echo '<br>r'.$result;
        if ($result == 0)
            return false;
        else
            return true;
    }

    function getJobsAppliedResume($u_id, $sortby, $limit, $limitstart) {
        $db = $this->getDBO();
        if ($u_id)
            if ((is_numeric($u_id) == false) || ($u_id == 0) || ($u_id == ''))
                return false;
        $result = array();
        if ($this->_client_auth_key != "") {
            $fortask = "alljobsappliedapplications";
            $jsjobsharingobject = $this->getJSModel('jobsharingsite');
            $data['uid'] = $u_id;
            $data['sortby'] = $sortby;
            $data['limitstart'] = $limitstart;
            $data['limit'] = $limit;
            $data['authkey'] = $this->_client_auth_key;
            $data['siteurl'] = $this->_siteurl;
            $encodedata = json_encode($data);
            $return_server_value = $jsjobsharingobject->serverTask($encodedata, $fortask);
            if (isset($return_server_value['alljobsappliedresume']) AND $return_server_value['alljobsappliedresume'] == -1) { // auth fail 
                $logarray['uid'] = $this->_uid;
                $logarray['referenceid'] = $return_server_value['referenceid'];
                $logarray['eventtype'] = $return_server_value['eventtype'];
                $logarray['message'] = $return_server_value['message'];
                $logarray['event'] = "All Applied Resume on Jobs";
                $logarray['messagetype'] = "Error";
                $logarray['datetime'] = date('Y-m-d H:i:s');
                $jsjobsharingobject->write_JobSharingLog($logarray);
                $this->_applications = array();
                $total = 0;
            } else {
                $parse_data = array();
                foreach ($return_server_value['relationjsondata'] AS $rel_data) {
                    $parse_data[] = (object) $rel_data;
                }
                $this->_applications = $parse_data;
                $total = $return_server_value['total'];
            }
        } else {
            $query = "SELECT COUNT(job.id)
            FROM `#__js_job_jobs` AS job, `#__js_job_categories` AS cat 
            WHERE job.jobcategory = cat.id AND job.uid= " . $u_id;
            $db->setQuery($query);
            $total = $db->loadResult();

            //$limit = $limit ? $limit : 5;
            if ($total <= $limitstart)
                $limitstart = 0;

            $query = "SELECT DISTINCT job.id cat.cat_title , company.name ,jobtype.title AS jobtypetitle, jobstatus.title AS jobstatustitle
                    , (SELECT COUNT(apply.id) FROM `#__js_job_jobapply` AS apply WHERE apply.jobid = job.id ) as appinjob
                    ,CONCAT(job.alias,'-',job.id) AS jobaliasid,company.id AS companid,company.logo AS companylogo
                    FROM `#__js_job_jobs` AS job
                    JOIN `#__js_job_categories` AS cat ON job.jobcategory = cat.id
                    JOIN `#__js_job_jobtypes` AS jobtype ON job.jobtype = jobtype.id
                    LEFT JOIN `#__js_job_jobstatus` AS jobstatus ON job.jobstatus = jobstatus.id
                    JOIN `#__js_job_companies` AS company ON job.companyid = company.id
                WHERE job.uid= " . $u_id . " ORDER BY  " . $sortby;
            $db->setQuery($query, $limitstart, $limit);
            $this->_applications = $db->loadObjectList();
        }


        $result[0] = $this->_applications;
        $result[1] = $total;

        return $result;
    }

    function storeRowObject($data, $row, $localjobid = false) {
        $message = isset($data['message']) ? $data['message'] : '';
        $data = filter_var_array($data, FILTER_SANITIZE_STRING);  // Sanitize entire array to string
        $data['message'] = $message;
        
        if (!$row->bind($data)) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        if (!$row->check()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        if (!$row->store()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        if ($localjobid != false) {
            if ($data['action_status'] == 1){

                $emailrerurn = $this->getJSModel('emailtemplate')->sendMail($localjobid, $data['uid'], $data['cvid']);
                
                $return_option = $this->getJSModel('emailtemplate')->getEmailOption('jobapply_jobapply' , 'admin');
                if($return_option == 1){
                    $emailrerurn = $this->getJSModel('adminemail')->sendMailtoAdmin($localjobid, $data['uid'], 4);
                }
            }
        }

        return $row;
    }

    function getMailForm($uid, $email, $jobapplyid) {
        if ((is_numeric($uid) == false) || ($uid == 0) || ($uid == ''))
            return false;
        $jobseeker_email = $email;
        $return_value = "<img id='jobsappcloseaction' src='".JURI::root()."components/com_jsjobs/images/act_no.png' onclick='jobsAppCloseAction($jobapplyid);'>
            <div id='jsjobs-email-appliedresume'> ";

                $return_value .= "<div id='jsjobs-input-fields'>";
                    $return_value .= "<div class='jsjobs-fieldtitle'>" . JText::_('Jobseeker') . "</div>";
                    $return_value .= "<div class='jsjobs-fieldvalue'><input name='jsmailaddress' id='jsmailaddress' value='$jobseeker_email' readonly='readonly'/></div>";
                    $return_value .= "<div class='jsjobs-fieldtitle'>" . JText::_('Subject Line') . "</div>";
                    $return_value .= "<div class='jsjobs-fieldvalue'><input type='text' name='jssubject' id='jssubject'/></div>";
                    $return_value .= "<div class='jsjobs-fieldtitle'>" . JText::_('Email Sender') . "</div>";
                    $return_value .= "<div class='jsjobs-fieldvalue'><input name='emmailaddress' id='emmailaddress' class='email validate'/></div>";
                $return_value .= "</div>";
                
                $return_value .= "<div id='jsjobs-text-area'>";
                    $return_value .= "<textarea name='candidatemessage' id='candidatemessage' rows='5' cols='38'></textarea>";
                $return_value .= "</div>";

                $return_value .= "<div id='jsjobs-action-button'>";
                    $return_value .= "<input id='js_btnid_sendmail' type='button' class='button' onclick='sendmailtocandidate(" . $jobapplyid . ")' value='" . JText::_('Send')."'/>";
                $return_value .= "</div>
            </div>";

        return $return_value;
    }
    
    function getJobAppliedResumeSearchOption($needle_array) {
        $gender = array(
            '0' => array('value' => '', 'text' => JText::_('Select Gender')),
            '1' => array('value' => 1, 'text' => JText::_('Male')),
            '2' => array('value' => 2, 'text' => JText::_('Female')),);


        if($needle_array)
            $needle_array = json_decode($needle_array, TRUE);


        $nationality = $this->getJSModel('countries')->getCountries(JText::_('Select Nationality'));
        $job_type = $this->getJSModel('jobtype')->getJobType(JText::_('Select Job Type'));
        $heighesteducation = $this->getJSModel('highesteducation')->getHeighestEducation(JText::_('Select Highest Education'));
        $job_categories = $this->getJSModel('category')->getCategories(JText::_('Select Category'));
        $job_subcategories = $this->getJSModel('subcategory')->getSubCategoriesforCombo($job_categories[1]['value'], JText::_('Select Sub Category'), '');
        $job_salaryrange = $this->getJSModel('salaryrange')->getJobSalaryRange(JText::_('Select Salary Range'), '');
        $job_currency = $this->getJSModel('currency')->getCurrency(JText::_('Select'));

        $searchoptions['nationality'] = JHTML::_('select.genericList', $nationality,   'nationality', 'class="inputbox" ' . '', 'value', 'text', isset($needle_array['nationality']) ? $needle_array['nationality'] : '');
        $searchoptions['jobcategory'] = JHTML::_('select.genericList', $job_categories,   'jobcategory', 'class="inputbox" ' . 'onChange="fj_getsubcategories(\'fj_subcategory\', this.value)"', 'value', 'text', isset($needle_array['jobcategory']) ? $needle_array['jobcategory'] : '');
        $searchoptions['jobsubcategory'] = JHTML::_('select.genericList', $job_subcategories,   'jobsubcategory', 'class="inputbox" ' . '', 'value', 'text', isset($needle_array['jobsubcategory']) ? $needle_array['jobsubcategory'] : '');
        $searchoptions['jobsalaryrange'] = JHTML::_('select.genericList', $job_salaryrange,   'jobsalaryrange', 'class="inputbox" ' . '', 'value', 'text', isset($needle_array['jobsalaryrange']) ? $needle_array['jobsalaryrange'] : '');
        $searchoptions['jobtype'] = JHTML::_('select.genericList', $job_type,   'jobtype', 'class="inputbox" ' . '', 'value', 'text', isset($needle_array['jobtype']) ? $needle_array['jobtype'] : '');
        $searchoptions['heighestfinisheducation'] = JHTML::_('select.genericList', $heighesteducation,   'heighestfinisheducation', 'class="inputbox" ' . '', 'value', 'text', isset($needle_array['heighestfinisheducation']) ? $needle_array['heighestfinisheducation'] : '');
        $searchoptions['gender'] = JHTML::_('select.genericList', $gender,   'gender', 'class="inputbox" ' . '', 'value', 'text', isset($needle_array['gender']) ? $needle_array['gender'] : '');
        $searchoptions['currency'] = JHTML::_('select.genericList', $job_currency,   'currency', 'class="inputbox" ' . '', 'value', 'text', isset($needle_array['currency']) ? $needle_array['currency'] : '');
        $result = array();
        $result[0] = $searchoptions;
        return $result;
    }
    
}
?>
