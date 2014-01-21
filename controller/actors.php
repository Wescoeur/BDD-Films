<?php

/* Model */
include_once('model/movie_list_actors.php');

/* Controller */
$person_limit = 200;
$person_type = 'actor';

include_once('controller/abstract/abstract_person.php');

/* View */
include_once('view/person.php');
