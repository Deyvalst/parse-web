<?php
ini_set("display_errors","off");
$type = 'Categories';
if($_GET['type']){
$type = $_GET['type'];
}
if($_GET['page']){
$page = '='.$_GET['page'];
}
if($_GET['match']){
$match = '='.rawurlencode($_GET['match']);
}
	//$homepage = file_get_contents('https://'.$_GET["target"],false,stream_context_create($c));
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://kaspi.kz/yml/product-view/pl/results?page"
  .$page."&q=%3AavailableInZones%3AMagnum_ZONE1%3Acategory%3A".$type."&text".$match.
  "&sort=relevance&qs&ui=d&i=-1&c=750000000");
//curl_setopt($ch, CURLOPT_URL, "https://kaspi.kz/yml/product-view/pl/filters?q=%3AavailableInZones%3AMagnum_ZONE1%3Acategory%3A".$type."&text&all=false&page=".$page."&sort=relevance&ui=d&i=-1&c=750000000");
//https://kaspi.kz/yml/city-registry/cities
// filters?text=%D0%BC%D0%B0%D1%82%D1%80%D0%B0%D1%81&page=0&all=false&fl=true&ui=d&q=%3AavailableInZones%3AMagnum_ZONE1&i=-1&c=750000000
// https://kaspi.kz/yml/product-view/pl/results?page=1&q=%3AavailableInZones%3AMagnum_ZONE1%3Acategory%3ACategories&text&sort=relevance&qs&requestId=c101752777a1e37482f8172e56681da4&ui=d&i=-1&c=750000000
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Myapplication/5.0');
curl_setopt($ch, CURLOPT_REFERER, "https://kaspi.kz/shop/c/pharmacy/?c=750000000");

$response = curl_exec($ch);
curl_close($ch);
$response = json_decode($response);
$callback = $_GET["callback"];
  //$data = json_encode(['data' => $homepage]);

  echo $callback.'('.json_encode($response->data, flags:JSON_UNESCAPED_UNICODE).')';
?>
