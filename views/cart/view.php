<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="#">Home</a></li>
				  <li class="active">Shopping Cart</li>
				</ol>
			</div>
                    <?php if(Yii::$app->session->hasFlash('success')) : ?>
                        <?php echo Yii::$app->session->getFlash('success'); ?>
                    <?php endif; ?>
                    <?php if(Yii::$app->session->hasFlash('error')) : ?>
                        <?php echo Yii::$app->session->getFlash('error'); ?>
                    <?php endif; ?>
                    <?php if($session['cart']) : ?>
			<div class="table-responsive cart_info">
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Товар</td>
							<td class="description"></td>
							<td class="price">Ціна</td>
							<td class="quantity">Кількість</td>
							<td class="total">Вартість</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
                                            <?php foreach($session['cart'] as $id => $product) : ?>
                                            <tr class="cart_product_<?= $id; ?>">
							<td class="cart_product">
                                                            <a href=""><?= Html::img("@web/images/products/{$product['img']}", ['alt' => $product['name'], 'class' => 'cartModalImg']); ?></a>
							</td>
							<td class="cart_description">
                                                            <h4><a href="<?= \yii\helpers\Url::to(['product/view', 'id' => $id]); ?>"><?= $product['name']; ?></a></h4>
								<p>Web ID: 1089772</p>
							</td>
							<td class="cart_price">
								<p>$<?= $product['price']; ?></p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
                                                                    <a data-id="<?= $id; ?>" class="cart_quantity_up" onclick="return cart_quantity_up(<?= $id; ?>);" href=""> + </a>
                                                                        <input id="cart_quantity_input_<?= $id; ?>" class="cart_quantity_input" type="text" name="quantity" value="<?= $product['qty']; ?>" autocomplete="off" size="2">
									<a data-id="<?= $id; ?>" class="cart_quantity_down" onclick="return cart_quantity_down(<?= $id; ?>);" href=""> - </a>
								</div>
							</td>
							<td class="cart_total">
								<p id="cart_total_price_<?= $id; ?>" class="cart_total_price">$<?= $product['price'] * $product['qty'] ?></p>
							</td>
							<td class="cart_delete">
                                                            <a class="cart_quantity_delete_<?= $id; ?>" onclick="return quantity_delete(<?= $id; ?>);" href=""><i class="fa fa-times"></i></a>
							</td>
                                 
						</tr>
                         
                                            <?php endforeach; ?>
                                                <tr>
                                                    <td colspan="3"><h4>Загальна кількість товарі та ціна: </h4></td>
                                                    <td><b><p class="cart_qty"><?= $session['cart.qty']; ?></p></b></td>
                                                    <td colspan="1"><p class="cart_total_price" id="cart_total_price_all">$<?= $session['cart.sum']; ?></p></td>
                                                    <td colspan="1"></td>
                                                </tr>
					</tbody>
				</table>
			</div>
                    <?php $form = ActiveForm::begin(); ?>
                        <?= $form->field($order, 'name'); ?>
                        <?= $form->field($order, 'email'); ?>
                        <?= $form->field($order, 'phone'); ?>
                        <?= $form->field($order, 'address'); ?>
                        <?= Html::submitButton('Оформити замовлення', ['class' => 'btn btn-success']); ?>
                    <?php ActiveForm::end(); ?>
                    <br>
                    <?php else : ?>
                        <h2>Корзина порожня</h2>
                    <?php endif; ?>
		</div>
	</section>
