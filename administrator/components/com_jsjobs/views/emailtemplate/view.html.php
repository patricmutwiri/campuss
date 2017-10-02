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

jimport('joomla.application.component.view');
jimport('joomla.html.pagination');

class JSJobsViewEmailTemplate extends JSView {

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout start
        if ($layoutName == 'emailtemplate') {          // email template
            $templatefor = JRequest::getVar('tf');
            switch ($templatefor) {
                case 'ew-cm' : $text = JText::_('New Company');
                    break;
                case 'cm-ap' : $text = JText::_('Company Approval');
                    break;
                case 'cm-rj' : $text = JText::_('Company Rejection');
                    break;
                case 'ew-ob' : $text = JText::_('New Job (Admin)');
                    break;
                case 'ew-ob-em' : $text = JText::_('New Job (Employer)');
                    break;
                case 'ob-ap' : $text = JText::_('Job Approval');
                    break;
                case 'ob-rj' : $text = JText::_('Job Rejecting');
                    break;
                case 'ap-rs' : $text = JText::_('Applied Resume Status');
                    break;
                case 'ew-rm' : $text = JText::_('New Resume');
                    break;
                case 'rm-ap' : $text = JText::_('Resume Approval');
                    break;
                case 'rm-rj' : $text = JText::_('Resume Rejecting');
                    break;
                case 'ba-ja' : $text = JText::_('Job Apply');
                    break;
                case 'ew-md' : $text = JText::_('New Department');
                    break;
                case 'ew-rp' : $text = JText::_('Employer Buy Package');
                    break;
                case 'ew-js' : $text = JText::_('Job Seeker Buy Package');
                    break;
                case 'ms-sy' : $text = JText::_('Message');
                    break;
                case 'jb-at' : $text = JText::_('Job Alert');
                    break;
                case 'jb-at-vis' : $text = JText::_('Employer Visitor Job');
                    break;
                case 'jb-to-fri' : $text = JText::_('Job To Friend');
                    break;
                case 'jb-pkg-pur' : $text = JText::_('Job Seeker Package Purchased');
                    break;
                case 'emp-pkg-pur' : $text = JText::_('Employer Package Purchased');
                    break;
                case 'ew-rm-vis' : $text = JText::_('New Resume Visitor');
                    break;
                case 'cm-dl' : $text = JText::_('Company Delete');
                    break;
                case 'ob-dl' : $text = JText::_('Job Delete');
                    break;
                case 'rm-dl' : $text = JText::_('Resume Delete');
                    break;
                case 'js-ja' : $text = JText::_('Job Apply Jobseeker');
                    break;
            }
            JToolBarHelper::title(JText::_('Email Templates') . ' <small><small>[' . $text . '] </small></small>');
            JToolBarHelper::save('emailtemplate.saveemailtemplate');
            $template = $this->getJSModel('emailtemplate')->getTemplate($templatefor);
            $this->assignRef('template', $template);
            $this->assignRef('templatefor', $templatefor);
        }elseif($layoutName == 'emailtemplateoptions'){
            JToolBarHelper::title(JText::_('Email Template Options'));
            $options = $this->getJSModel('emailtemplate')->getEmailTemplateOptionsForView();
            $this->assignRef('options', $options);
        }
//        layout end

        $this->assignRef('config', $config);
        $this->assignRef('application', $application);
        $this->assignRef('theme', $theme);
        $this->assignRef('option', $option);
        $this->assignRef('uid', $uid);
        $this->assignRef('msg', $msg);
        $this->assignRef('isjobsharing', $_client_auth_key);

        parent::display($tpl);
    }

}

?>
