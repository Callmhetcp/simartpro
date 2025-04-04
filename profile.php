<?php
session_start();

// Redirect to login if the session is not set
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'] ;
$user_fname = $_SESSION['user_firstname'] ;
$user_lname = $_SESSION['user_lastname'] ;
$email = $_SESSION['email'] ;
$dob = $_SESSION['user_dob'] ;
$gender = $_SESSION['user_gender'] ;
$nationality = $_SESSION['user_nationality'] ;
$state = $_SESSION['user_state'] ;
$phone = $_SESSION['user_phone'];

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
        <link rel="stylesheet" href="assets/css/profile.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/swap.css">
        <link rel="stylesheet" href="assets/css/table-wallet.css">
        <link rel="stylesheet" href="assets/css/mediaquery.css">
        <link rel="stylesheet" href="assets/main-mediaquery.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.4.5/css/swiper.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    
    
    
        <!-- ============FONT-AWESOME-LINKS============= -->
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


        <noscript> Powered by <a href=“https://www.smartsupp.com” target=“_blank”>Smartsupp</a></noscript>
    </head>

    <?php

        include 'profile_logic.php'
    ?>

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
     
        .app-container{
            margin-top: 200px;

        }
        .last-form{
            margin-bottom: 80px;

        }
        @media (max-width: 768px) {
            .main_content{
                margin-top: 3rem;
            }
            .app-container{
                margin-bottom: 130px;
            }
            .last-form{
                /* margin-bottom: 90px; */

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
            <div class="profile-header">
                <div class="profile-avatar">
                    <div class="avatar">
                        <span><?php echo htmlspecialchars(strtoupper(sprintf('%s', $user_fname[0]))); ?></span>
                         <span><?php echo htmlspecialchars(strtoupper(sprintf('%s', $user_lname[0]))); ?></span>
                    </div>
                </div>
                    
                <h1><?php echo htmlspecialchars(strtoupper(sprintf('%s %s', $user_fname, $user_lname))); ?></h1>
                <h4 class="email" id="user_id">ID: <?php echo htmlspecialchars($user_id); ?></h4>
                <p class="location" ><?php echo htmlspecialchars($nationality); ?></p>
                <span class="badge">
                <?php echo htmlspecialchars($status); ?>
                </span>
            </div>

             <nav class="quick-actions">
                <a href="features.php" class="action-item">
                    <span class="icon">💰</span>
                    <span>Invests</span>
                </a>
                <a href="wallet_page.php" class="action-item">
                    <span class="icon">👛</span>
                    <span>Wallet</span>
                </a>
                <a href="deposit.php" class="action-item">
                    <span class="icon">⬇️</span>
                    <span>Receive</span>
                </a>
                <a href="send.php" class="action-item">
                    <span class="icon">⬆️</span>
                    <span>Send</span>
                </a>
            </nav>
    
            <section class="profile-section">
                <h2>Personal Details</h2>

                <?php
                if (isset($_SESSION['update_message']) && isset($_SESSION['update_time'])) {
                    $timeout_duration = 5; // Timeout in seconds
                    $time_elapsed = time() - $_SESSION['update_time'];

                    if ($time_elapsed <= $timeout_duration) {
                        $message = htmlspecialchars($_SESSION['update_message']);
                        $type = $_SESSION['update_type'] === "success" ? "green" : "red";
                        echo "<p style='color: $type;'>$message</p>";
                    }

                    if ($time_elapsed > $timeout_duration) {
                        unset($_SESSION['update_message']);
                        unset($_SESSION['update_type']);
                        unset($_SESSION['update_time']);
                    }
                }
                ?>


                <form class="profile-form" method="POST" action="">
                    <div class="form-group">
                        <label for="fname">First Name</label>
                        <input type="text" id="fname" name="fname" value="<?php echo htmlspecialchars(ucfirst($user_fname)); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="lname">Last Name</label>
                        <input type="text" id="lname" name="lname" value="<?php echo htmlspecialchars(ucfirst($user_lname)); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>
                    </div>
                    <button type="submit" name="update_profile" class="btn-primary">Update Profile</button>
                </form>
            </section>
            
            <?php if ($update_success): ?>
                <p style="color: green;"><?php echo htmlspecialchars($update_success); ?></p>
            <?php endif; ?>

    
            <section class="profile-section">
                <h2>Change Password</h2>
                <form class="profile-form" method="POST">
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" id="current_password" name="current_password" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" name="change_password_btn" class="btn-primary">Change Password</button>
                </form>

                <?php if ($update_success): ?>
                    <p style="color: green;"><?php echo htmlspecialchars($update_success); ?></p>
                <?php endif; ?>

                <?php if ($update_error): ?>
                    <p style="color: red;"><?php echo htmlspecialchars($update_error); ?></p>
                <?php endif; ?>
            </section>
            
            <section class="profile-section">
                <h2>KYC Information</h2>

                <!-- Display feedback messages -->
                <?php if (!empty($kyc_message)): ?>
                    <div class="alert <?= strpos($kyc_message, 'successfully') !== false ? 'alert-success' : 'alert-danger'; ?>">
                        <?= htmlspecialchars($kyc_message); ?>
                    </div>
                <?php endif; ?>

                <!-- KYC Form -->
                <form class="profile-form last-form"  action="" method="POST">
                    <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" name="dob" id="dob" value="<?= htmlspecialchars($dob); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" name="address" id="address" value="<?= htmlspecialchars($address); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="gov_id">Government ID Type</label>
                        <input type="text" name="gov_id" id="gov_id" placeholder="Passport" value="<?= htmlspecialchars($gov_id); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="id_number">ID Number</label>
                        <input type="text" name="id_number" id="id_number" value="<?= htmlspecialchars($id_number); ?>" required>
                    </div>
                    <button type="submit" name="submit_kyc" class="btn-primary">Submit KYC</button>
                </form>
            </section>
    
        </div>
        <script>
            import { getAuth, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/11.0.2/firebase-auth.js";
            import { getFirestore, doc, getDoc } from "https://www.gstatic.com/firebasejs/11.0.2/firebase-firestore.js";
            const auth = getAuth();
            const db = getFirestore();
    
            document.addEventListener("DOMContentLoaded", async () => {
            const userUID = sessionStorage.getItem("userUID");
            const showUserId = document.querySelector("#user_id"); // Element to show user UID
    
            if (!userUID) {
                alert("No user logged in. Redirecting to login...");
                window.location.href = "login.php";
                return;
            }
            try {
            // Fetch user details from Firestore
            const userDoc = await getDoc(doc(db, "users", userUID));
    
            if (userDoc.exists()) {
            const userData = userDoc.data();
            showUserId.innerHTML = `Welcome, ${userData.firstName}! (UID: ${userUID})`;
            } else {
                showUserId.innerHTML = `User data not found. UID: ${userUID}`;
            }
            } catch (error) {
                console.error("Error fetching user data:", error.message);
                showUserId.innerHTML = `Error loading user data`;
            }
        });
    
        </script>
    
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


 
    <!-- ============JAVASCRIPT-LINKS============= -->
    <script src="assets/user/javascript/popup.js"></script>
</body>
</html>

