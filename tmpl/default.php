<?php 
// No direct access
defined('_JEXEC') or die;
?>

<?php 
if(isset($_POST['submit'])){

	//echo '<script type="text/javascript">'
	//	, 'encryptMessage();'
	//	, '</script>'
	//;

	// see https://docs.joomla.org/Sending_email_from_extensions
    $mailer = JFactory::getMailer();
    $config = JFactory::getConfig();
	$sender = array( 
    	$config->get( 'config.mailfrom' ),
    	$config->get( 'config.fromname' )
    ); 
	$mailer->setSender($sender);
	$recipient = "website_contact@jambor.pro";
	$mailer->addRecipient($recipient);
	$body = $_POST['encrypted'];
	$mailer->setSubject('Message from contact form jambor.pro');
	$mailer->setBody($body);
	$send = $mailer->Send();
	if ( $send !== true ) {
	    // echo 'Error sending email: ' . $send->__toString();
	    echo '<p>Sorry your E-Mail was not send. We will try to fix that.</p>';
	} else {
    	echo '<p>Thanks for contacting me. I will reply as soon as possible.</p>';
	}
} else {
	echo '<p>You can use this form to send an encrypted message to me. The form will generate the encrypted version of your message and you can send it right from this page.';
	echo ' (This form is a self developed beta which makes use of <a href="https://keybase.io/kbpgp" target="_blank">keybas.io</a> Java Script implementation kbpgp.)</p>';
	echo '<form  name="formencryptmessage" method="post">';
	echo '	<input type="text" id="yourname" value="Your name" onClick="this.select();"/>';
	echo '	<input type="text" id="youremail" value="Your email address" onClick="this.select();"/>';
	echo '	<br/><br/>';
	echo '	<textarea id="plaintext" name="plaintext" style="width: 100%; height: 150px" onClick="this.select();"> Write your message here.</textarea>';
	echo '	<br/><br/>';
	echo '	<input type="button" id="encryptmessage" name="encryptmessage" onclick="encryptMessage();" value="encrypt message">';
	echo '	<br/><br/>';
	echo '	<textarea name="encrypted" id="encrypted" style="width: 100%; height: 150px;" onClick="this.select();">Your encrypted message will be shown here after you click "encrypt message".</textarea>';
	echo '	<br/><br/>';
	echo '	<input name="submit" type="submit" value="Submit" />';
	echo '</form>';
}
?>

<script type="text/javascript" src="modules/mod_encryptedcontact/kbpgp/kbpgp-1.0.0.js"> </script>
<script type="text/javascript">

	function loadPublicKey() {
		
		var jamborjan;
		var client = new XMLHttpRequest();
		client.open('GET', 'https://keybase.io/jamborjan/key.asc');
		client.onreadystatechange = function() {
			jj_pgp_key = client.responseText;
			console.log('jamborjan s key loaded');
		};
		client.send();
		
	}

	function encryptMessage() {
		
		kbpgp.KeyManager.import_from_armored_pgp({ armored: jj_pgp_key }, function(err, jj) {
  			if (!err) {
  				jamborjan = jj;
    			console.log('jamborjan is loaded');
  			}
		});
		
		var params = {
  			encrypt_for: jamborjan,
  			msg:         'Name: '+document.getElementById('yourname').value+'\n'+'E-Mail: '+document.getElementById('youremail').value+'\n\n'+document.getElementById('plaintext').value
		};

		kbpgp.box(params, function(err, result_string, result_buffer) {
			document.getElementById('encrypted').value = result_string;
  			//console.log(err, result_string, result_buffer);
		});
		
	}

	window.onload=loadPublicKey();
	
</script>
