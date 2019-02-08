<?php 
include('header.php');
?>


<div class="box">
	<?php if(isset($_GET['id']))  {  

		$id = $_GET['id'];
		$sql = "select * from article where id = :id";
		try {
			$st = $conn->prepare($sql);
			$st->bindValue(":id", $id, PDO::PARAM_INT);
			$st->execute(); 
			$row=$st->fetch();
			?>
			<div class="blog-heading"><?php echo $row['name']?></div>
            <div class="blog-date">Дата Публикации: <?php echo $row['date_published']?></div>
            <div class="blog-body"><?php echo $row['article_text']; ?></div>

		<?php 
		} catch (PDOException $e) {
			echo "Query failes" . $e->getMessage();
		}

	 } ?>
</div>




<?php include('footer.php'); ?>



 