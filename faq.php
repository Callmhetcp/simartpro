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
      <link rel="stylesheet" href="assets/css/faq.min.css">
      <link rel="stylesheet" href="assets/css/main-mediaquery.css">
      <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.4.5/css/swiper.css">
      <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css">
  
  
  
      <!-- ============FONT-AWESOME-LINKS============= -->
      <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">

      

      <!-- ============JAVASCRIPT-LINKS============= -->
      <!-- <script defer src="assets/javascript/navbar.min.js"></script> -->
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


    
    
    <!-- ============ FAQ MAIN SECTION BEGIN HERE============= -->
     <section class="faq">
        <br>
        <br>
        <header>
            <div class="head_text">HAVE QUESTIONS?</div>
            <div class="dash"></div>
        </header>
        <div class="wrapper">
            <div class="questions_axis">
                <div class="container">
                    <div class="accordion">
                    <h3>General questions</h3>
                      <div class="accordion-item">
                        <button id="accordion-button-1" aria-expanded="false">
                          <span class="accordion-title">
                            Is Simart Pro incorporated?</span>
                          <span class="icon" aria-hidden="true"></span>
                        </button>
                        <div class="accordion-content">
                          <p>
                            Simart Pro is a legal financial investment company incorporated in Norway.
                          </p>
                        </div>
                      </div>
                      <div class="accordion-item">
                        <button id="accordion-button-2" aria-expanded="false">
                          <span class="accordion-title">Who is qualified to open an account with Company Name ?</span>
                          <span class="icon" aria-hidden="true"></span>
                        </button>
                        <div class="accordion-content">
                          <p>
                            Any individual (except for persons under the age of 18; as well as citizens of any countries where the Company does not provide their specified services).
                          </p>
                        </div>
                      </div>
                      <div class="accordion-item">
                        <button id="accordion-button-3" aria-expanded="false">
                          <span class="accordion-title">How do I start investment with Company Name?</span>
                          <span class="icon" aria-hidden="true"></span>
                        </button>
                        <div class="accordion-content">
                          <p>
                            All you need to pass a simple registration. After registration, login into your Company Name account then go to the investment section and open your first deposit.
                          </p>
                        </div>
                      </div>
                      <div class="accordion-item">
                        <button id="accordion-button-4" aria-expanded="false">
                          <span class="accordion-title">How may I become a client of Company Name?</span>
                          <span class="icon" aria-hidden="true"></span>
                        </button>
                        <div class="accordion-content">
                          <p>
                            You may become a client of Simart Pro and it is totally free of charge. All you need is to sign up and fill all required fields..
                          </p>
                        </div>
                      </div>
                      <div class="accordion-item">
                        <button id="accordion-button-5" aria-expanded="false">
                          <span class="accordion-title">Is it free of charge to open an account?</span>
                          <span class="icon" aria-hidden="true"></span>
                        </button>
                        <div class="accordion-content">
                          <p>
                            Yes, it is totally free of charge.
                          </p>
                        </div>
                      </div>
                      <br>
                      <br>
                      <br>
                      <br>
                      <h3>ACCOUNT QUESTIONS</h3>
                      <div class="accordion-item">
                        <button id="accordion-button-1" aria-expanded="false">
                          <span class="accordion-title">
                            How long does it take to make my client account active?</span>
                          <span class="icon" aria-hidden="true"></span>
                        </button>
                        <div class="accordion-content">
                          <p>
                            Your account will be active immediately after registration.
                          </p>
                        </div>
                      </div>
                      <div class="accordion-item">
                        <button id="accordion-button-2" aria-expanded="false">
                          <span class="accordion-title">How may I access my account?</span>
                          <span class="icon" aria-hidden="true"></span>
                        </button>
                        <div class="accordion-content">
                          <p>
                            You may log into your account by clicking the link Login and enter your username and password.
                          </p>
                        </div>
                      </div>
                      <div class="accordion-item">
                        <button id="accordion-button-3" aria-expanded="false">
                          <span class="accordion-title">How can I control my account?</span>
                          <span class="icon" aria-hidden="true"></span>
                        </button>
                        <div class="accordion-content">
                          <p>
                            In order to control your account you need to use navigation menu in the left side of our website.
                          </p>
                        </div>
                      </div>
                      <div class="accordion-item">
                        <button id="accordion-button-4" aria-expanded="false">
                          <span class="accordion-title">May I change my account details?</span>
                          <span class="icon" aria-hidden="true"></span>
                        </button>
                        <div class="accordion-content">
                          <p>
                            You may change your account details on Profile page.
                          </p>
                        </div>
                      </div>
                      <div class="accordion-item">
                        <button id="accordion-button-5" aria-expanded="false">
                          <span class="accordion-title">How secure user accounts and personal data?</span>
                          <span class="icon" aria-hidden="true"></span>
                        </button>
                        <div class="accordion-content">
                          <p>
                            All stored data on our servers remains protected via encryption technology all the time. All account related transactions done by our clients are mediated exclusively via secured internet connections.
                          </p>
                        </div>
                      </div>
                      <div class="accordion-item">
                        <button id="accordion-button-5" aria-expanded="false">
                          <span class="accordion-title">How many accounts can I open on the site?</span>
                          <span class="icon" aria-hidden="true"></span>
                        </button>
                        <div class="accordion-content">
                          <p>
                            Any client can have only one account. In the event of multiple registrations from your device we have rights to suspend all of your accounts.
                          </p>
                        </div>
                      </div>


                      <br>
                      <br>
                      <br>
                      <br>
                      <h3>DEPOSIT QUESTIONS</h3>
                      <div class="accordion-item">
                        <button id="accordion-button-1" aria-expanded="false">
                          <span class="accordion-title">When the deposit should be activated?
                          </span>
                          <span class="icon" aria-hidden="true"></span>
                        </button>
                        <div class="accordion-content">
                          <p>
                            Your deposit should be activated immediately if you use Perfect Money. If you use cryptocurrencies it could be some time which is required for getting confirmations by the cryptocurrency network. For deposits in cryptocurrencies we need at least 1 confirmation. If your deposit hasn't appear in your account for a long time, please contact us.
                          </p>
                        </div>
                      </div>
                      <div class="accordion-item">
                        <button id="accordion-button-2" aria-expanded="false">
                          <span class="accordion-title">Where can I read about the investment plans?</span>
                          <span class="icon" aria-hidden="true"></span>
                        </button>
                        <div class="accordion-content">
                          <p>
                            You can check all actual investment plans in your member area on Make Deposit page.
                          </p>
                        </div>
                      </div>
                      <div class="accordion-item">
                        <button id="accordion-button-3" aria-expanded="false">
                          <span class="accordion-title">How can I withdraw my profit?</span>
                          <span class="icon" aria-hidden="true"></span>
                        </button>
                        <div class="accordion-content">
                          <p>
                            In order to withdraw your profit you need to naigate to "cashout" page in your Cabinet. Please input payout amount and choose payment system which you have used for making your deposits.
                          </p>
                        </div>
                      </div>
                      <div class="accordion-item">
                        <button id="accordion-button-4" aria-expanded="false">
                          <span class="accordion-title">How soon after withdrawal request will the money appear on my payment account?</span>
                          <span class="icon" aria-hidden="true"></span>
                        </button>
                        <div class="accordion-content">
                          <p>
                            Your request will be processed instantly. We do everything possible to reduce awaiting time of our clients.
                        </div>
                      </div>
                  
                    </div>
                    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                    <script>
                        const $items = $('.accordion button');
                    
                        function toggleAccordion() {
                            const $item = $(this);
                            const itemToggle = $item.attr('aria-expanded');
                    
                            $items.attr('aria-expanded', 'false');
                    
                            if (itemToggle === 'false') {
                                $item.attr('aria-expanded', 'true');
                            }
                        }
                    
                        $items.on('click', toggleAccordion);
                    </script>
                  </div>
            </div>
            <div class="support_axis">
              <div class="wrapper">
                <div class="text">
                  <div class="big_text">
                    <span>support</span>
                    <span>Get in touch to learn more</span>
                  </div>

                  <div class="small_text">
                    We are investing in new technologies and always looking for new innovative products to build within the Company Name brand.
                  </div>
                </div>
                <div class="btn">
                  <a href="contact.php">Get in Touch</a>
                </div>
                <div class="address">
                  <div>
                    <b>Registered Office</b>
                    <span>Elveosen 3, Sandnes, Norway.</span>
                  </div>
                  <div>
                    <b>Support Email</b>
                    <span>support@simartpro.com</span>
                  </div>
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

              <div class="logo_name">Simart Pro</div>
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
                  <li><a class="links" href="#">purposes and values</a></li>
                  

              </ul>
          </div>
          <div class="footer-card">
              <h4>follow us</h4>
              <div class="social-links">
                  <a href="#"><i class="fab fa-facebook-f"></i></a>
                  <a href="#"><i class="fab fa-twitter"></i></a>
                  <a href="#"><i class="fab fa-instagram"></i></a>
                  <a href="#"><i class="fab fa-linkedin-in"></i></a>

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
<script>
const html = document.querySelector(`html`)
const body = document.querySelector(`body`);
const hamBurger = document.querySelector(`.hamburger`);
const mobileNavbar = document.querySelector(`.mobile_navbar`);
const checkNav = document.querySelector(`#check_nav`);
const allLinks = document.querySelector('.links');
const preloaderAnimation = document.querySelector(`.preloader_animation`);
const mobileNavigation = document.querySelector(`.navigation_wrapper`);
let thisHref = allLinks.getAttribute(`href`);
const alertBox = document.querySelector(`#toast-container`);




