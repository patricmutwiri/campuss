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

JHTML::_('behavior.calendar');
JHTML::_('behavior.formvalidation');
?>

<script language="javascript">
// for joomla 1.6
    Joomla.submitbutton = function (task) {
        if (task == '') {
            return false;
        } else {
            if (task == 'department.savedepatrment') {
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
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=department&view=department&layout=departments"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a>
        <?php if (isset($this->department->id)){ ?>
        <span id="heading-text"><?php echo JText::_('Edit Department'); ?></span>
        <?php }else{ ?>
        <span id="heading-text"><?php echo JText::_('Form Department'); ?></span>
         <?php } ?>
        </div>
        <form action="index.php" method="post" name="adminForm" id="adminForm" >
        <div class="js-form-area">
            
            <input type="hidden" name="check" value="post"/>
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="companyid"><?php echo JText::_('Company'); ?>&nbsp;<font color="red">*</font></label>
                    <div class="jsjobs-value"><?php echo $this->lists['companies']; ?></div>
                </div>

                
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="name"><?php echo JText::_('Department Name'); ?>&nbsp;<font color="red">*</font></label>
                    <div class="jsjobs-value"><input class="inputbox required" type="text" name="name" id="name" size="20"  value="<?php if (isset($this->department)) echo $this->department->name; ?>" /></div>
                </div>
                
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="name"><?php echo JText::_('Description'); ?>&nbsp;<font color="red">*</font></label>
                    <div class="jsjobs-value"> <?php
                            $editor = JFactory::getEditor();
                            if (isset($this->department))
                                echo $editor->display('description', $this->department->description, '550', '300', '60', '20', false);
                            else
                                echo $editor->display('description', '', '550', '300', '60', '20', false);
                            ?></div>
                </div>

                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="status"><?php echo JText::_('Status'); ?></label>
                    <div class="jsjobs-value"><?php echo $this->lists['status']; ?></div>
                </div>

                <input type="hidden" name="id" value="<?php if (isset($this->department)) echo $this->department->id; ?>" />
                <input type="hidden" name="task" value="department.savedepatrment" />
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" name="uid" value="<?php if (isset($this->department))
                                echo $this->department->uid;
                            else
                                echo $this->uid;
                            ?>" />


                <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $this->Itemid; ?>" />
                <?php
                    $md = JRequest::getVar('md');
                    echo '<input type="hidden" name="md" value="'.$md.'" />';
                ?>
        </div>
        <div class="js-buttons-area">
            <a class="js-btn-cancel" href="index.php?option=com_jsjobs&c=department&view=department&layout=departments"><?php echo JText::_('Cancel'); ?></a>
            <input type="submit" class="js-btn-save" name="submit_app" onclick="return validate_form(document.adminForm)" value="<?php echo JText::_('Save Department'); ?>" />
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
