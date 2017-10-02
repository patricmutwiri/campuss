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
<div id="js_jobs_main_wrapper">
<div id="js_menu_wrapper">
    <?php
    if (sizeof($this->jobseekerlinks) != 0) {
        foreach ($this->jobseekerlinks as $lnk) {
            ?>                     
            <a class="js_menu_link <?php if ($lnk[2] == 'controlpanel') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
            <?php
        }
    }
    if (sizeof($this->employerlinks) != 0) {
        foreach ($this->employerlinks as $lnk) {
            ?>
            <a class="js_menu_link <?php if ($lnk[2] == 'controlpanel') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
            <?php
        }
    }
    ?>
</div>
<?php
if ($this->config['offline'] == '1') {
    $this->jsjobsmessages->getSystemOfflineMsg($this->config);
} else {
    $suggested_jobs_text = JText::_('Newest Jobs');
    $userrole = $this->userrole;
    $config = $this->config;
    $jscontrolpanel = $this->jscontrolpanel;
    if (isset($userrole->rolefor)) {
        if ($userrole->rolefor != '') {
            if ($userrole->rolefor == 2){ // job seeker
                $allowed = true;
                $suggested_jobs_text = JText::_('Suggested Jobs');
            }elseif ($userrole->rolefor == 1) { // employer
                if ($config['employerview_js_controlpanel'] == 1)
                    $allowed = true;
                else
                    $allowed = false;
            }
        }else {
            $allowed = true;
        }
    } else{
        if($config['visitorview_js_controlpanel'] == 1)
            $allowed = true; // user not logined
        else
            $allowed = false;
    }
    if ($allowed == true) {
        $message = '';
        if ($jscontrolpanel['jsexpire_package_message'] == 1) {
            if (!empty($this->packagedetail[0]->packageexpiredays)) {
                $days = $this->packagedetail[0]->packageexpiredays - $this->packagedetail[0]->packageexpireindays;
                if ($days == 1)
                    $days = $days . ' ' . JText::_('Day');
                else
                    $days = $days . ' ' . JText::_('Days');
                $message = "<strong><font color='red'>" . JText::_('Your Package') . ' &quot;' . $this->packagedetail[0]->packagetitle . '&quot; ' . JText::_('Has Expired') . ' ' . $days . ' ' . JText::_('Ago') . " <a href='index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=packages&Itemid=$this->Itemid'>" . JText::_('Job Seeker Packages') . "</a></font></strong>";
            }
            if ($message != '') {
                ?>
                <div id="errormessage" class="errormessage">
                    <div id="message"><?php echo $message; ?></div>
                </div>
            <?php
            }
        }
        ?>
        <div id="jsjobs-main-wrapper">
            <span class="jsjobs-main-page-title"><?php echo JText::_('My Stuff'); ?></span>
             <div id="jsjobs-emp-cp-wrapper">
              <div class="jsjobs-cp-toprow-job-seeker">
               <?php
            $print = checkLinks('listnewestjobs', $userrole, $config, $jscontrolpanel);
            if ($print) {
                ?>
                <div class="js-col-xs-12 js-col-md-4 js-menu-wrap-job-seeker">
                    <a class="menu_style-job-seeker color3" href="index.php?option=com_jsjobs&c=job&view=job&layout=jobs&Itemid=<?php echo $this->Itemid; ?>">
                        <img class="jsjobs-img-job-seeker" src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/jobseeker/jobs.png"> 
                        <span class="jsjobs-title-job-seeker"><?php echo JText::_('Newest Jobs'); ?></span>
                    </a>
                </div>
                <?php
            }
           $print = checkLinks('myappliedjobs', $userrole, $config, $jscontrolpanel);
           if ($print) {
                  ?>
                 <div class="js-col-xs-12 js-col-md-4 js-menu-wrap-job-seeker">
                    <a class="menu_style-job-seeker color1" href="index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=myappliedjobs&Itemid=<?php echo $this->Itemid; ?>">
                        <span class="jsjobs-img-job-seeker"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/jobseeker/applied-jobs.png"></span>
                        <span class="jsjobs-title-job-seeker"><?php echo JText::_('My Applied Job'); ?></span>
                    </a> 
                 </div>
                  <?php
           }
            $print = checkLinks('myresumes', $userrole, $config, $jscontrolpanel);
            if ($print) {
                ?>
                <div class="js-col-xs-12 js-col-md-4 js-menu-wrap-job-seeker">
                    <a class="menu_style-job-seeker color2" href="index.php?option=com_jsjobs&c=jobapply&view=resume&layout=myresumes&Itemid=<?php echo $this->Itemid; ?>">
                        <img class="jsjobs-img-job-seeker" src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/jobseeker/add-resume.png"> 
                        <span class="jsjobs-title"><?php echo JText::_('My Resume'); ?></span>
                    </a>
                </div>
                 <?php
            }
            $print = checkLinks('jobsearch', $userrole, $config, $jscontrolpanel);
            if ($print) {
                ?>
                <div class="js-col-xs-12 js-col-md-4 js-menu-wrap-job-seeker">
                    <a class="menu_style-job-seeker color4" href="index.php?option=com_jsjobs&c=job&view=job&layout=jobsearch&Itemid=<?php echo $this->Itemid; ?>">
                        <img class="jsjobs-img-job-seeker" src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/jobseeker/search-job.png"> 
                        <span class="jsjobs-title-job-seeker"><?php echo JText::_('Search Job'); ?></span>
                    </a>
                </div>
                <?php
             }
                ?>
              </div>
              <?php 

                $showjobblock = checkBlocks('jsmystuff_area', $userrole, $config, $jscontrolpanel);
              if($showjobblock){ ?>
                <div class="jsjobs-cp-jobseeker-categories">
                 <div class="js-col-xs-12 js-col-md-12 jsjobs-cp-jobseeker-categories-btn">
                    <span class="js-cp-graph-title"><?php echo JText::_('Jobs');?></span>
                    <div class="js-col-xs-12 js-col-md-12 jsjobs-cp-jobseeker-category-btn">
                       <?php
                          $print = checkLinks('jobcat', $userrole, $config, $jscontrolpanel);
                          if ($print) {
                         ?>
                       <div class="js-cp-jobseeker-icon">
                          <a href="index.php?option=com_jsjobs&c=category&view=category&layout=jobcat&Itemid=<?php echo $this->Itemid; ?>">
                              <span class="jsjobs-cp-img-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/jobseeker/job-category.png"></span>
                              <span class="jsjobs-cp-jobseeker-title"><?php echo JText::_('Job By Category'); ?></span>
                          </a> 
                       </div>
                        <?php
                         }

                        $print = checkLinks('formresume', $userrole, $config, $jscontrolpanel);
                        if ($print) {
                            ?>
                           <div class="js-cp-jobseeker-icon">
                                <a class="menu_style-job-seeker color1" href="index.php?option=com_jsjobs&view=resume&layout=formresume&Itemid=<?php echo $this->Itemid; ?>">
                                    <span class="jsjobs-cp-img-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/jobseeker/resume.png"></span>
                                    <span class="jsjobs-cp-jobseeker-title"><?php echo JText::_('Add Resume'); ?></span>
                                </a>
                            </div>
                            <?php }
                         $print = checkLinks('my_jobsearches', $userrole, $config, $jscontrolpanel);
                         if ($print) {
                        ?> 
                       <div class="js-cp-jobseeker-icon">
                          <a href="index.php?option=com_jsjobs&c=jobsearch&view=jobsearch&layout=my_jobsearches&Itemid=<?php echo $this->Itemid; ?>">
                              <span class="jsjobs-cp-img-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/jobseeker/search-job.png"></span>
                              <span class="jsjobs-cp-jobseeker-title"><?php echo JText::_('Job Save Search'); ?></span>
                          </a> 
                       </div>
                        <?php
                         }
                          $print = checkLinks('mycoverletters', $userrole, $config, $jscontrolpanel);
                                               if ($print) {
                        ?>
                       <div class="js-cp-jobseeker-icon">
                                              <a href="index.php?option=com_jsjobs&c=coverletter&view=coverletter&layout=mycoverletters&Itemid=<?php echo $this->Itemid; ?>">
                              <span class="jsjobs-cp-img-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/jobseeker/cover-letter.png"></span>
                              <span class="jsjobs-cp-jobseeker-title"><?php echo JText::_('My Cover Letter'); ?></span>
                          </a> 
                       </div>
                        <?php
                         }
                          $print = checkLinks('formcoverletter', $userrole, $config, $jscontrolpanel);
                          if ($print) {
                        ?>
                       <div class="js-cp-jobseeker-icon">
                          <a href="index.php?option=com_jsjobs&c=coverletter&view=coverletter&layout=formcoverletter&Itemid=<?php echo $this->Itemid; ?>">
                              <span class="jsjobs-cp-img-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/jobseeker/add-coverletter.png"></span>
                              <span class="jsjobs-cp-jobseeker-title"><?php echo JText::_('Add Cover Letter'); ?></span>
                          </a> 
                       </div>
                       <?php
                        }
                         if (isset($userrole->rolefor) && $userrole->rolefor == 2) {//jobseeker
                           $link = "index.php?option=com_users&view=profile&Itemid=" . $this->Itemid;
                           $text = JText::_('Profile');
                           $icon = "profile.png";
                          } else {
                           $link = "index.php?option=com_jsjobs&c=common&view=common&layout=userregister&userrole=2&Itemid=" . $this->Itemid;
                           $text = JText::_('Register');
                           $icon = "register.png";
                         }
                         if ($jscontrolpanel['jobsloginlogout'] == 1) {
                           if (isset($userrole->rolefor)) {//jobseeker
                             $link = "index.php?option=com_jsjobs&task=jsjobs.logout&Itemid=" . $this->Itemid;
                             $text = JText::_('Logout');
                             $icon = "login.png";
                           } else {
                             $redirectUrl = JRoute::_('index.php?option=com_jsjobs&c=jobseeker&view=jobseeker&layout=controlpanel&Itemid=' . $this->Itemid ,false);
                             $redirectUrl = '&amp;return=' . $this->getJSModel('common')->b64ForEncode($redirectUrl);
                             $link = 'index.php?option=com_users&view=login' . $redirectUrl;
                             $text = JText::_('Login');
                             $icon = "login.png";
                            }
                          ?> 
                         <div class="js-cp-jobseeker-icon">
                            <a href="<?php echo $link; ?>">
                                <span class="jsjobs-cp-img-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/jobseeker/<?php echo $icon; ?>"></span>
                                <span class="jsjobs-cp-jobseeker-title"><?php echo $text; ?></span>
                            </a> 
                         </div>
                       <?php } ?> 
                    </div>
                 </div>
              </div>
              <?php
              } ?>
            <?php 

              $showstatsblock = checkBlocks('jsmystats_area', $userrole, $config, $jscontrolpanel);
            if($showstatsblock){ ?>
                <div class="jsjobs-cp-jobseeker-stats">
                   <span class="js-col-xs-12 js-col-md-12 js-sample-title"><?php echo JText::_('Statistics');?></span>
                  <div class="js-col-xs-12 js-col-md-12 js-cp-jobseeker-stats">
                       <?php
                         $print = checkLinks('jsmy_stats', $userrole, $config, $jscontrolpanel);
                         if ($print) {
                         ?>
                       <div class="js-cp-jobseeker-icon">
                          <a href="index.php?option=com_jsjobs&c=jobseeker&view=jobseeker&layout=my_stats&Itemid=<?php echo $this->Itemid; ?>">
                              <span class="jsjobs-cp-img-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/jobseeker/reports.png"></span>
                              <span class="jsjobs-cp-jobseeker-title"><?php echo JText::_('My Stats'); ?></span>
                          </a> 
                       </div>
                        <?php
                         }
                         $print = checkLinks('jspackages', $userrole, $config, $jscontrolpanel);
                         if ($print) {
                        ?>
                      <div class="js-cp-jobseeker-icon">
                          <a href="index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=packages&Itemid=<?php echo $this->Itemid; ?>">
                              <span class="jsjobs-cp-img-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/jobseeker/package.png"></span>
                              <span class="jsjobs-cp-jobseeker-title"><?php echo JText::_('Packages'); ?></span>
                          </a> 
                       </div>
                       <?php
                         }
                        $print = checkLinks('jspurchasehistory', $userrole, $config, $jscontrolpanel);
                        if ($print) {
                            ?>
                            <div class="js-cp-jobseeker-icon">
                                <a href="index.php?option=com_jsjobs&c=purchasehistory&view=purchasehistory&layout=jobseekerpurchasehistory&Itemid=<?php echo $this->Itemid; ?>">
                                    <span class="jsjobs-cp-img-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/log-history.png"></span>
                                    <span class="jsjobs-cp-jobseeker-title"><?php echo JText::_('Purchase History'); ?></span>
                                </a>
                            </div>
                        <?php }
                       ?>
                  </div>
              </div> 
              <?php
              } 
              ?>


            </div>
        </div>
        <?php
    } else { // not allowed job posting 
        $this->jsjobsmessages->getAccessDeniedMsg('You are not allowed', 'You are not allowed to view Job Seeker control panel', 0);
    }
}//ol
?>
<!-- <div id="jsjobsfooter" class="hidden">
    <table width="100%" style="table-layout:fixed;">
        <tr><td height="15"></td></tr>
        <tr>
            <td style="vertical-align:top;" align="center">
                <a class="img" target="_blank" href="http://www.joomsky.com"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png"></a>
                <br>
                Copyright &copy; 2008 - <?php echo  date('Y') ?> ,
                <span id="themeanchor"> <a class="anchor"target="_blank" href="http://www.burujsolutions.com">Buruj Solutions</a></span>
            </td>
        </tr>
    </table>
