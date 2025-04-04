<?php
// Include database connection
include 'connection.php';

// Fetch all crypto wallets from the database
$query = "SELECT cw.id, cw.crypto_id, cw.symbol, cw.address, cw.network, cw.qr_code_path, cw.name, cw.image_url 
          FROM crypto_wallets cw
          JOIN cryptos c ON cw.crypto_id = c.crypto_id";
$result = $conn->query($query);

$cryptoWallets = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cryptoWallets[] = $row;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Simart Pro</title>
    <link rel="stylesheet" href="assets/css/deposit.css">
    <link rel="stylesheet" href="assets/css/toastify.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/table-wallet.css">
    <link rel="stylesheet" href="assets/css/mediaquery.css">
    <link rel="stylesheet" href="assets/css/main-mediaquery.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.4.5/css/swiper.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


  
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

        <?php
            
            include 'session_handler.php';

        ?>
        <style>
            .app-container{
                margin-bottom: 70px;

            }
            @media (max-width: 768px) {
                .app-container{
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
                              <i class="fa fa-user"></i>
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

    <style>

        
        .main_content > header{
            color: white;
            padding: 20px;
            margin-bottom: 20px;
            text-align: center;
        }
        .edit_crypto_buttons{
            display: flex;
            justify-content: start;
            flex-direction: column;
            margin: 20px 0;
            align-items: start;
            padding: 20px;
            gap: 20px;
        }
        .add_wallet{
            padding: 10px 20px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }.add_wallet:hover{
            background-color: #222222;
            color: white;
        }
        .btn_group{
            position: relative;
        }
        .btn_group .edit_crypto{
            padding: 10px 20px;
            color: white;
            background-color: var(--surface);
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }.edit_crypto:hover{
            background-color: var(--border-color);
            color: white;

        }
      
        .dropdown_down {
            position: absolute;
            
            /* right: 20%; */
            top: 100%;
            background: var(--card-bg);
            border-radius: 12px;
            padding: 8px 10px;
            margin-top: 8px;
            min-width: 180px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            opacity: 0;
            visibility: hidden;
            transform: translateY(2px);
            transition: all 0.2s ease;
            background: var(--background);
            z-index: 200;
        
        }
        .dropdown_container:hover .dropdown_down{
            visibility: visible;
            transform: translateY(0);
            opacity: 1;
        }
        .dropdown_down .dropdown_item {
            padding: 12px 16px;
            display: block;
            color: var(--secondary-text);
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.2s ease;
            border-radius: 10px;
            border: none;
            background: transparent;
            width: 100%;
            display: flex;
            cursor: pointer;
        
        }
        .dropdown_down .dropdown_item:hover{
            background-color: var(--hover-color);
        }

        .dropdown_item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
            position: relative;
        }
        .dropdown_item > button{
            color: var(--secondary-text);
        }
        .dropdown_item:hover button,
        .dropdown_item:hover i{
            color: var(--text-color);

        }
        .crypto_item{
            width: 80%;
            text-align: left;
        }


#edit_wallet_popup{
    visibility: hidden;
    opacity: 0;
}
        
.action_overlay{
    position: fixed;
    width: 100%;
    max-width: 100vw;
    background: #000000b1;
    backdrop-filter: blur(8px); 
    top: 0;
    left: 0;
    right: 0;
    width: 100%;
    z-index: 99999999;
    height: 100vh;
    transition: all 0.6s ease;

    display: grid;
    place-content: center;
    place-items: center;


}
.show_action{
 display: block;
}
.action_overlay > .wrapper{
  background: var(--surface);
  padding: 20px;
  display: flex;
  flex-direction: column;
  gap: 30px;
  border-radius: 10px;
  justify-content: center;
  width: 420px;
  scale: 0.87;

}
.action_overlay > .wrapper > header{
  display: flex;
  justify-content: space-between;
  font-size: 20px;
  border-bottom: 1px solid rgba(128, 128, 128, 0.315);
  padding-bottom: 12px;
  cursor: default;
  color: var(--text-color);
}
.action_overlay > .wrapper > header img{
  cursor: pointer;
  background: var(--text-color);
  padding: 2px;
  width: 25px;
  scale: 0.88;
}
.action_overlay > .wrapper > main{
  display: flex;
  font-size: 18px;
  border-bottom: 1px solid rgba(128, 128, 128, 0.315);
  padding-bottom: 20px
}

