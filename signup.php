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
            <link rel="stylesheet" href="assets/css/signup_&_login.css">
            <link rel="stylesheet" href="assets/css/main-mediaquery.css">
            <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/5.4.5/css/swiper.css">
            <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">




            <!-- ============FONT-AWESOME-LINKS============= -->
            <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
            <!-- ============JAVASCRIPT-LINKS============= -->
            <script src="js/country-states.js"></script>
        <!-- Smartsupp Live Chat script -->
<script type="text/javascript">
var _smartsupp = _smartsupp || {};
_smartsupp.key = 'f399bc2a5e46bded0f48e09eea82b52e49333bec';
window.smartsupp||(function(d) {
  var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
  s=d.getElementsByTagName('script')[0];c=d.createElement('script');
  c.type='text/javascript';c.charset='utf-8';c.async=true;
  c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
})(document);
</script>
<noscript> Powered by <a href=“https://www.smartsupp.com” target=“_blank”>Smartsupp</a></noscript>


        </head>


        <?php
            
            include 'signup_logic.php';

        ?>


        <style>
            @keyframes flash {
            0%{
                transform: scale(0.12) translateY(35%);
                /* opacity: 0; */
        
            }

            100%{
                transform: scale(1) translateY(0);
                /* opacity: 1; */

            }
        }

        /* ============STYLING AND ANIMATION FOR THE HTML TAG============= */
        html{
            scroll-behavior: smooth;
            animation: flash 1s cubic-bezier(0.23, 1, 0.32, 1);
        }

        </style>
        <body>
            
        <div class="go_back" style="display: flex; justify-content: space-between;">
                
                <a class="links" href="index.php">
                    <i class="fa fa-arrow-circle-left"></i>
                    back to home
                </a>

                <div>
                    <?php include("google_translator.php") ?>
                    <img  style="cursor: pointer;" onclick="openTranslator()" width="23" src="https://th.bing.com/th/id/R.41d2ce8e8a978b24248ac44af2322f65?rik=gj58ngXoj7iaIw&pid=ImgRaw&r=0" alt="">
                </div>
            </div>

            <div class="wrapper" id="signup_html">

                <div class="image">
                    <div class="image_wrapper">
                        <img src="https://img.freepik.com/free-vector/mobile-wireframe-concept-illustration_114360-7091.jpg?t=st=1737905445~exp=1737909045~hmac=c308c5371ed26da3115dd89fc0dec78a0648dd9efd1bf379541d58404ad01c2d&w=740" srcset="">
                        
                    </div>
                </div>

                <div class="form_wrapper">
                    <header>
                        <div class="logo">
                            <div class="image_wrapper">
                                <a class="links" href="index.php">
                                    <img src="assets/images/logo.png" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="text">
                            <div class="span">Get started with Simart Pro</div>
                        </div>
                    </header>

                    <form action="" method="POST" class="form">
                        <?php if (!empty($GLOBALS['ERROR'])): ?>            
                            <div id="error" class="error_message"><?php echo $GLOBALS['ERROR']; ?></div>
                            <?php 
                                unset($GLOBALS['ERROR']); 
                            ?>
                        <?php endif; ?>
                        <div class="two_form_groups">
                            <div class="input-group">
                                <input type="text" required id="first_name_input" name="fname">
                                <label for="">First Name</label>
                            </div>
            
                            <div class="input-group">
                                <input type="text" required id="last_name_input" name="lname">
                                <label for="">Last Name</label>
                            </div>
                        </div>

                        <div class="input-group">
                            <input type="email" id="email_input" name="email" required >
                            <label for="email">Email Address</label>
                        </div>

                        <div class="input-group">
                            <input type="tel" id="phone_input" name="phone" required >
                            <label for="contact">Phone Number</label>
                        </div>

                        
                
                            <!-- <label for="state" class="form-label">State</label> -->
                            <div class="input-group">
                                <select id="country"  name="nationality" required>
                                    <option>select country</option>
                                </select>
                                <label for="">Nationality</label>

                            </div>
                            
                            <div class="input-group">

                                <select id="state"  name="state" required>
                                    <option>_</option>
                                </select>
                                <label for="">State</label>
                
                            </div>
                            

                            <div class="input-group">
                                <input type="date" name="dob" required>
                                <label for="">Date of Birth</label>  
                            </div>
                                

                            <div class="input-group">
                                <select name="gender" required class="input-group">
                                <option value="">-- select one --</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Others">Others</option>
                            </select>
                            <label for="">Gender</label>

                            </div>


                        <div class="input-group">
                            <input type="password" id="password_input" name="password" required>
                            <label for="">Password</label>
                            <div class="show_password">
                                <div class="image_wrapper" id="eye_icon_container" style="display:block;">
                                    <img id="show_hide" src="assets/svg/eye-off-svgrepo-com.svg" alt="">
                                    <!-- <img src="assets/svg/eye-svgrepo-com.svg" alt=""> -->
                                </div>
                            </div>
                            <script>
                                const passwordInput = document.querySelector(`#password_input`);
                                const showPassword = document.querySelector(`#show_hide`);
                                const eyeIconWrapper = document.querySelector(`#eye_icon_container`);

                                showPassword.addEventListener(`click`, () => {

                                    if(passwordInput.type === (`password`)) {
                                        passwordInput.type = (
                                            `text`
                                        );
                                        showPassword.src = (
                                            `assets/svg/eye-svgrepo-com.svg`
                                        );
                                    }
                                    else{
                                        passwordInput.type = (
                                            `password`
                                        );
                                        showPassword.src = (
                                            `assets/svg/eye-off-svgrepo-com.svg`
                                        );
                                    }
                                });
                            </script>
                        </div>

                        <div class="input-group">
                            <input type="password" id="confirm_password_input" name="conf_pass" required>
                            <label for="">Confirm Password</label>
                        </div>


                         <!--PASSWORD ALERT_TEXT -->
                            <span id="password_alert"> 

                            </span>


                            <style>
                                   .terms-container {
                                        /* padding: 2rem; */
                                        border-radius: 1rem;
                                        width: 100%;
                                        transition: transform 0.2s ease;
                                    }

                                    .terms-container:hover {
                                        transform: translateY(-2px);
                                    }

                                    .checkbox-wrapper {
                                        display: flex;
                                        align-items: flex-start;
                                        gap: 0.75rem;
                                        position: relative;
                                        padding: 0.5rem;
                                        border-radius: 0.5rem;
                                    }

                                    .custom-checkbox {
                                        position: relative;
                                        width: 24px;
                                        height: 24px;
                                        flex-shrink: 0;
                                    }

                                    .custom-checkbox input {
                                        position: absolute;
                                        opacity: 0;
                                        cursor: pointer;
                                        height: 100%;
                                        width: 100%;
                                        z-index: 1;
                                    }

                                    .checkmark {
                                        position: absolute;
                                        top: 0;
                                        left: 0;
                                        height: 24px;
                                        width: 24px;
                                        background-color: #6e591a;
                                        border: 2px solid ;
                                        border-radius: 6px;
                                        transition: all 0.2s ease;
                                    }

                                    .custom-checkbox input:checked ~ .checkmark {
                                        background-color:  #B68E2E;
                                        border-color: #6e591a;
                                    }

                                    .checkmark:after {
                                        content: "";
                                        position: absolute;
                                        display: none;
                                        left: 8px;
                                        top: 4px;
                                        width: 5px;
                                        height: 10px;
                                        border: solid white;
                                        border-width: 0 2px 2px 0;
                                        transform: rotate(45deg);
                                    }

                                    .custom-checkbox input:checked ~ .checkmark:after {
                                        display: block;
                                    }

                                    .terms-text {
                                        font-size: 1rem;
                                        line-height: 1.5;
                                        color: #6e591a;
                                    }

                                    .terms-link {
                                        
                                        color: #B68E2E;
                                        text-decoration: none;
                                        font-weight: 500;
                                        position: relative;
                                        transition: color 0.2s ease;
                                    }

                                    .terms-link:hover {
                                        color: #6e591a;
                                    }

                                    .terms-link::after {
                                        content: '';
                                        position: absolute;
                                        width: 100%;
                                        height: 2px;
                                        bottom: -2px;
                                        left: 0;
                                        background-color: currentColor;
                                        transform: scaleX(0);
                                        transition: transform 0.2s ease;
                                    }

                                    .terms-link:hover::after {
                                        transform: scaleX(1);
                                    }

                                   
                                 
                            </style>
                            <div class="terms-container">
                                <label class="checkbox-wrapper">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" name="terms" id="terms" checked>
                                        <span class="checkmark"></span>
                                    </div>
                                    <span class="terms-text">
                                        I agree to these <a href="./terms_conditions.php" class="terms-link">Terms and Conditions</a>
                                    </span>
                                </label>
                            </div>
                            <div class="submit_btn_wrapper">
                                <button type="submit" name="signup_btn">Sign up</button>
                            </div>

                        


                        <!-- ALREADY HAVE AN ACCOUNT? LOGIN! -->
                        <div class="already_have_an_account">
                            <span>Already have an Account?</span>
                            <a class="links" href="login.php">Login</a>
                        </div>
                            
                    </form>
                </div>
            </div>



        




            


            


            <!-- ============ PRELOADER ANIMATION============= -->
            <section class="preloader_animation">
                <div class="wrapper">
                    <div class="logo">
                        <div class="image_wrapper">
                            <img src="assets/images/logo.png" alt="">
                        </div>
                    </div>

                    <div class="loading_svg">
                        <div class="image_wrapper">
                            <img class="bouncing_circles" src="assets/svg/bouncing-circles.svg" alt="">
                        </div>
                    </div>
                </div>
            </section>

            <script>
                // user country code for selected option
                var user_country_code = "US";

                (() => {
                    // script https://www.php-code-generator.com/html/drop-down/state-name

                    // Get the country name and state name from the imported script.
                    const country_list = country_and_states.country;
                    const state_list = country_and_states.states;

                    const id_state_option = document.getElementById("state");
                    const id_country_option = document.getElementById("country");

                    const create_country_selection = () => {
                        let option = '';
                        option += '<option value="">select country</option>';
                        for (const country_code in country_list) {
                            // set selected option user country
                            let selected = (country_code == user_country_code) ? ' selected' : '';
                            option += '<option value="' + country_code + '"' + selected + '>' + country_list[country_code] + '</option>';
                        }
                        id_country_option.innerHTML = option;
                    };

                    const create_states_selection = () => {
                        // selected country code
                        let selected_country_code = id_country_option.value;
                        // get state names by selected country-code
                        let state_names = state_list[selected_country_code];

                        // if invalid country code
                        if (!state_names) {
                            id_state_option.innerHTML = '<option>select state</option>';
                            return;
                        }
                        // create option
                        let option = '';
                        option += '<option>select state</option>';
                        state_names.forEach(state => {
                            option += '<option value="' + state.code + '">' + state.name + '</option>';
                        });
                        id_state_option.innerHTML = option;
                    };

                    // country select change event update state code
                    id_country_option.addEventListener('change', create_states_selection);

                    create_country_selection();
                    create_states_selection();
                })();
            </script>
            
         

            
        </body>
                <!-- ============JAVASCRIPT-LINKS============= -->
                <script src="assets/javascript/function.js"></script>
                <script src="assets/javascript/app.js"></script>

                

</html>

