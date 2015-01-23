<?php
/**
 * Helper class for Encrypted Contact Form for Joomla!
 * 
 * @package    ...
 * @subpackage ...
 * @link https://...
 * @license        GNU/GPL, see LICENSE.php
 * mod_encryptedcontact is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
class mod_encryptedcontactHelper
{
    /**
     * Retrieves the public pgp key
     *
     * @param array $params An object containing the module parameters
     * @access public
     */    
    public static function getPubPGPKey( $params )
    {
        $pgppubkey = 'initial state';
        $pgpkeyradio = $params->get('pgp_key_radio');

        if ($pgpkeyradio == 'keybase_user') {
            //keybase_user
            $filename = 'https://keybase.io/'.$params->get('keybase_user').'/key.asc';
            $pgppubkey = file_get_contents($filename);
        }

        if ($pgpkeyradio == 'pgp_asc_link') {
            //pgp_asc_link
            $filename = $params->get('pgp_asc_link');
            $pgppubkey = file_get_contents($filename);
        }

        if ($pgpkeyradio == 'pgp_txt_key') {
            //pgp_txt_key
            $pgppubkey = $params->get('pgp_txt_key');
        }

        return $pgppubkey;
    }
}
?>
