<?php

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

function getProductCategorie()
{
  $sql = "SELECT *
          FROM categories
          JOIN products ON(categories.cat_id = products.cat_id)
          WHERE cat_id = product.cat_id";
  $result = getDB()->query($sql);
  if (!$result) {
    return [];
  }
  $product = [];
  while ($row = $result->fetch()) {
    $product[] = $row;
  }
  return $product;
}
