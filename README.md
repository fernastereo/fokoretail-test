# API for a chat system

Chat application developed to enable instant communication between users, combining a REST API in PHP with [Laravel](https://laravel.com/) and a [VueJS](https://vuejs.org/) frontend interface. The solution integrates Sockets using Laravel Echo and [Pusher](https://pusher.com/), allowing real-time updates of messages and notifications, providing a smooth and responsive user experience in collaborative environments.

## Requirements
- Node.js 16.1.0
- npm 7.11.2
- PHP 7.3.21
- Laravel 7.0

## Instructions for run the app:

1. Clone this repository
2. Configure your environment variables for Pusher and Laravel by copying the `.env.example` to `.env`
3. You need a valid account on Pusher.com.
4. Run _composer install_
5. Run _npm install_
6. Set your Database credentials on .env file
7. Run the migrations with _php artisan migrate_
8. Optionally you can run the seeders for some data samples adding _--seed_ to the above command.
9. Run your local server with php artisan serve

## You can watch the app live on: https://fokochat.click/

User-demo: demo@fokochat.click
Password: demosecret

Or just register and start to talk with friends.

## You can know more about me on: https://fernandocueto.com/

## End Points

#### Update profile user information

`method: put`

`/api/profile/{user}`

#### Retrieve profile user information

`method: get`

`/api/profile/{user}`

#### Retrieve a list of stored conversations from the curren user

`method: get`

`/api/users/{user}/conversations`

#### Create a new conversation

`method: post`

`/api/conversations`

#### Retrieves messages from one conversation

`method: get`

`/api/messages/{conversation}`

#### Store and Send message to one conversations

`method: post`

`/api/messages`

#### Send invitation to any registered user

`method: post`

`/api/invite`

#### Retrieve invitations sent to an user

`method: get`

`/api/invitations/{user}`

#### Discard invitation sent by an user

`method: put`

`/api/invitations/{invitation}/deny`

-   Requires authentication. As of now, this can only be achieved by logging in manually on the website.

---

⭐ If you like this project, ¡give it a star on GitHub!
