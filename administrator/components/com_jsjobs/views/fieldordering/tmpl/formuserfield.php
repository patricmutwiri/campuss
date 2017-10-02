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
            if (task == 'fieldordering.savejobuserfieldsave' || task == 'fieldordering.savejobuserfieldandnew' || task == 'fieldordering.savejobuserfield') {
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
            f.check.value = "<?php if (JVERSION < '3')
                echo JUtility::getToken();
            else
                echo JSession::getFormToken();
            ?>";//send token
        }else {
            alert('<?php echo JText::_('Some values are not acceptable').'. '.JText::_('Please retry'); ?>');
            return false;
        }
        return true;
    }
</script>
<?php
    $yesno = array();
    $yesno[] = (object) array('id' => 1, 'text' => JText::_('Yes'));
    $yesno[] = (object) array('id' => 0, 'text' => JText::_('No'));
    $sectionarray = array();
    $sectionarray[] = (object) array('id' => 1, 'text' => JText::_('Personal Information'));
    $sectionarray[] = (object) array('id' => 2, 'text' => JText::_('Addresses'));
    $sectionarray[] = (object) array('id' => 3, 'text' => JText::_('Education'));
    $sectionarray[] = (object) array('id' => 4, 'text' => JText::_('Employer'));
    $sectionarray[] = (object) array('id' => 5, 'text' => JText::_('Skills'));
    $sectionarray[] = (object) array('id' => 6, 'text' => JText::_('Resume'));
    $sectionarray[] = (object) array('id' => 7, 'text' => JText::_('References'));
    $sectionarray[] = (object) array('id' => 8, 'text' => JText::_('Languages'));
    $fieldtypes = array();
    $fieldtypes[] = (object) array('id' => 'text', 'text' => JText::_('Text Field'));
    $fieldtypes[] = (object) array('id' => 'checkbox', 'text' => JText::_('Check Box'));
    $fieldtypes[] = (object) array('id' => 'date', 'text' => JText::_('Date'));
    $fieldtypes[] = (object) array('id' => 'combo', 'text' => JText::_('Drop Down'));
    $fieldtypes[] = (object) array('id' => 'email', 'text' => JText::_('Email Address'));
    $fieldtypes[] = (object) array('id' => 'textarea', 'text' => JText::_('Text Area'));
    $fieldtypes[] = (object) array('id' => 'radio', 'text' => JText::_('Radio Button'));
    $fieldtypes[] = (object) array('id' => 'depandant_field', 'text' => JText::_('Depandent Field'));
    $fieldtypes[] = (object) array('id' => 'file', 'text' => JText::_('Upload File'));
    $fieldtypes[] = (object) array('id' => 'multiple', 'text' => JText::_('Multi Select'));
?>

