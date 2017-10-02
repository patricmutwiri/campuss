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

$document = JFactory::getDocument();

?>

<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
       <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=controlpanel"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Users'); ?></span></div>

      <form action="index.php?option=com_jsjobs&c=userrole&view=userrole&layout=users" method="post" name="adminForm" id="adminForm">
      <div id="jsjobs_filter_wrapper_new">                    
             <div id="jsjobs-filter-main-new" class="width100">
                 <span class="jsjobs-filter-new"><input type="text" name="searchname"  placeholder="<?php echo JText::_('Name'); ?>" id="searchname" size="15" value="<?php if (isset($this->lists['searchname'])) echo $this->lists['searchname']; ?>"  /></span>                
                 <span class="jsjobs-filter-new"><input type="text" name="searchusername"  placeholder="<?php echo JText::_('Username'); ?>" id="searchusername" size="15" value="<?php if (isset($this->lists['searchusername'])) echo $this->lists['searchusername']; ?>"  /></span>                   
                 <span class="jsjobs-filter-new"><input type="text" name="searchcompany"  placeholder="<?php echo JText::_('Company'); ?>" id="searchcompany" size="15" value="<?php if (isset($this->lists['searchcompany'])) echo $this->lists['searchcompany']; ?>" /></span>                   
                 <span class="jsjobs-filter-new"><span class="default-hidden"><input type="text" name="searchresume"  placeholder="<?php echo JText::_('Resume Title'); ?>" id="searchresume" size="15" value="<?php if (isset($this->lists['searchresume'])) echo $this->lists['searchresume']; ?>" /></span></span>
                 <span class="jsjobs-filter-new"><span class="default-hidden"><?php echo $this->lists['usergroup']; ?></span></span>
                 <span class="jsjobs-filter-new"><span class="default-hidden"><?php echo $this->lists['searchrole']; ?></span></span>
                 <span class="jsjobs-filter-new"><span class="default-hidden"><?php echo $this->lists['status']; ?></span></span>
                 <span class="jsjobs-filter-new"><span class="default-hidden"><?php echo JHTML::_('calendar',  $this->lists['datestart'], 'datestart', 'datestart', $js_dateformat, array('placeholder' => JText::_('Date Start'),'class' => 'inputbox validate-since', 'size' => '10', 'maxlength' => '19')); ?></span></span>
                 <span class="jsjobs-filter-new"><span class="default-hidden"><?php echo JHTML::_('calendar', $this->lists['dateend'], 'dateend', 'dateend', $js_dateformat, array('placeholder' => JText::_('Date End'),'class' => 'inputbox validate-since', 'size' => '10', 'maxlength' => '19')); ?></span></span>
                        
                 <span class="jsjobs-filter-new"><button class="js-button" id="js-search" onclick="this.form.submit();"><?php echo JText::_('Search'); ?></button></span>
                 <span class="jsjobs-filter-new"><button class="js-button" id="js-reset" onclick="document.getElementById('searchname').value = '';
                 document.getElementById('searchusername').value = '';
                 document.getElementById('searchcompany').value = '';
                 document.getElementById('searchresume').value = '';
                 document.getElementById('usergroup').value = '';
                 document.getElementById('searchrole').value = '';
                 document.getElementById('status').value = '';
                 document.getElementById('datestart').value = '';
                 document.getElementById('dateend').value = '';
                 this.form.submit();"><?php echo JText::_('Reset'); ?></button></span>
                 <span id="showhidefilter"><img src="components/com_jsjobs/include/images/filter-down.png"/></span>
             </div>    
         </div>
