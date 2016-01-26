#!/usr/bin/ruby
# -*- coding: utf-8 -*-

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
# along with this program.  If not, see <http://www.gnu.org/licenses/>. 1 #
#                                                                         #
# ----------------------------------------------------------------------- #

require 'mysql'

$dir_movie_images = 'Images'

########################
#                      #
# Class Database       #
#                      #
########################

class Database
  def initialize(hostname, username, password, database)
    @dtb = Mysql.real_connect(hostname, username, password, database)
    puts "Server Version: " + @dtb.get_server_info

    # Création des tables si elles n'existent pas
    @dtb.query("CREATE TABLE IF NOT EXISTS Movie
                (Id INT UNSIGNED PRIMARY KEY,
                 Title VARCHAR(255) NOT NULL,
                 Date VARCHAR(30),
                 Duration VARCHAR(10),
                 Story TEXT,
                 Extension VARCHAR(10),
                 Size BIGINT UNSIGNED,
                 LastModification INT UNSIGNED,
                 Date_add DATETIME)")
    @dtb.query("CREATE TABLE IF NOT EXISTS Actor
                (Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                 Name VARCHAR(100) NOT NULL)")
    @dtb.query("CREATE TABLE IF NOT EXISTS Director
                (Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                 Name VARCHAR(100) NOT NULL)")
    @dtb.query("CREATE TABLE IF NOT EXISTS Theme
                (Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                 Name VARCHAR(50) NOT NULL)")
    @dtb.query("CREATE TABLE IF NOT EXISTS Country
                (Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                 Name VARCHAR(50) NOT NULL)")
    @dtb.query("CREATE TABLE IF NOT EXISTS Directed_by
                (Id_movie INT UNSIGNED REFERENCES Movie(Id),
                 Id_director INT UNSIGNED REFERENCES Director(Id),
                 PRIMARY KEY(Id_movie, Id_director))")
    @dtb.query("CREATE TABLE IF NOT EXISTS Starred_in
                (Id_movie INT UNSIGNED REFERENCES Movie(Id),
                 Id_actor INT UNSIGNED REFERENCES Actor(Id),
                 PRIMARY KEY(Id_movie, Id_actor))")
    @dtb.query("CREATE TABLE IF NOT EXISTS Made_in
                (Id_movie INT UNSIGNED REFERENCES Movie(Id),
                 Id_country INT UNSIGNED REFERENCES Country(Id),
                 PRIMARY KEY(Id_movie, Id_country))")
    @dtb.query("CREATE TABLE IF NOT EXISTS Is_a
                (Id_movie INT UNSIGNED REFERENCES Movie(Id),
                 Id_theme INT UNSIGNED REFERENCES Theme(Id),
                 PRIMARY KEY(Id_movie, Id_theme))")
  end

  # Fermeture de la BDD
  def close
    @dtb.close if @dtb
  end

  # Vérifie qu'un fichier donné est dans la base
  def include?(filename_path)
    movie_name = Mysql.escape_string(File.basename(filename_path, '.*'))
    res = @dtb.query("SELECT Extension, Size, LastModification FROM Movie WHERE Title = \"#{movie_name}\"")

    while row = res.fetch_row
      return true if row[0] == File.extname(filename_path) and
        row[1] == File.size(filename_path).to_s and
        row[2] == File.mtime(filename_path).to_i.to_s
    end

    false
  end

  # Ajoute un film dans la base
  def add(movie, filename_path)
    if not @dtb.query("SELECT Id FROM Movie WHERE Id = #{movie.id}").num_rows.zero?
      return puts "Error : ID(#{movie.id}) already exist !"
    end

    file = Mysql.escape_string(File.basename(filename_path, '.*')).force_encoding("UTF-8")
    story = Mysql.escape_string(movie.story).force_encoding("UTF-8")
    image = movie.id.to_s + File.extname(movie.image)

    Dir.mkdir($dir_movie_images) if not Dir.exist? $dir_movie_images
    download_movie_image(movie.id, movie.image)

    @dtb.query("INSERT INTO Movie
                VALUES
                (#{movie.id}, \"#{file}\", \"#{movie.date}\", \"#{movie.duration}\",
                 \"#{story}\", \"#{File.extname(filename_path)}\", #{File.size(filename_path)},
                 #{File.mtime(filename_path).to_i}, \"#{Time.now.to_s}\")")

    movie.countries.each { |country| add_value(country, :country)
      add_relation_value(movie.id, country, :country)}
    movie.actors.each { |actor| add_value(actor, :actor)
      add_relation_value(movie.id, actor, :actor)}
    movie.director.each { |director| add_value(director, :director)
      add_relation_value(movie.id, director, :director)}
    movie.themes.each { |theme| add_value(theme, :theme)
      add_relation_value(movie.id, theme, :theme)}
  end

  def search(movie_name, type)
    case type
      when :country
        jtable = "Made_in"
      when :actor
        jtable = "Starred_in"
      when :director
        jtable = "Directed_by"
      when :theme
        jtable = "Is_a"
      else
        return nil
    end

    movie_name = Mysql.escape_string(movie_name).force_encoding("UTF-8")
    table = type.to_s
    arr = []
    res = @dtb.query("SELECT Name FROM #{table.capitalize}, #{jtable}, Movie
                      WHERE #{table.capitalize}.Id = Id_#{table} AND Movie.Id = Id_movie AND
                      Title LIKE \"#{movie_name.to_s}\"")
    while row = res.fetch_row do arr << row[0] end
    arr
  end

  private

  # Vérifie qu'un élément d'une colonne de table est dans la base
  # type = :country, :actor, :director, :theme
  def include_value?(value, type)
    not @dtb.query("SELECT Name FROM #{type.to_s.capitalize} WHERE Name = \"#{value}\"").num_rows.zero?
  end

  # Ajoute un élément dans une des colonnes de table
  def add_value(value, type)
    return nil if include_value?(value, type) == true
    @dtb.query("INSERT INTO #{type.to_s.capitalize}(Name) VALUES (\"#{value}\")")
  end

  # Ajoute une relation
  def add_relation_value(id_movie, value, type)
    case type
      when :country
      table = "Made_in"
      when :actor
      table = "Starred_in"
      when :director
      table = "Directed_by"
      when :theme
      table = "Is_a"
    end

    id_value = get_id_value(value, type)
    @dtb.query("INSERT INTO #{table} VALUES (#{id_movie}, #{id_value})")
  end

  # Retourne l'Id d'un élement dans une des colonnes de table
  def get_id_value(value, type)
    value = Mysql.escape_string(value)
    res = @dtb.query("SELECT Id FROM #{type.to_s.capitalize} WHERE Name = \"#{value}\"")
    return nil if res.num_rows.zero?
    return res.fetch_row[0]
  end

  # Télécharge l'image d'un film
  def download_movie_image(id_movie, url)
    open(url) do |f|
      File.open("#{$dir_movie_images}/#{id_movie}.jpg", "wb") do |file|
        file.puts f.read
      end
    end
  end
end