checkNav.addEventListener(`click`, () => {

	if(checkNav.checked){
		hamBurger.classList.add('is-active');
		mobileNavbar.style.setProperty(
			'transform',
			'translateX(+0)'
		);
		mobileNavbar.style.setProperty(
			'transition',
			'0.6s cubic-bezier(0.23, 1, 0.32, 1)'
		);
	}else {
		hamBurger.classList.remove('is-active');
		mobileNavbar.style.setProperty(
			'transform',
			'translateX(-50vh)'
		);

		mobileNavbar.style.setProperty(
			'transition',
			'1s'
		);
	};

	mobileNavbar.style.setProperty(
		'width',
		'70px'
	 );
	 document.querySelectorAll(`.menu_link`).forEach((menuLink) =>{
		menuLink.style.setProperty(
				'transform',
				'translateX(20px)'
			 );
	 });
});



document.querySelectorAll(`.menu_icon`).forEach((icon) => {
	icon.addEventListener(`click`, () => {
		if (mobileNavbar.style.width === `70px`) {
			 mobileNavbar.style.setProperty(
				'width',
				'160px'
			 );
			 document.querySelectorAll(`.menu_link`).forEach((menuLink) =>{
				menuLink.style.setProperty(
						'transform',
						'translateX(0)'
					 );
			 });
		}else {
			mobileNavbar.style.setProperty(
				'width',
				'70px'
			 );
			 document.querySelectorAll(`.menu_link`).forEach((menuLink) =>{
				menuLink.style.setProperty(
						'transform',
						'translateX(20px)'
					 );
			 });
		}


	});
});

</script>

    
</body>

    <!-- ============JAVASCRIPT-LINKS============= -->
    <!-- <script src="assets/javascript/function.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <script src="assets/javascript/typed.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.4.5/js/swiper.min.js"></script>
    <script src="assets/javascript/node_modules/lodash/lodash.min.js"></script>


</html>