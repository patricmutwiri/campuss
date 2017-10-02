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

JHTML::_('behavior.calendar');
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


?>
<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=controlpanel"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Payment Report'); ?></span></div>
      <form action="index.php" method="post" name="adminForm" id="adminForm">
          <div id="jsjobs_filter_wrapper">
                  <span class="jsjobs-filter"> <?php echo $this->lists['paymentfor']; ?></span>                   
                  <span class="jsjobs-filter"><?php echo $this->lists['paymentstatus']; ?></span>                   
                  <span class="jsjobs-filter"><?php echo JHTML::_('calendar', $this->lists['searchstartdate'], 'prsearchstartdate', 'prsearchstartdate', $js_dateformat, array('class' => 'inputbox', 'size' => '10', 'maxlength' => '19' , 'placeholder' =>'Date From')); ?></span>
                  <span class="jsjobs-filter"> <?php echo JHTML::_('calendar', $this->lists['searchenddate'], 'prsearchenddate', 'prsearchenddate', $js_dateformat, array('class' => 'inputbox', 'size' => '10', 'maxlength' => '19', 'placeholder' =>'Date To' )); ?></span>
                  <span class="jsjobs-filter"><button class="js-button" onclick="this.form.submit();"><?php echo JText::_('Search'); ?></button></span>
                  <span class="jsjobs-filter"><button class="js-button" onclick="this.form.getElementById('searchpaymentstatus').value = '';
                          document.getElementById('prsearchstartdate').value = '';
                          document.getElementById('prsearchenddate').value = '';
                          this.form.getElementById('paymentfor').value = 'both';
                          this.form.submit();"><?php echo JText::_('Reset'); ?></button></span>
          </div>     
            <?php if(!empty($this->items)){ ?>      
                <table class="adminlist" border="0" id="js-table">
                    <thead>
                        <tr>
                            <th class="title"><?php echo JText::_('Package'); ?></th>
                            <th class="title"><?php echo JText::_('Package For'); ?></th>
                            <th class="title"><?php echo JText::_('Name'); ?></th>
                            <th class="title"><?php echo JText::_('Payer Name'); ?></th>
                            <th class="center"><?php echo JText::_('Paid Amount'); ?></th>
                            <th class="center"><?php echo JText::_('Payment Status'); ?></th>
                            <th class="center"><?php echo JText::_('Created'); ?></th>
                        </tr>
                    </thead><tbody>
                    <?php
                    jimport('joomla.filter.output');
                    $k = 0;
                    for ($i = 0, $n = count($this->items); $i < $n; $i++) {
                        $row = $this->items[$i];
                        ?>
                        <tr valign="top" class="<?php echo "row$k"; ?>">
                            <td aligh="left"><?php echo $row->packagetitle; ?></td>
                            <td aligh="left"><?php echo $row->packagefor; ?></td>
                            <td aligh="left">
                                <?php if ($row->packagefor == 'Employer') { ?>
                                    <a href="index.php?option=com_jsjobs&c=user&view=user&layout=userstate_companies&md=<?php echo $row->uid; ?>"><?php echo $row->buyername; ?></a>
                                <?php } else if ($row->packagefor == 'Job Seeker') { ?>
                                    <a href="index.php?option=com_jsjobs&c=user&view=user&layout=userstate_resumes&ruid=<?php echo $row->uid; ?>"><?php echo $row->buyername; ?></a>
                                <?php } ?>
                            </td>
                            <td aligh="left"><?php echo $row->payer_firstname; ?></td>
                            <td aligh="center"><?php if ($row->paidamount) echo $row->symbol . $row->paidamount; ?></td>
                            <td align="center"><?php if ($row->transactionverified == 1)
                                echo '<strong style="color:green;">'.JText::_('Verified').'</strong>';
                            else
                                echo '<strong style="color:red;">'.JText::_('Not Verified').'</strong>';
                            ?></td>
                            <td align="center"><?php echo JHtml::_('date', $row->created, $this->config['date_format']); ?></td>

                        </tr>
                        <?php
                        $k = 1 - $k;
                    }
                    ?>
 <tbody>
                </table>
                                
                 <div id="jsjobs-pagination-wrapper">
                    <?php echo $this->pagination->getLimitBox(); ?>
                    <?php echo $this->pagination->getListFooter(); ?>
                </div>
<?php }else{ JSJOBSlayout::getNoRecordFound(); } ?>

                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" name="c" value="paymenthistory" />
                <input type="hidden" name="view" value="paymenthistory" />
                <input type="hidden" name="layout" value="payment_report" />
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


