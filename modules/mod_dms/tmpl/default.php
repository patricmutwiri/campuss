<?php
/**
 * @version 1.0 $Id: default.php 0 2008-08-26 
 * @package Joomla
 * @subpackage DMS
 * @author daryl
 * @copyright (C) 2013 RMIS www.rmisos.net
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<?php echo $helper->getCategory(); ?>

	<div class="dms">
		<?php
		
		for ($i=0,$n=count($helper->documents); $i<$n; $i++) {
			$doc = $helper->setDoc($i);
			$helper->printDocHTML();
		}

		for ($i=0,$n=count($helper->images); $i<$n; $i++) {
			$img = $helper->setImage($i);
			$helper->printImgHTML();
		}?>

	</div>
<?php
