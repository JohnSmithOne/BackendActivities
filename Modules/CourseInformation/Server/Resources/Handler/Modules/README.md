# Enrollment Management System API Documentation

This is a Documentation for an Enrollment Management for Course information. This document provides information on how to interact with the enrollment management backend and make use of its functionality.


## HTTP URL


The base URL for all API requests is:


```
http://localhost/enrollment-backend-documentation/API.php
```


## Authentication


The Microservice API uses API key authentication. To authenticate your requests, include the API key in the `Authorization` header as follows:


```
Authorization: Bearer <YOUR_API_KEY>
```


## Endpoints


### GET Method


Retrieve course information from a specific category.


```
GET /<module>/<parameters>=?
```


**Parameters:**


- `id` (required) - The unique identifier of the tbl_courses.
- `category` (required) - category of course.


**Response:**

#### *GET Request for specific data*

```
Status: 200 OK

status: "success"
data: [
    {
    "id": "1",
    "course": "BS Computer Science",
    }
]
method: GET
```

#### *GET Request for Empty Request*

```
Status: 200 OK

status: "success"
data: [
    {
    "id": "1",
    "course": "BS Computer Science",
    },

    {
    "id": "2",
    "course": "BS Information Technology ",
    },

    {
    "id": "3",
    "course": "BS Psychology",
    },

    {
    "id": "4",
    "course": "BS Mechanical Engineering",
    }

]
method: GET
```


### POST Method


Add a category and/or course.


```
POST /<module>
```


**Parameters:**


- `course_name` - The name of course.
- `category` - Category of Course.


**Response:**


```
Status: 201 Created

status: "success"
data: {
  "id": "1",
  "course_name": "BS Computer Science",
  "category": "Computer Science",
}
method: POST
```


### PUT Method


Update a course and/or category.


```
PUT /<module>/{1}
```


**Parameters:**

- `id` (required) - The unique identifier of the tbl_courses.
- `course_name` - The name of course.
- `category` - Category of Course.


**Response:**


```
Status: 200 OK


status: "success"
data: {
  "id": "1",
  "course_name": "BS Electronics and Communication Engineering",
  "category": "Engineering",
}
method: PUT
```



## Errors

In case of an error, additional information will be provided in the response body. The following errors uses a JSON Response format  to indicate failure of a request. 

### GET Method

```
GET /<module>/id=2232323
```

**Parameters:**


- `id` (required) - The unique identifier of the tbl_courses.
- `category` (required) - category of course.

**Response:**

#### *Id or Category Doesn't Exist*

```
Status:  404 Not Found 

status: "fail"
message: "Id or Category Doesn't Exist"

```

#### *Invalid Payload Parameters*
```
Status:  400 Bad Request 

status: "fail"
fail: "Invalid Payload Parameters"

```


#### *An unexpected error occurred on the server.*
```
Status: 500 Bad Request

status: "fail"
message: "An unexpected error occurred on the server."
```

#### *Authentication failed or API key is missing or invalid*

```
Status:  401 Unauthorized

status: "fail"
message: "Authentication failed or API key is missing or invalid"

```

### POST Method


Add a category and/or course.


```
POST /<module>
```


**Parameters:**


- `course_name` - The name of course.
- `category` - Category of Course.


**Response:**

#### *Invalid Payload Parameters*
```
Status:  400 Bad Request 

status: "fail"
fail: "Invalid Payload Parameters"

```

#### *An unexpected error occurred on the server.*
```
Status: 500 Bad Request

status: "fail"
message: "An unexpected error occurred on the server."
```

#### *Authentication failed or API key is missing or invalid*

```
Status:  401 Unauthorized

status: "fail"
message: "Authentication failed or API key is missing or invalid"

```

### PUT Method


Update a course and/or category.


```
PUT /<module>/{1}
```


**Parameters:**

- `id` (required) - The unique identifier of the tbl_courses.
- `course_name` - The name of course.
- `category` - Category of Course.


**Response:**

#### *Invalid Payload Parameters*
```
Status: 400 Bad Request

status: "fail"
message: "Invalid Payload Parameters"
```
#### *Id Doesn't Exist*

```
Status:  404 Not Found 

status: "fail"
message: "Id Doesn't Exist"

```

#### *An unexpected error occurred on the server.*
```
Status: 500 Internal Server Error

status: "fail"
message: "An unexpected error occurred on the server."
```

#### *Authentication failed or API key is missing or invalid*

```
Status:  401 Unauthorized

status: "fail"
message: "Authentication failed or API key is missing or invalid"

```




- 400 Bad Request - The request was invalid or missing required parameters.
- 401 Unauthorized - Authentication failed or API key is missing or invalid.
- 404 Not Found - The requested resource was not found.
- 500 Internal Server Error - An unexpected error occurred on the server.




