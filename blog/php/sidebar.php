<?php 
include('db_function.php');
?>

<div class="sidebar">
        <p>Тэги</p>
          <ul>
          <?php 
            $sql = "SELECT * from tag";
            try {
              $rows = $conn->query( $sql );
              foreach ( $rows as $row) { 
                echo "<li><a href='.?id=". $row['id']."'>" .$row['tag_name'] . "</a></li>";
              } 
            
            }
          catch ( PDOException $e) {
            echo "Query failed: " . $e->getMessage();
          }
         
            ?>
          </ul>
      </div>

 
