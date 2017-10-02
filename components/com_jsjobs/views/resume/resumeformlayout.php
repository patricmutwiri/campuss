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

class JSJobsResumeformlayout {

    function getResumeLayout($data) {
        $sectionName = JRequest::getVar('sectionName');
        $sectionData = $data[0];
        $currentFromData = $data[1];
        $resumelists = $data[2];
        $maxPhotoSize = $data[3];
        $allowedPhotoTypes = $data[4];
        $fieldsordering = $data[5];
        $sectionMaxForms = $data[6];
        $sectionExistingRecords = $data[7];
        $packagedetail = $data[8];
        $captcha = $data[9];
        $config = $data[10];
        $userfield = "";
        $layout = '';
        $layoutData = array();
        switch ($sectionName) {
            case 'personal':
                $layoutData[0] = $sectionData;
                $layoutData[1] = $fieldsordering;
                $layout = $this->getPersonalSectionLayout($layoutData, $resumelists, $packagedetail, $captcha, $config, $userfield);
                break;
            case 'address':
                $layout = $this->getAddressSectionLayout($sectionData, $currentFromData, $fieldsordering, $sectionMaxForms, $sectionExistingRecords, $packagedetail, $config, $userfield);
                break;
            case 'institute':
                $layout = $this->getInstituteSectionLayout($sectionData, $currentFromData, $fieldsordering, $sectionMaxForms, $sectionExistingRecords, $packagedetail, $config, $userfield);
                break;
            case 'employer':
                $layout = $this->getEmployerSectionLayout($sectionData, $currentFromData, $fieldsordering, $sectionMaxForms, $sectionExistingRecords, $packagedetail, $config, $userfield);
                break;
            case 'skills':
                $layout = $this->getSkillsSectionLayout($sectionData, $fieldsordering, $packagedetail, $config, $userfield);
                break;
            case 'editor':
                $layout = $this->getResumeSectionLayout($sectionData, $fieldsordering, $packagedetail, $config, $userfield);
                break;
            case 'reference':
                $layout = $this->getReferenceSectionLayout($sectionData, $currentFromData, $fieldsordering, $sectionMaxForms, $sectionExistingRecords, $packagedetail, $config, $userfield);
                break;
            case 'language':
                $layout = $this->getLanguageSectionLayout($sectionData, $currentFromData, $fieldsordering, $sectionMaxForms, $sectionExistingRecords, $packagedetail, $config, $userfield);
                break;
        }
        return $layout;
    }

