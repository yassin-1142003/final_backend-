# Comment Reporting System

This document provides instructions on how to test the comment reporting system in the Real Estate API.

## Overview

The comment reporting system allows users to report inappropriate comments. Administrators can then review these reports and take appropriate action (approve, reject, or delete).

## API Endpoints

### User Endpoints

1. **Report a Comment**
   - URL: `POST /api/apartments/{apartment}/comments/{comment}/report`
   - Auth: Required
   - Body:
     ```json
     {
       "reason": "This comment contains inappropriate content"
     }
     ```
   - Response: The created report object

### Admin Endpoints

1. **List Reports**
   - URL: `GET /api/admin/reports?status=pending`
   - Auth: Required (Admin only)
   - Query Parameters:
     - `status`: Filter by status (`pending`, `resolved`, or `rejected`). Default is `pending`.
   - Response: Paginated list of reports

2. **Resolve a Report**
   - URL: `PUT /api/admin/reports/{id}/resolve`
   - Auth: Required (Admin only)
   - Body:
     ```json
     {
       "resolution_notes": "This comment violates our community guidelines",
       "action": "delete" // Options: approve, reject, delete
     }
     ```
   - Response: The updated report object

## Testing Flow

1. **Register/Login**
   - Register as a regular user or login with existing credentials
   - Save the authentication token

2. **Create an Apartment**
   - Create a new apartment or use an existing one
   - Save the apartment ID

3. **Add a Comment**
   - Add a comment to the apartment
   - Save the comment ID

4. **Report the Comment**
   - Use the "Report Comment" endpoint to report the comment
   - Save the report ID

5. **Admin Actions** (require admin credentials)
   - Login as an admin user
   - List pending reports
   - Resolve a report by approving, rejecting, or deleting the comment

## Using Postman Collection

1. Import the Postman collection and environment files
2. Set the environment variables:
   - `base_url`: Your API base URL (e.g., `http://127.0.0.1:8000`)
   - `email`: Your test user email
   - `password`: Your test user password

3. Execute the requests in the following order:
   - Login (to get a token)
   - Create Apartment (if needed)
   - Create Comment (if needed)
   - Report Comment
   - List Reports (as admin)
   - Resolve Report (as admin)

The collection includes test scripts that will automatically save IDs to environment variables for easy testing.

## Database Structure

- `comments` table: Stores all comments with soft delete capability
- `comment_reports` table: Stores all reports with:
  - Relationship to the reported comment
  - Reporter user ID
  - Report reason
  - Status (pending, resolved, rejected)
  - Admin resolution data (who resolved it, when, and notes) 