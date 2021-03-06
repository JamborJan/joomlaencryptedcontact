# Encrypted Contact Form for Joomla!
A simple contact form that sends a PGP encrypted message.

This module uses the PGP Java Script implementation of keybas.io's kbpgp. It's actively maintained by keybas.io and under a BSD license.

- https://keybase.io/
- https://keybase.io/kbpgp
- https://en.wikipedia.org/wiki/BSD_licenses

You can use this module with 3 different options.

keybase.io
If you have a keybas.io account, simply provide your user name and the module we retrieve your public PGP key from there. As a keybas.io account can only be created with an invitation these days feel free to contact me. As long as I have invites I'm happy to share them (https://jambor.pro/contact).

Link to your pgp.asc file
You can also put your public PGP key on your webserver or any other accessible place. Simply put the link to the file in the respective field and the module will retrieve the key from there. This is pgpasc.org's approach. If you want to learn more about alternative key distribution visit their web page at pgpasc.org (http://pgpasc.org/).

Text PGP Key
You can also copy and paste the text version of your key in the module settings. The module will then use this key.

# Download

You can download the latest version here: https://jambor.pro/joomlaencryptedcontact.zip

# Status
This is my first Joomla module ever. This is the first version of the module. You can see it live working at my personal page https://jambor.pro/en/contact.

# Requirements
Your Joomla instance should be able to send emails. This module makes use of the email server configured within Joomla >> Configuration >> Server >> Mailing.

The PHP function file_get_contents must be allowed for loading a public PGP from keybase.io or your pgp.asc location. If you cannot activate this option you would have to copy your public key in the settings of the module.

# Installation
- Download the ZIP file
- Install it in your Joomla instance
- Go to the modules sections and look for the newly installed module
- Make all settings and insert your text which should be displayed
- Decide where your contact module should be placed
- Save the module

# How to create a single contact page
I wanted to create a lightweight and flexible module no complete Joomla component. That’s why it’s not possible to create a menu item of the type "Joomla Encrypted Contact".

To have a similar result simply follow these steps:
- Create a new article where you write the text you want to have displayed on your contact page
- Create your submenu
- Make it of the type single article and select the previous created article
- Make sure that your contact module is only displayed when the new menu is selected

You can check my examples here https://jambor.pro/en/contact and here http://2traveling.info/de/kontakt

# Support
Create a new issue if you find a bug or have a feature request.

# Credits
This has been crafted while listening to Tenacious D.

Now go, my son and rock!