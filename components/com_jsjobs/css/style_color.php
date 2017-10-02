<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

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

$color1 = "#4D89DC";
$color2 = "#4D4D4D";
$color3 = "#F5F5F5";
$color4 = "#666666";
$color5 = "#D4D4D5";
$color6 = "#F0F0F0";
$color7 = "#FFFFFF";
$color8 = "#3C3435";
$color9 = "";
$color10 = "";

$style = "
	div#jsjobs_r_p_notfound{border:1px solid ".$color5."; background:".$color3.";}
	div#jsjobs_r_p_notfound div.jstitle{color:".$color8.";}
	div#jsjobs_r_p_notfound div.jsjob_button_cp{}
	div#jsjobs_r_p_notfound div.jsjob_button_cp a{border:1px solid ".$color5."; background:".$color6."; color:".$color8.";}
	div#jsjobs_r_p_notfound div.jsjob_button_cp a:hover{border:1px solid ".$color2."; background:".$color1."; color:".$color7.";}
	div#js_main_wrapper span.js_controlpanel_section_title span a{background:".$color6.";color:".$color8.";border:1px solid ".$color5.";}
	div#js_main_wrapper span.js_controlpanel_section_title span a:hover{background:".$color1.";color:".$color7.";border:1px solid ".$color2.";}
	div#js_menu_wrapper{background: ".$color1."; border-bottom:7px solid ".$color2.";}
	div#js_menu_wrapper a.js_menu_link{color:".$color7.";}
	div#js_menu_wrapper a.js_menu_link:hover{background:".$color2.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-wrapper-mycompanies{border:1px solid ".$color5."; }
	div#jsjobs-main-wrapper span.jsjobs-main-page-title{border-bottom: 2px solid ".$color2.";color:".$color8.";}
	div#jsjobs-main-wrapper span.js_controlpanel_section_title{border-bottom: 2px solid ".$color2.";color:".$color8.";}
	div#jsjobs-main-wrapper span.jsjobs-main-page-title span.jsjobs-title-componet{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-wrapper-mycompanies div.jsjobs-main-companieslist-btn{border-top:1px solid ".$color5."; background:".$color3.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-wrapper-mycompanies div.jsjobs-main-companieslist div.jsjobs-main-wrap-imag-data div.com-logo a.img{border:1px solid ".$color5."; border-left:4px solid ".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-wrapper-mycompanies div.jsjobs-main-companieslist div.jsjobs-main-wrap-imag-data div.jsjobs-data-area div.jsjobs-data-1{border-bottom:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-wrapper-mycompanies div.jsjobs-main-companieslist-btn div.jsjobs-data-4 a{border:1px solid ".$color5.";background:".$color6.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-wrapper-mycompanies div.jsjobs-main-companieslist-btn div.jsjobs-data-4 a:hover{border:1px solid ".$color1."; }
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-wrapper-mycompanies div.jsjobs-main-companieslist div.jsjobs-main-wrap-imag-data div.jsjobs-data-area div.jsjobs-data-1 span.jsjobs-title{color:".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-wrapper-mycompanies div.jsjobs-main-companieslist div.jsjobs-main-wrap-imag-data div.jsjobs-data-area div.jsjobs-data-2 div.jsjobs-data-2-wrapper span.jsjobs-data-2-title{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-wrapper-mycompanies div.jsjobs-main-companieslist div.jsjobs-main-wrap-imag-data div.jsjobs-data-area div.jsjobs-data-2 div.jsjobs-data-2-wrapper span.jsjobs-data-2-value{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-wrapper-mycompanies div.jsjobs-main-companieslist div.jsjobs-main-wrap-imag-data div.jsjobs-data-area div.jsjobs-data-2 div.jsjobs-data-2-wrapper span.jsjobs-data-2-value a.js_job_company_anchor{color:".$color4."; text-decoration:none;}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-wrapper-mycompanies div.jsjobs-main-companieslist div.jsjobs-main-wrap-imag-data div.jsjobs-data-area div.jsjobs-data-2 div.jsjobs-data-2-wrapper span.jsjobs-data-2-value a.js_job_company_anchor:hover{color:".$color1.";}
	div#jsjobs-main-wrapper span.jsjobs-main-page-title span.jsjobs-add-resume-btn a.jsjobs-resume-a{border:1px solid ".$color5."; background:".$color6.";color:".$color8.";}
	div#jsjobs-main-wrapper span.jsjobs-main-page-title span.jsjobs-add-resume-btn a.jsjobs-resume-a:hover{border:1px solid ".$color1.";}
	div#jsjobs-main-wrapper span.jsjobs-main-page-title span.jsjobs-add-resume-btn a.jsjobs-resume-a span.jsjobs-add-resume-btn{border:none;}
	div#jsjobs-main-wrapper div.fieldwrapper-btn{border-top:2px solid ".$color2.";}

	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-wrapper-mycompanies div.jsjobs-main-companieslist-btn div.jsjobs-data-3 span.jsjobs-data-location-value{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-wrapper-mycompanies div.jsjobs-main-companieslist div.jsjobs-main-wrap-imag-data div.jsjobs-data-area div.jsjobs-data-1 span.jsjobs-posted{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-company-name div.jsjobs-full-width-data div.jsjobs-descrptn p{color:".$color4.";}


	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist{border:1px solid ".$color5."; border-bottom:none;}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist-btn{border:1px solid ".$color5.";background:".$color3.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist span.jsjobs-image-area a.jsjobs-image-area-achor{border:1px solid ".$color5."; border-left:4px solid ".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist div.jsjobs-data-1{border-bottom:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist div.jsjobs-data-area div.jsjobs-data-2 div.jsjobs-data-3-wrapper span.js_job_data_2_title{color: ".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist div.jsjobs-data-area div.jsjobs-data-2 div.jsjobs-data-2-wrapper span.js_job_data_2_title{color: ".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist div.jsjobs-content-wrap div.jsjobs-data-area div.jsjobs-data-2 span.js_job_data_2_value{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist-btn div.jsjobs-data-myjob-left-area{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist div.jsjobs-data-1 span.jsjobs-jobs-types{border:1px solid ".$color5.";border-bottom:none; background:".$color3.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist-btn div.jsjobs-data-myjob-right-area a.company_icon{background:".$color6."; border:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist-btn div.jsjobs-data-myjob-right-area a.company_icon:hover{ border:1px solid ".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist-btn div.jsjobs-data-myjob-right-area a.applied-resume-button-no{background:".$color1."; border:1px solid ".$color2."; color:".$color7.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist div.jsjobs-data-area div.jsjobs-data-3-myjob-no span.jsjobs-noof-jobs{border:1px solid ".$color5."; color:".$color4.";background:".$color3.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist div.jsjobs-data-1 div.jsjobs-data-1-right{color:".$color4.";}

	div#jsjobs-main-wrapper div#js_job_fb_commentparent span#js_job_fb_commentheading{ color:".$color7."; background:".$color8.";}
	div#jsjobs-cat-block a#jsjobs-cat-block-a{color:".$color4.";background:".$color3.";border:1px solid ".$color5.";}
	div#jsjobs-cat-block a#jsjobs-cat-block-a:hover{border:1px solid ".$color1.";}
	div#jsjobs-cat-block a#jsjobs-cat-block-a.subcatopen{border:1px solid ".$color1.";}
	div.jsjobs_subcat_wrapper{ border:1px solid ".$color1.";}
	div#for_subcat a#jsjobs-subcat-block-a{color:".$color4.";background:".$color3.";border:1px solid ".$color5.";}
	div#for_subcat a#jsjobs-subcat-block-a:hover{border:1px solid ".$color1.";}
	div#for_subcat span#showmore_p{color:".$color7.";background:".$color1.";}

	div#jsjob-search-popup span.popup-title,
	div#jsjobs-listpopup span.popup-title{color:".$color7.";background:".$color1.";}
	div#jsjobs_subcatpopups{border:1px solid ".$color5.";}
	div#jsjobs_subcatpopups a#jsjobs-subcat-popup-a{color:".$color4.";background:".$color3.";border:1px solid ".$color5.";}
	div#jsjobs_subcatpopups a#jsjobs-subcat-popup-a:hover{border:1px solid ".$color1.";}

	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper div.fieldtitle{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper div.fieldvalue span{color:".$color4.";}
	div#jsjobs-main-wrapper form#adminForm input.jsjobs_button{color:".$color8.";background:".$color6."; border:1px solid ".$color5.";}
	div#jsjobs-main-wrapper form#adminForm input.jsjobs_button:hover{color:".$color7.";background:".$color1."; border:1px solid ".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper-btn{border-top:2px solid ".$color2.";}
	div#jsjobs-wrapper div.page_heading input#button.button{color:".$color8.";background:".$color6."; border:1px solid ".$color5.";}
	div#jsjobs-wrapper div.page_heading input#button.button:hover{color:".$color7.";background:".$color1."; border:1px solid ".$color1.";}

	div#jsjobs-main-wrapper div#savesearch-form div.jsjobs-label{ color:".$color8."; }
	div#jsjobs-main-wrapper div#savesearch-form div.jsjobs-button-field input{ outline:none; background:".$color6."; border:1px solid ".$color5."; color:".$color8."; }
	div#jsjobs-main-wrapper div#savesearch-form div.jsjobs-button-field input:hover{ background:".$color1."; border:1px solid ".$color1."; color:".$color7.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist div.jsjobs-data-area div.jsjobs-data-2 div.jsjobs-data-2-wrapper span.js_job_data_2_value a{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist div.jsjobs-data-area div.jsjobs-data-2 div.jsjobs-data-2-wrapper span.js_job_data_2_value a:hover{color:".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist div.jsjobs-data-1 div.jsjobs-data-1-title a#jsjobs-a-job-tile span.job-title{color:".$color1.";}

	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resume-searchresults div.jsjobs-resume-searchresults{border:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resume-searchresults div.jsjobs-resume-searchresults div.jsjobs-resume-search div.jsjobs-image-area div.jsjobs-img-border div.jsjobs-image-wrapper{border:1px solid ".$color5."; border-left:4px solid ".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resume-searchresults div.jsjobs-resume-searchresults div.jsjobs-resume-search div.jsjobs-data-area div.jsjobs-data-2-wrapper-title span.jsjobs-posted{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resume-searchresults div.jsjobs-resume-searchresults div.jsjobs-resume-search div.jsjobs-data-area div.jsjobs-data-2-wrapper-title span.jsjobs-name-title{color:".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resume-searchresults div.jsjobs-resume-searchresults div.jsjobs-resume-search div.jsjobs-data-area div.jsjobs-data-2-wrapper-title{border-bottom:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resume-searchresults div.jsjobs-resume-searchresults div.jsjobs-resume-search div.jsjobs-data-area div.jsjobs-data-2-wrapper-title span.jsjobs-jobs-types{background:".$color3."; color:".$color4."; border:1px solid ".$color5."; border-bottom:none;}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resume-searchresults div.jsjobs-resume-searchresults div.jsjobs-resume-search div.jsjobs-data-area div.jsjobs-data-2-wrapper span.jsjobs-main-wrap span.js_job_data_2_title{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resume-searchresults div.jsjobs-resume-searchresults div.jsjobs-resume-search div.jsjobs-data-area div.jsjobs-data-2-wrapper span.jsjobs-main-wrap span.js_job_data_2_value{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resume-searchresults div.jsjobs-data-3-myresume{ background:".$color3.";  border:1px solid ".$color5."; border-top:none; }
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resume-searchresults div.jsjobs-data-3-myresume span.jsjobs-location span.js_job_data_2_value{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resume-searchresults div.jsjobs-data-3-myresume span.jsjobs-view-resume a{ background:".$color6.";  border:1px solid ".$color5."; color:".$color8."; }
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resume-searchresults div.jsjobs-data-3-myresume span.jsjobs-view-resume a:hover{ background:".$color1.";  border:1px solid ".$color7."; color:".$color7."; }

	div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-resumesearch-list{ border:1px solid ".$color5.";  background:".$color3.";}
	div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-resumesearch-list span.jsjobs-coverletter-title{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-coverletter-button-area span.jsjobs-coverletter-created{ border-left:1px solid ".$color5.";  border-right:1px solid ".$color5."; color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-coverletter-button-area span.jsjsobs-resumes-btn a.jsjobs-savesearch-btn{border:1px solid ".$color5."; background:".$color6."; text-decoration:none;}
	div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-coverletter-button-area span.jsjsobs-resumes-btn a.jsjobs-savesearch-btn:hover{border:1px solid ".$color1.";}

	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-mydepartmentlist{border:1px solid ".$color5.";background:".$color3.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-mydepartmentlist div.jsjob-main-department div.jsjobs-main-department-left span.jsjobs-coverletter-title{border-bottom:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-mydepartmentlist div.jsjob-main-department div.jsjobs-main-department-left span.jsjobs-coverletter-title span.jsjobs-title-name{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-mydepartmentlist div.jsjob-main-department div.jsjobs-main-department-left span.jsjobs-coverletter-title span.jsjobs-coverletter-created{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-mydepartmentlist div.jsjob-main-department div.jsjobs-main-department-left span.jsjobs-coverletter-title span.jsjobs-coverletter-created span.js_coverletter_created_title{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-mydepartmentlist div.jsjob-main-department div.jsjobs-main-department-left span.jsjobs-category-status span.jsjobs-listing-title-child span.jsjobs-title-status{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-mydepartmentlist div.jsjob-main-department div.jsjobs-main-department-right div.jsjobs-coverletter-button-area{border-left:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-mydepartmentlist div.jsjob-main-department div.jsjobs-main-department-right div.jsjobs-coverletter-button-area a{border:1px solid ".$color5.";background:".$color6.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-mydepartmentlist div.jsjob-main-department div.jsjobs-main-department-right div.jsjobs-coverletter-button-area a:hover{border:1px solid ".$color1.";}

	div#jsjobs-main-wrapper div.jsjobs-folderinfon div.jsjobs-listfolders{border:1px solid ".$color5.";background:".$color3.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfon div.jsjobs-listfolders div.jsjobs-message-title{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfon div.jsjobs-listfolders div.jsjobs-status-button span.jsjobs-message-created span.js_message_created_title{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfon div.jsjobs-listfolders div.jsjobs-status-button span.jsjobs-message-created{border-left:1px solid ".$color5."; border-right:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfon div.jsjobs-listfolders div.jsjobs-status-button span.jsjobs-message-btn a{border:1px solid ".$color5.";background:".$color6.";color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfon div.jsjobs-listfolders div.jsjobs-status-button span.jsjobs-message-btn a:hover{border:1px solid ".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfon div.jsjobs-listfolders div.jsjobs-status-button span.jsjobs-message-btn a.jsjobs-button-message-noof{border:1px solid ".$color5.";background:".$color6.";color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfon div.jsjobs-listfolders div.jsjobs-status-button span.jsjobs-message-btn a.jsjobs-button-message-noof:hover{border:1px solid ".$color7.";background:".$color1.";color:".$color7.";}

	div#js_main_wrapper div.js_job_main_wrapper div.header{border:1px solid ".$color5.";}
	div#js_main_wrapper div.js_job_main_wrapper div.js_job_image_area div.js_job_image_wrapper.mycompany{border:1px solid ".$color5.";border-left:4px solid ".$color1.";}
	div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_3.myresume_folder{border-bottom:1px solid ".$color5.";}
	div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_3.myresume_folder div.title{color:".$color1.";}
	div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_3.myresume_folder span.js_job_data_2_created_myresume{color:".$color8.";}
	div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_3.myresume_folder span.js_job_data_2_created_myresume.jobtype{border: 1px solid ".$color5."; border-bottom:none;color:".$color4.";}
	div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_2.myresume.first-child div.js_job_data_2_wrapper span.heading{color:".$color8.";}
	div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_2.myresume.first-child div.js_job_data_2_wrapper span.text{color:".$color4.";}
	div#js_main_wrapper div.js_job_main_wrapper div.bottom{border:1px solid ".$color5.";border-top:none;background:".$color3.";}
	div#js_main_wrapper div.js_job_main_wrapper div.bottom span.location span.js_job_data_2_value{color:".$color4.";}
	div#js_main_wrapper div.js_job_main_wrapper div.bottom div.btn-view a{background:".$color1.";color:".$color7."; border:1px solid ".$color2.";}
	div#jsjobs-main-wrapper div.js_jobs_data_wrapper{border-bottom:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.js_jobs_data_wrapper span.js_jobs_data_title{color:".$color8.";}
	div#jsjobs-main-wrapper div.js_jobs_data_wrapper span.js_jobs_data_value{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-description-area span.js_jobs_description_section_title{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-description-area div.js_jobs_full_width_data{color:".$color4.";}

	div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-messages-list{border:1px solid ".$color5.";background:".$color3.";}
	div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-messages-list div.jsjobs-message-title span.jsjobs-messages-covertitle{border-bottom:1px solid".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-messages-list div.jsjobs-message-title span.jsjobs-messages-covertitle span.jsjobs_message_title{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-messages-list div.jsjobs-message-title span.jsjobs-messages-covertitle span.jsjobs_message_title span.jsjobs_message{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-messages-list div.jsjobs-message-title span.jsjobs-messages-covertitle span.jsjobs-message-created{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-messages-list div.jsjobs-message-title span.jsjobs-messages-covertitle span.jsjobs-message-created span.js_message_created_title{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-messages-list div.jsjobs-message-title span.jsjobs-messages-company span.jsjobs_message{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-messages-list div.jsjobs-message-button-area span.jsjsobs-message-btn{border-left:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-messages-list div.jsjobs-message-button-area span.jsjsobs-message-btn a{background:".$color6.";color:".$color8.";border:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-messages-list div.jsjobs-message-button-area span.jsjsobs-message-btn a:hover{background:".$color1.";color:".$color7.";border:1px solid ".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-messages-list div.jsjobs-message-title span.jsjobs-messages-company a{ color:".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-main-message-wrap div.jsjobs-company-data div.border-class{border-bottom:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-messages-list div.jsjobs-message-title span.jsjobs_message_title-vlaue span.jsjobs_message{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-messages-list div.jsjobs-message-title span.jsjobs_message_title-vlaue{color:".$color4.";}

	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listcompany div.jsjobs-wrapper-listcompany div.jsjobs-listcompany div.jsjobs-data-area div.jsjob-data-1 span.jsjobs-listcompany-location a.companyanchor{color:".$color4."; text-decoration:none;}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listcompany div.jsjobs-wrapper-listcompany div.jsjobs-listcompany div.jsjobs-data-area div.jsjob-data-1 span.jsjobs-listcompany-location a.companyanchor:hover{color:".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-main-message{border:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-main-message-wrap div.jsjobs-company-logo span.jsjobs-img-wrap{border:1px solid ".$color5.";border-left: 4px solid ".$color1.";}
	
	div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-data-wrapper span.jsjobs-data-value{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-main-message-wrap div.jsjobs-company-data div.jsjobs-data-wrapper span.jsjobs-main-company span.jsjobs-data-title{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-main-message-wrap div.jsjobs-company-data div.jsjobs-data-wrapper span.jsjobs-main-job span.jsjobs-data-title{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-data-wrapper span.jsjobs-data-value{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-data-wrapper div.jsjobs-data-title-subject{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-data-wrapper div.jsjobs-data-value-subject{border:1px solid ".$color5.";color:".$color4.";background:".$color3.";}
	div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-data-wrapper div.jsjobs-data-title-message{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-data-wrapper div.jsjobs-data-value-message{border:1px solid ".$color5.";color:".$color4.";background:".$color3.";}
	div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-data-wrapper div.jsjobs-data-title{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-message-send-list span.jsjobs-controlpanel-section-title{background:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-message-history-wrapper{border:1px solid ".$color5.";background:".$color3.";}
	div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-message-history-wrapper span.jsjobs-img-sender span.jsjobs-img-area{border:1px solid ".$color5.";border-left:4px solid ".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-message-history-wrapper.yousend div.jsjobs-message-right-top span.jsjobs-message-name{ background:".$color8."; color:".$color7.";}
	div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-message-history-wrapper.othersend div.jsjobs-message-right-top span.jsjobs-message-name{ background:".$color1."; color:".$color7.";}
	div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-message-history-wrapper div.jsjobs-message-right-top div.jsjobs-message-created{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-message-history-wrapper div.jsjobs-message-data-wrapper span.jsjobs-message-value{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-purchasehistory-main div.jsjobs-purchase-listing-wrapper div.jsjobs-expire-days span.expired_package{border-left:1px solid ".$color5.";}

	div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.js_listing_wrapper input.js_job_button{outline:none; background-color:".$color1."; border:1px solid ".$color5."; color:".$color7.";}
	div#jsjobs-main-wrapper div.jsjobs-package-data span.jsjobs-package-title{border-bottom:2px solid ".$color2.";}
	div#jsjobs-main-wrapper div.jsjobs-package-data span.jsjobs-package-title span.stats_data_value{background:".$color8."; color:".$color7.";}
	div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper{border:1px solid ".$color5."; border-top:none; }
	div#jsjobs-main-wrapper div.jsjobs-package-data div.js_listing_wrapper{background:".$color3.";}
	div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-apply-button span.jsjobs-expiredays{border-top:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-listing-datawrap-details{ background:#FFFFFF; border-bottom:2px solid ".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-package-data span.jsjobs-package-title span.jsjobs-package-name{background:".$color3."; color:".$color8.";border:1px solid ".$color5."; border-bottom:none; }
	div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-package-data-detail span.jsjobs-package-values{border-bottom:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-package-data-detail span.jsjobs-package-values span.stats_data_title{ color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-package-data-detail span.jsjobs-package-values span.stats_data_value{ color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-apply-button span.jsjobs-buy-btn a{background:".$color1.";color:".$color7.";}
	div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-apply-button{background:".$color3.";}
	div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-apply-button span.jsjobs-view-btn a{border:1px solid ".$color5."; color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-package-data div.disc-message{color:".$color4.";border:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-listing-datawrap{border-right:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-package-data span.jsjobs-package-title span.jsjobs-package-name span.total-amount{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-package-data div.js_listing_wrapper a#jsjobs_buy_nowbtn_a{background-color:".$color1.";border:1px solid ".$color5.";color:".$color7.";}
	div#jsjobs-main-wrapper span.jsjobs-stats-title{color:".$color7.";background:".$color8.";}
	table#js-table thead tr{background:".$color8.";color:".$color7.";}
	table#js-table thead tr th{border-left:1px solid ".$color7.";}
	table#js-table tbody tr{border:1px solid ".$color5."; }
	table#js-table tbody tr td:first-child{background:".$color3.";}
	table#js-table tbody tr td{border:1px solid ".$color5."; color: ".$color8.";}

	div#jsjobs-main-wrapper div.jsjobs-company-name{border-bottom:1px solid ".$color5.";background:".$color3.";}	
	div#jsjobs-main-wrapper div.jsjobs-company-name span.jsjobs-company-title{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-company-name div.jsjobs-data-wrapper-email-location span.jsjob-data-value-email{color:".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-company-name div.jsjobs-data-wrapper-email-location span.jsjob-data-value-email a{color:".$color1."; text-decoration:none;}
	div#jsjobs-main-wrapper div.jsjobs-company-name div.jsjobs-data-wrapper-email-location span.jsjobs-location-comapny span.jsjob-data-value{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-company-applied-data div.jsjobs-company-logo span.jsjobs-company-logo-wrap span.jsjobs-left-border{border:1px solid ".$color5.";border-left:4px solid ".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-company-applied-data div.jsjobs-company-logo span.jsjobs-company-logo-wrap{}
	div#jsjobs-main-wrapper div.jsjobs-company-applied-data div.jsjobs-comoany-data div.js_job_data_wrapper{border-bottom:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-company-applied-data div.jsjobs-comoany-data div.js_job_data_wrapper span.js_job_data_title{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-company-applied-data div.jsjobs-comoany-data div.js_job_data_wrapper span.js_job_data_value{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-company-applied-data div.js_job_apply_button a.js_job_button{color:".$color8.";background:".$color6.";border:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-company-applied-data div.js_job_apply_button a.js_job_button:hover{color:".$color7.";background:".$color1.";border:1px solid ".$color1.";}

	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-mydepartmentlist div.jsjob-main-department div.jsjobs-main-department-left span.jsjobs-category-status span.jsjobs-listing-title-child span.jsjobs-company a{color:".$color4."; text-decoration:none;}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-mydepartmentlist div.jsjob-main-department div.jsjobs-main-department-left span.jsjobs-category-status span.jsjobs-listing-title-child span.jsjobs-company a:hover{color:".$color1.";}
	div#jsjobs-main-wrapper div.js_jobs_data_wrapper span.js_jobs_data_value a{color:".$color4."; text-decoration:none;}
	div#jsjobs-main-wrapper div.js_jobs_data_wrapper span.js_jobs_data_value a:hover{color:".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-data-wrapper span.jsjobs-job-main span.jsjobs-data-value{color:".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resume-searchresults div.jsjobs-resume-searchresults div.jsjobs-resume-search div.jsjobs-data-area div.font{color:".$color4.";}

	div.jsjobs-job-info div.jsjobs-data-jobs-wrapper span.js_job_data_value span a.js_job_company_anchor{color:".$color1."; text-decoration:none;  }
	div#jsjobs-main-wrapper div.jsjobs-job-info{border-bottom:1px solid ".$color5.";background:".$color3.";}
	div#jsjobs-main-wrapper div.jsjobs-job-info span.jsjobs-title{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-job-info div.jsjobs-data-jobs-wrapper span.js_job_data_value{color:".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-job-info div.jsjobs-data-jobs-wrapper span.jsjobs-location-wrap{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-job-info div.jsjobs-data-jobs-wrapper span.jsjobs_daysago{color:".$color4.";border-left:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-job-info div.jsjobs-data-jobs-wrapper span.jsjobs-location-wrap{border-left:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-job-data div.jsjobs-menubar-wrap ul li a{background:".$color6.";border:1px solid ".$color5.";color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-job-data div.jsjobs-menubar-wrap ul li a:hover{background:".$color1.";border:1px solid ".$color1.";color:".$color7.";}
	div#jsjobs-main-wrapper div.jsjobs-job-information-data span.js_controlpanel_section_title{background:".$color3."; color:".$color8.";border-bottom:2px solid ".$color2.";}
	div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-left-area{ border-right:1px solid ".$color5."; }
	div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-left-area div.jsjobs-jobs-overview-area div.js_job_data_wrapper{border-bottom:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-left-area div.jsjobs-jobs-overview-area div.js_job_data_wrapper span.js_job_data_title{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-left-area div.jsjobs-jobs-overview-area div.js_job_data_wrapper span.js_job_data_value{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-left-area span.jsjobs-controlpanel-section-title{background:".$color3."; color:".$color8.";border-bottom:2px solid ".$color2.";}
	div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-map-wrap span.jsjobs_controlpanel_section_title{background:".$color3."; color:".$color8.";border-bottom:2px solid ".$color2.";}
	div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-jobmore-info span.js_controlpanel_title{background:".$color3."; color:".$color8.";border-bottom:2px solid ".$color2.";}
	div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-jobmore-info span.js_controlpanel_title{background:".$color3."; color:".$color8.";border-bottom:2px solid ".$color2.";}
	div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-right-raea{ background:".$color3."; }
	div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-right-raea div.js_job_company_logo div.jsjobs-company-logo-wrap{border:1px solid ".$color5.";border-left:4px solid ".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-right-raea div.js_job_company_data span.js_job_data_value a{color:".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-right-raea div.js_job_company_data span.js_jobs_data_value a{color:".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-right-raea div.js_job_company_data span.jsjobs-location{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-jobmore-info div.js_job_apply_button{border-top:2px solid ".$color2.";}
	div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-jobmore-info div.js_job_apply_button a.js_job_button{border:1px solid ".$color2."; color:".$color7."; background:".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-jobmore-info div.jsjobs_full_width_data{color:".$color4."; border:1px solid ".$color5.";}

	div#js_main_wrapper span.js_controlpanel_section_title, div#tp_heading{color:".$color8."; border-bottom:2px solid ".$color1.";}

	div#js_main_wrapper span.js_controlpanel_section_title span.js_apply_view_job{color:".$color4.";background:".$color3.";border:1px solid ".$color5.";}
	div#js_main_wrapper div#sortbylinks span a{background:".$color8.";color:".$color7.";border-right:1px solid ".$color7.";}
	div#js_main_wrapper div#sortbylinks span a:hover{background:".$color1.";color:".$color7.";}
	div#js_main_wrapper div#sortbylinks span a.selected{background:".$color1.";color:".$color7.";}
	div#js_main_wrapper div#jsjobs_appliedapplication_tab_container a{background:".$color6.";color:".$color8.";border:1px solid ".$color5."; border-bottom:none;}
	div#js_main_wrapper div#jsjobs_appliedapplication_tab_container a:hover{background:".$color1.";color:".$color7.";}
	div#js_main_wrapper div#jsjobs_appliedapplication_tab_container a.selected{background:".$color1.";color:".$color7.";}
	div#js_main_wrapper div.js-jobs-jobs-applie{border:1px solid ".$color5.";}
	div.js-jobs-jobs-applie div.js_job_data_area div.js_job_data_2 div.appnotes_wrapper span.jsjobs-appnotesvalue{border:1px solid ".$color5.";background:".$color3.";color:".$color4.";}
	div#js_main_wrapper div.js-jobs-jobs-applie div.js_job_image_area div.js_job_image_wrapper{border:2px solid ".$color1.";}
	div#js_main_wrapper div.js-jobs-jobs-applie div.js_job_image_area a.view_resume_button{background:".$color1.";color:".$color7.";}
	div#js_main_wrapper div.js-jobs-jobs-applie div.js_job_image_area div.view_coverltr_button{border:1px solid ".$color1.";color:".$color8.";}
	div#js_main_wrapper div.js-jobs-jobs-applie div.js_job_data_area div.js_job_data_1{border-bottom:1px solid ".$color5.";}
	div#js_main_wrapper div.js-jobs-jobs-applie div.js_job_data_area div.js_job_data_1 span.js_job_title{color:".$color1.";}
	div#js_main_wrapper div.js-jobs-jobs-applie div.js_job_data_area div.js_job_data_1 span.js_job_posted span.js_jobapply_title{color:".$color8.";}
	div#js_main_wrapper div.js-jobs-jobs-applie div.js_job_data_area div.js_job_data_1 span.js_job_posted span.js_jobapply_value{color:".$color4.";}
	div#js_main_wrapper div.js-jobs-jobs-applie div.js_job_data_area div.js_job_data_2 div.jsjobsapp_wrapper span.jsjobs-apptitle{color:".$color8.";}
	div#js_main_wrapper div.js-jobs-jobs-applie div.js_job_data_area div.js_job_data_2 div.jsjobsapp_wrapper span.jsjobs-appvalue{color:".$color4.";}
	div.js-jobs-jobs-applie div.js_job_data_5{background:".$color3."; border-top:1px solid ".$color5.";}
	div.js-jobs-jobs-applie div.js_job_data_5 div.jsjobs_appliedresume_action{background:".$color6.";color:".$color8.";border:1px solid ".$color5.";}
	div.js-jobs-jobs-applie div.js_job_data_5 div.jsjobs_appliedresume_action:hover{ border:1px solid ".$color1.";}
	div#jsjobs_appliedresume_tab_search_data span.jsjobs_appliedresume_tab span.jsjobs-applied-resume-field div.field span.jsjobs_appliedresume_tab_search_data_title{color:".$color8.";}
	div.js-jobs-jobs-applie div.resumeaction1ton{border-top:1px solid ".$color5.";}

	div#coverletterPopup.coverletterPopup div.fieldwrapper_fullwidth_button input.cletter_popup_button{ border:1px solid ".$color5.";background:".$color6.";color:".$color8."; }
	div#coverletterPopup.coverletterPopup div.fieldwrapper_fullwidth_button input.cletter_popup_button:hover{ border:1px solid ".$color1.";background:".$color1.";color:".$color7."; }
	div#coverletterPopup.coverletterPopup div#coverletter_headline_bottom_area{border:1px solid ".$color5."; border-top:none;}
	div#coverletterPopup div#coverletter_headline_bottom_area div#coverletter_title{color:".$color8.";}
	div#coverletterPopup div#coverletter_headline_bottom_area div#coverletter_description{border-top:1px solid ".$color5."; color:".$color4.";}


	div#resumeactioncomments, div#resumeactionfolder div#jsjobs_applied_apps div.jsjobs-app-title{color:".$color8.";}
	div.js-jobs-jobs-applie div.resumeaction1ton div#jsjobs-email-appliedresume div#jsjobs-input-fields div.jsjobs-fieldtitle{color:".$color8.";}
	div.js-jobs-jobs-applie div.resumeaction1ton div#jsjobs-email-appliedresume div#jsjobs-input-fields div.jsjobs-fieldvalue input{border:1px solid ".$color5.";}
	div.js-jobs-jobs-applie div.resumeaction1ton div#resumeactioncomments div.jsjobs-field-title{color:".$color8.";}

	div.js-jobs-jobs-applie div.resumeaction1ton div#jsjobs-email-appliedresume div#jsjobs-action-button input{outline:none; border:1px solid ".$color5.";background:".$color6.";color:".$color8.";}
	div.js-jobs-jobs-applie div.resumeaction1ton div#jsjobs-email-appliedresume div#jsjobs-action-button input:hover{border:1px solid ".$color1.";background:".$color1.";color:".$color7.";}
	div#jsjobs_appliedresume_tab_search_data span.jsjobs_appliedresume_tab div.fieldwrapper-btn{border-top:2px solid ".$color2.";}
	div#jsjobs_appliedresume_tab_search span.jsjobs_appliedresume_tab div.fieldwrapper-btn div.jsjobs-folder-info-btn input#button{border:1px solid ".$color5.";background:".$color6.";color:".$color8.";}
	div#jsjobs_appliedresume_tab_search span.jsjobs_appliedresume_tab div.fieldwrapper-btn div.jsjobs-folder-info-btn input#button:hover{border:1px solid ".$color1.";background:".$color1.";color:".$color7.";}
	div#resumeactionfolder div#jsjobs_applied_apps div.jsjobs-app-action input{outline:none; border:1px solid ".$color5.";background:".$color6.";color:".$color8.";}
	div#resumeactionfolder div#jsjobs_applied_apps div.jsjobs-app-action input:hover{border:1px solid ".$color1.";background:".$color1.";color:".$color7.";}
	div#resumeactioncomments div.jsjobs_resumeactioncomments div.jsjobs-field-actionbutton input.button{outline:none; border:1px solid ".$color5.";background:".$color6.";color:".$color8.";}
	div#resumeactioncomments div.jsjobs_resumeactioncomments div.jsjobs-field-actionbutton input.button:hover{outline:none; border:1px solid ".$color1.";background:".$color1.";color:".$color7.";}

	div#resumedetail div#resumedetail_data span#resumedetail_data_title{color:".$color8.";}
	div#resumedetail div#resumedetail_data span#resumedetail_data_value{color:".$color4.";}

	div#js_main_wrapper div div.js-resume-section-body div div.add-resume-form a{color:".$color8."; border:1px solid ".$color5."; }
	div#js_main_wrapper div div.js-resume-section-body div div.add-resume-form a:hover{border:1px solid ".$color1."; }
	div#jsjobs-main-wrapper div.jsjobs-data-title-cover span.jsjobs-resume-data span.jsjobs-resume-value a{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-data-title-cover span.jsjobs-resume-data span.jsjobs-resume-value a:hover{color:".$color1.";}

	div.js-jobs-jobs-applie div.resumeaction1ton img#jobsappcloseaction{border:1px solid ".$color5."; background:#FFF;}

	div#jsjobs-wrapper div.page_heading{color:".$color8.";border-bottom:2px solid ".$color2.";}
	div#js-jobs-wrapper{border:1px solid ".$color5.";}
	div#js-jobs-wrapper div.js-toprow div.js-image{border:1px solid ".$color5."; border-left:4px solid ".$color1.";}
	div#js-jobs-wrapper div.js-toprow div.js-data div.js-first-row{border-bottom:1px solid ".$color5.";}
	div#js-jobs-wrapper div.js-toprow div.js-data div.js-first-row span.js-title{color:".$color1.";}
	div#js-jobs-wrapper div.js-toprow div.js-data div.js-first-row span.js-jobtype{color:".$color4.";}
	div#js-jobs-wrapper div.js-toprow div.js-data div.js-first-row span.js-jobtype span.js-type{color:".$color4.";background:".$color3.";border:1px solid ".$color5.";border-bottom:none;}
	div#js-jobs-wrapper div.js-toprow div.js-data div.js-second-row div.js-fields{color:".$color4.";}
	div#js-jobs-wrapper div.js-toprow div.js-data div.js-second-row div.js-fields span.js-bold{color:".$color8.";}
	div#js-jobs-wrapper div.js-toprow div.js-data div.js-second-row div.js-fields span.js-totaljobs{color:".$color4.";background:".$color3.";border:1px solid ".$color5.";}
	div#js-jobs-wrapper div.js-bottomrow{border-top:1px solid ".$color5.";background:".$color3.";}
	div#js-jobs-wrapper div.js-bottomrow div.js-address{color:".$color4.";}
	div#js-jobs-wrapper div.js-bottomrow div.js-actions a.js-button{border:1px solid ".$color5."; background:".$color6.";}
	div#js-jobs-wrapper div.js-bottomrow div.js-actions a.js-button:hover{border:1px solid ".$color1.";}
	div#js-jobs-wrapper div.js-bottomrow div.js-actions a.js-btn-apply{background:".$color1.";color:".$color7."; border:1px solid ".$color2.";}
	div.js_job_form_quickview_wrapper a.jsquick_view_btns.applynow{background:".$color1.";color:".$color7."; border:1px solid ".$color2.";}
	div.js_job_form_quickview_wrapper a.jsquick_view_btns{background:".$color6.";color:".$color8."; border:1px solid ".$color5.";}
	div.js_job_form_quickview_wrapper a.jsquick_view_btns:hover{background:".$color1.";color:".$color7."; border:1px solid ".$color1.";}
	div#jsjob-search-popup div.jsjob-contentarea, div#jsjobs-listpopup div.jsjob-contentarea{background:".$color3.";border:".$color5.";}
	div#jsjob-search-popup div.js-searchform-title{color:".$color8.";}
	div#jsjobs-showmore{background:".$color6.";border:1px solid ".$color5.";color:".$color8.";}
	div#tellafriend.tellafriend div#tellafriend_headline{background:".$color1.";color:".$color7.";}
	div#tellafriend.tellafriend div#borderfieldwrapper{border:1px solid ".$color5.";}
	div#tellafriend.tellafriend div.fieldwrapper div.fieldtitle{color:".$color8.";}
	
	div#jsjobs-shortlist_btn_margin input.js_job_shortlist_button{background:".$color6.";color:".$color8."; border:1px solid ".$color5.";}
	div#jsjobs-shortlist_btn_margin input.js_job_shortlist_button:hover{background:".$color1.";color:".$color7."; border:1px solid ".$color1.";}
	div#tellafriend.tellafriend div.fieldwrapper.fullwidth input.js_job_tellafreind_button{background:".$color6.";color:".$color8."; border:1px solid ".$color5.";}
	div#tellafriend.tellafriend div.fieldwrapper.fullwidth input.js_job_tellafreind_button:hover{background:".$color1.";color:".$color7."; border:1px solid ".$color1.";}
	div.js_job_form_field_wrapper div.js_job_form_button input#js_job_applynow_button{outline:none; background:".$color1.";color:".$color7."; border:1px solid ".$color2.";}
	div.js_job_form_field_wrapper div.js_job_form_button input#js_job_applynow_close{outline:none; background:".$color6.";color:".$color8."; border:1px solid ".$color5.";}
	div.js_job_form_field_wrapper div.js_job_form_button input#js_job_applynow_close:hover{background:".$color1.";color:".$color7."; border:1px solid ".$color1.";}

	div#jsjobs-main-wrapper div#sortbylinks ul li a{background:".$color8.";color:".$color7.";}
	div#jsjobs-main-wrapper div#sortbylinks ul li a.selected{background:".$color1.";color:".$color7.";}
	div#jsjobs-main-wrapper div#sortbylinks ul li a:hover{background:".$color1.";color:".$color7.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist{border:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-image-area{border:1px solid ".$color5.";border-left:4px solid ".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-data-area div.jsjobs-data-titlename div.jsjobs-applyname{border-bottom:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listresume div.jsjobs-main-wrapper-resumeslist div.jsjobs-main-resumeslist div.jsjobs-data-area div.jsjobs-data-titlename div.jsjobs-applyname span.jsjobs-titleresume a.jsjobs-anchor_resume{color:".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-data-area div.jsjobs-data-titlename div.jsjobs-applyname span.jsjobs-date-created{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-data-area div.jsjobs-data-titlename div.jsjobs-applyname span.jsjobs-fulltime-btn{color:".$color4.";border:1px solid ".$color5.";border-bottom:none;background:".$color3.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-data-area div.jsjobs-data-titlename span.jsjobs-emailaddress span.jsjobs-emailaddress-color{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-data-area div.jsjobs-data-titlename span.jsjobs-emailaddress span.jsjobs-address{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-data-area div.jsjobs-data-titlename span.jsjobs-salary-range span.jsjobs-salary-title{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-data-area div.jsjobs-data-titlename span.jsjobs-salary-range span.jsjobs-salary-value{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-data-area div.jsjobs-data-titlename span.jsjobs-categoryjob span.jsjobs-titlecategory{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-data-area div.jsjobs-data-titlename span.jsjobs-categoryjob span.jsjobs-valuecategory{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-data-area div.jsjobs-data-titlename span.jsjobs-totexprience span.jsjobs-totalexpreience-title{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-data-area div.jsjobs-data-titlename span.jsjobs-totexprience span.jsjobs-totalexpreience-value{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-myresume-btn{border-top:1px solid ".$color5."; background:".$color3.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-myresume-btn span.jsjobs-resume-loction{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-myresume-btn a{background:".$color6.";border:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-myresume-btn a:hover{border:1px solid ".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-data-area div.jsjobs-data-titlename div.jsjobs-application-title{color:".$color4.";}

	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist div.jsjobs-content-shortlist-area div.jsjobs-data-area-2 div.jsjobs-data-2-wrapper span.jsjobs-data-2-value a.js_job_data_2_company_link{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist div.jsjobs-content-shortlist-area div.jsjobs-data-area-2 div.jsjobs-data-2-wrapper span.jsjobs-data-2-value a.js_job_data_2_company_link:hover{color:".$color1.";}

	div#jsjobs-main-wrapper div.jsjobs-fieldwrapper div.jsjobs-fieldtitle{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-fieldwrapper span.jsjobs-longitude span.jsjobs-longitude-title{color:".$color8.";}

	div#jsjobs-main-wrapper div#jsjobs-field-wrapper-title div.jsjobs-field{color:".$color8.";}
	div#jsjobs-main-wrapper div#jsjobs-field-wrapper-description div.jsjobs-field{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-jobsalertinfo-save-btn{border-top:2px solid ".$color2.";}

	div#jsjobs-main-wrapper div.jsjobs-listing-main-wrapper div.jsjobs-listing-area{border:1px solid ".$color5."; background:".$color3.";}
	div#jsjobs-main-wrapper div.jsjobs-listing-main-wrapper div.jsjobs-listing-area span.jsjobs-coverletter-title{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-listing-main-wrapper div.jsjobs-listing-area div.jsjobs-coverletter-button-area span.jsjobs-coverletter-created{border-left:1px solid ".$color5.";border-right:1px solid ".$color5.";color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-listing-main-wrapper div.jsjobs-listing-area div.jsjobs-coverletter-button-area div.jsjobs-icon a{border:1px solid ".$color5.";background:".$color6.";}
	div#jsjobs-main-wrapper div.jsjobs-listing-main-wrapper div.jsjobs-listing-area div.jsjobs-coverletter-button-area div.jsjobs-icon a:hover{border:1px solid ".$color1.";}
	div#jsjobs-main-wrapper a.jsjobs-add-cover-btn{ border:1px solid ".$color5.";background:".$color6."; color:".$color8."; }
	div#jsjobs-main-wrapper a.jsjobs-add-cover-btn:hover{ border:1px solid ".$color1.";}

	div#jsjobs-main-wrapper div.jsjobs-jobstyoes-maain a.jsjobs-job-types{border:1px solid ".$color5.";background:".$color3.";color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-jobstyoes-maain a.jsjobs-job-types:hover{border:1px solid ".$color1.";background:".$color3.";color:".$color4.";}

	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listcompany div.jsjobs-wrapper-listcompany{border:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listcompany div.jsjobs-listcompany-button{border:1px solid ".$color5.";border-top:none;background:".$color3.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listcompany div.jsjobs-listcompany-button span.jsjobs-location{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listcompany div.jsjobs-wrapper-listcompany div.jsjobs-listcompany div.jsjobs-image-area div.jsjobs-image-wrapper-mycompany div.jsjobs-image-border{border:1px solid ".$color5.";border-left:4px solid ".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listcompany div.jsjobs-wrapper-listcompany div.jsjobs-listcompany div.jsjobs-data-area div.jsjob-data-1 span.jsjobs-data-jobtitle-title{border-bottom:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listcompany div.jsjobs-wrapper-listcompany div.jsjobs-listcompany div.jsjobs-data-area span.jsjobs-data-jobtitle-title a.jsjobs-titlelink span.jsjobs-data-jobtitle{color:".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listcompany div.jsjobs-wrapper-listcompany div.jsjobs-listcompany div.jsjobs-data-area div.jsjob-data-1 span.jsjobs-listcompany-website{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listcompany div.jsjobs-listcompany-button span.jsjobs-viewalljobs-btn a.js_listcompany_button{ color:".$color8."; background:".$color6."; border:1px solid ".$color5."; }
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listcompany div.jsjobs-listcompany-button span.jsjobs-viewalljobs-btn a.js_listcompany_button:hover{ color:".$color7."; background:".$color1."; border:1px solid ".$color1."; }
	div#jsjobs-main-wrapper div.jsjobs-message-send-list div.fieldwrapper-btn div.jsjobs-folder-info-btn input.jsjobs-send-message-button{ color:".$color8."; background:".$color6."; border:1px solid ".$color5."; }
	div#jsjobs-main-wrapper div.jsjobs-message-send-list div.fieldwrapper-btn div.jsjobs-folder-info-btn input.jsjobs-send-message-button:hover{ color:".$color7."; background:".$color1."; border:1px solid ".$color1."; }
	
	div#jsjobs-refine-actions div.bottombutton button#submit_btn{color:".$color8."; background:".$color6."; border:1px solid ".$color5."; }
	div#jsjobs-refine-actions div.bottombutton button#reset_btn{color:".$color8."; background:".$color6."; border:1px solid ".$color5."; }
	div#jsjobs-refine-actions div.bottombutton button#submit_btn:hover{color:".$color7."; background:".$color1."; border:1px solid ".$color1."; }
	div#jsjobs-refine-actions div.bottombutton button#reset_btn:hover{color:".$color7."; background:".$color1."; border:1px solid ".$color1."; }

	div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-jobs-save{ border:1px solid ".$color5."; background:".$color3."; }
	div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-jobs-save span.jsjobs-coverletter-title{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-jobs-save div.jsjobs-cover-button-area span.jsjobs-coverletter-created{border-left:1px solid ".$color5.";border-right:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-jobs-save div.jsjobs-cover-button-area span.jsjobs-coverletter-created span.jsjobs-coverletter-created-title{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-jobs-save div.jsjobs-cover-button-area span.jsjobs-btn-save a.js_listing_icon{color:".$color8."; background:".$color6."; border:1px solid ".$color5."; }
	div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-jobs-save div.jsjobs-cover-button-area span.jsjobs-btn-save a.js_listing_icon:hover{border:1px solid ".$color1."; }

	div.jsjobs-listing-stats-wrapper table#js-table tbody tr td{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-appliedjobslist{border:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-appliedjobslist-btn{border:1px solid ".$color5."; border-top:none;background:".$color3.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-appliedjobslist-btn span.js_job_data_location_value{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-data-title-cover{border:1px solid ".$color5."; border-top:none;}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listappliedjobs div.jsjobs-main-wrapper-appliedjobslist div.jsjobs-image-area a{border:1px solid ".$color5."; border-left:4px solid ".$color1."}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listappliedjobs div.jsjobs-main-wrapper-appliedjobslist div.jsjobs-data-area div.jsjobs-data-1{border-bottom:1px solid ".$color5."}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listappliedjobs div.jsjobs-main-wrapper-appliedjobslist div.jsjobs-data-area div.jsjobs-data-1 span.jsjobs-title a{color:".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listappliedjobs div.jsjobs-main-wrapper-appliedjobslist div.jsjobs-data-area div.jsjobs-data-1 span.jsjobs-posted{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listappliedjobs div.jsjobs-main-wrapper-appliedjobslist div.jsjobs-data-area div.jsjobs-data-1 span.jsjobs-jobstypes{border:1px solid ".$color5.";border-bottom:none;color:".$color4.";background:".$color3.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listappliedjobs div.jsjobs-main-wrapper-appliedjobslist div.jsjobs-data-area div.jsjobs-data-2 span.jsjobs-data-2-title{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listappliedjobs div.jsjobs-main-wrapper-appliedjobslist div.jsjobs-data-area div.jsjobs-data-2 span.jsjobs-data-2-value{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-appliedjobslist-btn span.jsjobs-resume-btn a{background:".$color6."; color:".$color8."; border:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-appliedjobslist-btn span.jsjobs-resume-btn a:hover{border:1px solid ".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-appliedjobslist-btn span.jsjobs-noofjob-value{background:".$color1.";color:".$color7.";}
	div#jsjobs-main-wrapper div.jsjobs-data-title-cover span.jsjobs-cover-letter-title{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-data-title-cover span.jsjobs-resume-title{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listappliedjobs div.jsjobs-main-wrapper-appliedjobslist div.jsjobs-data-area div.jsjobs-data-2 span.jsjobs-data-2-value a{color:".$color4."; text-decoration:none;}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listappliedjobs div.jsjobs-main-wrapper-appliedjobslist div.jsjobs-data-area div.jsjobs-data-2 span.jsjobs-data-2-value a:hover{color:".$color1.";}

	div#jsjobs_jobs_pagination_wrapper{border:1px solid ".$color5."; color:".$color4.";background:".$color3.";}

	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist{border:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist div.jsjobs-content-shortlist-area div.jsjobs-data-1{border-bottom:1px solid ".$color5."}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist div.jsjobs-content-shortlist-area div.jsjobs-data-1 span.jsjobs-title a{color:".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist div.jsjobs-content-shortlist-area div.jsjobs-data-1 span.jsjobs-posted-days{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist div.jsjobs-content-shortlist-area div.jsjobs-data-1 span.jsjobs-posted{border:1px solid ".$color5.";border-bottom:none;color:".$color4.";background:".$color3.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist div.jsjobs-image-area a{border:1px solid ".$color5."; border-left:4px solid ".$color1."}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist div.jsjobs-content-shortlist-area div.jsjobs-data-area-2 div.jsjobs-data-2-wrapper span.jsjobs-data-2-title{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist div.jsjobs-content-shortlist-area div.jsjobs-data-area-2 div.jsjobs-data-2-wrapper span.jsjobs-data-2-value{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist div.jsjobs-content-shortlist-area div.jsjobs-data-area-2 div.jsjobs-data-2-wrapper-jobsno{border:1px solid ".$color5.";color:".$color4.";background:".$color3.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist-btn{border:1px solid ".$color5.";border-top:none;color:".$color4.";background:".$color3.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist-btn span.js-job-data-location-value{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist-btn div.jsjobs-data-btn-tablet a.js_job_data_button{background:".$color6."; border:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist-btn div.jsjobs-data-btn-tablet a.js_job_data_button:hover{border:1px solid ".$color1.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist-btn div.jsjobs-data-btn-tablet a.js_job_data_button_apply{background:".$color1."; border:1px solid ".$color2."; color:".$color7.";}
	div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist div.jsjobs-data-area-2 div.jsjobs-comment-wrapper{border:1px solid ".$color5.";color:".$color4.";background:".$color3.";}

	div#jsjobs-wrapper div.page_heading label.pageform{ color:".$color8."; }
	div#jsjobs-main-wrapper div.jsjobs-data-wrapper div.jsjobs-view-letter-data{border-bottom:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-data-wrapper div.jsjobs-view-letter-data span.js_job_data_title{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-data-wrapper div.jsjobs-view-letter-data span.js_job_data_value{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-data-wrapper div.jsjobs-view-letter-description span.js_controlpanel_section_title{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-data-wrapper div.jsjobs-view-letter-description span.js_job_full_width_data{color:".$color4.";}

	div#jsjobs-main-wrapper div.jsjobs-purchasehistory-main span.jsjobs-title-wrap{border:1px solid ".$color5.";background:".$color3.";}
	div#jsjobs-main-wrapper div.jsjobs-purchasehistory-main span.jsjobs-title-wrap span.jsjobs-title-wrap-purchase a.anchor{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-purchasehistory-main span.jsjobs-title-wrap span.jsjobs-date-wrap{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-purchasehistory-main div.jsjobs-purchase-listing-wrapper{border:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-purchasehistory-main div.jsjobs-purchase-listing-wrapper div.jsjobs-listing-datawrap-details div.jsjobs-listing-wrap div.jsjobs-values-wrap span.stats_data_title{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-purchasehistory-main div.jsjobs-purchase-listing-wrapper div.jsjobs-listing-datawrap-details div.jsjobs-listing-wrap div.jsjobs-values-wrap span.stats_data_value{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-purchasehistory-main div.jsjobs-purchase-listing-wrapper div.jsjobs-listing-datawrap-details div.jsjobs-listing-wrap div.jsjobs-values-wrap{border-bottom:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-purchasehistory-main div.jsjobs-purchase-listing-wrapper div.jsjobs-listing-datawrap-details{border-bottom:2px solid ".$color2.";}
	div#jsjobs-main-wrapper div.jsjobs-purchasehistory-main div.jsjobs-purchase-listing-wrapper div.jsjobs-expire-days{background:".$color3.";}
	div#jsjobs-main-wrapper div.jsjobs-purchasehistory-main span.jsjobs-title-wrap span.jsjobs-price-wrap span.stats_data_value{color:".$color7."; background:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-listing-datawrap-details div.jsjobs-descriptions div.jsjob-description-data{border:1px solid ".$color5."; background:".$color3."; }
	div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-listing-datawrap-details div.jsjobs-descriptions div.jsjob-description-data span.stats_data_title{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-listing-datawrap-details div.jsjobs-descriptions div.jsjob-description-data span.stats_data_value{color:".$color4.";}

	div#js_main_wrapper div#jsjobs_appliedapplication_tab_container{border-bottom:2px solid ".$color1.";}

	div#coverletterPopup.coverletterPopup{background:#FFFFFF;}
	div#coverletterPopup div#coverletter_headline{color: ".$color7."; background:".$color1."; }
	div#coverletterPopup.coverletterPopup div.fieldwrapper.fullwidth input[type=\"button\"].js_job_cletter_popup_button{background:".$color7."; border:1px solid ".$color4."; color:".$color8."; }
	div#coverletterPopup.coverletterPopup div.fieldwrapper.fullwidth input[type=\"button\"].js_job_cletter_popup_button:hover{background:".$color2."; color:".$color3."; }


	div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-jobs-resume-panel div#jsjsjobs-row_wrapper{border:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-jobs-resume-panel div.js-cp-applied-resume div.js-cp-wrap-resume-jobs div.js-cp-resume-wrap div.js-cp-applied-resume div.js-cp-image-area img{border:1px solid ".$color5."; border-left:4px solid ".$color1."}
	div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-jobs-resume-panel div.js-cp-applied-resume div.js-cp-wrap-resume-jobs div.js-cp-resume-wrap div.js-cp-applied-resume div.js-cp-content-area div.js-cp-company-title{border-bottom:1px solid ".$color5."}
	div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-jobs-resume-panel div.js-cp-applied-resume div.js-cp-wrap-resume-jobs div.js-cp-resume-wrap div.js-cp-applied-resume div.js-cp-content-area div.js-cp-company-title a{color:".$color1.";}
	div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-jobs-resume-panel div.js-cp-applied-resume div.js-cp-wrap-resume-jobs div.js-cp-resume-wrap div.js-cp-applied-resume div.js-cp-company-location{color:".$color4.";}
	div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-jobs-resume-panel div.js-cp-applied-resume div.js-cp-wrap-resume-jobs div.js-cp-resume-wrap div.js-cp-applied-resume span.jsjobs-title{color:".$color8.";}
	div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-jobs-resume-panel div.js-cp-applied-resume div.js-cp-wrap-resume-jobs div.js-cp-resume-wrap div.js-cp-applied-resume span.jsjobs-value{color:".$color4.";}
	div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-jobs-resume-panel div.js-cp-applied-resume div.js-cp-wrap-resume-jobs div.js-cp-resume-wrap div.js-cp-applied-resume-lower{border-top:1px solid ".$color5."; color:".$color4.";background:".$color3.";}
	div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-jobs-resume-panel div.js-cp-applied-resume div.js-cp-wrap-resume-jobs div.js-cp-resume-wrap div.js-cp-applied-resume-lower span.jsjobs-loction{color:".$color4.";}

	div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-suggested-jobs div.js-cp-resume-jobs div.js-suggestedjobs-area div.js-cp-jobs-sugest{border:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-suggested-jobs div.js-cp-resume-jobs div.js-suggestedjobs-area div.js-cp-jobs-sugest div.js-cp-image-area{border:1px solid ".$color5."; border-left:4px solid ".$color1."}
	div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-suggested-jobs div.js-cp-resume-jobs div.js-suggestedjobs-area div.js-cp-jobs-sugest div.js-cp-content-area div.js-cp-company-title{ border-bottom:1px solid ".$color5."; color:".$color1.";}
	div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-suggested-jobs div.js-cp-resume-jobs div.js-suggestedjobs-area div.js-cp-jobs-sugest div.js-cp-content-area div.js-cp-company-location{color:".$color4.";}

	div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-resume-jobs div#jsjobs-appliedresume-seeker{border:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-applied-resume div.js-cp-resume-jobs div.js-appliedresume-area div.jsjobs-cp-resume-applied div.js-cp-image-area a img{border:1px solid ".$color5."; border-left:4px solid ".$color1."}
	div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-applied-resume div.js-cp-resume-jobs div.js-appliedresume-area div.jsjobs-cp-resume-applied div.js-cp-content-area div.js-cp-company-title{border-bottom:1px solid ".$color5."; color:".$color1.";}
	div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-applied-resume div.js-cp-resume-jobs div.js-appliedresume-area div.jsjobs-cp-resume-applied div.js-cp-content-area div.js-cp-company-location{color:".$color4.";}
	div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-applied-resume div.js-cp-resume-jobs div.js-appliedresume-area div.jsjobs-cp-resume-applied div.js-cp-content-area span.jsjobs-title{color:".$color8.";}
	div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-applied-resume div.js-cp-resume-jobs div.js-appliedresume-area div.jsjobs-cp-resume-applied div.js-cp-content-area span.jsjobs-value{color:".$color4.";}
	div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-applied-resume div.js-cp-resume-jobs div.js-appliedresume-area div.jsjobs-cp-resume-applied-lower{border-top:1px solid ".$color5."; color:".$color4.";background:".$color3.";}

	div#js_main_wrapper div div.js-resume-section-title{background:".$color3.";border-bottom:2px solid ".$color1."; color:".$color8.";}
	div#js_main_wrapper div div.js-resume-section-title img.jsjobs-resume-section-image{background:".$color1.";}
	div#js_main_wrapper div div.js-resume-section-body{background:".$color3."; border:1px solid ".$color5.";}
	div#js_main_wrapper div div.js-resume-section-body form div div.js-resume-field-container label{color:".$color8.";}
	div#js_main_wrapper div div.js-resume-section-body form div div.js-resume-show-hide-btn span{ color:".$color7."; background:".$color1.";}
	div#js_main_wrapper div div.js-resume-section-body form div div.js-resume-submit-container{border-top:1px solid ".$color5.";}
	div#js_main_wrapper div div.js-resume-section-body form div div.js-resume-submit-container button{outline:none; border:1px solid ".$color5."; color:".$color8."; background:".$color6.";}
	div#js_main_wrapper div div.js-resume-section-body form div div.js-resume-submit-container button:hover{border:1px solid ".$color1."; color:".$color7."; background:".$color1.";}
	div#js_main_wrapper div div.js-resume-section-body form div div.js-resume-field-container div.upload-field{border:1px solid ".$color5.";}
	div#js_main_wrapper div div.js-resume-section-body form div div.js-resume-field-container div.upload-field span.upload_btn{background:".$color1."; color:".$color7.";}

	div#js_main_wrapper div div.js-resume-section-body form div div.js-resume-field-container div.files-field div.selectedFiles{border:1px solid ".$color5.";}
	div#js_main_wrapper div div.js-resume-section-body form div div.js-resume-field-container div.files-field span.upload_btn{background:".$color1.";color:".$color7.";}
	div#js_main_wrapper div div.js-resume-section-body div.js-resume-section-view div.js-resume-profile div img.avatar{border:1px solid ".$color5."; border-left:4px solid ".$color1."; box-shadow:0px 0px 10px #999; }
	div#js_main_wrapper div div.js-resume-section-body div div.js-resume-section-view{background:#FFFFFF; border:1px solid ".$color5.";}
	div#js_main_wrapper div div.js-resume-section-body div div.js-resume-section-view div.js-resume-profile-info div div.js-resume-profile-name{color:".$color8.";}
	div#js_main_wrapper div div.js-resume-section-body div div.js-resume-section-view div.js-resume-profile-info div.js-resume-profile-email{color:".$color4."; border-top:1px solid ".$color5."; }
	div#js_main_wrapper div div.js-resume-section-body div div.js-resume-section-view div.js-resume-profile-info div.js-resume-profile-cell{color:".$color4.";}
	div#js_main_wrapper div div.js-resume-section-body div div.js-resume-section-view div.js-resume-data div.js-row{border-bottom:1px solid ".$color5.";}
	div#js_main_wrapper div div.js-resume-section-body div div.js-resume-data div div.js-resume-data-title{color:".$color8.";}
	div#js_main_wrapper div div.js-resume-section-body div div.js-resume-data div div.js-resume-data-value{color:".$color4.";}
	div#js_main_wrapper div div.js-resume-section-title img{background:".$color1.";}
	div#js_main_wrapper div#resumeFormContainer.js-resume-section-body.personal-section form#resumeForm.jsautoz_form{background:#FFFFFF;border:1px solid ".$color5."; }
	div#js_main_wrapper div div.js-resume-section-body form div div.loc-field a.map-link{background:".$color1.";color:".$color7.";}
	div#js_main_wrapper div div.js-resume-section-body div div.js-resume-data-section-view{border:1px solid ".$color5.";}
	div#js_main_wrapper div div.js-resume-section-body div div.js-resume-data-section-view div.js-resume-data-head{border-bottom:1px solid ".$color5.";color:".$color8."; background:".$color3.";}
	div#js_main_wrapper div div.js-resume-section-body div div.js-resume-data-section-view div div.js-resume-data-title{color:".$color8.";}
	div#js_main_wrapper div div.js-resume-section-body div div.js-resume-data-section-view div div.js-resume-data-value{color:".$color4.";}
	div#js_main_wrapper div div.js-resume-section-body div div.js-resume-address-section-view div.addressheading{border-bottom:1px solid ".$color5.";color:".$color8."; background:".$color3.";}
	div#js_main_wrapper div div.js-resume-section-body div div.js-resume-address-section-view div.addressvalue{border-bottom:1px solid ".$color5.";}
	div#js_main_wrapper div div.js-resume-section-body div div.js-resume-address-section-view div.addressvalue span.addressDetails{color:".$color4.";}
	div#js_main_wrapper div div#js-resume-section-view div.js-resume-section-view{background:#FFFFFF; border:1px solid ".$color5.";}
	div#js_main_wrapper div div.js-resume-section-body div div.js-resume-address-section-view div.map-toggler{color:".$color4."; background:".$color3."; border:1px solid ".$color5."; }
	div#js_main_wrapper div div.js-resume-section-body div div.js-resume-address-section-view{ border:1px solid ".$color5.";}
	div#resumeFilesPopup div.resumeFiles_close span{background:".$color1."; color:".$color7.";}
	div#resumeFilesPopup div#filesInfo{border:1px solid ".$color5.";}

	div#js_main_wrapper form div#coverletterPopup.coverletterPopup div#coverletter_description span{border:1px solid ".$color5.";}

	div#resumeFilesPopup.resumeFilesPopup{ background:".$color3.";}
	div#resumeFilesPopup div.fileSelectionButton{ background:".$color6."; color:".$color8."; border:1px solid ".$color5.";}

	div#resumeFilesPopup div#resumeFiles_headline{color:".$color7."; background:".$color1.";}
	div#resumeFilesPopup div.fileSelectionButton input.resumefiles{color:".$color8."; background:".$color6.";}
	div#resumeFilesPopup div.chosenFiles_heading{color:".$color7."; background:".$color8.";}

	div#js_jobs_main_popup_area div#js_jobs_main_popup_head{color:".$color7.";  background:".$color1.";}
	div#jsquickview_wrapper1 div#quickview_head{color:".$color8.";}
	div#jsquickview_wrapper1{background:".$color3."; border-bottom:1px solid ".$color5."; }
	div#js_jobs_main_popup_area div#jspopup_work_area{border:1px solid ".$color5."; border-top:none;}
	div#jsquickview_wrapper1 div#quickview_det{color:".$color4.";}
	div#jsquickview_block_bottom div#jsquick_view_title{color:".$color8."; background:".$color3."; border-bottom:2px solid ".$color2.";}
	div#jsquickview_block_bottom div.jsquick_view_rows{border-bottom:1px solid ".$color5.";}
	div#jsquickview_block_bottom div.jsquick_view_rows span.js_quick_title{color:".$color8.";}
	div#jsquickview_block_bottom div.jsquick_view_rows span.js_quick_value{color:".$color4.";}
	div#jsquickview_block_bottom div.jsquickview_decs{ border:1px solid ".$color5.";  color:".$color8.";  }
	div#jspopup_work_area div.shortlist_box div.jsjobs_shortlist_box label{ color:".$color8."; }
	div.jsjobs_stars_wrapper div.jsjobs-starst-slist label.contact_info_margin{ color:".$color8."; }
 	div#jspopup_work_area div#js_main_wrapper div.js_job_form_field_wrapper div.jsjobs_jobapply_wrapper div.jsjobapply_title{color:".$color8."; }
 	div#jspopup_work_area div#js_main_wrapper  span.jsjobs_job_in_formation{color:".$color8."; background:".$color3."; border-bottom:2px solid ".$color2.";}
 	div#js_main_wrapper div.js_job_data_jobapply{ border-bottom:1px solid ".$color5.";}
 	div#js_main_wrapper div.js_job_data_jobapply span.js_job_data_apply_title{color:".$color8."; }
 	div#js_main_wrapper div.js_job_data_jobapply span.js_job_data_apply_value{color:".$color4."; }

 	div.js_job_error_messages_wrapper{border:1px solid ".$color1."; color: ".$color7.";}
	div.js_job_error_messages_wrapper div.message2{box-shadow:0px 0px 10px #999; background:".$color1."; color: ".$color7.";}
	div.js_job_error_messages_wrapper div.footer{background:".$color3."; border-top: 1px solid ".$color5.";}
	div.js_job_error_messages_wrapper div.message1 span{ font-size: 17px; font-weight: bold; color:".$color8.";}
	div.js_job_error_messages_wrapper div.message2 span.img{box-shadow:0px 0px 10px #999; border:1px solid ".$color1.";}
	div.js_job_error_messages_wrapper div.footer a{background: ".$color6."; border: 1px solid ".$color5."; font-size: 16px;}
	div.js_job_error_messages_wrapper div.footer a:hover{background: ".$color1."; color:".$color7.";}

	div#jsjobs-main-wrapper div.jsjobs-package-data span.jsjobs-package-title-buy-now{ border:1px solid ".$color5."; border-bottom:2px solid ".$color2.";  background:".$color3.";}
	div#jsjobs-main-wrapper div.jsjobs-package-data span.jsjobs-package-title-buy-now span.stats_data_value{color:".$color7."; background:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper div.jsjobs-listing-datawrap{border:1px solid ".$color5."; border-bottom:2px solid ".$color2."; border-top:none;}
	div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper div.jsjobs-package-data-detail span.jsjobs-package-values{border-bottom:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper div.jsjobs-package-data-detail span.jsjobs-package-values span.stats_data_title{ color:".$color8."; }
	div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper div.jsjobs-package-data-detail span.jsjobs-package-values span.stats_data_value{ color:".$color4."; }
	div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-description{border:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper div.jsjobs-description span.jsjobs-description-title{color:".$color8.";}

	div#jsjobs-main-wrapper div.jsjobs-package-data div#js_main_wrapper.jsjobs-show_buynow_div span.js_job_title {background:".$color8."; color:".$color7.";}
	div#js_main_wrapper div.js_listing_wrapper.paymentmethod{border-bottom:1px solid ".$color5.";}
	div#js_main_wrapper div.js_listing_wrapper.paymentmethod span.payment_method_title{color:".$color8."; }
	div#js_main_wrapper div.js_listing_wrapper.paymentmethod span.payment_method_button input.js_job_button{outline: none; color:".$color8.";  background:".$color6."; border:1px solid ".$color5."; }
	div#js_main_wrapper div.js_listing_wrapper.paymentmethod span.payment_method_button input.js_job_button:hover{color:".$color7.";  background:".$color1."; border:1px solid ".$color7."; }

	div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper span.jsjobs-paymentmethods-title{background:".$color8."; color:".$color7.";}
	div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-listing-wrapperes div.jsjobs-list-wrap{border-bottom:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-listing-wrapperes:last-child div.jsjobs-list-wrap{border-bottom:none;}
	div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-listing-wrapperes div.jsjobs-list-wrap span.payment_method_title{color:".$color8."; }
	div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-listing-wrapperes div.jsjobs-list-wrap span.payment_method_button input#jsjobs_button{outline: none; color:".$color8.";  background-color:".$color6."; border:1px solid ".$color5."; }
	div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-listing-wrapperes div.jsjobs-list-wrap span.payment_method_button input#jsjobs_button:hover{color:".$color7.";  background-color:".$color1."; border:1px solid ".$color7."; }

	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper div.fieldvalue-check span.jsjobs-checkbox-gender{background:".$color3."; border:1px solid ".$color5."; }
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper div.fieldvalue-check span.jsjobs-checkbox-eduction{background:".$color3."; border:1px solid ".$color5."; }
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper div.fieldvalue-check span.jsjobs-checkbox-location{background:".$color3."; border:1px solid ".$color5."; }
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper div.fieldvalue-check span.jsjobs-checkbox-subcategory{background:".$color3."; border:1px solid ".$color5."; }

	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper div.fieldvalue-check span.jsjobs-checkbox-gender label{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper div.fieldvalue-check span.jsjobs-checkbox-eduction label{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper div.fieldvalue-check span.jsjobs-checkbox-location label{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper div.fieldvalue-check span.jsjobs-checkbox-subcategory label{color:".$color8.";}
	
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper div.check-box-joblink{background:".$color3."; border:1px solid ".$color5."; color:".$color8.";}

	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper div.fieldvalue-radio-button div#resumeapplyfilter span.jsjobs-radio-email-me{background:".$color3."; border:1px solid ".$color5."; }
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper div.fieldvalue-radio-button div#resumeapplyfilter span.jsjobs-radio-email-me span.jsjobs-radio-title{color:".$color8.";}
	div#jsjobs-main-wrapper div.jsjobs-company-applied-data div.js_job_apply_button{border-top:2px solid ".$color2.";}

	.js-resume-data-section-view js-row.no-margin div.js-row.no-margin{border-bottom:1px solid ".$color5.";}
	div#js_main_wrapper div div.js-resume-section-body div div.js-resume-data-section-view div.js-row{border-bottom:1px solid ".$color5.";}
	div#js_main_wrapper div div.js-resume-section-body div div.js-resume-data-section-view div.js-resume-data-head{border-bottom:1px solid ".$color1.";}
	div#js_main_wrapper div div.js-resume-section-body div div.js-resume-address-section-view div.addressheading{border-bottom:1px solid ".$color1.";}
	div#js_main_wrapper form div.jsjobsformheading{background:".$color3."; color:".$color8."; border:1px solid ".$color5."; border-bottom:1px solid ".$color1.";}
	form.editform div.jsjobsformheading{background:".$color3."; color:".$color8."; border:1px solid ".$color5."; border-bottom:2px solid ".$color1.";}
	div#js_main_wrapper div#instituteFormContainer form#resumeInstituteForm{border:1px solid ".$color5.";}
	div#js_main_wrapper div#employerFormContainer form#resumeEmployerForm{border:1px solid ".$color5.";}
	div#js_main_wrapper div#referenceFormContainer form#resumeReferenceForm{border:1px solid ".$color5.";}
	div#js_main_wrapper div#languageFormContainer form#resumeLanguageForm{border:1px solid ".$color5.";}

	div#jsjobs-main-wrapper div#js_apply_loginform_login{border:1px solid ".$color5."; background:".$color3.";}
	div#jsjobs-main-wrapper div#js_apply_loginform_login div.js_apply_loginform_title{color:".$color4.";}
	div#jsjobs-main-wrapper div#js_apply_loginform_login div.js_apply_loginform input#modlgn-username{border:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div#js_apply_loginform_login div.js_apply_loginform input#modlgn-passwd{border:1px solid ".$color5.";}
	div#jsjobs-main-wrapper div#js_apply_loginform_login div.js_apply_loginform input.js_apply_button{background:".$color1."; color:".$color7."; border:none;}
	div#jsjobs-main-wrapper div#js_apply_loginform_login div.js_apply_visitor div.js-border-left{border-left:1px solid ".$color5.";}

	div#jsjobs-main-wrapper div#sortbylinks span.my_resume_sbl_links a{background:".$color8."; color:".$color7.";}
	div#jsjobs-main-wrapper div#sortbylinks span.my_resume_sbl_links a:hover,
	div#jsjobs-main-wrapper div#sortbylinks span.my_resume_sbl_links a.selected{background:".$color1.";}

	div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-description span.jsjobs-description-value p{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-purchasehistory-main div.jsjobs-purchase-listing-wrapper div.jsjobs-listing-datawrap-details div.jsjobs-listing-wrap div.jsjobs-values-wrap.bordernone{border-bottom:none;}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper div.fieldvalue-check span.jsjobs-filter{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper div.fieldvalue-radio-button div#resumeapplyfilter span#jobsapplyalertsettingheading{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper div.fieldvalue-radio-button div#resumeapplyfilter span#formjobemailtext{color:".$color4.";}
	div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper div.fieldvalue input{color:".$color4.";}
	div.js-jobs-resume-apply-now-visitor{border:2px solid ".$color1.";}
	div.js-jobs-resume-apply-now-visitor div.js-jobs-resume-apply-now-button input#jsjobs-login-btn{border:none; background:".$color1."; color:".$color7.";}
	div#jsjobs_module_wrapper div#jsjobs_module_wrap div#jsjobs_module_data_fieldwrapper span#jsjobs_module_data_fieldtitle{color:".$color8.";}
	div#jsjobs_module_wrapper div#jsjobs_module_wrap div#jsjobs_module_data_fieldwrapper span#jsjobs_module_data_fieldvalue{color:".$color4.";}
	div#jsjobs_module{background:".$color3.";border:1px solid ".$color5.";}
	div#jsjobs_modulelist_databar{background:".$color3.";border:1px solid ".$color5.";}
	div#jsjobs_modulelist_titlebar{background:".$color3.";border:1px solid ".$color5.";}
	div#jsjobs_module span#jsjobs_module_heading{border-bottom:1px solid ".$color2.";}
	div#jsjobs_module a{color:".$color1.";}


	@media(min-width: 481px) and (max-width: 768px) {
		div#js_main_wrapper div#jsjobs_appliedapplication_tab_container a{border:1px solid ".$color5.";}
		div#jsjobs-main-wrapper div.jsjobs-folderinfon div.jsjobs-listfolders div.jsjobs-status-button span.jsjobs-message-created{border-left:none; border-right:none;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-mydepartmentlist div.jsjob-main-department div.jsjobs-main-department-right div.jsjobs-coverletter-button-area{border-left:none; }
		div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-jobs-save div.jsjobs-cover-button-area span.jsjobs-coverletter-created{ border-right:none;  border-left:none;  }
		div#jsjobs-main-wrapper div.jsjobs-listing-main-wrapper div.jsjobs-listing-area div.jsjobs-coverletter-button-area span.jsjobs-coverletter-created{ border-right:none;  border-left:none;  }
	}

	@media (max-width: 480px){
		div#js_main_wrapper div#jsjobs_appliedapplication_tab_container a{border:1px solid ".$color5.";}
		div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-coverletter-button-area span.jsjobs-coverletter-created{ border-left:none;  border-right:none;border-top:1px solid ".$color5.";  border-bottom:1px solid ".$color5."; }
		div#jsjobs-main-wrapper div.jsjobs-job-info div.jsjobs-data-jobs-wrapper span.jsjobs-location-wrap{border-left:none;}
		div#jsjobs-main-wrapper div.jsjobs-job-info div.jsjobs-data-jobs-wrapper span.jsjobs_daysago{border-left:none;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-mydepartmentlist div.jsjob-main-department div.jsjobs-main-department-right div.jsjobs-coverletter-button-area{border-left:none;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfon div.jsjobs-listfolders div.jsjobs-status-button span.jsjobs-message-created{border-left:none; border-right:none;}
		div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-jobs-save div.jsjobs-cover-button-area span.jsjobs-coverletter-created{ border-right:none;  border-left:none;  }
		div#jsjobs-main-wrapper div.jsjobs-listing-main-wrapper div.jsjobs-listing-area div.jsjobs-coverletter-button-area span.jsjobs-coverletter-created{ border-right:none;  border-left:none;  }

		div#jsjobs-main-wrapper div.jsjobs-purchasehistory-main div.jsjobs-purchase-listing-wrapper div.jsjobs-expire-days span.expired_package{border-left:none; border-top:1px solid ".$color5.";}
	}";

	// Language is RTL Then add following css too.
	$language = JFactory::getLanguage();
	if($language->isRtl()){
		$style .="

		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-wrapper-mycompanies div.jsjobs-main-companieslist div.jsjobs-main-wrap-imag-data div.com-logo a.img{border:1px solid ".$color5."; border-right:4px solid ".$color1.";}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist span.jsjobs-image-area a.jsjobs-image-area-achor{border:1px solid ".$color5."; border-right:4px solid ".$color1.";}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resume-searchresults div.jsjobs-resume-searchresults div.jsjobs-resume-search div.jsjobs-image-area div.jsjobs-img-border div.jsjobs-image-wrapper{border:1px solid ".$color5."; border-right:4px solid ".$color1.";}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_image_area div.js_job_image_wrapper.mycompany{border:1px solid ".$color5.";border-right:4px solid ".$color1.";}
		div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-message-history-wrapper span.jsjobs-img-sender span.jsjobs-img-area{border:1px solid ".$color5.";border-right:4px solid ".$color1.";}
		div#jsjobs-main-wrapper div.jsjobs-company-applied-data div.jsjobs-company-logo span.jsjobs-company-logo-wrap span.jsjobs-left-border{border:1px solid ".$color5.";border-right:4px solid ".$color1.";}
		div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-right-raea div.js_job_company_logo div.jsjobs-company-logo-wrap{border:1px solid ".$color5.";border-right:4px solid ".$color1.";}
		div#js-jobs-wrapper div.js-toprow div.js-image{border:1px solid ".$color5."; border-right:4px solid ".$color1.";}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-image-area{border:1px solid ".$color5.";border-right:4px solid ".$color1.";}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listcompany div.jsjobs-wrapper-listcompany div.jsjobs-listcompany div.jsjobs-image-area div.jsjobs-image-wrapper-mycompany div.jsjobs-image-border{border:1px solid ".$color5.";border-right:4px solid ".$color1.";}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listappliedjobs div.jsjobs-main-wrapper-appliedjobslist div.jsjobs-image-area a{border:1px solid ".$color5."; border-right:4px solid ".$color1."}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist div.jsjobs-image-area a img{border:1px solid ".$color5."; border-right:4px solid ".$color1."}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-jobs-resume-panel div.js-cp-applied-resume div.js-cp-wrap-resume-jobs div.js-cp-resume-wrap div.js-cp-applied-resume div.js-cp-image-area img{border:1px solid ".$color5."; border-right:4px solid ".$color1."}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-suggested-jobs div.js-cp-resume-jobs div.js-suggestedjobs-area div.js-cp-jobs-sugest div.js-cp-image-area{border:1px solid ".$color5."; border-right:4px solid ".$color1."}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-applied-resume div.js-cp-resume-jobs div.js-appliedresume-area div.jsjobs-cp-resume-applied div.js-cp-image-area a img{border:1px solid ".$color5."; border-right:4px solid ".$color1."}
		div#js_main_wrapper div div.js-resume-section-body div.js-resume-section-view div.js-resume-profile div img.avatar{border:1px solid ".$color5."; border-right:4px solid ".$color1."; }
		div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-main-message-wrap div.jsjobs-company-logo span.jsjobs-img-wrap{border:1px solid ".$color5."; border-right: 4px solid ".$color1.";}

		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-mydepartmentlist div.jsjob-main-department div.jsjobs-main-department-right div.jsjobs-coverletter-button-area{border-left:none; border-right:1px solid ".$color5.";}
		div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-messages-list div.jsjobs-message-button-area span.jsjsobs-message-btn{border-left:none; border-right:1px solid ".$color5.";}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-listing-datawrap{border-right:none; border-left:1px solid ".$color5."; }

		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-graph-wrap div.js-graph-left div.jsjobs-graph-wrp span.jsjobs-graph-title{ border-color: #ccc #9260e9 #ccc; color: #64676a; border-style: solid; border-width: 1px 5px 1px 1px; }
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-graph-wrap div.js-graph-right div.jsjobs-graph-wrp span.jsjobs-graph-title{border-color: #ccc #ef348a #ccc; color: #64676a; border-style: solid; border-width: 1px 5px 1px 1px; }
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-adding-section span.js-sample-title{border-color: #ccc #ef348a #ccc; color: #64676a; border-style: solid; border-width: 1px 5px 1px 1px;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.js-cp-stats-panel span.js-sample-title{ border-color: #ccc #9260e9 #ccc; color: #64676a; border-style: solid; border-width: 1px 5px 1px 1px; }

		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-jobseeker-cp-wrapper div.js-cp-graph-area span.js-cp-graph-title{border-color: #ccc #ef348a #ccc; color: #64676a; border-style: solid; border-width: 1px 5px 1px 1px;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-categories div.jsjobs-cp-jobseeker-categories-btn span.js-cp-graph-title{ border-color: #ccc #9260e9 #ccc; color: #64676a; border-style: solid; border-width: 1px 5px 1px 1px; }
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-stats span.js-sample-title{border-color: #ccc #ef348a #ccc; color: #64676a; border-style: solid; border-width: 1px 5px 1px 1px;}

		table#js-table tbody td.bodercolor1{border-left:none; border-right:3px solid #4020CD;}
		table#js-table tbody td.bodercolor2{border-left:none; border-right:3px solid #E37900;}
		table#js-table tbody td.bodercolor3{border-left:none; border-right:3px solid #86C544;}
		table#js-table tbody td.bodercolor4{border-left:none; border-right:3px solid #663333;}
		table#js-table tbody td.bodercolor5{border-left:none; border-right:3px solid #57A695;}
		table#js-table tbody td.bodercolor6{border-left:none; border-right:3px solid #Ff6600;}
		table#js-table tbody td.bodercolor7{border-left:none; border-right:3px solid #00AFEF;}

		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-toprow a.color3 {border-left: 5px solid #9260E9;border-right:1px solid #D4D4D5;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-toprow a.color2 {border-left: 5px solid #E69200;border-right:1px solid #D4D4D5;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-toprow a.color1 {border-left: 5px solid #53BF58;border-right:1px solid #D4D4D5;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-toprow a.color4 {border-left: 5px solid #ED473A;border-right:1px solid #D4D4D5;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-toprow-job-seeker a.color3 {border-left: 5px solid #EF348A;border-right:1px solid #D4D4D5;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-toprow-job-seeker a.color2 {border-left: 5px solid #9260E9;border-right:1px solid #D4D4D5;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-toprow-job-seeker a.color1 {border-left: 5px solid #53BF58;border-right:1px solid #D4D4D5;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-toprow-job-seeker a.color4 {border-left: 5px solid #4285F4;border-right:1px solid #D4D4D5;}

		@media (max-width: 480px){
		    table#js-table tbody tr.bodercolor1_rs td{border-left:1px solid ".$color5."; border-right:3px solid #4020CD;}
		    table#js-table tbody tr.bodercolor2_rs td{border-left:1px solid ".$color5."; border-right:3px solid #E37900;}
		    table#js-table tbody tr.bodercolor3_rs td{border-left:1px solid ".$color5."; border-right:3px solid #86C544;}
		    table#js-table tbody tr.bodercolor4_rs td{border-left:1px solid ".$color5."; border-right:3px solid #663333;}
		    table#js-table tbody tr.bodercolor5_rs td{border-left:1px solid ".$color5."; border-right:3px solid #57A695;}
		    table#js-table tbody tr.bodercolor6_rs td{border-left:1px solid ".$color5."; border-right:3px solid #Ff6600;}
		    table#js-table tbody tr.bodercolor7_rs td{border-left:1px solid ".$color5."; border-right:3px solid #00AFEF;}
		}
	";
	}

    $document = JFactory::getDocument();
    $document->addStyleDeclaration($style);
