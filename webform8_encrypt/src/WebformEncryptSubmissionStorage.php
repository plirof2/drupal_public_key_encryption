<?php

namespace Drupal\webform_encrypt;

use Drupal\Core\Entity\EntityInterface;
use Drupal\webform\WebformSubmissionStorage;
//use Drupal\encrypt\Entity\EncryptionProfile;

/**
 * Alter webform submission storage definitions.
 */
class WebformEncryptSubmissionStorage extends WebformSubmissionStorage {

  /**
   * Helper function to recursively encrypt fields.
   *
   * @param array $data
   *   The current form data array.
   * @param object $webform
   *   The webform we are encrypting..
   */
  public function encryptElements(array $data, $webform) {
    // Load the configuration.
    $config = $webform->getThirdPartySetting('webform_encrypt', 'element');

    foreach ($data as $element_name => $value) {
      //$encryption_profile = isset($config[$element_name]) ? EncryptionProfile::load($config[$element_name]['encrypt_profile']) : FALSE;
      $encryption_profile = "AAA";
      // If the value is an array and we have a encryption profile.
      if ($encryption_profile) {
        if (is_array($value)) {
          $this->encryptChildren($data[$element_name], $encryption_profile);
        }
        else {
          //$encrypted_value = \Drupal::service('encryption')            ->encrypt($value, $encryption_profile);
          $encrypted_value= $this->my_encrypt($value,$this->get_my_public_Key()); // jon 180524

          // Save the encrypted data value.
          $data[$element_name] = $encrypted_value;
        }
      }
    }
    return $data;
  }

  /**
   * Helper function to recursively encrypt children of fields.
   *
   * @param array $data
   *   Element data by reference.
   * @param object $encryption_profile
   *   The encryption profile to be used on this element.
   */
  public function encryptChildren(array &$data, $encryption_profile) {
    foreach ($data as $key => $value) {
      if (is_array($value)) {
        $this->encryptChildren($data[$key], $encryption_profile);
      }
      else {
        //$encrypted_value = \Drupal::service('encryption')          ->encrypt($value, $encryption_profile);
          $encrypted_value= $this->my_encrypt($value,$this->get_my_public_Key()); // jon 180524
        $data[$key] = $encrypted_value;
      }
    }
  }

  /**
   * Decrypts a string.
   *
   * @param string $string
   *   The string to be decrypted.
   * @param string $encryption_profile
   *   The encryption profile to be used to decrypt the string.
   * @param bool $check_permissions
   *   Flag that controls permissions check.
   *
   * @return string
   *   The decrypted value.
   */
  protected function decrypt($string, $encryption_profile, $check_permissions = TRUE) {
    if ($check_permissions && !\Drupal::currentUser()->hasPermission('view encrypted values')) {
      return '[Value Encrypted]';
    }
    /*
    $decrypted_value = \Drupal::service('encryption')->decrypt($string, $encryption_profile);
    if ($decrypted_value === FALSE) {
      return $string;
    }
    */

    $decrypted_value = $this->my_decrypt($string,$this->get_my_private_Key());
    if ($decrypted_value === FALSE) {
      return $string;
    }


    return $decrypted_value;
  }

  /**
   * Helper function to recursively decrypt fields.
   *
   * @param object $webform_submission
   *   The webform submission to work on.
   */
  public function decryptElements($webform_submission) {
    // Load webform.
    $webform = $webform_submission->getWebform();
    // Load submission data.
    $data = $webform_submission->getData();
    // Load the configuration.
    $config = $webform->getThirdPartySetting('webform_encrypt', 'element');
    foreach ($data as $element_name => $value) {
      //$encryption_profile = isset($config[$element_name]) ? EncryptionProfile::load($config[$element_name]['encrypt_profile']) : FALSE;
      $encryption_profile=false;
      if ($encryption_profile) {
        if (is_array($value)) {
          $this->decryptChildren($data[$element_name], $encryption_profile);
        }
        else {
          $decrypted_value = $this->decrypt($value, $encryption_profile);
          // Save the decrypted data value.
          $data[$element_name] = $decrypted_value;
        }
      }
    }
    return $data;
  }

