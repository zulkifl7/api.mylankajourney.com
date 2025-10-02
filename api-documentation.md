# API Documentation

This document provides a detailed description of the API endpoints for the My Lanka Journey application.

## Locations

### Get all locations

* **URL:** `/api/locations`
* **Method:** `GET`
* **Description:** Retrieves a list of all locations.
* **Success Response:**
  * **Code:** 200
  * **Content:** `[{"id":1,"name":"Location 1","description":"Description 1","created_at":"2024-01-01T00:00:00.000000Z","updated_at":"2024-01-01T00:00:00.000000Z"}]`

### Get a single location

* **URL:** `/api/locations/{id}`
* **Method:** `GET`
* **URL Params:** `id=[integer]` (required) - The ID of the location.
* **Success Response:**
  * **Code:** 200
  * **Content:** `{"id":1,"name":"Location 1","description":"Description 1","created_at":"2024-01-01T00:00:00.000000Z","updated_at":"2024-01-01T00:00:00.000000Z"}`
* **Error Response:**
  * **Code:** 404 Not Found

### Create a new location

* **URL:** `/api/locations`
* **Method:** `POST`
* **Data Params:**
  * `name=[string]` (required) - The name of the location.
  * `description=[string]` (required) - The description of the location.
* **Success Response:**
  * **Code:** 201 Created
  * **Content:** `{"id":1,"name":"Location 1","description":"Description 1","created_at":"2024-01-01T00:00:00.000000Z","updated_at":"2024-01-01T00:00:00.000000Z"}`
* **Error Response:**
  * **Code:** 422 Unprocessable Entity

### Update a location

* **URL:** `/api/locations/{id}`
* **Method:** `PUT` / `PATCH`
* **URL Params:** `id=[integer]` (required) - The ID of the location.
* **Data Params:**
  * `name=[string]` (optional) - The name of the location.
  * `description=[string]` (optional) - The description of the location.
* **Success Response:**
  * **Code:** 200 OK
  * **Content:** `{"id":1,"name":"Updated Location","description":"Updated Description","created_at":"2024-01-01T00:00:00.000000Z","updated_at":"2024-01-01T00:00:00.000000Z"}`
* **Error Response:**
  * **Code:** 404 Not Found
  * **Code:** 422 Unprocessable Entity

### Delete a location

* **URL:** `/api/locations/{id}`
* **Method:** `DELETE`
* **URL Params:** `id=[integer]` (required) - The ID of the location.
* **Success Response:**
  * **Code:** 204 No Content
* **Error Response:**
  * **Code:** 404 Not Found

## Activities

### Get all activities

* **URL:** `/api/activities`
* **Method:** `GET`
* **Description:** Retrieves a list of all activities.
* **Success Response:**
  * **Code:** 200
  * **Content:** `[{"id":1,"name":"Activity 1","description":"Description 1","image":"image.jpg","location_id":1,"created_at":"2024-01-01T00:00:00.000000Z","updated_at":"2024-01-01T00:00:00.000000Z"}]`

### Get a single activity

* **URL:** `/api/activities/{id}`
* **Method:** `GET`
* **URL Params:** `id=[integer]` (required) - The ID of the activity.
* **Success Response:**
  * **Code:** 200
  * **Content:** `{"id":1,"name":"Activity 1","description":"Description 1","image":"image.jpg","location_id":1,"created_at":"2024-01-01T00:00:00.000000Z","updated_at":"2024-01-01T00:00:00.000000Z"}`
* **Error Response:**
  * **Code:** 404 Not Found

### Create a new activity

* **URL:** `/api/activities`
* **Method:** `POST`
* **Data Params:**
  * `name=[string]` (required) - The name of the activity.
  * `description=[string]` (required) - The description of the activity.
  * `image=[string]` (required) - The image URL of the activity.
  * `location_id=[integer]` (required) - The ID of the location for the activity.
  * `activity_category_ids=[array]` (required) - An array of activity category IDs.
* **Success Response:**
  * **Code:** 201 Created
  * **Content:** `{"id":1,"name":"Activity 1","description":"Description 1","image":"image.jpg","location_id":1,"created_at":"2024-01-01T00:00:00.000000Z","updated_at":"2024-01-01T00:00:00.000000Z"}`
* **Error Response:**
  * **Code:** 422 Unprocessable Entity

### Update an activity

* **URL:** `/api/activities/{id}`
* **Method:** `PUT` / `PATCH`
* **URL Params:** `id=[integer]` (required) - The ID of the activity.
* **Data Params:**
  * `name=[string]` (optional) - The name of the activity.
  * `description=[string]` (optional) - The description of the activity.
  * `image=[string]` (optional) - The image URL of the activity.
  * `location_id=[integer]` (optional) - The ID of the location for the activity.
  * `activity_category_ids=[array]` (optional) - An array of activity category IDs.
