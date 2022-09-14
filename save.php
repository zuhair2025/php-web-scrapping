<?php
require 'vendor/autoload.php';
use Symfony\Component\DomCrawler\Crawler;

// url
$startPage = 0;
$endPage = 3;
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

    // Saving the scraped data in a .json file
    // $i = 1;
    foreach($items as $item){
        // grab the image
        $file_name = 'images/'.uniqid() . '-' . time().'.png';
        // get the content
        $image_content = file_get_contents($item['image']);
        // add the content
        file_put_contents('images/'.uniqid() . '-' . time().'.png', $image_content);
        // update the path
        $item['image'] = $file_name;
        // $i++;
    }

    file_put_contents('file.json', json_encode($items,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)); 

    echo 'Successfully saved to json file!';
}
// echo back out to the screen