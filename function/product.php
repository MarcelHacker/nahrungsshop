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
