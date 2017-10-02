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
$document = JFactory::getDocument();
jimport('joomla.html.pane');
JHTML::_('behavior.formvalidation');
JHTML::_('behavior.modal');
if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('../components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}
?>

<script type="text/javascript">
// for joomla 1.6
    Joomla.submitbutton = function (task) {
        if (task == '') {
            return false;
        } else {
            if (task == 'paymenthistory.save') {
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
            <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=paymenthistory&view=paymenthistory&layout=employerpaymenthistory"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Payment History Details'); ?></span></div>
        <form action="index.php" method="POST" name="adminForm" id="adminForm" >
            <div class="jsjobs-content-area">
                
                    <?php
                    $td = array('row0', 'row1');
                    $k = 0;
                    //$td=array('','');
                    $userlink = 'index.php?option=com_jsjobs&c=user&view=user&layout=users&tmpl=component&task=preview';
                    ?>
                    <div class="<?php echo $td[$k];
                    $k = 1 - $k;
                    ?>">
                        <label id="usernamemsg" for="username"><?php echo JText::_('User Name'); ?><font color="red">*</font> </label>
                        
                            <input  class="inputbox required" type="text" name="username" id="username" value="<?php
                            if (isset($this->user)) {
                                echo $this->user->username;
                            } else {
                                echo "";
                            }
                    ?>" />
                            <a class="modal" rel="{handler: 'iframe', size: {x: 870, y: 350}}" id="" href="<?php echo $userlink; ?>"><?php echo JText::_('Select User') ?></a>
                       
                    </div>
                    <div class="<?php echo $td[$k];
                        $k = 1 - $k;
                    ?>">
                        <label id="userpackagemsg" for="packageid"><?php echo JText::_('Package'); ?><font color="red">*</font></label>
                        <div id="package">
                        </div>
                    </div>
                    <div><div></div></div>
            </div>
                    <div class="js-buttons-area">
                        <a class="js-btn-cancel" href="index.php?option=com_jsjobs&c=paymenthistory&view=paymenthistory&layout=employerpaymenthistory"><?php echo JText::_('Cancel'); ?></a>
                        <input type="submit" class="js-btn-save" name="submit_app" onclick="return validate_form(document.adminForm)" value="<?php echo JText::_('Save'); ?>" />
                    </div> 
                <input type="hidden" name="nisactive" value="1" />
                <input type="hidden" name="check" value="" />
                <input type="hidden" name="task" value="paymenthistory.saveuserpackage" />
                <input type="hidden" name="userrole" id="userrole" value="" />
                <input type="hidden" name="userid" id="userid" value="" />
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <?php echo JHTML::_( 'form.token' ); ?>        
        </form>
    </div> 
    
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

<script language="javascript">
    function setuser(username, userid) {
        jQuery.post("index.php?option=com_jsjobs&task=userrole.listuserdataforpackage", {val: userid}, function (data) {
            if (data) {
                if (data != false) {
                    var obj = eval("(" + data + ")");//return Value
                    document.getElementById('package').innerHTML = obj.list;
                    document.getElementById('username').value = username;
                    document.getElementById('userrole').value = obj.userrole;
                    document.getElementById('userid').value = userid;
                    window.setTimeout('closeme();', 300);
                } else {
                    alert('<?php echo JText::_('Selected user is not js jobs system user, please asign role to user user roles > Users > Change Role') ?>');
                }
            }
        });
    }
    function closeme() {
        parent.SqueezeBox.close();
    }
</script>