<?php if(!empty($this->items)){ ?>
               <?php
                        $k = 0;
                        for ($i = 0, $n = count($this->items); $i < $n; $i++) {
                            $row = $this->items[$i];
                            $task = $row->block ? 'unblock' : 'block';
                            $link = 'index.php?option=com_jsjobs&c=userrole&view=userrole&layout=changerole&cid[]=' . $row->id . '';
                            ?>
                <div id="js-jobs-listwrapper">
                    <div id="jsjobs-top-left">
                    <?php if($row->roletitle=="employer"){  
                            if($row->companylogo==""){
                                $logo_path = "components/com_jsjobs/include/images/default-icon.png";
                            }else{
                                $logo_path = "../".$this->config['data_directory']."/data/employer/comp_".$row->companyid."/logo/".$row->companylogo;
                            } 
                        }else{
                            if ($row->photo != '') {
                                $logo_path = "../".$this->config['data_directory'] . "/data/jobseeker/resume_" . $row->resumeid . "/photo/" . $row->photo;
                            } else {
                                $logo_path = "components/com_jsjobs/include/images/Users.png";
                            }
                        }
                    ?>
                    <span class="outer-circle"><img class="circle" src="<?php echo $logo_path;?>"/></span>
                    </div>
                    <div id="jsjobs-top-right" class="min-height-box">
                            <div id="jsrightcorner">
                                <?php if($row->block==0){?>
                                    <span class="smallimg"><img src="components/com_jsjobs/include/images/approved-corner.png"/></span><span class="listheadrightcorner-green"><?php echo JText::_('Enabled'); ?></span>
                                <?php }else{ ?>
                                    <span class="smallimg"><img src="components/com_jsjobs/include/images/reject-cornor.png"/></span><span class="listheadrightcorner-red"><?php echo JText::_('Disabled'); ?></span>
                            <?php } ?>
                             </div>
                        <div id="jsjobslist-header" class="min-heigth-title">
                             <span class="listheadleft"><span class="title"><?php echo JText::_('Name');?>:</span>&nbsp;<?php echo $row->name; ?></span>
                             <?php if($row->roletitle == "employer"){?>
                             <span class="listheadright"><?php echo JText::_($row->roletitle); ?></span>
                             <?php }elseif($row->roletitle == "jobseeker"){ ?><span class="listheadright2"><?php echo JText::_($row->roletitle); ?></span><?php } ?> 
                        </div>
                        <?php if($row->roletitle == "employer") {?>
                            <span class="js-innerspanright"><span class="title"><?php echo JText::_('Company'); ?> :</span>&nbsp;<?php echo $row->companyname; ?></span>
                        <?php }elseif($row->roletitle == "jobseeker"){?>
                            <span class="js-innerspanleft"><span class="title"><?php echo JText::_('Resume'); ?> :</span>&nbsp;<?php echo $row->first_name . ' ' . $row->last_name; ?></span>
                        <?php } ?>
                        <span class="js-innerspanright"><span class="title"><?php echo JText::_('Group'); ?> :</span>&nbsp;<?php echo JText::_($row->groupname); ?></span>
                        <span class="js-innerspanleft"><span class="title"><?php echo JText::_('Username'); ?> :</span>&nbsp;<?php echo $row->username; ?></span>
                    </div>
                    <div id="jsjobs-bottom">
                        <span class="js-idbottom"><span class="title"><?php echo JText::_('Id'); ?> :</span>&nbsp;<?php echo $row->id; ?></span>
                        <a id="js-bottombutton" href="<?php echo $link; ?>"><img src="components/com_jsjobs/include/images/change-role-icon-2.png" alt="img">&nbsp;<?php echo JText::_('Change Role');?></a>
                    </div>
                </div>  
                <?php }
                        ?>
     
                <div id="jsjobs-pagination-wrapper">
                    <?php echo $this->pagination->getLimitBox(); ?>
                    <?php echo $this->pagination->getListFooter(); ?>
                </div>
            <?php }else{ JSJOBSlayout::getNoRecordFound(); } ?>

                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" name="task" value="view" />
                <input type="hidden" name="boxchecked" value="0" />
                <?php echo JHTML::_('form.token'); ?>
            </form>
    </div>    
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


