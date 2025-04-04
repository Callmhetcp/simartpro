<?php


            
// include 'session_handler.php';
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
        <link rel="stylesheet" href="assets/css/swap.css">
        <link rel="stylesheet" href="assets/css/history.css">
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
        .tradingview-widget-container{
            width: auto;
            height: auto;
            position: relative;
            bottom: auto;
            z-index: auto;
        }

        .main_content{
            margin-top: 8rem;
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

      <?php

        include 'admin_confirm_decline.php'                  

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

            <div class="app-container">
                <header class="app-header">
                    <h1>Latest Transactions</h1>



                    <!-- APPEARS ONLY ON ADMIN ACCOUNT -->
                    <div class="dropdown">
                        <button class="dropdown-button">Sort</button>
                        <div class="dropdown-menu">
                            <button type="submit" class="dropdown-item">All</button>
                            <button type="submit" class="dropdown-item">Pending</button>
                            <button type="submit" class="dropdown-item">Withdrawal</button>
                            <button type="submit" class="dropdown-item">Deposit</button>
                            <button type="submit" class="dropdown-item">Default</button>
                        </div>
                    </div>



                    
                </header>

                <div class="transactions">
                    
                  <?php
                  
                  displayTransactions();
                  ?>          
                          
                </div>
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
    



      <!-- CONFIRM / DECLINE TRASACTION  (POP-UP BOX)-->
      <!-- <section class="confirm_decline">
        <div class="bg_overlay">
            <div class="popup_box">
            <div class="wrapper">
                <header>
                <span>
                    Confirm/Decline   
                    <samp class="firstname"></samp>
                    <samp class="lastname"></samp>
                    transaction
                </span>
                <i class="material-icons close_confirm_decline">close</i>
                </header>
                <main class="question">
                <span>Are you sure you want to confirm/decline this transaction?</span>
                </main>
                <footer class="confirm_decline_buttons">
                <div class="wrapper">
                    <button id="close" class="close" type="button">Close</button>
                    <button onclick="confirmTransaction()" name="confirm" id="confirm" class="btn confirm" type="button">Confirm</button>
                    <button onclick="declineTransaction()" name="decline" id="decline" class="btn decline" type="button">Decline</button>
                    
                </div>
                </footer>
            </div>
            </div>
        </div>
        <div class="toast-container" id="toastContainer"></div>
        </section> -->

     
        <script>
    document.addEventListener('DOMContentLoaded', function () {
    const popupTriggers = document.querySelectorAll('.popup_trigger');
    const confirmDecline = document.querySelector('.confirm_decline');
    const popupBox = document.querySelector('.popup_box');
    const closeButtons = document.querySelectorAll('.close_confirm_decline, #close');
    const toastContainer = document.getElementById('toastContainer');

    let currentTransactionId = null;

    // Open popup on button click
    popupTriggers.forEach(trigger => {
        trigger.addEventListener('click', function () {
            const status = this.getAttribute('data-status').trim().toLowerCase();
            currentTransactionId = this.getAttribute('data-transaction-id');
            const firstname = this.getAttribute('data-firstname');
            const lastname = this.getAttribute('data-lastname');

            if (status === 'pending') {
                confirmDecline.querySelector('.firstname').textContent = firstname + " ";
                confirmDecline.querySelector('.lastname').textContent = lastname + " ";
                confirmDecline.style.visibility = 'visible';
                confirmDecline.style.opacity = '1';
                popupBox.style.opacity = '1';
                popupBox.style.transform = 'translateY(0)';
            } else {
                alert('This transaction cannot be confirmed or declined because it is not pending.');
            }
        });
    });

    // Close popup on button click
    closeButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            confirmDecline.style.visibility = 'hidden';
            confirmDecline.style.opacity = '0';
            popupBox.style.opacity = '0';
            popupBox.style.transform = 'translateY(-90%)';
        });
    });

    // Show toast message
    function showToast(type, message) {
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.innerHTML = `
            <div class="toast-icon">${type === 'success' ? '✓' : '✕'}</div>
            <div class="toast-content">
                <div class="toast-title">${type === 'success' ? 'Success' : 'Error'}</div>
                <div class="toast-message">${message}</div>
            </div>
            <button class="close-btn" onclick="this.parentElement.remove()">×</button>
        `;
        toastContainer.appendChild(toast);
        setTimeout(() => toast.remove(), 4000);
    }

    // Confirm transaction
    window.confirmTransaction = function () {
        
        if (!currentTransactionId) return showToast('error', 'No transaction selected.');

        fetch('admin_confirm_decline.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ transaction_id: currentTransactionId, action: 'confirm' })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showToast('success', 'Transaction confirmed successfully.');
                const transactionCard = document.querySelector(`[data-transaction-id="${currentTransactionId}"]`);
                if (transactionCard) {
                    const statusBadge = transactionCard.querySelector('.status-badge');
                    statusBadge.textContent = 'Completed';
                }
            } else {
                showToast('error', data.message || 'Failed to confirm transaction.');
            }
        })
        .catch(() => showToast('error', 'An error occurred while confirming the transaction.'))
        .finally(() => closePopup());
    };

    // Decline transaction
    window.declineTransaction = function () {
        if (!currentTransactionId) return showToast('error', 'No transaction selected.');

        fetch('admin_confirm_decline.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ transaction_id: currentTransactionId, action: 'decline' })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showToast('success', 'Transaction declined successfully.');
                const transactionCard = document.querySelector(`[data-transaction-id="${currentTransactionId}"]`);
                if (transactionCard) {
                    const statusBadge = transactionCard.querySelector('.status-badge');
                    statusBadge.textContent = 'Failed';
                }
            } else {
                showToast('error', data.message || 'Failed to decline transaction.');
            }
        })
        .catch(() => showToast('error', 'An error occurred while declining the transaction.'))
        .finally(() => closePopup());
    };

    // Close popup helper
    function closePopup() {
        confirmDecline.style.visibility = 'hidden';
        confirmDecline.style.opacity = '0';
        popupBox.style.opacity = '0';
        popupBox.style.transform = 'translateY(-90%)';
    }
});

