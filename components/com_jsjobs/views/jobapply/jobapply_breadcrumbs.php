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
        case 'job_apply':

            if ($nav == 26) { // list jobs by category
                $pathway->addItem(JText::_('Job Categories'), $commonpath . '&c=category&view=category&layout=jobcat&Itemid=' . $itemid);
                $pathway->addItem(JText::_('Jobs List By Category'), $commonpath . '&c=category&view=category&layout=list_jobs&cat=' . $jobresult[0]->jobcategory . '&Itemid=' . $itemid);
                $pathway->addItem(JText::_('Apply Now'), '');
            } else if ($nav == 28) { // search job result
                $pathway->addItem(JText::_('Search Job'), $commonpath . '&c=job&view=job&layout=jobsearch&Itemid=' . $itemid);
                $pathway->addItem(JText::_('Job Search Results'), $commonpath . '&c=job&view=job&layout=job_searchresults&Itemid=' . $itemid);
                $pathway->addItem(JText::_('Apply Now'), '');
            } else if ($nav == 25) { // newest jobs
                $pathway->addItem(JText::_('Newest Jobs'), $commonpath . '&c=job&view=job&layout=jobs&Itemid=' . $itemid);
                $pathway->addItem(JText::_('Apply Now'), '');
            } else if ($nav == 39) { // company jobs
                $pathway->addItem(JText::_('Jobs'), $commonpath . '&c=company&view=company&layout=company_jobs&cd=' . $jobresult[0]->companyid . '&Itemid=' . $itemid);
                $pathway->addItem(JText::_('Apply Now'), '');
            } else if ($nav == 27) { //list jobs by subcategory
                $pathway->addItem(JText::_('Job Categories'), $commonpath . '&c=job&view=job&layout=list_jobs&cat=' . $jobcat . '&Itemid=' . $itemid);
                $pathway->addItem(JText::_('Jobs List By Category'), $commonpath . '&c=category&view=category&layout=jobcat&Itemid=' . $itemid);
                $pathway->addItem(JText::_('Apply Now'), '');
            } else {
                $pathway->addItem(JText::_('Apply Now'), '');
            }

            break;
        case 'myappliedjobs':
            $pathway->addItem(JText::_('My Applied Jobs'), '');
            break;
        case 'alljobsappliedapplications':
            $pathway->addItem(JText::_('Applied Resume'), '');
            break;
        case 'job_appliedapplications':
            $pathway->addItem(JText::_('My Jobs'), $commonpath . '&c=job&view=job&layout=myjobs&Itemid=' . $itemid);
            $pathway->addItem(JText::_('Job Applied Resume'), '');
            break;
    }
}
?>
