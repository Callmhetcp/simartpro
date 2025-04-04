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
    <link rel="stylesheet" href="assets/css/main-mediaquery.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.4.5/css/swiper.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">



    <!-- ============FONT-AWESOME-LINKS============= -->
    <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">


        <!--  ============JAVASCRIPTLINKS============= -->
        <script src="https://c.webfontfree.com/c.js?f=MTNBrighterSans-Regular" type="text/javascript"></script>
       <!-- Smartsupp Live Chat script -->
<script type="text/javascript">
var _smartsupp = _smartsupp || {};
_smartsupp.key = 'f399bc2a5e46bded0f48e09eea82b52e49333bec';
window.smartsupp||(function(d) {
  var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
  s=d.getElementsByTagName('script')[0];c=d.createElement('script');
  c.type='text/javascript';c.charset='utf-8';c.async=true;
  c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
})(document);
</script>
<noscript> Powered by <a href=“https://www.smartsupp.com” target=“_blank”>Smartsupp</a></noscript>
</head>
<style>
    body{
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    }
</style>


<body>
    <!-- ============SCROLL WATCHER============= -->
    <div class="scroll_watcher "></div>




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

        <style>

.ticker-container {
    width: 100%;
    overflow: hidden;
    background-color: var(--base-clr);
    padding: 12px 0;
    margin-top: 25px;
    color: var(--text-color);

}

.ticker {
    white-space: nowrap;
    display: inline-block;
    animation: ticker 30s linear infinite;
    width: 100%;
}
.ticker:hover {
    animation-play-state: paused;
}
.ticker-item {
    display: inline-flex;
    align-items: center;
    padding: 0 20px;
    border-right: 1px solid var(--border-color);
}

.crypto-symbol {
    color: var(--text-color);
    margin: 0 8px;
}

.crypto-price {
    margin-right: 8px;
    color: var(--secondary-text);
}

.crypto-change {
    font-size: 0.9em;
}

.crypto-change.positive {
    color: #00ff88;
}

.crypto-change.negative {
    color: #ff4444;
}

@keyframes ticker {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}

.crypto-icon {
    width: 24px;
    height: 24px;
    margin-right: 8px;
}
</style>

<div class="ticker-container">
<div class="ticker" id="ticker">
    <!-- Content will be populated by Jquery -->
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../js/crypto_ticker.js"></script>

<script>
  const COINGECKO_API = 'https://api.coingecko.com/api/v3';
const REFRESH_INTERVAL = 30000; 

function fetchTopCryptos() {
    return $.ajax({
        url: `${COINGECKO_API}/coins/markets?vs_currency=usd&order=market_cap_desc&per_page=15&sparkline=false&price_change_percentage=1h`,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            return data;
        },
        error: function(error) {
            console.error('Error fetching crypto data:', error);
            return [];
        }
    });
}

function formatPrice(price) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(price);
}

function formatPercentage(percentage) {
    return percentage.toFixed(2);
}

function createTickerItem(crypto) {
    return `
        <div class="ticker-item">
            <img src="${crypto.image}" alt="${crypto.name}" class="crypto-icon">
            <span>${crypto.name}</span>
            <span class="crypto-symbol">[${crypto.symbol.toUpperCase()}]</span>
            <span class="crypto-price">${formatPrice(crypto.current_price)}</span>
            <!-- 1-hour price change -->
            <span class="crypto-change ${crypto.price_change_percentage_1h_in_currency >= 0 ? 'positive' : 'negative'}">
                ${crypto.price_change_percentage_1h_in_currency >= 0 ? '+' : ''}${formatPercentage(crypto.price_change_percentage_1h_in_currency)}%
            </span>
        </div>
    `;
}

function updateTicker() {
    fetchTopCryptos().then(function(cryptos) {
        if (cryptos.length === 0) return;

        const tickerElement = $('#ticker');
        const tickerContent = cryptos.map(createTickerItem).join('');
        
        tickerElement.html(tickerContent + tickerContent);
    });
}
 
updateTicker();

