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
?>

<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=paymenthistory&view=paymenthistory&layout=jobseekerpaymenthistory"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Payment History Details'); ?></span></div>
        <div class="js-phd-head"><?php echo $this->items->packagetitle; ?></div>
        <div id="js-phd-data" class="js-phd-data">
            <div class="js-phd-row">
                <div class="js-col-xs-12 js-col-md-6 js-phd-title"><?php echo JText::_('Payer Name');?></div>
                <div class="js-col-xs-12 js-col-md-6 js-phd-value"><?php echo $this->items->payer_firstname . ' ' . $this->items->payer_lastname;?></div>
            </div>
            <div class="js-phd-row">
                <div class="js-col-xs-12 js-col-md-6 js-phd-title"><?php echo JText::_('Payer E-mail');?></div>
                <div class="js-col-xs-12 js-col-md-6 js-phd-value"><?php echo $this->items->payer_email;?></div>
            </div>
            <div class="js-phd-row">
                <div class="js-col-xs-12 js-col-md-6 js-phd-title"><?php echo JText::_('Payer Amount');?></div>
                <div class="js-col-xs-12 js-col-md-6 js-phd-value"><?php echo $this->items->payer_amount;?></div>
            </div>
            <div class="js-phd-row">
                <div class="js-col-xs-12 js-col-md-6 js-phd-title"><?php echo JText::_('Payer Item Name');?></div>
                <div class="js-col-xs-12 js-col-md-6 js-phd-value"><?php echo $this->items->payer_itemname;?></div>
            </div>
            <div class="js-phd-row">
                <div class="js-col-xs-12 js-col-md-6 js-phd-title"><?php echo JText::_('Payer Item Name2');?></div>
                <div class="js-col-xs-12 js-col-md-6 js-phd-value"><?php echo $this->items->payer_itemname1;?></div>
            </div>
            <div class="js-phd-row">
                <div class="js-col-xs-12 js-col-md-6 js-phd-title"><?php echo JText::_('Transaction Verified');?></div>
                <div class="js-col-xs-12 js-col-md-6 js-phd-value"><?php if ($this->items->transactionverified == 1) echo JText::_('Approve'); else echo JText::_('Reject'); ?></div>
            </div>
            <div class="js-phd-row">
                <div class="js-col-xs-12 js-col-md-6 js-phd-title"><?php echo JText::_('Transaction Auto Verified');?></div>
                <div class="js-col-xs-12 js-col-md-6 js-phd-value"><?php if ($this->items->transactionautoverified == 1) echo JText::_('Auto Approve'); else echo JText::_('Manual Approved'); ?></div>
            </div>
            <div class="js-phd-row">
                <div class="js-col-xs-12 js-col-md-6 js-phd-title"><?php echo JText::_('Verify Date');?></div>
                <div class="js-col-xs-12 js-col-md-6 js-phd-value"><?php echo JHtml::_('date', $this->items->verifieddate, $this->config['date_format']); ?></div>
            </div>
            <div class="js-phd-row">
                <div class="js-col-xs-12 js-col-md-6 js-phd-title"><?php echo JText::_('Paid Amount');?></div>
                <div class="js-col-xs-12 js-col-md-6 js-phd-value"><?php echo $this->items->paidamount; ?></div>
            </div>
            <div class="js-phd-row">
                <div class="js-col-xs-12 js-col-md-6 js-phd-title"><?php echo JText::_('Created');?></div>
                <div class="js-col-xs-12 js-col-md-6 js-phd-value"><?php echo JHtml::_('date', $this->items->created, $this->config['date_format']); ?></div>
            </div>
            <div class="js-phd-row">
                <div class="js-col-xs-12 js-col-md-6 js-phd-title"><?php echo JText::_('Status');?></div>
                <div class="js-col-xs-12 js-col-md-6 js-phd-value"><?php if ($this->items->status == 1) echo JText::_('Approved'); else echo JText::_('Rejected'); ?></div>
            </div>
        </div>
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
