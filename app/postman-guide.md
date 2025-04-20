# Postman Testing Guide for Real Estate API

This guide provides step-by-step instructions for testing the Real Estate API using Postman.

## Setting Up Postman

1. **Download and Install Postman**
   - Download from [postman.com](https://www.postman.com/downloads/)
   - Install the application

2. **Create a Workspace**
   - Open Postman and create a new workspace
   - Name it "Real Estate API"

3. **Set Up Environment**
   - Click on "Environments" in the left sidebar
   - Create a new environment called "Real Estate Local"
   - Add the following variables:
     - `base_url`: `http://127.0.0.1:8000/api`
     - `token`: (leave empty for now)
     - `apartment_id`: (leave empty for now)
     - `comment_id`: (leave empty for now)

4. **Select Environment**
   - In the top-right corner, select the "Real Estate Local" environment

## Creating API Requests

### Authentication

#### 1. Register User
- **Method**: POST
- **URL**: `{{base_url}}/register`
- **Headers**:
  - Content-Type: application/json
  - Accept: application/json
- **Body** (raw JSON):
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
- **Tests** (JavaScript):
  ```javascript
  // Save user ID
  if (pm.response.code === 200 || pm.response.code === 201) {
    var jsonData = pm.response.json();
    if (jsonData.data && jsonData.data.user && jsonData.data.user.id) {
      pm.environment.set("user_id", jsonData.data.user.id);
    }
  }
  ```

#### 2. Login
- **Method**: POST
- **URL**: `{{base_url}}/login`
- **Headers**:
  - Content-Type: application/json
  - Accept: application/json
- **Body** (raw JSON):
  ```json
  {
    "email": "john@example.com",
    "password": "password123"
  }
  ```
- **Tests** (JavaScript):
  ```javascript
  // Save access token
  if (pm.response.code === 200) {
    var jsonData = pm.response.json();
    if (jsonData.data && jsonData.data.token) {
      pm.environment.set("token", jsonData.data.token);
    }
  }
  ```

#### 3. Get User Profile
- **Method**: GET
- **URL**: `{{base_url}}/user`
- **Auth**: Bearer Token (use `{{token}}`)
- **Headers**:
  - Accept: application/json

#### 4. Logout
- **Method**: POST
- **URL**: `{{base_url}}/logout`
- **Auth**: Bearer Token (use `{{token}}`)
- **Headers**:
  - Accept: application/json

### Apartments

#### 1. Create Apartment
- **Method**: POST
- **URL**: `{{base_url}}/apartments`
- **Auth**: Bearer Token (use `{{token}}`)
- **Body** (form-data):
  - title: Luxury Apartment
  - description: A beautiful luxury apartment with stunning views
  - price: 1500
  - location: Downtown
  - bedrooms: 2
  - bathrooms: 2
  - area: 1200
  - images (file): [upload image files]
- **Tests** (JavaScript):
  ```javascript
  // Save apartment ID
  if (pm.response.code === 200 || pm.response.code === 201) {
    var jsonData = pm.response.json();
    if (jsonData.data && jsonData.data.id) {
      pm.environment.set("apartment_id", jsonData.data.id);
    }
  }
  ```

#### 2. List All Apartments
- **Method**: GET
- **URL**: `{{base_url}}/apartments`
- **Headers**:
  - Accept: application/json
- **Params** (optional):
  - min_price: 1000
  - max_price: 2000
  - location: Downtown
  - sort_by: price
  - sort_order: asc

#### 3. Get Single Apartment
- **Method**: GET
- **URL**: `{{base_url}}/apartments/{{apartment_id}}`
- **Headers**:
  - Accept: application/json

#### 4. Update Apartment
- **Method**: PUT
- **URL**: `{{base_url}}/apartments/{{apartment_id}}`
- **Auth**: Bearer Token (use `{{token}}`)
- **Body** (form-data):
  - title: Updated Luxury Apartment
  - price: 1600
  - [other fields as needed]

#### 5. Search Apartments
- **Method**: GET
- **URL**: `{{base_url}}/search-apartments`
- **Headers**:
  - Accept: application/json
- **Params**:
  - query: luxury
  - min_price: 1000
  - bedrooms: 2

#### 6. Featured Apartments
- **Method**: GET
- **URL**: `{{base_url}}/featured-apartments`
- **Headers**:
  - Accept: application/json

### Comments

#### 1. Create Comment
- **Method**: POST
- **URL**: `{{base_url}}/apartments/{{apartment_id}}/comments`
- **Auth**: Bearer Token (use `{{token}}`)
- **Headers**:
  - Content-Type: application/json
  - Accept: application/json
- **Body** (raw JSON):
  ```json
  {
    "content": "This is a fantastic apartment!",
    "rating": 5
  }
  ```
- **Tests** (JavaScript):
  ```javascript
  // Save comment ID
  if (pm.response.code === 200 || pm.response.code === 201) {
    var jsonData = pm.response.json();
    if (jsonData.data && jsonData.data.id) {
      pm.environment.set("comment_id", jsonData.data.id);
    }
  }
  ```

#### 2. List Comments
- **Method**: GET
- **URL**: `{{base_url}}/apartments/{{apartment_id}}/comments`
- **Headers**:
  - Accept: application/json

#### 3. Update Comment
- **Method**: PUT
- **URL**: `{{base_url}}/apartments/{{apartment_id}}/comments/{{comment_id}}`
- **Auth**: Bearer Token (use `{{token}}`)
- **Headers**:
  - Content-Type: application/json
  - Accept: application/json
- **Body** (raw JSON):
  ```json
  {
    "content": "This is an updated comment!",
    "rating": 4
  }
  ```

#### 4. Report Comment
- **Method**: POST
- **URL**: `{{base_url}}/apartments/{{apartment_id}}/comments/{{comment_id}}/report`
- **Auth**: Bearer Token (use `{{token}}`)
- **Headers**:
  - Content-Type: application/json
  - Accept: application/json
- **Body** (raw JSON):
  ```json
  {
    "reason": "This comment contains inappropriate content"
  }
  ```
- **Tests** (JavaScript):
  ```javascript
  // Save report ID
  if (pm.response.code === 200 || pm.response.code === 201) {
    var jsonData = pm.response.json();
    if (jsonData.data && jsonData.data.id) {
      pm.environment.set("report_id", jsonData.data.id);
    }
  }
  ```

### Favorites

#### 1. Add to Favorites
- **Method**: POST
- **URL**: `{{base_url}}/favorites`
- **Auth**: Bearer Token (use `{{token}}`)
- **Headers**:
  - Content-Type: application/json
  - Accept: application/json
- **Body** (raw JSON):
  ```json
  {
    "apartment_id": "{{apartment_id}}"
  }
  ```

#### 2. List Favorites
- **Method**: GET
- **URL**: `{{base_url}}/favorites`
- **Auth**: Bearer Token (use `{{token}}`)
- **Headers**:
  - Accept: application/json

#### 3. Check Favorite Status
- **Method**: GET
- **URL**: `{{base_url}}/favorites/{{apartment_id}}/check`
- **Auth**: Bearer Token (use `{{token}}`)
- **Headers**:
  - Accept: application/json

#### 4. Remove from Favorites
- **Method**: DELETE
- **URL**: `{{base_url}}/favorites/{{apartment_id}}`
- **Auth**: Bearer Token (use `{{token}}`)
- **Headers**:
  - Accept: application/json

### Admin Endpoints (requires admin role)

#### 1. List Pending Comments
- **Method**: GET
- **URL**: `{{base_url}}/admin/comments/pending`
- **Auth**: Bearer Token (use `{{token}}` from admin login)
- **Headers**:
  - Accept: application/json

#### 2. Approve Comment
- **Method**: PUT
- **URL**: `{{base_url}}/admin/comments/{{comment_id}}/approve`
- **Auth**: Bearer Token (use `{{token}}` from admin login)
- **Headers**:
  - Accept: application/json

#### 3. List Comment Reports
- **Method**: GET
- **URL**: `{{base_url}}/admin/reports`
- **Auth**: Bearer Token (use `{{token}}` from admin login)
- **Headers**:
  - Accept: application/json
- **Params** (optional):
  - status: pending

#### 4. Resolve Report
- **Method**: PUT
- **URL**: `{{base_url}}/admin/reports/{{report_id}}/resolve`
- **Auth**: Bearer Token (use `{{token}}` from admin login)
- **Headers**:
  - Content-Type: application/json
  - Accept: application/json
- **Body** (raw JSON):
  ```json
  {
    "resolution_notes": "This report has been reviewed and the comment is acceptable",
    "action": "approve"
  }
  ```

## Testing Workflows

### Regular User Workflow
1. Register a regular user (role_id: 1)
2. Login to get your token
3. Browse apartments
4. View apartment details
5. Add comments to apartments
6. Add apartments to favorites
7. Report inappropriate comments

### Property Owner Workflow
1. Register a property owner (role_id: 2)
2. Login to get your token
3. Create new apartment listings
4. Upload images for your apartments
5. Update your apartment details
6. Search for other apartments
7. View and respond to comments on your listings

### Admin Workflow
1. Register an admin user (role_id: 3) or use a pre-created admin account
2. Login to get your token
3. Browse pending comments
4. Approve or reject comments
5. View reported comments
6. Resolve reports (approve, reject, or delete comments)

## Troubleshooting

### Common Issues

#### Authentication Errors
- Ensure your token is correctly set in the environment
- Check if your token has expired (re-login if needed)
- Verify you're using the correct user role for restricted endpoints

#### 404 Not Found
- Check if the resource ID is correct
- Ensure the URL path is formatted correctly

#### 422 Validation Errors
- Check the request body format
- Ensure all required fields are provided
- Verify data types (numbers for numeric fields, etc.)

#### Image Upload Issues
- Ensure you're using form-data, not raw JSON
- Check file size limits (usually 2MB per file)
- Verify supported image formats (jpeg, png, jpg, gif)

### Getting Help
If you encounter persistent issues, check:
1. API documentation for correct endpoint usage
2. Server logs for backend errors
3. Contact the development team with specific error messages 