    function getPersonalSectionLayout($resumeData, $resumelists, $packagedetail, $captcha, $config, $userfield) { // used and created by muhiaudin for new resume form view
        $userfieldcount = 0;
        $resumeid = JRequest::getVar('resumeid');
        $sectiontype = JRequest::getVar('sectiontype');
        $resume = $resumeData[0];
        $fieldsordering = $resumeData[1];
        $user = JFactory::getUser();
        $uid = $user->id;
        $session = JFactory::getSession();
        $visitor = $session->get('jsjob_jobapply');
        $customfieldobj = getCustomFieldClass();
        if ($user->guest) {
            $resumeidSession = $session->get('resumeid');
            if (!isset($resumeidSession)) {
                $session->set("resumeid", $resumeid);
            } else {
                /* why the visitor cannot edit resume when it can on form resume
                if ($sectiontype == "form" AND $resumeid != -1) {
                    echo 0;
                    JFactory::getApplication()->close();
                }
                */
            }
        }

        $nav = JRequest::getVar('nav');

        if ($config['date_format'] == 'm/d/Y')
            $dash = '/';
        else
            $dash = "-";
        $dateformat = $config['date_format'];        
        $firstdash = strpos($dateformat, $dash, 0);
        $firstvalue = substr($dateformat, 0, $firstdash);
        $firstdash = $firstdash + 1;
        $seconddash = strpos($dateformat, $dash, $firstdash);
        $secondvalue = substr($dateformat, $firstdash, $seconddash - $firstdash);
        $seconddash = $seconddash + 1;
        $thirdvalue = substr($dateformat, $seconddash, strlen($dateformat) - $seconddash);
        $js_dateformat = '%' . $firstvalue . $dash . '%' . $secondvalue . $dash . '%' . $thirdvalue;
        $js_scriptdateformat = $firstvalue . $dash . $secondvalue . $dash . $thirdvalue;
        
        $section_personal = 0;
        $first_name = 0;
        $middle_name = 0;
        $last_name = 0;
        $email_address = 0;
        $cell = 0;
        $photo = 0;
        $section_moreoptions = 0;

        $Itemid = JRequest::getVar('Itemid');
        for ($i = 0; $i < COUNT($fieldsordering); $i++) {
            $field = $fieldsordering[$i];
            switch ($field->field) {
                case "section_personal":
                    $section_personal = ($field->published == 1) ? 1 : 0;
                    break;
                case "first_name":
                    $first_name = ($field->published == 1) ? 1 : 0;
                    break;
                case "middle_name":
                    $middle_name = ($field->published == 1) ? 1 : 0;
                    break;
                case "last_name":
                    $last_name = ($field->published == 1) ? 1 : 0;
                    break;
                case "email_address":
                    $email_address = ($field->published == 1) ? 1 : 0;
                    break;
                case "cell":
                    $cell = ($field->published == 1) ? 1 : 0;
                    break;
                case "photo":
                    $photo = ($field->published == 1) ? 1 : 0;
                    break;
                case "section_moreoptions":
                    $section_moreoptions = ($field->published == 1) ? 1 : 0;
                    break;
            }
        }
        $data = '';
        if ($sectiontype == 'view') {
            $data = '
                    <div class="js-resume-section-view js-col-lg-12 js-col-md-12 no-padding">
                        <div class="js-resume-profile js-col-lg-12 js-col-md-12 no-padding">
                            <div class="js-col-lg-3 js-col-md-3 no-padding">';
            if ($photo == 1) {
                if (!empty($resume->photo)) {
                    if(isset($resume->image_path)){
                        $data .= '<img class="avatar" height="150" width="150" src="'.$resume->image_path.'"  />';
                    }else{
                        $data .= '<img class="avatar" height="150" width="150" src="' . JURI::root() . $config['data_directory'] . '/data/jobseeker/resume_' . $resume->id . '/photo/' . $resume->photo . '"  />';
                    }
                    
                } else {
                    $data .= '<img class="avatar" src="' . JURI::root() . '/components/com_jsjobs/images/jobseeker.png"  />';
                }
            }
            $data .= '
                            </div>
                            <div class="js-resume-profile-info js-col-lg-9 js-col-md-9 no-padding">
                                <div class="profile-name-outer js-row no-margin">
                                    <div class="js-resume-profile-name js-col-lg-11 js-col-md-11 no-padding">
                                        <span>';
            if ($first_name == 1) {
                $data .= $resume->first_name . ' ';
            }
            if ($middle_name == 1) {
                $data .= $resume->middle_name . ' ';
            }
            if ($last_name == 1) {
                $data .= $resume->last_name;
            }
            $data .= '
                                        </span>
                                    </div>';
            if (isset($uid) || $uid != 0) {
                $data .= '
                                    <div class="js-resume-edit js-col-lg-1 js-col-md-1 no-padding">
                                        <span id="edit-resume" onclick="return getResumeForm(' . $resumeid . ', \'\', \'personal\');"><img src="' . JURI::root() . 'components/com_jsjobs/images/edit-black.png"></span>
                                    </div>';
            }
            $data .= '
                                </div>
                                <div class="js-resume-profile-email js-row no-margin">
                                    <span>';
            if ($email_address == 1) {
                $data .= $resume->email_address;
            }
            $data .= '
                                    </span>
                                </div>
                                <div class="js-resume-profile-cell js-row no-margin">
                                    <span>';
            if ($cell == 1) {
                $data .= $resume->cell;
            }
            $data .= '
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="js-resume-data js-col-lg-12 js-col-md-12 no-padding">';
            foreach ($fieldsordering as $field) {
                switch ($field->field) {
                    case "application_title":
                        $data .= $this->getResumeField($field->fieldtitle, $resume->application_title, $field->published);
                        break;
                    case "nationality":
                        $data .= $this->getResumeField($field->fieldtitle, $resume->nationalitycountry, $field->published);
                        break;
                    case "license_country":
                        if($resume->driving_license != 1){
                            $resume->licensecountryname = JText::_('N/a');
                        }
                        $data .= $this->getResumeField($field->fieldtitle, $resume->licensecountryname, $field->published);
                        break;
                    case "license_no":
                        if($resume->driving_license != 1){
                            $resume->license_no = JText::_('N/a');
                        }
                        $data .= $this->getResumeField($field->fieldtitle, $resume->license_no, $field->published);
                        break;
                    case "driving_license":
                        switch($resume->driving_license){
                            case 1:
                                $driving_license = JText::_('Yes');
                            break;
                            case 2:
                                $driving_license = JText::_('N/a');
                            break;
                            default:
                                $driving_license = JText::_('N/a');
                            break;
                        }
                        $data .= $this->getResumeField($field->fieldtitle, $driving_license, $field->published);
                        break;
                    case "resumefiles":
                        if ($field->published == 1) {
                            $data .= '
                                            <div class="js-row no-margin">
                                                <div class="js-resume-data-title js-col-lg-3 js-col-md-3 no-padding">
                                                    <span>' . $field->fieldtitle . '</span>
                                                </div>
                                                <div id="resumeFilesList" class="js-resume-data-value filesList js-col-lg-8 js-col-md-8 no-padding"></div>
                                            </div>';
                        }
                        break;
                    case "date_of_birth":
                        if($resume->date_of_birth != '0000-00-00 00:00:00')
                            $date = JHtml::_('date', $resume->date_of_birth, $config['date_format']);
                        else
                            $date = '';
                        $data .= $this->getResumeField($field->fieldtitle, $date, $field->published);
                        break;
                    case "gender":
                        $gender = ($resume->gender == 1) ? JText::_('Male') : JText::_('Female');
                        $data .= $this->getResumeField($field->fieldtitle, $gender, $field->published);
                        break;
                    case "iamavailable":
                        $available = ($resume->iamavailable == 1) ? JText::_('Yes') : JText::_('No');
                        $data .= $this->getResumeField($field->fieldtitle, $available, $field->published);
                        break;
                    case "searchable":
                        $searchable = ($resume->searchable == 1) ? JText::_('Yes') : JText::_('No');
                        $data .= $this->getResumeField($field->fieldtitle, $searchable, $field->published);
                        break;
                    case "home_phone":
                        $data .= $this->getResumeField($field->fieldtitle, $resume->home_phone, $field->published);
                        break;
                    case "work_phone":
                        $data .= $this->getResumeField($field->fieldtitle, $resume->work_phone, $field->published);
                        break;
                    case "job_category":
                        $data .= $this->getResumeField($field->fieldtitle, JText::_($resume->categorytitle), $field->published);
                        break;
                    case "job_subcategory":
                        $data .= $this->getResumeField($field->fieldtitle, JText::_($resume->subcategorytitle), $field->published);
                        break;
                    case "salary":
                        $salary = JSModel::getJSModel('common')->getSalaryRangeView($resume->symbol,$resume->rangestart,$resume->rangeend,JText::_($resume->salarytype),$config['currency_align']);
                        $data .= $this->getResumeField($field->fieldtitle, $salary, $field->published);
                        break;
                    case "desired_salary":
                        $salary = JSModel::getJSModel('common')->getSalaryRangeView($resume->dsymbol,$resume->drangestart,$resume->drangeend,JText::_($resume->dsalarytype),$config['currency_align']);
                        $data .= $this->getResumeField($field->fieldtitle, $salary, $field->published);
                        break;
                    case "jobtype":
                        $data .= $this->getResumeField($field->fieldtitle, $resume->jobtypetitle, $field->published);
                        break;
                    case "heighestfinisheducation":
                        $data .= $this->getResumeField($field->fieldtitle, JText::_($resume->heighesteducationtitle), $field->published);
                        break;
                    case "date_start":
                        if($resume->date_start != '0000-00-00 00:00:00'){
                            $date = JHtml::_('date', $resume->date_start, $config['date_format']);
                        }else{
                            $date = '';
                        }
                        $data .= $this->getResumeField($field->fieldtitle, $date, $field->published);
                        break;
                    case "total_experience":
                        if(!empty($resume->experienceid)){
                            $resume->total_experience = $resume->experiencetitle;
                        }
                        $data .= $this->getResumeField($field->fieldtitle, $resume->total_experience, $field->published);
                        break;
                    default:
                        $data .= $this->getResumeUserField( $customfieldobj ,'', $userfield, $field , $resume);
                        break;
                }
            }
            $data .= '
                        </div>
                    </div>
                    ';
        } elseif ($sectiontype == 'form') {
            $data .= '
                <form action="index.php" method="post" name="resumeForm" id="resumeForm" class="jsautoz_form" enctype="multipart/form-data">';
            foreach ($fieldsordering as $field) {
                switch ($field->field) {
                    case "application_title":
                        if ($field->published == 1) {
                            $fieldValue = isset($resume) ? $resume->application_title : "";
                            $data .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                        }
                        break;
                    case "first_name":
                        if ($field->published == 1) {
                            $fieldValue = isset($resume) ? $resume->first_name : "";
                            $data .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                        }
                        break;
                    case "middle_name":
                        if ($field->published == 1) {
                            $fieldValue = isset($resume) ? $resume->middle_name : "";
                            $data .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                        }
                        break;
                    case "last_name": $lastname_required = ($field->required ? 'required' : '');
                        if ($field->published == 1) {
                            $fieldValue = isset($resume) ? $resume->last_name : "";
                            $data .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                        }
                        break;
                    case "email_address": $email_required = ($field->required ? 'required' : '');
                        if ($field->published == 1) {
                            $fieldValue = isset($resume) ? $resume->email_address : "";
                            $data .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                        }
                        break;
                    case "cell":
                        if ($field->published == 1) {
                            $fieldValue = isset($resume) ? $resume->cell : "";
                            $data .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                        }
                        break;
                    case "gender":
                        if ($field->published == 1) {
                            $fieldValue = $resumelists['gender'];
                            $data .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                        }
                        break;
                    case "photo":
                        if ($field->published == 1) {
                            $photo_required = ($field->required ? 'required' : '');
                            $data .= '
                                    <div class="js-row no-margin">
                                        <div class="js-resume-field-container js-col-lg-10 js-col-md-10 js-col-xs-12 js-col-lg-offset-1 js-col-md-offset-1 no-padding ">
                                            <label id="photomsg" for="photo">' . JText::_($field->fieldtitle);
                                                if ($field->required == 1) {
                                                    $data .= '<span class="error-msg">*</span>';
                                                }
                                            $data .= '</label>
                                            <div class="upload-field">
                                                <input id="uploadPhotoFile" placeholder="'.JText::_("Choose Files").'" disabled="disabled" value="';
                                                if (isset($resume->photo)) {
                                                    $data .= $resume->photo;
                                                }
                                                $data .= '" />
                                                <input type="file" class="inputbox" name="photo" id="photo" onChange="return resumePhotoSelection();" /><span class="upload_btn">'.JText::_('Choose Files').'</span>
                                            </div>
                                            <small>' . $config['image_file_type'] . '</small>
                                            <br><small>' . JText::_('Maximum File Size') . ' (' . $config['resume_photofilesize'] . 'KB)</small>
                                            <input type="hidden" id="photo_required" name="photo_required" value="' . $photo_required . '" />
                                            <input type="hidden" id="resume-photofilename" value="';
                                            if (isset($resume->photo)) {
                                                $data .= $resume->photo;
                                            } else {
                                                $data .= '';
                                            }
                                            $data .= '" />
                                        </div>
                                    </div>';
                        }
                        break;
                    case "resumefiles":
                        if ($field->published == 1) {
                            $files_required = ($field->required ? 'required' : '');
                            $data .= '
                                    <div class="js-row no-margin">
                                        <div class="js-resume-field-container js-col-lg-10 js-col-md-10 js-col-xs-12 js-col-lg-offset-1 no-padding">
                                            <label id="resumefilemsg" for="resumefile">' . JText::_($field->fieldtitle);
                            if ($field->required == 1) {
                                $data .= '<span class="error-msg">*</span>';
                            }
                            $data .= '</label>

                                            <div class="files-field">
                                                <span id="resumeFileSelector" onclick="return resumeFilesSelection();" class="upload_btn">'.JText::_('Choose Files').'</span>
                                                <div id="selectedFiles" class="selectedFiles" onclick="return resumeFilesSelection();">' . JText::_('No File Selected') . '</div>
                                            </div>
                                            <small class="fileSizeText">' . $config['document_file_type'] . '&nbsp;('.$config['document_file_size'].' KB)<br>'.JText::_('Maximum Uploads').' '.$config['document_max_files'].'</small>
                                            <small><strong>' . JText::_('You may also upload your resume file') . '</strong></small>
                                            <input type="hidden" maxlenght=""/>
                                            <input type="hidden" id="selectedFiles_required" name="selectedFiles_required" value="' . $files_required . '" />
                                        </div>
                                    </div>
                                    <div id="existingFiles" class="uploadedFiles js-col-md-10 js-col-lg-10 js-col-md-offset-1 js-col-lg-offset-1 js-col-xs-12"></div>';
                        }
                        break;
                    case "job_category":
                        if ($field->published == 1) {
                            $fieldValue = $resumelists['job_category'];
                            $data .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                        }
                        break;
                    case "job_subcategory":
                        if ($field->published == 1) {
                            $fieldValue = $resumelists['job_subcategory'];
                            $data .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                        }
                        break;
                    case "jobtype":
                        if ($field->published == 1) {
                            $fieldValue = $resumelists['jobtype'];
                            $data .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                        }
                        break;
                    case "nationality":
                        if ($field->published == 1) {
                            $fieldValue = $resumelists['nationality'];
                            $data .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                        }
                        break;
                    case "driving_license": 
                        if ($field->published == 1) {
                            $fieldValue = $resumelists['driving_license'];
                            $data .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                        }
                        break;
                    case "license_no": 
                        if ($field->published == 1) {
                            $fieldValue = isset($resume) ? $resume->license_no : "";
                            $data .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                        }
                        break;
                    case "license_country":
                        if ($field->published == 1) {
                            $fieldValue = $resumelists['license_country'];
                            $data .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                        }
                        break;
                    case "heighestfinisheducation":
                        if ($field->published == 1) {
                            $fieldValue = $resumelists['heighestfinisheducation'];
                            $data .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                        }
                        break;
                    case "total_experience":
                        if ($field->published == 1) {
                            $fieldValue = $resumelists['experienceid'];
                            if(!empty($resume->total_experience) && empty($resume->experienceid)){
                                $fieldValue .= '<div id="js-jobs-old-experience"><span class="experience">'.$resume->total_experience.'</span>'.JText::_('Please Select New Experience').'</div>';
                            }
                            $data .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                        }
                        break;
                    case "section_moreoptions":
                        $data .= '
                                <div class="js-row no-margin">
                                    <div class="js-resume-show-hide-btn js-col-lg-10 js-col-md-10 js-col-xs-12 js-col-lg-offset-1 js-col-md-offset-1 no-padding">
                                        <span id="show-more-basics" onclick="return showMoreBasics();">' . JText::_('Show More') . '</span>
                                    </div>
                                </div>
                                <div id="js-resume-more-options-container" class="js-row no-margin" style="display:none;">
                                    <div class="js-resume-more-options-Container js-col-lg-12 js-col-md-12 js-col-xs-12 no-padding">';
                        break;
                    case "home_phone":
                        if ($field->published == 1) {
                            if (isset($resume)) {
                                $fieldValue = $resume->home_phone;
                            } else {
                                $fieldValue = "";
                            }
                            $data .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                        }
                        break;
                    case "work_phone":
                        if ($field->published == 1) {
                            if (isset($resume)) {
                                $fieldValue = $resume->work_phone;
                            } else {
                                $fieldValue = "";
                            }
                            $data .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                        }
                        break;
                    case "date_of_birth":
                        if ($field->published == 1) {
                            $dateofbirth_required = ($field->required ? 'required' : '');
                            $data .= '
                                    <div class="js-row no-margin">
                                        <div class="js-resume-field-container js-col-lg-10 js-col-md-10 js-col-xs-12 js-col-lg-offset-1 js-col-md-offset-1 no-padding ">
                                            <label id="date_of_birthmsg" for="date_of_birth">' . JText::_($field->fieldtitle);
                            if ($field->required == 1) {
                                $data .= '<span class="error-msg">*</span>';
                            }
                            $data .= '</label>';
                            $date = (isset($resume) && $resume->date_of_birth != "0000-00-00 00:00:00") ? JHtml::_('date', $resume->date_of_birth, $config['date_format']) : '';
                            $data .= JHTML::_('calendar', $date, 'date_of_birth', 'date_of_birth', $js_dateformat, array('class' => 'inputbox validate-validatedateofbirth '.$dateofbirth_required, 'size' => '10', 'maxlength' => '19'));
                            $data .= '<input type="hidden" id="date_of_birth_required" name="date_of_birth_required" value="' . $dateofbirth_required . '">
                                        </div>
                                    </div>';
                        }
                        break;
                    case "date_start":
                        if ($field->published == 1) {
                            $date_start_required = ($field->required ? 'required' : '');
                            $data .= '
                                    <div class="js-row no-margin">
                                        <div class="js-resume-field-container js-col-lg-10 js-col-md-10 js-col-xs-12 js-col-lg-offset-1 js-col-md-offset-1 no-padding ">
                                            <label id="date_startmsg" for="date_start">' . JText::_($field->fieldtitle);
                            if ($field->required == 1) {
                                $data .= '<span class="error-msg">*</span>';
                            }
                            $data .= '</label>';
                            $date = (isset($resume) && $resume->date_start != "0000-00-00 00:00:00") ? JHtml::_('date', $resume->date_start, $config['date_format']) : '';
                            $data .= JHTML::_('calendar', $date, 'date_start', 'date_start', $js_dateformat, array('class' => 'inputbox validate-validatedateofbirth', 'size' => '10', 'maxlength' => '19'));
                            $data .= '<input type="hidden" id="date_start_required" name="date_start_required" value="' . $date_start_required . '">
                                        </div>
                                    </div>';
                        }
                        break;
                    case "searchable":
                        if ($field->published == 1) {
                            $fieldValue = isset($resume) ? $resume->searchable : "";
                            $data .= $this->getResumeFormField($field->fieldtitle,$field->field, $field->required, $fieldValue);
                        }
                        break;
                    case "iamavailable":
                        if ($field->published == 1) {
                            $fieldValue = isset($resume) ? $resume->iamavailable : "";
                            $data .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                        }
                        break;
                    case "start_date":
                        if ($field->published == 1) {
                            $startdate_required = ($field->required ? 'required' : '');
                            $startdatevalue = '';
                            if (isset($resume)) {
                                $startdatevalue = JHtml::_('date', $resume->date_start, $config['date_format']);
                            }
                            $data .= '
                            <div class="js-row no-margin">
                                <div class="js-resume-field-container js-col-lg-10 js-col-md-10 js-col-xs-12 js-col-lg-offset-1 js-col-md-offset-1 no-padding">
                                    <label id="date_startmsg" for="date_start">' . JText::_($field->fieldtitle);
                            if ($field->required == 1) {
                                $data .= '<span class="error-msg">*</span>';
                            }
                            $data .= '</label>';
                            if ((isset($resume)) && ($resume->date_start != "0000-00-00 00:00:00")) {
                                $data .= JHTML::_('calendar', JHtml::_('date', $resume->date_start, $config['date_format']), 'date_start', 'date_start', $js_dateformat, array('class' => 'inputbox validate-validatestartdate', 'size' => '10', 'maxlength' => '19'));
                            } else {
                                $data .= JHTML::_('calendar', '', 'date_start', 'date_start', $js_dateformat, array('class' => 'inputbox validate-validatestartdate', 'size' => '10', 'maxlength' => '19'));
                            }
                            $data .= '
                                    <input type="hidden" id="date_start_required" name="date_start_required" value="' . $startdate_required . '" />
                                </div>
                            </div>';
                        }
                        break;
                    case "salary":
                        if ($field->published == 1) {
                            $fieldValue = $resumelists['currencyid'] . $resumelists['jobsalaryrange'] . $resumelists['jobsalaryrangetypes'];
                            $data .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                        }
                        break;
                    case "desired_salary":
                        if ($field->published == 1) {
                            $fieldValue = $resumelists['dcurrencyid'] . $resumelists['desired_salary'] . $resumelists['djobsalaryrangetypes'];
                            $data .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                        }
                        break;
                    case "video":
                        if ($field->published == 1) {
                            $fieldValue = isset($resume) ? $resume->video : "";
                            $data .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                        }
                        break;
                    case "keywords":
                        if ($field->published == 1) {
                            $fieldValue = isset($resume) ? $resume->keywords : "";
                            $data .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                        }
                        break;
                    default:
                        $data .= $this->getResumeFormUserField($field, $resume , 1 , $customfieldobj);
                        break;
                }
            }
            $data .= '
                        </div>
                    </div>';

            if (!isset($uid) OR $uid == 0) {
                if (($config['resume_captcha'] == 1 OR $visitor['visitor'] == 1) && $captcha != false) {
                    //if ($config['captchause'] == 1) { // recaptcha is not working on form resume
                        $data .= '
                    <div class="js-row no-margin">
                        <div id="resumeCaptcha" class="js-resume-field-container js-col-lg-10 js-col-md-10 js-col-xs-12 js-col-lg-offset-1 js-col-md-offset-1 no-padding ">
                            <label id="captchamsg">' . JText::_('Captcha') . '<span class="error-msg">*</span></label>
                            ' . $captcha . '
                        </div>
                    </div>';
                    /*} else {
                        $data .= '
                    <div class="js-row no-margin">
                        <div class="js-resume-field-container js-col-lg-10 js-col-md-10 js-col-xs-12 js-col-lg-offset-1 js-col-md-offset-1 no-padding ">
                            <label id="captchamsg">' . JText::_('Captcha') . '<span class="error-msg">*</span></label>
                            <div id="dynamic_recaptcha_1"></div>
                        </div>
                    </div>';
                    }*/
                }
            }
            $isadmin = $_POST['isadmin'];
            if($isadmin == 1){
                $one = '';
                $two = '';
                $three = '';
                if(isset($resume->status)){
                    if($resume->status == 1){
                        $one = ' selected ';
                    }elseif($resume->status == 0){
                        $two = ' selected ';
                    }else{
                        $three = ' selected ';
                    }
                }
                $data .= '
                <div class="js-resume-field-container js-col-lg-10 js-col-md-10 js-col-xs-12 js-col-lg-offset-1 js-col-md-offset-1 no-padding ">
                        <label id="total_experiencemsg" for="total_experience">'.JText::_('Status').'</label>
                        <select id="status" name="status">
                            <option value="1" '.$one.'>'.JText::_('Approved').'</option>
                            <option value="0" '.$two.'>'.JText::_('Pending').'</option>
                            <option value="-1" '.$two.'>'.JText::_('Reject').'</option>
                        </select>
                    </div>
                    ';
            }
            $data .= '
                        <div class="js-row no-margin">
                            <div class="js-resume-submit-container js-col-lg-10 js-col-md-10 js-col-xs-12 js-col-lg-offset-1 js-col-md-offset-1 no-padding ">
                                <button type="submit" id="button" name="save_app" onclick="return submitResumeForm();" class="button validate delegateonclick">' . JText::_('Save Resume') . '</button>
                            </div>
                        </div>';
            if (isset($resume)) {
                if (($resume->created == '0000-00-00 00:00:00') || ($resume->created == ''))
                    $curdate = date('Y-m-d H:i:s');
                else
                    $curdate = $resume->created;
            }
            else {
                $curdate = date('Y-m-d H:i:s');
            }
            $data .= '
                    <input type="hidden" id="userfields_total" name="userfields_total"  value="' . $userfieldcount . '"  />
                    <input type="hidden" name="created" value="' . $curdate . '" />
                    <input type="hidden" id="id" name="id" value="';
            if (isset($resume)) {
                $data .= $resume->id;
            }
            if(isset($resume->uid))
                $uid = $resume->uid;
            $data.='" />
                    <input type="hidden" name="layout" value="empview" />
                    <input type="hidden" name="uid" value="' . $uid . '" />
                    <input type="hidden" name="isadmin" value="' . $isadmin . '" />
                    <input type="hidden" name="last_modified" value="" />
                    <input type="hidden" name="task" value="saveresume" />
                    <input type="hidden" name="datafor" value="personal" />
                    <input type="hidden" name="c" value="resume" />
                    <input type="hidden" name="check" value="" />
                    <input type="hidden" id="validated" name="validated" value="" />
                    <input type="hidden" name="Itemid" value="' . $Itemid . '" />
                    <input type="hidden" name="j_dateformat" id="j_dateformat" value="' . $js_scriptdateformat . '" />';
            if (isset($packagedetail[0]))
                $data .= '<input type="hidden" name="packageid" value="' . $packagedetail[0] . '" />';
            if (isset($packagedetail[1]))
                $data .= '<input type="hidden" name="paymenthistoryid" value="' . $packagedetail[1] . '" />';
            $data .= '
                    <input type="hidden" id="default_longitude" name="default_longitude" value="' . $config['default_longitude'] . '"/>
                    <input type="hidden" id="default_latitude" name="default_latitude" value="' . $config['default_latitude'] . '"/>
                </form>';
        }
        return $data;
    }

