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

/* -------------------------------------------------------------------- */
/* Récupérations des infos sur des films :                              */
/* - Tout                                                               */
/* - Auteurs/Réalisateurs/Thèmes/Pays                                   */
/* - Minimum (Année/Scénario/Id/...) par le fichier movie_base.php      */
/* -------------------------------------------------------------------- */

include_once("model/movie_base.php");

function movie_abstract_get_all($id, $query)
{
  global $dtb;
  $sth = $dtb->prepare($query);
  $sth->execute(array((int)$id));
  return $sth->fetchAll(PDO::FETCH_ASSOC);
}

/* Retourne les acteurs d'un film */
function get_movie_actors($id)
{
  $query = "SELECT Id_Actor AS Id, Name FROM Movie, Actor, Starred_in
            WHERE Id_Actor = Actor.Id AND Id_Movie = Movie.Id
            AND Movie.Id = ?";
  return movie_abstract_get_all($id, $query);
}

/* Retourne les réalisateurs d'un film */
function get_movie_directors($id)
{
  $query = "SELECT Id_Director AS Id, Name FROM Movie, Director, Directed_by
            WHERE Id_Director = Director.Id AND Id_Movie = Movie.Id
            AND Movie.Id = ?";
  return movie_abstract_get_all($id, $query);
}

/* Retourne les thèmes d'un film */
function get_movie_themes($id)
{
  $query = "SELECT Id_Theme AS Id, Name FROM Movie, Theme, Is_a
            WHERE Id_Theme = Theme.Id AND Id_Movie = Movie.Id
            AND Movie.Id = ?";
  return movie_abstract_get_all($id, $query);
}

/* Retourne les pays de production d'un film */
function get_movie_countries($id)
{
  $query = "SELECT Id_Country AS Id, Name FROM Movie, Country, Made_in
            WHERE Id_Country = Country.Id AND Id_Movie = Movie.Id
            AND Movie.Id = ?";
  return movie_abstract_get_all($id, $query);
}

/* Retourne la totalité des infos sur un film */
function get_movie_full($id)
{
  if(($movie = get_movie_base($id)) == null)
    return null;

  $movie['Actors'] = get_movie_actors($id);
  $movie['Directors'] = get_movie_directors($id);
  $movie['Themes'] = get_movie_themes($id);
  $movie['Countries'] = get_movie_countries($id);

  return $movie;
}

/* Retourne la totalité des infos sur un film tiré au hasard */
function get_random_movie_full()
{
  if(($movie = get_random_movie_base()) == null)
    return null;

  $movie['Actors'] = get_movie_actors($movie['Id']);
  $movie['Directors'] = get_movie_directors($movie['Id']);
  $movie['Themes'] = get_movie_themes($movie['Id']);
  $movie['Countries'] = get_movie_countries($movie['Id']);

  return $movie;
}
