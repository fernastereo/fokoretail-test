# API for a chat system

In This repository I make use of [Laravel](https://laravel.com/) and [Pusher](https://pusher.com/) for developing the API and [VueJS](https://vuejs.org/) for the frontend in an approach for an SPA. Instruction for run the app:

1. Clone this repository
2. Configure your environment variables for Pusher and Laravel by copying the `.env.example` to `.env`
3. You need a valid account on Pusher.com.
4. Run *composer install*
5. Run *npm install*
6. Set your Database credentials on .env file
7. Run the migrations with *php artisan migrate*
8. Optionally you can run the seeders for some data samples adding *--seed* to the above command.
9. Run your local server with php artisan serve

## End Points

#### Update profile user information
`method: put`

`/api/profile/{user}`


#### Retrieve profile user information
`method: get`

`/api/profile/{user}`


#### Retrieve a list of stored  conversations
`method: get`

`/api/conversations`


#### Create a new conversation
`method: post`

`/api/conversations`


#### Retrieves messages from one user
`method: get`

`/api/messages/{user}`


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


#### Retrieve a list of groups of conversation
`method: get`

`/api/groups`


#### Create a group of conversation
`method: post`

`/api/groups`

* Requires authentication. As of now, this can only be achieved by logging in manually on the website.