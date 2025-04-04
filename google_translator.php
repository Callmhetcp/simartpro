
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
        body, select, button {
            margin: 0;
            padding: 0;
            color: var(--text-color);
        }

        .skiptranslate,
        .goog-te-banner-frame {
            display: none !important;
        }

        body {
            top: 0 !important;
        }
        @keyframes bounce-in {
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
        }

        .translator-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #000000b1;
            backdrop-filter: blur(8px); 
            z-index: 1000;
            visibility: hidden;
            opacity: 0;
            transition: all 0.3s ease;
        }
        .translator-close-container{
            display: flex;
            justify-content: end;
            padding: 20px;
        }
        


        .translator-close {
            background-color: var(--background);
            color: white;
            padding: 0.7rem 2rem;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            text-align: center;
            box-shadow: inset 0 0 0 1px var(--border-color);
            border: none;
            &:hover{
                background-color: var(--primary-dark);
                border: none;
                box-shadow: none;


            }
        }
        .translator-container{
            display: flex;
            justify-content: center;
            align-items: center;
            height: 70vh;
        }
        .translator-content {
            width: 300px;
            transform: translate(-50%, -50%);
            background-color: var(--background);
            border: 1px solid var(--border-color);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            z-index: 1001;
            scale: 1.3;
        }
        .bounce-in{
            animation: bounce-in 0.7s forwards;
        }


        .google-translator {
            padding: 20px;
        }

        .translate-wrapper {
            position: relative;
            width: max-content;
        }

        .language-select {
            width: 215px;
            padding: 10px;
            background-color: var(--background);
            border: 1px solid var(--border-color);
            border-radius: 7px;
            color: var(--text-clr);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            appearance: none;
            transition: all 0.2s ease;
        }

        .language-select:hover {
            border-color: var(--primary-dark);
        }

        .language-select:focus {
            outline: none;
            border-color: var(--primary-dark);
            box-shadow: 0 0 0 4px rgba(94, 99, 255, 0.15);
        }

        .language-select option {
            background-color: var(--background);
            color: var(--text-clr);
            padding: 12px;
            font-size: 15px;
        }

        #google_translate_element2 {
            display: none !important;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { transform: translateY(100%); }
            to { transform: translateY(0); }
        }

        .language-select::-webkit-scrollbar {
            width: 8px;
        }

        .language-select::-webkit-scrollbar-track {
            background: var(--hover-color);
            border-radius: 4px;
        }

        .language-select::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 4px;
        }

        .language-select::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }


        @media (max-width: 480px) {
            .popup-content {
                padding: 20px 16px;
            }
            
            .language-select {
                font-size: 15px;
                padding: 14px;
            }
        }
        #google_translate_element2 {
            display: none !important;
        }

        .translate-button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: var(--accent-clr);
            color: var(--text-clr);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .translate-button:hover {
            background-color: #4a4dff;
        }

        @media (max-width: 480px) {
            .translator-container{
                scale: 0.88;
            }
            .language-select {
                width: 200px;
            }
        }
        @media (max-width: 380px) {
            .translator-container{
                scale: 0.78;
            }
        }
    </style>


    <div class="translator-overlay" id="translatorOverlay">
        <div class="translator-close-container">
            <button class="translator-close" onclick="closeTranslator()">Close</button>
        </div>
        <div class="translator-container">
            <div class="translator-content">
                <div class="google-translator">
                    <div class="translate-wrapper">
                        <div class="arrow-down" style="position:absolute; top:24%; right:4px; background: transparent; padding-right:10px;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="" style="stroke: var(--text-clr); fill:none;">
                                <path d="M19 9l-7 7-7-7" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <select class="language-select" onchange="doGTranslate(this);" style="font-size: 11px;">
                            <option value="">Select Language</option>
                            <option value="en|en">English</option>
                            <option value="en|af">Afrikaans</option>
                            <option value="en|sq">Albanian</option>
                            <option value="en|ar">Arabic</option>
                            <option value="en|hy">Armenian</option>
                            <option value="en|az">Azerbaijani</option>
                            <option value="en|eu">Basque</option>
                            <option value="en|be">Belarusian</option>
                            <option value="en|bg">Bulgarian</option>
                            <option value="en|ca">Catalan</option>
                            <option value="en|zh-CN">Chinese (Simplified)</option>
                            <option value="en|zh-TW">Chinese (Traditional)</option>
                            <option value="en|hr">Croatian</option>
                            <option value="en|cs">Czech</option>
                            <option value="en|da">Danish</option>
                            <option value="en|nl">Dutch</option>
                            <option value="en|et">Estonian</option>
                            <option value="en|tl">Filipino</option>
                            <option value="en|fi">Finnish</option>
                            <option value="en|fr">French</option>
                            <option value="en|gl">Galician</option>
                            <option value="en|ka">Georgian</option>
                            <option value="en|de">German</option>
                            <option value="en|el">Greek</option>
                            <option value="en|ht">Haitian Creole</option>
                            <option value="en|iw">Hebrew</option>
                            <option value="en|hi">Hindi</option>
                            <option value="en|hu">Hungarian</option>
                            <option value="en|is">Icelandic</option>
                            <option value="en|id">Indonesian</option>
                            <option value="en|ga">Irish</option>
                            <option value="en|it">Italian</option>
                            <option value="en|ja">Japanese</option>
                            <option value="en|ko">Korean</option>
                            <option value="en|lv">Latvian</option>
                            <option value="en|lt">Lithuanian</option>
                            <option value="en|mk">Macedonian</option>
                            <option value="en|ms">Malay</option>
                            <option value="en|mt">Maltese</option>
                            <option value="en|no">Norwegian</option>
                            <option value="en|fa">Persian</option>
                            <option value="en|pl">Polish</option>
                            <option value="en|pt">Portuguese</option>
                            <option value="en|ro">Romanian</option>
                            <option value="en|ru">Russian</option>
                            <option value="en|sr">Serbian</option>
                            <option value="en|sk">Slovak</option>
                            <option value="en|sl">Slovenian</option>
                            <option value="en|es">Spanish</option>
                            <option value="en|sw">Swahili</option>
                            <option value="en|sv">Swedish</option>
                            <option value="en|th">Thai</option>
                            <option value="en|tr">Turkish</option>
                            <option value="en|uk">Ukrainian</option>
                            <option value="en|ur">Urdu</option>
                            <option value="en|vi">Vietnamese</option>
                            <option value="en|cy">Welsh</option>
                            <option value="en|yi">Yiddish</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="google_translate_element2"></div>

    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2"></script>
    <script>
        eval(function(p, a, c, k, e, r) {
            e = function(c) {
                return (c < a ? '' : e(parseInt(c / a))) + ((c = c % a) > 35 ? String.fromCharCode(c + 29) : c.toString(36))
            }
            ;
            if (!''.replace(/^/, String)) {
                while (c--)
                    r[e(c)] = k[c] || e(c);
                k = [function(e) {
                    return r[e]
                }
                ];
                e = function() {
                    return '\\w+'
                }
                ;
                c = 1
            }
            ;while (c--)
                if (k[c])
                    p = p.replace(new RegExp('\\b' + e(c) + '\\b','g'), k[c]);
            return p
        }('6 7(a,b){n{4(2.9){3 c=2.9("o");c.p(b,f,f);a.q(c)}g{3 c=2.r();a.s(\'t\'+b,c)}}u(e){}}6 h(a){4(a.8)a=a.8;4(a==\'\')v;3 b=a.w(\'|\')[1];3 c;3 d=2.x(\'y\');z(3 i=0;i<d.5;i++)4(d[i].A==\'B-C-D\')c=d[i];4(2.j(\'k\')==E||2.j(\'k\').l.5==0||c.5==0||c.l.5==0){F(6(){h(a)},G)}g{c.8=b;7(c,\'m\');7(c,\'m\')}}', 43, 43, '||document|var|if|length|function|GTranslateFireEvent|value|createEvent||||||true|else|doGTranslate||getElementById|google_translate_element2|innerHTML|change|try|HTMLEvents|initEvent|dispatchEvent|createEventObject|fireEvent|on|catch|return|split|getElementsByTagName|select|for|className|goog|te|combo|null|setTimeout|500'.split('|'), 0, {}))
    </script>

    <script>
        function googleTranslateElementInit2() {
    new google.translate.TranslateElement({
        pageLanguage: 'en',
        autoDisplay: false
    }, 'google_translate_element2');
}

function openTranslator() {
    document.getElementById('translatorOverlay').style.visibility = 'visible';
    document.getElementById('translatorOverlay').style.opacity = '1';
    document.querySelector('.translator-content').classList.add('bounce-in');

}

function closeTranslator() {
    document.getElementById('translatorOverlay').style.visibility = 'hidden';
    document.getElementById('translatorOverlay').style.opacity = '0';
    document.querySelector('.translator-content').classList.remove('bounce-in');
}
    </script>