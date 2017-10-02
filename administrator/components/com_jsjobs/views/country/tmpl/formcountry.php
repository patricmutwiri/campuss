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
JHTML::_('behavior.formvalidation');
?>

<script type="text/javascript">
// for joomla 1.6
    Joomla.submitbutton = function (task) {
        if (task == '') {
            return false;
        } else {
            if (task == 'country.savecountry') {
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
        }
        else {
            alert('<?php echo JText::_('Some values are not acceptable').'. '.JText::_('Please retry'); ?>');
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
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=country&view=country&layout=countries"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a>
        <?php if (isset($this->country->id)){ ?>
        <span id="heading-text"><?php echo JText::_('Edit Country'); ?></span>
        <?php }else{ ?>
        <span id="heading-text"><?php echo JText::_('Form Country'); ?></span>
         <?php } ?>
        </div>
         <form action="index.php" method="POST" name="adminForm" id="adminForm" >
            <div class="js-form-area">
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="title"><?php echo JText::_('Title'); ?></label>
                    <div class="jsjobs-value"><input class="inputbox required" type="text" id="title" name="name" size="40" maxlength="255" value="<?php if (isset($this->country)) echo $this->country->name; ?>" /></div>
                </div>
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="status"><?php echo JText::_('Status'); ?></label>
                    <div class="jsjobs-value"><div class="div-white"><span class="js-cross"><input type="checkbox" name="enabled" id="status"value="1" <?php
                                                     if (isset($this->country)) {
                                                         if ($this->country->enabled == '1')
                                                             echo 'checked';
                                                     }else{
                                                        echo 'checked';
                                                     }
?>/></span> <label class="js-publish" for="status" ><?php echo JText::_('Publish'); ?></label>
                                                     </div>
                    </div>
                </div>

                <input type="hidden" name="id" value="<?php if (isset($this->country)) echo $this->country->id; ?>" />
                <input type="hidden" name="check" value="" />
                <input type="hidden" name="task" value="country.savecountry" />
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <?php echo JHTML::_( 'form.token' ); ?>        
            </div>
            <div class="js-buttons-area">
                <a class="js-btn-cancel" href="index.php?option=com_jsjobs&c=country&view=country&layout=countries"><?php echo JText::_('Cancel'); ?></a>
                <input type="submit" class="js-btn-save" name="submit_app" onclick="return validate_form(document.adminForm)" value="<?php echo JText::_('Save Country'); ?>" />
            </div>
        </form>
    </div>
</div>
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



