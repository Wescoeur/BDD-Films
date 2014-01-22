<?php

# ---------------------------------------------------------------------- #
# Filename: view/movie.php                                               #
# Author: ABHAMON Ronan                                                  #
# Date: 2014-01-22 - 14:00:37                                            #
# Site: https://github.com/Wescoeur                                      #
#                                                                        #
# ---------------------------------------------------------------------- #

?>

<div id="border_content">
<h2 class="banner_title"><?php echo $movie['Title'] ?></h2>
<img id="movie_img" src="resources/movie/<?php echo $movie['Id'] ?>.jpg" alt="Où qu'il est mon titre ?" />
<ul>
<li><span class="movie_legend">Date de sortie</span><span class="movie_info"><?php echo $movie['Date'] ?></span></li>
<li><span class="movie_legend">Durée du film</span><span class="movie_info"><?php echo $movie['Duration'] ?></span></li>
<?php
$movie_info = ['Directors', 'Actors', 'Themes', 'Countries'];
foreach($movie_info as $info)
{
  echo "<li>\n<span class=\"movie_legend\">";

  switch($info)
  {
    case 'Directors':
      echo 'Réalisateur'; break;
    case 'Actors':
      echo 'Acteur';      break;
    case 'Themes':
      echo 'Thème';       break;
    case 'Countries':
      echo 'Pays';        break;
  }

  if(count($movie[$info]) > 1 and $info != 'Countries')
    echo 's';

  echo "</span>\n<span class=\"movie_info\">\n<ul>\n";

  foreach($movie[$info] as $key => $value)
  {
    echo '<li><a href="search';

    switch($info)
    {
      case 'Directors':
	echo '_by_director-' . $value['Id'] . '.html">'; break;
      case 'Actors':
	echo '_by_actor-' . $value['Id'] . '.html">';    break;
      case 'Themes':
	echo '-0-' . $value['Id'] . '-0-0.html">';       break;
      case 'Countries':
	echo '-0-0-' . $value['Id'] . '-0.html">';       break;
    }

    echo $value['Name'] . '</a>';

    if($key + 1 != count($movie[$info]))
      echo ',';
    echo "</li>\n";
  }

  echo "</ul>\n</span>\n</li>\n";
}
?>
<li>
<span class="movie_legend">Allocine</span>
<span class="movie_info">
<?php echo '<a target="_vblank" href="http://www.allocine.fr/film/fichefilm_gen_cfilm=' . $movie['Id'] . ".html\">\n"; ?>
<img id="allo" src="resources/others/allo.png" alt="Lien" />
</a>
</span>
</li>
</ul>
</div>
<div class="movie_line"></div>
<div id="movie_story_border">
<h2 class="movie_part">Synopsis</h2>
<p id="movie_story_content"><?php echo $movie['Story']; ?>
</p>
</div>
<div class="movie_line"></div>
