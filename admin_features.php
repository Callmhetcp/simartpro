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
      <!-- <link rel="stylesheet" href="assets/css/features.css"> -->
      <link rel="stylesheet" href="assets/css/main.css">
      <link rel="stylesheet" href="assets/css/style.css">
      <link rel="stylesheet" href="assets/css/mediaquery.css">
      <link rel="stylesheet" href="assets/css/main-mediaquery.css">
      <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.4.5/css/swiper.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css">
      <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  
  
  
      <!-- ============FONT-AWESOME-LINKS============= -->
      <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>


  


        <style>
            html{
    animation: none;
  }
  :root {
--background: #1a1a1a;
--surface: #222222;
--text-color: #F5F5F5;
--secondary-text: #A9A9A9;
--primary-dark: #f3f2ef;
--primary-color: #cccccc;
--border-color: #2A2A2A;
--hover-color: rgba(255, 255, 255, 0.05);
--positive-color: #00c853;
--negative-color: #ff0000;

}
* {
margin: 0;
padding: 0;
box-sizing: border-box;
}

body {
min-height: 100vh;
color: white;
padding: 2rem;
}

.investment-header {
position: relative;
margin-bottom: 2rem;
}

.investment-title {
font-size: 1.5rem;
font-weight: 500;
cursor: pointer;
display: flex;
align-items: center;
gap: 0.5rem;
}

.investment-title::after {
content: '';
display: inline-block;
width: 0;
height: 0;
border-left: 5px solid transparent;
border-right: 5px solid transparent;
border-top: 5px solid white;
margin-top: 3px;
}

.dropdown {
position: absolute;
top: 100%;
left: 0;
background: var(--surface);
border-radius: 8px;
padding: 0.5rem;
min-width: 200px;
display: none;
z-index: 10;
box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.dropdown.active {
display: block;
}

.dropdown-item {
padding: 0.75rem 1rem;
cursor: pointer;
border-radius: 4px;
transition: background-color 0.2s;
}

.dropdown-item:hover {
background-color: var(--hover-color);
}

.cards-container {
display: grid;
grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
gap: 1.5rem;
max-width: 1200px;
}

.card {
background: var(--surface);
border-radius: 12px;
padding: 2rem;
position: relative;
}

.card-header {
position: relative;
margin-bottom: 1rem;
cursor: pointer;
}

.card-header::after {
content: '';
display: inline-block;
width: 0;
height: 0;
border-left: 5px solid transparent;
border-right: 5px solid transparent;
border-top: 5px solid white;
position: absolute;
right: 0;
top: 50%;
transform: translateY(-50%);
}

.card-title {
font-size: 1.25rem;
font-weight: 500;
margin-bottom: 1.5rem;
}

.select-button {
background: var(--background);
border: none;
color: var(--secondary-text);
padding: 0.75rem 1rem;
border-radius: 6px;
cursor: pointer;
width: 100%;
text-align: left;
font-size: 0.875rem;
}

.select-button::after {
content: '';
display: inline-block;
width: 0;
height: 0;
border-left: 4px solid transparent;
border-right: 4px solid transparent;
border-top: 4px solid #94a3b8;
margin-left: 0.5rem;
vertical-align: middle;
}

.select-button:hover {
background-color: var(--hover-color); 

}

/* Modal Styles */
.modal {
height: 100vh;
position: fixed;
width: 100%;
max-width: 100vw;
background: #000000b1;
backdrop-filter: blur(8px); 
top: 0;
width: 100%;
z-index: 80000000;
transition: all 0.6s ease;
left: 0;
right: 0;
display: grid;
place-content: center;
place-items: center;
overflow-y: scroll;
scrollbar-width: none;
opacity: 0;
visibility: hidden;

}

.modal.active {
opacity: 1;
visibility: visible;


}

.modal-content {
background: var(--surface);
padding: 20px;
display: flex;
flex-direction: column;
border-radius: 10px;
justify-content: center;
width: 420px;



}



.modal-title {
margin-bottom: 1.5rem;
font-size: 1.25rem;
}

.modal-input {
background-color: var(--background);
border: 1px solid rgba(128, 128, 128, 0.315);
padding: 0.50rem 0.6rem;
color: var(--text-color);
font-size: 1rem;
transition: all 0.3s ease;
border-radius: 4px;
width: 100%;
margin-bottom: 25px;
}

.modal-input:focus {
outline: none;
border-color: var(--primary-color);
box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.1);
}

.modal-buttons {
display: flex;
gap: 1rem;
justify-content: flex-end;
}

.modal-button {
padding: 0.75rem 1.5rem;
border: none;
border-radius: 6px;
cursor: pointer;
font-size: 0.875rem;
transition: background-color 0.2s;
}
.modal-button.cancel {
background: var(--text-color);
color: var(--background);

}

.modal-button.confirm {
background: var(--primary-color);
color: white;
}

.modal-button:hover {
/* opacity: 0.9; */
}

