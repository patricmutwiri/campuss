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

 
            <div id="currentfiles">

                <?php

                $files = unserialize($post->files);

                if (!is_array($files)) $files = array();

                ?>

                <table class="table table-striped" id="wpdm-files">
                    <thead>
                    <tr>
                        <th style="width: 50px;background: transparent;">Action</th>
                        <th style="width: 40%;">Filename</th>
                        <th style="width: 40%;">Title</th>
                        <th style="width: 130px;background: transparent;">Password</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    foreach ($files as $file_index => $file):
                        ?>
                        <tr class="cfile">
                            <td style="width: 50px;">
                                <input class="fa" type="hidden" value="<?php echo $file['path']; ?>" name="pack[files][<?php echo $file_index; ?>][path]">
                                <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>
                            </td>
                            <td style="width: 40%;"><div style="height: 20px;overflow: hidden" title="<?php echo $file['title']; ?>" class="ttip"><?php echo basename($file['path']); ?></div></td>
                            <td style="width: 35%;"><input type="text" name='pack[files][<?php echo $file_index; ?>][title]' class="form-control" value="<?php echo $file['title']; ?>" />
                            </td>
                            <td style="width: 150px;"><input  class="form-control" type="text" id="indpass_<?php echo $file_index; ?>" name='pack[files][<?php echo $file_index; ?>][password]' value="<?php echo $file['password']; ?>"> </td>
                        </tr>
                    <?php
                    endforeach;
                    ?>
                    </tbody>
                </table>


                <?php if ($files): ?>
                    <script type="text/javascript">

                        jQuery('.ttip').tooltip();
                        jQuery('img[rel=del], img[rel=undo]').click(function () {

                            if (jQuery(this).attr('rel') == 'del') {

                                jQuery(this).parents('tr.cfile').removeClass('cfile').addClass('dfile').find('input.fa').attr('name', 'del[]');
                                jQuery(this).attr('rel', 'undo').attr('src', '<?php echo plugins_url(); ?>/download-manager/images/add.png').attr('title', 'Undo Delete');

                            } else {


                                jQuery(this).parents('tr.dfile').removeClass('dfile').addClass('cfile').find('input.fa').attr('name', 'file[files][]');
                                jQuery(this).attr('rel', 'del').attr('src', '<?php echo plugins_url(); ?>/download-manager/images/minus.png').attr('title', 'Delete File');


                            }


                        });


                    </script>


                <?php endif; ?>


            </div>


