# drupal_public_key_encryption
drupal_public_key_encryption TESTS

## Drupal 7 features
 - Can encrypt textfields,textarea, date and numbers


## To Do :
 - [ ] give decrypt permission to people with results access (they will still need the form private key in order to decrypt the form )
 - [ ] remove debug code
 - [ ] Enable global form encryption (for ver 2.0)


## Usage Instructions :

This works like the webform_encrypt module (which was my original inspiration) but it uses assymetric encryption.

Drupal stores the encryption key (=public key) and the form owner holds the decryption key (=private key). Even site admin can;t see the encrypted submissions.
Basic functionality is ready for drupal 8 but it is not production ready yet.

This module aim was to allow form owner to keep its data safe. Each form can have it's own encrypt/decrypt key set. ONLY encryption keys are stored in the database. Decrypt/Private key is stored per session (only 1 decrypt key per session). If you have 2 or more forms you must enter the appropriate decrypt key each time (or use different browser/sessions).

Instructions :
- Enable module (and if you want the included result access module)
- Go to your webform "form settings" tab and click on option "PK_ENCRYPTER"
- If you do not have a Public Private key set, hit the "Generate new keys" button.
- You will then see a message that shows you the two created keys : 
<blockquote>-----BEGIN PUBLIC KEY-----
...
-----END PUBLIC KEY-----</blockquote>
and 
<blockquote>-----BEGIN PRIVATE KEY-----
...
-----END PRIVATE KEY-----</blockquote>
- !!! IMPORTANT!!! Store somewhere safe the PRIVATE KEY (if you loose it you won't be able to decrypt the encrypted fields)
- Copy and then paste -----BEGIN PUBLIC KEY-----...-----END PUBLIC KEY----- inside the textarea named <strong>Public Key</strong> in the PK Encrypt category (form settings)
- Optionally - Copy and then paste -----BEGIN PRIVATE KEY-----...-----END PRIVATE KEY----- inside the textarea named <strong>Private Key</strong> in the PK Encrypt category (form settings) **
- You can enter Private/decrypt key in the <strong>PKI-Client-Key</strong> webform tab - it is the same thing. This tab appears when you give specific users result access.

- Now to each field you can check the option "E NCRYPTION".
- Module has been tested in Encrypt/decrypt,edit single submissions. mail send (mails are send BEFORE the encryption process so- keep in mind where you send them)



** If you do not enter your private key you will just see a message in the place of each encrypted field.