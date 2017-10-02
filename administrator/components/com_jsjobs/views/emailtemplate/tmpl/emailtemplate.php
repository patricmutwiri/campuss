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
jimport('joomla.html.pane');

$editor = JFactory::getEditor();
JHTML::_('behavior.calendar');
JHTML::_('behavior.formvalidation');
$document = JFactory::getDocument();

if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('../components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}
?>

<script language="javascript">
// for joomla 1.6
    Joomla.submitbutton = function (task) {
        if (task == '') {
            return false;
        } else {
            if (task == 'emailtemplate.save') {
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
        }
        else {
            alert('<?php echo JText::_('Some Values Are Not Acceptable.  Please Retry.'); ?>');
            return false;
        }
        return true;
    }
</script>

<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=controlpanel"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Email Template'); ?></span></div>
        <form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data" >
            <input type="hidden" name="check" value="post"/>
            <div id="main_emailcontent_wrapper">
            <span class="upperblueline"></span>
            <div class="main_datacontent">
              <div class="emailleft_main">
                    <a class="<?php if($this->templatefor == 'ew-cm') echo 'selected_link'; ?>" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ew-cm"> <?php echo JText::_('New Company'); ?></a>
                    <a class="<?php if($this->templatefor == 'cm-ap') echo 'selected_link'; ?>" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=cm-ap"> <?php echo JText::_('Company Approval'); ?></a>
                    <a class="<?php if($this->templatefor == 'cm-rj') echo 'selected_link'; ?>" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=cm-rj"> <?php echo JText::_('Company Rejection'); ?></a>
                    <a class="<?php if($this->templatefor == 'cm-dl') echo 'selected_link'; ?>" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=cm-dl"> <?php echo JText::_('Company Delete'); ?></a>
                    <a class="<?php if($this->templatefor == 'ew-ob') echo 'selected_link'; ?>" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ew-ob"> <?php echo JText::_('New Job').' ( '.JText::_('Admin').' )'; ?></a>
                    <a class="<?php if($this->templatefor == 'ew-ob-em') echo 'selected_link'; ?>" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ew-ob-em"> <?php echo JText::_('New Job').' ( '.JText::_('Employer').' )'; ?></a>
                    <a class="<?php if($this->templatefor == 'ob-ap') echo 'selected_link'; ?>" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ob-ap"> <?php echo JText::_('Job Approval'); ?></a>
                    <a class="<?php if($this->templatefor == 'ob-rj') echo 'selected_link'; ?>" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ob-rj"> <?php echo JText::_('Job Rejecting'); ?></a>
                    <a class="<?php if($this->templatefor == 'ob-dl') echo 'selected_link'; ?>" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ob-dl"> <?php echo JText::_('Job Delete'); ?></a>
                    <a class="<?php if($this->templatefor == 'ap-rs') echo 'selected_link'; ?>" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ap-rs"> <?php echo JText::_('Applied Resume Status'); ?></a>
                    <a class="<?php if($this->templatefor == 'ew-rm') echo 'selected_link'; ?>" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ew-rm"> <?php echo JText::_('New Resume'); ?></a>
                    <a class="<?php if($this->templatefor == 'ew-rm-vis') echo 'selected_link'; ?>" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ew-rm-vis"> <?php echo JText::_('New Resume Visitor'); ?></a>
                    <a class="<?php if($this->templatefor == 'rm-ap') echo 'selected_link'; ?>" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=rm-ap"> <?php echo JText::_('Resume Approval'); ?></a>
                    <a class="<?php if($this->templatefor == 'rm-rj') echo 'selected_link'; ?>" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=rm-rj"> <?php echo JText::_('Resume Rejecting'); ?></a>
                    <a class="<?php if($this->templatefor == 'rm-dl') echo 'selected_link'; ?>" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=rm-dl"> <?php echo JText::_('Resume Delete'); ?></a>
                    <a class="<?php if($this->templatefor == 'ba-ja') echo 'selected_link'; ?>" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ba-ja"> <?php echo JText::_('Job Apply'); ?></a>
                    <a class="<?php if($this->templatefor == 'js-ja') echo 'selected_link'; ?>" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=js-ja"> <?php echo JText::_('Job Apply Jobseeker'); ?></a>
                    <a class="<?php if($this->templatefor == 'ew-md') echo 'selected_link'; ?>" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ew-md"> <?php echo JText::_('New Department'); ?></a>
                    <a class="<?php if($this->templatefor == 'ew-rp') echo 'selected_link'; ?>" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ew-rp"> <?php echo JText::_('Employer Purchase'); ?></a>
                    <a class="<?php if($this->templatefor == 'ew-js') echo 'selected_link'; ?>" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ew-js"> <?php echo JText::_('Job Seeker Purchase'); ?></a>
                    <a class="<?php if($this->templatefor == 'ms-sy') echo 'selected_link'; ?>" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ms-sy"> <?php echo JText::_('Message'); ?></a>
                    <a class="<?php if($this->templatefor == 'jb-at') echo 'selected_link'; ?>" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=jb-at"> <?php echo JText::_('Job Alert'); ?></a>
                    <a class="<?php if($this->templatefor == 'jb-at-vis') echo 'selected_link'; ?>" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=jb-at-vis"> <?php echo JText::_('Employer').' ( '.JText::_('visitor').' ) '.JText::_('Job'); ?></a>
                    <a class="<?php if($this->templatefor == 'jb-to-fri') echo 'selected_link'; ?>" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=jb-to-fri"> <?php echo JText::_('Job To Friend'); ?></a>
                    <a class="<?php if($this->templatefor == 'jb-pkg-pur') echo 'selected_link'; ?>" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=jb-pkg-pur"> <?php echo JText::_('Job Seeker Package Purchased'); ?></a>
                    <a class="<?php if($this->templatefor == 'emp-kg-pur') echo 'selected_link'; ?>" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=emp-pkg-pur"> <?php echo JText::_('Employer Package Purchased'); ?></a>
              </div><!-- leftmain-closed -->
              <div class="emailright_main">
                  <label for="subject"><?php echo JText::_('Subject'); ?>&nbsp;<font color="red">*</font></label>
                  <input class="inputfieldsizeful inputbox required" type="text" name="subject" id="subject" size="135" maxlength="255" value="<?php if (isset($this->template)) echo $this->template->subject; ?>" />
                  <label><?php echo JText::_('Body'); ?>&nbsp;<font color="red">*</font></label>
                  <div class="email_editor">
                      <?php
                            $editor = JFactory::getEditor();
                            if (isset($this->template))
                                echo $editor->display('body', $this->template->body, '550', '300', '60', '20', false);
                            else
                                echo $editor->display('body', '', '550', '300', '60', '20', false);
                            ?>  
                  </div><!-- email editor closed -->
                  <label class="parameter_email param_font"><?php echo JText::_('Parameters'); ?></label>
                    <?php if (($this->template->templatefor == 'company-approval' ) || ($this->template->templatefor == 'company-rejecting' )) { ?>
                        <span class="bottomdata_email">{COMPANY_NAME} :  <?php echo JText::_('Company Name'); ?></span>
                        <span class="bottomdata_email">{EMPLOYER_NAME} :  <?php echo JText::_('Employer Name'); ?></span>    
                        <span class="bottomdata_email">{COMPANY_LINK} :  <?php echo JText::_('View Company'); ?></span>  
                    <?php } elseif (($this->template->templatefor == 'job-approval' ) || ($this->template->templatefor == 'job-rejecting' )) { ?>
                        <span class="bottomdata_email">{JOB_TITLE} :  <?php echo JText::_('Job Title'); ?></span>
                        <span class="bottomdata_email">{EMPLOYER_NAME} :  <?php echo JText::_('Employer Name'); ?></span>    
                        <span class="bottomdata_email">{JOB_LINK} :  <?php echo JText::_('Job Link'); ?></span>  
                    <?php } elseif (($this->template->templatefor == 'resume-approval' ) || ($this->template->templatefor == 'resume-rejecting' )) { ?>                                     
                        <span class="bottomdata_email">{RESUME_TITLE} :  <?php echo JText::_('Resume Title'); ?></span>
                        <span class="bottomdata_email">{JOBSEEKER_NAME} :  <?php echo JText::_('Job Seeker Name'); ?></span> 
                        <span class="bottomdata_email">{RESUME_LINK} :  <?php echo JText::_('View Resume'); ?></span>    
                    <?php } elseif ($this->template->templatefor == 'company-new') { ?>
                        <span class="bottomdata_email">{COMPANY_NAME} :  <?php echo JText::_('Company Name'); ?></span>
                        <span class="bottomdata_email">{EMPLOYER_NAME} :  <?php echo JText::_('Employer Name'); ?></span>    
                        <span class="bottomdata_email">{COMPANY_LINK} :  <?php echo JText::_('View Company'); ?></span>  
                    <?php } elseif ($this->template->templatefor == 'job-new') { ?>
                        <span class="bottomdata_email">{JOB_TITLE} :  <?php echo JText::_('Job Title'); ?></span>
                        <span class="bottomdata_email">{EMPLOYER_NAME} :  <?php echo JText::_('Employer Name'); ?></span>    
                        <span class="bottomdata_email">{JOB_LINK} :  <?php echo JText::_('Job Link'); ?></span>  
                    <?php } elseif ($this->template->templatefor == 'job-new-employer') { ?>
                        <span class="bottomdata_email">{EMPLOYER_NAME} :  <?php echo JText::_('Employer Name'); ?></span>
                        <span class="bottomdata_email">{JOB_TITLE} :  <?php echo JText::_('Job Title'); ?></span>
                        <span class="bottomdata_email">{COMPANY_NAME} :  <?php echo JText::_('Company Name'); ?></span>    
                        <span class="bottomdata_email">{DEPARTMENT_NAME} :  <?php echo JText::_('Department Name'); ?></span>
                        <span class="bottomdata_email">{CATEGORGY_TITLE} :  <?php echo JText::_('Category Title'); ?></span>    
                        <span class="bottomdata_email">{JOB_TYPE_TITLE} :  <?php echo JText::_('Job Type Title'); ?></span>    
                        <span class="bottomdata_email">{JOB_STATUS} :  <?php echo JText::_('Job Status'); ?></span>    
                        <span class="bottomdata_email">{JOB_LINK} :  <?php echo JText::_('Job Link'); ?></span>
                    <?php } elseif ($this->template->templatefor == 'resume-new') { ?>                                      
                        <span class="bottomdata_email">{RESUME_TITLE} :  <?php echo JText::_('Resume Title'); ?></span>
                        <span class="bottomdata_email">{JOBSEEKER_NAME} :  <?php echo JText::_('Job Seeker Name'); ?></span> 
                        <span class="bottomdata_email">{RESUME_LINK} :  <?php echo JText::_('View Resume'); ?></span>    
                    <?php } elseif ($this->template->templatefor == 'department-new') { ?>                                      
                        <span class="bottomdata_email">{DEPARTMENT_TITLE} :  <?php echo JText::_('Department Title'); ?></span>
                        <span class="bottomdata_email">{COMPANY_NAME} :  <?php echo JText::_('Company Name'); ?></span>
                        <span class="bottomdata_email">{EMPLOYER_NAME} :  <?php echo JText::_('Employer Name'); ?></span>    
                    <?php } elseif ($this->template->templatefor == 'employer-buypackage') { ?>                                     
                        <span class="bottomdata_email">{PACKAGE_NAME} :  <?php echo JText::_('Package Title'); ?></span>
                        <span class="bottomdata_email">{EMPLOYER_NAME} :  <?php echo JText::_('Employer Name'); ?></span>    
                        <span class="bottomdata_email">{PACKAGE_PRICE} :  <?php echo JText::_('Package Price'); ?></span>    
                        <span class="bottomdata_email">{PACKAGE_LINK} :  <?php echo JText::_('View Package'); ?></span>   
                        <span class="bottomdata_email">{PAYMENT_STATUS} :  <?php echo JText::_('Payment Status'); ?></span>  
                    <?php } elseif ($this->template->templatefor == 'jobseeker-buypackage') { ?>                                        
                        <span class="bottomdata_email">{PACKAGE_NAME} :  <?php echo JText::_('Package Title'); ?></span>
                        <span class="bottomdata_email">{JOBSEEKER_NAME} :  <?php echo JText::_('Job Seeker Name'); ?></span> 
                        <span class="bottomdata_email">{PACKAGE_PRICE} :  <?php echo JText::_('Package Price'); ?></span>    
                        <span class="bottomdata_email">{PACKAGE_LINK} :  <?php echo JText::_('View Package'); ?></span>  
                        <span class="bottomdata_email">{PAYMENT_STATUS} :  <?php echo JText::_('Payment Status'); ?></span>  
                    <?php } elseif ($this->template->templatefor == 'jobapply-jobapply') { ?>                                       
                        <span class="bottomdata_email">{EMPLOYER_NAME} :  <?php echo JText::_('Employer Name'); ?></span>    
                        <span class="bottomdata_email">{JOBSEEKER_NAME} :  <?php echo JText::_('Job Seeker Name'); ?></span> 
                        <span class="bottomdata_email">{JOB_TITLE} :  <?php echo JText::_('Job Title'); ?></span>
                        <span class="bottomdata_email">{RESUME_LINK} :  <?php echo JText::_('View Resume'); ?></span>    
                        <span class="bottomdata_email">{RESUME_DATA} :  <?php echo JText::_('Resume'); ?></span> 
                    <?php } elseif ($this->template->templatefor == 'message-email') { ?>
                        <span class="bottomdata_email">{NAME} :  <?php echo JText::_('Name'); ?></span>  
                        <span class="bottomdata_email">{SENDER_NAME} :  <?php echo JText::_('Sender Name'); ?></span>    
                        <span class="bottomdata_email">{JOB_TITLE} :  <?php echo JText::_('Job Title'); ?></span>
                        <span class="bottomdata_email">{COMPANY_NAME} :  <?php echo JText::_('Company Name'); ?></span>
                        <span class="bottomdata_email">{RESUME_TITLE} :  <?php echo JText::_('Resume Title'); ?></span>
                    <?php } elseif ($this->template->templatefor == 'job-alert') { ?>
                        <span class="bottomdata_email">{JOBSEEKER_NAME} :  <?php echo JText::_('Job Seeker Name'); ?></span> 
                        <span class="bottomdata_email">{JOBS_INFO} :  <?php echo JText::_('Show Jobs In Tabular'); ?></span> 
                    <?php } elseif ($this->template->templatefor == 'job-alert-visitor') { ?>
                        <span class="bottomdata_email">{JOB_TITLE} :  <?php echo JText::_('Job Title'); ?></span>
                        <span class="bottomdata_email">{COMPANY_NAME} :  <?php echo JText::_('Company Name'); ?></span>  
                        <span class="bottomdata_email">{JOB_CATEGORY} :  <?php echo JText::_('Job Category'); ?></span>  
                        <span class="bottomdata_email">{JOB_STATUS} :  <?php echo JText::_('Job Status'); ?></span>  
                        <span class="bottomdata_email">{CONTACT_NAME} :  <?php echo JText::_('Visitor Contact Name'); ?></span>  
                        <span class="bottomdata_email">{JOB_LINK} :  <?php echo JText::_('Job Link'); ?></span>  
                    <?php } elseif ($this->template->templatefor == 'job-to-friend') { ?>
                        <span class="bottomdata_email">{SENDER_NAME} :  <?php echo JText::_('Sender Name'); ?></span>
                        <span class="bottomdata_email">{SITE_NAME} :  <?php echo JText::_('Site Name'); ?></span>
                        <span class="bottomdata_email">{JOB_TITLE} :  <?php echo JText::_('Job Title'); ?></span>
                        <span class="bottomdata_email">{JOB_CATEGORY} :  <?php echo JText::_('Job Category'); ?></span>  
                        <span class="bottomdata_email">{COMPANY_NAME} :  <?php echo JText::_('Company Name'); ?></span>  
                        <span class="bottomdata_email">{CLICK_HERE TO_VISIT} :  <?php echo JText::_('Click Here To Visit'); ?></span>    
                        <span class="bottomdata_email">{SENDER_MESSAGE} :  <?php echo JText::_('Sender Message'); ?></span>  
                    <?php } elseif ($this->template->templatefor == 'applied-resume_status') { ?>
                        <span class="bottomdata_email">{JOBSEEKER_NAME} :  <?php echo JText::_('Job Seeker Name'); ?></span>
                        <span class="bottomdata_email">{RESUME_STATUS} :  <?php echo JText::_('Applied Resume Status'); ?></span>
                        <span class="bottomdata_email">{JOB_TITLE} :  <?php echo JText::_('Job Title'); ?></span>
                        <span class="bottomdata_email">{STATUS} :  <?php echo JText::_('Resume Apply Status'); ?></span>
                    <?php } elseif ($this->template->templatefor == 'jobseeker-packagepurchase') { ?>
                        <span class="bottomdata_email">{JOBSEEKER_NAME} :  <?php echo JText::_('Job Seeker Name'); ?></span>
                        <span class="bottomdata_email">{PACKAGE_TITLE} :  <?php echo JText::_('Package Title'); ?></span>
                        <span class="bottomdata_email">{LINK} :  <?php echo JText::_('Url To Check The Status'); ?></span>
                        <span class="bottomdata_email">{PAYMENT_STATUS} :  <?php echo JText::_('Payment Status'); ?></span>
                    <?php } elseif ($this->template->templatefor == 'employer-packagepurchase') { ?>
                        <span class="bottomdata_email">{EMPLOYER_NAME} :  <?php echo JText::_('Employer Name'); ?></span>
                        <span class="bottomdata_email">{PACKAGE_TITLE} :  <?php echo JText::_('Package Title'); ?></span>
                        <span class="bottomdata_email">{LINK} :  <?php echo JText::_('Url To Check The Status'); ?></span>
                        <span class="bottomdata_email">{PAYMENT_STATUS} :  <?php echo JText::_('Payment Status'); ?></span>
                    <?php } elseif ($this->template->templatefor == 'company-delete') { ?>
                        <span class="bottomdata_email">{COMPANY_NAME} :  <?php echo JText::_('Company Name'); ?></span>
                        <span class="bottomdata_email">{COMPANY_OWNER_NAME} :  <?php echo JText::_('Company Owner Name'); ?></span>
                    <?php } elseif ($this->template->templatefor == 'job-delete') { ?>
                        <span class="bottomdata_email">{EMPLOYER_NAME} :  <?php echo JText::_('Employer Name'); ?></span>
                        <span class="bottomdata_email">{COMPANY_NAME} :  <?php echo JText::_('Company Name'); ?></span>
                        <span class="bottomdata_email">{JOB_TITLE} :  <?php echo JText::_('Job Title'); ?></span>
                    <?php } elseif ($this->template->templatefor == 'resume-delete') { ?>
                        <span class="bottomdata_email">{JOBSEEKER_NAME} :  <?php echo JText::_('Jobseeker Name'); ?></span>
                        <span class="bottomdata_email">{RESUME_TITLE} :  <?php echo JText::_('Resume Title'); ?></span>
                    <?php } elseif ($this->template->templatefor == 'resume-new-vis') { ?>
                        <span class="bottomdata_email">{JOBSEEKER_NAME} :  <?php echo JText::_('Jobseeker Name'); ?></span>
                        <span class="bottomdata_email">{RESUME_TITLE} :  <?php echo JText::_('Resume Title'); ?></span>
                        <span class="bottomdata_email">{RESUME_STATUS} :  <?php echo JText::_('Resume Status'); ?></span>
                    <?php } elseif ($this->template->templatefor == 'jobapply-jobseeker') { ?>
                        <span class="bottomdata_email">{JOBSEEKER_NAME} :  <?php echo JText::_('Jobseeker Name'); ?></span>
                        <span class="bottomdata_email">{RESUME_TITLE} :  <?php echo JText::_('Resume Title'); ?></span>
                        <span class="bottomdata_email">{COMPANY_NAME} :  <?php echo JText::_('Company Name'); ?></span>
                        <span class="bottomdata_email">{RESUME_APPLIED_STATUS} :  <?php echo JText::_('Resume Applied Status'); ?></span>
                    <?php } ?>

              </div><!-- rightmain closed -->
              <?php
                if (isset($this->template)) {
                    if (($this->template->created == '0000-00-00 00:00:00') || ($this->template->created == ''))
                        $curdate = date('Y-m-d H:i:s');
                    else
                        $curdate = $this->template->created;
                } else
                    $curdate = date('Y-m-d H:i:s');
                ?>
          </div> <!-- maindatacontent closed -->
          <input type="hidden" name="created" value="<?php echo $curdate; ?>" />
          <input type="hidden" name="view" value="jobposting" />
          <input type="hidden" name="uid" value="<?php echo $this->uid; ?>" />
          <input type="hidden" name="id" value="<?php echo $this->template->id; ?>" />
          <input type="hidden" name="templatefor" value="<?php echo $this->template->templatefor; ?>" />
          <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
          <input type="hidden" name="task" value="emailtemplate.saveemailtemplate" />
          <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $this->Itemid; ?>" />
        <?php echo JHTML::_( 'form.token' ); ?>        
        </form> 
        </div><!-- email main content wrapper closed -->

    </div><!-- content closed -->
</div><!-- main wrapper closed -->
				
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
