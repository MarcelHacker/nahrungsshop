<?php

function getAllProducts()
{
  $sql ="SELECT id,titel,descr,price
  FROM products";

  $result = getDB()->query($sql);
  if(!$result)
  {
    return [];
  }
  $products = [];
  while($row = $result->fetch())
  {
    $products[]=$row;
  }
  return $products;
}

function getProducts($sql)
{
  $result = getDB()->query($sql);
  if(!$result)
  {
    return [];
  }
  $products = [];
  while($row = $result->fetch())
  {
    $products[]=$row;
  }
  return $products;
}
?>