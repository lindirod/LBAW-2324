# EAP: Architecture Specification and Prototype

> To redefine project management, with ProPlanner we envision a platform where project teams thrive through efficient planning, active communication, and remote collaboration. The primary goal of our project is to empower organizations to achieve their project goals with ease and precision.

## A7: Web Resources Specification

This artifact provides documentation for a web application's architecture, adhering to the OpenAPI standard using YAML, and covers the CRUD operations for resources in the ProPlanner vertical prototype.

### 1. Overview



| Module | Description |
| -------- | -------- |
| M01: Authentication and Individual Profile | Web resources associated with user authentication and managing individual profiles, encompassing system functionalities such as login/logout, registration and the ability to view and edit personal profile details.    |
| M02: Projects | Web resources associated with project components, such as tasks, encompass the creation and editing of new projects and their respective tasks. These resources also involve the addition of users to projects and the management of their roles and hierarchy within each project. |
| M03: Administrator  | Web resources that facilitate user administration tasks. Administrators have the ability to view and search for users, delete or block user accounts, view and modify user information, and access system details related to each user. |
| M04: Search  | Web resources associated with searching functionalities, allowing users to search for specific information within the system. |



### 2. Permissions

| Identifier | Name | Description |
| -------- | -------- | -------- |
| **PUB**  | Public | User without privileges |
| **USR**  | User | Authenticated users |
| **OWN**  | Owner | Users that are owners of the content |
| **MEM**  | Project Member | User that belongs to a project |
| **PCO**  | Project Coordinator | User that coordinates a project |
| **ADM**  | Administrator | System administrators |