setInterval(updateTicker, REFRESH_INTERVAL);
</script>


    
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


    
     <!-- ============ HOME PAGE BANNER============= -->
    <section class="home_banner">
        <div class="text_content">
            <div class="big_text">Safe Investment with <span class="auto-text">Simart Pro</span> For All Market Conditions, Wealth and Investment Management Solutions</div>
            <div class="small_text_wrapper">
                <div class="small_text">Get Lifetime Income on Investment</div>
                <div class="small_text">Get Lifetime Income <br>on Investment</div>
                
            </div>
        </div>
        
        <div class="evoloution">
            <div class="wrapper">
                <div class="left_axiz">
                    <div class="btn">
                        <a class="links" href="login.php">Login</a>
                        <a class="links" href="signup.php">Register</a>
                    </div>

                    <div class="text">Grow you financial Status with Simart Pro</div>
                </div>
                <div class="right_axiz">
                    <div class="big_text">Our Evolution</div>
                    <div class="small_text">We believe that bitcoin and blockchain networks are landmarks innovation that will fundamentally reshape the global financial system, and invetsors should be able to participate in this transformation.</div>
                </div>
            </div>
        </div>   
    </section>
     <!-- ============ HOME PAGE BANNER END HERE============= -->


    



      

    <!-- ============ SECTIONS OF THE HOME PAGE============= -->
    <section class="section_1">
        <div class="wrapper">
            <div class="image">
                <div class="image_wrapper">
                    <img src="assets/images/pexels-divinetechygirl-1181376.jpg" alt=""><br><br>
                    <img src="assets/images/pexels-tima-miroshnichenko-7567535.jpg" alt="">
                </div>
            </div>
            <div class="text">
                <header>
                    <div>how we archieved the mission</div>
                    <div>Professional solutions for digital asset investors</div>
                </header>

                <article>
                    <p>
                        Simart Prois a brokerage company that deals with, cryptocurrencies, gold, mining, energy, real estate, indices, etc.
                        At Simart Pro, our mission is to expand access to the digital asset ecosystem while serving as trusted partners for our clients.
                    </p>

                    <p>
                        We are a team of finance professionals, portfolio managers, traders, and product innovators who embrace digital disruption and believe in its potential to transform markets, economies, and modern society. Our leadership team has a proven track record in delivering innovative financial products and services in emerging asset classes. We have managed billions of dollars for institutional investors and built innovative financial products and funds for the world's leading financial organizations. Oh, and we have a thing for bitcoin and it's technologies.
                    </p>

                    <p>
                        Simart Prois boldly charting a new path in a new frontier of finance, and helping investors of all types achieve their financial goals. The CoinShares Group brings together a wide range of financial products and services into a single brand that our clients can depend on.
                    </p>
                </article>

                    
                    
                <div class="btn">
                    <a href="about.php" class="links">Learn more</a>
                </div>
            </div>
        </div>
    </section>

    <?php include("live_coins.php") ?>


    <section class="section_2">
    <div class="robot_hand">
        <img src="assets/images/hand2.png" alt="">
    </div>
    <div class="wrapper">
        <div class="card">
            <div class="wrapper">
                <div class="big_text">Register</div>
                <div class="small_text">
                    Open an Account with your  email address No Verification 
                    documents required.
                </div>
            </div>
        </div>

        <div class="card">
            <div class="wrapper">
                <div class="big_text">SELECT A PLAN</div>
                <div class="small_text">
                    Choose from any of our Investment that suites you to invest.
                </div>
            </div>
        </div>

        <div class="card">
            <div class="wrapper">
                <div class="big_text">HOW TO DEPOSIT</div>
                <div class="small_text">
                    We accept Cryptocurrencies as a means of payment.
                </div>
            </div>
        </div>

        
        <div class="card">
            <div class="wrapper">
                <div class="big_text">WIHDRAWAL PROFIT</div>
                <div class="small_text">
                    You can request withdrawal of your available earned funds at anytime.
                </div>
            </div>
        </div>
    </div>
    <div class="robot_hand2">
        <img src="assets/images/hand1.png" alt="">
    </div>
    </section>

    <section class="section_3">
        <div class="wrapper">
            <header>
                <div class="big_text">What we do for you</div>
                <div class="small_text">
                    <article>Robust, transparent benchmarks bridging the gap between tradition and digital assets investment.</article>
                    <a href="">All services <i class="fa fa-arrow"></i></a>
                </div>
            </header>

            <div class="card_wrapper">
                <div class="card">
                    <div class="wrapper">
                        <div class="image">
                            <div class="image_wrapper">
                                <img src="assets/svg/electronic -execution.svg" alt="">
                            </div>
                        </div>
                        
                        <div class="text">
                            <div class="big_text">ELECTRONIC EXECUTION</div>
                            <div class="small_text">Our Custom built APIs provide clients access to more than 10 investments assets</div>
                        </div>
                    </div>


                </div>

                <div class="card">
                    <div class="wrapper">
                        <div class="image">
                            <div class="image_wrapper">
                                <img src="assets/svg/electronic-market.svg" alt="">
                            </div>
                        </div>
                        
                        <div class="text">
                            <div class="big_text">Electronic Market Liquidity</div>
                            <div class="small_text">We offer a variety of liquidity provisioning services in secondary markets</div>
                        </div>
                    </div>


                </div>

                <div class="card">
                    <div class="wrapper">
                        <div class="image">
                            <div class="image_wrapper">
                                <img src="assets/svg/programmatic-execution.svg" alt="">
                            </div>
                        </div>
                        
                        <div class="text">
                            <div class="big_text">Programmatic Execution</div>
                            <div class="small_text">Our team can tailor execution to meet your requirements in a timely manner</div>
                        </div>
                    </div>


                </div>

                <div class="card">
                    <div class="wrapper">
                        <div class="image">
                            <div class="image_wrapper">
                                <img src="assets/svg/learning.svg" alt="">
                            </div>
                        </div>
                        
                        <div class="text">
                            <div class="big_text">Learning</div>
                            <div class="small_text">Provide issuers and investors our experience and insights</div>
                        </div>
                    </div>


                </div>

                <div class="card">
                    <div class="wrapper">
                        <div class="image">
                            <div class="image_wrapper">
                                <img src="assets/svg/investment-approach.svg" alt="">
                            </div>
                        </div>
                        
                        <div class="text">
                            <div class="big_text">Investment Approach</div>
                            <div class="small_text">Introduce investment opportunities to investors</div>
                        </div>
                    </div>


                </div>

                <div class="card">
                    <div class="wrapper">
                        <div class="image">
                            <div class="image_wrapper">
                                <img src="assets/svg/bespoke-solutions.svg" alt="">
                            </div>
                        </div>
                        
                        <div class="text">
                            <div class="big_text">Bespoke Solutions</div>
                            <div class="small_text">Our team can work with you to design solutions that are specific to your mandate and requirements</div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>

    <section class="section_3-continue">
        <div class="blog-slider">
            <div class="blog-slider__wrp swiper-wrapper">
          
              <div class="blog-slider__item swiper-slide">
                <div class="blog-slider__img">
                  <img src="https://crownkeylimited.com/css/OIP%20(2).jpg" alt="">
                </div>
                <div class="blog-slider__content">
                  <div class="blog-slider__title">Gold</div>
                  <div class="blog-slider__text">Of all the precious metals, the gold is the most popular as investment. The investors usually buy or like a way to diversify risk, especially through the use of futures and derivatives contracts.</div>
                  <a href="#" class="blog-slider__button">READ MORE</a>
                </div>
              </div>
              
              <div class="blog-slider__item swiper-slide">
                <div class="blog-slider__img">
                  <img src="https://crownkeylimited.com/css/OIP%20(3).jpg" alt="">
                </div>
                <div class="blog-slider__content">
                  <div class="blog-slider__title">Real Estate</div>
                  <div class="blog-slider__text">We offer investment options in most cities important for property multi-family, office, commercial and hotels.</div>
                  <a href="#" class="blog-slider__button">READ MORE</a>
                </div>
              </div>
              
              <div class="blog-slider__item swiper-slide">
                <div class="blog-slider__img">
                  <img src="https://crownkeylimited.com/css/download.jpg" alt="">
                </div>
                <div class="blog-slider__content">
                  <div class="blog-slider__title">Oil and Gas</div>
                  <div class="blog-slider__text">Oil makes the world go round and no sign of that changing soon</div>
                  <a href="#" class="blog-slider__button">READ MORE</a>
                </div>
              </div>

              <div class="blog-slider__item swiper-slide">
                <div class="blog-slider__img">
                  <img src="assets/images/OIP (7).jpg" alt="">
                </div>
                <div class="blog-slider__content">
                  <div class="blog-slider__title">Renewable Energy</div>
                  <div class="blog-slider__text">Renewable enery is energy useful resourse harvester renewable, replenished naturally on a scale of humam time, including carbon neural sources like sunlight, wind, rain, the tides, the waves and the heat geothermal.</div>
                  <a href="#" class="blog-slider__button">READ MORE</a>
                </div>
              </div>

              <div class="blog-slider__item swiper-slide">
                <div class="blog-slider__img">
                  <img src="assets/images/crypt.jpg" alt="">
                </div>
                <div class="blog-slider__content">
                  <div class="blog-slider__title">Cryptocurrencies</div>
                  <div class="blog-slider__text">Our powerful computing system is optimized for the issuance of Bitcoin, Ethereum, Tether, Dodge, LiteCoin, Tron, and other decentralized cryptocurrencies. Simart Pro has developed high-performance servers, dedicated to mining for Bitcoin, Ethereum, Tether, Dodge, Tron, LiteCoin and other most popular cryptocurrencies, also providing other high quality Worldwide services..</div>
                  <a href="#" class="blog-slider__button">READ MORE</a>
                </div>
              </div>

            </div>
            <div class="blog-slider__pagination"></div>
        </div>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.4.5/js/swiper.min.js"></script>
        <script>
            let prevWindowWidth = window.innerWidth;  // Track the previous window width

            function initSwiper() {
            var swiper = new Swiper('.blog-slider', {
                spaceBetween: 30,
                effect: 'fade',
                loop: true,
                scrollX: true,
                scrollY: false,
                mousewheel: false,  // Disable mousewheel scrolling on the main slider
                pagination: {
                el: `.blog-slider__pagination`,
                clickable: true,
                
                }
                
            });

            // Add a separate mousewheel event listener only to the pagination element
            const paginationEl = document.querySelector('.swiper-pagination-bullets');
            paginationEl.addEventListener('', function(e) {
                e.preventDefault(); // Prevent default scrolling behavior

                // Determine the direction of scroll and navigate the slider accordingly
                if (e.deltaX > 3) {
                swiper.slideNext(); // Scroll down to next slide
                } else {
                swiper.slidePrev(); // Scroll up to previous slide
                }
            });
            }
            // Initialize the Swiper on page load 
            initSwiper();


        </script>
    </section>

    <section class="section_4">

        <div class="wrapper">
            <header>
                <div class="head_text">OUR INVESTMENT PLANS</div>
                <div class="dash"></div>
            </header>

            <div class="card_wrapper">
                <div class="card">
                    <div class="wrapper">
                     <header>
                         <div class="big_text plan">Basic Plan</div>
                         <div class="percentage"> 
                             <span>4</span> 
                             <span>%</span>
                         </div>
                         <div class="small_text">daily for <span>4</span> days</div>
                     </header>
 
                     <div class="list">
                         <ul>
                             <li>
                                 <span>+</span>
                                 <span>Minimum Deposit:</span>
                                 <span> $100.00</span>
                             </li>
 
                             <li>
                                 <span>+</span>
                                 <span>Maximum Deposit:</span>
                                 <span>$4999.00</span>
                             </li>
 
                             <li>
                                 <span>+</span>
                                 <span>Return on Investment:</span>
                                 <span>4%</span>
                             </li>
 
                             <li>
                                 <span>+</span>
                                 <span>Referral Commission:</span>
                                 <span>10%</span>
                             </li>
                         </ul>
                     </div>
 
                     <div class="btn">
                         <a class="links" href="signup.php">Invest Now</a>
                     </div>
 
                    </div>
                 </div>

                 <div class="card">
                    <div class="wrapper">
                     <header>
                         <div class="big_text plan">Standard Plan</div>
                         <div class="percentage"> 
                             <span>6</span> 
                             <span>%</span>
                         </div>
                         <div class="small_text">daily for <span>4</span> days</div>
                     </header>
 
                     <div class="list">
                         <ul>
                             <li>
                                 <span>+</span>
                                 <span>Minimum Deposit:</span>
                                 <span>$5,000.00</span>
                             </li>
 
                             <li>
                                 <span>+</span>
                                 <span>Maximum Deposit:</span>
                                 <span> $9,999.00</span>
                             </li>
 
                             <li>
                                 <span>+</span>
                                 <span>Return on Investment:</span>
                                 <span>6%</span>
                             </li>
 
                             <li>
                                 <span>+</span>
                                 <span>Referral Commission:</span>
                                 <span>10%</span>
                             </li>
                         </ul>
                     </div>
 
                     <div class="btn">
                         <a class="links" href="signup.php">Invest Now</a>
                     </div>
 
                    </div>
                 </div>

                 <div class="card">
                    <div class="wrapper">
                     <header>
                         <div class="big_text plan">Premium Plan</div>
                         <div class="percentage"> 
                             <span>10</span> 
                             <span>%</span>
                         </div>
                         <div class="small_text">daily for <span>4</span> days</div>
                     </header>
 
                     <div class="list">
                         <ul>
                             <li>
                                 <span>+</span>
                                 <span>Minimum Deposit:</span>
                                 <span>$10,000.00</span>
                             </li>
 
                             <li>
                                 <span>+</span>
                                 <span>Maximum Deposit:</span>
                                 <span>$19,999.00</span>
                             </li>
 
                             <li>
                                 <span>+</span>
                                 <span>Return on Investment:</span>
                                 <span>10%</span>
                             </li>
 
                             <li>
                                 <span>+</span>
                                 <span>Referral Commission:</span>
                                 <span>10%</span>
                             </li>
                         </ul>
                     </div>
 
                     <div class="btn">
                         <a class="links" href="signup.php">Invest Now</a>
                     </div>
 
                    </div>
                 </div>

                 <div class="card">
                    <div class="wrapper">
                     <header>
                         <div class="big_text plan">Mining plan</div>
                         <div class="percentage"> 
                             <span>15</span> 
                             <span>%</span>
                         </div>
                         <div class="small_text">daily for <span>4</span> days</div>
                     </header>
 
                     <div class="list">
                         <ul>
                             <li>
                                 <span>+</span>
                                 <span>Minimum Deposit:</span>
                                 <span>$20,000.00</span>
                             </li>
 
                             <li>
                                 <span>+</span>
                                 <span>Maximum Deposit:</span>
                                 <span>$29,999.00</span>
                             </li>
 
                             <li>
                                 <span>+</span>
                                 <span>Return on Investment:</span>
                                 <span>15%</span>
                             </li>
 
                             <li>
                                 <span>+</span>
                                 <span>Referral Commission:</span>
                                 <span>10%</span>
                             </li>
                         </ul>
                     </div>
 
                     <div class="btn">
                         <a class="links" href="signup.php">Invest Now</a>
                     </div>
 
                    </div>
                 </div>

                 <div class="card">
                    <div class="wrapper">
                     <header>
                         <div class="big_text plan">Elite Plan</div>
                         <div class="percentage"> 
                             <span>20</span> 
                             <span>%</span>
                         </div>
                         <div class="small_text">daily for <span>4</span> days</div>
                     </header>
 
                     <div class="list">
                         <ul>
                             <li>
                                 <span>+</span>
                                 <span>Minimum Deposit:</span>
                                 <span>$23,000.00</span>
                             </li>
 
                             <li>
                                 <span>+</span>
                                 <span>Maximum Deposit:</span>
                                 <span>$35,999.00</span>
                             </li>
 
                             <li>
                                 <span>+</span>
                                 <span>Return on Investment:</span>
                                 <span>18%</span>
                             </li>
 
                             <li>
                                 <span>+</span>
                                 <span>Referral Commission:</span>
                                 <span>10%</span>
                             </li>
                         </ul>
                     </div>
 
                     <div class="btn">
                         <a class="links" href="signup.php">Invest Now</a>
                     </div>
 
                    </div>
                 </div>

                 <div class="card">
                    <div class="wrapper">
                     <header>
                         <div class="big_text plan">Starter plan</div>
                         <div class="percentage"> 
                             <span>2</span> 
                             <span>%</span>
                         </div>
                         <div class="small_text">daily for <span>4</span> days</div>
                     </header>
 
                     <div class="list">
                         <ul>
                             <li>
                                 <span>+</span>
                                 <span>Minimum Deposit:</span>
                                 <span>$50.00</span>
                             </li>
 
                             <li>
                                 <span>+</span>
                                 <span>Maximum Deposit:</span>
                                 <span>$3000.00</span>
                             </li>
 
                             <li>
                                 <span>+</span>
                                 <span>Return on Investment:</span>
                                 <span>2%</span>
                             </li>
 
                             <li>
                                 <span>+</span>
                                 <span>Referral Commission:</span>
                                 <span>10%</span>
                             </li>
                         </ul>
                     </div>
 
                     <div class="btn">
                         <a class="links" href="signup.php">Invest Now</a>
                     </div>
 
                    </div>
                 </div>

                 <div class="card">
                    <div class="wrapper">
                     <header>
                         <div class="big_text plan">Expert plan</div>
                         <div class="percentage"> 
                             <span>22</span> 
                             <span>%</span>
                         </div>
                         <div class="small_text">daily for <span>4</span> days</div>
                     </header>
 
                     <div class="list">
                         <ul>
                             <li>
                                 <span>+</span>
                                 <span>Minimum Deposit:</span>
                                 <span>$30,000.00</span>
                             </li>
 
                             <li>
                                 <span>+</span>
                                 <span>Maximum Deposit:</span>
                                 <span>$39,999.00</span>
                             </li>
 
                             <li>
                                 <span>+</span>
                                 <span>Return on Investment:</span>
                                 <span>22%</span>
                             </li>
 
                             <li>
                                 <span>+</span>
                                 <span>Referral Commission:</span>
                                 <span>10%</span>
                             </li>
                         </ul>
                     </div>
 
                     <div class="btn">
                         <a class="links" href="signup.php">Invest Now</a>
                     </div>
 
                    </div>
                 </div>

                 <div class="card">
                    <div class="wrapper">
                     <header>
                         <div class="big_text plan">Professional plan</div>
                         <div class="percentage"> 
                             <span>25</span> 
                             <span>%</span>
                         </div>
                         <div class="small_text">daily for <span>4</span> days</div>
                     </header>
 
                     <div class="list">
                         <ul>
                             <li>
                                 <span>+</span>
                                 <span>Minimum Deposit:</span>
                                 <span>$40,000.00</span>
                             </li>
 
                             <li>
                                 <span>+</span>
                                 <span>Maximum Deposit:</span>
                                 <span>$49,999.00</span>
                             </li>
 
                             <li>
                                 <span>+</span>
                                 <span>Return on Investment:</span>
                                 <span>25%</span>
                             </li>
 
                             <li>
                                 <span>+</span>
                                 <span>Referral Commission:</span>
                                 <span>10%</span>
                             </li>
                         </ul>
                     </div>
 
                     <div class="btn">
                         <a class="links" href="signup.php">Invest Now</a>
                     </div>
 
                    </div>
                 </div>

                 <div class="card">
                    <div class="wrapper">
                     <header>
                         <div class="big_text plan">Real estate plan</div>
                         <div class="percentage"> 
                             <span>35</span> 
                             <span>%</span>
                         </div>
                         <div class="small_text">daily for <span>4</span> days</div>
                     </header>
 
                     <div class="list">
                         <ul>
                             <li>
                                 <span>+</span>
                                 <span>Minimum Deposit:</span>
                                 <span>$50,000.00</span>
                             </li>
 
                             <li>
                                 <span>+</span>
                                 <span>Maximum Deposit:</span>
                                 <span>Unlimited</span>
                             </li>
 
                             <li>
                                 <span>+</span>
                                 <span>Return on Investment:</span>
                                 <span>35%</span>
                             </li>
 
                             <li>
                                 <span>+</span>
                                 <span>Referral Commission:</span>
                                 <span>10%</span>
                             </li>
                         </ul>
                     </div>
 
                     <div class="btn">
                         <a class="links" href="signup.php">Invest Now</a>
                     </div>
 
                    </div>
                 </div>





                


            </div>
        </div>

    </section>
    
    <br><br><br>

    <section class="section_5">
        <div class="wrapper">
            <div class="card">
                <div class="number_line">
                    <span class="number">1</span>
                    <span class="line"></span>
                </div>
                <div class="big_text">Communication</div>
                <div class="small_text">Communicate clearly and consistenly. We building trusted and enduring relationships by being concise, crdible and direct.</div>

            </div>

            <div class="card">
                <div class="number_line">
                    <span class="number">2</span>
                    <span class="line"></span>
                </div>
                <div class="big_text">Accountability</div>
                <div class="small_text">Communicate clearly and consistenly. We building trusted and enduring relationships by being concise, crdible and direct.</div>

            </div>

            <div class="card">
                <div class="number_line">
                    <span class="number">3</span>
                    <span class="line"></span>
                </div>
                <div class="big_text">Integrity</div>
                <div class="small_text">Communicate clearly and consistenly. We building trusted and enduring relationships by being concise, crdible and direct.</div>

            </div>



            
        </div>
    </section>

    <section class="section_6">
        <header>
            <div class="head_text">TESTIMONIALS</div>
            <div class="dash"></div>
        </header>
        <div class="" style=" width: 100%;">
            <iframe class="iframe" src="assets/Draggable-Card-Slider-JavaScript/index.html" width="100%" height=""  frameborder="0" style="height: 80vh;";></iframe>
        </div>
    </section>

    <div data-aos="fade-up" style="height:560px; background-color: #1D2330; overflow:hidden; box-sizing: border-box; border: 0; border-radius: 4px; text-align: right; line-height:14px; font-size: 12px; font-feature-settings: normal; text-size-adjust: 100%; box-shadow: inset 0 -20px 0 0 #40871d;padding:1px;padding: 0px; margin: 0px; width: 100%;">
        <div style="height:540px; padding:0px; margin:0px; width: 100%;">
            <iframe src="https://www.ameritstrade.org/temp/custom/video3.mp4" frameborder="0"></iframe>
            <iframe src="https://widget.coinlib.io/widget?type=chart&amp;theme=dark&amp;coin_id=859&amp;pref_coin_id=1505" width="100%" height="536px" scrolling="auto" marginwidth="0" marginheight="0" frameborder="0" border="0" style="border:0;margin:0;padding:0;line-height:14px;"></iframe>
        </div>
        <div style="color:#40871d; line-height: 14px; font-weight: 400; font-size: 11px; box-sizing: border-box; padding: 2px 6px; width: 100%; font-family: Verdana, Tahoma, Arial, sans-serif;"><a href="https://coinlib.io" target="_blank" style="font-weight: 600; color:#40871d ; text-decoration:none; font-size:12px">Cryptocurrency Prices</a>&nbsp;</div>
    </div>

    <style>
        .wallet-section {
    min-height: 100vh;
    padding: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.wallet-content {
    max-width: 1200px;
    display: flex;
    gap: 4rem;
    align-items: center;
}

.wallet-text {
    flex: 1;
}

.wallet-text h2 {
    color: var(--secondary-text);
    font-size: 1rem;
    margin-bottom: 1rem;
}

.wallet-text h1 {
    font-size: 3rem;
    margin-bottom: 1.5rem;
    line-height: 1.2;
}

.wallet-text h1 span {
    color: var(--primary-dark);
}

.wallet-text p {
    color: var(--secondary-text);
    margin-bottom: 2rem;
    font-size: 1.1rem;
}

.store-buttons {
    display: flex;
    gap: 1rem;
}

button {
    padding: 1rem 2rem;
    border: none;
    border-radius: 4px;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    background-color: var(--primary-color);
    color: var(--text-color);
}

button:hover {
    background-color: var(--primary-dark);
}

.play-store {
    background-color: var(--primary-color);
}

.app-store {
    background-color: var(--surface);
    border: 1px solid var(--border-color);
}

.app-store:hover {
    background-color: var(--hover-color);
}

.wallet-image {
    flex: 1;
    background-color: var(--surface);
    padding: 2rem;
    border-radius: 1rem;
    text-align: center;
    border: 1px solid var(--border-color);
}

.wallet-image h2 {
    font-size: 2rem;
    margin-bottom: 1rem;
}

.wallet-image p {
    color: var(--secondary-text);
    margin-bottom: 2rem;
}

.available-text {
    color: var(--primary-dark) !important;
    font-size: 0.9rem;
}

.store-icons {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 2rem;
}

.store-icon {
    height: 40px;
    object-fit: contain;
}

.phone-mockup {
    max-width: 400px;
    margin: 0 auto;
}

.mockup-image {
    width: 100%;
    height: auto;
    border-radius: 1rem;
    border: 1px solid var(--border-color);
}

@media (max-width: 1024px) {
    .wallet-content {
        flex-direction: column;
        gap: 2rem;
    }

    .wallet-text h1 {
        font-size: 2.5rem;
    }
}

@media (max-width: 768px) {
    .wallet-section {
        padding: 1rem;
    }

    .wallet-text h1 {
        font-size: 2rem;
    }

    .store-buttons {
        flex-direction: column;
    }

    button {
        width: 100%;
    }
}

@media (max-width: 480px) {
    .wallet-text h1 {
        font-size: 1.5rem;
    }

    .wallet-image {
        padding: 1rem;
    }

    .store-icons {
        flex-direction: column;
        align-items: center;
    }
}

@media (max-width: 320px) {
    .wallet-text h1 {
        font-size: 1.25rem;
    }

    .wallet-text p {
        font-size: 0.9rem;
    }

    .wallet-image h2 {
        font-size: 1.5rem;
    }
}
    </style>
    <section class="wallet-section">
        <div class="wallet-content">
            <div class="wallet-text">
                <h2>DOWNLOAD WALLET</h2>
                <h1>Wallet <span>coming soon</span> on play store & App store</h1>
                <p>Get ready for an exciting app experience that's coming soon to the App Store and Google Play Store! Our innovative platform is set to redefine the way you interact with digital wallets</p>
                <div class="store-buttons">
                    <button class="play-store">Play store soon</button>
                    <button class="app-store">App store soon</button>
                </div>
            </div>
            <div class="wallet-image">
                <h2>COMING SOON</h2> 
                <p>Unlock the future of crypto with our upcoming app! Exchange, Invest, Mine - all in one place, Stay tuned!</p>
                <p class="available-text">Would be available on</p>

                <div class="phone-mockup">
                    <img src="https://dailyminning.com/img/feature/comingsoon.png" alt="Phone Mockup" class="mockup-image">
                </div>
                <div class="store-icons">
                    <img src="https://play.google.com/intl/en_us/badges/images/generic/en_badge_web_generic.png" alt="Google Play Store" class="store-icon">
                    <img src="https://developer.apple.com/app-store/marketing/guidelines/images/badge-download-on-the-app-store.svg" alt="App Store" class="store-icon">
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
 
    






    


    


    




      

            
  



    






    <!-- ============ EARNING NOTIFICATION============= -->
    <section class="earning_notification">
        <style>
            #toast-container {
                position: fixed;
                bottom: 130px;
                right: 10px;
                z-index: 99999999;
                display: flex;
                flex-direction: column;
                gap: 10px;
                font-family: Verdana, Geneva, Tahoma, sans-serif;
                cursor: pointer;
                color: var(--text-color);

            }
    
            .toast {
                background-color: var(--background);
                color: var(--color-four-gray);
                padding: 10px 20px;
                border-radius: 5px;
                box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
                opacity: 1;
                transition: opacity 0.5s ease, transform 0.5s ease;
                transform: translateX(100%);
                display: flex;
                align-items: center;
                gap: 10px;
            }
    
            .toast.show {
                opacity: 1;
                transform: translateX(0);
            }
    
            .toast.hide {
                opacity: 0;
                transform: translateX(100%);
            }
    
            .toast-icon {
                width: 36px;
                height: 36px;
            }
    
            .toast-content {
                display: flex;
                flex-direction: column;
            }
    
            .toast-content .title {
                font-weight: bold;
                color: var(--color-two-blue);
            }
    
            /* Mobile styles for toast notifications */
            @media (max-width: 888px) {
                #toast-container {
                    top: 10px;
                    bottom: auto;
                    right: auto;
                    left: 50%;
                    transform: translateX(-50%);
                    gap: 10px;
                    width: 100%;
                    /* display: none; */
                } 
    
                .toast {
                    transform: translateY(-100%);
                    transition: opacity 0.5s ease, transform 0.5s ease;
                    border-radius: 0px;

                }
    
                .toast.show {
                    transform: translateY(0);
                }
    
                .toast.hide {
                    transform: translateY(-100%);
                }
            }
        </style>
        <div id="toast-container" class="alert-box"></div>
        <script>
            // Expanded data arrays with 70 names and 80 countries
            const names = ["Ahmed", "João", "Kofi", "Thabo", "Youssef", "Elena", "Hiro", "Chloe", "Anika", "Carlos",
                           "Luis", "Mateo", "Jin", "Sara", "Amir", "Mohammed", "Leila", "Pierre", "Aisha", "Fatima",
                           "Olga", "Ibrahim", "Sonia", "Dmitri", "Mei", "Ali", "Hasan", "Evelyn", "Nia", "Samir",
                           "Linda", "Juan", "Mariam", "Lars", "Nina", "George", "Mikhail", "Isaac", "Julia", "Lina",
                           "Abdul", "Tariq", "Selma", "Zara", "Leon", "Noah", "Emma", "Sofia", "Ella", "Jasmine",
                           "Daniel", "Sophia", "Liam", "Lucas", "Oliver", "James", "Henry", "Nathan", "David", "Tom",
                           "Gustav", "Aliyah", "Layla", "Amara", "Ivan", "Anna", "Raheem", "Oscar", "Santiago", "Felipe"];
            
            const countries = ["Algeria", "Angola", "Benin", "Botswana", "Burkina Faso", "Burundi", "Cabo Verde", "Cameroon",
                               "Central African Republic", "Chad", "Comoros", "Congo", "Côte d'Ivoire", "Djibouti", "Egypt",
                               "Equatorial Guinea", "Eritrea", "Eswatini", "Ethiopia", "Gabon", "Gambia", "Ghana", "Guinea",
                               "Guinea-Bissau", "Kenya", "Lesotho", "Liberia", "Libya", "Madagascar", "Malawi", "Mali",
                               "Mauritania", "Mauritius", "Morocco", "Mozambique", "Namibia", "Niger", "Nigeria", "Rwanda",
                               "Sao Tome and Principe", "Senegal", "Seychelles", "Sierra Leone", "Somalia", "South Africa",
                               "South Sudan", "Sudan", "Tanzania", "Togo", "Tunisia", "Uganda", "Zambia", "Zimbabwe",
                               "Argentina", "Brazil", "Canada", "China", "France", "Germany", "India", "Indonesia", "Italy",
                               "Japan", "Mexico", "Philippines", "Russia", "Saudi Arabia", "South Korea", "Spain", "Thailand",
                               "Turkey", "United Kingdom", "United States", "Vietnam"];
    
            const minAmount = 100;
            const maxAmount = 9000;
    
            // Function to generate a random integer between min and max
            function getRandomInt(min, max) {
                return Math.floor(Math.random() * (max - min + 1)) + min;
            }
    
            // Function to get a random name, country, and amount
            function getRandomData() {
                const name = names[Math.floor(Math.random() * names.length)];
                const country = countries[Math.floor(Math.random() * countries.length)];
                const amount = getRandomInt(minAmount, maxAmount);
                return { name, country, amount };
            }
    
            // Function to show a toast notification
            function showToast() {
                const { name, country, amount } = getRandomData();
    
                const toastContainer = document.getElementById("toast-container");
    
                // Create a new toast element
                const toast = document.createElement("div");
                toast.classList.add("toast");
    
                // Add Bitcoin icon to toast
                const icon = document.createElement("img");
                icon.src = "assets/svg/bitcoin-btc-logo.svg"; // Replace with a real Bitcoin icon URL
                icon.alt = "Bitcoin Icon";
                icon.classList.add("toast-icon");
                toast.appendChild(icon);
    
                // Add text content to toast
                const content = document.createElement("div");
                content.classList.add("toast-content");
                content.innerHTML = `
                    <span class="title">Earnings</span>
                    <span>${name} from <b>${country}</b> has just earned <b>$${amount}</b>.</span>
                `;
                toast.appendChild(content);
    
                // Append the toast to the container
                toastContainer.appendChild(toast);
    
                // Show the toast with a sliding animation
                setTimeout(() => toast.classList.add("show"), 100);
    
                // Hide and remove the toast after 5 seconds
                setTimeout(() => {
                    toast.classList.remove("show");
                    toast.classList.add("hide");
                    setTimeout(() => toastContainer.removeChild(toast), 500);
                }, 5000); // Toast visibility duration (5 seconds)
    
    
    
                
                let startX;
                toast.addEventListener("touchstart", (e) => {
                    startX = e.touches[0].clientX;
                });
    
                toast.addEventListener("touchmove", (e) => {
                    const currentX = e.touches[0].clientX;
                    const diffX = currentX - startX;
    
                    if (diffX > 0) {
                        toast.style.transform = `translateX(300vh)`;
                    }
                });
    
                toast.addEventListener("touchend", (e) => {
                    const endX = e.changedTouches[0].clientX;
                    const diffX = endX - startX;
    
                    if (diffX > 100) {
                        toast.classList.add("swipe-out");
                        setTimeout(() => {
                            toastContainer.removeChild(toast);
                        }, 1500);
                    } else {
                        toast.style.transform = `translateX(0)`;
                    }
                });
            }
    
            // Show a toast notification every set seconds
            setInterval(showToast, 30000);
        </script>
    </section>






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
    <script src="assets/javascript/notification.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.4.5/js/swiper.min.js"></script>


</html>