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

<div id="border_content">
<h1 class="banner_title"><?php echo $name; ?></h1>
</div>
<div id="movie_table_border">
<table id="movie_table">
<?php
echo "<tr>\n<th></th>\n<th>\n";

for($i = 0; $i * $movies_limit < $movies_count; $i++)
  if($i != $page)
    echo '<span><a href="search_by_' . $search . '-' . $id . '-' . "$i.html\">$i</a></span>\n";
  else
    echo "<span class=\"movie_select\">$i</span>\n";

echo "</th></tr>\n";

/* INCLUDE */

include_once("view/search_content_table.php");

/* INCLUDE */

for($i = 0; $i * $movies_limit < $movies_count; $i++)
  if($i != $page)
    echo '<span><a href="search_by_' . $search . '-' . $id . '-' . "$i.html\">$i</a></span>\n";
  else
    echo "<span class=\"movie_select\">$i</span>\n";

echo "</th></tr>\n";
?>
</table>
</div>
