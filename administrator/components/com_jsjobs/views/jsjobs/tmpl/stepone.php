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
                <div class="update-header-img step-1">
                    <div class="header-parts first-part">
                        <span class="text"><?php echo JText::_('Configuration'); ?></span>
                        <span class="text-no">1</span>
                        <img src="components/com_jsjobs/include/images/update-header-1.png" />
                    </div>
                    <div class="header-parts second-part">
                        <span class="text"><?php echo JText::_('Permissions'); ?></span>
                        <span class="text-no">2</span>
                        <img src="components/com_jsjobs/include/images/update-header-3.png" />
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
                        <span class="title"><?php echo JText::_('PHP Version'); ?></span>
                        <span class="recommended"><?php echo JText::_('5.0'); ?></span>
                        <span class="current "><?php echo $this->phpversion; ?></span>
                    </div>
                    <?php if($this->phpversion < 5.0){?>
                        <span class="error-span"><?php echo JText::_('PHP version lower than recommended') ?>.</span>
                    <?php }?>
                    <div class="js_data_bar">
                        <span class="title"><?php echo JText::_('ZIP Library'); ?></span>
                        <span class="recommended"><img src="components/com_jsjobs/include/images/hired-new.png" /></span>
                        <span class="current <?php echo ($this->zip_lib == 0) ? 'invalid': 'valid'; ?>"><?php $src = ($this->zip_lib == 1) ? 'hired-new.png' : 'reject-s.png'; ?><img src="components/com_jsjobs/include/images/<?php echo $src;?>"/></span>
                    </div>
                    <?php if($src == 'reject-s.png'){?>
                        <span class="error-span"><?php echo JText::_('ZIP library does not exist') ?>.</span>
                    <?php }?>
                    <div class="js_data_bar">
                        <span class="title"><?php echo JText::_('GD Library'); ?></span>
                        <span class="recommended"><img src="components/com_jsjobs/include/images/hired-new.png" /></span>
                        <span class="current <?php echo ($this->gd_lib == 0) ? 'invalid': 'valid'; ?>"><?php $src = ($this->gd_lib == 1) ? 'hired-new.png' : 'reject-s.png'; ?><img src="components/com_jsjobs/include/images/<?php echo $src;?>" /></span>
                    </div>
                    <?php if($src == 'reject-s.png'){?>
                        <span class="error-span"><?php echo JText::_('GD library does not exist') ?>.</span>
                    <?php }?>
                    <div class="js_data_bar">
                        <span class="title"><?php echo JText::_('CURL Library'); ?></span>
                        <span class="recommended"><img src="components/com_jsjobs/include/images/hired-new.png" /></span>
                        <span class="current <?php echo ($this->curlexist == 0) ? 'invalid': 'valid'; ?>"><?php $src = ($this->curlexist == 1) ? 'hired-new.png' : 'reject-s.png'; ?><img src="components/com_jsjobs/include/images/<?php echo $src;?>"/></span>
                    </div>
                    <?php if($src == 'reject-s.png'){?>
                        <span class="error-span"><?php echo JText::_('CURL does not exist') ?>.</span>
                    <?php }?>
                    <?php if($this->phpversion > 5.0 && $this->zip_lib == 1 && $this->gd_lib == 1 && $this->curlexist == 1){ ?>
                        <div class="js_button_wrapper">
                            <input class="js_next_button" type="submit" value="<?php echo JText::_('Next Step'); ?>" onclick="return validate_form(document.adminForm);" />
                        </div>
                    <?php } ?>
                </div>
            </div>
            <input type="hidden" name="check" value="" />
            <input type="hidden" name="c" value="jsjobs" />
            <input type="hidden" name="view" value="jsjobs" />
            <input type="hidden" name="layout" value="steptwo" />
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
