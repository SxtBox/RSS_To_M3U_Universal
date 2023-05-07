<?php
error_reporting(0);
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
if (!ini_get("date.timezone")) {
	date_default_timezone_set("Europe/Tirane");
}

define("CLASS_DIR", dirname(__FILE__));
require_once(CLASS_DIR . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "Feed.php");

//require_once 'src/Feed.php';

/*
SOME RSS LINKS
https://feeds.soundcloud.com/users/soundcloud:users:164601864/sounds.rss
https://promodj.com/mixes/dancecore/rss.xml
https://radiorecord.ru/rss/rss.xml
http://feeds.feedburner.com/aokishouse
https://feeds.acast.com/public/shows/clublife-by-tiesto
https://rss.podomatic.net/rss/davepearce.podomatic.com/rss2.xml
http://www.joachimgarraud.com/Zemixx_By_DJ_Joachim_Garraud.rss
*/

// GET BY ?url={RSS URL}
$rss_url = isset($_GET["url"]) && !empty($_GET["url"]) ? $_GET["url"] : "https://radiorecord.ru/rss/rss.xml";
$rss = Feed::loadRss($rss_url);

// DIRECT URL
//$rss = Feed::loadRss("https://radiorecord.ru/rss/rss.xml");

$main_title = htmlSpecialChars($rss->title);
$main_title = str_replace(":", "", $main_title);
$main_title = str_replace("'", "", $main_title);
//echo $main_title;

$main_description = htmlSpecialChars($rss->description);
//echo $main_description;

//echo htmlSpecialChars($rss->title);
//echo htmlSpecialChars($rss->description);
       if($main_title) {
       $m3u_handler = "#EXTM3U #$main_title".PHP_EOL.PHP_EOL;
       echo $m3u_handler;
	}
       else
    {
       $m3u_handler = "#EXTM3U #Untitled".PHP_EOL.PHP_EOL;
       echo $m3u_handler;
	}

foreach( $rss->item AS $item ) {
// Streams Titles
$title = htmlSpecialChars($item->title);
$title = str_replace("&amp;", "ft", $title);
$title = str_replace("&", "ft", $title);
$title = str_replace("'", "", $title);
// Streams Titles

    if(($item->enclosure['url']))
       $stream = htmlSpecialChars($item->enclosure['url']);
	else
       {
       $stream = htmlSpecialChars($item->link);
       //$stream = htmlSpecialChars($item->enclosure['url']);
    }
//echo $stream;
$stream_title = "#EXTINF:0," .$title.PHP_EOL;
echo $stream_title;
echo $stream.PHP_EOL.PHP_EOL;
}
?>