### 3. OpenAPI Specification
```yaml=
openapi: 3.0.0

info:
  version: '1.0'
  title: 'LBAW ProPlanner Web API'
  description: 'Web Resources Specification (A7) for ProPlanner'

servers:
  - url: http://lbaw23132.lbaw.fe.up.pt
    description: Production server

tags:
  - name: 'M01: Authentication and Individual Profile'
  - name: 'M02: Projects'
  - name: 'M03: Administrator'
  - name: 'M04: Search'

paths:
  
  /login:
    get:
      operationId: R101
      summary: 'R101: Login Form'
      description: 'Provide login form. Access: PUB'
      tags:
        - 'M01: Authentication and Individual Profile'
      responses:
        '200':
          description: 'Ok. Show log-in UI'

    post:
      operationId: R102
      summary: 'R102: Login Action'
      description: 'Processes the login form submission. Access: PUB'
      tags:
        - 'M01: Authentication and Individual Profile'
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                email:
                  type: string
                  format: email
                password:
                  type: string
              required:
                - email
                - password
      responses:
        '302':
          description: 'Redirect after processing the login credentials.'
          content:
            'text/plain':
              schema:
                type: string
          headers:
            Location:
              description: 'Location to redirect to after successful login.'
              schema:
                type: string

  /logout:
    post:
      operationId: R103
      summary: 'R103: Logout Action'
      description: 'Logout the current authenticated user. Access: USR, ADM'
      tags:
        - 'M01: Authentication and Individual Profile'
      responses:
        '302':
          description: 'Redirect after processing logout.'
          content:
            'text/plain':
              schema:
                type: string
          headers:
            Location:
              description: 'Location to redirect to after successful logout.'
              schema:
                type: string

  /register:
    get:
      operationId: R104
      summary: 'R104: Register Form'
      description: 'Provide new user registration form. Access: PUB'
      tags:
        - 'M01: Authentication and Individual Profile'
      responses:
        '200':
          description: 'Ok. Show sign-up UI'

    post:
      operationId: R105
      summary: 'R105: Register Action'
      description: 'Processes the new user registration form submission. Access: PUB'
      tags:
        - 'M01: Authentication and Individual Profile'
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                name:
                  type: string
                username:
                  type: string
                email:
                  type: string
                  format: email
                profile_image:
                  type: string
                password:
                  type: string
                  format: password
                confirm_password:
                  type: string
                  format: password
              required:
                - name
                - username
                - email
                - password
      responses:
        '302':
          description: 'Redirect after processing the new user information.'
          content:
            'text/plain':
              schema:
                type: string
          headers:
            Location:
              description: 'Location to redirect to after successful registration.'
              schema:
                type: string


  /user/{id}:
    get:
      operationId: R106
      summary: 'R106: View user profile'
      description: 'Show the individual user profile. Access: USR'
      tags:
        - 'M01: Authentication and Individual Profile'
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'Ok. Show view profile UI'

  /user/edit:
    get:
      operationId: R107
      summary: 'R107: Edit user profile form'
      description: 'Show the individual user profile edit form. Access: OWN'
      tags:
        - 'M01: Authentication and Individual Profile'

      responses:
        '200':
          description: 'Ok. Show edit profile UI'
          content:
            'application/json':
              schema:
                type: object
                properties:
                  username:
                    type: string
                  email:
                    type: string
                    format: email
                  old_password:
                    type: string
                    format: password
                  new_password:
                    type: string
                    format: password
                  profile_image:
                    type: string
                    format: binary

    post:
      operationId: R108
      summary: 'R108: Edit user profile action'
      description: 'Edit user profile. Access: OWN'
      tags:
        - 'M01: Authentication and Individual Profile'
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                input_name:
                  type: string
                input_email:
                  type: string
                  format: email
                input_picture:
                  type: string  
                input_old_password:
                  type: string
                  format: password
                input_new_password:
                  type: string
                  format: password
      responses:
        '302':
          description: 'Redirect after processing the new user information.'
          content:
            'text/plain':
              schema:
                type: string
          headers:
            Location:
              description: 'Location to redirect to after processing user information.'
              schema:
                type: string

  /project/{id}:
    get:
      operationId: R201
      summary: 'R201: See project page'
      description: 'See the project page and all its information. Access: MEM'
      tags:
        - 'M02: Projects'
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
      responses:
        '200':
          description: 'Ok. Show project page UI'
          content:
            application/json:
              schema:
                type: object
                properties:
                  name:
                    type: string
                  members:
                    type: array
                    items:
                      $ref: '#/components/schemas/User'
                  tasks:
                    type: array
                    items:
                      $ref: '#/components/schemas/Task'
        '403':
          description: 'Forbidden'
        '404':
          description: 'Not Found'

  /project/create:
    get:
      operationId: R202
      summary: 'R202: Create New Project Form'
      description: 'Create New Project. Access: USR'
      tags:
        - 'M02: Projects'
      responses:
        '200':
          description: 'Ok. Show creation project UI'
          content:
            application/json:
              schema:
                type: object
                properties:
                  company:
                    type: string

    post:
      operationId: R203
      summary: 'R203: Create New Project Action'
      description: 'Create New Project. Access: USR'
      tags:
        - 'M02: Projects'
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                inputName:
                  type: string
                inputCompanyID:
                  type: integer
                inputDescription:
                  type: string
                inputAssignedMembers:
                  type: string
      responses:
        '302':
          description: 'Redirect after processing the project information.'
          content:
            'text/plain':
              schema:
                type: string
          headers:
            Location:
              description: 'Location to redirect to after processing project information.'
              schema:
                type: string


  /user/{id}/projects:
    get:
      operationId: R204
      summary: 'R204: View Projects of the user'
      description: 'Show the projects of the user. Access: USR'
      tags:
        - 'M02: Projects'
      
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
          
      responses:
        '200':
          description: 'Ok. Show creation project UI'
          content:
             application/json:
              schema:
                type: object
                properties:
                  name:
                    type: string
                  projects:
                    type: array
                    items:
                      $ref: '#/components/schemas/Project'


  /project/{id}/task/{task_id}:
    get:
      operationId: R205
      summary: 'R205: Get Task'
      description: 'Get the task information in JSON. Access: MEM'
      tags:
        - 'M02: Projects'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
        - in: path
          name: task_id
          schema:
            type: integer
          required: true

      responses:
        '200':
          description: 'Success'
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/Task'
        '403':
          description: 'Forbidden'
        '404':
          description: 'Not Found'

    patch:
      operationId: R206
      summary: 'R206: Update Task'
      description: 'Processes the task settings form submission. Access: MEM'
      tags:
        - 'M02: Projects'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
        - in: path
          name: task_id
          schema:
            type: integer
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                name:
                  type: string
                description:
                  type: string
                due_date:
                  type: integer
                status:
                  type: string
                  enum: ['To-do', 'In Progress', 'Completed']

      responses:
        '200':
          description: 'Success'
        '403':
          description: 'Forbidden'
        '404':
          description: 'Not Found'
          
    
    post:
      operationId: R207
      summary: 'R207: Complete an assigned task'
      description: 'Processes the task completion. Access: MEM'
      tags:
        - 'M02: Projects'
      parameters:
        - in: path
          name: id
          required: true
          schema:
            type: integer
          description: ID of the project
        - in: path
          name: task_id
          required: true
          schema:
            type: integer
          description: ID of the task to be completed (e.g., r207)
      responses:
        '200':
          description: Task completed successfully
        '403':
          description: Forbidden. You are not assigned to this task.
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/Task'    


  /user/{id}/tasks:
    get:
      operationId: R208
      summary: 'R208: View Tasks of the user'
      description: 'Show the tasks of the user. Access: USR'
      tags:
        - 'M02: Projects'
      
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
          
      responses:
        '200':
          description: 'Ok. Show creation project UI'
          content:
             application/json:
              schema:
                type: object
                properties:
                  name:
                    type: string
                  tasks:
                    type: array
                    items:
                      $ref: '#/components/schemas/Task'


  /project/{id}/task:
    post:
      operationId: R209
      summary: 'R209: Create Task'
      description: 'Processes the task creation form submission. Access: MEM'
      tags:
        - 'M02: Projects'
        
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
  
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                name:
                  type: string
                description:
                  type: string
                due_date:
                  type: integer
                status:
                  type: string
                  enum: ['To-do', 'In Progress', 'Completed']
                priority:
                  type: string
                  enum: ['Low', 'Medium', 'High']
              required:
                - name, due_date
  
      responses:
        '302':
          description: 'Redirect after processing the new task information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful creation. Redirect to task card.'
                  value: '/project/{id}'
                302Failure:
                  description: 'Failed creation. Redirect to project dashboard.'
                  value: '/project/{id}'
        '400':
          description: Bad Request
        "403":
          description: Forbidden
        "404":
          description: Not Found
          
          
    
  /projects/{proj_id}/add-user/{user_id}:
   post:
    operationId: R210
    summary: 'R210: Add User to a Project'
    description: 'Adds a user to a project. Accessible only by the project coordinator. Access: PCO'
    tags: 
    - 'M02: Projects'
    parameters:
      - name: proj_id
        in: path
        description: ID of the project
        required: true
        schema:
          type: integer
      - name: user_id
        in: path
        description: ID of the user to be added to the project
        required: true
        schema:
          type: integer
    responses:
      '200':
        description: Successful operation
        content:
          application/json:
            schema:
              $ref: '#/components/schemas/Project'
      '403':
        description: Forbidden. You are not the coordinator of this project.
  
  
  /admin/users/search:
    get:
      operationId: R301
      summary: 'R301: Search User Accounts (Admin)'
      description: 'Search for user accounts. Access: ADM'
      tags:
        - 'M03: Administrator'
      parameters:
        - in: query
          name: search_query
          schema:
            type: string
          description: 'Search query for user accounts. Use "exact:{name,email or id}" for exact-match search, or simply provide a full-text search query.'
          required: true

      responses:
        '200':
          description: 'Ok. Show search results'
          content:
            application/json:
              schema:
                type: object
                properties:
                  results:
                    type: array
                    items:
                      $ref: '#/components/schemas/User'
              example:
                results:
                  - name: 'John Doe'
                    email: 'john.doe@example.com'
                    profile_description: 'A description of John Doe'
                    profile_image: 'john_doe.jpg'
                  - name: 'Jane Smith'
                    email: 'jane.smith@example.com'
                    profile_description: 'A description of Jane Smith'
                    profile_image: 'jane_smith.jpg'
        '400':
          description: 'Bad Request'
        '403':
          description: 'Forbidden. Only administrators have access to this operation.'
        '404':
          description: 'No user accounts found matching the search criteria'
  
  /admin/users/{userId}:
    get:
      summary: 'R302: Get User Details (Admin View)'
      description: 'Retrieve details of a user for admin viewing.  Acess: ADM'
      tags:
        - 'M03: Administrator'
      parameters:
        - in: path
          name: userId
          required: true
          schema:
            type: integer
          description: 'ID of the user to retrieve.'
      responses:
        '200':
          description: 'OK. Show user details.'
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/User'
        '404':
          description: 'Not Found. User not found.'

  /admin/users/{userId}/edit:
    get:
      summary: 'R303: Show User Edit Page (Admin)'
      description: 'Show the edit page of a user account as an admin. Access: ADM'
      tags:
        - 'M03: Administrator'
      parameters:
        - in: path
          name: userId
          required: true
          schema:
            type: integer
          description: 'ID of the user to edit.'
      responses:
        '200':
          description: 'OK. Show the user edit page.'
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/User'
        '403':
          description: 'Forbidden. Only administrators have access to this operation.'
        '404':
          description: 'Not Found. User not found.'

    patch:
      summary: 'R304: Update User Profile (Admin)'
      description: 'Update the profile of a user. Access: ADM'
      tags:
        - 'M03: Administrator'
      parameters:
        - in: path
          name: userId
          required: true
          schema:
            type: integer
          description: 'ID of the user to edit.'
      requestBody: 
        description: 'Partial update to user profile information.'
        required: true
        content:
          application/json:
            schema:
              $ref: '#/components/schemas/User'
      responses:
        '200':
          description: 'OK. User profile patched successfully.'
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/User'
        '400':
          description: 'Bad Request. Invalid request data.'
        '403':
          description: 'Forbidden. Only administrators have access to this operation.'
        '404':
          description: 'Not Found. User not found.'
          
  /admin/users/{userId}/delete:
    delete:
      summary: 'R305: Delete User Account (Admin)'
      description: 'Delete a user account. Access: ADM'
      tags:
        - 'M03: Administrator'
      parameters:
        - in: path
          name: userId
          required: true
          schema:
            type: integer
          description: 'ID of the user to delete.'
      responses:
        '200':
          description: 'OK. User account deleted successfully.'
        '403':
          description: 'Forbidden. Only administrators have access to this operation.'
        '404':
          description: 'Not Found. User not found.'
          
          
  /search:
    get:
      operationId: R401
      summary: 'R401: General Search'
      description: 'Perform a search across all entities. Access: PUB'
      tags:
        - 'M04: Search'
      parameters:
        - in: query
          name: search_query
          schema:
            type: string
          description: 'Search query. Use "exact:{entity_name}" for an exact-match search, or simply provide a full-text search query.'
          required: true

      responses:
        '200':
          description: 'Ok. Show search results'
          content:
            application/json:
              schema:
                type: object
                properties:
                  results:
                    type: array
                    items:
                      anyOf:
                        - $ref: '#/components/schemas/User'
                        - $ref: '#/components/schemas/Task'
                        - $ref: '#/components/schemas/Project'
        '400':
          description: 'Bad Request'
        '403':
          description: 'Forbidden'
        '404':
          description: 'No entities found matching the search query'

  /tasks:
    get:
      operationId: R402
      summary: 'R402: Search tasks'
      description: 'Search tasks, filtering them. Access: MEM'
      tags:
      - 'M04: Search'
      parameters:
        - name: nameFilter
          in: query
          description: Filter tasks by name
          schema:
            type: string
        - name: dateFilter
          in: query
          description: Filter tasks by due date
          schema:
            type: string
            format: date
        - name: statusFilter
          in: query
          description: Filter tasks by status
          schema:
            type: string
        - name: priorityFilter
          in: query
          description: Filter tasks by priority
          schema:
            type: string
      responses:
        '200':
          description: A list of filtered tasks
          content:
            application/json:
              example:
                tasks:
                  - name: Task 1
                    due_date: '2023-01-01'
                    status: 'In Progress'
                    priority: 'High'
                  - name: Task 2
                    due_date: '2023-02-01'
                    status: 'Completed'
                    priority: 'Medium'
                  # Additional tasks...
        '400':
          description: Bad request. Invalid filter parameters.


components:
  schemas:
    User:
      type: object
      properties:
        name:
          type: string
        email:
          type: string
        profile_description:
          type: string
        profile_image:
          type: string

    Task:
      type: object
      properties:
        id:
          type: integer
        name:
          type: string
        description:
          type: string
        due_date:
          type: string
        status:
          type: string
          enum: ['To-do', 'In Progress', 'Completed']
        priority:
          type: string
          enum: ['Low', 'Medium', 'High']
        members:
          type: array
          items:
            $ref: '#/components/schemas/User'
        subtasks:
          type: array
          items:
            $ref: '#/components/schemas/SubTask'
        comments:
          type: array
          items:
            $ref: '#/components/schemas/Comment'
          
          
    Project:
      type: object
      properties:
        id:
          type: integer
        name:
          type: string
        description:
          type: string
        due_date:
          type: string
        is_archived:
          type: boolean
        is_favorite:
          type: boolean
        completion:
          type: number
          format: float
        members:
          type: array
          items:
            $ref: '#/components/schemas/User'
        tasks:
          type: array
          items:
            $ref: '#/components/schemas/Task'
            
           
    SubTask:
      type: object
      properties:
        id:
          type: integer
        name:
          type: string
        description:
          type: string
        status:
          type: string
          enum: ['To-do', 'In Progress', 'Completed']

    Comment:
      type: object
      properties:
        id:
          type: integer
        author:
          $ref: '#/components/schemas/User'
        date:
          type: string
        content:
          type: string
        reply:
          type: integer
```

