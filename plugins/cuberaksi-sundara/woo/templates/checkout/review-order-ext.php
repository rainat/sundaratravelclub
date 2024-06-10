<?php
		<!-- ori -->
						<div style="width:100%;display: none;gap:4px;">


							<img style="display: block;" src="<?php echo $image[0]; ?>" />

							<?php echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key)) . '&nbsp;'; ?>
							<?php //echo apply_filters('woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf('&times;&nbsp;%s', $cart_item['quantity']) . '</strong>', $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
							$from = date('Y-m-d', $cart_item['yith_booking_data']['from']);
							$to = date('Y-m-d', $cart_item['yith_booking_data']['to']);
							echo "<div>From: $from</div>";
							echo "<div>To: $to</div>";
							?>



							<?php //$text_formatted = wc_get_formatted_cart_item_data($cart_item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 

							//  $date = $cart_item['ameliabooking']['dateTimeValues'][0]['start'];
							//  echo  date('d M Y h:i:s',strtotime($date));

							?>
						</div>
						<!-- end ori -->