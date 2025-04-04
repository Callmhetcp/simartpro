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
        <link rel="stylesheet" href="assets/css/about.min.css">
        <link rel="stylesheet" href="assets/css/main-mediaquery.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.4.5/css/swiper.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    
    
    
        <!-- ============FONT-AWESOME-LINKS============= -->
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
        
    
    
            <!--  ============JAVASCRIPTLINKS============= -->
            <!-- Smartsupp Live Chat script -->
            <script type="text/javascript">
                var _smartsupp = _smartsupp || {};
                _smartsupp.key = 'd3650f3e8435103dd307f14927f59672b3116a5d';
                window.smartsupp||(function(d) {
                var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
                s=d.getElementsByTagName('script')[0];c=d.createElement('script');
                c.type='text/javascript';c.charset='utf-8';c.async=true;
                c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
                })(document);
            </script>
        <noscript> Powered by <a href=“https://www.smartsupp.com” target=“_blank”>Smartsupp</a></noscript>
    </head>
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



     <section class="about">
        <header>
            <div class="head_text">WHAT YOU SHOULD KNOW ABOUT US</div>
            <div class="dash"></div>
        </header>

        <div class="about_main_content">
            <div class="wrapper">
               <div class="text_grid">
                    <div class="card">
                        <header>
                            <div class="small_heading">
                                <span class="text">Our Story</span>
                                <span class="dash"></span>
                            </div>
                            <div class="big_heading">
                                <span>The story about Simart Pro</span>
                            </div>
                        </header>
                        <article>
                            We remain true to the same principles on which our company was founded in the year 2017 providing superior services to our clients, putting safety first, creating opportunities for our people the Simart Pro is a reputable and reliable investment company with the aim of bringing financial freedom to your door steps and anchoring the provision of oil and energy and has proven to be stable and dependable and sustainable in it’s business with a full certificate of insurance which is validate with above 40 million euros to cover up any lost in investment(if it would ever happen)there shouldn’t be any doubts regarding to our insured company, With us lost is a forgotten language.
                        </article>
                    </div>
                    <div class="card">
                        <header>
                        <div class="small_heading">
                            <span class="text">What we do</span>
                            <span class="dash"></span>
                        </div>
                        <div class="big_heading">
                            <span>Our mission</span>
                        </div>
                        </header>
                        <article>
                            <p>At the Simart Pro, our mission is to expand access to the digital asset ecosystem while serving as trusted partners for our clients. We take this role seriously, and have spent the last few years building products and services to meet our clients needs. from individuals to institutions, and everyone in between.
                                As the digital asset market grows and evolves, we analyze opportunities and build long-lasting investment solutions around the needs of our clients.
                             </p>
                            <div>
                                <b>Radius Simamora, S.H.</b>
                                <span> CEO & Shareholder</span>
                            </div>
                        </article>
                    </div>
               </div>
               <div class="image_grid">
                    <div class="image">
                        <img src="assets/images/pexels-cottonbro-5990031.jpg" alt="">
                        
                    </div>
                    <div class="text">
                        <div class="big_text">Technology and Security</div>
                        <div class="small_text">
                            Our platform is built on cutting-edge technology, providing users with the highest levels of security and transparency. We believe in the transformative power of blockchain and continuously strive to adopt the latest advancements to keep your assets safe. Every transaction is protected with the most stringent security protocols, ensuring a safe and trusted trading environment.
                        </div>
                    </div>
                    <div class="image">
                        <img src="assets/images/pexels-shkrabaanthony-5862323.jpg" alt="">
                    </div>
                    
               </div>
            </div>
        </div>

    </section>
           
    <section class="our_team">
        <header>
            <div class="small_heading">
                <span class="text">We like what we do</span>
                <span class="dash"></span>
            </div>
            <div class="big_heading">
                <span>Team of Experts</span>
            </div>
        </header>
        <div class="wrapper">
            <div class="card">
                <div class="wrapper">
                    <div class="image">
                        <div class="image_wrapper">
                            <img src="assets/images/ceo.png" alt="">
                        </div>
                    </div>
                    <div class="text">
                        <span>
                            Radius Simamora, S.H.
                        </span>
                        <span>CEO</span>
                    </div>
                    <div class="social-links">
                        <a href="404.php"><i class="fab fa-facebook-f"></i></a>
                        <a href="404.php"><i class="fab fa-twitter"></i></a>
                        <a href="404.php"><i class="fab fa-instagram"></i></a>
                        <a href="404.php"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="wrapper">
                    <div class="image">
                        <div class="image_wrapper">
                            <img src="assets/images/sandra.png" alt="">
                        </div>
                    </div>
                    <div class="text">
                        <span>
                            Sandra Anthony
                        </span>
                        <span>Legal Adviser</span>
                    </div>
                    <div class="social-links">
                        <a href="404.php"><i class="fab fa-facebook"></i></a>
                        <a href="404.php"><i class="fab fa-twitter"></i></a>
                        <a href="404.php"><i class="fab fa-instagram"></i></a>
                        <a href="404.php"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="wrapper">
                    <div class="image">
                        <div class="image_wrapper">
                            <img src="assets/images/john.png" alt="">
                        </div>
                    </div>
                    <div class="text">
                        <span>
                            John Sebastian
                        </span>
                        <span>Financial Analyst</span>
                    </div>
                    <div class="social-links">
                        <a href="404.php"><i class="fab fa-facebook-f"></i></a>
                        <a href="404.php"><i class="fab fa-twitter"></i></a>
                        <a href="404.php"><i class="fab fa-instagram"></i></a>
                        <a href="404.php"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="wrapper">
                    <div class="image">
                        <div class="image_wrapper">
                            <img src="assets/images/R.jpg" alt="">
                        </div>
                    </div>
                    <div class="text">
                        <span>
                            Simom Christopher A.
                        </span>
                        <span>Chief Technology Officer <samp style="font-family: sans-serif; font-size: 15px;">(CTO)</samp></span>
                    </div>
                    <div class="social-links">
                        <a href="404.php"><i class="fab fa-facebook-f"></i></a>
                        <a href="404.php"><i class="fab fa-twitter"></i></a>
                        <a href="404.php"><i class="fab fa-instagram"></i></a>
                        <a href="404.php"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>

        </div>
    </section>



    <!-- ============ FOOTER SECTION ============= -->
    <footer class="footer">
            <div class="logo">
                <a href="index.php" class="links" style="display: flex; align-items: center; gap: 20px; text-decoration: none;">
                    <div class="logo_wrapper">
                        <img src="assets/images/logo.png" alt="">
                    </div>
    
                    <div class="logo_name" onclick>Simart Pro</div>
                </a>
            </div>
            <div class="wrapper">
                <div class="footer-card">
                    <h4>company</h4>
                    <ul>
                        <span>
                            We remain true to the same principles on which our company was founded : providing superior services to our clients, putting safety first, creating opportunities for our people.
                        </span>
                    </ul>
                </div>
                <div class="footer-card">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a class="links" href="index.php">Home</a></li>
                        <li><a class="links" href="faq.php">FAQ</a></li>
                        <li><a class="links" href="contact.php">Contact</a></li>
                        <li><a class="links" href="login.php">Login</a></li>
                    </ul>
                </div>
                <div class="footer-card">
                    <h4>who we are</h4>
                    <ul>
                        <li><a class="links" href="about.php">About</a></li>
                        <li><a class="links" href="404.php">purposes and values</a></li>
                     

                    </ul>
                </div>
                <div class="footer-card">
                    <h4>follow us</h4>
                    <div class="social-links">
                        <a href="404.php"><i class="fab fa-facebook-f"></i></a>
                        <a href="404.php"><i class="fab fa-twitter"></i></a>
                        <a href="404.php"><i class="fab fa-instagram"></i></a>
                        <a href="dashboard.php"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                    <ul>
                        <li><a class="signup links" href="signup.php">Sign up</a></li>

                    </ul>

                </div>
            </div>
    </footer>
 
    












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


    <!-- CRYPTO LOADING SECTION //*POSITION FIXED TO THE BOTTOM*// -->
    <div class="tradingview-widget-container" >
                    <iframe scrolling="no" allowtransparency="true" frameborder="0" src="https://www.tradingview-widget.com/embed-widget/ticker-tape/?locale=en#%7B%22symbols%22%3A%5B%7B%22proName%22%3A%22FOREXCOM%3ASPXUSD%22%2C%22title%22%3A%22S%26P%20500%22%7D%2C%7B%22proName%22%3A%22FOREXCOM%3ANSXUSD%22%2C%22title%22%3A%22Nasdaq%20100%22%7D%2C%7B%22proName%22%3A%22FX_IDC%3AEURUSD%22%2C%22title%22%3A%22EUR%2FUSD%22%7D%2C%7B%22proName%22%3A%22BITSTAMP%3ABTCUSD%22%2C%22title%22%3A%22BTC%2FUSD%22%7D%2C%7B%22proName%22%3A%22BITSTAMP%3AETHUSD%22%2C%22title%22%3A%22ETH%2FUSD%22%7D%2C%7B%22description%22%3A%22XAU%2FUSD%22%2C%22proName%22%3A%22FOREXCOM%3AXAUUSD%22%7D%5D%2C%22showSymbolLogo%22%3Atrue%2C%22colorTheme%22%3A%22dark%22%2C%22isTransparent%22%3Afalse%2C%22displayMode%22%3A%22adaptive%22%2C%22width%22%3A%22100%25%22%2C%22height%22%3A46%2C%22utm_source%22%3A%22crownkeylimited.com%22%2C%22utm_medium%22%3A%22widget%22%2C%22utm_campaign%22%3A%22ticker-tape%22%2C%22page-uri%22%3A%22crownkeylimited.com%2F%22%7D" title="ticker tape TradingView widget" lang="en" style="user-select: none; box-sizing: border-box; display: block; height: 106px; width: 120%; background: transparent;"></iframe>
                    
                <style>
                    .tradingview-widget-copyright {
                    font-size: 13px !important;
                    line-height: 32px !important;
                    text-align: center !important;
                    vertical-align: middle !important;
                    /* @mixin sf-pro-display-font; */
                    font-family: -apple-system, BlinkMacSystemFont, 'Trebuchet MS', Roboto, Ubuntu, sans-serif !important;
                    color: #B2B5BE !important;
                    }

                    .tradingview-widget-copyright .blue-text {
                    color: #2962FF !important;
                    }

                    .tradingview-widget-copyright a {
                    text-decoration: none !important;
                    color: #B2B5BE !important;
                    }

                    .tradingview-widget-copyright a:visited {
                    color: #B2B5BE !important;
                    }

                    .tradingview-widget-copyright a:hover .blue-text {
                    color: #1E53E5 !important;
                    }

                    .tradingview-widget-copyright a:active .blue-text {
                    color: #1848CC !important;
                    }

                    .tradingview-widget-copyright a:visited .blue-text {
                    color: #2962FF !important;
                    }
                </style>
    </div>
    
</body>
    <!-- ============JAVASCRIPT-LINKS============= -->
    <script src="assets/javascript/function.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.4.5/js/swiper.min.js"></script>
</html>