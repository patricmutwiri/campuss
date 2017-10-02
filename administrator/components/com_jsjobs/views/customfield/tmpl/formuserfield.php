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

if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('../components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}
JHTML::_('behavior.calendar');
JHTML::_('behavior.formvalidation');

$yesno = array(
    '0' => array('value' => 1, 'text' => JText::_('Yes')),
    '1' => array('value' => 0, 'text' => JText::_('No')),);

$fieldtype = array(
    '0' => array('value' => 'text', 'text' => JText::_('Text Field')),
    '1' => array('value' => 'checkbox', 'text' => JText::_('Check Box')),
    '2' => array('value' => 'date', 'text' => JText::_('Date')),
    '3' => array('value' => 'select', 'text' => JText::_('Drop Down')),
    '4' => array('value' => 'emailaddress', 'text' => JText::_('Email Address')),
//  '5' => array('value' => 'editortext','text' => JText::_('Editor Text Area')),
    '6' => array('value' => 'textarea', 'text' => JText::_('Text Area')),);

if (isset($this->userfield)) {
    $lstype = JHTML::_('select.genericList', $fieldtype, 'type', 'class="inputbox" ' . 'onchange="toggleType(this.options[this.selectedIndex].value);"', 'value', 'text', $this->userfield->type);
    $lsrequired = JHTML::_('select.genericList', $yesno, 'required', 'class="inputbox" ' . '', 'value', 'text', $this->userfield->required);
    $lsreadonly = JHTML::_('select.genericList', $yesno, 'readonly', 'class="inputbox" ' . '', 'value', 'text', $this->userfield->readonly);
    $lspublished = JHTML::_('select.genericList', $yesno, 'published', 'class="inputbox" ' . '', 'value', 'text', $this->userfield->published);
} else {
    $lstype = JHTML::_('select.genericList', $fieldtype, 'type', 'class="inputbox" ' . 'onchange="toggleType(this.options[this.selectedIndex].value);"', 'value', 'text', 0);
    $lsrequired = JHTML::_('select.genericList', $yesno, 'required', 'class="inputbox" ' . '', 'value', 'text', 0);
    $lsreadonly = JHTML::_('select.genericList', $yesno, 'readonly', 'class="inputbox" ' . '', 'value', 'text', 0);
    $lspublished = JHTML::_('select.genericList', $yesno, 'published', 'class="inputbox" ' . '', 'value', 'text', 1);
}
?>
<script language="javascript">

// for joomla 1.6
    Joomla.submitbutton = function (task) {
        if (task == '') {
            return false;
        } else {
            if (task == 'customfield.saveuserfield') {
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
            var totalvariable = document.adminForm.valueCount.value;
            if (document.getElementById('type').value == 'select') {
                for (i = 0; i <= totalvariable; i++) {
                    if(jQuery('input[name="jsNames[' + i + ']"]').length && jQuery('input[name="jsValues[' + i + ']"]').length){
                        var value = jQuery('input[name="jsNames[' + i + ']"]').val();
                        var value1 = jQuery('input[name="jsValues[' + i + ']"]').val();
                        if (!value && !value1) {
                            msg.push('<?php echo JText::_('Some values are not acceptable, please retry'); ?>');
                            alert(msg.join('\n'));
                            return false;
                        }
                    }
                }
            }
            f.check.value = '<?php if (JVERSION < '3')
    echo JUtility::getToken();
else
    echo JSession::getFormToken();
?>'; //send token
        }
        else {
            msg.push('<?php echo JText::_('Some values are not acceptable, please retry'); ?>');
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
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=customfield&view=customfield&layout=userfields&ff=<?php echo $this->fieldfor ;?>"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a>
        <?php if (isset($this->userfield)){ ?>
        <span id="heading-text"><?php echo JText::_('Edit User Field'); ?></span>
        <?php }else{ ?>
        <span id="heading-text"><?php echo JText::_('Form User Field'); ?></span>
         <?php } ?>
        </div>
        <form action="index.php" method="post" name="adminForm" id="adminForm" >
        <div class="js-form-area">
            <input type="hidden" name="check" value="post"/>
            <div class="js-form-wrapper">
                <label class="jsjobs-title" for="fieldtype"><?php echo JText::_('Field Type'); ?></label>
                <div class="jsjobs-value"><?php echo $lstype; ?></div>
            </div>
            <div class="js-form-wrapper">
                <label class="jsjobs-title" for="fieldtype"><?php echo JText::_('Field Name'); ?></label>
                <div class="jsjobs-value"><input onchange="prep4SQL(this);" type="text" name="name" mosReq=1 mosLabel="Name" class="inputbox required" value="<?php if (isset($this->userfield)) echo $this->userfield->name; ?>"  /></div>
            </div>
            <div class="js-form-wrapper">
                <label class="jsjobs-title" for="fieldtype"><?php echo JText::_('Field Title'); ?></label>
                <div class="jsjobs-value"><input type="text" name="title" class="inputbox required" value="<?php if (isset($this->userfield)) echo $this->userfield->title; ?>" /></div>
                
            </div>
            <?php if (isset($this->resumesection)) { ?>
            <div class="js-form-wrapper">
                <label class="jsjobs-title" for="fieldtype"><?php echo JText::_('Resume Section'); ?></label>
                <div class="jsjobs-value"><?php echo $this->resumesection; ?></div>
            </div>
            <?php } ?>
            <div class="js-form-wrapper">
                <label class="jsjobs-title" for="fieldtype"><?php echo JText::_('Read only'); ?></label>
                <div class="jsjobs-value"><?php echo $lsreadonly; ?></div>
            </div>
            <div class="js-form-wrapper">
                <label class="jsjobs-title" for="fieldtype"><?php echo JText::_('Published'); ?></label>
                <div class="jsjobs-value"><?php if (isset($this->userfield->id)) {echo JText::_("Manage In Fields Ordering").' <a href="index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff='.$this->fieldfor.'">'.JText::_('Fields Ordering').'</a>'; }else{echo $lspublished; } ?></div>
            </div>
            <div class="js-form-wrapper">
                <label class="jsjobs-title" for="fieldtype"><?php echo JText::_('Required'); ?></label>
                <div class="jsjobs-value"><?php if (isset($this->userfield->id)) {echo JText::_("Manage In Fields Ordering").' <a href="index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff='.$this->fieldfor.'">'.JText::_('Fields Ordering').'</a>'; }else{echo $lsrequired; } ?></div>
            </div>
            <div class="js-form-wrapper">
                <label class="jsjobs-title" for="fieldtype"><?php echo JText::_('Field Size'); ?></label>
                <div class="jsjobs-value"><input type="text" name="size" class="inputbox validate-numeric" maxlength="6" value="<?php if (isset($this->userfield)) echo $this->userfield->size; ?>" /></div>
            </div>
            <div id="page1"></div>            
            <div id="divText">
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="fieldtype"><?php echo JText::_('Max Length'); ?></label>
                    <div class="jsjobs-value"><input type="text" name="maxlength" class="inputbox validate-numeric" maxlength="6" value="<?php if (isset($this->userfield)) echo $this->userfield->maxlength; ?>" /></div>
                </div>
            </div>
            <div id="divColsRows">
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="fieldtype"><?php echo JText::_('Columns'); ?></label>
                    <div class="jsjobs-value"><input type="text" name="cols" class="inputbox validate-numeric" maxlength="6" value="<?php if (isset($this->userfield)) echo $this->userfield->cols; ?>" /></div>
                </div>
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="fieldtype"><?php echo JText::_('Rows'); ?></label>
                    <div class="jsjobs-value"><input type="text" name="rows" class="inputbox validate-numeric" maxlength="6" value="<?php if (isset($this->userfield)) echo $this->userfield->rows; ?>" /></div>
                </div>
            </div>
            <div class="js-form-wrapper">
                <div id="divValues" style="text-align:left;width:100%;float;left:overflow: auto;">
                <label class="jsjobs-title" for="">
                    <?php echo JText::_('Use the table below to add new values'); ?>
                </label>
                <div class="jsjobs-value">
                    <input type="button" class="button" onclick="insertRow();" value="<?php echo JText::_('Add a Value');?>" />
                        <table align=left id="divFieldValues" cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform" >
                            <thead>
                            <th class="title" width="20%"><?php echo JText::_('Title');?></th>
                            <th class="title" width="80%"><?php echo JText::_('Value');?></th>
                            </thead>
                            <tbody id="fieldValuesBody">
                                <?php
                                $i = 0;
                                if (isset($this->userfield->type) && $this->userfield->type == 'select') {
                                    foreach ($this->fieldvalues as $value) {
                                        ?>
                                        <tr id="jsjobs_trcust<?php echo $i; ?>">
                                            <input type="hidden" value="<?php echo $value->id; ?>" name="jsIds[]" />
                                            <td width="20%"><input type="text" value="<?php echo $value->fieldtitle; ?>" name="jsNames[]" /></td>
                                            <td>
                                                <input type="text" value="<?php echo $value->fieldvalue; ?>" name="jsValues[]" />
                                                <span class="jquery_span_closetr" data-rowid="jsjobs_trcust<?php echo $i; ?>" data-optionid="<?php echo $value->id; ?>" style="padding:4px;background:#b31212;cursor:pointer;color:#FFFFFF;width:unset;float:right;" >X</span>
                                            </td>
                                        </tr>
                                    <?php
                                    $i++;
                                }
                                $i--; //for value to store correctly
                            } else {
                                ?>
                                    <tr id="jsjobs_trcust0">
                                        <td width="20%"><input type="text" value="" name="jsNames[]" /></td>
                                        <td width="80%"><input type="text" value="" name="jsValues[]" />
                                            <span data-rowid="jsjobs_trcust0" style="padding:4px;background:#b31212;cursor:pointer;color:#FFFFFF;">X</span>
                                        </td>
                                    </tr>
                                <?php } ?>      
                            </tbody>
                        </table>
                    </div>
                </div>
             </div>

                <input type="hidden" name="id" value="<?php if (isset($this->userfield)) echo $this->userfield->id ?>" />
                <input type="hidden" name="valueCount" value="<?php echo $i; ?>" />
                <input type="hidden" name="fieldfor" value="<?php echo $this->fieldfor; ?>" />
                <input type="hidden" name="task" value="customfield.saveuserfield" />
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
        </div>
<!--         <div class="js-buttons-area">
            <a class="js-btn-cancel" href="index.php?option=com_jsjobs&c=department&view=department&layout=departments"><?php echo JText::_('Cancel'); ?></a>
            <input type="submit" class="js-btn-save" name="submit_app" onclick="return validate_form(document.adminForm)" value="<?php echo JText::_('Save User Field'); ?>" />
        </div> -->
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



<script type="text/javascript">
    function jsRemovethisvalue(id){
        if(id!=0){
            lagn = '<?php echo JText::_('Are You Sure');?>';
            var r = confirm(lagn);
            if(r == true){
                jQuery('#jsjobs_trcust' + id).remove();
                document.adminForm.valueCount.value = document.adminForm.valueCount.value - 1;
            }
        }
    }

    function getObject(obj) {
        var strObj;
        if (document.all) {
            strObj = document.all.item(obj);
        } else if (document.getElementById) {
            strObj = document.getElementById(obj);
        }
        return strObj;
    }

    function insertRow() {
        var oTable = getObject("fieldValuesBody");
        var oRow, oCell, oCellCont, oInput, oSpan;
        var i, j;
        i = document.adminForm.valueCount.value;
        i++;
        // Create and insert rows and cells into the first body.
        oRow = document.createElement("TR");
        jQuery(oRow).attr('id', "jsjob_trcust" + i);
        oTable.appendChild(oRow);

        oCell = document.createElement("TD");
        oInput = document.createElement("INPUT");
        oInput.name = "jsNames[]";
        oInput.setAttribute('id', "jsNames_" + i);
        oCell.appendChild(oInput);
        oRow.appendChild(oCell);

        oCell = document.createElement("TD");
        oInput = document.createElement("INPUT");
        oInput.name = "jsValues[]";
        oInput.setAttribute('id', "jsValues_" + i);
        oCell.appendChild(oInput);

        oSpan = document.createElement("SPAN");
        oSpan.setAttribute('style', "padding:4px;background:#b31212;cursor:pointer;color:#FFFFFF;");
        oSpan.appendChild( document.createTextNode("X") );
        
        jQuery(oSpan).click(function () {
            jQuery('#jsjob_trcust' + i).remove();
            document.adminForm.valueCount.value = document.adminForm.valueCount.value - 1;

        });
        oCell.appendChild(oSpan);

        oRow.appendChild(oCell);
        oInput.focus();

        document.adminForm.valueCount.value = i;
    }

    function disableAll() {
        jQuery("#divValues").slideUp();
        jQuery("#divColsRows").slideUp();
        jQuery("#divText").slideUp();
        /*
         
         var elem;
         try{ 
         divValues.slideOut();
         divColsRows.slideOut();
         //divWeb.slideOut();
         //divShopperGroups.slideOut();
         //divAgeVerification.slideOut();
         divText.slideOut();
         
         } catch(e){ }
         if (elem=getObject('jsNames[0]')) {
         elem.setAttribute('mosReq',0);
         }
         */
    }
    function toggleType(type) {
        disableAll();
        prep4SQL(document.adminForm.name);
        selType(type);
    }
    function selType(sType) {
        var elem;

        switch (sType) {
            case 'editorta':
            case 'textarea':
                jQuery("#divText").slideDown();
                jQuery("#divColsRows").slideDown();
            break;
            case 'emailaddress':
            case 'password':
            case 'text':
                jQuery("#divText").slideDown();
            break;
            case 'select':
            case 'multiselect':
                jQuery("#divValues").slideDown();
                jQuery("#divValues").css('display','inline-block');
                /*
                 if (elem=getObject('jsNames[0]')) {
                 elem.setAttribute('mosReq',1);
                 }
                 */
            break;
            case 'radio':
            case 'multicheckbox':
                jQuery("#divColsRows").slideDown();
                jQuery("#divValues").slideDown();
                /*
                 if (elem=getObject('jsNames[0]')) {
                 elem.setAttribute('mosReq',1);
                 }
                 */
            break;
            case 'delimiter':
            break;
            default:
            break;
        }
    }

    function prep4SQL(o) {
        if (o.value != '') {
            o.value = o.value.replace('js_', '');
            o.value = 'js_' + o.value.replace(/[^a-zA-Z]+/g, '');
        }
    }
</script>  
<?php //if($i > 0 ){   ?>
            <script type="text/javascript">
                jQuery(document).ready(function () {
                    toggleType(jQuery('#type').val());
                });

                jQuery("span.jquery_span_closetr").each(function () {
                    var span = jQuery(this);
                    jQuery(span).click(function () {
                        var span_current = jQuery(this);
                        if (jQuery(span_current).attr('data-optionid') != 'undefined') {
                            jQuery.post("index.php?option=com_jsjobs&task=customfield.deleteuserfieldoption", {id: jQuery(span_current).attr('data-optionid')}, function (data) {
                                if (data) {
                                    var tr_id = jQuery(span_current).attr('data-rowid');
                                    jQuery('#' + tr_id).remove();
                                    document.adminForm.valueCount.value = document.adminForm.valueCount.value - 1;
                                } else {
                                    alert('<?php echo JText::_('Can not delete option in use'); ?>');

                                }

                            });
                        } else {
                            var tr_id = jQuery(span_current).attr('data-rowid');
                            jQuery('#' + tr_id).remove();
                            document.adminForm.valueCount.value = document.adminForm.valueCount.value - 1;
                        }
                    });
                });
            </script>
<?php //} ?>