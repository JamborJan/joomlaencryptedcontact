<?php
/**
 * Encrypted Contact Form for Joomla! Module Entry Point
 * 
 * @package 	mod_encryptedcontact
 * @link 		https://github.com/JamborJan/joomlaencryptedcontact
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html (c) 2015 Jan Jambor, see LICENSE
 */
 
// no direct access
defined('_JEXEC') or die;
// Include the syndicate functions only once
require_once( dirname(__FILE__) . '/helper.php' );
 
$pgppubkey = mod_encryptedcontactHelper::getPubPGPKey($params);
require( JModuleHelper::getLayoutPath('mod_encryptedcontact'));

?>
