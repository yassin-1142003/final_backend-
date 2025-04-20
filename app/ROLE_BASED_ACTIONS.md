# Role-Based Actions in the Real Estate API

This document outlines the specific actions and permissions available to each user role in the Real Estate API.

## User Roles

The system includes three main user roles:

1. **Admin** (role_id: 1) - Full system access with moderation capabilities
2. **Property Owner** (role_id: 2) - Can create and manage apartment listings
3. **Regular User** (role_id: 3) - Can browse apartments, leave comments, and manage favorites

## Admin Capabilities

Admins have full access to the system and special moderation privileges:

### Apartment Management
- View all apartments (GET `/apartments`)
- Create new apartments (POST `/apartments`)
- View individual apartments (GET `/apartments/{id}`)
- Update any apartment (PUT `/apartments/{id}`)
- Delete any apartment (DELETE `/apartments/{id}`)

### Comment Moderation
- View all comments for any apartment (GET `/apartments/{id}/comments`)
- View pending comments awaiting approval (GET `/admin/comments/pending`)
- Approve comments (PUT `/admin/comments/{id}/approve`)
- Delete any comment (DELETE `/apartments/{id}/comments/{id}`)

### Comment Report Management
- View all comment reports (GET `/admin/reports`)
- Filter reports by status (GET `/admin/reports?status=pending`)
- Resolve reports by approving, rejecting, or deleting the reported comment (PUT `/admin/reports/{id}/resolve`)

### User Management
- Admins can manage their own profile (GET, PUT `/profile`)

## Property Owner Capabilities

Property owners can manage their own listings:

### Apartment Management
- View all apartments (GET `/apartments`)
- Create new apartments (POST `/apartments`)
- View individual apartments (GET `/apartments/{id}`)
- Update their own apartments (PUT `/apartments/{id}`)
- Delete their own apartments (DELETE `/apartments/{id}`)

### Comment Interaction
- View comments on their apartments (GET `/apartments/{id}/comments`)
- View average ratings on their apartments (GET `/apartments/{id}/rating`)
- Report inappropriate comments on their apartments (POST `/apartments/{id}/comments/{id}/report`)

### Favorites Management
- Add apartments to favorites (POST `/favorites`)
- View their favorited apartments (GET `/favorites`)
- Remove apartments from favorites (DELETE `/favorites/{id}`)
- Check if an apartment is in their favorites (GET `/favorites/{id}/check`)
- Toggle favorite status (POST `/favorites/{id}/toggle`)

### User Management
- Property owners can manage their own profile (GET, PUT `/profile`)

## Regular User Capabilities

Regular users can browse and interact with listings:

### Apartment Browsing
- View all apartments (GET `/apartments`)
- View featured apartments (GET `/featured-apartments`)
- View individual apartments (GET `/apartments/{id}`)
- Search and filter apartments (GET `/apartments?search=term&min_price=value&max_price=value&location=value&bedrooms=value&bathrooms=value&min_area=value&max_area=value`)
- Sort apartments (GET `/apartments?sort_by=field&sort_direction=asc`)

### Comment Management
- View comments on apartments (GET `/apartments/{id}/comments`)
- View average ratings (GET `/apartments/{id}/rating`)
- Create comments and ratings (POST `/apartments/{id}/comments`)
- Update their own comments (PUT `/apartments/{id}/comments/{id}`)
- Delete their own comments (DELETE `/apartments/{id}/comments/{id}`)
- Report inappropriate comments (POST `/apartments/{id}/comments/{id}/report`)

### Favorites Management
- Add apartments to favorites (POST `/favorites`)
- View their favorited apartments (GET `/favorites`)
- Remove apartments from favorites (DELETE `/favorites/{id}`)
- Check if an apartment is in their favorites (GET `/favorites/{id}/check`)
- Toggle favorite status (POST `/favorites/{id}/toggle`)

### User Management
- Regular users can manage their own profile (GET, PUT `/profile`)

## Authentication for All Roles

All users, regardless of role, can access these authentication endpoints:

- Register (POST `/register`)
- Login (POST `/login`)
- Get profile (GET `/profile`)
- Logout (POST `/logout`)
- Refresh token (POST `/refresh`)

## Access Control Implementation

Access control is implemented through:

