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
    $line_chart_text = JText::_('Statistics');
    $userrole = $this->userrole;
    $config = $this->config;
    $emcontrolpanel = $this->emcontrolpanel;
    if (isset($userrole->rolefor)) {
        if ($userrole->rolefor == 1){ // employer
            $allowed = true;
            $line_chart_text = JText::_('Jobs');
        }else
            $allowed = false;
    }else {
        if ($config['visitorview_emp_conrolpanel'] == 1)
            $allowed = true;
        else
            $allowed = false;
    } // user not logined
    if ($allowed == true) {
        ?>
        <div id="jsjobs-main-wrapper">
            <span class="jsjobs-main-page-title"><?php echo JText::_('My Stuff'); ?></span>
            <div id="jsjobs-emp-cp-wrapper">
                <div class="jsjobs-cp-toprow">
                    <?php
                    $print = checkLinks('myjobs', $userrole, $config, $emcontrolpanel);
                    if ($print) {
                        ?>
                        <div class="js-col-xs-4 js-col-md-4 js-menu-wrap js-tablet js-mobile">
                            <a class="menu_style color2" href="index.php?option=com_jsjobs&c=job&view=job&layout=myjobs&Itemid=<?php echo $this->Itemid; ?>">
                                <span class="jsjobs-img"><img  src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/jobs.png"></span> 
                                <span class="jsjobs-title"><?php echo JText::_('My Jobs'); ?></span>
                            </a>
                        </div>
                    <?php
                    }
                    $print = checkLinks('formjob', $userrole, $config, $emcontrolpanel);
                    if ($print) {
                        ?>
                        <div class="js-col-xs-4 js-col-md-4 js-menu-wrap js-tablet">
                            <a class="menu_style color1" href="index.php?option=com_jsjobs&c=job&view=job&layout=formjob&Itemid=<?php echo $this->Itemid; ?>">
                                <span class="jsjobs-img"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/add-job.png"></span>
                                <span class="jsjobs-title"><?php echo JText::_('New Job'); ?></span>
                            </a>
                        </div>
                        <?php
                    }
                    $print = checkLinks('resumesearch', $userrole, $config, $emcontrolpanel);
                    if ($print) {
                        ?>
                        <div class="js-col-xs-4 js-col-md-4 js-menu-wrap js-tablet">
                            <a class="menu_style color3" href="index.php?option=com_jsjobs&c=resume&view=resume&layout=resumebycategory&Itemid=<?php echo $this->Itemid; ?>">
                                <span class="jsjobs-img"><img  src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/categories.png"></span>
                                <span class="jsjobs-title"><?php echo JText::_('Resume By Category'); ?></span>
                            </a>
                        </div>
                        <?php
                    }
                    $print = checkLinks('resumesearch', $userrole, $config, $emcontrolpanel);
                    if ($print) {
                        ?>
                        <div class="js-col-xs-4 js-col-md-4 js-menu-wrap js-tablet">
                            <a class="menu_style color4" href="index.php?option=com_jsjobs&c=resume&view=resume&layout=resumesearch&Itemid=<?php echo $this->Itemid; ?>">
                                <span class="jsjobs-img"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/resme-search.png"></span>
                                <span class="jsjobs-title"><?php echo JText::_('Resume Search'); ?></span>
                            </a>
                        </div>
                    <?php } ?>
                </div>
                <div class="jsjobs-cp-graph-wrap">
                    <?php 
                        $showjobgraph = checkBlocks('jobs_graph', $userrole, $emcontrolpanel);
                        $showresumegraph = checkBlocks('resume_graph', $userrole, $emcontrolpanel);
 ?>
                </div>
                <?php 
                
                $showjobblock = checkBlocks('mystuff_area', $userrole, $emcontrolpanel);
                if($showjobblock){
                ?>
                <div class="jsjobs-cp-adding-section">
                    <span class="js-col-xs-12 js-col-md-12 js-sample-title"><?php echo JText::_('My Stuff'); ?></span>
                    <div class="js-col-xs-12 js-col-md-12 js-adding-btn">
                        <?php
                        $print = checkLinks('mycompanies', $userrole, $config, $emcontrolpanel);
                        if ($print) {
                            ?>
                            <div class="js-cp-employer-icon">
                                <a href="index.php?option=com_jsjobs&c=company&view=company&layout=mycompanies&Itemid=<?php echo $this->Itemid; ?>">
                                    <span class="jsjobs-new-company-icon"><img  src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/companies.png"> </span>
                                    <span class="jsjobs-new-company-title"><?php echo JText::_('My Companies'); ?></span>
                                </a>
                            </div>
                            <?php
                        }
                        $print = checkLinks('formcompany', $userrole, $config, $emcontrolpanel);
                        if ($print) {
                            ?>
                            <div class="js-cp-employer-icon">
                                <a href="index.php?option=com_jsjobs&c=company&view=company&layout=formcompany&Itemid=<?php echo $this->Itemid; ?>">
                                    <span class="jsjobs-new-company-icon"><img  src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/add-company.png"></span>
                                    <span class="jsjobs-new-company-title"><?php echo JText::_('New Company'); ?></span>
                                </a>
                            </div>
                        <?php
                        }
                        $print = checkLinks('mydepartment', $userrole, $config, $emcontrolpanel);
                        if ($print) {
                            ?>
                            <div class="js-cp-employer-icon">
                                <a href="index.php?option=com_jsjobs&c=department&view=department&layout=mydepartments&Itemid=<?php echo $this->Itemid; ?>">
                                    <span class="jsjobs-new-company-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/department.png"></span>
                                    <span class="jsjobs-new-company-title"><?php echo JText::_('My Departments'); ?></span>
                                </a>
                            </div>
                            <?php
                        }
                        $print = checkLinks('formdepartment', $userrole, $config, $emcontrolpanel);
                        if ($print) {
                            ?>
                            <div class="js-cp-employer-icon">
                                <a href="index.php?option=com_jsjobs&c=department&view=department&layout=formdepartment&Itemid=<?php echo $this->Itemid; ?>">
                                    <span class="jsjobs-new-company-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/add-departmnet.png"></span>
                                    <span class="jsjobs-new-company-title"><?php echo JText::_('New Department'); ?></span>
                                </a>
                            </div>
                            <?php
                        }
                        $print = checkLinks('my_resumesearches', $userrole, $config, $emcontrolpanel);
                        if ($print) {
                            ?>
                            <div class="js-cp-employer-icon">
                                <a href="index.php?option=com_jsjobs&c=resume&view=resume&layout=my_resumesearches&Itemid=<?php echo $this->Itemid; ?>">
                                    <span class="jsjobs-new-company-icon"><img  src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/save-resume.png"></span> 
                                    <span class="jsjobs-new-company-title"><?php echo JText::_('Resume Save Search'); ?></span>
                                </a>
                            </div>
                        <?php } ?>
                        <?php
                        if (isset($userrole->rolefor) && $userrole->rolefor == 1) {//jobseeker
                            $link = "index.php?option=com_users&view=profile&Itemid=" . $this->Itemid;
                            $text = JText::_('Profile');
                            $icon = "profile.png";
                        } else {
                            $link = "index.php?option=com_jsjobs&c=common&view=common&layout=userregister&userrole=3&Itemid=" . $this->Itemid;
                            $text = JText::_('Register');
                            $icon = "register.png";
                        }
                    if ($emcontrolpanel['emploginlogout'] == 1) {
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
                        <div class="js-cp-employer-icon">
                            <a href="<?php echo $link; ?>">
                                <span class="jsjobs-new-company-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/<?php echo $icon; ?>"></span>
                                <span class="jsjobs-new-company-title"><?php echo $text; ?></span>
                            </a>
                        </div> 
                    <?php
                    } ?>

                    </div> 
                </div>
                <?php

                }

                ?>


                <?php 
                $showstatsblock = checkBlocks('mystats_area', $userrole, $emcontrolpanel);
                if($showstatsblock){ ?>
                    <div class="js-cp-stats-panel">
                        <span class="js-col-xs-12 js-col-md-12 js-sample-title"><?php echo JText::_('Statistics');?></span>
                        <div class="js-col-xs-12 js-col-md-12 js-adding-btn">
                            <?php
                            $print = checkLinks('my_stats', $userrole, $config, $emcontrolpanel);
                            if ($print) {
                                ?>
                                <div class="js-cp-employer-icon">
                                    <a href="index.php?option=com_jsjobs&c=employer&view=employer&layout=my_stats&Itemid=<?php echo $this->Itemid; ?>">
                                        <span class="jsjobs-new-company-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/Stats.png"></span>
                                        <span class="jsjobs-new-company-title"><?php echo JText::_('My Stats'); ?></span>
                                    </a>
                                </div>
                            <?php }
                            ?>
                            <?php
                            $print = checkLinks('packages', $userrole, $config, $emcontrolpanel);
                            if ($print) {
                                ?>
                                <div class="js-cp-employer-icon">
                                    <a href="index.php?option=com_jsjobs&c=employerpackages&view=employerpackages&layout=packages&Itemid=<?php echo $this->Itemid; ?>">
                                        <span class="jsjobs-new-company-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/package.png"></span>
                                        <span class="jsjobs-new-company-title"><?php echo JText::_('Packages'); ?></span>
                                    </a>
                                </div>
                            <?php
                            }
                            $print = checkLinks('purchasehistory', $userrole, $config, $emcontrolpanel);
                            if ($print) {
                                ?>
                                <div class="js-cp-employer-icon">
                                    <a href="index.php?option=com_jsjobs&c=purchasehistory&view=purchasehistory&layout=employerpurchasehistory&Itemid=<?php echo $this->Itemid; ?>">
                                        <span class="jsjobs-new-company-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/log-history.png"></span>
                                        <span class="jsjobs-new-company-title"><?php echo JText::_('Purchase History'); ?></span>
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

        if ($emcontrolpanel['empexpire_package_message'] == 1) {
            $message = '';
            if (!empty($this->packagedetail[0]->packageexpiredays)) {
                $days = $this->packagedetail[0]->packageexpiredays - $this->packagedetail[0]->packageexpireindays;
                if ($days == 1)
                    $days = $days . ' ' . JText::_('Day');
                else
                    $days = $days . ' ' . JText::_('Days');
                $message = "<strong><font color='red'>" . JText::_('Your Package') . ' &quot;' . $this->packagedetail[0]->packagetitle . '&quot; ' . JText::_('Has Expired') . ' ' . $days . ' ' . JText::_('Ago') . ' <a href="index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=packages&Itemid=$this->Itemid">' . JText::_('Employer Packages') . "</a></font></strong>";
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
        <?php
    } else { // not allowed job posting 
        $this->jsjobsmessages->getAccessDeniedMsg('You are not allowed', 'You are not allowed to view employer control panel', 0);
    }
}
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

<?php

function checkBlocks($configname, $userrole, $emcontrolpanel) {
    $print = false;
    if (isset($userrole->rolefor)) {
        if ($userrole->rolefor == 1) {
            if ($emcontrolpanel[$configname] == 1)
                $print = true;
        }
    }else {
        $configname = 'vis_'.$configname;
        if ($emcontrolpanel[$configname] == 1)
            $print = true;
    }
    return $print;
}

function checkLinks($name, $userrole, $config, $emcontrolpanel) {
    $print = false;
    if (isset($userrole->rolefor)) {
        if ($userrole->rolefor == 1) {
            if ($name == 'empresume_rss') {
                if ($config[$name] == 1)
                    $print = true;
            }elseif ($emcontrolpanel[$name] == 1)
                $print = true;
        }
    }else {
        if ($name == 'empmessages')
            $name = 'vis_emmessages';
        elseif ($name == 'empresume_rss')
            $name = 'vis_resume_rss';
        else
            $name = 'vis_em' . $name;

        if ($config[$name] == 1)
            $print = true;
    }
    return $print;
}
?>