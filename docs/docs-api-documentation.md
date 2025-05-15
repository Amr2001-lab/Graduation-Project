# docs/API Documentation

## API Documentation

All endpoints are prefixed with `/api`.\
Authentication uses Laravel’s session guard, so include your **session cookie** with every request.

***

### 1. Authentication

#### 1.1. Register

`POST /api/register`

Describes the fields required to register a new user.

| Field      | Type   | Description         |
| ---------- | ------ | ------------------- |
| `name`     | string | Full name           |
| `email`    | string | Must be unique      |
| `password` | string | Min 8 chars         |
| `role`     | string | `buyer` \| `seller` |

**Response 201**

A successful registration returns the created user's details.

```json
{
  "id": 12,
  "name": "Alice",
  "email": "alice@example.com",
  "role": "buyer",
  "created_at": "2025-05-20T12:34:56Z"
}
```