1. **Middleware checks** - Role-based middleware that validates the user's role before allowing access to protected routes
2. **Policy-based authorization** - For more granular control in controllers (e.g., ensuring users can only update their own apartments)
3. **Token-based authentication** - Using Laravel Sanctum for API token management

## Example Usage Scenarios

### Admin Scenario
1. Admin logs in
2. Views all apartments in the system
3. Checks for pending comments requiring approval
4. Approves or rejects pending comments
5. Reviews reported comments and takes appropriate action
6. Updates or deletes problematic content as needed

### Property Owner Scenario
1. Owner logs in
2. Creates a new apartment listing with details and images
3. Views their existing listings
4. Updates apartment information or images
5. Reviews comments left on their apartments
6. Reports any inappropriate comments for admin review

### Regular User Scenario
1. User registers or logs in
2. Browses available apartments
3. Searches for apartments with specific criteria
4. Views apartment details and existing comments
5. Adds interesting apartments to their favorites
6. Leaves ratings and comments on apartments they've visited
7. Updates or deletes their own comments if needed

## API Endpoints By Role

### Public Endpoints (No Authentication Required)
- `GET /api/health` - Health check
- `GET /api/test` - API test
- `POST /api/register` - User registration
- `POST /api/login` - User login
- `POST /api/forgot-password` - Request password reset
- `POST /api/reset-password` - Reset password
- `POST /api/verify-email/{id}/{hash}` - Verify email address
- `GET /api/apartments` - List apartments
- `GET /api/apartments/{id}` - View apartment details
- `GET /api/featured-apartments` - View featured apartments
- `GET /api/search-apartments` - Search apartments
- `GET /api/apartments/{id}/comments` - View comments on an apartment
- `GET /api/apartments/{id}/rating` - View average rating for an apartment

### Regular User & Owner Endpoints (Authentication Required)
- `POST /api/logout` - Logout
- `POST /api/refresh` - Refresh token
- `GET /api/user` - Get user profile
- `POST /api/resend-verification-email` - Resend verification email
- `GET /api/favorites` - List favorites
- `POST /api/favorites` - Add to favorites
- `DELETE /api/favorites/{id}` - Remove from favorites
- `GET /api/favorites/{id}/check` - Check favorite status
- `POST /api/favorites/{id}/toggle` - Toggle favorite status
- `POST /api/apartments/{id}/comments` - Create comment
- `PUT /api/apartments/{id}/comments/{id}` - Update own comment
- `DELETE /api/apartments/{id}/comments/{id}` - Delete own comment
- `POST /api/apartments/{id}/comments/{id}/report` - Report comment
- `GET /api/saved-searches` - List saved searches
- `POST /api/saved-searches` - Create saved search
- `GET /api/saved-searches/{id}` - View saved search details
- `PUT /api/saved-searches/{id}` - Update saved search
- `DELETE /api/saved-searches/{id}` - Delete saved search

### Owner-Only Endpoints (Authentication + Owner Role Required)
- `POST /api/apartments` - Create apartment
- `PUT /api/apartments/{id}` - Update own apartment
- `DELETE /api/apartments/{id}` - Delete own apartment
- `GET /api/user/apartments` - View own apartments

### Administrator Endpoints (Authentication + Admin Role Required)
- `GET /api/admin/comments/pending` - View pending comments
- `PUT /api/admin/comments/{id}/approve` - Approve comment
- `GET /api/admin/reports` - View comment reports
- `PUT /api/admin/reports/{id}/resolve` - Resolve comment report

## Testing Role-Based Access

To thoroughly test role-based functionality:

1. **Create three test accounts:**
   - Admin user (role_id = 1)
   - Regular user (role_id = 2)
   - Property owner (role_id = 3)

2. **Test with each account to verify:**
   - Proper access to authorized endpoints
   - Proper denial of access to unauthorized endpoints
   - Correct functioning of role-specific features

3. **Verify role escalation protection:**
   - Ensure regular users cannot access owner features
   - Ensure regular users and owners cannot access admin features
   - Verify that users can only modify their own resources

## Database Role Structure

The role system is implemented in the database with:

1. **roles table:**
   - id: Role identifier (1=admin, 2=regular, 3=owner)
   - name: Role name
   - description: Role description

2. **users table:**
   - role_id: Foreign key to roles table

This structure allows for flexible role-based access control throughout the application. 