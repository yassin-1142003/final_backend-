# Real Estate API Documentation

## API Overview

This API provides endpoints for managing apartments, user authentication, comments, favorites, and more in a real estate application.

## Authentication

### Register User
- **URL**: `/api/register`
- **Method**: `POST`
- **Body**:
  ```json
  {
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "role_id": 1,
    "phone": "1234567890"
  }
  ```
- **Response**: Returns user data and access token
- **Role IDs**: 1 = Regular User, 2 = Property Owner, 3 = Admin

### Login
- **URL**: `/api/login`
- **Method**: `POST`
- **Body**:
  ```json
  {
    "email": "john@example.com",
    "password": "password123"
  }
  ```
- **Response**: Returns user data and access token

### Get User Profile
- **URL**: `/api/user`
- **Method**: `GET`
- **Auth**: Required
- **Response**: Returns authenticated user data

### Logout
- **URL**: `/api/logout`
- **Method**: `POST`
- **Auth**: Required
- **Response**: Confirmation message

## Apartments

### List All Apartments
- **URL**: `/api/apartments`
- **Method**: `GET`
- **Query Parameters**:
  - `min_price`: Minimum price
  - `max_price`: Maximum price
  - `location`: Location search
  - `sort_by`: Field to sort by (default: created_at)
  - `sort_order`: Sort direction (asc/desc)
- **Response**: Returns paginated list of apartments

### Get Single Apartment
- **URL**: `/api/apartments/{id}`
- **Method**: `GET`
- **Response**: Returns apartment details with images and user info

### Create Apartment
- **URL**: `/api/apartments`
- **Method**: `POST`
- **Auth**: Required (Property Owner)
- **Body** (form-data):
  - `title`: Apartment title
  - `description`: Detailed description
  - `price`: Price (numeric)
  - `location`: Location
  - `bedrooms`: Number of bedrooms (integer)
  - `bathrooms`: Number of bathrooms (integer)
  - `area`: Area in square units (numeric)
  - `images[]`: Multiple image files (optional)
- **Response**: Returns created apartment data

### Update Apartment
- **URL**: `/api/apartments/{id}`
- **Method**: `PUT`
- **Auth**: Required (Property Owner, owner of the apartment)
- **Body** (form-data): Same as Create Apartment (fields to update)
- **Response**: Returns updated apartment data

### Delete Apartment
- **URL**: `/api/apartments/{id}`
- **Method**: `DELETE`
- **Auth**: Required (Property Owner, owner of the apartment)
- **Response**: Confirmation message

### Search Apartments
- **URL**: `/api/search-apartments`
- **Method**: `GET`
- **Query Parameters**:
  - `query`: Search term
  - `min_price`: Minimum price
  - `max_price`: Maximum price
  - `bedrooms`: Number of bedrooms
  - `bathrooms`: Number of bathrooms
- **Response**: Returns paginated list of matching apartments

### Featured Apartments
- **URL**: `/api/featured-apartments`
- **Method**: `GET`
- **Response**: Returns list of featured apartments

### User's Apartments
- **URL**: `/api/user/apartments`
- **Method**: `GET`
- **Auth**: Required
- **Response**: Returns paginated list of apartments owned by user

## Comments

### List Comments for Apartment
- **URL**: `/api/apartments/{apartment_id}/comments`
- **Method**: `GET`
- **Response**: Returns paginated list of approved comments

### Get Single Comment
- **URL**: `/api/apartments/{apartment_id}/comments/{comment_id}`
- **Method**: `GET`
- **Response**: Returns comment details

### Create Comment
- **URL**: `/api/apartments/{apartment_id}/comments`
- **Method**: `POST`
- **Auth**: Required
- **Body**:
  ```json
  {
    "content": "This is a great apartment!",
    "rating": 5
  }
  ```
- **Response**: Returns created comment data

### Update Comment
- **URL**: `/api/apartments/{apartment_id}/comments/{comment_id}`
- **Method**: `PUT`
- **Auth**: Required (Comment owner)
- **Body**:
  ```json
  {
    "content": "Updated comment",
    "rating": 4
  }
  ```
- **Response**: Returns updated comment data

### Delete Comment
- **URL**: `/api/apartments/{apartment_id}/comments/{comment_id}`
- **Method**: `DELETE`
- **Auth**: Required (Comment owner)
- **Response**: Confirmation message