---

## A8: Vertical prototype

> The Vertical Prototype encompasses the incorporation of high-priority features identified as essential (marked with an asterisk) in both the general and theme requirement documents. Its primary purpose is to validate the presented architecture while also facilitating a better understanding of the technologies employed in the project.
Implemented using the LBAW Framework, this prototype spans all layers of the solution's architecture: user interface, business logic, and data access. It involves the realization of pages for viewing, inserting, editing, and removing information. Additionally, the prototype addresses permission control for accessing these pages.

### 1. Implemented Features

#### 1.1. Implemented User Stories


| User Story reference | Name                   | Priority                   | Description                   |
| -------------------- | ---------------------- | -------------------------- | ----------------------------- |
| US101                 | Sign-up | High | As a Guest, I want to register myself into the system, so that I can access all functionalities of the system. |
| US102                 | Sign-in | High | As a Guest, I want to log in so that I can access my profile. |
| US103                 | See Homepage | High | As a Guest, I want to access the homepage, so that I can be briefly presented to the website. |
| US201                 | Logout | High | As a User, I want to log out of my account so that my profile doesn’t stay open on the website. |
| US202                 | Exact Match Search | High | As a User, I want to be able to write a sequence of characters so that I can search for its exact corresponding results. |
| US203                 | Full-text Search | High | As a User, I want to be able to write a sequence of characters so that I can search for its partial or exact corresponding results. |
| US301                 | Project Creation | High | As an Authenticated User, I want to create a new project, so that I can define goals and assign tasks for a project. |
| US302                 | View my Projects | High | As a User, I want to view my Project details so that I can check: the project description, participants, tasks, and substaks |
| US303                 | View Profile | High | As an Authenticated User, I want to view my profile, so that I can check my statistics and what others can see about me (profile picture, username, ...). |
| US304                 | Edit Profile | High | As an Authenticated User, I want to edit my profile, so that I can update my information. |
| US401                 | Create Task | High | As a Project member, I want to create a task so that I can add a task to a project. |
| US402                 | Manage Tasks | High | As a Project member, I want to manage existing tasks so that I can edit or remove them. |
| US403                 | View Task Details | High | As a Project member, I want to select the tasks’ details option so that I can visualize them. |
| US404                 | Complete an Assigned Task | High | As a Project member, I want to select the completion option in a task so that I can confirm its success. |
| US405                 | Search Tasks | High | As a Project member, I want to be able to write a sequence of characters so that I can find the existing tasks that match my intended search. |
| US501                 | Add User to Project | High | As a Project Coordinator, I want to be able to add a user to a project so that they can become a valuable member of the project team and contribute to its success. |
| US603                 | Administer User Accounts | High | As an Administrator, I want the ability to manage user accounts effectively, including searching for users, viewing their profiles, editing user details, and creating new user accounts, to ensure the smooth operation of the system. |


