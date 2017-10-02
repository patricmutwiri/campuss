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

global $mainframe;
$document->addStyleSheet('../components/com_jsjobs/css/token-input-jsjobs.css');

if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('../components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}
$document->addScript('../components/com_jsjobs/js/jquery.tokeninput.js');
$document->addScript('components/com_jsjobs/include/js/jquery_idTabs.js');
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

$date_format = array(
    '0' => array('value' => 'd-m-Y', 'text' => JText::_('dd-mm-yyyy')),
    '1' => array('value' => 'm/d/Y', 'text' => JText::_('mm-dd-yyyy')),
    '2' => array('value' => 'Y-m-d', 'text' => JText::_('yyyy-mm-dd')),);

$leftright = array(
    '0' => array('value' => 1,
        'text' => JText::_('Left Align')),
    '1' => array('value' => 2,
        'text' => JText::_('Right Align')),);

$yesno = array(
    '0' => array('value' => 1,
        'text' => JText::_('Yes')),
    '1' => array('value' => 0,
        'text' => JText::_('No')),);

$yesnobackup = array(
    '0' => array('value' => 1,
        'text' => JText::_('Yes Recommended')),
    '1' => array('value' => 0,
        'text' => JText::_('No')),);

$captchalist = array(
    '0' => array('value' => 1,
        'text' => JText::_('JS Jobs Captcha')),
    '1' => array('value' => 0,
        'text' => JText::_('Joomla Recaptcha')),);

$showhide = array(
    '0' => array('value' => 1,
        'text' => JText::_('Show')),
    '1' => array('value' => 0,
        'text' => JText::_('Hide')),);
$defaultradius = array(
    '0' => array('value' => 1, 'text' => JText::_('Meters')),
    '1' => array('value' => 2, 'text' => JText::_('Kilometers')),
    '2' => array('value' => 3, 'text' => JText::_('Miles')),
    '3' => array('value' => 4, 'text' => JText::_('Nautical Miles')),
);

$paymentmethodsarray = array(
    '0' => array('value' => 'paypal', 'text' => JText::_('Paypal')),
    '1' => array('value' => 'fastspring', 'text' => JText::_('Fastspring')),
    '2' => array('value' => 'authorizenet', 'text' => JText::_('Authorize,net')),
    '3' => array('value' => '2checkout', 'text' => JText::_('2checkout')),
    '4' => array('value' => 'Pagseguro', 'text' => JText::_('Pagseguro')),
    '5' => array('value' => 'other', 'text' => JText::_('Other')),
    '6' => array('value' => 'no', 'text' => JText::_('Not Use')),);

$defaultaddressdisplaytype = array(
    '0' => array('value' => 'csc', 'text' => JText::_('City, State, Country')),
    '1' => array('value' => 'cs', 'text' => JText::_('City, State')),
    '2' => array('value' => 'cc', 'text' => JText::_('City, Country')),
    '3' => array('value' => 'c', 'text' => JText::_('City')),
);
$searchjobtag = array(
    '0' => array('value' => 1, 'text' => JText::_('Top left')),
    '1' => array('value' => 2, 'text' => JText::_('Top right')), 
    '2' => array('value' => 3, 'text' => JText::_('middle left')), 
    '3' => array('value' => 4, 'text' => JText::_('middle right')), 
    '4' => array('value' => 5, 'text' => JText::_('bottom left')), 
    '5' => array('value' => 6, 'text' => JText::_('bottom right')),
    '6' => array('value' => 7, 'text' => JText::_('None'))
);

$captcha = JHTML::_('select.genericList', $captchalist, 'captchause', 'class="inputbox" ' . '', 'value', 'text', $this->config['captchause']);

$date_format = JHTML::_('select.genericList', $date_format, 'date_format', 'class="inputbox" ' . '', 'value', 'text', $this->config['date_format']);


//rss

$big_field_width = 40;
$med_field_width = 25;
$sml_field_width = 15;
?>

<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div> 
      <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=controlpanel"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Configurations'); ?></span></div>
        <form action="index.php" method="POST" name="adminForm" id="adminForm" >
            <input type="hidden" name="check" value="post"/>
                <div id="tabs_wrapper" class="tabs_wrapper">
                  <div class="idTabs">
                    <a class="selected" href="#site_setting"><?php echo JText::_('Site Settings'); ?></a> 
                    <a  class="linktabclass" href="#listjobs"><?php echo JText::_('List Job'); ?></a>
                    <a  class="linktabclass" href="#listjoboption"><?php echo JText::_('Job Options'); ?></a>
                    <a  class="linktabclass" href="#package"><?php echo JText::_('Package'); ?></a>
                    <!--<a  href="#payment"><?php echo JText::_('Payment'); ?></a> -->
                    <a  class="linktabclass" href="#email"><?php echo JText::_('Email'); ?></a> 
                    <a  class="linktabclass" href="#userregistration"><?php echo JText::_('User Registration'); ?></a>
                    <a  class="linktabclass" href="#socialsharing"><?php echo JText::_('Job Social Sharing'); ?></a> 
                    <a  class="linktabclass" href="#rss_job_set"><?php echo JText::_('RSS Job Setting'); ?></a>
                    <a  class="linktabclass" href="#rss_resume_set"><?php echo JText::_('RSS Resume Setting'); ?></a>
                    <a  class="linktabclass" href="#googlemapadsense"><?php echo JText::_('Google Map And Adsense'); ?></a>
                    <?php if ($this->isjobsharing) { ?> 
                    <a  class="linktabclass" href="#jobsharing"><?php echo JText::_('Job Sharing'); ?></a>
                    <?php } ?>  
                  </div>
      
 <div id="site_setting">
 <div class="headtext"><?php echo JText::_('Site Settings'); ?></div>
 <div id="jsjobs_left_main">
    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="title">
            <?php echo JText::_('Title'); ?>
        </label>
        <div class="jobs-config-value">
            <input type="text" id="title" name="title" value="<?php echo $this->config['title']; ?>" class="inputfieldsizeful inputbox required" maxlength="255" size="<?php echo $med_field_width; ?>"  />
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom"><?php echo JText::_(''); ?></label>     
        </div>
    </div>
    
    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="offline">
            <?php echo JText::_('Offline'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $yesno, 'offline', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['offline']); ?>
            <textarea name="offline_text" id="offline_text" cols="25" rows="3" class="textareabox inputbox"><?php echo $this->config['offline_text']; ?></textarea> 
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom"><?php echo JText::_(''); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="data_directory">
            <?php echo JText::_('Data Directory'); ?>
        </label>
        <div class="jobs-config-value">
            <input type="text" name="data_directory" id="data_directory" value="<?php echo $this->config['data_directory']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $med_field_width; ?>"/>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom"><?php echo JText::_('System will upload all user files in this folder'); echo " (".JPATH_SITE.'/'.$this->config['data_directory'].")";?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="cur_location">
            <?php echo JText::_('Show Breadcrumbs'); ?>
        </label>
        <div class="jobs-config-value">
             <?php echo JHTML::_('select.genericList', $yesno, 'cur_location', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['cur_location']); ?>
        </div>
        <div class="jobs-config-descript" >
            <label class=" stylelabelbottom labelcolorbottom" for="cur_location"><?php echo JText::_('Show navigation in template breadcrumbs'); ?></label>     
        </div>
    </div>
    
    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="date_format">
            <?php echo JText::_('Default Date Format'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo $date_format; ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="date_format"><?php echo JText::_('Date format which is used in whole application'); ?>.</label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="defaultaddressdisplaytype">
            <?php echo JText::_('Default Address Display Style'); ?>
        </label>
        <div class="jobs-config-value">
           <?php echo JHTML::_('select.genericList', $defaultaddressdisplaytype, 'defaultaddressdisplaytype', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['defaultaddressdisplaytype']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="defaultaddressdisplaytype"><?php echo JText::_(''); ?></label>     
        </div>
    </div>


    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="employer_defaultgroup">
            <?php echo JText::_('Employer Default Group'); ?>
        </label>
        <div class="jobs-config-value">
           <?php echo $this->lists['employer_group']; ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="employer_defaultgroup"><?php echo JText::_('This group will auto assign to new employer'); ?></label>     
        </div>
    </div>


    
    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="jobseeker_defaultgroup">
            <?php echo JText::_('Job Seeker Default Group'); ?>
        </label>
        <div class="jobs-config-value">
           <?php echo $this->lists['jobseeker_group']; ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="jobseeker_defaultgroup">
            <?php echo JText::_('This group will auto assign to new job seeker'); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="captchause">
            <?php echo JText::_('Set Default Captcha'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
           <?php echo $captcha; ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="captchause"><?php echo JText::_('Select captcha for application'); ?>.</label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="message_auto_approve">
            <?php echo JText::_('Message Auto Approve'); ?> <span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $yesno, 'message_auto_approve', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['message_auto_approve']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="message_auto_approve"><?php echo JText::_('Auto approve messages for job seeker and employer'); ?></label>     
        </div>
    </div> 

    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="conflict_message_auto_approve">
            <?php echo JText::_('Conflict Message Auto Approve'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $yesno, 'conflict_message_auto_approve', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['conflict_message_auto_approve']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="conflict_message_auto_approve"><?php echo JText::_('Auto approve conflicted messages for job seeker and employer'); ?>.</label>     
        </div>
    </div>


 
 </div><!-- left closed -->
 
 
    <div id="jsjobs_right_main">
    

    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="number_of_cities_for_autocomplete">
            <?php echo JText::_('Maximum record for city field'); ?>
        </label>
        <div class="jobs-config-value">
           <input type="text" name="number_of_cities_for_autocomplete" id="number_of_cities_for_autocomplete" value="<?php echo $this->config['number_of_cities_for_autocomplete']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $med_field_width; ?>" maxlength="255" />
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="number_of_cities_for_autocomplete"><?php echo JText::_('Set number of cities to show in result of the location input box'); ?>.</label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="newtyped_cities">
            <?php echo JText::_('User can add cities in database'); ?>
        </label>
        <div class="jobs-config-value">
           <?php echo JHTML::_('select.genericList', $yesno, 'newtyped_cities', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['newtyped_cities']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="newtyped_cities"><?php echo JText::_('User can add new city in the system'); ?></label>     
        </div>
    </div>    

    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="document_file_type">
            <?php echo JText::_('Document File Extensions'); ?>
        </label>
        <div class="jobs-config-value">
           <input type="text" name="document_file_type" id="document_file_type" value="<?php echo $this->config['document_file_type']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $med_field_width; ?>" maxlength="255" />
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="document_file_type"><?php echo JText::_('Add document allowed extensions'); ?>. <?php echo JText::_('Must be comma seperated'); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="image_file_type">
            <?php echo JText::_('Image File Extensions'); ?>
        </label>
        <div class="jobs-config-value">
           <input type="text" name="image_file_type" id="image_file_type" value="<?php echo $this->config['image_file_type']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $med_field_width; ?>" maxlength="255" />
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="image_file_type"><?php echo JText::_('Add image allowed extensions'); ?>. <?php echo JText::_('Must be comma seperated'); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="company_logofilezize">
            <?php echo JText::_('Company Logo Maximum Size'); ?>
        </label>
        <div class="jobs-config-value">
            <input type="text" name="company_logofilezize" id="company_logofilezize" value="<?php echo $this->config['company_logofilezize']; ?>" class="inputfieldsize inputbox validate-numeric" maxlength="6" size="<?php echo $med_field_width; ?>" /><label class="jobs-mini-descp" for="company_logofilezize"><?php echo JText::_('Kb'); ?></label>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="company_logofilezize"><?php echo JText::_('System will not upload if company logo size exceed to given size'); ?></label>     
        </div>
    </div>


    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="document_max_files">
            <?php echo JText::_('Number of Files For Resume'); ?>
        </label>
        <div class="jobs-config-value">
           <input type="text" name="document_max_files" id="document_max_files" value="<?php echo $this->config['document_max_files']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $med_field_width; ?>" maxlength="255" />
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="document_max_files"><?php echo JText::_('Maximum number of files that job seeker can upload in resume'); ?></label>     
        </div>
    </div>    


    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="document_file_size">
            <?php echo JText::_('Resume').' / '.JText::_('Userfield').' :  '.JText::_('File Maximum Size'); ?>
        </label>
        <div class="jobs-config-value">
           <input type="text" name="document_file_size" id="document_file_size" value="<?php echo $this->config['document_file_size']; ?>" class="inputfieldsize inputbox validate-numeric" maxlength="6" size="<?php echo $med_field_width; ?>" /><label class="jobs-mini-descp" for="document_file_size"><?php echo JText::_('Kb'); ?></label>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="document_file_size"><?php echo JText::_('System will not upload if resume file size exceed to given size'); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="currency_align">
            <?php echo JText::_('Currency Symbol Position'); ?>
        </label>
        <div class="jobs-config-value">
           <?php echo JHTML::_('select.genericList', $leftright, 'currency_align', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['currency_align']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="currency_align"><?php echo JText::_('Show currency symbol left or right to the amount'); ?></label>     
        </div>
    </div>  

    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="categories_colsperrow">
            <?php echo JText::_('Categories Columns Per Row'); ?>
        </label>
        <div class="jobs-config-value">
            <input type="text" id="categories_colsperrow" name="categories_colsperrow" value="<?php echo $this->config['categories_colsperrow']; ?>" class="inputfieldsizeful inputbox validate-numeric" maxlength="6" size="<?php echo $med_field_width; ?>" />
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="categories_colsperrow"><?php echo JText::_('Show number of categories in one row in jobs and resume');?>.</label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="captchause">
            <?php echo JText::_('Sub Categories Limit'); ?>
        </label>
        <div class="jobs-config-value">
           <input type="text" name="subcategory_limit" id="subcategory_limit" value="<?php echo $this->config['subcategory_limit']; ?>" class="inputbox validate-numeric inputfieldsize" maxlength="6" size="<?php echo $med_field_width; ?>" maxlength="5" />
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="captchause"><?php echo JText::_('How many sub categories show in popup at category layout'); ?>.</label>
        </div>
    </div>
<div id="jsjob_configuration_wrapper">
    <label class="jobs-config-title stylelabeltop labelcolortop" for="newdays">
        <?php echo JText::_('Mark Job New'); ?>
    </label>
    <div class="jobs-config-value">
        <input type="text" name="newdays" id="newdays" value="<?php echo $this->config['newdays']; ?>" class="inputbox validate-numeric inputfieldsize" maxlength="6" size="<?php echo $med_field_width; ?>" maxlength="5" /><label class="jobs-mini-descp" for="newdays"><?php echo JText::_('Days'); ?></label>
    </div>
    <div class="jobs-config-descript">
        <label class="stylelabelbottom labelcolorbottom" for="newdays"><?php echo JText::_('How many days system show New tag'); ?>.</label>     
    </div>
</div>




    </div><!-- right closed -->
</div><!-- site setting closed -->

    <div id="listjobs">
    <div class="headtext"><?php echo JText::_('Job Listing Settings'); ?></div>
 <div id="jsjobs_left_main">
    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="showgoldjobsinnewestjobs">
            <?php echo JText::_('Show Gold Jobs'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $yesno, 'showgoldjobsinnewestjobs', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['showgoldjobsinnewestjobs']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="showgoldjobsinnewestjobs"><?php echo JText::_('Show gold jobs in jobs lising page'); ?></label>     
        </div>
    </div>
    
    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="showfeaturedjobsinnewestjobs">
            <?php echo JText::_('Show Featured Jobs'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $yesno, 'showfeaturedjobsinnewestjobs', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['showfeaturedjobsinnewestjobs']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="showfeaturedjobsinnewestjobs"><?php echo JText::_('Show featured jobs in jobs lising page'); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="noofgoldjobsinlisting">
            <?php echo JText::_('Number Of Gold Jobs'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
             <input type="text" name="noofgoldjobsinlisting" id="noofgoldjobsinlisting" value="<?php echo $this->config['noofgoldjobsinlisting']; ?>" class="inputfieldsizeful inputbox validate-numeric" maxlength="6" size="<?php echo $med_field_width; ?>" />
        </div>
        <div class="jobs-config-descript" >
            <label class=" stylelabelbottom labelcolorbottom" for="noofgoldjobsinlisting"><?php echo JText::_('How many gold job show per page scroll'); ?>.</label>     
        </div>
    </div>

 </div><!-- left closed -->
 
 <div id="jsjobs_right_main">

     
    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="nooffeaturedjobsinlisting">
            <?php echo JText::_('Number Of Featured Jobs'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <input type="text" name="nooffeaturedjobsinlisting" id="nooffeaturedjobsinlisting" value="<?php echo $this->config['nooffeaturedjobsinlisting']; ?>" class="inputfieldsizeful inputbox validate-numeric" maxlength="6" size="<?php echo $med_field_width; ?>" />
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="nooffeaturedjobsinlisting"><?php echo JText::_('How many featured job show per page scroll'); ?>.</label>     
        </div>
    </div>


    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="searchjobtag">
            <?php echo JText::_(' Refine Search Tag Position'); ?>
        </label>
        <div class="jobs-config-value">
             <?php echo JHTML::_('select.genericList', $searchjobtag, 'searchjobtag', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['searchjobtag']); ?>
        </div>
        <div class="jobs-config-descript" >
            <label class=" stylelabelbottom labelcolorbottom" for="searchjobtag"><?php echo JText::_('Position of refine search tag'); ?>.</label>     
        </div>
    </div>
   
    </div><!-- right closed -->
</div><!-- list job closed -->



<div id="listjoboption">
 <div class="headtext"><?php echo JText::_('Job Labels'); ?></div>
<div id="jsjobs_left_main">
     <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="labelinlisting">
            <?php echo JText::_('Show Label In Jobs Listing'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $yesno, 'labelinlisting', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['labelinlisting']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="labelinlisting"><?php echo JText::_('Show labels in jobs listings, my jobs etc'); ?></label>     
        </div>
    </div>
</div>
<?php /*
 <div class="headtext"><?php echo JText::_('Members').' (' . JText::_('Field settings for login users') . ')'; ?></div>
    <div id="jsjobs_left_main">
    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="lj_title">
            <?php echo JText::_('Job Title'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $showhide, 'lj_title', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['lj_title']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="lj_title"><?php echo JText::_(''); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="lj_jobtype">
            <?php echo JText::_('Job Type'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $showhide, 'lj_jobtype', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['lj_jobtype']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="lj_jobtype"><?php echo JText::_(''); ?></label>     
        </div>
    </div>
    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="lj_jobstatus">
            <?php echo JText::_('Job Status'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $showhide, 'lj_jobstatus', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['lj_jobstatus']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="lj_jobstatus"><?php echo JText::_(''); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="lj_company">
            <?php echo JText::_('Company'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $showhide, 'lj_company', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['lj_company']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="lj_company"><?php echo JText::_(''); ?></label>     
        </div>
    </div>
 
    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="lj_companysite">
            <?php echo JText::_('Company Website'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $showhide, 'lj_companysite', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['lj_companysite']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="lj_companysite"><?php echo JText::_(''); ?></label>     
        </div>
    </div>
 
 </div><!-- left closed -->
 <div id="jsjobs_right_main">
    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="lj_country">
            <?php echo JText::_('Country'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $showhide, 'lj_country', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['lj_country']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="lj_country"><?php echo JText::_(''); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="lj_state">
            <?php echo JText::_('State'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $showhide, 'lj_state', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['lj_state']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="lj_state"><?php echo JText::_(''); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="lj_city">
            <?php echo JText::_('City'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $showhide, 'lj_city', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['lj_city']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="lj_city"><?php echo JText::_(''); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="lj_category">
            <?php echo JText::_('Category'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $showhide, 'lj_category', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['lj_category']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="lj_category"><?php echo JText::_(''); ?></label>     
        </div>
    </div>

   <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="lj_created">
            <?php echo JText::_('Created'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $showhide, 'lj_created', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['lj_created']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="lj_created"><?php echo JText::_(''); ?></label>     
        </div>
    </div>
    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="lj_salary">
            <?php echo JText::_('Salary'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $showhide, 'lj_salary', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['lj_salary']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="lj_salary"><?php echo JText::_(''); ?></label>     
        </div>
    </div>
    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="lj_noofjobs">
            <?php echo JText::_('Number Of Jobs'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $showhide, 'lj_noofjobs', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['lj_noofjobs']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="lj_noofjobs"><?php echo JText::_(''); ?></label>     
        </div>
    </div>
    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="lj_description">
            <?php echo JText::_('Description'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $showhide, 'lj_description', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['lj_description']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="lj_description"><?php echo JText::_(''); ?></label>     
        </div>
    </div>
    

  </div><!-- right closed -->

 <div class="headtext"><?php echo JText::_('Visitors').' (' . JText::_('Field settings for visitors') . ')';?></div>
    <div id="jsjobs_left_main">
    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="visitor_lj_title">
            <?php echo JText::_('Job Title'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $showhide, 'visitor_lj_title', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitor_lj_title']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="visitor_lj_title"><?php echo JText::_(''); ?></label>     
        </div>
    </div>
    
    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="visitor_lj_jobtype">
            <?php echo JText::_('Job Type'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $showhide, 'visitor_lj_jobtype', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitor_lj_jobtype']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="visitor_lj_jobtype"><?php echo JText::_(''); ?></label>     
        </div>
    </div>
    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="visitor_lj_jobstatus">
            <?php echo JText::_('Job Status'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $showhide, 'visitor_lj_jobstatus', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitor_lj_jobstatus']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="visitor_lj_jobstatus"><?php echo JText::_(''); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="visitor_lj_company">
            <?php echo JText::_('Company'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $showhide, 'visitor_lj_company', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitor_lj_company']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="visitor_lj_company"><?php echo JText::_(''); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="visitor_lj_companysite">
            <?php echo JText::_('Company Website'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $showhide, 'visitor_lj_companysite', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitor_lj_companysite']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="visitor_lj_companysite"><?php echo JText::_(''); ?></label>     
        </div>
    </div>

</div><!-- left closed -->
 <div id="jsjobs_right_main">
 
<?php /*
    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="visitor_lj_country">
            <?php echo JText::_('Country'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $showhide, 'visitor_lj_country', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitor_lj_country']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="visitor_lj_country"><?php echo JText::_(''); ?></label>     
        </div>
    </div>
    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="visitor_lj_state">
            <?php echo JText::_('State'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $showhide, 'visitor_lj_state', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitor_lj_state']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="visitor_lj_state"><?php echo JText::_(''); ?></label>     
        </div>
    </div>
    
    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="visitor_lj_city">
            <?php echo JText::_('City'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $showhide, 'visitor_lj_city', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitor_lj_city']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="visitor_lj_city"><?php echo JText::_(''); ?></label>     
        </div>
    </div>
    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="visitor_lj_category">
            <?php echo JText::_('Category'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $showhide, 'visitor_lj_category', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitor_lj_category']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="visitor_lj_category"><?php echo JText::_(''); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="visitor_lj_created">
            <?php echo JText::_('Created'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $showhide, 'visitor_lj_created', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitor_lj_created']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="visitor_lj_created"><?php echo JText::_(''); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="visitor_lj_salary">
            <?php echo JText::_('Salary'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $showhide, 'visitor_lj_salary', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitor_lj_salary']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="visitor_lj_salary"><?php echo JText::_(''); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="visitor_lj_description">
            <?php echo JText::_('Description'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $showhide, 'visitor_lj_description', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitor_lj_description']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="visitor_lj_description"><?php echo JText::_(''); ?></label>     
        </div>
    </div>
    

    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="visitor_lj_noofjobs">
            <?php echo JText::_('Number Of Jobs'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $showhide, 'visitor_lj_noofjobs', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['visitor_lj_noofjobs']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="visitor_lj_noofjobs"><?php echo JText::_(''); ?></label>     
        </div>
    </div>
    
   
  </div><!-- right closed -->
   */ ?>
</div> <!-- List job option closed -->


<div id="package">
   <div class="headtext"><?php echo JText::_('Package Settings'); ?></div>
  <div id="jsjobs_left_main">
    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="employer_defaultpackage">
            <?php echo JText::_('Auto Assign Package To Employer'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo $this->lists['employer_defaultpackage']; ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="employer_defaultpackage"><?php echo JText::_('Auto assign package to').' '; ?>&nbsp;<b class="defaultmycolorclass"><?php echo JText::_('New Employer'); ?></b></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="jobseeker_defaultpackage">
            <?php echo JText::_('Auto Assign Package To Job Seeker'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo $this->lists['jobseeker_defaultpackage']; ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="jobseeker_defaultpackage"><?php echo JText::_('Auto assign package to').' '; ?>&nbsp;<b class="defaultmycolorclass"><?php echo JText::_('New Job Seeker'); ?></b></label>
        </div>
    </div>

    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="onlyonce_employer_getfreepackage">
            <?php echo JText::_('Employer Get Free Package Once'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $yesno, 'onlyonce_employer_getfreepackage', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['onlyonce_employer_getfreepackage']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="onlyonce_employer_getfreepackage"><?php echo JText::_('Limit free package').'. '.JText::_('Employer get free package only once'); ?></label>     
        </div>
    </div>
 
 </div><!-- left closed -->
 
 <div id="jsjobs_right_main">
    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="onlyonce_jobseeker_getfreepackage">
            <?php echo JText::_('Job Seeker Get Free Package Once'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $yesno, 'onlyonce_jobseeker_getfreepackage', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['onlyonce_jobseeker_getfreepackage']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="onlyonce_jobseeker_getfreepackage"><?php echo JText::_('Limit free package').'. '.JText::_('Job seeker get free package only once'); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="employer_freepackage_autoapprove">
            <?php echo JText::_('Employer Free Package Auto Approve'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $yesno, 'employer_freepackage_autoapprove', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['employer_freepackage_autoapprove']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="employer_freepackage_autoapprove"><?php echo JText::_(''); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="jobseeker_freepackage_autoapprove">
            <?php echo JText::_('Job Seeker Free Package Auto Approve'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $yesno, 'jobseeker_freepackage_autoapprove', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['jobseeker_freepackage_autoapprove']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="jobseeker_freepackage_autoapprove"><?php echo JText::_(''); ?></label>     
        </div>
    </div>

   
  </div><!-- right closed -->
</div><!-- package closed -->

<div id="email">
   <div class="headtext"><?php echo JText::_('Email Settings'); ?></div>
  <div id="jsjobs_left_main">
    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="mailfromaddress">
            <?php echo JText::_('Sender email address'); ?>
        </label>
        <div class="jobs-config-value">
            <input type="text" name="mailfromaddress" id="mailfromaddress" value="<?php echo $this->config['mailfromaddress']; ?>" class="inputfieldsizeful inputbox validate-email" size="<?php echo $big_field_width; ?>"/>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="mailfromaddress"><?php echo JText::_('Email address that will be used to send emails'); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="mailfromname">
            <?php echo JText::_('Sender Name'); ?>
        </label>
        <div class="jobs-config-value">
            <input type="text" name="mailfromname" id="mailfromname" value="<?php echo $this->config['mailfromname']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $med_field_width; ?>" />
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="mailfromname"><?php echo JText::_('Sender name that will be used in emails'); ?></label>     
        </div>
    </div>
 </div><!-- left closed -->
 <div id="jsjobs_right_main">
    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="adminemailaddress">
            <?php echo JText::_('Admin E-mail Address'); ?>
        </label>
        <div class="jobs-config-value">
            <input type="text" name="adminemailaddress" id="adminemailaddress" value="<?php echo $this->config['adminemailaddress']; ?>" class="inputfieldsizeful inputbox validate-email" size="<?php echo $med_field_width; ?>" />
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="adminemailaddress"><?php echo JText::_('Admin will receive email notifications on this address'); ?></label>     
        </div>
    </div>
  </div><!-- right closed -->
</div><!-- email closed -->

<div id="userregistration">
<div class="headtext"><?php echo JText::_('User Registration'); ?></div>
 <div id="jsjobs_left_main">
    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="user_registration_captcha">
            <?php echo JText::_('Show Captcha On Registration Form'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $yesno, 'user_registration_captcha', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['user_registration_captcha']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="user_registration_captcha"><?php echo JText::_('Show captcha on JS Jobs registration form'); ?>.</label>     
        </div>
    </div>
 
 </div><!-- left closed -->
 
</div> <!-- user registration closed -->

<div id="socialsharing">
   <div class="headtext"><?php echo JText::_('Social Links'); ?></div>
    <div class="socialconfig_block">
        <div class="socialconfig_content" >
        <input type="checkbox" value="1" name="jobseeker_share_fb_like" id="jobseeker_share_fb_like" <?php
        if ($this->config['jobseeker_share_fb_like'] == 1)
               echo 'checked="true"';
        else
               'checked="false"';
        ?> /><label class="socialconfig_label" for="jobseeker_share_fb_like"><?php echo JText::_('Facebook Likes'); ?><span class="pro_version">*</span></label>
        </div>
        
        <div class="socialconfig_content" >
        <input type="checkbox" value="1" name="jobseeker_share_fb_comments" id="jobseeker_share_fb_comments" <?php
        if ($this->config['jobseeker_share_fb_comments'] == 1)
            echo 'checked="true"';
        else
            'checked="false"';
        ?> /><label class="socialconfig_label" for="jobseeker_share_fb_comments"><?php echo JText::_('Facebook Comments'); ?><span class="pro_version">*</span></label>
        </div>
       
        <div class="socialconfig_content" >
        <input type="checkbox" value="1" name="jobseeker_share_fb_share" id="jobseeker_share_fb_share" <?php
        if ($this->config['jobseeker_share_fb_share'] == 1)
               echo 'checked="true"';
        else
               'checked="false"';
           ?> /><label class="socialconfig_label" for="jobseeker_share_fb_share"><?php echo JText::_('Facebook Share'); ?><span class="pro_version">*</span></label>
        </div>

        <div class="socialconfig_content" >
        <input type="checkbox" value="1" name="jobseeker_share_google_like" id="jobseeker_share_google_like" <?php
        if ($this->config['jobseeker_share_google_like'] == 1)
            echo 'checked="true"';
        else
            'checked="false"';
        ?> /><label class="socialconfig_label" for="jobseeker_share_google_like"><?php echo JText::_('Google Likes'); ?><span class="pro_version">*</span></label>
        </div>
        
        <div class="socialconfig_content" >
        <input type="checkbox" value="1" name="jobseeker_share_blog_share" id="jobseeker_share_blog_share" <?php
        if ($this->config['jobseeker_share_blog_share'] == 1)
            echo 'checked="true"';
        else
            'checked="false"';
        ?> /><label class="socialconfig_label" for="jobseeker_share_blog_share"><?php echo JText::_('Blogger'); ?><span class="pro_version">*</span></label>
        </div>
       
        <div class="socialconfig_content" >
        <input type="checkbox" value="1" name="jobseeker_share_google_share" id="jobseeker_share_google_share" <?php
           if ($this->config['jobseeker_share_google_share'] == 1)
               echo 'checked="true"';
           else
               'checked="false"';
           ?> /><label class="socialconfig_label" for="jobseeker_share_google_share"><?php echo JText::_('Google Share'); ?><span class="pro_version">*</span></label>
        </div>

        <div class="socialconfig_content" >
        <input type="checkbox" value="1" name="jobseeker_share_friendfeed_share" id="jobseeker_share_friendfeed_share" <?php
        if ($this->config['jobseeker_share_friendfeed_share'] == 1)
            echo 'checked="true"';
        else
            'checked="false"';
        ?> /><label class="socialconfig_label" for="jobseeker_share_friendfeed_share"><?php echo JText::_('Friend Feed Share'); ?><span class="pro_version">*</span></label>
        </div>
        
        <div class="socialconfig_content" >
        <input type="checkbox" value="1" name="jobseeker_share_linkedin_share" id="jobseeker_share_linkedin_share" <?php
        if ($this->config['jobseeker_share_linkedin_share'] == 1)
            echo 'checked="true"';
        else
            'checked="false"';
               ?> /><label class="socialconfig_label" for="jobseeker_share_linkedin_share"><?php echo JText::_('Linked-in Share'); ?><span class="pro_version">*</span></label>
        </div>
       
        <div class="socialconfig_content" >
        <input type="checkbox" value="1" name="jobseeker_share_digg_share" id="jobseeker_share_digg_share" <?php
        if ($this->config['jobseeker_share_digg_share'] == 1)
            echo 'checked="true"';
        else
            'checked="false"';
        ?> /><label class="socialconfig_label" for="jobseeker_share_digg_share"><?php echo JText::_('Digg Share'); ?><span class="pro_version">*</span></label>
        </div>
        
        <div class="socialconfig_content" >
        <input type="checkbox" value="1" name="jobseeker_share_twiiter_share" id="jobseeker_share_twiiter_share" <?php
        if ($this->config['jobseeker_share_twiiter_share'] == 1)
            echo 'checked="true"';
        else
            'checked="false"';
        ?> /><label class="socialconfig_label" for="jobseeker_share_twiiter_share"><?php echo JText::_('Twitter Share'); ?><span class="pro_version">*</span></label>
        </div>
        
        <div class="socialconfig_content" >
        <input type="checkbox" value="1" name="jobseeker_share_myspace_share" id="jobseeker_share_myspace_share" <?php
        if ($this->config['jobseeker_share_myspace_share'] == 1)
            echo 'checked="true"';
        else
            'checked="false"';
        ?> /><label class="socialconfig_label" for="jobseeker_share_myspace_share"><?php echo JText::_('Myspace Share'); ?><span class="pro_version">*</span></label>
        </div>
       
        <div class="socialconfig_content" >
        <input type="checkbox" value="1" name="jobseeker_share_yahoo_share" id="jobseeker_share_yahoo_share" <?php
        if ($this->config['jobseeker_share_yahoo_share'] == 1)
            echo 'checked="true"';
        else
            'checked="false"';
        ?> /><label class="socialconfig_label" for="jobseeker_share_yahoo_share"><?php echo JText::_('Yahoo Share'); ?><span class="pro_version">*</span></label>
        </div>

    </div>
 </div> <!-- user social closed --> 

 <div id="rss_job_set">

  <div class="headtext"><?php echo JText::_('RSS Jobs Settings'); ?><span class="pro_version">*</span></div>
 <div id="jsjobs_left_main">
    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="job_rss">
            <?php echo JText::_('Jobs RSS'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <?php
            echo JHTML::_('select.genericList', $showhide, 'job_rss', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['job_rss']);
            ;
            ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="job_rss"><?php echo JText::_(''); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="rss_job_title">
            <?php echo JText::_('Title'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <input type="text" name="rss_job_title" id="rss_job_title" value="<?php echo $this->config['rss_job_title']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $med_field_width; ?>" maxlength="255" />
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="rss_job_title"><?php echo JText::_('Must provide title for job feed'); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="rss_job_description">
            <?php echo JText::_('Description'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <textarea name="rss_job_description" id="rss_job_description" cols="25" rows="3" class="inputfieldsizeful inputbox"><?php echo $this->config['rss_job_description']; ?></textarea>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="rss_job_description"><?php echo JText::_('Must provide description for job feed'); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="rss_job_copyright">
            <?php echo JText::_('Copyright'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <input type="text" name="rss_job_copyright" id="rss_job_copyright" value="<?php echo $this->config['rss_job_copyright']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $med_field_width; ?>" maxlength="255" />
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="rss_job_copyright"><?php echo JText::_('Leave blank if not show'); ?></label>     
        </div>
    </div>


 
 </div><!-- left closed -->
 
 <div id="jsjobs_right_main">
    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="rss_job_editor">
            <?php echo JText::_('Editor'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <input type="text" name="rss_job_editor" id="rss_job_editor" value="<?php echo $this->config['rss_job_editor']; ?>" class="inputfieldsizeful inputbox validate-email" size="<?php echo $med_field_width; ?>" maxlength="255" />
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="rss_job_editor"><?php echo JText::_('Leave blank if not show editor used for feed content issue'); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="rss_job_ttl">
            <?php echo JText::_('Time To Live'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <input type="text" name="rss_job_ttl" id="rss_job_ttl" value="<?php echo $this->config['rss_job_ttl']; ?>" class="inputfieldsizeful inputbox validate-numeric"  maxlength="6"  size="<?php echo $med_field_width; ?>" maxlength="255" />
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="rss_job_ttl"><?php echo JText::_('Time To Live For Job Feed'); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="rss_job_webmaster">
            <?php echo JText::_('Webmaster'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <input type="text" name="rss_job_webmaster" id="rss_job_webmaster" value="<?php echo $this->config['rss_job_webmaster']; ?>" class="inputfieldsizeful inputbox validate-email" size="<?php echo $med_field_width; ?>" maxlength="255" />
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="rss_job_webmaster"><?php echo JText::_('Leave blank if not show webmaster email address used for techincal issue'); ?></label>     
        </div>
    </div>
  </div><!-- right closed -->
   
  <div class="headtext"><?php echo JText::_('Job Block'); ?><span class="pro_version">*</span></div>
 <div id="jsjobs_left_main">
    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="rss_job_categories">
            <?php echo JText::_('Show With Categories'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $showhide, 'rss_job_categories', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['rss_job_categories']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="rss_job_categories"><?php echo JText::_('Use rss categories with our job categories'); ?></label>     
        </div>
    </div>
 </div><!-- left closed -->
 
 <div id="jsjobs_right_main">
    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="rss_job_image">
            <?php echo JText::_('Company Image'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $showhide, 'rss_job_image', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['rss_job_image']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="rss_job_image"><?php echo JText::_('Show company logo with job feeds'); ?></label>     
        </div>
    </div>

  </div><!-- right closed -->

 </div> <!-- rss jobs closed --> 

 <div id="rss_resume_set">

  <div class="headtext"><?php echo JText::_('RSS Resume Settings'); ?><span class="pro_version">*</span></div>
 <div id="jsjobs_left_main">
    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="resume_rss">
            <?php echo JText::_('Resume RSS'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <?php
            echo JHTML::_('select.genericList', $showhide, 'resume_rss', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['resume_rss']);
            ;
            ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="resume_rss"><?php echo JText::_(''); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="rss_resume_title">
            <?php echo JText::_('Title'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <input type="text" name="rss_resume_title" id="rss_resume_title" value="<?php echo $this->config['rss_resume_title']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $med_field_width; ?>" maxlength="255" />
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="rss_resume_title"><?php echo JText::_('Must provide title for resume feed'); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="rss_resume_description">
            <?php echo JText::_('Description'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <textarea name="rss_resume_description" id="rss_resume_description" cols="25" rows="3" class="inputfieldsizeful inputbox"><?php echo $this->config['rss_resume_description']; ?></textarea>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="rss_resume_description"><?php echo JText::_('Must provide description for resume feed'); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="rss_resume_copyright">
            <?php echo JText::_('Copyright'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <input type="text" name="rss_resume_copyright" id="rss_resume_copyright" value="<?php echo $this->config['rss_resume_copyright']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $med_field_width; ?>" maxlength="255" />
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="rss_resume_copyright"><?php echo JText::_('Leave Blank If Not Show'); ?></label>     
        </div>
    </div>

 </div><!-- left closed -->
 
 <div id="jsjobs_right_main">
    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="rss_resume_editor">
            <?php echo JText::_('Editor'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <input type="text" name="rss_resume_editor" id="rss_resume_editor" value="<?php echo $this->config['rss_resume_editor']; ?>" class="inputfieldsizeful inputbox validate-email" size="<?php echo $med_field_width; ?>" maxlength="255" />
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="rss_resume_editor"><?php echo JText::_('Leave blank if not show editor email address used for content issue'); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="rss_resume_ttl">
            <?php echo JText::_('Time To Live'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <input type="text" name="rss_resume_ttl" id="rss_resume_ttl" value="<?php echo $this->config['rss_resume_ttl']; ?>" class="inputfieldsizeful inputbox validate-numeric"  maxlength="6" size="<?php echo $med_field_width; ?>" maxlength="255" />
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="rss_resume_ttl"><?php echo JText::_('Time to live for resume feed'); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="rss_resume_webmaster">
            <?php echo JText::_('Webmaster'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <input type="text" name="rss_resume_webmaster" id="rss_resume_webmaster" value="<?php echo $this->config['rss_resume_webmaster']; ?>" class="inputfieldsize inputbox validate-email" size="<?php echo $med_field_width; ?>" maxlength="255" />
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="rss_resume_webmaster"><?php echo JText::_('Leave blank if not show webmaster email address used for technical issue'); ?></label>     
        </div>
    </div>
  </div><!-- right closed -->
   
  <div class="headtext"><?php echo JText::_('Resume Block'); ?><span class="pro_version">*</span></div>
 <div id="jsjobs_left_main">
    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="rss_resume_categories">
            <?php echo JText::_('Show With Categories'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $showhide, 'rss_resume_categories', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['rss_resume_categories']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="rss_resume_categories"><?php echo JText::_('Use rss categories with our resume categories'); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="rss_resume_file">
            <?php echo JText::_('Show Resume File'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $showhide, 'rss_resume_file', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['rss_resume_file']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="rss_resume_file"><?php echo JText::_('Show resume file to downloadable from feed'); ?></label>     
        </div>
    </div>
 </div><!-- left closed -->
 
 <div id="jsjobs_right_main">
    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="rss_resume_image">
            <?php echo JText::_('Resume Image'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $showhide, 'rss_resume_image', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['rss_resume_image']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="rss_resume_image"><?php echo JText::_('Show resume image with job feeds'); ?></label>     
        </div>
    </div>

  </div><!-- right closed -->
  </div> <!-- rss resume closed -->

 <div id="googlemapadsense">
 <div class="headtext"><?php echo JText::_('Map'); ?></div>
 <div id="jsjobs_left_main">
    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="mapheight">
            <?php echo JText::_('Map Height'); ?>
        </label>
        <div class="jobs-config-value">
            <input class="inputfieldsize inputbox validate-numeric"  maxlength="6" type="text" id="mapheight" name="mapheight" value="<?php echo $this->config['mapheight']; ?>"/><label class="jobs-mini-descp" for="mapheight"><?php echo JText::_('Pixels'); ?></label>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="mapheight"><?php echo JText::_(''); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="mapwidth">
            <?php echo JText::_('Map Width'); ?>
        </label>
        <div class="jobs-config-value">
            <input class="inputfieldsize inputbox validate-numeric" maxlength="6" type="text" id="mapwidth" name="mapwidth" value="<?php echo $this->config['mapwidth']; ?>"/><label class="jobs-mini-descp" for="mapwidth"><?php echo JText::_('Pixels'); ?></label>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="mapwidth"><?php echo JText::_(''); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="">
            <?php echo JText::_('Map'); ?>
        </label>
        <div class="jobs-config-value">
            <a href="Javascript: showdiv();loadMap();"><?php echo JText::_('Show Map'); ?></a>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for=""><?php echo JText::_(''); ?></label>     
        </div>
    </div>
 
    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="google_map_api_key">
            <?php echo JText::_('Google Map API key'); ?>
        </label>
        <div class="jobs-config-value">
            <input class="inputfieldsize inputbox" type="text" id="google_map_api_key" name="google_map_api_key" value="<?php echo $this->config['google_map_api_key']; ?>"/>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="google_map_api_key"><?php echo JText::_('Get API key from').' <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">'.JText::_('here').'</a>'; ?></label>
        </div>
    </div>

 </div><!-- left closed -->
 
 <div id="jsjobs_right_main">

    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="default_latitude">
            <?php echo JText::_('Latitude'); ?>
        </label>
        <div class="jobs-config-value">
            <input type="text" id="default_latitude" class="inputfieldsizeful" name="default_latitude" value="<?php echo $this->config['default_latitude']; ?>"/>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="default_latitude"><?php echo JText::_('Default latitude'); ?></label>     
        </div>
    </div>
    
    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="default_longitude">
            <?php echo JText::_('Longitude'); ?>
        </label>
        <div class="jobs-config-value">
            <input type="text" id="default_longitude" name="default_longitude" class="inputfieldsizeful" value="<?php echo $this->config['default_longitude']; ?>"/>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="default_longitude"><?php echo JText::_('Default longitude'); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="defaultradius">
            <?php echo JText::_('Default Map Radius Type'); ?>
        </label>
        <div class="jobs-config-value">
            <?php echo JHTML::_('select.genericList', $defaultradius, 'defaultradius', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['defaultradius']); ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="defaultradius"><?php echo JText::_(''); ?></label>     
        </div>
    </div> 
    </div><!-- right closed -->
    
    <div id="js_jobs_main_popup_area">
        <div id="js_jobs_main_popup_head">
            <div id="jspopup_title"><?php echo JText::_('Map');?></div>
            <img id="jspopup_image_close" src="components/com_jsjobs/include/images/popup-close.png" />
        </div>
        <div id="jspopup_work_area">
            <div id="map" style="width:<?php echo $this->config['mapwidth']; ?>px; height:<?php echo $this->config['mapheight']; ?>px"><div id="map_container"></div></div>
        </div>
    </div>



 <div class="headtext"><?php echo JText::_('Google Adsense Settings'); ?><span class="pro_version">*</span></div>
 <div id="jsjobs_left_main">

    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="googleadsenseshowinlistjobs">
            <?php echo JText::_('Show Google Ads In List Jobs'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <?php
            echo JHTML::_('select.genericList', $showhide, 'googleadsenseshowinlistjobs', 'class="inputfieldsizeful inputbox" ' . '', 'value', 'text', $this->config['googleadsenseshowinlistjobs']);
            ?>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="googleadsenseshowinlistjobs"><?php echo JText::_('Show google adds in jobs listings'); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="googleadsenseclient">
            <?php echo JText::_('Google Adsense Client Id'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <input type="text" name="googleadsenseclient" id="googleadsenseclient" value="<?php echo $this->config['googleadsenseclient']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $med_field_width; ?>" maxlength="255" />
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="googleadsenseclient"><?php echo JText::_(''); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="googleadsenseslot">
            <?php echo JText::_('Google Adsense Slot Id'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <input type="text" name="googleadsenseslot" id="googleadsenseslot" value="<?php echo $this->config['googleadsenseslot']; ?>" class="inputfieldsizeful inputbox" size="<?php echo $med_field_width; ?>" maxlength="255" />
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="googleadsenseslot"><?php echo JText::_(''); ?></label>     
        </div>
    </div>    
    
    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="googleadsensecustomcss">
            <?php echo JText::_('Google Ads Custom Css'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <textarea name="googleadsensecustomcss" id="googleadsensecustomcss" cols="25" rows="3" class="inputfieldsizeful inputbox"><?php echo $this->config['googleadsensecustomcss']; ?></textarea>
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="googleadsensecustomcss"><?php echo JText::_(''); ?></label>     
        </div>
    </div>


 
 </div><!-- left closed -->
 
 <div id="jsjobs_right_main">


    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="googleadsenseshowafter">
            <?php echo JText::_('Google Ads Show After Number Of Jobs'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <input type="text" name="googleadsenseshowafter" id="googleadsenseshowafter" value="<?php echo $this->config['googleadsenseshowafter']; ?>" class="inputfieldsizeful inputbox validate-numeric" maxlength="6" size="<?php echo $small_field_width; ?>" maxlength="255" />
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="googleadsenseshowafter"><?php echo JText::_(''); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="googleadsensewidth">
            <?php echo JText::_('Google Ads Width'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <input type="text" name="googleadsensewidth" id="googleadsensewidth" value="<?php echo $this->config['googleadsensewidth']; ?>" class="inputfieldsizeful inputbox validate-numeric" maxlength="6" size="<?php echo $small_field_width; ?>" maxlength="255" />
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="googleadsensewidth"><?php echo JText::_(''); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="googleadsenseheight">
            <?php echo JText::_('Google Ads Height'); ?><span class="pro_version">*</span>
        </label>
        <div class="jobs-config-value">
            <input type="text" name="googleadsenseheight" id="googleadsenseheight" value="<?php echo $this->config['googleadsenseheight']; ?>" class="inputfieldsizeful inputbox validate-numeric" maxlength="6" size="<?php echo $small_field_width; ?>" maxlength="255" />
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="googleadsenseheight"><?php echo JText::_(''); ?></label>     
        </div>
    </div>

  </div><!-- right closed -->
 </div><!-- map and google adsense closed -->
  
  <?php if ($this->isjobsharing) { ?> 
 <div id="jobsharing">
 <div class="headtext"><?php echo JText::_('Job Sharing Default Location'); ?></div>
 <div id="jsjobs_left_main">
    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="default_sharing_country">
            <?php echo JText::_('Country'); ?>
        </label>
        <div class="jobs-config-value">
        <?php
    if ((isset($this->lists['defaultsharingcountry'])) && ($this->lists['defaultsharingcountry'] != ''))
        echo $this->lists['defaultsharingcountry'];
    ?>    
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="default_sharing_country"><?php echo JText::_(''); ?></label>     
        </div>
    </div>

    <div id="jsjob_configuration_wrapper">
        <label class="jobs-config-title stylelabeltop labelcolortop" for="default_sharing_state">
            <?php echo JText::_('State'); ?>
        </label>
        <div class="jobs-config-value">
            <?php
    if ((isset($this->lists['defaultsharingstate'])) && ($this->lists['defaultsharingstate'] != '')) { ?>
        <input class="inputfieldsizeful inputbox" type="text" name="default_sharing_state" id="default_sharing_state" size="40" maxlength="100" value="<?php echo $this->lists['defaultsharingstate']; ?>" />
  <?php  } else {
        ?>
      <input class="inputfieldsizeful inputbox" type="text" name="default_sharing_state" id="default_sharing_state" size="40" maxlength="100" value="" />
    <?php } ?>  
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="default_sharing_state"><?php echo JText::_(''); ?></label>     
        </div>
    </div>
 
 </div><!-- left closed -->
 
 <div id="jsjobs_right_main">
    <div id="jsjob_configuration_wrapper" >
        <label class="jobs-config-title stylelabeltop labelcolortop" for="default_sharing_city">
            <?php echo JText::_('City'); ?>
        </label>
        <div class="jobs-config-value">
              <?php
    if ((isset($this->lists['defaultsharingcity'])) && ($this->lists['defaultsharingcity'] != '')) {    
       ?> <input class="inputfieldsize inputbox" type="text" name="default_sharing_city" id="default_sharing_city" size="40" maxlength="100" value="<?php echo $this->lists['defaultsharingcity']; ?>" />
    <?php } else {
        ?>
      <input class="inputfieldsize inputbox" type="text" name="default_sharing_city" id="default_sharing_city" size="40" maxlength="100" value="" />
    <?php } ?> 
        </div>
        <div class="jobs-config-descript">
            <label class=" stylelabelbottom labelcolorbottom" for="default_sharing_city"><?php echo JText::_(''); ?></label>     
        </div>
    </div>

  </div><!-- right closed -->
 <?php } ?> 
  </div><!-- job sharing wrapper -->  
    </div><!-- tab wrapper -->
    <input type="hidden" name="layout" value="configurations" />
    <input type="hidden" name="task" value="configuration.saveconf" />
    <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
        <?php echo JHTML::_( 'form.token' ); ?>        
    </form>

    </div><!-- content closed -->
   
</div><!-- main wrapper closed -->
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

<script type="text/javascript">

    function dochange(src, val) {
        if (src == 'defaultsharingstate')
            var countryid = val;
        else if (src == 'defaultsharingcity')
            var stateid = val;
        jQuery("#" + src).html("Loading...");
        jQuery.post("index.php?option=com_jsjobs&task=jobsharing.defaultaddressdatajobsharing", {data: src, val: val}, function (data) {
            if (data) {
                if (data == "") {
                    return_value = "<input class='inputbox' type='text' name='default_sharing_state' id='default_sharing_state' readonly='readonly' size='40' maxlength='100'  />";
                    jQuery("#" + src).html(return_value); //retuen value
                    getcountrycity(val);
                } else {
                    jQuery("#" + src).html(data); //retuen value
                    if (src == 'defaultsharingstate') {
                        cityhtml = "<input class='inputbox' type='text' name='default_sharing_city' readonly='readonly' size='40' maxlength='100'  />";
                        jQuery('#defaultsharingcity').html(cityhtml); //retuen value
                    }
                }
            }
        });
    }

    function getcountrycity(countryid) {
        var src = 'defaultsharingcity';
        jQuery("#" + src).html("Loading...");
        jQuery.post("index.php?option=com_jsjobs&task=jobsharing.defaultaddressdatajobsharing", {data: src, state: -1, val: countryid}, function (data) {
            if (data) {
                jQuery("#" + src).html(data); //retuen value
            }
        });
    }

    function hideshowtables(table_id) {
        var obj = document.getElementById(table_id);
        var bool = obj.style.display;
        if (bool == '')
            obj.style.display = "none";
        else
            obj.style.display = "";
    }

</script>
<style type="text/css">
    div#map_container{background:#000;width:100%;height:100%;}
    div#map{width:100%;height:100%;}
</style>
<?php $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://"; ?>
<script type="text/javascript" src="<?php echo $protocol; ?>maps.googleapis.com/maps/api/js?key=<?php echo $this->config['google_map_api_key']; ?>"></script>
<script type="text/javascript">
    function loadMap() {
        var default_latitude = document.getElementById('default_latitude').value;
        var default_longitude = document.getElementById('default_longitude').value;
        var latlng = new google.maps.LatLng(default_latitude, default_longitude);
        zoom = 10;
        var myOptions = {
            zoom: zoom,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("map_container"), myOptions);
        var lastmarker = new google.maps.Marker({
            postiion: latlng,
            map: map,
        });
        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
        });
        marker.setMap(map);
        lastmarker = marker;

        google.maps.event.addListener(map, "click", function (e) {
            var latLng = new google.maps.LatLng(e.latLng.lat(), e.latLng.lng());
            geocoder = new google.maps.Geocoder();
            geocoder.geocode({'latLng': latLng}, function (results, status) {

                if (status == google.maps.GeocoderStatus.OK) {
                    if (lastmarker != '')
                        lastmarker.setMap(null);
                    var marker = new google.maps.Marker({
                        position: results[0].geometry.location,
                        map: map,
                    });
                    marker.setMap(map);
                    lastmarker = marker;
                    document.getElementById('default_latitude').value = marker.position.lat();
                    document.getElementById('default_longitude').value = marker.position.lng();

                } else {
                    alert("Geocode was not successful for the following reason: " + status);
                }
            });
        });
    }
    function showdiv() {
        jQuery("div#js_jobs_main_popup_back").show();
        jQuery("div#js_jobs_main_popup_area").slideDown('slow');
    }
    function hidediv() {
        document.getElementById('map').style.visibility = 'hidden';
    }
</script>

<div id="js_jobs_main_popup_back"></div>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("img#jspopup_image_close,div#js_jobs_main_popup_back").click(function(){
            jQuery("div#js_jobs_main_popup_area").slideUp('slow');
            setTimeout(function () {
                jQuery("div#js_jobs_main_popup_back").hide();
                jQuery("div#jspopup_work_area").html('');
            }, 700);
        });
    });
</script>