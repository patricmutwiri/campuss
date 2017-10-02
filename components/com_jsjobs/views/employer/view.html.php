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

class JSJobsViewEmployer extends JSView {

    function display($tpl = null) {
        require_once(JPATH_COMPONENT . '/views/common.php');
        $viewtype = 'html';

        if ($layout == 'controlpanel') {
            $emcontrolpanel = $this->getJSModel('configurations')->getConfigByFor('emcontrolpanel');
            if ($uid) {
                $packagedetail = $this->getJSModel('user')->getUserPackageDetailByUid($uid);
                $this->assignRef('packagedetail', $packagedetail);
            }
            $this->assignRef('emcontrolpanel', $emcontrolpanel);
        } elseif ($layout == 'my_stats') {        // my stats
            $page_title .= ' - ' . JText::_('My Stats');
            $mystats_allowed = $this->getJSModel('permissions')->checkPermissionsFor("EMPLOYER_PURCHASE_HISTORY");
            if ($mystats_allowed == VALIDATE) {
                $result = $this->getJSModel('employer')->getMyStats_Employer($uid);
                $this->assignRef('companiesallow', $result[0]);
                $this->assignRef('totalcompanies', $result[1]);
                $this->assignRef('jobsallow', $result[2]);
                $this->assignRef('totaljobs', $result[3]);
                $this->assignRef('publishedjob', $result[14]);
                $this->assignRef('expiredjob', $result[15]);
                if (isset($result[12])) {
                    $this->assignRef('package', $result[12]);
                    $this->assignRef('packagedetail', $result[13]);
                }
                $this->assignRef('ispackagerequired', $result[20]);
                $this->assignRef('goldcompaniesexpire', $result[21]);
                $this->assignRef('featurescompaniesexpire', $result[22]);
            }
            $this->assignRef('mystats_allowed', $mystats_allowed);
        }
        require_once('employer_breadcrumbs.php');
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
