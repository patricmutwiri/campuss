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
    <div id="jsjobs-main-wrapper">
        <span class="jsjobs-main-page-title"><?php echo JText::_('Department Information'); ?></span>
    <?php
    if (isset($this->department)) { ?>
            <div class="js_jobs_data_wrapper">
                <span class="js_jobs_data_title"><?php echo JText::_('Name'); ?>:</span>
                <span class="js_jobs_data_value"><?php echo $this->department->name; ?></span>
            </div>
            <div class="js_jobs_data_wrapper">
                <span class="js_jobs_data_title"><?php echo JText::_('Company'); ?>:</span>
                <span class="js_jobs_data_value">
                    <?php
                    $companyaliasid = ($this->isjobsharing != "") ? $this->department->scompanyaliasid : $this->department->companyaliasid;
                    $companyaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($companyaliasid);
                    $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=view_company&nav=31&cd=' . $companyaliasid . '&Itemid=' . $this->Itemid;
                    ?>
                    <a href="<?php echo $link ?>"><?php echo $this->department->companyname; ?></a>
                </span>
            </div>
            <div class="jsjobs-description-area">
                <span class="js_jobs_description_section_title"><?php echo JText::_('Description'); ?>:</span>
                <div class="js_jobs_full_width_data"><?php echo $this->department->description; ?></div>
            </div>
    <?php } else { 
            $this->jsjobsmessages->getAccessDeniedMsg('Could not find any matching results', 'Could not find any matching results', 0);
        } ?>
        </div>
        <?php

}//ol
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