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

class JSJobsViewResume extends JSView {

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
        if($layoutName == 'formresume') { //form resume
            require_once (JPATH_ROOT.'/components/com_jsjobs/models/resume.php');
            $resumeModel = new JSJobsModelResume();
            $resumeid = JRequest::getVar('resumeid', '');
            if($resumeid == ''){
                $resumeid = JRequest::getVar('cid');
                $resumeid = $resumeid[0];
            }
            if (isset($resumeid)) $isNew = false;
            $fieldsordering = $this->getJSModel('fieldordering')->getFieldsOrderingforForm(3);
            $resumecountresult = $resumeModel->getResumeDataCountById($resumeid);
            $validresume = true;
            if(is_numeric($resumeid)){
				$validresume = $resumeModel->checkResumeExists($resumeid);
			}
            $this->assignRef('validresume',$validresume);
            $callfrom = JRequest::getVar('callfrom','empapps');
            $this->assignRef('callfrom',$callfrom);
            $this->assignRef('resumecountresult',$resumecountresult);
            $this->assignRef('fieldsordering', $fieldsordering);
            $this->assignRef('resumeid', $resumeid);
            $isadmin = 1;
            $this->assignRef('isadmin', $isadmin);
            $text = $isNew ? JText::_('Add') : JText::_('Edit');
            JToolBarHelper::title(JText::_('Resume') . ': <small><small>[ ' . $text . ' ]</small></small>');
        }elseif ($layoutName == 'appqueue') {  //app queue
            JToolBarHelper::title(JText::_('Resume Approval Queue'));
            $form = 'com_jsjobs.appqueue.list.';
            $datafor = 2;
            $resumetitle = $mainframe->getUserStateFromRequest($form.'resumetitle','resumetitle','','string');
            $resumename = $mainframe->getUserStateFromRequest($form.'resumename','resumename','','string');
            $resumecategory = $mainframe->getUserStateFromRequest($form.'resumecategory','resumecategory','','string');
            $resumetype = $mainframe->getUserStateFromRequest($form.'resumetype','resumetype','','string');
            $desiredsalary = $mainframe->getUserStateFromRequest($form.'desiredsalary','desiredsalary','','string');
            $location = $mainframe->getUserStateFromRequest($form.'location','location','','string');
            $dateto = $mainframe->getUserStateFromRequest($form.'dateto','dateto','','string');
            $datefrom = $mainframe->getUserStateFromRequest($form.'datefrom','datefrom','','string');
            $status = '';
            $isgfcombo = $mainframe->getUserStateFromRequest($form.'isgfcombo','isgfcombo','','string');
            $sortby = JRequest::getVar('sortby','asc');
            $my_click = JRequest::getVar('my_click');
            if($my_click==1){
                $sortby = $this->getSortArg($sortby);
            }
            $js_sortby = JRequest::getVar('js_sortby');

            $result = $this->getJSModel('resume')->getAllEmpApps($datafor, $resumetitle, $resumename, $resumecategory, $resumetype, $desiredsalary, $location, $dateto, $datefrom, $status, $isgfcombo, $sortby, $js_sortby, $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            $lists = $result[2];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            $this->assignRef('lists', $lists);
            $this->assignRef('js_sortby', $js_sortby);
            $this->assignRef('sort', $sortby);
        }elseif ($layoutName == 'empapps') { //resumes
            JToolBarHelper::title(JText::_('Resume'));
            JToolBarHelper::editList('resume.edit');
            JToolBarHelper::deleteList(JText::_('Are You Sure?'), 'resume.remove');
            JToolBarHelper::cancel('resume.cancel');
            $form = 'com_jsjobs.empapps.list.';
            $datafor = 1;
            $resumetitle = $mainframe->getUserStateFromRequest($form.'resumetitle','resumetitle','','string');
            $resumename = $mainframe->getUserStateFromRequest($form.'resumename','resumename','','string');
            $resumecategory = $mainframe->getUserStateFromRequest($form.'resumecategory','resumecategory','','string');
            $resumetype = $mainframe->getUserStateFromRequest($form.'resumetype','resumetype','','string');
            $desiredsalary = $mainframe->getUserStateFromRequest($form.'desiredsalary','desiredsalary','','string');
            $location = $mainframe->getUserStateFromRequest($form.'location','location','','string');
            $dateto = $mainframe->getUserStateFromRequest($form.'dateto','dateto','','string');
            $datefrom = $mainframe->getUserStateFromRequest($form.'datefrom','datefrom','','string');
            $status = $mainframe->getUserStateFromRequest($form.'status','status','','string');
            $isgfcombo = $mainframe->getUserStateFromRequest($form.'isgfcombo','isgfcombo','','string');
            $sortby = JRequest::getVar('sortby','asc');
            $my_click = JRequest::getVar('my_click');
            if($my_click==1){
                $sortby = $this->getSortArg($sortby);
            }
            $js_sortby = JRequest::getVar('js_sortby');

            $result = $this->getJSModel('resume')->getAllEmpApps($datafor, $resumetitle, $resumename, $resumecategory, $resumetype, $desiredsalary, $location, $dateto, $datefrom, $status, $isgfcombo, $sortby, $js_sortby, $limitstart, $limit);
            $items = $result[0];
            $total = $result[1];
            $lists = $result[2];
            if ($total <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($total, $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
            $this->assignRef('lists', $lists);
            $this->assignRef('js_sortby', $js_sortby);
            $this->assignRef('sort', $sortby);
        }elseif (($layoutName == 'resumeprint')) {// view resume
            require_once(JPATH_ROOT . '/components/com_jsjobs/models/resume.php');
            $resumeid = JRequest::getVar('id', '');
            if (!$resumeid)
                $resumeid = JRequest::getVar('rd', '');
            $myresume = JRequest::getVar('nav', '2');
            $folderid = JRequest::getVar('fd', '');
            $sortvalue = $sort = JRequest::getVar('sortby', false);
            if ($sort != false)
                $sort = $this->getEmpListOrdering($sort);
            $tabaction = JRequest::getVar('ta', false);
            $model = $this->getModel();
            $show_only_section_that_have_value = $this->getJSModel('configuration')->getConfigValue('show_only_section_that_have_value');

            $resume_object = new JSJobsModelResume();
            $result = $resume_object->getResumeViewbyId($uid, false, $resumeid, $myresume, $sort, $tabaction);
            $canview = 1;
            $validresume = true;
            if(is_numeric($resumeid)){
                $validresume = $resume_object->checkResumeExists($resumeid);
            }
            $this->assignRef('validresume',$validresume);

            $this->assignRef('resume', $result['personal']);
            $this->assignRef('addresses', $result['addresses']);
            $this->assignRef('institutes', $result['institutes']);
            $this->assignRef('employers', $result['employers']);
            $this->assignRef('references', $result['references']);
            $this->assignRef('languages', $result['languages']);
            $this->assignRef('fieldsordering', $result['fieldsordering']);
            $this->assignRef('userfields', $result['userfields']);
            $this->assignRef('show_only_section_that_have_value', $show_only_section_that_have_value);
            $this->assignRef('canview', $canview);
            $this->assignRef('cvids', $result['cvids']); // for employer resumes navigations
            $nav = JRequest::getVar('nav', '');
            $this->assignRef('nav', $nav);
            $jobaliasid = JRequest::getVar('bd', '');
            $this->assignRef('jobaliasid', $jobaliasid);
            $this->assignRef('resumeid', $resumeid);
            $this->assignRef('sortby', $sortvalue);
            $this->assignRef('fd', $folderid);
            $this->assignRef('ms', $myresume);

            $user = JFactory::getUser();
            if (isset($user->groups[8]) OR isset($user->groups[7])) {
                $isadmin = 1;
            }
            $this->assignRef('isadmin', $isadmin);
            JToolBarHelper::title(JText::_('View Resumes'));
        }

        $this->assignRef('config', $config);
        $this->assignRef('application', $application);
        $this->assignRef('items', $items);
        $this->assignRef('theme', $theme);
        $this->assignRef('option', $option);
        $this->assignRef('uid', $uid);
        $this->assignRef('msg', $msg);
        $this->assignRef('isjobsharing', $_client_auth_key);

        parent::display($tpl);
    }
        function getSortArg($sort) {
        if ($sort == 'asc')
            return "desc";
        else
            return "asc";
    }    

}
?>
