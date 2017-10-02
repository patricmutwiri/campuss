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
JFactory::getDocument()->addScript(JURI::root().'administrator/components/com_jsjobs/include/js/responsivetable.js');
?>
<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    

    <div id="full_background" style="display:none;"></div>
    <div id="popup_main" style="display:none;">

    </div>

    <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=controlpanel"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Field Ordering'); ?></span></div>
       <form action="index.php?option=com_jsjobs" method="post" name="adminForm" id="adminForm">
            <div id="jsjobs_filter_wrapper">           
                    <span class="jsjobs-filter"><input type="text" name="fieldtitle" placeholder="<?php echo JText::_('Title'); ?>" id="fieldtitle" value="<?php if (isset($this->lists['fieldtitle'])) echo $this->lists['fieldtitle']; ?>"  /></span>
                    <span class="jsjobs-filter"><?php echo $this->lists['userpublish']; ?></span>
                    <span class="jsjobs-filter"><?php echo $this->lists['visitorpublish']; ?></span>
                    <span class="jsjobs-filter"><?php echo $this->lists['fieldrequired']; ?></span>
                    <span class="jsjobs-filter"><button class="js-button" onclick="this.form.submit();"><?php echo JText::_('Search'); ?></button></span>
                    <span class="jsjobs-filter"><button class="js-button" onclick="document.getElementById('fieldtitle').value = '';document.getElementById('userpublish').value = '';document.getElementById('visitorpublish').value = '';document.getElementById('fieldrequired').value = ''; this.form.submit();"><?php echo JText::_('Reset'); ?></button></span>
            </div>
            <?php if(!empty($this->items)){ ?>      
                <table class="adminlist" cellpadding="1" border="0" id="js-table">
                    <thead>
                        <tr>
                            <th width="2%" class="title">
                                <?php echo JText::_('Num'); ?>
                            </th>
                            <th width="3%"  class="center">
                                <?php if (JVERSION < '3') { ?> 
                                    <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
                                <?php } else { ?>
                                    <input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this);" />
                                <?php } ?>
                            </th>
                            <th width="25%" class="title bold" > <span class="blackcolor"><?php echo JText::_('Field Title'); ?></span></th>
                            <th width="5%" class="center bold" nowrap="nowrap"><span class="blackcolor"><?php echo JText::_('Section'); ?></span></th>
                            <th width="5%" class="center bold"><span class="blackcolor"><?php echo JText::_('User Published'); ?></span></th>
                            <th width="5%" class="center bold"><span class="blackcolor"><?php echo JText::_('Visitor Published'); ?> </span>    </th>
                            <th width="5%" class="center bold"><span class="blackcolor"><?php echo JText::_('Required'); ?>  </span> </th>
                            <th width="10%" class="center bold" nowrap="nowrap"><span class="blackcolor"><?php echo JText::_('Ordering'); ?></span></th>
                            <th width="10%" class="center bold" nowrap="nowrap"><span class="blackcolor"><?php echo JText::_('Action'); ?></span></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="10">
                                <?php //echo $this->pagination->getListFooter();  ?>
                            </td>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        $k = 0;
                        for ($i = 0, $n = count($this->items); $i < $n; $i++) {
                            $row = $this->items[$i];
                            if (isset($this->items[$i + 1]))
                                $row1 = $this->items[$i + 1];
                            else
                                $row1 = $this->items[$i];
                            $uptask = 'fieldorderingup';
                            $upimg = 'uparrow.png';
                            $downtask = 'fieldorderingdown';
                            $downimg = 'downarrow.png';

                            $pubtask = $row->published ? 'fieldunpublished' : 'fieldpublished';
                            $pubimg = $row->published ? 'tick1.png' : 'cross.png';
                            $alt = $row->published ? JText::_('Published') : JText::_('Unpublished');

                            $visitorpubtask = $row->isvisitorpublished ? 'visitorfieldunpublished' : 'visitorfieldpublished';
                            $visitorpubimg = $row->isvisitorpublished ? 'tick1.png' : 'cross.png';
                            $visitoralt = $row->isvisitorpublished ? JText::_('Published') : JText::_('Unpublished');

                            $requiredtask = $row->required ? 'fieldnotrequired' : 'fieldrequired';
                            $requiredpubimg = $row->required ? 'tick1.png' : 'cross.png';
                            $Requiredalt = $row->required ? JText::_('Required') : JText::_('Notrequired');


                            $checked = JHTML::_('grid.id', $i, $row->id);
                            $link = JFilterOutput::ampReplace('index.php?option=' . $this->option . '&task=fieldordering.edit&cid[]=' . $row->id);
                            ?>
                            <tr class="<?php echo "row$k"; ?>">
                                <td>
                                    <?php echo $i + 1 + $this->pagination->limitstart; ?>
                                </td>
                                <td align="center">
                                    <?php echo JHTML::_('grid.id', $i, $row->id); ?>
                                </td>
                                <?php
                                $sec = substr($row->field, 0, 8); //get section_
                                $newsection = 0;
                                if ($sec == 'section_') {
                                    $newsection = 1;
                                    $subsec = substr($row->field, 0, 12);
                                    if ($subsec == 'section_sub_') {
                                        ?>
                                        <td colspan="2" align="center"><strong><?php echo $row->fieldtitle; ?></strong></td>
                                    <?php } else { ?>
                                        <td colspan="2" align="center"><strong><font size="2"><?php echo $row->fieldtitle; ?></font></strong></td>
                                    <?php } ?>

                                    <td align="center">
                                        <?php if ($row->cannotunpublish == 1) { ?>
                                            <img src="components/com_jsjobs/include/images/<?php echo $pubimg; ?>" width="16" height="16" border="0" alt="<?php echo JText::_('Can Not Unpublished'); ?>" />
                                        <?php } else { ?>
                                            <a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i; ?>', 'fieldordering.<?php echo $pubtask; ?>')">
                                                <img src="components/com_jsjobs/include/images/<?php echo $pubimg; ?>" width="16" height="16" border="0"  /></a>
                                        <?php } ?>
                                    </td>
                                    <td align="center" colspan="1">
                                        <?php if ($row->cannotunpublish == 1) { ?>
                                            <img src="components/com_jsjobs/include/images/<?php echo $visitorpubimg; ?>" width="16" height="16" border="0" alt="<?php echo JText::_('Can Not Unpublished'); ?>" />
                                        <?php } else { ?>
                                            <a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i; ?>', 'fieldordering.<?php echo $visitorpubtask; ?>')">
                                                <img src="components/com_jsjobs/include/images/<?php echo $visitorpubimg; ?>" width="16" height="16" border="0" alt="<?php echo $visitoralt; ?>" /></a>
                                        <?php } ?>
                                    </td>
                                    <td colspan="3"></td>
                                <?php } else { ?>
                            <!--    <td ><?php //echo $row->name;   ?></td> -->
                                    <td><?php if ($row->fieldtitle)
                                echo JText::_($row->fieldtitle);
                            else
                                echo $row->userfieldtitle;
                            ?></td>
                                    <td><?php echo $row->section; ?></td>
                                    <td align="center">
        <?php if ($row->cannotunpublish == 1) { ?>
                                            <img src="components/com_jsjobs/include/images/<?php echo $pubimg; ?>" width="16" height="16" border="0" alt="<?php echo JText::_('Can Not Unpublished'); ?>" />
                                        <?php } else { ?>
                                            <a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i; ?>', 'fieldordering.<?php echo $pubtask; ?>')">
                                                <img src="components/com_jsjobs/include/images/<?php echo $pubimg; ?>" width="16" height="16" border="0"  /></a>
                                        <?php } ?>
                                    </td>
                                    <td align="center">
        <?php if ($row->cannotunpublish == 1) { ?>
                                            <img src="components/com_jsjobs/include/images/<?php echo $visitorpubimg; ?>" width="16" height="16" border="0" alt="<?php echo JText::_('Can Not Unpublished'); ?>" />
                                        <?php } else { ?>
                                            <a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i; ?>', 'fieldordering.<?php echo $visitorpubtask; ?>')">
                                                <img src="components/com_jsjobs/include/images/<?php echo $visitorpubimg; ?>" width="16" height="16" border="0" alt="<?php echo $visitoralt; ?>" /></a>
                                        <?php } ?>
                                    </td>
                                    <td align="center">
                                        <?php if ($row->sys == 1 || ($row->isuserfield == 1 && $row->userfieldtype == 'checkbox')) { ?>
                                            <img src="components/com_jsjobs/include/images/<?php echo $requiredpubimg; ?>" width="16" height="16" border="0" alt="<?php echo $requiredalt; ?>" />
                                        <?php } else { ?>
                                            <a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i; ?>', 'fieldordering.<?php echo $requiredtask; ?>')">
                                                <img src="components/com_jsjobs/include/images/<?php echo $requiredpubimg; ?>" width="16" height="16" border="0" alt="<?php echo $requiredalt; ?>" /></a>
                                        <?php } ?>
                                    </td>
                                    <td class="center">
                                        <?php
                                        if ($row->ordering != 1) {
                                            if ($newsection != 1) {
                                                ?>      
                                                <a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i; ?>', 'fieldordering.<?php echo $downtask; ?>')">
                                                    <img src="components/com_jsjobs/include/images/<?php echo $upimg; ?>" width="16" height="16" border="0" alt="<?php echo JText::_('Order Up');?>" /></a>
                                            <?php
                                            } else
                                                echo '&nbsp;&nbsp;&nbsp;&nbsp;';
                                        } else
                                            echo '&nbsp;&nbsp;&nbsp;&nbsp;';
                                        ?>  
                                        &nbsp;&nbsp;<?php echo $row->ordering; ?>&nbsp;&nbsp;
                                        <?php
                                        //if ($i < $n-1) { 
                                        if ($row->section == $row1->section) {
                                            ?>
                                            <a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i; ?>', 'fieldordering.<?php echo $uptask; ?>')">
                                                <img src="components/com_jsjobs/include/images/<?php echo $downimg; ?>" width="16" height="16" border="0" alt="<?php echo JText::_('Order Down');?>" /></a>
                                    <?php
                                    }
                                    //} 
                                    ?>  
                                    </td>
                                    <td class="center">
                                        <a href="javascript:void(0);" onclick="showPopupAndSetValues(<?php echo $row->id; ?>)" ><img src="components/com_jsjobs/include/images/edit.png" title="<?php echo JText::_('Edit'); ?>"></a>
                                        <?php if ($row->isuserfield == 1) { ?>  
                                            <a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i; ?>', 'fieldordering.deleteuserfield');">
                                            <img src="components/com_jsjobs/include/images/remove.png" title="<?php echo JText::_('Delete'); ?>"></a>
                                        <?php } ?>
                                    </td>
                                <?php
                                $newsection = 0;
                            }
                            ?>
                            </tr>

                                    <?php
                                    $k = 1 - $k;
                                }
                                ?>


                    </tbody>
                </table>
                <div id="jsjobs-pagination-wrapper">
                    <?php echo $this->pagination->getLimitBox(); ?>
                    <?php echo $this->pagination->getListFooter(); ?>
                </div>
