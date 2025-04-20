# Saved Searches System

This document provides instructions on how to use the saved searches feature in the Real Estate API.

## Overview

The saved searches system allows users to save their search criteria for properties, enabling them to quickly access their favorite search filters later. Users can also opt to receive notifications about new properties that match their saved criteria.

## API Endpoints

### User Endpoints

1. **List Saved Searches**
   - URL: `GET /api/saved-searches`
   - Auth: Required
   - Response: List of user's saved searches

2. **Create Saved Search**
   - URL: `POST /api/saved-searches`
   - Auth: Required
   - Body:
     ```json
     {
       "name": "Downtown Apartments",
       "filters": {
         "location": "downtown",
         "min_price": 200000,
         "max_price": 500000,
         "bedrooms": 2,
         "bathrooms": 2
       },
       "is_notifiable": true,
       "notification_frequency": "weekly"
     }
     ```
   - Response: The created saved search object

3. **Get Saved Search**
   - URL: `GET /api/saved-searches/{id}`
   - Auth: Required
   - Response: Details of the specified saved search

4. **Update Saved Search**
   - URL: `PUT /api/saved-searches/{id}`
   - Auth: Required
   - Body:
     ```json
     {
       "name": "Updated Downtown Search",
       "filters": {
         "location": "downtown",
         "min_price": 250000,
         "max_price": 600000,
         "bedrooms": 3
       },
       "is_notifiable": false
     }
     ```
   - Response: The updated saved search object

5. **Delete Saved Search**
   - URL: `DELETE /api/saved-searches/{id}`
   - Auth: Required
   - Response: Success message

## Data Structure

The saved searches feature allows users to store various property search criteria:

- **Name**: A user-friendly name for the saved search
- **Filters**: JSON object containing search criteria:
  - `location`: Area/neighborhood name
  - `min_price`/`max_price`: Price range
  - `bedrooms`/`bathrooms`: Number of rooms
  - `area`: Property size
  - Other property-specific filters
- **Notification Settings**:
  - `is_notifiable`: Whether to send notifications for new matches
  - `notification_frequency`: How often to check for matches (daily, weekly, monthly)
  - `last_notified_at`: When the last notification was sent

## Testing Flow

1. **Login**
   - Login with your user credentials
   - Save the authentication token

2. **Create a Saved Search**
   - Use the "Create Saved Search" endpoint with your preferred filters
   - Save the saved_search_id

3. **List Your Saved Searches**
   - Verify your saved search appears in the list

4. **Update the Saved Search**
   - Modify some search parameters

5. **Get Saved Search Details**
   - Verify the changes were applied

6. **Delete the Saved Search** (optional)
   - Remove the saved search if no longer needed

## Using Postman Collection

The Postman collection includes all necessary requests for testing the saved searches functionality:

1. Import the updated collection and environment files
2. Set the environment variables (base_url, email, password)
3. Execute the Login request to get a token
4. Use the saved searches requests in the order described in the Testing Flow section

## Implementation Details

The saved searches system is built with:

- `SavedSearch` model with JSON storage for filters
- Soft delete capability for data retention
- User relationship for ownership validation
- Support for notification preferences with customizable frequency