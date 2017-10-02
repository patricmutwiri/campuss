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
        case 'formcoverletter':
            if (isset($result[0])) {
                $pathway->addItem(JText::_('My Cover Letters'), $commonpath . '&c=coverletter&view=coverletter&layout=mycoverletters&Itemid=' . $itemid);
            }
            $pathway->addItem(JText::_('Cover Letter Form'), '');
            break;
        case 'mycoverletters':
            $pathway->addItem(JText::_('My Cover Letters'), '');
            break;
        case 'view_coverletter':
            if ($nav == 8) { //my cover letters 
                $pathway->addItem(JText::_('My Cover Letters'), $commonpath . '&c=coverletter&view=coverletter&layout=mycoverletters&Itemid=' . $itemid);
                $pathway->addItem(JText::_('View Cover Letter'), '');
            } elseif ($nav == 10) { //view cover letters - search
                $pathway->addItem(JText::_('My Jobs'), $commonpath . '&c=job&view=job&layout=myjobs&Itemid=' . $itemid);
                //$pathway->addItem(JText::_('Applied Resume'), $commonpath.'&c=jobapply&view=jobapply&layout=alljobsappliedapplications&Itemid='.$itemid); b/c layout deleted
                $pathway->addItem(JText::_('Job Applied Resume'), $commonpath . '&c=jobapply&view=jobapply&layout=job_appliedapplications&bd=' . $jobaliasid . '&Itemid=' . $itemid);
                $resumealiasid = JSModel::getJSModel('common')->removeSpecialCharacter($resumealiasid);
                $pathway->addItem(JText::_('View Resume'), $commonpath . '&c=resume&view=resume&layout=view_resume&nav=2&rd=' . $resumealiasid . '&bd=' . $jobaliasid . '&Itemid=' . $itemid);
                $pathway->addItem(JText::_('View Cover Letter'), '');
            } elseif ($nav == 40) { //view cover letters - search
                $pathway->addItem(JText::_('Resume Search'), $commonpath . '&c=resume&view=resume&layout=resumesearch&Itemid=' . $itemid);
                $pathway->addItem(JText::_('Resume Search Result'), $commonpath . '&c=resume&view=resume&layout=resume_searchresults&Itemid=' . $itemid);
                $pathway->addItem(JText::_('View Cover Letter'), '');
            }
            break;
    }
}
?>
