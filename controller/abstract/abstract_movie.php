<?php

# ---------------------------------------------------------------------- #
# Filename: abstract/abstract_movie.php                                  #
# Author: ABHAMON Ronan                                                  #
# Date: 2014-01-22 - 14:00:12                                            #
# Site: https://github.com/Wescoeur                                      #
#                                                                        #
# ---------------------------------------------------------------------- #

foreach($movie as $key => $value)
  if(is_string($value)) /* Title, Story, Date, Duration, Extension, Size */
    $movie[$key] = htmlspecialchars($value);
  else if(is_array($value)) /* Actors, Directors, Themes, Countries */
    foreach($movie[$key] as $subkey => $subvalue)
      $movie[$key][$subkey]['Name'] = htmlspecialchars($subvalue['Name']);
