<?php
/**
 * Login
 *
 * Efetua o login de usuário
 *
 * PHP version 5
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author     Thiago Paes - mrprompt@gmail.com
 * @package    Ponto
 * @subpackage Login
 * @filesource login.php
 * @copyright  Copyright 2011, Thiago Paes
 * @link       http://github.com/mrprompt/Ponto/
 * @version    $Revision: 0.1 $
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * @see Usuarios
 */
require_once __DIR__ . '/../../php/Usuarios.php';

$retorno = null;

// se não for um ajax já paro
if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])
        || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    die();
}

try {
    $objUsuarios = new \Usuarios();

    $retorno = $objUsuarios->setLogin($_POST['usuario'])
                           ->setPassword($_POST['senha'])
                           ->login();
} catch (Exception $e) {
    $retorno = $e->getMessage();
}

header('Content-type:application/json');
echo json_encode($retorno);