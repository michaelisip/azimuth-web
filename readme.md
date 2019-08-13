# Azimuth

Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam quidem minima praesentium consequuntur numquam ratione iste perferendis quo hic. Magni, earum! Consequatur excepturi possimus sed voluptatem molestiae praesentium, quam consequuntur!


# Installation

```
1. npm install
2. composer install
3. Duplicate .env.example and rename to .env and fill your values
4. php artisan serve
5. php artisan migrate
6. open in browser
```

# Credentials
```
----- Admin ------
Email: admin@info.com
Password: password

------ User ------
Email: user@info.com
Password: password
```

# Generating Data

By default, ehen migrating the database schemas, seeders for the users, admin, and quiz questions table will automatically generated for us. To add more data for testing purposes, run the following command:
```
php artisan db:seed
```

## Additional Admin Accounts

If for some reason we need to register another admin, we just need to run the below command on our command line and input the desired information.
```
php artisan admin:register
```

## Additional Quizzes and Questions

To add more quizzes and questions, simply run the following command to generate 5 quizzes with 10 questions for each.
```
php artisan db:seed --class=QuizQuestionsSeeder
```


## Additional Users

To add more users, simply run the following command to generate 100 users.
```
php artisan db:seed --class=UsersSeeder
```

