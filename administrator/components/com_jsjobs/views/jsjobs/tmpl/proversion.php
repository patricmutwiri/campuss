<?php
/**
 * @Copyright Copyright (C) 2009-2011
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
  + Created by:	Ahmad Bilal
 * Company:		Buruj Solutions
  + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	Jan 11, 2009
  ^
  + Project: 		JS Jobs
 * File Name:	admin-----/views/application/tmpl/info.php
  ^
 * Description: JS Jobs Information
  ^
 * History:		NONE
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
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=controlpanel"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a>
            <span id="heading-text"><?php echo JText::_('Feature Available In Js Jobs Pro Version'); ?></span>
        </div>
    <div id="js_profeature_main_wrapper">
        <div id="proheading" class="proheading">
            <span class="headtext"><?php echo JText::_('JS JOBS PRO FEATURES');?></span>
            <a class="buynow" target="_blank" href="http://www.joomsky.com/products/js-jobs-pro-wp.html"><img class="jsimg" src="components/com_jsjobs/include/images/pro/buy-now.png"> <?php echo JText::_('BUY NOW');?></a>
        </div>
        <div class="topimage bgwhite"><img class="jsimg" src="components/com_jsjobs/include/images/pro/image-1.png"></div>
        <div class="pro_wrapper">
            <div class="small_box">
                <div class="box bgwhite">
                    <div class="img"><img class="jsimg" src="components/com_jsjobs/include/images/pro/add-job.png"></div>
                    <div class="data">
                        <div class="heading">Visitor Can Add/Edit Jobs</div>
                        <div class="detail">JS Jobs comes with unique feature, visitor can add jobs and also he can edit job.<br>
JS Jobs send him an edit job link in his email.</div>
                    </div>
                </div>
            </div>
            <div class="small_box">
                <div class="box bgwhite">
                    <div class="img"><img class="jsimg" src="components/com_jsjobs/include/images/pro/gold-feature.png"></div>
                    <div class="data">
                        <div class="heading">Gold And Featured Jobs</div>
                        <div class="detail">JS Jobs give you the jobs listing along with the special Gold and Featured jobs listing.<br>
Gold and Featured jobs are not just listing in different layout it can also be listed in Newest Jobs controllable by admin.</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pro_wrapper">
            <div class="small_box">
                <div class="box bgwhite">
                    <div class="img"><img class="jsimg" src="components/com_jsjobs/include/images/pro/tell-friend.png"></div>
                    <div class="data">
                        <div class="heading">Tell A Friend</div>
                        <div class="detail">Tell a firend is a feature which enables users to share any job with thier friends by sending them a emails through our system.<br>Employers and job seeker both can use this feature</div>
                    </div>
                </div>
            </div>
            <div class="small_box">
                <div class="box bgwhite">
                    <div class="img"><img class="jsimg" src="components/com_jsjobs/include/images/pro/message.png"></div>
                    <div class="data">
                        <div class="heading">Message System</div>
                        <div class="detail">JS Jobs have message system feature. Employer can send message to job seeker and job
On each message JS Jobs send email notification.</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="full_box">
            <div class="box bgwhite">
                <div class="img"><img class="jsimg" src="components/com_jsjobs/include/images/pro/themes.png"></div>
                <div class="data">
                    <div class="heading">Multi Themes</div>
                    <div class="detail">You can customize the color layout for the JS Jobs.
You can either select colors from a color pallet table or select the predefined set.</div>
                </div>
            </div>
        </div>
        <div class="pro_wrapper">
            <div class="small_box">
                <div class="box bgwhite">
                    <div class="img"><img class="jsimg" src="components/com_jsjobs/include/images/pro/suggets-jobs.png"></div>
                    <div class="data">
                        <div class="heading">Suggested Jobs</div>
                        <div class="detail">Very usefull feature for job seeker. System suggested jobs available in his control panel.</div>
                    </div>
                </div>
            </div>
            <div class="small_box">
                <div class="box bgwhite">
                    <div class="img"><img class="jsimg" src="components/com_jsjobs/include/images/pro/add-resume.png"></div>
                    <div class="data">
                        <div class="heading">Visitor Can Add Resume</div>
                        <div class="detail">If user hesitates to register, don't worry about it. JS Jobs offers, Vistor can add resume with full details.</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="full_box">
            <div class="box bgwhite">
                <div class="img"><img class="jsimg" src="components/com_jsjobs/include/images/pro/applied-jobs.png"></div>
                <div class="data">
                    <div class="heading">Applied Resume</div>
                    <div class="detail">JS Jobs give more power to employer on applied resume.
Nowadays employer receive lot of resume for his jobs. Some of them relevant and some are not. JS Jobs handle this problem with filter and give useful options to employer.
Employer can add filter on his job on base of category, education, gender & location
Admin move resume to any of these tabs just by click<br>
– Inbox<br>
– Shortlisted<br>
– Spam<br>
– Hired<br>
– Rejected<br>
It help employer to find best candidate for his job.</div>
                </div>
            </div>
        </div>
        <div class="pro_wrapper">
            <div class="small_box">
                <div class="box bgwhite">
                    <div class="img"><img class="jsimg" src="components/com_jsjobs/include/images/pro/job-alert.png"></div>
                    <div class="data">
                        <div class="heading">Job Alert</div>
                        <div class="detail">Job seeker can get his desire job is his email account. Just subscribe for job alert and add his preferences and alert frequency<br>(daily/weekly/monthly).</div>
                    </div>
                </div>
            </div>
            <div class="small_box">
                <div class="box bgwhite">
                    <div class="img"><img class="jsimg" src="components/com_jsjobs/include/images/pro/custom-fields.png"></div>
                    <div class="data">
                        <div class="heading">User Fields</div>
                        <div class="detail">Custom fields are now more efficient and reliable.<br>
Admin can make custom fields visible on search forms, refine search popup and on main listings.</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pro_wrapper">
            <div class="small_box">
                <div class="box bgwhite">
                    <div class="img"><img class="jsimg" src="components/com_jsjobs/include/images/pro/payment.png"></div>
                    <div class="data">
                        <div class="heading">Payment System</div>
                        <div class="detail">You can charge both the Jobseeker and Employer of your site on packages bases. Payment system is integrated with the following online payment system.
2checkout, alipay, authorize.net, avangate, bluepaid, epay, eway, fastspring, googlecheckout, hsbc, moneybookers, pagseguro, payfast, paypal, payza, sagepay and wolrdpay.</div>
                    </div>
                </div>
            </div>
            <div class="small_box">
                <div class="box bgwhite">
                    <div class="img"><img class="jsimg" src="components/com_jsjobs/include/images/pro/map-adsan.png"></div>
                    <div class="data">
                        <div class="heading">Google Adsense And Map</div>
                        <div class="detail">Admin can add Google ads in job listing, that show ads after how many number of jobs. It will help you to earn money. You can also use Google map where the employer can set location of jobs, and jobseeker can easily search jobs on the radius base from a particular location.</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="full_box">
            <div class="box bgwhite">
                <div class="img"><img class="jsimg" src="components/com_jsjobs/include/images/pro/package.png"></div>
                <div class="data">
                    <div class="heading">Packages</div>
                    <div class="detail">Admin create package for employer and job seeker with various option related to the particular action like how many jobs, companies, departments, resumes and coverletters for the respective actor.</div>
                </div>
            </div>
        </div>
        <div class="pro_wrapper">
            <div class="small_box">
                <div class="box bgwhite">
                    <div class="img"><img class="jsimg" src="components/com_jsjobs/include/images/pro/language.png"></div>
                    <div class="data">
                        <div class="heading">Multi Language</div>
                        <div class="detail">JS Jobs have different languages its not for just the English it have following different languages.
                                            Arabic, Arabic (Egypt), Spanish, Dutch, German, French, Romanian, Russian, Greek, Portuguese (Brazil)
                                            You can set the JS Jobs language according to your locality.</div>
                    </div>
                </div>
            </div>
            <div class="small_box">
                <div class="box bgwhite">
                    <div class="img"><img class="jsimg" src="components/com_jsjobs/include/images/pro/sef.png"></div>
                    <div class="data">
                        <div class="heading">Search Engine Friendly URL</div>
                        <div class="detail">JS Jobs support Joomla SEF. All JS Jobs url are sef. JS Jobs also offer meta data and meta key words for search engines.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>


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