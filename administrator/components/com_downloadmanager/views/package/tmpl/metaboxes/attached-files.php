<?php

/**
 * @version     1.0.0
 * @package     com_downloadmanager
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Shaon <scripteden@gmail.com> - http://scripteden.com
 */


defined('_JEXEC') or die('Restricted access');

$files = isset($post->files)? unserialize($post->files) : array();

if (!is_array($files)) $files = array();

//if(count($files)>15)
//include(dirname(__FILE__)."/attached-files-datatable.php");
//else {
?>


<div id="currentfiles" class="w3eden">



                    <?php



                    foreach ($files as $file_index => $file):

                        $value = $file['path'];

                        if(strlen($value)>50){
                            $svalue = substr($value, 0,23)."...".substr($value, strlen($value)-27);
                        }
                        $imgext = array('png','jpg','jpeg', 'gif');
                        $ext = explode(".", $value);
                        $ext = end($ext);
                        $ext = strtolower($ext);
                        $filepath = file_exists($value)?$value:JPATH_DM_UPLOAD.$value;
                        $thumb = "";
                        if(in_array($ext, $imgext))
                            $thumb = dm_dynamic_thumb($filepath, array(48, 48));

                        if($ext=='' || !file_exists(JPATH_DM_COM.'assets/file-type-icons/'.$ext.'.png'))
                            $ext = '_blank';
                        ?>
                        <div class="cfile" id="cfile-<?php echo $file_index; ?>">
                            <div class="panel panel-default" id="panel-<?php echo $file_index; ?>">
                                <input class="faz" type="hidden" value="<?php echo $value; ?>" name="pack[files][<?php echo $file_index; ?>][path]">
                                <div class="panel-heading"><button type="button" class="btn btn-xs btn-default pull-right" rel="del" data-pid="<?php echo $file_index; ?>"><i class="fa fa-times text-danger"></i></button> <span title="<?php echo $value; ?>"><?php echo strlen($value)<100?$value:substr($value, 0, 80).'...'; ?></span></div>
                                <div class="panel-body">
                                    <div class="media">
                                        <div class="pull-left">

                                            <img class="file-ico" onerror="this.src='<?php echo JURL_DM_COM.'assets/file-type-icons/_blank.png';?>';" src="<?php echo $thumb?$thumb:JURL_DM_COM.'assets/file-type-icons/'.$ext.'.png';?>" />
                                        </div>
                                    <div class="media-body">
                                    <input placeholder="File Title" title="File Title" class="form-control" type="text" name='pack[files][<?php echo $file_index; ?>][title]' value="<?php echo esc_html($file['title']); ?>" /><br/>
                                    <!-- div class="input-group">
                                    <input placeholder="File Password"  title="File Password" class="form-control inline" type="text" id="indpass_<?php echo $file_index; ?>" name='pack[files][<?php echo $file_index; ?>][password]' value="<?php echo esc_html($file['password']); ?>">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default" class="genpass" title='Generate Password' onclick="return generatepass('indpass_<?php echo $file_index; ?>')"><i class="fa fa-ellipsis-h"></i></button>
                                    </span>
                                    </div -->
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    endforeach;
                    ?>


</div>
                <?php if ($files): ?>
                    <script type="text/javascript">


                        jQuery('body').on('click','button[rel=del]', function () {


                            if(confirm('Are you sure?')){
                                jQuery('#cfile-'+jQuery(this).data('pid')).remove();
                            }


                            return false;
                        });

                        jQuery(function(){
                            //jQuery('#currentfiles').sortable();
                        });


                    </script>


                <?php endif; ?>



<?php //} ?>