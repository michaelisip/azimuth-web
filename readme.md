# Azimuth

Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam quidem minima praesentium consequuntur numquam ratione iste perferendis quo hic. Magni, earum! Consequatur excepturi possimus sed voluptatem molestiae praesentium, quam consequuntur!

# Documentation

## Default Credentials
```
----- Admin ------
Email: admin@info.com
Password: password

------ User ------
Email: user@info.com
Password: password
```

## Creating Admin Account

When migrating the database schemas, seeders for the users and admin table will automatically generated for us. If for some reason we need to register another admin, we just need to run the below command on our command line and input the desired information.
```
php artisan admin:register
```

## Adding Users

To add more users, simply run the following command to generate 100 users.
```
php artisan db:seed --class=UsersSeeder
```

