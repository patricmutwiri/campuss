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
jimport('joomla.html.pane');

$editor = JFactory::getEditor();
JHTML::_('behavior.calendar');
JHTML::_('behavior.formvalidation');
$document = JFactory::getDocument();

if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('../components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}
?>

<script language="javascript">
// for joomla 1.6
    Joomla.submitbutton = function (task) {
        if (task == '') {
            return false;
        } else {
            if (task == 'emailtemplate.save') {
                returnvalue = validate_form(document.adminForm);
            } else
                returnvalue = true;
            if (returnvalue) {
                Joomla.submitform(task);
                return true;
            } else
                return false;
        }
    }
    function validate_form(f)
    {
        if (document.formvalidator.isValid(f)) {
            f.check.value = '<?php
if (JVERSION < '3')
    echo JUtility::getToken();
else
    echo JSession::getFormToken();
?>';//send token
        }
        else {
            alert('<?php echo JText::_('Some Values Are Not Acceptable.  Please Retry.'); ?>');
            return false;
        }
        return true;
    }
</script>

<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=controlpanel"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a>
            <span id="heading-text"><?php echo JText::_('Email Template Options'); ?></span>
        </div>
        <table class="adminlist" border="0" id="js-table">
            <thead>
                <tr>
                    <th width="30%" class="title"><?php echo JText::_('Title'); ?></th>
                    <th width="14%" class="center"><?php echo JText::_('Employer'); ?></th>
                    <th width="14%" class="center"><?php echo JText::_('Job Seeker'); ?></th>
                    <th width="14%" class="center"><?php echo JText::_('Admin'); ?></th>
                    <th width="14%" class="center"><?php echo JText::_('Job Seeker Visitor'); ?></th>
                    <th width="14%" class="center"><?php echo JText::_('Employer Visitor'); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr valign="top" class="">
                    <td class="emailtemp_heading" colspan="6"> <?php echo JText::_('Company'); ?> </td>
                </tr>
                <?php
                $img_yes = "tick2.png";
                $img_no = "cross.png";
                $method = 'updateemailoption';
                ?>
                <tr valign="top" class="">
                    <td> <?php echo JText::_('Add New Company'); ?> </td>
                    <?php
                        $data = $this->options['add_new_company'];
                    ?>
                    <td align="center"><a href="index.php?option=com_jsjobs&c=emailtemplate&task=<?php echo $method; ?>&emailfor=<?php echo $data->emailfor; ?>&for=1"><img src="components/com_jsjobs/include/images/<?php if($data->employer == 1) echo $img_yes; else echo $img_no; ?>" width="16" height="16" border="0" /></a></td>
                    <td class="center">-</td>
                    <td class="center"><a href="index.php?option=com_jsjobs&c=emailtemplate&task=<?php echo $method; ?>&emailfor=<?php echo $data->emailfor; ?>&for=3"><img src="components/com_jsjobs/include/images/<?php if($data->admin == 1) echo $img_yes; else echo $img_no; ?>" width="16" height="16" border="0" /></a></td>
                    <td class="center">-</td>
                    <td class="center">-</td>
                </tr>
                <tr valign="top" class="">
                    <td> <?php echo JText::_('Company Status'); ?> </td>
                    <?php 
                    $data = $this->options['company_status'];
                    ?>
                    <td align="center"><a href="index.php?option=com_jsjobs&c=emailtemplate&task=<?php echo $method; ?>&emailfor=<?php echo $data->emailfor; ?>&for=1"><img src="components/com_jsjobs/include/images/<?php if($data->employer == 1) echo $img_yes; else echo $img_no; ?>" width="16" height="16" border="0" /></a></td>
                    <td class="center">-</td>
                    <td class="center">-</td>
                    <td class="center">-</td>
                    <td class="center">-</td>
                </tr>
                <tr valign="top" class="">
                    <td> <?php echo JText::_('Company Delete'); ?> </td>
                    <?php 
                    $data = $this->options['company_delete'];
                    ?>
                    <td align="center"><a href="index.php?option=com_jsjobs&c=emailtemplate&task=<?php echo $method; ?>&emailfor=<?php echo $data->emailfor; ?>&for=1"><img src="components/com_jsjobs/include/images/<?php if($data->employer == 1) echo $img_yes; else echo $img_no; ?>" width="16" height="16" border="0" /></a></td>
                    <td class="center">-</td>
                    <td class="center">-</td>
                    <td class="center">-</td>
                    <td class="center">-</td>
                </tr>
                <tr valign="top" class="">
                    <td class="emailtemp_heading" colspan="6"> <?php echo JText::_('Job'); ?> </td>
                </tr>
                <tr valign="top" class="">
                    <td> <?php echo JText::_('Add New Job'); ?> </td>
                    <?php 
                    $data = $this->options['add_new_job'];
                    ?>
                    <td align="center"><a href="index.php?option=com_jsjobs&c=emailtemplate&task=<?php echo $method; ?>&emailfor=<?php echo $data->emailfor; ?>&for=1"><img src="components/com_jsjobs/include/images/<?php if($data->employer == 1) echo $img_yes; else echo $img_no; ?>" width="16" height="16" border="0" /></a></td>
                    <td class="center">-</td>
                    <td class="center"><a href="index.php?option=com_jsjobs&c=emailtemplate&task=<?php echo $method; ?>&emailfor=<?php echo $data->emailfor; ?>&for=3"><img src="components/com_jsjobs/include/images/<?php if($data->admin == 1) echo $img_yes; else echo $img_no; ?>" width="16" height="16" border="0" /></a></td>
                    <td class="center">-</td>
                    <td class="center">PRO</td>

                </tr>
                <tr valign="top" class="">
                    <td> <?php echo JText::_('Job Status'); ?> </td>
                    <?php 
                    $data = $this->options['job_status'];
                    ?>
                    <td align="center"><a href="index.php?option=com_jsjobs&c=emailtemplate&task=<?php echo $method; ?>&emailfor=<?php echo $data->emailfor; ?>&for=1"><img src="components/com_jsjobs/include/images/<?php if($data->employer == 1) echo $img_yes; else echo $img_no; ?>" width="16" height="16" border="0" /></a></td>
                    <td class="center">-</td>
                    <td class="center">-</td>
                    <td class="center">-</td>
                    <td class="center">PRO</td>

                </tr>
                <tr valign="top" class="">
                    <td> <?php echo JText::_('Job Delete'); ?> </td>
                    <?php 
                    $data = $this->options['job_delete'];
                    ?>
                    <td align="center"><a href="index.php?option=com_jsjobs&c=emailtemplate&task=<?php echo $method; ?>&emailfor=<?php echo $data->emailfor; ?>&for=1"><img src="components/com_jsjobs/include/images/<?php if($data->employer == 1) echo $img_yes; else echo $img_no; ?>" width="16" height="16" border="0" /></a></td>
                    <td class="center">-</td>
                    <td class="center">-</td>
                    <td class="center">-</td>
                    <td class="center">-</td>
                </tr>
                <tr valign="top" class="">
                    <td class="emailtemp_heading" colspan="6"> <?php echo JText::_('Resume'); ?> </td>
                </tr>
                <tr valign="top" class="">
                    <td> <?php echo JText::_('Add New Resume'); ?> </td>
                    <?php 
                    $data = $this->options['add_new_resume'];
                    ?>

                    <td align="center">-</td>
                    <td class="center"><a href="index.php?option=com_jsjobs&c=emailtemplate&task=<?php echo $method; ?>&emailfor=<?php echo $data->emailfor; ?>&for=2"><img src="components/com_jsjobs/include/images/<?php if($data->jobseeker == 1) echo $img_yes; else echo $img_no; ?>" width="16" height="16" border="0" /></a></td>
                    <td class="center"><a href="index.php?option=com_jsjobs&c=emailtemplate&task=<?php echo $method; ?>&emailfor=<?php echo $data->emailfor; ?>&for=3"><img src="components/com_jsjobs/include/images/<?php if($data->admin == 1) echo $img_yes; else echo $img_no; ?>" width="16" height="16" border="0" /></a></td>
                    <td class="center">PRO</td>
                    <td class="center">-</td>

                </tr>
                <tr valign="top" class="">
                    <td> <?php echo JText::_('Resume Status'); ?> </td>
                    <?php 
                    $data = $this->options['resume_status'];
                    ?>                    
                    <td align="center">-</td>
                    <td class="center"><a href="index.php?option=com_jsjobs&c=emailtemplate&task=<?php echo $method; ?>&emailfor=<?php echo $data->emailfor; ?>&for=2"><img src="components/com_jsjobs/include/images/<?php if($data->jobseeker == 1) echo $img_yes; else echo $img_no; ?>" width="16" height="16" border="0" /></a></td>
                    <td class="center">-</td>
                    <td class="center">PRO</td>
                    <td class="center">-</td>

                </tr>
                <tr valign="top" class="">
                    <td> <?php echo JText::_('Resume Delete'); ?> </td>
                    <?php 
                    $data = $this->options['resume_delete'];
                    ?>                    
                    <td align="center">-</td>
                    <td class="center"><a href="index.php?option=com_jsjobs&c=emailtemplate&task=<?php echo $method; ?>&emailfor=<?php echo $data->emailfor; ?>&for=2"><img src="components/com_jsjobs/include/images/<?php if($data->jobseeker == 1) echo $img_yes; else echo $img_no; ?>" width="16" height="16" border="0" /></a></td>
                    <td class="center">-</td>
                    <td class="center">-</td>
                    <td class="center">-</td>
                </tr>
                <tr valign="top" class="">
                    <td class="emailtemp_heading" colspan="6"> <?php echo JText::_('Miscellaneous'); ?> </td>
                </tr>
                <tr valign="top" class="">
                    <td> <?php echo JText::_('Job Apply'); ?> </td>
                    <?php 
                    $data = $this->options['jobapply_jobapply'];
                    ?>
                    <td align="center"><a href="index.php?option=com_jsjobs&c=emailtemplate&task=<?php echo $method; ?>&emailfor=<?php echo $data->emailfor; ?>&for=1"><img src="components/com_jsjobs/include/images/<?php if($data->employer == 1) echo $img_yes; else echo $img_no; ?>" width="16" height="16" border="0" /></a></td>
                    <td class="center"><a href="index.php?option=com_jsjobs&c=emailtemplate&task=<?php echo $method; ?>&emailfor=<?php echo $data->emailfor; ?>&for=2"><img src="components/com_jsjobs/include/images/<?php if($data->jobseeker == 1) echo $img_yes; else echo $img_no; ?>" width="16" height="16" border="0" /></a></td>
                    <td class="center"><a href="index.php?option=com_jsjobs&c=emailtemplate&task=<?php echo $method; ?>&emailfor=<?php echo $data->emailfor; ?>&for=3"><img src="components/com_jsjobs/include/images/<?php if($data->admin == 1) echo $img_yes; else echo $img_no; ?>" width="16" height="16" border="0" /></a></td>
                    <td class="center">-</td>
                    <td class="center">-</td>
                </tr>
                <tr valign="top" class="">
                    <td> <?php echo JText::_('Applied Resume Status Change'); ?> </td>
                    <?php 
                    $data = $this->options['applied_resume_status'];
                    ?>
                    <td align="center">-</td>
                    <td class="center">PRO</td>
                    <td class="center">-</td>
                    <td class="center">-</td>
                    <td class="center">-</td>
                </tr>
                <tr valign="top" class="">
                    <td> <?php echo JText::_('Employer Purchase Package'); ?> </td>
                    <?php 
                    $data = $this->options['employer_purchase_package'];
                    ?>
                    <td align="center">PRO</td>
                    <td class="center">-</td>
                    <td class="center">PRO</td>
                    <td class="center">-</td>
                    <td class="center">-</td>
                </tr>
                <tr valign="top" class="">
                    <td> <?php echo JText::_('Jobseeker Purchase Package'); ?> </td>
                    <?php 
                    $data = $this->options['jobseeker_purchase_package'];
                    ?>
                    <td align="center">-</td>
                    <td class="center">PRO</td>
                    <td class="center">PRO</td>
                    <td class="center">-</td>
                    <td class="center">-</td>
                </tr>
                <tr valign="top" class="">
                    <td> <?php echo JText::_('Add New Department'); ?> </td>
                    <?php 
                    $data = $this->options['add_new_department'];
                    ?>
                    <td align="center">-</td>
                    <td class="center">-</td>
                    <td class="center"><a href="index.php?option=com_jsjobs&c=emailtemplate&task=<?php echo $method; ?>&emailfor=<?php echo $data->emailfor; ?>&for=3"><img src="components/com_jsjobs/include/images/<?php if($data->admin == 1) echo $img_yes; else echo $img_no; ?>" width="16" height="16" border="0" /></a></td>
                    <td class="center">-</td>
                    <td class="center">-</td>
                </tr>
            </tbody>
        </table>

    </div><!-- email main content wrapper closed -->

    </div><!-- content closed -->
</div><!-- main wrapper closed -->
				
<div id="jsjobsfooter">
    <table width="100%" style="table-layout:fixed;">
        <tr><td height="15"></td></tr>
        <tr>
            <td style="vertical-align:top;" align="center">
                <a class="img" target="_blank" href="http://www.joomsky.com"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png"></a>
                <br>
                Copyright &copy; 2008 - <?php echo  date('Y') ?> ,
                <span id="themeanchor"> <a class="anchor"target="_blank" href="http://www.burujsolutions.com">Buruj Solutions </a></span>
            </td>
        </tr>
    </table>
</div>