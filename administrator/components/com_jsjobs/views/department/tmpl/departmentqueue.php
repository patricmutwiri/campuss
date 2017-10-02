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
JFactory::getDocument()->addScript(JURI::root().'administrator/components/com_jsjobs/include/js/responsivetable.js');
$status = array(
    '1' => JText::_('Approved'),
    '-1' => JText::_('Rejected'));
?>



<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=department&view=department&layout=departments"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Department Approval Queue'); ?></span></div>
     <form action="index.php" method="post" name="adminForm" id="adminForm">
        <div id="jsjobs_filter_wrapper">
            <span class="jsjobs-filter"><input type="text" name="searchdepartment" placeholder="<?php echo JText::_('Department Name'); ?>" id="searchdepartment" size="15" value="<?php if (isset($this->lists['searchdepartment'])) echo $this->lists['searchdepartment']; ?>" /></span>                   
            <span class="jsjobs-filter"><input type="text" name="searchcompany" placeholder="<?php echo JText::_('Company Name'); ?>"  id="searchcompany" size="15" value="<?php if (isset($this->lists['searchcompany'])) echo $this->lists['searchcompany']; ?>"  /></span>
            <span class="jsjobs-filter"><button class="js-button" onclick="this.form.submit();"><?php echo JText::_('Search'); ?></button></span>
            <span class="jsjobs-filter"><button class="js-button" onclick="document.getElementById('searchdepartment').value = '';
                            document.getElementById('searchcompany').value = '';
                            this.form.submit();"><?php echo JText::_('Reset'); ?></button></span>
        </div>
    <?php if(!empty($this->items)){ ?>

                <table class="adminlist" border="0" id="js-table">
                    <thead>
                        <tr>
                            <th width="20">
                                <?php if (JVERSION < '3') { ?> 
                                    <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
                                <?php } else { ?>
                                    <input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this);" />
                                <?php } ?>
                            </th>
                            <th class="title"><?php echo JText::_('Department'); ?></th>
                            <th class="title"><?php echo JText::_('Company'); ?></th>
                            <th class="center"  width="15%"><?php echo JText::_('Created'); ?></th>
                            <th class="center"  width="15%"><?php echo JText::_('Status'); ?></th>
                        </tr>
                    </thead><tbody>
                    <?php
                    jimport('joomla.filter.output');
                    $k = 0;
                    $approvetask = 'departmentapprove';
                    $approveimg = 'tick2.png';
                    $rejecttask = 'departmentreject';
                    $rejectimg = 'cross.png';
                    $Approvealt = JText::_('Approve');
                    $Rejectalt = JText::_('Reject');
                    for ($i = 0, $n = count($this->items); $i < $n; $i++) {
                        $row = $this->items[$i];
                        $checked = JHTML::_('grid.id', $i, $row->id);
                        $link = JFilterOutput::ampReplace('index.php?option=' . $this->option . '&task=department.edit&cid[]=' . $row->id);
                        ?>
                        <tr valign="top" class="<?php echo "row$k"; ?>">
                            <td>
                                <?php echo $checked; ?>
                            </td>
                            <td class="title">
                                <a href="<?php echo $link; ?>">
                                    <?php echo $row->name; ?></a>
                            </td>
                            <td class="title">
                                <?php echo $row->companyname; ?>
                            </td>
                            <td class="center">
                                <?php echo JHtml::_('date', $row->created, $this->config['date_format']); ?>
                            </td>
                            <td class="center">
                                <a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i; ?>', 'department.<?php echo $approvetask; ?>')">
                                    <img src="components/com_jsjobs/include/images/<?php echo $approveimg; ?>" width="16" height="16" border="0" alt="<?php echo $approvealt; ?>" title="<?php echo JText::_('Approve') ;?>" /></a>
                                &nbsp;&nbsp; - &nbsp;&nbsp
                                <a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i; ?>', 'department.<?php echo $rejecttask; ?>')">
                                    <img src="components/com_jsjobs/include/images/<?php echo $rejectimg; ?>" width="16" height="16" border="0" alt="<?php echo $rejectalt; ?>" title="<?php echo JText::_('Reject') ;?>"/></a>
                            </td>
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
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" name="c" value="department" />
                <input type="hidden" name="view" value="department" />
                <input type="hidden" name="layout" value="departmentqueue" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
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