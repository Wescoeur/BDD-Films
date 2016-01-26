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
# along with this program.  If not, see <http://www.gnu.org/licenses/>.   #
#                                                                         #
# ----------------------------------------------------------------------- #

?>

<div id="index_content">
<h1 class="banner_title">Bienvenue sur TinyMovieDatabase !</h1>
<div id="movies_list">
<h2 class="index_small_title">Derniers films</h2>
<table id="movies_list_content">
<?php

foreach($movies as $key => $movie)
{
  if($key % $w_table == 0)
    echo "<tr>\n";

  echo "<td>\n";
  echo '<a href="movie_' . $movie['Id'] . ".html\">\n";
  echo '<img class="movie_model" title="' . $movie['Title'] . '" src="resources/movie/' . $movie['Id'] . ".jpg\" alt=\"\" />\n";
  echo "</a>\n";
  echo "</td>\n";

  if($key % $w_table == ($w_table - 1))
    echo "</tr>\n";
}

if($key % $w_table != ($w_table - 1))
  echo "</tr>\n";

?>
</table>
</div>
<div class="movie_line"></div>
<div class="index_container">
<h2 class="index_small_title">Genres</h2>
<?php

foreach($themes as $key => $theme)
{
  if($key % $h_theme == 0)
    echo "<ul class=\"index_subcontainer\">\n";

  echo '<li><a href="search-0-0-' . $theme['Id'] . '-0.html">' . $theme['Name'] . "</a></li>\n";

  if($key % $h_theme == ($h_theme - 1))
    echo "</ul>\n";
}

if($key % $h_theme != ($h_theme - 1))
  echo "</ul>\n";

?>
</div>
<div class="index_container">
<h2 class="index_small_title">Epoques</h2>
<?php

foreach($decades as $key => $decade)
{
  if($key % $h_decade == 0)
    echo "<ul class=\"index_subcontainer\">\n";

  echo '<li><a href="search-' . $decade['Year'] . '-0-0-0.html">' . $decade['Year'] . '(' . $decade['Count'] . ")</a></li>\n";

  if($key % $h_decade == ($h_decade - 1))
    echo "</ul>\n";
}

if($key % $h_decade != ($h_decade - 1))
  echo "</ul>\n";

?>
</div>
<div class="index_container">
<h2 class="index_small_title">Lettres</h2>
<?php

$n = 1;

echo "<ul class=\"index_vert_subcontainer\">\n";
echo "<li><a href=\"search-0-0-0-1.html\">#</a></li>\n";

foreach(range('A', 'Z') as $key => $letter)
{
  if($n % $v_letter == 0)
    echo "<ul class=\"index_vert_subcontainer\">\n";

  echo '<li><a href="search-0-0-0-' . ($key + 2) . ".html\">$letter</a></li>\n";

  if($n % $v_letter == ($v_letter - 1))
    echo "</ul>\n";

  $n++;
}

if($n % $v_letter != $v_letter)
  echo "</ul>\n";

?>
</div>
<div class="index_container">
<h2 class="index_small_title">Total: <?php echo $movie_count ?> films</h2>
</div>
<div class="movie_line"></div>
<div class="index_container_2">
<h2 class="index_small_title">Pays</h2>
<?php

foreach($countries as $key => $country)
{
  if($key % $h_country == 0)
    echo "<ul class=\"index_subcontainer\">\n";

  echo '<li><a href="search-0-' . $country['Id'] . '-0-0.html">' . $country['Name'] . "</a></li>\n";

  if($key % $h_country == ($h_country - 1))
    echo "</ul>\n";
}

if($key % $h_country != ($h_country - 1))
  echo "</ul>\n";

?>
</div>
</div>
<div class="movie_line"></div>
