# Encrypted Contact Form for Joomla!
A simple contact form which sends an PGP encrypted message.

This Joomla module makes use of keybas.io Java Script implementation kbpgp.

# Status
This is my first Joomla Modul ever developed. This is the first version of the module. You can see it live working at my personal page https://jambor.pro.

# Requirements
Your Joomla instance should be able to send emails. This module makes use of the email server configured within Joomla >> Configuration >> Server >> Mailing.

The PHP function file_get_contents must be allowed for loading a public PGP from keybase.io or your pgp.asc location. If you cannot activate this option you would have to copy your public key in the settings of the module.

# Installation
- Download the ZIP file
- Install it in your Joomla instance
- Create a new Module and enter the required information
- Deside where your Contact Modul should be placed and on which Pages

# Create a Contact page
I wanted to create a lightwight and flexible module no complete Joomla component. Thats why its not possible to create a menu item of the type "Joomla Encrypted Contact".

To have a similar result simplay follow these steps:
- Create a new article where you write the text you want to have displayed on your contact page
- Create your submenu
- Make it of the type single article and select the previous created article
- Make sure that your contact modul is only displayed when the new menu is selected

# Support
Create a new isuue if you found an issue or have a feature request.

# Credits
This has been crafted while listening to Tenacious D.

Now go, my son and rock!