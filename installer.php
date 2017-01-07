<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die;

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

/**
 * Installer script file for the content bare plugin
 */
class plgcontentbareInstallerScript
{	
	static $version = '1.0.0';
	
	/**
	 * Called before an install/update method
	 *
	 * @return  boolean  True on success
	 */
	public function preflight($type, $parent) 
	{

	}
	
	/**
	 * Called after an install/update method
	 *
	 * @return  boolean  True on success
	 */
	public function postflight($type, $parent) 
	{				
 		echo '<p style="margin: 20px 0">';	
		echo JText::_('PLG_CONTENT_BARE_VERSION').' <span class="label">'.self::$version.'</span>';
		echo '<br /><br />Olivier Buisard @ <a href="http://www.simplifyyourweb.com" target="_blank">Simplify Your Web</a>';
 		echo '</p>';			
			
		if ($type == 'update') {
			
			// update warning
			
			JFactory::getApplication()->enqueueMessage(JText::_('PLG_CONTENT_BARE_WARNING_RELEASENOTES'), 'warning');
		}	
		
		return true;
	}	
	
	/**
	 * Called on installation
	 *
	 * @return  boolean  True on success
	 */
	public function install($parent) {}
	
	/**
	 * Called on update
	 *
	 * @return  boolean  True on success
	 */
	public function update($parent) {}
	
	/**
	 * Called on uninstallation
	 */
	public function uninstall($parent) {}
	
}
?>