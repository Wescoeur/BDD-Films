<?php

# ----------------------------------------------------------------------- #
# Copyright (C) 2014-2016 ABHAMON Ronan                                   #
#                                                                         #
# This program is free software: you can redistribute it and/or modify    #
# it under the terms of the GNU General Public License as published by    #
# the Free Software Foundation, either version 3 of the License, or       #
# (at your option) any later version.                                     #
#                                                                         #
# This program is distributed in the hope that it will be useful,         #
# but WITHOUT ANY WARRANTY; without even the implied warranty of          #
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           #
# GNU General Public License for more details.                            #
#                                                                         #
# You should have received a copy of the GNU General Public License       #
# along with this program.  If not, see <http://www.gnu.org/licenses/>. 1 #
#                                                                         #
# ----------------------------------------------------------------------- #

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
