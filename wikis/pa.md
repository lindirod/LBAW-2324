# PA: Product and Presentation

> To redefine project management, with ProPlanner we envision a platform where project teams thrive through efficient planning, active communication, and remote collaboration. The primary goal of our project is to empower organizations to achieve their project goals with ease and precision.

## A9: Product

We created a web-based project management application that encompasses features such as task management and assignment, a notification system, and more. Our application is versatile, catering to users in both professional and personal settings.

### 1. Installation

Docker command to start the image available at the group's GitLab Container Registry using the production database:

```
docker run -it -p 8000:80 --name=lbaw23132 -e DB_DATABASE="lbaw23132" -e DB_SCHEMA="lbaw23132" -e DB_USERNAME="lbaw23132" -e DB_PASSWORD="tAmWyvvh" git.fe.up.pt:5050/lbaw/lbaw2324/lbaw23132
```

### 2. Usage

> URL to the product: [http://lbaw23132.lbaw.fe.up.pt](https://lbaw23132.lbaw.fe.up.pt)

#### 2.1. Administration Credentials

| Email               | Password |
| ------------------- | -------- |
| johndoe@example.com | 1234     |

#### 2.2. User Credentials

| Type                | Email                | Password |
| ------------------- | -------------------- | -------- |
| Project Coordinator | mariadoe@example.com | 1234     |
| Project Member      | anadoe@example.com   | 1234     |

### 3. Application Help

We aimed to develop an application characterized by user-friendly simplicity, incorporating self-explanatory features. Additionally, we prioritized accessibility by ensuring that every input is accompanied by either a placeholder or label, clearly indicating the expected content for each field.

We've included static pages such as "About Us" and "Frequently Asked Questions" to aid new users in navigating the platform. These pages provide insights into the website's functionality and its overarching purpose. Additionally, we've implemented a "Contacts" page, enabling users to easily reach out for assistance with any aspect of the website.

![image](https://hackmd.io/_uploads/HJQ3z6-Pp.png)
Figure 1: ProPlanner FAQ page

![image](https://hackmd.io/_uploads/By2lQaWDp.png)
Figure 2: ProPlanner section of About Us page

![image](https://hackmd.io/_uploads/HyPUX6WPT.png)
Figure 3: ProPlanner section of Contacts page

Through the website we also implemented alert messages that give feedback upon a certain action as well as giving the user a change to not go through with the action chosen.

![image](https://hackmd.io/_uploads/ry62NTbDa.png)
Figure 4: ProPlanner alert for user to confirm action

![image](https://hackmd.io/_uploads/r1HlBpZD6.png)
Figure 5: ProPlanner alert that gives the user feedback upon trying to delete profile

![image](https://hackmd.io/_uploads/SJVSHT-P6.png)
Figure 6: ProPlanner alert that gives feedback upon deleting profile

### 4. Input Validation

The input data is validated in both the server and the client-side. For instance, during the creation of a project or a task, client-side validation is applied to the due date, restricting users from selecting a date beyond the present day. Additionally, it ensures that users cannot create a task with an empty title.

### 5. Check Accessibility and Usability

The checklists for both [Accessibility](https://git.fe.up.pt/lbaw/lbaw2324/lbaw23132/-/blob/main/validation/SapoUX/Checklist%20de%20Acessibilidade%20-%20SAPO%20UX.pdf) and [Usability](https://git.fe.up.pt/lbaw/lbaw2324/lbaw23132/-/blob/main/validation/SapoUX/Checklist%20de%20Usabilidade%20-%20SAPO%20UX.pdf) can be accessed by clicking the provided links.

### 6. HTML & CSS Validation

The validation for both [HTML](https://git.fe.up.pt/lbaw/lbaw2324/lbaw23132/-/tree/main/validation/HTML) and [CSS](https://git.fe.up.pt/lbaw/lbaw2324/lbaw23132/-/tree/main/validation/CSS) can be accessed by clicking the provided links.

### 7. Revisions to the Project

#### 7.1 Project Invitation

Initially, we had envisioned invitations via email to be intended for Guests or current platform users, so they could collaborate on a project. However, we chose to restrict this invitation only to ProPlanner users. When notified via email, the user can accept the invitation through the provided link. If, on the other hand, they do not wish to participate in the project, they simply need to ignore the invitation, which has a limited validity period.

#### 7.2 Static Pages and Notifications Model

We believe that, for a better distinction of the existing components, it would make sense to create modules corresponding to Static Pages and Notifications.

- M05: Static Pages
- M06: Notifications

#### 7.3 Changes made to the database

##### 7.3.1 Table password_reset_token

There was a need to set up a table that could store a token and tie it to the user's email, facilitating the receipt of a link to restore the password.

##### 7.3.2 Deletion of table Administrator

Initially, we modeled the system, incorporating a table for administrators, as they perform distinct functions from regular users. However, we found that their differentiation could be achieved more easily through a boolean 'is_admin'.

##### 7.3.3 Tables favorite and archive

Given the identification of an error in the mapping of the relationships between favorites and archived items, two tables were created.

### 8. Implementation Details

#### 8.1. Libraries Used

The only library we used was FontAwesome, to use icons in our project.

#### 8.2 User Stories

| US Identifier | Name                                          | Module   | Priority | Team Members                 | State |
| ------------- | --------------------------------------------- | -------- | -------- | ---------------------------- | ----- |
| US101         | Sign-up                                       | Module 1 | High     | Inês, Linda, Gustavo, Luís | 100%  |
| US102         | Sign-in                                       | Module 1 | High     | Inês, Linda, Gustavo, Luís | 100%  |
| US103         | See Homepage                                  | Module 5 | High     | Inês                        | 100%  |
| US104         | FAQ                                           | Module 5 | Medium   | Inês                        | 100%  |
| US105         | About Us                                      | Module 5 | Medium   | Linda                        | 100%  |
| US106         | Contacts                                      | Module 5 | Medium   | Linda, Inês                 | 100%  |
| US107         | Email Invitations                             | Module 1 | Medium   | Linda, Inês                 | 100%  |
| US108         | Password Recovery                             | Module 1 | Medium   | Inês                        | 100%  |
| US111         | Delete Account                                | Module 1 | Medium   | Luís                        | 100%  |
| US201         | Logout                                        | Module 1 | High     | Inês, Linda, Gustavo, Luís | 100%  |
| US202         | Exact Match Search                            | Module 4 | High     | Luís                        | 100%  |
| US203         | Full Text Search                              | Module 4 | High     | Luís                        | 100%  |
| US204         | Email Acceptance                              | Module 1 | Medium   | Inês, Linda                 | 100%  |
| US205         | Search Over Multiple Attributes               | Module 4 | Medium   | Inês, Linda, Luís          | 100%  |
| US206         | Search Filters                                | Module 4 | Medium   | Luís                        | 100%  |
| US207         | Seeking Assistance and Help Resources         | Module 5 | Medium   | Inês, Linda                 | 100%  |
| US208         | Seeking Information                           | Module 5 | Medium   | Inês, Linda                 | 100%  |
| US209         | Ordering of Results                           | Module 4 | Low      | Luís                        | 100%  |
| US301         | Project Creation                              | Module 2 | High     | Linda                        | 100%  |
| US302         | View my Projects                              | Module 2 | High     | Linda                        | 100%  |
| US303         | View Profile                                  | Module 1 | High     | Inês                        | 100%  |
| US304         | Edit Profile                                  | Module 1 | High     | Luís                        | 100%  |
| US305         | Mark Favorite Projects                        | Module 2 | High     | Inês                        | 100%  |
| US306         | Profile Picture Support                       | Module 1 | Medium   | Linda                        | 100%  |
| US307         | View Personal Notifications                   | Module 6 | Medium   | Luís                        | 100%  |
| US308         | Manage Project Invitation                     | Module 1 | Low      | Inês, Linda                 | 100%  |
| US401         | Create Task                                   | Module 2 | High     | Inês                        | 100%  |
| US402         | Manage Tasks                                  | Module 2 | High     | Inês, Linda                 | 100%  |
| US403         | View Task Details                             | Module 2 | High     | Linda                        | 100%  |
| US404         | Complete an Assigned Task                     | Module 2 | High     | Linda                        | 100%  |
| US405         | Search Tasks                                  | Module 4 | High     | Luís                        | 100%  |
| US406         | Assign Users to Tasks                         | Module 2 | High     | Inês                        | 100%  |
| US407         | Comment on Task                               | Module 2 | Medium   | Linda, Inês                 | 100%  |
| US408         | Leave Project                                 | Module 2 | Medium   | Linda                        | 100%  |
| US409         | View Project Team                             | Module 2 | Medium   | Linda                        | 100%  |
| US410         | View Team Members Profile                     | Module 2 | Medium   | Inês                        | 100%  |
| US411         | Notified when Assigned to Task                | Module 6 | Medium   | Luís                        | 100%  |
| US412         | Notified when Task is Completed               | Module 6 | Medium   | Luís                        | 100%  |
| US501         | Add User to Project                           | Module 2 | High     | Inês                        | 100%  |
| US502         | Assign New Coordinator                        | Module 2 | Medium   | Linda                        | 100%  |
| US503         | Edit Project Details                          | Module 2 | Medium   | Inês                        | 100%  |
| US504         | Assign Task to Member                         | Module 2 | Medium   | Inês                        | 100%  |
| US505         | Remove Project Member                         | Module 2 | Medium   | Linda                        | 100%  |
| US506         | Archive Project                               | Module 2 | Medium   | Inês                        | 100%  |
| US507         | Notified when Project Invitation is Accepted  | Module 6 | Medium   | Luís                        | 100%  |
| US508         | Notified when the Project Coordinator Changes | Module 6 | Medium   | Luís                        | 100%  |
| US509         | Manage Members Permissions                    | Module 2 | Low      | Inês, Linda                 | 100%  |
| US601         | Browse Projects                               | Module 3 | High     | Gustavo                      | 100%  |
| US602         | View Project Details                          | Module 3 | High     | Gustavo                      | 100%  |
| US603         | Administer User Accounts                      | Module 3 | High     | Gustavo                      | 100%  |
| US604         | Block and Unblock User Accounts               | Module 3 | Medium   | Gustavo                      | 100%  |
| US605         | Delete User Account                           | Module 3 | Medium   | Gustavo                      | 100%  |

---

## A10: Presentation

### 1. Product presentation

 We built a Project Management platform, the ProPlanner, where a user can authenticate and is then able to be a part of projects or create a brand new one!
 Each project will be overseen by a coordinator and will be composed by a team of project members that will have tasks assigned to them in order to complete them and therefore finish the project itself.

URL to the product: https://lbaw23132.lbaw.fe.up.pt/

---

## Revision history

Changes made to the first submission:

1. Item 1
2. ..
