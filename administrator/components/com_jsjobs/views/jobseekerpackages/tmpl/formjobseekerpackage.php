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
$uid = JFactory::getUser()->id;
JHTML::_('behavior.calendar');
JHTML::_('behavior.formvalidation');
$document = JFactory::getDocument();
if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('../components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}
if ($this->config['date_format'] == 'm/d/Y')
    $dash = '/';
else
    $dash = '-';
$dateformat = $this->config['date_format'];
$firstdash = strpos($dateformat, $dash, 0);
$firstvalue = substr($dateformat, 0, $firstdash);
$firstdash = $firstdash + 1;
$seconddash = strpos($dateformat, $dash, $firstdash);
$secondvalue = substr($dateformat, $firstdash, $seconddash - $firstdash);
$seconddash = $seconddash + 1;
$thirdvalue = substr($dateformat, $seconddash, strlen($dateformat) - $seconddash);
$js_dateformat = '%' . $firstvalue . $dash . '%' . $secondvalue . $dash . '%' . $thirdvalue;
$js_scriptdateformat = $firstvalue . $dash . $secondvalue . $dash . $thirdvalue;
?>
<script language="javascript">

    function validate_start_stop_discount() {
        var date_start_make = new Array();
        var date_stop_make = new Array();
        var split_start_value = new Array();
        var split_stop_value = new Array();
        var returnvalue = true;
        var isedit = document.getElementById("id");
        var start_string = document.getElementById("discountstartdate").value;
        var stop_string = document.getElementById("discountenddate").value;
        var format_type = document.getElementById("j_dateformat").value;
        if (format_type == 'd-m-Y') {
            split_start_value = start_string.split('-');

            date_start_make['year'] = split_start_value[2];
            date_start_make['month'] = split_start_value[1];
            date_start_make['day'] = split_start_value[0];

            split_stop_value = stop_string.split('-');

            date_stop_make['year'] = split_stop_value[2];
            date_stop_make['month'] = split_stop_value[1];
            date_stop_make['day'] = split_stop_value[0];

        } else if (format_type == 'm/d/Y') {
            split_start_value = start_string.split('/');
            date_start_make['year'] = split_start_value[2];
            date_start_make['month'] = split_start_value[0];
            date_start_make['day'] = split_start_value[1];

            split_stop_value = stop_string.split('/');

            date_stop_make['year'] = split_stop_value[2];
            date_stop_make['month'] = split_stop_value[0];
            date_stop_make['day'] = split_stop_value[1];

        } else if (format_type == 'Y-m-d') {

            split_start_value = start_string.split('-');

            date_start_make['year'] = split_start_value[0];
            date_start_make['month'] = split_start_value[1];
            date_start_make['day'] = split_start_value[2];

            split_stop_value = stop_string.split('-');

            date_stop_make['year'] = split_stop_value[0];
            date_stop_make['month'] = split_stop_value[1];
            date_stop_make['day'] = split_stop_value[2];

        }
        var start = new Date(date_start_make['year'], date_start_make['month'] - 1, date_start_make['day']);
        var stop = new Date(date_stop_make['year'], date_stop_make['month'] - 1, date_stop_make['day']);
        if (start >= stop) {
            returnvalue = false;
        }
        return returnvalue;

    }
    window.addEvent('domready', function () {
        document.formvalidator.setHandler('discountstartdate', function (value) {

            var return_value = validate_start_stop_discount();
            return return_value;

        });
    });

    window.addEvent('domready', function () {
        document.formvalidator.setHandler('discount', function (value) {

            var price = document.getElementById("price").value;
            var price_value = parseFloat(price);
            if (isNaN(price_value))
                return false;
            var discount = document.getElementById("discount").value;
            var discount_value = parseFloat(discount);
            if (isNaN(discount_value))
                return false;

            var discount_obj = document.getElementById("discounttype");
            var discount_type = discount_obj.options[discount_obj.selectedIndex].value;
            if (discount_type == 1) { // 1 for amount 
                if (discount_value > price)
                    return false;
            } else if (discount_type == 2) { // 2 for persent 
                if (discount_value > 100)
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
            if (task == 'jobseekerpackages.savejobseekerpackage') {
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
        var msg = new Array();
        if (document.formvalidator.isValid(f)) {
            f.check.value = '<?php if (($jversion == '1.5') || ($jversion == '2.5'))
    echo JUtility::getToken();
else
    echo JSession::getFormToken();
?>';//send token
        }
        else {
            msg.push('<?php echo JText::_('Some values are not acceptable, please retry'); ?>');
            var element_package_discountstart = document.getElementById('discountstartdate');
            if (hasClass(element_package_discountstart, 'invalid')) {
                var isedit = document.getElementById("id");
                msg.push('<?php echo JText::_('Discount start date must be less than discount end date'); ?>');
            }
            var element_discount = document.getElementById('discount');
            if (hasClass(element_discount, 'invalid')) {
                msg.push('<?php echo JText::_('Enter correct discount value according to discount type'); ?>');

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
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=jobseekerpackages"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a>
            <?php if (isset($this->package->id)){ ?>
            <span id="heading-text"><?php echo JText::_('Edit Job Seeker Package'); ?></span>
            <?php }else{ ?>
            <span id="heading-text"><?php echo JText::_('Form Job Seeker Package'); ?></span>
            <?php } ?>
        </div>
         <form action="index.php" method="post" name="adminForm" id="adminForm"   >
        <div class="js-form-area">
                <input type="hidden" name="check" value="post"/>
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="title"><?php echo JText::_('Title'); ?>:&nbsp;<font color="red">*</font></label>
                    <div class="jsjobs-value"><input class="inputbox required" type="text" name="title" id="title" size="40" maxlength="255" value="<?php if (isset($this->package)) echo $this->package->title; ?>" /></div>
                </div>

                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="price"><?php echo JText::_('Price'); ?>:&nbsp;<font color="red">*</font></label>
                    <div class="jsjobs-value"><?php echo $this->lists['currency']; ?><input class="inputbox required validate-numeric"  type="text" name="price" id="price" size="40" maxlength="255" value="<?php if (isset($this->package)) echo $this->package->price; ?>" /></div>
                </div>
                
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="discount"><?php echo JText::_('Discount'); ?>:&nbsp;</label>
                    <div class="jsjobs-value"><input class="inputbox validate-discount" maxlength="6" type="text" name="discount" id="discount" size="40" maxlength="255" value="<?php if (isset($this->package)) echo $this->package->discount; ?>" /></div>
                </div>
                
                <div class="js-form-wrapper">
                     <?php
                        $startdatevalue = '';
                        if (isset($this->package) && $this->package->discountstartdate != '0000-00-00 00:00:00')
                            if (isset($this->package))
                                $startdatevalue = JHtml::_('date', $this->package->discountstartdate, $this->config['date_format']);
                        ?>
                    <label class="jsjobs-title" for="discountstartdate"><?php echo JText::_('Discount Start Date'); ?>:&nbsp;</label>
                    <div class="jsjobs-value"><?php echo JHTML::_('calendar', $startdatevalue, 'discountstartdate', 'discountstartdate', $js_dateformat, array('class' => 'inputbox validate-discountstartdate', 'size' => '10', 'maxlength' => '19')); ?></div>
                </div>

                <div class="js-form-wrapper">
                <?php
                        $stopdatevalue = '';
                        if (isset($this->package) && $this->package->discountenddate != '0000-00-00 00:00:00')
                            if (isset($this->package))
                                $stopdatevalue = JHtml::_('date', $this->package->discountenddate, $this->config['date_format']);
                        ?>
                    <label class="jsjobs-title" for="discountenddate"><?php echo JText::_('Discount End Date'); ?>:&nbsp;</label>
                    <div class="jsjobs-value"><?php echo JHTML::_('calendar', $stopdatevalue, 'discountenddate', 'discountenddate', $js_dateformat, array('class' => 'inputbox validate-discountenddate', 'size' => '10', 'maxlength' => '19')); ?></div>
                </div>

                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="discountmessage"><?php echo JText::_('Discount Message'); ?>:&nbsp;</label>
                    <div class="jsjobs-value"><input class="inputbox" type="text" name="discountmessage" id="discountmessage" size="40" maxlength="255" value="<?php if (isset($this->package)) echo $this->package->discountmessage; ?>" /></div>
                </div>

                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="discounttype"><?php echo JText::_('Discount Type'); ?>:&nbsp;</label>
                    <div class="jsjobs-value"><?php echo $this->lists['type']; ?></div>
                </div>

                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="applyjobs"><?php echo JText::_('Apply Jobs'); ?>:&nbsp;</label>
                    <div class="jsjobs-value"><input class="inputbox validate-numeric" type="text" name="applyjobs" id="applyjobs" size="40" maxlength="255" value="<?php if (isset($this->package)) echo $this->package->applyjobs; ?>" />&nbsp;<?php echo JText::_('-1 To Unlimited') ?> </div>
                </div>

                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="resumeallow"><?php echo JText::_('Resume Allow'); ?>:&nbsp;</label>
                    <div class="jsjobs-value"><input class="inputbox validate-numeric" type="text" name="resumeallow" id="resumeallow" size="40" maxlength="255" value="<?php if (isset($this->package)) echo $this->package->resumeallow; ?>" />&nbsp;<?php echo JText::_('-1 To Unlimited') ?></div>
                </div>

                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="coverlettersallow"><?php echo JText::_('Cover Letter Allow'); ?>:&nbsp;</label>
                    <div class="jsjobs-value"><input class="inputbox validate-numeric" type="text" name="coverlettersallow" id="coverlettersallow" size="40" maxlength="255" value="<?php if (isset($this->package)) echo $this->package->coverlettersallow; ?>" />&nbsp;<?php echo JText::_('-1 To Unlimited') ?></div>
                </div>


                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="jobsearch"><?php echo JText::_('Job Search'); ?>:&nbsp;</label>
                    <div class="jsjobs-value"><?php echo $this->lists['jobsearch']; ?></div>
                </div>

                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="savejobsearch"><?php echo JText::_('Save Job Search'); ?>:&nbsp;</label>
                    <div class="jsjobs-value"><?php echo $this->lists['savejobsearch']; ?></div>
                </div>

                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="packageexpireindays"><b><?php echo JText::_('Expire In Days'); ?></b>:&nbsp;<font color="red">*</font></label>
                    <div class="jsjobs-value"><input class="inputbox required validate-numeric" type="text" name="packageexpireindays" id="packageexpireindays" size="40" maxlength="6" value="<?php if (isset($this->package)) echo $this->package->packageexpireindays; ?>" /></div>
                </div>

                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="name"><b><?php echo JText::_('Description'); ?>:</b>&nbsp;<font color="red">*</font></label>
                    <div class="jsjobs-value"> <?php
                            $editor = JFactory::getEditor();
                            if (isset($this->package))
                                echo $editor->display('description', $this->package->description, '550', '300', '60', '20', false);
                            else
                                echo $editor->display('description', '', '550', '300', '60', '20', false);
                            ?></div>
                </div>



<?php
if (isset($this->paymentmethodlink)) {
    foreach ($this->paymentmethodlink AS $paymethodlink) { ?>
    <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="<?php echo $paymethodlink->title; ?>">
        <?php echo $paymethodlink->title; ?> <?php
        if ($paymethodlink->title == "Paypal") {
            echo JText::_('Account');
        } elseif ($paymethodlink->title == "Pagseguro") {
            echo JText::_('Account');
        } else {
            echo JText::_('Link');
        }
        ?>
        </label>
        <div class="jsjobs-value">
        

        <?php if ($paymethodlink->title == "Paypal") { ?>
                                        <input id="<?php echo $paymethodlink->title; ?>" class="inputbox " type="hidden" name="link[]"  size="50" maxlength="255" value=""/>
        <?php } elseif ($paymethodlink->title == "Pagseguro") { ?>
                                        <input id="<?php echo $paymethodlink->title; ?>" class="inputbox " type="hidden" name="link[]"  size="50" maxlength="255" value=""/>
                            <?php } else { ?>
                                        <input id="<?php echo $paymethodlink->title; ?>" class="inputbox " type="text" name="link[]"  size="50" maxlength="255" value="<?php echo $paymethodlink->link; ?>"/>
                            <?php } ?>
</div>
                            <input type="hidden" name="paymentmethodids[]" value="<?php echo $paymethodlink->paymentmethod_id; ?>" />
                            <input type="hidden" name="linkids[]" value="<?php echo $paymethodlink->linkid; ?>" />
</div>                            
    
        <?php

    }
}
?>



                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="status"><?php echo JText::_('Status'); ?>:&nbsp;</label>
                    <div class="jsjobs-value"><?php echo $this->lists['status']; ?></div>
                </div>

                <input type="hidden" name="id" value="<?php if (isset($this->package)) echo $this->package->id; ?>" />
                <input type="hidden" name="task" value="jobseekerpackages.savejobseekerpackage" />
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" name="uid" value="<?php echo $uid; ?>" />
                <input type="hidden" name="j_dateformat" id="j_dateformat" value="<?php echo $js_scriptdateformat; ?>" />
                <input type="hidden" name="check" value="" />
        </div>
            <div class="js-buttons-area">
                <a class="js-btn-cancel" href="index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=jobseekerpackages"><?php echo JText::_('Cancel'); ?></a>
                <input type="submit" class="js-btn-save" name="submit_app" onclick="return validate_form(document.adminForm)" value="<?php echo JText::_('Save Job Seeker Package'); ?>" />
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







