<style>
    :root {
    --background: #1a1a1a;
    --surface: #222222;
    --text-color: #F5F5F5;
    --secondary-text: #A9A9A9;
    --primary-dark: #A6841C;
    --primary-color: #6e591a;
    --border-color: #383838;
    --hover-color: rgba(255, 255, 255, 0.05);
    --positive-color: #00c853;
    --negative-color: #ff3d3d;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;

}
.bottom-nav {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    display: none;
    justify-content: space-around;
    background-color: var(--surface);
    padding: 0.5rem;
    border-top: 1px solid var(--border-color);
}

.nav-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-decoration: none;
    color: var(--secondary-text);
    padding: 0.5rem;
    position: relative;
    flex: 1;
    transition: color 0.3s ease;
    cursor: pointer;
}
.nav-item svg{
    fill: var(--secondary-text);
    width: 24px;
    height: 24px;
}

.nav-item i {
    font-size: 1.2rem;
    margin-bottom: 0.3rem;
}

.nav-item span {
    font-size: 0.75rem;
    font-weight: 500;
}

.nav-item.active {
    color: var(--primary-dark);
}
.nav-item.active svg{
    fill: var(--primary-dark);

}




.nav-indicator {
    position: absolute;  
    top: 0;
    left: 0;
    height: 3px;
    background-color: var(--primary-dark);
    border-radius: 0 0 4px 4px;
    transition: transform 0.3s ease;
}

/* Dropdown styles */
.dropdown {
    position: absolute;
    bottom: 100%;
    right: -50%;
    transform: translateX(-50%) translateY(10px);
    background-color: var(--surface);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 0.5rem;
    width: 200px;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    margin-bottom: 10px;
}

.dropdown::before {
    content: '';
    position: absolute;
    bottom: -6px;
    right: 13px;
    transform: translateX(-50%);
    width: 12px;
    height: 12px;
    background-color: var(--surface);
    border-right: 1px solid var(--border-color);
    border-bottom: 1px solid var(--border-color);
    transform-origin: center;
    rotate: 45deg;
}

.dropdown.active {
    opacity: 1;
    visibility: visible;
    transform: translateX(-50%) translateY(0);
}



.dropdown-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 0.75rem 1rem;
    color: var(--secondary-text);
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.dropdown-item:hover {
    background-color: var(--background);
    color: var(--text-color);
}


.dropdown-item i {
    font-size: 1rem;
    margin-right: 0.75rem;
    margin-bottom: 0 !important;
}
.dropdown-item svg {
    fill: var(--secondary-text);
    width: 24px;
    height: 24px;
}


.dropdown-item span {
    font-size: 0.9rem !important;
}
@media (max-width: 888px) {
    .bottom-nav{
        display: flex;
    }
}

/* Responsive styles */
@media (max-width: 380px) {
    .nav-item span {
        font-size: 0.7rem;
    }
    
    .nav-item i {
        font-size: 1rem;
    }

    .dropdown {
        width: 180px;
        padding: 0.4rem;
    }

    .dropdown-item {
        padding: 0.6rem 0.8rem;
    }

    .dropdown-item i {
        font-size: 0.9rem;
        margin-right: 0.5rem;
    }

    .dropdown-item span {
        font-size: 0.8rem !important;
    }
}

