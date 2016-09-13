<?php

class EnkiSessionHandler implements SessionHandlerInterface {
  /**
   * @var PDO
   */
  private $db;

  public function close() {
    $this->db = null;
    return true;
  }

  public function destroy($sessionID) {
    $sth = $this->db->prepare('DELETE FROM `sessions` WHERE `session_id` = :session_id');
    $sth->execute(['session_id' => $sessionID]);

    return true;
  }

  public function gc($maxLifeTime) {
    return true;
  }

  public function open($savePath, $name) {
    $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
    return true;
  }

  public function read($sessionID) {
    try {
      $sth = $this->db->prepare('SELECT session_data FROM `sessions` WHERE `session_id` = :session_id');
      $sth->execute(['session_id' => $sessionID]);

      return $sth->fetchColumn();
    } catch (\Exception $e) {
      dump($e);
      return '';
    }
  }

  public function write($sessionID, $sessionData) {
    if (empty($sessionID) || empty($sessionData)) {
      return true;
    }

    try {
      $sth = $this->db->prepare("REPLACE INTO `sessions` (session_id, session_data) VALUES (:session_id, :session_data)");
      $sth->execute(['session_id' => $sessionID, 'session_data' => $sessionData]);

      return true;
    } catch (\Exception $e) {
      dump($e);
      return false;
    }

  }
}