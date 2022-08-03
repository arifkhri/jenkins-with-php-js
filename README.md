# php-jenkins-log 

Web app to showing a log from jenkins using php & php-curl-class, auto deploy with paramiko using python3

---
## Requirement

- php : v7.4.29 
- composer : v2.1.9 
- python: v3.10.0

    
## Installation
1. Set jenkins id, key, and ulr inside /src/controllers/home.php
2. Set dropdown options inside /src/config/jenkins.php
3. copy vhost.conf to your nginx vhost
4. access http://localhost:2100

## Deployment
Before deploy we should
> 1. Set ip staging inside /src/config/index.php
>2.  Set ip, username, and password inside /deploy.py

    $ python3
    $ python3 deploy.py


