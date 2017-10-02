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

class JSJobsViewJobSeekerPackages extends JSView {

    function display($tpl = null) {
        require_once(JPATH_COMPONENT . '/views/common.php');
        $viewtype = 'html';

        if ($layout == 'package_buynow') {
            $page_title .= ' - ' . JText::_('Buy Now');
            $packageid = JRequest::getVar('gd');
            $package = $this->getJSModel('jobseekerpackages')->getJobSeekerPackageById($packageid);
            $this->assignRef('package', $package);
            $nav = JRequest::getVar('nav', '');
            $layoutfor = JRequest::getVar('jslayfor');
            if($layoutfor!='detail')
                $layoutfor = 'no';
            $this->assignRef('layoutfor', $layoutfor);
            $this->assignRef('nav', $nav);
            $this->assignRef('paymentmethod', $paymentmethod);
            $this->assignRef('idealdata', $ideal_data);
        } elseif ($layout == 'package_details') {
            $page_title .= ' - ' . JText::_('Package Details');
            $packageid = JRequest::getVar('gd');
            $package = $this->getJSModel('jobseekerpackages')->getJobSeekerPackageById($packageid);
            $this->assignRef('package', $package);
        } elseif ($layout == 'packages') {            // job seeker package
            $page_title .= ' - ' . JText::_('Packages');
            $result = $this->getJSModel('jobseekerpackages')->getJobSeekerPackages($limit, $limitstart);
            $this->assignRef('packages', $result[0]);
            if ($result[1] <= $limitstart)
                $limitstart = 0;
            $pagination = new JPagination($result[1], $limitstart, $limit);
            $this->assignRef('pagination', $pagination);
        }
        require_once('jobseekerpackages_breadcrumbs.php');

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
        $this->assignRef('pdflink', $pdflink);
        $this->assignRef('printlink', $printlink);
        $this->assignRef('isjobsharing', $_client_auth_key);

        parent::display($tpl);
    }

}

?>