.action_overlay > .wrapper > main select{
  width: 200px;
  padding: 0.50rem 0.6rem;
  background-color: var(--background);
  border: 1px solid rgba(128, 128, 128, 0.315);
  border-radius: 4px;
  color: white;
}

.action_overlay > .wrapper > main label{
  color: var(--secondary-text);
  font-size: 14px;
}
.action_overlay > .wrapper > main input,
.action_overlay > .wrapper > main textarea{
  background-color: var(--background);
  border: 1px solid rgba(128, 128, 128, 0.315);
  padding: 0.50rem 0.6rem;
  font-size: 1rem;
  transition: all 0.3s ease;
  width: 200px;
  color: var(--text-color);

}
.action_overlay > .wrapper > main textarea{
  max-width: 100%;
  min-width: 100%;
  width: 100%;

  max-height: 180px;
  min-height: 180px;
  height: 180px;
}
.action_overlay > .wrapper > main select:focus,
.action_overlay > .wrapper > main input:focus,
.action_overlay > .wrapper > main textarea:focus{

  outline: none;
  border-color: var(--primary-color);
  box-shadow: 0 0 0 4px rgba(94, 99, 255, 0.1);
}

.qr_code_wrapper{
    margin-top: 20px;
}

.qr_code_wrapper h6{
    color: var(--text-color);
    font-size: 16px;
}


.negative_btn,
.positive_btn{
  padding: 11px 20px;
  border: none;
  outline: none;
  cursor: pointer;
  color: var(--background);
  border-radius: 5px;
  background: var(--text-color);

}
.positive_btn{
  background: var(--primary-color);
  color: var(--text-color);


}

#image_input{
    appearance: none;
}


@media (max-width: 768px) {
    .action_overlay > .wrapper{
        scale: 0.88;
    }
}

@media (max-width: 480px) {
    .action_overlay > .wrapper{
        scale: 0.79;
    }
}

@media (max-width: 350px) {
    .action_overlay > .wrapper{
        scale: 0.69;
    }
}











  


    </style>

    <main class="main_content">
        
        <header>
            <h1>Select Crypto Wallet and make deposit</h1>
        </header>




        <div class="edit_crypto_buttons">
            <button class="add_wallet">Add Wallet</button>

            <div class="btn_group">
   <div class="dropdown_container">
        <button class="edit_crypto">Edit Crypto</button>
        <div class="dropdown_down">
            <?php foreach ($cryptoWallets as $wallet): ?>
                <div class="dropdown_item">
                    <button class="crypto_item" 
                            data-popup="edit_wallet_popup_<?php echo $wallet['id']; ?>" 
                            onclick="openEditForm('<?php echo $wallet['id']; ?>')">
                        <?php echo $wallet['symbol']; ?>
                    </button>
                    <i class="fa fa-trash"></i>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Dynamic Action Overlays -->
        <?php foreach ($cryptoWallets as $wallet): ?>
            <section class="action_overlay" 
                     id="edit_wallet_popup_<?php echo $wallet['id']; ?>" 
                     style="display: none; overflow-y: scroll;">
                <div class="wrapper">
                    <header>
                        <h4>
                            Edit <strong><?php echo $wallet['symbol']; ?> Wallet</strong> Info
                        </h4>
                        <img class="close_action" 
                             src="assets/images/c-close-svgrepo-com.svg" 
                             alt="Close" 
                             width="20"
                             onclick="closeEditForm('<?php echo $wallet['id']; ?>')">
                    </header>
                    <main style="display: flex; flex-direction: column; gap: 10px;">
                    <form  id="edit_wallet_form_<?php echo $wallet['id']; ?>">
    <!-- form fields here -->
    <input type="hidden" name="crypto_id" value="<?php echo $wallet['crypto_id']; ?>">

    <label for="payment_method_address_<?php echo $wallet['id']; ?>">Payment Method Address*</label>
    <input id="payment_method_address_<?php echo $wallet['id']; ?>" 
           name="payment_method_address" 
           type="text" 
           placeholder="..." 
           style="width: 100%;"
           value="<?php echo htmlspecialchars($wallet['address']); ?>">

    <label for="payment_method_network_<?php echo $wallet['id']; ?>">Payment Method Network*</label>
    <input id="payment_method_network_<?php echo $wallet['id']; ?>" 
           name="payment_method_network" 
           type="text" 
           placeholder="..." 
           style="width: 100%;"
           value="<?php echo htmlspecialchars($wallet['network']); ?>">

    <div class="qr_code_wrapper">
        <img src="<?php echo htmlspecialchars($wallet['qr_code_path']); ?>" 
             width="190" 
             style="border-radius: 7px;"
             alt="QR Code">
        <br><br>
        <label for="image_input_<?php echo $wallet['id']; ?>" class="button">Change QR Code</label><br>
        <input type="file" 
               name="qr_code_input" 
               id="image_input_<?php echo $wallet['id']; ?>" 
               accept=".jpg, .jpeg, .png" 
               style="margin-bottom: 10px;">
        <br>
    </div>

    <div style="display: flex; gap: 10px;">
        <button id="close_<?php echo $wallet['id']; ?>" 
                class="close_action negative_btn" 
                type="button"
                onclick="closeEditForm('<?php echo $wallet['id']; ?>')">
            Close
        </button>
        <button name="submit_btn_<?php echo $wallet['id']; ?>" 
                id="submit_btn_<?php echo $wallet['id']; ?>"  
                class="positive_btn" 
                type="button"
                onclick="submitEditForm('<?php echo $wallet['id']; ?>')">
            Save Changes
        </button>
                    </form>
                        </div>
                    </main>
                </div>
            </section>
        <?php endforeach; ?>
    </div>
