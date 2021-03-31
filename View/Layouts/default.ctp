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
        <?php echo $this->Html->charset(); ?>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>
            <?php __('ESS/UFRJ'); ?>
            <?php echo $title_for_layout; ?>
        </title>
        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css('bootstrap.min');
        echo $this->Html->script(['jquery-3.6.0', 'popper.min', 'bootstrap.min', 'bootstrap.bundle.min']);
        // echo $this->Html->css('cake.generic');
        // echo $this->Html->css('abas');
        // echo $this->Html->script('jquery-1.9.1.min'); // Include jQuery library
        echo $this->Js->writeBuffer();
        echo $scripts_for_layout;
        ?>
        <!--
        <style>
            a {color: #000; font-weight: 500; text-decoration: underline}
            a:hover {color: #003d4c; font-weight: 500; text-decoration: underline}
        </style>
        //-->
    </head>
    <!--
        <body style="color:#003d4c; background: #2b6c9c">
    //-->
    <body style="font-size: 95%;">
        <div class='container'>
            <div class='row justify-content-center'>
                <!--
                <div class='col-auto'>
                //-->
                <?= $this->element('submenu_navegacao'); ?>
            </div>
        </div>
        <!--
        </div>
        //-->
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

        <div id="footer">
            <?php
            echo $this->Html->link(
                    $this->Html->image('cake.power.gif', array('alt' => __("CakePHP: the rapid development php framework", true), 'border' => "0")), 'http://www.cakephp.org/', array('target' => '_blank', 'escape' => false)
            );
            ?>
        </div>

        <?php // echo $this->element('sql_dump'); ?>

    </body>
</html>