    function getAddressSectionLayout($addressResult, $currentAddress, $fieldsordering, $maxAddressForms, $existingAddresses, $packagedetail, $config, $userfield) { // used and created by muhiaudin for new resume form view
        $userfieldcount = 0;
        $resumeid = JRequest::getVar('resumeid');
        $addressid = JRequest::getVar('sectionid');
        $addressfor = JRequest::getVar('sectiontype');
        $user = JFactory::getUser();
        $uid = $user->id;
        $customfieldobj = getCustomFieldClass();

        $showAddAddressButton = 1;
        if ($existingAddresses >= $maxAddressForms) {
            if ($addressfor == 'form' && empty($addressid)) {
                $data = 'alert("' . JText::_('You can not add new address, you have added maximum addresses') . '")';
            }
            $showAddAddressButton = 0;
        }
        /*
        if ($addressfor == "view") {
            if (count($addressResult) == 0) {
                $showAddAddressButton = 0;
            }
        }
        */

        $session = JFactory::getSession();
        $config = $session->get('jsjobconfig_dft');
        $nav = JRequest::getVar('nav');

        $Itemid = JRequest::getVar('Itemid');

        $data = '';
        $section_address = 0;
        if ($fieldsordering[0]->field == 'section_address') {
            $section_address = $fieldsordering[0]->published;
            unset($fieldsordering[0]);
        }
        if ($section_address == 1) {
            if ($addressfor == 'view') {
                foreach ($addressResult as $address) {
                    $add_loccount = 0;
                    $data .= '<div id="address_' . $address->id . '" class="js-resume-address-section-view js-row no-margin">';
                    foreach ($fieldsordering AS $field) {
                        switch ($field->field) {
                            case 'address':
                                $data .= '<div class="addressheading js-col-lg-12 js-col-md-12 js-col-xs-12 no-padding">
                                    <span class="sectionText">' . $address->address . '</span>
                                </div>';
                                if (isset($uid) || $uid != 0) {
                                    $isadmin = $_POST['isadmin'];
                                    $data .= '
                                        <div class="edit-resume js-col-lg-1 js-col-md-1 js-col-xs-12 no-padding">
                                            <span onclick="return deleteResumeSection(\'' . $resumeid . '\', \'' . $address->id . '\',\'' . $isadmin . '\', \'address\');"><img src="' . JURI::root() . 'components/com_jsjobs/images/delete-icon.png"></span>
                                            <span onclick="return getResumeForm(\'' . $resumeid . '\', \'' . $address->id . '\', \'address\');"><img src="' . JURI::root() . 'components/com_jsjobs/images/edit-black.png"></span>
                                        </div>';
                                }
                                break;
                            case 'address_city':
                                if ($field->published == 1) {
                                    $data .= '
                                                <div class="addressvalue js-col-lg-12 js-col-md-12 js-col-xs-12 no-padding">
                                                    <span class="addressDetails">';
                                    $comma = '';
                                    $addresslayouttype = $config['defaultaddressdisplaytype'];
                                    if ($address->city != '') {
                                        $data .= $address->city;
                                        $comma = ', ';
                                    }
                                    switch ($addresslayouttype) {
                                        case 'csc':
                                            if ($address->state != '') {
                                                $data .= $comma . $address->state;
                                            }
                                            if ($address->country != '') {
                                                $data .= $comma . $address->country;
                                            }
                                            break;
                                        case 'cs':
                                            if ($address->state != '') {
                                                $data .= $comma . $address->state;
                                            }
                                            break;
                                        case 'cc':
                                            if ($address->country != '') {
                                                $data .= $comma . $address->country;
                                            }
                                            break;
                                    }
                                    $data .= '      </span>
                                                </div>';
                                }
                                break;
                            case "address_zipcode":
                                if ($field->published == 1) {
                                    $data .= '  <div class="addressvalue js-col-lg-12 js-col-md-12 js-col-xs-12 no-padding">
                                                    <span class="addressDetails">' . JText::_($field->fieldtitle) . ' ' . $address->address_zipcode . '</span>
                                                </div>';
                                }
                                break;
                            case "address":
                                if ($field->published == 1) {
                                    $address_address = ($address->address == '') ? 'N/A' : $address->address;
                                    $data .= '
                                            <div class="addressvalue js-col-lg-12 js-col-md-12 js-col-xs-12 no-padding">
                                                <span class="sectionText">' . $address_address . '</span>
                                            </div>';
                                }
                                break;
                            case "latitude":
                            case "longitude":
                            case "address_location":
                                if ($field->published == 1 && $add_loccount == 0) {
                                    $data .= '<input id="longitude_' . $address->id . '" type="hidden" name="longitude" value="' . $address->longitude . '" />
                                            <input id="latitude_' . $address->id . '" type="hidden" name="latitude" value="' . $address->latitude . '" />';
                                    if (isset($this->printresume) AND $this->printresume == 1) {
                                        $data .= '
                                        <div id="map_container_' . $address->id . '" class="map_container js-col-lg-12 js-col-md-12 js-col-xs-12 no-padding" style="display:none;">
                                            <div id="map_view_' . $address->id . '" class="map_view"></div>
                                        </div><script type="text/javascript">toggleMap(' . $address->id . ');</script>';
                                    } else {
                                        $data .= '
                                        <div class="map-toggler js-col-lg-12 js-col-md-12 js-col-xs-12 no-padding" onclick="return toggleMap(' . $address->id . ');">
                                            <span><img src="' . JURI::root() . 'components/com_jsjobs/images/show-map.png" /><span class="text">' . JText::_('Show Map') . '</span></span>
                                        </div>
                                        <div id="map_container_' . $address->id . '" class="map_container js-col-lg-12 js-col-md-12 js-col-xs-12 no-padding" style="display:none;">
                                            <div id="map_view_' . $address->id . '" class="map_view"></div>
                                        </div>';
                                    }
                                    $add_loccount++;
                                }
                                break;
                            default:
                                $data .= $this->getResumeUserField( $customfieldobj ,'', $userfield, $field ,$address, $address->id);
                                break;
                        }
                    }
                    $data .= '
                            </div>';
                }
                if ($addressResult == 0) {
                    $data .= '<div class="resume-section-no-record-found" id="section_address">'.JText::_('No record found').'...</div>';
                }
                if ($showAddAddressButton == 1) {
                    $data .= '
                        <div id="add-resume-address" onclick="return getResumeForm(' . $resumeid . ', -1, \'address\');" class="add-resume-form js-col-lg-12 js-col-md-12" no-padding>
                            <a href="javascript:void(0)"><img src="' . JURI::root() . 'components/com_jsjobs/images/add-circle.png" />' . JText::_('Add New Address') . '</a>
                        </div>';
                }
            } elseif ($addressfor == 'form') {
                $data = array('data' => '', 'city_id' => null, 'city_name' => null);
                if (isset($currentAddress) && count($currentAddress) != 0) {
                    $data['city_id'] = "" . $currentAddress->address_city . "";
                }
                if (isset($currentAddress) && count($currentAddress) != 0) {
                    $data['city_name'] = $currentAddress->city ;
                    switch ($config['defaultaddressdisplaytype']) {
                        case 'csc':
                            $data['city_name'] .= ", " . $currentAddress->state . ", " . $currentAddress->country;
                            break;
                        case 'cs':
                            $data['city_name'] .= ", " . $currentAddress->state;
                            break;
                        case 'cc':
                            $data['city_name'] .= ", " . $currentAddress->country;
                            break;
                    }
                }
                if (isset($currentAddress) && count($currentAddress) != 0) {
                    $formlang = JText::_('Edit Address');
                    $formcss = 'editform';
                }else{
                    $formlang = JText::_('Add Address');
                    $formcss = '';
                }
                $data['data'] .= '
                    <form action="index.php" method="post" name="resumeAddressForm" id="resumeAddressForm" class="jsautoz_form '.$formcss.'" enctype="multipart/form-data">';
                $data['data'] .= '<div class="jsjobsformheading">'.$formlang.'</div>';
                foreach ($fieldsordering as $field) {
                    switch ($field->field) {
                        case "address_city": $address_city_required = ($field->required ? 'required' : '');
                            $data['data'] .= '
                                <div class="js-row no-margin">
                                    <div class="js-resume-field-container js-col-lg-10 js-col-md-10 js-col-xs-12 js-col-lg-offset-1 js-col-md-offset-1 no-padding ">
                                        <label id="address_citymsg" for="address_city">' . JText::_($field->fieldtitle);
                            if ($field->required == 1) {
                                $data['data'] .= '<span class="error-msg">*</span>';
                            }
                            $data['data'] .= '</label>
                                        <input class="inputbox ' . $address_city_required . '" type="text" name="address_city" id="address_city" size="40" maxlength="100" value="" />
                                        <input class="inputbox" type="hidden" name="addresscityforedit" id="addresscityforedit" size="40" maxlength="100" value="';
                            if (isset($currentAddress) && count($currentAddress) != 0) {
                                $data['city_id'] = $currentAddress->address_city;
                                $data['city_name'] = $currentAddress->city ;
                                switch ($config['defaultaddressdisplaytype']) {
                                    case 'csc':
                                        $data['city_name'] .= ", " . $currentAddress->state . ", " . $currentAddress->country;
                                        break;
                                    case 'cs':
                                        $data['city_name'] .= ", " . $currentAddress->state;
                                        break;
                                    case 'cc':
                                        $data['city_name'] .= ", " . $currentAddress->country;
                                        break;
                                }
                                $data['data'] .= 1;
                            }
                            $data['data'] .= '" />
                                    </div>
                                </div>';
                            break;
                        case "address_zipcode":
                            if ($field->published == 1) {
                                if (isset($currentAddress) && count($currentAddress) != 0) {
                                    $fieldValue = $currentAddress->address_zipcode;
                                } else {
                                    $fieldValue = "";
                                }
                                $data['data'] .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                            }
                            break;
                        case "address":
                            if ($field->published == 1) {
                                if (isset($currentAddress) && count($currentAddress) != 0) {
                                    $fieldValue = $currentAddress->address;
                                } else {
                                    $fieldValue = "";
                                }
                                $data['data'] .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                            }
                            break;
                        case "address_location": //longitude and latitude 
                            if ($field->published == 1) {
                                $address_location_required = ($field->required ? 'required' : '');
                                $data['data'] .= '
                                <div class="js-row no-margin">
                                    <div class="js-resume-field-container loc-field js-col-lg-10 js-col-md-10 js-col-xs-12 js-col-lg-offset-1 js-col-md-offset-1 no-padding ">
                                        <label id="longitudemsg" for="longitude">' . JText::_($field->fieldtitle);
                                if ($field->required == 1) {
                                    $data['data'] .= '<span class="error-msg">*</span>';
                                }
                                $data['data'] .= '</label>
                                            <div id="outermapdiv">
                                                <div id="map" style="width:' . $config['mapwidth'] . 'px; height:' . $config['mapheight'] . 'px">
                                                    <div id="closetag"><a href="Javascript: hidediv();">' . JText::_('X') . '</a></div>
                                                    <div id="map_container"></div>
                                                </div>
                                            </div>
                                            <div class="location-container js-col-md-5 js-col-lg-5 js-col-xs-12 no-padding">
                                                <input  class="inputbox ' . $address_location_required . '" type="text" id="longitude" name="longitude" size="25" placeholder="' . JText::_('Longitude') . '" value = "';
                                if (isset($currentAddress->longitude)) {
                                    $data['data'] .= $currentAddress->longitude;
                                }
                                $data['data'] .= '" />
                                            </div>
                                            <div class="js-col-md-5 js-col-lg-5 js-col-xs-12 no-padding">
                                                <input  class="inputbox ' . $address_location_required . '" type="text" id="latitude" name="latitude" size="25" placeholder="' . JText::_('Latitude') . '" value = "';
                                if (isset($currentAddress->latitude))
                                    $data['data'] .= $currentAddress->latitude;
                                $data['data'] .= '" />
                                            </div>
                                            <a class="anchor map-link" href="Javascript: showdiv();loadMap();"><span id="anchor">' . JText::_('Map') . '</span></a>
                                        </div>
                                    </div>';
                            }
                            break;
                        default:
                            $currentAddressid = isset($currentAddress->id) ? $currentAddress->id : '';
                            $data['data'] .= $this->getResumeFormUserField($field, $currentAddress , 2 , $customfieldobj);
                            break;
                    }
                }
                $data['data'] .= '
                    <div class="js-row no-margin">
                        <div class="js-resume-submit-container js-col-lg-10 js-col-md-10 js-col-xs-12 js-col-lg-offset-1 js-col-md-offset-1 no-padding ">
                            <button type="submit" id="button" class="button delegateonclick" onclick="return submitResumeAddressForm();" name="save_app" >' . JText::_('Save Address') . '</button>
                            <button class="cancelForm delegateonclick" onclick="return cancelForm(\'' . $resumeid . '\', \'address\');">' . JText::_('Cancel') . '</button>
                        </div>
                    </div>';
                if (isset($currentAddress) && count($currentAddress) != 0) {
                    if (($currentAddress->created == '0000-00-00 00:00:00') || ($currentAddress->created == ''))
                        $curdate = date('Y-m-d H:i:s');
                    else
                        $curdate = $currentAddress->created;
                }else {
                    $curdate = date('Y-m-d H:i:s');
                }
                $data['data'] .= '
                        <input type="hidden" id="userfields_total" name="userfields_total"  value="' . $userfieldcount . '"  />
                        <input type="hidden" name="created" value="' . $curdate . '" />
                        <input type="hidden" id="id" name="id" value="';
                if (isset($currentAddress) && count($currentAddress) != 0) {
                    $data['data'] .= $currentAddress->id;
                }
                $data['data'] .= '" />
                        <input type="hidden" id="resumeid" name="resumeid" value="' . $resumeid . '" />
                        <input type="hidden" name="layout" value="formresume" />
                        <input type="hidden" name="created" value="' . date('Y-m-d H:i:s') . '" />
                        <input type="hidden" name="last_modified" value="' . date('Y-m-d H:i:s') . '" />
                        <input type="hidden" name="task" value="saveresumesection" />
                        <input type="hidden" name="datafor" value="address" />
                        <input type="hidden" name="c" value="resume" />
                        <input type="hidden" id="validated" name="validated" value="">
                        <input type="hidden" name="check" value="" />
                        <input type="hidden" name="Itemid" value="' . $Itemid . '" />
                        <input type="hidden" id="default_longitude" name="default_longitude" value="' . $config['default_longitude'] . '"/>
                        <input type="hidden" id="default_latitude" name="default_latitude" value="' . $config['default_latitude'] . '"/>
                    </form>';
                $data = json_encode($data);
            }
        }
        return $data;
    }

