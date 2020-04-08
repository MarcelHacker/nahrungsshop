<?php
function addProductToCart(int $userId, int $productId)  // Add product to cart
{
  $sql = "INSERT INTO cart SET user_id = :userId, product_Id = :productId";
  $statement = getDB()->prepare($sql);

  $statement->execute([
    ':userId' =>  $userId,
    ':productId' => $productId
  ]);
}

function countProductsInCart(int $userId)  // Count products in cart
{
  $sql = "SELECT COUNT(id) FROM cart WHERE user_id =" . $userId;
  $cartResults = getDB()->query($sql);
  if ($cartResults === false) {
    return 0;
  }
  $cartItems = $cartResults->fetchColumn();
  return $cartItems;
}

function getCartItemsForUserId(int $userId): array // 
{
  $sql = "SELECT product_id,title,description,price
          FROM cart
          JOIN products ON(cart.product_id = products.id)
          WHERE user_id = " . $userId;
  $results = getDb()->query($sql);
  if ($results === false) {
    return [];
  }
  $found = [];
  while ($row = $results->fetch()) {
    $found[] = $row;
  }
  return $found;
}

function getCartSumForUserId(int $userId): int
{
  $sql = "SELECT SUM(price * quantity)
          FROM cart
          JOIN products ON(cart.product_id = products.id)
          WHERE user_id = " . $userId;
  $result = getDb()->query($sql);
  if ($result === false) {
    return 0;
  }
  return (int) $result->fetchColumn();
}
