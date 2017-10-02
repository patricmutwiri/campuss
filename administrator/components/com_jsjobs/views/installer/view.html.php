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

class JSJobsViewInstaller extends JSView {

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
//        layout statr
        if ($layoutName == 'finalstep') {        //job types
            JToolBarHelper::title(JText::_('Final Step'));
            $goCp = $this->getJSModel('company')->getIfSampleData();
            $this->assignRef('isgotocp', $goCp);            
            $session = JFactory::getSession();
            $data = $session->get('data');
            $this->assignRef('data', $data);
        }
//        layout end
        $this->assignRef('option', $option);
        $this->assignRef('uid', $uid);
        $this->assignRef('isjobsharing', $_client_auth_key);

        parent::display($tpl);
    }

}

?>
