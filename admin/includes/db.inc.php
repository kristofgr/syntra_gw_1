<?php
function connectToDB()
{
  try {
    $db = new PDO('mysql:host=' . DB_HOST . '; port=' . DB_PORT . '; dbname=' . DB_DB, DB_USER, DB_PASSWORD);
  } catch (PDOException $e) {
    echo "Error!: " . $e->getMessage() . "<br/>";
    die();
  }
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);

  return $db;
}

function isValidLogin(string $user, string $pass): bool|object
{
  $sql = "SELECT id, username, created_at
      FROM users 
      WHERE username=:username AND password=:password";

  $stmt = connectToDB()->prepare($sql);
  $stmt->execute([
    "username" => $user,
    "password" => $pass
  ]);

  $user = $stmt->fetch(PDO::FETCH_OBJ);

  if (!$user)
    return false;

  return $user;
}
