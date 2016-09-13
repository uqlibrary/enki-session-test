<?php
// This file mimicks common1.inc on ENKI

// 1. Set session handlers
$handler = new EnkiSessionHandler();
session_set_save_handler($handler, true);

session_start();

// 2. If destroy
if (!empty($_GET['destroy'])) {
  session_destroy();
}