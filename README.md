# drupal_public_key_encryption
drupal_public_key_encryption modules for both drupal 7 & drupal 8

## General features (should be working in production version)
 - Each FORM creator can generate a set of public-private keys. Drupal will store in database ONLY the public key which is used each time to encrypt the submission.
 - Private key MUST be entered in each time you create a new session. 
 - Each form can have a different set of keys. Owner MUST store somewhere safe his private key. Without it all entered data are NOT visible.(even the site admin can't decrypt them since the private key isn't stored anywhere)
 - Form owner can define trusted users that have result access and he can choose if he will give them the private key to have access to personal data.

## Drupal 7 version features
 - Accepts ONLY ONE private key per session (you can decrypt ONLY 1 form each time). This is done for security reasons -avoid storing many decrypt keys in one place.
 - Individual set of keys for each form. (can be accessed from WEBFORM>Form Oprions > PKI Encrypt)
 - Give specific users result access.

## Drupal 7 version to DO:
 - CAN edit/view individual submissions
 - MAIL submission NOT checked
 - Do more multiuser tests

## Drupal 8 version features (NOT production ready !!!!)
 - Can encrypt/decrypt submissions
 - 

## Drupal 8 version To DO :
 - NOT production ready !!!!
 - Create Public-Private Keys SET
 - Store Private key on SESSION
 - 
 - MAIL submission NOT checked 
 - TO DO:  edit/view individual submissions
