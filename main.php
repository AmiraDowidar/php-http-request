<?php

// use strict data types
declare(strict_types=1);

/**
 * support function to retrive json data from $url via curl
 * @param $url 
 * return $data
 */

function getDataViaCurl($url){

	// TODO: check http response 200, 404, ...etc

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	// option for returning data
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HEADER, false);
	//retrieve data from curl_exec 
	$data = curl_exec($curl);
	
	curl_close($curl);

	return $data;
}

/**
 * support function to retrive json data from $url via file_get_contents
 * @param $url 
 * return $data
 */

function getDateViaGetFileContents($url){
			//http://php.net/manual/en/function.file-get-contents.php
		$contents = file_get_contents($url);

		//If $contents is not a boolean FALSE value.
		if($contents !== false){
		    //Print out the contents.
		    return $contents;
		}

		return null;
}


/**
 * function to retrive json data from $url and return number of occurences of a topic via substr_count($haystack, $needle)
 * @param $topic 
 * return $data
 */

function CountTopicOccurances(string $topic){

	try {
	   	//The URL with parameters / query string.
		$url = "https://en.wikipedia.org/w/api.php?action=parse&section=0&prop=text&format=json&page=$topic";

		$contents = json_decode(getDataViaCurl($url));
		$contents = json_encode($contents->parse->text);

		//http://php.net/manual/en/function.substr-count.php
		//substring count with case sensitive
		return (int)(substr_count($contents, $topic));
	} catch (Throwable $t) {
	    // Executed only in PHP 7, will not match in PHP 5.x
	    echo $t->getMessage(), "\n";
	} catch (Exception $e) {
	    // Executed only in PHP 5.x, will not be reached in PHP 7
	    echo $e->getMessage(), "\n";
	}



}

if (isset($_GET['topic'])) {
    $topic =  $_GET['topic'];
} else if(isset($argv)){
	$topic =  $argv[0];
}else{
	$topic = "php";
}

$count = CountTopicOccurances($topic);

// TODO: add test function to test for corner cases