<?php }else{ JSJOBSlayout::getNoRecordFound(); } ?>

                <?php
                    $session = JFactory::getSession();
                    $session->set('fieldfor',$this->ff);
                ?>
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" name="ff" value="<?php echo $this->ff; ?>" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <input type="hidden" name="c"  value="fieldordering" />
                <input type="hidden" name="view"  value="fieldordering" />
                <input type="hidden" name="layout"  value="fieldsordering" />
                <input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
                <input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
<?php echo JHTML::_('form.token'); ?>
            </form>
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

    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery("div#full_background").click(function () {
                closePopup();
            });
        });

        function resetFrom() {
            jQuery("input#title").val('');
            jQuery("select#ustatus").val('');
            jQuery("select#vstatus").val('');
            jQuery("select#required").val('');
            jQuery("form#jsjobsform").submit();
        }

        function showPopupAndSetValues(id) {
            jQuery.post("index.php?option=com_jsjobs&task=fieldordering.getOptionsForFieldEdit", {field: id}, function (data) {
                if (data) {
                    var d = jQuery.parseJSON(data);
                    jQuery("div#full_background").css("display", "block");
                    jQuery("div#popup_main").html(d);
                    jQuery("div#popup_main").slideDown('slow');
                }
            });
        }

        function closePopup() {
            jQuery("div#popup_main").slideUp('slow');
            setTimeout(function () {
                jQuery("div#full_background").hide();
                jQuery("div#popup_main").html('');
            }, 700);
        }
    </script>
