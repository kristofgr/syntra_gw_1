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
      WHERE username=:username 
      AND password=MD5(:password)
      AND status=1";

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

function getProducts($order = 'id'): array
{
  $sql = "SELECT id, name, image, status, date_created, date_updated
      FROM products
      ORDER BY " . $order;

  $stmt = connectToDB()->prepare($sql);
  $stmt->execute();

  return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function getCategories(): array
{
  return [
    1 => 'Tech',
    2 => 'Toy',
    4 => 'Wearables',
  ];
}
function

  addProduct(array $tokens): void
{
  $sql = "INSERT INTO products(name, image) VALUES (:name, :image)";

  $stmt = connectToDB()->prepare($sql);
  $stmt->execute($tokens);
}