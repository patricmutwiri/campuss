<?php

/**
 * @version     1.0.0
 * @package     com_downloadmanager
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Shaon <scripteden@gmail.com> - http://scripteden.com
 */


defined('_JEXEC') or die('Restricted access');

?><div id="lock-options"  class="tab-pane">
    You can use one or more of following methods to lock your package download:
    <br/>
    <br/>
    <div class="wpdm-accordion" style="border: 1px solid #ccc;padding-bottom:1px">

        <h3><input type="checkbox" class="wpdmlock" rel='password' name="pack[password_lock]" <?php if(get_post_data($post,'password_lock', true)=='1') echo "checked=checked"; ?> value="1">Enable Password Lock</h3>
        <div  id="password" class="fwpdmlock" <?php if(get_post_data($post,'password_lock', true)!='1') echo "style='display:none'"; ?> >
            <table width="100%"  cellpadding="0" cellspacing="0">
                <tr id="password_row">
                    <td>Password:</td>
                    <td><input size="10" style="width: 200px" type="text" name="pack[password]" id="pps_z" value="<?php echo get_post_data($post,'password', true); ?>" /><span class="info infoicon" title="You can use single or multiple password<br/>for a package. If you are using multiple password then<br/>separate each password by []. example [password1][password2]">&nbsp;</span> </td>
                </tr>
                <tr id="password_usage_row">
                    <td>PW Usage Limit:</td>
                    <td><input size="10" style="width: 80px" type="text" name="pack[password_usage_limit]" value="<?php echo get_post_data($post,'password_usage_limit', true); ?>" /> / password <span class="info infoicon" title="Password will expire after it exceed this usage limit">&nbsp;</span></td>
                </tr>
                <tr id="password_usage_row">
                    <td colspan="2"><label><input type="checkbox" name="pack[password_usage]" value="0" /> Reset Password Usage Count</label></td>
                     </td>
                </tr>
            </table>
        </div>
        <h3><input type="checkbox" rel="linkedin" class="wpdmlock" name="pack[linkedin_lock]" <?php if(get_post_data($post,'linkedin_lock', true)=='1') echo "checked=checked"; ?> value="1">LinkedIn Share Lock</h3>
        <div id="linkedin" class="frm fwpdmlock" <?php if(get_post_data($post,'linkedin_lock', true)!='1') echo "style='display:none'"; ?> >
            <table width="100%"  cellpadding="0" cellspacing="0" >
                <tr>
                    <td>Custom linkedin share message:
                        </br><textarea style="width: 100%" name="pack[linkedin_message]"><?php echo get_post_data($post,'linkedin_message', true) ?></textarea>
                        URL to share (keep empty for current page url):
                        </br><input style="width: 100%" type="text" name="pack[linkedin_url]" value="<?php echo get_post_data($post,'linkedin_url', true) ?>" />
                    </td>
                </tr>
            </table>
        </div>
        <h3><input type="checkbox" rel="tweeter" class="wpdmlock" name="pack[tweet_lock]" <?php if(get_post_data($post,'tweet_lock', true)=='1') echo "checked=checked"; ?> value="1">Tweet Lock</h3>
        <div id="tweeter" class="frm fwpdmlock" <?php if(get_post_data($post,'tweet_lock', true)!='1') echo "style='display:none'"; ?> >
            <table width="100%"  cellpadding="0" cellspacing="0" >
                <tr>
                    <td>Custom tweet message:
                        </br><textarea style="width: 100%" type="text" name="pack[tweet_message]"><?php echo get_post_data($post,'tweet_message', true) ?></textarea></td>
                </tr>
            </table>
        </div>
        <h3><input type="checkbox" rel="gplusone" class="wpdmlock" name="pack[gplusone_lock]" <?php if(get_post_data($post,'gplusone_lock', true)=='1') echo "checked=checked"; ?> value="1">Enable Google +1 Lock</h3>
        <div id="gplusone" class="frm fwpdmlock" <?php if(get_post_data($post,'gplusone_lock', true)!='1') echo "style='display:none'"; ?> >
            <table width="100%"  cellpadding="0" cellspacing="0" >
                <tr>
                    <td width="90px">URL for +1:</td>
                    <td><input size="10" style="width: 200px" type="text" name="pack[google_plus_1]" value="<?php echo get_post_data($post,'google_plus_1', true) ?>" /></td>
                </tr>
            </table>
        </div>
        <h3><input type="checkbox" rel="facebooklike" class="wpdmlock" name="pack[facebooklike_lock]" <?php if(get_post_data($post,'facebooklike_lock', true)=='1') echo "checked=checked"; ?> value="1">Enable Facebook Like Lock</h3>
        <div id="facebooklike" class="frm fwpdmlock" <?php if(get_post_data($post,'facebooklike_lock', true)!=1) echo "style='display:none;'"; ?> >
            <table  width="100%" cellpadding="0" cellspacing="0">

                <tr>
                    <td width="90px">URL to Like:</td>
                    <td><input size="10" style="width: 200px" type="text" name="pack[facebook_like]" value="<?php echo get_post_data($post,'facebook_like', true) ?>" /></td>
                </tr>
            </table>
        </div>
        <h3><input type="checkbox" rel="email" class="wpdmlock" name="pack[email_lock]" <?php if(get_post_data($post,'email_lock', true)=='1') echo "checked=checked"; ?> value="1">Enable Email Lock </h3>
        <div id="email" class="frm fwpdmlock"  <?php if(get_post_data($post,'email_lock', true)!='1') echo "style='display:none'"; ?> >
            <table  cellpadding="0" cellspacing="0" width="100%">
                <tr><td>
                        <?php if(isset($post->ID)) do_action('wpdm_custom_form_field',$post->ID); ?>
                    </td>
                </tr>
                <tr><td>

                        Will ask for email (and checked custom data) before download<br/>
                  </td></tr>
            </table>
        </div>
        <?php do_action('wpdm_download_lock_option',$post); ?>
    </div>
    <div class="clear"></div>
</div>