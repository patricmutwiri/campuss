<?php
/**
 * @version     1.0.0
 * @package     com_downloadmanager
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Shaon <scripteden@gmail.com> - http://scripteden.com
 */


defined('_JEXEC') or die('Restricted access');

class DownloadManagerHelper extends JHelperContent
{
    protected  $toolbar_items;
    function CustomToolbar(){

        //$this->AddToolbarLink("<i class='fa fa-user'></i> Subscribers", "index.php?option=com_downloadmanager&view=subscribers", "btn btn-success");
        $this->AddToolbarLink("<i class='fa fa-cogs'></i> Settings", "index.php?option=com_downloadmanager&view=settings", "btn btn-danger");

        ?>

        <div class="dm-toolbar w3eden" id="dm-toolbar">

            <div class="btn-group">
                <a type="button" href="index.php?option=com_downloadmanager&view=packages" class="btn btn-primary">Packages</a>
                <a type="button" class="btn btn-primary" href="index.php?option=com_downloadmanager&view=package">
                    <i class="fa fa-plus"></i>
                </a>
            </div>
            <div class="btn-group">
                <a type="button" href="index.php?option=com_downloadmanager&view=categories" class="btn btn-info">Categories</a>
                <a type="button" class="btn btn-info" href="index.php?option=com_downloadmanager&view=category">
                    <i class="fa fa-plus"></i>
                </a>
            </div>

            <?php foreach($this->toolbar_items as $item) echo '&nbsp;'.$item.'&nbsp;'; ?>

        </div>

        <?php
    }

    function AddToolbarLink($label, $url, $cssclass = 'btn btn-default'){
        $this->toolbar_items[] = "<a href='{$url}' class='{$cssclass}'>{$label}</a>";
    }

    public static function FileInput($id = 'file', $name = 'file'){
        ?>
            <script src="<?php echo JUri::base() ?>components/com_downloadmanager/assets/plupload/plupload.full.min.js"></script>


        <div id="upload-ui-<?php echo $id; ?>" class="plupload-upload-ui">
            <div id="drag-drop-area-<?php echo $id; ?>">
                <div class="drag-drop-inside">
                    <p class="drag-drop-info">Drop Files Here</p>
                    <p>&mdash; OR &mdash;</p>
                    <p class="drag-drop-buttons"><button id="browse-button-<?php echo $id; ?>" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> &nbsp; Select Files</button></p>
                </div>
            </div>
        </div>


        <script type="text/javascript">

            jQuery(document).ready(function($){


                var uploader = new plupload.Uploader({
                    runtimes : 'html5,flash,silverlight,html4',
                    browse_button : 'browse-button-<?php echo $id; ?>',
                    container: document.getElementById('upload-ui-<?php echo $id; ?>'),
                    autostart : true,
                    url : 'index.php?option=com_downloadmanager&view=package&task=Upload',
                    flash_swf_url : '<?php echo JUri::base('components/com_downloadmanager/assets/pluplaod/Moxie.swf') ?>',
                    silverlight_xap_url : '<?php echo JUri::base('components/com_downloadmanager/assets/pluplaod/Moxie.xap') ?>',

                    filters : {
                        max_file_size : '1000mb',
                        mime_types: [
                            {title : "All Files", extensions : "*"}
                        ]
                    },

                    init: {
                        PostInit: function() {
                            document.getElementById('filelist-<?php echo $id; ?>').innerHTML = '';

//                            document.getElementById('uploadfiles').onclick = function() {
//                                uploader.start();
//                                return false;
//                            };
                        },

                        FilesAdded: function(up, files) {

                            plupload.each(files, function(file){
                                jQuery('#filelist-<?php echo $id; ?>').append(
                                    '<div class="file" id="' + file.id + '"><b>' +

                                    file.name + '</b> (<span>' + plupload.formatSize(0) + '</span>/' + plupload.formatSize(file.size) + ') ' +
                                    '<div class="progress progress-success progress-striped active"><div class="bar fileprogress"></div></div></div>');
                            });

                            up.refresh();
                            up.start();
                        },

                        UploadProgress: function(up, file) {
                            //document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
                            jQuery('#' + file.id + " .fileprogress").width(file.percent + "%");
                            jQuery('#' + file.id + " span").html(plupload.formatSize(parseInt(file.size * file.percent / 100)));
                        },

                        Error: function(up, err) {
                            document.getElementById('console-<?php echo $id; ?>').innerHTML += "\nError #" + err.code + ": " + err.message;
                        }
                    }
                });

                uploader.init();




                // a file was uploaded
                uploader.bind('FileUploaded', function(up, file, response) {

                    // this is your ajax response, update the DOM with it or something...
                    //console.log(response);
                    //response
                    jQuery('#' + file.id ).remove();
                    var d = new Date();
                    var ID = d.getTime();
                    response = response.response;
                    var nm = response;
                    if(response.length>20) nm = response.substring(0,7)+'...'+response.substring(response.length-10);

                    var html = jQuery('#wpdm-file-entry').html();
                    var ext = response.split('.');
                    ext = ext[ext.length-1];
                    var icon = "file-type-icons/"+ext+".png";
                    html = html.replace(/##filepath##/g, response);
                    html = html.replace(/##fileindex##/g, ID);
                    html = html.replace(/##preview##/g, icon);
                    //jQuery('#currentfiles').prepend(html);
                    jQuery('#currentfiles').html(html);



                });




            });

        </script>
        <div id="filelist-<?php echo $id; ?>" class="filelist"></div>
        <div id="console-<?php echo $id; ?>"></div>

        <?php
    }

    static public function getModalButtonObject($name,$text,$link,$width=850,$height=600)
    {
        JHTML::_('behavior.modal', "a.{$name}");  // load the modal behavior for the name u given
        $buttonMap = new JObject();   // create an Jobject which will contain some data, it is similar like stdClass object
        $buttonMap->set('modal', true);
        $buttonMap->set('text', $text );
        $buttonMap->set('name', 'image');
        $buttonMap->set('modalname', $name);
        $buttonMap->set('options', "{handler: 'iframe', size: {x: ".$width.", y: ".$height."}}");
        $buttonMap->set('link', $link);
        ?>
            <a id="<?php echo $buttonMap->modalname; ?>" class="<?php echo $buttonMap->modalname; ?>" title="<?php echo $buttonMap->text; ?>" href="<?php echo $buttonMap->link; ?>" rel="<?php echo $buttonMap->options; ?>"><?php echo $buttonMap->text; ?></a>

        <?php
    }
}
