<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 14.05.2016
 * Time: 10:40
 */

namespace app\models;
use yii\db\ActiveRecord;

class Cart extends ActiveRecord{

    public function addToCart($product, $qty = 1){
        if(isset($_SESSION['cart'][$product->id])){
            $_SESSION['cart'][$product->id]['qty'] += $qty;
        }else{
            $_SESSION['cart'][$product->id] = [
                'qty' => $qty,
                'name' => $product->name,
                'price' => $product->price,
                'img' => $product->img
            ];
        }
        $_SESSION['cart.qty'] = isset($_SESSION['cart.qty']) ? $_SESSION['cart.qty'] + $qty : $qty;
        $_SESSION['cart.sum'] = isset($_SESSION['cart.sum']) ? $_SESSION['cart.sum'] + $qty * $product->price : $qty * $product->price;
    }

    public function dellTovarVithCart($id) {
        
        if(!isset($_SESSION['cart'][$id])) return false;
        
        $minus_qty = $_SESSION['cart'][$id]['qty'];
        $minus_sum = $_SESSION['cart'][$id]['price'] * $_SESSION['cart'][$id]['qty'];
        
        $_SESSION['cart.qty'] -= $minus_qty;
        $_SESSION['cart.sum'] -= $minus_sum;
        
        unset($_SESSION['cart'][$id]);
        
    }
    
    public function updateTovarToCartPlus($product_id, $qty) {
        
        $_SESSION['cart'][$product_id]['qty'] = $qty;
        $_SESSION['cart.sum'] += $_SESSION['cart'][$product_id]['price'];
        $_SESSION['cart.qty']++;
    }
    
    public function updateTovarToCartMinus($product_id, $qty) {
        
        $_SESSION['cart'][$product_id]['qty'] = $qty;
        $_SESSION['cart.sum'] -= $_SESSION['cart'][$product_id]['price'];
        $_SESSION['cart.qty']--; 
    }
} 