    function getInstituteSectionLayout($instituteResult, $currentInstitute, $fieldsordering, $maxInstituteForms, $existingInstitutes, $packagedetail, $config, $userfield) { // used and created by muhiaudin for new resume form view
        $userfieldcount = 0;
        $resumeid = JRequest::getVar('resumeid');
        $instituteid = JRequest::getVar('sectionid');
        $institutefor = JRequest::getVar('sectiontype');
        $user = JFactory::getUser();
        $uid = $user->id;
        $customfieldobj = getCustomFieldClass();
        $showAddInstituteButton = 1;
        if ($existingInstitutes >= $maxInstituteForms) {
            if ($institutefor == 'form' && empty($instituteid)) {
                $data = 'alert("' . JText::_('Added Max Institutes') . '")';
            }
            $showAddInstituteButton = 0;
        }
        /*
        if ($institutefor == "view") {
            if (count($instituteResult) == 0) {
                $showAddInstituteButton = 0;
            }
        }
        */

        $session = JFactory::getSession();
        $config = $session->get('jsjobconfig_dft');
        $nav = JRequest::getVar('nav');

        $Itemid = JRequest::getVar('Itemid');

        $big_field_width = 40;
        $med_field_width = 25;
        $sml_field_width = 15;
        $data = '';
        $section_institute = 0;
        if ($fieldsordering[0]->field == 'section_institute') {
            $section_institute = $fieldsordering[0]->published;
            unset($fieldsordering[0]);
        }
        if ($section_institute == 1) {
            if ($institutefor == 'view') {
                foreach ($instituteResult as $institute) {
                    $data .= '  <div id="institute_' . $institute->id . '" class="js-resume-data-section-view js-resume-institute-section-view js-row no-margin">';
                    foreach ($fieldsordering as $field) {
                        switch ($field->field) {
                            case "institute":
                                if ($field->published == 1) {
                                    $institute_institute = ($institute->institute != '') ? $institute->institute : 'N/A';
                                    $data .= '<div class="js-resume-data-head js-row no-margin">
                                                <div class="js-col-lg-10 js-col-md-10 no-padding">
                                                    <span class="data-head-name">' . $institute_institute . '</span>
                                                </div>';
                                    if (isset($uid) || $uid != 0) {
                                        $isadmin = $_POST['isadmin'];
                                        $data .= '
                                                        <div class="edit-resume-data js-col-lg-1 js-col-md-1 js-col-xs-12 no-padding">
                                                            <span onclick="return deleteResumeSection(\'' . $resumeid . '\', \'' . $institute->id . '\',\'' . $isadmin . '\', \'institute\');"><img src="' . JURI::root() . 'components/com_jsjobs/images/delete-icon.png"></span>
                                                            <span onclick="return getResumeForm(\'' . $resumeid . '\', \'' . $institute->id . '\', \'institute\');"><img src="' . JURI::root() . 'components/com_jsjobs/images/edit-black.png"></span>                                                        
                                                        </div>';
                                    }
                                    $data .= '</div>';
                                }
                                break;
                            case "institute_city":
                                $comma = '';
                                $addresslayouttype = $config['defaultaddressdisplaytype'];
                                $cityname = ($institute->city != '') ? $institute->city : 'N/A';
                                $data .= $this->getResumeField($field->fieldtitle, $cityname, $field->published);
                                switch ($addresslayouttype) {
                                    case 'csc':
                                        $statename = ($institute->state != '') ? $institute->state : 'N/A';
                                        $data .= $this->getResumeField(JText::_('State'), $statename, $field->published);
                                        $countryname = ($institute->country != '') ? $institute->country : 'N/A';
                                        $data .= $this->getResumeField(JText::_('Country'), $countryname, $field->published);
                                        break;
                                    case 'cs':
                                        $statename = ($institute->state != '') ? $institute->state : 'N/A';
                                        $data .= $this->getResumeField(JText::_('State'), $statename, $field->published);
                                        break;
                                    case 'cc':
                                        $countryname = ($institute->country != '') ? $institute->country : 'N/A';
                                        $data .= $this->getResumeField(JText::_('Country'), $countryname, $field->published);
                                        break;
                                }
                                break;
                            case "institute_address":
                                $data .= $this->getResumeField($field->fieldtitle, $institute->institute_address, $field->published);
                                break;
                            case "institute_certificate_name":
                                $data .= $this->getResumeField($field->fieldtitle, $institute->institute_certificate_name, $field->published);
                                break;
                            case "institute_study_area":
                                $data .= $this->getResumeField($field->fieldtitle, $institute->institute_study_area, $field->published);
                                break;
                            default:
                                $data .= $this->getResumeUserField( $customfieldobj ,'', $userfield, $field,$institute, $institute->id);
                                break;
                        }
                    }
                    $data .= '  </div>';
                }
                if ($existingInstitutes == 0) {
                    $data .= '<div class="resume-section-no-record-found" id="section_institute">'.JText::_('No record found').'...</div>';
                }
                if ($showAddInstituteButton == 1) {
                    $data .= '
                        <div id="add-resume-institute" onclick="return getResumeForm(' . $resumeid . ', -1, \'institute\');" class="add-resume-form js-col-lg-12 js-col-md-12" no-padding>
                            <a href="javascript:void(0)"><img src="' . JURI::root() . 'components/com_jsjobs/images/add-circle.png" />' . JText::_('Add New Education') . '</a>
                        </div>';
                }
            } elseif ($institutefor == 'form') {
                $data = array('data' => '', 'city_id' => null, 'city_name' => null);
                if (isset($currentInstitute) && count($currentInstitute) != 0) {
                    $data['city_id'] = "" . $currentInstitute->institute_city . "";
                }
                if (isset($currentInstitute) && count($currentInstitute) != 0) {
                    $data['city_name'] = $currentInstitute->city . ", " . $currentInstitute->state . ", " . $currentInstitute->country;
                }
                if (isset($currentInstitute) && count($currentInstitute) != 0) {
                    $formlang = JText::_('Edit Education');
                    $formcss = 'editform';
                }else{
                    $formlang = JText::_('Add Education');
                    $formcss = '';
                }
                $data['data'] .= '
                    <form action="index.php" method="post" name="resumeInstituteForm" id="resumeInstituteForm" class="jsautoz_form '.$formcss.'" enctype="multipart/form-data" onSubmit="return validateInstituteForm(this);">';
                $data['data'] .= '<div class="jsjobsformheading">'.$formlang.'</div>';
                foreach ($fieldsordering as $field) {
                    switch ($field->field) {
                        case "institute":
                            if ($field->published == 1) {
                                if (isset($currentInstitute) && count($currentInstitute) != 0) {
                                    $fieldValue = $currentInstitute->institute;
                                } else {
                                    $fieldValue = "";
                                }
                                $data['data'] .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                            }
                            break;
                        case "institute_city": $institute_city_required = ($field->required ? 'required' : '');
                            $data['data'] .= '
                                <div class="js-row no-margin">
                                    <div class="js-resume-field-container js-col-lg-10 js-col-md-10 js-col-xs-12 js-col-lg-offset-1 js-col-md-offset-1 no-padding ">
                                        <label id="institute_citymsg" for="institute_city">' . JText::_($field->fieldtitle);
                            if ($field->required == 1) {
                                $data['data'] .= '<span class="error-msg">*</span>';
                            }
                            $data['data'] .= '</label>
                                        <input class="inputbox ' . $institute_city_required . '" type="text" name="institute_city" id="institute_city" size="40" maxlength="100" value="" />
                                        <input class="inputbox" type="hidden" name="institutecityforedit" id="institutecityforedit" size="40" maxlength="100" value="';
                            if (isset($currentInstitute) && count($currentInstitute) != 0) {
                                $data['data'] .= $currentInstitute->institute_city;
                            }
                            $data['data'] .= '" />
                                    </div>
                                </div>';
                            break;
                        case "institute_address":
                            if ($field->published == 1) {
                                if (isset($currentInstitute) && count($currentInstitute) != 0) {
                                    $fieldValue = $currentInstitute->institute_address;
                                } else {
                                    $fieldValue = "";
                                }
                                $data['data'] .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                            }
                            break;
                        case "institute_certificate_name":
                            if ($field->published == 1) {
                                if (isset($currentInstitute) && count($currentInstitute) != 0) {
                                    $fieldValue = $currentInstitute->institute_certificate_name;
                                } else {
                                    $fieldValue = "";
                                }
                                $data['data'] .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                            }
                            break;
                        case "institute_study_area":
                            if ($field->published == 1) {
                                if (isset($currentInstitute) && count($currentInstitute) != 0) {
                                    $fieldValue = $currentInstitute->institute_study_area;
                                } else {
                                    $fieldValue = "";
                                }
                                $data['data'] .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                            }
                            break;
                        default:
                            $currentInstituteid = isset($currentInstitute->id) ? $currentInstitute->id : '';
                            $data['data'] .= $this->getResumeFormUserField($field, $currentInstitute , 3 , $customfieldobj);
                            break;
                    }
                }
                $data['data'] .= '
                    <div class="js-row no-margin">
                        <div class="js-resume-submit-container js-col-lg-10 js-col-md-10 js-col-xs-12 js-col-lg-offset-1 js-col-md-offset-1 no-padding ">
                            <button type="submit" id="button" class="button delegateonclick" onclick="return submitResumeInstituteForm();" name="save_app" >' . JText::_('Save Education') . '</button>
                            <button class="cancelForm delegateonclick" onclick="return cancelForm(\'' . $resumeid . '\', \'institute\');">' . JText::_('Cancel') . '</button>
                        </div>
                    </div>';
                if (isset($currentInstitute) && count($currentInstitute) != 0) {
                    if (($currentInstitute->created == '0000-00-00 00:00:00') || ($currentInstitute->created == ''))
                        $curdate = date('Y-m-d H:i:s');
                    else
                        $curdate = $currentInstitute->created;
                }else {
                    $curdate = date('Y-m-d H:i:s');
                }
                $data['data'] .= '
                        <input type="hidden" id="userfields_total" name="userfields_total"  value="' . $userfieldcount . '"  />
                        <input type="hidden" name="created" value="' . $curdate . '" />
                        <input type="hidden" id="id" name="id" value="';
                if (isset($currentInstitute) && count($currentInstitute) != 0) {
                    $data['data'] .= $currentInstitute->id;
                }
                $data['data'] .= '" />
                        <input type="hidden" id="resumeid" name="resumeid" value="' . $resumeid . '" />
                        <input type="hidden" name="layout" value="formresume" />
                        <input type="hidden" name="created" value="' . date('Y-m-d H:i:s') . '" />
                        <input type="hidden" name="last_modified" value="' . date('Y-m-d H:i:s') . '" />
                        <input type="hidden" name="task" value="saveresumesection" />
                        <input type="hidden" name="datafor" value="institute" />
                        <input type="hidden" name="c" value="resume" />
                        <input type="hidden" name="check" value="" />
                        <input type="hidden" id="validated" name="validated" value="">
                        <input type="hidden" name="Itemid" value="' . $Itemid . '" />
                    </form>';
                $data = json_encode($data);
            }
        }
        return $data;
    }

