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

# Test Data Credentials

Upon seeding, these are the credentials to be used

```
----- Admin ------
Email: admin@info.com
Password: password

------ User ------
Email: user@info.com
Password: password
```

# Additional Admin Accounts

Run the command below on command line to generate an admin account.

```
php artisan admin:register
```

# Remaining Tasks

1. Datatable ajax on `../quiz/1/score` and `../admin/reports/student/1/scores` pages are not yet finished, initial code is commented for guide and [this](https://github.com/yajra/laravel-datatables) package was used for the datatables.
2. Issue of practice mode sound effects not working on safari.
either 3. Further improvements on importing data cause sometimes it throws a `Maximum execution time of 30 seconds exceeded` or `Allowed memory size of 134217728 bytes exhausted (tried to allocate 24 bytes)` error. [This](https://github.com/Maatwebsite/Laravel-Excel) package was used for the import and export features.
3. 