### Get Average Rating
- **URL**: `/api/apartments/{apartment_id}/rating`
- **Method**: `GET`
- **Response**: Returns average rating for apartment

### Report Comment
- **URL**: `/api/apartments/{apartment_id}/comments/{comment_id}/report`
- **Method**: `POST`
- **Auth**: Required
- **Body**:
  ```json
  {
    "reason": "This comment is inappropriate"
  }
  ```
- **Response**: Returns created report data

## Admin Comment Management

### Get Pending Comments
- **URL**: `/api/admin/comments/pending`
- **Method**: `GET`
- **Auth**: Required (Admin)
- **Response**: Returns paginated list of pending comments

### Approve Comment
- **URL**: `/api/admin/comments/{comment_id}/approve`
- **Method**: `PUT`
- **Auth**: Required (Admin)
- **Response**: Returns approved comment data

### List Comment Reports
- **URL**: `/api/admin/reports`
- **Method**: `GET`
- **Auth**: Required (Admin)
- **Query Parameters**:
  - `status`: Filter by status (pending, resolved, rejected)
- **Response**: Returns paginated list of comment reports

### Resolve Comment Report
- **URL**: `/api/admin/reports/{report_id}/resolve`
- **Method**: `PUT`
- **Auth**: Required (Admin)
- **Body**:
  ```json
  {
    "resolution_notes": "This report has been reviewed",
    "action": "approve|reject|delete"
  }
  ```
- **Response**: Returns resolved report data

## Favorites

### List User's Favorites
- **URL**: `/api/favorites`
- **Method**: `GET`
- **Auth**: Required
- **Response**: Returns paginated list of favorite apartments

### Add to Favorites
- **URL**: `/api/favorites`
- **Method**: `POST`
- **Auth**: Required
- **Body**:
  ```json
  {
    "apartment_id": 1
  }
  ```
- **Response**: Returns created favorite data

### Remove from Favorites
- **URL**: `/api/favorites/{apartment_id}`
- **Method**: `DELETE`
- **Auth**: Required
- **Response**: Confirmation message

### Check Favorite Status
- **URL**: `/api/favorites/{apartment_id}/check`
- **Method**: `GET`
- **Auth**: Required
- **Response**: Returns favorite status (boolean)

### Toggle Favorite
- **URL**: `/api/favorites/{apartment_id}/toggle`
- **Method**: `POST`
- **Auth**: Required
- **Response**: Returns updated favorite status

## Health Check and Information

### API Test
- **URL**: `/api/test`
- **Method**: `GET`
- **Response**: Simple confirmation that API is working

### API Health
- **URL**: `/api/health`
- **Method**: `GET`
- **Response**: Returns API status, version, environment, and server time

## Testing with Postman

### Setup
1. Create a user account (register)
2. Login to get your auth token
3. Use the auth token for all protected endpoints

### Testing Flow Example
1. Register a user (role_id: 2 for property owner)
2. Login to get your auth token
3. Create an apartment listing with images
4. List all apartments to see your created listing
5. Create a comment on another apartment
6. Add an apartment to favorites
7. Search for apartments based on location or features
8. Update your apartment listing
9. Report a comment that seems inappropriate
10. Check the average rating of an apartment

### Error Handling
- 400: Bad Request - Check your request parameters
- 401: Unauthorized - Authentication required
- 403: Forbidden - Insufficient permissions
- 404: Not Found - Resource doesn't exist
- 422: Validation Error - Check input validation
- 500: Server Error - Something went wrong server-side

## User Roles and Permissions

### Regular User (role_id: 1)
- View apartments and comments
- Create, update, and delete own comments
- Add/remove favorites
- Report inappropriate comments

### Property Owner (role_id: 2)
All Regular User permissions plus:
- Create apartments
- Update own apartments
- Delete own apartments

### Admin (role_id: 3)
All Property Owner permissions plus:
- Manage all apartments
- Approve/reject comments
- Resolve comment reports

## Working with Images

When creating or updating apartments:
- Use form-data format instead of raw JSON
- Include image files with the key `images[]` (can include multiple)
- Images will be stored in the public storage directory
- Image URLs will be included in apartment responses 