<?php 

namespace Controllers;

use Model\Proyecto;
use MVC\Router;

class DashboardController{
  public static function index(Router $router){
    session_start();
    isAuth();

    $router->render('dashboard/index', [
      'titulo' => 'Proyectos'
    ]);
  }

  public static function crear_proyeto(Router $router){
    $alertas = [];
    session_start();
    isAuth();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $proyecto = new Proyecto($_POST );
      
      //Validación
      $alertas = $proyecto->validarProyecto();
      
      if (empty($alertas)) {
        //Generar una url única
        $hash = md5(uniqid());
        $proyecto->url = $hash;

        //Almacenar el creador del proyecto
        $proyecto->propietarioId = $_SESSION['id'];

        //Guardar el proyecto
        $proyecto->guardar();

        //Redireccionar
        header('Location: /proyecto?id='.$proyecto->url);
      }
    }
    
    $router->render('dashboard/crear-proyecto', [
      'titulo' => 'Crear Proyecto',
      'alertas' => $alertas
    ]);
  }

  public static function proyecto(Router $router){
    $alertas = [];
    session_start();
    isAuth();

    $url = $_GET['id'];
    if(!$url) header('Location: /dashboard');

    //Revisar que la persona que visita el proyecto, es quien lo creó
    $proyecto = Proyecto::where('url', $url);

    if($proyecto->propietarioId !== $_SESSION['id']){
      header('Location: /dashboard');
    }
    
    $router->render('dashboard/proyecto', [
      'titulo' => $proyecto->proyecto
    ]);
  }

  public static function perfil(Router $router){
    session_start();
    isAuth();

    $router->render('dashboard/perfil', [
      'titulo' => 'Editar Perfil'
    ]);
  }
}
