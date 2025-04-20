# Real Estate API Guide for Postman

This guide will help you understand how to test and use all the endpoints available in our Real Estate API using Postman.

## Table of Contents

1. [Setup](#setup)
2. [Authentication](#authentication)
3. [Apartments](#apartments)
4. [Comments](#comments)
5. [Favorites](#favorites)
6. [Admin Actions](#admin-actions)

## Setup

1. Download and install [Postman](https://www.postman.com/downloads/)
2. Import the API collection (optional if provided)
3. Set up environment variables for efficient testing:
   - `baseUrl`: `http://127.0.0.1:8000/api`
   - `token`: This will be automatically set after successful login

## Authentication

### Register a New User

- **Request**:
  - Method: `POST`
  - URL: `{{baseUrl}}/register`
  - Body (JSON):
    ```json
    {
        "name": "John Doe",
        "email": "john@example.com",
        "password": "password123",
        "password_confirmation": "password123",
        "role_id": 2,  // 1: Admin, 2: Property Owner, 3: Regular User
        "phone": "1234567890"
    }
    ```
- **Response**: Status 201 Created with user data and token

### Login

- **Request**:
  - Method: `POST`
  - URL: `{{baseUrl}}/login`
  - Body (JSON):
    ```json
    {
        "email": "john@example.com",
        "password": "password123"
    }
    ```
- **Response**: Status 200 OK with user data and token
- **Tip**: Copy the token from the response and set it to your `token` environment variable

### Get User Profile

- **Request**:
  - Method: `GET`
  - URL: `{{baseUrl}}/profile`
  - Headers:
    - `Authorization`: `Bearer {{token}}`
- **Response**: Status 200 OK with user profile data

### Logout

- **Request**:
  - Method: `POST`
  - URL: `{{baseUrl}}/logout`
  - Headers:
    - `Authorization`: `Bearer {{token}}`
- **Response**: Status 200 OK with logout confirmation

## Apartments

### List All Apartments

- **Request**:
  - Method: `GET`
  - URL: `{{baseUrl}}/apartments`
  - Query Parameters (optional):
    - `search`: Search term for apartments
    - `min_price`: Minimum price filter
    - `max_price`: Maximum price filter
    - `location`: Location filter
    - `bedrooms`: Number of bedrooms filter
    - `bathrooms`: Number of bathrooms filter
    - `min_area`: Minimum area filter
    - `max_area`: Maximum area filter
    - `sort_by`: Field to sort by (e.g., 'price', 'created_at')
    - `sort_direction`: 'asc' or 'desc'
    - `page`: Page number for pagination
- **Response**: Status 200 OK with paginated apartment listings

### Get Featured Apartments

- **Request**:
  - Method: `GET`
  - URL: `{{baseUrl}}/featured-apartments`
- **Response**: Status 200 OK with featured apartment listings

### Get Single Apartment

- **Request**:
  - Method: `GET`
  - URL: `{{baseUrl}}/apartments/{apartment_id}`
- **Response**: Status 200 OK with detailed apartment data

### Create Apartment (Property Owner or Admin)

- **Request**:
  - Method: `POST`
  - URL: `{{baseUrl}}/apartments`
  - Headers:
    - `Authorization`: `Bearer {{token}}`
  - Body (Form-data):
    - `title`: "Beautiful Apartment"
    - `description`: "A spacious apartment with great views"
    - `price`: 1500
    - `location`: "New York"
    - `bedrooms`: 2
    - `bathrooms`: 1
    - `area`: 90
    - `images[]`: [File uploads] (multiple files allowed)
- **Response**: Status 201 Created with apartment data

### Update Apartment (Owner or Admin)

- **Request**:
  - Method: `PUT`
  - URL: `{{baseUrl}}/apartments/{apartment_id}`
  - Headers:
    - `Authorization`: `Bearer {{token}}`
  - Body (Form-data):
    - `title`: "Updated Apartment Name"
    - `description`: "Updated description"
    - `price`: 1600
    - `location`: "New York"
    - `bedrooms`: 2
    - `bathrooms`: 1
    - `area`: 90
    - `images[]`: [File uploads] (optional)
- **Response**: Status 200 OK with updated apartment data

### Delete Apartment (Owner or Admin)

- **Request**:
  - Method: `DELETE`
  - URL: `{{baseUrl}}/apartments/{apartment_id}`
  - Headers:
    - `Authorization`: `Bearer {{token}}`
- **Response**: Status 200 OK with deletion confirmation

## Comments

### List Comments for an Apartment

- **Request**:
  - Method: `GET`
  - URL: `{{baseUrl}}/apartments/{apartment_id}/comments`
- **Response**: Status 200 OK with paginated comments

### Get Average Rating for an Apartment

- **Request**:
  - Method: `GET`
  - URL: `{{baseUrl}}/apartments/{apartment_id}/rating`
- **Response**: Status 200 OK with average rating data

### Get Single Comment

- **Request**:
  - Method: `GET`
  - URL: `{{baseUrl}}/apartments/{apartment_id}/comments/{comment_id}`
- **Response**: Status 200 OK with comment data

### Create Comment (Authenticated Users)

- **Request**:
  - Method: `POST`
  - URL: `{{baseUrl}}/apartments/{apartment_id}/comments`
  - Headers:
    - `Authorization`: `Bearer {{token}}`
  - Body (JSON):
    ```json
    {
        "content": "This is a great apartment!",
        "rating": 4
    }
    ```
- **Response**: Status 201 Created with comment data

### Update Comment (Comment Owner)

- **Request**:
  - Method: `PUT`
  - URL: `{{baseUrl}}/apartments/{apartment_id}/comments/{comment_id}`
  - Headers:
    - `Authorization`: `Bearer {{token}}`
  - Body (JSON):
    ```json
    {
        "content": "Updated comment content",
        "rating": 5
    }
    ```
- **Response**: Status 200 OK with updated comment data

### Delete Comment (Comment Owner or Admin)

- **Request**:
  - Method: `DELETE`
  - URL: `{{baseUrl}}/apartments/{apartment_id}/comments/{comment_id}`
  - Headers:
    - `Authorization`: `Bearer {{token}}`
- **Response**: Status 200 OK with deletion confirmation

### Report Comment

- **Request**:
  - Method: `POST`
  - URL: `{{baseUrl}}/apartments/{apartment_id}/comments/{comment_id}/report`
  - Headers:
    - `Authorization`: `Bearer {{token}}`
  - Body (JSON):
    ```json
    {
        "reason": "This comment contains inappropriate content"
    }
    ```
- **Response**: Status 201 Created with report confirmation

## Favorites

### List User's Favorite Apartments

- **Request**:
  - Method: `GET`
  - URL: `{{baseUrl}}/favorites`
  - Headers:
    - `Authorization`: `Bearer {{token}}`
- **Response**: Status 200 OK with paginated favorite apartments

### Add Apartment to Favorites

- **Request**:
  - Method: `POST`
  - URL: `{{baseUrl}}/favorites`
  - Headers:
    - `Authorization`: `Bearer {{token}}`
  - Body (JSON):
    ```json
    {
        "apartment_id": 1
    }
    ```
- **Response**: Status 201 Created with favorite data

### Remove Apartment from Favorites

- **Request**:
  - Method: `DELETE`
  - URL: `{{baseUrl}}/favorites/{apartment_id}`
  - Headers:
    - `Authorization`: `Bearer {{token}}`
- **Response**: Status 200 OK with deletion confirmation

### Check if Apartment is in Favorites

- **Request**:
  - Method: `GET`
  - URL: `{{baseUrl}}/favorites/{apartment_id}/check`
  - Headers:
    - `Authorization`: `Bearer {{token}}`
- **Response**: Status 200 OK with boolean result

### Toggle Favorite Status

- **Request**:
  - Method: `POST`
  - URL: `{{baseUrl}}/favorites/{apartment_id}/toggle`
  - Headers:
    - `Authorization`: `Bearer {{token}}`
- **Response**: Status 200 OK with updated favorite status

## Admin Actions

### Get Pending Comments (Admin Only)

- **Request**:
  - Method: `GET`
  - URL: `{{baseUrl}}/admin/comments/pending`
  - Headers:
    - `Authorization`: `Bearer {{token}}`
- **Response**: Status 200 OK with pending comments data

### Approve Comment (Admin Only)

- **Request**:
  - Method: `PUT`
  - URL: `{{baseUrl}}/admin/comments/{comment_id}/approve`
  - Headers:
    - `Authorization`: `Bearer {{token}}`
- **Response**: Status 200 OK with approved comment data

### List Comment Reports (Admin Only)

- **Request**:
  - Method: `GET`
  - URL: `{{baseUrl}}/admin/reports`
  - Headers:
    - `Authorization`: `Bearer {{token}}`
  - Query Parameters (optional):
    - `status`: Filter by status ('pending', 'resolved', 'rejected')
- **Response**: Status 200 OK with comment reports data

### Resolve Comment Report (Admin Only)

- **Request**:
  - Method: `PUT`
  - URL: `{{baseUrl}}/admin/reports/{report_id}/resolve`
  - Headers:
    - `Authorization`: `Bearer {{token}}`
  - Body (JSON):
    ```json
    {
        "action": "approve", // Options: "approve", "reject", "delete"
        "resolution_notes": "Comment reviewed and approved"
    }
    ```
- **Response**: Status 200 OK with resolved report data

## Testing Flow Examples

### Property Owner Flow

1. Register as a property owner (role_id: 2)
2. Login to get authentication token
3. Create a new apartment listing
4. View your created apartment
5. Update apartment details
6. Check for and respond to comments on your apartment
7. Delete your apartment if needed

### Regular User Flow

1. Register as a regular user (role_id: 3)
2. Login to get authentication token
3. Browse available apartments
4. View apartment details
5. Add apartments to favorites
6. Leave comments and ratings on apartments
7. Check your favorite apartments list
8. Update or delete your own comments

### Admin Flow

1. Register as an admin (role_id: 1) or use a pre-created admin account
2. Login to get authentication token
3. Manage all apartments (view, create, update, delete)
4. Moderate comments (view pending comments, approve comments)
5. Handle reported comments (view reports, resolve reports)
6. Manage all aspects of the platform

## Notes

- Remember to replace `{apartment_id}`, `{comment_id}`, and `{report_id}` with actual IDs in your requests
- All authenticated endpoints require a valid token in the Authorization header
- Different roles have different permissions - refer to the ROLE_BASED_ACTIONS.md document for details

## API Base URL

All API requests are made to:

```
https://mughtarib.abaadre.com/public/api
``` 