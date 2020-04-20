<?php

/**
 * A summary informing the user what the associated element does.
 *
 * A *description*, that can span multiple lines, to go _in-depth_ into the details of this element
 * and to provide some background information or textual references.
 *
 *
 * 
 */

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

function getProductCategorie($productId)  // Get product categorie
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

function getProductWithTitle(string $title) // For website search
{
  $db = getDB();
  if (!$db) {
    die();
  } else {

    $statement = $db->prepare("SELECT * FROM products WHERE title = :title");
    $statement->execute(array('title' => $title));
    $product = $statement->fetch();
  }
  return $product;
}
