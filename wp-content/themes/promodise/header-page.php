<!DOCTYPE html>
<html <?php language_attributes();?>
<head>
    <!-- Required meta tags -->
    <meta charset="<?php bloginfo( 'charset' );?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="seo & digital marketing" />
    <meta
        name="keywords"
        content="marketing,digital marketing,creative, agency, startup,promodise,onepage, clean, modern,seo,business, company"
    />


    <?php
    wp_head();
    ?>


</head>

<body data-spy="scroll" data-target=".fixed-top">
<nav class="navbar navbar-expand-lg fixed-top trans-navigation">
    <div class="container">
        <?php
        if(has_custom_logo()){
            echo get_custom_logo();
        }else {
            $site_name = get_bloginfo('name');
            if (is_front_page()){
                echo '<span class="nav-link">'. $site_name .'</span>';
            }else{
                echo '<a class="nav-link" href="' . home_url() . '">'. $site_name .'</a>';
            }
        }
        ?>
        <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#mainNav"
            aria-controls="mainNav"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon">
            <i class="fa fa-bars"></i>
          </span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="mainNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/"> Главная </a>
                </li>
                <li class="nav-item dropdown">
                    <a
                        class="nav-link dropdown-toggle"
                        href="#"
                        id="navbarWelcome"
                        role="button"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >О нас</a
                    >
                    <div class="dropdown-menu" aria-labelledby="navbarWelcome">
                        <a class="dropdown-item" href="about.html"> О компании </a>
                        <a class="dropdown-item" href="about.html"> Об услугах </a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link smoth-scroll" href="service.html">Услуги</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link smoth-scroll" href="pricing.html">Цены</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link smoth-scroll" href="blog.html">Журнал</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link smoth-scroll" href="contact.html">Контакты</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!--MAIN HEADER AREA END -->
<!--MAIN BANNER AREA START -->
<div class="page-banner-area page-contact" id="page-banner">
    <div class="overlay dark-overlay"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 m-auto text-center col-sm-12 col-md-12">
                <div class="banner-content content-padding">
                    <h1 class="text-white">Давайте обсудим работу над&nbsp;вашим проектом</h1>
                    <p>Напишите нам и вам ответит проектный менеджер</p>
                </div>
            </div>
        </div>
    </div>
</div>