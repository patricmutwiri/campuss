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
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
// for joomla 1.6
    Joomla.submitbutton = function(task) {
        if (task == '') {
            return false;
        } else {
            if (task == 'startinstallation') {
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
            f.check.value = '<?php if (JVERSION < 3) echo JUtility::getToken(); else echo JSession::getFormToken(); ?>';//send token
        }
        else {
            alert('Some values are not acceptable.  Please retry.');
            return false;
        }
        opendiv();
        return true;
    }
</script>
<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>
    <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=controlpanel"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Update'); ?></span></div>
        <form action="index.php" method="POST" name="adminForm" id="adminForm" >
    <div class="js_installer_wrapper">
        <div class="update-header-img step-2">
            <div class="header-parts first-part">
                <span class="text"><?php echo JText::_('Configuration'); ?></span>
                <span class="text-no">1</span>
                <img src="components/com_jsjobs/include/images/update-header-2.png" />
            </div>
            <div class="header-parts second-part">
                <span class="text"><?php echo JText::_('Permissions'); ?></span>
                <span class="text-no">2</span>
                <img src="components/com_jsjobs/include/images/update-header-1.png" />
            </div>
            <div class="header-parts third-part">
                <span class="text"><?php echo JText::_('Install'); ?></span>
                <span class="text-no">3</span>
                <img src="components/com_jsjobs/include/images/update-header-3.png" />
            </div>
            <div class="header-parts fourth-part">
                <span class="text"><?php echo JText::_('Finish'); ?></span>
                <span class="text-no">4</span>
                <img src="components/com_jsjobs/include/images/update-header-3.png" />
            </div>
        </div>
        <div class="installer-bottom-part">
            <div class="js_header_bar"><?php echo JText::_('Quick Configuration');?></div>
            <div class="js_heading_bar">
                <span class="title"><?php echo JText::_('Settings'); ?></span>
                <span class="recommended"><?php echo JText::_('Recommended'); ?></span>
                <span class="current"><?php echo JText::_('Current'); ?></span>
            </div>
            <div class="js_data_bar">
                <span class="title"><?php echo JText::_('Admin Directory'); ?></span>
                <span class="recommended"><?php echo JText::_('Writable'); ?></span>
                <span class="current <?php echo ($this->result['admin_dir'] < 755) ? 'invalid': 'valid'; ?>"><?php $msg = ($this->result['admin_dir'] < 755) ? JText::_('Not Writable') : JText::_('Writable'); ?><?php echo $msg;?></span>
            </div>
            <?php if($msg == 'Not Writable'){?>
                <span class="error-span"><?php echo JText::_('Directory permissions error').'&nbsp;(&nbsp'. JPATH_ADMINISTRATOR .'&nbsp)&nbsp;'. JText::_('directory is not writable') ?>.</span>
            <?php }?>
            <div class="js_data_bar">
                <span class="title"><?php echo JText::_('Site Directory'); ?></span>
                <span class="recommended"><?php echo JText::_('Writable'); ?></span>
                <span class="current <?php echo ($this->result['site_dir'] < 755) ? 'invalid': 'valid'; ?>"><?php $msg = ($this->result['site_dir'] < 755) ? JText::_('Not Writable') : JText::_('Writable'); ?><?php echo $msg;?></span>
            </div>
            <?php if($msg == 'Not Writable'){?>
                <span class="error-span"><?php echo JText::_('Directory permissions error').'&nbsp;(&nbsp'. JPATH_SITE .'&nbsp)&nbsp;'. JText::_('directory is not writable') ?>.</span>
            <?php }?>
            <div class="js_data_bar">
                <span class="title"><?php echo JText::_('Tmp Directory'); ?></span>
                <span class="recommended"><?php echo JText::_('Writable'); ?></span>
                <span class="current <?php echo ($this->result['tmp_dir'] < 755) ? 'invalid': 'valid'; ?>"><?php $msg = ($this->result['tmp_dir'] < 755) ? JText::_('Not Writable') : JText::_('Writable'); ?><?php echo $msg;?></span>
            </div>
            <?php
                $tempflag = 1;
             if($msg == 'Not Writable'){
                $tempfalg = 0;?>
                
                <span class="error-span"><?php echo JText::_('Directory permissions error').'&nbsp;(&nbsp'. JPATH_SITE .'/tmp'  .'&nbsp)&nbsp;'. JText::_('directory is not writable') ?>.</span>
            <?php }?>
            <div class="js_data_bar">
                <span class="title"><?php echo JText::_('Create Database Table'); ?></span>
                <span class="recommended"><img src="components/com_jsjobs/include/images/hired-new.png" /></span>
                <span class="current <?php echo ($this->result['create_table'] == 0) ? 'invalid': 'valid'; ?>"><?php $src = ($this->result['create_table'] == 1) ? 'hired-new.png':'reject-s.png'; ?><img src="components/com_jsjobs/include/images/<?php echo $src?>" /></span>
            </div>
            <?php if($src == 'reject-s.png'){?>
                <span class="error-span"><?php echo JText::_('System unable to create database table').'. '.JText::_('Please make sure your database user have create table permissions'); ?>.</span>
            <?php }?>
            <div class="js_data_bar">
                <span class="title"><?php echo JText::_('Insert Record Into Table'); ?></span>
                <span class="recommended"><img src="components/com_jsjobs/include/images/hired-new.png" /></span>
                <span class="current <?php echo ($this->result['insert_record'] == 0) ? 'invalid': 'valid'; ?>"><?php $src = ($this->result['insert_record'] == 1) ? 'hired-new.png':'reject-s.png'; ?><img src="components/com_jsjobs/include/images/<?php echo $src?>" /></span>
            </div>
            <?php if($src == 'reject-s.png'){?>
                <span class="error-span"><?php echo JText::_('System unable to insert record into table').'. '.JText::_('Please make sure your database user have inserting permissions'); ?>.</span>
            <?php }?>
            <div class="js_data_bar">
                <span class="title"><?php echo JText::_('Update Record In Table'); ?></span>
                <span class="recommended"><img src="components/com_jsjobs/include/images/hired-new.png" /></span>
                <span class="current <?php echo ($this->result['update Record'] == 0) ? 'invalid': 'valid'; ?>"><?php $src = ($this->result['update_record'] == 1) ? 'hired-new.png':'reject-s.png'; ?><img src="components/com_jsjobs/include/images/<?php echo $src?>" /></span>
            </div>
            <?php if($src == 'reject-s.png'){?>
                <span class="error-span"><?php echo JText::_('System unable to update record into table').'. '.JText::_('Please make sure your database user have update permissions'); ?>.</span>
            <?php }?>
            <div class="js_data_bar">
                <span class="title"><?php echo JText::_('Delete Record In Table'); ?></span>
                <span class="recommended"><img src="components/com_jsjobs/include/images/hired-new.png" /></span>
                <span class="current <?php echo ($this->result['delete Record'] == 0) ? 'invalid': 'valid'; ?>"><?php $src = ($this->result['delete_record'] == 1) ? 'hired-new.png':'reject-s.png'; ?><img src="components/com_jsjobs/include/images/<?php echo $src?>" /></span>
            </div>
            <?php if($src == 'reject-s.png'){?>
                <span class="error-span"><?php echo JText::_('System unable to delete record into table').'. '.JText::_('Please make sure your database user have delete permissions'); ?>.</span>
            <?php }?>
            <div class="js_data_bar">
                <span class="title"><?php echo JText::_('Drop Database Table'); ?></span>
                <span class="recommended"><img src="components/com_jsjobs/include/images/hired-new.png" /></span>
                <span class="current <?php echo ($this->result['drop_table'] == 0) ? 'invalid': 'valid'; ?>"><?php $src = ($this->result['drop_table'] == 1) ? 'hired-new.png':'reject-s.png'; ?><img src="components/com_jsjobs/include/images/<?php echo $src?>" /></span>
            </div>
            <?php if($src == 'reject-s.png'){?>
                <span class="error-span"><?php echo JText::_('System unable to drop database table').'. '.JText::_('Please make sure your database user have drop table permissions'); ?>.</span>
            <?php }?>
            <div class="js_data_bar">
                <span class="title"><?php echo JText::_('File Download Using CURL'); ?></span>
                <span class="recommended"><img src="components/com_jsjobs/include/images/hired-new.png" /></span>
                <span class="current <?php echo ($this->result['file_downloaded'] == 0) ? 'invalid': 'valid'; ?>"><?php $src = ($this->result['file_downloaded'] == 1) ? 'hired-new.png':'reject-s.png'; ?><img src="components/com_jsjobs/include/images/<?php echo $src?>" /></span>
            </div>
            <?php if($src == 'reject-s.png'){?>
                <span class="error-span"><?php 
                if($tempflag!=1){
                     echo JText::_('Directory permissions error').'&nbsp;(&nbsp'. JPATH_SITE .'/tmp'  .'&nbsp)&nbsp;'. JText::_('directory is not writable') ;
                }else{
                    echo JText::_('CURL in not enabled').'. '.JText::_('System unable to download file').'. '.JText::_('Please make sure you have enabled CURL library'); 
                    }?>.</span>
        </div>

            <?php }?>
        <?php 
            if($this->result['admin_dir'] >= 755 && $this->result['site_dir'] >= 755 && $this->result['tmp_dir'] >= 755 && $this->result['file_downloaded'] == 1 && $this->result['create_table'] == 1 && $this->result['insert_record'] == 1 && $this->result['update_record'] == 1 && $this->result['delete_record'] == 1 && $this->result['drop_table'] == 1){
        ?>
        <div class="js_button_wrapper">
            <input class="js_next_button" type="submit" value="<?php echo JText::_('Next Step'); ?>" onclick="return validate_form(document.adminForm);" />
        </div>
        <?php 
        } 
        ?>
    </div>
    <input type="hidden" name="check" value="" />
    <input type="hidden" name="c" value="jsjobs" />
    <input type="hidden" name="view" value="jsjobs" />
    <input type="hidden" name="layout" value="stepthree" />
    <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
</form>

    </div>
</div>
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
