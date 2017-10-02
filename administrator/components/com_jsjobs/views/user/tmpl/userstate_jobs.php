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

$status = array(
    '0' => JText::_('Pending'),
    '1' => JText::_('Approved'),
    '-1' => JText::_('Rejected'));
?>
<table width="100%">
    <tr>
        <td align="left" width="175" valign="top">
            <table width="100%"><tr><td style="vertical-align:top;">
                        <?php
                        include_once('components/com_jsjobs/views/menu.php');
                        ?>
                    </td>
                </tr></table>
        </td>
        <td width="100%" valign="top">

            <form action="index.php?option=com_jsjobs" method="post" name="adminForm" id="adminForm">

                <table class="adminlist" cellpadding="1">
                    <thead>
                        <tr>
                            <th width="2%" class="title">
                                <?php echo JText::_('Num'); ?>
                            </th>
                            <th class="title"><?php echo JText::_('Name'); ?></th>
                            <th  class="title" ><?php echo JText::_('Company'); ?></th>
                            <th  class="title" ><?php echo JText::_('Category'); ?></th>
                            <th  class="title" ><?php echo JText::_('Start Publishing'); ?></th>
                            <th  class="title" ><?php echo JText::_('Stop Publishing'); ?></th>
                            <th  class="title" ><?php echo JText::_('Created'); ?></th>
                            <th  class="title" ><?php echo JText::_('Status'); ?></th>						</tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="10">
                                <?php echo $this->pagination->getListFooter(); ?>
                            </td>
                        </tr>
                    </tfoot>
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
                                <td><?php echo $row->title; ?></td>
                                <td><?php echo $row->companyname; ?>	</td>
                                <td><?php echo $row->cat_title; ?>	</td>
                                <td><?php echo $row->startpublishing; ?></td>
                                <td><?php echo $row->stoppublishing; ?>	</td>
                                <td><?php echo JHtml::_('date', $row->created, $this->config['date_format']); ?></td>
                                <td class="center">
                                    <?php
                                    if ($row->status == 1)
                                        echo "<font color='green'>" . $status[$row->status] . "</font>";
                                    elseif ($row->status == -1)
                                        echo "<font color='red'>" . $status[$row->status] . "</font>";
                                    else
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

                <input type="hidden" name="option" value="<?php echo $this->option ?>" />
                <input type="hidden" name="task" value="view" />
                <input type="hidden" name="boxchecked" value="0" />
                <input type="hidden" name="bd" value="<?php echo $this->jobuid; ?>" />
                <?php echo JHTML::_('form.token'); ?>
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
