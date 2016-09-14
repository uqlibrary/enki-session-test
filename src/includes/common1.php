<?php
// This file mimics common1.inc on ENKI

session_name(SESSION_COOKIE_PREFIX . 'ENKI_ID');
session_set_cookie_params(7200, '/', 'library.uq.edu.au');

// 1. Set session handlers
$handler = new EnkiSessionHandler();
session_set_save_handler($handler, true);
session_start();

// 2. Check for UQL cookies
if (!empty($_COOKIE[SESSION_COOKIE_PREFIX . 'USER_GROUP']) && empty($_SESSION[SESSION_COOKIE_PREFIX . 'USER_GROUP'])) {
  // LOGGED IN, BUT NOT ON ENKI!
  fillFromAPI($_COOKIE[SESSION_COOKIE_PREFIX . 'ID']);
}

/**
 * To test iva UQLAIS we need Cookie. To test via UQLAPP we need 'X-Uql-Token'. We set both
 * @param $id
 */
function fillFromAPI($id) {
  $client = new \GuzzleHttp\Client([
    'headers' => [
      'Cookie' => SESSION_COOKIE_PREFIX . 'ID=' . $id,
      'X-Uql-Token' => $id
    ]
  ]);

  $response = $client->get(USER_PATH);
  $data = json_decode($response->getBody(), true);

  echo "API RESPONSE:";
  dump($data);

  // Add data to $_SESSION in the same format as old UQLAIS
  $_SESSION["uql_username"] = $data['id'];
  $_SESSION["uql_title"] = $NOPE;
  $_SESSION["uql_first_name"] = $NOPE;
  $_SESSION["uql_last_name"] = $NOPE;
  $_SESSION["uql_full_name"] = $data['name'];
  $_SESSION["uql_p_type"] = $data['type'];
  $_SESSION["uql_expiry_date"] = $NOPE;
  $_SESSION["uql_user_group"] = $_COOKIE[SESSION_COOKIE_PREFIX . 'USER_GROUP'];
  $_SESSION["uql_barcode"] = $data['barcode'];
  $_SESSION["uql_home_library"] = $NOPE;
  $_SESSION["uql_email_address"] = $data['mail'];
  $_SESSION["uql_stat_class"] = $data['class'];

  // Create the UQL_USER instance
  $u = new UQL_User();
  $u->first_name = $NOPE;
  $u->last_name = $NOPE;
  $u->ptype = $data['type'];
  $u->username = $data['id'];
}