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
      <link rel="stylesheet" href="assets/css/main.css">
      <link rel="stylesheet" href="assets/css/style.css">
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
      
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
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


                        <li class=""><span><i class="material-icons notification-icon">notifications_none</i></sp>
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
            

        <?php
        
             include 'dashboard_logic.php'             
        
        ?>

    
        
            
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
          <div class="wrapper">
              <section class="quick_actions_section">
                <div class="wrapper">

                  <div class="users_balance_section">
                      <div>
                          <span>Wallet <i class="material-icons">keyboard_arrow_down</i></span>
                          <span id="amount" class="user-balance scramble-text">$<?php echo number_format($balance, 2); ?></span>

                          <script>
                            function scrambleText(element, originalText, steps, interval) {
                              const characters = '0123456789$,.'; 
                              let scrambled = originalText.split('');
                              
                              let step = 0;
                              const scrambleInterval = setInterval(() => {
                                step++;
                                scrambled = scrambled.map((char, i) => 
                                  Math.random() < 0.5 && step < steps ? characters.charAt(Math.floor(Math.random() * characters.length)) : originalText[i]
                                );
                                element.textContent = scrambled.join('');
                        
                                if (step >= steps) {
                                  clearInterval(scrambleInterval);
                                  element.textContent = originalText; // Restore original text
                                }
                              }, interval);
                            }
                        
                            const span = document.querySelector('#amount');
                            const originalText = '$<?php echo number_format($balance, 2); ?>';
                        
                            // Run the animation once on page load
                            scrambleText(span, originalText, 15, 100); // 15 steps, 100ms per step
                        
                            // Call the scrambleText function every 4 seconds after the initial run
                            setInterval(() => {
                              scrambleText(span, originalText, 15, 100);
                            }, 4000); // 4 seconds interval
                          </script>
                        </body>
                      </div>
                  </div>

                  <div class="action_cards">
                      <div class="wrapper">
                          <div class="card">
                              <a href="admin_send.php">
                                  <span><i class="material-icons">arrow_upward</i></span>
                                  <span>Send</span>
                              </a>
                          </div>
                          <div class="card">
                              <a href="admin_deposit.php">
                                  <span><i class="material-icons">arrow_downward</i></span>
                                  <span>Deposit</span>
                              </a>
                          </div>
                          <div class="card">
                              <a href="admin_features.php">
                                  <span><i class="material-icons">sell</i></span>
                                  <span>Sell</span>
                              </a>
                          </div>
                          <div class="card">
                              <a href="admin_swap.php">
                                  <span><i class="material-icons">swap_calls</i></span>
                                  <span>Convert</span>
                              </a>
                          </div>
                          <div class="card">
                               <a href="users.php">
                                    <i class="fa fa-user-o"></i>
                                    <span>Users</span>
                               </a>
                          </div>
                          <div class="card">
                              <a href="admin_history.php">
                                  <span><i class="material-icons">history</i></span>
                                  <span>History</span>
                              </a>
                          </div>
                      </div>
                  </div>

                  <div class="quick_actions_minimized">
                    <div class="wrapper">
                      <ul>
                          <li>
                              <a href="admin_send.php">
                                <span><i class="material-icons">arrow_upward</i></span>
                                <span>Send</span>
                              </a>
                          </li>
                      </ul>
          
                      <ul>
                          <li>
                              <a href="admin_deposit.php">
                                <span><i class="material-icons">arrow_downward</i></span>
                                <span>Deposit</span>
                              </a>
                          </li>
                      </ul>
          
                      <ul>
                          <li>
                              <a href="admin_features.php">
                                <span><i class="material-icons">sell</i></span>
                                <span>Sell</span>
                              </a>
                          </li>
                      </ul>
          
                      <ul>
                          <li>
                              <a href="admin_swap.php">
                                  <span><i class="material-icons">swap_calls</i></span>
                                  <span>Convert</span>
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
                    </div>
                  </div>

                </div>
              </section>
            <?php
                
                include 'wallet.php';

            ?>

              
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
    <script src="assets/user/javascript/function.js"></script>



