<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$apiUrl = "https://api.dpip.lol/subdomain/list?key=SUPER_SECRET_API_TOKEN";

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $apiUrl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); // Follow redirects

$response = curl_exec($curl);
if ($response === false) {
    echo "cURL Error: " . curl_error($curl);
    curl_close($curl);
    exit;
}
curl_close($curl);

$response = trim($response);
$data = json_decode($response, true);

if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
    echo "JSON Error: " . json_last_error_msg();
    exit;
}

if (!isset($data['success']) || !$data['success']) {
    echo "The 'success' key is missing or set to 'false'.";
    exit;
}

if (!isset($data['subdomains']) || !is_array($data['subdomains'])) {
    echo "The 'subdomains' key is missing or not an array.";
    exit;
}

$keywordsToExclude = ['keywords_to_exclude_from_results'];

$filteredSubdomains = array_filter($data['subdomains'], function ($subdomain) use ($keywordsToExclude) {
    if (!in_array($subdomain['type'], ['A', 'AAAA', 'CNAME'])) {
        return false;
    }

    if (strpos($subdomain['name'], 'prv') === 0) {
        return false;
    }

    foreach ($keywordsToExclude as $keyword) {
        if (strpos($subdomain['name'], $keyword) !== false) {
            return false;
        }
    }

    return true;
});

$subdomainNames = array_map(function ($subdomain) {
    return $subdomain['name'];
}, $filteredSubdomains);
$subdomainNames = array_values($subdomainNames);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/img/logo.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>DouxxPI Private domains</title>
    <meta name="description" content="List of available subdomains on dpip.lol">
</head>
<body>
    <!-- Header -->
    <header class="header" id="header">
        <nav class="nav container">
            <a href="#" class="nav__logo">
                <img src="../assets/img/big_logo.png" alt="">
            </a>
            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li class="nav__item">
                        <a href="/" class="nav__link active-link">Home</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <main class="main">
        

        <!-- Home Section -->
        <section class="home section" id="home">
            <div class="home__container container grid">
                <div>
                    <img src="../assets/img/big_logo_2.png" alt="" class="home__img">
                </div>
                
                <div class="home__data">
                    <div class="home__header">
                        <h1 class="home__title">DPIP</h1>
                        <h2 class="home__subtitle">.lol</h2>
                    </div>

                    <div class="home__footer">
                        <h3 class="home__title-description">DPIP.lol Subdomains</h3>
                        <p class="home__description">Here are all the subdomains of <strong>dpip.lol</strong>, take a look at the projects !</p>
                        <a href="https://dpip.lol/" class="button button--flex">
                            <span class="button--flex">
                                Back to home
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Subdomain Section -->
    <section class="discount section" id="subdomains">
            <div class="discount__container container grid">
                <div class="discount__animate">
                    <h2 class="discount__title">Available Subdomains</h2>
                    <p class="discount__description">Check out our available subdomains:</p>
                    <div class="subdomain-box">
                        <ul class="subdomain-list">
                            <?php if (!empty($subdomainNames)): ?>
                                <?php foreach ($subdomainNames as $subdomain): ?>
                                    <li>
                                        <a href="https://<?php echo htmlspecialchars($subdomain); ?>" target="_blank">
                                            <?php echo htmlspecialchars($subdomain); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li>No subdomains found.</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <img src="../assets/img/big_logo.png" alt="" class="discount__img">
            </div>
        </section>

    <!-- Footer -->
    <footer class="footer section">
        <div class="footer__container container grid">
            <a href="#" class="footer__logo">
                <img src="../assets/img/logo.png" alt="">
            </a>
            <div class="footer__content">
                <h3 class="footer__title">Featured websites</h3>
                <ul class="footer__links">
                    <li>
                        <a href="https://douxx.tech" target="_blank" class="footer__link">douxx.tech</a>
                    </li>
                    <li>
                        <a href="https://douxx.xyz" target="_blank" class="footer__link">douxx.xyz</a>
                    </li>
                    <li>
                        <a href="https://2peek.me" target="_blank" class="footer__link">2peek.me</a>
                    </li>
                    <li>
                        <a href="https://getan.email" target="_blank" class="footer__link">getan.email</a>
                    </li>
                </ul>
            </div>

            <div class="footer__content">
                <h3 class="footer__title">Some information</h3>
                <ul class="footer__links">
                    <li>
                        <p>V 1.0 '/subdomains'</p>
                    </li>
                    <li>
                        <a href="mailto:douxx@douxx.tech" target="_blank" class="footer__link">douxx@douxx.tech</a>
                    </li>
                    <li>
                        <a href="https://xc.dpip.lol" target="_blank" class="footer__link">some game server</a>
                    </li>
                    <li>
                        <a href="https://rick.dpip.lol" target="_blank" class="footer__link">A rickroll</a>
                    </li>
                </ul>
            </div>

            <div class="footer__content">
                <form action="" class="footer__form" id="subscribeForm">
                    <input type="email" placeholder="Email" class="footer__input" required>
                    <button type="submit" class="button button--flex">
                        <i class="ri-send-plane-line button__icon"></i> Subscribe
                    </button>
                </form>
                <div class="footer__social">
                    <a href="https://github.com/douxxu" target="_blank" class="footer__social-link">
                        <i class="ri-github-fill"></i>
                    </a>
                    <a href="https://tiktok.com/@douxxpi" target="_blank" class="footer__social-link">
                        <i class="ri-tiktok-fill"></i>
                    </a>
                    <a href="https://discord.com/users/1117912749146656790" target="_blank" class="footer__social-link">
                        <i class="ri-discord-fill"></i>
                    </a>
                </div>
            </div>
        </div>
        <p class="footer__copy">
            <a href="https://douxx.tech" target="_blank" class="footer__copy-link">&#169; douxx.tech. All rights reserved</a>
        </p>
    </footer>

    <!-- Scroll Up Button -->
    <a href="#" class="scrollup" id="scroll-up">
        <i class="ri-arrow-up-s-line scrollup__icon"></i>
    </a>
    
    <!-- Main JS -->
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="../assets/js/main.js"></script>

    <!-- Additional CSS -->

    <style>
        .subdomain-box {
            height: 100%;
            max-height: 150px;
            overflow-y: auto;
            border: 1px solid #444;
            border-radius: 5px;
            padding: 10px;
            background-color: #2c2c2c;
        }
        .subdomain-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .subdomain-list li {
            margin: 5px 0;
        }
        .subdomain-list a {
            display: inline-block;
            text-decoration: none;
            color: #e0e0e0;
            background-color: #444;
            padding: 10px;
            border-radius: 5px;
            transition: all 0.3s;
            width: calc(100% - 20px);
        }
        .subdomain-list a:hover {
            background-color: #555;
            transform: scale(1.05);
            color: #fff;
        }
    </style>


</body>
</html>