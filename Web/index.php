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
	<link rel="shortcut icon" href="favicon.png" type="image/png">
        <link rel="stylesheet" href="css/normalize.css"/>
        <link rel="stylesheet" href="css/table-alone.css"/>
        <link rel="stylesheet" href="css/jquery.sidr.light.css"/>
        <link rel="stylesheet" href="css/animate.min.css"/>
        <link rel="stylesheet" href="css/md-slider.css"/>
        
    <link rel="stylesheet" href="css/responsiveslides.css"/>
        <link rel="stylesheet" href="css/style.css"/>
        <?php if (isset($_GET['content']) && $_GET['content'] == 'start-project') { ?>
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
					 <?php if (isset($_COOKIE['simbiosis']) == null) { ?>
                <div class="container_12 clearfix">
				 <?php } else { ?>
				  
				  <div class="container_12 clearfix" style="width:1150px;">
				 <?php } ?>
                    <div id="headerwrapper" class="grid_12 header-content">
                        <div class="header-left">
                            <div id="logo">
                                <a href="."><img src="images/logo.png" alt="$SITE_NAME"/></a>
                            </div>
                            <div class="main-nav clearfix">
                                <div class="nav-item" style="margin-left: -20px;font-size: 20px;">
                                    <a href="." class="nav-title" style="color:#FF8D58">CROOWD</a>
                                </div>
                                <div class="nav-item" style="font-size: 10px">
                                    <a onclick="menuButton(1,'cari-pinjaman');" class="nav-title" style="cursor: pointer;">Cari Pinjaman</a>
                                </div>
                                <span class="sep"></span>
                                <div class="nav-item" style="font-size: 10px">
                                    <a onclick="menuButton(2,'mulai-berinvestasi');" class="nav-title" style="cursor: pointer;">Mulai Berinvestasi</a>
                                </div>
                            </div>
                        </div>
                        <div class="header-right">
                            <div class="account-panel">
														
							
                                <?php if (isset($_COOKIE['simbiosis']) == null) { ?>
					
                                    <!-- <a href="#" class="btn btn-red sys_show_popup_login">Register</a>-->
                                    <a href="http://app.croowd.co.id" class="btn btn-black">Masuk</a>
                                <?php } else { ?>
									<?php
$cookies = $_COOKIE['simbiosis'];
//echo $cookies;
$data = bacaHTML('member/getBySession/' . $cookies );
//$datas = json_decode($data);
$json = json_decode($data, true);

//echo $cookies;
/*$cookie_name = "simbiosis";
$cookie_value = "f18b882cbcac02a8db481131a3495db966f8a6cf";
setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day*/
?>			
       
                             <a href="http://app.croowd.co.id" onclick="onMenu('register')" class="btn btn-red">Keluar</a> <a href="http://app.croowd.co.id" onclick="onMenu('register')" class="btn btn-black"><?=$json['name'];?></a>
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
                    </div>
                </div>
            </header><!--end: #header -->
            <span id="setBodys">
                <?php
                if (isset($_GET['content']) != null) {
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
                <?php include 'function/popregister.php';?>
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
        
    <script type="text/javascript" src="js/responsiveslides.min.js"></script>
        <script type="text/javascript" src="js/pie.js"></script>
        <?php if (isset($_GET['content']) == 'start-project') { ?>
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
