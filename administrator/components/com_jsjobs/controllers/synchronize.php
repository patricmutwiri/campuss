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

class JSJobsControllerSynchronize extends JSController {

    function __construct() {
        parent::__construct();
        $this->registerTask('add', 'edit');
    }

    function startSynchronizeProcess($auth_key) {
        $user = JFactory::getUser();
        $uid = $user->id;
        $session = JFactory::getSession();
        $model = $this->getModel('jsjobs', 'JSJobsModel');
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');

        if ($auth_key != "") {
            $return_value = $jobsharing->updateclientauthenticationkey('', $auth_key);
            if ($return_value != "") {
                // synchronization start 
                $server_syn_table = $this->getServerDefaultTables();
                $server_syn_table = json_decode($server_syn_table, true);
                $client_default_table_data = $jobsharing->getAllClientDefaultTableData();
                $client_default_table_data = json_decode($client_default_table_data, true);
                $server_job_category = json_decode($server_syn_table['job_categories'], true);
                $client_job_category = $client_default_table_data['job_categories'];
                //num 1
                echo "<style type=\"text/css\">
                        div#wrapper{width: 925px;margin: 0 auto;margin-top: 5%;padding: 10px;border: 1px solid #a9a9a9;border-radius: 8px;box-shadow: 0px 0px 4px #a9abae;}
                        div#wrapper:after{display:block;float:left;content:'';}
                        div#wrapper h1{margin: 0px;margin-bottom: 10px;text-align: center;font-size: 18px;color: #fff;text-shadow: 1px 1px 1px #000;background: url(components/com_jsjobs/include/images/head_bar.png);padding: 4px 0px;background-size: 100% 100%;}
                        div#left_wrapper{width: 147px;float: left;margin-right: 20px;}
                        div#right_wrapper{width: 756px;float: left;}
                        div.wrapper{width:100%;display:inline-block;}
                        span#progress_bar{width: 98%;margin-top:10px;display: block;height: 10px;border: 1px solid #000;border-radius: 8px;overflow:hidden;}
                        span#progress_bar span{width: 0%;display: block;height: 10px;border: 1px solid #000;background: url(components/com_jsjobs/include/images/sync_barbg.png);}
                        span#progress_text{display: block;font-size: 12px;padding: 4px;text-align: right;margin-right:13px;}
                        span#process_msg{display: block;font-size: 16px;margin-bottom: 20px;color: #018FCD;}
                        span#process_msg span#process_msg_changeable{color:#63625F;font-size:15px;}
                        div.half_width{display:inline-block;width:50%;float:left;text-align:center;}
                        div.half_width.min-height{min-height:20px;}
                        div.half_width img.full_width{width:100%;}
                        span#sync_msg_complete{display: block;font-size: 20px;text-align: center;color: #0290CD;font-weight: bold;margin:20px 0px 30px 0px;}
                        span.sync_green{display: block;font-size:15px;text-align: left;padding: 5px;margin-bottom: 2px;background: url(components/com_jsjobs/include/images/sync_green.png);background-size: 100% 100%;}
                        span.sync_red{display: block;font-size:15px;text-align: left;padding: 5px;margin-bottom: 2px;background: url(components/com_jsjobs/include/images/sync_red.png);background-size: 100% 100%;}                        
                        input.btn_continue{padding: 4px 20px;background: url(components/com_jsjobs/include/images/sync_btn.png);outline: none;border: 1px solid #a9abae;border-radius: 4px;}
                        input.btn_continue:hover{cursor:pointer;}
                        </style>";
                echo str_pad('<html><head><script type="text/javascript" src="components/com_jsjobs/include/js/jquery.js"></script></head><body><div id="wrapper"><h1>' . JText::_('Synchronize Process') . '</h1>
                    <div style="width:100%;display:inline-block;">
                        <div id="left_wrapper"><img src="components/com_jsjobs/include/images/sync_circle.png"/><img style="width:100%" src="components/com_jsjobs/include/images/sync_logo.png" /></div>
                        <div id="right_wrapper">
                            <div class="wrapper">
                                <span id="progress_bar"><span></span></span>
                                <span id="progress_text"><span id="progress">0%</span>&nbsp;' . JText::_('Complete...') . '</span>
                                <span id="process_msg">' . JText::_('Current Process') . ':&nbsp;<span id="process_msg_changeable">...</span></span>
                            </div>
                            <div class="wrapper">
                                <div class="half_width min-height" id="text_changeable">
                                </div>
                                <div class="half_width">
                                    <img src="components/com_jsjobs/include/images/sync_logo.png" class="full_width" />
                                    <span id="sync_msg_complete"></span>
                                    <input type="button" value=">> ' . JText::_('Continue') . '" class="btn_continue" disabled="true"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div></body></html>', 5120);
                flush();
                ob_flush();
                echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"0%"},"fast");</script>', 50120);
                echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Synchronize Categories') . '...");</script>', 50120);
                echo str_pad('<script type="text/javascript">jQuery("span#progress").html("0%");</script>', 50120);
                flush();
                ob_flush();
                $table_category = "categories";
                $syn_job_category = $jobsharing->synchronizeClientServerTables($server_job_category, $client_job_category, $table_category, $auth_key);
                $syn_job_category_true = json_decode($syn_job_category['return_server_value_' . $table_category]);
                $syn_job_category_update = json_decode($syn_job_category['return_server_value_' . $table_category]);
                $message_sync = "";
                if (is_array($syn_job_category_update) AND ! empty($syn_job_category_update)) {
                    $message_sync.= JText::_('Job Category Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_category['rejected_client_' . $table_category]) AND $syn_job_category['rejected_client_' . $table_category] !== "")
                        if (isset($syn_job_category['rejected_client_' . $table_category]) AND $syn_job_category['rejected_client_' . $table_category] !== "")
                            $message_sync.= JText::_('Following Categories Are Rejected Due To Improper Name') . $syn_job_category['rejected_client_' . $table_category] . '<br/>';
                    $update_new_job_category = $jobsharing->updateClientServerTables($syn_job_category_update, $table_category);
                    //$update_new_job_category = $model->updateJobCategory($syn_job_category_update);
                    if ($update_new_job_category == true) {
                        //$message_sync.= JText::_('Update Job Category Synchronize Successfully') . '<br/>';
                        echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"4%"},"fast");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Update Job Category Synchronize Successfully') . '...");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#progress").html("4%");</script>', 50120);
                        echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                        flush();
                        ob_flush();
                    } else {
                        //$message_sync.='<span style="color:red;">' . JText::_('Error: Updating Job Category Synchronization') . '</span><br/>';
                        echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"4%"},"fast");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error: Updating Job Category Synchronization') . '...");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#progress").html("4%");</script>', 50120);
                        echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                        flush();
                        ob_flush();
                    }
                } elseif ($syn_job_category_true == true) {
                    $message_sync.=JText::_('Job Category Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_category['rejected_client_' . $table_category]) AND $syn_job_category['rejected_client_' . $table_category] !== "")
                        if (isset($syn_job_category['rejected_client_' . $table_category]) AND $syn_job_category['rejected_client_' . $table_category] !== "")
                            $message_sync.= JText::_('Following Categories Are Rejected Due To Improper Name') . $syn_job_category['rejected_client_' . $table_category] . '<br/>';
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"4%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Job Category Synchronize Successfully') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("4%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }elseif ($syn_job_category == false) {
                    $message_sync.='<span style="color:red;">' . JText::_('Error:job Category Synchronization') . '</span><br/>';
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"4%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error:job Category Synchronization') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("4%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }

                $server_job_subcategory = json_decode($server_syn_table['job_subcategories'], true);
                $client_job_subcategory = $client_default_table_data['job_subcategories'];
                //num 2
                $message_sync = "";
                echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Synchronize Sub Categories') . '...");</script>', 50120);
                flush();
                ob_flush();
                $table_subcategory = "subcategories";
                $syn_job_subcategory = $jobsharing->synchronizeClientServerTables($server_job_subcategory, $client_job_subcategory, $table_subcategory, $auth_key);
                $syn_job_subcategory_true = json_decode($syn_job_subcategory['return_server_value_' . $table_subcategory]);
                $syn_job_subcategory_update = json_decode($syn_job_subcategory['return_server_value_' . $table_subcategory]);

                if (is_array($syn_job_subcategory_update) AND ! empty($syn_job_subcategory_update)) {
                    $message_sync.=JText::_('Job Subcategory Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_subcategory['rejected_client_' . $table_subcategory]) AND $syn_job_subcategory['rejected_client_' . $table_subcategory] !== "")
                        if (isset($syn_job_subcategory['rejected_client_' . $table_subcategory]) AND $syn_job_subcategory['rejected_client_' . $table_subcategory] !== "")
                            $message_sync.= JText::_('Following Subcategories Are Rejected Due To Improper Name') . $syn_job_subcategory['rejected_client_' . $table_subcategory] . '<br/>';
                    $update_new_job_subcategory = $jobsharing->updateClientServerTables($syn_job_subcategory_update, $table_subcategory);
                    //$update_new_job_subcategory = $model->updateJobSubcategory($syn_job_subcategory_update);
                    if ($update_new_job_subcategory == true) {
                        //$message_sync.=JText::_('Update Job Subcategory Synchronize Successfully') . '<br/>';
                        echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"7%"},"fast");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Update Job Subcategory Synchronize Successfully') . '...");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#progress").html("7%");</script>', 50120);
                        echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                        flush();
                        ob_flush();
                    } else {
                        //$message_sync.='<span style="color:red;">' . JText::_('Error: Updating Job Subcategory Synchronization') . '</span><br/>';
                        echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"7%"},"fast");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error: Updating Job Subcategory Synchronization') . '...");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#progress").html("7%");</script>', 50120);
                        echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                        flush();
                        ob_flush();
                    }
                } elseif ($syn_job_subcategory_true == true) {
                    $message_sync.=JText::_('Job Subcategory Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_subcategory['rejected_client_' . $table_subcategory]) AND $syn_job_subcategory['rejected_client_' . $table_subcategory] !== "")
                        $message_sync.= JText::_('Following Subcategories Are Rejected Due To Improper Name') . $syn_job_subcategory['rejected_client_' . $table_subcategory] . '<br/>';
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"7%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Job Subcategory Synchronize Successfully') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("7%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }elseif ($syn_job_subcategory == false) {
                    $message_sync.='<span style="color:red;">' . JText::_('Error:job Subcategory Synchronization') . '</span><br/>';
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"7%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error:job Subcategory Synchronization') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("7%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }

                $server_job_jobtypes = json_decode($server_syn_table['job_types'], true);
                $client_job_jobtypes = $client_default_table_data['job_types'];
                //num 3
                $message_sync = "";
                echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Synchronize Job Types') . '...");</script>', 50120);
                flush();
                ob_flush();
                $table_jobtypes = "jobtypes";
                $syn_job_jobtypes = $jobsharing->synchronizeClientServerTables($server_job_jobtypes, $client_job_jobtypes, $table_jobtypes, $auth_key);
                $syn_job_jobtypes_true = json_decode($syn_job_jobtypes['return_server_value_' . $table_jobtypes]);
                $syn_job_jobtypes_update = json_decode($syn_job_jobtypes['return_server_value_' . $table_jobtypes]);

                if (is_array($syn_job_jobtypes_update) AND ! empty($syn_job_jobtypes_update)) {
                    $message_sync.=JText::_('Jobtypes Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_jobtypes['rejected_client_' . $table_jobtypes]) AND $syn_job_jobtypes['rejected_client_' . $table_jobtypes] !== "")
                        $message_sync.= JText::_('Following Jobtypes Are Rejected Due To Improper Name') . $syn_job_jobtypes['rejected_client_' . $table_jobtypes] . '<br/>';
                    $update_new_jobtypes = $jobsharing->updateClientServerTables($syn_job_jobtypes_update, $table_jobtypes);
                    //$update_new_jobtypes = $model->updateJobTypes($syn_job_jobtypes_update);
                    if ($update_new_jobtypes == true) {
                        $message_sync.=JText::_('Update Jobtypes Synchronize Successfully') . '<br/>';
                        echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"10%"},"fast");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Update Jobtypes Synchronize Successfully') . '...");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#progress").html("10%");</script>', 50120);
                        echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                        flush();
                        ob_flush();
                    } else {
                        $message_sync.='<span style="color:red;">' . JText::_('Error: Updating Jobtypes Synchronization') . '</span><br/>';
                        echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"10%"},"fast");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error: Updating Jobtypes Synchronization') . '...");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#progress").html("10%");</script>', 50120);
                        echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                        flush();
                        ob_flush();
                    }
                } elseif ($syn_job_jobtypes_true == true) {
                    $message_sync.= JText::_('Jobtypes Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_jobtypes['rejected_client_' . $table_jobtypes]) AND $syn_job_jobtypes['rejected_client_' . $table_jobtypes] !== "")
                        $message_sync.= JText::_('Following Jobtypes Are Rejected Due To Improper Name') . $syn_job_jobtypes['rejected_client_' . $table_jobtypes] . '<br/>';
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"10%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Jobtypes Synchronize Successfully') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("10%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }elseif ($syn_job_jobtypes == false) {
                    $message_sync.='<span style="color:red;">' . JText::_('Error:jobtypes Synchronization') . '</span><br/>';
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"10%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error:jobtypes Synchronization') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("10%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }

                $server_job_jobstatus = json_decode($server_syn_table['job_status'], true);
                $client_job_jobstatus = $client_default_table_data['job_status'];
                //num 4
                $message_sync = "";
                echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Synchronize Job Status') . '...");</script>', 50120);
                flush();
                ob_flush();
                $table_jobstatus = "jobstatus";
                $syn_job_jobstatus = $jobsharing->synchronizeClientServerTables($server_job_jobstatus, $client_job_jobstatus, $table_jobstatus, $auth_key);
                $syn_job_jobstatus_true = json_decode($syn_job_jobstatus['return_server_value_' . $table_jobstatus]);
                $syn_job_jobstatus_update = json_decode($syn_job_jobstatus['return_server_value_' . $table_jobstatus]);

                if (is_array($syn_job_jobstatus_update) AND ! empty($syn_job_jobstatus_update)) {
                    $message_sync.=JText::_('Jobstatus Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_jobstatus['rejected_client_' . $table_jobstatus]) AND $syn_job_jobstatus['rejected_client_' . $table_jobstatus] !== "")
                        $message_sync.= JText::_('Following Jobstatus Are Rejected Due To Improper Name') . $syn_job_jobstatus['rejected_client_' . $table_jobstatus] . '<br/>';
                    $update_new_jobstatus = $jobsharing->updateClientServerTables($syn_job_jobstatus_update, $table_jobstatus);
                    //$update_new_jobstatus = $model->updateJobStatus($syn_job_jobstatus_update);
                    if ($update_new_jobstatus == true) {
                        $message_sync.=JText::_('Update Jobstatus Synchronize Successfully') . '<br/>';
                        echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"13%"},"fast");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Update Jobstatus Synchronize Successfully') . '...");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#progress").html("13%");</script>', 50120);
                        echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                        flush();
                        ob_flush();
                    } else {
                        $message_sync.='<span style="color:red;">' . JText::_('Error: Updating Jobstatus Synchronization') . '</span><br/>';
                        echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"13%"},"fast");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error: Updating Jobstatus Synchronization') . '...");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#progress").html("13%");</script>', 50120);
                        echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                        flush();
                        ob_flush();
                    }
                } elseif ($syn_job_jobstatus_true == true) {
                    $message_sync.=JText::_('Jobstatus Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_jobstatus['rejected_client_' . $table_jobstatus]) AND $syn_job_jobstatus['rejected_client_' . $table_jobstatus] !== "")
                        $message_sync.= JText::_('Following Jobstatus Are Rejected Due To Improper Name') . $syn_job_jobstatus['rejected_client_' . $table_jobstatus] . '<br/>';
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"13%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Jobstatus Synchronize Successfully') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("13%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }elseif ($syn_job_jobstatus == false) {
                    $message_sync.='<span style="color:red;">' . JText::_('Error:jobstatus Synchronization') . '</span><br/>';
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"13%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error:jobstatus Synchronization') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("13%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }

                $server_job_jobcurrencies = json_decode($server_syn_table['job_currencies'], true);
                $client_job_jobcurrencies = $client_default_table_data['job_currencies'];
                //num 5
                $message_sync = "";
                echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Synchronize Currencies') . '...");</script>', 50120);
                flush();
                ob_flush();
                $table_jobcurrencies = "currencies";
                $syn_job_jobcurrencies = $jobsharing->synchronizeClientServerTables($server_job_jobcurrencies, $client_job_jobcurrencies, $table_jobcurrencies, $auth_key);

                $syn_job_jobcurrencies_true = json_decode($syn_job_jobcurrencies['return_server_value_' . $table_jobcurrencies]);

                $syn_job_jobcurrencies_update = json_decode($syn_job_jobcurrencies['return_server_value_' . $table_jobcurrencies]);

                if (is_array($syn_job_jobcurrencies_update) AND ! empty($syn_job_jobcurrencies_update)) {
                    $message_sync.=JText::_('Currencies Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_jobcurrencies['rejected_client_' . $table_jobcurrencies]) AND $syn_job_jobcurrencies['rejected_client_' . $table_jobcurrencies] !== "")
                        $message_sync.= JText::_('Following currencies are rejected due to improper name').' '. $syn_job_jobcurrencies['rejected_client_' . $table_jobcurrencies] . '<br/>';
                    $update_new_jobcurrencies = $jobsharing->updateClientServerTables($syn_job_jobcurrencies_update, $table_jobcurrencies);
                    //$update_new_jobcurrencies = $model->updateJobCurrencies($syn_job_jobcurrencies_update);
                    if ($update_new_jobcurrencies == true) {
                        $message_sync.=JText::_('Update Currencies Synchronize Successfully') . '<br/>';
                        echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"17%"},"fast");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Update Currencies Synchronize Successfully') . '...");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#progress").html("17%");</script>', 50120);
                        echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                        flush();
                        ob_flush();
                    } else {
                        $message_sync.='<span style="color:red;">' . JText::_('Error: Updating Currencies Synchronization') . '</span><br/>';
                        echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"17%"},"fast");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error: Updating Currencies Synchronization') . '...");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#progress").html("17%");</script>', 50120);
                        echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                        flush();
                        ob_flush();
                    }
                } elseif ($syn_job_jobcurrencies_true == true) {
                    $message_sync.=JText::_('Currencies Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_jobcurrencies['rejected_client_' . $table_jobcurrencies]) AND $syn_job_jobcurrencies['rejected_client_' . $table_jobcurrencies] !== "")
                        $message_sync.= JText::_('Following currencies are rejected due to improper name') .' '. $syn_job_jobcurrencies['rejected_client_' . $table_jobcurrencies] . '<br/>';
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"17%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Following currencies are rejected due to improper name') .' '. '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("17%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }elseif ($syn_job_jobcurrencies == false) {
                    $message_sync.='<span style="color:red;">' . JText::_('Error:currencies Synchronization') . '</span><br/>';
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"17%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error:currencies Synchronization') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("17%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }


                $server_job_salaryrangetypes = json_decode($server_syn_table['job_salaryrangetypes'], true);

                $client_job_salaryrangetypes = $client_default_table_data['job_salaryrangetypes'];
                //num 6
                $message_sync = "";
                echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Synchronize Salary Range Type') . '...");</script>', 50120);
                flush();
                ob_flush();
                $table_salaryrangetypes = "salaryrangetypes";

                $syn_job_salaryrangetypes = $jobsharing->synchronizeClientServerTables($server_job_salaryrangetypes, $client_job_salaryrangetypes, $table_salaryrangetypes, $auth_key);
                $syn_job_salaryrangetypes_true = json_decode($syn_job_salaryrangetypes['return_server_value_' . $table_salaryrangetypes]);
                $syn_job_salaryrangetypes_update = json_decode($syn_job_salaryrangetypes['return_server_value_' . $table_salaryrangetypes]);

                if (is_array($syn_job_salaryrangetypes_update) AND ! empty($syn_job_salaryrangetypes_update)) {
                    $message_sync.=JText::_('Salaryrange Types Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_salaryrangetypes['rejected_client_' . $table_salaryrangetypes]) AND $syn_job_salaryrangetypes['rejected_client_' . $table_salaryrangetypes] !== "")
                        if (isset($syn_job_salaryrangetypes['rejected_client_' . $table_salaryrangetypes]) AND $syn_job_salaryrangetypes['rejected_client_' . $table_salaryrangetypes] !== "")
                            $message_sync.= JText::_('Following Salaryrange Types Are Rejected Due To Improper Name') . $syn_job_salaryrangetypes['rejected_client_' . $table_salaryrangetypes] . "<br/>";
                    $update_new_salaryrangetypes = $jobsharing->updateClientServerTables($syn_job_salaryrangetypes_update, $table_salaryrangetypes);
                    //$update_new_salaryrangetypes = $model->updateJobSalaryRangeTypes($syn_job_salaryrangetypes_update);
                    if ($update_new_salaryrangetypes == true) {
                        $message_sync.=JText::_('Update Salaryrange Types Synchronize Successfully') . '<br/>';
                        echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"20%"},"fast");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Update Salaryrange Types Synchronize Successfully') . '...");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#progress").html("20%");</script>', 50120);
                        echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                        flush();
                        ob_flush();
                    } else {
                        $message_sync.='<span style="color:red;">' . JText::_('Error: Updating Salaryrange Types Synchronization') . '</span><br/>';
                        echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"20%"},"fast");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error: Updating Salaryrange Types Synchronization') . '...");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#progress").html("20%");</script>', 50120);
                        echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                        flush();
                        ob_flush();
                    }
                } elseif ($syn_job_salaryrangetypes_true == true) {
                    $message_sync.=JText::_('Salaryrange Types Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_salaryrangetypes['rejected_client_' . $table_salaryrangetypes]) AND $syn_job_salaryrangetypes['rejected_client_' . $table_salaryrangetypes] !== "")
                        $message_sync.= JText::_('Following Salaryrange Types Are Rejected Due To Improper Name') . $syn_job_salaryrangetypes['rejected_client_' . $table_salaryrangetypes] . "<br/>";
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"20%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Following Salaryrange Types Are Rejected Due To Improper Name') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("20%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }elseif ($syn_job_salaryrangetypes == false) {
                    $message_sync.='<span style="color:red;">' . JText::_('Error:salaryrange Types Synchronization') . '</span><br/>';
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"20%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error:salaryrange Types Synchronization') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("20%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }

                $server_job_salaryrange = json_decode($server_syn_table['job_salaryrange'], true);
                $client_job_salaryrange = $client_default_table_data['job_salaryrange'];
                //num 7
                $message_sync = "";
                echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Synchronize Salary Range') . '...");</script>', 50120);
                flush();
                ob_flush();
                $table_salaryrange = "salaryrange";
                $syn_job_salaryrange = $jobsharing->synchronizeClientServerTables($server_job_salaryrange, $client_job_salaryrange, $table_salaryrange, $auth_key);

                $syn_job_salaryrange_true = json_decode($syn_job_salaryrange['return_server_value_' . $table_salaryrange]);

                $syn_job_salaryrange_update = json_decode($syn_job_salaryrange['return_server_value_' . $table_salaryrange]);

                if (is_array($syn_job_salaryrange_update) AND ! empty($syn_job_salaryrange_update)) {
                    $message_sync.=JText::_('Salaryrange Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_salaryrange['rejected_client_' . $table_salaryrange]) AND $syn_job_salaryrange['rejected_client_' . $table_salaryrange] !== "")
                        $message_sync.= JText::_('Following Salaryrange Are Rejected Due To Improper Name') . $syn_job_salaryrange['rejected_client_' . $table_salaryrange] . "<br/>";
                    $update_new_salaryrange = $jobsharing->updateClientServerTables($syn_job_salaryrange_update, $table_salaryrange);
                    //$update_new_salaryrange = $model->updateJobSalaryRange($syn_job_salaryrange_update);
                    if ($update_new_salaryrange == true) {
                        $message_sync.=JText::_('Update Salaryrange Synchronize Successfully') . '<br/>';
                        echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"23%"},"fast");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Update Salaryrange Synchronize Successfully') . '...");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#progress").html("23%");</script>', 50120);
                        echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                        flush();
                        ob_flush();
                    } else {
                        $message_sync.='<span style="color:red;">' . JText::_('Error: Updating Salaryrange Synchronization') . '</span><br/>';
                        echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"23%"},"fast");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error: Updating Salaryrange Synchronization') . '...");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#progress").html("23%");</script>', 50120);
                        echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                        flush();
                        ob_flush();
                    }
                } elseif ($syn_job_salaryrange_true == true) {
                    $message_sync.=JText::_('Salaryrange Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_salaryrange['rejected_client_' . $table_salaryrange]) AND $syn_job_salaryrange['rejected_client_' . $table_salaryrange] !== "")
                        $message_sync.= JText::_('Following Salaryrange Are Rejected Due To Improper Name') . $syn_job_salaryrange['rejected_client_' . $table_salaryrange] . "<br/>";
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"23%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Salaryrange Synchronize Successfully') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("23%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }elseif ($syn_job_salaryrange == false) {
                    $message_sync.='<span style="color:red;">' . JText::_('Error:salaryrange Synchronization') . '</span><br/>';
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"23%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error:salaryrange Synchronization') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("23%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }


                $server_job_ages = json_decode($server_syn_table['job_ages'], true);
                $client_job_ages = $client_default_table_data['job_ages'];
                //num 8
                $message_sync = "";
                echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Synchronize Ages') . '...");</script>', 50120);
                flush();
                ob_flush();
                $table_ages = "ages";
                $syn_job_ages = $jobsharing->synchronizeClientServerTables($server_job_ages, $client_job_ages, $table_ages, $auth_key);
                $syn_job_ages_true = json_decode($syn_job_ages['return_server_value_' . $table_ages]);
                $syn_job_ages_update = json_decode($syn_job_ages['return_server_value_' . $table_ages]);

                if (is_array($syn_job_ages_update) AND ! empty($syn_job_ages_update)) {
                    $message_sync.=JText::_('Ages Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_ages['rejected_client_' . $table_ages]) AND $syn_job_ages['rejected_client_' . $table_ages] !== "")
                        $message_sync.= JText::_('Following Ages Are Rejected Due To Improper Name') . $syn_job_ages['rejected_client_' . $table_ages] . "<br/>";
                    $update_new_ages = $jobsharing->updateClientServerTables($syn_job_ages_update, $table_ages);
                    //$update_new_ages = $model->updateJobAges($syn_job_ages_update);
                    if ($update_new_ages == true) {
                        $message_sync.=JText::_('Update Ages Synchronize Successfully') . '<br/>';
                        echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"27%"},"fast");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Update Ages Synchronize Successfully') . '...");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#progress").html("27%");</script>', 50120);
                        echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                        flush();
                        ob_flush();
                    } else {
                        $message_sync.='<span style="color:red;">' . JText::_('Error: Updating Ages Synchronization') . '</span><br/>';
                        echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"27%"},"fast");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error: Updating Ages Synchronization') . '...");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#progress").html("27%");</script>', 50120);
                        echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                        flush();
                        ob_flush();
                    }
                } elseif ($syn_job_ages_true == true) {
                    $message_sync.=JText::_('Ages Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_ages['rejected_client_' . $table_ages]) AND $syn_job_ages['rejected_client_' . $table_ages] !== "")
                        $message_sync.= JText::_('Following Ages Are Rejected Due To Improper Name') . $syn_job_ages['rejected_client_' . $table_ages] . "<br/>";
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"27%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Following Ages Are Rejected Due To Improper Name') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("27%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }elseif ($syn_job_ages == false) {
                    $message_sync.='<span style="color:red;">' . JText::_('Error:ages Synchronization') . '</span><br/>';
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"27%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error:ages Synchronization') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("27%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }

                $server_job_shifts = json_decode($server_syn_table['job_shifts'], true);
                $client_job_shifts = $client_default_table_data['job_shifts'];
                //num 9
                $message_sync = "";
                echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Synchronize Shifts') . '...");</script>', 50120);
                flush();
                ob_flush();
                $table_shifts = "shifts";
                $syn_job_shifts = $jobsharing->synchronizeClientServerTables($server_job_shifts, $client_job_shifts, $table_shifts, $auth_key);

                $syn_job_shifts_true = json_decode($syn_job_shifts['return_server_value_' . $table_shifts]);

                $syn_job_shifts_update = json_decode($syn_job_shifts['return_server_value_' . $table_shifts]);

                if (is_array($syn_job_shifts_update) AND ! empty($syn_job_shifts_update)) {
                    $message_sync.=JText::_('Shifts Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_shifts['rejected_client_' . $table_shifts]) AND $syn_job_shifts['rejected_client_' . $table_shifts] !== "")
                        $message_sync.= JText::_('Following Shifts Are Rejected Due To Improper Name') . $syn_job_shifts['rejected_client_' . $table_shifts] . "<br/>";
                    $update_new_shifts = $jobsharing->updateClientServerTables($syn_job_shifts_update, $table_shifts);
                    //$update_new_shifts = $model->updateJobShifts($syn_job_shifts_update);
                    if ($update_new_shifts == true) {
                        $message_sync.=JText::_('Update Shifts Synchronize Successfully') . '<br/>';
                        echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"30%"},"fast");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Update Shifts Synchronize Successfully') . '...");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#progress").html("30%");</script>', 50120);
                        echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                        flush();
                        ob_flush();
                    } else {
                        $message_sync.='<span style="color:red;">' . JText::_('Error: Updating Shifts Synchronization') . '</span><br/>';
                        echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"30%"},"fast");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error: Updating Shifts Synchronization') . '...");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#progress").html("30%");</script>', 50120);
                        echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                        flush();
                        ob_flush();
                    }
                } elseif ($syn_job_shifts_true == true) {
                    $message_sync.=JText::_('Shifts Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_shifts['rejected_client_' . $table_shifts]) AND $syn_job_shifts['rejected_client_' . $table_shifts] !== "")
                        $message_sync.= JText::_('Following Shifts Are Rejected Due To Improper Name') . $syn_job_shifts['rejected_client_' . $table_shifts] . "<br/>";
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"30%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Following Shifts Are Rejected Due To Improper Name') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("30%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }elseif ($syn_job_shifts == false) {
                    $message_sync.='<span style="color:red;">' . JText::_('Error:shifts Synchronization') . '</span><br/>';
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"30%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error:shifts Synchronization') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("30%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }

                $server_job_careerlevels = json_decode($server_syn_table['job_careerlevels'], true);
                $client_job_careerlevels = $client_default_table_data['job_careerlevels'];
                //num 10
                $message_sync = "";
                echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Synchronize Career Levels') . '...");</script>', 50120);
                flush();
                ob_flush();
                $table_careerlevels = "careerlevels";
                $syn_job_careerlevels = $jobsharing->synchronizeClientServerTables($server_job_careerlevels, $client_job_careerlevels, $table_careerlevels, $auth_key);

                $syn_job_careerlevels_true = json_decode($syn_job_careerlevels['return_server_value_' . $table_careerlevels]);


                $syn_job_careerlevels_update = json_decode($syn_job_careerlevels['return_server_value_' . $table_careerlevels]);

                if (is_array($syn_job_careerlevels_update) AND ! empty($syn_job_careerlevels_update)) {
                    $message_sync.=JText::_('Careerlevels Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_careerlevels['rejected_client_' . $table_careerlevels]) AND $syn_job_careerlevels['rejected_client_' . $table_careerlevels] !== "")
                        $message_sync.= JText::_('Following Careerlevels Are Rejected Due To Improper Name') . $syn_job_careerlevels['rejected_client_' . $table_careerlevels] . "<br/>";
                    $update_new_careerlevels = $jobsharing->updateClientServerTables($syn_job_careerlevels_update, $table_careerlevels);
                    //$update_new_careerlevels = $model->updateJobCareerLevels($syn_job_careerlevels_update);
                    if ($update_new_careerlevels == true) {
                        $message_sync.=JText::_('Update Careerlevels Synchronize Successfully') . '<br/>';
                        echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"34%"},"fast");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Update Careerlevels Synchronize Successfully') . '...");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#progress").html("34%");</script>', 50120);
                        echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                        flush();
                        ob_flush();
                    } else {
                        $message_sync.='<span style="color:red;">' . JText::_('Error: Updating Careerlevels Synchronization') . '</span><br/>';
                        echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"34%"},"fast");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error: Updating Careerlevels Synchronization') . '...");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#progress").html("34%");</script>', 50120);
                        echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                        flush();
                        ob_flush();
                    }
                } elseif ($syn_job_careerlevels_true == true) {
                    $message_sync.=JText::_('Careerlevels Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_careerlevels['rejected_client_' . $table_careerlevels]) AND $syn_job_careerlevels['rejected_client_' . $table_careerlevels] !== "")
                        $message_sync.= JText::_('Following Careerlevels Are Rejected Due To Improper Name') . $syn_job_careerlevels['rejected_client_' . $table_careerlevels] . "<br/>";
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"34%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Careerlevels Synchronize Successfully') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("34%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }elseif ($syn_job_careerlevels == false) {
                    $message_sync.='<span style="color:red;">' . JText::_('Error:careerlevels Synchronization') . '</span><br/>';
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"34%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error:careerlevels Synchronization') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("34%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }

                $server_job_experiences = json_decode($server_syn_table['job_experiences'], true);
                $client_job_experiences = $client_default_table_data['job_experiences'];
                //num 11
                $message_sync = "";
                echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Synchronize Experiences') . '...");</script>', 50120);
                flush();
                ob_flush();
                $table_experiences = "experiences";
                $syn_job_experiences = $jobsharing->synchronizeClientServerTables($server_job_experiences, $client_job_experiences, $table_experiences, $auth_key);
                $syn_job_experiences_true = json_decode($syn_job_experiences['return_server_value_' . $table_experiences]);
                $syn_job_experiences_update = json_decode($syn_job_experiences['return_server_value_' . $table_experiences]);

                if (is_array($syn_job_experiences_update) AND ! empty($syn_job_experiences_update)) {
                    $message_sync.=JText::_('Experiences Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_experiences['rejected_client_' . $table_experiences]) AND $syn_job_experiences['rejected_client_' . $table_experiences] !== "")
                        $message_sync.= JText::_('Following Experiences Are Rejected Due To Improper Name') . $syn_job_experiences['rejected_client_' . $table_experiences] . "<br/>";
                    $update_new_experiences = $jobsharing->updateClientServerTables($syn_job_experiences_update, $table_experiences);
                    //$update_new_experiences = $model->updateJobExperiences($syn_job_experiences_update);
                    if ($update_new_experiences == true) {
                        $message_sync.=JText::_('Update Experiences Synchronize Successfully') . '<br/>';
                        echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"38%"},"fast");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Update Experiences Synchronize Successfully') . '...");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#progress").html("38%");</script>', 50120);
                        echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                        flush();
                        ob_flush();
                    } else {
                        $message_sync.='<span style="color:red;">' . JText::_('Error: Updating Experiences Synchronization') . '</span><br/>';
                        echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"38%"},"fast");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error: Updating Experiences Synchronization') . '...");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#progress").html("38%");</script>', 50120);
                        echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                        flush();
                        ob_flush();
                    }
                } elseif ($syn_job_experiences_true == true) {
                    $message_sync.=JText::_('Experiences Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_experiences['rejected_client_' . $table_experiences]) AND $syn_job_experiences['rejected_client_' . $table_experiences] !== "")
                        $message_sync.= JText::_('Following Experiences Are Rejected Due To Improper Name') . $syn_job_experiences['rejected_client_' . $table_experiences] . "<br/>";
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"38%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Experiences Synchronize Successfully') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("38%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }elseif ($syn_job_experiences == false) {
                    $message_sync.='<span style="color:red;">' . JText::_('Error:experiences Synchronization') . '</span><br/>';
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"38%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error:experiences Synchronization') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("38%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }

                $server_job_heighesteducation = json_decode($server_syn_table['job_heighesteducation'], true);
                $client_job_heighesteducation = $client_default_table_data['job_heighesteducation'];
                //num 12
                $message_sync = "";
                echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('SynchronizeHighestEducation') . '...");</script>', 50120);
                flush();
                ob_flush();
                $table_heighesteducation = "heighesteducation";
                $syn_job_heighesteducation = $jobsharing->synchronizeClientServerTables($server_job_heighesteducation, $client_job_heighesteducation, $table_heighesteducation, $auth_key);

                $syn_job_heighesteducation_true = json_decode($syn_job_heighesteducation['return_server_value_' . $table_heighesteducation]);

                $syn_job_heighesteducation_update = json_decode($syn_job_heighesteducation['return_server_value_' . $table_heighesteducation]);

                if (is_array($syn_job_heighesteducation_update) AND ! empty($syn_job_heighesteducation_update)) {
                    $message_sync.=JText::_('Heighest Education Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_heighesteducation['rejected_client_' . $table_heighesteducation]) AND $syn_job_heighesteducation['rejected_client_' . $table_heighesteducation] !== "")
                        $message_sync.= JText::_('FollowingHighestEducation Are Rejected Due To Improper Name') . $syn_job_heighesteducation['rejected_client_' . $table_heighesteducation] . "<br/>";
                    $update_new_heighesteducation = $jobsharing->updateClientServerTables($syn_job_heighesteducation_update, $table_heighesteducation);
                    //$update_new_heighesteducation = $model->updateJobHeighestEducation($syn_job_heighesteducation_update);
                    if ($update_new_heighesteducation == true) {
                        $message_sync.=JText::_('UpdateHighestEducation Synchronize Successfully') . '<br/>';
                        echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"40%"},"fast");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('UpdateHighestEducation Synchronize Successfully') . '...");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#progress").html("40%");</script>', 50120);
                        echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                        flush();
                        ob_flush();
                    } else {
                        $message_sync.='<span style="color:red;">' . JText::_('Error: UpdatingHighestEducation Synchronization') . '</span><br/>';
                        echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"40%"},"fast");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error: UpdatingHighestEducation Synchronization') . '...");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#progress").html("40%");</script>', 50120);
                        echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                        flush();
                        ob_flush();
                    }
                } elseif ($syn_job_heighesteducation_true == true) {
                    $message_sync.=JText::_('Heighest Education Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_heighesteducation['rejected_client_' . $table_heighesteducation]) AND $syn_job_heighesteducation['rejected_client_' . $table_heighesteducation] !== "")
                        if (isset($syn_job_heighesteducation['rejected_client_' . $table_heighesteducation]) AND $syn_job_heighesteducation['rejected_client_' . $table_heighesteducation] !== "")
                            $message_sync.= JText::_('FollowingHighestEducation Are Rejected Due To Improper Name') . $syn_job_heighesteducation['rejected_client_' . $table_heighesteducation] . "<br/>";
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"40%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Heighest Education Synchronize Successfully') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("40%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }elseif ($syn_job_heighesteducation == false) {
                    $message_sync.='<span style="color:red;">' . JText::_('Error:heighest Education Synchronization') . '</span><br/>';
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"40%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error:heighest Education Synchronization') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("40%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }

                // Address Data synchronize start  
                $client_syn_address_table_data = $jobsharing->getClientAddressData();
                $client_syn_address_table_data = json_decode($client_syn_address_table_data, true);
                $server_syn_address_table_data = $this->getServerAddressData();
                $server_syn_address_table_data = json_decode($server_syn_address_table_data, true);
                $server_job_countries = json_decode($server_syn_address_table_data['job_countries'], true);
                $client_job_countries = $client_syn_address_table_data['job_countries'];
                //num 13
                $message_sync = "";
                echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Synchronize Countries') . '...");</script>', 50120);
                flush();
                ob_flush();
                $table_countries = "countries";
                $syn_job_countries = $jobsharing->synchronizeClientServerTables($server_job_countries, $client_job_countries, $table_countries, $auth_key);
                $syn_job_countries_true = json_decode($syn_job_countries['return_server_value_' . $table_countries]);
                $syn_job_countries_update = json_decode($syn_job_countries['return_server_value_' . $table_countries]);

                if (is_array($syn_job_countries_update) AND ! empty($syn_job_countries_update)) {
                    $message_sync.=JText::_('Countries Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_countries['rejected_client_' . $table_countries]) AND $syn_job_countries['rejected_client_' . $table_countries] !== "")
                        $message_sync.= JText::_('Following Countries Are Rejected Due To Improper Name') . $syn_job_countries['rejected_client_' . $table_countries] . "<br/>";
                    $update_new_countries = $jobsharing->updateClientServerTables($syn_job_countries_update, $table_countries);
                    //$update_new_countries = $model->updateJobCountries($syn_job_countries_update);
                    if ($update_new_countries == true) {
                        $message_sync.=JText::_('Update Countries Synchronize Successfully') . '<br/>';
                        echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"43%"},"fast");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Update Countries Synchronize Successfully') . '...");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#progress").html("43%");</script>', 50120);
                        echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                        flush();
                        ob_flush();
                    } else {
                        $message_sync.='<span style="color:red;">' . JText::_('Error: Updating Countries Synchronization') . '</span><br/>';
                        echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"43%"},"fast");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error: Updating Countries Synchronization') . '...");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#progress").html("43%");</script>', 50120);
                        echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                        flush();
                        ob_flush();
                    }
                } elseif ($syn_job_countries_true == true) {
                    $message_sync.=JText::_('Countries Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_countries['rejected_client_' . $table_countries]) AND $syn_job_countries['rejected_client_' . $table_countries] !== "")
                        $message_sync.= JText::_('Following Countries Are Rejected Due To Improper Name') . $syn_job_countries['rejected_client_' . $table_countries] . "<br/>";
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"43%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Countries Synchronize Successfully') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("43%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }elseif ($syn_job_countries == false) {
                    $message_sync.='<span style="color:red;">' . JText::_('Error:countries Synchronization') . '</span><br/>';
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"43%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error:countries Synchronization') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("43%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }
                $server_job_states = json_decode($server_syn_address_table_data['job_states'], true);
                $client_job_states = $client_syn_address_table_data['job_states'];
                //num 14
                $message_sync = "";
                echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Synchronize States') . '...");</script>', 50120);
                flush();
                ob_flush();
                $table_states = "states";
                $syn_job_states = $jobsharing->synchronizeClientServerTables($server_job_states, $client_job_states, $table_states, $auth_key);

                $syn_job_states_true = json_decode($syn_job_states['return_server_value_' . $table_states]);

                $syn_job_states_update = json_decode($syn_job_states['return_server_value_' . $table_states]);

                if (is_array($syn_job_states_update) AND ! empty($syn_job_states_update)) {
                    $message_sync.=JText::_('States Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_states['rejected_client_' . $table_states]) AND $syn_job_states['rejected_client_' . $table_states] !== "")
                        $message_sync.= JText::_('Following States Are Rejected Due To Improper Name') . $syn_job_states['rejected_client_' . $table_states] . "<br/>";
                    $update_new_states = $jobsharing->updateClientServerTables($syn_job_states_update, $table_states);
                    //$update_new_states = $model->updateJobStates($syn_job_states_update);
                    if ($update_new_states == true) {
                        $message_sync.=JText::_('Update States Synchronize Successfully') . '<br/>';
                        echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"46%"},"fast");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Update States Synchronize Successfully') . '...");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#progress").html("46%");</script>', 50120);
                        echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                        flush();
                        ob_flush();
                    } else {
                        $message_sync.='<span style="color:red;">' . JText::_('Error: Updating States Synchronization') . '</span><br/>';
                        echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"46%"},"fast");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error: Updating States Synchronization') . '...");</script>', 50120);
                        echo str_pad('<script type="text/javascript">jQuery("span#progress").html("46%");</script>', 50120);
                        echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                        flush();
                        ob_flush();
                    }
                } elseif ($syn_job_states_true == true) {
                    $message_sync.=JText::_('States Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_states['rejected_client_' . $table_states]) AND $syn_job_states['rejected_client_' . $table_states] !== "")
                        if (isset($syn_job_states['rejected_client_' . $table_states]) AND $syn_job_states['rejected_client_' . $table_states] !== "")
                            $message_sync.= JText::_('Following States Are Rejected Due To Improper Name') . $syn_job_states['rejected_client_' . $table_states] . "<br/>";
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"46%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('States Synchronize Successfully') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("46%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }elseif ($syn_job_states == false) {
                    $message_sync.='<span style="color:red;">' . JText::_('Error:states Synchronization') . '</span><br/>';
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"46%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error:states Synchronization') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("46%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }

                //$server_job_cities = json_decode($server_syn_address_table_data['job_cities'],true);
                $server_job_cities = "";

                $client_job_cities = $client_syn_address_table_data['job_cities'];
                //$client_job_cities="";
                //num 15
                $message_sync = "";
                echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Synchronize Cities') . '...");</script>', 50120);
                flush();
                ob_flush();
                $table_cities = "cities";
                $syn_job_cities = $jobsharing->synchronizeClientServerTables($server_job_cities, $client_job_cities, $table_cities, $auth_key);
                $syn_job_cities_true = json_decode($syn_job_cities['return_server_value_' . $table_cities]);
                $syn_job_cities_update = json_decode($syn_job_cities['return_server_value_' . $table_cities]);

                if (is_array($syn_job_cities_update) AND ! empty($syn_job_cities_update)) {
                    $message_sync.=JText::_('Cities Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_cities['rejected_client_' . $table_cities]) AND $syn_job_cities['rejected_client_' . $table_cities] !== "")
                        $message_sync.= JText::_('Following Cities Are Rejected Due To Improper Name') . $syn_job_cities['rejected_client_' . $table_cities] . "<br/>";
                    $update_new_cities = $jobsharing->updateClientServerTables($syn_job_cities_update, $table_cities);
                    //$update_new_cities = $model->updateJobCities($syn_job_cities_update);
                    if ($update_new_cities == true)
                        if ($update_new_cities == true) {
                            $message_sync.=JText::_('Update Cities Synchronize Successfully') . '<br/>';
                            echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"50%"},"fast");</script>', 50120);
                            echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Update Cities Synchronize Successfully') . '...");</script>', 50120);
                            echo str_pad('<script type="text/javascript">jQuery("span#progress").html("50%");</script>', 50120);
                            echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                            flush();
                            ob_flush();
                        } else {
                            $message_sync.='<span style="color:red;">' . JText::_('Error: Updating Cities Synchronization') . '</span><br/>';
                            echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"50%"},"fast");</script>', 50120);
                            echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error: Updating Cities Synchronization') . '...");</script>', 50120);
                            echo str_pad('<script type="text/javascript">jQuery("span#progress").html("50%");</script>', 50120);
                            echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                            flush();
                            ob_flush();
                        }
                } elseif ($syn_job_cities_true == true) {
                    $message_sync.=JText::_('Cities Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_cities['rejected_client_' . $table_cities]) AND $syn_job_cities['rejected_client_' . $table_cities] !== "")
                        $message_sync.= JText::_('Following Cities Are Rejected Due To Improper Name') . $syn_job_cities['rejected_client_' . $table_cities] . "<br/>";
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"50%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Cities Synchronize Successfully') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("50%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }elseif ($syn_job_cities == false) {
                    $message_sync.='<span style="color:red;">' . JText::_('Error:cities Synchronization') . '</span><br/>';
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"50%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error:cities Synchronization') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("50%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }

                // Address Data synchronize end  
                //num 16
                $message_sync = "";
                echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Synchronize Companies') . '...");</script>', 50120);
                flush();
                ob_flush();
                $client_job_companies = $client_default_table_data['job_companies'];
                $syn_job_companies = $jobsharing->synchronizeClientServerCompanies($client_job_companies, $auth_key);

                $syn_job_companies_value = $syn_job_companies['return_server_value_companies'];
                if ($syn_job_companies_value == true) {
                    $message_sync.=JText::_('Companies Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_companies['rejected_client_companies']) AND $syn_job_companies['rejected_client_companies'] !== "")
                        $message_sync.= JText::_('Following Companies Are Rejected Due To Improper Name') . $syn_job_companies['rejected_client_companies'] . "<br/>";
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"53%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Companies Synchronize Successfully') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("53%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }
                elseif ($syn_job_companies_value == false) {
                    $message_sync.='<span style="color:red;">' . JText::_('Error:companies Synchronization') . '</span><br/>';
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"53%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error:companies Synchronization') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("53%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }
                //num 17
                $message_sync = "";
                echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Synchronize Departments') . '...");</script>', 50120);
                flush();
                ob_flush();
                $client_job_departments = $client_default_table_data['job_departments'];
                $syn_job_departments = $jobsharing->synchronizeClientServerDepartment($client_job_departments, $auth_key);

                $syn_job_departments_value = $syn_job_departments['return_server_value_departments'];

                if ($syn_job_departments_value == true) {
                    $message_sync.=JText::_('Departments Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_departments['rejected_client_departments']) AND $syn_job_departments['rejected_client_departments'] !== "")
                        $message_sync.= JText::_('Following Departments Are Rejected Due To Improper Name') . $syn_job_departments['rejected_client_departments'] . "<br/>";
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"56%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Departments Synchronize Successfully') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("56%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }
                elseif ($syn_job_departments_value == false) {
                    $message_sync.='<span style="color:red;">' . JText::_('Error:departments Synchronization') . '</span><br/>';
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"56%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error:departments Synchronization') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("56%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }
                //num 18
                $message_sync = "";
                echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Synchronize Jobs') . '...");</script>', 50120);
                flush();
                ob_flush();
                $client_job_jobs = $client_default_table_data['job_jobs'];
                $syn_job_jobs = $jobsharing->synchronizeClientServerJobs($client_job_jobs, $auth_key);
                $syn_job_jobs_value = $syn_job_jobs['return_server_value_jobs'];

                if ($syn_job_jobs_value == true) {
                    $message_sync.=JText::_('Jobs Synchronize Successfully') . '<br/>';
                    $message_sync.=JText::_('Jobs Userfields Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_jobs['rejected_client_jobs']) AND $syn_job_jobs['rejected_client_jobs'] !== "")
                        $message_sync.= JText::_('Following Jobs Are Rejected Due To Improper Name') . $syn_job_jobs['rejected_client_jobs'] . "<br/>";
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"60%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Jobs Synchronize Successfully') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("60%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }
                elseif ($syn_job_jobs_value == false) {
                    $message_sync.='<span style="color:red;">' . JText::_('Error:jobs Synchronization') . '</span><br/>';
                    $message_sync.='<span style="color:red;">' . JText::_('Error:jobs Userfields Synchronization') . '</span><br/>';
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"60%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error:jobs Synchronization') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("60%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }
                // num 18.5 Update the jobshortlist table please
                $this->getSharingModel('jobshortlist')->updateShortlistIDs(1); // 1 means sharing is on                
                //num 19
                $message_sync = "";
                echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Synchronize Resume') . '...");</script>', 50120);
                flush();
                ob_flush();
                $client_job_resume = $client_default_table_data['job_resume'];
                $syn_job_resume = $jobsharing->synchronizeClientServerResume($client_job_resume, $auth_key);
                $syn_job_resume_value = $syn_job_resume['return_server_value_resume'];
                if ($syn_job_resume_value == true) {
                    $message_sync.=JText::_('Resume Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_resume['rejected_client_resume']) AND $syn_job_resume['rejected_client_resume'] !== "")
                        $message_sync.= JText::_('Following Resume Are Rejected Due To Improper Name') . $syn_job_resume['rejected_client_resume'] . "<br/>";
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"65%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Resume Synchronize Successfully') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("65%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }elseif ($syn_job_resume_value == false) {
                    $message_sync.='<span style="color:red;">' . JText::_('Error:resume Synchronization') . '</span><br/>';
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"65%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error:resume Synchronization') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("65%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }
                //num 20
                $message_sync = "";
                echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Synchronize Cover Letter') . '...");</script>', 50120);
                flush();
                ob_flush();
                $client_job_coverletters = $client_default_table_data['job_coverletter'];
                $syn_job_coverletters = $jobsharing->synchronizeClientServerCoverLetters($client_job_coverletters, $auth_key);
                $syn_job_coverletters_value = $syn_job_coverletters['return_server_value_coverletters'];

                if ($syn_job_coverletters_value == true) {
                    $message_sync.=JText::_('Coverletters Synchronize Successfully') . '<br/>';
                    if (isset($syn_job_coverletters['rejected_client_coverletters']) AND $syn_job_coverletters['rejected_client_coverletters'] !== "")
                        $message_sync.= JText::_('Following Coverletters Are Rejected Due To Improper Name') . $syn_job_coverletters['rejected_client_coverletters'] . "<br/>";
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"68%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Coverletters Synchronize Successfully') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("68%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }
                elseif ($syn_job_coverletters_value == false) {
                    $message_sync.='<span style="color:red;">' . JText::_('Error:coverletters Synchronization') . '</span><br/>';
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"68%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error:coverletters Synchronization') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("68%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }
                //num 21
                $message_sync = "";
                echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Synchronize Job Apply') . '...");</script>', 50120);
                flush();
                ob_flush();
                $client_job_jobapply = $client_default_table_data['job_jobapply'];
                $syn_job_jobapply = $jobsharing->synchronizeClientServerJobapply($client_job_jobapply, $auth_key);
                $syn_job_jobapply_value = $syn_job_jobapply['return_server_value_jobapply'];

                if ($syn_job_jobapply_value == true) {
                    $message_sync.=JText::_('Jobapply Synchronize Successfully') . '<br/>';
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"70%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Jobapply Synchronize Successfully') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("70%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_green").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                } elseif ($syn_job_jobapply_value == false) {
                    $message_sync.='<span style="color:red;">' . JText::_('Error:jobapply Synchronization') . '</span><br/>';
                    echo str_pad('<script type="text/javascript">jQuery("span#progress_bar span").animate({"width":"70%"},"fast");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#process_msg_changeable").html("' . JText::_('Error:jobapply Synchronization') . '...");</script>', 50120);
                    echo str_pad('<script type="text/javascript">jQuery("span#progress").html("70%");</script>', 50120);
                    echo str_pad('<script type="text/javascript">var span = jQuery("<span>").attr("class","sync_red").html("' . $message_sync . '");jQuery("div#text_changeable").append(span);</script>', 50120);
                    flush();
                    ob_flush();
                }
                //num 22
                //num 23
                //num 24

                //num 25
                //num 26

                $session = JFactory::getSession();
                $session->set('synchronizedatamessage', $message_sync);
                $link = 'index.php?option=com_jsjobs&c=jobsharing&view=jobsharing&layout=jobshare';
                $msg = JText::_('Synchronize Complete Successfully');
                echo str_pad('<script type="text/javascript">jQuery("span#sync_msg_complete").html("' . $msg . '");</script>', 50120);
                echo str_pad('<script type="text/javascript">jQuery("input.btn_continue").prop(\'disabled\',false);</script>', 50120);
                echo str_pad('<script type="text/javascript">jQuery("input.btn_continue").click(function(){window.location = "' . JURI::root() . "administrator/index.php?option=com_jsjobs" . '";});</script>', 50120);
                flush();
                ob_flush();
                //$this->setRedirect($link, $msg);
                JFactory::getApplication()->close();
            } else {
                JSJOBSActionMessages::setMessage('Problem active job sharing service please try again later', 'jobsharing','error');
                $link = 'index.php?option=com_jsjobs&c=jobsharing&view=jobsharing&layout=jobshare';
                $this->setRedirect($link);
            }
        } else {
            JSJOBSActionMessages::setMessage('Problem active job sharing service please try again later', 'jobsharing','error');
            $link = 'index.php?option=com_jsjobs&c=jobsharing&view=jobsharing&layout=jobshare';
            $this->setRedirect($link);
        }
    }

    function getServerDefaultTables() {
        $fortask = "synchronizedefaulttables";
        $jsondata = JRequest::getVar('data');
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $returnvalue = $jobsharing->getAllServerDefaultTables('', $fortask);
        return $returnvalue;
    }

    function getServerAddressData() {
        $fortask = "synchronizeaddressdata";
        $jsondata = JRequest::getVar('data');
        $jobsharing = $this->getModel('jobsharing', 'JSJobsModel');
        $returnvalue = $jobsharing->getAllServerAddressData('', $fortask);
        return $returnvalue;
    }

    function display($cachable = false, $urlparams = false) {
        $document = JFactory::getDocument();
        $viewName = JRequest::getVar('view', 'synchronize');
        $layoutName = JRequest::getVar('layout', 'synchronize');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $model = $this->getModel('jsjobs', 'JSJobsModel');
        if (!JError::isError($model)) {
            $view->setModel($model, true);
        }
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>
