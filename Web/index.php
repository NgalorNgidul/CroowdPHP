<?php
include './function/function.php';

if (isset($_GET['action']) == 'logout') {
    logout();
} else {
    
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Selamat Datang di Croowd.co.id</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale = 1.0, maximum-scale=1.0, user-scalable=no" />
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,300' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/normalize.css"/>
        <link rel="stylesheet" href="css/table-alone.css"/>
        <link rel="stylesheet" href="css/jquery.sidr.light.css"/>
        <link rel="stylesheet" href="css/animate.min.css"/>
        <link rel="stylesheet" href="css/md-slider.css"/>
        <link rel="stylesheet" href="css/style.css"/>
        <?php if ($_GET['content'] == 'start-project') { ?>
            <link href="css/css/wizard.css" rel="stylesheet" />
        <?php } ?>
                    <script type="text/javascript" src="js/raphael-min.js"></script>


        <!--[if lte IE 7]>
        <link rel="stylesheet" href="css/ie7.css"/>
        <![endif]-->
        <!--[if lte IE 8]>
        <link rel="stylesheet" href="css/ie8.css"/>
        <![endif]-->
        <link rel="stylesheet" href="css/responsive.css"/>
        <!--[if lt IE 9]>
        <script type="text/javascript" src="js/html5.js"></script>
        
        <![endif]-->
            <script type="text/javascript" src="js/jquery.min.js"></script>


    </head>
    <body>
        <div id="wrapper">
            <header id="header">
                <!--     <div class="wrap-top-menu">
                         <div class="container_12 clearfix">
                             <div class="grid_12">
                                 <nav class="top-menu">
                <?php // include "function/menu-header.php"; ?>
     
     
                                 </nav>
                                 <div class="top-message clearfix">
                                     <i class="icon iFolder"></i>
                                     <span class="txt-message">Syahrial Fandrianah</span>
     
                                     <div class="clear"></div>
                                 </div>
                                 <i id="sys_btn_toggle_search" class="icon iBtnRed make-right"></i>
                             </div>
                         </div>
                     </div> --><!-- end: .wrap-top-menu -->
                <div class="container_12 clearfix">
                    <div class="grid_12 header-content">
                        <div id="sys_header_right" class="header-right">
                            <div class="account-panel">
                                <?php if ($_COOKIE['simbiosis'] == null) { ?>
                                    <a href="#" class="btn btn-red sys_show_popup_login">Register</a>
                                    <a href="#" class="btn btn-black sys_show_popup_login">Login</a>
                                <?php } else { ?>
                                    <a href="index.php?action=logout" class="btn btn-red">Log out</a>

                                <?php } ?>
                            </div>
                            <div class="form-search">
                                <!--<form onsubmit="return searchProyek();">-->
                                    <label for="sys_txt_keyword">
                                        <input id="sys_txt_keyword" onchange="searchProyek();" class="txt-keyword" type="text" value="<?=$_GET['parameter'];?>" placeholder="Cari proyek"/>
                                    </label>
                                    <button class="btn-search" onclick="searchProyek();"><i class="icon iMagnifier"></i></button>
                                    <button class="btn-reset-keyword" type="reset"><i class="icon iXHover"></i></button>

                                <!--</form>-->
                            </div>
                        </div>
                        <div class="header-left">
                            <h1 id="logo">
                                <a href="."><img src="images/logo.png" alt="$SITE_NAME"/></a>
                            </h1>
                            <!--<div class="main-nav clearfix">
                                <div class="nav-item">
                                    <a href="category.html" class="nav-title">Proyek</a>
                                    <p class="rs nav-description">Lis proyek</p>
                                </div>
                                <span class="sep"></span>
                                <div class="nav-item">
                                    <a href="index.php?content=start-project" id="start-project" class="nav-title">Mulai</a>
                                    <p class="rs nav-description">Proyek baru anda</p>
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>
            </header><!--end: #header -->
            <span id="setBodys">
                <?php
                if ($_GET['content'] != null) {
                    include"index2.php";
                } else {
                    include"index1.php";
                }
                ?>
            </span>
            <footer id="footer">
                <?php include "function/footer.php"; ?>
            </footer><!--end: #footer -->

        </div>

        <div class="popup-common" id="sys_popup_common">
            <div class="overlay-bl-bg"></div>
            <div class="container_12 pop-content">
                <div class="grid_12 wrap-btn-close ta-r">
                    <i class="icon iBigX closePopup"></i>
                </div>
                <div class="grid_6 prefix_1">
                    <div class="form login-form">
                        <form action="#">
                            <h3 class="rs title-form">Register</h3>
                            <div class="box-white">
                                <h4 class="rs title-box">New to Kickstars?</h4>
                                <p class="rs">A Kickstars account is required to continue.</p>
                                <div class="form-action">
                                    <label for="txt_name">
                                        <input id="txt_name" class="txt fill-width" type="text" placeholder="Enter full name"/>
                                    </label>
                                    <div class="wrap-2col clearfix">
                                        <div class="col">
                                            <label for="txt_email">
                                                <input id="txt_email" class="txt fill-width" type="email" placeholder="Enter your e-mail address"/>
                                            </label>
                                            <label for="txt_re_email">
                                                <input id="txt_re_email" class="txt fill-width" type="email" placeholder="Re-enter your e-mail adress"/>
                                            </label>
                                        </div>
                                        <div class="col">
                                            <label for="txt_password">
                                                <input id="txt_password" class="txt fill-width" type="password" placeholder="Enter password"/>
                                            </label>
                                            <label for="txt_re_password">
                                                <input id="txt_re_password" class="txt fill-width" type="password" placeholder="Re-enter password"/>
                                            </label>
                                        </div>
                                    </div>
                                    <p class="rs pb10">By signing up, you agree to our <a href="#" class="fc-orange">terms of use</a> and <a href="#" class="fc-orange">privacy policy</a>.</p>
                                    <p class="rs ta-c">
                                        <button class="btn btn-red btn-submit" type="submit">Register</button>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="grid_4">
                    <div class="form login-form">
                        <form action="#">
                            <h3 class="rs title-form">Login</h3>
                            <div class="box-white">
                                <h4 class="rs title-box">Already Have an Account?</h4>
                                <p class="rs">Please log in to continue.</p>
                                <div class="form-action">
                                    <label for="txt_email_login">
                                        <input id="txt_email_login" class="txt fill-width" type="email" placeholder="Enter your e-mail address"/>
                                    </label>
                                    <label for="txt_password_login">
                                        <input id="txt_password_login" class="txt fill-width" type="password" placeholder="Enter password"/>
                                    </label>

                                    <label for="chk_remember" class="rs pb20 clearfix">
                                        <input id="chk_remember" type="checkbox" class="chk-remember"/>
                                        <span class="lbl-remember">Remember me</span>
                                    </label>
                                    <p class="rs ta-c pb10">
                                        <button class="btn btn-red btn-submit" type="submit">Login</button>
                                    </p>
                                    <p class="rs ta-c">
                                        <a href="#" class="fc-orange">I forgot my password</a>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
                       
        <script type="text/javascript" src="js/autoNumeric-1.9.34.js"></script>

            
        <!--<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>-->
        
        <script type="text/javascript" src="js/jquery-migrate-1.2.1.min.js"></script>
        <script type="text/javascript" src="js/jquery.touchwipe.min.js"></script>
        <script type="text/javascript" src="js/md_slider.js"></script>
        <script type="text/javascript" src="js/jquery.sidr.min.js"></script>
        <script type="text/javascript" src="js/jquery.tweet.min.js"></script>
        <script type="text/javascript" src="js/pie.js"></script>
        <?php if ($_GET['content'] == 'start-project') { ?>
            <script type="text/javascript" src="component/start-project/start-project.js"></script>

            <script type="text/javascript" src="js/js/bootstrap.min.js"></script>
            <script type="text/javascript" src="js/jquery.bootstrap.wizard.js"></script>
        <?php } ?>   
        <script type="text/javascript" src="js/js.js"></script>
        <script type="text/javascript" src="js/script.js"></script>
        <script>
           
//            (function (i, s, o, g, r, a, m) {
//                i['GoogleAnalyticsObject'] = r;
//                i[r] = i[r] || function () {
//                    (i[r].q = i[r].q || []).push(arguments)
//                }, i[r].l = 1 * new Date();
//                a = s.createElement(o),
//                        m = s.getElementsByTagName(o)[0];
//                a.async = 1;
//                a.src = g;
//                m.parentNode.insertBefore(a, m)
//            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
//
//            ga('create', 'UA-20585382-5', 'megadrupal.com');
//            ga('send', 'pageview');

        </script>
    </body>
</html>
