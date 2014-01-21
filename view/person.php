<div id="border_content">
<h2 class="banner_title">
<?php

if($person_type == 'actor') echo 'Acteurs';
else echo 'Réalisateurs';
echo ": $person_count";

?>
</h2>
</div>
<div id="person_table_border">
<table id="person_table">
<?php

/* Lettres */
echo "<tr>\n<th></th>\n<th>\n";

if($letter != '-')
  echo '<span><a href="' . $person_type . "s.html\">-</a></span>\n";
else
  echo "<span class=\"person_select\">-</span>\n";

foreach(range('A', 'Z') as $a_letter)
{
  if(lcfirst($a_letter) != $letter)
    echo '<span><a href="' . $person_type . 's-' . lcfirst($a_letter) . ".html\">$a_letter</a></span>\n";
  else
    echo "<span class=\"person_select\">$a_letter</span>\n";
}

echo "</th>\n</tr>\n";

/* Numéros */
if($person_count > $person_limit)
{
  echo "<tr>\n<th></th>\n<th>\n";

  for($i = 0; $i * $person_limit < $person_count; $i++)
    if($i != $page)
    {
      if($letter == '-')
	echo "<span><a href=\"$person_type-$i.html\">$i</a></span>\n";
      else
	echo "<span><a href=\"$person_type-$letter-$i.html\">$i</a></span>\n";
    }
    else
      echo "<span class=\"person_select\">$i</span>\n";

  echo "</th></tr>\n";
}

echo "<tr><th id=\"person_num\"></th><th id=\"person_page\">" . ucfirst($letter) . "</th></tr>\n";

/* Données */
foreach($persons as $key => $value)
  echo '<tr><td class="person_id">' . ($key + 1 + $person_limit * $page) .
  '</td><td class="person_name"><a href="search_by_' . $person_type . '-' . $value['Id'] . '.html">' . $value['Name'] . "</a></td></tr>\n";

?>
</table>
</div>
