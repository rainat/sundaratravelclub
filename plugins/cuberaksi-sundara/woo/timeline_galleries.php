<?php

namespace Cuberaksi\WooCommerce;
/*
* @params post ID $post_id
*/

function get_timeline_galleries($post_id)
{
   $results = [];
   for ($i = 1; $i <= 12; $i++) {
      $results["day{$i}"] = get_gallery_each_day("{$i}", $post_id);
   }
   return $results;
}

function get_gallery_each_day($day, $post_id)
{
   $results = [];
   if (have_rows('repeater_day_' . $day, $post_id)) :

      // Loop through rows.
      while (have_rows('repeater_day_' . $day, $post_id)) : the_row();
         $gallery = false;
         $images = get_sub_field('gallery');
         $json_images = wp_json_encode($images);
         // echo "<script>console.log($day,$json_images)</script>";
         if ($images) {
            $gallery = [];
            foreach ($images as $image) {
               $gallery[] = ['full' => $image['url'], 'thumbnail' => $image['sizes']['thumbnail']];
            }
         }
         // Load sub field value.
         $icon = get_sub_field('icon');
         // if ($icon) $icon = $icon['url'];
         $results[] = ['icon' => $icon, 'title' => get_sub_field('title'), 'description' =>  get_sub_field('description'), 'gallery' => $gallery];

      // Do something...

      // End loop.
      endwhile;
      return $results;
   // No value.
   else :
   // Do something...
   endif;

   return false;
}
