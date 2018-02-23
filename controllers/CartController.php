<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 14.05.2016
 * Time: 10:37
 */

namespace app\controllers;
use app\models\Product;
use app\models\Cart;
use app\models\Order;
use app\models\OrderItems;
use Yii;
use yii\helpers\Json;


class CartController extends AppController{

    public function actionAdd(){
        $id = Yii::$app->request->get('id');
        $qty = (int) Yii::$app->request->get('qty');
        $qty = !$qty ? 1 : $qty;
        $product = Product::findOne($id);
        if(empty($product)) return FALSE;
        $session =Yii::$app->session;
        $session->open();
        $cart = new Cart();
        $cart->addToCart($product, $qty);
        
        if(!Yii::$app->request->isAjax) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionClear(){
        $session =Yii::$app->session;
        $session->open();
        $session->remove('cart');
        $session->remove('cart.qty');
        $session->remove('cart.sum');
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }
    
    public function actionUpdate() {
        
        $id = Yii::$app->request->get('id');
        $qty_plus = Yii::$app->request->get('qty_plus');
        $qty_minus = Yii::$app->request->get('qty_minus');
        $session =Yii::$app->session;
        $session->open();
        $cart = new Cart();
        if($qty_plus) {
        $cart->updateTovarToCartPlus($id, $qty_plus);
        $data['sum'] = $session['cart'][$id]['price'] * $qty_plus;
        $data['cart_qty'] = $session['cart.qty'];
        $data['cart_sum'] = $session['cart.sum'];
        }
        if($qty_minus) {
        $cart->updateTovarToCartMinus($id, $qty_minus);
        $data['sum'] = $session['cart'][$id]['price'] * $qty_minus;
        $data['cart_qty'] = $session['cart.qty'];
        $data['cart_sum'] = $session['cart.sum'];
        }
        $res = Yii::$app->getResponse();
        $res->format = yii\web\Response::FORMAT_JSON;
        $res->data = $data;
        $res->send();
        //return Json::encode($data);
    }

        public function actionDell() {
        
        if(Yii::$app->request->isPost) $id = Yii::$app->request->post('id');
        if(Yii::$app->request->isGet) $id = Yii::$app->request->get('id');
        
        $session = Yii::$app->session;
        $session->open();
        
        $cart = new Cart();
        $cart->dellTovarVithCart($id);
        
        if(Yii::$app->request->isPost) return true;
        
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionGetcart() {
        
        $session = Yii::$app->session;
        $session->open();
        
        $this->layout = FALSE;
        return $this->render('cart-modal', compact('session'));
        
    }
    
    public function actionView() {
        
        $session = Yii::$app->session;
        $session->open();
        
        $order = new Order();
        
        if($order->load(Yii::$app->request->Post())) {
            $order->qty = $session['cart.qty'];
            $order->sum = $session['cart.sum'];
            $order->save();
            if($order->save()) {
               // $this->saveOrderItem($session, $order->id);
                if($this->saveOrderItem($session, $order->id)) {
                Yii::$app->session->setFlash('success', 'Ваше замовлення оформленне. Менеджер звяжеться з вами на протязы 15 хв.');
                Yii::$app->mailer->compose('orederToUser', compact('session'))->setFrom('abrams25@yandex.ua')->setTo($order->email)->setSubject('Замовлення')->send();
                    $session->remove('cart');
                    $session->remove('cart.qty');
                    $session->remove('cart.sum');
                return $this->refresh();
                } else {
                    Yii::$app->session->setFlash('error', 'Сталася помилка, спробуйте ще раз 2.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Сталася помилка, спробуйте ще раз.');
            }
        }
        
        return $this->render('view', compact('session', 'order'));
        
    }
    
    public function saveOrderItem($ptoducts, $id_oreder) {
        
        foreach($ptoducts['cart'] as $id => $product) {
            $ob_oreder_item = new OrderItems();
            $ob_oreder_item->name = $product['name'];
            $ob_oreder_item->price = $product['price'];
            $ob_oreder_item->qty_item = $product['qty'];
            $ob_oreder_item->sum_item = $product['price'] * $product['qty'];
            $ob_oreder_item->order_id = $id_oreder;
            $ob_oreder_item->product_id = $id;
            $save = $ob_oreder_item->save();
        }
        return $save;
    }
    
} 