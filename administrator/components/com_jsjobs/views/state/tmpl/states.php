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
//echo '<pre>'; print_r($this->items); echo "</pre>";
$sort_combo = array(
    '0' => array('value' => 0, 'text' => JText::_('Sort By')),
    '1' => array('value' => 1, 'text' => JText::_('State Name')),
    '2' => array('value' => 2, 'text' => JText::_('Status')),);
    
    $sort_combo = JHTML::_('select.genericList', $sort_combo, 'js_sortby', 'class="inputbox" onchange="js_Ordering();"'.'', 'value', 'text',$this->js_sortby);
?>
<script type="text/javascript">
    function js_Ordering(){
        var val = jQuery('#js_sortby option:selected').val();
        jQuery('form#adminForm').submit();
    }

    function js_imgSort(){
        var val = jQuery('#js_sortby option:selected').val();
        if(val!=0){
            jQuery('#my_click').val('1');
            jQuery('form#adminForm').submit();
        }
    }
</script>


<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
         <form action="index.php?option=com_jsjobs" method="post" name="adminForm" id="adminForm">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=country&view=country&layout=countries"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><a href="index.php?option=com_jsjobs&c=country&view=country&layout=countries"><?php echo JText::_('Countries'); ?></a> > <?php echo JText::_('States'); ?></span>

            <span id="sorting-wrapper">
                <span id="sorting-bar1">
                    <?php echo $sort_combo ?>
                </span>
                <span id="sortimage">
                    <?php if ($this->sort == 'asc') {$img = "components/com_jsjobs/include/images/down.png"; }else{$img = "components/com_jsjobs/include/images/up.png"; } ?>
                    <a href="javascript: void(0);"onclick="js_imgSort();"><img src="<?php echo $img ?>"></a>
                </span>
            </span>

        </div>
        
         <div id="jsjobs_filter_wrapper">                                         
            <span class="jsjobs-filter"><input type="text" name="searchname" placeholder="<?php echo JText::_('Name'); ?>" id="searchname" value="<?php if (isset($this->lists['searchname'])) echo $this->lists['searchname']; ?>" /></span>
            <span class="jsjobs-filter"><?php echo $this->lists['searchstatus']; ?></span>
            <span class="jsjobs-filter "><div class="mycheckboxblock"><input type="checkbox" class="jsinputstate" id="hascities" name="hascities" value="" <?php if (isset($this->lists['hascities'])) echo "checked"; ?> /><label id="hascities" for="hascities" name="hascities" class="jshasstates"><?php echo JText::_('Has Cities'); ?></label></div></span>
            <span class="jsjobs-filter"><button class="js-button" onclick="this.form.submit();"><?php echo JText::_('Search'); ?></button></span>
            <span class="jsjobs-filter"><button class="js-button" onclick="document.getElementById('searchname').value = '';
                    document.getElementById('searchstatus').value = '';                                                        
                    document.getElementById('hascities').checked = false;                                                        
                    this.form.submit();"><?php echo JText::_('Reset'); ?></button></span>
         </div>
<?php if(!empty($this->items)){ ?>
                <table class="adminlist" border="0" id="js-table">
                    <thead>
                        <tr ><td colspan="3">
                                <?php
                                $session = JFactory::getSession();
                                $countryid = $session->get('countryid');
                                $statecode = $session->get('statecode');
                                ?>
                               <!--  <a href="index.php?option=com_jsjobs&c=country&view=country&layout=countries"><?php //echo JText::_('Countries'); ?></a> > <?php //echo JText::_('States'); ?>  -->
                            </td></tr>

                        <tr>
                            <th width="1%">
                                <?php if (JVERSION < '3') { ?> 
                                    <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
                                <?php } else { ?>
                                    <input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this);" />
                                <?php } ?>
                            </th>
                            <th  width="60%" class="title"><?php echo JText::_('Name'); ?></th>
                            <th width="13%" class="center"><?php echo JText::_('Published'); ?></th>
                            <th width="13%" class="center"><?php echo JText::_('Cities'); ?></th>
                        </tr>
                    </thead><tbody>
                    <?php
                    jimport('joomla.filter.output');
                    $k = 0;
                    for ($i = 0, $n = count($this->items); $i < $n; $i++) {
                        $row = $this->items[$i];
                        $checked = JHTML::_('grid.id', $i, $row->id);
                        $link = JFilterOutput::ampReplace('index.php?option=' . $this->option . '&task=state.editjobstate&cid[]=' . $row->id);
                        ?>
                        <tr valign="top" class="<?php echo "row$k"; ?>">
                            <td>
                                <?php echo $checked; ?>
                            </td>
                            <td>
                                <a href="<?php echo $link; ?>">
                                    <?php echo $row->name; ?></a>
                            </td>
                            <td align="center">
                                <?php
                                if ($row->enabled == '1') {
                                    $functionname = 'unpublishstates';
                                    $img = 'tick2.png';
                                } else {
                                    $functionname = 'publishstates';
                                    $img = 'cross.png';
                                }
                                ?>
                                <a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i; ?>', 'state.<?php echo $functionname; ?>')">
                                    <img src="components/com_jsjobs/include/images/<?php echo $img; ?>" width="16" height="16" border="0"  />
                                </a>
                            </td>
                            <td class="center"><a href="index.php?option=com_jsjobs&c=city&view=city&layout=cities&sd=<?php echo $row->id; ?>&ct=<?php echo $this->ct; ?>"><?php echo JText::_('Cities'); ?></a></td>
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
                <input type="hidden" name="c" value="state" />
                <input type="hidden" name="view" value="state" />
                <input type="hidden" name="layout" value="states" />
                <input type="hidden" name="task" value="view" />
                <input type="hidden" name="boxchecked" value="0" />
                <input type="hidden" name="sortby" value="<?php echo $this->sort;?>"/>
                <input type="hidden" id="my_click" name="my_click" value=""/>
                
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



