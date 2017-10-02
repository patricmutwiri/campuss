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
 
// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.html.parameter');
JHTML::_('behavior.formvalidation');
?>
<div id="js_jobs_main_wrapper">
<div id="js_menu_wrapper">
    <?php
    if (sizeof($this->jobseekerlinks) != 0) {
        foreach ($this->jobseekerlinks as $lnk) {
            ?>                     
            <a class="js_menu_link <?php if ($lnk[2] == 'job_categories') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
            <?php
        }
    }
    if (sizeof($this->employerlinks) != 0) {
        foreach ($this->employerlinks as $lnk) {
            ?>
            <a class="js_menu_link <?php if ($lnk[2] == 'job_categories') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
            <?php
        }
    }
    ?>
</div>

<?php
if ($this->config['offline'] == '1') {
    $this->jsjobsmessages->getSystemOfflineMsg($this->config);
} else {
    ?>
    <div id="js_main_wrapper">
        <span class="js_controlpanel_section_title">
            <?php
            if ($this->userrole == 2) {
                echo JText::_('Job Seeker Login');
            } elseif ($this->userrole == 3) {
                echo JText::_('Employer Login');
            }
            ?>
        </span>
        <form action="<?php echo JRoute::_('index.php?option=com_users&task=user.login' ,false); ?>" method="post" id="loginform" name="loginform">

            <div id="userform" class="userform">
                <table cellpadding="5" cellspacing="0" border="0" width="100%" class="admintable" >
                    <tr>
                        <td align="right" nowrap>
                            <label id="name-lbl" for="name"><?php echo JText::_('User Name'); ?>: </label>* 
                        </td>
                        <td>
                            <input id="username" class="validate-username" type="text" size="25" value="" name="username" >
                        </td>
                    </tr>
                    <tr>
                        <td align="right" nowrap>
                            <label id="password-lbl" for="password"><?php echo JText::_('Password'); ?>: </label>* 
                        </td>
                        <td>
                            <input id="password" class="validate-password" type="password" size="25" value="" name="password">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input id="button" class="button validate" type="button" onclick="return checkformlogin();" value="<?php echo JText::_('Login'); ?>"/>

                    <!--<button  type="submit" class="button validate" onclick="return myValidate(this.loginform);"><?php echo JText::_('Jlogin'); ?></button>-->
                        </td>
                    </tr>

                </table>
                <input type="hidden" name="return" value="<?php echo $this->loginreturn; ?>" />
                <?php echo JHtml::_('form.token'); ?>
            </div>	
        </form>
    </div>
    <div>
        <ul>
            <li>
                <a href="<?php echo JRoute::_('index.php?option=com_users&view=reset' ,false); ?>">
                    <?php echo JText::_('Forgot Your Password?'); ?></a>
            </li>
            <li>
                <a href="<?php echo JRoute::_('index.php?option=com_users&view=remind' ,false); ?>">
                    <?php echo JText::_('Forgot Your Username?'); ?></a>
            </li>
            <?php
            $usersConfig = JComponentHelper::getParams('com_users');
            if ($usersConfig->get('allowUserRegistration')) :
                ?>
                <li>
                    <a href="<?php echo JRoute::_('index.php?option=com_jsjobs&view=common&layout=userregister&userrole=' . $this->userrole . '&Itemid=0' ,false); ?>">
                        <?php echo JText::_('Dont Have An Account?'); ?></a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    <script type="text/javascript" language="javascript">
        function checkformlogin() {
            var username = document.getElementById('username').value;
            var password = document.getElementById('password').value;
            if (username != "" && password != "") {
                document.loginform.submit();
            } else {
                alert('<?php echo JText::_('Fill Req Fields'); ?>');
            }
        }
    </script>	


<?php } //ol  ?>
<!-- <div id="jsjobsfooter" class="hidden">
    <table width="100%" style="table-layout:fixed;">
        <tr><td height="15"></td></tr>
        <tr>
            <td style="vertical-align:top;" align="center">
                <a class="img" target="_blank" href="http://www.joomsky.com"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png"></a>
                <br>
                Copyright &copy; 2008 - <?php echo  date('Y') ?> ,
                <span id="themeanchor"> <a class="anchor"target="_blank" href="http://www.burujsolutions.com">Buruj Solutions</a></span>
            </td>
        </tr>
    </table>
</div> -->

</div>

