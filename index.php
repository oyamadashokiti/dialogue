<?php
header("Content-Type: text/html; charset=UTF-8");
mb_language("uni");
mb_internal_encoding("utf-8");
mb_http_input("auto");
mb_http_output("utf8");
try{
  $dbh = new PDO('mysql:host=localhost;dbname=dialogue','root','root');

}catch(PDOException $e){
  var_dump($e->getMessage());
  exit;
}
$dbh->query('SET NAMES utf8');

//echo "success!","<br>";

//ユーザーidを指定して名前を表示する関数
function userName($userLogin){
  global $dbh;
  $sql = "select * from user";
  $stmt = $dbh->query($sql);
  foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $user){
    if ($user['user_id'] == $userLogin ){
      echo ($user['user_name'].'<br>');
    }else{
    }
  }
}


//任意のデータを表示
//$table_array = array();
//$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
//echo($row[0]['user_name']); 

//ユーザーごとの興味あるトピックを抽出する関数
function userInterestId($userId){
  global $dbh;
  $sql = "select * from user_id where user_id ="."$userId";
  $stmt = $dbh->query($sql);
  foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $userId){
  $user1Topic[] = $userId['topic_id'];
  }
  return $user1Topic;
}


//TOPIC_IDに紐付いたトピック名を表示する関数
function topicName($userTopic){
  global $dbh;
  $sql = "select * from topic";
  $stmt = $dbh->query($sql);
  foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $topic){
    if(in_array($topic['topic_id'],$userTopic)){
      echo ($topic['topic_name'].'<br>');
    }
  }
}

//トピックに紐付いているタグを抽出する関数
function topicTags($userTopic){
  global $dbh;
  $sql = "select * from topic_tags";
  $stmt = $dbh->query($sql);
  foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $topicTags){
    if(in_array($topicTags['topic_id'],$userTopic)){
      $user1Tag[] = $topicTags['topic_tags_tag'];
    }
  }
  return $user1Tag;
}

userName(1);
$user1Topic = userInterestId(1);
$user1Tags = topicTags($user1Topic);
$user1Tag = array_unique($user1Tags);

userName(2);
$user2Topic = userInterestId(2);
$user2Tags = topicTags($user2Topic);
$user2Tag = array_unique($user2Tags);

//共通話題
$intersect = array_intersect($user1Topic,$user2Topic);

//共通タグ
$tagIntersect = array_intersect($user1Tag,$user2Tag);

topicName($intersect);
var_dump($tagIntersect);

//切断
$dbh = null;
