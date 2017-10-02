<?php
/**
 * @version 1.0 $Id: helper.php 0 2013-12-20
 * @package Joomla
 * @subpackage DMS
 * @author daryl
 * @copyright (C) 2013 RMIS www.rmisos.net
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

class modDmsHelper extends JObject {
	public $params;
	public $model;
	public $documents;
	public $images;
	function __construct(&$params) {
		$this->params = $params;
		$this->model = new dmsModelBod($params);
		$this->images = $this->model->getImages();
		$this->documents = $this->model->getDocuments();
		//var_dump($this->documents);die;
		$this->loadCSS();
		$this->loadJS();
	}
	private function loadCSS() {
		$document	= JFactory::getDocument();
		$document->addStyleSheet('/components/com_dms/assets/css/flist-thumbs-bod.css');
		//$document->addStyleSheet('/components/com_dms/assets/css/dms.css');
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6')) {
			$document->addStyleSheet('/components/com_dms/assets/css/dms-ie.css');
		}
	}
	private function loadJS() {
		if (DMSHelper::is30()) {
			JHtmlBehavior::framework(true);
		} else {
			JHTML::_('behavior.mootools');
		}
		if ($this->params->get('tips') == 'yes') DMSHelper::addMooTips();
	}
	public function getCategory() {
		$db = JFactory::getDBO();
		$sett = DMSHelper::getSettings();
		$cat = $this->params->get( 'cat' );
		JRequest::setVar('cat', $cat);
		if ($sett->display_titles) {
			$q = 'SELECT id, title FROM #__categories WHERE id = '.$cat;
			$db->setQuery($q);
			$row = $db->loadObject();
			$category = $row->title;
			$html = '<h4>'.$category.'</h4>';
			return $html;
		}
		return '';
	}
	function setImage($index = 0) {
		if (isset($this->images[$index])) {
			$this->img = &$this->images[$index];
		} else {
			$this->img = new JObject;
		}
	}
	function setDoc($index = 0)	{
		if (isset($this->documents[$index])) {
			$this->doc = &$this->documents[$index];
		} else {
			$this->doc = new JObject;
		}
	}
	function printDocHTML() {
		$doc = $this->doc;
		$title = $doc->doc_title;
		if ($this->params->get('tips') == 'yes') {
				?><div id="doc<?php echo $doc->doc_id; ?>_tip" style="display:none;"><h3><?php echo JText::_('Download'); ?></h3><?php echo $doc->summary; ?></div>
				<div id="doc<?php echo $doc->doc_id; ?>" class="imgOutline mooTips" rel="{content:'doc<?php echo $doc->doc_id; ?>_tip',hovered:true}"><?php
		} else {
				?><div class="imgOutline"><?php
		}
		?>
			<div class="imgTotal">
				<div class="imgBorder">
					<?php echo $this->doc->getIconDownloadHTML(); ?>
				</div>
			</div>
			<?php if ($this->params->get('permicons') == 'yes') { ?>
			<div class="permIcon">
				<img src="<?php echo $doc->picon; ?>" alt="<?php echo $doc->picon; ?>" />
			</div>
			<?php } ?>
			<div class="imginfoBorder">
				<a href="index.php?option=com_dms&task=bod.aquire&did=<?php echo $doc->doc_id; ?>">
				<?php echo substr($title, 0, 9).(strlen($title) > 9 ? '<br>'.substr($title, 9) : ''); ?>
				</a>
			</div>
		</div>
		<?php
	}
	function printImgHTML() {
		$img = $this->img;
		$location = $img->basedir.'/'.$img->doc_location;
		$title = $img->doc_title;
		if ($this->params->get('tips') == 'yes') {
				?><div id="doc<?php echo $img->doc_id; ?>_tip" style="display:none;"><h3><?php echo JText::_('Download'); ?></h3><?php echo $img->summary; ?></div>
				<div id="doc<?php echo $img->doc_id; ?>" class="imgOutline mooTips" onClick="window.location.href='index.php?option=com_dms&task=bod.aquire&did=<?php echo $img->doc_id; ?>';" rel="{content:'doc<?php echo $img->doc_id; ?>_tip',hovered:true}"><?php
		} else {
				?><div class="imgOutline"><?php
		}
		?>
			<div class="imgTotal">
				<div align="center" class="imgBorder">
					<div class="image">
						<a href="index.php?option=com_dms&task=bod.aquire&did=<?php echo $img->doc_id; ?>&tmpl=component&format=raw" title="<?php echo $img->doc_title; ?>" class="modal" rel="{handler: 'iframe', size: {x: 650, y: 465}}">
							<img id="doc_<?php echo $img->doc_id; ?>" src="index.php?option=com_dms&task=bod.aquire&did=<?php echo $img->doc_id; ?>&tmpl=component&format=raw" width="<?php echo $img->width_60; ?>" height="<?php echo $img->height_60; ?>" alt="<?php echo $img->doc_title; ?> - <?php echo DMSHelper::parseSize($img->size); ?>" border="0" />
						</a>
					</div>
				</div>
			</div>
			<?php if ($this->params->get('permicons') == 'yes') { ?>
			<div class="permIcon">
					<img src="<?php echo $img->picon; ?>" alt="<?php echo $img->picon; ?>" />
			</div>
			<?php } ?>
			<div class="imginfoBorder">
				<a href="index.php?option=com_dms&task=bod.aquire&did=<?php echo $img->doc_id; ?>&tmpl=component&format=raw" class="modal" rel="{handler: 'iframe', size: {x: 650, y: 465}}">
				<?php echo substr($title, 0, 9).(strlen($title) > 9 ? '<br>'.substr($title, 9) : ''); ?>
				</a>
			</div>
		</div>
		<?php
	}
}
