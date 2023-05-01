<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    public $components = [
        'Session',
        'Acl',
        'Auth' => [
            // O certo eh redirecionar para o perfil do usuario
            'loginRedirect' => [
                'controller' => 'murals',
                'url' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'murals',
                'url' => 'index'
            ],
        ],
        'DebugKit.Toolbar'
    ];

    public function beforeFilter()
    {

        $this->Auth->allow('index');

        setlocale(LC_TIME, NULL);
        setlocale(LC_TIME, "pt_BR", "pt_BR.utf-8", "pt_BR.utf-8", "portuguese");
        date_default_timezone_set('America/Sao_Paulo');

        /* Usuário */
        $this->set('id_categoria', $this->Session->read('id_categoria'));
        $this->set('categoria', $this->Session->read('categoria'));

        /* Meses */
        $meses = ['01' => 'Janeiro', '02' => 'Fevereiro', '03' => 'Março', '04' => 'Abril', '05' => 'Maio', '06' => 'Junho', '07' => 'Julho', '08' => 'Agosto', '09' => 'Setembro', '10' => 'Outubro', '11' => 'Novembro', '12' => 'Dezembro'];
        $this->set('meses', $meses);

        $this->set('dia', strftime('%e', time()));
        // $this->set('mes', utf8_encode(strftime('%B', time())));
        $this->set('mes', strftime('%B', time()));
        $this->set('ano', strftime('%Y', time()));
    }

}