<?php


header("Content-Type: text/html; charset=UTF-8");
$topicCode = file_get_contents("movieTopic.txt");
$topics = explode("\n", $topicCode);
for($i = 0; $i <= 1623; $i++){
$topics[$i] = $topics[$i].',""'."\n";
}
echo($topics[100]);

file_put_contents("movieTopic2.txt", $topics);
