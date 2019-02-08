<?php 


class ArticleTag {
	public function insertTag($tags) {
			include('db_function.php');
			foreach($tags as $tag) {
				$sql = "insert into article_tag (article_id, tag_id) values ((select id from article order by ID desc limit 1), (select id from tag where tag_name = :tag))";
			try {
				$st = $conn->prepare( $sql );
				$st->bindValue(":tag", $tag, PDO::PARAM_INT);
				$st->execute();
			} catch ( PDOException $e) {
	            echo "Query failed: " . $e->getMessage();
    		}
			}
		}
}

 ?>