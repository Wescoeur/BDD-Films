<?php

include_once("view/header.php");
include_once("view/connection.php");

if(isset($_GET['action']))
  switch($_GET['action'])
  {
    /* index.php */
    case 'index':
      include_once("controller/index.php"); break;

    /* movie_(val).html */
    case 'movie':
      include_once("controller/movie.php"); break;

    /* random_movie.html */
    case 'random':
      include_once("controller/random.php"); break;

    /* actors.html & directors.html */
    case 'person':
      if(!isset($_GET['person_type']) || ($_GET['person_type'] != 'actors' && $_GET['person_type'] != 'directors'))
	include_once("controller/index.php");
      else if($_GET['person_type'] == 'actors')
	include_once("controller/actors.php");
      else
	include_once("controller/directors.php");
      break;

    /* search.html */
    case 'search':
      include_once("controller/search.php"); break;

    /* search_by_actor & search_by_director.html */
    case 'search_by_person':
      if(!isset($_GET['search']) || ($_GET['search'] != 'actor' && $_GET['search'] != 'director'))
	include_once("controller/index.php");
      else if($_GET['search'] == 'actor')
	include_once("controller/search_by_actor.php");
      else
	include_once("controller/search_by_director.php");
      break;

    /* default */
    default: break;
  }
else
  include_once("controller/index.php");

include_once("view/footer.php");
