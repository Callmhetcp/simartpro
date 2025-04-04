<?php

ini_set('session.cookie_lifetime', 0);
ini_set('session.gc_maxlifetime', 0);
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_lname = $_SESSION['user_lastname'] ;
$email = $_SESSION['email'] ;


if (!isset($_SESSION['notifications'])) {
  $_SESSION['notifications'] = [];
}

function addLoginNotification($userName) {
  $message = "Login successful for user: " . htmlspecialchars($userName);
  $_SESSION['notifications'][] = $message;
}

addLoginNotification($user_lname);

// Display notifications
?>
<?php
include 'access_control.php';
checkAdminAccess(); // Ensure only admins can access this page

// The rest of the admin dashboard code goes here
?>

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
        <!-- <link rel="stylesheet" href="assets/css/main.css"> -->
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/swap.css">
        <link rel="stylesheet" href="assets/css/table-wallet.css">
        <link rel="stylesheet" href="assets/css/mediaquery.css">
        <link rel="stylesheet" href="assets/css/main-mediaquery.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.4.5/css/swiper.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    
    
    
        <!-- ============FONT-AWESOME-LINKS============= -->
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


        <noscript> Powered by <a href=“https://www.smartsupp.com” target=“_blank”>Smartsupp</a></noscript>
    </head>
    <style>
        html{
          animation: none;
        }
        .tradingview-widget-container{
            width: auto;
            height: auto;
            position: relative;
            bottom: auto;
            z-index: auto;
        }

        .main_content{
            margin-bottom: 70px;

        }
        @media (max-width: 768px) {
            .main_content{
                margin-bottom: 200px;
            }
        }
  
    </style>

<body>
    
<header class="dashboard_header">
          <div class="wrapper">
                    <div class="logo">
                    <div class="image_wrapper">
                        <img src="assets/images/logo.png" width="42" height="42" alt="">
                    </div>
                    </div>
                    
                    <div class="icons">
                    <ul>
                       
                        <h4 style="color: white;"><?php echo htmlspecialchars($user_lname); ?>
                        <span class="login-status"></span>
                        </h4>

                        <div>
                            <?php include("google_translator.php") ?>
                            <img  style="cursor: pointer;" onclick="openTranslator()" width="23" src="https://th.bing.com/th/id/R.41d2ce8e8a978b24248ac44af2322f65?rik=gj58ngXoj7iaIw&pid=ImgRaw&r=0" alt="">
                        </div>
                        <li class=""><a href="#"><i class="material-icons notification-icon">notifications_none</i></a>
                            <div class="notification_box">
                                <div class="wrapper">
                                <header>
                                    <span>Notifications</span>
                                    <a href="#" id="clearAll">Clear All</a>
                                </header>

                                <ul id="notificationList">
                                    <!-- Notifications will be dynamically loaded here -->
                                </ul>

                                <div class="view_all">
                                    <a href="#" id="viewToggleLink" style="display: none;">View All</a>
                                </div>



                        <li><a><i class="material-icons account-icon">account_circle</i></a>
                            <div class="profile_box">
                                <ul>
                                    <li>
                                        <a href="admin_profile.php">
                                            <i class="material-icons">person_outline</i>
                                            <span>Profile </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="admin_wallet_page.php">
                                            <i class="material-icons">account_balance_wallet</i>
                                            <span>Wallet</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="logout.php">
                                            <i class="material-icons">logout</i>
                                            <span>Logout</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            
                        </li>
                     

                        
                    </ul>
                    </div>
                </div>

          <script>
    // Fetch notifications when the page loads
    document.addEventListener('DOMContentLoaded', function() {
        fetchNotifications();
    });

    let allNotifications = []; // To store all notifications
    let showAll = false; // Flag to track whether to show all notifications or not

    // Function to fetch notifications
    function fetchNotifications() {
        fetch('fetch_notifications.php') // PHP file to fetch notifications from the database
            .then(response => response.json())
            .then(data => {
                const notificationList = document.getElementById('notificationList');
                notificationList.innerHTML = ''; // Clear previous notifications
                allNotifications = data.notifications || [];

                // If there are no notifications, display "No notifications"
                if (allNotifications.length === 0) {
                    notificationList.innerHTML = '<li>No notifications</li>';
                } else {
                    // Display notifications based on whether we're showing all or not
                    const notificationsToDisplay = showAll ? allNotifications : allNotifications.slice(0, 3);
                    
                    // Loop through the notifications to append them
                    notificationsToDisplay.forEach(notification => {
                        const li = document.createElement('li');
                        li.innerHTML = `
                            <a href="#">
                                <i class="fa fa-user"></i>
                                <span>${notification.message}</span> <!-- Display the message -->
                            </a>
                        `;
                        notificationList.appendChild(li);
                    });

                    // Toggle the "View All" and "View Less" link visibility and text
                    const viewToggleLink = document.getElementById('viewToggleLink');
                    if (allNotifications.length === 3) {
                        viewToggleLink.style.display = 'block';
                        viewToggleLink.textContent = 'View All';
                    } else if (allNotifications.length > 3) {
                        viewToggleLink.style.display = 'block';
                        viewToggleLink.textContent = showAll ? 'View Less' : 'View All';
                    } else {
                        viewToggleLink.style.display = 'block'; // Hide button if there are 3 or fewer notifications
                    }

                    // Make the container scrollable if there are more than 5 notifications
                    if (allNotifications.length > 5) {
                        document.querySelector('.notification-container').style.maxHeight = '300px';
                        document.querySelector('.notification-container').style.overflowY = 'auto'; // Enable scrolling
                    }
                }
            })
            .catch(error => console.error('Error fetching notifications:', error));
    }

    // Handle the toggle between "View All" and "View Less"
    document.getElementById('viewToggleLink').addEventListener('click', function(e) {
        e.preventDefault(); // Prevent default link behavior
        showAll = !showAll; // Toggle the showAll flag
        fetchNotifications(); // Reload notifications based on the new state
    });

    // Mark notifications as read when the user clicks 'Clear All'
    document.getElementById('clearAll').addEventListener('click', function() {
        fetch('clear_notifications.php', { method: 'POST' })
            .then(response => response.text())
            .then(data => {
                // Refresh the notification list after clearing
                fetchNotifications();
            })
            .catch(error => console.error('Error clearing notifications:', error));
    });
