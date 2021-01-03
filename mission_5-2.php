<html>
<head lang="ja">
<meta charset="utf-8">
<title>mission_5-1.php</title>
</head>
<body>
    
<?php
	// DB接続設定
	$dsn = 'mysql:dbname=データベース名;host=localhost';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
	//データベース内にテーブルを作成
    $sql= "CREATE TABLE IF NOT EXISTS tbtest";
	$stmt = $pdo->query($sql);
	
	
     //投稿機能
    $sql = $pdo -> prepare("INSERT INTO tbtest (name, comment) VALUES (:name, :comment )");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	
	//もし名前とコメントが埋まっていたら投稿
	if(!empty($_POST["name"]) && !empty($_POST["comment"] && !empty($_POST["pass"] && empty($_POST["edit_num"])))) {
	   if($_POST["pass"]=="pass"){
	      $name = $_POST["name"];
          $comment = $_POST["comment"];
          $date=date("Y/m/d H:i:s");
	      $pass = $_POST["pass"];
	      $sql -> execute();
	}
	}
	
    	//削除機能
	//削除フォームと削除パスワードが埋まっているとき
    if(!empty($_POST["delete"])&& !empty($_POST["delpass"])) { 
     //削除のパスワード設定
     if($_POST["delpass"]=="delpass"){
         $deleteid = $_POST["delete"];
	     $sql = 'delete from tbtest where id=:id';
         $stmt = $pdo->prepare($sql);
	     $stmt->bindParam(':id', $deleteid, PDO::PARAM_INT);
	     $stmt->execute();
     }
	 }
	   	
	   	//編集選択機能
	if(!empty($_POST["edit"])&& !empty($_POST["editpass"])){
	   //編集のパス設定
	   if($_POST["editpass"]=="editpass"){
	      $editid = $_POST["edit"]; //変更する投稿番号
	      $editpass=$_POST["editpass"];
          $sql = 'SELECT * FROM tbtest';
	      $stmt = $pdo->prepare($sql);
	      $stmt->bindParam(';id', $editid,PDO::PARAM_INT);
	      $stmt->execute();
          $results = $stmt->fetchAll();
    
       foreach($results as $row){
          if($row['id'] == $editid){
             $editname = $row['name'];
             $editcomment = $row['comment'];
         
             $editnum = $row['id'];     
      }
     }
   }
}
    
      //編集実行機能
    if((!empty($_POST["name"]))&&(!empty($_POST["comment"]))&&(!empty($_POST["edit_num"]))){
       $editid = $_POST["edit_num"];      //ここで編集対象番号の値の受け取りを行う
       $name = $_POST["name"];
       $comment = $_POST["comment"];
       $sql = 'UPDATE tbtest SET name=:name,comment=:comment WHERE id=:id';
       $stmt = $pdo->prepare($sql);
       $stmt->bindParam(':name', $name, PDO::PARAM_STR);
       $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
       $stmt->bindParam(':id', $editid, PDO::PARAM_INT);
       $stmt->execute();
    }
	 
	 ?>
	<form action="mission_5-1.php" method="post">
      <input type="text" name="name" placeholder="名前" value="<?php if(isset($editname)) {echo $editname;} ?>"><br>
      <input type="text" name="comment" placeholder="コメント" value="<?php if(isset($editcomment)) {echo $editcomment;} ?>"><br>
      <input type="text" name="pass" placeholder="パスワード" value="<?php if(!empty($editpass)){echo $pass;}?>">
      <input type="hidden" name="edit_num" value="<?php if(isset($editnum)) {echo $editnum;} ?>"> <!--編集番号が送信されたら、投稿フォームの編集選択フォームに表示に表示-->
      <input type="submit" name="submit" value="送信">
    </form>

    <form action="mission_5-1.php" method="post">
      <input type="text" name="delete" placeholder="削除対象番号" ></br>
      <input type="text" name="delpass"  placeholder="パスワード" >
      <input type="submit"  value="削除">
    </form>

    <form action="mission_5-1.php" method="post">
      <input type="text" name="edit" placeholder="編集対象番号"></br>
      <input type="text" name="editpass" placeholder="パスワード">
      <input type="submit" value="編集">
    </form>
    
  
<?php
    $date=date("Y/m/d H:i:s");
	$sql = "SELECT * FROM tbtest ";
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].' ';
		echo $row['name'].' ';
		echo $row['comment'].' ';
	    echo $date=date("Y/m/d H:i:s");
		echo '<br>';
		
	echo "<hr>";
	} 
	
	?>
	
	</body>
	
	</html>