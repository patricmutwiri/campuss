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

if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('../components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}


$status = array(
    '1' => JText::_('Job Approved'),
    '-1' => JText::_('Job Rejected'));

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

$sort_combo = array(
    '0' => array('value' => 0, 'text' => JText::_('Sort By')),
    '1' => array('value' => 1, 'text' => JText::_('Job Title')),
    '2' => array('value' => 2, 'text' => JText::_('Job Type')),
    '3' => array('value' => 3, 'text' => JText::_('Company Name')),
    '4' => array('value' => 4, 'text' => JText::_('Category')),
    '5' => array('value' => 5, 'text' => JText::_('Location')),
    '6' => array('value' => 6, 'text' => JText::_('Status')),
    '7' => array('value' => 7, 'text' => JText::_('Created')),
    '8' => array('value' => 8, 'text' => JText::_('Viewed')),);
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

<script type="text/javascript">
    function confirmdeletejob(id, task) {
        if (confirm("<?php echo JText::_('Are You Sure?'); ?>") == true) {
            return listItemTask(id, task);
        } else
            return false;
    }
</script>

<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
            <form action="index.php" method="post" name="adminForm" id="adminForm">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=controlpanel"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Jobs'); ?></span>
            <span id="sorting-wrapper">
            <span id="sorting-bar1">
                <?php echo $sort_combo ?>
            </span>
            <span id="sortimage">
                <?php if ($this->sort == 'asc') {$img = "components/com_jsjobs/include/images/up.png"; }else{$img = "components/com_jsjobs/include/images/down.png"; } ?>
                <a href="javascript: void(0);"onclick="js_imgSort();"><img src="<?php echo $img ?>"></a>
            </span>
            </span>
        </div>
        <div id="jsjobs_filter_wrapper_new">
            <div id="checkallbox-main">
                <div id="checkallbox">
                <?php if (JVERSION < '3') { ?> 
                    <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>); highlightAll();" />
                <?php } else { ?>
                    <input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this); highlightAll();" />
                <?php } ?>
                </div>
            </div>    
            <div id="jsjobs-filter-main-new">
                <span class="jsjobs-filter-new"><input type="text" name="companyname" placeholder="<?php echo JText::_('Company Name'); ?>" id="companyname" value="<?php if (isset($this->lists['companyname'])) echo $this->lists['companyname']; ?>"  /></span>
                <span class="jsjobs-filter-new"><input type="text" name="jobtitle" placeholder="<?php echo JText::_('Job Title'); ?>" id="jobtitle" value="<?php if (isset($this->lists['jobtitle'])) echo $this->lists['jobtitle']; ?>"  /></span>
                <span class="jsjobs-filter-new"><input type="text" name="location" placeholder="<?php echo JText::_('Location'); ?>" id="location" value="<?php if (isset($this->lists['location'])) echo $this->lists['location']; ?>"  /></span>
                <span class="jsjobs-filter-new"><span class="default-hidden"><?php echo $this->lists['jobcategory']; ?></span></span>
                <span class="jsjobs-filter-new"><span class="default-hidden"><?php echo $this->lists['jobtype']; ?></span></span>
                <span class="jsjobs-filter-new"><span class="default-hidden"><?php echo JHTML::_('calendar', $this->lists["datefrom"], 'datefrom', 'datefrom', $js_dateformat, array('placeholder' => JText::_('Date From'),'class' => 'inputbox validate-since', 'size' => '10', 'maxlength' => '19')); ?></span></span>
                <span class="jsjobs-filter-new"><span class="default-hidden"><?php echo JHTML::_('calendar', $this->lists["dateto"], 'dateto', 'dateto', $js_dateformat, array('placeholder' => JText::_('Date To'),'class' => 'inputbox validate-since', 'size' => '10', 'maxlength' => '19')); ?></span></span>
                <span class="jsjobs-filter-new"><span class="default-hidden"><?php echo $this->lists['status']; ?></span></span>
                <span class="jsjobs-filter-new"><button class="js-button" id="js-search" onclick="this.form.submit();"><?php echo JText::_('Search'); ?></button></span>
                <span class="jsjobs-filter-new"><button class="js-button" id="js-reset"><?php echo JText::_('Reset'); ?></button></span>
                <span id="showhidefilter"><img src="components/com_jsjobs/include/images/filter-down.png"/></span>
            </div>    
        </div>
      <?php if(!empty($this->items)){ ?>
                 <?php
                    jimport('joomla.filter.output');
                    $k = 0;

                    $jobdeletetask = 'jobenforcedelete';
                    $deleteimg = 'publish_x.png';
                    $Deletealt = JText::_('Delete');


                    for ($i = 0, $n = count($this->items); $i < $n; $i++) {
                        $row = $this->items[$i];
                        $checked = JHTML::_('grid.id', $i, $row->id);
                        $link = JFilterOutput::ampReplace('index.php?option=' . $this->option . '&task=job.edit&cid[]=' . $row->id);
                        $comp_path = JFilterOutput::ampReplace('index.php?option=' . $this->option . '&task=company.edit&cid[]=' . $row->companyid);

                        ?>

                <div id="js-jobs-comp-listwrapper" class="jsjobs-check-container select_<?php echo $row->id;?>">
                    <div id="jsjobs-top-comp-left">
                       <?php if($row->companylogo==""){?>
                       <a class="jsjobs-leftimg" href="<?php echo $comp_path;?>"><img class="myfilelogoimg" src="components/com_jsjobs/include/images/default-icon.png"/></a> 
                       <?php }else{
                      $logo_path = "../".$this->config['data_directory']."/data/employer/comp_".$row->companyid."/logo/".$row->companylogo;
                        ?>
                       <a class="jsjobs-leftimg" href="<?php echo $comp_path;?>"><img class="myfilelogoimg" src="<?php echo $logo_path;?>"/></a>
                       <?php } ?>
                    </div>
                    <div id="jsjobs-top-comp-right">
                        <div id="jsjobslist-comp-header">
                            <div id="innerheaderlefti">
                               <span id="jsjobs_jobltitle" class="datablockhead-left">
                                <span class="notbold color-blue font-mysize"><a href="<?php echo $link; ?>"><?php echo $row->title; ?></a></span>
                               </span>
                               <span class="fulltimejob"><span class="notbold color"><?php echo JText::_($row->jobtypetitle); ?></span></span>
                            </div>
                            <?php
                              if(date('Y-m-d',strtotime($row->stoppublishing)) < date('Y-m-d')){
                                $expired = true;
                              }else{
                                $expired = false;
                              }
                            ?>

                                <span class="datablockhead-right">
                                 <?php  if($expired == true){ ?>
                                  <span class="rightcorner"><img src="components/com_jsjobs/include/images/reject-cornor.png"><span class="listheadrightcorner-red"><?php echo JText::_('Expired'); ?></span></span>
                                 <?php
                                 }else{
                                   if($row->status == 1){?>
                                      <span class="rightcorner"><img src="components/com_jsjobs/include/images/approved-corner.png"><span class="listheadrightcorner-green"><?php echo JText::_('Approved'); ?></span></span>
                                      <?php }else{ ?>
                                      <span class="rightcorner"><img src="components/com_jsjobs/include/images/reject-cornor.png"><span class="listheadrightcorner-red"><?php echo JText::_('Rejected'); ?></span></span>
                                   <?php } 
                                 }
                                 ?>  
                                </span>

                          </div>
                          <div id="jsjobslist-comp-body">
                          <span class="datablock"><span class="title"><?php echo JText::_($this->getJSModel('fieldordering')->getFieldTitleByFieldAndFieldfor('company', 2 )); ?> :</span><span class="notbold color"><?php echo $row->companyname; ?></span></span>
                          <span class="datablock"><span class="title"><?php echo JText::_($this->getJSModel('fieldordering')->getFieldTitleByFieldAndFieldfor('jobcategory', 2 )); ?> :</span><span class="notbold color"><?php echo JText::_($row->cat_title); ?></span></span>
                          <span class="datablock"><span class="title"><?php echo JText::_($this->getJSModel('fieldordering')->getFieldTitleByFieldAndFieldfor('city', 2 )); ?> :</span><span class="notbold color"><?php echo $row->location; ?></span></span>
                          </div>
                    </div>
                    <div id="jsjobs-bottom-comp">
                        <div id="bottomleftnew-job">
                            <span class="bottomcheckbox ss_<?php echo $row->id;?>"><?php echo $checked; ?></span>
                            <span class="js-created"><b><?php echo JText::_('Created'); ?>:</b>&nbsp;<span class="color"><?php echo JHtml::_('date', $row->created, $this->config['date_format']); ?></span></span>
                        </div>
                        <div id="bottomrightnew-job">
                             <a class="js-bottomspan" href="index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=jobappliedresume&oi=<?php echo $row->id; ?>"><img src="components/com_jsjobs/include/images/resume-new.png" alt="resume">&nbsp;&nbsp;<?php echo JText::_('Resume').'&nbsp;('.$row->totalresume.')&nbsp;';?></a>
                             <a class="js-bottomspan" href="javascript:void(0);" onclick="return confirmdeletejob('cb<?php echo $i; ?>', 'job.remove');"><img src="components/com_jsjobs/include/images/delete-icon-new.png" alt="del">&nbsp;&nbsp;<?php echo JText::_('Delete');?></a>
                             <a class="js-bottomspan" href="javascript:void(0);" onclick="return confirmdeletejob('cb<?php echo $i; ?>', 'job.<?php echo $jobdeletetask; ?>');"><img src="components/com_jsjobs/include/images/forced-delete-new.png" alt="fdel">&nbsp;&nbsp;<?php echo JText::_('Force Delete');?></a>
                        </div>
                    </div>  
                </div> 
                        <?php
                        $k = 1 - $k;
                    }
                    ?>

             
                <div id="jsjobs-pagination-wrapper">
                    <?php echo $this->pagination->getLimitBox(); ?>
                    <?php echo $this->pagination->getListFooter(); ?>
                </div>

<?php }else{ JSJOBSlayout::getNoRecordFound(); } ?>                
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="c" value="job" />
                <input type="hidden" name="view" value="job" />
                <input type="hidden" name="layout" value="jobs" />
                <input type="hidden" name="callfrom" value="jobs" />
                <input type="hidden" name="boxchecked" value="0" />
                <input type="hidden" name="sortby" value="<?php echo $this->sort;?>"/>
                <input type="hidden" id="my_click" name="my_click" value=""/>
            </form>
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

