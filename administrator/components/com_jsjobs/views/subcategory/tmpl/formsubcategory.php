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
            if (task == 'subcategory.savesubcategory') {
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
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=subcategory&view=subcategory&layout=subcategories&cd=<?php echo $this->categoryid;?>"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a>
            <?php if (isset($this->subcategory->id)){ ?>
            <span id="heading-text"><?php echo JText::_('Edit Sub Category'); ?></span>
            <?php }else{ ?>
            <span id="heading-text"><?php echo JText::_('Form Sub Category'); ?></span>
            <?php } ?>
        </div>
        <form action="index.php" method="POST" name="adminForm" id="adminForm" >
            <div class="js-form-area">
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for=""><strong><?php echo JText::_('Category'); ?>:&nbsp;</strong></label>
                    <div class="jsjobs-value"><strong>&nbsp;<?php if (isset($this->subcategory)) echo $this->subcategory->cat_title; ?></strong></div>
                </div>

                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="title"><?php echo JText::_('Category Title'); ?>:&nbsp;</label>
                    <div class="jsjobs-value"><input class="inputbox required" type="text" name="title" id="title" size="40" maxlength="255" value="<?php if (isset($this->subcategory->title)) echo $this->subcategory->title; ?>" /></div>
                </div>


                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="status"><?php echo JText::_('Status'); ?></label>
                    <div class="jsjobs-value"><div class="div-white"><span class="js-cross"><input type="checkbox" name="status" id="status" value="1" <?php
                                                     if (isset($this->subcategory->status)) {
                                                         if ($this->subcategory->status == '1')
                                                             echo 'checked';
                                                     }else{
                                                        echo 'checked';
                                                     }
?>/></span> <label class="js-publish" for="status" ><?php echo JText::_('Publish'); ?></label>
                                                     </div>
                    </div>
                </div>

              <input type="hidden" name="id" value="<?php if (isset($this->subcategory)) if (isset($this->subcategory->id)) echo $this->subcategory->id; ?>" />
                <input type="hidden" name="categoryid" value="<?php
                                    if (isset($this->subcategory))
                                        if ($this->subcategory->categoryid)
                                            echo $this->subcategory->categoryid;
                                        else
                                            echo $this->categoryid;
                                    else
                                        echo $this->categoryid;
?>" />
                <input type="hidden" name="isdefault" value="<?php if (isset($this->subcategory)) echo $this->subcategory->isdefault; ?>" />
                <input type="hidden" name="ordering" value="<?php if (isset($this->subcategory)) echo $this->subcategory->ordering; ?>" />

                <input type="hidden" name="task" value="subcategory.savesubcategory" />
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" name="check" value="post"/>



            
            </div>
            <div class="js-buttons-area">
                <a class="js-btn-cancel" href="index.php?option=com_jsjobs&c=subcategory&view=subcategory&layout=subcategories&cd=1"><?php echo JText::_('Cancel'); ?></a>
                <input type="submit" class="js-btn-save" name="submit_app" onclick="return validate_form(document.adminForm)" value="<?php echo JText::_('Save Sub Category'); ?>" />
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










