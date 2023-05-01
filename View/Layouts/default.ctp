<?php
/* SVN FILE: $Id$ */
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.console.libs.templates.skel.views.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <?= $this->Html->charset(); ?>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>
            <?php __('ESS/UFRJ'); ?>
            <?php echo $title_for_layout; ?>
        </title>
        <?php
        echo $this->Html->meta('icon');
        ?>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <?php
        // echo $this->Html->css('bootstrap.min');
        // echo $this->Html->script(['jquery-3.6.0', 'popper.min', 'bootstrap.min', 'bootstrap.bundle.min']);
        // echo $this->Html->css('cake.generic');
        // echo $this->Html->css('abas');
        // echo $this->Html->script('jquery-1.9.1.min'); // Include jQuery library

        echo $this->Js->writeBuffer();
        echo $scripts_for_layout;
        ?>
        <style>
            a {
                color: #000;
                font-weight: 500;
                /* text-decoration: underline; */
            }
            a:hover {
                color: #003d4c;
                font-weight: 500; /* text-decoration: underline blue */
            }
        </style>

    </head>
    <!--
        <body style="color:#003d4c; background: #2b6c9c">
    //-->
    <body style="font-size: 95%;">
        <!<!-- Menu superior -->
        <div class='container'>
            <div class='row justify-content-center'>
                <!--
                <div class='col-auto'>
                //-->
                <?php
                $id_categoria = $this->Session->read('id_categoria');
                if (isset($id_categoria)) {
                    switch ($id_categoria) {
                        case 1: // Administrador
                            echo $this->element('submenu_navegacao');
                            break;
                        case 2: // Estudante
                            // pr($this->Session->read('estagiario'));
                            // die();
                            if ($this->Session->read('estagiario') === '1'):
                                echo $this->element('submenu_nav_estudante');
                            elseif ($this->Session->read('estagiario') === '0'):
                                echo $this->element('submenu_nav_aluno');
                            endif;
                            break;
                        case 3: // Docente
                            echo $this->element('submenu_nav_docente');
                            break;
                        case 4: // Supervisora
                            echo $this->element('submenu_navegacao');
                            break;
                        default:
                            echo $this->element('submenu_navegacao');
                            break;
                    }
                } else {
                    echo $this->element('submenu_navegacao');
                }
                ?>

            </div>
        </div>
        <!-- Corpo com o conteúdo -->
        <div class='container'>
            <div class='row justify-content-left'>
                <div class='col-12'>
                    <div id="content">

                        <?php echo $this->Session->flash(); ?>

                        <?php echo $content_for_layout; ?>
                    </div>
                </div>
            </div>
        </div>
        <!<!-- Pé de pagina -->
        <div id="footer" class="text-center text-white">
            <?php
            echo $this->Html->link(
                    $this->Html->image('cake.power.gif', array('alt' => __("Coordenação de Estágio da ESS/UFRJ: ", true), 'border' => "0")), 'http://ess.ufrj.br/', array('target' => '_blank', 'escape' => false)
            );
            ?>
        </div>

        <?php echo $this->element('sql_dump'); ?>

    </body>
</html>
