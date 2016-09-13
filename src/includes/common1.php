<?php
// This file mimics common1.inc on ENKI

session_name(SESSION_COOKIE_PREFIX . 'ENKI_ID');

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
}