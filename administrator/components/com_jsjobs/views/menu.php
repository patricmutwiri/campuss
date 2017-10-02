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
    $ff = JRequest::getVar('ff', 0);
    if ($ff == 0) $ff = JRequest::getVar('fieldfor', 0);
    $c = JRequest::getVar('c');
?>
<div id="js-tk-links">
    <div class="js-divlink">
        <a href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=controlpanel">
            <img src="components/com_jsjobs/include/images/left_menu_icons/admin.png" />
        </a>
        <a href="#" class="js-parent <?php if($c=='jsjobs' || $c=='jobtype' || $c=='jobstatus' || $c=='shift' || $c=='highesteducation' || $c=='age' || $c=='careerlevel' || $c=='experience' || $c=='currency') echo 'lastshown'; ?>"><span class="text"><?php echo JText::_('Admin'); ?> <img class="arrow" src="components/com_jsjobs/include/images/left_menu_icons/arrow1.png"/></span></a>
        <div class="js-innerlink">
            <a class="js-child" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=controlpanel"><span class="text"> <?php echo JText::_('Control Panel'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=jobtype&view=jobtype&layout=jobtypes"><span class="text"><?php echo JText::_('Job Types'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=jobstatus&view=jobstatus&layout=jobstatus"><span class="text"> <?php echo JText::_('Job Status'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=shift&view=shift&layout=shifts"><span class="text"> <?php echo JText::_('Shifts'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=highesteducation&view=highesteducation&layout=highesteducations"><span class="text"> <?php echo JText::_('Highest Education'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=age&view=age&layout=ages"><span class="text"> <?php echo JText::_('Ages'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=careerlevel&view=careerlevel&layout=careerlevels"><span class="text"> <?php echo JText::_('Career Levels'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=experience&view=experience&layout=experience"><span class="text"> <?php echo JText::_('Experience'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=info"><span class="text"> <?php echo JText::_('Information'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=stepone"><span class="text"> <?php echo JText::_('JS Job Update'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=currency&view=currency&layout=currency"><span class="text"> <?php echo JText::_('Currency'); ?></span></a>
        </div>
    </div>
    <?php /*
    <div class="js-divlink">
        <a href="index.php?option=com_jsjobs&c=jobsharing&view=jobsharing&layout=jobshare">
            <img src="components/com_jsjobs/include/images/left_menu_icons/shearing.png" />
        </a>
        <a href="#" class="js-parent <?php if($c == 'jobsharing') echo 'lastshown'; ?>"><span class="text"><?php echo JText::_('Sharing Service'); ?><img class="arrow" src="components/com_jsjobs/include/images/left_menu_icons/arrow1.png"/></span></a>
        <div class="js-innerlink">
            <a class="js-child" href="index.php?option=com_jsjobs&c=jobsharing&view=jobsharing&layout=jobshare"><span class="text"> <?php echo JText::_('Job Sharing'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=jobsharing&view=jobsharing&layout=jobsharelog"><span class="text"> <?php echo JText::_('Job Share Log'); ?></span></a>
        </div>
    </div>
    */  ?>
    <div class="js-divlink">
        <a href="index.php?option=com_jsjobs&c=configuration&view=configuration&layout=configurations">
            <img src="components/com_jsjobs/include/images/left_menu_icons/configration.png" />
        </a>
        <a href="#" class="js-parent <?php if($c == 'configuration' || $c == 'paymentmethodconfiguration') echo 'lastshown'; ?>"><span class="text"><?php echo JText::_('Configurations'); ?><img class="arrow" src="components/com_jsjobs/include/images/left_menu_icons/arrow1.png"/></span></a>
        <div class="js-innerlink">
            <a class="js-child" href="index.php?option=com_jsjobs&c=configuration&view=configuration&layout=configurations"><span class="text"><?php echo JText::_('General'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=configuration&view=configuration&layout=configurationsemployer"><span class="text"><?php echo JText::_('Employer'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=configuration&view=configuration&layout=configurationsjobseeker"><span class="text"><?php echo JText::_('Job Seeker'); ?></span></a>
        </div>
    </div>
    <div class="js-divlink">
        <a href="index.php?option=com_jsjobs&c=company&view=company&layout=companies">
            <img src="components/com_jsjobs/include/images/left_menu_icons/company.png" />
        </a>
        <a href="#" class="js-parent <?php if($c == 'company' || $ff == 1) echo 'lastshown'; ?>"><span class="text"><?php echo JText::_('Companies'); ?><img class="arrow" src="components/com_jsjobs/include/images/left_menu_icons/arrow1.png"/></span></a>
        <div class="js-innerlink">
            <a class="js-child" href="index.php?option=com_jsjobs&c=company&view=company&layout=companies"><span class="text"><?php echo JText::_('Companies'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=company&view=company&layout=companiesqueue"><span class="text"><?php echo JText::_('Approval Queue'); ?></span></a>
            
            <a class="js-child" href="index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff=1"><span class="text"><?php echo JText::_('Fields'); ?></span></a>
        </div>
    </div>
    <div class="js-divlink">
        <a href="index.php?option=com_jsjobs&c=department&view=department&layout=departments">
            <img src="components/com_jsjobs/include/images/left_menu_icons/departments.png" />
        </a>
        <a href="#" class="js-parent <?php if($c == 'department') echo 'lastshown'; ?>"><span class="text"><?php echo JText::_('Departments'); ?><img class="arrow" src="components/com_jsjobs/include/images/left_menu_icons/arrow1.png"/></span></a>
        <div class="js-innerlink">
            <a class="js-child" href="index.php?option=com_jsjobs&c=department&view=department&layout=departments"><span class="text"><?php echo JText::_('Departments'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=department&view=department&layout=departmentqueue"><span class="text"><?php echo JText::_('Approval Queue'); ?></span></a>
        </div>
    </div>
    <div class="js-divlink">
        <a href="index.php?option=com_jsjobs&c=job&view=job&layout=jobs">
            <img src="components/com_jsjobs/include/images/left_menu_icons/jobs.png" />
        </a>
        <a href="#" class="js-parent <?php if($c == 'job' || $c == 'jobalert' || $ff == 2) echo 'lastshown'; ?>"><span class="text"><?php echo JText::_('Jobs'); ?><img class="arrow" src="components/com_jsjobs/include/images/left_menu_icons/arrow1.png"/></span></a>
        <div class="js-innerlink">
            <a class="js-child" href="index.php?option=com_jsjobs&c=job&view=job&layout=jobs"><span class="text"><?php echo JText::_('Jobs'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=job&view=job&layout=jobqueue"><span class="text"><?php echo JText::_('Approval Queue'); ?></span></a>
            
            <a class="js-child" href="index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff=2"><span class="text"><?php echo JText::_('Fields'); ?></span></a>
        </div>
    </div>
    <div class="js-divlink">
        <a href="index.php?option=com_jsjobs&c=resume&view=resume&layout=empapps">
            <img src="components/com_jsjobs/include/images/left_menu_icons/resume.png" />
        </a>
        <a href="#" class="js-parent <?php if($c == 'resume' || $ff == 3) echo 'lastshown'; ?>"><span class="text"><?php echo JText::_('Resume'); ?><img class="arrow" src="components/com_jsjobs/include/images/left_menu_icons/arrow1.png"/></span></a>
        <div class="js-innerlink">
            <a class="js-child" href="index.php?option=com_jsjobs&c=resume&view=resume&layout=empapps"><span class="text"><?php echo JText::_('Resume'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=resume&view=resume&layout=appqueue"><span class="text"><?php echo JText::_('Approval Queue'); ?></span></a>
            
            <a class="js-child" href="index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff=3"><span class="text"><?php echo JText::_('Fields'); ?></span></a>
        </div>
    </div>
    <div class="js-divlink">
        <a href="index.php?option=com_jsjobs&c=employerpackages&view=employerpackages&layout=employerpackages">
            <img src="components/com_jsjobs/include/images/left_menu_icons/packages.png" />
        </a>
        <a href="#" class="js-parent <?php if($c == 'employerpackages' || $c == 'jobseekerpackages') echo 'lastshown'; ?>"><span class="text"><?php echo JText::_('Packages'); ?><img class="arrow" src="components/com_jsjobs/include/images/left_menu_icons/arrow1.png"/></span></a>
        <div class="js-innerlink">
            <a class="js-child" href="index.php?option=com_jsjobs&c=employerpackages&view=employerpackages&layout=employerpackages"><span class="text"><?php echo JText::_('Employer Packages'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=jobseekerpackages"><span class="text"><?php echo JText::_('Job Seeker Packages'); ?></span></a>
        </div>
    </div>
    <div class="js-divlink">
        <a href="index.php?option=com_jsjobs&c=paymenthistory&view=paymenthistory&layout=employerpaymenthistory">
            <img src="components/com_jsjobs/include/images/left_menu_icons/payment.png" />
        </a>
        <a href="#" class="js-parent <?php if($c == 'paymenthistory') echo 'lastshown'; ?>"><span class="text"><?php echo JText::_('Payments'); ?><img class="arrow" src="components/com_jsjobs/include/images/left_menu_icons/arrow1.png"/></span></a>
        <div class="js-innerlink">
            <a class="js-child" href="index.php?option=com_jsjobs&c=paymenthistory&view=paymenthistory&layout=employerpaymenthistory"><span class="text"><?php echo JText::_('Employer History'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=paymenthistory&view=paymenthistory&layout=jobseekerpaymenthistory"><span class="text"><?php echo JText::_('Job Seeker History'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=paymenthistory&view=paymenthistory&layout=payment_report"><span class="text"><?php echo JText::_('Payment Report'); ?></span></a>
        </div>
    </div>
    <div class="js-divlink">
        <a href="index.php?option=com_jsjobs&c=category&view=category&layout=categories">
            <img src="components/com_jsjobs/include/images/left_menu_icons/category.png" />
        </a>
        <a href="#" class="js-parent <?php if($c == 'category') echo 'lastshown'; ?>"><span class="text"><?php echo JText::_('Categories'); ?><img class="arrow" src="components/com_jsjobs/include/images/left_menu_icons/arrow1.png"/></span></a>
        <div class="js-innerlink">
            <a class="js-child" href="index.php?option=com_jsjobs&c=category&view=category&layout=categories"><span class="text"><?php echo JText::_('Categories'); ?></span></a>
        </div>
    </div>
    <div class="js-divlink">
        <a href="index.php?option=com_jsjobs&c=salaryrange&view=salaryrange&layout=salaryrange">
            <img src="components/com_jsjobs/include/images/left_menu_icons/salary_range.png" />
        </a>
        <a href="#" class="js-parent <?php if($c == 'salaryrange' || $c == 'salaryrangetype') echo 'lastshown'; ?>"><span class="text"><?php echo JText::_('Salary Range'); ?><img class="arrow" src="components/com_jsjobs/include/images/left_menu_icons/arrow1.png"/></span></a>
        <div class="js-innerlink">
            <a class="js-child" href="index.php?option=com_jsjobs&c=salaryrange&view=salaryrange&layout=salaryrange"><span class="text"><?php echo JText::_('Salary Range'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=salaryrangetype&view=salaryrangetype&layout=salaryrangetype"><span class="text"><?php echo JText::_('Salary Range Type'); ?></span></a>
        </div>
    </div>
    <div class="js-divlink">
        <a href="index.php?option=com_jsjobs&c=userrole&view=userrole&layout=users">
            <img src="components/com_jsjobs/include/images/left_menu_icons/role.png" />
        </a>
        <a href="#" class="js-parent <?php if($c == 'userrole' || $c == 'user') echo 'lastshown'; ?>"><span class="text"><?php echo JText::_('User Roles'); ?><img class="arrow" src="components/com_jsjobs/include/images/left_menu_icons/arrow1.png"/></span></a>
        <div class="js-innerlink">
            <a class="js-child" href="index.php?option=com_jsjobs&c=userrole&view=userrole&layout=users"><span class="text"><?php echo JText::_('Users'); ?></span></a>
        </div>
    </div>
    <div class="js-divlink">
        <a href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ew-cm">
            <img src="components/com_jsjobs/include/images/left_menu_icons/email_tempeltes.png" />
        </a>
        <a href="#" class="js-parent <?php if($c == 'emailtemplate') echo 'lastshown'; ?>"><span class="text"><?php echo JText::_('Email Templates'); ?><img class="arrow" src="components/com_jsjobs/include/images/left_menu_icons/arrow1.png"/></span></a>
        <div class="js-innerlink">
            <a class="js-child" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplateoptions"><span class="text"> <?php echo JText::_('Options'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ew-cm"><span class="text"> <?php echo JText::_('New Company'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=cm-ap"><span class="text"> <?php echo JText::_('Company Approval'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=cm-rj"><span class="text"> <?php echo JText::_('Company Rejection'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=cm-dl"><span class="text"> <?php echo JText::_('Company Delete'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ew-ob"><span class="text"> <?php echo JText::_('New Job').'('.JText::_('Admin').')'; ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ew-ob-em"><span class="text"> <?php echo JText::_('New Job').'('.Jtext::_('Employer').')'; ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ob-ap"><span class="text"> <?php echo JText::_('Job Approval'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ob-rj"><span class="text"> <?php echo JText::_('Job Rejecting'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ob-dl"><span class="text"> <?php echo JText::_('Job Delete'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ap-rs"><span class="text"> <?php echo JText::_('Applied Resume Status'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ew-rm"><span class="text"> <?php echo JText::_('New Resume'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ew-rm-vis"><span class="text"> <?php echo JText::_('New Resume').' '.JText::_('Visitor'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=rm-ap"><span class="text"> <?php echo JText::_('Resume Approval'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=rm-rj"><span class="text"> <?php echo JText::_('Resume Rejecting'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=rm-dl"><span class="text"> <?php echo JText::_('Resume Delete'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ba-ja"><span class="text"> <?php echo JText::_('Job Apply'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=js-ja"><span class="text"> <?php echo JText::_('Job Apply').' '.JText::_('Jobseeker'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ew-md"><span class="text"> <?php echo JText::_('New Department'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ew-rp"><span class="text"> <?php echo JText::_('Employer Purchase'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ew-js"><span class="text"> <?php echo JText::_('Job Seeker Purchase'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ms-sy"><span class="text"> <?php echo JText::_('Message'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=jb-at"><span class="text"> <?php echo JText::_('Job Alert'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=jb-at-vis"><span class="text"> <?php echo JText::_('Employer').'('.Jtext::_('Visitor').')'.Jtext::_('Job'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=jb-to-fri"><span class="text"> <?php echo JText::_('Job To Friend'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=jb-pkg-pur"><span class="text"> <?php echo JText::_('Job Seeker Package Purchased'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=emp-pkg-pur"><span class="text"> <?php echo JText::_('Employer Package Purchased'); ?></span></a>
        </div>
    </div>
    <div class="js-divlink">
        <a href="index.php?option=com_jsjobs&c=country&view=country&layout=countries">
            <img src="components/com_jsjobs/include/images/left_menu_icons/countries.png" />
        </a>        
        <a href="#" class="js-parent <?php if($c == 'country' || $c == 'addressdata') echo 'lastshown'; ?>"><span class="text"><?php echo JText::_('Countries'); ?><img class="arrow" src="components/com_jsjobs/include/images/left_menu_icons/arrow1.png"/></span></a>
        <div class="js-innerlink">
            <a class="js-child" href="index.php?option=com_jsjobs&c=country&view=country&layout=countries"><span class="text"><?php echo JText::_('Countries'); ?></span></a>
            <a class="js-child" href="index.php?option=com_jsjobs&c=addressdata&view=addressdata&layout=loadaddressdata"><span class="text"><?php echo JText::_('Load Address Data'); ?></span></a>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("img#js-admin-responsive-menu-link").click(function(e){
            e.preventDefault();
            if(jQuery("div#jsjobs-menu").css('display') == 'none'){
                jQuery("div#jsjobs-menu").show();
                jQuery("div#jsjobs-menu").width(280);
                jQuery("div#jsjobs-menu").find('a.js-parent,a.js-parent2').show();
                jQuery('a.js-parent.lastshown').next().find('a.js-child').css('display','block');
                jQuery('a.js-parent.lastshown').find('img.arrow').attr("src","components/com_jsjobs/include/images/left_menu_icons/arrow2.png");
                jQuery('a.js-parent.lastshown').find('span').css('color','#ffffff');
            }else{
                jQuery("div#jsjobs-menu").hide();
            }
        });

        jQuery('div#jsjobs-menu div.js-divlink a').not('a.js-parent').not('a.js-child').on("touchstart", function (e) {
            'use strict'; //satisfy code inspectors
            var link = jQuery(this); //preselect the link
            if (link.hasClass('touch')) {
                return true;
            }else {
                link.addClass('touch');
                jQuery('div#jsjobs-menu div.js-divlink a').not(this).not('a.js-parent').not('a.js-child').removeClass('touch');
                e.preventDefault();
                var div = jQuery('div#jsjobs-menu');
                openMenu(div);
                return false; //extra, and to make sure the function has consistent return points
            }
        });
        function openMenu(div){
            jQuery(div).width(280);
            jQuery(div).find('a.js-parent,a.js-parent2').show();
            jQuery('a.js-parent.lastshown').next().find('a.js-child').css('display','block');
            jQuery('a.js-parent.lastshown').find('img.arrow').attr("src","components/com_jsjobs/include/images/left_menu_icons/arrow2.png");
            jQuery('a.js-parent.lastshown').find('span').css('color','#ffffff');
        }
        jQuery("div#jsjobs-menu").hover(function(){
            openMenu(this);
        },function(){
            jQuery(this).width(65);
            jQuery(this).find('a.js-parent,a.js-parent2').hide();
            jQuery('a.js-parent.lastshown').next().find('a.js-child').css('display','none');
            jQuery('a.js-parent.lastshown').find('img.arrow').attr("src","components/com_jsjobs/include/images/left_menu_icons/arrow1.png");
            jQuery('a.js-parent.lastshown').find('span').css('color','#acaeb2');
        });
        jQuery("a.js-child").find('span.text').click(function(e){
            jQuery(this).css('color','#ffffff');
        });
        jQuery("a.js-parent").click(function(e){
            e.preventDefault();
            jQuery('a.js-parent.lastshown').next().find('a.js-child').css('display','none');
            jQuery('a.js-parent.lastshown').find('span').css('color','#acaeb2');
            jQuery('a.js-parent.lastshown').find('img.arrow').attr("src","components/com_jsjobs/include/images/left_menu_icons/arrow1.png");
            jQuery('a.js-parent.lastshown').removeClass('lastshown');
            jQuery(this).find('span').css('color','#ffffff');
            jQuery(this).addClass('lastshown');
            if(jQuery(this).next().find('a.js-child').css('display') == 'none'){
                jQuery(this).next().find('a.js-child').css({'display':'block'},800);
                jQuery(this).find('img.arrow').attr("src","components/com_jsjobs/include/images/left_menu_icons/arrow2.png");
            }
        });
    });
</script>
