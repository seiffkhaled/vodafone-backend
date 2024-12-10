# Task And Report Management Backend

## Setup Instructions

### 1. Clone the repository

First, clone the repository to your local machine using the following command:

```bash
git clone https://github.com/your-repository/vodafone-backend.git
```
### 2. Install Dependencies
```bash
cd vodafone-backend
composer install
```
### 3. Set up Environment Variables
```
cp .env.example .env
```
### 4. Generate Application Key
```
php artisan key:generate
```
### 5. Set up the Database
```
php artisan migrate
```
6. Run the Application
```
php artisan serve
```
### Example for requests and responses
## with Authorization Header {Bearer token}
POST /api/user/login
## {
    "email": "user@example.com",
    "password": "password"
}

POST /api/user/tasks
## {
    "user_id": 1,
    "title": "task 2",
    "description": "task 2 description",
    "start_date": "2024-12-12",
    "due_date": "2025-01-10",
    "status": "pending"
}
## {
    "message": "Task created successfully!",
    "task": {
        "id": 1,
        "user_id": 1,
        "title": "task 2",
        "description": "task 2 description",
        "start_date": "2024-12-12",
        "due_date": "2025-01-10",
        "status": "pending",
        "created_at": "2024-12-10T00:00:00.000000Z",
        "updated_at": "2024-12-10T00:00:00.000000Z"
    }
}
GET /api/user/tasks?status=pending&start_date=2024-12-01&end_date=2025-01-01
## {
    "data": [
        {
            "id": 1,
            "user_id": 1,
            "title": "task 2",
            "description": "task 2 description",
            "start_date": "2024-12-12",
            "due_date": "2025-01-10",
            "status": "pending",
            "created_at": "2024-12-10T00:00:00.000000Z",
            "updated_at": "2024-12-10T00:00:00.000000Z"
        }
    ],
    "links": {
        "first": "http://localhost:8000/api/user/tasks?page=1",
        "last": "http://localhost:8000/api/user/tasks?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "per_page": 15,
        "to": 1,
        "total": 1
    }
}
POST /api/user/subscribe
## {
    "start_date": "2024-12-12",
    "frequency": "weekly",
    "report_time": "00"
}
