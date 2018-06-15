<?php
/*
* version 1.1e-beta  -20180314 - fixed greek
* version 1.1d-beta  -20161212 - fixed email
* Changes :
*  1.1c-beta  -20161209 - fixed some paths
*  1.1b-beta  -20161208 - Reminder mail is associated with ViewOwnResults menu link
* -20161208 1.1a- Reminder mail is associated with ViewOwnResults menu link
* -20161204b 1.0- implementing permissions , translate
* -20161204a - implementing permissions
* -20161005 -renamed to participants
* -1.0a-beta  20160930 : seems to work version
*/
/**
 * Implements hook_menu().
 */
function webform_participants_menu() {
  $items = array();
    $items['node/%webform_menu/Participants/participants-codes'] = array(
    'title' => 'Participants Codes',
    'page callback' => 'webform_participants_generate_page',
    'page arguments' => array(1),
    'access callback' => 'node_access',
    'access arguments' => array('update', 1),
    // 'access callback' =>'webform_participants_my_access_callback',
    'weight' => 12,
    'type' => MENU_LOCAL_TASK,
  );
  return $items;
}


function webform_participants_generate_page($node) {
  $out = drupal_get_form('webform_participants_generate_form', $node);
  return $out;
}

function webform_participants_generate_form($form, &$form_state, $node) {
  $nid = $node->nid;
  $form['intro'] = array(
    '#markup' => '<h2>' . t('Generate new codes for %node_title', array("%node_title" => $node->title)) . '</h2><p>' . t('To generate codes please enter the required number of codes and hit the button.') . '</p>',
  );
  $form['nid'] = array(
    '#type' => 'hidden',
    '#value' => $nid,  
  );
  // added by J 160927++++++++++++++
  $form['participant_mails'] = array(
    '#type' => 'textarea',
    '#title' => t('copy the PRIVATE KEY that was given to you '),
    '#required' => false,
  );  
  // added by J 160927------------

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Submit your private key'),
  );


  return $form;
}


function webform_participants_generate_form_submit($form, &$form_state) {
  $number = $form_state['values']['number_of_tokens']; 
  $nid = $form_state['values']['nid'];
  $private_key=$form_state['values']['participant_mails'];
  drupal_set_message("INSIDE extra decryptors  decrypt key = $private_key");
  // Check existance of PKI encrypt module
  _mySite_session("current_private_key",$private_key); //save PRivate key to SESSION
  $session_private_key=_mySite_session("current_private_key");
  drupal_set_message("INSIDE extra decryptors  SESSION decrypt key = $session_private_key");

  drupal_goto('node/' . $nid . '/Participants/participants-codes');
}





/**
 * Implements hook_permission().
 * add a permission "access_webform_participants_menu"
 */
function webform_participants_permission() {
  return array(
    'access_webform_participants_menu' => array(
      'title' => t('webform_participants : access webform participants menu'),
    )
  );
}


/**
callback access function
Checks if current user has access to the results on this node & access to
*/
function webform_participants_my_access_callback() {
  //get node
  $nid = 0;
  if (arg(0) == 'node' && is_numeric(arg(1))) {
      $nid = arg(1);
  }
  $node = node_load($nid);
  //$nodeurl = url('node/'. $node->nid);
  $nodeurl_relative ='node/'. $node->nid;
  //drupal_set_message("nodeurl = ".$nodeurl); //shows FULL url eg /test_installation/node/321423/  -We do not want that
  //drupal_set_message("valid path (test participants form)= $nodeurl_relative nodeurl_relative/webform-results= ".drupal_valid_path($nodeurl_relative.'/webform-results'));
  //return drupal_valid_path($nodeurl_relative.'/webform-results') && user_access('access_webform_participants_menu');  //ok WORKS 
  return drupal_valid_path($nodeurl_relative.'/webform-results') ; // at this point we choose to ignore it. Reminder email is tied with webforms_results view
}
