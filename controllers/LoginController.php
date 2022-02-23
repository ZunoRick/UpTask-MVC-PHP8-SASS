<?php 

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController{
  public static function login(Router $router){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

    }

    //Render a la vista
    $router->render('auth/login', [
      'titulo' => 'Iniciar Sesión'
    ]);
  }

  public static function logout(){
    echo "Desde Logout";
  }

  public static function crear(Router $router){
    $alertas = [];
    $usuario = new Usuario;

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $usuario->sincronizar($_POST);
      $alertas = $usuario->validarNuevaCuenta();

      if (empty($alertas)) {
        $existeUsuario = Usuario::where('email', $usuario->email);

        if ($existeUsuario) {
          Usuario::setAlerta('error', 'La cuenta ya ha sido registrada');
          $alertas = Usuario::getAlertas();
        }else{
          //Hashear el password
          $usuario->hashPassword();

          //eliminar password2
          unset($usuario->password2);

          //generar un token
          $usuario->crearToken();
          
          //Crear nuevo usuario
          $resultado = $usuario->guardar();

          //Enviar el email
          $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
          $email->enviarConfirmacion();
          if ($resultado) {
            header('Location: /mensaje');
          }
        }
      }

    }

    //Render a la vista
    $router->render('auth/crear', [
      'titulo' => 'Crear tu Cuenta',
      'usuario' => $usuario,
      'alertas' => $alertas
    ]);
  }

  public static function olvide(Router $router){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

    }

    //Render a la vista
    $router->render('auth/olvide', [
      'titulo' => 'Olvidé mi Password'
    ]);
  }

  public static function reestablecer(Router $router){
    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

    }
    $router ->render('auth/reestablecer', [
      'titulo' => 'Reestablecer Password'
    ]);
  }

  public static function mensaje(Router $router){
    $router ->render('auth/mensaje', [
      'titulo' => 'Cuenta creada exitosamente'
    ]);
  }

  public static function confirmar(Router $router){
    $token = s($_GET['token']);

    if (!$token) header('Location: /');

    //Encontrar al usuario con el token
    $usuario = Usuario::where('token', $token);
    if (empty($usuario)) {
      //No se encontró un usuario con ese token
      Usuario::setAlerta('error', 'Token no válido');
    }else{
      //Confirmar la cuenta
      $usuario->confirmado = 1;
      $usuario->token = null;
      unset($usuario->password2);
      
      //Guardar en la BD
      $usuario->guardar();
      Usuario::setAlerta('exito', 'Cuenta comprobada correctamente');
    }
    
    $alertas = Usuario::getAlertas();

    $router ->render('auth/confirmar', [
      'titulo' => 'Confirma tu cuenta UpTask',
      'alertas' => $alertas
    ]);
  }
}