/* Card Dropdown Styles */
.card-dropdown {
position: absolute;
top: 100%;
right: 0;
background: var(--surface);
border-radius: 8px;
padding: 0.5rem;
min-width: 150px;
display: none;
z-index: 10;
box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.card-dropdown.active {
display: block;
}

.card-dropdown-item {
padding: 0.75rem 1rem;
cursor: pointer;
border-radius: 4px;
transition: background-color 0.2s;
}

.card-dropdown-item:hover {
background-color: var(--hover-color);
}

/* Selection Options Styles */
.selection-options {
display: none;
background: var(--background);
border-radius: 8px;
padding: 1rem;
margin-top: 1rem;
}

.selection-options.active {
display: block;
}

.selection-options h6 {
font-size: 1rem;
margin-bottom: 0.5rem;
}

.selection-options a {
display: block;
padding: 0.5rem;
color: #94a3b8;
text-decoration: none;
transition: background-color 0.2s, color 0.2s;
border-radius: 4px;
}

.selection-options a:hover {
background-color: var(--surface);
color: white;
}











.plans-header {

background-color: var(--surface);
padding: 1.5rem;
border-bottom: 1px solid var(--border-color);
margin-top: 50px;
}

.dropdown-arrow{
margin-top: 10px;
content: '';
display: inline-block;
width: 0;
height: 0;
border-left: 7px solid transparent;
border-right: 7px solid transparent;
border-top: 7px solid white;
cursor:pointer;   
}
.plans-header-dropdown{
position: absolute;
background: var(--background);
border-radius: 8px;
padding: 0.5rem;
display: none;
z-index: 10;
margin-top: 20px;

box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
.plans-header-dropdown.active{
display: block;

}

.plans-header-dropdown-item {
padding: 0.75rem 1rem;
cursor: pointer;
text-align: left;
border-radius: 4px;
transition: background-color 0.2s;
}

.plans-header-dropdown-item:hover {
background-color: var(--hover-color);
}

.header-content {
max-width: 1200px;
margin: 0 auto;
display: flex;
justify-content: space-between;
align-items: center;
}

.header-left h1 {
font-size: 1.5rem;
margin-bottom: 0.5rem;
}

.header-left h4 {
color: var(--secondary-text);
font-weight: normal;
font-size: 0.9rem;
}

.btn-back {
background-color: var(--surface);
color: var(--text-color);
border: 1px solid var(--border-color);
padding: 0.5rem 1rem;
border-radius: 0.5rem;
cursor: pointer;
transition: background-color 0.2s;
}

.btn-back:hover {
background-color: var(--hover-color);
}

.container {
max-width: 1200px;
margin: 2rem auto;
padding: 0 1rem;
}

.plans-container {
display: grid;
grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
gap: 1.5rem;
}

.plans-card {
background-color: var(--surface);
border: 1px solid var(--border-color);
border-radius: 1rem;
overflow: hidden;
transition: transform 0.2s;
}


.plans-card-header {
background-color: var(--hover-color);
padding: 1rem;
text-align: center;
display:flex;
gap: 40px;
align-items:center;
justify-content:center;

}
.plans-card-header:after {
content: '';
display: inline-block;
width: 0;
height: 0;
border-left: 5px solid transparent;
border-right: 5px solid transparent;
border-top: 5px solid white;
margin-top: 3px;
cursor:pointer;
}

.plans-card-header h5 {
font-size: 1.1rem;
cursor: pointer;
}
.edit_mining_popup,
.delete_mining_popup,
.add_plan_popup,
.delete_plan_popup,
.edit_plan_popup,
.invest_popup{
visibility: hidden;
opacity: 0;

}
.action_overlay{
height: 100vh;
position: fixed;
width: 100%;
max-width: 100vw;
background: #000000b1;
backdrop-filter: blur(8px); 
top: 0;
width: 100%;
z-index: 80000000;
transition: all 0.6s ease;
left: 0;
right: 0;
display: grid;
place-content: center;
place-items: center;
overflow-y: scroll;
scrollbar-width: none;
padding-top: 400px;
padding-bottom: 30px;




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
font-size: 18px;
border-bottom: 1px solid rgba(128, 128, 128, 0.315);
padding-bottom: 20px
}
.action_overlay > .wrapper > main form{
display: flex;
flex-direction: column;
gap: 8px;

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
text-align: left;
margin-left: 5px;
}
.action_overlay > .wrapper > main input,
.action_overlay > .wrapper > main textarea{
background-color: var(--background);
border: 1px solid rgba(128, 128, 128, 0.315);
padding: 0.50rem 0.6rem;
color: var(--text-clr);
font-size: 1rem;
transition: all 0.3s ease;
width: 200px;
border-radius: 8px;

}
.action_overlay > .wrapper > main select:focus,
.action_overlay > .wrapper > main input:focus,
.action_overlay > .wrapper > main textarea:focus{

outline: none;
border-color: var(--primary-color);
box-shadow: 0 0 0 4px rgba(94, 99, 255, 0.1);
}

.rate{
display: flex;
align-items: center;
width: 100%;
gap: 0;
justify-content: start;
padding: 10px;
position: relative;
flex-direction: row-reverse;
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






.plans-card-dropdown{
position: absolute;
background: var(--background);
border-radius: 7px;
box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
padding: 0.5rem;
text-align: left;
display: none;
margin-left: 20px;
margin-top: 8px;
}
.plans-card-dropdown-item{
padding: 0.75rem 1rem;
cursor: pointer;
border-radius: 4px;
transition: background-color 0.2s;
font-size: 13px;
}


.plans-card-dropdown-item:hover {
background-color: var(--hover-color);
}


.card-body {
padding: 1.5rem;
}

.card-body-content {
margin-bottom: 1.5rem;
}

.price-range {
display: flex;
align-items: center;
justify-content: center;
gap: 1rem;
margin-bottom: 1.5rem;
}

.price-range h2 {
font-size: 1.2rem;
}

.price-range i {
color: var(--secondary-text);
}

h6 {
color: var(--secondary-text);
margin-bottom: 0.5rem;
}

ul {
list-style: none;
}

.plans-card li {
color: var(--secondary-text);
margin-bottom: 0.5rem;
padding-left: 1.5rem;
position: relative;
}

.plans-card li::before {
content: "•";
color: var(--primary-color);
position: absolute;
left: 0;
}



.button-wrapper {
text-align: center;
}

.btn-invest {
background-color: var(--primary-color);
color: var(--text-color);
border: none;
padding: 0.75rem 2rem;
border-radius: 0.5rem;
cursor: pointer;
font-weight: 500;
transition: background-color 0.2s;
width: 100%;
}

.btn-invest:hover {
background-color: var(--primary-dark);
}

@media (max-width: 768px) {
.header-content {
  flex-direction: column;
  gap: 1rem;
  text-align: center;
}

.plans-container {
  grid-template-columns: 1fr;
  padding-bottom: 70px;
}
}

        </style>

  </head>



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
<!--  -->
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
      
      <main class="main_content" style="padding: 20px;">

        <div class="investment-header">
            <h1 class="investment-title">Investment</h1>
            <div class="dropdown">
                <div class="dropdown-item" id="createInvestment">Create Investment</div>
                <div class="dropdown-item">Generate Plan</div>
            </div>
        </div>

        <div class="cards-container" id="cardsContainer">
            <!-- <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Crypto Currency</h2>
                </div>
                <button class="select-button">Select Option</button>
                <div class="selection-options crypto-options">
                    <h6>Crypto Currency Investment Options</h6>
                    <a>Bitcoin</a>
                    <a>Ethereum</a>
                    <a>Binance Coin</a>
                    <a>Litecoin</a>
                    <a>Dogecoin</a>
                    <a>XRP</a>
                    <a>Shiba Inu</a>
                    <a>USDT</a>
                </div>
                <div class="card-dropdown">
                    <div class="card-dropdown-item edit">Edit</div>
                    <div class="card-dropdown-item delete">Delete</div>
                    <div class="card-dropdown-item add-option">Add Option</div>
                </div>
            </div> -->

            <!-- <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Forex</h2>
                </div>
                <button class="select-button">Select Option</button>
                <div class="selection-options forex-options">
                    <h6>Forex Investment Options</h6>
                    <a>USD/CAD</a>
                    <a>EUR/USD</a>
                    <a>USD/CHF</a>
                    <a>GBP/USD</a>
                    <a>NZD/USD</a>
                    <a>EUR/GBP</a>
                    <a>EUR/CAD</a>
                    <a>EUR/AUD</a>
                    <a>GBP/CHF</a>
                    <a>EUR/JPY</a>
                </div>
                <div class="card-dropdown">
                    <div class="card-dropdown-item edit">Edit</div>
                    <div class="card-dropdown-item delete">Delete</div>
                    <div class="card-dropdown-item add-option">Add Option</div>
                </div>
            </div> -->
<!-- 
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Stocks</h2>
                </div>
                <button class="select-button">Select Option</button>
                <div class="selection-options stocks-options">
                    <h6>Stocks Investment Options</h6>
                    <a>Advanced Micro Devices Inc</a>
                    <a>GameStop Corporation</a>
                    <a>Cassava Sciences Inc</a>
                    <a>Alpha Metallurgical Resources Inc</a>
                    <a>Danaos Corp</a>
                    <a>Cleveland-Cliffs Inc</a>
                    <a>Movado Group Inc</a>
                    <a>Aerocentury Corp</a>
                    <a>NVIDIA Corporation</a>
                    <a>Microsoft Corporation</a>
                </div> -->
                <div class="card-dropdown">
                    <div class="card-dropdown-item edit">Edit</div>
                    <div class="card-dropdown-item delete">Delete</div>
                    <div class="card-dropdown-item add-option">Add Option</div>
                </div>
            </div>
        </div>






        <!-- Create Investment Modal -->
        <div class="modal" id="createModal">
            <div class="modal-content">
                <h2 class="modal-title">Create New Investment</h2>
                <input type="text" class="modal-input" placeholder="Enter investment name" id="investmentName">
                <div class="modal-buttons">
                    <button class="modal-button cancel" id="cancelCreateButton">Cancel</button>
                    <button class="modal-button confirm" id="confirmCreateButton">Create New</button>
                </div>
            </div>
        </div>

        <!-- Edit Investment Modal -->
        <div class="modal" id="editModal">
            <div class="modal-content">
                <h2 class="modal-title">Edit Investment</h2>
                <input type="text" class="modal-input" placeholder="Enter new investment name" id="editInvestmentName">
                <div class="modal-buttons">
                    <button class="modal-button cancel" id="cancelEditButton">Cancel</button>
                    <button class="modal-button confirm" id="confirmEditButton">Save</button>
                </div>
            </div>
        </div>
 
        <!-- Delete Confirmation Modal -->
        <div class="modal" id="deleteModal">
            <div class="modal-content">
                <h2 class="modal-title">Confirm Delete</h2>
                <p>Are you sure you want to delete this investment?</p>
                <div class="modal-buttons">
                    <button class="modal-button cancel" id="cancelDeleteButton">Cancel</button>
                    <button class="modal-button confirm" id="confirmDeleteButton">Confirm</button>
                </div>
            </div>
        </div>

        <!-- Create Investment Modal -->
        <div class="modal" id="addOption">
            <div class="modal-content">
                <h2 class="modal-title">Create New Option</h2>
                <input type="text" class="modal-input" placeholder="Name" id="crypto_name">
                <input type="text" class="modal-input" placeholder="Symbol" id="symbol">
                <div class="modal-buttons">
                    <button class="modal-button cancel" id="cancelAddOptionButton">Close</button>
                    <button class="modal-button confirm" id="confirmAddOptionButton">Add New</button>
                </div>
            </div>
        </div>
        <!-- ///// -->










        <!-- PLANS -->
        <header class="plans-header" id="plans-header" style="display: none;">

            <div class="header-content" >
                <div class="header-left" >
                    <h1>XRP</h1>
                    <h4>Stake from $0.00 (0.00 XRP) wallet</h4>
                    <div class="dropdown-arrow">

                        <div class="plans-header-dropdown">
                            <!-- names from  the backend -->
                            <div class="plans-header-dropdown-item edit_plan">Edit <!-- from the backend --></div>
                            <div class="plans-header-dropdown-item delete_plan">Delete </div>
                            <div class="plans-header-dropdown-item add_plan">Add plan </div>
                            <div class="plans-header-dropdown-item  link_crypto">Link to crypto </div>
                        </div>
                    </div>
                </div>
                <button class="btn-back">Back</button>
            </div>


            <!-- ADD PLAN -->
            <section class="add_plan_popup action_overlay" id="">
                <div class="wrapper">
                    <header>
                        <h4>
                            Create new plan
                        </h4>
                        <img class="close_addplan_popup" src="assets/images/c-close-svgrepo-com.svg" alt="Close" width="20">
                    </header>
                    <main style="display:flex; flex-direction:column; gap:10px;">
                        <form id="addPlanForm">
                            <!-- Hidden field for crypto_id which will be dynamically set -->
                            <input type="hidden" id="selected_crypto_id" name="crypto_id" value="">

                            <label for="name">Name*</label>
                            <input id="name" name="name" value="" type="text" placeholder="Name*" style="width: 100%;" required>

                            <label for="roi">ROI*</label>
                            <input id="roi" name="roi" value="" type="text" placeholder="Enter ROI" style="width: 100%;" required>

                            <label for="roi_max">ROI Max*</label>
                            <input id="roi_max" name="roi_max" value="" type="text" placeholder="Enter ROI Max" style="width: 100%;" required>

                            <label for="minimum">Minimum*</label>
                            <input id="minimum" name="minimum" value="" type="text" placeholder="Enter Minimum" style="width: 100%;" required>

                            <label for="maximum">Maximum*</label>
                            <input id="maximum" name="maximum" value="" type="text" placeholder="Enter Maximum" style="width: 100%;" required>

                            <label for="earning_duration">Earning Duration*</label>
                             <select id="earning_duration" name="earning_duration" style="width: 100%;" required>
                                <option value="">Choose</option>
                                <option value="5">Every Five Minutes</option>
                                <option value="10">Every Ten Minutes</option>
                                <option value="30">Every Thirty Minutes</option>
                                <option value="60">Hourly</option>
                                <option value="360">Every Six Hours</option>
                                <option value="1440">Daily</option>
                                <option value="720">Twice Daily</option>
                            </select>

                            <label for="duration_timeframe">Duration Timeframe*</label>
                            <input id="duration_timeframe" name="duration_timeframe" value="" type="text" placeholder="Enter Duration Timeframe" style="width: 100%;" required>

                            <label for="duration">Duration*</label>
                            <select id="duration" name="duration" style="width: 100%;" required>
                                    <option value="">Choose</option>
                                    <option value="60">Hourly</option>
                                    <option value="1440">Daily</option>
                                    <option value="43200">Monthly</option>
                            </select>

                            <label for="commission">Commission*</label>
                            <input id="commission" name="commission" value="" type="text" placeholder="Enter Commission" style="width: 100%;" required>

                            <label for="benefit">Benefit*</label>
                            <input id="benefit" name="benefit" value="" type="text" placeholder="Enter Benefit" style="width: 100%;" required>

                            <div class="rate">
                                <label for="rate">Fixed rate</label>
                            </div>

                            <div style="display: flex; gap:10px;">
                                <button id="close" class="close_addplan_popup negative_btn" type="button">Close</button>
                                <button id="add_btn" class="positive_btn" name="button" type="submit">Add New</button>
                            </div>
                        </form>
                    </main>

                </div>
            </section>


            <!-- EDIT PLAN -->
            <div class="modal edit_plan_popup" id="editModal">
                <div class="modal-content">
                    <h2 class="modal-title">Edit Option</h2>
                    <input type="text" class="modal-input" placeholder="Name" id="edit_crypto_name">
                    <input type="text" class="modal-input" placeholder="Symbol" id="edit_symbol">
                    <div class="modal-buttons">
                        <button class="close_edit_plan_popup modal-button cancel" id="close_edit_modal">Close</button>
                        <button class="modal-button confirm" id="confirm_edit_crypto">Edit</button>
                    </div>
                </div>
            </div>

            <!-- ///// -->

            <!-- DELETE PLAN -->
            <div class="modal delete_plan_popup" id="deleteModal">
                <div class="modal-content">
                    <h2 class="modal-title">Confirm Delete</h2>
                    <p>Are you sure you want to delete <span id="cryptoName"></span></p>
                    <div class="modal-buttons">
                        <button class="close_delete_plan_popup modal-button cancel" id="cancelDelete">Cancel</button>
                        <button id="confirmDelete" class="modal-button confirm">Confirm</button>
                    </div>
                </div>
            </div>







        </header>


         


        <div class="container">

            <div class="plans-container">
                    <!-- <div class="plans-card">
                        <div class="plans-card-header">
                            <h5>${plan.name}
                            <div class="plans-card-dropdown">
                                <div class="plans-card-dropdown-item edit_mining">Edit <span>XRP Trial</span> Mining</div>
                                <div class="plans-card-dropdown-item delete_mining">Delete <span>XRP Trial</span> Mining</div>

                            </div>
                            </h5>
                            
                        </div>
                        <div class="card-body">
                            <div class="price-range">
                                <h2>$${parseFloat(plan.minimum).toFixed(2)}</h2>
                                <i class="fas fa-long-arrow-alt-down"></i>
                                <h2>$${parseFloat(plan.maximum).toFixed(2)}</h2>
                            </div>
                            <h6>Includes:</h6>
                            <ul>
                                <li>${parseFloat(plan.roi).toFixed(2)}% ROI</li>
                                <li>Contract: ${plan.earning_duration} ${plan.duration_timeframe}(s)</li>
                                <li>Commission: ${parseFloat(plan.commission).toFixed(2)}%</li>
                                <li>Benefit: ${plan.benefit}</li>
                            </ul>
                            <div class="button-wrapper">
                                <button class="btn-invest">Invest Now</button>
                            </div>
                        </div>
                    </div> -->

                
                            




        </div>



      </main>

      <script>
            const investmentTitle = document.querySelector('.investment-title');
            const dropdown = document.querySelector('.dropdown');



            const createInvestment = document.getElementById('createInvestment');
            
            const showplansHeaderDropdown = document.querySelector('.dropdown-arrow');
            const plansHeaderDropdown = document.querySelector('.plans-header-dropdown');

            const createModal = document.getElementById('createModal');

            const editModal = document.getElementById('editModal');

            const deleteModal = document.getElementById('deleteModal');

            const addOptionModal = document.getElementById('addOption')

            const cancelCreateButton = document.getElementById('cancelCreateButton');
            const confirmCreateButton = document.getElementById('confirmCreateButton');

            const cancelEditButton = document.getElementById('cancelEditButton');
            const confirmEditButton = document.getElementById('confirmEditButton');

            const cancelDeleteButton = document.getElementById('cancelDeleteButton');
            const confirmDeleteButton = document.getElementById('confirmDeleteButton');
            
            const cancelAddOptionButton = document.getElementById('cancelAddOptionButton');
            const confirmAddOptionButton = document.getElementById('confirmAddOptionButton');


            const investmentName = document.getElementById('investmentName');
            const editInvestmentName = document.getElementById('editInvestmentName');
            const cardsContainer = document.querySelector('.cards-container');

         

            let currentCard = null;

            // Toggle dropdown when investment title is clicked
            investmentTitle.addEventListener('click', () => {
                dropdown.classList.toggle('active');

            });
            
            showplansHeaderDropdown.addEventListener('click', () => {
                plansHeaderDropdown.classList.toggle('active');
            })

            document.addEventListener('click', (e) => {
                if (!e.target.closest('.investment-header')) {
                    dropdown.classList.remove('active');
                }
            });

            // Show create modal when 'Create Investment' is clicked
            createInvestment.addEventListener('click', () => {
                createModal.classList.add('active');
                dropdown.classList.remove('active');
                investmentName.value = ''; // Clear input
            });

            cancelCreateButton.addEventListener('click', () => {
                createModal.classList.remove('active');
            });
// Event listener for creating an investment card
            confirmCreateButton.addEventListener('click', () => {
                const name = investmentName.value.trim(); // Get the value from the input field
                if (name) {
                    fetch('create_investment.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ action: 'create_investment', name: name })
                    })
                    .then(response => response.json()) // Parse the JSON response
                    .then(data => {
                        if (data.success) {
                            // Show success Toastify notification
                            Toastify({
                                text: "Investment table created successfully!",
                                duration: 3000,
                                close: true,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)", // Green success background
                            }).showToast();

                            setTimeout(() => {
                                    window.location.href = window.location.href; // Reload page after success
                                }, 3000); // Delay for the duration of the toast

                            const newCard = createCard(name); // Create a new card with the investment name
                            cardsContainer.appendChild(newCard); // Add the new card to the container
                            createModal.classList.remove('active'); // Close the modal
                        } else {
                            // Show error Toastify notification
                            Toastify({
                                text: "Error: " + data.message,
                                duration: 5000,
                                close: true,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)", // Red/yellow error background
                            }).showToast();
                        }
                    })
                    .catch(error => {
                        // Show error Toastify notification for any other errors
                        Toastify({
                            text: "An error occurred: " + error.message,
                            duration: 5000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)", // Red/yellow error background
                        }).showToast();
                    });
                } else {
                    // Show error Toastify notification for empty input
                    Toastify({
                        text: "Please enter an investment name.",
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)", // Red/yellow error background
                    }).showToast();
                }
            });


           // Fetch and display investments from the database
            function fetchInvestments() {
                fetch('fetch_investments.php')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.investments.length > 0) {
                            data.investments.forEach(investment => {
                                const newCard = createCard(investment.investment_name, investment.card_id);
                                cardsContainer.appendChild(newCard);
                            });
                        } else {
                            // Show Toastify notification when no investments are found
                            Toastify({
                                text: "No investments found.",
                                duration: 3000,
                                close: true,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)", // Red/yellow error background
                            }).showToast();
                        }
                    })
                    .catch(error => {
                        // Show Toastify notification for fetch errors
                        Toastify({
                            text: "Error fetching investments: " + error.message,
                            duration: 5000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)", // Red/yellow error background
                        }).showToast();
                    });
            }



        function createCard(name, id) {
        const newCard = document.createElement('div');
        newCard.className = 'card';
        newCard.setAttribute('data-id', id); // Set the data-id attribute

        newCard.innerHTML = `
            <div class="card-header">
                <h2 class="card-title">${name}</h2>
            </div>
            <button class="select-button">Select Option</button>
            <div class="selection-options" id="crypto-list-container">
                <h6>${name} Investment Options</h6>
                <!-- Options will be dynamically added here -->
            </div>
            <div class="card-dropdown" >
                <div class="card-dropdown-item edit">Edit ${name}</div>
                <div class="card-dropdown-item delete">Delete ${name}</div>
                <div class="card-dropdown-item add-option">Add Option</div>
            </div>
        `;

        addCardListeners(newCard); // Attach listeners
        fetchAndPopulateCryptos(newCard, id); // Populate cryptos for the card
        return newCard;
    }



        function addCardListeners(card) {
            const cardHeader = card.querySelector('.card-header');
            const cardDropdown = card.querySelector('.card-dropdown');
            const editButton = card.querySelector('.edit');
            const deleteButton = card.querySelector('.delete');
            const addOptionButton = card.querySelector('.add-option');
            const selectButton = card.querySelector('.select-button');
            const selectionOptions = card.querySelector('.selection-options');

            // Toggle dropdown visibility
            cardHeader.addEventListener('click', () => {
                cardDropdown.classList.toggle('active');
            });

            // Edit investment
            editButton.addEventListener('click', () => {
                const currentCard = card;
                const currentName = card.querySelector('.card-title').textContent;
                const investmentId = card.getAttribute('data-id');
                
                editInvestmentName.value = currentName;
                editModal.classList.add('active');
                cardDropdown.classList.remove('active');

                confirmEditButton.addEventListener('click', function confirmEditHandler() {
                    const newName = editInvestmentName.value.trim();
                    if (newName && investmentId) {
                        fetch('edit_investment.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ id: investmentId, new_name: newName }),
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    currentCard.querySelector('.card-title').textContent = newName; // Update UI
                                    editModal.classList.remove('active');
                                    
                                    // Show success Toastify notification
                                    Toastify({
                                        text: "Investment updated successfully!",
                                        duration: 3000,
                                        close: true,
                                        gravity: "top",
                                        position: "right",
                                        backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                                    }).showToast();
                                } else {
                                    // Show error Toastify notification
                                    Toastify({
                                        text: "Error: " + data.message,
                                        duration: 5000,
                                        close: true,
                                        gravity: "top",
                                        position: "right",
                                        backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                                    }).showToast();
                                }
                            })
                            .catch(error => {
                                // Handle network or fetch errors with Toastify
                                Toastify({
                                    text: "An error occurred: " + error.message,
                                    duration: 5000,
                                    close: true,
                                    gravity: "top",
                                    position: "right",
                                    backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                                }).showToast();
                            })
                            .finally(() => {
                                confirmEditButton.removeEventListener('click', confirmEditHandler); // Clean up listener
                            });
                        } else {
                            // Show validation error Toastify notification
                            Toastify({
                                text: "Invalid input or investment ID.",
                                duration: 3000,
                                close: true,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                            }).showToast();
                        }
                    });
            });

            // Delete investment
            deleteButton.addEventListener('click', () => {
                const investmentId = card.getAttribute('data-id');
                deleteModal.classList.add('active');
                cardDropdown.classList.remove('active');

                confirmDeleteButton.addEventListener('click', function confirmDeleteHandler() {
                    fetch('delete_investment.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id: investmentId }),
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                card.remove(); // Remove the card from the DOM
                                deleteModal.classList.remove('active');
                                // Show success Toastify notification
                                Toastify({
                                    text: "Investment deleted successfully!",
                                    duration: 3000,
                                    close: true,
                                    gravity: "top",
                                    position: "right",
                                    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)", // Green success background
                                }).showToast();
                            } else {
                                // Show error Toastify notification
                                Toastify({
                                    text: "Error: " + data.message,
                                    duration: 5000,
                                    close: true,
                                    gravity: "top",
                                    position: "right",
                                    backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)", // Red/yellow error background
                                }).showToast();
                            }
                        })
                        .catch(error => {
                            // Show error Toastify notification for fetch errors
                            Toastify({
                                text: "An error occurred. Please try again.",
                                duration: 5000,
                                close: true,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)", // Red/yellow error background
                            }).showToast();
                        })
                        .finally(() => {
                            confirmDeleteButton.removeEventListener('click', confirmDeleteHandler); // Clean up listener
                        });
                });
            });


            // Add Option
            addOptionButton.addEventListener('click', () => {
                const investmentId = card.getAttribute('data-id');
                addOptionModal.classList.add('active');
                cardDropdown.classList.remove('active');

                confirmAddOptionButton.addEventListener('click', function confirmAddOptionHandler() {
                    const cryptoNameInput = document.querySelector('#crypto_name');
                    const symbolInput = document.querySelector('#symbol');
                    const cryptoName = cryptoNameInput.value.trim();
                    const symbol = symbolInput.value.trim();

                    if (!cryptoName || !symbol) {
                        // Show error Toastify notification
                        Toastify({
                            text: "Please fill in both the Crypto Name and Symbol.",
                            duration: 5000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)", // Red/yellow error background
                        }).showToast();
                        return;
                    }

                    fetch('addCrypto.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ card_id: investmentId, crypto_name: cryptoName, symbol }),
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const newOption = document.createElement('a');
                                newOption.textContent = `${cryptoName} (${symbol})`;
                                selectionOptions.appendChild(newOption);
                                cryptoNameInput.value = '';
                                symbolInput.value = '';
                                // Show success Toastify notification
                                Toastify({
                                    text: "Crypto added successfully!",
                                    duration: 3000,
                                    close: true,
                                    gravity: "top",
                                    position: "right",
                                    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)", // Green success background
                                }).showToast();
                                // Delay the page reload to show the toast
                                setTimeout(() => {
                                    window.location.href = window.location.href; // Reload page after success
                                }, 3000); // Delay for the duration of the toast
                            } else {
                                // Show error Toastify notification
                                Toastify({
                                    text: "Error: " + data.message,
                                    duration: 5000,
                                    close: true,
                                    gravity: "top",
                                    position: "right",
                                    backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)", // Red/yellow error background
                                }).showToast();
                            }
                        })
                        .catch(error => {
                            // Show error Toastify notification for fetch errors
                            Toastify({
                                text: "An error occurred. Please try again.",
                                duration: 5000,
                                close: true,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)", // Red/yellow error background
                            }).showToast();
                        })
                        .finally(() => {
                            confirmAddOptionButton.removeEventListener('click', confirmAddOptionHandler); // Clean up listener
                        });
                });
            });

            cancelAddOptionButton.addEventListener('click', () => {
                addOptionModal.classList.remove('active');
            });

            // Toggle selection options
            selectButton.addEventListener('click', () => {
                selectionOptions.classList.toggle('active');
                selectButton.textContent = selectionOptions.classList.contains('active') ? 'Hide Options' : 'Select Option';
            });
        }

        // Global variables to store the selected crypto's ID and Name
        let selectedCryptoId = null;
        let selectedCryptoName = null;

        // Function to fetch and populate cryptos dynamically
        function fetchAndPopulateCryptos(card, cardId) {
            fetch('getCryptos.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ card_id: cardId }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const selectionOptions = card.querySelector('.selection-options');
                    selectionOptions.innerHTML = ''; 

                    data.cryptos.forEach(crypto => {
                        const cryptoOption = document.createElement('a');
                        cryptoOption.textContent = `${crypto.crypto_name} (${crypto.symbol})`;
                        cryptoOption.setAttribute('data-crypto-id', crypto.crypto_id);
                        selectionOptions.appendChild(cryptoOption);

                        cryptoOption.addEventListener('click', function () {
                            storeSelectedCryptoId(crypto.crypto_id, crypto.crypto_name);  // Store selected crypto ID
                            updateHeaderContent(crypto);
                            document.getElementById('plans-header').style.display = 'block';
                            fetchAndDisplayPlans(crypto.crypto_id);  // Fetch and display plans based on selected crypto_id
                        });
                    });
                } else {
                    console.error('Error fetching cryptos:', data.message);
                }
            })
            .catch(error => {
                console.error('Error fetching cryptos:', error);
            });
        }

        function storeSelectedCryptoId(cryptoId, cryptoName) {
            selectedCryptoId = cryptoId;  
            selectedCryptoName = cryptoName; 
        }

        function updateHeaderContent(crypto) {
            const headerLeft = document.querySelector('.header-left');
            headerLeft.querySelector('h1').textContent = crypto.crypto_name;
            fetchCryptoDetails(crypto.symbol);
        }

        function fetchCryptoDetails(cryptoSymbol) {
            fetch('getCryptoTransactions.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ crypto_symbol: cryptoSymbol }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const availableBalance = data.available_balance;
                    updateBalanceDisplay(availableBalance, cryptoSymbol);
                } else {
                    console.error('Error fetching crypto details:', data.message);
                    updateBalanceDisplay(0, cryptoSymbol); // Default to 0 on error
                }
            })
            .catch(error => {
                console.error('Error fetching crypto details:', error);
                updateBalanceDisplay(0, cryptoSymbol); // Default to 0 on error
            });
        }

        function updateBalanceDisplay(availableBalance, cryptoSymbol) {
            const headerLeft = document.querySelector('.header-left');
            headerLeft.querySelector('h4').textContent = `Stake from $${availableBalance.toFixed(2)} (${cryptoSymbol}) wallet`;
        }

        function fetchAndDisplayPlans(cryptoId) {
            fetch('getPlans.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ crypto_id: cryptoId })
            })
            .then(response => response.json())
            .then(data => {
                const plansContainer = document.querySelector('.plans-container');
                plansContainer.innerHTML = ''; 

                if (data.success && data.plans.length > 0) {
                    data.plans.forEach((plan, index) => {
                        const uniqueEditPopupId = `edit_mining_popup_${index}`;
                        const uniqueDeletePopupId = `delete_mining_popup_${index}`;
                        const uniqueInvestPopupId = `invest_popup${index}`

                        const planCard = `
                            <div class="plans-card">
                                <div class="plans-card-header">
                                    <h5>${plan.name}
                                    <div class="plans-card-dropdown">
                                        <div class="plans-card-dropdown-item edit_mining" data-edit-popup="${uniqueEditPopupId}">Edit <span>${plan.name}</span></div>
                                        <div class="plans-card-dropdown-item delete_mining" data-delete-popup="${uniqueDeletePopupId}">Delete <span>${plan.name}</span></div>
                                    </div>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="price-range">
                                        <h2>$${parseFloat(plan.minimum).toFixed(2)}</h2>
                                        <i class="fas fa-long-arrow-alt-down"></i>
                                        <h2>$${parseFloat(plan.maximum).toFixed(2)}</h2>
                                    </div>
                                    <h6>Includes:</h6>
                                    <ul>
                                        <li>${parseFloat(plan.roi).toFixed(2)}% ROI</li>
                                        <li>Contract: ${plan.duration_timeframe} Day(s)</li>
                                        <li>Commission: ${parseFloat(plan.commission).toFixed(2)}%</li>
                                        <li>Benefit: ${plan.benefit}</li>
                                    </ul>
                                    <div class="button-wrapper">
                                        <button class="btn-invest show_invest_popup" data-show-invest-popup="${uniqueInvestPopupId}">Invest Now</button>
                                    </div>
                                </div>
                            </div>

                            
                            <!-- Unique Edit Mining Popup -->
                            <section class="edit_mining_popup action_overlay" id="${uniqueEditPopupId}">
                                <div class="wrapper">
                                    <header>
                                        <h4>Edit <span>${plan.name}</span></h4>
                                        <img class="close_mining" src="assets/images/c-close-svgrepo-com.svg" alt="Close" width="20">
                                    </header>
                                    <main style="display: flex; flex-direction: column; gap: 10px;">
                                        <form id="editPlanForm" method="POST">
                                            <!-- Form Fields -->
                                            <input type="hidden" id="crypto_id" name="crypto_id" value="${plan.crypto_id}">
                                            <input type="hidden" id="plan_id" name="plan_id" value="${plan.id}">
                                            
                                            <label for="name">Name*</label>
                                            <input id="name" name="name" value="${plan.name}" type="text" placeholder="Name*" style="width: 100%;" required>

                                            <label for="roi">ROI*</label>
                                            <input id="roi" name="roi" value="${parseFloat(plan.roi).toFixed(2)}" type="text" placeholder="Enter ROI" style="width: 100%;" required>

                                            <label for="roi_max">ROI Max*</label>
                                            <input id="roi_max" name="roi_max" value="${parseFloat(plan.roi_max).toFixed(2)}" type="text" placeholder="Enter ROI Max" style="width: 100%;" required>

                                            <label for="minimum">Minimum*</label>
                                            <input id="minimum" name="minimum" value="${parseFloat(plan.minimum).toFixed(2)}" type="text" placeholder="Enter Minimum" style="width: 100%;" required>

                                            <label for="maximum">Maximum*</label>
                                            <input id="maximum" name="maximum" value="${parseFloat(plan.maximum).toFixed(2)}" type="text" placeholder="Enter Maximum" style="width: 100%;" required>

                                            <label for="earning_duration">Earning Duration*</label>
                                            <select id="earning_duration_${plan.id}" name="earning_duration" style="width: 100%;" required>
                                                <option value="">Choose</option>
                                                <option value="5" ${plan.earning_duration == 5 ? 'selected' : ''}>Every Five Minutes</option>
                                                <option value="10" ${plan.earning_duration == 10 ? 'selected' : ''}>Every Ten Minutes</option>
                                                <option value="30" ${plan.earning_duration == 30 ? 'selected' : ''}>Every Thirty Minutes</option>
                                                <option value="60" ${plan.earning_duration == 60 ? 'selected' : ''}>Hourly</option>
                                                <option value="360" ${plan.earning_duration == 360 ? 'selected' : ''}>Every Six Hours</option>
                                                <option value="1440" ${plan.earning_duration == 1440 ? 'selected' : ''}>Daily</option>
                                                <option value="720" ${plan.earning_duration == 720 ? 'selected' : ''}>Twice Daily</option>
                                            </select>

                                            <label for="duration_timeframe">Duration Timeframe*</label>
                                            <input id="duration_timeframe" name="duration_timeframe" value="${plan.duration_timeframe}" type="text" placeholder="Enter Duration Timeframe" style="width: 100%;" required>

                                            <label for="duration">Duration*</label>
                                            <select id="duration_${plan.id}" name="duration" style="width: 100%;" required>
                                                <option value="">Choose</option>
                                                <option value="60" ${plan.duration == 60 ? 'selected' : ''}>Hourly</option>
                                                <option value="1440" ${plan.duration == 1440 ? 'selected' : ''}>Daily</option>
                                                <option value="43200" ${plan.duration == 43200 ? 'selected' : ''}>Monthly</option>
                                            </select>

                                            <label for="commission">Commission*</label>
                                            <input id="commission" name="commission" value="${parseFloat(plan.commission).toFixed(2)}" type="text" placeholder="Enter Commission" style="width: 100%;" required>

                                            <label for="benefit">Benefit*</label>
                                            <input id="benefit" name="benefit" value="${plan.benefit}" type="text" placeholder="Enter Benefit" style="width: 100%;" required>

                                            <div class="rate">
                                                <label for="rate">Fixed rate</label>
                                            </div>

                                            <div style="display: flex; gap: 10px;">
                                                <button id="close_btn" class="close_addplan_popup negative_btn" type="button">Close</button>
                                                <button id="edit_btn" class="positive_btn" name="button" type="submit">Edit Plan</button>
                                            </div>
                                        </form>
                                    </main>
                                </div>
                            </section>


                            <!-- Unique Delete Mining Popup -->
                            <div class="modal delete_mining_popup" id="${uniqueDeletePopupId}" data-plan-id="${plan.id}">
                                <div class="modal-content">
                                    <h2 class="modal-title">Delete <span>${plan.name}</span></h2>
                                    <p>Are you sure you want to delete <span>${plan.name}</span>?</p>
                                    <div class="modal-buttons">
                                        <button class="close_delete_mining modal-button cancel">Cancel</button>

                                        <!-- Backend Logic for Deleting the Plan -->
                                        <button id="delete_btn" class="modal-button confirm">Confirm</button>
                                    </div>
                                </div>
                            </div>




                            <section class="invest_popup action_overlay" id="${uniqueInvestPopupId}" style="padding-top: 40px; padding-bottom: 0px;">
                            <div class="wrapper">
                                <header>
                                    <h6>Enter Amount To Invest on <span>${plan.name}</span></h6>
                                    <img class="close_invest_popup" src="assets/images/c-close-svgrepo-com.svg" alt="Close" width="20">
                                </header>
                                <main style="display:flex; flex-direction:column; gap:10px;">
                                    <form id="investForm">
                                        <!-- Form Fields -->
                                        <input type="hidden" name="crypto_id" value="${plan.crypto_id}">
                                        <input type="hidden" name="plan_id" value="${plan.id}"> <!-- Assuming plan ID is sent here -->

                                        <label for="investment_amount">Enter Amount*</label>
                                        <input id="investment_amount" name="investment_amount" value="" type="number" placeholder="Enter Amount*" style="width: 100%; margin-bottom: 10px;" required>

                                        <div style="display: flex; gap:10px;">
                                            <button id="close" class="close_invest_popup negative_btn" type="button">Close</button>
                                            <button id="submitInvest" class="positive_btn close_invest_popup" name="button" type="submit">Proceed</button>
                                        </div>
                                    </form>
                                </main>
                            </div>
                        </section>

                        `;

                        plansContainer.insertAdjacentHTML('beforeend', planCard);
                    });

                    const planCardHeader = document.querySelectorAll('.plans-card-header');
                    const planCardDropdown = document.querySelectorAll('.plans-card-dropdown');
                    
                    planCardHeader.forEach((card, index) => {
                        card.addEventListener('click', () => {
                            planCardDropdown.forEach((dropdown, dropdownIndex) => {
                                if (dropdownIndex === index) {
                                    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
                                } else {
                                    dropdown.style.display = 'none';
                                }
                            });
                        });
                    });


                    const editButtons = document.querySelectorAll('.edit_mining');
                    const deleteButtons = document.querySelectorAll('.delete_mining');
                    const showInvestPopup = document.querySelectorAll('.show_invest_popup');

                    // Add click event listeners to all edit buttons
                    editButtons.forEach((editButton) => {
                        editButton.addEventListener('click', () => {
                            const popupId = editButton.getAttribute('data-edit-popup');
                            const popup = document.getElementById(popupId);

                            if (popup) {
                                // Show the popup
                                popup.style.visibility = 'visible';
                                popup.style.opacity = '1';

                                // Select the form inside the popup
                                const editForm = popup.querySelector('form');

                                // Close button functionality
                                const closeButton = popup.querySelector('#close_btn');
                                closeButton.addEventListener('click', () => {
                                    popup.style.visibility = 'hidden';
                                    popup.style.opacity = '0';
                                });

                                if (!editForm) {
                                    console.error('No form found inside the popup.');
                                    return;
                                }

                                // Event listener for form submission
                                editForm.addEventListener('submit', function (e) {
                                    e.preventDefault(); // Prevent default form submission

                                    // Ensure the crypto ID is set before submitting the form
                                    if (!selectedCryptoId) {
                                        alert('Please select a cryptocurrency first!');
                                        return;
                                    }

                                    // Dynamically set the hidden input field for crypto ID
                                    const cryptoIdInput = editForm.querySelector('input[name="crypto_id"]');
                                    if (!cryptoIdInput) {
                                        alert('Hidden input for crypto_id is missing.');
                                        return;
                                    }
                                    cryptoIdInput.value = selectedCryptoId;

                                    // Collect form data
                                    const formData = new FormData(editForm);
                                    const submitButton = editForm.querySelector('#edit_btn');

                                    if (!submitButton) {
                                        console.error('Submit button with ID "edit_btn" is missing.');
                                        return;
                                    }

                                    // Disable the submit button to prevent multiple clicks
                                    submitButton.disabled = true;
                                    submitButton.textContent = "Processing...";

                                    // Send the data to the server via fetch
                                    fetch('editPlan.php', {
                                        method: 'POST',
                                        body: formData,
                                    })
                                        .then((response) => response.json()) // Expect JSON response from PHP
                                        .then((data) => {
                                            // Re-enable the submit button
                                            submitButton.disabled = false;
                                            submitButton.textContent = "Edit Plan";

                                            if (data.success) {
                                                // Show success notification
                                                Toastify({
                                                    text: "Investment plan edited successfully!",
                                                    duration: 3000,
                                                    close: true,
                                                    gravity: "top",
                                                    position: "right",
                                                    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                                                }).showToast();

                                                // Reload the page after successful edit
                                                setTimeout(() => {
                                                    location.reload();
                                                }, 3000); // Delay the page reload to let the toast message show
                                            } else {
                                                // Show error notification
                                                Toastify({
                                                    text: "Error: " + data.message,
                                                    duration: 5000,
                                                    close: true,
                                                    gravity: "top",
                                                    position: "right",
                                                    backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                                                }).showToast();
                                            }
                                        })
                                        .catch((error) => {
                                            // Handle fetch errors
                                            submitButton.disabled = false;
                                            submitButton.textContent = "Edit Plan";

                                            Toastify({
                                                text: "An error occurred: " + error.message,
                                                duration: 5000,
                                                close: true,
                                                gravity: "top",
                                                position: "right",
                                                backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                                            }).showToast();
                                        });
                                });
                            } else {
                                console.error(`Popup with ID ${popupId} not found.`);
                            }
                        });
                    });

                   // Add click event listeners to all delete buttons
                    deleteButtons.forEach((deleteButton) => {
                        deleteButton.addEventListener('click', () => {
                            const popupId = deleteButton.getAttribute('data-delete-popup');
                            const popup = document.getElementById(popupId);

                            if (popup) {
                                // Show the popup
                                popup.style.visibility = 'visible';
                                popup.style.opacity = '1';

                                // Get the plan ID (you can add it as a data attribute in the popup or button)
                                const planId = popup.getAttribute('data-plan-id'); // Assuming you store plan ID in a data attribute
                                
                                if (!planId) {
                                    console.error("Plan ID is missing.");
                                    return;
                                }

                                // Find the delete button inside the modal
                                const deleteButtonInModal = popup.querySelector('#delete_btn');

                                // Event listener for the Confirm delete button
                                if (deleteButtonInModal) {
                                    deleteButtonInModal.addEventListener('click', () => {
                                        // Prepare data to send to the server
                                        const formData = new FormData();
                                        formData.append('plan_id', planId); // Send the plan_id to the backend

                                        // Perform the fetch to delete the plan from the database
                                        fetch('deletePlan.php', {
                                            method: 'POST',
                                            body: formData,
                                        })
                                        .then((response) => response.json())
                                        .then((data) => {
                                            if (data.success) {
                                                // Show success notification
                                                Toastify({
                                                    text: "Investment plan deleted successfully!",
                                                    duration: 3000,
                                                    close: true,
                                                    gravity: "top",
                                                    position: "right",
                                                    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                                                }).showToast();

                                                // Close the modal and reload the page
                                                popup.style.visibility = 'hidden';
                                                popup.style.opacity = '0';
                                                setTimeout(() => {
                                                    location.reload(); // Reload the page to reflect the changes
                                                }, 3000); // Delay the reload to allow the toast to show
                                            } else {
                                                // Show error notification
                                                Toastify({
                                                    text: "Error: " + data.message,
                                                    duration: 5000,
                                                    close: true,
                                                    gravity: "top",
                                                    position: "right",
                                                    backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                                                }).showToast();
                                            }
                                        })
                                        .catch((error) => {
                                            // Handle any errors from the fetch request
                                            Toastify({
                                                text: "An error occurred: " + error.message,
                                                duration: 5000,
                                                close: true,
                                                gravity: "top",
                                                position: "right",
                                                backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                                            }).showToast();
                                        });
                                    });
                                }
                            } else {
                                console.error(`Popup with ID ${popupId} not found.`);
                            }
                        });
                    });

                    // Close the modal when the cancel button is clicked
                    const cancelButtons = document.querySelectorAll('.modal .close_delete_mining');
                    cancelButtons.forEach((cancelButton) => {
                        cancelButton.addEventListener('click', () => {
                            const popup = cancelButton.closest('.delete_mining_popup');
                            popup.style.visibility = 'hidden';
                            popup.style.opacity = '0';
                        });
                    });

                    // Show investment popup dynamically for each investment plan
                    const showInvestPopupButtons = document.querySelectorAll('.btn-invest');
                    showInvestPopupButtons.forEach((showInvestButton) => {
                        showInvestButton.addEventListener('click', (event) => {
                            const popupId = event.target.getAttribute('data-show-invest-popup');
                            const popup = document.getElementById(popupId);
                            if (popup) {
                                popup.style.visibility = 'visible';
                                popup.style.opacity = '1';
                            }
                        });
                    });

                    // Close the investment popup when the close button is clicked
                    const closePopupButtons = document.querySelectorAll('.close_invest_popup');
                    closePopupButtons.forEach((closeButton) => {
                        closeButton.addEventListener('click', (event) => {
                            const popup = event.target.closest('.invest_popup');
                            if (popup) {
                                popup.style.visibility = 'hidden';
                                popup.style.opacity = '0';
                            }
                        });
                    });

                    // Handle investment form submission
                    // Attach event listeners dynamically based on each individual plan card
                    const investForms = document.querySelectorAll('.invest_popup form');
                    investForms.forEach((investForm) => {
                        investForm.addEventListener('submit', function (e) {
                            e.preventDefault(); // Prevent default form submission

                            // Fetch input values for this specific form
                            const investmentAmount = parseFloat(investForm.querySelector('input[name="investment_amount"]').value);
                            const planId = parseInt(investForm.querySelector('input[name="plan_id"]').value, 10);
                            const cryptoId = parseInt(investForm.querySelector('input[name="crypto_id"]').value, 10);

                            // Input validation
                            if (!Number.isInteger(planId) || planId <= 0) {
                                alert('Invalid plan ID.');
                                return;
                            }
                            if (!Number.isInteger(cryptoId) || cryptoId <= 0) {
                                alert('Invalid crypto ID.');
                                return;
                            }
                            if (!investmentAmount || isNaN(investmentAmount) || investmentAmount <= 0) {
                                alert('Please enter a valid investment amount.');
                                return;
                            }

                            // Fetch the crypto symbol from the cryptos table (based on the crypto ID)
                            fetch('getCryptoSymbol.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({ crypto_id: cryptoId }),
                            })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        const selectedCryptoSymbol = data.symbol;

                                        // Fetch the available balance for the selected cryptocurrency
                                        fetch('verifybalance.php', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                            },
                                            body: JSON.stringify({ 
                                                crypto_symbol: selectedCryptoSymbol,
                                                investment_amount: investmentAmount
                                             }),
                                        })
                                            .then(response => response.json())
                                            .then(data => {
                                                if (data.success) {
                                                    const availableBalance = parseFloat(data.available_balance);

                                                    // Validate user's balance
                                                     // Validate user's balance
                                                     if (investmentAmount > availableBalance) {
                                                            Toastify({
                                                                text: 'You do not have enough balance to invest this amount.',
                                                                duration: 3000, // Duration in milliseconds
                                                                gravity: 'top', // 'top' or 'bottom'
                                                                position: 'right', // 'left', 'center', or 'right'
                                                                backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc3a0)', // Custom gradient
                                                                stopOnFocus: true, // Stops the toast on hover
                                                            }).showToast();
                                                            return;
                                                        }

                                                    // Fetch investment plan details
                                                    fetch('getInvestmentPlanDetails.php', {
                                                        method: 'POST',
                                                        headers: {
                                                            'Content-Type': 'application/json',
                                                        },
                                                        body: JSON.stringify({ plan_id: planId }),
                                                    })
                                                        .then(response => response.json())
                                                        .then(planData => {
                                                            if (planData.success) {
                                                                const minInvestment = parseFloat(planData.plan.min_investment);
                                                                const maxInvestment = parseFloat(planData.plan.max_investment);

                                                                // Validate investment amount range
                                                                if (investmentAmount < minInvestment || investmentAmount > maxInvestment) {
                                                                    alert(`Investment amount must be between ${minInvestment} and ${maxInvestment}.`);
                                                                    return;
                                                                }

                                                                // Proceed with the investment submission
                                                                fetch('addInvestmentPlan.php', {
                                                                    method: 'POST',
                                                                    headers: {
                                                                        'Content-Type': 'application/json',
                                                                    },
                                                                    body: JSON.stringify({
                                                                        crypto_id: cryptoId,
                                                                        plan_id: planId,
                                                                        investment_amount: investmentAmount.toFixed(2),
                                                                    }),
                                                                })
                                                                    .then(response => response.json())
                                                                    .then(data => {
                                                                        if (data.success) {
                                                                        Toastify({
                                                                            text: 'Investment added successfully.',
                                                                            duration: 3000,
                                                                            close: true,
                                                                            gravity: 'top',
                                                                            position: 'right',
                                                                            backgroundColor: 'linear-gradient(to right, #00b09b, #96c93d)', // Green gradient for success
                                                                            stopOnFocus: true,
                                                                        }).showToast();

                                                                        // Optionally, close the popup
                                                                        const popup = investForm.closest('.invest_popup');
                                                                        if (popup) {
                                                                            popup.style.visibility = 'hidden';
                                                                            popup.style.opacity = '0';
                                                                        }
                                                                    } else {
                                                                        Toastify({
                                                                            text: 'Error: ' + data.message,
                                                                            duration: 3000,
                                                                            close: true,
                                                                            gravity: 'top',
                                                                            position: 'right',
                                                                            backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc3a0)', // Red gradient for error
                                                                            stopOnFocus: true,
                                                                        }).showToast();
                                                                    }


                                                                    })
                                                                    .catch(error => {
                                                                        console.error('Error:', error);
                                                                    });

                                                            } else {
                                                                alert('Error: ' + planData.message);
                                                            }
                                                        })
                                                        .catch(error => {
                                                            alert('An error occurred while fetching the plan details: ' + error.message);
                                                        });
                                                } else {
                                                    alert('Error fetching balance: ' + data.message);
                                                }
                                            })
                                            .catch(error => {
                                                alert('An error occurred while fetching the balance: ' + error.message);
                                            });
                                    } else {
                                        alert('Error fetching crypto symbol: ' + data.message);
                                    }
                                })
                                .catch(error => {
                                    alert('An error occurred while fetching the crypto symbol: ' + error.message);
                                });
                        });
                    });










                    document.querySelectorAll('.close_mining').forEach((closeButton) => {
                        closeButton.addEventListener('click', () => {
                            const popup = closeButton.closest('.edit_mining_popup');
                            if (popup) {
                                popup.style.visibility = 'hidden';
                                popup.style.opacity = '0';
                            }
                        });
                    });

                    document.querySelectorAll('.close_delete_mining').forEach((closeButton) => {
                        closeButton.addEventListener('click', () => {
                            const popup = closeButton.closest('.delete_mining_popup');
                            if (popup) {
                                popup.style.visibility = 'hidden';
                                popup.style.opacity = '0';
                            }
                        });
                    });

                    document.querySelectorAll('.close_invest_popup').forEach((closeButton) => {
                        closeButton.addEventListener('click', () => {
                            const popup = closeButton.closest('.invest_popup');
                            if (popup) {
                                popup.style.visibility = 'hidden';
                                popup.style.opacity = '0';
                            }
                        });
                    });


                } else {
                    plansContainer.innerHTML = '<p>No plans available for this cryptocurrency.</p>';
                }
            })
            .catch(error => {
                console.error('Error fetching plans:', error);
            });
        }

        document.querySelector('.btn-back').addEventListener('click', function() {
            location.reload();  // Reload the page to refresh everything
        });





            // Open the edit modal and populate it with the selected crypto's details
            function openEditModal(cryptoId, cryptoName, symbol) {
                selectedCryptoId = cryptoId; // Store the selected crypto's ID
                document.getElementById('edit_crypto_name').value = cryptoName;
                document.getElementById('edit_symbol').value = symbol;
                document.getElementById('editModal').style.display = 'block';  // Show the modal
            }

            // Close the modal
            document.getElementById('close_edit_modal').addEventListener('click', () => {
                document.getElementById('editModal').style.display = 'none';  // Hide the modal
            });

            // Confirm the edit when the "Edit" button is clicked
            document.getElementById('confirm_edit_crypto').addEventListener('click', function() {
                const cryptoNameInput = document.querySelector('#edit_crypto_name');
                const symbolInput = document.querySelector('#edit_symbol');
                const cryptoName = cryptoNameInput.value.trim();
                const symbol = symbolInput.value.trim();

                if (!cryptoName || !symbol) {
                    alert('Please fill in both the Crypto Name and Symbol.');
                    return;
                }

                // Send the updated data to the server to update the crypto
                fetch('editCrypto.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        crypto_id: selectedCryptoId,
                        crypto_name: cryptoName,
                        symbol: symbol
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the selected option in the list
                        const cryptoOption = document.querySelector(`[data-crypto-id="${selectedCryptoId}"]`);
                        if (cryptoOption) {
                            cryptoOption.textContent = `${cryptoName} (${symbol})`;
                        }

                        document.getElementById('editModal').style.display = 'none';  // Hide the modal

                        // Show success Toastify notification
                        Toastify({
                            text: "Crypto updated successfully!",
                            duration: 3000,  // Show the toast for 3 seconds
                            close: true,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)", // Green success background
                        }).showToast();

                        // Delay the reload to allow the toast to be visible
                        setTimeout(() => {
                            window.location.href = window.location.href; // Reload the page
                        }, 3000); // 3 seconds delay to match the toast duration
                    } else {
                        // Show error Toastify notification
                        Toastify({
                            text: "Error: " + data.message,
                            duration: 5000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)", // Red/yellow error background
                        }).showToast();
                    }
                    })
                    .catch(error => {
                        // Show error Toastify notification for fetch errors
                        Toastify({
                            text: "An error occurred. Please try again.",
                            duration: 5000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)", // Red/yellow error background
                        }).showToast();
                    });

            });
            // Function to open the delete modal and populate it with the selected crypto's details
            function openDeleteModal(cryptoId, cryptoName) {
                selectedCryptoId = cryptoId; // Store the selected crypto's ID
                document.getElementById('cryptoName').textContent = cryptoName;
                document.getElementById('deleteModal').style.display = 'block';  // Show the modal
            }

            // Event listener for the "Confirm Delete" button
            document.getElementById('confirmDelete').addEventListener('click', function () {
                if (!selectedCryptoId) {
                    alert('Invalid crypto ID. Please try again.');
                    return;
                }

                // Send delete request to the server with the selected cryptoId
                fetch('deleteCrypto.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ crypto_id: selectedCryptoId }),  // Send selectedCryptoId to delete
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Successfully deleted, remove the crypto from the list in the UI
                        const cryptoElement = document.querySelector(`[data-crypto-id="${selectedCryptoId}"]`);
                        if (cryptoElement) {
                            cryptoElement.remove(); // Remove the crypto option from the DOM
                        }

                        // Show success Toastify notification
                        Toastify({
                            text: "Crypto deleted successfully!",
                            duration: 3000,  // Toast will be visible for 3 seconds
                            close: true,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)", // Green success background
                        }).showToast();

                        closeDeleteModal();  // Close the modal

                        // Reload the page after the toast
                        setTimeout(() => {
                            window.location.href = window.location.href; // Reload the page
                        }, 3000); // Wait for the toast to be visible before reloading
                    } else {
                        // Show error Toastify notification
                        Toastify({
                            text: `Error: ${data.message}`,
                            duration: 5000,  // Toast will be visible for 5 seconds
                            close: true,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)", // Red/yellow error background
                        }).showToast();
                    }
                    })
                    .catch(error => {
                        console.error('Deletion error:', error);

                        // Show error Toastify notification for fetch errors
                        Toastify({
                            text: 'An error occurred. Please try again.',
                            duration: 5000,  // Toast will be visible for 5 seconds
                            close: true,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)", // Red/yellow error background
                        }).showToast();
                    });

            });

            // Event listener for the "Cancel" button to close the modal
            document.getElementById('cancelDelete').addEventListener('click', closeDeleteModal);

            // Function to close the delete modal
            function closeDeleteModal() {
                const modal = document.getElementById('deleteModal');
                modal.style.display = 'none';  // Hide the modal
            }

                    // Function to store selected crypto ID
            function storeSelectedCryptoId(cryptoId, cryptoName) {
                selectedCryptoId = cryptoId;  // Store the selected crypto ID
                document.getElementById('selected_crypto_id').value = cryptoId; // Set the hidden input field with the selected crypto ID
            }

            // Event listener for the form submission
            document.getElementById('addPlanForm').addEventListener('submit', function (e) {
                e.preventDefault(); // Prevent form submission

                // Make sure the cryptoId is set before submitting the form
                if (!selectedCryptoId) {
                    alert('Please select a cryptocurrency first!');
                    return;
                }

                // Set the selected cryptoId to the hidden input field before submitting
                document.getElementById('selected_crypto_id').value = selectedCryptoId;

                const formData = new FormData(this); // Collect all form data
                const submitButton = document.getElementById('add_btn');
                
                // Disable the submit button to prevent multiple clicks
                submitButton.disabled = true;
                submitButton.textContent = "Processing...";

                fetch('addPlan.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json()) // Expect JSON response from PHP
                .then(data => {
                    submitButton.disabled = false;
                    submitButton.textContent = "Add New";

                    if (data.success) {
                        // Show success notification
                        Toastify({
                            text: "Investment plan added successfully!",
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                        }).showToast();

                        // Optionally clear the form
                        document.getElementById('addPlanForm').reset();
                    } else {
                        // Show error notification
                        Toastify({
                            text: "Error: " + data.message,
                            duration: 5000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                        }).showToast();
                    }
                })
                .catch(error => {
                    submitButton.disabled = false;
                    submitButton.textContent = "Add New";

                    // Handle fetch errors
                    Toastify({
                        text: "An error occurred: " + error.message,
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                    }).showToast();
                });
            });

       

            cancelEditButton.addEventListener('click', () => {
                editModal.classList.remove('active');
            });

            confirmDeleteButton.addEventListener('click', () => {
                if (currentCard) {
                    currentCard.remove();
                    deleteModal.classList.remove('active');
                }
            });

            cancelDeleteButton.addEventListener('click', () => {
                deleteModal.classList.remove('active');
            });

            [createModal, editModal, deleteModal].forEach(modal => {
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) {
                        modal.classList.remove('active');
                    }
                });
            });

            

            // Listen for enter key on investment name inputs
            investmentName.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    confirmCreateButton.click();
                }
            });

            editInvestmentName.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    confirmEditButton.click();
                }
            });

            // Close dropdowns if clicked outside
            document.addEventListener('click', (e) => {
                if (!e.target.closest('.card-header') && !e.target.closest('.select-button')) {
                    document.querySelectorAll('.card-dropdown, .selection-options').forEach(dropdown => {
                        dropdown.classList.remove('active');
                    });
                }
            });

            

            fetchInvestments();
            



        document.addEventListener('DOMContentLoaded', () => {
            const addPlan = document.querySelector('.add_plan');
            const addPlanPopup = document.querySelector('.add_plan_popup');
                addPlan.addEventListener('click', () => {
                    addPlanPopup.style.visibility = 'visible';
                    addPlanPopup.style.opacity = '1';
                    
                })


            const closeAddPlanPopup = document.querySelectorAll('.close_addplan_popup');
                closeAddPlanPopup.forEach((close) => {
                    close.addEventListener('click', () => {
                        addPlanPopup.style.visibility = 'hidden';
                        addPlanPopup.style.opacity = '0';
                    })
                });

            const editPlan = document.querySelector('.edit_plan');
            const editPlanPopup = document.querySelector('.edit_plan_popup');
                editPlan.addEventListener('click', () => {
                    editPlanPopup.style.visibility = 'visible';
                    editPlanPopup.style.opacity = '1';
                })
            const closeEditPlanPopup = document.querySelector('.close_edit_plan_popup');
                    closeEditPlanPopup.addEventListener('click', () => {
                        editPlanPopup.style.visibility = 'hidden';
                        editPlanPopup.style.opacity = '0';
                    })



            const deletePlan = document.querySelector('.delete_plan');
            const deletePlanPopup = document.querySelector('.delete_plan_popup');
                deletePlan.addEventListener('click', () => {
                    deletePlanPopup.style.visibility = 'visible';
                    deletePlanPopup.style.opacity = '1';
                });
            const closeDeletePlanPopup = document.querySelector('.close_delete_plan_popup');
                closeDeletePlanPopup.addEventListener('click', () => {
                    deletePlanPopup.style.visibility = 'hidden';
                    deletePlanPopup.style.opacity = '0';
                })








            // const editMining = document.querySelectorAll('.edit_mining');
            // const editMiningPopup = document.querySelector('.edit_mining_popup');
            
            // const deleteMining = document.querySelectorAll('.delete_mining');
            // const deleteMiningPopup = document.querySelector('.delete_mining_popup');


            // editMining.forEach((edit_mining) => {
            //     console.log("hello")

            //     edit_mining.addEventListener('click', () => {
            //         editMiningPopup.style.visibility = 'visible';
            //         editMiningPopup.style.opacity = '1';
            //     });
            // });



            // deleteMining.forEach((delete_mining) => {

            //     delete_mining.addEventListener('click', () => {
            //         deleteMiningPopup.style.visibility = 'visible';
            //         deleteMiningPopup.style.opacity = '1';
            //     });
            // });

            // const closeMiningButtons = document.querySelectorAll('.close_mining');
            // const closeDeleteMining = document.querySelectorAll('.close_delete_mining');

            // closeMiningButtons.forEach((close) => {
            //     close.addEventListener('click', () => {
            //         editMiningPopup.style.visibility = 'hidden';
            //         editMiningPopup.style.opacity = '0';
            //     })
            // });

            // closeDeleteMining.forEach((close) => {
            //     close.addEventListener('click', () => {
            //         deleteMiningPopup.style.visibility = 'hidden';
            //         deleteMiningPopup.style.opacity = '0';
            //     })
            // });
        
            
        });