    function getEmployerSectionLayout($employerResult, $currentEmployer, $fieldsordering, $maxEmployerForms, $existingEmployers, $packagedetail, $config, $userfield) {
        $userfieldcount = 0;
        $resumeid = JRequest::getVar('resumeid');
        $employerid = JRequest::getVar('sectionid');
        $employerfor = JRequest::getVar('sectiontype');
        $user = JFactory::getUser();
        $uid = $user->id;
        $customfieldobj = getCustomFieldClass();

        $showAddEmployerButton = 1;
        if ($existingEmployers >= $maxEmployerForms) {
            if ($employerfor == 'form' && empty($employerid)) {
                $data = 'alert("' . JText::_('You can not add new employer, you have added maximum employers') . '")';
                $employerfor = 'view';
            }
            $showAddEmployerButton = 0;
        }
        /*
        if ($existingEmployers == 0) {
            $showAddEmployerButton = 0;
        }
        */

        $session = JFactory::getSession();
        $config = $session->get('jsjobconfig_dft');
        if(empty($config)){
            $config = JSModel::getJSModel('configurations')->getConfigByFor('default');
        }
        $nav = JRequest::getVar('nav');

        if ($config['date_format'] == 'm/d/Y')
            $dash = '/';
        else
            $dash = "-";
        $dateformat = $config['date_format'];
        $firstdash = strpos($dateformat, $dash, 0);
        $firstvalue = substr($dateformat, 0, $firstdash);
        $firstdash = $firstdash + 1;
        $seconddash = strpos($dateformat, $dash, $firstdash);
        $secondvalue = substr($dateformat, $firstdash, $seconddash - $firstdash);
        $seconddash = $seconddash + 1;
        $thirdvalue = substr($dateformat, $seconddash, strlen($dateformat) - $seconddash);
        $js_dateformat = '%' . $firstvalue . $dash . '%' . $secondvalue . $dash . '%' . $thirdvalue;
        $js_scriptdateformat = $firstvalue . $dash . $secondvalue . $dash . $thirdvalue;

        $Itemid = JRequest::getVar('Itemid');

        $big_field_width = 40;
        $med_field_width = 25;
        $sml_field_width = 15;

        $data = '';
        $section_employer = 0;
        if ($fieldsordering[0]->field == 'section_employer') {
            $section_employer = $fieldsordering[0]->published;
            unset($fieldsordering[0]);
        }
        if ($section_employer == 1) {
            if ($employerfor == 'view') {
                foreach ($employerResult as $employer) {
                    $data .= '  <div id="employer_' . $employer->id . '" class="js-resume-data-section-view js-resume-employer-section-view js-row no-margin">';
                    foreach ($fieldsordering as $field) {
                        switch ($field->field) {
                            case "employer":
                                if ($field->published == 1) {
                                    $data .= '
                                            <div class="js-resume-data-head js-row no-margin">
                                                <div class="js-col-lg-10 js-col-md-10 no-padding">
                                                    <span class="data-head-name">' . $employer->employer . '</span>
                                                </div>';
                                    if (isset($uid) || $uid != 0) {
                                        $isadmin = $_POST['isadmin'];
                                        $data .= '
                                                <div class="edit-resume-data js-col-lg-1 js-col-md-1 js-col-xs-12 no-padding">
                                                    <span onclick="return deleteResumeSection(\'' . $resumeid . '\', \'' . $employer->id . '\',\'' . $isadmin . '\', \'employer\');"><img src="' . JURI::root() . 'components/com_jsjobs/images/delete-icon.png"></span>
                                                    <span onclick="return getResumeForm(\'' . $resumeid . '\', \'' . $employer->id . '\', \'employer\');"><img src="' . JURI::root() . 'components/com_jsjobs/images/edit-black.png"></span>                                                
                                                </div>';
                                    }
                                    $data .= '</div>';
                                }
                                break;
                            case "employer_city":
                                if ($field->published == 1) {
                                    $comma = '';
                                    $addresslayouttype = $config['defaultaddressdisplaytype'];
                                    $cityname = ($employer->city != '') ? $employer->city : 'N/A';
                                    $data .= $this->getResumeField($field->fieldtitle, $cityname, $field->published);
                                    switch ($addresslayouttype) {
                                        case 'csc':
                                            $statename = ($employer->state != '') ? $employer->state : 'N/A';
                                            $data .= $this->getResumeField(JText::_('State'), $statename, $field->published);
                                            $countryname = ($employer->country != '') ? $employer->country : 'N/A';
                                            $data .= $this->getResumeField(JText::_('Country'), $countryname, $field->published);
                                            break;
                                        case 'cs':
                                            $statename = ($employer->state != '') ? $employer->state : 'N/A';
                                            $data .= $this->getResumeField(JText::_('State'), $statename, $field->published);
                                            break;
                                        case 'cc':
                                            $countryname = ($employer->country != '') ? $employer->country : 'N/A';
                                            $data .= $this->getResumeField(JText::_('Country'), $countryname, $field->published);
                                            break;
                                    }
                                }
                                break;
                            case "employer_address":
                                $data .= $this->getResumeField($field->fieldtitle, $employer->employer_address, $field->published);
                                break;
                            case "employer_position":
                                $data .= $this->getResumeField($field->fieldtitle, $employer->employer_position, $field->published);
                                break;
                            case "employer_resp":
                                $data .= $this->getResumeField($field->fieldtitle, $employer->employer_resp, $field->published);
                                break;
                            case "employer_pay_upon_leaving":
                                $data .= $this->getResumeField($field->fieldtitle, $employer->employer_pay_upon_leaving, $field->published);
                                break;
                            case "employer_supervisor":
                                $data .= $this->getResumeField($field->fieldtitle, $employer->employer_supervisor, $field->published);
                                break;
                            case "employer_from_date":
                                $date = JHTML::_('date', $employer->employer_from_date, $config['date_format']);
                                $data .= $this->getResumeField($field->fieldtitle, $date, $field->published);
                                break;
                            case "employer_to_date":
                                $date = JHTML::_('date', $employer->employer_to_date, $config['date_format']);
                                $data .= $this->getResumeField($field->fieldtitle, $date, $field->published);
                                break;
                            case "employer_leave_reason":
                                $data .= $this->getResumeField($field->fieldtitle, $employer->employer_leave_reason, $field->published);
                                break;
                            case "employer_zip":
                                $data .= $this->getResumeField($field->fieldtitle, $employer->employer_zip, $field->published);
                                break;
                            case "employer_phone":
                                $data .= $this->getResumeField($field->fieldtitle, $employer->employer_phone, $field->published);
                                break;
                            default:
                                $data .= $this->getResumeUserField( $customfieldobj ,'', $userfield, $field,$employer, $employer->id);
                                break;
                        }
                    }
                    $data .= '  </div>';
                }
                if ($existingEmployers == 0) {
                    $data .= '<div class="resume-section-no-record-found" id="section_employer">'.JText::_('No record found').'...</div>';
                }

                if ($showAddEmployerButton == 1) {
                    $data .= '
                        <div id="add-resume-employer" onclick="return getResumeForm(' . $resumeid . ', -1, \'employer\');" class="add-resume-form js-col-lg-12 js-col-md-12" no-padding>
                            <a href="javascript:void(0)"><img src="' . JURI::root() . 'components/com_jsjobs/images/add-circle.png" />' . JText::_('Add New Employer') . '</a>
                        </div>';
                }
            } elseif ($employerfor == 'form') {
                $data = array('data' => '', 'city_id' => null, 'city_name' => null);
                if (isset($currentEmployer) && count($currentEmployer) != 0) {
                    $data['city_id'] = "" . $currentEmployer->employer_city . "";
                }
                if (isset($currentEmployer) && count($currentEmployer) != 0) {
                    $data['city_name'] = $currentEmployer->city . ", " . $currentEmployer->state . ", " . $currentEmployer->country;
                }
                if (isset($currentEmployer) && count($currentEmployer) != 0) {
                    $formlang = JText::_('Edit Employer');
                    $formcss = 'editform';
                }else{
                    $formlang = JText::_('Add Employer');
                    $formcss = '';
                }
                $data['data'] .= '
                    <form action="index.php" method="post" name="resumeEmployerForm" id="resumeEmployerForm" class="jsautoz_form '.$formcss.'" enctype="multipart/form-data">';
                $data['data'] .= '<div class="jsjobsformheading">'.$formlang.'</div>';
                foreach ($fieldsordering as $field) {
                    switch ($field->field) {
                        case "employer":
                            if ($field->published == 1) {
                                if (isset($currentEmployer) && count($currentEmployer) != 0) {
                                    $fieldValue = $currentEmployer->employer;
                                } else {
                                    $fieldValue = "";
                                }
                                $data['data'] .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                            }
                            break;
                        case "employer_position":
                            if ($field->published == 1) {
                                if (isset($currentEmployer) && count($currentEmployer) != 0) {
                                    $fieldValue = $currentEmployer->employer_position;
                                } else {
                                    $fieldValue = "";
                                }
                                $data['data'] .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                            }
                            break;
                        case "employer_resp":
                            if ($field->published == 1) {
                                if (isset($currentEmployer) && count($currentEmployer) != 0) {
                                    $fieldValue = $currentEmployer->employer_resp;
                                } else {
                                    $fieldValue = "";
                                }
                                $data['data'] .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                            }
                            break;
                        case "employer_pay_upon_leaving":
                            if ($field->published == 1) {
                                if (isset($currentEmployer) && count($currentEmployer) != 0) {
                                    $fieldValue = $currentEmployer->employer_pay_upon_leaving;
                                } else {
                                    $fieldValue = "";
                                }
                                $data['data'] .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                            }
                            break;
                        case "employer_supervisor":
                            if ($field->published == 1) {
                                if (isset($currentEmployer) && count($currentEmployer) != 0) {
                                    $fieldValue = $currentEmployer->employer_supervisor;
                                } else {
                                    $fieldValue = "";
                                }
                                $data['data'] .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                            }
                            break;
                        default:
                            $currentEmployerid = isset($currentEmployer->id) ? $currentEmployer->id : '';
                            $data['data'] .= $this->getResumeFormUserField($field, $currentEmployer , 4 , $customfieldobj);
                            break;
                    }
                }
                $data['data'] .= '
                                <div class="js-row no-margin">
                                    <div class="js-resume-field-container js-col-lg-10 js-col-md-10 js-col-xs-12 js-col-lg-offset-1 js-col-md-offset-1 no-padding ">';
                foreach ($fieldsordering as $field) {
                    switch ($field->field) {
                        case "employer_from_date":
                            if ($field->published == 1) {
                                $employer_from_date_required = ($field->required ? 'required' : '');
                                $empfromdatevalue = '';
                                if (isset($currentEmployer) && count($currentEmployer) != 0)
                                    $empfromdatevalue = JHtml::_('date', $currentEmployer->employer_from_date, $config['date_format']);
                                $data['data'] .= '
                                        <div class="js-resume-field-container js-col-lg-4 js-col-md-4 js-col-xs-12 no-padding ">
                                            <label id="employer_from_datemsg" for="employer_from_date">' . JText::_($field->fieldtitle);
                                if ($field->required == 1) {
                                    $data['data'] .= '<span class="error-msg">*</span>';
                                }
                                $data['data'] .= '</label>';
                                if (isset($currentEmployer) && count($currentEmployer) != 0 && ($currentEmployer->employer_from_date != "0000-00-00 00:00:00")) {
                                    $data['data'] .= JHTML::_('calendar', JHtml::_('date', $currentEmployer->employer_from_date, $config['date_format']), 'employer_from_date', 'employer_from_date', $js_dateformat, array('class' => 'inputbox validate-employer_from_date', 'size' => '10', 'maxlength' => '19'));
                                } else {
                                    $data['data'] .= JHTML::_('calendar', '', 'employer_from_date', 'employer_from_date', $js_dateformat, array('class' => 'inputbox validate-employer_from_date', 'size' => '10', 'maxlength' => '19'));
                                }
                                $data['data'] .= '
                                            <input type="hidden" id="employer_from_date_required" name="employer_from_date_required" value="' . $employer_from_date_required . '">
                                        </div>';
                            }
                            break;
                        case "employer_to_date":
                            if ($field->published == 1) {
                                $employer_to_date_required = ($field->required ? 'required' : '');
                                $emptodatevalue = '';
                                if (isset($currentEmployer) && count($currentEmployer) != 0)
                                    $emptodatevalue = JHtml::_('date', $currentEmployer->employer_to_date, $config['date_format']);
                                $data['data'] .= '
                                        <div class="js-resume-field-container js-col-lg-4 js-col-md-4 js-col-xs-12 js-col-lg-offset-1 js-col-md-offset-1 no-padding ">
                                            <label id="employer_to_datemsg" for="employer_to_date">' . JText::_($field->fieldtitle);
                                if ($field->required == 1) {
                                    $data['data'] .= '<span class="error-msg">*</span>';
                                }
                                $data['data'] .= '</label>';
                                if (isset($currentEmployer) && count($currentEmployer) != 0 && ($currentEmployer->employer_to_date != "0000-00-00 00:00:00")) {
                                    $data['data'] .= JHTML::_('calendar', JHtml::_('date', $currentEmployer->employer_to_date, $config['date_format']), 'employer_to_date', 'employer_to_date', $js_dateformat, array('class' => 'inputbox validate-employer_to_date', 'size' => '10', 'maxlength' => '19'));
                                } else {
                                    $data['data'] .= JHTML::_('calendar', '', 'employer_to_date', 'employer_to_date', $js_dateformat, array('class' => 'inputbox validate-validatedateofbirth', 'size' => '10', 'maxlength' => '19'));
                                }
                                $data['data'] .= '
                                            <input type="hidden" id="employer_to_date_required" name="employer_to_date_required" value="' . $employer_to_date_required . '">
                                        </div>';
                            }
                            break;
                    }
                }
                $data['data'] .= '
                                    </div>
                                </div>';
                foreach ($fieldsordering as $field) {
                    switch ($field->field) {
                        case "employer_leave_reason":
                            if ($field->published == 1) {
                                if (isset($currentEmployer) && count($currentEmployer) != 0) {
                                    $fieldValue = $currentEmployer->employer_leave_reason;
                                } else {
                                    $fieldValue = "";
                                }
                                $data['data'] .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                            }
                            break;
                        case "employer_city": $employer_city_required = ($field->required ? 'required' : '');
                            $data['data'] .= '
                                <div class="js-row no-margin">
                                    <div class="js-resume-field-container js-col-lg-10 js-col-md-10 js-col-xs-12 js-col-lg-offset-1 js-col-md-offset-1 no-padding ">
                                        <label id="employer_citymsg" for="employer_city">' . JText::_($field->fieldtitle);
                            if ($field->required == 1) {
                                $data['data'] .= '<span class="error-msg">*</span>';
                            }
                            $data['data'] .= '</label>
                                        <input class="inputbox ' . $employer_city_required . '" type="text" name="employer_city" id="employer_city" size="40" maxlength="100" value="" />
                                        <input class="inputbox" type="hidden" name="employercityforedit" id="employercityforedit" size="40" maxlength="100" value="';
                            if (isset($currentEmployer) && count($currentEmployer) != 0) {
                                $data['data'] .= $currentEmployer->employer_city;
                            }
                            $data['data'] .= '" />
                                    </div>
                                </div>';
                            break;
                        case "employer_zip":
                            if ($field->published == 1) {
                                if (isset($currentEmployer) && count($currentEmployer) != 0) {
                                    $fieldValue = $currentEmployer->employer_zip;
                                } else {
                                    $fieldValue = "";
                                }
                                $data['data'] .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                            }
                            break;
                        case "employer_phone":
                            if ($field->published == 1) {
                                if (isset($currentEmployer) && count($currentEmployer) != 0) {
                                    $fieldValue = $currentEmployer->employer_phone;
                                } else {
                                    $fieldValue = "";
                                }
                                $data['data'] .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                            }
                            break;
                        case "employer_address":
                            if ($field->published == 1) {
                                if (isset($currentEmployer) && count($currentEmployer) != 0) {
                                    $fieldValue = $currentEmployer->employer_address;
                                } else {
                                    $fieldValue = "";
                                }
                                $data['data'] .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                            }
                            break;
                    }
                }
                $data['data'] .= '
                    <div class="js-row no-margin">
                        <div class="js-resume-submit-container js-col-lg-10 js-col-md-10 js-col-xs-12 js-col-lg-offset-1 js-col-md-offset-1 no-padding ">
                            <button type="submit" id="button" class="button delegateonclick" onclick="return submitResumeEmployerForm();" name="save_app" >' . JText::_('Save Employer') . '</button>
                            <button class="cancelForm delegateonclick" onclick="return cancelForm(\'' . $resumeid . '\', \'employer\');">' . JText::_('Cancel') . '</button>
                        </div>
                    </div>';
                if (isset($currentEmployer) && count($currentEmployer) != 0) {
                    if (($currentEmployer->created == '0000-00-00 00:00:00') || ($currentEmployer->created == ''))
                        $curdate = date('Y-m-d H:i:s');
                    else
                        $curdate = $currentEmployer->created;
                }else {
                    $curdate = date('Y-m-d H:i:s');
                }
                $data['data'] .= '
                        <input type="hidden" id="userfields_total" name="userfields_total"  value="' . $userfieldcount . '"  />
                        <input type="hidden" name="created" value="' . $curdate . '" />
                        <input type="hidden" id="id" name="id" value="';
                if (isset($currentEmployer) && count($currentEmployer) != 0) {
                    $data['data'] .= $currentEmployer->id;
                }
                $data['data'] .= '" />
                        <input type="hidden" id="resumeid" name="resumeid" value="' . $resumeid . '" />
                        <input type="hidden" name="layout" value="formresume" />
                        <input type="hidden" name="last_modified" value="' . date('Y-m-d H:i:s') . '" />
                        <input type="hidden" name="task" value="saveresumesection" />
                        <input type="hidden" name="datafor" value="employer" />
                        <input type="hidden" id="validated" name="validated" value="" />
                        <input type="hidden" name="c" value="resume" />
                        <input type="hidden" name="check" value="" />
                        <input type="hidden" name="Itemid" value="' . $Itemid . '" />
                    </form>';
                $data = json_encode($data);
            }
        }
        return $data;
    }

