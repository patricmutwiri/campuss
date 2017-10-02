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
$document = JFactory::getDocument();
if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('../components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}
?>
<script language="javascript">
// for joomla 1.6
    Joomla.submitbutton = function (task) {
        if (task == '') {
            return false;
        } else {
            if (task == 'addressdata.save') {
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
        <form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=controlpanel"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Load Address Data'); ?></span></div>
         <div id="addresstop_bluebar">
            <img class="imglogo" src="components/com_jsjobs/include/images/logo-address.png">
            <label class="joomsky_title"><?php echo JText::_('Joomsky'); ?></label>
            <label class="joomsky_detail"><?php echo JText::_('Download From Joomsky Website'); ?></label>
            <a class="download_class" href="http://www.joomsky.com/index.php/download-buy/product/product/8/43" target="_blank" ><img id="loadaddressdata_downloadbutton" src="components/com_jsjobs/include/images/download-buttonpng.png"/></a>
         </div><!--Top Blue Bar closed-->
         <div id="main_address_data">
            <div id="data_row">   
               <label class="label_name" ><?php echo JText::_('Action').' : '; ?></label>
               <span class="combo_block" ><input type="radio" class="combo_box" name="datakept" id="option1" value="1" /><label class="combo_label" for="option1"><?php echo JText::_('Kept Data'); ?></label></span>
               <span class="combo_block" ><input type="radio" class="combo_box" name="datakept" id="option2" checked="checked" value="2" /><label class="combo_label" for="option2"><?php echo JText::_('Discard Old Data Jobs And Companies Data May Disturb'); ?></label></span>
            </div> 
            <div id="data_row"> 
               <label class="label_name" ><?php echo JText::_('File').' : '; ?></label>
               <span class="combo_block" ><input type="radio" class="combo_box" name="fileowner" id="fileowner1" value="1" /><label class="combo_label" for="fileowner1"><?php echo JText::_('My File'); ?></label></span>
               <span class="combo_block" ><input type="radio" class="combo_box" name="fileowner" id="fileowner2" checked="checked" value="2" /><label class="combo_label" for="fileowner2"><?php echo JText::_('Joomsky File'); ?></label></span>
            </div>
            <div id="data_row">  
               <label class="label_name" ><?php echo JText::_('Data Contain').' : '; ?></label>
               <span class="combo_block" ><input type="radio" class="combo_box" name="datacontain" id="datacontain1" value="1" /><label class="combo_label" for="datacontain1"><?php echo JText::_('States'); ?></label></span>
               <span class="combo_block" ><input type="radio" class="combo_box" name="datacontain" id="datacontain2" value="2" /><label class="combo_label" for="datacontain2"><?php echo JText::_('Cities'); ?></label></span>
               <span class="combo_block" ><input type="radio" class="combo_box" name="datacontain" id="datacontain3" checked="checked" value="3" /><label class="combo_label" for="datacontain3"><?php echo JText::_('States And Cities'); ?></label></span>
            </div>
            <div id="data_row"> 
               <label class="label_name" ></label> 
               <span id="loadaddressdata_msg" class="combo_block_mesg"><?php echo JText::_('Make sure you did not changed country id or state id in database'); ?></span>
            </div>   
            <div id="data_row"> 
               <label class="label_name" ><?php echo JText::_('File').' : '; ?><font color="red">*</font>&nbsp;</label>
               <span class="file_label"><input type="file" class="inputbox  required" name="loadaddressdata" id="loadaddressdata" size="20" maxlenght='30'/></span>
            </div>   
            <div id="main_address_data_bottom"></div>
            <div id="data_row"> 

               <input class="button" type="submit" name="submit_app" id="submitbutton" value="<?php echo JText::_('Load Address Data'); ?>" onclick="return validate_form(document.adminForm)" />
            </div> 
         </div><!--main address closed-->
         
         <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
         <input type="hidden" name="task" value="addressdata.loadaddressdata" />
         <input type="hidden" name="check" value="" />
        <?php echo JHTML::_( 'form.token' ); ?>        
    </form>
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


<script>
    jQuery("input[type=radio]").change(function () {
        var keptdata = jQuery("#option1").is(':checked');
        var discarddata = jQuery("#option2").is(':checked');
        var myfile = jQuery("#fileowner1").is(':checked');
        var joomskyfile = jQuery("#fileowner2").is(':checked');
        var states = jQuery("#datacontain1").is(':checked');
        var cities = jQuery("#datacontain2").is(':checked');
        var statesandcities = jQuery("#datacontain3").is(':checked');
        var msg = '';
        if (keptdata == true) {
            if (myfile == true) {
                if (states == true) {
                    msg = "<?php echo JText::_('State id must be unique in database state table') ?>";
                } else if (cities == true) {
                    msg = "<?php echo JText::_('Do not define city id and properly define country and state id in file') ?>";
                } else if (statesandcities == true) {
                    msg = "<?php echo JText::_('Do not define city id and state id must be unique state database table. Make sure properly define state id and country id in file') ?>";
                }
            } else if (joomskyfile == true) {
                if (states == true) {
                    msg = "";
                } else if (cities == true) {
                    msg = "<?php echo JText::_('Make sure countries and states were not edit other wise problem may occurred') ?>";
                } else if (statesandcities == true) {
                    msg = "<?php echo JText::_('Make sure you did not changed country id or state id in database') ?>";
                }
            }
        } else if (discarddata == true) {
            if (myfile == true) {
                if (states == true) {
                    msg = "<?php echo JText::_('State id must be unique in database state table') ?>";
                } else if (cities == true) {
                    msg = "<?php echo JText::_('Do not define city id and properly define country and state id in file') ?>";
                } else if (statesandcities == true) {
                    msg = "<?php echo JText::_('Do not define city id and state id must be unique state database table. Make sure properly define state id and country id in file') ?>";
                }
            } else if (joomskyfile == true) {
                if (states == true) {
                    msg = "";
                } else if (cities == true) {
                    msg = "<?php echo JText::_('Make sure countries and states were not edit other wise problem may occurred') ?>";
                } else if (statesandcities == true) {
                    msg = "<?php echo JText::_('Make sure you did not changed country id or state id in database') ?>";
                }
            }
        }

        if (msg != "") {
            jQuery("span#loadaddressdata_msg").html(msg);
            jQuery("div#loadaddressdata_msg").slideDown("slow");
        } else
            jQuery("div#loadaddressdata_msg").slideUp("slow");
    });
</script>