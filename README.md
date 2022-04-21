# API Subscriber Platform

Create a simple subscription platform(only RESTful APIs with MySQL) in which users can subscribe to a website (there can be multiple websites in the system). Whenever a new post is published on a particular website, all it's subscribers shall receive an email with the post title and description in it. (no authentication of any kind is required)


# Installation
1. Clone the repository
2. Run the following command to generate .env file for the project and generate the application key
```
composer run-script post-root-package-install
composer run-script post-create-project-cmd
```
3. Modified the .env file to your needs
4. Run the following command to generate the database
```
php artisan migrate
```
or with seeders
```
php artisan migrate --seed
```

# API Documentation
It's included as the file `API Subscriber Platform.postman_collection.json` in the root directory of the repository. Using Postman v.2.1