</script>
</body>
<script src="assets/user/javascript/popup.js"></script>
<script src="assets/user/javascript/function.js"></script>

</html>

<svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" width="708" height="555.86743" viewBox="0 0 708 555.86743" xmlns:xlink="http://www.w3.org/1999/xlink"><path id="b10fb2cf-c586-4c5f-9fbf-e678f5ffa3db-37" data-name="Path 133" d="M890.46523,679.51478a211.72219,211.72219,0,0,1-46.19649,37.27045c-.39154.24069-.7897.4667-1.18925.70031l-27.639-24.46263c.29035-.26957.61188-.57235.95806-.90494C836.99246,672.563,939.22932,535.83823,946.042,502.54351,945.57186,505.31735,952.18923,614.09419,890.46523,679.51478Z" transform="translate(-246 -172.06628)" fill="#f0f0f0"/><path id="a32c10c7-75df-4179-a648-6a8d2a687209-38" data-name="Path 134" d="M849.6017,721.5053c-.52265.12466-1.0544.24137-1.58764.34772l-20.7355-18.35251c.40524-.14119.87883-.30927,1.42046-.49568,8.89662-3.15026,35.39436-12.66026,61.76413-23.49189,28.33447-11.64369,56.53311-24.79986,62.59765-33.227C951.75986,648.244,911.68646,707.62224,849.6017,721.5053Z" transform="translate(-246 -172.06628)" fill="#f0f0f0"/><path d="M890.08181,317.64639h-2.95289V236.75278a46.819,46.819,0,0,0-46.819-46.81906H668.92579a46.819,46.819,0,0,0-46.81911,46.81891v443.7888a46.819,46.819,0,0,0,46.819,46.81906H840.30972a46.819,46.819,0,0,0,46.81915-46.81888V375.22785h2.95294Z" transform="translate(-246 -172.06628)" fill="#383838"/><path d="M877.1627,237.07439V680.21716a34.95659,34.95659,0,0,1-34.9693,34.95674H669.98426a34.95435,34.95435,0,0,1-34.957-34.95674V237.07439a34.95435,34.95435,0,0,1,34.957-34.95674h20.89839a16.61888,16.61888,0,0,0,15.38341,22.87963h98.18146a16.60126,16.60126,0,0,0,15.384-22.87963H842.1934A34.95659,34.95659,0,0,1,877.1627,237.07439Z" transform="translate(-246 -172.06628)" fill="#fff"/><path d="M823.59459,467.3551H672.22789a10.0113,10.0113,0,0,1-10-10v-4.97754a10.0113,10.0113,0,0,1,10-10h151.3667a10.0113,10.0113,0,0,1,10,10v4.97754A10.0113,10.0113,0,0,1,823.59459,467.3551Z" transform="translate(-246 -172.06628)" fill="#f0f0f0"/><path d="M823.59459,510.26233H672.22789a10.0113,10.0113,0,0,1-10-10v-4.97754a10.0113,10.0113,0,0,1,10-10h151.3667a10.0113,10.0113,0,0,1,10,10v4.97754A10.0113,10.0113,0,0,1,823.59459,510.26233Z" transform="translate(-246 -172.06628)" fill="#f0f0f0"/><path d="M831.16637,457.75891H679.79967a10.512,10.512,0,0,1-10.5-10.5v-4.97754a10.512,10.512,0,0,1,10.5-10.5h151.3667a10.512,10.512,0,0,1,10.5,10.5v4.97754A10.512,10.512,0,0,1,831.16637,457.75891Zm-151.3667-23.97754a8.50951,8.50951,0,0,0-8.5,8.5v4.97754a8.50951,8.50951,0,0,0,8.5,8.5h151.3667a8.50951,8.50951,0,0,0,8.5-8.5v-4.97754a8.50951,8.50951,0,0,0-8.5-8.5Z" transform="translate(-246 -172.06628)" fill="#3f3d56"/><path d="M831.16637,500.66614H679.79967a10.512,10.512,0,0,1-10.5-10.5V485.1886a10.512,10.512,0,0,1,10.5-10.5h151.3667a10.512,10.512,0,0,1,10.5,10.5v4.97754A10.512,10.512,0,0,1,831.16637,500.66614ZM679.79967,476.6886a8.50951,8.50951,0,0,0-8.5,8.5v4.97754a8.50951,8.50951,0,0,0,8.5,8.5h151.3667a8.50951,8.50951,0,0,0,8.5-8.5V485.1886a8.50951,8.50951,0,0,0-8.5-8.5Z" transform="translate(-246 -172.06628)" fill="#3f3d56"/><path d="M877.1627,237.07439V333.4641A103.53895,103.53895,0,0,1,747.28027,233.38945q0-4.24023.34076-8.39217h56.82649a16.60126,16.60126,0,0,0,15.384-22.87963H842.1934A34.95659,34.95659,0,0,1,877.1627,237.07439Z" transform="translate(-246 -172.06628)" fill="#f0f0f0"/><path d="M722.04076,709.15425c0,2.03176-.0758,4.03834-.23971,6.01965H669.98426a34.95435,34.95435,0,0,1-34.957-34.95674v-47.3998a77.07339,77.07339,0,0,1,87.01347,76.33689Z" transform="translate(-246 -172.06628)" fill="#6c63ff"/><path d="M304.12133,625.985a6.00681,6.00681,0,0,0,7.911-3.0669l46.67932-105.79394a13.3793,13.3793,0,0,0-17.0774-17.876h-.00012a13.19944,13.19944,0,0,0-6.75012,5.78027,13.64886,13.64886,0,0,0-.65442,1.293l-46.67932,105.794a5.99964,5.99964,0,0,0,3.06738,7.91162Z" transform="translate(-246 -172.06628)" fill="#6c63ff"/><path d="M356.79528,560.55725l-46.17176-10.26074,11.428-30.23193a31.94972,31.94972,0,0,1,34.299-23.62793l.44483.04931Z" transform="translate(-246 -172.06628)" fill="#2f2e41"/><path d="M450.055,627.49817a7.02814,7.02814,0,0,1-6.41186-4.17676L396.964,517.52747a14.38052,14.38052,0,0,1,25.60937-12.99707v-.00049a14.61775,14.61775,0,0,1,.70264,1.38818l46.6792,105.794a7.00007,7.00007,0,0,1-3.57862,9.23l-13.96142,6.15966-.00708-.01562A6.94406,6.94406,0,0,1,450.055,627.49817Z" transform="translate(-246 -172.06628)" fill="#6c63ff"/><path d="M385.48546,591.16907a6.00671,6.00671,0,0,0-6,6V720.18323a6.00672,6.00672,0,0,0,6,6H400.245a6.00672,6.00672,0,0,0,6-6V597.16907a6.00671,6.00671,0,0,0-6-6Z" transform="translate(-246 -172.06628)" fill="#6c63ff"/><path d="M356.29308,591.16907a6.00671,6.00671,0,0,0-6,6V720.18323a6.00672,6.00672,0,0,0,6,6h14.75976a6.00672,6.00672,0,0,0,6-6V597.16907a6.00671,6.00671,0,0,0-6-6Z" transform="translate(-246 -172.06628)" fill="#6c63ff"/><circle cx="131.82814" cy="239.22404" r="51" fill="#6c63ff"/><path d="M394.79994,432.69926c3.30591-.09179,7.42029-.20654,10.59-2.522a8.13272,8.13272,0,0,0,3.20008-6.07275,5.47082,5.47082,0,0,0-1.86036-4.49315c-1.65551-1.39894-4.073-1.72707-6.67822-.96144l2.69922-19.72559-1.98144-.27148L397.596,421.84282l1.65466-.75928c1.91834-.87988,4.55164-1.32764,6.188.05518a3.51513,3.51513,0,0,1,1.15271,2.8955,6.14689,6.14689,0,0,1-2.38123,4.52784c-2.46667,1.80175-5.74621,2.03418-9.46582,2.13818Z" transform="translate(-246 -172.06628)" fill="#2f2e41"/><rect x="166.54982" y="228.55925" width="10.77161" height="2" fill="#2f2e41"/><rect x="132.54982" y="228.55925" width="10.77161" height="2" fill="#2f2e41"/><path d="M428.36168,628.11938l-18.356-134a6.00013,6.00013,0,0,0-5.94482-5.18566H390.20543a6.02466,6.02466,0,0,0,.08985-1v-5a6.00015,6.00015,0,0,0-6-6h-12a6.00014,6.00014,0,0,0-6,6v5a6.02466,6.02466,0,0,0,.08984,1H352.52965a6.00049,6.00049,0,0,0-5.94482,5.18566l-18.356,134a6,6,0,0,0,5.94434,6.81434h88.24414A6,6,0,0,0,428.36168,628.11938Z" transform="translate(-246 -172.06628)" fill="#2f2e41"/><path d="M399.79528,560.55725V496.486l.44482-.04931a31.96115,31.96115,0,0,1,34.31543,23.68017l11.41138,30.17969Z" transform="translate(-246 -172.06628)" fill="#2f2e41"/><path d="M375.25992,463.88179l-35.27546-13.69192c-5.76827-2.23892-11.56878-4.40968-17.30651-6.72569a19.72637,19.72637,0,0,1-6.66153-3.92617,13.09008,13.09008,0,0,1-3.32111-6.42695c-1.22347-5.17132-1.00226-10.82516-.915-16.10249a122.69927,122.69927,0,0,1,1.42174-17.24065,83.28557,83.28557,0,0,1,10.65027-30.38043c9.89272-16.23155,26.93718-28.44363,46.5429-27.469,9.07668.4512,18.20557,3.70824,24.94937,9.914a15.75138,15.75138,0,0,0,2.35507,2.28248,3.26776,3.26776,0,0,0,1.87567.12592q1.23442-.07942,2.47088-.12124a51.04308,51.04308,0,0,1,8.56551.35928,27.12111,27.12111,0,0,1,14.13035,5.86736c3.37014,2.89908,6.11233,6.99171,6.39451,11.53986a13.65989,13.65989,0,0,1-4.6143,11.15057c-4.20852,3.54694-10.2131,2.30024-15.26138,2.03278l-18.49376-.97979-9.37018-.49642c-1.92935-.10222-1.92373,2.89808,0,3l24.90494,1.31945c4.00221.212,8.127.73168,12.13244.49169a13.57368,13.57368,0,0,0,8.33317-3.35238,16.62754,16.62754,0,0,0,5.03664-15.60115c-1.284-6.13755-5.85183-11.21468-11.20665-14.23511-7.28613-4.1098-15.988-4.50357-24.14076-3.896l1.06066.43934c-9.22224-9.89816-23.34855-14.07733-36.61026-12.61482-14.00229,1.54417-26.45612,9.35584-35.40409,20.03753-9.97644,11.90941-15.413,26.75957-17.52653,42.02983a139.839,139.839,0,0,0-1.082,24.87973,31.35039,31.35039,0,0,0,1.85228,10.75107,15.39035,15.39035,0,0,0,7.22512,7.74612,103.39756,103.39756,0,0,0,11.46784,4.71084L342.436,454.3438l25.52829,9.90863,6.49811,2.5222c1.80087.699,2.581-2.2006.79752-2.89284Z" transform="translate(-246 -172.06628)" fill="#2f2e41"/><path d="M319.79528,361.93372a15.5,15.5,0,1,1,15.5-15.5A15.51744,15.51744,0,0,1,319.79528,361.93372Zm0-28a12.5,12.5,0,1,0,12.5,12.5A12.51408,12.51408,0,0,0,319.79528,333.93372Z" transform="translate(-246 -172.06628)" fill="#2f2e41"/><rect x="528.17702" y="440.81546" width="42.23651" height="42.23651" transform="translate(147.61407 -410.75474) rotate(37.40978)" fill="#f0f0f0"/><path d="M389.29528,228.93372a33.94883,33.94883,0,0,1,27.27734,13.70214l19.58984-25.6137-58.77881-44.95588-44.95556,58.779,25.33349,19.37585A34.003,34.003,0,0,1,389.29528,228.93372Z" transform="translate(-246 -172.06628)" fill="#f0f0f0"/><path d="M953,727.93372H247a1,1,0,0,1,0-2H953a1,1,0,0,1,0,2Z" transform="translate(-246 -172.06628)" fill="#3f3d56"/><path d="M780.68737,562.00305H708.8253a10.0113,10.0113,0,0,1-10-10v-4.97754a10.0113,10.0113,0,0,1,10-10h71.86207a10.0113,10.0113,0,0,1,10,10v4.97754A10.0113,10.0113,0,0,1,780.68737,562.00305Z" transform="translate(-246 -172.06628)" fill="#A9A9A9"/><path d="M788.25939,552.40735H716.39708a10.512,10.512,0,0,1-10.5-10.5v-4.97754a10.512,10.512,0,0,1,10.5-10.5h71.86231a10.512,10.512,0,0,1,10.5,10.5v4.97754A10.512,10.512,0,0,1,788.25939,552.40735Zm-71.86231-23.97754a8.50951,8.50951,0,0,0-8.5,8.5v4.97754a8.50951,8.50951,0,0,0,8.5,8.5h71.86231a8.50951,8.50951,0,0,0,8.5-8.5v-4.97754a8.50951,8.50951,0,0,0-8.5-8.5Z" transform="translate(-246 -172.06628)" fill="#383838"/></svg>