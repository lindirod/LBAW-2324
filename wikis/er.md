# ER: Requirements Specification Component

> To redefine project management, with ProPlanner we envision a platform where project teams thrive through efficient planning, active communication, and remote collaboration. The primary goal of our project is to empower organizations to achieve their project goals with ease and precision.

## A1: ProPlanner

The ProPlanner platform is being developed by a dedicated group of students as a web-based information system for project management.
With the increasing emergence of fast-paced environments, from business to educational contexts, effective project management is crucial.
Companies require time-saving solutions to develop their products, while educators seek to bridge the gap between theory and practice in project management. Thus, we propose ProPlanner as a system able to bring project planning, active communication, and remote collaboration under one roof.

#### Main Features

This platform will allow users not only to create projects and their respective teams but also to define tasks, allowing strict role definitions for each team member.
Its intuitive design will make it easy to search and filter tasks according to their priority and date, ensuring a reduction in access time among the numerous tasks a project consists of.
Projects will dispose of forums, enabling communication among team members, receiving constant feedback from members and their coordinators, and promoting the sharing of useful resources concerning the project. A notification system is also included. Users are notified whenever a task is assigned to them or is already completed, an invitation to collaborate is accepted, or a project coordinator is switched.

#### User Profiles

Regarding the users, there are 5 main types: **Guest** users, who are not logged in and have read-only access to the application's functionalities, can receive email invitations with a redirection link to the signup page. After signing up, they become **Authenticated** users, who are allowed to create and view their projects and add them to their favorites list. Once an authenticated user is assigned to a project, they become a **Project Member**. Project members are not restricted to project creation since they can create and manage tasks, comment, and assign users to tasks. The **Project Coordinator** plays a role of higher importance, being responsible for adding and removing project members, editing project details, and archiving them. **Administrators'** accounts are independent of user accounts since they cannot take part in projects and are only allowed to browse and view their details.

---

## A2: Actors and User stories

The main goal of this artefact is to identify and describe the actors that will potentially interact with the system, as well as their user stories.

### 1. Actors

