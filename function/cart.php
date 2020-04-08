<?php
function addProductToCart(int $userId, int $productId)  // Add product to cart
{
  $sql = "INSERT INTO cart SET user_id = :userId,product_Id = :productId";
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
