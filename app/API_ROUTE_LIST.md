# API Route List for https://mughtarib.abaadre.com/public/api

This document provides a comprehensive list of all API endpoints available on the production server.

## Health Check Endpoints

| Method | Endpoint | Description | Authentication Required |
|--------|----------|-------------|------------------------|
| GET    | /test    | Simple API test endpoint | No |
| GET    | /health  | Returns API health status with version and timestamp | No |

## Authentication Endpoints

| Method | Endpoint | Description | Authentication Required |
|--------|----------|-------------|------------------------|
| POST   | /register | Register a new user | No |
| POST   | /login    | Login and get authentication token | No |
| POST   | /logout   | Logout and invalidate token | Yes |
| GET    | /user     | Get authenticated user profile | Yes |
| POST   | /refresh  | Refresh authentication token | Yes |
| POST   | /forgot-password | Request password reset link | No |
| POST   | /reset-password  | Reset password with token | No |
| POST   | /verify-email/{id}/{hash} | Verify email address | No |
| POST   | /resend-verification-email | Resend verification email | No |

## Apartment Endpoints

| Method | Endpoint | Description | Authentication Required |
|--------|----------|-------------|------------------------|
| GET    | /apartments | Get list of all apartments | No |
| GET    | /apartments/{apartment} | Get single apartment details | No |
| GET    | /featured-apartments | Get featured apartments | No |
| GET    | /search-apartments | Search apartments with filters | No |
| POST   | /apartments | Create new apartment | Yes (Owner) |
| PUT    | /apartments/{apartment} | Update apartment | Yes (Owner) |
| DELETE | /apartments/{apartment} | Delete apartment | Yes (Owner) |
| GET    | /user/apartments | Get apartments owned by authenticated user | Yes |

## Comments Endpoints

| Method | Endpoint | Description | Authentication Required |
|--------|----------|-------------|------------------------|
| GET    | /apartments/{apartment}/comments | Get comments for an apartment | No |
| GET    | /apartments/{apartment}/comments/{comment} | Get single comment | No |
| GET    | /apartments/{apartment}/rating | Get average rating for apartment | No |
| POST   | /apartments/{apartment}/comments | Create new comment | Yes |
| PUT    | /apartments/{apartment}/comments/{comment} | Update comment | Yes (Owner) |
| DELETE | /apartments/{apartment}/comments/{comment} | Delete comment | Yes (Owner) |
| POST   | /apartments/{apartment}/comments/{comment}/report | Report comment | Yes |

## Favorites Endpoints

| Method | Endpoint | Description | Authentication Required |
|--------|----------|-------------|------------------------|
| GET    | /favorites | Get user's favorite apartments | Yes |
| POST   | /favorites | Add apartment to favorites | Yes |
| DELETE | /favorites/{apartment} | Remove apartment from favorites | Yes |
| GET    | /favorites/{apartment}/check | Check if apartment is in favorites | Yes |
| POST   | /favorites/{listing}/toggle | Toggle favorite status | Yes |

## Saved Search Endpoints

| Method | Endpoint | Description | Authentication Required |
|--------|----------|-------------|------------------------|
| GET    | /saved-searches | Get user's saved searches | Yes |
| POST   | /saved-searches | Create new saved search | Yes |
| GET    | /saved-searches/{id} | Get saved search details | Yes |
| PUT    | /saved-searches/{id} | Update saved search | Yes |
| DELETE | /saved-searches/{id} | Delete saved search | Yes |

## Admin Endpoints

| Method | Endpoint | Description | Authentication Required |
|--------|----------|-------------|------------------------|
| GET    | /admin/comments/pending | Get pending comments | Yes (Admin) |
| PUT    | /admin/comments/{comment}/approve | Approve comment | Yes (Admin) |
| GET    | /admin/reports | Get comment reports | Yes (Admin) |
| PUT    | /admin/reports/{id}/resolve | Resolve comment report | Yes (Admin) |

## Base URL

All endpoints should be prefixed with:
```
https://mughtarib.abaadre.com/public/api
```

## Authentication

For protected endpoints, include the token in the Authorization header:
```
Authorization: Bearer {your_token}
``` 