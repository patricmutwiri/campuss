<?php
/**
 * @Copyright Copyright (C) 2009-2010 Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:     Buruj Solutions
 + Contact:     www.burujsolutions.com , info@burujsolutions.com
 * Created on:  Nov 22, 2010
 ^
 + Project:     JS Jobs
 ^ 
 */

// no direct access
defined('_JEXEC') or die('Restricted access');


jimport('joomla.application.component.view');

class JSJobsViewReport extends JSView {

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
        if ($layoutName == 'resume1') {
            require_once(JPATH_ROOT . '/components/com_jsjobs/models/resume.php');
            if (isset($user->groups[8]) OR isset($user->groups[7])) {
                $isadmin = 1;
            }
            $resumeid = JRequest::getVar('rd', '');
            $myresume = JRequest::getVar('nav', '');
            $folderid = JRequest::getVar('fd', '');
            $sortvalue = $sort = JRequest::getVar('sortby', false);
            $tabaction = JRequest::getVar('ta', false);
            $show_only_section_that_have_value = $this->getJSModel('configuration')->getConfigValue('show_only_section_that_have_value');
            $resumeid = JRequest::getVar('rd');
            if (is_numeric($resumeid) == true) {
                $resume_object = new JSJobsModelResume();
                $result = $resume_object->getResumeViewbyId($uid, false, $resumeid, $myresume, $sort, $tabaction);
            }
            $this->assignRef('resume', $result['personal']);
            $this->assignRef('addresses', $result['addresses']);
            $this->assignRef('institutes', $result['institutes']);
            $this->assignRef('employers', $result['employers']);
            $this->assignRef('skills', $result['skills']);
            $this->assignRef('editor', $result['editor']);
            $this->assignRef('references', $result['references']);
            $this->assignRef('languages', $result['languages']);
            $this->assignRef('fieldsordering', $result['fieldsordering']);
            $this->assignRef('userfields', $result['userfields']);
            $user = JFactory::getUser();
            $this->assignRef('isadmin', $isadmin);
        }
        $this->assignRef('config', $config);
        $document = JFactory::getDocument();
        $document->setTitle('Resume');
        parent::display();
    }

}

?>