* **Success Response:**
  * **Code:** 200 OK
  * **Content:** `{"id":1,"name":"Updated Activity","description":"Updated Description","image":"updated.jpg","location_id":1,"created_at":"2024-01-01T00:00:00.000000Z","updated_at":"2024-01-01T00:00:00.000000Z"}`
* **Error Response:**
  * **Code:** 404 Not Found
  * **Code:** 422 Unprocessable Entity

### Delete an activity

* **URL:** `/api/activities/{id}`
* **Method:** `DELETE`
* **URL Params:** `id=[integer]` (required) - The ID of the activity.
* **Success Response:**
  * **Code:** 204 No Content
* **Error Response:**
  * **Code:** 404 Not Found

## Activity Categories

### Get all activity categories

* **URL:** `/api/activity-categories`
* **Method:** `GET`
* **Description:** Retrieves a list of all activity categories.
* **Success Response:**
  * **Code:** 200
  * **Content:** `[{"id":1,"name":"Category 1","slug":"category-1","created_at":"2024-01-01T00:00:00.000000Z","updated_at":"2024-01-01T00:00:00.000000Z"}]`

### Get a single activity category

* **URL:** `/api/activity-categories/{id}`
* **Method:** `GET`
* **URL Params:** `id=[integer]` (required) - The ID of the activity category.
* **Success Response:**
  * **Code:** 200
  * **Content:** `{"id":1,"name":"Category 1","slug":"category-1","created_at":"2024-01-01T00:00:00.000000Z","updated_at":"2024-01-01T00:00:00.000000Z"}`
* **Error Response:**
  * **Code:** 404 Not Found

### Create a new activity category

* **URL:** `/api/activity-categories`
* **Method:** `POST`
* **Data Params:**
  * `name=[string]` (required) - The name of the activity category.
  * `slug=[string]` (required) - The slug of the activity category.
* **Success Response:**
  * **Code:** 201 Created
  * **Content:** `{"id":1,"name":"Category 1","slug":"category-1","created_at":"2024-01-01T00:00:00.000000Z","updated_at":"2024-01-01T00:00:00.000000Z"}`
* **Error Response:**
  * **Code:** 422 Unprocessable Entity

### Update an activity category

* **URL:** `/api/activity-categories/{id}`
* **Method:** `PUT` / `PATCH`
* **URL Params:** `id=[integer]` (required) - The ID of the activity category.
* **Data Params:**
  * `name=[string]` (optional) - The name of the activity category.
  * `slug=[string]` (optional) - The slug of the activity category.
* **Success Response:**
  * **Code:** 200 OK
  * **Content:** `{"id":1,"name":"Updated Category","slug":"updated-category","created_at":"2024-01-01T00:00:00.000000Z","updated_at":"2024-01-01T00:00:00.000000Z"}`
* **Error Response:**
  * **Code:** 404 Not Found
  * **Code:** 422 Unprocessable Entity

### Delete an activity category

* **URL:** `/api/activity-categories/{id}`
* **Method:** `DELETE`
* **URL Params:** `id=[integer]` (required) - The ID of the activity category.
* **Success Response:**
  * **Code:** 204 No Content
* **Error Response:**
  * **Code:** 404 Not Found

## Trip Plans

### Get all trip plans

* **URL:** `/api/trip-plans`
* **Method:** `GET`
* **Description:** Retrieves a list of all trip plans.
* **Success Response:**
  * **Code:** 200
  * **Content:** `[{"id":1,"name":"John Doe","email":"john.doe@example.com","phone":"1234567890","country":"USA","no_of_adults":2,"no_of_children":1,"start_date":"2024-12-01","end_date":"2024-12-10","message":"Looking for a great trip!","activities":[1,2],"created_at":"2024-01-01T00:00:00.000000Z","updated_at":"2024-01-01T00:00:00.000000Z"}]`

### Get a single trip plan

* **URL:** `/api/trip-plans/{id}`
* **Method:** `GET`
* **URL Params:** `id=[integer]` (required) - The ID of the trip plan.
* **Success Response:**
  * **Code:** 200
  * **Content:** `{"id":1,"name":"John Doe","email":"john.doe@example.com","phone":"1234567890","country":"USA","no_of_adults":2,"no_of_children":1,"start_date":"2024-12-01","end_date":"2024-12-10","message":"Looking for a great trip!","activities":[1,2],"created_at":"2024-01-01T00:00:00.000000Z","updated_at":"2024-01-01T00:00:00.000000Z"}`
* **Error Response:**
  * **Code:** 404 Not Found

### Create a new trip plan

* **URL:** `/api/trip-plans`
* **Method:** `POST`
* **Data Params:**
  * `name=[string]` (required) - The name of the user.
  * `email=[string]` (required) - The email of the user.
  * `phone=[string]` (required) - The phone number of the user.
  * `country=[string]` (required) - The country of the user.
  * `no_of_adults=[integer]` (required) - The number of adults.
  * `no_of_children=[integer]` (required) - The number of children.
  * `start_date=[date]` (required) - The start date of the trip.
  * `end_date=[date]` (required) - The end date of the trip.
  * `message=[string]` (optional) - A message from the user.
  * `activities=[array]` (required) - An array of activity IDs.
