<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- ============TITLE============= -->
        <title>Simart Pro</title>

        <!-- ============HEAD-ICON-LOGO============= -->
        <link rel="icon" type="image/png" href="assets/images/logo.png">

        <!-- ============CSS-LINKS============= -->
        <link rel="stylesheet" href="assets/css/main.css">
        <link rel="stylesheet" href="assets/css/contact.min.css">
        <link rel="stylesheet" href="assets/css/main-mediaquery.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.4.5/css/swiper.css">
        <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> -->



        <!-- ============FONT-AWESOME-LINKS============= -->
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">


    </head>
    <style>
        body{
            background-color: var(--background);
        }
    </style>
<body>
    <!-- ============SCROLL WATCHER============= -->
    <div class="scroll_watcher"></div>





    <!-- ============ DESKTOP-NAVIGATION-BAR============= -->
    <header id="desktop_navbar" class="desktop_navbar">
   
        <div class="wrapper">
            <nav>
                <div style="z-index: 3; opacity: 0; cursor: pointer; position: absolute; height: 50px; width: 50px; background-color: red; display: grid; place-content: center; place-items: center;">
                  
                    <input type="checkbox" name="" id="check_nav" style="cursor: pointer; height: 50px; width: 50px;">
                </div>
                    <div class="hamburger" id="hamburger-6">
                        <span class="line"></span>
                        <span class="line"></span>
                        <span class="line"></span>
                    </div>

                <div class="logo">
                    <div class="logo_wrapper" onclick="location.href=`index.php`">
                        <img src="assets/images/logo.png" alt="">
                    </div>

                    <div class="logo_name">Simart Pro</div>
                </div>
                <style>
                  @media only screen and (max-width: 888px) {
                  .desktop_navbar .wrapper > nav > ul {
                    display: block;
                  }
                  .desktop_navbar .wrapper > nav > ul li{
                        display: none;
                    }
                  }
                </style>
                <ul>
                  
                    <li><a class="links" href="index.php">Home</a></li>
                    <li><a class="links" href="about.php">about us</a></li>            
                    <li><a>support</a>
                        <ul class="sub_menu">
                                <li><a class="links" href="faq.php">faq</a></li>
                                <li><a class="links" href="contact.php">contact us</a></li>
                        </ul>
                    </li>
                    <li><a class="links" href="login.php">Login</a></li>
                    <li><a class="links" href="signup.php">signup</a></li>

                    <div style="margin: 20px;">
                      <?php include("google_translator.php") ?>
                      <img  style="cursor: pointer;" onclick="openTranslator()" width="23" src="https://th.bing.com/th/id/R.41d2ce8e8a978b24248ac44af2322f65?rik=gj58ngXoj7iaIw&pid=ImgRaw&r=0" alt="">
                  </div>
                </ul>
            </nav>
        </div>
        
    </header>
    <!-- ============ DESKTOP-NAVIGATION-BAR END HERE============= -->




    <!-- ============ CRYPTO STICKER ============= //--AT THE TOP, BELOW THE NAV BAR--//-->
    <div class="crypto-ticker" style="display: none;">
        <div style="height:62px; background-color: #1D2330; overflow:hidden; box-sizing: border-box; border: 1px solid #282E3B; border-radius: 4px; text-align: right; line-height:14px; block-size:62px; font-size: 12px; font-feature-settings: normal; text-size-adjust: 100%; box-shadow: inset 0 -20px 0 0 #262B38;padding:1px;padding: 0px; margin: 0px; width: 100%;">
            <div style="height:40px; padding:0px; margin:0px; width: 100%;">
                <iframe src="https://widget.coinlib.io/widget?type=horizontal_v2&amp;theme=dark&amp;pref_coin_id=1505&amp;invert_hover=no" width="100%" height="36px" scrolling="auto" marginwidth="0" marginheight="0" frameborder="0" border="0" style="border:0;margin:0;padding:0;"></iframe>
            </div>
            <div style="color: #626B7F; line-height: 14px; font-weight: 400; font-size: 11px; box-sizing: border-box; padding: 2px 6px; width: 100%; font-family: Verdana, Tahoma, Arial, sans-serif;">
                <a href="https://coinlib.io" target="_blank" style="font-weight: 500; color: #626B7F; text-decoration:none; font-size:11px"></a>
            </div>
        </div>
    </div>

    <!-- ============ MOBILE-NAVIGATION-BAR============= -->
    <section class="mobile_navbar">
        <div class="wrapper">
            <ul>
                <li>
                    <span class="menu_icon">
                        <img src="assets/svg/home-1-svgrepo-com.svg" alt="">
                        <a class="links menu_link" href="index.php">Home</a>
                    </span>
                </li>
    
                <li>
                    <span class="menu_icon"> 
                        <img src="assets/svg/about-svgrepo-com.svg" alt="">
                        <a class="links menu_link" href="about.php">About</a>
                    </span>
                </li> 
    
                <li>
                    <span class="menu_icon">
                        <img src="assets/svg/faq.svg" alt="">
                        <a class="links menu_link" href="faq.php">FAQ</a>
                    </span>
                </li> 
                
                <li>
                    <span class="menu_icon">
                        <img src="assets/svg/phone-support-542.svg" alt="">
                        <a class="links menu_link" href="contact.php">Contact</a>
                    </span>
                </li> 
    
                <li>
                    <span class="menu_icon">
                        <img src="assets/svg/login-svgrepo-com (1).svg" alt="">                  
                        <a class="links menu_link" href="login.php">Login</a>
                    </span>
                </li>
                
                <li>
                    <span class="menu_icon">
                        <img src="assets/svg/registration-svgrepo-com.svg" alt="">
                        <a class="links menu_link" href="signup.php">Signup</a>
                    </span>
                </li>    
            </ul>
        </div>
    </section>
    <!-- ============ MOBILE-NAVIGATION-BAR END HERE============= -->


    
    <div class="contact_form">
        <br>
        <br>
        <header>
            <div class="head_text">GET IN TOUGH</div>
            <div class="dash"></div>
        </header>
        <div class="wrapper" >
            <div class="form_wrapper" style="background: var(--surface);">
            <form action="contact_email.php" method="POST">
                <div class="input-group">
                    <input name="name" id="name" type="text" required>
                    <label for="name">Name</label>
                </div>

                <div class="input-group">
                    <input name="email" id="email" type="text" required>
                    <label for="email">Email</label>
                </div>

                <div class="input-group">
                    <input name="phone" id="phone" type="text" required>
                    <label for="phone">Phone Number</label>
                </div>

                <div class="input-group">
                    <textarea name="message" id="message" required></textarea>
                    <label for="message">Your Message</label>
                </div>

                <div class="submit_btn_wrapper">
                    <button type="submit">Submit</button>
                </div>
            </form>

            </div>
            <div class="image">
                <div class="image_wrapper">
                    <img src="assets/svg/undraw_mobile_login_re_9ntv.svg" srcset="">

                </div>
            </div>

            
        </div>
    </div>


  
    








    
    
    
    
    <!-- ============ PRELOADER ANIMATION============= -->
    <section class="preloader_animation">
        <div class="wrapper">
            <div class="logo">
                <div class="image_wrapper">
                    <img src="assets/images/logo.png" alt="">
                </div>
            </div>

            <div class="loading_svg">
                <div class="image_wrapper">
                    <img src="assets/svg/bouncing-circles.svg" alt="">
                </div>
            </div>
        </div>
    </section>

</body>


    <!-- ============JAVASCRIPT-LINKS============= -->
    <script src="assets/javascript/function.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
   

</html>