![](https://hackmd.io/_uploads/ByUyO2Kep.png)

Figure 1: Proplanner Actors.

| Identifier          | Description                                                                                                                                                               |
| ------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| User                | A generic term refering to any individual who interacts with the application, encompassing all roles mentioned below based on their level of access and responsibilities. |
| Guest User          | Not logged in user with read-only access to application functionalities. Can receive email invitations for sign-up via redirection links.                                 |
| Authenticated User  | User who has signed up and logged into the application. Can create, view, and favorite their projects. Can be assigned as project members.                                |
| Project Member      | Authenticated user assigned to a project. Can create, manage tasks, comment on project content, and assign users to tasks. Not restricted to project creation.            |
| Project Coordinator | Holds a higher role in project management. Responsible for adding/removing project members. Can edit project details and archive projects.                                |
| Administrator       | Account independent of user accounts. Cannot participate in projects. Limited to browsing and viewing user details.                                                       |
| OAuth API           | External OAuth API that can be used to register or authenticate into the system.                                                                                          |

Table 1: Actors Description.

### 2. User Stories

#### 2.1. Guest

| Identifier | Name                   | Priority | Description                                                                                                                                                                                 |
| ---------- | ---------------------- | -------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| US101      | Sign-up                | High     | As a Guest, I want to register myself into the system, so that I can access all functionalities of the system.                                                                              |
| US102      | Sign-in                | High     | As a Guest, I want to log in so that I can access my profile.                                                                                                                               |
| US103      | See homepage           | High     | As a Guest, I want to access the homepage, so that I can be briefly presented to the website                                                                                                |
| US104      | FAQ                    | High     | As a Guest, I want to access the FAQ, so that I can get quick answers to the common questions                                                                                               |
| US105      | About Us               | High     | As a Guest, I want to access the About Us page, so that I can see detailed description of the website and its creators                                                                      |
| US106      | Contacts               | High     | As a Guest, I want to access the Contacts page, so that I can contact the adminstration team, in case some anomaly happens                                                                  |
| US107      | Email Invitations      | Medium   | As a Guest, I want to receive email invitations with redirection links to the signup page when I'm invited by others so that I can easily create an account and access additional features. |
| US108      | Password Recovery      | Medium   | As a Guest, I want to be able to recover my password so that I can still have access to my account if I forget my current password.                                                         |
| US109      | Sign-up with OAuth API | Low      | As a Guest, I want to register in the website using an external API (e.g. Google, Facebook) so taht I can access all the functionalities available in the platform.                         |
| US110      | Sign-in with OAuth API | Low      | As a Guest, I wanto to log in in the website using an external API (e.g. Google, Facebook), so that I can use the platform with my account                                                  |

Table 2: Guest Stories Description.

#### 2.2. User

| Identifier | Name                                  | Priority | Description                                                                                                                                                                                                                                       |
| ---------- | ------------------------------------- | -------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| US201      | Logout                                | High     | As a User, I want to log out of my account so that my profile doesn’t stay open on the website.                                                                                                                                                  |
| US202      | Exact Match Search                    | High     | As a User, I want to be able to write a sequence of characters so that I can search for its exact corresponding results.                                                                                                                          |
| US203      | Full-text Search                      | High     | As a User, I want to be able to write a sequence of characters so that I can search for its partial or exact corresponding results.                                                                                                               |
| US204      | Email Acceptance                      | Medium   | As a User, I want to accept an invitation so that I can be logged in.                                                                                                                                                                             |
| US205      | Search over Multiple Attributes       | Medium   | As a User, I want to be able to write sequences of characters that cover several fields so that I can search for their corresponding results.                                                                                                     |
| US206      | Search Filters                        | Medium   | As a Use, I want to be able to select filters on the search results so that I can optimize my search.                                                                                                                                             |
| US207      | Seeking Assistance and Help Resources | Medium   | As a User, I want access to helpful resources and assistance within the application so that I can find answers to my questions and efficiently resolve issues.                                                                                    |
| US208      | Seeking Information                   | Medium   | As a User, I want easy access to essential product information, such as details about the platform, key features, and contact information for support so that I can learn more about the website's capabilities for effective project management. |
| US209      | Ordering of Results                   | Low      | As a User, I want to be able to order the search results so that I can optimize my search.                                                                                                                                                        |

Table 3: User Stories Description.

#### 2.3. Authenticated User

| Identifier | Name                        | Priority | Description                                                                                                                                               |
| ---------- | --------------------------- | -------- | --------------------------------------------------------------------------------------------------------------------------------------------------------- |
| US301      | Project Creation            | High     | As an Authenticated User, I want to create a new project, so that I can define goals and assign tasks for a project.                                      |
| US302      | View my Projects            | High     | As a User, I want to view my Project details so that I can check: the project description, participants, tasks, and substaks.                             |
| US303      | View Profile                | High     | As an Authenticated User, I want to view my profile, so that I can check my statistics and what others can see about me (profile picture, username, ...). |
| US304      | Edit Profile                | High     | As an Authenticated User, I want to edit my profile, so that I can update my information.                                                                 |
| US305      | Mark Favorite Projects      | Medium   | As an Authenticated User, I want to select projects as my favorites so that I can have easier access to them.                                             |
| US306      | Profile Picture Support     | Medium   | As an Authenticated User, I want to be able to manage my profile picture so that I can add, remove, or change it.                                         |
| US307      | View Personal Notifications | Medium   | As an Authenticated User, I want to be notified of new updates about the projects that I am enrolled in so that I can keep up with relevant informations  |
| US308      | Reintegration Appeal        | Low      | As an Authenticated User, I want to be able to request a reintegration on the project so that I can be part of it again.                                  |
| US309      | Manage Project Invitation   | Low      | As an Authenticated User, I want to be able to manage my invitations so that I can accept or reject a project invitation.                                 |

Table 4: Authenticated User Stories Description.

#### 2.4. Project Member

| Identifier | Name                             | Priority | Description                                                                                                                                                                                                  |
| ---------- | -------------------------------- | -------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| US401      | Create Task                      | High     | As a Project member, I want to create a task so that I can add a task to a project.                                                                                                                          |
| US402      | Manage Tasks                     | High     | As a Project member, I want to manage existing tasks so that I can edit or remove them.                                                                                                                      |
| US403      | View Task Details                | High     | As a Project member, I want to select the tasks’ details option so that I can visualize them.                                                                                                               |
| US404      | Complete an Assigned Task        | High     | As a Project member, I want to select the completion option in a task so that I can confirm its success.                                                                                                     |
| US405      | Search Tasks                     | High     | As a Project member, I want to be able to write a sequence of characters so that I can find the existing tasks that match my intended search.                                                                |
| US406      | Assign Users to Tasks            | High     | As a Project member,  I want the ability to assign a task to a user so that tasks are distributed and managed efficiently within the project.                                                                |
| US407      | Comment on Task                  | Medium   | As a Project member, I want to be able to write a comment on tasks so that I can express my thoughts on the matter.                                                                                          |
| US408      | Leave Project                    | Medium   | As a Project member, I want to be able to select the leaving option on a project so that I can remove myself from it.                                                                                        |
| US409      | View Project Team                | Medium   | As a Project member, I want to select the team visualization option so that I can check its members.                                                                                                         |
| US410      | View Team Members' Profiles      | Medium   | As a Project member, I want to be able to click on a team member icon so that I can view its profile.                                                                                                        |
| US411      | Notified When Assigned to Task   | Medium   | As a Project member, I want to receive a notification when I am assigned to a task within a project so that I can be promptly informed about my new responsibilities and begin working on the assigned task. |
| US412      | Notified When Task is Completed  | Medium   | As a Project member, I want to receive a notification when a task within a project I am involved in is marked as completed so that I can stay informed about the progress of the project and related tasks.  |
| US413      | View Project Timeline            | Low      | As a Project member, I want to scroll through the Project content so that I can view everything that happened in the project until now.                                                                      |
| US414      | Browse the Project Message Forum | Low      | As a Project member, I want to scroll through the project message forum so that I can view everything that was written in it until now.                                                                      |
| US415      | Post Message Forum               | Low      | As a Project member, I want to be able to write a message on the project forum so that I can share my ideas.                                                                                                 |
| US416      | Edit Post                        | Low      | As a Project member, I want to be able to select the edit post option so that I can edit it.                                                                                                                 |
| US417      | Delete Post                      | Low      | As a Project member, I want to be able to select the delete post option so that I can delete it.                                                                                                             |

Table 5: Project Member Stories Description.

#### 2.5. Project Coordinator

| Identifier | Name                                          | Priority | Description                                                                                                                                                                                                                                      |
| ---------- | --------------------------------------------- | -------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| US501      | Add User to Project                           | High     | As a Project Coordinator, I want to be able to add a user to a project so that they can become a valuable member of the project team and contribute to its success.                                                                              |
| US502      | Assign New Coordinator                        | Medium   | As a Project Coordinator, I want the ability to assign a new Project Coordinator to a project when necessary so that effective project management and leadership can be maintained.                                                              |
| US503      | Edit Project Details                          | Medium   | As a Project Coordinator, I want the ability to edit project details so that the project's information remains accurate and up-to-date.                                                                                                          |
| US504      | Assign Task to Member                         | Medium   | As a Project Coordinator,  I want the ability to assign a task to a project member so that tasks are distributed and managed efficiently within the project.                                                                                     |
| US505      | Remove Project Member                         | Medium   | As a Project Coordinator, I want the ability to remove a project member from a project when necessary so that project integrity and collaboration effectiveness are maintained.                                                                  |
| US506      | Archive Project                               | Medium   | As a Project Coordinator, I want the ability to archive a project when it is completed or no longer active so that a tidy and organized project management environment is maintained.                                                            |
| US507      | Notified When Project Invitation is Accepted  | Medium   | As a Project Coordinator, I want to receive a notification when a user accepts an invitation to join a project managed by me so that I can be informed about new project members and their involvement.                                          |
| US508      | Notified When the Project Coordinator Changes | Medium   | As a Project Coordinator, I want to receive immediate notifications when there is a change in the project coordinator for a specific project so that I can stay informed about leadership transitions and continue effective project management. |
| US509      | Manage Members Permissions                    | Low      | As a Project Coordinator, I want the ability to manage members' permissions within a project so that each project member has the appropriate level of access and responsibilities.                                                               |
| US510      | Invite to Project by Email                    | Low      | As a Project Coordinator, I want the ability to invite users to join a project by sending them email invitations so that we can expand the project team with new members.                                                                        |

Table 6: Project Coordinator Stories Description.

#### 2.6. Administrator

| Identifier | Name                            | Priority | Description                                                                                                                                                                                                                             |
| ---------- | ------------------------------- | -------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| US601      | Browse Projects                 | High     | As an Administrator, I want the ability to browse and view a list of all projects in the system so that I can oversee and manage project-related activities effectively.                                                                |
| US602      | View Project Details            | High     | As an Administrator, I want the ability to view project details for all projects in the system so that I can oversee and manage project-related activities effectively.                                                                 |
| US603      | Administer User Accounts        | High     | As an Administrator, I want the ability to manage user accounts effectively, including searching for users, viewing their profiles, editing user details, and creating new user accounts, to ensure the smooth operation of the system. |
| US604      | Block and Unblock User Accounts | Medium   | As an Administrator, I want the ability to block and unblock user accounts as needed so that security and manage user access are effectively maintained.                                                                                |
| US605      | Delete User Account             | Medium   | As an Administrator, I want the ability to delete a user account when necessary so that  the system maintains accurate user records and security.                                                                                       |

Table 7: Administrator Stories Description.

### 3. Supplementary Requirements

> Section including business rules, technical requirements, and restrictions.
> For each subsection, a table containing identifiers, names, and descriptions for each requirement.

#### 3.1. Business rules

| Identifier | Name                                                                   | Description                                                                                                                |
| ---------- | ---------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------- |
| BR01       | Anonymize Shared User Data Upon Account Deletion                       | When an account is deleted, shared user data such as comments, reviews, and likes will be retained but will be anonymized. |
| BR02       | Isolate Administrator Accounts from Project Creation and Participation | Administrator accounts are separate from user accounts and do not have the capability to create or engage in projects.     |

Table 8: Business Rules Description.

#### 3.2. Technical requirements

| Identifier     | Name                      | Description                                                                                                                                                                                                                                                                                                                                        |
| -------------- | ------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| TR01           | Performance               | To maintain the user's engagement, the system must provide response times of less than 2 seconds.                                                                                                                                                                                                                                                  |
| TR02           | Robustness                | The system should be capable of gracefully handling and sustaining operation in presence of runtime errors.                                                                                                                                                                                                                                        |
| TR03           | Scalability               | The system should be ready to accommodate the increase in both user numbers and their interactions.                                                                                                                                                                                                                                                |
| TR04           | Accessibility             | The system should guarantee universal accessibility to its pages, regardless of users' disabilities or their choice of web browser.                                                                                                                                                                                                                |
| **TR05** | **Portability**     | **The ProPlanner project management website should work on multiple platforms, such as Linux and Mac OS, to accommodate a broad user base effectively. This platform independence will enable a wide user base to easily access and utilize the system for their project management needs, regardless of their preferred operating system.** |
| **TR06** | **Usability**       | **The system should offer a straightforward and user-friendly experience. The ProPlanner project management website is intended for users with varying levels of technical expertise. Therefore, ensuring excellent usability is a critical requirement to accommodate a diverse user base effectively.**                                    |
| **TR07** | **Web Application** | **The ProPlanner project management website should be developed as a web application, incorporating web technologies such as HTML, JavaScript, CSS, and PHP. Enabling universal access without the need for additional software is crucial, achieved through standard web technologies.**                                                    |

Table 9: Technical Requirements Description.

#### 3.3. Restrictions

| Identifier | Name     | Description                                                       |
| ---------- | -------- | ----------------------------------------------------------------- |
| C01        | Deadline | The system should be ready to be used at the end of the semester. |
| C02        | Database | The database should use PostgreSQL                                |

Table 10: Restrictions Description.

---

## A3: Information Architecture

> The Information Architecture artifact aims to identify and describe user requirements ensuring that we capture existing and emerging needs. Furthermore, it acts as a testing ground to preview and validate the user interface of the product in development, allowing efficient design iterations.

### 1. Sitemap

The image below represents the pages ProPlanner is expected to include and how they can be accessed or used. It is a simple design of the process of using the website.

![Figure 2: Sitemap.](https://hackmd.io/_uploads/SJygZjYea.png)
Figure 2: Sitemap.

### 2. Wireframes

A wireframe is a visual guide that represents the skeletal framework of a website. They depict the page layout or arrangement of the website's content, including interface elements and navigational systems, and how they work together.

#### UI01: Guest Homepage

Initial page presented to a Guest, being able to access FAQ, About Us and Contacts pages.
To become authenticated in the system, Login and Register are also presented.
![Guest Homepage](https://hackmd.io/_uploads/SJuq8iKxT.png)

1. Access static pages.
2. Representation of the footer, that will be available in every page.

#### UI02: Authenticated User Profile

When an user is authenticated, this is what we aspire the users profile to look like so that it presentes their statistics and enables access to various functionalities on the website.
![Authenticated User Profile](https://hackmd.io/_uploads/BJWJwjYl6.png)

3. Navigation bar where the users are able to view their notifications, consult static pages such as Contacts, FAQ, About Us and also search for keywords...
4. Breadcrumbs to help the user navigate
5. Buttons for editing the user profile and to view favorite projects
6. Section that includes Tasks and Projects from the user that is current logged-in.

#### UI03: Tasks of an Authenticated User

Detailed view of Tasks, allowing users to sort and filter based on their current interests. Once filter is pressed a vast number of options from Project Name to Progress are displayed on a Side Bar.
![Tasks of an Authenticated user](https://hackmd.io/_uploads/rkBXvjFx6.png)

7. Side bar with access to features like the creation of a new task, see the task list and the forum between project members
8. The side bar also includes a list of projects of the authenticated user
9. In this section, the user can see the properties of the tasks assigned to him and have access to even more details regarding each task
10. Filter that allows users to search for tasks that meet  their current interests

#### UI04: Overview of a Project

In the project overview, users can view the status of the tasks regarding that specific project, inluding the project members.
![Overview of a Project](https://hackmd.io/_uploads/S1FvwiKlT.png)
11. Project Members that belong to the current project. When Person Icon is pressed the user is redirected to the member profile. By clicking on the Add Person Icon project coordinators are able to add members.
12. Status of each task of the project, that includes pending tasks, tasks currently in progress, and tasks that have already been completed. Besides that, the user can see the details of the tasks and the members assigned to them

#### UI05: Creation of New Project

![Creation of New Project](https://hackmd.io/_uploads/BkLluotep.png)
13. By filling all the required fields, users can create new projects, associate team members and tasks.

#### UI06: Creation of New Task

![Creation of New Task](https://hackmd.io/_uploads/ByzL_otlT.png)

14. In this section, users will be able to create new tasks within the project that they are enrolled in, and associate them to project members.

#### Extra: Sign up

![Sign up](https://hackmd.io/_uploads/H1ecOjtla.png)

---

## Revision history

Changes made to the first submission:
1..
