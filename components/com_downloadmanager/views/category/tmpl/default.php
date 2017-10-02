<?php

/**
 * @version     1.0.0
 * @package     com_downloadmanager
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Shaon <scripteden@gmail.com> - http://scripteden.com
 */


defined('_JEXEC') or die('Restricted access');

$jinput = JFactory::getApplication()->input;
$id = $jinput->get('id');
if( $id > 0 )
{
    $db = JFactory::getDBO();
    $query = $db->getQuery(true);
    $query
        ->select('*')
        ->from($db->quoteName('#__dm_packages'))
        ->where("category like '%$id%'");
    $db->setQuery($query);
    $packs = $db->loadObjectList();

    $query = $db->getQuery(true);
    $query
        ->select('*')
        ->from($db->quoteName('#__dm_categories'))
        ->where('cid = '.$id);
    $db->setQuery($query);
    $cat = $db->loadObject();

}


?>


<div class="wpdm-front w3eden">
<h2><?php echo $cat->name; ?></h2>

 <div class="row">

     <?php foreach($packs as $pack){ ?>
         <div class="col-md-12">
         <div class="panel panel-default">
             <div class="panel-body">
                 <div class="media">
                     <div class="pull-left">
                        <?php if($pack->preview!=''){ ?>
                        <img class="img-rounded" src="<?php echo dm_dynamic_thumb($pack->preview, array(200, 150)); ?>" />
                        <?php } ?>
                     </div>
                     <div class="media-body"> 
                        <h3><a href="<?php echo JRoute::_(array('option' => 'com_downloadmanager', 'view' => 'package', 'id' => $pack->id));?>"><?php echo $pack->title; ?></a></h3>
                        <p><?php echo $pack->excerpt; ?></p>
                     </div>
                 </div>
             </div>
             <div class="panel-footer">
                 <div class="pull-left"><i class="fa fa-download"></i> <?php echo $pack->download_count; ?> Download(s)</div>
                 <div class="pull-left"><i class="fa fa-database"></i> <?php echo $pack->package_size; ?></div>
                 <div class="pull-left"><i class="fa fa-calendar"></i> <?php echo date("M d, Y", $pack->create_date); ?></div>
                 <div class="clear"></div>
             </div>
         </div>
         </div>
     <?php } ?>

 </div>


</div>


