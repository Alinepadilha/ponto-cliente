<?php
/**
 * Cadastro
 *
 * Cadastra ou atualiza os dados de um usuário
 *
 * PHP version 5
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author     Thiago Paes - mrprompt@gmail.com
 * @package    Ponto
 * @subpackage Cadastro
 * @filesource cadastro.php
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
    // validando
    if ($_POST['senha'] !== $_POST['senha_confirmacao']) {
        throw new \UsuariosException('Senhas não conferem.');
    }

    $objUsuarios = new \Usuarios();

    $objUsuarios->setLogin($_POST['usuario'])
                ->setPassword($_POST['senha'])
                ->setOwner($_POST['owner'])
                ->setNome($_POST['nome'])
                ->setHorasAlmoco($_POST['horas_almoco'])
                ->setHorasDia($_POST['horas_dia'])
                ->setEmail($_POST['email'])
                ->setId($_POST['id'])
                ->setDiasTrabalho(implode(',', $_POST['dias_trabalho']))
                ->save();

    $retorno = array(
        'id'            => $objUsuarios->getId(),
        'login'         => $objUsuarios->getLogin(),
        'nome'          => $objUsuarios->getNome(),
        'owner'         => $objUsuarios->getOwner(),
        'horas_almoco'  => $objUsuarios->getHorasAlmoco(),
        'horas_dia'     => $objUsuarios->getHorasDia(),
        'email'         => $objUsuarios->getEmail(),
        'dias_trabalho' => $objUsuarios->getDiasTrabalho()
    );
} catch (Exception $e) {
    $retorno = $e->getMessage();
}

header('Content-type:application/json');
echo json_encode($retorno);

