<?php
use yii\helpers\Html;
?>

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
                                                            <h4><a href="<?= \yii\helpers\Url::to(['product/view', 'id' => $id], true); ?>"><?= $product['name']; ?></a></h4>
								<p>Web ID: 1089772</p>
							</td>
							<td class="cart_price">
								<p>$<?= $product['price']; ?></p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
                                        
                                                                        <input id="cart_quantity_input_<?= $id; ?>" class="cart_quantity_input" type="text" name="quantity" value="<?= $product['qty']; ?>" autocomplete="off" size="2">
						
								</div>
							</td>
							<td class="cart_total">
								<p id="cart_total_price_<?= $id; ?>" class="cart_total_price">$<?= $product['price'] * $product['qty'] ?></p>
							</td>
					
                                 
						</tr>
                         
                                            <?php endforeach; ?>
                                                <tr>
                                                    <td colspan="3"><h4>Загальна кількість товарі та ціна: </h4></td>
                                                    <td><p class="cart_qty"><b><?= $session['cart.qty']; ?></b></p></td>
                                                    <td colspan="1"><p class="cart_total_price">$<?= $session['cart.sum']; ?></p></td>
                                                    <td colspan="1"></td>
                                                </tr>
					</tbody>
				</table>
			</div>