<div id="jsjobs_full_black"><div class="jsjobs_job_copy"><?php echo JText::_('Job has been copied');?></div></div>

<script type="text/javascript">
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

        
        // reset form
        jQuery('#js-reset').click(function(e){
          jQuery('#companyname').val('');
          jQuery('#jobtitle').val('');
          jQuery('#location').val('');
          jQuery('#jobcategory').prop('selectedIndex', 0);
          jQuery('#jobtype').prop('selectedIndex', 0);
          jQuery('#dateto').val('');
          jQuery('#datefrom').val('');
          jQuery('#status').prop('selectedIndex', 0);
          jQuery('#isgfcombo').prop('selectedIndex', 0);
          this.form.submit();
        });
    });
</script>				

<script type="text/javascript" src="<?php echo JURI::root(); ?>components/com_jsjobs/js/tinybox.js"></script>
<link media="screen" rel="stylesheet" href="<?php echo JURI::root(); ?>components/com_jsjobs/js/style.css" />
<script type="text/javascript" language="Javascript">
  function copyjob(val) {
      jQuery.post("index.php?option=com_jsjobs&task=job.getcopyjob", {val: val}, function (data) {
          if (data) {
            jQuery('div#jsjobs_full_black').slideDown('slow');
              setTimeout(function () {
                  document.adminForm.submit();
              }, 3000);
          }
      });
  }
  jQuery(document).ready(function(){
    jQuery('input[id^="cb"]').click(function(){
      var checkbox = jQuery(this);
      var value = jQuery(checkbox).val();
      single_highlight(value);
    });
  });
  function single_highlight(id){
    if (jQuery("div.select_"+id+" span input:checked").length > 0){
      showBorder(id);
    }else{
      hideBorder(id);
    }
  }

  function showBorder(id){
    jQuery("div.select_"+id).addClass('ck_blue');
    jQuery("span.ss_"+id).addClass('ck_blue');
  }

  function hideBorder(id){
    jQuery("div.select_"+id).removeClass('ck_blue');
    jQuery("span.ss_"+id).removeClass('ck_blue');
  }

  function highlightAll(){
    if (jQuery("span.bottomcheckbox input").is(':checked') == false){
      jQuery("div.jsjobs-check-container").removeClass('ck_blue');
      jQuery("span.bottomcheckbox").removeClass('ck_blue');
    }
    if (jQuery("span.bottomcheckbox input").is(':checked') == true){
      jQuery("div.jsjobs-check-container").addClass('ck_blue');
      jQuery("span.bottomcheckbox").addClass('ck_blue');
    }
  }

</script>