</div>

<script>
    // Open the edit form for a specific wallet
    function openEditForm(walletId) {
        const popup = document.getElementById(`edit_wallet_popup_${walletId}`);
        if (popup) {
            popup.style.display = 'block';
        }
    }

    // Close the edit form for a specific wallet
    function closeEditForm(walletId) {
        const popup = document.getElementById(`edit_wallet_popup_${walletId}`);
        if (popup) {
            popup.style.display = 'none';
        }
    }

    // Submit the edit form for a specific wallet
function submitEditForm(walletId) {
    // Retrieve input values
    const walletAddress = document.getElementById(`payment_method_address_${walletId}`).value.trim();
    const walletNetwork = document.getElementById(`payment_method_network_${walletId}`).value.trim();
    const qrCodeFile = document.getElementById(`image_input_${walletId}`).files[0];

    // Validate required fields
    if (!walletAddress || !walletNetwork) {
        alert("Please fill all required fields.");
        return;
    }

    // Create a FormData object to hold the form data
    const formData = new FormData();
    formData.append("crypto_id", walletId);
    formData.append("payment_method_address", walletAddress);
    formData.append("payment_method_network", walletNetwork);

    // Append QR code file if provided
    if (qrCodeFile) {
        formData.append("qr_code_input", qrCodeFile);
    }

    // Create a new XMLHttpRequest to send the form data
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "upload_qr_code.php", true);

    // Set up the onload event handler
    xhr.onload = function () {
        if (xhr.status === 200) {
            alert(xhr.responseText);
            location.reload(); // Reload to reflect the changes
        } else {
            alert("Error occurred while saving changes.");
        }
    };

    // Send the form data
    xhr.send(formData);
}

