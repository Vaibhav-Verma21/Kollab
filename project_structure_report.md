# Laravel Project Structure Report

## 1. Page Mapping

Page Name: Landing Page
URL: /
Blade File: resources/views/welcome.blade.php
Controller: None (Closure)
Controller Method: None
Purpose: Landing page for the application

Page Name: Dashboard Page
URL: /dashboard
Blade File: resources/views/dashboard.blade.php
Controller: None (Closure)
Controller Method: None
Purpose: User dashboard

Page Name: Catalog Page
URL: /catalog
Blade File: resources/views/catalog.blade.php
Controller: app/Http/Controllers/CourseController.php
Controller Method: index
Purpose: Display all available courses

Page Name: My Courses Page
URL: /my-courses
Blade File: resources/views/my-courses.blade.php
Controller: app/Http/Controllers/CourseController.php
Controller Method: myEnrolled
Purpose: View courses the user is enrolled in

Page Name: Course Details Page
URL: /course/{slug}
Blade File: resources/views/course.blade.php
Controller: app/Http/Controllers/CourseController.php
Controller Method: show
Purpose: View a specific course's details

Page Name: Workspace / Whiteboard Page
URL: /workspace
Blade File: resources/views/workspace.blade.php
Controller: app/Http/Controllers/WorkspaceController.php
Controller Method: index
Purpose: Collaborative workspace, whiteboard, and notes

Page Name: Forum Page
URL: /forum
Blade File: resources/views/forum.blade.php
Controller: app/Http/Controllers/ForumController.php
Controller Method: index
Purpose: Community forum

Page Name: Assignment Page
URL: /assignment
Blade File: resources/views/assignment.blade.php
Controller: None (Closure)
Controller Method: None
Purpose: View assignments


## 2. Authentication Mapping

Login:
Routes: /login
Controller: app/Http/Controllers/Auth/AuthenticatedSessionController.php
Methods: create, store
Views: resources/views/auth/login.blade.php
Middleware: guest
User model: app/Models/User.php

Register:
Routes: /register
Controller: app/Http/Controllers/Auth/RegisteredUserController.php
Methods: create, store
Views: resources/views/auth/register.blade.php

Logout:
Routes: /logout
Methods: destroy


## 3. Database Mapping

MongoDB connection:
.env: DB_CONNECTION=mongodb, DB_URI="mongodb+srv://..."
config/database.php: connections.mongodb

Package used: mongodb/laravel-mongodb

Collections:

Collection: users
Model: app/Models/User.php
Controller: Auth controllers, ProfileController
Pages using it: Login, Register, Profile, Dashboard

Collection: courses
Model: app/Models/Course.php
Controller: CourseController, EnrollmentController
Pages using it: Catalog, My Courses, Course Details

Collection: notes
Model: app/Models/Note.php
Controller: NoteController
Pages using it: Workspace

Collection: forum_threads
Model: app/Models/ForumThread.php
Controller: ForumController
Pages using it: Forum

Collection: forum_replies
Model: app/Models/ForumReply.php
Controller: ForumController
Pages using it: Forum

Collection: chat_messages
Model: app/Models/ChatMessage.php
Controller: WorkspaceController
Pages using it: Workspace

Collection: whiteboard_actions
Model: app/Models/WhiteboardAction.php
Controller: WorkspaceController
Pages using it: Workspace

Collection: whiteboard_users
Model: app/Models/WhiteboardUser.php
Controller: WorkspaceController
Pages using it: Workspace


## 4. Model Mapping

Model: User
File path: app/Models/User.php
Collection: users
Used by: Authentication, Profiles, Enrollments
Controller: Auth Controllers, ProfileController

Model: Course
File path: app/Models/Course.php
Collection: courses
Used by: Course listings, Enrollments
Controller: CourseController, EnrollmentController

Model: Note
File path: app/Models/Note.php
Collection: notes
Used by: Saving user notes
Controller: NoteController

Model: ForumThread
File path: app/Models/ForumThread.php
Collection: forum_threads
Used by: Forum threads
Controller: ForumController

Model: ForumReply
File path: app/Models/ForumReply.php
Collection: forum_replies
Used by: Replies to forum threads
Controller: ForumController

Model: ChatMessage
File path: app/Models/ChatMessage.php
Collection: chat_messages
Used by: Real-time chat
Controller: WorkspaceController

Model: WhiteboardAction
File path: app/Models/WhiteboardAction.php
Collection: whiteboard_actions
Used by: Collaborative whiteboard drawing
Controller: WorkspaceController

Model: WhiteboardUser
File path: app/Models/WhiteboardUser.php
Collection: whiteboard_users
Used by: Tracking users on the whiteboard
Controller: WorkspaceController


## 5. Route Mapping

Route URL: /
Route file: routes/web.php
Controller: None
Method: None
Blade returned: welcome.blade.php

Route URL: /dashboard
Route file: routes/web.php
Controller: None
Method: None
Blade returned: dashboard.blade.php

Route URL: /catalog
Route file: routes/web.php
Controller: CourseController
Method: index
Blade returned: catalog.blade.php

Route URL: /my-courses
Route file: routes/web.php
Controller: CourseController
Method: myEnrolled
Blade returned: my-courses.blade.php

Route URL: /course/{slug}
Route file: routes/web.php
Controller: CourseController
Method: show
Blade returned: course.blade.php

Route URL: /workspace
Route file: routes/web.php
Controller: WorkspaceController
Method: index
Blade returned: workspace.blade.php

Route URL: /forum
Route file: routes/web.php
Controller: ForumController
Method: index
Blade returned: forum.blade.php

Route URL: /assignment
Route file: routes/web.php
Controller: None
Method: None
Blade returned: assignment.blade.php

Route URL: /login
Route file: routes/auth.php
Controller: AuthenticatedSessionController
Method: create / store
Blade returned: auth/login.blade.php

Route URL: /register
Route file: routes/auth.php
Controller: RegisteredUserController
Method: create / store
Blade returned: auth/register.blade.php


## 6. Feature Mapping

Courses:
Files used: routes/web.php, app/Http/Controllers/CourseController.php, app/Models/Course.php
Controller: CourseController, EnrollmentController
Views: catalog.blade.php, my-courses.blade.php, course.blade.php
Database collection: courses

Notes:
Files used: routes/web.php, app/Http/Controllers/NoteController.php, app/Models/Note.php
Controller: NoteController
Views: workspace.blade.php
Database collection: notes

Chat:
Files used: app/Models/ChatMessage.php
Controller: WorkspaceController
Views: workspace.blade.php
Database collection: chat_messages

Whiteboard:
Files used: routes/web.php, app/Http/Controllers/WorkspaceController.php, app/Models/WhiteboardAction.php, app/Models/WhiteboardUser.php
Controller: WorkspaceController
Views: workspace.blade.php
Database collection: whiteboard_actions, whiteboard_users


## 7. Important Project Files

File path: routes/web.php
Purpose: Defines the web routes for the application

File path: routes/api.php
Purpose: Defines the API routes for the application

File path: routes/auth.php
Purpose: Defines the authentication routes

File path: config/database.php
Purpose: Database configuration, including MongoDB setup

File path: app/Models/*
Purpose: Eloquent models that map to MongoDB collections

File path: app/Http/Controllers/*
Purpose: Controllers to handle application logic for pages and APIs

File path: resources/views/*
Purpose: Blade templates for the frontend UI

File path: .env
Purpose: Environment variables, including MongoDB URI and database name
