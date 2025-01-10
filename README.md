<div align="center">

<a href="https://dpip.lol" style="display: block; text-align: center;">
  <img alt="DPIP.lol Logo" src="https://images.dpip.lol/big_logo.png" />
  <h1 align="center">DPIP.lol</h1>
</a>

</div>
<p align="center">
  DouxxPI Private domains
</p>

<p align="center">
  <a href="#introduction"><strong>Introduction</strong></a> ·
  <a href="#deployment"><strong>Deployment</strong></a>
</p>
<br/>

## Introduction
DPIP.lol (Accronym for DouxxPI Private domains) is a general purposes domain used by douxxpi / douxxu (douxx.tech)
This repo contains the landing page and the mail api. Feel free to make PRs to improve it !

## Deployment
To host the landing page, you'll need a web server like apache2 or ngnix. Just clone the repository into your document root and you should be fine.
To host the API, you'll need to create a file names `utils/secrets.php` containing this php script:

```php
<?php
define('DB_HOST', 'HOST:PORT');
define('DB_USER', 'USERNAME');
define('DB_PASS', 'PWD');
define('DB_NAME', 'NAME');
define('TOKEN', 'MAILAPI_TOKEN')
?>
```

Once done, be sure that php is running on your webserver and you should be ok !

---
This project is licensed under the GPL-3.0 license.
Made by </> Douxx.tech

