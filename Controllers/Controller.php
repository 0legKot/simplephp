
  <?php
class Controller
{
    function getView($viewName,$data){
        return include_once($_SERVER['DOCUMENT_ROOT'].'/Views/'.$viewName.'View.html');
      }
}
?>