<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a>
            <?php if (isset($this->application->id)){ ?>
            <span id="heading-text"><?php echo JText::_('Edit user field'); ?></span>
            <?php }else{ ?>
            <span id="heading-text"><?php echo JText::_('Form user field'); ?></span>
            <?php } ?>
        </div>
        <form action="index.php" method="POST" name="adminForm" id="adminForm">
            <div class="js-form-area">
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="title"></label>
                    <div class="jsjobs-value"></div>
                </div>

                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for=""><?php echo JText::_('Field Type'); ?><font color="red">*</font></label>
                    <div class="jsjobs-value"><?php echo customfields::select('userfieldtype', $fieldtypes, isset($this->application['userfield']->userfieldtype) ? $this->application['userfield']->userfieldtype : 'text', '', array('class' => 'inputbox required', 'data-validation' => '', 'onchange' => 'toggleType(this.options[this.selectedIndex].value);')); ?></div>
                </div>
                <div class="js-form-wrapper" id="for-combo-wrapper" style="display:none;">
                    <label class="jsjobs-title" for=""><?php echo JText::_('Select','js-jobs') .'&nbsp;'. JText::_('Parent Field'); ?><font color="red">*</font></label>
                    <div class="jsjobs-value" id="for-combo"></div>      
                </div>
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for=""><?php echo JText::_('Field Title'); ?><font color="red">*</font></label>
                    <div class="jsjobs-value"><?php echo customfields::text('fieldtitle', isset($this->application['userfield']->fieldtitle) ? $this->application['userfield']->fieldtitle : '', array('class' => 'inputbox required', 'data-validation' => 'required')); ?></div>
                </div>
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for=""><?php echo JText::_('Show on listing'); ?></label>
                    <div class="jsjobs-value"><?php echo customfields::select('showonlisting', $yesno, isset($this->application['userfield']->showonlisting) ? $this->application['userfield']->showonlisting : 0, '', array('class' => 'inputbox one')); ?></div>
                </div>

                <?php if ($this->ff == 3) { 
                    if($this->application['hide'])
                        $disabled = '1';
                    else
                        $disabled = '';
                    ?>
                    <div class="js-form-wrapper">
                        <label class="jsjobs-title" for=""><?php echo JText::_('Resume Section'); ?><font color="red">*</font></label>
                        <div class="jsjobs-value">
                            <?php 
                                echo customfields::select('section', $sectionarray, isset($this->application['userfield']->section) ? $this->application['userfield']->section : '', '', array('class' => 'inputbox one required', 'data-validation' => 'required', 'onchange' => 'resumesectionchange(this.value);'), $disabled); 
                            ?> 
                            <div id="js_section_msg">
                                <?php echo JText::_('Section Will Not Change In Edit Case'); ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for=""><?php echo JText::_('User Published'); ?></label>
                    <div class="jsjobs-value"><?php echo customfields::select('published', $yesno, isset($this->application['userfield']->published) ? $this->application['userfield']->published : 1, '', array('class' => 'inputbox one')); ?></div>
                </div>
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for=""><?php echo JText::_('Visitor Published'); ?></label>
                    <div class="jsjobs-value"><?php echo customfields::select('isvisitorpublished', $yesno, isset($this->application['userfield']->isvisitorpublished) ? $this->application['userfield']->isvisitorpublished : 1, '', array('class' => 'inputbox one')); ?></div>
                </div>
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for=""><?php echo JText::_('User Search'); ?></label>
                    <div class="jsjobs-value">
                        <?php 
                            $defaultvalue = isset($this->application['userfield']->search_user) ? $this->application['userfield']->search_user : 1;
                            $attrarray = array('class' => 'inputbox one');
                            if($this->ff == 1){ // In case of company this field should be disabled
                                $attrarray['disabled'] = true;
                                $defaultvalue = 0;
                            }
                            echo customfields::select('search_user', $yesno, $defaultvalue, '', $attrarray);
                        ?>                        
                    </div>
                </div>
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for=""><?php echo JText::_('Visitor Search'); ?></label>
                    <div class="jsjobs-value">
                        <?php 
                            $defaultvalue = isset($this->application['userfield']->search_visitor) ? $this->application['userfield']->search_visitor : 1;
                            $attrarray = array('class' => 'inputbox one');
                            if($this->ff == 1){ // In case of company this field should be disabled
                                $attrarray['disabled'] = true;
                                $defaultvalue = 0;
                            }
                            echo customfields::select('search_visitor', $yesno, $defaultvalue, '', $attrarray);
                        ?>
                    </div>
                </div>
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for=""><?php echo JText::_('Required'); ?></label>
                    <div class="jsjobs-value"><?php echo customfields::select('required', $yesno, isset($this->application['userfield']->required) ? $this->application['userfield']->required : 0, '', array('class' => 'inputbox one')); ?></div>
                </div>
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for=""><?php echo JText::_('Field Size'); ?></label>
                    <div class="jsjobs-value"><?php echo customfields::text('size', isset($this->application['userfield']->size) ? $this->application['userfield']->size : '', array('class' => 'inputbox one')); ?></div>
                </div>
                <?php /*
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for=""><?php echo JText::_('Java Script'); ?></label>
                    <div class="jsjobs-value"><?php echo customfields::textarea('j_script', isset($this->application['userfield']->j_script) ? $this->application['userfield']->j_script : '', array('class' => 'inputbox one')); ?></div>
                </div>
                */ ?>

                <div id="for-combo-options-head" >
                    <span class="js-admin-title"><?php echo JText::_('Use The Table Below To Add New Values'); ?></span>
                </div>
                <div id="for-combo-options">
                    <?php
                    $arraynames = '';
                    $comma = '';
                    if (isset($this->application['userfieldparams']) && $this->application['userfield']->userfieldtype == 'depandant_field') {
                        foreach ($this->application['userfieldparams'] as $key => $val) {
                            $textvar = $key;
                            $textvar .='[]';
                            $arraynames .= $comma . "$key";
                            $comma = ',';
                            ?>
                            <div class="js-field-wrapper">
                                <div class="js-field-title">
                                    <?php echo $key; ?>
                                </div>
                                <div class="jsjobs-value combo-options-fields" id="<?php echo $key; ?>">
                                    <?php
                                    if (!empty($val)) {
                                        foreach ($val as $each) {
                                            ?>
                                            <span class="input-field-wrapper">
                                                <input name="<?php echo $textvar; ?>" id="<?php echo $key; ?>" value="<?php echo $each; ?>" class="inputbox one user-field" type="text">
                                                <img class="input-field-remove-img" src="components/com_jsjobs/include/images/remove.png">
                                            </span><?php
                                        }
                                    }
                                    ?>
                                    <input id="depandant-field-button" onclick="getNextField(&quot;<?php echo $key; ?>&quot;,this );" value="Add More" type="button">
                                </div>
                            </div><?php
                        }
                    }
                    ?>
                </div>

                <div id="divText" class="js-form-wrapper">
                    <label class="jsjobs-title" for=""><?php echo JText::_('Max Length'); ?></label>
                    <div class="jsjobs-value"><?php echo customfields::text('maxlength', isset($this->application['userfield']->maxlength) ? $this->application['userfield']->maxlength : '', array('class' => 'inputbox one')); ?></div>
                </div>
                <div class="js-form-wrapper divColsRows">
                    <label class="jsjobs-title" for=""><?php echo JText::_('Columns'); ?></label>
                    <div class="jsjobs-value"><?php echo customfields::text('cols', isset($this->application['userfield']->cols) ? $this->application['userfield']->cols : '', array('class' => 'inputbox one')); ?></div>
                </div>
                <div class="js-form-wrapper divColsRows">
                    <label class="jsjobs-title" for=""><?php echo JText::_('Rows'); ?></label>
                    <div class="jsjobs-value"><?php echo customfields::text('rows', isset($this->application['userfield']->rows) ? $this->application['userfield']->rows : '', array('class' => 'inputbox one')); ?></div>
                </div>
                <div id="divValues" class="js-form-wrapper divColsRows">
                    <span class="js-admin-title"><?php echo JText::_('Use The Table Below To Add New Values'); ?></span>
                    <div class="page-actions">
                        <div id="user-field-values" class="no-padding">
                            <?php
                            if (isset($this->application['userfield']) && $this->application['userfield']->userfieldtype != 'depandant_field') {
                                if (isset($this->application['userfieldparams'])) {
                                    if( ! empty($this->application['userfieldparams']))
                                    foreach ($this->application['userfieldparams'] as $key => $val) {
                                        ?>
                                        <span class="input-field-wrapper">
                                            <?php echo customfields::text('values[]', isset($val) ? $val : '', array('class' => 'inputbox one user-field')); ?>
                                            <img class="input-field-remove-img" src="components/com_jsjobs/include/images/remove.png" />
                                        </span>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <span class="input-field-wrapper">
                                    <?php echo customfields::text('values[]', isset($val) ? $val : '', array('class' => 'inputbox one user-field')); ?>
                                        <img class="input-field-remove-img" src="components/com_jsjobs/include/images/remove.png" />
                                    </span>
                                <?php
                                }
                            }
                            ?>
                            <a class="js-button-link button user-field-val-button" id="user-field-val-button" onclick="insertNewRow();"><?php echo JText::_('Add Value') ?></a>
                        </div>  
                    </div>
                </div>

                <?php echo customfields::hidden('id', isset($this->application['userfield']->id) ? $this->application['userfield']->id : ''); ?>
                <?php 
                    $cannotsearch = 0;
                    if($this->ff == 1){ // for company field are not available for search
                        $cannotsearch = 1;
                    }
                    echo customfields::hidden('cannotsearch', $cannotsearch); 
                ?>
                <?php echo customfields::hidden('cannotshowonlisting', 0); ?>
                <?php echo customfields::hidden('isuserfield', 1); ?>
                <?php echo customfields::hidden('fieldfor', $this->ff); ?>
                <?php echo customfields::hidden('ordering', isset($this->application['userfield']->ordering) ? $this->application['userfield']->ordering : '' ); ?>
                <?php echo customfields::hidden('fieldname', isset($this->application['userfield']->field) ? $this->application['userfield']->field : '' ); ?>
                <?php echo customfields::hidden('field', isset($this->application['userfield']->field) ? $this->application['userfield']->field : '' ); ?>
                <?php echo customfields::hidden('arraynames2', $arraynames); ?>
                <?php // echo customfields::hidden('parentfield', isset($this->application['userfield']->parentfield) ? $this->application['userfield']->parentfield : '' ); ?>
                <input type="hidden" name="task" value="fieldordering.savejobuserfield" />
                <input type="hidden" name="check" value="" />
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
            </div>
            <div class="js-buttons-area">
                <a class="js-btn-cancel" href="index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering"><?php echo JText::_('Cancel'); ?></a>
                <input type="submit" class="js-btn-save" name="submit_app" onclick="return validate_form(document.adminForm)" value="<?php echo JText::_('Save user field'); ?>" />
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

<script type="text/javascript">
    jQuery(document).ready(function () {
        toggleType(jQuery('#userfieldtype').val());
        resumesectionchange(jQuery('select#section').val());
    });
    function resumesectionchange(value){
        var ff = jQuery('input#fieldfor').val();
        if(ff == 3){
            if(value != 1){
                jQuery("select#search_user").val(0).parent().parent().hide();
                jQuery("select#search_visitor").val(0).parent().parent().hide();
                jQuery("select#showonlisting").val(0).parent().parent().hide();
                jQuery("input#cannotshowonlisting").val(1);
                jQuery("input#cannotsearch").val(1);
            }else{
                jQuery("select#search_user").parent().parent().show();
                jQuery("select#search_visitor").parent().parent().show();
                jQuery("select#showonlisting").parent().parent().show();
            }
        }
    }
    function disableAll() {
        jQuery("#divValues").slideUp();
        jQuery(".divColsRows").slideUp();
        jQuery("#divText").slideUp();
    }
    function toggleType(type) {
        disableAll();
        //prep4SQL(document.forms['adminForm'].elements['field']);
        selType(type);

        // Set the option for custom fields
        if(type == 'checkbox'){
            jQuery("select#required").val(0).parent().parent().hide();
        }else{
            jQuery("select#required").parent().parent().show();
        }
    }

    // function prep4SQL(field) {
    //     if (field.value != '') {
    //         field.value = field.value.replace('js_', '');
    //         field.value = 'js_' + field.value.replace(/[^a-zA-Z_0-9]+/g, '');
    //     }
    // }

    function selType(sType) {
        var elem;
        /*
         text
         checkbox
         date
         combo
         email
         textarea
         radio
         editor
         depandant_field
         multiple*/

        switch (sType) {
            case 'editor':
                jQuery("#divText").slideUp();
                jQuery("#divValues").slideUp();
                jQuery(".divColsRows").slideUp();
                jQuery("div#for-combo-wrapper").hide();
                jQuery("div#for-combo-options").hide();
                jQuery("div#for-combo-options-head").hide();

                break;
            case 'textarea':
                jQuery("#divText").slideUp();
                jQuery(".divColsRows").slideDown();
                jQuery(".divColsRows").css('display','inline-block');
                jQuery("#divValues").slideUp();
                jQuery("div#for-combo-wrapper").hide();
                jQuery("div#for-combo-options").hide();
                jQuery("div#for-combo-options-head").hide();
                break;
            case 'email':
            case 'password':
            case 'text':
                jQuery("#divText").slideDown();
                jQuery("div#for-combo-wrapper").hide();
                jQuery("div#for-combo-options").hide();
                jQuery("div#for-combo-options-head").hide();
                break;
            case 'combo':
            case 'multiple':
                jQuery("#divValues").slideDown();
                jQuery("#divValues").css('display','inline-block');
                jQuery("div#for-combo-wrapper").hide();
                jQuery("div#for-combo-options").hide();
                jQuery("div#for-combo-options-head").hide();
                break;
            case 'depandant_field':
                comboOfFields();
                break;
            case 'radio':
            case 'checkbox':
                //jQuery(".divColsRows").slideDown();
                jQuery("#divValues").slideDown();
                jQuery("#divValues").css('display','inline-block');
                jQuery("div#for-combo-wrapper").hide();
                jQuery("div#for-combo-options").hide();
                jQuery("div#for-combo-options-head").hide();
                /*
                 if (elem=getObject('jsNames[0]')) {
                 elem.setAttribute('mosReq',1);
                 }
                 */
                break;
            case 'file':
                jQuery("div#for-combo-wrapper").hide();
                jQuery("div#for-combo-options").hide();
                jQuery("div#for-combo-options-head").hide();            
                break;
            case 'delimiter':
            default:
        }
    }

    function comboOfFields() {
        var ff = jQuery("input#fieldfor").val();
        var pf = jQuery("input#fieldname").val();
        jQuery.post("index.php?option=com_jsjobs&task=fieldordering.getfieldsforcombobyfieldfor", {fieldfor: ff, parentfield: pf}, function (data) {
            if (data) {
                console.log(data);
                var d = jQuery.parseJSON(data);
                jQuery("div#for-combo").html(d);
                jQuery("div#for-combo-wrapper").show();
            }
        });
    }

    function getDataOfSelectedField() {
        var field = jQuery("select#parentfield").val();
        jQuery.post("index.php?option=com_jsjobs&task=fieldordering.getSectionToFillValues", {pfield: field}, function (data) {
            if (data) {
                console.log(data);
                var d = jQuery.parseJSON(data);
                jQuery("div#for-combo-options-head").css('display','inline-block');
                jQuery("div#for-combo-options").html(d);
                jQuery("div#for-combo-options").css('display','inline-block');
            }
        });
    }

    function getNextField(divid,object) {
        var textvar = divid + '[]';
        var fieldhtml = "<span class='input-field-wrapper' ><input type='text' name='" + textvar + "' class='inputbox one user-field'  /><img class='input-field-remove-img' src='components/com_jsjobs/include/images/remove.png' /></span>";
        jQuery(object).before(fieldhtml);
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

    function insertNewRow() {
        var fieldhtml = '<span class="input-field-wrapper" ><input name="values[]" id="values" value="" class="inputbox one user-field" type="text" /><img class="input-field-remove-img" src="components/com_jsjobs/include/images/remove.png" /></span>';
        jQuery("#user-field-val-button").before(fieldhtml);
    }
    jQuery(document).ready(function () {
        jQuery("body").delegate("img.input-field-remove-img", "click", function () {
            jQuery(this).parent().remove();
        });
    });
</script>
