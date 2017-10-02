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
    '-1' => JText::_('Rejected'),
    '0' => JText::_('Pending'));
?>



<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=paymenthistory&view=paymenthistory&layout=payment_report"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Job Seeker Stats'); ?></span></div>
     <form action="index.php" method="post" name="adminForm" id="adminForm">

    <?php if(!empty($this->items)){ ?>

                <table width="100%">
    <tr>
        
        <td width="100%" valign="top">

            <form action="index.php" method="post" name="adminForm" id="adminForm">

                <table class="adminlist" border="0" id="js-table">
                    <thead>
                        <tr>
                            <th width="2%" class="title">
                                <?php echo JText::_('Num'); ?>
                            </th>
                            <th class="title"><?php echo JText::_('Name'); ?></th>
                            <th  class="title" ><?php echo JText::_('Application Title'); ?></th>
                            <th  class="title" ><?php echo JText::_('Category'); ?></th>
                            <th  class="center" ><?php echo JText::_('Created'); ?></th>
                            <th  class="center" ><?php echo JText::_('Status'); ?></th>                      </tr>
                    </thead>
                    <tbody>
                        <?php
                        $k = 0;
                        for ($i = 0, $n = count($this->items); $i < $n; $i++) {
                            $row = $this->items[$i];
                            ?>
                            <tr class="<?php echo "row$k"; ?>">
                                <td>
                                    <?php echo $i + 1 + $this->pagination->limitstart; ?>
                                </td>
                                <td><?php echo $row->first_name . ' ' . $row->last_name; ?></td>
                                <td><?php echo $row->application_title; ?>  </td>
                                <td><?php echo $row->cat_title; ?>  </td>
                                <td align="center"><?php echo JHtml::_('date', $row->created, $this->config['date_format']); ?></td>
                                <td class="center">
                                    <?php
                                    if ($row->status == 1)
                                        echo "<font color='green'>" . $status[$row->status] . "</font>";
                                    elseif ($row->status == -1)
                                        echo "<font color='red'>" . $status[$row->status] . "</font>";
                                    elseif ($row->status == 0)
                                        echo "<font color='blue'>" . $status[$row->status] . "</font>";
                                    ?>
                                </td>
                            </tr>
                            <?php
                            $k = 1 - $k;
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </td>
    </tr>
</table>                                        

                <div id="jsjobs-pagination-wrapper">
                    <?php echo $this->pagination->getLimitBox(); ?>
                    <?php echo $this->pagination->getListFooter(); ?>
                </div>
        <?php }else{ JSJOBSlayout::getNoRecordFound(); } ?>
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" name="c" value="user" />
                <input type="hidden" name="view" value="user" />
                <input type="hidden" name="layout" value="userstate_resumes" />
                <input type="hidden" name="ruid" value="<?php if($this->resumeuid) echo $this->resumeuid; else echo ''; ?>" />
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