</div> -->

</div>
 
<?php

function checkBlocks($configname, $userrole, $config, $jscontrolpanel) {
    $print = false;
    if (isset($userrole->rolefor)) {
        if ($userrole->rolefor == 2) {
            if ($jscontrolpanel[$configname] == 1)
                $print = true;
        }elseif ($userrole->rolefor == 1) {
            if ($config['employerview_js_controlpanel'] == 1){
              $visname = 'vis_'.$configname;
                if ($jscontrolpanel[$visname] == 1){
                  $print = true;
                }
            }
        }
    }else {
        $configname = 'vis_'.$configname;
        if ($jscontrolpanel[$configname] == 1)
            $print = true;
    }
    return $print;  
}

function checkLinks($name, $userrole, $config, $jscontrolpanel) {
    $print = false;
    switch ($name) {
        case 'jspackages': $visname = 'vis_jspackages';
            break;
        case 'jspurchasehistory': $visname = 'vis_jspurchasehistory';
            break;
        case 'jsmy_stats': $visname = 'vis_jsmy_stats';
            break;
        case 'jsmessages': $visname = 'vis_jsmessages';
            break;
        case 'jsjob_rss': $visname = 'vis_job_rss';
            break;
        case 'jsregister': $visname = 'vis_jsregister';
            break;

        default:$visname = 'vis_js' . $name;
            break;
    }
    if (isset($userrole->rolefor)) {
        if ($userrole->rolefor == 2) {
            if ($name == 'jsjob_rss') {
                if ($config[$name] == 1)
                    $print = true;
            }elseif ($jscontrolpanel[$name] == 1)
                $print = true;
        }elseif ($userrole->rolefor == 1) {
            if ($config['employerview_js_controlpanel'] == 1)
                if ($config[$visname] == 1)
                    $print = true;
        }
    }else {
        if ($config[$visname] == 1)
            $print = true;
    }
    return $print;
}
?>