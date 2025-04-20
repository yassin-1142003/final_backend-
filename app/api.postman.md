# Real Estate API Documentation

## Setup and Authentication

### Setting Up Postman

1. Import the collection:
   - Open Postman
   - Click on "Import" button
   - Select the `real-estate-api.postman_collection.json` file
   - Click "Import"

2. Import the environment:
   - Click on "Import" button
   - Select the `real-estate-api.postman_environment.json` file
   - Click "Import"

3. Select the environment:
   - In the top-right corner, click on the environment dropdown
   - Select "Real Estate API Environment"

### Authentication Flow

1. **Register a User**
   - Use the "Register" request in the Authentication folder
   - Fill in the required fields:
     ```json
     {
         "name": "Your Name",
         "email": "your.email@example.com",
         "password": "password123",
         "password_confirmation": "password123",
         "phone": "1234567890",
         "role_id": 1
     }
     ```
   - Role IDs: 1 = Regular User, 2 = Property Owner, 3 = Admin

2. **Login**
   - Use the "Login" request in the Authentication folder
   - Fill in your credentials:
     ```json
     {
         "email": "your.email@example.com",
         "password": "password123"
     }
     ```
   - The response will contain an access token
   - The token will be automatically stored in the environment variable `{{authToken}}`

3. **View Your Profile**
   - Use the "Get Profile" request in the Authentication folder
   - The request will use your stored token automatically

4. **Logout**
   - Use the "Logout" request when finished

## User Role-Based Actions

### Regular Users (role_id: 1)

Regular users can:
- View apartments (`GET /apartments`)
- View single apartment details (`GET /apartments/{id}`)
- Search apartments (`GET /apartments/search`)
- View featured apartments (`GET /apartments/featured`)
- Add apartments to favorites (`POST /apartments/{id}/favorite`)
- List favorite apartments (`GET /favorites`)
- Remove apartments from favorites (`DELETE /apartments/{id}/favorite`)
- Check if an apartment is favorited (`GET /apartments/{id}/favorite/check`)
- Toggle favorite status (`POST /apartments/{id}/favorite/toggle`)
- View apartment comments (`GET /apartments/{id}/comments`)
- Post comments on apartments (`POST /apartments/{id}/comments`)
- Update their own comments (`PUT /apartments/{id}/comments/{comment_id}`)
- Delete their own comments (`DELETE /apartments/{id}/comments/{comment_id}`)
- Report inappropriate comments (`POST /apartments/{id}/comments/{comment_id}/report`)

### Property Owners (role_id: 2)

Property owners can do everything regular users can, plus:
- Create new apartments (`POST /apartments`)
- Update their own apartments (`PUT /apartments/{id}`)
- Delete their own apartments (`DELETE /apartments/{id}`)
- Respond to comments on their properties

### Administrators (role_id: 3)

Administrators can do everything property owners can, plus:
- View all pending comments (`GET /admin/comments/pending`)
- Approve or reject comments (`PUT /admin/comments/{id}/approve`)
- View all comment reports (`GET /admin/reports`)
- Resolve comment reports (`PUT /admin/reports/{id}/resolve`)
- Manage all apartments (edit/delete any apartment)
- Manage all comments (edit/delete any comment)

## Testing Flows by Role

### Regular User Flow

1. Register as a regular user (role_id: 1)
2. Login to get your authentication token
3. Browse apartments (GET /apartments)
4. Search for apartments by location or features
5. View apartment details
6. Add apartments to favorites
7. View your favorite apartments
8. Post comments on apartments
9. Report inappropriate comments

### Property Owner Flow

1. Register as a property owner (role_id: 2)
2. Login to get your authentication token
3. Create a new apartment listing
   - Fill in all required details
   - Add images if desired
4. View your created apartment
5. Update apartment details
6. View comments on your apartments
7. Respond to user comments
8. Remove a listing if needed

### Administrator Flow

1. Login as an administrator (role_id: 3)
2. View pending comments for approval
3. Approve or reject pending comments
4. View reported comments
5. Resolve comment reports
   - You can approve, reject, or delete reported comments
   - Provide resolution notes

## Working with Images

When creating or updating apartments, images can be uploaded as form-data:
- Use the key `images[]` for multiple image uploads
- Make sure to set the request type to `form-data` rather than raw JSON
- Images will be stored in the public storage directory

## Error Handling

Most API errors will return with appropriate HTTP status codes:
- 400: Bad Request (invalid input)
- 401: Unauthorized (missing or invalid token)
- 403: Forbidden (insufficient permissions)
- 404: Not Found (resource doesn't exist)
- 422: Validation Error (invalid form data)
- 500: Server Error

For validation errors (422), check the `errors` object in the response for field-specific error messages.

## Environment Variables

The collection automatically sets these variables:
- `{{base_url}}`: The API base URL (http://127.0.0.1:8000/api)
- `{{authToken}}`: Your authentication token (set after login)
- `{{user_id}}`: Current user ID
- `{{apartment_id}}`: Currently selected apartment ID
- `{{comment_id}}`: Currently selected comment ID
- `{{report_id}}`: Currently selected report ID

## Database Structure

Main tables in the database:
- `users`: User accounts with roles
- `apartments`: Property listings
- `apartment_images`: Images for apartments
- `comments`: User comments on apartments
- `comment_reports`: Reports about inappropriate comments
- `favorites`: User's favorite apartments

## Directory Structure

Key directories in the project:
- `/app/Models`: Database models
- `/app/Http/Controllers/API`: API controllers
- `/database/migrations`: Database structure
- `/routes/api.php`: API route definitions
- `/storage/app/public/apartments`: Apartment images 