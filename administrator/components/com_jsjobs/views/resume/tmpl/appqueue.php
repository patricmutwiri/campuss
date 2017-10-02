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
}
$sort_combo = array(
    '0' => array('value' => 0, 'text' => JText::_('Sort By')),
    '1' => array('value' => 1, 'text' => JText::_('Application Title')),
    '2' => array('value' => 2, 'text' => JText::_('First Name')),
    '3' => array('value' => 3, 'text' => JText::_('Category')),
    '4' => array('value' => 4, 'text' => JText::_('Job Type')),
    '5' => array('value' => 5, 'text' => JText::_('Location')),
    '6' => array('value' => 6, 'text' => JText::_('Status')),
    '7' => array('value' => 7, 'text' => JText::_('Created')),);
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
            <form action="index.php" method="post" name="adminForm" id="adminForm">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=controlpanel"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Resume Approval Queue'); ?></span>
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
                    <span class="selectallbox"><span class="selectallbox-onhover" style="display:none"><?php echo JText::_("Mark All"); ?><img src="components/com_jsjobs/include/images/bottom-tool-tip.png" alt="downhover-part"></span></span>
                   <?php if (JVERSION < '3') { ?> 
                    <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>); highlightAll();" />
                <?php } else { ?>
                    <input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this); highlightAll();" />
                <?php } ?>
             </div>
            </div>    
            <div id="jsjobs-filter-main-new">
                <span class="jsjobs-filter-new"><input type="text" name="resumetitle" placeholder="<?php echo JText::_('Resume Title'); ?>" id="resumetitle" value="<?php if (isset($this->lists['resumetitle'])) echo $this->lists['resumetitle']; ?>"  /></span>
                <span class="jsjobs-filter-new"><input type="text" name="resumename" placeholder="<?php echo JText::_('Name'); ?>" id="resumename" value="<?php if (isset($this->lists['resumename'])) echo $this->lists['resumename']; ?>"  /></span>
                <span class="jsjobs-filter-new"><?php echo $this->lists['desiredsalary']; ?></span>
                <span class="jsjobs-filter-new"><span class="default-hidden"><input type="text" name="location" placeholder="<?php echo JText::_('Location'); ?>" id="location" value="<?php if (isset($this->lists['location'])) echo $this->lists['location']; ?>"  /></span></span>
                <span class="jsjobs-filter-new"><span class="default-hidden"><?php echo $this->lists['resumecategory']; ?></span></span>
                <span class="jsjobs-filter-new"><span class="default-hidden"><?php echo $this->lists['resumetype']; ?></span></span>
                <span class="jsjobs-filter-new"><span class="default-hidden"><?php echo JHTML::_('calendar', $this->lists['datefrom'], 'datefrom', 'datefrom', $js_dateformat, array('placeholder' => JText::_('Date From'),'class' => 'inputbox validate-since', 'size' => '10', 'maxlength' => '19')); ?></span></span>
                <span class="jsjobs-filter-new"><span class="default-hidden"><?php echo JHTML::_('calendar', $this->lists['dateto'], 'dateto', 'dateto', $js_dateformat, array('placeholder' => JText::_('Date To'),'class' => 'inputbox validate-since', 'size' => '10', 'maxlength' => '19')); ?></span></span>
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

                    $resumedeletetask = 'resumeenforcedelete';
                    $jobdeletetask = 'jobenforcedelete';
                    $deleteimg = 'publish_x.png';
                    $Deletealt = JText::_('Delete');


                    for ($i = 0, $n = count($this->items); $i < $n; $i++) {
                        $row = $this->items[$i];
                        $checked = '<input type="checkbox" onclick="single_highlight('.$row->id.');" id="cb'.$i.'" name="cid[]" value="'.$row->id.'" />';
                        $link = JFilterOutput::ampReplace('index.php?option=' . $this->option . '&task=resume.edit&cid[]=' . $row->id.'&callfrom=appqueue');
                        
                        if($row->photo==""){
                          $logo_path = "components/com_jsjobs/include/images/Users.png";
                        }else{
                          $logo_path = "../".$this->config['data_directory']."/data/jobseeker/resume_".$row->id."/photo/".$row->photo;
                        }
                        ?>

                <div id="js-jobs-comp-listwrapper" class="jsjobs-check-container select_<?php echo $row->id;?>">
                    <div id="jsjobs-top-comp-left">
                         <span class="outer-circle"><a href="<?php echo $link; ?>"> <img class="circle" src="<?php echo $logo_path; ?>"/> </a></span> 
                    </div>
                    <div id="jsjobs-top-comp-right_resume">
                        <div id="jsjobslist-comp-header" class="jsjobsqueuereletive">                            
                                                    <div id="innerheaderlefti">
                               <span class="datablockhead-left"><?php echo $checked; ?></span>
                               <span id="jsjobs-resumetitle" class="datablockhead-left">
                                <span class="notbold color-blue font-mysize"><a href="<?php echo $link; ?>"><?php echo $row->application_title; ?></a></span>                                  
                               </span>
                            </div>

                            <span id="js-queues-statuses"><?php
                                $class_color = '';
                                $arr = array();                                                                
                                if($row->status==0){
                                  if($class_color==''){
                                    echo '<img class="q-image" src="components/com_jsjobs/include/images/q-comp.png">';
                                  }?>
                                  <span class="q-self forapproval"><?php echo JText::_('Resume'); ?></span><?php
                                  $class_color = 'q-self';
                                    $arr['self'] = 1;
                                  } ?>
                                  <span class="<?php echo $class_color; ?> waiting-text"><?php echo JText::_('Waiting for approval'); ?></span>
                              </span>
                          </div>
                          <div id="jsjobslist-comp-body">
                            <span class="datablock" ><span class="title"><?php echo JText::_($this->getJSModel('fieldordering')->getFieldTitleByFieldAndFieldfor('first_name', 3 )); ?> :</span><span class="notbold color"><?php  echo $row->first_name . ' ' . $row->last_name; ?></span></span>
                            <span class="datablock" ><span class="title"><?php echo JText::_($this->getJSModel('fieldordering')->getFieldTitleByFieldAndFieldfor('job_category', 3 )); ?> :</span><span class="notbold color"><?php echo JText::_($row->cat_title); ?></span></span>
                            <span class="datablock" ><span class="title"><?php echo JText::_($this->getJSModel('fieldordering')->getFieldTitleByFieldAndFieldfor('desired_salary', 3 )); ?> :</span><span class="notbold color"><?php echo $row->salary; ?></span></span>
                            <span class="datablock" ><span class="title"><?php echo JText::_($this->getJSModel('fieldordering')->getFieldTitleByFieldAndFieldfor('address', 3 )); ?> :</span><span class="notbold color"><?php echo $row->location; ?></span></span>
                          </div>
                    </div>
                    <div id="jsjobs-bottom-comp">
                        <div id="bottomleftnew" class="resumepaddingleftqueue">
                            <span class="js-created"><b><?php echo JText::_('Created'); ?>:</b>&nbsp;<span class="color"><?php echo JHtml::_('date', $row->created, $this->config['date_format']); ?></span></span>
                        </div>
                        <div id="bottomrightnew"> <?php
                          $total = count($arr);
                          if($total==3){
                            $objid = 4; //for all
                          }elseif($total!=1){
                            if(isset($arr['self']) && isset($arr['gold'])){
                              $objid = 1; // for resume&gold
                            }
                          }
                          if($total==1){
                            if(isset($arr['self'])){
                              echo '<a class="js-bottomspan" href="index.php?option=com_jsjobs&c=resume&task=resumeapprove&id='.$row->id.'"><img src="components/com_jsjobs/include/images/hired-new.png">  '.JText::_('Approve').'</a>';
                            }
                          }else{ ?>
                            <div class="js-bottomspan jobsqueue-approvalqueue" onmouseout="hideThis(this);" onmouseover="approveActionPopup('<?php echo $row->id; ?>');"><img src="components/com_jsjobs/include/images/hired-new.png">&nbsp;&nbsp;<?php echo JText::_('Approve');?>
                              <div id="jsjobs-queue-actionsbtn" class="jobsqueueapprove_<?php echo $row->id;?>">
                                <?php
                                  if(isset($arr['self'])){
                                    echo '<a id="jsjobs-act-row" class="jsjobs-act-row" href="index.php?option=com_jsjobs&c=resume&task=resumeapprove&id='.$row->id.'"><img class="jobs-action-image" src="components/com_jsjobs/include/images/company.png">'.JText::_("Resume Approve").'</a>';
                                  }
                                ?>
                              </div>
                            </div>
                          <?php
                          } // End approve
                          if($total==1){
                            if(isset($arr['self'])){
                              echo '<a class="js-bottomspan" href="index.php?option=com_jsjobs&c=resume&task=resumereject&id='.$row->id.'"><img src="components/com_jsjobs/include/images/reject-s.png">  '.JText::_('Reject').'</a>';
                            }
                          }else{ ?>
                            <div class="js-bottomspan jobsqueue-approvalqueue" onmouseout="hideThis(this);" onmouseover="rejectActionPopup('<?php echo $row->id; ?>');"><img src="components/com_jsjobs/include/images/reject-s.png">&nbsp;&nbsp;<?php echo JText::_('Reject');?>
                              <div id="jsjobs-queue-actionsbtn" class="jobsqueuereject_<?php echo $row->id;?>">
                                <?php
                                  if(isset($arr['self'])){
                                    echo '<a id="jsjobs-act-row" class="jsjobs-act-row" href="index.php?option=com_jsjobs&c=resume&task=resumereject&id='.$row->id.'"><img class="jobs-action-image" src="components/com_jsjobs/include/images/company.png">'.JText::_("Resume Reject").'</a>';
                                  }
                                ?>
                              </div>
                            </div>
                          <?php
                          }//End Reject ?>
                          <a class="js-bottomspan" href="javascript:void(0);" onclick=" return confirmdeleteresume('cb<?php echo $i; ?>', 'resume.remove');"><img src="components/com_jsjobs/include/images/delete-icon-new.png" alt="del">&nbsp;&nbsp;<?php echo JText::_('Delete');?></a>
                          <a class="js-bottomspan" href="javascript:void(0);" onclick=" return confirmdeleteresume('cb<?php echo $i; ?>', 'resume.<?php echo $resumedeletetask; ?>');"><img src="components/com_jsjobs/include/images/forced-delete-new.png" alt="fdel">&nbsp;&nbsp;<?php echo JText::_('Force Delete');?></a>                          
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
                <input type="hidden" name="c" value="resume" />
                <input type="hidden" name="view" value="resume" />
                <input type="hidden" name="layout" value="appqueue" />
                <input type="hidden" name="task" value="" />
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
<script type="text/javascript">
    jQuery(document).ready(function(){
      jQuery('input[id^="cb"]').click(function(){
        var checkbox = jQuery(this);
        var value = jQuery(checkbox).val();
        single_highlight(value);
      });
    });

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
          jQuery('#resumetitle').val('');
          jQuery('#resumename').val('');
          jQuery('#desiredsalary').prop('selectedIndex', 0);
          jQuery('#location').val('');
          jQuery('#resumecategory').prop('selectedIndex', 0);
          jQuery('#resumetype').prop('selectedIndex', 0);
          jQuery('#dateto').val('');
          jQuery('#datefrom').val('');
          jQuery('#isgfcombo').prop('selectedIndex', 0);
          this.form.submit();
        });        

    });

    function approveActionPopup(id){
      var cname = '.jobsqueueapprove_'+id;
      jQuery(cname).show();
      jQuery(cname).mouseout(function(){
        jQuery(cname).hide();
      });
    }

    function rejectActionPopup(id){
      var cname = '.jobsqueuereject_'+id;
      jQuery(cname).show();
      jQuery(cname).mouseout(function(){
        jQuery(cname).hide();
      });
    }

    function hideThis(obj){
      jQuery(obj).find('div#jsjobs-queue-actionsbtn').hide();
    }
  function single_highlight(id){
    if (jQuery("div.select_"+id+" span input:checked").length > 0){
      showBorder(id);
    }else{
      hideBorder(id);
    }
  }

  function showBorder(id){
    jQuery("div.select_"+id).addClass('ck_blue');
  }

  function hideBorder(id){
    jQuery("div.select_"+id).removeClass('ck_blue');
  }

  function highlightAll(){
    if (jQuery("span.datablockhead-left input").is(':checked') == false){
      jQuery("div.jsjobs-check-container").removeClass('ck_blue');
    }
    if (jQuery("span.datablockhead-left input").is(':checked') == true){
      jQuery("div.jsjobs-check-container").addClass('ck_blue');
      
    }
  }

</script>

<script type="text/javascript">
    function confirmdeleteresume(id, task) {
        if (confirm("<?php echo JText::_('Are You Sure?'); ?>") == true) {
            return listItemTask(id, task);
        } else
            return false;
    }
</script>
