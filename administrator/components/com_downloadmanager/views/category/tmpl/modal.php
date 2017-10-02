<?php
/**
 * @version     1.0.0
 * @package     com_downloadmanager
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Shaon <scripteden@gmail.com> - http://scripteden.com
 */


defined('_JEXEC') or die('Restricted access');

ob_clean();
$app = JFactory::getApplication();

if ($app->isSite())
{
	JSession::checkToken('get') or die(JText::_('JINVALID_TOKEN'));
}

require_once JPATH_ROOT . '/components/com_downloadmanager/helpers/route.php';

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');


?>
<style>#dm-toolbar{ display: none; }</style>
<form style="padding: 20px" action=""  method="post" name="adminForm" id="adminForm" class="form-inline">
    <?php
    $jinput = JFactory::getApplication()->input;


    $query = "";
    $db = JFactory::getDBO();
    $query = $db->getQuery(true);
    $query
        ->select('*')
        ->from($db->quoteName('#__dm_categories'))
        ->order('name desc');
    $db->setQuery($query);
    $result = $db->loadObjectList();

    ?>

    <div class="w3eden">



        <!--form method="post" action="" id="posts-filter" -->




        <div class="clear"></div>


        <table cellspacing="0" class="table table-hover table-striped">
            <thead>
            <tr>

                <th style="" class="manage-column column-media sortable <?php echo $jinput->get('sorder')=='asc'?'asc':'desc'; ?>" id="media" scope="col"><a href='<?php echo  $burl.$sap;?>sfield=title&sorder=<?php echo $jinput->get('sorder')=='asc'?'desc':'asc'; ?><?php echo $qr; ?>&paged=<?php echo $paged;?>'><span>Category Title</span> <?php if($jinput->get('sfield')=='title') { echo $jinput->get('sorder')=='asc'?'<i class="fa fa-chevron-up" style="color:#D2322D;margin-left:10px"></i>':'<i class="fa fa-chevron-down" style="color:#D2322D;margin-left:10px"></i>'; } ?></a></th>
                <th style="width: 120px" class="manage-column column-media" id="media" scope="col" align="center">Actions</th>
            </tr>
            </thead>

            <tfoot>
            <tr>

                <th style="" class="manage-column column-media sortable <?php echo $jinput->get('sorder')=='asc'?'asc':'desc'; ?>" id="media" scope="col"><a href='<?php echo  $burl.$sap;?>sfield=title&sorder=<?php echo $jinput->get('sorder')=='asc'?'desc':'asc'; ?><?php echo $qr; ?>&paged=<?php echo $paged;?>'><span>Category Title</span> <?php if($jinput->get('sfield')=='title') { echo $jinput->get('sorder')=='asc'?'<i class="fa fa-chevron-up" style="color:#D2322D;margin-left:10px"></i>':'<i class="fa fa-chevron-down" style="color:#D2322D;margin-left:10px"></i>'; } ?></a></th>
                <th style="" class="manage-column column-media" id="media" scope="col" align="center">Actions</th>
            </tr>
            </tfoot>

            <tbody class="list:post" id="the-list">
            <?php foreach($result as $post) {

                ?>
                <tr valign="top" class="alternate author-self status-inherit" id="post-<?php echo $post->cid; ?>">



                    <td class="media column-media">
                        <a href="javascript:void(0)" onclick="if (window.parent) window.parent.<?php echo $this->escape($_REQUEST['function']);?>('<?php echo $post->cid; ?>', '<?php echo $this->escape(addslashes($post->name)); ?>', '<?php echo $this->escape($post->cid); ?>', null, '<?php echo $this->escape(DownloadManagerHelperRoute::getCategoryRoute($post->cid, $post->cid, 'en')); ?>', '<?php echo $this->escape('en'); ?>', null);">
                            <?php echo $post->name; ?></a>
                    </td>
                    <td class="actions"><a href='#' class='selectp btn btn-info btn-xs pull-right' rel='<?php echo $post->cid; ?>' title="Select Category" ><i class="fa fa-plus"></i></a></td>

                </tr>
            <?php } ?>
            </tbody>
        </table>

        <?php

        ?>

        <div id="ajax-response"></div>


        <!--/form-->
        <br class="clear">

    </div>
    <script language="JavaScript">
        <!--
//        jQuery(function(){
//            jQuery('#dm-toolbar').remove();
//            jQuery('body').on('click', '.selectp' ,function(){
//                var id = '#post-'+this.rel;
//                jQuery('#li-'+this.rel).html("<a href='#'><i class='fa fa-time'></i> Deleting...</a>");
//                jQuery.post('index.php?option=com_downloadmanager&view=package&task=delete&id='+this.rel,function(){
//                    jQuery(id).fadeOut();
//                }) ;
//                return false;
//            });
//            jQuery('.delp').popover({placement:'left', html:true});
//
//            jQuery('body').on('click', '.canceldelete',function(){
//                jQuery('.delp').popover('hide');
//                return false;
//            });
//
//        });
        //-->
    </script>
</form>