* **Success Response:**
  * **Code:** 201 Created
  * **Content:** `{"id":1,"name":"John Doe","email":"john.doe@example.com","phone":"1234567890","country":"USA","no_of_adults":2,"no_of_children":1,"start_date":"2024-12-01","end_date":"2024-12-10","message":"Looking for a great trip!","activities":[1,2],"created_at":"2024-01-01T00:00:00.000000Z","updated_at":"2024-01-01T00:00:00.000000Z"}`
* **Error Response:**
  * **Code:** 422 Unprocessable Entity

### Update a trip plan

* **URL:** `/api/trip-plans/{id}`
* **Method:** `PUT` / `PATCH`
* **URL Params:** `id=[integer]` (required) - The ID of the trip plan.
* **Data Params:**
  * `name=[string]` (optional) - The name of the user.
  * `email=[string]` (optional) - The email of the user.
  * `phone=[string]` (optional) - The phone number of the user.
  * `country=[string]` (optional) - The country of the user.
  * `no_of_adults=[integer]` (optional) - The number of adults.
  * `no_of_children=[integer]` (optional) - The number of children.
  * `start_date=[date]` (optional) - The start date of the trip.
  * `end_date=[date]` (optional) - The end date of the trip.
  * `message=[string]` (optional) - A message from the user.
  * `activities=[array]` (optional) - An array of activity IDs.
* **Success Response:**
  * **Code:** 200 OK
  * **Content:** `{"id":1,"name":"Updated John Doe","email":"john.doe.updated@example.com","phone":"0987654321","country":"Canada","no_of_adults":3,"no_of_children":2,"start_date":"2025-01-01","end_date":"2025-01-10","message":"Updated trip plans!","activities":[3,4],"created_at":"2024-01-01T00:00:00.000000Z","updated_at":"2024-01-01T00:00:00.000000Z"}`
* **Error Response:**
  * **Code:** 404 Not Found
  * **Code:** 422 Unprocessable Entity

### Delete a trip plan

* **URL:** `/api/trip-plans/{id}`
* **Method:** `DELETE`
* **URL Params:** `id=[integer]` (required) - The ID of the trip plan.
* **Success Response:**
  * **Code:** 204 No Content
* **Error Response:**
  * **Code:** 404 Not Found

## Subscriptions

### Get all subscriptions

* **URL:** `/api/subscriptions`
* **Method:** `GET`
* **Description:** Retrieves a list of all subscriptions.
* **Success Response:**
  * **Code:** 200
  * **Content:** `[{"id":1,"email":"subscriber@example.com","created_at":"2024-01-01T00:00:00.000000Z","updated_at":"2024-01-01T00:00:00.000000Z"}]`

### Get a single subscription

* **URL:** `/api/subscriptions/{id}`
* **Method:** `GET`
* **URL Params:** `id=[integer]` (required) - The ID of the subscription.
* **Success Response:**
  * **Code:** 200
  * **Content:** `{"id":1,"email":"subscriber@example.com","created_at":"2024-01-01T00:00:00.000000Z","updated_at":"2024-01-01T00:00:00.000000Z"}`
* **Error Response:**
  * **Code:** 404 Not Found

### Create a new subscription

* **URL:** `/api/subscriptions`
* **Method:** `POST`
* **Data Params:**
  * `email=[string]` (required) - The email for the subscription.
* **Success Response:**
  * **Code:** 201 Created
  * **Content:** `{"id":1,"email":"subscriber@example.com","created_at":"2024-01-01T00:00:00.000000Z","updated_at":"2024-01-01T00:00:00.000000Z"}`
* **Error Response:**
  * **Code:** 422 Unprocessable Entity

### Update a subscription

* **URL:** `/api/subscriptions/{id}`
* **Method:** `PUT` / `PATCH`
* **URL Params:** `id=[integer]` (required) - The ID of the subscription.
* **Data Params:**
  * `email=[string]` (optional) - The email for the subscription.
* **Success Response:**
  * **Code:** 200 OK
  * **Content:** `{"id":1,"email":"updated.subscriber@example.com","created_at":"2024-01-01T00:00:00.000000Z","updated_at":"2024-01-01T00:00:00.000000Z"}`
* **Error Response:**
  * **Code:** 404 Not Found
  * **Code:** 422 Unprocessable Entity

### Delete a subscription

* **URL:** `/api/subscriptions/{id}`
* **Method:** `DELETE`
* **URL Params:** `id=[integer]` (required) - The ID of the subscription.
* **Success Response:**
  * **Code:** 204 No Content
* **Error Response:**
  * **Code:** 404 Not Found