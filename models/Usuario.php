<?php 

namespace Model;

class Usuario extends ActiveRecord{
  protected static $tabla = 'usuarios';
  protected static $columnasDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];

  public function __construct($args = []){
    $this->id = $args['id'] ?? null;
    $this->nombre = $args['nombre'] ?? '';
    $this->email = $args['email'] ?? '';
    $this->password = $args['password'] ?? '';
    $this->password2 = $args['password2'] ?? null;
    $this->token = $args['token'] ?? '';
    $this->confirmado = $args['confirmado'] ?? 0;
  }

  //validación para cuentas nuevas
  public function validarNuevaCuenta(){
    if (!$this->nombre) {
      self::$alertas['error'][] = 'El nombre del Usuario es obligatorio';
    }
    if (!$this->email) {
      self::$alertas['error'][] = 'El email del Usuario es obligatorio';
    }
    if (!$this->password) {
      self::$alertas['error'][] = 'El password no puede ir vacío';
    }
    if (strlen($this->password) < 6) {
      self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
    }
    if ($this->password !== $this->password2) {
      self::$alertas['error'][] = 'Los passwords son diferentes';
    }

    return self::$alertas;
  }

  //Valida un email
  public function validarEmail(){
    if (!$this->email) {
      self::$alertas['error'][] = 'El email es obligatorio';
    }
    if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
      self::$alertas['error'][] = 'El email no válido';
    }
    return self::$alertas;
  }

  //Valida el Password
  public function validarPassword(){
    if (!$this->password) {
      self::$alertas['error'][] = 'El password no puede ir vacío';
    }
    if (strlen($this->password) < 6) {
      self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
    }
    return self::$alertas;
  }

  //hashea el password
  public function hashPassword(){
    $this->password = password_hash($this->password, PASSWORD_BCRYPT);
  }

  //generar un token
  public function crearToken(){
    $this->token = md5(uniqid());
  }
}