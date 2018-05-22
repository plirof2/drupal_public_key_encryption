<?php
// Generate a public and private key
function generate()
{
	//shell_exec('export RANDFILE="/opt/lampp/htdocs/.rnd";openssl ecparam -genkey -name secp256k1');
	shell_exec('export RANDFILE="/opt/lampp/htdocs/.rnd"');
    // Set the key parameters
    $config = array(
        "digest_alg" => "sha512",
        "private_key_bits" => 4096,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
    );

    // Create the private and public key
    $res = openssl_pkey_new($config);

    // Extract the private key from $res to $privKey
    openssl_pkey_export($res, $privKey);

    // Extract the public key from $res to $pubKey
    $pubKey = openssl_pkey_get_details($res);

    return array(
        'private' => $privKey,
        'public' => $pubKey["key"],
        'type' => $config,
    );
}

// Encrypt data using the public key
function encrypt($data, $publicKey)
{
    // Encrypt the data using the public key
   openssl_public_encrypt($data, $encryptedData, $publicKey);
echo  "<HR>publicKey= $publicKey";
    // Return encrypted data
    return $encryptedData;
}

// Decrypt data using the private key
function decrypt($data, $privateKey)
{
    // Decrypt the data using the private key
   openssl_private_decrypt($data, $decryptedData, $privateKey);
   echo  "<HR>privateKey = $privateKey";

    // Return decrypted data
    return $decryptedData;
}

// Encrypt and then decrypt a string
echo  "<HR>";
echo  "<HR>";
echo  "<HR>";
echo  "<HR>";
echo  "<HR>";
$arrKeys = generate();
$strEncrypted = encrypt('Hello World!', $arrKeys['public']);
echo $strEncrypted;
echo  "<HR>";
$strDecrypted = decrypt($strEncrypted, $arrKeys['private']);
echo $strDecrypted;
echo  "<HR>";

?>