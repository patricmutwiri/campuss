<?php

/** @Copyright Copyright (C) 2011
 * @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
 + Created by:	Ahmad Bilal
 * Company:		Buruj Solutions
 + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	Oct 22, 2011
 ^
 + Project:		JS Documentation 
*/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class com_JSJobsInstallerScript
{

	/**
	 * method to install the component
	 *
	 * @return void
	 */
	function install($parent) 
	{

		// $parent is the class calling this method
		$parent->getParent()->setRedirectURL('index.php?option=com_jsjobs&view=installer&layout=sampledata');
	}

	/**
	 * method to uninstall the component
	 *
	 * @return void
	 */
	function uninstall($parent) 
	{
		// $parent is the class calling this method
		echo '<p>' . JText::_('JS_JSJOBS_UNINSTALL_TEXT') . '</p>';
	}

	/**
	 * method to update the component
	 *
	 * @return void
	 */
	function update($parent) {

		
	}

	/**
	 * method to run before an install/update/uninstall method
	 *
	 * @return void
	 */
	function preflight($type, $parent) 
	{
	}

	/**
	 * method to run after an install/update/uninstall method
	 *
	 * @return void
	 */
	function postflight($type, $parent) 
	{
		jimport('joomla.installer.helper');
		$installer = new JInstaller();
		//$installer->_overwrite = true;

		$ext_module_path = JPATH_ADMINISTRATOR.'/components/com_jsjobs/extensions/modules/';
		
			$extensions = array(
				'mod_jsjobslogin.zip'=>'JS Jobs Login Module'

			 );
             
			echo "<br /><br /><font color='green'><strong>Installing modules</strong></font>";
			 foreach( $extensions as $ext => $extname ){
				  $package = JInstallerHelper::unpack( $ext_module_path.$ext );
				  if( $installer->install( $package['dir'] ) ){
					echo "<br /><font color='green'>$extname successfully installed.</font>";
				  }else{
					echo "<br /><font color='red'>ERROR: Could not install the $extname. Please install manually.</font>";
				  }
				JInstallerHelper::cleanupInstall( $ext_module_path.$ext, $package['dir'] ); 
			}


			echo "<br /><br /><font color='green'><strong>Installing plugins</strong></font>";
			$ext_plugin_path = JPATH_ADMINISTRATOR.'/components/com_jsjobs/extensions/plugins3/';
			$extensions = array( 
				'plg_jsjobsregister.zip'=>'JS Jobs Register Plugin'

			 );
				 
			 foreach( $extensions as $ext => $extname ){
				  $package = JInstallerHelper::unpack( $ext_plugin_path.$ext );
				  if( $installer->install( $package['dir'] ) ){
					echo "<br /><font color='green'>$extname successfully installed.</font>";
				  }else{
					echo "<br /><font color='red'>ERROR: Could not install the $extname. Please install manually.</font>";
				  }
				JInstallerHelper::cleanupInstall( $ext_plugin_path.$ext, $package['dir'] ); 
			}
		
	}



}

