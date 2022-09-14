<?php
require 'vendor/autoload.php';
use Symfony\Component\DomCrawler\Crawler;

// url
$startPage = 1;
$endPage = 10;
for($i=$startPage;$i<=$endPage;$i++){
    webScrape($i);
    echo '<br>';
}
function webScrape($p){
    $client = new \GuzzleHttp\Client();

    $url = 'YOUR URL'; // put a url you want to scrap
    $res = $client->request('GET', $url);

    // go get the data from url
    $html = ''.$res->getBody();
    $crawler = new Crawler($html);

    // loop through the data
    $items = $crawler->filter('.product_item_wrapper')->each(function (Crawler $item, $i) {
        $title = $item->filter('.product-title')->text();
        $author = $item->filter('.wd_product_categories')->text();
        $image = $item->filter('img')->attr('src');
        $price = $item->filter('.amount')->text();
        $item = [
            'image' => $image,
            'title' => $title,
            'author' => $author,
            'price' => $price
        ];

        return $item;
    });

    foreach($items as $item){
        echo '<img src="'.$item['image'].'"/>';
        echo '<p>'.$item['title'].'</p>';
        echo '<p>'.$item['author'].'</p>';
        echo '<p>'.$item['price'].'</p>';
    }
}
// echo back out to the screen