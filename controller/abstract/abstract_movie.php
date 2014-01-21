<?php

foreach($movie as $key => $value)
  if(is_string($value)) /* Title, Story, Date, Duration, Extension, Size */
    $movie[$key] = htmlspecialchars($value);
  else if(is_array($value)) /* Actors, Directors, Themes, Countries */
    foreach($movie[$key] as $subkey => $subvalue)
      $movie[$key][$subkey]['Name'] = htmlspecialchars($subvalue['Name']);
