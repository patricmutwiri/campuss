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
    window.addEvent('domready', function () {
        document.formvalidator.setHandler('salarayrangestart', function (value) {
            if (isNaN(value))
                return false;
            var rangeend = document.getElementById("rangeend").value;
            var rvalue = parseInt(rangeend);
            if (value > rvalue) {
                return false;
            }
            return true;
        });
    });

    window.addEvent('domready', function () {
        document.formvalidator.setHandler('salarayrangeend', function (value) {
            if (isNaN(value))
                return false;
            var rangestart = document.getElementById("rangestart").value;
            var rsvalue = parseInt(rangestart);
            if (value < rsvalue) {
                return false;
            }
            return true;
        });
    });



// for joomla 1.6
    Joomla.submitbutton = function (task) {
        if (task == '') {
            return false;
        } else {
            if (task == 'salaryrange.savejobsalaryrangesave' || task == 'salaryrange.savejobsalaryrangeandnew' || task == 'salaryrange.savejobsalaryrange') {
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
            f.check.value = '<?php if (JVERSION < 3)
    echo JUtility::getToken();
else
    echo JSession::getFormToken();
?>';//send token
        }
        else {
            var msg = new Array();
            msg.push('<?php echo JText::_('Some values are not acceptable, please retry'); ?>');
            var element_rangestart = document.getElementById('rangestart');
            if (hasClass(element_rangestart, 'invalid')) {
                msg.push('<?php echo JText::_('Salary range start must be less than salary range end'); ?>');
            }
            var element_rangeend = document.getElementById('rangeend');
            if (hasClass(element_rangeend, 'invalid')) {
                msg.push('<?php echo JText::_('Salary range end must be greater than salary range start'); ?>');
            }
            alert(msg.join('\n'));
            return false;
        }
        return true;
    }
    function hasClass(el, selector) {
        var className = " " + selector + " ";

        if ((" " + el.className + " ").replace(/[\n\t]/g, " ").indexOf(className) > -1) {
            return true;
        }
        return false;
    }

</script>




<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=salaryrange&view=salaryrange&layout=salaryrange"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a>
            <?php if (isset($this->application->id)){ ?>
            <span id="heading-text"><?php echo JText::_('Edit Salary Range'); ?></span>
            <?php }else{ ?>
            <span id="heading-text"><?php echo JText::_('Form Salary Range'); ?></span>
            <?php } ?>
        </div>
        <form action="index.php" method="POST" name="adminForm" id="adminForm" >
            <div class="js-form-area">
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="rangestart"><?php echo JText::_('Salary Range Start'); ?> :</label>
                    <div class="jsjobs-value"><input class="inputbox required validate-salarayrangestart" type="text" name="rangestart" id="rangestart" size="40" maxlength="255" value="<?php if (isset($this->application)) echo $this->application->rangestart; ?>" /></div>
                </div>

                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="rangeend"><?php echo JText::_('Salary Range End'); ?> :</label>
                    <div class="jsjobs-value"><input class="inputbox required validate-salarayrangeend" type="text" name="rangeend" id="rangeend" size="40" maxlength="255" value="<?php if (isset($this->application)) echo $this->application->rangeend; ?>" /></div>
                </div>

                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="status"><?php echo JText::_('Status'); ?></label>
                    <div class="jsjobs-value"><div class="div-white"><span class="js-cross"><input id="status" type="checkbox" name="status" value="1" <?php
                                                     if (isset($this->application)) {
                                                         if ($this->application->status == '1')
                                                             echo 'checked';
                                                     }else{
                                                        echo 'checked';
                                                     }
?>/></span> <label class="js-publish" for="status" ><?php echo JText::_('Publish'); ?></label>
                                                     </div>
                    </div>
                </div>

                <input type="hidden" name="id" value="<?php if (isset($this->application)) echo $this->application->id; ?>" />
                <input type="hidden" name="isdefault" value="<?php if (isset($this->application)) echo $this->application->isdefault; ?>" />
                <input type="hidden" name="ordering" value="<?php if (isset($this->application)) echo $this->application->ordering; ?>" />

                <input type="hidden" name="check" value="" />
                <input type="hidden" name="task" value="salaryrange.savejobsalaryrange" />
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />



            </div>
            <div class="js-buttons-area">
                <a class="js-btn-cancel" href="index.php?option=com_jsjobs&c=salaryrange&view=salaryrange&layout=salaryrange"><?php echo JText::_('Cancel'); ?></a>
                <input type="submit" class="js-btn-save" name="submit_app" onclick="return validate_form(document.adminForm)" value="<?php echo JText::_('Save Salary Range'); ?>" />
            </div>
            <?php echo JHTML::_( 'form.token' ); ?>        
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



