<?php
/**
 * @version     1.0.0
 * @package     com_downloadmanager
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Shaon <scripteden@gmail.com> - http://scripteden.com
 */


defined('_JEXEC') or die('Restricted access');
?>


<div class="wpdm-front w3eden">
<div style="max-width: 900px;margin-top: 20px">
    <form id="wpdm-pf" action="index.php?option=com_downloadmanager&view=settings&task=save" method="post">


                <div class="panel panel-default" id="package-settings-section">
                    <div class="panel-heading"><b>URL Settings</b></div>
                    <div class="panel-body">
                <div class="form-group">
                    <label>Category URL Base Slug</label>
                    <input id="title" class="form-control"  type="text" value="<?php echo dm_get_option('curl_base','download-category'); ?>" name="set[curl_base]" />
                </div>
                <div class="form-group">
                    <label>File URL Base Slug</label>
                    <input id="title" class="form-control"  type="text" value="<?php echo dm_get_option('furl_base','download'); ?>" name="set[furl_base]" />
                </div>
                        </div>
                    </div>



                <div class="panel panel-default" id="package-settings-section">
                    <div class="panel-heading"><b>File Download Settings</b></div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label>Download Speed</label>
                            <div class="input-group" style="width: 150px"><input class="form-control"  type="number" value="<?php echo dm_get_option('speed','1024'); ?>" name="set[speed]" /><span class="input-group-addon" id="sizing-addon1">KB/s</span></div>
                        </div>
                        <div  class="form-group"><hr/>
                            <label>Parallel Download from Same IP</label><br/>
                            <label class="eden-radio" style="margin-right: 20px"><input type="radio" name="set[parallel]" value="1" <?php echo dm_get_option('parallel',0)==1?'checked=checked':''; ?> /><span class="fa fa-check"></span> Allowed</label>
                            <label class="eden-radio"><input type="radio" name="set[parallel]" value="0" <?php echo dm_get_option('parallel',0)==0?'checked=checked':''; ?> /><span class="fa fa-check"></span> Not Allowed</label>
                        </div>
                        <div  class="form-group"><hr/><input type="hidden" name="set[oib]" value="0" />
                            <label class="eden-check" style="margin-right: 20px"><input type="checkbox" name="set[oib]" value="1" <?php echo dm_get_option('oib',0)==1?'checked=checked':''; ?> /><span class="fa fa-check"></span> Open in Browser</label><br/>
                            <em>Try to Open in Browser instead of download when someone clicks on download link </em>

                        </div>
                    </div>
                </div>















                <div class="panel panel-primary " id="form-action">
                    <div class="panel-heading">
                        <b>Actions</b>
                    </div>
                    <div class="panel-body">



                        <button type="submit" accesskey="p" tabindex="5" id="publish" class="btn btn-success btn-lg" name="publish"><i class="fa fa-save" id="psp"></i> &nbsp; Save Settings</button>

                    </div>
                </div>



    </form>
</div>
</div>
