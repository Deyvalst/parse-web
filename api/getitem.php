<?php
ini_set("display_errors","off");
$callback = $_GET["callback"];
// $target = $_GET["id"];
$target = '/p/karandash-maped-black-pep-s-851721-hb-1-sht-117571510';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://kaspi.kz/shop".$target."/?c=750000000");
//https://kaspi.kz/yml/city-registry/cities
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Myapplication/5.0');
curl_setopt($ch, CURLOPT_REFERER, "https://kaspi.kz/shop/c/pharmacy/?c=750000000");

$itempage = curl_exec($ch);
curl_close($ch);

$dom = new DOMDocument();
$dom->loadHTML('<?xml encoding="UTF-8">' . $itempage, options:LIBXML_COMPACT|LIBXML_NONET);
$xpath = new DOMXPath($dom);
$specs = $xpath->query('//dd[@class="specifications-list__specs"]')[0]->childNodes;
$entries = [];
foreach ($specs as $x){
$entries[$x->childNodes[0]->textContent] = $x->childNodes[1]->textContent;
}
$itemdata = [];
$itemdata['details'] = $entries;
$itemdata['title'] = $xpath->query('//h1[@class="item__heading"]')[0]->textContent;
$itemdata['info'] = $xpath->query('//div[@class="description"]')[0]->textContent;

$result = json_encode($itemdata,flags:JSON_UNESCAPED_UNICODE);
echo $callback.'('.$result.')';
?>