@media (max-width: 320px) {
    .nav-item {
        padding: 0.4rem 0.2rem;
    }

    .nav-item span {
        font-size: 0.65rem;
    }

    .nav-item i {
        font-size: 0.9rem;
    }




    .dropdown-item {
        padding: 0.5rem 0.6rem;
    }

    .dropdown-item i {
        font-size: 0.8rem;
        margin-right: 0.4rem;
    }

    .dropdown-item span {
        font-size: 0.75rem !important;
    }


}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<nav class="bottom-nav" id="bottom_nav">
    <a href="./admin_dashboard.php" class="nav-item">
        <svg xmlns="http://www.w3.org/2000/svg" style="width: 30px;" class="svg" viewBox="0 -960 960 960" fill="">
            <path d="M520-640v-160q0-17 11.5-28.5T560-840h240q17 0 28.5 11.5T840-800v160q0 17-11.5 28.5T800-600H560q-17 0-28.5-11.5T520-640ZM120-480v-320q0-17 11.5-28.5T160-840h240q17 0 28.5 11.5T440-800v320q0 17-11.5 28.5T400-440H160q-17 0-28.5-11.5T120-480Zm400 320v-320q0-17 11.5-28.5T560-520h240q17 0 28.5 11.5T840-480v320q0 17-11.5 28.5T800-120H560q-17 0-28.5-11.5T520-160Zm-400 0v-160q0-17 11.5-28.5T160-360h240q17 0 28.5 11.5T440-320v160q0 17-11.5 28.5T400-120H160q-17 0-28.5-11.5T120-160Zm80-360h160v-240H200v240Zm400 320h160v-240H600v240Zm0-480h160v-80H600v80ZM200-200h160v-80H200v80Zm160-320Zm240-160Zm0 240ZM360-280Z" />
        </svg>
        <span>Dashboard</span>
    </a>




    <a href="./users.php" class="nav-item">
        <svg 
            xmlns="http://www.w3.org/2000/svg" 
            viewBox="0 0 24 24" 
            width="24" 
            height="24" 
            fill="currentColor">
            <circle cx="12" cy="8" r="4"></circle>
            <path d="M12 14c-5 0-9 2.5-9 6v1h18v-1c0-3.5-4-6-9-6z"></path>
        </svg>

        <span>Users</span>
    </a>




    <a href="./admin_swap.php" class="nav-item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <g id="Transfer_data" data-name="Transfer data">
                <path d="M3.294,8.708l3,3a1,1,0,1,0,1.414-1.414L6.414,9H20a1,1,0,0,0,0-2H6.414L7.707,5.707A1,1,0,0,0,6.293,4.293l-3,3A1,1,0,0,0,3.294,8.708Z" />
                <path d="M20.706,15.292l-3-3a1,1,0,0,0-1.414,1.414L17.586,15H4a1,1,0,0,0,0,2H17.586l-1.293,1.293a1,1,0,0,0,1.414,1.414l3-3A1,1,0,0,0,20.706,15.292Z" />
            </g>
        </svg>
        <span>Covert</span>
    </a>
    <div class="nav-item" id="finance_nav">
        <svg height="24" id="svg8" version="1.1" class="svg_stroke" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg">
            <defs id="defs2">
                <rect height="7.0346723" id="rect2504" width="7.9207187" x="-1.1008456" y="289.81766"/>
            </defs>
            <g id="g1769" style="stroke-width:1.01669"  transform="matrix(0.98358049,0,0,0.98358049,-77.76606,40.305423)">
                <path d="M 55.564453,6.9824219 V 9.0332031 H 51.5 v 2.8671879 h -4.064453 v 2.822265 h -4.064453 v 6.617188 h -1.929688 c 0.03882,0.313006 -0.07693,0.781738 0.05664,1 h 21.060547 c -0.03885,-0.313006 0.07693,-0.781739 -0.05664,-1 H 60.628906 V 6.9824219 Z m 1,1.0019531 h 3.064453 v 13.34375 H 56.564453 Z M 52.5,10.033203 h 3.064453 V 21.328125 H 52.5 Z m -4.064453,2.869141 H 51.5 v 8.425781 h -3.064453 z m -4.064453,2.818359 h 3.064453 v 5.607422 h -3.064453 z" id="path1291" stroke:none; transform="matrix(1.0166936,0,0,1.0166936,38.396517,-40.97628)"/>
                <path d="m 57.597656,1.65625 v 4.5097656 1.3261719 l 0.998047,-0.056641 V 5.6757812 l 3.585938,-1.765625 z m 0.998047,1.6074219 1.318359,0.6464843 -1.318359,0.6484376 z" id="path1716" stroke:none; fill="" transform="matrix(1.0166936,0,0,1.0166936,38.396517,-40.97628)"/>
            </g>
        </svg>
        <span>Finance</span>
        <div class="dropdown">
         
           
            <a href="./admin_history.php" class="dropdown-item">
                <svg class="quick-action-icon" viewBox="0 0 24 24">
                    <path d="M13.5,8H12V13L16.28,15.54L17,14.33L13.5,12.25V8M13,3A9,9 0 0,0 4,12H1L4.96,16.03L9,12H6A7,7 0 0,1 13,5A7,7 0 0,1 20,12A7,7 0 0,1 13,19C11.07,19 9.32,18.21 8.06,16.94L6.64,18.36C8.27,20 10.5,21 13,21A9,9 0 0,0 22,12A9,9 0 0,0 13,3"/>
                </svg>
                <span>History</span>
            </a>

            <a href="./admin_features.php" class="dropdown-item">
                <svg 
                    xmlns="http://www.w3.org/2000/svg" 
                    viewBox="0 0 24 24" 
                    width="24" 
                    height="24" 
                    fill="currentColor">
                    <path d="M3 20h18v2H3v-2z"></path>
                    <rect x="5" y="10" width="4" height="8" rx="1"></rect>
                    <rect x="10" y="6" width="4" height="12" rx="1"></rect>
                    <rect x="15" y="2" width="4" height="16" rx="1"></rect>
                </svg>

                <span>Investment</span>
            </a>

            <a href="./admin_market.php" class="dropdown-item">
                <svg 
                    xmlns="http://www.w3.org/2000/svg" 
                    viewBox="0 0 24 24" 
                    width="24" 
                    height="24" 
                    fill="currentColor">
                    <path d="M4 4h16a2 2 0 0 1 2 2v2h-20V6a2 2 0 0 1 2-2z"></path>
                    <path d="M4 8a2 2 0 0 1-2 2h1a2 2 0 0 0 2-2H4zm5 0a2 2 0 0 1-2 2h2a2 2 0 0 0 2-2H9zm5 0a2 2 0 0 1-2 2h2a2 2 0 0 0 2-2h-2zm5 0a2 2 0 0 1-2 2h1a2 2 0 0 0 2-2h-1z"></path>
                    <path d="M2 10h20v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-8z"></path>
                    <rect x="10" y="14" width="4" height="4" rx="0.5"></rect>
                </svg>

                <span>Market</span>
            </a>
       
         
        </div>
    </div>
