<?php
/**
 * Encrypted Contact Form for Joomla! Module Entry Point
 * 
 * @package 	mod_encryptedcontact
 * @link 		https://github.com/JamborJan/joomlaencryptedcontact
 * @license 	The MIT License (MIT) Copyright (c) 2015 Jan Jambor, see LICENSE
 */
 
// no direct access
defined('_JEXEC') or die;
// Include the syndicate functions only once
require_once( dirname(__FILE__) . '/helper.php' );
 
$pgppubkey = mod_encryptedcontactHelper::getPubPGPKey($params);
require( JModuleHelper::getLayoutPath('mod_encryptedcontact'));

?>
