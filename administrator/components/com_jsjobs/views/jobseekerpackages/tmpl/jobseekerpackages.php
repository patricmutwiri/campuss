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
    <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=controlpanel"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Job Seeker Packages'); ?></span></div>
       <form action="index.php" method="post" name="adminForm" id="adminForm">
           <div id="jsjobs_filter_wrapper">
               <span class="jsjobs-filter"><input type="text" name="searchtitle" placeholder="<?php echo JText::_('Title'); ?>" id="searchtitle" size="15" value="<?php if (isset($this->lists['searchtitle'])) echo $this->lists['searchtitle']; ?>"  /></span>                   
               <span class="jsjobs-filter"><input type="text" name="searchprice" placeholder="<?php echo JText::_('Price'); ?>" id="searchprice" size="15" value="<?php if (isset($this->lists['searchprice'])) echo $this->lists['searchprice']; ?>"/></span>
               <span class="jsjobs-filter"><?php echo $this->lists['searchstatus']; ?></span>
               <span class="jsjobs-filter"><button class="js-button" onclick="this.form.submit();"><?php echo JText::_('Search'); ?></button></span>
               <span class="jsjobs-filter"><button class="js-button" onclick="document.getElementById('searchtitle').value = '';
                               document.getElementById('searchprice').value = '';document.getElementById('searchstatus').value = '';
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
                            <th  width="50%" class="title"><?php echo JText::_('Title'); ?></th>
                            <th  width="15%" class="center"><?php echo JText::_('Price'); ?></th>
                            <th  width="15%"  class="center"><?php echo JText::_('Discount'); ?></th>
                            <th width="15%" class="center"><?php echo JText::_('Published'); ?></th>
                        </tr>
                    </thead><tbody>
                    <?php
                    jimport('joomla.filter.output');
                    $k = 0;
                    $currency_align = $this->config['currency_align'];
                    for ($i = 0, $n = count($this->items); $i < $n; $i++) {
                        $row = $this->items[$i];
                        $checked = JHTML::_('grid.id', $i, $row->id);
                        $link = JFilterOutput::ampReplace('index.php?option=' . $this->option . '&task=jobseekerpackages.edit&cid[]=' . $row->id);
                        if($row->discounttype == 1){
                            $type = $row->symbol;
                        }elseif($row->discounttype == 2){
                            $type = '%';
                        }
                        ?>
                        <tr valign="top" class="<?php echo "row$k"; ?>">
                            <td>
                                <?php echo $checked; ?>
                            </td>
                            <td>
                                <a href="<?php echo $link; ?>">
                                    <?php echo $row->title; ?></a>
                            </td>
                            <td align="center"><?php if($row->price == 0){ echo JText::_('Free');
                                }else{ 
                                    if($currency_align == 1)
                                        echo $row->symbol.' '.$row->price;
                                    else
                                        echo $row->price.' '.$row->symbol;
                                } ?></td>
                            <td align="center"><?php 
                                if($row->discount == 0){ 
                                    echo '-';
                                } else{ 
                                    if($currency_align == 1)
                                        echo $type.' '.$row->discount; 
                                    else
                                        echo $row->discount.' '.$type; 
                                }
                                ?></td>
                            <td align="center">
                                <?php
                                $img = $row->status ? 'tick.png' : 'publish_x.png';
                                ?>
                                <img src="components/com_jsjobs/include/images/<?php echo $img; ?>" width="16" height="16" border="0"  />
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
                <input type="hidden" name="c" value="jobseekerpackages" />
                <input type="hidden" name="view" value="jobseekerpackages" />
                <input type="hidden" name="layout" value="jobseekerpackages" />
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



