<?php
class HomeController extends Controller
{
    public function IndexAction()
    {
      include_once($_SERVER['DOCUMENT_ROOT'].'/Models/FilmsRepo.php');
      $repo=new FilmsRepo;
      $films=$repo->GetAll();
      return $this->getView('Index',$films);
    }
    public function SearchByFilmNameAction()
    {
      include_once($_SERVER['DOCUMENT_ROOT'].'/Models/FilmsRepo.php');
      $repo=new FilmsRepo;
      $films=$repo->GetFilteredByFilmName($_POST["keyword"]);
      return $this->getView('Index',$films);
    }
    public function SearchByActorNameAction()
    {
      include_once($_SERVER['DOCUMENT_ROOT'].'/Models/FilmsRepo.php');
      $repo=new FilmsRepo;
      $films=$repo->GetFilteredByActorName($_POST["keyword"]);
      return $this->getView('Index',$films);
    }
}
?>