document.addEventListener('DOMContentLoaded', () => {
    const addPlan = document.querySelector('.add_plan');
    const addPlanPopup = document.querySelector('.add_plan_popup');

    // Event listener for the form submission
    document.getElementById('editPlanForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent form submission

        // Make sure the cryptoId is set before submitting the form
        if (!selectedCryptoId) {
            alert('Please select a cryptocurrency first!');
            return;
        }

        // Set the selected cryptoId to the hidden input field before submitting
        document.getElementById('selected_crypto_id').value = selectedCryptoId;

        const formData = new FormData(this); // Collect all form data
        const submitButton = document.getElementById('edit_btn');
        
        // Disable the submit button to prevent multiple clicks
        submitButton.disabled = true;
        submitButton.textContent = "Processing...";

        fetch('editPlan.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json()) // Expect JSON response from PHP
        .then(data => {
            submitButton.disabled = false;
            submitButton.textContent = "Edit Plan";

            if (data.success) {
                // Show success notification
                Toastify({
                    text: "Investment plan edited successfully!",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                }).showToast();

                // Optionally clear the form
                document.getElementById('editPlanForm').reset();
            } else {
                // Show error notification
                Toastify({
                    text: "Error: " + data.message,
                    duration: 5000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                }).showToast();
            }
        })
        .catch(error => {
            submitButton.disabled = false;
            submitButton.textContent = "Edit Plan";

            // Handle fetch errors
            Toastify({
                text: "An error occurred: " + error.message,
                duration: 5000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
            }).showToast();
        });
    });
});
      </script>



      

      
      
       <footer  class="dashboard_footer">
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


</body>
</html>

