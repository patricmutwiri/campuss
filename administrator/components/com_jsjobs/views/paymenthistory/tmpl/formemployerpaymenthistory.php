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

$editor = JFactory::getEditor();
JHTML::_('behavior.calendar');
JHTML::_('behavior.formvalidation');
?>

<script language="javascript">
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

<table width="100%" >
    <tr>
        <td align="left" width="175"  valign="top">
            <table width="100%" ><tr><td style="vertical-align:top;">
<?php
include_once('components/com_jsjobs/views/menu.php');
?>
                    </td>
                </tr></table>
        </td>
        <td width="100%" valign="top" align="left">


            <form action="index.php" method="post" name="adminForm" id="adminForm"  >
                <input type="hidden" name="check" value="post"/>
                <table cellpadding="5" cellspacing="0" border="0" width="100%" class="adminform">
<?php if ($this->msg != '') { ?>
                        <tr>
                            <td colspan="2" align="center"><font color="red"><strong><?php echo JText::_($this->msg); ?></strong></font></td>
                        </tr>
                        <tr><td colspan="2" height="10"></td></tr>	
<?php } ?>
                    <tr class="row0">
                        <td valign="top" align="right"><label id="packagetitlemsg" for="packagetitle"><?php echo JText::_('Title'); ?></label>&nbsp;<font color="red">*</font></td>
                        <td><input class="inputbox required" type="text" name="packagetitle" id="packagetitle" size="40" maxlength="255" value="<?php if (isset($this->package)) echo $this->package->packagetitle; ?>" /></td>
                    </tr>
                    <tr class="row1">
                        <td valign="top" align="right"><label id="packagepricemsg" for="packageprice"><?php echo JText::_('Price'); ?></label>&nbsp;<font color="red">*</font></td>
                        <td><input class="inputbox required validate-numeric" type="text" name="packageprice" id="packageprice" size="40" maxlength="255" value="<?php if (isset($this->package)) echo $this->package->packageprice; ?>" /></td>
                    </tr>
                    <tr class="row0">
                        <td valign="top" align="right"><label id="discountamountmsg" for="discountamount"><?php echo JText::_('Discount'); ?></label>&nbsp;<font color="red">*</font></td>
                        <td><input class="inputbox required validate-numeric" type="text" name="discountamount" id="discountamount" size="40" maxlength="255" value="<?php if (isset($this->package)) echo $this->package->discountamount; ?>" /></td>
                    </tr>
                    <tr class="row1">
                        <td valign="top" align="right"><label id="discountstartdate_msg" for="discountstartdate"><?php echo JText::_('Discount Start Date'); ?></label>&nbsp;</td>
                        <td><input class="inputbox " type="text" name="discountstartdate" id="discountstartdate" readonly size="10" maxlength="10" value="<?php if (isset($this->package)) echo $this->package->discountstartdate; ?>" />
                            <input type="reset" class="button" value="..." onclick="return showCalendar('discountstartdate', '%Y-%m-%d');"  /></td>

                    </tr>
                    <tr class="row0">
                        <td valign="top" align="right"><label id="discountenddate_msg" for="discountenddate"><?php echo JText::_('Discount End Date'); ?></label>&nbsp;</td>
                        <td><input class="inputbox " type="text" name="discountenddate" id="discountenddate" readonly size="10" maxlength="10" value="<?php if (isset($this->package)) echo $this->package->discountenddate; ?>" />
                            <input type="reset" class="button" value="..." onclick="return showCalendar('discountenddate', '%Y-%m-%d');"  /></td>
                    </tr>
                    <tr class="row1">
                        <td valign="top" align="right"><label id="discountmessage_msg" for="discountmessage"><?php echo JText::_('Discount Message'); ?></label>&nbsp;<font color="red">*</font></td>
                        <td><input class="inputbox required" type="text" name="discountmessage" id="discountmessage" size="40" maxlength="255" value="<?php if (isset($this->package)) echo $this->package->discountmessage; ?>" /></td>
                    </tr>
                    <tr class="row0">
                        <td align="right"><label id="discounttypemsg" for="discounttype"><?php echo JText::_('Discount Type'); ?></label></td>
                        <td><?php echo $this->lists['type']; ?>
                        </td>

                    </tr>

                    <tr class="row1">
                        <td colspan="2" valign="top" align="center"><label id="descriptionmsg" for="description"><strong><?php echo JText::_('Description'); ?></strong></label>&nbsp;<font color="red">*</font></td>
                    </tr>

                    <tr class="row0">
                        <td colspan="2" align="center">
                            <?php
                            $editor = JFactory::getEditor();
                            if (isset($this->package))
                                echo $editor->display('description', $this->package->description, '550', '300', '60', '20', false);
                            else
                                echo $editor->display('description', '', '550', '300', '60', '20', false);
                            ?>	
                        </td>
                    </tr>
                    <tr class="row1">
                        <td valign="top" align="right"><label id="resumeallowmsg" for="resumeallow"><?php echo JText::_('Companies Allow'); ?></label>&nbsp;</td>
                        <td><input class="inputbox " type="text" name="resumeallow" id="resumeallow" size="40" maxlength="255" value="<?php if (isset($this->package)) echo $this->package->resumeallow; ?>" /></td>
                    </tr>
                    <tr class="row0">
                        <td valign="top" align="right"><label id="coverlettersallowmsg" for="coverlettersallow"><?php echo JText::_('Jobs Allow'); ?></label>&nbsp;</td>
                        <td><input class="inputbox " type="text" name="coverlettersallow" id="coverlettersallow" size="40" maxlength="255" value="<?php if (isset($this->package)) echo $this->package->coverlettersallow; ?>" /></td>
                    </tr>
                    <tr class="row1">
                        <td valign="top" align="right"><label id="featuredresumemsg" for="featuredresume"><?php echo JText::_('Featured Companies'); ?></label>&nbsp;</td>
                        <td><input class="inputbox " type="text" name="featuredresume" id="featuredresume" size="40" maxlength="255" value="<?php if (isset($this->package)) echo $this->package->featuredresume; ?>" /></td>
                    </tr>
                    <tr class="row0">
                        <td valign="top" align="right"><label id="goldresumemsg" for="goldresume"><?php echo JText::_('Gold Companies'); ?></label>&nbsp;</td>
                        <td><input class="inputbox " type="text" name="goldresume" id="goldresume" size="40" maxlength="255" value="<?php if (isset($this->package)) echo $this->package->goldresume; ?>" /></td>
                    </tr>
                    <tr class="row1">
                        <td align="right"><label id="jobsearchmsg" for="jobsearch"><?php echo JText::_('Resume Search	'); ?></label></td>
                        <td><?php echo $this->lists['yesNo']; ?></td>
                    </tr>
                    <tr class="row0">
                        <td align="right"><label id="savejobsearchmsg" for="savejobsearch"><?php echo JText::_('Save Resume Search'); ?></label></td>
                        <td><?php echo $this->lists['yesNo']; ?></td>
                    </tr>


                    <tr class="row1">
                        <td align="right"><label id="statusmsg" for="status"><?php echo JText::_('Status'); ?></label></td>
                        <td><?php echo $this->lists['status']; ?>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="2" height="5"></td>
                    <tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input class="button" type="submit" onclick="return validate_form(document.adminForm)" name="submit_app" onClick="return myValidate();" value="<?php echo JText::_('Save Employer Package'); ?>" />
                        </td>
                    </tr>
                </table>


                <input type="hidden" name="id" value="<?php if (isset($this->package)) echo $this->package->id; ?>" />
                <input type="hidden" name="task" value="paymenthistory.saveemployerpaymenthistory" />
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" name="uid" value="<?php echo $uid; ?>" />

                <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $this->Itemid; ?>" />
                <?php echo JHTML::_( 'form.token' ); ?>        
            </form>

        </td>
    </tr>
</table>				
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
