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



// Include the database connection file
include 'connection.php';

// Get all users to display in the list
$query = "SELECT user_id, status FROM users";
$result = $conn->query($query);
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
    <title>Simart Pro</title>
    <link rel="icon" type="image/png" href="assets/images/logo.png">
    <link rel="stylesheet" href="assets/css/swap.css">
    <!-- <link rel="stylesheet" href="assets/css/users.css"> -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/mediaquery.css">
    <link rel="stylesheet" href="assets/css/main-mediaquery.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.4.5/css/swiper.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

    #toast {
    font-size: 14px;
    font-weight: bold;
    color: #fff;
    transition: all 0.5s ease-in-out;
    opacity: 0;
}

#toast.success {
    background-color: #4caf50; /* Green for success */
}

#toast.error {
    background-color: #f44336; /* Red for error */
}
  
</style>

<body>
    <?php


   include 'users_logic.php';

    $dropdownOptions =  [
        'Edit', 'Delete', 'Disable', 'Add Balance', 'Email', 'Verify Email', 'Verify KYC'
    ];
    ?>


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
    <style>
        
:root {
    
    --pending-color: #eab308;
    --background: #1a1a1a;
    --surface: #222222;
    --text-color: #F5F5F5;
    --secondary-text: #A9A9A9;
    --primary-dark: #A6841C;
    --primary-color: #6e591a;
    --border-color: #2A2A2A;
    --hover-color: rgba(255, 255, 255, 0.05);
    --positive-color: #00c853;
    --negative-color: #ff3d3d;
  }
  
  .box-body {
      /* max-width: 480px; */
      margin: 0 auto;
      padding: 16px;
    }
    
    /* Search Bar */
    .input-group-navbar {
      position: relative;
      margin-bottom: 24px;
    }
    
    .input-group-navbar input {
      width: 100%;
      padding: 12px 48px 12px 16px;
      background: var(--background);
      border: 1px solid var(--border-color);
      border-radius: 14px;
      font-size: 16px;
      transition: all 0.2s ease;
      color: var(--secondary-text);
      
    }
    .input-group-navbar input::placeholder{
      color: var(--secondary-text);
    }
    
    .input-group-navbar input:focus {
      outline: none;
      border-color: var(--primary-color);
      box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.1);
    }
    
    .input-group-navbar button {
      position: absolute;
      right: 8px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      padding: 8px;
      cursor: pointer;
      color: var(--secondary-text);
    }
    
    .error_message{
      padding: 8px;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background: rgba(190, 31, 55, 0.201);
      text-align: center;
      color: var(--negative-color);
      border-radius: 5px;
      transition: all 0.7s ease-in-out;
      font-size: 11px;
      font-weight: bold;
      width: 100%;
      letter-spacing: 0.8px;
      display: none;
    }
    
    /* User Cards */
    .table {
      display: grid;
      margin-top: 24px;
      gap: 20px;
    }
    
    .table tr {
      background: var(--surface);
      border-radius: 14px;
      padding: 16px;
      display: grid;
      grid-template-columns: auto 1fr auto;
      align-items: center;
      gap: 16px;
      box-shadow: 0 1px 9px rgba(0, 0, 0, 0.1);
      margin-bottom: 10px;
    }
    
    /* Avatar */
    .avatar {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      overflow: hidden;
      display: block;
    }
    
    .avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    
    /* User Info */
    .user-info {
      overflow: hidden;
    }
    
    .user-info strong {
      display: block;
      font-size: 16px;
      color: var(--text-color);
      margin-bottom: 4px;
    }
    
    .sidetitle {
      display: block;
      font-size: 14px;
      color: var(--secondary-text);
      margin-bottom: 4px;
    }
    
    .location {
      font-size: 14px;
      color: var(--secondary-text);
    }
    
    .balance {
      font-weight: 600;
      color: var(--primary-color);
    }
    
    /* Badge */
    .badge {
      display: inline-block;
      padding: 4px 8px;
      border-radius: 12px;
      font-size: 12px;
      font-weight: 500;
    }
    
    .badge-success {
      background-color: rgba(16, 185, 129, 0.1);
      color: var(--positive-color);
      margin-top: 7px;
    }
    
    /* Actions Dropdown */
    .btn-group {
      position: relative;
    }
    
    .dropdown-toggle {
      background: var(--background);
      border: 1px solid var(--border-color);
      border-radius: 50%;
      width: 36px;
      height: 36px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.2s ease;
      color: var(--secondary-text);
    }
    
    .dropdown-toggle:hover {
      background: var(--hover-color);
      color: var(--text-color);
    }
    
    .action-dropdown-menu {
      position: absolute;
      right: 20%;
      top: 100%;
      background: var(--card-bg);
      border-radius: 12px;
      padding: 8px 10px;
      margin-top: 8px;
      min-width: 180px;
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
      opacity: 0;
      visibility: hidden;
      transform: translateY(-10px);
      transition: all 0.2s ease;
      background: var(--background);
      z-index: 200;
    
    }
    
    .action-dropdown-menu.show {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }
    
    .dropdown-item {
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
    
    .dropdown-item:hover {
      background-color: var(--hover-color);
      color: var(--text-color);
    }
    
    .pagination {
      display: flex;
      justify-content: center;
      gap: 8px;
      margin-top: 24px;
      list-style: none;
    }
    
    .page-link {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 36px;
      height: 36px;
      border-radius: 50%;
      border: 1px solid var(--border-color);
      background: var(--background);
      color: var(--secondary-text);
      font-size: 14px;
      cursor: pointer;
      transition: all 0.2s ease;
    }
    
    .page-item.active .page-link {
      background: var(--primary-color);
      color: white;
      border-color: var(--primary-color);
    }
    
    .page-link:hover:not(.active) {
      background: var(--hover-color);
    }
    
    .spinner-grow {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      animation: spinner-grow 0.75s linear infinite;
      margin-right: 4px;
    }
  
    
    .d-none {
      display: none;
    }
    
    @media (max-width: 480px) {
      .table tr {
        /* grid-template-columns: auto 1fr; */
      }
      
      .btn-group {
        grid-column: span 2;
        justify-self: end;
      }
    }
  
  
  
    .bounce-in{
      animation: bounce-in 0.7s ease-out forwards;
  }
  /* @keyframes bounce-in {
      from,
      20%,
      40%,
      60%,
      80%,
      to {
          -webkit-animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
          animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
      }
  
      0% {
          opacity: 0;
          -webkit-transform: scale3d(0.3, 0.3, 0.3);
          transform: scale3d(0.3, 0.3, 0.3);
      }
  
      20% {
          -webkit-transform: scale3d(1.1, 1.1, 1.1);
          transform: scale3d(1.1, 1.1, 1.1);
      }
  
      40% {
          -webkit-transform: scale3d(0.9, 0.9, 0.9);
          transform: scale3d(0.9, 0.9, 0.9);
      }
  
      60% {
          opacity: 1;
          -webkit-transform: scale3d(1.03, 1.03, 1.03);
          transform: scale3d(1.03, 1.03, 1.03);
      }
  
      80% {
          -webkit-transform: scale3d(0.97, 0.97, 0.97);
          transform: scale3d(0.97, 0.97, 0.97);
      }
  
      to {
          opacity: 1;
          -webkit-transform: scale3d(1, 1, 1);
          transform: scale3d(1, 1, 1);
      }
  } */
  
  /* <!--  ADMIN - ACTIONS TO THE USERS --> */
  .edit_user,
  .delete_section,
  .add_balance,
  .send_email,
  .verify_kyc{
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
    width: 100%;
    z-index: 100000;
    height: 100vh;
    transition: all 0.6s ease;
    left: 0;
    right: 0;
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
  
  }
  .action_overlay > .wrapper > header{
    display: flex;
    justify-content: space-between;
    font-size: 20px;
    border-bottom: 1px solid rgba(128, 128, 128, 0.315);
    padding-bottom: 12px;
    cursor: default;
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
    padding-bottom: 20px;
}

  .action_overlay > .wrapper > main span{
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
    color: var(--text-clr);
    font-size: 1rem;
    transition: all 0.3s ease;
    width: 100%;
  
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
  
    </style>
    <main class="main_content">
        <div class="box-body" style="margin-top: 150px;">
            <div class="input-group-navbar">
                <input type="text" id="searchInput" class="form-control" placeholder="Search users by name or email">
                <button type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </div>
            <div id="error" class="error_message">No users found matching your search.</div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Avatar</th>
                            <th>User Info</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <!-- Avatar -->
                                <td>
                                    <a class="avatar" href="#">
                                        <img src="https://api.dicebear.com/6.x/initials/svg?seed=<?= urlencode($user['name']) ?>&backgroundColor=A6841C&textColor=ffffff" alt="<?= $user['name'] ?>'s Avatar">
                                    </a>
                                </td>

                                
                                <!-- User Info -->
                                <td class="user-info">
                                    <strong><?= htmlspecialchars($user['name']) ?></strong>
                                    <span class="sidetitle"><?= htmlspecialchars($user['user_id']) ?></span>
                                    <span class="sidetitle"><?= htmlspecialchars($user['email']) ?></span>
                                    <span class="location"><?= htmlspecialchars($user['nationality']) ?></span>
                                    <div class="balance">$<?= number_format($user['balance'], 2) ?></div>
                                    <span id="status-badge-<?= htmlspecialchars($user['user_id']) ?>" class="badge <?= $user['status'] === 'Enabled' ? 'badge-success' : ($user['status'] === 'Disabled' ? 'badge-fail' : 'badge-danger') ?>">
                                    <?= htmlspecialchars(ucfirst($user['status'])) ?>
                                    </span>

                                    <span class="badge <?= $user['kyc_status'] === 'Verified' ? 'badge-success' : ($user['kyc_status'] === 'Disabled' ? 'badge-danger' : 'badge-danger') ?>">
                                        <?= htmlspecialchars($user['kyc_status']) ?>
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td>
                                    <div class="btn-group">
                                        <button class="dropdown-toggle" onclick="toggleDropdown(this)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="12" cy="5" r="1"></circle>
                                                <circle cx="12" cy="19" r="1"></circle>
                                            </svg>
                                        </button>
                                        
                                        <div class="action-dropdown-menu">
                                            <button class="dropdown-item edit__user" name="edit" onclick="openEditUser('edit_user_<?= htmlspecialchars($user['user_id']) ?>')" >Edit</button>
                                            <button class="dropdown-item delete" name="delete" onclick="openDeleteUser('delete_user_<?= htmlspecialchars($user['user_id']) ?>')">Delete</button>
                                            <button class="dropdown-item toggle-status" 
                                                    id="toggle-button-<?= htmlspecialchars($user['user_id']) ?>" 
                                                    data-user-id="<?= htmlspecialchars($user['user_id']) ?>" 
                                                    data-status="<?= htmlspecialchars($user['status']) ?>">
                                                <?= $user['status'] === 'enabled' ? 'Disable' : 'Enable' ?>
                                            </button>




                                            <button class="dropdown-item add__balance" name="add_balance" onclick="openAddBalance('add_balance_<?= htmlspecialchars($user['user_id']) ?>')">Add Balance</button>
                                            <button class="dropdown-item send__email" name="send_email"  onclick="openSendEmail('send_email_<?= htmlspecialchars($user['user_id']) ?>')">Email</button>
                                            <button class="dropdown-item verify__kyc" name="verify_kyc"  onclick="openVerifyKyc('verify_kyc_<?= htmlspecialchars($user['user_id']) ?>')">Verify KYC</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            
                            
                            <script>
                                $(document).ready(function () {
                                // Button click event for toggling the user status
                                $('.toggle-status').on('click', function () {
                                    const $button = $(this);  // The clicked button
                                    const userId = $button.data('user-id');  // User ID
                                    let currentStatus = $button.data('status');  // Current status from the data-status attribute
                                    let newStatus = currentStatus === 'enabled' ? 'disabled' : 'enabled';  // Toggle status

                                    // Optimistically update the UI (button text and badge color)
                                    $button.text(newStatus === 'enabled' ? 'Disable' : 'Enable');
                                    $button.data('status', newStatus);

                                    const $badge = $('#status-badge-' + userId);  // Badge element for status
                                    if (newStatus === 'enabled') {
                                        $badge.removeClass('badge-fail badge-danger').addClass('badge-success').text('Enabled');
                                    } else {
                                        $badge.removeClass('badge-success badge-danger').addClass('badge-fail').text('Disabled');
                                    }

                                    // Send AJAX request to update the status in the backend
                                    $.ajax({
                                        url: 'update_user_status.php',  // Backend script to update the status
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            user_id: userId,
                                            status: newStatus
                                        },
                                        success: function (response) {
                                            if (response.success) {
                                                console.log('Backend updated successfully:', response);
                                            } else {
                                                alert('Failed to update the status: ' + response.message);

                                                // Revert UI changes if the backend update fails
                                                $button.text(currentStatus === 'enabled' ? 'Disable' : 'Enable');
                                                $button.data('status', currentStatus);

                                                if (currentStatus === 'enabled') {
                                                    $badge.removeClass('badge-fail').addClass('badge-success').text('Enabled');
                                                } else {
                                                    $badge.removeClass('badge-success').addClass('badge-fail').text('Disabled');
                                                }
                                            }
                                        },
                                        error: function () {
                                            alert('An error occurred while updating the status.');

                                            // Revert UI changes if the AJAX request fails
                                            $button.text(currentStatus === 'enabled' ? 'Disable' : 'Enable');
                                            $button.data('status', currentStatus);

                                            if (currentStatus === 'enabled') {
                                                $badge.removeClass('badge-fail').addClass('badge-success').text('Enabled');
                                            } else {
                                                $badge.removeClass('badge-success').addClass('badge-fail').text('Disabled');
                                            }
                                        }
                                    });
                                });
                            });

                            </script>






                                                
                            <!-- EDIT DEVELOPERS DETAILS -->
                            <section class="edit_user action_overlay" id="edit_user_<?= htmlspecialchars($user['user_id']) ?>">
                                <div class="wrapper">
                                    <header>
                                        <h4>
                                            Edit <strong><?= htmlspecialchars($user['name']) ?> </strong>'s Details
                                        </h4>
                                        <img class="close_action" src="assets/images/c-close-svgrepo-com.svg" alt="" width="20">
                                    </header>
                                    <main style="display:flex; flex-direction:column; gap:10px;">
                                    <form action="users_logic.php" method="POST">
                                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['user_id']) ?>">
                                        <label for="firstname">First name*</label>
                                        <input id="firstname" name="firstname" value="<?= htmlspecialchars($user['name']) ?>" type="text" placeholder="Name*" style="width: 100%;">
                                        <label for="lastname">Last name*</label>
                                        <input id="lastname" name="lastname" value="<?= htmlspecialchars($user['lastname']) ?>" type="text" placeholder="Name*" style="width: 100%;">
                                        <label for="email" >Email*</label>
                                        <input id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" type="email" placeholder="Email*" style="width: 100%;">
                                        <label for="phone_No">Phone No.*</label>
                                        <input id="phone_No" name="phone_No" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" type="text" placeholder="Phone no.*" style="width: 100%;">
                                        <label for="gender">Gender*</label>
                                        <select id="gender" name="gender" style="width: 100%;">
                                            <option value="Male" <?= ($user['gender'] ?? '') === 'Male' ? 'selected' : '' ?>>Male</option>
                                            <option value="Female" <?= ($user['gender'] ?? '') === 'Female' ? 'selected' : '' ?>>Female</option>
                                        </select>
                                    </main>
                                    <div style="display: flex; gap:10px;">
                                            <button id="close" class="close_action negative_btn" type="button">Close</button>
                                            <button id="delete_btn" class="positive_btn" name="button" type="submit">Save Changes</button>
                                    </form>
                               </div>
                            </div>
                            </section>
                        

                        <!-- DELETE USER -->
                        <section class="delete_section action_overlay" id="delete_user_<?= htmlspecialchars($user['user_id']) ?>">
                            <div class="wrapper">
                                <header>
                                    <h5>
                                        Delete <strong><?= htmlspecialchars($user['name']) ?></strong>'s Details
                                    </h5>
                                    <img class="close_action" src="assets/images/c-close-svgrepo-com.svg" alt="" width="20">
                                </header>
                                <main class="question">
                                    <span>Are you sure you want to delete <strong><?= htmlspecialchars($user['name']) ?></strong>'s details?</span>
                                </main>
                                <div style="display: flex; gap: 10px;">
                                    <form action="delete_logic.php" method="POST">
                                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['user_id']) ?>">
                                        <button id="close" class="close_action negative_btn" type="button">Close</button>
                                        <button id="delete_btn" class="positive_btn" name="button" type="submit">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </section>

                        <!-- ADD BALANCE -->
                        <section class="add_balance action_overlay" id="add_balance_<?= htmlspecialchars($user['user_id']) ?>">
                            <div class="wrapper">
                                <header>
                                    <h4>Add Balance</h4>
                                    <img class="close_action" src="assets/images/c-close-svgrepo-com.svg" alt="" width="20">
                                </header>
                                <main>
                                    <form action="add_balance_logic.php" method="POST">
                                        <div style="width: 100%; display: flex; flex-direction:column; gap:8px;">
                                                      
                                            <input style="width: 100%;" type="hidden" name="user_id" value="<?= htmlspecialchars($user['user_id']) ?>">

                                            <select style="width: 100%;" name="wallet" id="wallet_<?= htmlspecialchars($user['user_id']) ?>" required>
                                                <option value="">Select Wallet</option>
                                                <option value="BTC">BTC</option>
                                                <option value="USDT">USDT</option>
                                                <option value="ETH">ETH</option>
                                                <option value="DOGE">DOGE</option>
                                                <option value="BNB">BNB</option>
                                                <option value="SHIB">SHIB</option>
                                                <option value="LTC">LTC</option>
                                                <option value="XRP">XRP</option>
                                            </select>

                                            <input style="width: 100%;" type="number" name="amount" placeholder="Enter amount" required>

                                            <div style="display: flex; gap: 10px; margin-top: 10px;">
                                                <button id="close" class="close_action negative_btn" type="button">Close</button>
                                                <button id="send_btn" class="positive_btn" name="send" type="submit">Send</button>
                                            </div>
                                        </div>

                                    </form>
                                </main>
                            </div>
                        </section>

                        <!-- SEND EMAIL -->
                        <section class="send_email action_overlay" id="send_email_<?= htmlspecialchars($user['user_id']) ?>">
                            <div class="wrapper">
                                <form action="send_email.php" method="POST" enctype="multipart/form-data">
                                <header>
                                    <h4>Send Email</h4>
                                    <img class="close_action" src="assets/images/c-close-svgrepo-com.svg" alt="" width="20">
                                </header>
                                <main style="display:flex; flex-direction:column; gap:10px;">
                                    <!-- Subject Input -->
                                    <input type="text" name="subject" placeholder="Subject*" style="width: 100%;" required>
                                    
                                    <!-- Message Input -->
                                    <textarea name="message" id="<?= htmlspecialchars($user['user_id']) ?>" placeholder="Message*" required></textarea>
                                    
                                    <p>Enable / Disable Notification</p>
                                    
                                    <!-- File Input (optional for attachments) -->
                                    <input type="file" name="attachment" id="attachment">
                                </main>
                                <div style="display: flex; gap:10px;">
                                    <!-- Form to Send Email -->
                                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['user_id']) ?>">
                                        
                                        <button id="close" class="close_action negative_btn" type="button">Close</button>
                                        <button id="send_email_btn" class="positive_btn" type="submit">Send Mail</button>
                                    </form>
                                </div>
                            </div>
                        </section>


                        
                        <!-- VERIFY KYC -->
                        <section class="verify_kyc action_overlay" id="verify_kyc_<?= htmlspecialchars($user['user_id']) ?>">
                            <div class="wrapper">
                                <header>
                                    <h4>
                                        Approve/Decline KYC
                                    </h4>
                                    <img class="close_action" src="assets/images/c-close-svgrepo-com.svg" alt="" width="20">
                                </header>
                                <main style="display:flex; flex-direction:column; gap:10px;">
                                    <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['user_id']) ?>">
                                    <input type="text" placeholder="Date of Birth*" style="width: 100%;" value="<?= htmlspecialchars($user['dob']) ?>">
                                    <input type="text" placeholder="Address*" style="width: 100%;" value="<?= htmlspecialchars($user['address']) ?>">
                                    <input type="text" placeholder="Government Issued ID*" style="width: 100%;" value="<?= htmlspecialchars($user['gov_id']) ?>">
                                    <input type="text" placeholder="Identity Number*" style="width: 100%;" value="<?= htmlspecialchars($user['id_number']) ?>">

                                </main>
                                <div style="display: flex; gap:10px;">
                                <form action="decline_kyc_status.php" method="POST">
                                    <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['user_id']) ?>">
                                    <button class="negative_btn" type="submit" name="decline_kyc">Decline</button>
                                </form>
                                    <form action="update_kyc_status.php" method="POST">
                                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['user_id']) ?>">
                                        <button id="approve_btn" class="positive_btn" name="approve_kyc" type="submit">Approve</button>
                                    </form>
                               </div>
                            </div>
                        </section>
                        

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>


            <nav>
                <ul class="pagination" id="pagination"></ul>
            </nav>
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
    <!--  ADMIN - ACTIONS TO THE USERS -->


    <script src="assets/user/javascript/popup.js"></script>
    <!-- <script src="assets/user/javascript/action_popup.js"></script> -->
    <script>
            let currentPage = 1;
            const usersPerPage = 10;

            const searchInput = document.getElementById('searchInput');
            const usersTableBody = document.getElementById('usersTableBody');
            const paginationContainer = document.getElementById('pagination');

            let filteredUserRows = [];

            const getAllUserRows = () => Array.from(document.querySelectorAll('#usersTableBody tr'));

            const renderUsersForPage = (page) => {
                const startIndex = (page - 1) * usersPerPage;
                const endIndex = startIndex + usersPerPage;

                getAllUserRows().forEach(row => row.style.display = 'none'); // Hide all rows
                filteredUserRows.slice(startIndex, endIndex).forEach(row => row.style.display = ''); // Show filtered rows
            };

            const createPagination = () => {
                const totalPages = Math.ceil(filteredUserRows.length / usersPerPage);
                let paginationHTML = '';

                paginationHTML += `
                    <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                        <button class="page-link" onclick="changePage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>‹</button>
                    </li>
                `;

                for (let i = 1; i <= totalPages; i++) {
                    paginationHTML += `
                        <li class="page-item ${currentPage === i ? 'active' : ''}">
                            <button class="page-link" onclick="changePage(${i})">${i}</button>
                        </li>
                    `;
                }

                paginationHTML += `
                    <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                        <button class="page-link" onclick="changePage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>›</button>
                    </li>
                `;

                paginationContainer.innerHTML = paginationHTML;
            };

            const changePage = (page) => {
                const totalPages = Math.ceil(filteredUserRows.length / usersPerPage);

                if (page >= 1 && page <= totalPages) {
                    currentPage = page;
                    renderUsersForPage(currentPage);
                    createPagination();
                }
            };

            const handleSearch = () => {
                const searchTerm = searchInput.value.toLowerCase();
                const allUserRows = getAllUserRows();

                filteredUserRows = allUserRows.filter((row) => {
                    const name = row.querySelector('.user-info strong')?.textContent.toLowerCase();
                    const email = row.querySelector('.sidetitle')?.textContent.toLowerCase();
                    return name.includes(searchTerm) || email.includes(searchTerm);
                });

                document.getElementById('error').style.display = filteredUserRows.length ? 'none' : 'block';

                currentPage = 1;
                createPagination();
                renderUsersForPage(currentPage);
            };

            const toggleDropdown = (button) => {
                const dropdown = button.nextElementSibling;
                document.querySelectorAll('.action-dropdown-menu.show').forEach(menu => {
                    if (menu !== dropdown) menu.classList.remove('show');
                });
                dropdown.classList.toggle('show');
            };

            document.addEventListener('click', (event) => {
                const isDropdownButton = event.target.closest('.dropdown-toggle');
                const isDropdownMenu = event.target.closest('.action-dropdown-menu');

                if (!isDropdownButton && !isDropdownMenu) {
                    document.querySelectorAll('.action-dropdown-menu.show').forEach(menu => {
                        menu.classList.remove('show');
                    });
                }
            });


            searchInput.addEventListener('input', handleSearch);
            document.addEventListener('DOMContentLoaded', () => {
                filteredUserRows = getAllUserRows(); 
                renderUsersForPage(currentPage);
                createPagination();
            });

    </script>


