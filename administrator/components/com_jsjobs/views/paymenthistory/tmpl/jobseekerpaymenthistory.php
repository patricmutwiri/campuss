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
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=controlpanel"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Job Seeker Payment History'); ?></span></div>

     <form action="index.php" method="post" name="adminForm" id="adminForm">
         <div id="jsjobs_filter_wrapper" class="jsjobs_filter_wrapper_class">
             <span class="jsjobs-filter"><input type="text" name="searchtitle"  placeholder="<?php echo JText::_('Title'); ?>" id="searchtitle" size="15" value="<?php if (isset($this->lists['searchtitle'])) echo $this->lists['searchtitle']; ?>"  /></span>                   
             <span class="jsjobs-filter"><input type="text" name="searchempname"  placeholder="<?php echo JText::_('Employee Name'); ?>" id="searchempname" size="15" value="<?php if (isset($this->lists['searchempname'])) echo $this->lists['searchempname']; ?>"  /></span>                   
             <span class="jsjobs-filter"><input type="text" name="searchprice"  placeholder="<?php echo JText::_('Price'); ?>" id="searchprice" size="15" value="<?php if (isset($this->lists['searchprice'])) echo $this->lists['searchprice']; ?>" /></span>                   
             <span class="jsjobs-filter"><span class="default-hidden"><?php echo $this->lists['paymentstatus']; ?></span></span>
             <span class="jsjobs-filter"><span class="default-hidden"><?php echo JHTML::_('calendar', $this->lists['searchdatestart'], 'searchdatestart', 'searchdatestart', $js_dateformat, array('placeholder' => JText::_('Date Start'),'class' => 'inputbox validate-since', 'size' => '10', 'maxlength' => '19')); ?></span></span>
             <span class="jsjobs-filter"><span class="default-hidden"><?php echo JHTML::_('calendar', $this->lists['searchdateend'], 'searchdateend', 'searchdateend', $js_dateformat, array('placeholder' => JText::_('Date End'),'class' => 'inputbox validate-since', 'size' => '10', 'maxlength' => '19')); ?></span></span>
             <span class="jsjobs-filter"><button class="js-button" onclick="this.form.submit();"><?php echo JText::_('Search'); ?></button></span>
             <span class="jsjobs-filter"><button class="js-button" onclick="document.getElementById('searchtitle').value = '';
                     document.getElementById('searchempname').value = '';
                     document.getElementById('searchprice').value = '';
                     document.getElementById('searchpaymentstatus').value = '';
                     document.getElementById('searchdatestart').value = '';
                     document.getElementById('searchdateend').value = '';
                     this.form.submit();"><?php echo JText::_('Reset'); ?></button></span>
             <span class="jsjobs-filter"><span id="showhidefilter"><img src="components/com_jsjobs/include/images/filter-down.png"/></span></span>
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
                            <th ><?php echo JText::_('Title'); ?></th>
                            <th class="left"><?php echo JText::_('Job Seeker Name'); ?></th>
                            <th class="center"><?php echo JText::_('Price'); ?></th>
                            <th class="center"><?php echo JText::_('Discount Amount'); ?></th>
                            <th class="center"><?php echo JText::_('Created'); ?></th>
                            <th class="center"><?php echo JText::_('Payment Status'); ?></th>
                            <th class="center"><?php echo JText::_('Purchase Status'); ?></th>
                            <th class="center"><?php echo JText::_('Verify Payment'); ?></th>
                        </tr>
                    </thead><tbody>
                    <?php
                    jimport('joomla.filter.output');
                    $k = 0;
                    $approvetask = 'jobseekerpaymentapprove';
                    $approveimg = 'tick2.png';
                    $rejecttask = 'jobseekerpaymentereject';
                    $rejectimg = 'cross.png';
                    $Approvealt = JText::_('Approve');
                    $Rejectalt = JText::_('Reject');

                    for ($i = 0, $n = count($this->items); $i < $n; $i++) {
                        $row = $this->items[$i];
                        $checked = JHTML::_('grid.id', $i, $row->id);
                        $link = JFilterOutput::ampReplace('index.php?option=' . $this->option . '&task=paymenthistory.edit&cid[]=' . $row->id);
                        ?>
                        <tr valign="top" class="<?php echo "row$k"; ?>">
                            <td>
                                <?php echo $checked; ?>
                            </td>


                            <td ><a href="index.php?option=com_jsjobs&c=paymenthistory&view=paymenthistory&layout=jobseekerpaymentdetails&pk=<?php echo $row->id; ?>"><?php echo $row->packagetitle; ?></a></td>
                            <td align="left"><?php echo $row->jobseekername; ?></td>
                            <td align="center"><?php echo $row->symbol . $row->packageprice; ?></td>
                            <td align="center"><?php if ($row->discountamount) echo $row->symbol . $row->discountamount; ?></td>
                            <td align="center"><?php echo JHtml::_('date', $row->created, $this->config['date_format']); ?></td>
                            <td align="center"><?php if ($row->transactionverified == 1)
                                echo '<strong style="color:green;">'.JText::_('Verified').'</strong>';
                            else
                                echo '<strong style="color:red;">'.JText::_('Not Verified').'</strong>';
                            ?></td>
                            <td align="center"><?php if ($row->status == 1)
                                echo '<strong style="color:green;">'.JText::_('Verified').'</strong>';
                            else
                                echo '<strong style="color:red;">'.JText::_('Not Verified').'</strong>';
                            ?></td>
                            <td class="center">
                                <a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i; ?>', 'paymenthistory.<?php echo $approvetask; ?>')">
                                    <img src="components/com_jsjobs/include/images/<?php echo $approveimg; ?>" width="16" height="16" border="0" alt="<?php echo $approvealt; ?>" /></a>
                                &nbsp;&nbsp; - &nbsp;&nbsp
                                <a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i; ?>', 'paymenthistory.<?php echo $rejecttask; ?>')">
                                    <img src="components/com_jsjobs/include/images/<?php echo $rejectimg; ?>" width="16" height="16" border="0" alt="<?php echo $rejectalt; ?>" /></a>
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
                <input type="hidden" name="c" value="paymenthistory" />
                <input type="hidden" name="view" value="paymenthistory" />
                <input type="hidden" name="layout" value="jobseekerpaymenthistory" />
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

<script>
    jQuery(document).ready(function(){
      

            jQuery("span#showhidefilter").click(function(e){
            e.preventDefault();
            var img2 = "<?php echo JURI::root()."administrator/components/com_jsjobs/include/images/filter-up.png";?>";
            var img1 = "<?php echo JURI::root()."administrator/components/com_jsjobs/include/images/filter-down.png";?>";
            if(jQuery('.default-hidden').is(':visible')){
            jQuery(this).find('img').attr('src',img1);
            }else{
            jQuery(this).find('img').attr('src',img2);
            }
            jQuery(".default-hidden").toggle();
            var height = jQuery(this).height();
            var imgheight = jQuery(this).find('img').height();
            var currenttop = (height-imgheight) / 2;
            jQuery(this).find('img').css('top',currenttop);
        });

    });
    


</script>