  /**
   * Helper function to recursively decrypt children of fields.
   *
   * @param array $data
   *   Element data by reference.
   * @param object $encryption_profile
   *   The encryption profile to be used on this element.
   */
  public function decryptChildren(array &$data, $encryption_profile) {
    foreach ($data as $key => $value) {
      if (is_array($value)) {
        $this->decryptChildren($data[$key], $encryption_profile);
      }
      else {
        $decrypted_value = $this->decrypt($value, $encryption_profile);
        $data[$key] = $decrypted_value;
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  protected function doPreSave(EntityInterface $entity) {
    /** @var \Drupal\webform\WebformSubmissionInterface $entity */
    $id = parent::doPreSave($entity);

    $data_original = $entity->getData();

    $webform = $entity->getWebform();

    $encrypted_data = $this->encryptElements($data_original, $webform);
    $entity->setData($encrypted_data);

    $this->invokeWebformElements('preSave', $entity);
    $this->invokeWebformHandlers('preSave', $entity);
    return $id;
  }

  /**
   * {@inheritdoc}
   */
  protected function loadData(array &$webform_submissions) {
    parent::loadData($webform_submissions);

    foreach ($webform_submissions as &$webform_submission) {
      $data = $this->decryptElements($webform_submission);
      $webform_submission->setData($data);
      $webform_submission->setOriginalData($data);
    }
  }




//
//--------------------------------------
// Encrypt data using the public key
protected function my_encrypt($data, $publicKey)
{
    // Encrypt the data using the public key
   openssl_public_encrypt($data, $encryptedData, $publicKey);
  //$encryptedData=ssl_encrypt($data,'public',get_my_public_Key());
//echo  "<HR>publicKey= $publicKey";
    // Return encrypted data
    return base64_encode($encryptedData);
}

// Decrypt data using the private key
protected function my_decrypt($data, $privateKey)
{
    // Decrypt the data using the private key
   openssl_private_decrypt(base64_decode($data), $decryptedData, $privateKey);
//   echo  "<HR>privateKey = $privateKey";

    // Return decrypted data
    return ($decryptedData);
}

protected function get_my_private_Key()
{
$private_my_key= trim('-----BEGIN PRIVATE KEY-----
MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAJka97mFuKzAd9qY
s5nKdoNW/dkyQCFcGFFtZ7ZsXvTUOe678Bh91Ca5zeYin+vpsYRbzci/CYvxbYui
VJVjn+URmnY2/I1FzQg0NDkGFD27lgBAFB1euLf+hN6mhVBdj4y9V2cpHV9IiWAg
5WZeF2d/nwuyMI/nv1mdmvfNmyofAgMBAAECgYARMk86vkNE3AVaPyaFEpGHJQE0
IQnE9XQhyTkJ61grBZ9QKjnIdnGau+ndfGwb8k6nACy37IUk+8QDGAOKF/uAcaR5
9pXArxlJo73EC9yadFyAc/DMf/y2vEFFC4ZrXoZhx+CG1qvqjSK4hccg2VZdlq0U
ktXprIFXCwgxQkFMSQJBAMihyvPbAWzP8+uSdMcCBlzrkhIuokYhRZDoyYtsNq/Y
Dsyg1N+4F0MGHcwikYhc68oZuHXe4A1bRkGDriAfk1MCQQDDW4V9xsRDM4QGKEKS
lcUgK+FQP4pNKxa4T/peaXDeYTKIZ1KRFNUULfX57vFWJ9y857zkzQ+m0JksDfUM
KeCFAkBlvCT9ooAGfSxit9EfWJeBZrKbJaqDhTuRT3ljiWvxns1iVeubxe2FvwQ9
Dwpc60FlKcWvf2R9YVsuvWb+QwShAkBosPZD5i4tWUEqT48FoS+Hwxw29iY2np3J
XkrtJ5JuCiabhMtxpnleHBdSvmMk6a3YqlPHRcFagzVir4Qf5Z1FAkEAjqJyHb8V
rZu2uj1+r/vGv9BbH80xjReT8udGjewBxBtqCfFoMuE8Xh6EImOXdZSHBXF2Srzq
bb12MrEizy/XNQ==
-----END PRIVATE KEY-----');

/*
    $settings = _webform_pki_encrypt_webform_pki_encrypt_settings(get_current_node_id());
    if (!empty($settings)) {
      //$public_my_key = $settings['public_key'] ;
      $private_my_key = $settings['private_key'];
    }
    $session_private_key=_mySite_session("current_private_key");
    //drupal_set_message("SESS PRIV="._mySite_session("current_private_key"));
    //drupal_set_message(  "<h1>nid=".get_current_node_id()."private_my_key=$private_my_key </h1>");
    if($session_private_key!=null) $private_my_key=$session_private_key;
*/
    return $private_my_key;
}

protected function get_my_public_Key()
{
$public_my_key=trim('-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCZGve5hbiswHfamLOZynaDVv3Z
MkAhXBhRbWe2bF701Dnuu/AYfdQmuc3mIp/r6bGEW83IvwmL8W2LolSVY5/lEZp2
NvyNRc0INDQ5BhQ9u5YAQBQdXri3/oTepoVQXY+MvVdnKR1fSIlgIOVmXhdnf58L
sjCP579ZnZr3zZsqHwIDAQAB
-----END PUBLIC KEY-----'); //sample default value
/*
    $settings = _webform_pki_encrypt_webform_pki_encrypt_settings(get_current_node_id());
    if (!empty($settings)) {
      $public_my_key = $settings['public_key'] ;
      //$my_private_key = $settings['private_key'];
    }
    //drupal_set_message(  "<h1>public_my_key=$public_my_key</h1>");
*/
    return $public_my_key;
}
}//class WebformEncryptSubmissionStorage extends WebformSubmissionStorage {