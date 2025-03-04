<?php


if (!is_user_logged_in()) {
    header("location:" . site_url() . "/login");
    die();
}


/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package cybersecurityalliance
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"> -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&display=swap" rel="stylesheet">

    <?php wp_head(); ?>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <style>
        #center_items {
            flex: 1;
        }

        #center_items ul {
            display: flex;
            list-style: none;
            flex: 1;
            justify-content: center;
        }

        #center_items ul li {
            margin-right: 30px;
            white-space: nowrap;
        }

        @media (min-width: 992px) {
            .sfm-navicon-button {
                display: none !important;
            }
        }

        @media (max-width: 992px) {
            #center_items {
                display: none !important;
            }

            .profile_dropdown {
                margin-left: auto;
            }
        }

        body {
            background-color: rgba(242, 242, 242, 1);
        }

        .card {
            background: #FFFFFF;
            border: none;
            border-radius: 0px;
        }
    </style>
</head>

<body <?php body_class(); ?>>

<div class="bar bg-blue" style="display: flex;background-color: #010921e6!important;">
        <?php
        if (is_front_page()) {
            ?>
             <a href="
        <?= site_url() ?>
        ">
            <div class="pull-left">
                <img src="<?php echo get_template_directory_uri() ?>/assets/images/logo-cybersecurity-alliance.png" style="height:40px">
                <span style="color:white;font-size:16px;margin-left:5px">CYBERSECURITY ALLIANCE</span>
            </div>
        </a>
            <?php 
        }
        else {
            ?>
            <a href="
        <?= site_url() ?>
        ">
            <div class="pull-left">
                <img src="<?php echo get_template_directory_uri() ?>/assets/images/logo-cybersecurity-alliance.png" style="height:40px">
                <span style="color:white;font-size:16px;margin-left:5px">CYBERSECURITY ALLIANCE</span>
            </div>
        </a>
            <?php
        }
        ?>
        <div id="center_items">
            <?php
            $defaults = array(
                'theme_location'  => '',
                'menu'            => $current_page_sf_menu,
                'container'       => '',
                'container_class' => '',
                'container_id'    => '',
                'menu_class'      => 'menu',
                'menu_id'         => 'sfm-nav',
                'echo'            => true,
                'fallback_cb'     => 'wp_page_menu',
                'before'          => '',
                'after'           => '',
                'link_before'     => '',
                'link_after'      => '',
                'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                'depth'           => 0,
                'walker'          => ''
            );
            wp_nav_menu($defaults);
            ?>
        </div>

        <div class="pull-right profile_dropdown" style="white-space: nowrap">
            <!-- <div class="dropdown">
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false"
                    style="background:transparent !important;color:white !important;border:none">
                    <?php
                    $current_user = wp_get_current_user();
                    echo $current_user->user_firstname . " " . $current_user->user_lastname
                    ?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu bg-blue" style="background-color: #00000080!important;"
                    aria-labelledby="dropdownMenu2">
                    <li style="background:transparent !important">
                        <?php
                        if (is_administrator() || is_territoriale() || is_polizia_postale()) {
                        ?>
                        <a href="<?= site_url() ?>/wp-admin" style="background:transparent !important">
                            Backoffice
                        </a>
                        <?php
                        }
                        ?>
                        <a href="<?= site_url() ?>/profilo" style="background:transparent !important">
                            Profilo personale
                        </a>
                        <?php
                        if (is_administrator() || is_territoriale() || is_polizia_postale()) {
                        ?>
                        <a href="<?= site_url() ?>/segnalazioni_polizia"
                            style="background:transparent !important">Segnalazioni PP</a>
                        <?php
                        }
                        ?>
                        <a href="<?= site_url() ?>/wp-login.php?action=logout"
                            style="border-top: 1px solid #FFFFFF;padding-top: 5px;background:transparent !important">
                            Esci
                        </a>
                    </li>
                </ul>
            </div> -->
            <div class="dropdown">
                <a class="btn dropdown-toggle border-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="me-2" src="<?php echo get_template_directory_uri() ?>/assets/images/Setting.png" alt="">
                    <!-- <?php
                            $current_user = wp_get_current_user();
                            echo $current_user->user_firstname . " " . $current_user->user_lastname
                            ?> -->
                </a>

                <ul class="dropdown-menu bg-blue align-items-center" style="background-color: #00000080!important;">
                    <?php
                    if (is_administrator() || is_territoriale() || is_polizia_postale()) {
                    ?>
                        <li>
                            <a class="dropdown-item" href="<?= site_url() ?>/wp-admin">
                                <img class="me-2" src="<?php echo get_template_directory_uri() ?>/assets/images/BB.png" alt=""> Backoffice
                            </a>
                        </li>
                    <?php
                    }
                    ?>
                    <li><a class="dropdown-item" href="<?= site_url() ?>/profilo"> <img class="me-2" src="<?php echo get_template_directory_uri() ?>/assets/images/vector.png" alt=""> Profilo personale</a></li>
                    <?php
                    if (is_administrator() || is_territoriale() || is_polizia_postale()) {
                    ?>
                        <li><a class="dropdown-item" href="<?= site_url() ?>/segnalazioni_polizia"> <img class="me-2" src="<?php echo get_template_directory_uri() ?>/assets/images/1.png" alt=""> Segnalazioni PP</a></li>
                    <?php
                    }
                    ?>
                    <hr class="m-0 text-white">
                    <li><a class="dropdown-item" href="<?= site_url() ?>/wp-login.php?action=logout"> <img class="me-2" src="<?php echo get_template_directory_uri() ?>/assets/images/2.png" alt=""> Esci</a></li>

                </ul>
            </div>
        </div>
    </div>