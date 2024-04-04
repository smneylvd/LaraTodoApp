### Instructions:

1. make sure that you have empty databases called `laravel`, `testing` or create them
2. install `composer` and run `composer install`
3. after all packages installed you can run by `php artisan serve`
4. your api will be available by address `http://localhost:8000`

#### You can run Unit tests by  `php artisan test`
### Below written the documentation for API itself
make sure to add `http://localhost:8000` as prefix for all routes



### Register a New User

- **Endpoint:** `/auth/register`
- **Method:** `POST`
- **Request Body:**
    - `email` (required): The email address of the user.
    - `name` (required): The name of the user.
    - `password` (required): The password for the user account.
    - `repassword` (required): Confirmation of the password.

- **Success Response:**
    - **Status Code:** 200
    - **Content:**
      ```json
      {
        "access_token": "5|TRdAALsNM7QXdhmyZv7i60HqbuZ0GFK0SI6psw5h",
        "token_type": "bearer"
      }
      ```

- **Error Responses:**
    - **Status Code:** 400
    - **Content:** JSON object containing details about the validation errors.

### Login

- **Endpoint:** `/auth/login`
- **Method:** `POST`
- **Request Body:**
    - `email` (required): The email address of the user.
    - `password` (required): The password for the user account.

- **Success Response:**
    - **Status Code:** 200
    - **Content:**
      ```json
      {
        "access_token": "5|TRdAALsNM7QXdhmyZv7i60HqbuZ0GFK0SI6psw5h",
        "token_type": "bearer"
      }
      ```

- **Error Responses:**
    - **Status Code:** 401
    - **Content:** JSON object indicating incorrect credentials.

### Logout

- **Endpoint:** `/auth/logout`
- **Method:** `GET`

- **Success Response:**
    - **Status Code:** 200
    - **Content:** JSON object containing a success message indicating successful logout.

- **Error Responses:**
    - **Status Code:** 401
    - **Content:** JSON object indicating unauthorized access.

### User Profile

- **Endpoint:** `/auth/profile`
- **Method:** `GET`

- **Success Response:**
    - **Status Code:** 200
    - **Content:** JSON object containing the user profile details.
      ```json
      {
        "id": 1,
        "name": "admin",
        "email": "nurs@gmail.com",
        "email_verified_at": null,
        "api_token": null,
        "created_at": "2024-04-04T10:29:02.000000Z",
        "updated_at": "2024-04-04T10:29:02.000000Z",
        "deleted_at": null
      }
      ```

- **Error Responses:**
    - **Status Code:** 401
    - **Content:** JSON object indicating unauthorized access.

---

### Get All Statuses

- **Endpoint:** `/status`
- **Method:** `GET`

- **Success Response:**
    - **Status Code:** 200
    - **Content:** JSON array containing all status records.
      ```json
      [
        {
          "id": 1,
          "title": "undone",
          "slug": "undone",
          "created_at": "2024-04-04T10:29:33.000000Z",
          "updated_at": "2024-04-04T10:29:33.000000Z",
          "deleted_at": null
        },
        {
          "id": 2,
          "title": "task 1",
          "slug": "done",
          "created_at": "2024-04-04T11:24:41.000000Z",
          "updated_at": "2024-04-04T11:24:41.000000Z",
          "deleted_at": null
        }
      ]
      ```

- **Error Responses:**
    - **Status Code:** 401
    - **Content:** JSON object indicating unauthorized access.

---

### Get a Specific Status

- **Endpoint:** `/status/{id}`
- **Method:** `GET`
- **Path Parameters:**
    - `id`: The ID of the status.

- **Success Response:**
    - **Status Code:** 200
    - **Content:** JSON object containing the status details.

- **Error Responses:**
    - **Status Code:** 401
    - **Content:** JSON object indicating unauthorized access.
    - **Status Code:** 404
    - **Content:** JSON object indicating that the status with the given ID was not found.

---

### Create a New Status

- **Endpoint:** `/status/store`
- **Method:** `POST`
- **Request Body:**
    - `title` (required): The title of the status.
    - `slug` (required): The slug for the status, must be unique.

- **Success Response:**
    - **Status Code:** 200
    - **Content:** JSON object containing the newly created status details.
      ```json
      {
        "title": "task 1",
        "slug": "done",
        "created_at": "2024-04-04T11:24:41.000000Z",
        "updated_at": "2024-04-04T11:24:41.000000Z",
        "id": 2
      }
      ```

- **Error Responses:**
    - **Status Code:** 400
    - **Content:** JSON object containing details about the validation errors.

---

### Update a Status

- **Endpoint:** `/status/{id}`
- **Method:** `POST`
- **Path Parameters:**
    - `id`: The ID of the status to be updated.
- **Request Body:**
    - `title` (required): The new title of the status.
    - `slug` (required): The new slug for the status, must be unique.

- **Success Response:**
    - **Status Code:** 200
    - **Content:** JSON object containing the updated status details.
      ```json
      {
        "title": "task 1",
        "slug": "done",
        "created_at": "2024-04-04T11:24:41.000000Z",
        "updated_at": "2024-04-04T11:24:41.000000Z",
        "id": 2
      }
      ```

- **Error Responses:**
    - **Status Code:** 400
    - **Content:** JSON object containing details about the validation errors.
    - **Status Code:** 401
    - **Content:** JSON object indicating unauthorized access.
    - **Status Code:** 404
    - **Content:** JSON object indicating that the status with the given ID was not found.

---

### Delete a Status

- **Endpoint:** `/status/{id}`
- **Method:** `DELETE`
- **Path Parameters:**
    - `id`: The ID of the status to be deleted.

