<?php
function addProductToCart(int $userId, int $productId)  // Add product to cart
{
  $sql = "INSERT INTO cart
  SET quantity=1,user_id = :userId,product_id = :productId
  ON DUPLICATE KEY UPDATE quantity = quantity +1
  ";
  $statement = getDB()->prepare($sql);

  $result = $statement->execute([
    ':userId' =>  $userId,
    ':productId' => $productId
  ]);
  return $result;
}

function deleteProductFromCart(int $userId, int $productId)  // Delete product from cart
{
  $sql = "DELETE FROM cart
          WHERE user_id = :userId AND product_id = :productId";
  $statement = getDB()->prepare($sql);

  $result = $statement->execute([
    ':userId' =>  $userId,
    ':productId' => $productId
  ]);
  return $result;
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

function getCartItemsForUserId(int $userId): array // Products in cart from user
{
  $sql = "SELECT *
          FROM cart
          JOIN products ON(cart.product_id = products.id)
          WHERE user_id = $userId";
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

function getCartSumForUserId(int $userId): int // Total price of products in cart
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
