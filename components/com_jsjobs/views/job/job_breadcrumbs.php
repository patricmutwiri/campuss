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
 
$commonpath = "index.php?option=com_jsjobs";
$pathway = $mainframe->getPathway();
if ($config['cur_location'] == 1) {
    switch ($layout) {
        case 'formjob':
            if ($result[0]) { // for edit form job
                $pathway->addItem(JText::_('My Jobs'), $commonpath . '&c=job&view=job&layout=myjobs&Itemid=' . $itemid);
                $pathway->addItem(JText::_('Edit Job Information'), '');
            } else {
                $pathway->addItem(JText::_('New Job Information'), '');
            }
            break;
        case 'formjob_visitor':
            if (isset($result[0])) {
                $pathway->addItem(JText::_('My Companies'), $commonpath . '&c=company&view=company&layout=mycompanies&Itemid=' . $itemid);
                $pathway->addItem(JText::_('Company Information'), '');
            } else {
                $pathway->addItem(JText::_('New Job Information'), '');
            }
            break;
        case 'myjobs':
            $pathway->addItem(JText::_('My Jobs'), '');
            break;
        case 'view_job':
            if ($nav == 19) { //my jobs
                $navcompany = 41;
                $pathway->addItem(JText::_('My Jobs'), $commonpath . '&c=job&view=job&layout=myjobs&Itemid=' . $itemid);
                $pathway->addItem(JText::_('View Job'), '');
            } else if ($nav == 13) { //job cat
                $pathway->addItem(JText::_('Job Categories'), $commonpath . '&c=category&view=category&layout=jobcat&Itemid=' . $itemid);
                $pathway->addItem(JText::_('Jobs List By Category'), $commonpath . '&c=category&view=category&layout=list_jobs&cat=' . $job->jobcategory . '&Itemid=' . $itemid);
                $pathway->addItem(JText::_('View Job'), '');
            } else if ($nav == 14) { //job subcat
                $pathway->addItem(JText::_('Job Categories'), $commonpath . '&c=category&view=category&layout=jobcat&Itemid=' . $itemid);
                $pathway->addItem(JText::_('Jobs List By Category'), $commonpath . '&c=category&view=category&layout=list_jobs&cat=' . $catid . '&Itemid=' . $itemid);
                $pathway->addItem(JText::_('Jobs List By Subcategory'), $commonpath . '&c=category&view=category&layout=list_subcategoryjobs&cat=' . $catid . '&jobsubcat=' . $jobsubcatid . '&Itemid=' . $itemid);
                $pathway->addItem(JText::_('View Job'), '');
            } else if ($nav == 17) { //job search
                $pathway->addItem(JText::_('Search Job'), $commonpath . '&c=job&view=job&layout=jobsearch&Itemid=' . $itemid);
                $pathway->addItem(JText::_('Job Search Results'), $commonpath . '&c=job&view=job&layout=job_searchresults&Itemid=' . $itemid);
                $pathway->addItem(JText::_('View Job'), '');
            } else if ($nav == 16) { //my applied jobs
                $pathway->addItem(JText::_('My Applied Jobs'), $commonpath . '&c=jobapply&view=jobapply&layout=myappliedjobs&Itemid=' . $itemid);
                $pathway->addItem(JText::_('View Job'), '');
            } else if ($nav == 15) { //newest jobs
                $pathway->addItem(JText::_('Newest Jobs'), $commonpath . '&c=job&view=job&layout=jobs&Itemid=' . $itemid);
                $pathway->addItem(JText::_('View Job'), '');
            } else if ($nav == 20) { //company jobs jobs
                $pathway->addItem(JText::_('Newest Jobs'), $commonpath . '&c=company&view=company&layout=company_jobs&cd=' . $result[0]->companyid . '&Itemid=' . $itemid);
                $pathway->addItem(JText::_('View Job'), '');
            } else {
                $pathway->addItem(JText::_('View Job'), '');
            }
            break;
        case 'jobsearch':
            $pathway->addItem(JText::_('Search Job'), '');
            break;
        case 'job_searchresults':
            $pathway->addItem(JText::_('Search Job'), $commonpath . '&c=job&view=job&layout=jobsearch&Itemid=' . $itemid);
            $pathway->addItem(JText::_('Job Search Results'), '');
            break;
        case 'list_jobs':
            $pathway->addItem(JText::_('Job Categories'), $commonpath . '&c=category&view=category&layout=jobcat&Itemid=' . $itemid);
            $pathway->addItem(JText::_('Jobs List By Category'), '');
            break;
        case 'listnewestjobs':
            $pathway->addItem(JText::_('Newest Jobs'), '');
            break;
    }
}
?>
