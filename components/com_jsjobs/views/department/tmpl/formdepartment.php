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
    $document->addScript('components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}
?>
<div id="js_jobs_main_wrapper">
<div id="js_menu_wrapper">
    <?php
    if (sizeof($this->jobseekerlinks) != 0) {
        foreach ($this->jobseekerlinks as $lnk) {
            ?>                     
            <a class="js_menu_link <?php if ($lnk[2] == 'coverletter') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
            <?php
        }
    }
    if (sizeof($this->employerlinks) != 0) {
        foreach ($this->employerlinks as $lnk) {
            ?>
            <a class="js_menu_link <?php if ($lnk[2] == 'coverletter') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
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
                is_tinyMCE_active = false;
                if (typeof(tinyMCE) != "undefined") {
                    if(tinyMCE.editors.length > 0){
                        is_tinyMCE_active = true;
                    }
                }
                if(is_tinyMCE_active == true){
                    var content = tinyMCE.get('description').getContent();
                    content = content.trim();
                    if(content == '' || content == null){
                        alert('<?php echo JText::_('Some values are not acceptable').'. '.JText::_('Please retry'); ?>');
                        return false;
                    }
                }
                f.check.value = '<?php if (JVERSION < 3) echo JUtility::getToken(); else echo JSession::getFormToken(); ?>';//send token
            } else {
                alert('<?php echo JText::_('Some values are not acceptable').'. '.JText::_('Please retry'); ?>');
                return false;
            }
            return true;
        }

    </script>
    <?php
        if (isset($this->department->id)) {
           $heading = "Edit Department Information";
        }else{
           $heading = "Department Information";
        }    
    ?>  
        <div id="jsjobs-main-wrapper">
            <span class="jsjobs-main-page-title"><?php echo JText::_("$heading"); ?></span>
    <?php
        if ($this->formdepartment_allowed == VALIDATE) { // employer
        ?>
        <!-- Your Area starts here -->        
            <div class="jsjobs-folderinfo">
            <form action="index.php" method="post" name="adminForm" id="adminForm" class="jsautoz_form" onSubmit="return myValidate(this);">
                <div class="fieldwrapper">
                    <div class="fieldtitle">
                        <label id="companyidmsg" for="companyid"><?php echo JText::_('Company'); ?>&nbsp;<font color="red">*</font></label>
                    </div>
                    <div class="fieldvalue">
                        <?php echo $this->lists['companies']; ?>
                    </div>
                </div>				        
                <div class="fieldwrapper">
                    <div class="fieldtitle">
                        <label id="namemsg" for="name"><?php echo JText::_('Department Name'); ?>&nbsp;<font color="red">*</font></label>
                    </div>
                    <div class="fieldvalue">
                        <input class="inputbox-required" type="text" name="name" id="name"  value="<?php if (isset($this->department)) echo $this->department->name; ?>" />
                    </div>
                </div>				        
                <div class="fieldwrapper">
                    <div class="fieldtitle">
                        <label id="descriptionmsg" for="description"><strong><?php echo JText::_('Description'); ?>&nbsp;<font color="red">*</font></strong></label>
                    </div>
                    <div class="fieldvalue">
                        <?php
                        $editor = JFactory::getEditor();
                        if (isset($this->department))
                            echo $editor->display('description', $this->department->description, '100%', '100%', '60', '20', false);
                        else
                            echo $editor->display('description', '', '100%', '100%', '60', '20', false);
                        ?>	
                    </div>
                </div>				        
                <div class="fieldwrapper-btn">
                    <div class="jsjobs-folder-info-btn">
                        <sapn class="jsjobs-folder-btn">
                    <input type="submit" id="button" class="button jsjobs_button" value="<?php echo JText::_('Save'); ?>"/>
                    </sapn>
                    </div>
                </div>

                <?php
                if (isset($this->department)) {
                    if (($this->department->created == '0000-00-00 00:00:00') || ($this->department->created == ''))
                        $curdate = date('Y-m-d H:i:s');
                    else
                        $curdate = $this->department->created;
                } else
                    $curdate = date('Y-m-d H:i:s');
                ?>
                <input type="hidden" name="check" value="" />
                <input type="hidden" name="created" value="<?php echo $curdate; ?>" />
                <input type="hidden" name="uid" value="<?php echo $this->uid; ?>" />
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" name="task" value="savedepartment" />
                <input type="hidden" name="c" value="department" />
                <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $this->Itemid; ?>" />
                <input type="hidden" name="id" value="<?php if (isset($this->department)) echo $this->department->id; ?>" /> 
                 <?php echo JHTML::_( 'form.token' ); ?>     
            </form>
            </div>
<!-- End your area -->
        <?php
    } else {
        switch ($this->formdepartment_allowed) {
            case JOBSEEKER_NOT_ALLOWED_EMPLOYER_PRIVATE_AREA:
                $this->jsjobsmessages->getAccessDeniedMsg('Job seeker not allowed', 'Job seeker is not allowed in employer private area', 0);
                break;
            case USER_ROLE_NOT_SELECTED:
                $link = "index.php?option=com_jsjobs&c=common&view=common&layout=new_injsjobs&Itemid=".$this->Itemid;
                $vartext = JText::_('You do not select your role').','.JText::_('Please select your role');
                $this->jsjobsmessages->getUserNotSelectedMsg('You do not select your role', $vartext, $link);
                break;
            case VISITOR_NOT_ALLOWED_EMPLOYER_PRIVATE_AREA:
                $this->jsjobsmessages->getAccessDeniedMsg('You are not logged in', 'Please login to access private area', 1);
                break;
        }
    } ?>
    </div>
<?php
}
?>
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

</div>
