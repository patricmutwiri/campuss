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

$host = $_SERVER['HTTP_HOST'];
$self = $_SERVER['PHP_SELF'];
$url = "http://$host$self";
$document = JFactory::getDocument();

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<script>
    function opendiv() {
        document.getElementById('jsjob_installer_waiting_div').style.display = 'block';
        document.getElementById('jsjob_installer_waiting_span').style.display = 'block';
    }
</script>

<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
        <div id="jsjobs-heading"><span id="heading-text"><?php echo JText::_('Control Panel'); ?></span></div>
<!--  -->
<table width="100%">
    <tr>
        <td width="100%" valign="top">
            <div id="jsjobs_info_heading"><?php echo JText::_('Activate/updates'); ?></div> 
            <div id="jsjob_installer_msg">
                <?php echo JText::_('JS Jobs Installer'); ?>
            </div>
            <form action="index.php" method="POST" name="adminForm" id="adminForm">
                <div id="jsjob_installer_waiting_div" style="display:none;"></div>
                <span id="jsjob_installer_waiting_span" style="display:none;"><?php echo JText::_('Please wait installation in progress...'); ?></span>
                <div id="jsjob_installer_outerwrap">
                    <div id="jsjob_installer_leftimage">
                        <span id="jsjob_installer_leftimage_logo"></span>
                    </div>
                    <div id="jsjob_installer_wrap">
                        <span id="installer_text">
                            <?php echo JText::_('Please Fill The Form And Press Start'); ?>
                        </span>
                        <?php if (in_array('curl', get_loaded_extensions())) { ?>
                            <div id="jsjob_installer_formlabel">
                                <label id="transactionkeymsg" for="transactionkey"><?php echo JText::_('Activation Key'); ?></label>
                            </div>
                            <div id="jsjob_installer_forminput">
                                <input id="transactionkey" name="transactionkey" class="inputbox required" value="" />
                            </div>
                            <div id="jsjob_installer_formsubmitbutton">
                                <input type="submit" class="button" name="submit_app" id="jsjob_instbutton" onclick="return confirmcall();" value="<?php echo JText::_('Start'); ?>" />
                            </div>
                        <?php } else { ?>
                            <div id="jsjob_installer_warning"><?php echo JText::_('Warning'); ?>!</div>
                            <div id="jsjob_installer_warningmsg"><?php echo JText::_('Curl is not enable, please enable curl'); ?></div>
                        <?php } ?>
                    </div>
                </div>
                <div id="jsjob_installer_lowerbar">
                    <?php if (!in_array('curl', get_loaded_extensions())) { ?>
                        <span id="jsjob_installer_arrow"><?php echo JText::_('Reference Link'); ?></span>
                        <span id="jsjob_installer_link"><a href="http://devilsworkshop.org/tutorial/enabling-curl-on-windowsphpapache-machine/702/"><?php echo JText::_('Http://devilsworkshop.org/...'); ?></a></span>
                        <span id="jsjob_installer_link"><a href="http://www.tomjepson.co.uk/enabling-curl-in-php-php-ini-wamp-xamp-ubuntu/"><?php echo JText::_('Http://www.tomjepson.co.uk/...'); ?></a></span>
                        <span id="jsjob_installer_link"><a href="http://www.joomlashine.com/blog/how-to-enable-curl-in-php.html"><?php echo JText::_('Http://www.joomlashine.com/...'); ?></a></span>
                    <?php } else { ?>
                        <span id="jsjob_installer_mintmsg"><?php echo JText::_('It may take few minutes...'); ?></span>
                    <?php } ?>
                </div>

                <input type="hidden" name="check" value="" />
                <input type="hidden" name="domain" value="<?php echo JURI::root(); ?>" />
                <input type="hidden" name="producttype" value="pro" />
                <input type="hidden" name="count_config" value="<?php echo $this->count_config; ?>" />
                <input type="hidden" name="productcode" value="jsjobs" />
                <input type="hidden" name="productversion" value="<?php echo $this->configur[1]; ?>" />
                <input type="hidden" name="task" value="startupdate" />
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
            </form>
        </td>
    </tr>
</table>
<!--  -->
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





<script type="text/javascript">
// for joomla 1.6
    Joomla.submitbutton = function (task) {
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
    function confirmcall() {
        var result = confirm("<?php echo JText::_('All files override are you sure to continue'); ?>");
        if (result == true) {
            var r = validate_form(document.adminForm);
            return r;
        } else
            return false;
    }
    function validate_form(f)
    {
        if (document.formvalidator.isValid(f)) {
            f.check.value = '<?php if (JVERSION < 3)
                        echo JUtility::getToken();
                    else
                        echo JSession::getFormToken();
                    ?>';//send token
        }
        else {
            alert('Some values are not acceptable.  Please retry.');
            return false;
        }
        opendiv();
        return true;
    }
</script>