    function getSkillsSectionLayout($skills, $fieldsordering, $packagedetail, $config, $userfield) {
        $userfieldcount = 0;
        $resumeid = JRequest::getVar('resumeid');
        $skillsfor = JRequest::getVar('sectiontype');
        $user = JFactory::getUser();
        $uid = $user->id;
        $customfieldobj = getCustomFieldClass();

        $session = JFactory::getSession();
        $config = $session->get('jsjobconfig_dft');
        $nav = JRequest::getVar('nav');
        $big_field_width = 40;
        $Itemid = JRequest::getVar('Itemid');

        $data = '';
        $section_skills = 0;
        if ($fieldsordering[0]->field == 'section_skills') {
            $section_skills = $fieldsordering[0]->published;
            unset($fieldsordering[0]);
        }
        if ($section_skills == 1) {
            if ($skillsfor == 'view') {
                $data .= '  <div id="skills" class="js-resume-data-section-view js-resume-skill-section-view js-row no-margin">';
                foreach ($fieldsordering as $field) {
                    switch ($field->field) {
                        case "skills":
                            if ($field->published == 1) {
                                if ($skills->skills == '') {
                                    $skills->skills = 'N/A';
                                }
                                $data .= '<div class="js-row no-margin">
                                                    <div class="js-resume-data-title js-col-lg-3 js-col-md-3 no-padding">
                                                        <span>' . JText::_($field->fieldtitle) . '</span>
                                                    </div>
                                                    <div class="js-resume-skills-value js-col-lg-7 js-col-md-7 no-padding">
                                                        <div class="js-resume-data-value js-col-lg-10 js-col-md-10 no-padding">
                                                            <span>' . $skills->skills . '</span>
                                                        </div>
                                                    </div>';
                                if (isset($uid) || $uid != 0) {
                                    $data .= '
                                                                <div class="js-resume-skills-edit js-col-lg-1 js-col-md-1 js-col-xs-12 no-padding">
                                                                    <span onclick="return getResumeForm(\'' . $resumeid . '\', \'\', \'skills\');"><img src="' . JURI::root() . 'components/com_jsjobs/images/edit-black.png"></span>
                                                                </div>';
                                }
                                $data .= '</div>';
                            }
                            break;
                        default:
                            $data .= $this->getResumeUserField( $customfieldobj ,'', $userfield, $field, $skills);
                            break;
                    }
                }
                $data .= '</div>';
            } elseif ($skillsfor == 'form') {
                $data .= '
                    <form action="index.php" method="post" name="resumeSkillsForm" id="resumeSkillsForm" class="jsautoz_form">';
                foreach ($fieldsordering as $field) {
                    switch ($field->field) {
                        case "skills":
                            if ($field->published == 1) {
                                $skills_required = ($field->required ? 'required' : '');
                                $data .= '
                                    <div class="js-row no-margin">
                                        <div class="js-resume-field-container js-col-lg-10 js-col-md-10 js-col-xs-12 js-col-lg-offset-1 js-col-md-offset-1 no-padding ">
                                            <label id="skillsmsg" for="skills">' . JText::_($field->fieldtitle);
                                if ($field->required == 1) {
                                    $data .= '<span class="error-msg">*</span>';
                                }
                                $data .= '</label>
                                <textarea class="inputbox " name="skills" id="skills" cols="200" rows="1">';
                                if (isset($skills) && count($skills) != 0) {
                                    $data .= $skills->skills;
                                }$data .= '</textarea>
                                    <input type="hidden" id="skills_required" name="skills_required" value="' . $skills_required . '" />
                                </div>
                            </div>';
                            }
                            break;
                        default:
                            $data .= $this->getResumeFormUserField($field, $skills , 5 , $customfieldobj);
                            break;
                    }
                }
                $data .= '
                    <div class="js-row no-margin">
                        <div class="js-resume-submit-container js-col-lg-10 js-col-md-10 js-col-xs-12 js-col-lg-offset-1 js-col-md-offset-1 no-padding ">
                            <button type="submit" id="button" class="button delegateonclick" onclick="return submitResumeSkillsForm();" name="save_app" >' . JText::_('Save Skills') . '</button>
                            <button class="cancelForm delegateonclick" onclick="return cancelForm(\'' . $resumeid . '\', \'skills\');">' . JText::_('Cancel') . '</button>
                        </div>
                    </div>';
                if (isset($skills) && count($skills) != 0) {
                    if (($skills->created == '0000-00-00 00:00:00') || ($skills->created == ''))
                        $curdate = date('Y-m-d H:i:s');
                    else
                        $curdate = $skills->created;
                }else {
                    $curdate = date('Y-m-d H:i:s');
                }
                $data .= '
                        <input type="hidden" id="userfields_total" name="userfields_total"  value="' . $userfieldcount . '"  />
                        <input type="hidden" name="created" value="' . $curdate . '" />
                        <input type="hidden" id="id" name="id" value="';
                if (isset($skills) && count($skills) != 0) {
                    $data .= $skills->id;
                }
                $data .= '" />
                        <input type="hidden" id="resumeid" name="resumeid" value="' . $resumeid . '" />
                        <input type="hidden" name="layout" value="formresume" />
                        <input type="hidden" name="created" value="' . $curdate . '" />
                        <input type="hidden" name="last_modified" value="' . $curdate . '" />
                        <input type="hidden" name="task" value="saveresume" />
                        <input type="hidden" name="datafor" value="skills" />
                        <input type="hidden" name="c" value="resume" />
                        <input type="hidden" id="validated" name="validated" value="">
                        <input type="hidden" name="check" value="" />
                        <input type="hidden" name="Itemid" value="' . $Itemid . '" />
                    </form>';
            }
        }

        return $data;
    }

    function getResumeSectionLayout($resume, $fieldsordering, $packagedetail, $config, $userfield) {
        $userfieldcount = 0;
        $resumeid = JRequest::getVar('resumeid');
        $resumefor = JRequest::getVar('sectiontype');
        $user = JFactory::getUser();
        $uid = $user->id;
        $session = JFactory::getSession();
        $config = $session->get('jsjobconfig_dft');
        $nav = JRequest::getVar('nav');
        $Itemid = JRequest::getVar('Itemid');
        $customfieldobj = getCustomFieldClass();
        $big_field_width = 40;
        $med_field_width = 25;
        $sml_field_width = 15;

        $data = '';
        $section_resume = 0;
        if ($fieldsordering[0]->field == 'section_resume') {
            $section_resume = $fieldsordering[0]->published;
            unset($fieldsordering[0]);
        }
        if ($section_resume == 1) {
            if ($resumefor == 'view') {
                $data .= '<div id="editorView" class="js-resume-editor-section-view js-resume-editor-section-view js-row no-margin">';
                $data .= '<div id="" class="js-resume-data-section-view js-resume-skill-section-view js-row no-margin">';
                foreach ($fieldsordering AS $field) {
                    switch ($field->field) {
                        case 'resume':
                            if ($field->published == 1) {
                                $data .= '';
                                $data .= '<div class="resumeditor js-col-lg-12 js-col-md-12 js-col-xs-12 no-padding">';
                                if (isset($uid) || $uid != 0) {
                                    $data .= '
                                                        <div class="edit-resume js-col-lg-1 js-col-md-1 js-col-xs-12 no-padding">
                                                            <span onclick="return getResumeForm(\'' . $resumeid . '\', \'\', \'editor\');"><img src="' . JURI::root() . 'components/com_jsjobs/images/edit-black.png"></span>
                                                        </div>';
                                }
                                $data .= '<span class="resumeEditorValue">' . $resume->resume . '</span>
                                            </div>
                                        ';
                            }
                            break;
                        default:
                            $data .= $this->getResumeUserField( $customfieldobj ,'', $userfield, $field,$resume);
                            break;
                    }
                }
                $data .= '</div></div>';
            } elseif ($resumefor == 'form') {
                $data = '';
                $data .= '
                    <form action="index.php" method="post" name="resumeEditorForm" id="resumeEditorForm" class="jsautoz_form">';
                foreach ($fieldsordering as $field) {
                    switch ($field->field) {
                        case "resume":
                            if ($field->published == 1) {
                                $resume_required = ($field->required ? 'required' : '');
                                $data .= '
                                    <div class="js-row no-margin">
                                        <div class="js-resume-field-container js-col-lg-10 js-col-md-10 js-col-xs-12 js-col-lg-offset-1 js-col-md-offset-1 no-padding ">
                                            <label id="skillsmsg" for="skills">' . JText::_($field->fieldtitle);
                                if ($field->required == 1) {
                                    $data .= '<span class="error-msg">*</span>';
                                }
                                $data .= '</label>';

                                // $resumeEditor = JFactory::getEditor();
                                // if (isset($resume->resume) && count($resume) != 0)
                                //     $data .= $resumeEditor->display('resume', $resume->resume, '100%', '100%', '60', '20', false);
                                // else
                                //     $data .= $resumeEditor->display('resume', '', '100%', '100%', '60', '20', false);
                                $resumevalue = '';
                                if (isset($resume->resume) && count($resume) != 0){
                                    $resumevalue = $resume->resume;
                                }
                                $data .= '<textarea id="resume" name="resume" >'.$resumevalue.'</textarea>';

                                $data .= '
                                    <input type="hidden" id="editor_required" name="editor_required" value="' . $resume_required . '" />
                                </div>
                            </div>';
                            }
                            break;
                        default:
                            $data .= $this->getResumeFormUserField($field, $resume , 6 , $customfieldobj);
                            break;
                    }
                }
                $data .= '
                    <div class="js-row no-margin">
                        <div class="js-resume-submit-container js-col-lg-10 js-col-md-10 js-col-xs-12 js-col-lg-offset-1 js-col-md-offset-1 no-padding ">
                            <button type="submit" id="button" class="button delegateonclick" onclick="return submitResumeEditorForm();" name="save_app" >' . JText::_('Save Resume') . '</button>
                            <button class="cancelForm delegateonclick" onclick="return cancelForm(\'' . $resumeid . '\', \'editor\');">' . JText::_('Cancel') . '</button>
                        </div>
                    </div>';
                if (isset($resume)) {
                    if (($resume->created == '0000-00-00 00:00:00') || ($resume->created == ''))
                        $curdate = date('Y-m-d H:i:s');
                    else
                        $curdate = $resume->created;
                }else {
                    $curdate = date('Y-m-d H:i:s');
                }
                $data .= '
                        <input type="hidden" id="userfields_total" name="userfields_total"  value="' . $userfieldcount . '"  />
                        <input type="hidden" name="created" value="' . $curdate . '" />
                        <input type="hidden" id="id" name="id" value="';
                if (isset($resume)) {
                    $data .= $resume->id;
                }
                $data .= '" />
                        <input type="hidden" id="resumeid" name="resumeid" value="' . $resumeid . '" />
                        <input type="hidden" name="layout" value="formresume" />
                        <input type="hidden" name="created" value="' . $curdate . '" />
                        <input type="hidden" name="last_modified" value="' . $curdate . '" />
                        <input type="hidden" name="task" value="saveresume" />
                        <input type="hidden" name="datafor" value="resume" />
                        <input type="hidden" name="c" value="resume" />
                        <input type="hidden" id="validated" name="validated" value="">
                        <input type="hidden" name="check" value="" />
                        <input type="hidden" name="Itemid" value="' . $Itemid . '" />
                    </form>';
            }
        }
        return $data;
    }

