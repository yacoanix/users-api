# CRM API

In this API you can manage a CRM in which you can create a customer database. There may be more than one user who can manage this list of clients, and these users will be managed by a user with 'Admin' role.

## Install Project

### Requirements
- PHP >= 7.3
- Laravel utilizes Composer to manage its dependencies. So, before using Laravel, make sure you have [Composer](https://getcomposer.org/) installed on your machine.

### Instructions
- Clone the project on your machine.
- Go to the root directory of the project and run the following command:

```
$ composer install
```
- Configure your .env file, more information about this [here](https://laravel.com/docs/8.x/configuration#environment-configuration).
- Run the next commands:
```
$ php artisan key:generate
```
```
$ php artisan storage:link
```
- Execute the migrations and seeders of the project (Before configuring the database values in your .env file).
```
$ php artisan migrate --seed
```
- Finally you need run this commands
```
$ php artisan optimize:clear
```
```
$ php artisan passport:install
```

- And the project is ready to use.

### Local Development Server

If you have PHP installed locally and you would like to use PHP's built-in development server to serve your application, you may use the serve Artisan command. This command will start a development server at http://localhost:8000:
```commands
php artisan serve
```

## API Resources

- For all API requests, the following headers must be added:

```json
{
    "headers": {
        "Content-Type": "application/json",
        "X-Requested-With": "XMLHttpRequest"
    }
}
```
- This API is created with an OAuth 2 authentication protocol. For almost all requests (except Login) it will be necessary to be authenticated. For this you will have to add the header 'Authorization' with the parameters 'token_type' and 'access_token' that the Login returns. Example:

```json
{
    "headers": {
        "Content-Type": "application/json",
        "X-Requested-With": "XMLHttpRequest",
        "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiOGNiMDdmZDM5MzRkYmNiMGQwNzE3MGJlMWM3OWVjMDc1NjIwZGFkNzM4MTkxZTg0NmJjZDZkY2MxOWYwZTY5MzhjM2YzYjI3YjcwNzQxZTkiLCJpYXQiOjE2MjY1NDAxODkuNzM2NTQ5LCJuYmYiOjE2MjY1NDAxODkuNzM2NTUyLCJleHAiOjE2NTgwNzYxODkuNzI1Njc5LCJzdWIiOiIxMiIsInNjb3BlcyI6W119.sHiMki0FIChyQjoiHwVFVV0Kkrn_DsMHxgp4jxzGrlG4Uq4_LEjMKO0exYOA68uQRYB1WYpYsfvNGFYErK8ERRMlI7S_4Vkhm16N5-Dy7hwiOlkMbz74bTFXj9HN1MLpOdEkQTrQghgEmqw1nQTk6Y1BzIpoMdHPjG8dwegzIQDigY6tmOsQp1CRWF3CjKVCGNYli1LPxoEIRIv3dO-bT9yccQwalmWi2d_2JO20JVu03qTkmlruKSq-cFHxQBzF3auUcIY9GfJiiWgr4YeGddDWL5D-kjLEHVs9nT8bPbmYxnazeR_hhmiJmXR99V8B-2gzy2Hz0viSo7bi9bSDB1YHta6u5QcgAsHUMzGbDtouzLqnDgqIfcfFKoXFHEpDHfskHYM9Mz0s1nIqlWjO2dEzfJvj9kDyDukHMl1eMpWJiPy6zVhl37f3oWFXo8d-TFwFt5stCHOogQqyuhG3HamnmPHKgR7EfHbe652-zxBfIGevBTQhYDV92bwjbP4YFCyQdKXwZ9kmSLm6CYxb096yU34awnyk0QtTG9ZYQAAn6n8oyVeRPGhzjgvWBk-NSk8xAtb-pdSowBQeo7NdjUKeh1CEil3ekQS7DArDoQvcpijKX5PSE7m8VedLPAq-gu9k5CuaBoUcInhqf6Kz8eYIdjRUW9-XDzp_mfki058"
    }
}
```

### Authentication

#### Login
**- URL:**
```url
POST: http://www.yacoanix.com/api/v1/auth/login
```
**- Parameters:**
- email: (String, Required) User email.
- password: (String, Required) User password.

**- Response:**
```json
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNDM3MzVmYTUzMTAyMjc5ZmRkNTNmYTY3Nzc4ZTNkMjdiNThkNWRmNTZhNTU0ZjMyY2RjYTMwNDEzNGZkNzEzZjRjMTJjMWI0YzE2YzlmNjEiLCJpYXQiOjE2MjY2MjY2NzAuODY3MTEzLCJuYmYiOjE2MjY2MjY2NzAuODY3MTE3LCJleHAiOjE2NTgxNjI2NzAuODU5NTQxLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.pOTdp2WjA_p6qNiUTJaeOR1iSVBcwnaEIT-33N9wVhyDcqEWf_XmbETfN493E4wraG0zWLAngibe155uUzVbaqBuxEx6BOOhLUNozZ-_PVFXfHxl61LSRIPFNTNkCEI2RMcDQCRef8BnUewHyq8ZpQFalGXH0g64GjxVJwmUSTUsHNRqNp2LGJnBP45r9N59Hgj3jcDPKdcrOu-DEfqh2VxbmEEsM2f5cq0Osofo0YBpuDXepwqfHYd-zvW8iBj18F7kvokdZ0LXU_wL7Yz1ORQZ7ZRW6dNNDp1tggI8GtFrL0bTLZ3w0u_7PptiPUpFAb-vjP4uvAOVXBryOckA8l1nkV1R6Inn5ZoA_gCeoJqMwXuHPZO5vZbi7zMhJ20iuo6D5zZlRhrnMtK5C_HL2esbESn2h6E1JD7YXbtQWxs2I7fFPyjBnq0zLAtYwJ4JjZBvc-TVmQMunXu3ieZd5rqnwT_3mBNmUPOPeRAR4l7sOaQCIg7spzDXWf55oFRijNPD9tJcoX76jKlBDr4og2IqT-bqnO-1dnGa6fqiPBURm60BUcCAuCmfmUYj2gSS03dBtVOH9frwpECktFSiAM4WEFtK4x_nq5qSx9e5NNtEfy2W0Gv1v2Kqzr7WYdirrqNggFq7orH3icAE5hhoCjo-x8nauqEHmKcx3_4A7zw",
    "token_type": "Bearer",
    "expires_at": "2022-07-18 16:44:30"
}
```

#### Logout
**- URL:**
```url
GET: http://www.yacoanix.com/api/v1/auth/logout
```

**- Response:**
```json
{
    "message": "Successfully logged out"
}
```

### Users
- Only a user with 'Admin' role will be able to use these routes.

#### List users
**- URL:**
```url
GET: http://www.yacoanix.com/api/v1/users
```
**- Parameters:**
- name: (String, optional) Filter user name.
- email: (String, optional) Filter user email.
- sortBy: (String, optional) You can order by id, name or email.
- sortDesc: (String, optional) If you pass a 'true' string, you can see the list in reverse order.
- page: (Number, optional) If you pass this parameter, the list will be paginated by default at 10 users per page.
- perPage: (Number, optional) Change default value users per page.

**- Response:**
- The 'meta' and 'links' objects only appear if pagination exists.
```json
{
    "data": [
        {
            "id": 1,
            "name": "admin",
            "email": "admin@admin.es",
            "is_admin": true
        },
        {
            "id": 2,
            "name": "Dr. Maia Kertzmann",
            "email": "gerry.homenick@example.net",
            "is_admin": false
        },
        {
            "id": 3,
            "name": "Reina Hilpert",
            "email": "wolf.concepcion@example.org",
            "is_admin": false
        }
    ],
    "links": {
        "first": "http://www.yacoanix.com/api/v1/users?page=1",
        "last": "http://www.yacoanix.com/api/v1/users?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://www.yacoanix.com/api/v1/users?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "http://www.yacoanix.com/api/v1/users",
        "per_page": 10,
        "to": 5,
        "total": 5
    }
}
```

#### Create user
**- URL:**
```url
POST: http://www.yacoanix.com/api/v1/users
```
**- Parameters:**
- name: (String, Required) User name.
- email: (String, Required, unique) User email.
- password: (String, Required) User password.

**- Response:**
```json
{
    "message": "Successfully created user!"
}
```

#### Update user
**- URL:**
```url
PUT/PATCH: http://www.yacoanix.com/api/v1/users/{USER_ID}
```
**- Parameters:**
- name: (String, Optional) New user name.
- email: (String, Optional, unique) New user email.
- password: (String, Optional) New user password.

**- Response:**
```json
{
    "message": "Successfully updated user!"
}
```

#### Delete user
**- URL:**
```url
DELETE: http://www.yacoanix.com/api/v1/users/{USER_ID}
```

**- Response:**
```json
{
    "message": "Successfully deleted user!"
}
```

#### Change admin role

- This route can assign and revoke the 'Admin' role to a user

**- URL:**
```url
POST: http://www.yacoanix.com/api/v1/users/{USER_ID}/change-admin
```

**- Response:**
```json
{
    "message": "Successfully assigned Admin role to user!"
}
```
or

```json
{
    "message": "Successfully revoked Admin role to user!"
}
```

### Customers
- Any user can manage customers.

#### List customers
**- URL:**
```url
GET: http://www.yacoanix.com/api/v1/customers
```
**- Parameters:**
- name: (String, optional) Filter customer name.
- surname: (String, optional) Filter customer surname.
- sortBy: (String, optional) You can order by id, name or email.
- sortDesc: (String, optional) If you pass a 'true' string, you can see the list in reverse order.
- page: (Number, optional) If you pass this parameter, the list will be paginated by default at 10 customers per page.
- perPage: (Number, optional) Change default value customers per page.

**- Response:**
- The 'meta' and 'links' objects only appear if pagination exists.
```json
{
    "data": [
        {
            "id": 1,
            "name": "Otilia Kunze",
            "surname": "Clare Powlowski",
            "photo": null,
            "creator_id": 4,
            "updater_id": null
        },
        {
            "id": 2,
            "name": "Prof. Malcolm Osinski",
            "surname": "Gail Kuphal IV",
            "photo": null,
            "creator_id": 3,
            "updater_id": null
        },
        {
            "id": 3,
            "name": "Prof. Ella Satterfield PhD",
            "surname": "Isabel Koch",
            "photo": null,
            "creator_id": 4,
            "updater_id": null
        },
        {
            "id": 4,
            "name": "Dagmar Koepp",
            "surname": "Gretchen Bins",
            "photo": null,
            "creator_id": 2,
            "updater_id": null
        },
        {
            "id": 5,
            "name": "Norris Heaney",
            "surname": "Kaitlyn Flatley",
            "photo": null,
            "creator_id": 5,
            "updater_id": null
        }
    ],
    "links": {
        "first": "http://www.yacoanix.com/api/v1/customers?page=1",
        "last": "http://www.yacoanix.com/api/v1/customers?page=4",
        "prev": null,
        "next": "http://www.yacoanix.com/api/v1/customers?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 4,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://www.yacoanix.com/api/v1/customers?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": "http://www.yacoanix.com/api/v1/customers?page=2",
                "label": "2",
                "active": false
            },
            {
                "url": "http://www.yacoanix.com/api/v1/customers?page=3",
                "label": "3",
                "active": false
            },
            {
                "url": "http://www.yacoanix.com/api/v1/customers?page=4",
                "label": "4",
                "active": false
            },
            {
                "url": "http://www.yacoanix.com/api/v1/customers?page=2",
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "http://www.yacoanix.com/api/v1/customers",
        "per_page": "5",
        "to": 5,
        "total": 20
    }
}
```

#### Create customer
**- URL:**
```url
POST: http://www.yacoanix.com/api/v1/customers
```
**- Parameters:**
- name: (String, Required) Customer name.
- surname: (String, Required, unique) Customer surname.
- photo: (image, optional, max 500x500) Customer photo.

**- Response:**
```json
{
    "message": "Successfully created customer!"
}
```

#### Update customer
**- URL:**
```url
PUT/PATCH: http://www.yacoanix.com/api/v1/customers/{CUSTOMER_ID}
```
**- Parameters:**
- name: (String, Optional) New customer name.
- surname: (String, Optional) New customer surname.

**- Response:**
```json
{
    "message": "Successfully updated customer!"
}
```

#### Delete customer
**- URL:**
```url
DELETE: http://www.yacoanix.com/api/v1/customers/{CUSTOMER_ID}
```

**- Response:**
```json
{
    "message": "Successfully deleted customer!"
}
```

#### Show customer
**- URL:**
```url
GET: http://www.yacoanix.com/api/v1/customers/{CUSTOMER_ID}
```

**- Response:**
```json
{
    "data": {
        "id": 1,
        "name": "Otilia Kunze",
        "surname": "Clare Powlowski",
        "photo": "http://www.yacoanix.com/storage/customer_photos/qIzD6npZhNthVZ22UKDh9p542jb59kb6Lwdd0W1b.png",
        "creator_id": 4,
        "updater_id": null
    }
}
```



#### Upload customer photo
**- URL:**
```url
POST: http://www.yacoanix.com/api/v1/customers/{CUSTOMER_ID}/upload-photo
```

**- Parameters:**
- photo: (image, required, max 500x500) New customer photo.

**- Response:**
```json
{
    "message": "Successfully uploaded customer photo!"
}
```

#### Delete customer photo
**- URL:**
```url
DELETE: http://www.yacoanix.com/api/v1/customers/{CUSTOMER_ID}/delete-photo
```

**- Response:**
```json
{
    "message": "Successfully deleted customer photo!"
}
```





