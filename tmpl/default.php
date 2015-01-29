<?php 
// No direct access
defined('_JEXEC') or die;
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
	$body = $message;
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

<form  name="formencryptmessage" method="post">
	<input type="text" id="yourname" name="yourname" value="<?php echo $yourname; ?>" onClick="this.select();" <?php if ($readonly == 1) echo ' DISABLED'; ?>/>
	<input type="text" id="youremail" name="youremail" value="<?php echo $youremail; ?>" onClick="this.select();" <?php if ($readonly == 1) echo ' DISABLED'; ?>/>
	<br/><br/>
	<textarea id="message" name="message" style="width: 100%; height: 150px" onClick="this.select();" <?php if ($readonly == 1) echo ' DISABLED'; ?>><?php echo $message; ?></textarea>
	<br/><br/>
	<input type="button" id="encryptmessage" name="encryptmessage" onclick="encryptMessage();" value="<?php echo JText::_('MOD_ENCRYPTEDCONTACT_ENC_MESSAGE_BTN');?>" <?php if ($readonly == 1) echo ' DISABLED'; ?>/>
	<input name="submit" type="submit" value="<?php echo JText::_('MOD_ENCRYPTEDCONTACT_SUBMIT_BTN');?>" <?php if ($readonly == 1) echo ' DISABLED'; ?>/><br/>
	<!-- START area to JS-->
	<textarea name="pgppubkey" id="pgppubkey" style="width: 100%; height: 150px; display: none;" READONLY><?php echo $pgppubkey; ?></textarea>
	<!-- END transfer area to JS-->
</form>


<script type="text/javascript" src="modules/mod_encryptedcontact/kbpgp/kbpgp-1.0.0.js"> </script>
<script type="text/javascript">

	function encryptMessage() {

		var pgppubkey = document.getElementById('pgppubkey').value;

		kbpgp.KeyManager.import_from_armored_pgp({
		  armored: pgppubkey
		}, function(err, target) {
		  if (!err) {

			var params = {
	  			encrypt_for: target,
	  			msg:         'Name: '+document.getElementById('yourname').value+'\r\n'+'E-Mail: '+document.getElementById('youremail').value+'\r\n\r\n'+document.getElementById('message').value
			};

			kbpgp.box(params, function(err, result_string, result_buffer) {
				document.getElementById('message').value = result_string;
	  			console.log(err, result_string, result_buffer);
			});

		  } else {
		    console.log(err);		  	
		  }
		});
		
	}
	
</script>

