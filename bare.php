<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
*/

// no direct access
defined( '_JEXEC' ) or die;

// import library dependencies
jimport('joomla.plugin.plugin');

/*
 * syntax 
 * 
 * {bare option_1_1=[value_1_1]}bare content 1{/bare}
 * {bare option_2_1=[value_2_1] option_2_2=[value_2_2]}bare content 2{/bare}
 */
class plgContentBare extends JPlugin
{
	protected $autoloadLanguage = true;
	
	/**
	 * @param	string	The context of the content being passed to the plugin
	 * @param	object	The article object
	 * @param	object	The article params
	 * @param	int		The article number, in case we are in a list of articles
	 */
	public function onContentPrepare($context, &$article, &$params, $page = 0)
	{
		$canProceed = ($context == 'com_content.article' || $context == 'com_content.category' || $context == 'com_content.featured');
		if (!$canProceed) {
			return true;
		}
		
		$app = JFactory::getApplication();	
		
		if ($app->isAdmin()) {
			return true;
		}
				
		// get the plugin parameter
		$additional_label = $this->params->get('additional_label', '');
		if (empty($additional_label)) {
			$additional_label = JText::_('PLG_CONTENT_BARE_ADDITIONALLABEL'); // to handle multi-languages
		}
		
		// text to match
		$regex = "#{bare\s*(.*?)}(.*?){/bare}#s";

		// remove the {bare} syntax from the articles in lists
		if ($context == 'com_content.category' || $context == 'com_content.featured') {
			$article->text = preg_replace($regex, '', $article->text);
			return true;
		}
		
		// find all instances of the regex and put in $matches
		preg_match_all($regex, $article->text, $matches, PREG_SET_ORDER);
		
		// process the syntax found
		if ($matches) {
//			var_dump ($matches);
			
// 			without PREG_SET_ORDER

// 			array (size=3)
// 				0 => array (size=2)
// 					0 => string '{bare option_1_1=[value_1_1]}bare content 1{/bare}' (length=50)
// 					1 => string '{bare option_2_1=[value_2_1] option_2_2=[value_2_2]}bare content 2{/bare}' (length=73)
// 				1 => array (size=2)
// 					0 => string 'option_1_1=[value_1_1]' (length=22)
// 					1 => string 'option_2_1=[value_2_1] option_2_2=[value_2_2]' (length=45)
// 				2 => array (size=2)
// 					0 => string 'bare content 1' (length=14)
// 					1 => string 'bare content 2' (length=14)

// 			with PREG_SET_ORDER
			
// 			array (size=2)
// 				0 => array (size=3)
// 					0 => string '{bare option_1_1=[value_1_1]}bare content 1{/bare}' (length=50)
// 					1 => string 'option_1_1=[value_1_1]' (length=22)
// 					2 => string 'bare content 1' (length=14)
// 				1 => array (size=3)
// 					0 => string '{bare option_2_1=[value_2_1] option_2_2=[value_2_2]}bare content 2{/bare}' (length=73)
// 					1 => string 'option_2_1=[value_2_1] option_2_2=[value_2_2]' (length=45)
// 					2 => string 'bare content 2' (length=14)
			
			foreach ($matches as $match) {
				
				$replacement = $match[2].' <span class="label label-info">'.$additional_label.'</span>';
				$article->text = preg_replace($regex, $replacement, $article->text, 1); // found one match then stop
			}
		}		
			
		// no return value
	}
	
	/**
	 * @param	string	The context of the content being passed to the plugin
	 * @param	object	The article object
	 * @param	object	The article params
	 * @param	int		The article number, in case we are in a list of articles
	 */
	public function onContentBeforeDisplay($context, &$article, &$params, $page = 0)
	{
		$article->title = $article->title.' [testing plugin]';
	}
	
}