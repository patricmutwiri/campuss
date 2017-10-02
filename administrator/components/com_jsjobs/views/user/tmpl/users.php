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
jimport('joomla.filter.output');
?>
<div id="jsjobs-popup-wrap">
    <div class="jsjobs-heading">
        <span class="jsjobs-heading-title">
            <strong><?php echo JText::_('Filter'); ?></strong>
        </span>
    </div>
    <form action="index.php?option=com_jsjobs&c=user&view=user&layout=users&tmpl=component" method="post" name="adminForm" id="adminForm">
        <div class="jsjobs-popup-search-area">
            <span class="jsjobs-search"> 
                <span class="jsjobs-title"><?php echo JText::_('Name'); ?>:</span>
                <span class="jsjobs-value"><input type="text" name="searchname" id="searchname" value="<?php if (isset($this->lists['searchname'])) echo $this->lists['searchname']; ?>" class="text_area" onchange="document.adminForm.submit();" /></span>
                <span class="jsjobs-title"><?php echo JText::_('User Name'); ?>:</span>
                <span class="jsjobs-value"><input type="text" name="searchusername" id="searchusername" size="15" value="<?php if (isset($this->lists['searchusername'])) echo $this->lists['searchusername']; ?>" class="text_area" onchange="document.adminForm.submit();" /></span>
                <span class="jsjobs-title"><?php echo JText::_('Role'); ?>:</span>
                <span class="jsjobs-value"><?php echo $this->lists['searchrole']; ?></span>
                <span class="jsjobs-button">
                    <button id="jsjobs-reset-btn" onclick="document.getElementById('searchname').value = '';
                        document.getElementById('searchrole').value = '';
                        document.getElementById('searchusername').value = '';
                        document.getElementById('searchrole').value = '';
                        this.form.submit();"><?php echo JText::_('Reset'); ?>
                    </button>
                </span>
            </span>
        </div>
        <div class="jsjobs-adminlist">
            <span class="jsjobs-adminlist-heading">   
                <span class="heading-title"><?php echo JText::_('Num'); ?></span>
                <span class="heading-title"><?php echo JText::_('Name'); ?></span>
                <span class="heading-title"><?php echo JText::_('User Name'); ?></span>
                <span class="heading-title"><?php echo JText::_('Role'); ?></span>
                <span class="heading-title"><?php echo JText::_('Id'); ?></span>      
            </span>
        </div>
        <?php
            $k = 0;
            for ($i = 0, $n = count($this->items); $i < $n; $i++) {
                $row = $this->items[$i];
                $img = $row->block ? 'cross.png' : 'tick2.png';
                $task = $row->block ? 'unblock' : 'block';
                $alt = $row->block ? JText::_('Enabled') : JText::_('Blocked');
                ?>
                <div class="<?php echo "row$k"; ?> jsjobs-adminlist-value">
                    <span class="heading-title">
                        <?php echo $i + 1 + $this->pagination->limitstart; ?>
                    </span>
                    <span class="heading-title">
                        <?php 
                        if(empty($row->roletitle)){
                            echo $row->name;
                        }else{ ?>
                            <a onclick="window.parent.setuser('<?php echo $row->username; ?>', '<?php echo $row->id; ?>');
                               " ><?php echo $row->name; ?>
                            </a>
                            <?php
                        }
                        ?>
                    </span>
                    <span class="heading-title"><?php echo $row->username; ?></span>
                    <span class="heading-title"><?php if(empty($row->roletitle)) echo JText::_('None'); else echo $row->roletitle; ?></span>
                    <span class="heading-title"><?php echo $row->id; ?></span> 

                </div>
                <?php
                $k = 1 - $k;
            }
        ?>
         <div class="jsjobs-pagination">
            <?php echo $this->pagination->getListFooter(); ?> 
         </div>
    <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
    <input type="hidden" name="c" value="user" />
    <input type="hidden" name="view" value="user" />
    <input type="hidden" name="layout" value="users" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="Itemid" value="<?php echo $this->Itemid; ?>" />
    <input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
    <?php echo JHTML::_('form.token'); ?>
     </form>
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
    $(document).ready(function(){
        $("#hide").click(function(){
            $(this).hide();
        });
    });
</script>


