<?php 

namespace Controllers;

use Model\Proyecto;
use Model\Usuario;
use MVC\Router;

class DashboardController{
  public static function index(Router $router){
    session_start();
    isAuth();

    $proyectos = Proyecto::belongsTo('propietarioId', $_SESSION['id']);

    $router->render('dashboard/index', [
      'titulo' => 'Proyectos',
      'proyectos' => $proyectos
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
    $alertas = [];

    $usuario = Usuario::find($_SESSION['id']);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $usuario->sincronizar($_POST);
      $alertas = $usuario->validar_perfil();

      if (empty($alertas)) {
        $existeUsuario = Usuario::where('email', $usuario->email);

        if ($existeUsuario && $existeUsuario->id !== $usuario->id) {
          Usuario::setAlerta('error', 'Correo ya registrado');
          $alertas = $usuario->getAlertas();
        } else{
          //guardar el usuario
          $usuario->guardar();
  
          Usuario::setAlerta('exito', 'Guardado Correctamente');
          $alertas = $usuario->getAlertas();
  
          //Asignar el nombre nuevo a la barra
          $_SESSION['nombre'] = $usuario->nombre;
        }
      }
    }

    $router->render('dashboard/perfil', [
      'titulo' => 'Editar Perfil',
      'usuario' => $usuario,
      'alertas' => $alertas
    ]);
  }

  public static function cambiar_password(Router $router){
    session_start();
    isAuth();

    $alertas = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $usuario = Usuario::find($_SESSION['id']);
      
      //Sincronizar con los datos del usuario
      $usuario->sincronizar($_POST);

      $alertas = $usuario->nuevo_password();

      if (empty($alertas)) {
        $resultado = $usuario->comprobar_password();
        
        if($resultado){
          $usuario->password = $usuario->password_nuevo;

          //Eliminar propiedades no necesarias
          unset($usuario->password_actual);
          unset($usuario->password_nuevo);

          //Hashear el nuevo password
          $usuario->hashPassword();

          //actualizar
          $resultado = $usuario->guardar();

          if ($resultado) {
            Usuario::setAlerta('exito', 'Password Guardado Correctamente');
            $alertas = Usuario::getAlertas();
          }
        }else{
          Usuario::setAlerta('error', 'Password Incorrecto');
          $alertas = Usuario::getAlertas();
        }
      }
    }
    
    $router->render('dashboard/cambiar-password', [
      'titulo' => 'Cambiar Password',
      'alertas' => $alertas
    ]);
  }

  public static function eliminar_proyeto(){
    session_start();

    $alertas = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $proyecto = Proyecto::where('url', $_POST['idProyecto']);

      if (!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
        $respuesta = [
          'tipo' => 'error',
          'mensaje' => 'Hubo un error al eliminar el proyecto'
        ];
        echo json_encode($respuesta);
        return;
      }

      $resultado = $proyecto->eliminar();
      if ($resultado) {
        $respuesta = [
          'tipo' => 'exito',
          'mensaje' => 'El proyecto se eliminó correctamente'
        ];
        echo json_encode($respuesta);
        return;
      }
    }
  }
}
