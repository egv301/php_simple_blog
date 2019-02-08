<?php include('header.php'); ?>
<?php include('ArticleTag.php'); ?>
<?php
// define variables and set to empty values
$article_name_Err = $article_textErr = $tagError = "";
$article_name = $article_text = $tag_text = "";
$successValidate = false;
$thanks="";

if ( isset($_POST['submit']) and $_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["article_name"])) {
    $article_name_Err = "Название Обязательное";
    $successValidate = false;
    $thanks = "";
  } else {
    $article_name = test_input($_POST["article_name"]);
    
     $successValidate = true;
     $thanks = "Статья опубликована";

    
  }
   

  if (empty($_POST["article_text"])) {
    $article_textErr = "Обязательное поле";
    $successValidate = false;
    $thanks = "";
  } else {
    $article_text = test_input($_POST["article_text"]);
    $successValidate = true;
    $thanks = "Статья опубликована";
  }

  if (empty($_POST["tag_text"])) {
    $tagError = "Обязательное поле";
   $successValidate = false;
   $thanks = "";
  } else {
    $tag_text = test_input($_POST["tag_text"]);
    $successValidate = true;
    $thanks = "Статья опубликована";
  }


}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<div class="box">
	

<h2>Добавить статью</h2>
<form method="post" action="add_article.php">
  <p>  
  <label for="name">Название Статьи</label>
  <input type="text"   required="" name="article_name" value="">
  <span class="error">* <?php echo $article_name_Err;?></span>
  </p>  
  <br>
  <p>
  <label for="name">Статья</label> 
  <textarea name="article_text" required="" rows="5" cols="40"></textarea>
  <span class="error"><?php echo $article_textErr;?></span>
  <br><br>
  <p>  
  <label for="name">Теги</label>
  <input type="text" required="" name="tag_text" value="">
  <span class="error">* <?php echo $tagError;?></span>
 </p>
  <input type="submit" name="submit" value="Отправить">
  </p>
  
  	
  
</form>
	<div style="height: 50px; width: 50px; margin: 0 auto;">
		<p><?php echo $thanks; ?></p>
	</div>

</div>



<?php if ($successValidate) {
	$sql = "insert into article (name, date_published, article_text) values (:article_name, :date, :article_text)";
	try {
		$st = $conn->prepare( $sql );
		$st->bindValue(":article_name", $article_name, PDO::PARAM_STR);
		$st->bindValue(":article_text", $article_text, PDO::PARAM_STR);
		$st->bindValue(":date", date("Y-m-d"), PDO::PARAM_STR);
		$st->execute();



	} catch ( PDOException $e) {
            echo "Query failed: " . $e->getMessage();
    }

    $tagsArray = [];
    $sql = "select * from tag";
    try{
    	$st = $conn->prepare($sql);
    	$st->execute();
    	foreach ($st->fetchall() as $row) {
    		$tagsArray[] = $row['tag_name'];
    	}
    } catch (PDOException $e) {
    	echo "Query failed" . $e->getMessage();
    }

   	// insert tags
	$myArray = explode(',', $tag_text);
	foreach ($myArray as $element) {
		if (!in_array($element, $tagsArray))
		$sql = "insert into tag (tag_name) values (:tag_name)";
		try {
			$st = $conn->prepare( $sql );
			$st->bindValue(":tag_name", $element, PDO::PARAM_STR);
			$st->execute();
		} catch ( PDOException $e) {
            echo "Query failed: " . $e->getMessage();
    		}
		}


   	$artTagObj = new ArticleTag();
   	// $artTagObj->getTags();
   	$artTagObj->insertTag($myArray = explode(',', $tag_text));
   	$article_name = $article_text = $tag_text = "";
   	$thanks="";
   	}
?>

<?php include('footer.php'); ?>