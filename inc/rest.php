<?php

add_action( 'rest_api_init', function () {
  register_rest_route( 'reclaimthecity/v1', '/filter', array(
    'methods' => 'GET',
    'callback' => 'filter_shop',
    'permission_callback' => '__return_true',
  ) );

} );

function filter_shop($data){
  $cat = false;
  $sub_cat=false;
  $order = 'date';
  if($data->get_param('bl_cat')){
    $cat = $data->get_param('bl_cat');
  }
  if($data->get_param('bl_sub_cat')){
    $sub_cat = $data->get_param('bl_sub_cat');
    $sub_cat = json_decode(urldecode($sub_cat));
    if($sub_cat=='reset'){
      $sub_cat=false;
    }
  }
  if($data->get_param('bl_sort')){
    $order = $data->get_param('bl_sort');
  }
  return get_shop_grid($cat,$sub_cat,$order);
}