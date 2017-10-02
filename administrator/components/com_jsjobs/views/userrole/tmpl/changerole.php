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
?>

<script type="text/javascript">
// for joomla 1.6
    Joomla.submitbutton = function (task) {
        if (task == '') {
            return false;
        } else {
            if (task == 'userrole.save') {
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
            alert('Some values are not acceptable.  Please retry.');
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
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=userrole&view=userrole&layout=users"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Users'); ?></span></div>

<?php if(!empty($this->role)){ ?>
       <form action="index.php" method="POST" name="adminForm" id="adminForm" >
                <div class="js-usercontent">
                         
                    <div class="js-lineusercontent">
                        <span class="js-spansize1"><label id="titlemsg" for="title"><b><?php echo JText::_('Name'); ?> : </b></label></span>
                        <span class="js-spansize2"><?php if (isset($this->role)) echo $this->role->name; ?></span>
                    </div> 
                    <div class="js-lineusercontent">
                        <span class="js-spansize1"><label><b><?php echo JText::_('Username'); ?> : </b></label></span>
                        <span class="js-spansize2"><?php if (isset($this->role)) echo $this->role->username; ?></span>
                    </div> 
                    <div class="js-lineusercontent">
                        <?php
                            $img = $this->role->block ? 'cross.png' : 'tick2.png';
                            $task = $this->role->block ? 'unblock' : 'block';
                            $alt = $this->role->block ? JText::_('Enabled') : JText::_('Blocked');
                            ?>
                        <span class="js-spansize1"><label><b><?php echo JText::_('Enabled'); ?> : </b></label></span>
                        <span class="js-spansize2"><img src="components/com_jsjobs/include/images/<?php echo $img; ?>" width="16" height="16" border="0"  /></span>
                    </div> 
                    <div class="js-lineusercontent">
                        <span class="js-spansize1"><label><b><?php echo JText::_('Group'); ?> : </b></label></span>
                        <span class="js-spansize2"><?php if (isset($this->role)) echo $this->role->groupname; ?></span>
                    </div> 
                    <div class="js-lineusercontent">
                        <span class="js-spansize1"><label><b><?php echo JText::_('Id'); ?> : </b></label></span>
                        <span class="js-spansize2"><?php if (isset($this->role)) echo $this->role->id; ?></span>
                    </div> 
                    <div class="js-lineusercontent">
                        <span class="js-spansize1"><label><b><?php echo JText::_('Role'); ?> : </b></label></span>
                        <span class="js-spansize2"><?php echo $this->lists['roles']; ?></span>
                    </div> 
                </div>
                <?php
                if (isset($this->role)) {
                    if (($this->role->dated == '0000-00-00 00:00:00') || ($this->role->dated == ''))
                        $curdate = date('Y-m-d H:i:s');
                    else
                        $curdate = $this->role->dated;
                }else {
                    $curdate = date('Y-m-d H:i:s');
                }
                ?>
                <input type="hidden" name="dated" value="<?php echo $curdate; ?>" />
                <input type="hidden" name="id" value="<?php if (isset($this->role)) echo $this->role->userroleid; ?>" />
                <input type="hidden" name="uid" value="<?php if (isset($this->role)) echo $this->role->id; ?>" />
                <input type="hidden" name="check" value="" />
                <input type="hidden" name="task" value="userrole.saveuserrole" />
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />



            <div class="js-buttons-area">
                <a class="js-btn-cancel" href="index.php?option=com_jsjobs&c=userrole&view=userrole&layout=users"><?php echo JText::_('Cancel'); ?></a>
                <input type="submit" class="js-btn-save" name="submit_app" onclick="return validate_form(document.adminForm)" value="<?php echo JText::_('Save User Role'); ?>" />
            </div>
            </form>

<?php }else{ JSJOBSlayout::getNoRecordFound(); } ?>
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




