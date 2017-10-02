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
    jQuery(document).ready(function () {
        var value = jQuery("#showapplybutton").val();
        var divsrc = "div#showhideapplybutton";
        if (value == 2) {
            jQuery(divsrc).slideDown("slow");
        }
    });
    function showhideapplybutton(src, value) {
        var divsrc = "div#" + src;
        if (value == 2) {
            jQuery(divsrc).slideDown("slow");
        } else if (value == 1) {
            jQuery(divsrc).slideUp("slow");
            jQuery(divsrc).hide();
        }
        return true;
    }


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
            f.check.value = '<?php
if (JVERSION < '3')
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

$applybutton = array(
    '0' => array('value' => 1,
        'text' => JText::_('Enable')),
    '1' => array('value' => 0,
        'text' => JText::_('Disable')),);




$big_field_width = 40;
$med_field_width = 25;
$sml_field_width = 15;
?>

<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=controlpanel"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Job Seeker Configurations'); ?></span></div>
         <form action="index.php" method="POST" name="adminForm" id="adminForm">
          <input type="hidden" name="check" value="post"/>
           <div id="tabs_wrapper" class="tabs_wrapper">
            <div class="idTabs">
                <a class="selected" href="#js_generalsetting"><?php echo JText::_('General Settings'); ?></a>
                <a  href="#js_visitor"><?php echo JText::_('Visitors'); ?></a>
                <a  href="#js_jobsearch"><?php echo JText::_('Job Search'); ?></a>
                <a  href="#js_memberlinks"><?php echo JText::_('Members Links'); ?></a>
                <a  href="#js_visitorlinks"><?php echo JText::_('Visitors Links'); ?></a>
                <a  href="#email"><?php echo JText::_('Contact Email'); ?></a>
            </div><!-- tab id div closed -->
            
            <div id="js_generalsetting">
                <div class="headtext"><?php echo JText::_('General Settings'); ?></div>
                     <div id="jsjobs_left_main">
                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="js_newlisting_requiredpackage">
                                <?php echo JText::_('Package Required For Job Seeker'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'js_newlisting_requiredpackage', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['js_newlisting_requiredpackage']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="js_newlisting_requiredpackage"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>
                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="empautoapprove">
                                <?php echo JText::_('Resume Auto Approve'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'empautoapprove', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['empautoapprove']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="empautoapprove"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="goldresume_autoapprove">
                                <?php echo JText::_('Gold Resume Auto Approve'); ?><span class="pro_version">*</span>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'goldresume_autoapprove', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['goldresume_autoapprove']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="goldresume_autoapprove"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="featuredresume_autoapprove">
                                <?php echo JText::_('Featured Resume Auto Approve'); ?><span class="pro_version">*</span>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'featuredresume_autoapprove', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['featuredresume_autoapprove']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="featuredresume_autoapprove"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="resumegoldexpiryindays">
                                <?php echo JText::_('Gold Resume Expire In Days'); ?><span class="pro_version">*</span>
                            </label>
                            <div class="jobs-config-value">
                                <input type="text" name="resumegoldexpiryindays" id="resumegoldexpiryindays" value="<?php echo $this->config['resumegoldexpiryindays']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $med_field_width; ?>" maxlength="255" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="resumegoldexpiryindays"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="resumefeaturedexpiryindays">
                                <?php echo JText::_('Featured Resume Expire In Days'); ?><span class="pro_version">*</span>
                            </label>
                            <div class="jobs-config-value">
                                <input type="text" name="resumefeaturedexpiryindays" id="resumefeaturedexpiryindays" value="<?php echo $this->config['resumefeaturedexpiryindays']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $med_field_width; ?>" maxlength="255" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="resumefeaturedexpiryindays"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="resume_photofilesize">
                                <?php echo JText::_('Resume Photo Size Allowed'); ?>
                            </label>
                            <div class="jobs-config-value">
                               <input type="text" name="resume_photofilesize" id="resume_photofilesize" value="<?php echo $this->config['resume_photofilesize']; ?>" class="inputfieldsize inputbox validate-numeric" maxlength="6" size="<?php echo $med_field_width; ?>" /><label class="jobs-mini-descp" for="resume_photofilesize"><?php echo JText::_('Kb'); ?></label>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="resume_photofilesize"><?php echo JText::_('Max file size allowed'); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="show_applied_resume_status">
                                <?php echo JText::_('Show Applied Resume Status'); ?><span class="pro_version">*</span>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'show_applied_resume_status', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['show_applied_resume_status']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="show_applied_resume_status"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="jobalert_auto_approve">
                                <?php echo JText::_('Job Alert Auto Approve'); ?><span class="pro_version">*</span>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'jobalert_auto_approve', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['jobalert_auto_approve']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="jobalert_auto_approve"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_jslistjobshortlist">
                                <?php echo JText::_('Job Short List'); ?><span class="pro_version">*</span>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $showhide, 'vis_jslistjobshortlist', 'class="inputfieldsizeful inputbox"' . 'onChange="showhideapplybutton(\'showhideapplybutton\', this.value)"', 'value', 'text', $this->config['vis_jslistjobshortlist']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="vis_jslistjobshortlist"><?php echo JText::_('Job short list setting effects on jobs listing page'); ?></label>     
                            </div>
                        </div>
                        
                    </div><!-- left closed -->
                     
                    
                    <div id="jsjobs_right_main">


                        

                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="showapplybutton">
                                <?php echo JText::_('Show Apply Now Button'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $applybutton, 'showapplybutton', 'class="inputfieldsizeful inputbox"' . 'onChange="showhideapplybutton(\'showhideapplybutton\', this.value)"', 'value', 'text', $this->config['showapplybutton']); ?>
                            </div>
                        </div>
                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="apllybuttonshow">
                                <?php echo JText::_('Apply Now Redirect Link'); ?><span class="pro_version">*</span>
                            </label>                            
                            <div class="jobs-config-value" id="defhiden" for="apllybuttonshow">
                                <input type="text" id="apllybuttonshow" name="applybuttonredirecturl" class="inputfieldsizeful inputbox" value="<?php echo $this->config['applybuttonredirecturl']; ?>" size="<?php echo $big_field_width; ?>" >
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="apllybuttonshow"><?php echo JText::_('Click on Apply Now button will be redirect to given url'); ?></label>
                            </div>

                        </div>

                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="show_only_section_that_have_value">
                                <?php echo JText::_('Show Only The Sections That Have Value'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'show_only_section_that_have_value', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['show_only_section_that_have_value']); ?> 
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="show_only_section_that_have_value"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="max_resume_employers">
                                <?php echo JText::_('Number Of Employers Allowed'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <input type="text" name="max_resume_employers" id="max_resume_employers" value="<?php echo $this->config['max_resume_employers']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $med_field_width; ?>" maxlength="255" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="max_resume_employers"><?php echo JText::_('Maximum number of employer allow in resume'); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="max_resume_addresses">
                                <?php echo JText::_('Number Of Addresses Allowed'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <input type="text" name="max_resume_addresses" id="max_resume_addresses" value="<?php echo $this->config['max_resume_addresses']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $med_field_width; ?>" maxlength="255" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="max_resume_addresses"><?php echo JText::_('Maximum number of address allow in resume'); ?></label>     
                            </div>
                        </div>
                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="max_resume_institutes">
                                <?php echo JText::_('Number Of Institute Allowed'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <input type="text" name="max_resume_institutes" id="max_resume_institutes" value="<?php echo $this->config['max_resume_institutes']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $med_field_width; ?>" maxlength="255" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="max_resume_institutes"><?php echo JText::_('Maximum number of institute allow in resume'); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="max_resume_languages">
                                <?php echo JText::_('Number Of Languages Allowed'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <input type="text" name="max_resume_languages" id="max_resume_languages" value="<?php echo $this->config['max_resume_languages']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $med_field_width; ?>" maxlength="255" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="max_resume_languages"><?php echo JText::_('Maximum number of language allow in resume'); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="max_resume_references">
                                <?php echo JText::_('Number Of References Allowed'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <input type="text" name="max_resume_references" id="max_resume_references" value="<?php echo $this->config['max_resume_references']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $med_field_width; ?>" maxlength="255" />
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="max_resume_references"><?php echo JText::_('Maximum number of reference allow in resume'); ?></label>     
                            </div>
                        </div>


 

                      </div><!-- right closed -->

            </div><!-- js general setting closed -->
        <div id="js_jobsearch">
            <div class="headtext"><?php echo JText::_('Search Job Settings'); ?></div>
             <div id="jsjobs_left_main">
                <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_job_showsave">
                        <?php echo JText::_('Allow Save Search'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $yesno, 'search_job_showsave', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_job_showsave']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_job_showsave"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>
                <?php /*
                <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_job_title">
                        <?php echo JText::_('Title'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'search_job_title', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_job_title']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_job_title"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_job_category">
                        <?php echo JText::_('Category'); ?>
                    </label>
                    <div class="jobs-config-value">
                       <?php echo JHTML::_('select.genericList', $showhide, 'search_job_category', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_job_category']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_job_category"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_job_type">
                        <?php echo JText::_('Job Type'); ?>
                    </label>
                    <div class="jobs-config-value">
                       <?php echo JHTML::_('select.genericList', $showhide, 'search_job_type', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_job_type']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_job_type"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_job_shift">
                        <?php echo JText::_('Shifts'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'search_job_shift', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_job_shift']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_job_shift"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>


                <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_job_durration">
                        <?php echo JText::_('Duration'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'search_job_durration', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_job_durration']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_job_durration"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_job_startpublishing">
                        <?php echo JText::_('Start Publishing'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'search_job_startpublishing', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_job_startpublishing']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_job_startpublishing"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>
                
                <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_job_stoppublishing">
                        <?php echo JText::_('Stop Publishing'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'search_job_stoppublishing', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_job_stoppublishing']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_job_stoppublishing"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                <div id="jsjob_configuration_wrapper" >
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_job_status">
                        <?php echo JText::_('Job Status'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'search_job_status', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_job_status']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_job_status"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>  
                                <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_job_careerlevel">
                        <?php echo JText::_('Career Level'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'search_job_careerlevel', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_job_careerlevel']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_job_careerlevel"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>
                <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_job_workpermit">
                        <?php echo JText::_('Work Permit'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'search_job_workpermit', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_job_workpermit']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_job_workpermit"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>
                <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_job_reqiuredtravel">
                        <?php echo JText::_('Required Travel'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'search_job_reqiuredtravel', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_job_reqiuredtravel']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_job_reqiuredtravel"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>
                */ ?>
             </div><!-- left closed -->
            <?php /* 
             <div id="jsjobs_right_main">

                <div id="jsjob_configuration_wrapper" >
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_job_company">
                        <?php echo JText::_('Company'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'search_job_company', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_job_company']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_job_company"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_job_companysite">
                        <?php echo JText::_('Company Site'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'search_job_companysite', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_job_companysite']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_job_companysite"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>
             
                <div id="jsjob_configuration_wrapper" >
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_job_subcategory">
                        <?php echo JText::_('Sub Category'); ?>
                    </label>
                    <div class="jobs-config-value">
                       <?php echo JHTML::_('select.genericList', $showhide, 'search_job_subcategory', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_job_subcategory']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_job_subcategory"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                <div id="jsjob_configuration_wrapper" >
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_job_salaryrange">
                        <?php echo JText::_('Salary Range'); ?>
                    </label>
                    <div class="jobs-config-value">
                       <?php echo JHTML::_('select.genericList', $showhide, 'search_job_salaryrange', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_job_salaryrange']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_job_salaryrange"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                
                <div id="jsjob_configuration_wrapper" >
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_job_city">
                        <?php echo JText::_('City'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'search_job_city', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_job_city']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_job_city"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>
                
                   
                <div id="jsjob_configuration_wrapper" >
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_job_zipcode">
                        <?php echo JText::_('Zip Code'); ?>
                    </label>
                    <div class="jobs-config-value">
                       <?php echo JHTML::_('select.genericList', $showhide, 'search_job_zipcode', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_job_zipcode']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_job_zipcode"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                <div id="jsjob_configuration_wrapper" >
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_job_coordinates">
                        <?php echo JText::_('Map Coordinates'); ?>
                    </label>
                    <div class="jobs-config-value">
                       <?php echo JHTML::_('select.genericList', $showhide, 'search_job_coordinates', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_job_coordinates']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_job_coordinates"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                <div id="jsjob_configuration_wrapper" >
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_job_keywords">
                        <?php echo JText::_('Keywords'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'search_job_keywords', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_job_keywords']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_job_keywords"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                <div id="jsjob_configuration_wrapper" >
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_job_gender">
                        <?php echo JText::_('Gender'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'search_job_gender', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_job_gender']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_job_gender"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>
                <div id="jsjob_configuration_wrapper" >
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_job_education">
                        <?php echo JText::_('Highest Education'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'search_job_education', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_job_education']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_job_education"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>
                <div id="jsjob_configuration_wrapper" >
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="search_job_experience">
                        <?php echo JText::_('Experience'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'search_job_experience', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['search_job_experience']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="search_job_experience"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>
                
 
              </div><!-- right closed --> 
              */ ?> 
        </div><!-- js job search closed -->
        <div id="js_memberlinks">
           <div class="headtext"><?php echo JText::_('Job Seeker Top Menu Links'); ?></div>
             <div id="jsjobs_left_main">
                <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="tmenu_jscontrolpanel">
                        <?php echo JText::_('Control Panel'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'tmenu_jscontrolpanel', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['tmenu_jscontrolpanel']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="tmenu_jscontrolpanel"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

            <div id="jsjob_configuration_wrapper">
                <label class="jobs-config-title stylelabeltop labelcolortop" for="tmenu_jsnewestjob">
                    <?php echo JText::_('Newest Jobs'); ?>
                </label>
                <div class="jobs-config-value">
                   <?php echo JHTML::_('select.genericList', $showhide, 'tmenu_jsnewestjob', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['tmenu_jsnewestjob']); ?>
                </div>
                <div class="jobs-config-descript">
                    <label class=" stylelabelbottom labelcolorbottom" for="tmenu_jsnewestjob"><?php echo JText::_(''); ?></label>     
                </div>
            </div>
         
             <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="tmenu_jsjobcategory">
                        <?php echo JText::_('Job Categories'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'tmenu_jsjobcategory', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['tmenu_jsjobcategory']);?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="tmenu_jsjobcategory"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

             </div><!-- left closed -->
             
            <div id="jsjobs_right_main">
                <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="tmenu_jssearchjob">
                        <?php echo JText::_('Search Jobs'); ?>
                    </label>
                    <div class="jobs-config-value">
                       <?php echo JHTML::_('select.genericList', $showhide, 'tmenu_jssearchjob', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['tmenu_jssearchjob']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="tmenu_jssearchjob"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>
                
                <div id="jsjob_configuration_wrapper" >
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="tmenu_jsmyresume">
                        <?php echo JText::_('My Resumes'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'tmenu_jsmyresume', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['tmenu_jsmyresume']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="tmenu_jsmyresume"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>
            </div><!-- right closed -->
              
              <div class="headtext"><?php echo JText::_('Job Seeker Control Panel Links'); ?></div>
                 <div id="jsjobs_left_main">

                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="jsactivejobs_graph">
                            <?php echo JText::_('Active Jobs Graph'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'jsactivejobs_graph', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['jsactivejobs_graph']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="jsactivejobs_graph"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="jsmystuff_area">
                            <?php echo JText::_('My Stuff Area'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'jsmystuff_area', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['jsmystuff_area']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="jsmystuff_area"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="jsmystats_area">
                            <?php echo JText::_('My Stats Area'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'jsmystats_area', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['jsmystats_area']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="jsmystats_area"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="jsnewestjobs_box">
                            <?php echo JText::_('Suggested Jobs Box'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'jsnewestjobs_box', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['jsnewestjobs_box']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="jsnewestjobs_box"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="jsappliedresume_box">
                            <?php echo JText::_('Applied Resume Box'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'jsappliedresume_box', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['jsappliedresume_box']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="jsappliedresume_box"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>
                    
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="myresumes">
                            <?php echo JText::_('My Resumes'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'myresumes', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['myresumes']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="myresumes"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="formresume">
                            <?php echo JText::_('Add Resume'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'formresume', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['formresume']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="formresume"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>
                    
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="jobcat">
                            <?php echo JText::_('Jobs By Categories'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'jobcat', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['jobcat']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="jobcat"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="listnewestjobs">
                            <?php echo JText::_('Newest Jobs'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'listnewestjobs', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['listnewestjobs']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="listnewestjobs"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>
                    
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="jobsearch">
                            <?php echo JText::_('Search Jobs'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'jobsearch', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['jobsearch']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="jobsearch"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="listallcompanies">
                            <?php echo JText::_('All Companies'); ?>
                        </label>
                        <div class="jobs-config-value">
                           <?php echo JHTML::_('select.genericList', $showhide, 'listallcompanies', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['listallcompanies']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="listallcompanies"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="listjobbytype">
                            <?php echo JText::_('Job By Types'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                           <?php echo JHTML::_('select.genericList', $showhide, 'listjobbytype', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['listjobbytype']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="listjobbytype"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="myappliedjobs">
                            <?php echo JText::_('My Applied Jobs'); ?>
                        </label>
                        <div class="jobs-config-value">
                           <?php echo JHTML::_('select.genericList', $showhide, 'myappliedjobs', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['myappliedjobs']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="myappliedjobs"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>
                    


                 </div><!-- left closed -->
                    <div id="jsjobs_right_main">
                  <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="mycoverletters">
                            <?php echo JText::_('My Cover Letters'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'mycoverletters', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['mycoverletters']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="mycoverletters"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div> 

                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="formcoverletter">
                            <?php echo JText::_('Add Cover Letter'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'formcoverletter', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['formcoverletter']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="formcoverletter"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>
                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="my_jobsearches">
                            <?php echo JText::_('Job Save Searches'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php  echo JHTML::_('select.genericList', $showhide, 'my_jobsearches', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['my_jobsearches']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="my_jobsearches"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="jspurchasehistory">
                            <?php echo JText::_('Purchase History'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php  echo JHTML::_('select.genericList', $showhide, 'jspurchasehistory', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['jspurchasehistory']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="jspurchasehistory"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="jsmy_stats">
                            <?php echo JText::_('My Stats'); ?>
                        </label>
                        <div class="jobs-config-value">
                           <?php echo JHTML::_('select.genericList', $showhide, 'jsmy_stats', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['jsmy_stats']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="jsmy_stats"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="jobalertsetting">
                            <?php echo JText::_('Job Alert'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'jobalertsetting', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['jobalertsetting']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="jobalertsetting"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="jsmessages">
                            <?php echo JText::_('Messages'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'jsmessages', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['jsmessages']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="jsmessages"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="jsjob_rss">
                            <?php echo JText::_('Jobs RSS'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'jsjob_rss', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['jsjob_rss']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="jsjob_rss"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="jspackages">
                            <?php echo JText::_('Packages'); ?>
                        </label>
                        <div class="jobs-config-value">
                           <?php echo JHTML::_('select.genericList', $showhide, 'jspackages', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['jspackages']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="jspackages"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>
                    
                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="jsexpire_package_message">
                            <?php echo JText::_('Expire Package Message'); ?>
                        </label>
                        <div class="jobs-config-value">
                           <?php echo JHTML::_('select.genericList', $showhide, 'jsexpire_package_message', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['jsexpire_package_message']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="jsexpire_package_message"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="jsregister">
                            <?php echo JText::_('Job Seeker Registration'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'jsregister', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['jsregister']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="jsregister"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="listjobshortlist">
                            <?php echo JText::_('Short Listed Jobs'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'listjobshortlist', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['listjobshortlist']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="listjobshortlist"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>
                    
                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="jobsloginlogout">
                            <?php echo JText::_('Show Login/logout Button'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $yesno, 'jobsloginlogout', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['jobsloginlogout']); ?> 
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="jobsloginlogout"><?php echo JText::_('Show Login/logout Button In Job Seeker Control Panel'); ?></label>     
                        </div>
                    </div>
                  </div><!-- right closed -->

        </div><!-- js member links closed -->
        <div id="js_visitorlinks">
           <div class="headtext"><?php echo JText::_('Job Seeker Top Menu Links'); ?></div>
             <div id="jsjobs_left_main">
                <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="tmenu_vis_jscontrolpanel">
                        <?php echo JText::_('Control Panel'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'tmenu_vis_jscontrolpanel', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['tmenu_vis_jscontrolpanel']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="tmenu_vis_jscontrolpanel"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                 <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="tmenu_vis_jsnewestjob">
                        <?php echo JText::_('Newest Jobs'); ?>
                    </label>
                    <div class="jobs-config-value">
                       <?php echo JHTML::_('select.genericList', $showhide, 'tmenu_vis_jsnewestjob', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['tmenu_vis_jsnewestjob']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="tmenu_vis_jsnewestjob"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

                <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="tmenu_vis_jsjobcategory">
                        <?php echo JText::_('Job Categories'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'tmenu_vis_jsjobcategory', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['tmenu_vis_jsjobcategory']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="tmenu_vis_jsjobcategory"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>

             </div><!-- left closed -->
             
            <div id="jsjobs_right_main">

                 <div id="jsjob_configuration_wrapper">
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="tmenu_vis_jssearchjob">
                        <?php echo JText::_('Search Jobs'); ?>
                    </label>
                    <div class="jobs-config-value">
                       <?php echo JHTML::_('select.genericList', $showhide, 'tmenu_vis_jssearchjob', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['tmenu_vis_jssearchjob']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="tmenu_vis_jssearchjob"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>
                <div id="jsjob_configuration_wrapper" >
                    <label class="jobs-config-title stylelabeltop labelcolortop" for="tmenu_vis_jsmyresume">
                        <?php echo JText::_('My Resumes'); ?>
                    </label>
                    <div class="jobs-config-value">
                        <?php echo JHTML::_('select.genericList', $showhide, 'tmenu_vis_jsmyresume', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['tmenu_vis_jsmyresume']); ?>
                    </div>
                    <div class="jobs-config-descript">
                        <label class=" stylelabelbottom labelcolorbottom" for="tmenu_vis_jsmyresume"><?php echo JText::_(''); ?></label>     
                    </div>
                </div>
            </div><!-- right closed -->
              
              <div class="headtext"><?php echo JText::_('Job Seeker Control Panel Links'); ?></div>
                 <div id="jsjobs_left_main">
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_jsactivejobs_graph">
                            <?php echo JText::_('Active Jobs Graph'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'vis_jsactivejobs_graph', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_jsactivejobs_graph']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="vis_jsactivejobs_graph"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_jsmystuff_area">
                            <?php echo JText::_('My Stuff Area'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'vis_jsmystuff_area', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_jsmystuff_area']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="vis_jsmystuff_area"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_jsnewestjobs_box">
                            <?php echo JText::_('Newest Jobs Box'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'vis_jsnewestjobs_box', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_jsnewestjobs_box']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="vis_jsnewestjobs_box"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_jsappliedresume_box">
                            <?php echo JText::_('Applied Resume Box'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'vis_jsappliedresume_box', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_jsappliedresume_box']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="vis_jsappliedresume_box"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_jsmyresumes">
                            <?php echo JText::_('My Resumes'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'vis_jsmyresumes', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_jsmyresumes']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="vis_jsmyresumes"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_jsformresume">
                            <?php echo JText::_('Add Resume'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'vis_jsformresume', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_jsformresume']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="vis_jsformresume"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>
                    
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_jsjobcat">
                            <?php echo JText::_('Jobs By Categories'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'vis_jsjobcat', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_jsjobcat']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="vis_jsjobcat"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>


                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_jslistnewestjobs">
                            <?php echo JText::_('Newest Jobs'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'vis_jslistnewestjobs', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_jslistnewestjobs']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="vis_jslistnewestjobs"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_jslistallcompanies">
                            <?php echo JText::_('All Companies'); ?>
                        </label>
                        <div class="jobs-config-value">
                           <?php echo JHTML::_('select.genericList', $showhide, 'vis_jslistallcompanies', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_jslistallcompanies']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="vis_jslistallcompanies"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_jslistjobbytype">
                            <?php echo JText::_('Job By Types'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                           <?php echo JHTML::_('select.genericList', $showhide, 'vis_jslistjobbytype', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_jslistjobbytype']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="vis_jslistjobbytype"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

   
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_jsmyappliedjobs">
                            <?php echo JText::_('My Applied Jobs'); ?>
                        </label>
                        <div class="jobs-config-value">
                           <?php echo JHTML::_('select.genericList', $showhide, 'vis_jsmyappliedjobs', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_jsmyappliedjobs']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="vis_jsmyappliedjobs"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_jsmystats_area">
                            <?php echo JText::_('My Stats Area'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'vis_jsmystats_area', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_jsmystats_area']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="vis_jsmystats_area"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                                    
                 </div><!-- left closed -->
                 
                 <div id="jsjobs_right_main">
                 <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_jsjobsearch">
                            <?php echo JText::_('Search Jobs'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'vis_jsjobsearch', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_jsjobsearch']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="vis_jsjobsearch"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div> 
                
                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_jsmy_jobsearches">
                            <?php echo JText::_('Job Save Searches'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'vis_jsmy_jobsearches', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_jsmy_jobsearches']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="vis_jsmy_jobsearches"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>


                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_jsmycoverletters">
                            <?php echo JText::_('My Cover Letters'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'vis_jsmycoverletters', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_jsmycoverletters']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="vis_jsmycoverletters"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div> 

                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_jsformcoverletter">
                            <?php echo JText::_('Add Cover Letter'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'vis_jsformcoverletter', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_jsformcoverletter']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="vis_jsformcoverletter"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_jspurchasehistory">
                            <?php echo JText::_('Purchase History'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'vis_jspurchasehistory', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_jspurchasehistory']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="vis_jspurchasehistory"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_jspackages">
                            <?php echo JText::_('Packages'); ?>
                        </label>
                        <div class="jobs-config-value">
                           <?php echo JHTML::_('select.genericList', $showhide, 'vis_jspackages', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_jspackages']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="vis_jspackages"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>
                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_jsmy_stats">
                            <?php echo JText::_('My Stats'); ?>
                        </label>
                        <div class="jobs-config-value">
                           <?php echo JHTML::_('select.genericList', $showhide, 'vis_jsmy_stats', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_jsmy_stats']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="vis_jsmy_stats"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_jsjobalertsetting">
                            <?php echo JText::_('Job Alert'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'vis_jsjobalertsetting', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_jsjobalertsetting']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="vis_jsjobalertsetting"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_jsmessages">
                            <?php echo JText::_('Messages'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'vis_jsmessages', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_jsmessages']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="vis_jsmessages"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_job_rss">
                            <?php echo JText::_('Jobs RSS'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'vis_job_rss', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_job_rss']);?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="vis_job_rss"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="vis_jsregister">
                            <?php echo JText::_('Register'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $showhide, 'vis_jsregister', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['vis_jsregister']);?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="vis_jsregister"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>
                    

                    <div id="jsjob_configuration_wrapper" >
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="jobsloginlogout">
                            <?php echo JText::_('Show Login/logout Button'); ?>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $yesno, 'jobsloginlogout', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['jobsloginlogout']); ?> 
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="jobsloginlogout"><?php echo JText::_('Show Login/logout Button In Job Seeker Control Panel'); ?></label>     
                        </div>
                    </div>
                  </div><!-- right closed -->
                
            </div><!-- js visitor closed -->


        <div id="js_visitor">
            <div class="headtext"><?php echo JText::_('Job Seeker'); ?></div>
                 <div id="jsjobs_left_main">
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="visitor_can_apply_to_job">
                            <?php echo JText::_('Visitor Can Apply To Job'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $yesno, 'visitor_can_apply_to_job', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitor_can_apply_to_job']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="visitor_can_apply_to_job"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="visitor_can_add_resume">
                            <?php echo JText::_('Visitor Can Add New Resume'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $yesno, 'visitor_can_add_resume', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitor_can_add_resume']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="visitor_can_add_resume"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>

                     <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="overwrite_jobalert_settings">
                                <?php echo JText::_('Job Alert For Visitor'); ?><span class="pro_version">*</span>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $yesno, 'overwrite_jobalert_settings', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['overwrite_jobalert_settings']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="overwrite_jobalert_settings"><?php echo JText::_(''); ?></label>     
                            </div>
                    </div>

                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="visitor_show_login_message">
                            <?php echo JText::_('Show Login Message To Visitor'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                           <?php echo JHTML::_('select.genericList', $yesno, 'visitor_show_login_message', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitor_show_login_message']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="visitor_show_login_message"><?php echo JText::_(''); ?></label>     
                        </div>
                    </div>
                </div><!-- left closed -->
                 
                 <div id="jsjobs_right_main">
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="resume_captcha">
                            <?php echo JText::_('Resume Captcha'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                           <?php echo JHTML::_('select.genericList', $yesno, 'resume_captcha', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['resume_captcha']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="resume_captcha"><?php echo JText::_('Show captcha on visitor form resume'); ?></label>     
                        </div>
                    </div>

                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="job_alert_captcha">
                            <?php echo JText::_('Job Alert Captcha'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                           <?php echo JHTML::_('select.genericList', $yesno, 'job_alert_captcha', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['job_alert_captcha']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="job_alert_captcha"><?php echo JText::_('Show captcha visitor job alert form'); ?></label>     
                        </div>
                    </div>
                </div><!-- right closed -->
                <div class="headtext"><?php echo JText::_('Visitors Can View Job Seeker'); ?></div>
                     <div id="jsjobs_left_main">
                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="visitorview_js_controlpanel">
                                <?php echo JText::_('Control Panel'); ?>
                            </label>
                            <div class="jobs-config-value">
                               <?php echo JHTML::_('select.genericList', $showhide, 'visitorview_js_controlpanel', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitorview_js_controlpanel']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="visitorview_js_controlpanel"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>
                        <?php /*
                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="visitorview_js_packages">
                                <?php echo JText::_('Packages'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $showhide, 'visitorview_js_packages', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitorview_js_packages']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="visitorview_js_packages"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="visitorview_js_jobcat">
                                <?php echo JText::_('Job Categories'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $showhide, 'visitorview_js_jobcat', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitorview_js_jobcat']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="visitorview_js_jobcat"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="visitorview_js_viewpackage">
                                <?php echo JText::_('Package Detail'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $showhide, 'visitorview_js_viewpackage', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitorview_js_viewpackage']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="visitorview_js_viewpackage"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>   */  ?>

                        <div id="jsjob_configuration_wrapper">
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="visitorview_js_jobsearch">
                                <?php echo JText::_('Job Search'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $showhide, 'visitorview_js_jobsearch', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitorview_js_jobsearch']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="visitorview_js_jobsearch"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>
                     </div><!-- left closed -->
                     
                    <div id="jsjobs_right_main">
                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="visitorview_emp_viewcompany">
                                <?php echo JText::_('View Company'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $showhide, 'visitorview_emp_viewcompany', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitorview_emp_viewcompany']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="vis_empackages"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>
                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="visitorview_emp_viewjob">
                                <?php echo JText::_('View Job'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $showhide, 'visitorview_emp_viewjob', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitorview_emp_viewjob']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="visitorview_emp_viewjob"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>
                        <?php /*
                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="visitorview_js_newestjobs">
                                <?php echo JText::_('Newest Jobs'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $showhide, 'visitorview_js_newestjobs', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitorview_js_newestjobs']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="visitorview_js_newestjobs"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="visitorview_js_listjob">
                                <?php echo JText::_('List Jobs'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $showhide, 'visitorview_js_listjob', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitorview_js_listjob']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="visitorview_js_listjob"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>

                        <div id="jsjob_configuration_wrapper" >
                            <label class="jobs-config-title stylelabeltop labelcolortop" for="visitorview_js_jobsearchresult">
                                <?php echo JText::_('Job Search Results'); ?>
                            </label>
                            <div class="jobs-config-value">
                                <?php echo JHTML::_('select.genericList', $showhide, 'visitorview_js_jobsearchresult', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitorview_js_jobsearchresult']); ?>
                            </div>
                            <div class="jobs-config-descript">
                                <label class=" stylelabelbottom labelcolorbottom" for="visitorview_js_jobsearchresult"><?php echo JText::_(''); ?></label>     
                            </div>
                        </div>
                           
                           */ ?>
                          
                      </div><!-- right closed -->

        </div><!-- js visitor closed -->
        <div id="email">
            <div class="headtext"><?php echo JText::_('Applied Resume Alert'); ?></div>
                 <div id="jsjobs_left_main">
                    <div id="jsjob_configuration_wrapper">
                        <label class="jobs-config-title stylelabeltop labelcolortop" for="jobseeker_resume_applied_status">
                            <?php echo JText::_('Applied Resume Status'); ?><span class="pro_version">*</span>
                        </label>
                        <div class="jobs-config-value">
                            <?php echo JHTML::_('select.genericList', $yesno, 'jobseeker_resume_applied_status', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['jobseeker_resume_applied_status']); ?>
                        </div>
                        <div class="jobs-config-descript">
                            <label class=" stylelabelbottom labelcolorbottom" for="jobseeker_resume_applied_status"><?php echo JText::_('Applied Resume Status Update Mail Send To Job Seeker'); ?></label>     
                        </div>
                    </div>
              
                 </div><!-- left closed -->
                 
             </div><!-- js email closed -->
    </div><!-- wrapper closed -->
    <input type="hidden" name="layout" value="configurationsjobseeker" />
    <input type="hidden" name="task" value="configuration.saveconf" />
    <input type="hidden" name="notgeneralbuttonsubmit" value="1" />
    <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
        <?php echo JHTML::_( 'form.token' ); ?>        
    </form>
    </div><!-- jsjobs content -->
</div><!-- jsjobs wrapper -->
<div class="proversiononly"><span class="pro_version">*</span><?php echo JText::_('Pro version only');?></div>
<div id="bottomend"></div>
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









