<?php
//id,title,description,price,cat_id,source
function getAllProducts() // For all products in database
{
  $sql = "SELECT id,title,description,price,cat_id,source
  FROM products";

  $result = getDB()->query($sql);
  if (!$result) {
    return [];
  }
  $products = [];
  while ($row = $result->fetch()) {
    $products[] = $row;
  }
  return $products;
}

function getProducts($sql)  // For specific product in database
{
  $result = getDB()->query($sql);
  if (!$result) {
    return [];
  }
  $products = [];
  while ($row = $result->fetch()) {
    $products[] = $row;
  }
  return $products;
}

function getProductCategorie($productId) //TODO categorie for product 
{
  $sql = "SELECT *
  FROM products
  JOIN categories ON products.cat_id = categories.cat_id
  WHERE products.id = $productId";

  $result = getDB()->query($sql);
  if (!$result) {
    return [];
  }
  $productCategorie = [];
  while ($row = $result->fetch()) {
    $productCategorie[] = $row;
  }
  return $productCategorie;
}
