
<?php

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedCryptoData = isset($_POST['selectedCryptoData']) ? $_POST['selectedCryptoData'] : null;

    $crypto = json_decode($selectedCryptoData, true);
}
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
      <link rel="stylesheet" href="assets/css/payment.css">
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


  
        <?php
            
            include 'session_handler.php';

        ?>
    
    <style>
      html{
        animation: none;
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
                                  <a href="profile.php">
                                      <i class="material-icons">person_outline</i>
                                      <span>Profile </span>
                                  </a>
                              </li>
                              <li>
                                  <a href="wallet_page.php">
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
                          <a href="dashboard.php">
                              <i class="material-icons">dashboard</i>
                              <span>Home</span>
                          </a>
                      </li>
                      <li>
                          <a href="swap.php">
                              <i class="material-icons">swap_calls</i>
                              <span>Convert</span>
                          </a>
                      </li>
                      <li>
                          <a href="#">
                              <i class="material-icons">history</i>
                              <span>History</span>
                          </a>
                      </li>
                      <li>
                          <a href="#">
                              <i class="material-icons">widgets</i>
                              <span>Features</span>
                          </a>
                      </li>
                      <li>
                          <a href="#">
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

      <?php if ($crypto): ?>
      <!-- THIS IS RENDERED ONLY IF THE "$crypto" EXISTS -->
        <main class="main_content">
            <div class="app-container">
                <div class="payment-container">
                    <div class="payment-card">

                          <!-- WARNING  -->
                        <div class="warning-banner">
                            <i class="fa fa-info-circle"></i>
                            <span>Only send <samp><?= $crypto['symbol'] ?></samp> assets to this address. Other assets will be lost forever</span>
                        </div>


                        <div class="crypto-amount">

                            <!-- CRYPTO SYMBOL -->
                            <div class="crypto-icon">
                                <?php if (isset($crypto['imageUrl'])): ?>
                                    <img src="<?= $crypto['imageUrl'] ?>" alt="<?= $crypto['symbol'] ?>" width="50">
                                <?php endif; ?>
                                <span style="color: var(--secondary-text);"><?= $crypto['name'] ?><samp class="crypto-currency"> (<?= $crypto['symbol'] ?>)</samp></span>
                            </div>

                            <!-- AMOUNT TO PAY -->
                            <div class="amount-display">
                                <h4 class="crypto-price"></h4>
                                <span style="color: #fff;" class="dollar-amount">≈ <samp>$</samp><?= $crypto['amount'] ?></span>
                          
                            </div>

                        </div>




                        
                        <!--WALLET ADDRESS  -->
                        <div class="wallet-address">
                            <input type="text" id="wallet" value="<?= $crypto['wallet'] ?>" readonly disabled>
                        </div>


                        <div class="action-buttons">

                            <!--  COPY WALLET ADDRESS-->
                            <button class="action-btn copy-btn" onclick="copyToClipboard()">
                                <i class="fa fa-clipboard"></i>
                                <span>Copy</span>
                            </button>


                            <!-- PAYMENT BUTTON FOR BACKEND  -->
                            <button class="action-btn paid-btn" id="paidButton">
                                <i class="fa fa-check"></i>
                                <span>Paid</span>
                            </button>
                            
                            
                             <!-- GO BACK TO THE PREVIOUS PAGE -->
                             <button class="action-btn back-btn" id="backButton">
                                <i class="fa fa-backward"></i>
                                <span>Back</span>
                            </button>
                            <script>
                                document.addEventListener("DOMContentLoaded", function () {
                                    // Back button functionality
                                    document.getElementById("backButton").onclick = function (event) {
                                        event.preventDefault();
                                        window.history.back();
                                    };

                                    // Paid button functionality
                                    document.getElementById("paidButton").addEventListener("click", function () {
                                        const transactionId = "<?= uniqid('txn_') ?>"; // Generating the unique transaction ID
                                        const cryptoSymbol = "<?= $crypto['symbol'] ?>";
                                        const amount = "<?= $crypto['amount'] ?>";
                                        const walletAddress = "<?= $crypto['wallet'] ?>";
                                        const userId = "<?= $_SESSION['user_id'] ?>"; // Fetching the user ID from the session
                                        console.log("Sending data to the server...");


                                        // Send the data to the server (process_payment.php)
                                        fetch("send_payment_logic.php", {
                                            method: "POST",
                                            headers: {
                                                "Content-Type": "application/json",
                                            },
                                            body: JSON.stringify({
                                            transactionId: transactionId,
                                            cryptoSymbol: cryptoSymbol,
                                            amount: amount,
                                            walletAddress: walletAddress,
                                            userId: userId
                                            // Including the user ID
                                        }),
                                        })
                                            .then((response) => response.json())
                                            .then((data) => {
                                                if (data.success) {
                                                    alert("Withdrawal is pending, waiting for admin approval.");
                                                    window.location.href = "send.php"; // Redirect to deposit page
                                                } else {
                                                    alert("Error: " + (data.error || "There was an error processing your payment,please submit your KYC."));
                                                
                                                }
                                            })
                                            .catch((error) => {
                                                console.error("Error:", error);
                                                alert("An error occurred. Please try again later.");
                                            });
                                    });
                                });
                            </script>



                        </div>
                    </div>
                </div>
            </div>
        </main>


    <?php else: ?>
        header('Location: deposit.php');
        
    <?php endif; ?>

      

      
      
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
                    <a href="dashboard.php">
                        <i class="material-icons">dashboard</i>
                        <span>Home</span>
                    </a>
                </li>
            </ul>

            <ul>
                <li>
                    <a href="swap.php">
                        <i class="material-icons">swap_calls</i>
                        <span>Convert</span>
                    </a>
                </li>
            </ul>

            <ul>
                <li>
                    <a href="dashboard.php">
                        <i class="material-icons">history</i>
                        <span>History</span>
                    </a>
                </li>
            </ul>

            <ul>
                <li>
                    <a href="features.php">
                        <i class="material-icons">widgets</i>
                        <span>Investments</span>
                    </a>
                </li>
            </ul>

            <ul>
                <li>
                    <a href="market.php">
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
    <script>
        const symbolToId = {
            BTC: "bitcoin",
            USDT: "tether",
            ETH: "ethereum",
            DOGE: "dogecoin",
            BNB: "binancecoin",
            SHIB: "shiba-inu",
            LTC: "litecoin",
            XRP: "ripple"
        };

        const loadingSpinner = `<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 50 50" style="animation: spin 1.5s linear infinite;">
            <circle cx="25" cy="25" r="20" stroke="#fff" stroke-width="5" fill="none"/>
            <circle cx="25" cy="25" r="20" stroke="#00c853" stroke-width="5" fill="none" stroke-dasharray="125.6" stroke-dashoffset="125.6" style="animation: dash 1.5s ease-in-out infinite;"></circle>
            </svg>`;

        const style = document.createElement('style');
        style.innerHTML = `
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            @keyframes dash {
                0% { stroke-dashoffset: 125.6; }
                50% { stroke-dashoffset: 31.4; }
                100% { stroke-dashoffset: 125.6; }
            }
        `;

        document.head.appendChild(style);

        async function fetchCryptoPrice() {
            const cryptoCurrency = document.querySelector(`.crypto-currency`);
            const dollarAmount = document.querySelector(`.dollar-amount`);
            const cryptoPrice = document.querySelector(`.crypto-price`);

            const cryptoCode = cryptoCurrency.innerText.replace(/[()]/g, '').trim();
            if (symbolToId[cryptoCode]) {
                const amountInDollars = parseFloat(dollarAmount.innerText.replace(/[^\d.]/g, ''));
    
                const cryptoId = symbolToId[cryptoCode];
                cryptoPrice.innerHTML = loadingSpinner;
    
                try {
                    const response = await fetch(`https://api.coingecko.com/api/v3/simple/price?ids=${cryptoId}&vs_currencies=usd`);
                    const data = await response.json();
    
                    if (data[cryptoId] && data[cryptoId].usd) {
                        const cryptoPriceInUSD = data[cryptoId].usd;
    
                        const cryptoAmount = amountInDollars / cryptoPriceInUSD;
    
                        cryptoPrice.innerHTML = `${cryptoAmount.toFixed(6)} ${cryptoCode}`;
                    } else {
                        cryptoPrice.innerHTML = "Price data not available.";
                    }
                } catch (error) {
                    console.error("Error fetching price data:", error);
                    cryptoPrice.classList.add("error")
                    cryptoPrice.innerHTML = "Error fetching price data.";
                }
            } else {
                cryptoPrice.innerHTML = "Currency not supported.";
            }

        }
        fetchCryptoPrice();

        function copyToClipboard() {
            const wallet = document.getElementById("wallet");
            const walletAddress = wallet.value;
            navigator.clipboard.writeText(walletAddress).then(() => {
                window.alert('Copied to clipboard');
            }).catch(err => {
                window.alert('Failed to copy to clipboard: ' + err);
            });
        }
    </script>




</body>
</html>

