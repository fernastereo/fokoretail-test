# API for a chat system

In This repository I make use of [Laravel](https://laravel.com/) and [Pusher](https://pusher.com/) for developing the API and [VueJS](https://vuejs.org/) for the frontend in an approach for an SPA. Instructions for run the app:

1. Clone this repository
2. Configure your environment variables for Pusher and Laravel by copying the `.env.example` to `.env`
3. You need a valid account on Pusher.com.
4. Run _composer install_
5. Run _npm install_
6. Set your Database credentials on .env file
7. Run the migrations with _php artisan migrate_
8. Optionally you can run the seeders for some data samples adding _--seed_ to the above command.
9. Run your local server with php artisan serve

## You can watch the app live on: http://13.52.80.153/

Just register and start to talk with friends.

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