    function getReferenceSectionLayout($referenceResult, $currentReference, $fieldsordering, $maxReferenceForms, $existingReferences, $packagedetail, $config, $userfield) {
        $userfieldcount = 0;
        $resumeid = JRequest::getVar('resumeid');
        $referenceid = JRequest::getVar('sectionid');
        $referencefor = JRequest::getVar('sectiontype');
        $user = JFactory::getUser();
        $uid = $user->id;
        $customfieldobj = getCustomFieldClass();

        $showAddReferenceButton = 1;
        if ($existingReferences >= $maxReferenceForms) {
            if ($referencefor == 'form' && empty($referenceid)) {
                $data = 'alert("' . JText::_('You can not add new reference, you have added maximum references') . '")';
                $referencefor = 'view';
            }
            $showAddReferenceButton = 0;
        }
        /*
        if ($existingReferences == 0) {
            $showAddReferenceButton = 0;
        }
        */

        $session = JFactory::getSession();
        $config = $session->get('jsjobconfig_dft');
        if(empty($config)){
            $config = JSModel::getJSModel('configurations')->getConfigByFor('default');
        }
        $nav = JRequest::getVar('nav');

        if ($config['date_format'] == 'm/d/Y')
            $dash = '/';
        else
            $dash = "-";
        $dateformat = $config['date_format'];
        $firstdash = strpos($dateformat, $dash, 0);
        $firstvalue = substr($dateformat, 0, $firstdash);
        $firstdash = $firstdash + 1;
        $seconddash = strpos($dateformat, $dash, $firstdash);
        $secondvalue = substr($dateformat, $firstdash, $seconddash - $firstdash);
        $seconddash = $seconddash + 1;
        $thirdvalue = substr($dateformat, $seconddash, strlen($dateformat) - $seconddash);
        $js_dateformat = '%' . $firstvalue . $dash . '%' . $secondvalue . $dash . '%' . $thirdvalue;
        $js_scriptdateformat = $firstvalue . $dash . $secondvalue . $dash . $thirdvalue;

        $Itemid = JRequest::getVar('Itemid');
        $big_field_width = 40;
        $med_field_width = 25;
        $sml_field_width = 15;

        $data = '';
        $section_references = 0;
        if ($fieldsordering[0]->field == 'section_reference') {
            $section_references = $fieldsordering[0]->published;
            unset($fieldsordering[0]);
        }
        if ($section_references == 1) {
            if ($referencefor == 'view') {
                foreach ($referenceResult as $reference) {
                    $data .= '  <div id="reference_' . $reference->id . '" class="js-resume-data-section-view js-resume-reference-section-view js-row no-margin">';
                    foreach ($fieldsordering as $field) {
                        switch ($field->field) {
                            case "reference":
                                if ($field->published == 1) {
                                    $data .= '<div class="js-resume-data-head js-row no-margin">
                                                <div class="js-col-lg-10 js-col-md-10 no-padding">
                                                    <span class="data-head-name">' . $reference->reference . '</span>
                                                </div>';
                                    if (isset($uid) || $uid != 0) {
                                        $isadmin = $_POST['isadmin'];
                                        $data .= '<div class="edit-resume-data js-col-lg-1 js-col-md-1 js-col-xs-12 no-padding">
                                                    <span onclick="return deleteResumeSection(\'' . $resumeid . '\', \'' . $reference->id . '\',\'' . $isadmin . '\', \'reference\');"><img src="' . JURI::root() . 'components/com_jsjobs/images/delete-icon.png"></span>
                                                    <span onclick="return getResumeForm(\'' . $resumeid . '\', \'' . $reference->id . '\', \'reference\');"><img src="' . JURI::root() . 'components/com_jsjobs/images/edit-black.png"></span>                                                
                                                </div>';
                                    }
                                    $data .= '</div>';
                                }
                                break;
                            case "reference_city":
                                $comma = '';
                                $addresslayouttype = $config['defaultaddressdisplaytype'];
                                $cityname = ($reference->city != '') ? $reference->city : 'N/A';
                                $data .= $this->getResumeField($field->fieldtitle, $cityname, $field->published);
                                switch ($addresslayouttype) {
                                    case 'csc':
                                        $statename = ($reference->state != '') ? $reference->state : 'N/A';
                                        $data .= $this->getResumeField(JText::_('State'), $statename, $field->published);
                                        $countryname = ($reference->country != '') ? $reference->country : 'N/A';
                                        $data .= $this->getResumeField(JText::_('Country'), $countryname, $field->published);
                                        break;
                                    case 'cs':
                                        $statename = ($reference->state != '') ? $reference->state : 'N/A';
                                        $data .= $this->getResumeField(JText::_('State'), $statename, $field->published);
                                        break;
                                    case 'cc':
                                        $countryname = ($reference->country != '') ? $reference->country : 'N/A';
                                        $data .= $this->getResumeField(JText::_('Country'), $countryname, $field->published);
                                        break;
                                }
                                break;
                            case "reference_name":
                                $data .= $this->getResumeField($field->fieldtitle, $reference->reference_name, $field->published);
                                break;
                            case "reference_zipcode":
                                $data .= $this->getResumeField($field->fieldtitle, $reference->reference_zipcode, $field->published);
                                break;
                            case "reference_address":
                                $data .= $this->getResumeField($field->fieldtitle, $reference->reference_address, $field->published);
                                break;
                            case "reference_phone":
                                $data .= $this->getResumeField($field->fieldtitle, $reference->reference_phone, $field->published);
                                break;
                            case "reference_relation":
                                $data .= $this->getResumeField($field->fieldtitle, $reference->reference_relation, $field->published);
                                break;
                            case "reference_years":
                                $data .= $this->getResumeField($field->fieldtitle, $reference->reference_years, $field->published);
                                break;
                            default:
                                $data .= $this->getResumeUserField( $customfieldobj ,'', $userfield, $field,$reference, $reference->id);
                                break;
                        }
                    }
                    $data .= '  </div>';
                }
                if ($existingReferences == 0) {
                    $data .= '<div class="resume-section-no-record-found" id="section_reference">'.JText::_('No record found').'...</div>';
                }
                if ($showAddReferenceButton == 1) {
                    $data .= '
                        <div id="add-resume-reference" onclick="return getResumeForm(' . $resumeid . ', -1, \'reference\');" class="add-resume-form js-col-lg-12 js-col-md-12" no-padding>
                            <a href="javascript:void(0)"><img src="' . JURI::root() . 'components/com_jsjobs/images/add-circle.png" />' . JText::_('Add New Reference') . '</a>
                        </div>';
                }
            } elseif ($referencefor == 'form') {
                $data = array('data' => '', 'city_id' => null, 'city_name' => null);
                if (isset($currentReference) && count($currentReference) != 0) {
                    $data['city_id'] = "" . $currentReference->reference_city . "";
                }
                if (isset($currentReference) && count($currentReference) != 0) {
                    $data['city_name'] = $currentReference->city . ", " . $currentReference->state . ", " . $currentReference->country;
                }
                if (isset($currentReference) && count($currentReference) != 0) {
                    $formlang = JText::_('Edit Reference');
                    $formcss = 'editform';
                }else{
                    $formlang = JText::_('Add Reference');
                    $formcss = '';
                }
                $data['data'] .= '
                    <form action="index.php" method="post" name="resumeReferenceForm" id="resumeReferenceForm" class="jsautoz_form '.$formcss.'">';
                $data['data'] .= '<div class="jsjobsformheading">'.$formlang.'</div>';
                foreach ($fieldsordering as $field) {
                    switch ($field->field) {
                        case "reference":
                            if ($field->published == 1) {
                                if (isset($currentReference) && count($currentReference) != 0) {
                                    $fieldValue = $currentReference->reference;
                                } else {
                                    $fieldValue = "";
                                }
                                $data['data'] .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                            }
                            break;
                        case "reference_name":
                            if ($field->published == 1) {
                                if (isset($currentReference) && count($currentReference) != 0) {
                                    $fieldValue = $currentReference->reference_name;
                                } else {
                                    $fieldValue = "";
                                }
                                $data['data'] .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                            }
                            break;
                        case "reference_city": $reference_city_required = ($field->required ? 'required' : '');
                            $data['data'] .= '
                                <div class="js-row no-margin">
                                    <div class="js-resume-field-container js-col-lg-10 js-col-md-10 js-col-xs-12 js-col-lg-offset-1 js-col-md-offset-1 no-padding ">
                                        <label id="reference_citymsg" for="reference_city">' . JText::_($field->fieldtitle);
                            if ($field->required == 1) {
                                $data['data'] .= '<span class="error-msg">*</span>';
                            }
                            $data['data'] .= '</label>
                                        <input class="inputbox ' . $reference_city_required . '" type="text" name="reference_city" id="reference_city" size="40" maxlength="100" value="" />
                                        <input class="inputbox" type="hidden" name="referencecityforedit" id="referencecityforedit" size="40" maxlength="100" value="';
                            if (isset($currentReference) && count($currentReference) != 0) {
                                $data['data'] .= $currentReference->reference_city;
                            }
                            $data['data'] .= '" />
                                    </div>
                                </div>';
                            break;
                        case "reference_zipcode":
                            if ($field->published == 1) {
                                if (isset($currentReference) && count($currentReference) != 0) {
                                    $fieldValue = $currentReference->reference_zipcode;
                                } else {
                                    $fieldValue = "";
                                }
                                $data['data'] .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                            }
                            break;
                        case "reference_address":
                            if ($field->published == 1) {
                                if (isset($currentReference) && count($currentReference) != 0) {
                                    $fieldValue = $currentReference->reference_address;
                                } else {
                                    $fieldValue = "";
                                }
                                $data['data'] .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                            }
                            break;
                        case "reference_phone":
                            if ($field->published == 1) {
                                if (isset($currentReference) && count($currentReference) != 0) {
                                    $fieldValue = $currentReference->reference_phone;
                                } else {
                                    $fieldValue = "";
                                }
                                $data['data'] .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                            }
                            break;
                        case "reference_relation":
                            if ($field->published == 1) {
                                if (isset($currentReference) && count($currentReference) != 0) {
                                    $fieldValue = $currentReference->reference_relation;
                                } else {
                                    $fieldValue = "";
                                }
                                $data['data'] .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                            }
                            break;
                        case "reference_years":
                            if ($field->published == 1) {
                                if (isset($currentReference) && count($currentReference) != 0) {
                                    $fieldValue = $currentReference->reference_years;
                                } else {
                                    $fieldValue = "";
                                }
                                $data['data'] .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                            }
                            break;
                        default:
                            $currentReferenceid = isset($currentReference->id) ? $currentReference->id : '';
                            $data['data'] .= $this->getResumeFormUserField($field, $currentReference , 7 , $customfieldobj);
                            break;
                    }
                }
                $data['data'] .= '
                    <div class="js-row no-margin">
                        <div class="js-resume-submit-container js-col-lg-10 js-col-md-10 js-col-xs-12 js-col-lg-offset-1 js-col-md-offset-1 no-padding ">
                            <button type="submit" id="button" class="button delegateonclick" onclick="return submitResumeReferenceForm();" name="save_app" >' . JText::_('Save Reference') . '</button>
                            <button class="cancelForm delegateonclick" onclick="return cancelForm(\'' . $resumeid . '\', \'reference\');">' . JText::_('Cancel') . '</button>
                        </div>
                    </div>';
                if (isset($currentReference) && count($currentReference) != 0) {
                    if (($currentReference->created == '0000-00-00 00:00:00') || ($currentReference->created == ''))
                        $curdate = date('Y-m-d H:i:s');
                    else
                        $curdate = $currentReference->created;
                }else {
                    $curdate = date('Y-m-d H:i:s');
                }
                $data['data'] .= '
                        <input type="hidden" id="userfields_total" name="userfields_total"  value="' . $userfieldcount . '"  />
                        <input type="hidden" name="created" value="' . $curdate . '" />
                        <input type="hidden" id="id" name="id" value="';
                if (isset($currentReference) && count($currentReference) != 0) {
                    $data['data'] .= $currentReference->id;
                }
                $data['data'] .= '" />
                        <input type="hidden" id="resumeid" name="resumeid" value="' . $resumeid . '" />
                        <input type="hidden" name="layout" value="formresume" />
                        <input type="hidden" name="last_modified" value="' . date('Y-m-d H:i:s') . '" />
                        <input type="hidden" name="task" value="saveresumesection" />
                        <input type="hidden" name="datafor" value="reference" />
                        <input type="hidden" id="validated" name="validated" value="" />
                        <input type="hidden" name="c" value="resume" />
                        <input type="hidden" name="check" value="" />
                        <input type="hidden" name="Itemid" value="' . $Itemid . '" />
                    </form>';
                $data = json_encode($data);
            }
        }
        return $data;
    }

