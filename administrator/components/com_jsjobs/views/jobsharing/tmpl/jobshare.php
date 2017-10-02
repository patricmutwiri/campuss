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

?>


<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=controlpanel"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Job Sharing'); ?></span></div>
<!--  -->
<table width="100%">
    <tr>
        <td width="100%" valign="top">
            
            <form action="index.php" method="post" name="jobserverserialnumber" id="jobserverserialnumber" method="post" style="margin: 0px;">
                <div id="jsjobs_jobsharing_blackbar"><?php echo JText::_('Server Serial Number'); ?></div>
                <div id="jsjobs_jobsharing_wrapper">
                    <span class="texttype"><?php echo JText::_('Please type your server serial number and'); ?></span><span id="jsjobs_jobsharing_redinfo"><?php echo JText::_('Submit'); ?></span>
                    <input type="text" name="server_serialnumber" id="server_serialnumber" />
                    <input type="submit" value="<?php echo JText::_('Submit'); ?>" id="jsjobs_sharing_serverkeybutton" />
                    <div id="jsjobs_messagebox"><span id="jsjobs_messageboxtopcorner"></span>
                        <?php echo JText::_('Please enter your JS Jobs server serial number'); ?><br/>
                        <?php echo JText::_('To get serial number click here'); ?>&nbsp;<a href="">http://www.joomsky.com</a><br/>
                        <?php echo JText::_('Insert serial number here and submit, then goto Joomsky again and verify your website.'); ?><br/>
                    </div>
                </div>
                <input type="hidden" name="c" value="jsjobs" />
                <input type="hidden" name="option" value="com_jsjobs" />
                <input type="hidden" name="task" value="saveserverserailnumber" />
                <?php echo JHTML::_( 'form.token' ); ?>        
            </form>
            <form action="index.php" method="post" name="jobShare" id="jobShare" method="post">
                <div id="jsjobs_jobsharing_subscribe_wrapper">
                    <div id="jsjobs_jobsharing_graybar"><span class="sharingtext"><?php echo JText::_('Sharing Subscribe'); ?></span> </div>
                    <div id="jsjobs_jobsharing_subscribe_righttext">
                        <span id="jsjobs_jobsharing_subscribe_righttext_heading"><?php echo JText::_('Sharing Services'); ?></span>
                        <span id="jsjobs_jobsharing_subscribe_righttext_heading_bottom"><?php echo JText::_('Subscribe and unsubscribe sharing services'); ?></span>
                    </div>
                </div>
                <div id="jsjobs_jobsharing_subscribe_button_wrapper">
                    <span id="jsjobs_jobsharing_subscribetitle">
                        <?php
                        echo JText::_('Your Sharing Services'); 
                        
                         if ($this->isjobsharing) {
                            echo '<span id="jsjobs_jobsharing_subscribe_text" class="subscribe">' . JText::_('Subscribed') . '</span>';
                        } else {
                            echo '<span id="jsjobs_jobsharing_subscribe_text" class="unsubscribe">' . JText::_('Unsubscribed') . '</span>';
                        }
                        ?>
                        <span class="linebetween"></span>
                    </span>

                    <div id="jsjobs_jobsharing_wrapper">
                        <span class="parent_span"><span id="jsjobs_jobsharing_subscribeone"><?php echo JText::_('Authentication Key'); ?>&nbsp;:&nbsp;</span>
                        <?php
                        if ($this->isjobsharing) {
                            echo '<input class="input_button_style" type="button" onclick="unsubscribejobsharing();" value="' . JText::_('Unsubscribed') . '" id="jsjobs_sharing_serverkeybutton"  />';
                        } else {
                            echo '<input class="input_field_style" type="text" id="server_serialnumber" name="authenticationkey" placeholder="' . JText::_('Enter The Key') . '" id="jsjobs_sharing_subcribe_authkey" />';
                            echo '<input class="input_button_style" type="button" id="jsjobs_sharing_serverkeybutton" onclick="submitjobform();" value="' . JText::_('Subscribed') . '" />';
                        }
                        ?>
                        </span>
                        <div id="jsjobs_messagebox"><span id="jsjobs_messageboxtopcorner"></span>
                            <?php echo JText::_('Get authentication key from Joomsky my product area here is link'); ?><br/>&nbsp;<a href="">http://www.joomsky.com</a><br/>
                            <?php echo JText::_('Insert your authentication key here and press subscribe to job sharing services.'); ?>
                            <?php echo JText::_('If you want to unsubscribe then after subscribe you are able to make unsubscribe'); ?><br/>
                        </div>
                    </div>
                </div>
                <div id="jobsharingwait" style="display:none"> 
                    <img src="components/com_jsjobs/include/images/loading.gif" height="32" width="32"></img>
                </div>
                <p id="jobsharingmessage" style="display:none"> <?php echo JText::_("Please wait your system synchronize with server"); ?></p>
                <?php if ($this->result != 'empty')  ?><p id="jobsharingmessageresult" style="display:block"> <?php if ($this->result != 'empty') echo $this->result; ?></p>


                <input type="hidden" id="task" name="task" value="jobsharing.requestjobsharing">
                <input type="hidden" name="ip" id="ip" value="<?php echo $_SERVER["REMOTE_ADDR"]; ?>">
                <input type="hidden" name="domain" id="domain" value="<?php echo $_SERVER["HTTP_HOST"]; ?>">
                <input type="hidden" name="siteurl" id="siteurl" value="<?php echo JURI:: root(); ?>">
                <?php if (isset($this->isjobsharing) AND ( $this->isjobsharing != ''))  ?> <input type="hidden" name="authkey" id="authkey" value="<?php echo $this->isjobsharing; ?>">
                <input type="hidden" name="option" value="com_jsjobs">
                <?php echo JHTML::_( 'form.token' ); ?>        
            </form> 
        </td>
    </tr>
</table>    
<!--  -->
    </div>    
</div>
<div id="jsjobs-footer">
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







<script type="text/javascript">
    function submitjobform() {
        document.getElementById('task').value = "jobsharing.requestjobsharing"; //retuen value
        document.getElementById('jobsharingwait').style.display = "block"; //retuen value
        document.getElementById('jobsharingmessage').style.display = "block"; //retuen value
        document.jobShare.submit();
    }
    function unsubscribejobsharing() {
        document.getElementById('task').value = "jobsharing.unsubscribejobsharing"; //retuen value
        document.jobShare.submit();
    }
</script>
