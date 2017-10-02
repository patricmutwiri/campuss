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
$big_field_width = 40;
$med_field_width = 25;
$sml_field_width = 15;
JHTML::_('behavior.formvalidation');
?>
<div id="js_jobs_main_wrapper">
<div id="js_menu_wrapper">
    <?php
    if (sizeof($this->jobseekerlinks) != 0) {
        foreach ($this->jobseekerlinks as $lnk) {
            ?>                     
            <a class="js_menu_link <?php if ($lnk[2] == 'job') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
            <?php
        }
    }
    if (sizeof($this->employerlinks) != 0) {
        foreach ($this->employerlinks as $lnk) {
            ?>
            <a class="js_menu_link <?php if ($lnk[2] == 'job') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
            <?php
        }
    }
    ?>
</div>
<?php
if ($this->config['offline'] == '1') {
    $this->jsjobsmessages->getSystemOfflineMsg($this->config);
} else {
    ?>
    <script language="javascript">
        function myValidate(f) {
            if (document.formvalidator.isValid(f)) {
                f.check.value = '<?php if (JVERSION < 3)
        echo JUtility::getToken();
    else
        echo JSession::getFormToken();
    ?>';//send token
            } else {
                alert('<?php echo JText::_("Some values are not acceptable, please retry"); ?>');
                return false;
            }
            return true;
        }

    </script>
    <?php
    if(isset($this->coverletter->id)){
        $heading = JText::_("Edit Cover Letter");
    }else{
        $heading = JText::_("Form Cover Letter");
    } ?>
    <div id="jsjobs-main-wrapper">
        <span class="jsjobs-main-page-title"><?php echo $heading; ?></span>
    <?php    
    if ($this->canaddnewcoverletter == VALIDATE) {    // add new coverletter, in edit case always 1
        ?>
        	<form action="index.php" method="post" name="adminForm" id="adminForm" class="form-validate jsautoz_form" onSubmit="return myValidate(this);">
                <div class="jsjobs-field-main-wrapper">
    	        	<div id="jsjobs-field-wrapper-title">
    	        		<div class="jsjobs-field">
    	        			<label id="titlemsg" for="title"><?php echo JText::_('Title'); ?><font id="font" color="red">*</font></label>
    	        		</div>
    	        		<div class="jsjobs-value">
    	        			<input class="inputbox required" type="text" name="title" id="title" size="<?php echo $big_field_width; ?>" maxlength="250" value = "<?php if (isset($this->coverletter)) echo $this->coverletter->title; ?>" />
    	        		</div>
    	        	</div>
    	        	<div id="jsjobs-field-wrapper-description">
    	        		<div class="jsjobs-field">
    	        			<label id="descriptionmsg" for="description"><?php echo JText::_('Description'); ?><font color="red">*</font></label>
    	        		</div>
    	        		<div class="jsjobs-value">
    	        			<textarea class="inputbox required" name="description" id="description" cols="60" rows="9"><?php if (isset($this->coverletter)) echo $this->coverletter->description; ?></textarea>
    	        		</div>
    	        	</div>
                    <div class="jsjobs-jobsalertinfo-save-btn">
                        <input type="submit" id="button" class="button jsjobs_button" value="<?php echo JText::_('Save Cover Letter'); ?>"/>
    	        	</div>
                </div>
                <?php
                if (isset($this->coverletter)) {
                    if (($this->coverletter->created == '0000-00-00 00:00:00') || ($this->coverletter->created == ''))
                        $curdate = date('Y-m-d H:i:s');
                    else
                        $curdate = $this->coverletter->created;
                } else
                    $curdate = date('Y-m-d H:i:s');
                ?>                
                <input type="hidden" name="created" value="<?php echo $curdate; ?>" />
                <input type="hidden" name="id" value="<?php if (isset($this->coverletter)) echo $this->coverletter->id; ?>" />
                <input type="hidden" name="layout" value="empview" />
                <input type="hidden" name="uid" value="<?php echo $this->uid; ?>" />
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" name="task" value="savecoverletter" />
                <input type="hidden" name="c" value="coverletter" />
                <input type="hidden" name="check" value="" />
                <input type="hidden" name="Itemid" value="<?php echo $this->Itemid; ?>" />
		        <?php if (isset($this->packagedetail[0])) echo '<input type="hidden" name="packageid" value="' . $this->packagedetail[0] . '" />'; ?>
		        <?php if (isset($this->packagedetail[1])) echo '<input type="hidden" name="paymenthistoryid" value="' . $this->packagedetail[1] . '" />'; ?>
                <?php echo JHTML::_( 'form.token' ); ?>      
            </form>	        	
        </div>
    <?php
    } else { // can not add new coverletter 
        switch ($this->canaddnewcoverletter) {
            case EMPLOYER_NOT_ALLOWED_JOBSEEKER_PRIVATE_AREA:
                $this->jsjobsmessages->getAccessDeniedMsg('Employer not allowed', 'Employer is not allowed in job seeker private area', 0);
                break;
            case NO_PACKAGE:
                $link = "index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=packages&Itemid=".$this->Itemid;
                $vartext = JText::_('Package is required to perform this action').','.JText::_('please get A package');
                $this->jsjobsmessages->getPackageExpireMsg('You do not have package', $vartext, $link);
                break;
            case EXPIRED_PACKAGE:
                $link = "index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=packages&Itemid=".$this->Itemid;
                $vartext = JText::_('Package is required to perform this action and your current package is expired').','.JText::_('please get new package');
                $this->jsjobsmessages->getPackageExpireMsg('Your current package is expired', $vartext, $link);
                break;
            case COVER_LETTER_LIMIT_EXCEEDS:
                $link = "index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=packages&Itemid=".$this->Itemid;
                $vartext = JText::_('You can not add new cover letter'). ',' .JText::_('Please get package to extend your cover letter limit');
                $this->jsjobsmessages->getPackageExpireMsg('Cover letter limit exceeds',$vartext, $link);
                break;
            case USER_ROLE_NOT_SELECTED:
                $link = "index.php?option=com_jsjobs&c=common&view=common&layout=new_injsjobs&Itemid=".$this->Itemid;
                $vartext = JText::_('You do not select your role').','.JText::_('Please select your role');
                $this->jsjobsmessages->getUserNotSelectedMsg('You do not select your role',$vartext, $link);
                break;
            case VISITOR_NOT_ALLOWED_JOBSEEKER_PRIVATE_AREA:
                $this->jsjobsmessages->getAccessDeniedMsg('You are not Logged in', 'Please login to access private area', 1);
                break;
        }
    }
}//ol
?>		
<!-- <div id="jsjobsfooter" class="hidden">
    <table width="100%" style="table-layout:fixed;">
        <tr><td height="15"></td></tr>
        <tr>
            <td style="vertical-align:top;" align="center">
                <a class="img" target="_blank" href="http://www.joomsky.com"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png"></a>
                <br>
                Copyright &copy; 2008 - <?php echo  date('Y') ?> ,
                <span id="themeanchor"> <a class="anchor"target="_blank" href="http://www.burujsolutions.com">Buruj Solutions</a></span>
            </td>
        </tr>
    </table>
</div> -->
</div>
