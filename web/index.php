<?php
// tells you the current directory 
require __DIR__ . "/../src/Repository/GameRepository.php";

// getting all the games the user has rated
$repo = new GameRepository();
// getting the games
$games = $repo->findByUserId(1);

?>
<html>
<body>
<h1>Gamebook Ratings</h1>
<ul>
    <!-- looping thorugh all the games-->
<?php foreach ($games as $game): ?>
   <li>
       <!--showing the title and the id-->
       <span class="title"><?php echo $game->getTitle() ?></span><br>
       <a href="add-rating.php?game=<?php echo $game->getId() ?>">Rate</a>
       <?php echo $game->getAverageScore() ?><br>
       <img src="<?php echo $game->getImagePath() ?>">
   </li>
<?php endforeach ?>
</ul>
</body>
</html>
