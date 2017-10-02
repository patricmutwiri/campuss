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
jimport('joomla.html.pane');
$document = JFactory::getDocument();
$document->addScript(JURI::base() . '/includes/js/joomla.javascript.js');
$document->addStyleSheet('components/com_jsjobs/css/token-input-jsjobs.css');
$document->addStyleSheet('components/com_jsjobs/css/combobox/chosen.css');
JHTML::_('behavior.calendar');
if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}
$document->addScript('components/com_jsjobs/js/jquery.tokeninput.js');
$document->addScript('components/com_jsjobs/js/combobox/chosen.jquery.js');
$document->addScript('components/com_jsjobs/js/combobox/prism.js');

$width_big = 40;
$width_med = 25;
$width_sml = 15;
?>
<div id="js_jobs_main_wrapper">
<div id="js_menu_wrapper">
    <?php
    if (sizeof($this->jobseekerlinks) != 0) {
        foreach ($this->jobseekerlinks as $lnk) {
            ?>                     
            <a class="js_menu_link <?php if ($lnk[2] == 'job_categories') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
            <?php
        }
    }
    if (sizeof($this->employerlinks) != 0) {
        foreach ($this->employerlinks as $lnk) {
            ?>
            <a class="js_menu_link <?php if ($lnk[2] == 'job_categories') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
            <?php
        }
    }
    ?>