</script>
    <div class="app-container" style="width: 100%;">
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
                         <?php foreach ($cryptoWallets as $wallet): ?>
                        <div class="crypto-option" data-id="<?php echo $wallet['id']; ?>" data-symbol="<?php echo $wallet['symbol']; ?>" data-name="<?php echo $wallet['name']; ?>" data-image-url="<?php echo $wallet['image_url']; ?>" data-wallet="<?php echo $wallet['address']; ?>" data-qr-code="<?php echo $wallet['qr_code_path']; ?>"data-network="<?php echo $wallet['network']; ?>">
                            <img src="<?php echo $wallet['image_url']; ?>" alt="<?php echo $wallet['symbol']; ?>">
                            <img style="display:none;" src="<?php echo $wallet['qr_code_path']; ?>" alt="<?php echo $wallet['symbol']; ?>">
                            <span class="crypto-name"><?php echo $wallet['name']; ?></span>
                            <span class="crypto-ticker"><?php echo $wallet['symbol']; ?></span>
                             <span class="crypto-ticker"><?php echo $wallet['network']; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="amount-section">
                <h2>Wallet </h2>
                <div id="copy" class="copy_message">Error Message !!!</div>
                <div class="wallet-address-container">
                    <input style="color: white;" type="text" class="wallet" id="wallet" name="wallet" disabled placeholder="Wallet">
                    <!-- Copy Button (Hidden initially) -->
                    <button id="copyButton" class="copy-button" style="display: none; color: var(--secondary-text);" onclick="copyToClipboard()">Copy</button>
                </div>
                <br>

                <div class="selected-crypto" id="selectedCrypto">
                    <span>Select cryptocurrency</span>
                </div>
            </div>

            <form id="cryptoForm" action="admin_payment.php" method="POST">
                <input type="hidden" id="selectedCryptoData" name="selectedCryptoData">
                <div id="error" class="error_message">Error Message !!!</div>
           
                <button type="" class="deposit-button" id="depositButton" style="">

                    <i class="fas fa-arrow-right"></i>
                    <span>Continue to Deposit</span>
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
                    <a href="admin_dashboard.php">
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
                    <a href="admin_history.php">
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









  


                            




    <script src="assets/user/javascript/popup.js"></script>
    <script>
        const cryptoOptions = document.querySelectorAll('.crypto-option');
        const selectedCrypto = document.getElementById('selectedCrypto');
        const selectedCryptoDataInput = document.getElementById('selectedCryptoData');
        const amountInput = document.getElementById('amount');
        const walletInput = document.getElementById('wallet');
        const copyButton = document.getElementById('copyButton');
        let currentSelection = null;

        cryptoOptions.forEach(option => {
            option.addEventListener('click', () => {
                if (currentSelection) {
                    currentSelection.classList.remove('selected');
                }

                option.classList.add('selected');
                currentSelection = option;

                const qrCode = option.dataset.qrCode;
                const name = option.dataset.name;
                const symbol = option.dataset.symbol;
                const imageUrl = option.dataset.imageUrl;
                const amount = amountInput.value;
                const wallet = option.dataset.wallet;
                const network = option.dataset.network;

                selectedCrypto.innerHTML = `
                    <img src="${imageUrl}" alt="${name}">
                    <div>
                        <span class="selected-name">${name}</span>
                        <span class="selected-ticker">${symbol}</span>
                        <span class="selected-ticker">${network}</span>
                    </div>
                `;
                selectedCrypto.classList.add('has-selection');

                walletInput.value = wallet;

                if (wallet) {
                    copyButton.style.display = 'inline-block';
                } else {
                    copyButton.style.display = 'none';
                }

                selectedCryptoDataInput.value = JSON.stringify({
                    id: option.dataset.id,
                    symbol: symbol,
                    name: name,
                    imageUrl: imageUrl,
                    qrCode: qrCode,
                    amount: amount,
                    wallet: wallet,
                    network: network
                });

            });
        });

        function copyToClipboard() {
            const wallet = walletInput.value;
            const copyMessage = document.getElementById("copy");
            navigator.clipboard.writeText(wallet).then(() => {
                copyMessage.innerHTML = "Copied to clipboard!";
                copyMessage.style.display = "block";
                
                setTimeout(() => {
                    copyMessage.style.display = "none";
                }, 2000);
            }).catch(err => {
                window.alert('Failed to copy to clipboard: ' + err);
            });
        }
        
        const cryptoForm = document.getElementById("cryptoForm");
        const walletAddress = document.getElementById("wallet");

        cryptoForm.addEventListener("submit", function(event){
            const errorMessage = document.getElementById("error");

            if(walletAddress.value === ""){
                event.preventDefault();
                errorMessage.innerHTML = "No Currency Selected!";
                errorMessage.style.display = "block";
                setTimeout(() => {
                    errorMessage.style.display = "none";
                }, 2000);

            }

        });
        





        // EDIT WALLET POPUPS
        const cryptoItems = document.querySelectorAll(".crypto_item");
         cryptoItems.forEach((item) => {
            item.addEventListener('click', function() {
                const popupId = item.getAttribute("data-popup")
                const popup = document.getElementById(popupId);
                if (popup) {
                    popup.style.visibility = "visible";
                    popup.style.opacity = "1";
                }
            })
         })

             
        document.querySelectorAll('.close_action').forEach(button => {
            button.addEventListener('click', function () {
                const actionOverlay = this.closest('.action_overlay');
                if (actionOverlay) {
                    actionOverlay.style.visibility = 'hidden'; 
                    actionOverlay.style.opacity = '0';
                }
            });
        });





        



        
    </script>







    <script src="assets/javascript/active-tab.js"></script>




</body>
</html>
