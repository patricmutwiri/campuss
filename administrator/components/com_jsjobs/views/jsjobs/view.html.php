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

class JSJobsViewJsjobs extends JSView {

    function display($tpl = null) {
        require_once JPATH_COMPONENT_ADMINISTRATOR . '/views/common.php';
        if ($layoutName == 'controlpanel') {
            JToolBarHelper::title('JS Jobs');
            $ck = $this->getJSModel('configuration')->getCheckCronKey();
            if ($ck == false) {
                $this->getJSModel('configuration')->genearateCronKey();
            }
            $ck = $this->getJSModel('configuration')->getCronKey(md5(date('Y-m-d')));
            $this->assignRef('ck', $ck);
            $jobs_cp_data = $this->getJSModel('jsjobs')->getTodayStats();
            $this->assignRef('jobs_cp_data', $jobs_cp_data);
            $this->assignRef('topjobs', $topjobs);
        } elseif ($layoutName == 'info') {
            JToolBarHelper::title(JText::_('Information'));
        } elseif ($layoutName == 'translation') {
            JToolBarHelper::title(JText::_('Translations'));
        } elseif ($layoutName == 'updates') {          // roles
            JToolBarHelper::title(JText::_('JS Job Update'));
            $configur = $this->getJSModel('configuration')->getConfigur();
            $this->assignRef('configur', $configur);
            $count_config = $this->getJSModel('configuration')->getCountConfig();
            $this->assignRef('count_config', $count_config);
        }if ($layoutName == 'stepone') { //Installation
            $array = explode('.', phpversion());
            $phpversion = $array[0] . '.' . $array[1];
            $curlexist = function_exists('curl_version');
            //$curlversion = curl_version()['version'];
            if (extension_loaded('gd') && function_exists('gd_info')) {
                $gd_lib = 1;
            } else {
                $gd_lib = 0;
            }
            $zip_lib = 0;
            if (file_exists('components/com_jsjobs/include/lib/pclzip.lib.php')) {
                $zip_lib = 1;
            }
            $this->assignRef('phpversion', $phpversion);
            $this->assignRef('curlversion', $curlversion);
            $this->assignRef('gd_lib', $gd_lib);
            $this->assignRef('zip_lib', $zip_lib);
            $this->assignRef('curlexist', $curlexist);
            JToolBarHelper :: title(JText :: _('INSTALLATION'));
        } elseif ($layoutName == 'steptwo') {
            $returnvalue = $this->getJSModel('jsjobs')->getStepTwoValidate();
            $this->assignRef('result', $returnvalue);
            JToolBarHelper :: title(JText :: _('INSTALLATION'));
        } elseif ($layoutName == 'stepthree') {
            $versioncode = $this->getJSModel('jsjobs')->getConfigByConfigName('version');
            $this->assignRef('versioncode', $versioncode);
            $versiontype = $this->getJSModel('jsjobs')->getConfigByConfigName('versiontype');
            $this->assignRef('versiontype', $versiontype);
            $count_config = $this->getJSModel('jsjobs')->getConfigCount();
            $this->assignRef('count_config', $count_config);
            JToolBarHelper :: title(JText :: _('INSTALLATION'));
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