    function getLanguageSectionLayout($languageResult, $currentLanguage, $fieldsordering, $maxLanguageForms, $existingLanguages, $packagedetail, $config, $userfield) {
        $userfieldcount = 0;
        $resumeid = JRequest::getVar('resumeid');
        $languageid = JRequest::getVar('sectionid');
        $languagefor = JRequest::getVar('sectiontype');
        $user = JFactory::getUser();
        $uid = $user->id;
        $customfieldobj = getCustomFieldClass();

        $showAddLanguageButton = 1;
        if ($existingLanguages >= $maxLanguageForms) {
            if ($languagefor == 'form' && empty($languageid)) {
                $data = 'alert("' . JText::_('You can not add new language, you have added maximum languages') . '")';
                $languagefor = 'view';
            }
            $showAddLanguageButton = 0;
        }
        /*
        if ($existingLanguages == 0) {
            $showAddLanguageButton = 0;
        }
        */

        $session = JFactory::getSession();
        $config = $session->get('jsjobconfig_dft');
        $nav = JRequest::getVar('nav');

        $Itemid = JRequest::getVar('Itemid');

        $big_field_width = 40;
        $med_field_width = 25;
        $sml_field_width = 15;

        $data = '';
        $section_language = 0;
        if ($fieldsordering[0]->field == 'section_language') {
            $section_language = $fieldsordering[0]->published;
            unset($fieldsordering[0]);
        }
        if ($section_language == 1) {
            if ($languagefor == 'view') {
                foreach ($languageResult as $language) {
                    $data .= '  <div id="language_' . $language->id . '" class="js-resume-data-section-view js-resume-language-section-view js-row no-margin">';
                    foreach ($fieldsordering as $field) {
                        switch ($field->field) {
                            case "language":
                                if ($field->published == 1) {
                                    $data .= '<div class="js-resume-data-head js-row no-margin">
                                                    <div class="js-col-lg-10 js-col-md-10 no-padding">
                                                        <span class="data-head-name">' . $language->language . '</span>
                                                    </div>';
                                    if (isset($uid) || $uid != 0) {
                                        $isadmin = $_POST['isadmin'];
                                        $data .= '
                                                                <div class="edit-resume-data js-col-lg-1 js-col-md-1 js-col-xs-12 no-padding">
                                                                <span onclick="return deleteResumeSection(\'' . $resumeid . '\', \'' . $language->id . '\',\'' . $isadmin . '\', \'language\');"><img src="' . JURI::root() . 'components/com_jsjobs/images/delete-icon.png"></span>
                                                                <span onclick="return getResumeForm(\'' . $resumeid . '\', \'' . $language->id . '\', \'language\');"><img src="' . JURI::root() . 'components/com_jsjobs/images/edit-black.png"></span>                                                                
                                                                </div>';
                                    }
                                    $data .= '</div>';
                                }
                                break;
                            case "language_reading":
                                $data .= $this->getResumeField($field->fieldtitle, $language->language_reading, $field->published);
                                break;
                            case "language_writing":
                                $data .= $this->getResumeField($field->fieldtitle, $language->language_writing, $field->published);
                                break;
                            case "language_understanding":
                                $data .= $this->getResumeField($field->fieldtitle, $language->language_understanding, $field->published);
                                break;
                            case "language_where_learned":
                                $data .= $this->getResumeField($field->fieldtitle, $language->language_where_learned, $field->published);
                                break;
                            default:
                                $data .= $this->getResumeUserField( $customfieldobj ,'', $userfield, $field,$language, $language->id);
                                break;
                        }
                    }
                    $data .= '  </div>';
                }

                if ($existingLanguages == 0) {
                    $data .= '<div class="resume-section-no-record-found" id="section_language">'.JText::_('No record found').'...</div>';
                }

                if ($showAddLanguageButton == 1) {
                    $data .= '
                        <div id="add-resume-language" onclick="return getResumeForm(' . $resumeid . ', -1, \'language\');" class="add-resume-form js-col-lg-12 js-col-md-12" no-padding>
                            <a href="javascript:void(0)"><img src="' . JURI::root() . 'components/com_jsjobs/images/add-circle.png" />' . JText::_('Add New Language') . '</a>
                        </div>';
                }
            } elseif ($languagefor == 'form') {
                if (isset($currentLanguage) && count($currentLanguage) != 0) {
                    $language = JText::_('Edit Language');
                    $formcss = 'editform';
                }else{
                    $language = JText::_('Add Language');
                    $formcss = '';
                }
                $data .= '
                    <form action="index.php" method="post" name="resumeLanguageForm" id="resumeLanguageForm" class="jsautoz_form '.$formcss.'" onSubmit="return validateLanguageForm(this);">';
                $data .= '<div class="jsjobsformheading">'.$language.'</div>';
                foreach ($fieldsordering as $field) {
                    switch ($field->field) {
                        case "language":
                            if ($field->published == 1) {
                                if (isset($currentLanguage) && count($currentLanguage) != 0) {
                                    $fieldValue = $currentLanguage->language;
                                } else {
                                    $fieldValue = "";
                                }
                                $data .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                            }
                            break;
                        case "language_reading":
                            if ($field->published == 1) {
                                if (isset($currentLanguage) && count($currentLanguage) != 0) {
                                    $fieldValue = $currentLanguage->language_reading;
                                } else {
                                    $fieldValue = "";
                                }
                                $data .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                            }
                            break;
                        case "language_writing": $language_writing_required = ($field->required ? 'required' : '');
                            if ($field->published == 1) {
                                if (isset($currentLanguage) && count($currentLanguage) != 0) {
                                    $fieldValue = $currentLanguage->language_writing;
                                } else {
                                    $fieldValue = "";
                                }
                                $data .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                            }
                            break;
                        case "language_understanding":
                            if ($field->published == 1) {
                                if (isset($currentLanguage) && count($currentLanguage) != 0) {
                                    $fieldValue = $currentLanguage->language_understanding;
                                } else {
                                    $fieldValue = "";
                                }
                                $data .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                            }
                            break;
                        case "language_where_learned":
                            if ($field->published == 1) {
                                if (isset($currentLanguage) && count($currentLanguage) != 0) {
                                    $fieldValue = $currentLanguage->language_where_learned;
                                } else {
                                    $fieldValue = "";
                                }
                                $data .= $this->getResumeFormField($field->fieldtitle, $field->field, $field->required, $fieldValue);
                            }
                            break;
                        default:
                            $currentLanguageid = isset($currentLanguage->id) ? $currentLanguage->id : '';
                            $data .= $this->getResumeFormUserField($field, $currentLanguage , 8 , $customfieldobj);
                            break;
                    }
                }

                $data .= '
                    <div class="js-row no-margin">
                        <div class="js-resume-submit-container js-col-lg-10 js-col-md-10 js-col-xs-12 js-col-lg-offset-1 js-col-md-offset-1 no-padding ">
                            <button type="submit" id="button" class="button delegateonclick" onclick="return submitResumeLanguageForm();" name="save_app" >' . JText::_('Save Language') . '</button>
                            <button class="cancelForm delegateonclick" onclick="return cancelForm(\'' . $resumeid . '\', \'language\');">' . JText::_('Cancel') . '</button>
                        </div>
                    </div>';
                if (isset($currentLanguage) && count($currentLanguage) != 0) {
                    if (($currentLanguage->created == '0000-00-00 00:00:00') || ($currentLanguage->created == ''))
                        $curdate = date('Y-m-d H:i:s');
                    else
                        $curdate = $currentLanguage->created;
                }else {
                    $curdate = date('Y-m-d H:i:s');
                }
                $data .= '
                        <input type="hidden" id="userfields_total" name="userfields_total"  value="' . $userfieldcount . '"  />
                        <input type="hidden" name="created" value="' . $curdate . '" />
                        <input type="hidden" id="id" name="id" value="';
                if (isset($currentLanguage) && count($currentLanguage) != 0) {
                    $data .= $currentLanguage->id;
                }
                $data .= '" />
                        <input type="hidden" id="resumeid" name="resumeid" value="' . $resumeid . '" />
                        <input type="hidden" name="layout" value="formresume" />
                        <input type="hidden" name="last_modified" value="' . date('Y-m-d H:i:s') . '" />
                        <input type="hidden" name="task" value="saveresumesection" />
                        <input type="hidden" name="datafor" value="language" />
                        <input type="hidden" id="validated" name="validated" value="" />
                        <input type="hidden" name="c" value="resume" />
                        <input type="hidden" name="check" value="" />
                        <input type="hidden" name="Itemid" value="' . $Itemid . '" />
                    </form>';
            }
        }
        return $data;
    }

    function getResumeFormField($fieldtitle, $fieldName, $required, $fieldValue) {

        if ($fieldName == 'gender' || $fieldName == 'total_experience' || $fieldName == 'license_country'  || $fieldName == 'driving_license' || $fieldName == 'job_category' || $fieldName == 'job_subcategory' || $fieldName == 'jobtype' || $fieldName == 'nationality' || $fieldName == 'salary' || $fieldName == 'desired_salary' || $fieldName == 'heighestfinisheducation') {
            $data = '
                <div class="js-row no-margin">
                    <div class="js-resume-field-container js-col-lg-10 js-col-md-10 js-col-xs-12 js-col-lg-offset-1 js-col-md-offset-1 no-padding ">
                        <label id="' . $fieldName . 'msg" for="' . $fieldName . '">' . JText::_($fieldtitle);
            if ($required == 1) {
                $data .= '<span class="error-msg">*</span>';
            }
            $data .= '
                        </label>' . $fieldValue .
                    '<input type="hidden" id="' . $fieldName . '_required" name="' . $fieldName . '_required" value="' . $required . '" />
                    </div>
                </div>';
        } elseif ($fieldName == 'searchable' || $fieldName == 'iamavailable') {
            $data = '
                <div class="js-resume-checkbox-container js-resume-checkbox-container-inner js-col-lg-3 js-col-md-3 js-col-xs-12 js-col-lg-offset-1 js-col-md-offset-1 no-padding">
                    <div class="checkbox-field js-col-md-2 js-col-lg-2 no-padding">
                        <input type="checkbox" name="' . $fieldName . '" id="' . $fieldName . '" value="1"';
            if (isset($fieldValue)) {
                $data .= ($fieldValue == 1) ? "checked='checked'" : "";
            } else {
                $data .= "checked=\'checked\'";
            }
            if ($fieldValue == 1) {
                $data.= "checked='checked'";
            }
            $data .= '" />
                        <input type="hidden" id="' . $fieldName . '_required" name="' . $fieldName . '_required" value="';
            if ($required == 1) {
                $data .= 1;
            } $data .= '" />
                    </div>
                    <div class="checkbox-field-label js-col-md-10 js-col-lg-10 no-padding">
                        <label id="' . $fieldName . 'msg" for="' . $fieldName . '">' . JText::_($fieldtitle);
            if ($required == 1) {
                $data .= '<span class="error-msg">*</span>';
            }
            $data .= '</label>
                    </div>
                </div>';
        } else {
            $data = '
                <div class="js-row no-margin">
                    <div class="js-resume-field-container js-col-lg-10 js-col-md-10 js-col-xs-12 js-col-lg-offset-1 js-col-md-offset-1 no-padding ">
                        <label id="' . $fieldName . 'msg" for="' . $fieldName . '">';
            if ($fieldName == "institute_certificate_name") {
                $data .= JText::_('Cert/deg/oth');
            } else {
                $data .= JText::_($fieldtitle);
            }
            if ($required == 1) {
                $data .= '<span class="error-msg">*</span>';
            }
            $data .= '</label>
                        <input class="inputbox' . $required;
            if ($required == 1) {
                $data .= ' required';
            } if ($fieldName == "email_address") {
                $data .= ' validate-email"';
            } else {
                $data .='"';
            } $data .= ' type="text" name="' . $fieldName . '" id="' . $fieldName . '" maxlength="250" value = "' . $fieldValue . '" />
                        <input type="hidden" id="' . $fieldName . '_required" name="' . $fieldName . '_required" value="' . $required . '" />
                    </div>
                </div>';
        }
        return $data;
    }

    function getResumeFormUserField($field, $object , $section , $customfieldobj ) {
        $id = isset($object->id)  ? $object->id : NULL;
        $params = isset($object->params) ? $object->params : NULL;
        $data = NULL;
        $result = $customfieldobj->formCustomFields($field , $id , $params, 1 , $section);

        if( isset($result['value'])){
            $data .= '  <div class="js-row no-margin">
                            <div class="js-resume-field-container js-col-lg-10 js-col-md-10 js-col-xs-12 js-col-lg-offset-1 js-col-md-offset-1 no-padding ">';
            $data .= '          <label id="msg" for="" >';
            $data .=                JText::_($result['title']);
                                    if($field->required == 1){
            $data .= '                  <span class="error-msg">*</span>';
                                    }
            $data .= '          </label>';
            $data .=            $result['value'];
            $data .= '      </div>
                        </div>';            
        }
        return $data;
    }

    function getResumeFilesLayout($files, $data_directory) {
        $resumeid = JRequest::getVar('resumeid');
        $printresume = JRequest::getVar('printresume');
        $filesfor = JRequest::getVar('filesfor');
        if (empty($resumeid)) {
            return false;
        }
        if (empty($filesfor)) {
            $filesfor = "form";
        }
        $path = JURI::root() . $data_directory . '/data/jobseeker/resume_' . $resumeid . '/resume/';
        $returnValue = '';
        if (!$files || empty($files)) {
            if ($resumeid != -1) {
                $returnValue .= '';
            }
        } else {
            if ($filesfor == "form") {
                foreach ($files as $file) {
                    $selectedFilename = substr($file->filename, 0, 4);
                    $fileExt = substr($file->filename, strrpos($file->filename, '.') + 1);
                    $returnValue .= '<span id="' . $file->id . '" class="selectedFile">' . $selectedFilename . '.. .' . $fileExt . '<a href="javascript:void(0);" onclick="return deleteResumeFile(' . $file->id . ', ' . $resumeid . ')"><img src="' . JURI::root() . 'components/com_jsjobs/images/delete.png" height="10px" width="10px" /></a></span>';
                }
            }
            if ($filesfor == 'popup') {
                foreach ($files as $file) {
                    $returnValue .= '
                            <div id="' . $file->id . '" class="chosenFile js-row no-margin">
                                <div class="js-col-lg-12 js-col-md-12 no-padding">
                                    <div class="js-row no-margin">
                                        <span class="uploadFileName">' . $file->filename . '</span>
                                        <span id="' . $file->id . '" class="deleteUploadedFile" onclick="return deleteResumeFile(' . $file->id . ', ' . $resumeid . ')"><img src="' . JURI::root() . 'components/com_jsjobs/images/delete.png" height="15px" width="15px" /></span>
                                    </div>
                                </div>
                            </div>';
                }
            }
            if ($filesfor == 'view') {
                if ($printresume == 1) {
                    $returnValue .= '<ul>';
                } else {
                    $returnValue .= '<ul><a title="'.JText::_('Download All').'" class="zip-downloader" href="' . JURI::root() . 'index.php?option=com_jsjobs&c=resume&task=getallresumefiles&resumeid=' . $resumeid . '" onclick="" target="_blank"><img src="' . JURI::root() . 'components/com_jsjobs/images/download-all.png"></a>';
                }
                foreach ($files as $file) {
                    $selectedFilename = substr($file->filename, 0, 4);
                    $fileExt = substr($file->filename, strrpos($file->filename, '.') + 1);
                    $returnValue .= '<li id="' . $file->id . '" class="selectedFile" title="' . $file->filename . '">' . $selectedFilename . '.. .' . $fileExt;
                    if ($printresume != 1) {
                        $returnValue .= '<a target="_blank" href="' . $path . $file->filename . '" alt=""><img src="' . JURI::root() . 'components/com_jsjobs/images/download.png" height="15px" width="15px" /></a></li>';
                    }
                }
                $returnValue .= '</ul>';
            }
        }
        return $returnValue;
    }

    function getResumeField($fieldtitle, $fieldvalue, $published) {
        $data = '';
        if ($published == 1) {
            $data .= '
                    <div class="js-row no-margin">
                        <div class="js-resume-data-title js-col-lg-3 js-col-md-3 js-col-xs-3 no-padding">
                            <span>' . JText::_($fieldtitle) . ':</span>
                        </div>
                        <div class="js-resume-data-value js-col-lg-8 js-col-md-8 js-col-xs-8 no-padding">
                            <span>' . $fieldvalue . '</span>
                        </div>
                    </div>';
        }
        return $data;
    }

    function getResumeUserField( $customfieldobj ,$isjobsharing, $userfields, $field, $params, $subreferenceid = null) {
        $data = '';
        if ($isjobsharing != "") {
            if (is_object($userfields)) {
                for ($k = 0; $k < 15; $k++) {
                    $isodd = 1 - $isodd;
                    $field_title = 'fieldtitle_' . $k;
                    $field_value = 'fieldvalue_' . $k;
                    if (!empty($thisjob->userfields->$field_title) && $thisjob->userfields->$field_title != null) {
                        $data .= '  <div class="js-row no-margin">
                                        <div class="js-resume-data-title js-col-lg-3 js-col-md-3 js-col-xs-3 no-padding">
                                            <span>' . JText::_($thisjob->userfields->$field_title) . '</span>
                                        </div>
                                        <div class="js-resume-data-value js-col-lg-8 js-col-md-8 js-col-xs-8 no-padding">
                                            ' . $thisjob->userfields->$field_value . '
                                        </div>
                                    </div>';
                    }
                }
            }
        } else {
            $field = $field->field;
            $arr = $customfieldobj->showCustomFields($field, 11 ,$params);
            if(!$arr)
                return '';
            $title = $arr['title'];
            $value = $arr['value'];
            $data .= ' <div class="js-row no-margin">
                                <div class="js-resume-data-title js-col-lg-3 js-col-md-3 js-col-xs-3 no-padding">
                                    <span>' . JText::_($title) . ':</span>
                                </div>';
            $data .= ' <div class="js-resume-data-value js-col-lg-8 js-col-md-8 js-col-xs-8 no-padding">
                            ' . $value . '
                        </div>
            </div>';
            
        }
        return $data;
    }
}
?>