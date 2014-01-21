<?php

/* Model */
include_once('model/movie_list_directors.php');

/* Controller */
$person_limit = 200;
$person_type = 'director';

include_once('controller/abstract/abstract_person.php');

/* View */
include_once('view/person.php');
