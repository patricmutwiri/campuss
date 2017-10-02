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

class JSJobsViewOutput extends JSView {

    function display($tpl = NULL) {
        require_once(JPATH_COMPONENT . '/views/common.php');
        $viewtype = 'pdf';
        if ($layout == 'resumepdf') {
            $resumeid = $this->getJSModel('common')->parseId(JRequest::getVar('rd', ''));
            $myresume = 6; // hard code b/c here we go for the pdf output
            $folderid = JRequest::getVar('fd', '');
            $sortvalue = $sort = JRequest::getVar('sortby', false);
            $tabaction = JRequest::getVar('ta', false);
            $show_only_section_that_have_value = $this->getJSModel('configurations')->getConfigValue('show_only_section_that_have_value');
            if (is_numeric($resumeid) == true) {
                $resume_model = $this->getJSModel('resume');
                $result = $resume_model->getResumeViewbyId($uid, false, $resumeid, $myresume, $sort, $tabaction);
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
        }
        $this->assignRef('config', $config);
        $document = JFactory::getDocument();
        $document->setTitle('Resume');
        parent::display();
    }

}

?>