</nav>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
    const $navItems = $('.nav-item');
    const $indicator = $('.nav-indicator');
    const $financeNavItem = $('#finance_nav');
    const $bottomNavDropdown = $('.dropdown');

    
    function updateIndicator($element) {
        const width = $element.outerWidth();
        const left = $element.position().left;
        $indicator.css({
            width: `${width}px`,
            transform: `translateX(${left}px)`
        });
    }

    const $activeItem = $('.nav-item.active');
    if ($activeItem.length) {
        updateIndicator($activeItem);
    }

    $(window).on('resize', function() {
        const $activeItem = $('.nav-item.active');
        if ($activeItem.length) {
            updateIndicator($activeItem);
        }
    });


    let isDropdownOpen = false;
    $financeNavItem.on('click', function (e) {
        e.preventDefault();
        $financeNavItem.toggleClass("active");
        isDropdownOpen = !isDropdownOpen;
        $bottomNavDropdown.toggleClass('active', isDropdownOpen);
    });
    
    $(window).on('click', function (e) {

        if (!$financeNavItem.is(e.target) && $financeNavItem.has(e.target).length === 0 && isDropdownOpen) {
            isDropdownOpen = false;
            $bottomNavDropdown.removeClass('active');$financeNavItem
        }
    
    });
});



</script>