</script>


        <!-- ============ CRYPTO STICKER ============= //--AT THE TOP, BELOW THE NAV BAR--//-->

<style>

.ticker-container {
    width: 100%;
    overflow: hidden;
    background-color: var(--base-clr);
    padding: 12px 0;
    margin-top: 25px;

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
    color: var(--secondary-text-clr);
    margin: 0 8px;
}

.crypto-price {
    margin-right: 8px;
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



      </header>



    
        
            
      <aside class="sidebar">
        <div class="wrapper">


            <div class="sidebar_menu">
                <ul>
                    <li>
                        <a href="admin_dashboard.php">
                            <i class="material-icons">dashboard</i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="admin_swap.php">
                            <i class="material-icons">swap_calls</i>
                            <span>Convert</span>
                        </a>
                    </li>

                    <li>
                        <a href="users.php">
                            <i class="fa fa-user-o"></i>
                            <span>Users</span>
                        </a>
                    </li>

                    <li>
                        <a href="admin_history.php">
                            <i class="material-icons">history</i>
                            <span>History</span>
                        </a>
                    </li>
                    <li>
                        <a href="admin_features.php">
                            <i class="material-icons">widgets</i>
                            <span>Investments</span>
                        </a>
                    </li>
                    <li>
                        <a href="admin_market.php">
                            <i class="material-icons">store</i>
                            <span>Market</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="sidebar_widgets">
            <div class="wrapper">
                <div class="image">
                <img src="assets/images/crypto-join.png" alt="">
                </div>
                <div class="text">
                <h3>Invest Now!</h3>
                <a href="">
                    Buy and Sell Coins
                </a>
                <br><br>
                </div>
            </div>
            </div>
        </div>
      </aside>


      <main class="main_content">
        <div class="location_badge">
            <div class="wrapper"></div>
        </div>
        <section class="content">
            <div class="exchange-container">
                <form class="exchange-calculator">
                    <div id="error" class="error_message"> error!</div>
                    <div class="input-group">
                        <label class="input-label">You Pay</label>
                        <input type="text" class="form-control" placeholder="0.00"  id="input-amount">
                        <div class="crypto-select">
                            <button type="button" class="select-btn select-btn1" data-dropdown="from">
                                <span>Select Crypto</span>
                            </button>
                        </div>
                    </div>
    
                    <div class="equals-sign">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M7 13L17 13M7 17L17 17" stroke="white" stroke-linecap="round"/>
                        </svg>
                    </div>
    
                    <div class="input-group">
                        <label class="input-label">You Receive</label>
                        <input type="text" class="form-control" placeholder="0.00" disabled id="recieve-amount">
                        <div class="crypto-select">
                            <button type="button" class="select-btn select-btn2" data-dropdown="to">
                                <span>Select Crypto</span>
                            </button>
                        </div>
                    </div>
    
                    <div  class="exchange-btn" id="exchange-btn">Exchange Now</div>
                </form>
            </div>

            <style>
                .widget_wrapper {
                    display: grid;
                    grid-template-columns: repeat(4, 1fr);
                    gap: 20px;
                    padding: 20px;
                    background-color: var( --surface);
                    border-radius: var(--border-radius);
                }
                .widget-card {
                    border-radius: 8px;
                    overflow: hidden;
                    background: rgba(255, 255, 255, 0.05);

                }
                .tradingview-widget-copyright {
                    font-size: 13px !important;
                    line-height: 32px !important;
                    text-align: center !important;
                    vertical-align: middle !important;
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
                @media (max-width: 1200px) {
                    .widget_wrapper {
                        grid-template-columns: repeat(3, 1fr);
                    }
                }
                @media (max-width: 900px) {
                    .widget_wrapper {
                        grid-template-columns: repeat(2, 1fr);
                    }
                }
                @media (max-width: 600px) {
                    .widget_wrapper {
                        grid-template-columns: 1fr;
                    }
                }
            </style>
            </style>
            <div id="widgetWrapper" class="widget_wrapper"></div>

            <script>
                const widgets = [
                    { symbol: "BITSTAMP:BTCUSD", name: "BTC/USD" },
                    { symbol: "BITSTAMP:ETHUSD", name: "ETH/USD" },
                    { symbol: "BINANCE:LTCUSDT", name: "LTC/USDT" },
                    { symbol: "BINANCE:XRPUSDT", name: "XRP/USDT" },
                    { symbol: "BITMEX:XBTUSD", name: "XBT/USD" },
                    { symbol: "KRAKEN:DOTUSD", name: "DOT/USD" },
                    { symbol: "BITTREX:DOGEUSD", name: "DOGE/USD" },
                    { symbol: "BITFINEX:XRPUSD", name: "XRP/USD" }
                ];

                const widgetWrapper = document.getElementById('widgetWrapper');

                widgets.forEach(widget => {
                    const widgetCard = document.createElement('div');
                    widgetCard.className = 'widget-card';
                    widgetCard.innerHTML = `
                        <div class="tradingview-widget-container" style="width: 100%; height: 126px;">
                            <iframe scrolling="no" allowtransparency="true" frameborder="0" 
                                src="https://www.tradingview-widget.com/embed-widget/single-quote/?locale=in#%7B%22symbol%22%3A%22${widget.symbol}%22%2C%22width%22%3A%22100%25%22%2C%22colorTheme%22%3A%22dark%22%2C%22isTransparent%22%3Atrue%2C%22height%22%3A126%2C%22utm_source%22%3A%22example.com%22%2C%22utm_medium%22%3A%22widget_new%22%2C%22utm_campaign%22%3A%22single-quote%22%2C%22page-uri%22%3A%22example.com%2Fpage%22%7D" 
                                style="box-sizing: border-box; height: calc(126px - 32px); width: 100%;">
                            </iframe>
                            <div class="tradingview-widget-copyright">
                                <a href="https://www.tradingview.com/symbols/${widget.symbol}/" rel="noopener" target="_blank">
                                    <span class="blue-text">${widget.name} Rates</span>
                                </a> by TradingView
                            </div>
                        </div>
                    `;
                    widgetWrapper.appendChild(widgetCard);
                });
            </script>
        </section>
    
        <div class="overlay"></div>
        <div class="dropdown-menu">
            <div class="dropdown-header">Select Currency</div>
            <!-- Dropdown items will be dynamically inserted here -->
        </div>
        
        
      </main>

      
      <footer class="dashboard_footer">
        <div class="wrapper">
          <span>© 2020 <a href="index.php">Simart Pro</a>All Right Reserved</span>
          <span><a href="#">Purchase Now</a></span>
        </div>
      </footer>

      <section class="bottom_nav">
        <div class="wrapper">
            <ul>
                <li>
                    <a href="admin_dashboard.php">
                        <i class="material-icons">dashboard</i>
                        <span>Home</span>
                    </a>
                </li>
            </ul>

            <ul>
                <li>
                    <a href="admin_swap.php">
                        <i class="material-icons">swap_calls</i>
                        <span>Convert</span>
                    </a>
                </li>
            </ul>

            <ul>
                <li>
                    <a href="users.php">
                        <i class="fa fa-user-o"></i>
                        <span>Users</span>
                    </a>
                </li>
            </ul>

            <ul>
                <li>
                    <a href="admin_history.php">
                        <i class="material-icons">history</i>
                        <span>History</span>
                    </a>
                </li>
            </ul>

            <ul>
                <li>
                    <a href="admin_features.php">
                        <i class="material-icons">widgets</i>
                        <span>Investments</span>
                    </a>
                </li>
            </ul>

            <ul>
                <li>
                    <a href="admin_market.php">
                        <i class="material-icons">store</i>
                        <span>Market</span>
                    </a>
                </li>
            </ul>
        </div>
      </section>


 
    <!-- ============JAVASCRIPT-LINKS============= -->
    <script src="assets/user/javascript/popup.js"></script>
    <script src="assets/user/javascript/swap.js"></script>
    <script src="assets/javascript/active-tab.js"></script>
</body>
</html>

