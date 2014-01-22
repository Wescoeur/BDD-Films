<?php

# ---------------------------------------------------------------------- #
# Filename: abstract/abstract_person.php                                 #
# Author: ABHAMON Ronan                                                  #
# Date: 2014-01-22 - 14:00:12                                            #
# Site: https://github.com/Wescoeur                                      #
#                                                                        #
# ---------------------------------------------------------------------- #

$person_b = ($person_type == 'actor');

/* Lettre */
if(!isset($_GET['letter']) || !preg_match('#^[a-z]#', $_GET['letter']))
  $letter = '-';
else
  $letter = $_GET['letter'][0];

/* Nombre de personnes */
if($letter == '-')
  $person_count = ($person_b) ? get_actors_number() : get_directors_number();
else
  $person_count = ($person_b) ? get_actors_l_number($letter) : get_directors_l_number($letter);

/* Page */
if(!isset($_GET['page']) || !preg_match('#^[0-9]+#', $_GET['page']))
  $page = 0;
else
  $page = $_GET['page'];

/* Liste */
if($letter == '-')
  $persons = ($person_b) ?
    get_actors_list($page * $person_limit, $person_limit) :
    get_directors_list($page * $person_limit, $person_limit);
else
  $persons = ($person_b) ?
    get_actors_l_list($letter, $page * $person_limit, $person_limit) :
    get_directors_l_list($letter, $page * $person_limit, $person_limit);

/* Sécurité accès ... */
foreach($actors as $key => $value)
  $persons[$key]['Name'] = htmlspecialchars($value['Name']);
