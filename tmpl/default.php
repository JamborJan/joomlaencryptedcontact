<?php 
/**
 * Encrypted Contact Form for Joomla!
 * 
 * @package 	mod_encryptedcontact
 * @link 		https://github.com/JamborJan/joomlaencryptedcontact
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html (c) 2015 Jan Jambor, see LICENSE
 */

// No direct access
defined('_JEXEC') or die;

$show_pgp_key = $params->get('show_pgp_key');
$show_pgp_text = $params->get('show_pgp_text');
$enable_file_upload = $params->get('enable_file_upload');

?>

<?php 
if(isset($_POST['submit'])){

	// We'll ned that later 
	$readonly = 1;
	$yourname = htmlspecialchars($_POST['yourname']);
	$youremail = htmlspecialchars($_POST['youremail']);
	$message = htmlspecialchars($_POST['message']);

	// see https://docs.joomla.org/Sending_email_from_extensions
    $mailer = JFactory::getMailer();
    $config = JFactory::getConfig();
	$sender = array( 
    	$config->get( 'config.mailfrom' ),
    	$config->get( 'config.fromname' )
    ); 
	$mailer->setSender($sender);
	$recipient = $params->get('email_recipient');
	$mailer->addRecipient($recipient);
	if (substr($message, 0, 27 ) != '-----BEGIN PGP MESSAGE-----') {
		$body = "Name: ".$yourname."\r\n E-Mail: ".$youremail."\r\n\r\n".$message;
	} else {
		$body = $message;
	}
	$mailer->setSubject($params->get('email_subject'));
	$mailer->setBody($body);
	$send = $mailer->Send();
	if ( $send !== true ) {
	    // echo 'Error sending email: ' . $send->__toString();
	    echo '<p>Sorry your E-Mail was not send. We will try to fix that.</p>';
	} else {
    	echo '<p>'.$params->get('thank_you_text').'</p>';
	}
} else {
	// Fill in default text when page is loaded the first time 
	$readonly = 0;
	$yourname = JText::_('MOD_ENCRYPTEDCONTACT_YOUR_NAME');
	$youremail = JText::_('MOD_ENCRYPTEDCONTACT_YOUR_EMAIL');
	$message = $params->get('message_text');
}
?>

<?php if ($readonly == 0) echo '<p>'.$params->get('welcome_text').'</p>'; ?>

<?php
	// Button design for the form
	$font_color = $params->get('font_color');
	$bg_color = $params->get('bg_color');

	$button_design = '
		height: 60px;
		margin: 10px 0px 10px 0px;
		border: 1px solid '.$bg_color.';
		border-radius: 5px;
		color: '.$font_color.';
		font-weight: bold;
		padding: 10px 20px;
		font-size: 16px;
		background: '.$bg_color.';
		-webkit-appearance: none;
		-moz-appearance: none;
	';
?>

<form  name="formencryptmessage" method="post">
	<input type="text" id="yourname" name="yourname" value="<?php echo $yourname; ?>" onClick="this.setSelectionRange(0, this.value.length);" <?php if ($readonly == 1) echo ' DISABLED'; ?>/>
	<input type="text" id="youremail" name="youremail" value="<?php echo $youremail; ?>" onClick="this.setSelectionRange(0, this.value.length);" <?php if ($readonly == 1) echo ' DISABLED'; ?>/>
	<br/><br/>
	<textarea id="message" name="message" style="width: 100%; height: 150px" onClick="this.setSelectionRange(0, this.value.length);" <?php if ($readonly == 1) echo ' DISABLED'; ?>><?php echo $message; ?></textarea>
	<br/>
	<!-- START file upload-->
	<?php if ($enable_file_upload == 1) {
		echo $params->get('upload_text').' <br />';
		echo '<input type="file" id="upload_file" name="upload_file" size="40">';
	}?>

	<!-- END file upload-->
	<br/>
	<input style="<?php echo $button_design; ?>" type="button" id="encryptmessage" name="encryptmessage" onclick="encryptMessage();" value="<?php echo JText::_('MOD_ENCRYPTEDCONTACT_ENC_MESSAGE_BTN');?>" <?php if ($readonly == 1) echo ' DISABLED'; ?>/>
	<input style="<?php echo $button_design; ?>" name="submit" type="submit" value="<?php echo JText::_('MOD_ENCRYPTEDCONTACT_SUBMIT_BTN');?>" <?php if ($readonly == 1) echo ' DISABLED'; ?>/><br/>
	<!-- START area to JS-->
	<?php if ($show_pgp_key == 1) {echo '<br/><br/>'.$show_pgp_text.'<br/>';}?>
	<textarea name="pgppubkey" id="pgppubkey" style="width: 100%; height: 150px; <?php if ($show_pgp_key != 1) {echo 'display: none;';} ?>" onClick="this.setSelectionRange(0, this.value.length);" READONLY><?php echo $pgppubkey; ?></textarea>
	<!-- END transfer area to JS-->
</form>

<script type="text/javascript" src="modules/mod_encryptedcontact/kbpgp/kbpgp-1.0.0.js"> </script>
<script type="text/javascript">

	function encryptMessage() {

		var pgppubkey = document.getElementById('pgppubkey').value;

		var control = document.getElementById("upload_file");
		if (control) {
			var i = 0, files = control.files, len = files.length;
			console.log("Amount of files: " + len);
			for (; i < len; i++) {
		        console.log("Filename: " + files[i].name);
		        console.log("Type: " + files[i].type);
		        console.log("Size: " + files[i].size + " bytes");
			    if (len == 1) {
			    	// I know this is stupid now, but needed later if multiple files are supported
			    	var r = new FileReader();
			    	r.readAsBinaryString(files[i]);
			    	r.onloadend = function(file) {
	  					var buffer = new kbpgp.Buffer(r.result);
	  					//
	  					// TODO
	  					// Now we need to get this behind the message before encrypting
	  					//
					};
			    }
		    }
		}

		kbpgp.KeyManager.import_from_armored_pgp({
		  armored: pgppubkey
		}, function(err, target) {
		  if (!err) {

			var params = {
	  			encrypt_for: target,
	  			msg:         'Name: '+document.getElementById('yourname').value+'\r\n'+'E-Mail: '+document.getElementById('youremail').value+'\r\n\r\n'+document.getElementById('message').value // +buffer.toString('base64')
			};

			kbpgp.box(params, function(err, result_string, result_buffer) {
				document.getElementById('message').value = result_string;
	  			// console.log(err, result_string, result_buffer);
			});

		  } else {
		    console.log(err);		  	
		  }
		});
		
	}
	
</script>

