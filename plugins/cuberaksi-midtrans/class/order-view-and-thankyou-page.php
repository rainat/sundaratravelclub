<?php
/**
 * Output HTML to display payment/instruction url
 */

global $woocommerce;

//create the order object
$order = new WC_Order( $order_id );

// ## Print HTML
?>
<?php if( $order->meta_exists('_mt_payment_url') ) : ?>
  <div style="display:none">
  <h2>Payment Info</h2>
  <table class="woocommerce-table shop_table midtrans_payment_info">
      <tbody>
          <?php if( $order->is_paid() ) : ?>
          <tr>
              <th>Payment Status</th>
              <td>Payment Completed</td>
          </tr>
          <?php else : ?>
          <!-- TODO refactor this script tag to be CSP compliant -->
          <!-- Make customer focus to payment url, if order need payment -->
          <script type="text/javascript">
            setTimeout(function(){
              document.querySelectorAll('.midtrans_payment_info')[0].scrollIntoView();
            }, 1500);
          </script>
          <?php endif; ?>
          <?php if( $order->meta_exists('_mt_payment_pdf_url') ) : ?>
          <tr>
              <th>Payment Instructions</th>
              <td><?php echo '<a href="'.esc_url($order->get_meta('_mt_payment_pdf_url')).'">'.esc_url($order->get_meta('_mt_payment_pdf_url')).'</a>'?></td>
          </tr>
          <?php else : ?>
          <tr>
              <th>Payment Page</th>
              <td><?php echo '<a href="'.esc_url($order->get_meta('_mt_payment_url')).'">'.esc_url($order->get_meta('_mt_payment_url')).'</a>'?></td>
          </tr>
          <?php endif; ?>
      </tbody>
  </table>

</div>
<?php 
      $founded = get_posts(['post_type'=>'elementor_library','post_title'=>'Customer Panel Button']);

      if ($founded) {
        $customer_button_id = $founded[0]->ID;
        echo do_shortcode("[elementor-template id='$customer_button_id']"); 
      }
      
      ?>
<?php endif; ?>
<?php
// ## End of print HTML