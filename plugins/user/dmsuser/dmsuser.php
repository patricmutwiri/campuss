<?php
/**
 * @version 1.0 $Id: dmsuser.php 0 2008-08-26 
 * @package Joomla
 * @subpackage DMS
 * @author daryl
 * @copyright (C) 2013 RMIS www.rmisos.net
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.plugin.plugin');
if (!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

if (file_exists(JPATH_ROOT.DS.'components'.DS.'com_dms'.DS.'helpers'.DS.'helper.php')) {
	require_once( JPATH_ROOT.DS.'components'.DS.'com_dms'.DS.'helpers'.DS.'helper.php');
}
class plgUserDmsuser extends JPlugin {

	function onUserAfterSave($user, $isnew, $succes, $msg) {
		return $this->onAfterStoreUser($user, $isnew, $succes, $msg);
	}
	function onAfterStoreUser($user, $isnew, $succes, $msg) {
		$mainframe = JFactory::getApplication();

		$this->findUser($user);
	}
	function onUserLogin($user, $options) {
		$this->findUser($user);
	}
	function findUser($user) {
		$config = JFactory::getConfig();
		$db = JFactory::getDBO();
		if ($this->isAuthor($user)) {
			$q = 'SELECT d.* FROM #__dms_user d'
				. ' LEFT JOIN #__users AS u ON u.id = d.user_id'
				. ' WHERE u.username = '.$db->Quote($user['username']);
			$db->setQuery($q);
			$udms = $db->loadObject();
			if (!$udms)	{/** FIX, might not be new **/
				$q = 'SELECT * FROM #__users WHERE username = '.$db->Quote($user['username']);
				$db->setQuery($q);
				$row = $db->loadObject();
				//require_once( JPATH_ROOT.DS.'components'.DS.'com_dms'.DS.'models'.DS.'author.php');
				jimport('joomla.utilities.date');
				jimport('joomla.application.component.*');
				$name = $user['username'];
				$user_id = $row->id; //$user['id'];
				$basedir = 'dms'.DS.$name.DS.'docs';
				$date = new JDate();
				if (DMSHelper::is30()) {
					$added = $date->toSql();
				} else {
					$added = $date->toMySQL();
				}
				$q = 'INSERT INTO #__dms_user VALUES (0, '.$user_id.', "'.$basedir.'", 0, "'.$added.'", 1)';
				$db->setQuery( $q );
				if(!$db->query()) {
					JError::raiseWarning(201, $db->getError());
					return false;
				}
			}

			jimport('joomla.filesystem.folder');
			require_once (JPATH_ROOT.DS.'components'.DS.'com_dms'.DS.'helpers'.DS.'helper.php');

			$sett = DMSHelper::dmsconfig();
			$path = JPATH_ROOT.DS.'dms'.DS.$user['username'].DS.'docs';
			if (!JFolder::exists($path)) {
				JFolder::create($path, 0775);
			}
			if ($sett->vault) {
				$path = $sett->vault.DS.$user['username'];
				if (!JFolder::exists($path)) {
					JFolder::create($path, 0775);
				}
			}
		}
	}
	function isAuthor($user) {
		$db = JFactory::getDBO();
		$q = 'SELECT * FROM #__users WHERE username = '.$db->Quote($user['username']);
		$db->setQuery($q);
		if ($row = $db->loadObject()) {
			$user = JFactory::getUser($row->id);
			if (DMSHelper::is17()) {
				$auths = $user->getAuthorisedGroups();
				$groups = array(3,4,5,6,7,8);
				foreach($groups as $auth) {
					if (in_array($auth, $auths)) {
						return true;
					}
				}
			} else {
				if ($user->gid >= AUTHOR) {
					return true;
				}
			}
		}
		return false;
	}

	function onBeforeDeleteUser($user) {
		$mainframe = JFactory::getApplication();
		if (DMSHelper::isAuthor()) {
			$sett = DMSHelper::dmsconfig();
			jimport('joomla.filesystem.folder');

			$path = JPATH_ROOT.DS.'dms'.DS.$user['username'].DS.'docs';
			if (JFolder::exists($path)) {
				JFolder::delete($path);
			}
			$path = JPATH_ROOT.DS.'dms'.DS.$user['username'];
			if (JFolder::exists($path)) {
				JFolder::delete($path);
			}
			$path = $sett->vault.DS.$user['username'];
			if (JFolder::exists($path)) {
				JFolder::delete($path);
			}
		}
	}

	function onAfterDeleteUser($user, $succes, $msg) {
		$mainframe = JFactory::getApplication();
		$config = JFactory::getConfig();
		$db = JFactory::getDBO();

	 	// only the $user['id'] exists and carries valid information

		if (DMSHelper::isAuthor()) {
			$q = 'select * from information_schema.tables where table_schema = "'.$config->getValue('db').'" and table_name = "jos_comprofiler"';
			$db->setQuery($q);
			if ($t = $db->loadObject()) {
				if (!DMSHelper::is30()) {
					$q = 'delete from #__dms_sections where user_id = '.$user['id'];
					$db->setQuery($q);
					$db->query();
				}
				$q = 'delete from #__dms_user where user_id = '.$user['id'];
				$db->setQuery($q);
				$db->query();
				$q = 'delete from #__dms_bank where user_id = '.$user['id'];
				$db->setQuery($q);
				$db->query();
			}
		}
	}
}
