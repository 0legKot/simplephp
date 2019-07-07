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
    public function GetAll(){
        $result = $this->db->query ('SELECT * FROM films ORDER BY name ASC');
        $responseList = array();
        foreach ($result as $row) {
            $film = new Film();
            $film->FilmId = $row['id_film'];
            $film->Name = $row['name'];
            $film->Year = $row['year'];
            $film->Format = $row['format'];
            array_push($responseList, $film);
        }
        return $responseList;
    }
}