</div>
<?php
if ($this->config['offline'] == '1') {
    $this->jsjobsmessages->getSystemOfflineMsg($this->config);
} else { ?>
        <div id="jsjobs-main-wrapper">
            <span class="jsjobs-main-page-title"><?php echo JText::_('Resume Search'); ?></span>
    <?php
        if ($this->canview == VALIDATE) { ?>
            <div class="jsjobs-field-main-wrapper">
            <form action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=resume&view=resume&layout=resume_searchresults&Itemid=' . $this->Itemid ,false); ?>" method="post" name="adminForm" id="adminForm" class="jsautoz_form" >
                <?php 
                    $k = 1;
                    $customfieldobj = getCustomFieldClass();
                    $fieldsordering = $this->getJSModel('fieldsordering')->getFieldsOrderingForSearchByFieldFor(3);
                    foreach ($fieldsordering as $field) {
                        switch ($field->field) {
                            case 'application_title': ?>
                                <div class="jsjobs-fieldwrapper">
                                    <div class="jsjobs-fieldtitle">
                                        <?php echo JText::_($field->fieldtitle); ?>
                                    </div>
                                    <div class="jsjobs-fieldvalue">
                                        <input class="inputbox" type="text" name="title" size="40" maxlength="255"  />
                                    </div>
                                </div>                      
                            <?php
                            break;
                            case 'first_name': ?>
                                <div class="jsjobs-fieldwrapper">
                                    <div class="jsjobs-fieldtitle">
                                        <?php echo JText::_($field->fieldtitle); ?>
                                    </div>
                                    <div class="jsjobs-fieldvalue">
                                        <input class="inputbox" type="text" name="name" size="40" maxlength="255"  />
                                    </div>
                                </div>                      
                            <?php
                            break;
                            case 'nationality': ?>
                                <div class="jsjobs-fieldwrapper">
                                    <div class="jsjobs-fieldtitle">
                                        <?php echo JText::_($field->fieldtitle); ?>
                                    </div>
                                    <div class="jsjobs-fieldvalue">
                                        <?php echo $this->searchoptions['nationality']; ?>
                                    </div>
                                </div>                      
                            <?php
                            break;
                            case 'gender': ?>
                                <div class="jsjobs-fieldwrapper">
                                    <div class="jsjobs-fieldtitle">
                                        <?php echo JText::_($field->fieldtitle); ?>
                                    </div>
                                    <div class="jsjobs-fieldvalue">
                                        <?php echo $this->searchoptions['gender']; ?>
                                    </div>
                                </div>                      
                            <?php
                            break;
                            case 'iamavailable': ?>
                                <div class="jsjobs-fieldwrapper">
                                    <div class="jsjobs-fieldtitle">
                                        <?php echo JText::_($field->fieldtitle); ?>
                                    </div>
                                    <div class="jsjobs-fieldvalue">
                                        <input type='checkbox' name='iamavailable' value='1' <?php if (isset($this->resume)) echo ($this->resume->iamavailable == 1) ? "checked='checked'" : ""; ?> />
                                    </div>
                                </div>                      
                            <?php
                            break;
                            case 'job_category': ?>
                                <div class="jsjobs-fieldwrapper">
                                    <div class="jsjobs-fieldtitle">
                                        <?php echo JText::_($field->fieldtitle); ?>
                                    </div>
                                    <div class="jsjobs-fieldvalue">
                                        <?php echo $this->searchoptions['jobcategory']; ?>
                                    </div>
                                </div>                      
                            <?php
                            break;
                            case 'job_subcategory': ?>
                                <div class="jsjobs-fieldwrapper">
                                    <div class="jsjobs-fieldtitle">
                                        <?php echo JText::_($field->fieldtitle); ?>
                                    </div>
                                    <div class="jsjobs-fieldvalue">
                                        <?php echo $this->searchoptions['jobsubcategory']; ?>
                                    </div>
                                </div>                      
                            <?php
                            break;
                            case 'jobtype': ?>
                                <div class="jsjobs-fieldwrapper">
                                    <div class="jsjobs-fieldtitle">
                                        <?php echo JText::_($field->fieldtitle); ?>
                                    </div>
                                    <div class="jsjobs-fieldvalue">
                                        <?php echo $this->searchoptions['jobtype']; ?>
                                    </div>
                                </div>                      
                            <?php
                            break;
                            case 'salary': ?>
                                <div class="jsjobs-fieldwrapper">
                                    <div class="jsjobs-fieldtitle">
                                        <?php echo JText::_($field->fieldtitle); ?>
                                    </div>
                                    <div class="jsjobs-fieldvalue">
                                        <span class="jsjobs-currancy"><?php echo $this->searchoptions['currency']; ?></span>
                                        <span class="jsjobs-salaryrange"><?php echo $this->searchoptions['jobsalaryrange']; ?></span>
                                    </div>
                                </div>                      
                            <?php
                            break;
                            case 'heighestfinisheducation': ?>
                                <div class="jsjobs-fieldwrapper">
                                    <div class="jsjobs-fieldtitle">
                                        <?php echo JText::_($field->fieldtitle); ?>
                                    </div>
                                    <div class="jsjobs-fieldvalue">
                                        <?php echo $this->searchoptions['heighestfinisheducation']; ?>
                                    </div>
                                </div>                      
                            <?php
                            break;
                            case 'total_experience': ?>
                                <div class="jsjobs-fieldwrapper">
                                    <div class="jsjobs-fieldtitle">
                                        <?php echo JText::_($field->fieldtitle); ?>
                                    </div>
                                    <div class="jsjobs-fieldvalue">
                                        <?php echo $this->searchoptions['experiencemin']; ?>
                                        <?php echo $this->searchoptions['experiencemax']; ?>
                                    </div>
                                </div>                      
                            <?php
                            break;
                            case 'address_city': ?>
                                <div class="jsjobs-fieldwrapper">
                                    <div class="jsjobs-fieldtitle">
                                        <?php echo JText::_($field->fieldtitle); ?>
                                    </div>
                                    <div class="jsjobs-fieldvalue">
                                        <input type="text" name="searchcity" size="40" id="searchcity"  value="" />
                                    </div>
                                </div>                      
                            <?php
                            break;
                            case 'address_zipcode': ?>
                                <div class="jsjobs-fieldwrapper">
                                    <div class="jsjobs-fieldtitle">
                                        <?php echo JText::_($field->fieldtitle); ?>
                                    </div>
                                    <div class="jsjobs-fieldvalue">
                                        <input class="inputbox" type="text" name="zipcode" size="10" maxlength="15"  />
                                    </div>
                                </div>                      
                            <?php
                            break;
                            case 'keywords': ?>
                                <div class="jsjobs-fieldwrapper">
                                    <div class="jsjobs-fieldtitle">
                                        <?php echo JText::_($field->fieldtitle); ?>
                                    </div>
                                    <div class="jsjobs-fieldvalue">
                                        <input class="inputbox" type="text" name="keywords" size="40"   />
                                    </div>
                                </div>                      
                            <?php
                            break;
                            default:
                                $params = null;
                                $f_res = $customfieldobj->formCustomFieldsForSearch($field, $k, $params , 1);
                                if($f_res){ ?>
                                    <div class="jsjobs-fieldwrapper">
                                        <div class="jsjobs-fieldtitle">
                                            <?php echo JText::_($f_res['title']); ?>
                                        </div>
                                        <div class="jsjobs-fieldvalue">
                                            <?php echo $f_res['field']; ?>
                                        </div>
                                    </div>
                                    <?php
                                } 
                            break;
                        }
                    }
                    ?>
                <div class="fieldwrapper-btn">
                    <div class="jsjobs-folder-info-btn">
                        <sapn class="jsjobs-folder-btn">
                            <input type="submit" id="button" class="button jsjobs_button" name="submit_app" onclick="document.adminForm.submit();" value="<?php echo JText::_('Resume Search'); ?>" />
                        </sapn>
                    </div>
                </div>

                <input type="hidden" name="isresumesearch" value="1" />
                <input type="hidden" name="view" value="resume" />
                <input type="hidden" name="layout" value="resume_searchresults" />
                <input type="hidden" name="uid" value="<?php echo $this->uid; ?>" />
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" name="task11" value="view" />
                <script language="javascript">
                    function fj_getsubcategories(src, val) {
                        jQuery("#" + src).html("Loading ...");
                        jQuery.post('<?php echo JURI::root(); ?>index.php?option=com_jsjobs&c=subcategory&task=listsubcategoriesForSearch', {val: val}, function (data) {
                            if (data) {
                                jQuery("#" + src).html(data);
                                jQuery("#" + src + " select.jsjobs-cbo").chosen();
                            } else {
                                jQuery("#" + src).html('<?php echo '<input type="text" name="jobsubcategory" value="">'; ?>');
                            }
                        });

                    }
                </script>


            </form>
            </div>
        <?php
    } else {
        switch ($this->canview) {
            case NO_PACKAGE:
                $link = "index.php?option=com_jsjobs&c=employerpackages&view=employerpackages&layout=packages&Itemid=".$this->Itemid;
                $vartext = JText::_('Package is required to perform this action').', '.JText::_('please get package');
                $this->jsjobsmessages->getPackageExpireMsg('You do not have package', $vartext, $link);
                break;
            case EXPIRED_PACKAGE:
                $link = "index.php?option=com_jsjobs&c=employerpackages&view=employerpackages&layout=packages&Itemid=".$this->Itemid;
                $vartext = JText::_('Package is required to perform this action and your current package is expired').','.JText::_('please get new package');
                $this->jsjobsmessages->getPackageExpireMsg('Your current package is expired',$vartext, $link);
                break;
            case RESUME_SEARCH_NOT_ALLOWED_IN_PACAKGE:
                $link = "index.php?option=com_jsjobs&c=employerpackages&view=employerpackages&layout=packages&Itemid=".$this->Itemid;
                $vartext = JText::_('Package is required to perform this action and your current package is expired').','.JText::_('please get new package');
                $this->jsjobsmessages->getPackageExpireMsg('Resume search is not allowed in package',$vartext, $link);
                break;
            case JOBSEEKER_NOT_ALLOWED_EMPLOYER_PRIVATE_AREA:
                $this->jsjobsmessages->getAccessDeniedMsg('Job seeker not allowed', 'Job seeker is not allowed in employer private area', 0);
                break;
            case USER_ROLE_NOT_SELECTED:
                $link = "index.php?option=com_jsjobs&c=common&view=common&layout=new_injsjobs&Itemid=".$this->Itemid;
                $vartext = JText::_('You do not select your role').', '.JText::_('Please select your role');
                $this->jsjobsmessages->getUserNotSelectedMsg('You do not select your role',$vartext, $link);
                break;
            case VISITOR_NOT_ALLOWED_EMPLOYER_PRIVATE_AREA:
                $this->jsjobsmessages->getAccessDeniedMsg('You are not logged in', 'Please login to access private area', 1);
                break;
        }
    } ?>
        </div>
    <?php
}//ol
?>  
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
</div>
 
<script type="text/javascript" language="javascript">
    jQuery(document).ready(function () {
        jQuery("#searchcity").tokenInput("<?php echo JURI::root() . "index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname"; ?>", {
            theme: "jsjobs",
            preventDuplicates: true,
            hintText: "<?php echo JText::_('Type In A Search'); ?>",
            noResultsText: "<?php echo JText::_('No Results'); ?>",
            searchingText: "<?php echo JText::_('Searching...'); ?>",
            tokenLimit: 1
        });

    });

</script>