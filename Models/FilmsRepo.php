<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/Models/Film.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/Models/Actor.php');
class FilmsRepo
{
    function __construct(){
        $this->db = getConnection();
    }
    function __destruct(){
        $this->db->close();
    }
    function array_group_by(array $arr, callable $key_selector) {
        $result = array();
        foreach ($arr as $i) {
          $key = call_user_func($key_selector, $i);
          $result[$key][] = $i;
        }  
        return $result;
      }
    public function GetAll(){
        $result = $this->db->query ('SELECT f.id_film, f.name, f.year, f.format, a.firstname, a.lastname FROM films AS f 
        INNER JOIN link AS fa 
        ON f.id_film = fa.film_id
        INNER JOIN actors AS a 
        ON a.id_actor = fa.actor_id
        ORDER by f.name ASC');
        return $this->processQuery($result);
    }
    public function GetFilteredByFilmName($keyword){
        $result = $this->db->query ('SELECT f.id_film, f.name, f.year, f.format, a.firstname, a.lastname FROM films AS f 
        INNER JOIN link AS fa 
        ON f.id_film = fa.film_id
        INNER JOIN actors AS a 
        ON a.id_actor = fa.actor_id
        WHERE f.name=\''.$keyword.'\'
        ORDER by f.name ASC' );
        return $this->processQuery($result);
    }
    public function GetFilteredByActorName($keyword){
        $result = $this->db->query ('SELECT f.id_film, f.name, f.year, f.format, a.firstname, a.lastname  FROM (SELECT f.id_film,f.name, f.year,f.format 
        FROM films AS f 
        INNER JOIN link AS fa 
        ON f.id_film = fa.film_id
        INNER JOIN actors AS a 
        ON a.id_actor = fa.actor_id
        WHERE a.firstname=\''.$keyword.'\' OR a.lastname=\''.$keyword.'\') AS f
        INNER JOIN link AS fa 
        ON f.id_film = fa.film_id
        INNER JOIN actors AS a 
        ON a.id_actor = fa.actor_id
        ORDER by f.name ASC' );
        return $this->processQuery($result);
    }
    function processQuery($result){
        while($row = $result->fetch_array())
        {
            $rows[] = $row;
        }
        $responseList = array();
        $groupped=$this->array_group_by($rows,function($i) {return $i[0];});
        foreach ($groupped as $group) {
            $film = new Film();
            $film->FilmId = $group[0]['id_film'];
            $film->Name = $group[0]['name'];
            $film->Year = $group[0]['year'];
            $film->Format = $group[0]['format'];
            foreach ($group as $actor)
            $film->Actors .=$actor['firstname'].' '.$actor['lastname'].', ';
            array_push($responseList, $film);
        }
        return $responseList;
    }
    public function Add($film){
        $sql = "INSERT INTO films (name,year,format)
        VALUES (".$film->Name.", ".$film->Year.", ".$film->Format.")";
        $db->query($sql);
        if ($film->Actors){
            foreach ($film->Actors as $actor)
            $str .="(".$actor->FirstName.",".$actor->LastName."),";
            $str=substr($str,-1); //remove last ','
            //error in case we already have him
            $sql = "INSERT INTO actors (firstname,lastname)
            VALUES ".$str;
            $db->query($sql);
        }
    }
    public function Delete($id){
        $sql = "DELETE FROM films WHERE id=".$id;
        $db->query($sql);
    }
}