- **Success Response:**
    - **Status Code:** 200
    - **Content:** JSON object indicating successful deletion.

- **Error Responses:**
    - **Status Code:** 401
    - **Content:** JSON object indicating unauthorized access.
    - **Status Code:** 404
    - **Content:** JSON object indicating that the status with the given ID was not found.

---

### Get All Tasks

- **Endpoint:** `/tasks`
- **Method:** `GET`
- **Query Parameters:**
    - `order_by`: Field to order tasks by (optional, default: `id`). Allowed
      values: `id`, `title`, `description`, `attachments`, `user_id`, `status_id`, `created_at`, `updated_at`.
    - `order_by_direction`: Order direction (optional, default: `asc`). Allowed values: `asc`, `desc`.
    - `per_page`: Number of tasks per page (optional, default: `12`).

- **Success Response:**
    - **Status Code:** 200
    - **Content:** JSON object containing paginated tasks list, total number of tasks, current page, and total pages.
      ```json
      {
        "items": [
          {
            "id": 2,
            "title": "task 1",
            "description": "undone",
            "attachments": null,
            "deadline": null,
            "user_id": 1,
            "status_id": 1,
            "created_at": "2024-04-04T10:42:37.000000Z",
            "updated_at": "2024-04-04T10:42:37.000000Z",
            "deleted_at": null,
            "user": {
              "id": 1,
              "name": "admin",
              "email": "nurs@gmail.com",
              "email_verified_at": null,
              "api_token": null,
              "created_at": "2024-04-04T10:29:02.000000Z",
              "updated_at": "2024-04-04T10:29:02.000000Z",
              "deleted_at": null
            },
            "status": {
              "id": 1,
              "title": "undone",
              "slug": "undone",
              "created_at": "2024-04-04T10:29:33.000000Z",
              "updated_at": "2024-04-04T10:29:33.000000Z",
              "deleted_at": null
            }
          },
          {
            "id": 3,
            "title": "task 1",
            "description": "undone",
            "attachments": null,
            "deadline": null,
            "user_id": 1,
            "status_id": 1,
            "created_at": "2024-04-04T10:42:45.000000Z",
            "updated_at": "2024-04-04T10:42:45.000000Z",
            "deleted_at": null,
            "user": {
              "id": 1,
              "name": "admin",
              "email": "nurs@gmail.com",
              "email_verified_at": null,
              "api_token": null,
              "created_at": "2024-04-04T10:29:02.000000Z",
              "updated_at": "2024-04-04T10:29:02.000000Z",
              "deleted_at": null
            },
            "status": {
              "id": 1,
              "title": "undone",
              "slug": "undone",
              "created_at": "2024-04-04T10:29:33.000000Z",
              "updated_at": "2024-04-04T10:29:33.000000Z",
              "deleted_at": null
            }
          }
        ],
        "total": 13,
        "current_page": 1,
        "total_pages": 7
      }
      ```

- **Error Responses:**
    - **Status Code:** 400
    - **Content:** JSON object indicating validation error details.

---

### Get a Specific Task

- **Endpoint:** `/tasks/{id}`
- **Method:** `GET`
- **Path Parameters:**
    - `id`: The ID of the task.

- **Success Response:**
    - **Status Code:** 200
    - **Content:** JSON object containing the task details.

- **Error Responses:**
    - **Status Code:** 404
    - **Content:** JSON object indicating that the task with the given ID was not found.

---

### Create a New Task

- **Endpoint:** `/tasks/store`
- **Method:** `POST`
- **Request Body:**
    - `title` (required): The title of the task.
    - `description` (required): The description of the task.
    - `status_id` (optional): The ID of the status for the task.

- **Success Response:**
    - **Status Code:** 200
    - **Content:** JSON object containing the newly created task details.
      ```json
      {
        "title": "task 1",
        "description": "undone",
        "status_id": 1,
        "user_id": 1,
        "created_at": "2024-04-04T10:42:53.000000Z",
        "deadline": null,
        "updated_at": "2024-04-04T10:42:53.000000Z",
        "id": 14
      }
      ```

- **Error Responses:**
    - **Status Code:** 400
    - **Content:** JSON object indicating details about the validation errors.

---

### Update a Task

- **Endpoint:** `/tasks/{id}`
- **Method:** `POST`
- **Path Parameters:**
    - `id`: The ID of the task to be updated.
- **Request Body:**
    - `title` (required): The new title of the task.
    - `description` (required): The new description of the task.
    - `status_id` (optional): The new status ID for the task.

- **Success Response:**
    - **Status Code:** 200
    - **Content:** JSON object containing the updated task details.
      ```json
      {
        "title": "task 1",
        "description": "undone",
        "status_id": 1,
        "user_id": 1,
        "created_at": "2024-04-04T10:42:53.000000Z",
        "deadline": null,
        "updated_at": "2024-04-04T10:42:53.000000Z",
        "id": 14
      }
      ```

- **Error Responses:**
    - **Status Code:** 400
    - **Content:** JSON object indicating details about the validation errors.
    - **Status Code:** 404
    - **Content:** JSON object indicating that the task with the given ID was not found.

---

### Delete a Task

- **Endpoint:** `/tasks/{id}`
- **Method:** `DELETE`
- **Path Parameters:**
    - `id`: The ID of the task to be deleted.

- **Success Response:**
    - **Status Code:** 200
    - **Content:** JSON object indicating successful deletion.

- **Error Responses:**
    - **Status Code:** 404
    - **Content:** JSON object indicating that the task with the given ID was not found.
