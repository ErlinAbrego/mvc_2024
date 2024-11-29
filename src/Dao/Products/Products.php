<?php

namespace Dao\Products;

use Dao\Table;

class Products extends Table
{
    public static function obtenerProducts()
    {
        $sqlstr = 'SELECT * FROM products;';
        $Products = self::obtenerRegistros($sqlstr, []);
        return $Products;
    }
    public static function obtenerProductsXId($id)
    {
        $sqlstr = 'SELECT * from products where productId=:productId;';
        $products = self::obtenerUnRegistro($sqlstr, ["productId" => $id]);
        return $products;
    }
    public static function agregarProducts($products)
    {
        unset($products['productId']);
        unset($products['creado']);
        unset($products['actualizado']);
        $sqlstr = 'INSERT INTO products (productName, productDescription, 
                    productPrice, productImgUrl, productStock, productStatus) 
                    values (:productName, :productDescription, :productPrice, :productImgUrl, 
                    :productStock, :productStatus);';
        return self::executeNonQuery($sqlstr, $products);
    }
    public static function actualizarProducts($products)
    {
        unset($products['creado']);
        unset($products['actualizado']);
        $sqlstr = 'UPDATE products SET productName = :productName, 
                    productDescription = :productDescription, 
                    productPrice = :productPrice, 
                    productImgUrl = :productImgUrl, 
                    productStock = :productStock, 
                    productStatus = :productStatus 
                WHERE productId = :productId;';
        return self::executeNonQuery($sqlstr, $products);
    }
    public static function eliminarProducts($products)
    {
        $sqlstr = 'DELETE FROM products WHERE productId = :productId;';
        return self::executeNonQuery($sqlstr, ["productId" => $products]);
    }
}
