<?php 
// No direct access
defined('_JEXEC') or die; ?>

<h1>Contact</h1>

<p>You can use this form to send an encrypted message. The form will generate the encrypted version of your message and you can send it right away.<p>

<form>

<input type="text" id="yourname" value="Your name"/>
<input type="text" id="youremail" value="Your email address"/>
<br/><br/>
<textarea id="plaintext" name="plaintext" style="width: 100%; height: 150px">
Your message.
</textarea>
<br/><br/>
<input type="button" id="encryptmessage" name="encryptmessage" onclick="encryptMessage();" value="encrypt message">
<br/><br/>
<textarea name="encrypted" id="encrypted" style="width: 100%; height: 150px;">
<?php echo $hello; ?>
</textarea>
<br/><br/>
<input name="Submit" type="submit" value="Submit" />

</form>

<script type="text/javascript" src="modules/mod_encryptedcontact/kbpgp/kbpgp-1.0.0.js"> </script>
<script type="text/javascript">

	function encryptMessage() {
		
		var jamborjan;
		var client = new XMLHttpRequest();
		client.open('GET', 'https://keybase.io/jamborjan/key.asc');
		client.onreadystatechange = function() {
			jj_pgp_key = client.responseText;
		};
		client.send();
		
		kbpgp.KeyManager.import_from_armored_pgp({
			armored: jj_pgp_key
			}, function(err, jj) {
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
	
</script>
