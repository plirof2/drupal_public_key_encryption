<?php
//NOTE GET PRIVATE AND PUBLIC KEYS from VIEW SOURCE of page
function get_my_private_Key()
{
$private_my_key= trim('-----BEGIN PRIVATE KEY-----
MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDB9Hbv9wBltAgj
rOI0zZJOiGg2w/HespgjlHZgW3MkPtX2gA24EVhW/O+LIB6aQ/gCGFLcjRu7m7va
2etqnDuIoEdKVAVOGKToHJkdBVTrA4CaeOmfbovBkKhEX2Cd6HZ/IL6fDYaaFIFi
YOfTbXbgC6OL4O3kjUFDXcDvVgWdHULlAYjZNSGZy4d0T0uq1mjXDik1DDTq2Ubq
7yeCRbLsvwU28jCLClYf7ml/qroL4GKEXtwzkl+F3b9Fa/vTsb2HQKq6vP8v7ECj
UaWWuIimwvxyVdHb05V0SQHYhBfKNxbZ6sNJ0UC9UMADymsFzhdq3wEsMqnYp3xU
LubTnmsfAgMBAAECggEAd9Ez4I4wWqPbG17j50bPiWBPMPXfZ3ng7qn6bxBPkyaW
O09kKj/c2PAsc0AGZ7pxbanlFoa9iSpt5IcXHaciSAbrw4kgNdyXkySHmhv/F6f0
PHlRqcI65/sbWBGruCExgtuRpuROMMVWIJZI4J4Q/9twzyrHC5gPpzQ1yiTUFvg2
uaeIb9b/ktV637ux5LUg+XxniasJpeSbMFp0dO8/8Xn8wk6CUFd4y/w8jWzfFMXL
4FAQxsHU17UeYiGHGslfisrKTnhiUBUHtSne2p3keK7aVPZKaJyynDsbocmuJzAV
a86MX8PS0XwUgAn3fZt7ovJbiuGvZZfVY3vSdm9rUQKBgQDuVP4VtEGdIfjZFhEX
wn3QYpOrhAD+XnaBWcA64p01hKtCsQdR2qVapLj89mdgWYvSEwdVxJqyVQZlTWxZ
qfQZuGsiRny19HT2Jg8hmSwxmdN0ijC45o2ZKsC2EmjhJQTlxaGe/PR2PEGv5WEV
N/H31hPI+270vebmIL92JLM7zQKBgQDQVUt7mJfPUqYRELEl1GV1eKfcDuOCBBG6
JDMHfQWMfTJwO0IQASFN9tU1CJPXVx6MLiO7QIa4zZSNiFtwKEvLnhsLBQjnGzjR
wN6vajaqs9VynI3DPEaPO17Kouc5he7LpMH9OJbQqtL0eR7qFdL1pKo/U+0cHRJJ
3zP2+SQOmwKBgFPZYR8fsOnodtVhVxgl2//BfrScF4FmmIi/m8rbyXV3vI0VHT8m
DoDKbS7KPep+9pstCKqbJdXR5hMj3xfYnEGkSUTgyaV2YOPs1ev7KLo2pVdd+vBC
ZNTbXrtv1KhJTuTL2CXIVvV2E6IfsD031pBcJ8/Q7eN7IE4cfV/CX7CNAoGBAMpD
xYE96UX0LB8tYZAk4kxm1DImkmPMp5ldQ93lV9nKQ4oLPlxjfH5BQ0a2CTNs9c+L
jE1knGgX0D6JQJ1nwg7ydbcBMF+QYl3jL1CHgoPBDV60+D2w66BsN9/swSlsCyfT
0jOTGXmGIEISxhznC2ZKdK//P5mn7/WgqscBpCw5AoGBALnrSk0XJM1r/hhY86hv
9woJl515vNGbWM4uK51DmywTLzCchEox9evwOQNhJYCpeMfoAOTLfgjgQX0dtOcJ
wm5PSBzY4F39bT5924IAwjxL7kLVxMzzFwM8rC7b4ZTYIqsycmSB68D4OHjqt6Hg
fQ0wZjb5vjQbJ2x0LpH2Fn/u
-----END PRIVATE KEY-----');

    return $private_my_key;
}

function get_my_public_Key()
{
$public_my_key=trim('-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwfR27/cAZbQII6ziNM2S
TohoNsPx3rKYI5R2YFtzJD7V9oANuBFYVvzviyAemkP4AhhS3I0bu5u72tnrapw7
iKBHSlQFThik6ByZHQVU6wOAmnjpn26LwZCoRF9gneh2fyC+nw2GmhSBYmDn0212
4Auji+Dt5I1BQ13A71YFnR1C5QGI2TUhmcuHdE9LqtZo1w4pNQw06tlG6u8ngkWy
7L8FNvIwiwpWH+5pf6q6C+BihF7cM5Jfhd2/RWv707G9h0Cqurz/L+xAo1GllriI
psL8clXR29OVdEkB2IQXyjcW2erDSdFAvVDAA8prBc4Xat8BLDKp2Kd8VC7m055r
HwIDAQAB
-----END PUBLIC KEY-----');

    return $public_my_key;
}

// Generate a public and private key
function generate()
{
	//shell_exec('export RANDFILE="/opt/lampp/htdocs/.rnd";openssl ecparam -genkey -name secp256k1');
	shell_exec('export RANDFILE="/opt/lampp/htdocs/.rnd"');
    // Set the key parameters
    $config = array(
        "digest_alg" => "sha128",
        "private_key_bits" => 1024,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
    );

    // Create the private and public key
    //echo  "<HR>";
    $res = openssl_pkey_new($config);
    //echo  "<HR>";
//print_r($res); 
//echo  "<HR>";
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
   //openssl_public_encrypt($data, $encryptedData, get_my_public_Key());
   openssl_public_encrypt($data, $encryptedData, $publicKey); //ORIG
//echo  "<HR>publicKey= $publicKey";
    // Return encrypted data
    return $encryptedData;
}

// Decrypt data using the private key
function decrypt($data, $privateKey)
{
    // Decrypt the data using the private key
   //openssl_private_decrypt($data, $decryptedData, get_my_private_Key()); //ORIG
   openssl_private_decrypt($data, $decryptedData, $privateKey); //ORIG
   //echo  "<HR>privateKey = $privateKey";

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
echo  "<HR size=5><b>";
echo "<pre>".$arrKeys['public']."</pre";
//echo  "</b><BR>".get_my_public_Key()."<HR>";
echo $strEncrypted;
echo  "<HR>OK ENCRYPT<HR>";
$strDecrypted = decrypt($strEncrypted, $arrKeys['private']);
echo  "<HRsize=5><b>";
echo "<pre>".$arrKeys['private']."</pre";
//echo  "</b><BR>".get_my_private_Key()."<HR>";
echo  "<HR>Now DECRYPT<HR>";
echo $strDecrypted;
echo  "<HR>";

?>