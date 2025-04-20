# Comprehensive Real Estate API Guide

This guide provides detailed instructions for setting up and using the Real Estate API, including specific actions for different user roles, step-by-step Postman instructions, and technical details about the implementation.

## Table of Contents
- [Setup and Installation](#setup-and-installation)
- [API Overview](#api-overview)
- [User Role-Based Actions](#user-role-based-actions)
- [Step-by-Step Postman Guide](#step-by-step-postman-guide)
- [Database Structure](#database-structure)
- [File Storage Configuration](#file-storage-configuration)
- [API Routes Reference](#api-routes-reference)
- [Authentication System](#authentication-system)
- [Common Errors and Solutions](#common-errors-and-solutions)

## Setup and Installation

### Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL database
- Node.js and NPM (for frontend if applicable)

### Installation Steps
1. Clone the repository
2. Navigate to the project directory: `cd app`
3. Install dependencies: `composer install`
4. Copy `.env.example` to `.env` and configure database settings
5. Generate application key: `php artisan key:generate`
6. Run migrations: `php artisan migrate`
7. Create symbolic link for storage: `php artisan storage:link`
8. Start the server: `php artisan serve`

The API will be available at `http://127.0.0.1:8000/api`

## API Overview

The Real Estate API provides endpoints for managing apartments, user accounts, comments, favorites, and admin functionalities. The API uses token-based authentication with Laravel Sanctum.

### Base URL
```
http://127.0.0.1:8000/api
```

### Authentication
All protected endpoints require a Bearer token in the Authorization header:
```
Authorization: Bearer {your_token}
```

## User Role-Based Actions

### Regular Users (role_id: 1)
Regular users can:
1. **Register and manage account**
   - Register a new account
   - Login/logout
   - View profile information
   
2. **Browse apartments**
   - View all apartments
   - Search apartments with filters
   - View featured apartments
   - View apartment details
   
3. **Manage comments**
   - Add comments and ratings to apartments
   - Edit their own comments
   - Delete their own comments
   - Report inappropriate comments
   
4. **Manage favorites**
   - Add apartments to favorites
   - Remove apartments from favorites
   - View all favorite apartments
   - Check if an apartment is in favorites

### Owners (role_id: 2)
Owners have all regular user permissions, plus:
1. **Create and manage apartments**
   - Create new apartment listings
   - Upload apartment images
   - Edit their own apartments
   - Delete their own apartments
   
2. **Manage apartment-related content**
   - View comments on their apartments
   - Respond to comments (via regular comment system)

### Administrators (role_id: 3)
Administrators have all permissions, plus:
1. **User management**
   - View user information (via API)
   
2. **Comment moderation**
   - View pending comments
   - Approve or reject comments
   - View reported comments
   - Resolve comment reports (approve, reject, or delete)
   
3. **Content management**
   - Manage any apartment (edit, delete)
   - Manage any comment (edit, delete)

## Step-by-Step Postman Guide

### Setting Up Postman

1. **Import the Postman Collection**
   - Open Postman
   - Click "Import" button in the top left
   - Select the file `real-estate-api.postman_collection.json`

2. **Set Up Environment**
   - Click "Environments" in the sidebar
   - Click "Import" and select `real-estate-api.postman_environment.json`
   - Or create a new environment with variable `base_url` set to `http://127.0.0.1:8000/api`
   - Make sure the environment is selected in the dropdown (top right)

### Authentication Flow

#### Register a New User

1. Open the "Authentication" folder in the collection
2. Select the "Register" request
3. In the Body tab, modify the JSON data as needed:
   ```json
   {
     "name": "John Doe",
     "email": "john@example.com",
     "password": "password123",
     "password_confirmation": "password123",
     "role_id": 2,
     "phone": "1234567890"
   }
   ```
   - For role_id: 1 = Regular User, 2 = Owner, 3 = Admin
4. Click "Send"
5. You should receive a 201 Created response with user data and token

#### Login

1. Select the "Login" request
2. In the Body tab, enter your credentials:
   ```json
   {
     "email": "john@example.com",
     "password": "password123"
   }
   ```
3. Click "Send"
4. The token will be automatically saved to the `authToken` environment variable

#### Get User Profile

1. Select the "Get Profile" request
2. Click "Send"
3. You should see your user profile information

### Apartment Management Flow

#### Create an Apartment (Owner or Admin)

1. Open the "Apartments" folder
2. Select the "Create Apartment" request
3. In the Body tab (form-data):
   - Fill in all required fields: title, description, price, location, bedrooms, bathrooms, area
   - Optionally add images using the "images[]" field
4. Click "Send"
5. Note the apartment ID in the response for future requests

#### List All Apartments

1. Select the "List Apartments" request
2. Optionally add query parameters:
   - page: Page number for pagination
   - sort: Field to sort by (price, created_at, etc.)
   - order: Sort direction (asc or desc)
3. Click "Send"

#### Get Apartment Details

1. Select the "Get Apartment" request
2. Change the URL to include the apartment ID: `/apartments/{id}`
3. Click "Send"

#### Update an Apartment (Owner or Admin)

1. Select the "Update Apartment" request
2. Update the URL with the correct apartment ID
3. Modify fields in the form-data body
4. Click "Send"

#### Delete an Apartment (Owner or Admin)

1. Select the "Delete Apartment" request
2. Update the URL with the correct apartment ID
3. Click "Send"

### Comment Management Flow

#### Add a Comment to an Apartment

1. Open the "Comments" folder
2. Select the "Create Comment" request
3. Update the URL with the correct apartment ID: `/apartments/{id}/comments`
4. In the Body tab, modify the JSON:
   ```json
   {
     "content": "Great apartment with amazing views!",
     "rating": 5
   }
   ```
5. Click "Send"
6. Note the comment ID in the response

#### List Comments for an Apartment

1. Select the "List Comments" request
2. Update the URL with the correct apartment ID
3. Click "Send"

#### Update a Comment

1. Select the "Update Comment" request
2. Update the URL with the correct apartment and comment IDs
3. Modify the JSON body
4. Click "Send"

#### Report a Comment

1. Select the "Report Comment" request
2. Update the URL with the correct apartment and comment IDs
3. Provide a reason in the JSON body:
   ```json
   {
     "reason": "Inappropriate content"
   }
   ```
4. Click "Send"

### Admin Actions

#### View Pending Comments

1. Log in as an admin user
2. Open the "Admin" folder
3. Select the "Pending Comments" request
4. Click "Send"

#### Approve a Comment

1. Select the "Approve Comment" request
2. Update the URL with the correct comment ID
3. Click "Send"

#### View Comment Reports

1. Select the "Comment Reports" request
2. Optionally filter by status with query parameter: `?status=pending`
3. Click "Send"

#### Resolve a Comment Report

1. Select the "Resolve Report" request
2. Update the URL with the correct report ID
3. In the JSON body, specify the resolution:
   ```json
   {
     "resolution_notes": "Comment removed due to violation of terms",
     "action": "delete"
   }
   ```
   - Possible actions: "approve", "reject", "delete"
4. Click "Send"

### Favorites Management Flow

#### Add an Apartment to Favorites

1. Open the "Favorites" folder
2. Select the "Add to Favorites" request
3. Update the URL with the correct apartment ID
4. Click "Send"

#### List Favorite Apartments

1. Select the "List Favorites" request
2. Click "Send"

#### Remove from Favorites

1. Select the "Remove from Favorites" request
2. Update the URL with the correct apartment ID
3. Click "Send"

## Database Structure

The application uses several key tables:

1. **users** - User accounts
2. **apartments** - Property listings
3. **apartment_images** - Images associated with apartments
4. **comments** - User reviews and ratings
5. **favorites** - User's favorite apartments
6. **comment_reports** - Reports of inappropriate comments

## File Storage Configuration

The application uses local storage for apartment images:

1. Images are stored in: `storage/app/public/apartments`
2. The public symbolic link ensures they're accessible at: `http://127.0.0.1:8000/storage/apartments/filename.jpg`

## API Routes Reference

### Authentication Routes
- `POST /register` - Register a new user
- `POST /login` - User login
- `GET /profile` - Get current user profile
- `POST /logout` - User logout

### Apartment Routes
- `GET /apartments` - List all apartments
- `POST /apartments` - Create a new apartment
- `GET /apartments/{id}` - Get apartment details
- `PUT /apartments/{id}` - Update an apartment
- `DELETE /apartments/{id}` - Delete an apartment
- `GET /apartments/search` - Search apartments
- `GET /apartments/featured` - Get featured apartments

### Comment Routes
- `GET /apartments/{id}/comments` - List comments for an apartment
- `POST /apartments/{id}/comments` - Add a comment
- `PUT /apartments/{id}/comments/{commentId}` - Update a comment
- `DELETE /apartments/{id}/comments/{commentId}` - Delete a comment
- `GET /apartments/{id}/rating` - Get average rating
- `POST /apartments/{id}/comments/{commentId}/report` - Report a comment

### Admin Routes
- `GET /admin/comments/pending` - List pending comments
- `PUT /admin/comments/{id}/approve` - Approve a comment
- `GET /admin/comments/reports` - List comment reports
- `PUT /admin/comments/reports/{id}/resolve` - Resolve a comment report

### Favorites Routes
- `POST /apartments/{id}/favorite` - Add to favorites
- `GET /favorites` - List favorites
- `DELETE /apartments/{id}/favorite` - Remove from favorites
- `GET /apartments/{id}/favorite/check` - Check favorite status

## Authentication System

The API uses Laravel Sanctum for token-based authentication:

1. When a user registers or logs in, a token is issued
2. This token must be included in the Authorization header
3. Tokens have an expiration time (default: 1 hour)
4. The token provides access to protected routes based on user role

## Common Errors and Solutions

### 401 Unauthorized
- Make sure you're including the correct token in the Authorization header
- Your token may have expired; try logging in again

### 403 Forbidden
- You're trying to access a resource that requires higher permissions
- Check if you have the correct role (regular user, owner, admin)

### 404 Not Found
- Check that the resource ID is correct
- Verify that the resource exists and hasn't been deleted

### 422 Validation Error
- Check the response body for specific validation errors
- Make sure all required fields are provided with valid values

### 500 Server Error
- Check server logs for more detailed error information
- May indicate a configuration or implementation issue

---

For any further questions or issues, please refer to the API documentation or contact the development team. 