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

$document = JFactory::getDocument();
//Old css
$document->addStyleSheet('components/com_jsjobs/css/style.css', 'text/css');
require_once(JPATH_COMPONENT.'/css/style_color.php');

$language = JFactory::getLanguage();
if($language->isRtl()){
    $document->addStyleSheet('components/com_jsjobs/css/style_rtl.css', 'text/css');
}

?>

<div id="js_jobs_main_wrapper">
	<div id="jsjobs_r_p_notfound">
		<div class="jstitle"><?php echo JText::_('Requested page not found').'...!';?></div>
		<div class="jsjob_button_cp">
			<a class="jsjob_anchor_em" href="index.php?option=com_jsjobs&view=employer&layout=controlpanel"><?php echo JText::_('Employer Control Panel');?></a>
			<a class="jsjob_anchor_js" href="index.php?option=com_jsjobs&view=jobseeker&layout=controlpanel"><?php echo JText::_('Jobseeker Control Panel');?></a>
		</div>
	</div>
</div>