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
}
?>