<script>
    function openEditUser(sectionId) {
        const section = document.getElementById(sectionId);
        if (!section) return; 

        document.querySelectorAll('.edit_user').forEach(sec => {
            sec.style.visibility = 'hidden';
            sec.style.opacity = '0';
        });

        section.style.visibility = 'visible';
        section.style.opacity = '1';
    }

    function openDeleteUser(sectionId) {
        const section = document.getElementById(sectionId);
        if (!section) return; 

        document.querySelectorAll('.delete_section').forEach(sec => {
            sec.style.visibility = 'hidden';
            sec.style.opacity = '0';
        });

        section.style.visibility = 'visible';
        section.style.opacity = '1';
    }
    function openAddBalance(sectionId) {
        const section = document.getElementById(sectionId);
        if (!section) return; 

        document.querySelectorAll('.add_balance').forEach(sec => {
            sec.style.visibility = 'hidden';
            sec.style.opacity = '0';
        });

        section.style.visibility = 'visible';
        section.style.opacity = '1';
    }
    function openSendEmail(sectionId) {
        const section = document.getElementById(sectionId);
        if (!section) return; 

        document.querySelectorAll('.send_email').forEach(sec => {
            sec.style.visibility = 'hidden';
            sec.style.opacity = '0';
        });

        section.style.visibility = 'visible';
        section.style.opacity = '1';
    }

    function openVerifyKyc(sectionId) {
        const section = document.getElementById(sectionId);
        if (!section) return; 

        document.querySelectorAll('.verify_kyc').forEach(sec => {
            sec.style.visibility = 'hidden';
            sec.style.opacity = '0';
        });

        section.style.visibility = 'visible';
        section.style.opacity = '1';
    }







    
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
<!-- <script>
    document.querySelector('form').addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent the default form submission
        const formData = new FormData(this);

        fetch('users_logic.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showToast(data.message, 'success');
            } else {
                showToast(data.message, 'error');
            }
        })
        .catch(error => {
            showToast('An unexpected error occurred.', 'error');
            console.error('Error:', error);
        });
    });

    function showToast(message, type) {
        const toast = document.getElementById('toast');
        const toastMessage = document.getElementById('toast-message');

        // Set toast message and type
        toastMessage.textContent = message;
        toast.className = type; // Apply success or error class
        toast.style.opacity = 1; // Make the toast visible
        toast.style.display = 'block';

        // Automatically hide the toast after 3 seconds
        setTimeout(() => {
            toast.style.opacity = 0; // Fade out effect
            setTimeout(() => {
                toast.style.display = 'none';
                toast.className = ''; // Reset class after hiding
            }, 500);
        }, 3000);
    }
</script> -->
