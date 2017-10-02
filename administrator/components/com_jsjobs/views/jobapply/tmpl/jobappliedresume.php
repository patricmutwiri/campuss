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

$document = JFactory::getDocument();
if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('../components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}
?>

<script type="text/javascript">
    function fj_getsubcategories(src, val) {
        jQuery.post("index.php?option=com_jsjobs&task=subcategory.listsubcategoriesForSearch", {val: val}, function (data) {
            if (data) {
                jQuery("#" + src).html(data);
            }
        });
    }

    function tabaction(jobid, action) {
        jQuery('#jobid').val(jobid);
        jQuery('#tab_action').val(action);
        jQuery('#task').val('jobapply.aappliedresumetabactions');
        jQuery('#adminForm').submit();
    }
    
    function tabsearch() {
        jQuery('div#jobsappliedresumeAS').toggle();
    }

    function jobappliedresumesearch(jobid, action) {
        jQuery('#jobid').val(jobid);
        jQuery('#tab_action').val(action); // 6 for search 
        jQuery('#task').val("jobapply.aappliedresumetabactions");
        jQuery('#adminForm').submit();
    }

    function actioncall(jobapplyid, jobid, resumeid, action) {
        jQuery('#resumedetail_'+jobapplyid).html("");
        if (action == 3) { // folder
            getfolders('resumeaction_' + jobapplyid, jobid, resumeid, jobapplyid);
        } else if (action == 4) { // comments
            getresumecomments('resumeaction_' + jobapplyid, jobapplyid);
        } else if (action == 5) { // email candidate
            mailtocandidate('resumeaction_' + jobapplyid, resumeid, jobapplyid);
        } else {
            var src = '#resumeactionmessage_' + jobapplyid;
            jQuery(src).html("Loading ...");
            jQuery.post("index.php?option=com_jsjobs&task=jobapply.saveshortlistcandiate", {jobid: jobid, resumeid: resumeid, action: action}, function (data) {
                if (data) {
                    var obj = jQuery.parseJSON(data);
                    if(obj.saved=="ok"){
                            jQuery(src).html('<span class="resume_message_print_ok"><label id="popup_message"><img src="components/com_jsjobs/include/images/approve.png"/>'+obj.message+'</label></span>');
                    }else{  
                        jQuery(src).html('<span class="resume_message_print_notok"><label id="popup_message"><img src="components/com_jsjobs/include/images/unpublish.png"/>'+obj.message+'</label></span>');
                    }
                    setTimeout(function () {
                        closeresumeactiondiv(src)
                    }, 3000);
                }
            });
        }

    }
    function closeresumeactiondiv(src) {
        jQuery(src).html("");
        location.reload();
    }

    function actionchangestatus(jobapplyid, jobid, resumeid, action) {
        var src = '#resumeactionmessage_' + jobapplyid;
        jQuery(src).html("Loading ...");
        jQuery.post("index.php?option=com_jsjobs&task=jobapply.updateactionstatus", {jobid: jobid, resumeid: resumeid, applyid: jobapplyid, action_status: action}, function (data) {
            if (data) {
                var obj = jQuery.parseJSON(data);
                if(obj.saved=="ok"){
                        jQuery(src).html('<span class="resume_message_print_ok"><label id="popup_message"><img src="components/com_jsjobs/include/images/approve.png"/>'+obj.message+'</label></span>');
                }else{
                    jQuery(src).html('<span class="resume_message_print_notok"><label id="popup_message"><img src="components/com_jsjobs/include/images/unpublish.png"/>'+obj.message+'</label></span>');
                }
                setTimeout(function () {
                    closeresumeactiondiv(src)
                }, 3000);
            }
        });
    }

    function setresumeid(resumeid, action) {
        jQuery('#resumeid').val(resumeid);
        jQuery('#action').val(jQuery("#" + action).val());
        jQuery('adminForm').submit();
    }
    function saveaddtofolder(jobapplyid, jobid, resumeid) {
        var src = '#resumeactionmessage_' + jobapplyid;
        var clearhtml = '#resumeaction_' + jobapplyid;
        var folderid = document.getElementById('folderid').value;
        jQuery(src).html("Loading ...");
        jQuery.post("index.php?option=com_jsjobs&task=folderresume.saveresumefolder", {jobid: jobid, resumeid: resumeid, applyid: jobapplyid, folderid: folderid}, function (data) {
            if (data) {
                var obj = jQuery.parseJSON(data);
                jQuery(clearhtml).html("");
                if(obj.saved=="ok"){
                        jQuery(src).html('<span class="resume_message_print_ok"><label id="popup_message"><img src="components/com_jsjobs/include/images/approve.png"/>'+obj.message+'</label></span>');
                }else{
                    jQuery(src).html('<span class="resume_message_print_notok"><label id="popup_message"><img src="components/com_jsjobs/include/images/unpublish.png"/>'+obj.message+'</label></span>');
                }
                setTimeout(function () {
                    closeresumeactiondiv(src)
                }, 3000);
            }
        });
    }
    function saveresumecomments(jobapplyid, resumeid) {
        var src = '#resumeactionmessage_' + jobapplyid;
        var clearhtml = '#resumeaction_' + jobapplyid;
        var comments = jQuery('#comments').val();
        jQuery(src).html("Loading ...");
        jQuery.post("index.php?option=com_jsjobs&task=jobapply.saveresumecomments", {jobapplyid: jobapplyid, resumeid: resumeid, comments: comments}, function (data) {
            if (data) {
                var obj = jQuery.parseJSON(data);
                jQuery(clearhtml).html("");
                if(obj.saved=="ok"){
                        jQuery(src).html('<span class="resume_message_print_ok"><label id="popup_message"><img src="components/com_jsjobs/include/images/approve.png"/>'+obj.message+'</label></span>');
                }else{
                    jQuery(src).html('<span class="resume_message_print_notok"><label id="popup_message"><img src="components/com_jsjobs/include/images/unpublish.png"/>'+obj.message+'</label></span>');
                }
                setTimeout(function () {
                    closeresumeactiondiv(src)
                }, 3000);
            }
        });
    }

    function closethisactiondiv(){
        jQuery('.resume_sp_actions_div').html("");
    }
    function closethisactiondiv2(){
        jQuery('.resumedetail_detail').html("");
    }

    function getfolders(src, jobid, resumeid, applyid) {
        jQuery("#" + src).html("Loading ...");
        jQuery.post("index.php?option=com_jsjobs&task=folder.getmyforlders", {jobid: jobid, resumeid: resumeid, applyid: applyid}, function (data) {
            if (data) {
                jQuery("#" + src).html(data);
            }
        });
    }
    function mailtocandidate(src, resumeid, jobapplyid) {
        jQuery("#" + src).html("Loading ...");
        jQuery.post("index.php?option=com_jsjobs&task=jobapply.mailtocandidate", {resumeid: resumeid, jobapplyid: jobapplyid}, function (data) {
            if (data) {
                jQuery("#" + src).html(data);
            }
        });
    }
    function sendmailtocandidate(jobapplyid) {
        var src = 'resumeactionmessage_' + jobapplyid;
        var arr = new Array();
        var emmailaddress = document.getElementById('emmailaddress').value;
        if (emmailaddress) {
            var result = echeck(emmailaddress);
            if (result == false) {
                alert('<?php echo JText::_('Invalid Email'); ?>');
                document.getElementById('emmailaddress').focus();
                return false;
            }
            arr[0] = emmailaddress;
            arr[1] = document.getElementById('jsmailaddress').value;
            arr[2] = document.getElementById('jssubject').value;
            arr[3] = document.getElementById('candidatemessage').value;
            sendtocandidate(arr, jobapplyid);

        } else {
            alert('<?php echo JText::_('Your Email Is Required').'!'; ?>');
            document.getElementById('emmailaddress').focus();
            return false;
        }
    }
    function sendtocandidate(arr, jobapplyid) {
        var src = '#resumeactionmessage_' + jobapplyid;
        var clearhtml = '#resumeaction_' + jobapplyid;
        jQuery(src).html("Loading ...");
        jQuery.post("index.php?option=com_jsjobs&task=jobapply.sendtocandidate", {val: JSON.stringify(arr)}, function (data) {
            if (data) {
                var obj = jQuery.parseJSON(data);
                jQuery(clearhtml).html("");
                if(obj.saved=="ok"){
                    jQuery(src).html('<span class="resume_message_print_ok"><label id="popup_message"><img src="components/com_jsjobs/include/images/approve.png"/>'+obj.message+'</label></span>');
                }else{
                    jQuery(src).html('<span class="resume_message_print_notok"><label id="popup_message"><img src="components/com_jsjobs/include/images/unpublish.png"/>'+obj.message+'</label></span>');
                }
                setTimeout(function () {
                    closeresumeactiondiv(src)
                }, 3000);
            }
        });
    }

    function getresumecomments(src, jobapplyid) {
        jQuery("#" + src).html("Loading ...");
        jQuery.post("index.php?option=com_jsjobs&task=jobapply.getresumecomments", {jobapplyid: jobapplyid}, function (data) {
            if (data) {
                jQuery("#" + src).html(data); //retuen value   
            }
        });
    }
    function getjobdetail(jobapplyid, jobid, resumeid) {
        
        jQuery('#resumeactionmessage_' + jobapplyid).html("");
        jQuery('#resumeaction_' + jobapplyid).html("");

        var src = '#resumedetail_' + jobapplyid;

        jQuery(src).html("Loading ...");
        jQuery.post("index.php?option=com_jsjobs&task=resume.getresumedetail", {jobid: jobid, resumeid: resumeid}, function (data) {
            if (data) {
                jQuery(src).html(data); //retuen value
            }
        });
    }

    function clsjobdetail(src) {
        jQuery("#" + src).html("");
    }
    function clsaddtofolder(src) {
        jQuery("#" + src).html("");
    }

    function echeck(str) {
        var at = "@";
        var dot = ".";
        var lat = str.indexOf(at);
        var lstr = str.length;
        var ldot = str.indexOf(dot);
        if (str.indexOf(at) == -1)
            return false;
        if (str.indexOf(at) == -1 || str.indexOf(at) == 0 || str.indexOf(at) == lstr)
            return false;
        if (str.indexOf(dot) == -1 || str.indexOf(dot) == 0 || str.indexOf(dot) == lstr)
            return false;
        if (str.indexOf(at, (lat + 1)) != -1)
            return false;
        if (str.substring(lat - 1, lat) == dot || str.substring(lat + 1, lat + 2) == dot)
            return false;
        if (str.indexOf(dot, (lat + 2)) == -1)
            return false;
        if (str.indexOf(" ") != -1)
            return false;
        return true;
    }
</script>

<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=job&view=job&layout=jobs"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a>
            <span id="heading-text"><?php echo JText::_('Job Applied Resume'); ?></span>
        </div>
        <?php 
        if(isset($this->items[0]->jobtitle)){ ?>
            <div id="js-jobs-appliedresume-title" class="js-col-xs-12 js-col-md-12">
                <span class="headtitle"><?php echo $this->items[0]->jobtitle; ?></span>
            </div>
            <?php
        } ?>

        <form action="index.php" method="post" name="adminForm" id="adminForm">
            <?php if(!empty($this->items)){ ?>
                <?php
                jimport('joomla.filter.output');
                $k = 0;
                $count = 0;
                for ($i = 0, $n = count($this->items); $i < $n; $i++) {
                    $count++;
                    $row = $this->items[$i];
                    $link = JFilterOutput::ampReplace('index.php?option=' . $this->option . '&task=jobapply.edit&cid[]=' . $row->id);
                    $resumelink = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=view_resume&rd=' . $row->appid . '&oi=' . $this->oi;
                    $plink = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=resumeprint&rd=' . $row->appid . '&oi=' . $this->oi;
                    $exportlink = 'index.php?option=com_jsjobs&task=export.exportresume&bd=' . $this->oi . '&rd=' . $row->appid;
                    $des_id = "des_$i";
                ?>
                <div style="display:none;" id="<?php echo $des_id; ?>"><?php echo $row->cletterdescription; ?></div>
                <div id="jobs-jobapplied-wrapper" data-containerid="container_<? echo $row->jobapplyid; ?>">
                    <div id="js-top-row">
                        <div id="jsjobs-left-image" class="js-col-xs-12 js-col-md-2">
                             <span class="outer-circle-appliedresume"><img class="circle-appliedresume" src="components/com_jsjobs/include/images/default-icon.png"/></span>
                            <div class="js-col-xs-12 js-col-md-12 js-nullpadding">
                                 <a class="view-links view-resume" href="index.php?option=com_jsjobs&task=resume.edit&cid[]=<?php echo $row->appid; ?>"><img src="components/com_jsjobs/include/images/view-resume-new.png" alt="resume-link">&nbsp;<?php echo JText::_('View Resume'); ?></a>
                                 <a class="view-links view-cvletter" href="javascript:void(0);" onclick="showPopupAndSetValues('<?php echo $row->first_name . ' ' . $row->last_name;?>','<?php echo $row->clettertitle;?>','<?php echo $des_id;?>');"><img src="components/com_jsjobs/include/images/view-coverletter-new.png" alt="resume-link">&nbsp;<?php echo JText::_('View Cover Letter'); ?></a>
                            </div>
                        </div>
                        <div id="jsjobs-right-content" class="js-col-xs-12 js-col-md-10">
                            <div class="js-jobs-title-row">
                                <span class="js-col-xs-12 js-col-md-6 resume-title"><?php echo $row->applicationtitle; ?></span>
                                <span class="js-col-xs-12 js-col-md-3 resume-created"><span class="js-bold color-default"><?php echo JText::_('Created'); ?>: </span><?php echo JHtml::_('date', $row->apply_date, $this->config['date_format']); ?></span>
                            </div>
                            <div class="js-main-area">
                                <div class="js-col-xs-12 js-col-md-12 js-field color-font"><span class="js-bold color-default"><?php echo JText::_('Application Title'); ?></span>:&nbsp;<?php  echo $row->first_name . ' ' . $row->last_name; ?></div>
                                <div class="js-col-xs-12 js-col-md-6 js-field color-font"><span class="js-bold color-default"><?php echo JText::_('Current Salary'); ?></span>:&nbsp;<?php 
                                   echo $this->getJSModel('common')->getSalaryRangeView($row->symbol,$row->rangestart,$row->rangeend,JText::_($row->rangetype));
                                   ?>
                                </div>
                                <div class="js-col-xs-12 js-col-md-6 js-field color-font"><span class="js-bold color-default"><?php echo JText::_('Total Experience'); ?>:&nbsp;</span><?php if(empty($row->exptitle)){ echo  $row->total_experience; }else{ echo JText::_($row->exptitle); } ?></div>
                                <div class="js-col-xs-12 js-col-md-6 js-field color-font"><span class="js-bold color-default"><?php echo JText::_('Expected Salary'); ?>:&nbsp;</span><?php 
                                   echo  $this->getJSModel('common')->getSalaryRangeView($row->dsymbol,$row->drangestart,$row->drangeend,JText::_($row->drangetype));
                                    ?>
                                </div>
                                <div class="js-col-xs-12 js-col-md-6 js-field color-font"><span class="js-bold color-default"><?php echo JText::_('Education'); ?></span>:&nbsp;<?php echo $row->education; ?></div>
                                <div class="js-col-xs-12 js-col-md-6 js-field color-font"><span class="js-bold color-default"><?php echo JText::_('Gender'); ?></span>:&nbsp;<?php if($row->gender == 1) echo JText::_('Male'); else echo JText::_('Female'); ?></div>
                                <div class="js-col-xs-12 js-col-md-6 js-field color-font"><span class="js-bold color-default"><?php echo JText::_('Available'); ?></span>:&nbsp;<?php echo $row->iamavailable==1 ? JText::_('Yes') :  JText::_('No'); ?></div>
                                <div class="js-col-xs-12 js-col-md-6 js-field color-font"><span class="js-bold color-default"><?php echo JText::_('Location'); ?></span>:&nbsp;<?php echo $this->getJSModel('city')->getLocationDataForView($row->cityid);?>
                                </div>
                            </div>
                        </div>
                        
                        <span class="resumedetail_detail" id="resumedetail_<?php echo $row->jobapplyid; ?>"></span>
                        <span class="resume_message_print" id="resumeactionmessage_<?php echo $row->jobapplyid; ?>"></span>
                        <div class="resume_sp_actions_div" id="resumeaction_<?php echo $row->jobapplyid; ?>"></div>
                    </div>
                </div>
                <?php
                    $k = 1 - $k;
                }?>

                <div id="jsjobs-pagination-wrapper">
                    <?php echo $this->pagination->getLimitBox(); ?>
                    <?php echo $this->pagination->getListFooter(); ?>
                </div>
            <?php }else{ 
                JSJOBSlayout::getNoRecordFound(); 
            } ?>                            
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" name="c"  id="c" value="jobapply" />
                <input type="hidden" name="view"  id="view" value="jobapply" />
                <input type="hidden" name="layout"  id="layout" value="jobappliedresume" />
                <input type="hidden" name="task"  id="task" value="actionresume" />
                <input type="hidden" name="jobid" id="jobid" value="<?php echo $this->oi; ?>" />
                <input type="hidden" name="oi" id="oi" value="<?php echo $this->oi; ?>" />
                <input type="hidden" name="resumeid" id="resumeid" value="<?php // echo $row->appid; ?>" />
                <input type="hidden" name="id" id="id" value="" />
                <input type="hidden" name="action" id="action" value="" />
                <input type="hidden" name="action_status" id="action_status" value="" />
                <input type="hidden" name="tab_action" id="tab_action" value="" />
                <input type="hidden" name="boxchecked" value="0" />
            </form>
        </div>
    </div>
<div id="full_background" style="display:none;"></div>
<div id="popup-main-outer" style="display:none;">
<div id="popup-main" style="display:none;">
    <span class="popup-top"><span id="popup_title"></span><img id="popup_cross" src="components/com_jsjobs/include/images/popup-close.png">
    </span>
    <div class="js-field-wrapper js-row no-margin" id="popup-bottom-part">
        <span id="popup_coverletter_title"></span>
        <span id="popup_coverletter_desc"> </span>
    </div>
</div>
</div>
<div id="jsjobsfooter">
    <table width="100%" style="table-layout:fixed;">
        <tr><td height="15"></td></tr>
        <tr>
            <td style="vertical-align:top;" align="center">
                <a class="img" target="_blank" href="http://www.joomsky.com"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png"></a>
                <br>
                Copyright &copy; 2008 - <?php echo  date('Y') ?> ,
                <span id="themeanchor"> <a class="anchor"target="_blank" href="http://www.burujsolutions.com">Buruj Solutions </a></span>
            </td>
        </tr>
    </table>
</div>

<script type="text/javascript">

    function showPopupAndSetValues(name,title,desc_id){
        jQuery("div#full_background").css("display","block");
        jQuery("div#popup-main").css("display","block");
        jQuery("div#popup-main-outer").slideDown('slow');
        jQuery("div#popup-main").slideDown('slow');
        jQuery("div#popup-main-outer").css("display","block");
        jQuery("div#full_background").click(function(){closePopup();});
        jQuery("img#popup_cross").click(function(){closePopup();});
        jQuery("div#popup-main").slideDown('slow');
        jQuery("span#popup_title").html(name);
        jQuery("span#popup_coverletter_title").html(title);
        myDivObj = document.getElementById(desc_id);
        if ( myDivObj ) {
            jQuery("span#popup_coverletter_desc").html(myDivObj.innerHTML);
        }
    }

    function closePopup(){      
        jQuery("div#popup-main-outer").slideUp('slow');
        setTimeout(function () {
            jQuery("div#full_background").hide();
            jQuery("span#popup_title").html('');
            jQuery("div#popup-main").css("display","none");
            jQuery("span#popup_coverletter_title").html('');
            jQuery("span#popup_coverletter_desc").html('');
        }, 700);
    }
</script>