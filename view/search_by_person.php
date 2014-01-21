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
