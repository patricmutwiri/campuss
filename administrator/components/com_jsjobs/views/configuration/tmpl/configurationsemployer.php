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
JHTML::_('behavior.formvalidation');

$document = JFactory::getDocument();
if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('../components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}

$document->addScript('components/com_jsjobs/include/js/jquery_idTabs.js');

global $mainframe;
?>
<script language="javascript">
// for joomla 1.6
    Joomla.submitbutton = function (task) {
        if (task == '') {
            return false;
        } else {
            if (task == 'configuration.save') {
                returnvalue = validate_form(document.adminForm);
            } else
                returnvalue = true;
            if (returnvalue) {
                Joomla.submitform(task);
                return true;
            } else
                return false;
        }
    }
    function validate_form(f)
    {
        if (document.formvalidator.isValid(f)) {
            f.check.value = '<?php if (JVERSION < '3')
    echo JUtility::getToken();
else
    echo JSession::getFormToken();
?>';//send token
        } else {
            alert('<?php echo JText::_('Some values are not acceptable please check all tabs'); ?>');
            return false;
        }
        return true;
    }
</script>

<?php
$ADMINPATH = JPATH_BASE . '\components\com_jsjobs';



$yesno = array(
    '0' => array('value' => 1,
        'text' => JText::_('Yes')),
    '1' => array('value' => 0,
        'text' => JText::_('No')),);


$showhide = array(
    '0' => array('value' => 1,
        'text' => JText::_('Show')),
    '1' => array('value' => 0,
        'text' => JText::_('Hide')),);

$resumealert = array(
    '0' => array('value' => '', 'text' => JText::_('Select Option')),
    '1' => array('value' => 1, 'text' => JText::_('All Fields')),
    '2' => array('value' => 2, 'text' => JText::_('Only Filled Fields')),
);



$big_field_width = 40;
$med_field_width = 25;
$sml_field_width = 15;
?>


<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=controlpanel"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Employer Configurations'); ?></span></div>
         <form action="index.php" method="POST" name="adminForm" id="adminForm">
          <input type="hidden" name="check" value="post"/>
           <div id="tabs_wrapper" class="tabs_wrapper">
            <div class="idTabs">
                <a class="selected" href="#emp_generalsetting"><?php echo JText::_('General Settings'); ?></a>
                <a  href="#emp_visitor"><?php echo JText::_('Visitors'); ?></a>
                <a  href="#emp_listresume"><?php echo JText::_('Search Resume'); ?></a>
                <a  href="#emp_company"><?php echo JText::_('Company'); ?></a>
                <a  href="#emp_memberlinks"><?php echo JText::_('Members Links'); ?></a>
                <a  href="#emp_visitorlinks"><?php echo JText::_('Visitors Links'); ?></a>
                <a  href="#email"><?php echo JText::_('Resume Data'); ?></a>
            </div><!-- tab id div closed -->
            
            <div id="emp_generalsetting">
                <div class="headtext"><?php echo JText::_('General Settings'); ?></div>
                     <div id="jsjobs_left_main">
                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="newlisting_requiredpackage">
                                <?php echo JText::_('Package Required For Employer'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'newlisting_requiredpackage', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['newlisting_requiredpackage']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="newlisting_requiredpackage"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="showemployerlink">
                                <?php echo JText::_('Allow User Register As Employer'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'showemployerlink', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['showemployerlink']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="showemployerlink"><?php echo JText::_('Effects on user registration'); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="employerview_js_controlpanel">
                                <?php echo JText::_('Employer Can View Job Seeker Area'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'employerview_js_controlpanel', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['employerview_js_controlpanel']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="employerview_js_controlpanel"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="companyautoapprove">
                                <?php echo JText::_('Company Auto Approve'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'companyautoapprove', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['companyautoapprove']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="companyautoapprove"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="jobautoapprove">
                                <?php echo JText::_('Job Auto Approve'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'jobautoapprove', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['jobautoapprove']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="jobautoapprove"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="department_auto_approve">
                                <?php echo JText::_('Department Auto Approve'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'department_auto_approve', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['department_auto_approve']); ?> 
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="department_auto_approve"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="folder_auto_approve">
                                <?php echo JText::_('Folder Auto Approve'); ?><span class="pro_version">*</span>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'folder_auto_approve', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['folder_auto_approve']); ?> 
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="folder_auto_approve"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>
                     
                     </div><!-- left closed -->
                    <div id="jsjobs_right_main">
                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="goldcompany_autoapprove">
                                <?php echo JText::_('Gold Company Auto Approve'); ?><span class="pro_version">*</span>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'goldcompany_autoapprove', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['goldcompany_autoapprove']); ?> 
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="goldcompany_autoapprove"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="featuredcompany_autoapprove">
                                <?php echo JText::_('Featured Company Auto Approve'); ?><span class="pro_version">*</span>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'featuredcompany_autoapprove', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['featuredcompany_autoapprove']); ?> 
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="featuredcompany_autoapprove"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="companygoldexpiryindays">
                                <?php echo JText::_('Gold company Expire In Days'); ?><span class="pro_version">*</span>
                            </label>
                            <div class="jobs-config-value">
                                <input type="text" name="companygoldexpiryindays" id="companygoldexpiryindays" value="<?php echo $this->config['companygoldexpiryindays']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $med_field_width; ?>" maxlength="255" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="companygoldexpiryindays"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="companyfeaturedexpiryindays">
                                <?php echo JText::_('Featured company Expire In Days'); ?><span class="pro_version">*</span>
                            </label>
                            <div class="jobs-config-value">
                                <input type="text" name="companyfeaturedexpiryindays" id="companyfeaturedexpiryindays" value="<?php echo $this->config['companyfeaturedexpiryindays']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $med_field_width; ?>" maxlength="255" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="companyfeaturedexpiryindays"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>


                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="goldjob_autoapprove">
                                <?php echo JText::_('Gold Job Auto Approve'); ?><span class="pro_version">*</span>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'goldjob_autoapprove', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['goldjob_autoapprove']); ?> 
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="goldjob_autoapprove"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="featuredjob_autoapprove">
                                <?php echo JText::_('Featured job Auto Approve'); ?><span class="pro_version">*</span>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'featuredjob_autoapprove', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['featuredjob_autoapprove']); ?> 
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="featuredjob_autoapprove"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                </div><!-- right closed -->

            </div><!-- emp general setting closed -->
            <div id="emp_visitor">
                <div class="headtext"><?php echo JText::_('Job Posting Options'); ?></div>
                 <div id="jsjobs_left_main">
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="visitor_can_post_job">
                            <?php echo JText::_('Post Job'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $yesno, 'visitor_can_post_job', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitor_can_post_job']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="visitor_can_post_job"><?php echo JText::_('Visitor can post job'); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="visitor_can_edit_job">
                            <?php echo JText::_('Edit Job Posting'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $yesno, 'visitor_can_edit_job', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitor_can_edit_job']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="visitor_can_edit_job"><?php echo JText::_('Visitor can edit their posted job'); ?></label>     
                        </div>
                    </div>
                 
                 </div><!-- left closed -->
                 
                 <div id="jsjobs_right_main">
                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="job_captcha">
                            <?php echo JText::_('Form Captcha'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $yesno, 'job_captcha', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['job_captcha']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="job_captcha"><?php echo JText::_('Show captcha on visitor form job'); ?></label>     
                        </div>
                    </div>

                  </div><!-- right closed -->
                
                <div class="headtext"><?php echo JText::_('Visitors Can View Employer Area'); ?></div>
                 <div id="jsjobs_left_main">
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="visitorview_emp_conrolpanel">
                            <?php echo JText::_('Control Panel'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'visitorview_emp_conrolpanel', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitorview_emp_conrolpanel']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="visitorview_emp_conrolpanel"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="visitorview_emp_packages">
                            <?php echo JText::_('Packages'); ?>
                        </label>
                        <div class="jobs-config-value">
                           <?php echo JHTML::_('select.genericList', $showhide, 'visitorview_emp_packages', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitorview_emp_packages']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="visitorview_emp_packages"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="visitorview_emp_resumesearch">
                            <?php echo JText::_('Resume Search'); ?>
                        </label>
                        <div class="jobs-config-value">
                           <?php echo JHTML::_('select.genericList', $showhide, 'visitorview_emp_resumesearch', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitorview_emp_resumesearch']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="visitorview_emp_resumesearch"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>
                 
                 </div><!-- left closed -->
                 
                 <div id="jsjobs_right_main">


                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="visitorview_emp_resumesearchresult">
                            <?php echo JText::_('Resume Search Results'); ?>
                        </label>
                        <div class="jobs-config-value">
                           <?php echo JHTML::_('select.genericList', $showhide, 'visitorview_emp_resumesearchresult', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitorview_emp_resumesearchresult']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="visitorview_emp_resumesearchresult"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="visitorview_emp_viewpackage">
                            <?php echo JText::_('Package Detail'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'visitorview_emp_viewpackage', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitorview_emp_viewpackage']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="visitorview_emp_viewpackage"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                  </div><!-- right closed -->
        </div><!-- emp visitor closed -->
        <div id="emp_listresume">
            <div class="headtext"><?php echo JText::_('Search Resume Form Settings'); ?></div>
             <div id="jsjobs_left_main">
                <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_resume_showsave">
                        <?php echo JText::_('Allow Save Search'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $yesno, 'search_resume_showsave', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_resume_showsave']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_resume_showsave"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>
                <?php /*
                <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_resume_salaryrange">
                        <?php echo JText::_('Salary Range'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'search_resume_salaryrange', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_resume_salaryrange']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_resume_salaryrange"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_resume_title">
                        <?php echo JText::_('Title'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'search_resume_title', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_resume_title']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_resume_title"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_resume_gender">
                        <?php echo JText::_('Gender'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'search_resume_gender', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_resume_gender']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_resume_gender"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_resume_name">
                        <?php echo JText::_('Name'); ?>
                    </label>
                    <div class="jobs-config-value">
                       <?php echo JHTML::_('select.genericList', $showhide, 'search_resume_name', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_resume_name']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_resume_name"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_resume_type">
                        <?php echo JText::_('Type'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'search_resume_type', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_resume_type']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_resume_type"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_resume_category">
                        <?php echo JText::_('Category'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'search_resume_category', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_resume_category']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_resume_category"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                 <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_resume_available">
                        <?php echo JText::_('Available'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'search_resume_available', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_resume_available']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_resume_available"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>
                */ ?>
             </div><!-- left closed -->
             <?php /*
             <div id="jsjobs_right_main">
                <div id="jsjob_configuration_wrapper" >
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_resume_experience">
                        <?php echo JText::_('Experience'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'search_resume_experience', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_resume_experience']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_resume_experience"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                <div id="jsjob_configuration_wrapper" >
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_resume_nationality">
                        <?php echo JText::_('Nationality'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'search_resume_nationality', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_resume_nationality']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_resume_nationality"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                <div id="jsjob_configuration_wrapper" >
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_resume_heighesteducation">
                        <?php echo JText::_('Highest Education'); ?>
                    </label>
                    <div class="jobs-config-value">
                       <?php echo JHTML::_('select.genericList', $showhide, 'search_resume_heighesteducation', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_resume_heighesteducation']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_resume_heighesteducation"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                <div id="jsjob_configuration_wrapper" >
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_resume_subcategory">
                        <?php echo JText::_('Sub Category'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'search_resume_subcategory', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_resume_subcategory']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_resume_subcategory"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                <div id="jsjob_configuration_wrapper" >
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_resume_keywords">
                        <?php echo JText::_('Keywords'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'search_resume_keywords', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_resume_keywords']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_resume_keywords"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                <div id="jsjob_configuration_wrapper" >
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_resume_zipcode">
                        <?php echo JText::_('Zip Code'); ?>
                    </label>
                    <div class="jobs-config-value">
                       <?php echo JHTML::_('select.genericList', $showhide, 'search_resume_zipcode', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_resume_zipcode']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_resume_zipcode"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                <div id="jsjob_configuration_wrapper" >
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_resume_location">
                        <?php echo JText::_('Location'); ?>
                    </label>
                    <div class="jobs-config-value">
                       <?php echo JHTML::_('select.genericList', $showhide, 'search_resume_location', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_resume_location']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_resume_location"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>
 
              </div><!-- right closed -->  
              */ ?>
        </div><!-- emp list resume closed -->
        <div id="emp_company">
          <div class="headtext"><?php echo JText::_('Company Settings'); ?></div>
             <div id="jsjobs_left_main">
                <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="comp_name">
                        <?php echo JText::_('Company Name'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'comp_name', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['comp_name']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="comp_name"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="comp_email_address">
                        <?php echo JText::_('Company Email Address'); ?>
                    </label>
                    <div class="jobs-config-value">
                       <?php echo JHTML::_('select.genericList', $showhide, 'comp_email_address', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['comp_email_address']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="comp_email_address"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="comp_city">
                        <?php echo JText::_('City'); ?>
                    </label>
                    <div class="jobs-config-value">
                      <?php echo JHTML::_('select.genericList', $showhide, 'comp_city', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['comp_city']); ?></td>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="comp_city"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>
             
             </div><!-- left closed -->
             
             <div id="jsjobs_right_main">
                <div id="jsjob_configuration_wrapper" >
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="comp_show_url">
                        <?php echo JText::_('Company Url'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'comp_show_url', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['comp_show_url']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="comp_show_url"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                <div id="jsjob_configuration_wrapper" >
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="comp_zipcode">
                        <?php echo JText::_('Zip Code'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'comp_zipcode', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['comp_zipcode']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="comp_zipcode"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

              </div><!-- right closed -->  
        </div><!-- emp company closed -->
        <div id="emp_memberlinks">
           <div class="headtext"><?php echo JText::_('Employer Top Menu Links'); ?></div>
             <div id="jsjobs_left_main">
                <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="tmenu_emcontrolpanel">
                        <?php echo JText::_('Control Panel'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'tmenu_emcontrolpanel', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['tmenu_emcontrolpanel']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="tmenu_emcontrolpanel"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="tmenu_emnewjob">
                        <?php echo JText::_('New Job'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'tmenu_emnewjob', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['tmenu_emnewjob']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="tmenu_emnewjob"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                 <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="tmenu_emmyjobs">
                        <?php echo JText::_('My Jobs'); ?>
                    </label>
                    <div class="jobs-config-value">
                       <?php echo JHTML::_('select.genericList', $showhide, 'tmenu_emmyjobs', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['tmenu_emmyjobs']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="tmenu_emmyjobs"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

             
             </div><!-- left closed -->
             
             <div id="jsjobs_right_main">
                <div id="jsjob_configuration_wrapper" >
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="tmenu_emsearchresume">
                        <?php echo JText::_('Resume Search'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'tmenu_emsearchresume', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['tmenu_emsearchresume']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="tmenu_emsearchresume"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>
                 <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="tmenu_emmycompanies">
                        <?php echo JText::_('My Companies'); ?>
                    </label>
                    <div class="jobs-config-value">
                       <?php echo JHTML::_('select.genericList', $showhide, 'tmenu_emmycompanies', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['tmenu_emmycompanies']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="tmenu_emmycompanies"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>
                <?php /*
                <div id="jsjob_configuration_wrapper" >
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="tmenu_emnewcompany">
                        <?php echo JText::_('New Company'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'tmenu_emnewcompany', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['tmenu_emnewcompany']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="tmenu_emnewcompany"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                <div id="jsjob_configuration_wrapper" >
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="tmenu_emnewdepartment">
                        <?php echo JText::_('New Department'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'tmenu_emnewdepartment', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['tmenu_emnewdepartment']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="tmenu_emnewdepartment"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                <div id="jsjob_configuration_wrapper" >
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="tmenu_emnewfolder">
                        <?php echo JText::_('New Folder'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'tmenu_emnewfolder', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['tmenu_emnewfolder']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="tmenu_emnewfolder"><?php echo JText::_(''); ?></label>     
                    </div>
                </div> */ ?>

               
              </div><!-- right closed -->
              
              <div class="headtext"><?php echo JText::_('Employer Control Panel Links'); ?></div>
                 <div id="jsjobs_left_main">

                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="jobs_graph">
                            <?php echo JText::_('Jobs Graph'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'jobs_graph', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['jobs_graph']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="jobs_graph"><?php echo JText::_(''); ?></label>
                        </div>
                    </div>
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="resume_graph">
                            <?php echo JText::_('Resume Graph'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'resume_graph', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['resume_graph']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="resume_graph"><?php echo JText::_(''); ?></label>
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="box_newestresume">
                            <?php echo JText::_('Newest Resume Box'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'box_newestresume', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['box_newestresume']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="box_newestresume"><?php echo JText::_(''); ?></label>
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="box_appliedresume">
                            <?php echo JText::_('Applied Resume Box'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'box_appliedresume', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['box_appliedresume']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="box_appliedresume"><?php echo JText::_(''); ?></label>
                        </div>
                    </div>
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="mystuff_area">
                            <?php echo JText::_('My Stuff Area'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'mystuff_area', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['mystuff_area']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="mystuff_area"><?php echo JText::_(''); ?></label>
                        </div>
                    </div>
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="mystats_area">
                            <?php echo JText::_('My Stats Area'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'mystats_area', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['mystats_area']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="mystats_area"><?php echo JText::_(''); ?></label>
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="mycompanies">
                            <?php echo JText::_('My Companies'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'mycompanies', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['mycompanies']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="mycompanies"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="formcompany">
                            <?php echo JText::_('New Company'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'formcompany', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['formcompany']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="formcompany"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>
                    <?php /* 
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="alljobsappliedapplications">
                            <?php echo JText::_('Applied Resume'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'alljobsappliedapplications', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['alljobsappliedapplications']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="alljobsappliedapplications"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>
                    */ ?>
                    

                    
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="myjobs">
                            <?php echo JText::_('My Jobs'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'myjobs', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['myjobs']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="myjobs"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="formjob">
                            <?php echo JText::_('New Job'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'formjob', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['formjob']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="formjob"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>


                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="my_resumesearches">
                            <?php echo JText::_('Resume Save Searches'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'my_resumesearches', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['my_resumesearches']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="my_resumesearches"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="resumesearch">
                            <?php echo JText::_('Resume Search'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'resumesearch', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['resumesearch']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="resumesearch"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                 </div><!-- left closed -->
                 
                 <div id="jsjobs_right_main">
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="emresumebycategory">
                            <?php echo JText::_('Resume By Categories'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php
                                        echo JText::_('If Resume Search Is Allowed Then Its Allowed Also');
                                        //JHTML::_('select.genericList', $showhide, 'emresumebycategory', 'class="inputfieldsizeful inputbox" '. '', 'value', 'text', $this->config['emresumebycategory']); 
                                        ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="emresumebycategory"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>
                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="mydepartment">
                            <?php echo JText::_('My Departments'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'mydepartment', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['mydepartment']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="mydepartment"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="purchasehistory">
                            <?php echo JText::_('Purchase History'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'purchasehistory', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['purchasehistory']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="purchasehistory"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="empmessages">
                            <?php echo JText::_('Messages'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'empmessages', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['empmessages']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="empmessages"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="my_stats">
                            <?php echo JText::_('My Stats'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'my_stats', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['my_stats']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="my_stats"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="empresume_rss">
                            <?php echo JText::_('Resume RSS'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'empresume_rss', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['empresume_rss']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="empresume_rss"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="myfolders">
                            <?php echo JText::_('Folders'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'myfolders', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['myfolders']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="myfolders"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="newfolders">
                            <?php echo JText::_('New Folder'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'newfolders', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['newfolders']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="newfolders"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>


                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="empexpire_package_message">
                            <?php echo JText::_('Expire Package Message'); ?>
                        </label>
                        <div class="jobs-config-value">
                           <?php echo JHTML::_('select.genericList', $showhide, 'empexpire_package_message', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['empexpire_package_message']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="empexpire_package_message"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="empregister">
                            <?php echo JText::_('Employer Registration'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'empregister', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['empregister']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="empregister"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="emploginlogout">
                                <?php echo JText::_('Show Login/logout Button'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'emploginlogout', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['emploginlogout']); ?> 
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="emploginlogout"><?php echo JText::_('Show Login/logout Button In Employer Control Panel'); ?></label>     
                            </div>
                    </div>


                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="packages">
                            <?php echo JText::_('Packages'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'packages', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['packages']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="packages"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>      

                  </div><!-- right closed -->

        </div><!-- emp member links closed -->
        <div id="emp_visitorlinks">
            <div class="headtext"><?php echo JText::_('Employer Top Menu Links'); ?></div>
                 <div id="jsjobs_left_main">
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="tmenu_vis_emcontrolpanel">
                            <?php echo JText::_('Control Panel'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'tmenu_vis_emcontrolpanel', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['tmenu_vis_emcontrolpanel']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="tmenu_vis_emcontrolpanel"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="tmenu_vis_emnewjob">
                            <?php echo JText::_('New Job'); ?>
                        </label>
                        <div class="jobs-config-value">
                           <?php echo JHTML::_('select.genericList', $showhide, 'tmenu_vis_emnewjob', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['tmenu_vis_emnewjob']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="tmenu_vis_emnewjob"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="tmenu_vis_emmyjobs">
                            <?php echo JText::_('My Jobs'); ?>
                        </label>
                        <div class="jobs-config-value">
                           <?php echo JHTML::_('select.genericList', $showhide, 'tmenu_vis_emmyjobs', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['tmenu_vis_emmyjobs']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="tmenu_vis_emmyjobs"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>
                 
                 </div><!-- left closed -->
                 
                 <div id="jsjobs_right_main">
                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="tmenu_vis_emmycompanies">
                            <?php echo JText::_('My Companies'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'tmenu_vis_emmycompanies', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['tmenu_vis_emmycompanies']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="tmenu_vis_emmycompanies"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="tmenu_vis_emsearchresume">
                            <?php echo JText::_('Resume Search'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'tmenu_vis_emsearchresume', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['tmenu_vis_emsearchresume']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="tmenu_vis_emsearchresume"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>
                </div><!-- right closed -->
                <div class="headtext"><?php echo JText::_('Employer Control Panel Links'); ?></div>
                     <div id="jsjobs_left_main">
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_jobs_graph">
                            <?php echo JText::_('Jobs Graph'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'vis_jobs_graph', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_jobs_graph']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="vis_jobs_graph"><?php echo JText::_(''); ?></label>
                        </div>
                    </div>
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_resume_graph">
                            <?php echo JText::_('Resume Graph'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'vis_resume_graph', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_resume_graph']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="vis_resume_graph"><?php echo JText::_(''); ?></label>
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_box_newestresume">
                            <?php echo JText::_('Newest Resume Box'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'vis_box_newestresume', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_box_newestresume']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="vis_box_newestresume"><?php echo JText::_(''); ?></label>
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_box_appliedresume">
                            <?php echo JText::_('Applied Resume Box'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'vis_box_appliedresume', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_box_appliedresume']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="vis_box_appliedresume"><?php echo JText::_(''); ?></label>
                        </div>
                    </div>
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_mystuff_area">
                            <?php echo JText::_('My Stuff Area'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'vis_mystuff_area', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_mystuff_area']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="vis_mystuff_area"><?php echo JText::_(''); ?></label>
                        </div>
                    </div>
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_mystats_area">
                            <?php echo JText::_('My Stats Area'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'vis_mystats_area', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_mystats_area']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="vis_mystats_area"><?php echo JText::_(''); ?></label>
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_emmycompanies">
                            <?php echo JText::_('My Companies'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'vis_emmycompanies', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_emmycompanies']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="vis_emmycompanies"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_emformcompany">
                            <?php echo JText::_('New Company'); ?>
                        </label>
                        <div class="jobs-config-value">
                           <?php echo JHTML::_('select.genericList', $showhide, 'vis_emformcompany', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_emformcompany']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="vis_emformcompany"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>
                        <?php /*
                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_emalljobsappliedapplications">
                                <?php echo JText::_('Applied Resume'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $showhide, 'vis_emalljobsappliedapplications', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_emalljobsappliedapplications']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="vis_emalljobsappliedapplications"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>   */  ?>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_emmyjobs">
                                <?php echo JText::_('My Jobs'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $showhide, 'vis_emmyjobs', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_emmyjobs']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="vis_emmyjobs"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_emformjob">
                                <?php echo JText::_('New Job'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $showhide, 'vis_emformjob', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_emformjob']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="vis_emformjob"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_emresumesearch">
                                <?php echo JText::_('Resume Search'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $showhide, 'vis_emresumesearch', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_emresumesearch']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="vis_emresumesearch"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>
                        
                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_emmy_resumesearches">
                                <?php echo JText::_('Resume Save Searches'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $showhide, 'vis_emmy_resumesearches', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_emmy_resumesearches']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="vis_emmy_resumesearches"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                     </div><!-- left closed -->
                     
                     <div id="jsjobs_right_main">
                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_emresumebycategory">
                                <?php echo JText::_('Resume By Categories'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $showhide, 'vis_emresumebycategory', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_emresumebycategory']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="vis_emresumebycategory"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>
                        
                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_emmydepartment">
                                <?php echo JText::_('My Departments'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $showhide, 'vis_emmydepartment', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_emmydepartment']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="vis_emmydepartment"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>
                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_emformdepartment">
                                <?php echo JText::_('New Department'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $showhide, 'vis_emformdepartment', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_emformdepartment']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="vis_emformdepartment"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>
                        
                         <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_emmyfolders">
                                <?php echo JText::_('Folders'); ?><span class="pro_version">*</span>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $showhide, 'vis_emmyfolders', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_emmyfolders']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="vis_emmyfolders"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_emnewfolders">
                                <?php echo JText::_('New Folder'); ?><span class="pro_version">*</span>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $showhide, 'vis_emnewfolders', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_emnewfolders']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="vis_emnewfolders"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_empackages">
                                <?php echo JText::_('Packages'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $showhide, 'vis_empackages', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_empackages']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="vis_empackages"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                          <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_empurchasehistory">
                                <?php echo JText::_('Purchase History'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $showhide, 'vis_empurchasehistory', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_empurchasehistory']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="vis_empurchasehistory"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>
                          <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_emmessages">
                                <?php echo JText::_('Messages'); ?><span class="pro_version">*</span>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $showhide, 'vis_emmessages', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_emmessages']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="vis_emmessages"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>
                          <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_emmy_stats">
                                <?php echo JText::_('My Stats'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $showhide, 'vis_emmy_stats', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_emmy_stats']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="vis_emmy_stats"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>
                          <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_resume_rss">
                                <?php echo JText::_('Resume RSS'); ?><span class="pro_version">*</span>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $showhide, 'vis_resume_rss', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_resume_rss']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="vis_resume_rss"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>
                         
                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_emempregister">
                                <?php echo JText::_('Register'); ?><span class="pro_version">*</span>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $showhide, 'vis_emempregister', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_emempregister']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="vis_emempregister"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>
                         
                      </div><!-- right closed -->

        </div><!-- emp emp visitor links closed -->
        <div id="email">
            <div class="headtext"><?php echo JText::_('Email Alert To Employer On Resume Apply'); ?></div>
                 <div id="jsjobs_left_main">
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="employer_resume_alert_fields">
                            <?php echo JText::_('What Include In Email'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $resumealert, 'employer_resume_alert_fields', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['employer_resume_alert_fields']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="employer_resume_alert_fields"><?php echo JText::_('All fields are included in employer email content or only filled fields').'. '. JText::_('This option is valid if employer select send resume data in email settings at from job'); ?></label>     
                        </div>
                    </div>
              
                 </div><!-- left closed -->
                 
             </div><!-- emp email closed -->
    </div><!-- wrapper closed -->
    <input type="hidden" name="layout" value="configurationsemployer" />
    <input type="hidden" name="task" value="configuration.saveconf" />
    <input type="hidden" name="notgeneralbuttonsubmit" value="1" />
    <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
        <?php echo JHTML::_( 'form.token' ); ?>        
    </form>
    </div><!-- jsjobs content -->
</div><!-- jsjobs wrapper -->
<div class="proversiononly"><span class="pro_version">*</span><?php echo JText::_('Pro version only');?></div>
<div id="bottomend"></div>
<!--  -->
<div id="jsjobs-footer">
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

