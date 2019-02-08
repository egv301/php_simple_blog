<?php include('header.php'); ?>
<?php include('sidebar.php'); ?>
<div class="box">
        <?php 
          if (isset($_GET['id'])) {
          $id = $_GET['id'];
          $sql = "select s.* from article s inner join ((select * from article_tag where tag_id = :id)) as vd on vd.article_id = s.id";
          try {
            $st = $conn->prepare($sql);
            $st->bindValue(":id", $id, PDO::PARAM_INT);
            $st->execute();
            foreach ( $st->fetchall() as $row) { 
              $string = $row['article_text'];
              $string = strip_tags($string);
              if (strlen($string) > 400) {

                  // truncate string
                  $stringCut = substr($string, 0, 400);
                  $endPoint = strrpos($stringCut, ' ');

                  
                  $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                  $string .= "... <a href='view_article.php?id=".$row["ID"]."' alt='edit'>Читать далее</a>";
              } ?>
              
              <div class="blog-heading"><?php echo $row['name']?></div>
              <div class="blog-date">Дата Публикации: <?php echo $row['date_published']?></div>
              <div class="blog-body"><?php echo $string; ?></div>
          <?php   }
          } catch ( PDOException $e) {
            echo "Query failed: " . $e->getMessage();
          }
          
          }
        else {
         $sql = "SELECT * from article order by date_published";
          try {
            $rows = $conn->query( $sql );
            foreach ( $rows as $row) { 
              $string = $row['article_text'];
              $string = strip_tags($string);
              if (strlen($string) > 400) {

                  // truncate string
                  $stringCut = substr($string, 0, 400);
                  $endPoint = strrpos($stringCut, ' ');

                  
                  $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                  $string .= "... <a href='view_article.php?id=".$row["ID"]."' alt='edit'>Читать далее</a>";
              } ?>
              
              <div class="blog-heading"><?php echo $row['name']?></div>
              <div class="blog-date">Дата Публикации: <?php echo $row['date_published']?></div>
              <div class="blog-body"><?php echo $string; ?></div>
          <?php   }
          } catch ( PDOException $e) {
            echo "Query filaed: " . $e->getMessage();
          }
          $conn=null;
        }
          ?>
      </div>

<?php include('footer.php'); ?>
