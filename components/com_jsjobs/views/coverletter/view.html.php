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

class JSJobsViewCoverLetter extends JSView {

    function display($tpl = null) {
        require_once(JPATH_COMPONENT . '/views/common.php');
        $viewtype = 'html';

        if ($layout == 'formcoverletter') {            // form cover letter
            $page_title .= ' - ' . JText::_('Cover Letter Form');
            if (isset($_GET['cl']))
                $letterid = $_GET['cl'];
            else
                $letterid = null;
            $letterid = $this->getJSModel('common')->parseId(JRequest::getVar('cl', ''));
            $result = $this->getJSModel('coverletter')->getCoverLetterbyId($letterid, $uid);
            $this->assignRef('coverletter', $result[0]);
            $this->assignRef('canaddnewcoverletter', $result[4]);
            JHTML::_('behavior.formvalidation');
        } elseif ($layout == 'mycoverletters') {            // my cover letters
            $page_title .= ' - ' . JText::_('My Cover Letters');
            $mycoverletter_allowed = $this->getJSModel('permissions')->checkPermissionsFor("MY_COVER_LETTER");
            if ($mycoverletter_allowed == VALIDATE) {
                $result = $this->getJSModel('coverletter')->getMyCoverLettersbyUid($uid, $limit, $limitstart);
                $this->assignRef('coverletters', $result[0]);
                if ($result[1] <= $limitstart)
                    $limitstart = 0;
                $pagination = new JPagination($result[1], $limitstart, $limit);
                $this->assignRef('pagination', $pagination);
            }
            $this->assignRef('mycoverletter_allowed', $mycoverletter_allowed);
        }elseif ($layout == 'view_coverletter') {            // view cover letter
            $page_title .= ' - ' . JText::_('View Cover Letter');
            $letterid = $this->getJSModel('common')->parseId(JRequest::getVar('cl', ''));
            $result = $this->getJSModel('coverletter')->getCoverLetterbyId($letterid, null);
            $this->assignRef('coverletter', $result[0]);
            $nav = JRequest::getVar('nav', '');
            $this->assignRef('nav', $nav);
            $jobaliasid = JRequest::getVar('bd', '');
            $this->assignRef('jobaliasid', $jobaliasid);
            $resumealiasid = JRequest::getVar('rd', '');
            $this->assignRef('resumealiasid', $resumealiasid);
        }
        require_once('coverletter_breadcrumbs.php');
        $document->setTitle($page_title);
        $this->assignRef('userrole', $userrole);
        $this->assignRef('config', $config);
        $this->assignRef('option', $option);
        $this->assignRef('params', $params);
        $this->assignRef('viewtype', $viewtype);
        $this->assignRef('employerlinks', $employerlinks);
        $this->assignRef('jobseekerlinks', $jobseekerlinks);
        $this->assignRef('uid', $uid);
        $this->assignRef('id', $id);
        $this->assignRef('Itemid', $itemid);
        $this->assignRef('isjobsharing', $_client_auth_key);

        parent::display($tpl);
    }

}

?>
