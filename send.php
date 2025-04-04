<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Simart Pro</title>
    <link rel="stylesheet" href="assets/css/deposit.css">
    <link rel="stylesheet" href="assets/css/toastify.css">
    <!-- <link rel="stylesheet" href="assets/css/main.css"> -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/table-wallet.css">
    <link rel="stylesheet" href="assets/css/mediaquery.css">
    <link rel="stylesheet" href="assets/css/main-mediaquery.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.4.5/css/swiper.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

        <?php
            
            include 'session_handler.php';

        ?>
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
                            <span>Swap</span>
                        </a>
                    </li>
                    <li>
                        <a href="history.php">
                            <i class="material-icons">history</i>
                            <span>History</span>
                        </a>
                    </li>
                    <li>
                        <a href="features.php">
                            <i class="material-icons">widgets</i>
                            <span>Investments</span>
                        </a>
                    </li>
                    <li>
                        <a href="market.php">
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
        <main class="main-content">
            <div class="amount-section">
                <h2>Enter Amount </h2>


                <div class="amount-input-container">
                    <span class="currency-symbol">$</span>
                    <input  type="" id="amount" class="amount" value="1000" name="amount" inputmode="numeric" pattern="[0-9]*" placeholder="0.00" oninput="validateInput(event)" >
                    <script>
                        function validateInput(event) {
                            let inputValue = event.target.value;

                            if (/[^0-9.]/.test(inputValue)) {
                                inputValue = inputValue.replace(/[^0-9.]/g, '');
                            }

                            if ((inputValue.split('.').length - 1) > 1) {
                                inputValue = inputValue.slice(0, inputValue.lastIndexOf('.')) + inputValue.slice(inputValue.lastIndexOf('.') + 1);
                            }

                            event.target.value = inputValue;
                        }
                    </script>
                </div>
                <br>

            </div>

            <div class="crypto-section">
                <div class="wrapper">
                    <h2>Select Payment Option</h2>
                    <div class="crypto-grid" id="cryptoGrid">
                        <?php

                            $cryptoData = [
                                ['id' => '1', 'symbol' => 'BTC', 'name' => 'Bitcoin', 'imageUrl' => 'https://s2.coinmarketcap.com/static/img/coins/64x64/1.png'], //
                                ['id' => '2', 'symbol' => 'USDT', 'name' => 'Tether', 'imageUrl' => 'https://s2.coinmarketcap.com/static/img/coins/64x64/825.png'], //
                                ['id' => '3', 'symbol' => 'ETH', 'name' => 'Ethereum', 'imageUrl' => 'https://s2.coinmarketcap.com/static/img/coins/64x64/1027.png'],
                                ['id' => '4', 'symbol' => 'DOGE', 'name' => 'Dogecoin', 'imageUrl' => 'https://s2.coinmarketcap.com/static/img/coins/64x64/74.png'], //
                                ['id' => '5', 'symbol' => 'BNB', 'name' => 'Binance Coin', 'imageUrl' => 'https://s2.coinmarketcap.com/static/img/coins/64x64/1839.png'],
                                ['id' => '6', 'symbol' => 'SHIB', 'name' => 'Shiba Inu', 'imageUrl' => 'https://s2.coinmarketcap.com/static/img/coins/64x64/5994.png'], //
                                ['id' => '7', 'symbol' => 'LTC', 'name' => 'Litecoin', 'imageUrl' => 'https://s2.coinmarketcap.com/static/img/coins/64x64/2.png'],
                                ['id' => '8', 'symbol' => 'XRP', 'name' => 'Ripple', 'imageUrl' => 'https://s2.coinmarketcap.com/static/img/coins/64x64/52.png'],
                            ];

                            foreach ($cryptoData as $crypto) {
                                echo '<div class="crypto-option" data-id="' . $crypto['id'] . '" data-symbol="' . $crypto['symbol'] . '" data-name="' . $crypto['name'] . '" data-image-url="' . $crypto['imageUrl']. '">';
                                echo '<img src="' . $crypto['imageUrl'] . '" alt="' . $crypto['symbol'] . '">';
                                echo '<span class="crypto-name">' . $crypto['name'] . '</span>';
                                echo '<span class="crypto-ticker">' . $crypto['symbol'] . '</span>';
                                echo '</div>';

                            }
                        ?>
                    </div>
                </div>
            </div>

            <div class="amount-section">
                <h2>Wallet </h2>
                <div id="copy" class="copy_message">Error Message !!!</div>
                <div class="wallet-address-container">
                    <input style="color: white;" type="text" class="wallet" id="wallet" name="wallet" placeholder="Wallet">
                    <!-- Copy Button (Hidden initially) -->
                    <button id="copyButton" class="copy-button" style="display: none; color: var(--secondary-text);" onclick="copyToClipboard()">Copy</button>
                </div>
                <br>

                <div class="selected-crypto" id="selectedCrypto">
                    <span>Select cryptocurrency</span>
                </div>
            </div>

            <form id="cryptoForm" action="send_payment.php" method="POST">
                <input type="hidden" id="selectedCryptoData" name="selectedCryptoData">
                <div id="error" class="error_message">Error Message !!!</div>
                <button type="" class="deposit-button" id="depositButton" style="margin-bottom: 140px;">
                    <i class="fas fa-arrow-right"></i>
                    <span>Continue to Withdraw</span>
                </button>
                <div class="buttons">
                    <div class="btn" id="error">
                        <i class="fas fa-arrow-right"></i>
                        <span>Continue to Deposit</span>
                    </div>
                </div>
            </form>
        </main>
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
                    <a href="history.php">
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

    <?php
    
    include 'wallet_logic.php';
    
    ?>

    <script src="assets/user/javascript/popup.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", () => {
        const cryptoOptions = document.querySelectorAll('.crypto-option');
        const selectedCrypto = document.getElementById('selectedCrypto');
        const selectedCryptoDataInput = document.getElementById('selectedCryptoData');
        const amountInput = document.getElementById('amount');
        const walletInput = document.getElementById('wallet');
        const copyButton = document.getElementById('copyButton');
        const cryptoForm = document.getElementById("cryptoForm");
        const errorMessage = document.getElementById("error");
        const depositButton = document.getElementById('depositButton');
        let currentSelection = null;

        // PHP variable passed to JS (user's crypto balances)
        const cryptoBalances = <?php echo json_encode($cryptoData); ?>;

        function updateCryptoData() {
            if (!currentSelection) return;

            const name = currentSelection.dataset.name;
            const symbol = currentSelection.dataset.symbol;
            const imageUrl = currentSelection.dataset.imageUrl;
            const amount = amountInput.value;
            const walletValue = walletInput.value.trim(); 
            selectedCrypto.innerHTML = `
                <img src="${imageUrl}" alt="${name}">
                <div>
                    <span class="selected-name">${name}</span>
                    <span class="selected-ticker">${symbol}</span>
                </div>
            `;
            selectedCrypto.classList.add('has-selection');

            if (walletValue) {
                copyButton.style.display = 'inline-block';
            } else {
                copyButton.style.display = 'none';
            }

            selectedCryptoDataInput.value = JSON.stringify({
                id: currentSelection.dataset.id,
                symbol: symbol,
                name: name,
                imageUrl: imageUrl,
                amount: amount,  
                wallet: walletValue
            });

            // Validate amount whenever the crypto selection or amount changes
            validateAmount();
        }

        function validateAmount() {
            if (!currentSelection) return;

            const selectedSymbol = currentSelection.dataset.symbol;
            const enteredAmount = parseFloat(amountInput.value) || 0;
            const availableBalance = cryptoBalances[selectedSymbol] || 0;

            // If entered amount exceeds available balance, display error and disable "Deposit" button
            if (enteredAmount > availableBalance) {
                errorMessage.innerHTML = `Insufficient balance for ${selectedSymbol}. Available: ${availableBalance.toFixed(8)}`;
                errorMessage.style.display = "block";
                // Disable the "Deposit" button
                depositButton.disabled = true;
                return false;
            } else {
                // Hide error message and enable "Deposit" button
                errorMessage.style.display = "none";
                depositButton.disabled = false;
                return true;
            }
        }

        // Attach click event to crypto options
        cryptoOptions.forEach(option => {
            option.addEventListener('click', () => {
                if (currentSelection) {
                    currentSelection.classList.remove('selected');
                }

                option.classList.add('selected');
                currentSelection = option;

                updateCryptoData();
            });
        });

        // Add input listeners for wallet and amount fields
        walletInput.addEventListener('input', updateCryptoData);
        amountInput.addEventListener('input', updateCryptoData);  

        // Copy wallet address to clipboard
        copyButton.addEventListener('click', () => {
            const wallet = walletInput.value;
            const copyMessage = document.getElementById("copyMessage");

            navigator.clipboard.writeText(wallet).then(() => {
                copyMessage.innerHTML = "Copied to clipboard!";
                copyMessage.style.display = "block";

                setTimeout(() => {
                    copyMessage.style.display = "none";
                }, 2000);
            }).catch(err => {
                window.alert('Failed to copy to clipboard: ' + err);
            });
        });

        // Form submission validation
        cryptoForm.addEventListener("submit", function (event) {
            const walletValue = walletInput.value.trim();

            if (!walletValue) {
                event.preventDefault();
                errorMessage.innerHTML = "Wallet address cannot be empty!";
                errorMessage.style.display = "block";
                return;
            }

            if (!currentSelection) {
                event.preventDefault();
                errorMessage.innerHTML = "No cryptocurrency selected!";
                errorMessage.style.display = "block";
                return;
            }

            if (!validateAmount()) {
                event.preventDefault(); // Prevent form submission if balance is insufficient
            }
        });
    });
    </script>


    <script src="assets/javascript/active-tab.js"></script>




</body>
</html>