...

#### 1.2. Implemented Web Resources


> Module M01: Authentication and Individual Profile

| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R101: Login Form | GET /login  |
| R102: Login Action | POST /login  |
| R103: Logout Action | POST /logout |
| R104: Register Form | GET /register |
| R105: Register Action | POST /register |
| R106: View User Profile | GET /user/{id} |
| R107: Edit User Profile Form | GET /user/edit |
| R108: Edit User Profile Action | POST /user/edit |

> Module M02: Projects

| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R201: See Project Page | GET /project/{id} |
| R202: Create New Project Form | GET /project/create |
| R203: Create New Project Action | POST /project/create |
| R204: View Projects of the User | GET /user/{id}/projects |
| R205: Get Task | GET project/{id}/task/{task_id} |
| R206: Update Task | PATCH project/{id}/task/{task_id} |
| R207: Complete an assigned task | POST project/{id}/task/{task_id}  |
| R208: View Tasks of the User | GET /user/{id}/tasks |
| R209: Create Task | POST /project/{id}/task|
| R210: Add User to a Projects | POST /projects/{proj_id}/add-user/{user_id}|

> Module M03: Administrator

| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R301: Search User Accounts | GET /admin/users/search|
| R302: Get User Details | GET /admin/users/{userId}|
| R303: Show User Edit Page | GET /admin/users/{userId}/edit |
| R304: Update User Profile | PATCH /admin/users/{userId}/edit |
| R305: Delete User Account | DELETE /admin/users/{userId}/delete |

> Module M04: Search

| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R401: General Search | GET /search|
| R402: Search Tasks | GET /tasks |

### 2. Prototype

The prototype is available at http://lbaw23132.lbaw.fe.up.pt

Credentials:
   - admin user: admin@example.com
    password: 1234
    
   - regular user: mariadoe@example.com
   password: 1234

---


## Revision history

Changes to be made:
- During the implementation of A7 and A8, we identified an inconsistency in A2. It turns out that some user stories were assigned incorrect priorities. Our approach in tackling the high-priority tasks was guided by both general and specific requirements. Consequently, we've recognized the need for adjustments in A2 to align it accurately with our ongoing work in A7 and A8. We appreciate your understanding as we swiftly address and update A2 to maintain coherence across the project.
