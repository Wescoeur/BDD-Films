<div id="border_content">
<h1 class="banner_title">La totale</h1>
</div>
<div id="select_container">
<select id="decade" onChange="javascript:submit_value();">
<option value="0">Toutes les décennies</option>
<?php
foreach($decades as $decade)
{
   if($select['decade'] == $decade['Year']) echo '<option selected ';
   else echo '<option ';
   echo 'value="' . $decade['Year'] . '">' . $decade['Year'] . "</option>\n";
}
?>
</select>
<select id="country" onChange="javascript:submit_value();">
<option value="0">Toutes les origines</option>
<?php
foreach($countries as $country)
{
  if($select['country'] == $country['Id']) echo '<option selected ';
  else echo '<option ';
  echo 'value="' . $country['Id'] . '">' . $country['Name'] . "</option>\n";
}
?>
</select>
<select id="theme" onChange="javascript:submit_value();">
<option value="0">Tous les thèmes</option>
<?php
foreach($themes as $theme)
{
  if($select['theme'] == $theme['Id']) echo '<option selected ';
  else echo '<option ';
  echo 'value="' . $theme['Id'] . '">' . $theme['Name'] . "</option>\n";
}
?>
</select>
<select id="letter" onChange="javascript:submit_value();">
<option value="0">Toutes les lettres</option>
<option<?php if($select['letter'] == 1) echo ' selected '; ?> value="1">#</option>
<?php
foreach(range('A', 'Z') as $key => $letter)
{
  if($select['letter'] == $key + 2) echo '<option selected ';
  else echo '<option ';
  echo 'value="' . ($key + 2) . '">' . $letter . "</option>\n";
}
?>
</select>
</div>
<div id="movie_table_border">
<table id="movie_table">
<?php

echo "<tr>\n<th></th>\n<th>\n";

for($i = 0; $i * $movies_limit < $movies_count; $i++)
  if($i != $page)
    echo '<span><a href="search-' . $select['decade'] . '-' . $select['country'] . '-' .  $select['theme'] .
      '-' . $select['letter'] . '-' . "$i.html\">$i</a></span>\n";
  else
    echo "<span class=\"movie_select\">$i</span>\n";

echo "</th></tr>\n";

/* INCLUDE */

include_once("view/search_content_table.php");

/* INCLUDE */

for($i = 0; $i * $movies_limit < $movies_count; $i++)
  if($i != $page)
    echo '<span><a href="search-' . $select['decade'] . '-' . $select['country'] . '-' .  $select['theme'] .
      '-' . $select['letter'] . '-' . "$i.html\">$i</a></span>\n";
  else
    echo "<span class=\"movie_select\">$i</span>\n";

echo "</th></tr>\n";
?>
</table>
</div>
<script type="text/javascript">

function getSelectValue(Id)
{
  var elem = document.getElementById(Id);
  return elem.options[elem.selectedIndex].value;
}

function submit_value()
{
  var curlocation = "search-";

  curlocation += getSelectValue('decade') + '-';
  curlocation += getSelectValue('country') + '-';
  curlocation += getSelectValue('theme') + '-';
  curlocation += getSelectValue('letter') + '.html';

  location.href = curlocation;
}

</script>
