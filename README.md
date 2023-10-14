# qkit
[![MIT](https://img.shields.io/badge/qKit-1.0.0–beta-green.svg)]() 
[![MIT](https://img.shields.io/badge/License-MIT-green.svg)](https://choosealicense.com/licenses/mit/) 
[![PHP](https://img.shields.io/badge/PHP-8.0+-7a86b8.svg)](https://www.php.net/)
[![Composer](https://img.shields.io/badge/Composer-2.0.0+-f98e03.svg)](https://getcomposer.org/)

A PHP Framework from scratch.

# What is it's purpose?
It's a framework aiming to create a fast and easy solution for people that don't want too much crammed in a framework..
under 100kb.

# I want a templating engine! I want this and that!
I have already put those [here](https://github.com/testcore-labs/qkit-modules)

## Deployment

To deploy this project, run:
```bash
  composer require
```

Then get nginx and make sure all of your requests go to /public/index.php as this framework has a router.

nginx conf for example:
```nginx
server {
        listen 80;
        listen [::]:80;

        root /home/qkit/public/;
        index index.php;

        server_name localhost;

        location / {
         try_files $uri $uri/ /index.php?$query_string;
        }

        location ~ \.php$ {
         try_files $uri =404;
         include fastcgi_params;
         fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
         #fastcgi_index index.php;
         fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        }
}
```

.. and that's it. Dead simple.

Will document more, just go into the `core/` folder and you will be able to read it mostly.. `public/index.php` has examples for routing. 
