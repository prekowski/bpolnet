bPolNet
=======

Project by Paweł Rekowski <pawel.rekowski@gmail.com>

To run this project call

```php
git clone https://github.com/prekowski/bpolnet.git
cd bpolnet
composer install
./bin/console doctrine:database:create 
./bin/console doctrine:schema:create 
./bin/console doctrine:fixtures:load --purge-with-truncate  
./bin/console server:start
```

To run command
```php
$ ./bin/console app:cancel-subscription
```

To activate subscription please enter http://127.0.0.1:8000, click subscription show link and RED Active Subscription link.
Next add your credit Card - Yes, your card will be send to anonymous and clear after this action ;)

Have fun :)