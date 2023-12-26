# EBD: Database Specification Component

> To redefine project management, with ProPlanner we envision a platform where project teams thrive through efficient planning, active communication, and remote collaboration. The primary goal of our project is to empower organizations to achieve their project goals with ease and precision.

## A4: Conceptual Data Model

 The Conceptual Data Model aims to identify and represent the key entities and relationships within a database using a UML class diagram.

### 1. Class diagram

![uml.drawio](uploads/a58819e98e369117195317d9d823b994/uml.drawio.png)
Figure 1: UML Class Diagram of ProPlanner.

### 2. Additional Business Rules

- Tasks can only be assigned to members of the project they belong to.
- A task's due date must be equal or lesser than the due date of the project it is a part of.
- Only team members of a project can comment on said project's tasks.

---

## A5: Relational Schema, validation and schema refinement

This artifact presents the Relational Schema, derived from the Conceptual Data Model. It encompasses details for each relational table, including attributes, domains, keys, and constraints.

### 1. Relational Schema

| Relation reference | Relation Compact Notation                                                                                                                                                                                                                                                                          |
| ------------------ | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| R01                | Project(`<ins>`proj_id`</ins>`, name **NN**, description **NN**, due_date **NN** CK due_date >= today, is_archived **DF** FALSE, comp_id → Company, coord_id → Authenticated_user, is_favorite **DF** FALSE, percentageCompleted)                              |
| R02                | Authenticated_user(`<ins>`user_id`</ins>`, name **NN**, email **UK NN**, username **UK NN**, password **NN**, profile_image, projects_in_progress **DF** 0, projects_completed **DF** 0, tasks_in_progress **DF** 0, tasks_completed **DF** 0) |
| R03                | Administrator(`<ins>`admin_id`</ins>`, name **NN**, email **UK NN**, password **UK NN**, username **NN**)                                                                                                                                                              |
| R04                | Project_member(`<ins>`proj_id`</ins>` → Project, `<ins>`user_id`</ins>` → Authenticated_user)                                                                                                                                                                                            |
| R05                | Task(`<ins>`task_id`</ins>`, name **NN**, description, due_date **NN CK** due_date >= today, status **NN CK** status IN status_task **DF** 'To Do', priority **NN CK** priority in priority_task, proj_id → Project, assigned_member → Project_member)         |
| R06                | Subtask(`<ins>`subtask_id`</ins>`, name **NN**, description, status **NN CK** status IN status_task **DF** 'To Do', task_id → Task)                                                                                                                                         |
| R07                | Company(`<ins>`comp_id`</ins>`, name **NN**, admin_id →  Administrator)                                                                                                                                                                                                                 |
| R08                | Invitation(`<ins>`user_id`</ins>` → Authenticated_user, proj_id → Project, coord_id → Authenticated_user, approved **DF** FALSE)                                                                                                                                                      |
| R09                | Post(`<ins>`post_id`</ins>`, date **NN**, content **NN**, assigned_member → Project_member, proj_id → Project)                                                                                                                                                                   |
| R10                | Employee(`<ins>`comp_id`</ins>` → Company, `<ins>`user_id`</ins>` → Authenticated_user)                                                                                                                                                                                                  |
| R11                | Comment(`<ins>`comment_id`</ins>`, date **NN**, content **NN**, task_id → Task, assigned_member → Project_member, `<ins>`reply`</ins>` → Comment)                                                                                                                           |
| R12                | Notification(`<ins>`notif_id`</ins>`, date **NN**, content **NN**)                                                                                                                                                                                                                 |
| R13                | Project_notification(`<ins>`notif_id`</ins>` → Notification **NN**, proj_id → Project **NN**)                                                                                                                                                                                    |
| R14                | Assignment_notification(`<ins>`notif_id`</ins>` → Notification **NN**, task_id → Task **NN**)                                                                                                                                                                                    |
| R15                | Comment_notification(`<ins>`notif_id`</ins>` → Notification **NN**, comment_id → Comment **NN**)                                                                                                                                                                                 |

Legend:

- UK = UNIQUE;
- NN = NOT NULL;
- DF = DEFAULT;
- CK = CHECK;
- 

### 2. Domains

Specification of additional domains:

| Domain Name   | Domain Specification                      |
| ------------- | ----------------------------------------- |
| Today         | DATE DEFAULT CURRENT_DATE                 |
| priority_task | ENUM ('High', 'Medium', 'Low')            |
| status_task   | ENUM('To-Do', 'In Progress', 'Completed') |

### 3. Schema validation

| **TABLE R01**               | Project                                                                                                      |
| --------------------------------- | ------------------------------------------------------------------------------------------------------------ |
| **Keys**                    | {proj_id}                                                                                                    |
| **Functional Dependencies** |                                                                                                              |
| FD0101                            | {proj_id} → {name, description, due_date, is_archived, comp_id, coord_id, is_favorite, percentageCompleted} |
| **NORMAL FORM**             | BCNF                                                                                                         |

| **TABLE R02**               | Authenticated_user                                                                                                                          |
| --------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------- |
| **Keys**                    | {user_id}, {email}, {username}                                                                                                              |
| **Functional Dependencies** |                                                                                                                                             |
| FD0201                            | {user_id} → {name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed} |
| FD0202                            | {email} → {user_id, name, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed} |
| FD0203                            | {username} → {user_id, name, email, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed} |
| **NORMAL FORM**             | BCNF                                                                                                                                        |

| **TABLE R03**               | Administrator                                            |
| --------------------------------- | -------------------------------------------------------- |
| **Keys**                    | {admin_id}, {email}, {username}                          |
| **Functional Dependencies** |                                                          |
| FD0301                            | {admin_id} → {name, email, password, username, comp_id} |
| FD0302                            | {email} → {admin_id, name, password, username, comp_id} |
| FD0303                            | {username} → {admin_id, name, email, password, comp_id} |
| **NORMAL FORM**             | BCNF                                                     |

| **TABLE R04**               | Project_member     |
| --------------------------------- | ------------------ |
| **Keys**                    | {proj_id, user_id} |
| **Functional Dependencies** | none               |
| **NORMAL FORM**             | BCNF               |

| **TABLE R05**               | Task                                                                                   |
| --------------------------------- | -------------------------------------------------------------------------------------- |
| **Keys**                    | {task_id}                                                                              |
| **Functional Dependencies** |                                                                                        |
| FD0501                            | {task_id} → {name, description, due_date, status, priority, proj_id, assigned_member} |
| **NORMAL FORM**             | BCNF                                                                                   |

| **TABLE R06**               | Subtask                                              |
| --------------------------------- | ---------------------------------------------------- |
| **Keys**                    | {subtask_id}                                         |
| **Functional Dependencies** |                                                      |
| FD0601                            | {subtask_id} → {name, description, task_id, status} |
| **NORMAL FORM**             | BCNF                                                 |

| **TABLE R07**               | Company                       |
| --------------------------------- | ----------------------------- |
| **Keys**                    | {comp_id}                     |
| **Functional Dependencies** |                               |
| FD0701                            | {comp_id} → {name, admin_id} |
| **NORMAL FORM**             | BCNF                          |

| **TABLE R08**               | Invitation                                 |
| --------------------------------- | ------------------------------------------ |
| **Keys**                    | {user_id}                                  |
| **Functional Dependencies** |                                            |
| FD0801                            | {user_id} → {proj_id, coord_id, approved} |
| **NORMAL FORM**             | BCNF                                       |

| **TABLE R09**               | Post                                             |
| --------------------------------- | ------------------------------------------------ |
| **Keys**                    | {post_id}                                        |
| **Functional Dependencies** |                                                  |
| FD0901                            | {post_id} → {date, content, member_id, proj_id} |
| **NORMAL FORM**             | BCNF                                             |

| **TABLE R10**               | Employee           |
| --------------------------------- | ------------------ |
| **Keys**                    | {comp_id, user_id} |
| **Functional Dependencies** | none               |
| **NORMAL FORM**             | BCNF               |

| **TABLE R11**               | Comment                                                   |
| --------------------------------- | --------------------------------------------------------- |
| **Keys**                    | {comment_id, reply}                                       |
| **Functional Dependencies** |                                                           |
| FD1101                            | {comment_id} → {date, content, task_id, assigned_member} |
| FD1102                            | {reply} → {date, content, task_id, assigned_member}      |
| **NORMAL FORM**             | BCNF                                                      |

| **TABLE R12**               | Notification                  |
| --------------------------------- | ----------------------------- |
| **Keys**                    | {notif_id}                    |
| **Functional Dependencies** |                               |
| FD1201                            | {notif_id} → {date, content} |
| **NORMAL FORM**             | BCNF                          |

| **TABLE R13**               | Project_notification    |
| --------------------------------- | ----------------------- |
| **Keys**                    | {notif_id}              |
| **Functional Dependencies** |                         |
| FD1301                            | {notif_id} → {proj_id} |
| **NORMAL FORM**             | BCNF                    |

| **TABLE R14**               | Assignment_notification |
| --------------------------------- | ----------------------- |
| **Keys**                    | {notif_id}              |
| **Functional Dependencies** |                         |
| FD1401                            | {notif_id} → {task_id} |
| **NORMAL FORM**             | BCNF                    |

| **TABLE R15**               | Comment_notification       |
| --------------------------------- | -------------------------- |
| **Keys**                    | {notif_id}                 |
| **Functional Dependencies** |                            |
| FD1501                            | {notif_id} → {comment_id} |
| **NORMAL FORM**             | BCNF                       |

All tables are already in BCNF, therefore there is no need for further normalization of the schema.

---

## A6: Indexes, triggers, transactions and database population

This artifact describes the physical database schema, including indexes, data integrity rules enforced by triggers, transaction management, and scripts to create and populate the database.

### 1. Database Workload

| **Relation reference** | **Relation Name** | **Order of magnitude** | **Estimated growth** |
| ---------------------------- | ----------------------- | ---------------------------- | -------------------------- |
| R01                          | Project                 | 1k (thousands)               | 1 (units)/day              |
| R02                          | Authenticated_user      | 10k (tens of thousands)      | 10/day                     |
| R03                          | Administrator           | 100                          | 1/day                      |
| R04                          | Project_member          | 10k                          | 10/day                     |
| R05                          | Task                    | 100k (hundreds of thousands) | 100 (hundreds)/day         |
| R06                          | Subtask                 | 1M(millions)                 | 1k/day                     |
| R07                          | Company                 | 100 (hundreds)               | 1/day                      |
| R08                          | Invitation              | 10k                          | 10 (tens)/day              |
| R09                          | Post                    | 1M                           | 1k/day                     |
| R10                          | Employee                | 10k                          | 10/day                     |
| R11                          | Comment                 | 100k                         | 100/day                    |
| R12                          | Notification            | 1M                           | 1k/day                     |
| R13                          | Project_notification    | 100k                         | 100/day                    |
| R14                          | Assignment_notification | 100k                         | 100/day                    |
| R15                          | Comment_notification    | 100k                         | 100/day                    |

### 2. Proposed Indices

#### 2.1. Performance Indices

> Indices proposed to improve performance of the identified queries.

| **Index**         | IDX01                                                                                                     |
| ----------------------- | --------------------------------------------------------------------------------------------------------- |
| **Relation**      | Project_member                                                                                            |
| **Attribute**     | user_id                                                                                                   |
| **Type**          | Hash                                                                                                      |
| **Cardinality**   | Medium                                                                                                    |
| **Clustering**    | Yes                                                                                                       |
| **Justification** | Each User will be looking up their associated projects several times so it has to be as fast as possible. |
| `SQL code`            | `CREATE INDEX projects_id_user ON Project_member USING hash (user_id);`                                 |

| **Index**         | IDX02                                                                                                   |
| ----------------------- | ------------------------------------------------------------------------------------------------------- |
| **Relation**      | Project_member                                                                                          |
| **Attribute**     | proj_id                                                                                                 |
| **Type**          | Hash                                                                                                    |
| **Cardinality**   | Medium                                                                                                  |
| **Clustering**    | Yes                                                                                                     |
| **Justification** | Getting the members of a project will be a frequent operation so using an index will make it cost less. |
| `SQL code`            | `CREATE INDEX members_id_project ON Project_member USING hash (proj_id);`                             |

| **Index**         | IDX03                                                                                                       |
| ----------------------- | ----------------------------------------------------------------------------------------------------------- |
| **Relation**      | Task                                                                                                        |
| **Attribute**     | proj_id                                                                                                     |
| **Type**          | Hash                                                                                                        |
| **Cardinality**   | Medium                                                                                                      |
| **Clustering**    | Yes                                                                                                         |
| **Justification** | Searching for the tasks of a project will be more efficient using a Hash Index on the id_project attribute. |
| `SQL code`            | `CREATE INDEX tasks_id_project ON Task USING hash (proj_id);`                                             |

#### 2.2. Full-text Search Indices

> The system being developed must provide full-text search features supported by PostgreSQL. Thus, it is necessary to specify the fields where full-text search will be available and the associated setup, namely all necessary configurations, indexes definitions and other relevant details.

| **Index**         | IDX04                                                                                                                                                               |
| ----------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Relation**      | Project                                                                                                                                                             |
| **Attribute**     | name                                                                                                                                                                |
| **Type**          | GIST                                                                                                                                                                |
| **Clustering**    | No                                                                                                                                                                  |
| **Justification** | This index allows the user to search for a project using its name. Since the name of a project can change, a GIST index gives a better performance on dynamic data. |
| `SQL code`            | `CREATE INDEX project_name_search ON Project USING gist (to_tsvector('english', name));`                                                                          |

### 3. Triggers

> User-defined functions and trigger procedures that add control structures to the SQL language or perform complex computations, are identified and described to be trusted by the database server. Every kind of function (SQL functions, Stored procedures, Trigger procedures) can take base types, composite types, or combinations of these as arguments (parameters). In addition, every kind of function can return a base type or a composite type. Functions can also be defined to return sets of base or composite values.

| **Trigger**                                                                   | TRIGGER01                                    |
| ----------------------------------------------------------------------------------- | -------------------------------------------- |
| **Description**                                                               | Update Task status according to its subtasks |
| SQL Code                                                                            |                                              |
| CREATE OR REPLACE FUNCTION task_status_upd() RETURNS TRIGGER AS                     |                                              |
| $BODY$                                                                            |                                              |
| BEGIN                                                                               |                                              |
| IF EXISTS (SELECT 1                                                                 |                                              |
| FROM Subtask                                                                        |                                              |
| WHERE NEW.task_id = Subtask.task_id AND Subtask.status = 'In Progress') THEN        |                                              |
| UPDATE Task                                                                         |                                              |
| SET status = 'In Progress'                                                          |                                              |
| WHERE NEW.task_id = Task.task_id;                                                   |                                              |
| ELSIF NOT EXISTS (SELECT 1                                                          |                                              |
| FROM Subtask                                                                        |                                              |
| WHERE NEW.task_id = Subtask.task_id AND Subtask.status IN ('To-do', 'In Progress')) |                                              |
| AND EXISTS (SELECT 1                                                                |                                              |
| FROM Subtask                                                                        |                                              |
| WHERE NEW.task_id = Subtask.task_id AND Subtask.status = 'Completed') THEN          |                                              |
| UPDATE Task                                                                         |                                              |
| SET status = 'Completed'                                                            |                                              |
| WHERE NEW.task_id = Task.task_id;                                                   |                                              |
| END IF;                                                                             |                                              |
| RETURN NEW;                                                                         |                                              |
| END                                                                                 |                                              |
| $BODY$                                                                            |                                              |
| LANGUAGE plpgsql;                                                                   |                                              |
| CREATE TRIGGER task_status_upd                                                      |                                              |
| AFTER INSERT OR UPDATE ON Subtask                                                   |                                              |
| FOR EACH ROW                                                                        |                                              |
| EXECUTE FUNCTION task_status_upd();                                                 |                                              |

| **Trigger**                                                  | TRIGGER02                    |
| ------------------------------------------------------------------ | ---------------------------- |
| **Description**                                              | Update progress of a project |
| SQL Code                                                           |                              |
| CREATE OR REPLACE FUNCTION proj_prog() RETURNS TRIGGER AS          |                              |
| $BODY$                                                           |                              |
| DECLARE                                                            |                              |
| Completed INT;                                                     |                              |
| NumberofTasks INT;                                                 |                              |
| BEGIN                                                              |                              |
| SELECT COUNT(CASE WHEN status = 'Completed' THEN 1 ELSE NULL END), |                              |
| COUNT(task_id)                                                     |                              |
| INTO Completed, NumberofTasks                                      |                              |
| FROM Task                                                          |                              |
| WHERE NEW.proj_id = Task.proj_id;                                  |                              |

    IF NumberofTasks > 0 THEN
            UPDATE Project
            SET percentageCompleted = Completed * 100.0 / NumberofTasks
            WHERE NEW.proj_id = Project.proj_id;
        END IF;

    RETURN NEW;
    END$BODY$
    LANGUAGE plpgsql;
    CREATE TRIGGER proj_prog
    AFTER INSERT OR UPDATE ON Task
    FOR EACH ROW
    EXECUTE FUNCTION proj_prog();

| **Trigger**                                            | TRIGGER03                                                |
| ------------------------------------------------------------ | -------------------------------------------------------- |
| **Description**                                        | Update number of projects in progress assigned to a user |
| SQL Code                                                     |                                                          |
| CREATE OR REPLACE FUNCTION user_projass() RETURNS TRIGGER AS |                                                          |
| $BODY$                                                     |                                                          |
| BEGIN                                                        |                                                          |
| UPDATE Authenticated_user                                    |                                                          |
| SET projects_in_progress = projects_in_progress + 1          |                                                          |
| WHERE NEW.user_id = user_id;                                 |                                                          |
| RETURN NEW;                                                  |                                                          |
| END                                                          |                                                          |
| $BODY$                                                     |                                                          |
| LANGUAGE plpgsql;                                            |                                                          |
| CREATE TRIGGER user_projass                                  |                                                          |
| AFTER INSERT ON Project_member                               |                                                          |
| FOR EACH ROW                                                 |                                                          |
| EXECUTE PROCEDURE user_projass();                            |                                                          |

| **Trigger**                                             | TRIGGER04                                              |
| ------------------------------------------------------------- | ------------------------------------------------------ |
| **Description**                                         | Update number of projects completed assigned to a user |
| SQL Code                                                      |                                                        |
| CREATE OR REPLACE FUNCTION user_projcomp() RETURNS TRIGGER AS |                                                        |
| $BODY$                                                      |                                                        |
| BEGIN                                                         |                                                        |
| IF EXISTS (                                                   |                                                        |
| SELECT proj_id                                                |                                                        |
| FROM Project                                                  |                                                        |
| WHERE NEW.proj_id = proj_id AND percentageCompleted = 100     |                                                        |
| ) THEN                                                        |                                                        |
| UPDATE Authenticated_user                                     |                                                        |
| SET projects_completed = projects_completed + 1,              |                                                        |
| projects_in_progress = projects_in_progress - 1               |                                                        |
| FROM Project_member                                           |                                                        |
| WHERE NEW.proj_id = Project_member.proj_id                    |                                                        |
| AND Project_member.user_id = Authenticated_user.user_id;      |                                                        |
| END IF;                                                       |                                                        |
| RETURN NEW;                                                   |                                                        |
| END                                                           |                                                        |
| $BODY$                                                      |                                                        |
| LANGUAGE plpgsql;                                             |                                                        |
| CREATE TRIGGER user_projcomp                                  |                                                        |
| AFTER UPDATE ON Project                                       |                                                        |
| FOR EACH ROW                                                  |                                                        |
| EXECUTE FUNCTION user_projcomp();                             |                                                        |

### 4. Transactions

| TRAN01                                        | Add Subtask                                                                                                                                                                                                                                                                       |
| --------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Justification                                 | In order to preserve consistency, a transaction is needed, ensuring that all the code executes without any errors. If an error occurs, a ROLLBACK is issued (when the insertion of a subtask fails, for example). The isolation level is Serializable, because we need to execute |
| Isolation level                               | SERIALIZABLE                                                                                                                                                                                                                                                                      |
| SQL code                                      |                                                                                                                                                                                                                                                                                   |
| BEGIN TRANSACTION                             |                                                                                                                                                                                                                                                                                   |
| SET TRANSACTION ISOLATION LEVEL SERIALIZABLE; |                                                                                                                                                                                                                                                                                   |

    -- Create task
     INSERT INTO Task (name, description, due_date, assigned_member)
     VALUES ($name, $description, $due_date, $assigned_member)
     RETURNING id;

    -- Insert subtask relation
     INSERT INTO Subtask (id, name, description, task_id)
     VALUES (id,$name, $description, $task_id);

    COMMIT;

| TRAN02                                                  | Get current project members                                                                                                                                                                                                                                                                                                                                                                                                                       |
| ------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Justification                                           | During a transaction, the insertion of new rows in the Project_member table can occur, which implies that the information retrieved in both selects could be different, resulting in Phantom Read (a transaction re-executes a query and finds that the results have changed by another transaction). Aiming for a less restrictive isolation level that still guarantees its data is consistent, we used READ ONLY (since it only uses Selects). |
| Isolation level                                         | SERIALIZABLE READ ONLY                                                                                                                                                                                                                                                                                                                                                                                                                            |
| SQL code                                                |                                                                                                                                                                                                                                                                                                                                                                                                                                                   |
| BEGIN TRANSACTION                                       |                                                                                                                                                                                                                                                                                                                                                                                                                                                   |
| SET TRANSACTION ISOLATION LEVEL SERIALIZABLE READ ONLY; |                                                                                                                                                                                                                                                                                                                                                                                                                                                   |

    -- Get project members
    SELECT name, email, Project.proj_id
    FROM User
    INNER JOIN Project_member ON user_id = Project_member.user_id
    INNER JOIN Project ON Project.proj_id = Project_member.proj_id
    ORDER BY Project.proj_id ASC;

    END TRANSACTION;

| TRAN03                                            | Accept invitation, register and enter an existing project                                                                                                                                                                                     |
| ------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Justification                                     | After getting an invitation, if the user decides to sign up, we need to enure the whole process is completed. We chose READ UNCOMMITTED as the isolation level, in order to guarantee that if anything fails we will not lose the invitation. |
| Isolation level                                   | READ UNCOMMITTED                                                                                                                                                                                                                              |
| SQL code                                          |                                                                                                                                                                                                                                               |
| BEGIN TRANSACTION                                 |                                                                                                                                                                                                                                               |
| SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED; |                                                                                                                                                                                                                                               |

    DELETE FROM Invitation WHERE user_id = $user_id;

    INSERT INTO Authenticated_user(name, email, username, password)
        VALUES($name, $email, $username, $password);

    INSERT INTO Project_member(proj_id, user_id)
        VALUES($proj_id, $user_id)
    COMMIT;

## Annex A. SQL Code

### A.1. Database schema

```sql
DROP INDEX IF EXISTS projects_id_user;
DROP INDEX IF EXISTS members_id_project;
DROP INDEX IF EXISTS tasks_id_project;
DROP INDEX IF EXISTS project_name_search;
DROP TABLE IF EXISTS Comment_notification;
DROP TABLE IF EXISTS Assignment_notification;
DROP TABLE IF EXISTS Project_notification;
DROP TABLE IF EXISTS Notification;
DROP TABLE IF EXISTS Comment;
DROP TABLE IF EXISTS Employee;
DROP TABLE IF EXISTS Post;
DROP TABLE IF EXISTS Invitation;
DROP TABLE IF EXISTS Subtask;
DROP TABLE IF EXISTS Task;
DROP TABLE IF EXISTS Project_member;
DROP TABLE IF EXISTS Project;
DROP TABLE IF EXISTS Authenticated_user;
DROP TABLE IF EXISTS Company;
DROP TABLE IF EXISTS Administrator;
DROP TYPE IF EXISTS priority_task;
DROP TYPE IF EXISTS status_task;


CREATE TYPE status_task AS ENUM (
    'To-do',
    'In Progress',
    'Completed'
);

CREATE TYPE priority_task AS ENUM (
    'Low',
    'Medium',
    'High'
);

CREATE TABLE Administrator (
 admin_id SERIAL PRIMARY KEY,
 name TEXT NOT NULL,
 email TEXT NOT NULL UNIQUE,
 password TEXT NOT NULL,
 username TEXT NOT NULL UNIQUE
);

CREATE TABLE Company (
 comp_id SERIAL PRIMARY KEY,
 name TEXT NOT NULL,
 admin_id INTEGER REFERENCES Administrator(admin_id)
);

CREATE TABLE Authenticated_user (
    user_id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    username TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    profile_image TEXT,
    projects_in_progress INTEGER DEFAULT 0,
    projects_completed INTEGER DEFAULT 0,
    tasks_in_progress INTEGER DEFAULT 0,
    tasks_completed INTEGER DEFAULT 0
);

CREATE TABLE Project (
    proj_id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    description TEXT NOT NULL,
    due_date DATE NOT NULL CHECK (due_date >= CURRENT_DATE),
    is_archived BOOLEAN DEFAULT FALSE,
    is_favorite BOOLEAN DEFAULT FALSE,
    percentageCompleted NUMERIC(5,2),
    comp_id INTEGER REFERENCES Company(comp_id),
    coord_id INTEGER REFERENCES Authenticated_user(user_id)
);


CREATE TABLE Project_member (
    proj_id INTEGER REFERENCES Project(proj_id),
    user_id INTEGER UNIQUE REFERENCES Authenticated_user(user_id),
    is_assigned BOOLEAN DEFAULT FALSE,
    PRIMARY KEY (proj_id, user_id)
);

CREATE TABLE Task (
   task_id SERIAL PRIMARY KEY,
   name TEXT NOT NULL,
   description TEXT,
   due_date DATE NOT NULL CHECK (due_date >= CURRENT_DATE),
   status status_task NOT NULL DEFAULT 'To-do',
   priority priority_task NOT NULL,
   CONSTRAINT status_check CHECK (status IN ('To-do', 'In Progress', 'Completed')),
   CONSTRAINT priority_check CHECK (priority IN ('Low', 'Medium', 'High')),
   proj_id INTEGER REFERENCES Project(proj_id),
   assigned_member INTEGER REFERENCES Project_member(user_id)
);

CREATE TABLE Subtask (
    subtask_id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    description TEXT,
    status status_task NOT NULL DEFAULT 'To-do',
    task_id INTEGER REFERENCES Task(task_id),
    CONSTRAINT status_check CHECK (status IN ('To-do', 'In Progress', 'Completed'))
);


CREATE TABLE Invitation (
    user_id INTEGER PRIMARY KEY REFERENCES Authenticated_user(user_id),
    proj_id INTEGER REFERENCES Project(proj_id),
    coord_id INTEGER REFERENCES Authenticated_user(user_id),
    approved BOOLEAN DEFAULT FALSE
);


CREATE TABLE Post (
    post_id SERIAL PRIMARY KEY,
    date DATE NOT NULL,
    content TEXT NOT NULL,
    assigned_member INTEGER REFERENCES Project_member(user_id),
    proj_id INTEGER REFERENCES Project(proj_id)
);

CREATE TABLE Employee (
    comp_id INTEGER REFERENCES Company(comp_id),
    user_id INTEGER REFERENCES Authenticated_user(user_id),
    PRIMARY KEY (comp_id, user_id)
);

CREATE TABLE Comment (
    comment_id SERIAL,
    date DATE NOT NULL,
    content TEXT NOT NULL,
    task_id INTEGER REFERENCES Task(task_id),
    assigned_member INTEGER REFERENCES Project_member(user_id),
    reply INTEGER,
    PRIMARY KEY (comment_id, reply)
);

CREATE TABLE Notification (
    notif_id SERIAL PRIMARY KEY,
    date DATE NOT NULL,
    content TEXT NOT NULL
);

CREATE TABLE Project_notification (
    notif_id INTEGER PRIMARY KEY REFERENCES Notification(notif_id) NOT NULL,
    proj_id INTEGER REFERENCES Project(proj_id) NOT NULL
);

CREATE TABLE Assignment_notification (
    notif_id INTEGER PRIMARY KEY REFERENCES Notification(notif_id) NOT NULL,
    task_id INTEGER REFERENCES Task(task_id) NOT NULL
);

CREATE TABLE Comment_notification (
    notif_id INTEGER PRIMARY KEY REFERENCES Notification(notif_id) NOT NULL,
    comment_id INTEGER,
    reply INTEGER,
    FOREIGN KEY (comment_id, reply) REFERENCES Comment(comment_id, reply)
);

CREATE INDEX projects_id_user ON Project_member USING hash (user_id);
CREATE INDEX members_id_project ON Project_member USING hash (proj_id);
CREATE INDEX tasks_id_project ON Task USING hash (proj_id);
CREATE INDEX project_name_search ON Project USING gist (to_tsvector('english', name));



CREATE OR REPLACE FUNCTION task_status_upd() RETURNS TRIGGER AS 
    $BODY$
    BEGIN
    IF EXISTS (SELECT 1
               FROM Subtask
               WHERE NEW.task_id = Subtask.task_id AND Subtask.status = 'In Progress') THEN
        UPDATE Task
        SET status = 'In Progress'
        WHERE NEW.task_id = Task.task_id;
    ELSIF NOT EXISTS (SELECT 1
                     FROM Subtask
                     WHERE NEW.task_id = Subtask.task_id AND Subtask.status IN ('To-do', 'In Progress'))
                     AND EXISTS (SELECT 1
                                FROM Subtask
                                WHERE NEW.task_id = Subtask.task_id AND Subtask.status = 'Completed') THEN
        UPDATE Task
        SET status = 'Completed'
        WHERE NEW.task_id = Task.task_id;
    END IF;
    RETURN NEW;
    END
    $BODY$
    LANGUAGE plpgsql;
    CREATE TRIGGER task_status_upd
    AFTER INSERT OR UPDATE ON Subtask
    FOR EACH ROW
    EXECUTE FUNCTION task_status_upd();



CREATE OR REPLACE FUNCTION proj_prog() RETURNS TRIGGER AS 
$BODY$
BEGIN
    IF EXISTS (
        SELECT proj_id,
               COUNT(CASE WHEN status = 'Completed' THEN 1 ELSE NULL END) AS Completed,
               COUNT(task_id) AS NumberofTasks 
        FROM Task
        WHERE NEW.proj_id = Task.proj_id
        GROUP BY proj_id
    ) THEN 
    UPDATE Project
        SET percentageCompleted = Completed / NumberofTasks * 100
        WHERE NEW.proj_id = Project.proj_id;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;
CREATE TRIGGER proj_prog
AFTER INSERT OR UPDATE ON Task
FOR EACH ROW
EXECUTE FUNCTION proj_prog();


CREATE OR REPLACE FUNCTION user_projass() RETURNS TRIGGER AS 
$BODY$
BEGIN
    UPDATE Authenticated_user
    SET projects_in_progress = projects_in_progress + 1
    WHERE NEW.user_id = user_id;
END
$BODY$
LANGUAGE plpgsql;
CREATE TRIGGER user_projass
AFTER INSERT ON Project_member
FOR EACH ROW
EXECUTE PROCEDURE user_projass();

CREATE OR REPLACE FUNCTION user_projcomp() RETURNS TRIGGER AS 
$BODY$
BEGIN
    IF EXISTS (
        SELECT proj_id
        FROM Project
        WHERE NEW.proj_id = proj_id AND percentageCompleted = 100
    ) THEN
        UPDATE Authenticated_user
        SET projects_completed = projects_completed + 1,
            projects_in_progress = projects_in_progress - 1
        FROM Project_member
        WHERE NEW.proj_id = Project_member.proj_id
            AND Project_member.user_id = Authenticated_user.user_id;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;
CREATE TRIGGER user_projcomp
AFTER UPDATE ON Project
FOR EACH ROW
EXECUTE FUNCTION user_projcomp();

```

### A.2. Database population

```sql
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (1, 'Drake Algore', 'dalgore0@instagram.com', 'dalgore0', 'bS9)$5=#', 'http://dummyimage.com/176x100.png/cc0000/ffffff', 27, 21, 33, 23);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (2, 'Cecil Castelyn', 'ccastelyn1@technorati.com', 'ccastelyn1', 'bB1=|YtK{', 'http://dummyimage.com/107x100.png/dddddd/000000', 9, 15, 24, 20);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (3, 'Jeanette MacElroy', 'jmacelroy2@booking.com', 'jmacelroy2', 'jC6~`.@/', 'http://dummyimage.com/168x100.png/ff4444/ffffff', 22, 19, 25, 15);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (4, 'Boony Robet', 'brobet3@comcast.net', 'brobet3', 'pU6{N1o!', 'http://dummyimage.com/243x100.png/5fa2dd/ffffff', 1, 2, 5, 43);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (5, 'Sallyann Nys', 'snys4@cocolog-nifty.com', 'snys4', 'dC2\RR=iz|ca}Aq$', 'http://dummyimage.com/128x100.png/5fa2dd/ffffff', 16, 42, 37, 27);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (6, 'Izzy Beckers', 'ibeckers5@sciencedaily.com', 'ibeckers5', 'yS0)Ov$vfWT''Rgv', 'http://dummyimage.com/105x100.png/cc0000/ffffff', 21, 30, 14, 9);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (7, 'Nell McGirl', 'nmcgirl6@networkadvertising.org', 'nmcgirl6', 'aQ8)e.?zNZ', 'http://dummyimage.com/109x100.png/ff4444/ffffff', 30, 27, 39, 27);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (8, 'Ania Iglesias', 'aiglesias7@reference.com', 'aiglesias7', 'oX3.f}jjOnxdu<M', 'http://dummyimage.com/107x100.png/5fa2dd/ffffff', 44, 43, 17, 32);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (9, 'Sidonia Titchen', 'stitchen8@eepurl.com', 'stitchen8', 'lM7(t(Bz7A*Fu', 'http://dummyimage.com/250x100.png/dddddd/000000', 3, 12, 32, 50);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (10, 'Barty Howey', 'bhowey9@disqus.com', 'bhowey9', 'kC0(@!x~NZ,sO', 'http://dummyimage.com/220x100.png/5fa2dd/ffffff', 29, 15, 39, 17);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (11, 'Theo Chevis', 'tchevisa@sogou.com', 'tchevisa', 'dM1($mBZfT=', 'http://dummyimage.com/233x100.png/5fa2dd/ffffff', 26, 27, 48, 14);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (12, 'Dolph Tall', 'dtallb@ft.com', 'dtallb', 'pP6.pH!9mYA5x', 'http://dummyimage.com/122x100.png/ff4444/ffffff', 25, 6, 16, 40);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (13, 'Angelia Gutcher', 'agutcherc@biblegateway.com', 'agutcherc', 'qS5%BtF$Dv', 'http://dummyimage.com/221x100.png/cc0000/ffffff', 23, 34, 0, 49);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (14, 'Faustina Pentony', 'fpentonyd@alibaba.com', 'fpentonyd', 'eI0}w.G+L1~u)''G', 'http://dummyimage.com/222x100.png/dddddd/000000', 8, 14, 31, 28);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (15, 'Cordi Bagot', 'cbagote@jugem.jp', 'cbagote', 'fF8"LoT`', 'http://dummyimage.com/112x100.png/dddddd/000000', 22, 21, 23, 25);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (16, 'Heloise Fullbrook', 'hfullbrookf@vinaora.com', 'hfullbrookf', 'rN8/TG+(NQ2ci', 'http://dummyimage.com/226x100.png/ff4444/ffffff', 46, 28, 16, 39);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (17, 'Kikelia Saltsberg', 'ksaltsbergg@newyorker.com', 'ksaltsbergg', 'eK1!h8~l_G0/', 'http://dummyimage.com/146x100.png/cc0000/ffffff', 24, 6, 6, 19);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (18, 'Northrop Seakings', 'nseakingsh@networksolutions.com', 'nseakingsh', 'eE4@C`l{', 'http://dummyimage.com/115x100.png/ff4444/ffffff', 18, 5, 42, 31);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (19, 'Leonanie Blase', 'lblasei@mozilla.com', 'lblasei', 'jQ3}''+n{xoz', 'http://dummyimage.com/206x100.png/5fa2dd/ffffff', 8, 49, 39, 12);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (20, 'Charis Antonat', 'cantonatj@bizjournals.com', 'cantonatj', 'mA5&70{`EJ,_8p(!', 'http://dummyimage.com/104x100.png/5fa2dd/ffffff', 12, 9, 2, 19);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (21, 'Kelci Gwynn', 'kgwynnk@jigsy.com', 'kgwynnk', 'wH4,A!GW8ehu', 'http://dummyimage.com/100x100.png/ff4444/ffffff', 44, 1, 1, 10);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (22, 'Theadora Argue', 'targuel@prweb.com', 'targuel', 'nA8|n8Yo', 'http://dummyimage.com/240x100.png/dddddd/000000', 13, 34, 14, 47);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (23, 'Bridget Organ', 'borganm@google.com', 'borganm', 'gI8`c")?X0eFmjs', 'http://dummyimage.com/116x100.png/dddddd/000000', 31, 8, 48, 50);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (24, 'Ludovika Enever', 'lenevern@seattletimes.com', 'lenevern', 'zM8)U*5|KJipl', 'http://dummyimage.com/230x100.png/dddddd/000000', 30, 34, 28, 45);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (25, 'Broddie Burge', 'bburgeo@cbslocal.com', 'bburgeo', 'kX4%''{Tk!E)ID', 'http://dummyimage.com/161x100.png/dddddd/000000', 41, 34, 35, 34);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (26, 'Rafaello Ahrendsen', 'rahrendsenp@google.co.jp', 'rahrendsenp', 'mY9)K+Pt', 'http://dummyimage.com/132x100.png/cc0000/ffffff', 19, 31, 47, 20);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (27, 'Zorina Mellers', 'zmellersq@cnn.com', 'zmellersq', 'xY3/<{%''', 'http://dummyimage.com/221x100.png/dddddd/000000', 13, 12, 3, 42);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (28, 'Nesta Ruffle', 'nruffler@answers.com', 'nruffler', 'aO6$mJ@KL>', 'http://dummyimage.com/143x100.png/cc0000/ffffff', 12, 11, 49, 48);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (29, 'Eli Padbery', 'epadberys@woothemes.com', 'epadberys', 'aX5+.)1y9QhJHt7|', 'http://dummyimage.com/199x100.png/5fa2dd/ffffff', 20, 17, 17, 11);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (30, 'Mahmud Bradburn', 'mbradburnt@china.com.cn', 'mbradburnt', 'sG9&@_9lw{xPavXL', 'http://dummyimage.com/108x100.png/dddddd/000000', 42, 10, 48, 44);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (31, 'Pepita Starbuck', 'pstarbucku@squidoo.com', 'pstarbucku', 'uG3}B45e\b', 'http://dummyimage.com/211x100.png/5fa2dd/ffffff', 6, 27, 37, 6);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (32, 'Puff Liebermann', 'pliebermannv@princeton.edu', 'pliebermannv', 'kG0}qnqT', 'http://dummyimage.com/215x100.png/5fa2dd/ffffff', 32, 19, 18, 3);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (33, 'Theodoric Sargint', 'tsargintw@harvard.edu', 'tsargintw', 'xJ3_~F''<', 'http://dummyimage.com/124x100.png/5fa2dd/ffffff', 14, 36, 19, 6);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (34, 'Royce Caldayrou', 'rcaldayroux@amazonaws.com', 'rcaldayroux', 'iF7\#)YUex|', 'http://dummyimage.com/234x100.png/cc0000/ffffff', 9, 30, 40, 22);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (35, 'Gannie Lavarack', 'glavaracky@intel.com', 'glavaracky', 'aB1~`*`RRk', 'http://dummyimage.com/115x100.png/cc0000/ffffff', 34, 49, 49, 46);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (36, 'Neila Dooland', 'ndoolandz@com.com', 'ndoolandz', 'kP5}Fh?}', 'http://dummyimage.com/153x100.png/cc0000/ffffff', 5, 44, 26, 36);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (37, 'Brock Eagleston', 'beagleston10@gmpg.org', 'beagleston10', 'gX7?lAN<Hp=', 'http://dummyimage.com/190x100.png/dddddd/000000', 48, 23, 3, 0);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (38, 'Irvine Stennine', 'istennine11@fotki.com', 'istennine11', 'lD0)''+CrvFvbvNT4', 'http://dummyimage.com/166x100.png/5fa2dd/ffffff', 8, 12, 22, 37);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (39, 'Maybelle Kalisz', 'mkalisz12@hostgator.com', 'mkalisz12', 'cW0<)vr7C', 'http://dummyimage.com/191x100.png/cc0000/ffffff', 5, 11, 35, 21);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (40, 'Jarrett Rangle', 'jrangle13@sourceforge.net', 'jrangle13', 'gT5&,t9(kL+', 'http://dummyimage.com/235x100.png/dddddd/000000', 40, 1, 45, 48);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (41, 'Mallissa McGettrick', 'mmcgettrick14@nbcnews.com', 'mmcgettrick14', 'lM9~p,ovD/', 'http://dummyimage.com/102x100.png/dddddd/000000', 9, 50, 43, 47);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (42, 'Lanny Ponten', 'lponten15@reddit.com', 'lponten15', 'uY8{NOo9!@yt4Yd', 'http://dummyimage.com/181x100.png/5fa2dd/ffffff', 44, 31, 20, 36);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (43, 'Lamont Braga', 'lbraga16@flickr.com', 'lbraga16', 'dF7%cqN$', 'http://dummyimage.com/122x100.png/5fa2dd/ffffff', 9, 8, 45, 13);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (44, 'Morey Ferrick', 'mferrick17@github.com', 'mferrick17', 'tL1/60Nl#<', 'http://dummyimage.com/224x100.png/dddddd/000000', 0, 40, 29, 43);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (45, 'Rab Druce', 'rdruce18@smugmug.com', 'rdruce18', 'lR5<gk/R+u4B!DW', 'http://dummyimage.com/166x100.png/dddddd/000000', 18, 48, 10, 49);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (46, 'Cilka Troke', 'ctroke19@angelfire.com', 'ctroke19', 'gO9@5k1\uv<,', 'http://dummyimage.com/132x100.png/cc0000/ffffff', 12, 18, 22, 34);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (47, 'Goddart Barrott', 'gbarrott1a@timesonline.co.uk', 'gbarrott1a', 'zY2?DxC''Eu/<nxo', 'http://dummyimage.com/173x100.png/dddddd/000000', 27, 31, 25, 35);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (48, 'Gipsy MacCaughey', 'gmaccaughey1b@wsj.com', 'gmaccaughey1b', 'tF1@%e=3+', 'http://dummyimage.com/225x100.png/5fa2dd/ffffff', 29, 14, 1, 26);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (49, 'Sumner Sollitt', 'ssollitt1c@godaddy.com', 'ssollitt1c', 'dM9?xPOFJM|u+ucm', 'http://dummyimage.com/173x100.png/ff4444/ffffff', 46, 4, 46, 1);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (50, 'Michele Sloss', 'msloss1d@friendfeed.com', 'msloss1d', 'oN5`NC_CK', 'http://dummyimage.com/121x100.png/ff4444/ffffff', 33, 19, 19, 17);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (51, 'Ondrea Sueter', 'osueter1e@slate.com', 'osueter1e', 'wQ7$q.<RyEbTD', 'http://dummyimage.com/184x100.png/cc0000/ffffff', 47, 45, 23, 39);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (52, 'Hastie Cobleigh', 'hcobleigh1f@hp.com', 'hcobleigh1f', 'aL0+q7}s7hB,B', 'http://dummyimage.com/116x100.png/dddddd/000000', 49, 27, 2, 39);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (53, 'Brig Brinsden', 'bbrinsden1g@privacy.gov.au', 'bbrinsden1g', 'tK1~"<QTrr`p', 'http://dummyimage.com/202x100.png/5fa2dd/ffffff', 40, 49, 33, 33);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (54, 'Afton Overstone', 'aoverstone1h@dion.ne.jp', 'aoverstone1h', 'dD0*o+{(''?2B$.T', 'http://dummyimage.com/125x100.png/cc0000/ffffff', 4, 30, 33, 10);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (55, 'Morgan Tuttle', 'mtuttle1i@google.pl', 'mtuttle1i', 'zK8(/2/u9', 'http://dummyimage.com/128x100.png/cc0000/ffffff', 19, 15, 14, 39);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (56, 'Clayborne Courtman', 'ccourtman1j@disqus.com', 'ccourtman1j', 'uF5#+NkuzcoV@2h', 'http://dummyimage.com/212x100.png/dddddd/000000', 26, 30, 50, 39);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (57, 'Tyne Cheater', 'tcheater1k@youtu.be', 'tcheater1k', 'vA3%hO/,Uy*Tlu%', 'http://dummyimage.com/218x100.png/5fa2dd/ffffff', 40, 19, 6, 32);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (58, 'Flin Daviddi', 'fdaviddi1l@miibeian.gov.cn', 'fdaviddi1l', 'jU8=$uCE`ab*Ve', 'http://dummyimage.com/113x100.png/ff4444/ffffff', 34, 37, 16, 11);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (59, 'Odele Foulks', 'ofoulks1m@youtu.be', 'ofoulks1m', 'jN9\d)Q`Bh0AV', 'http://dummyimage.com/242x100.png/5fa2dd/ffffff', 44, 38, 34, 13);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (60, 'Lucky Peteri', 'lpeteri1n@dell.com', 'lpeteri1n', 'eT5~eMc>9+rt~J', 'http://dummyimage.com/161x100.png/ff4444/ffffff', 32, 13, 16, 3);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (61, 'Gloria Woolf', 'gwoolf1o@nature.com', 'gwoolf1o', 'dZ0..!kW/', 'http://dummyimage.com/112x100.png/dddddd/000000', 27, 32, 38, 47);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (62, 'Ester Maloney', 'emaloney1p@issuu.com', 'emaloney1p', 'lI5.7`/of2Km', 'http://dummyimage.com/232x100.png/5fa2dd/ffffff', 3, 18, 25, 5);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (63, 'Rudolph Gonnely', 'rgonnely1q@paypal.com', 'rgonnely1q', 'zB5@}~x7{~VQ{jf', 'http://dummyimage.com/169x100.png/ff4444/ffffff', 28, 5, 37, 3);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (64, 'Genovera Albon', 'galbon1r@intel.com', 'galbon1r', 'eC8@C!`3rC11Jm', 'http://dummyimage.com/164x100.png/cc0000/ffffff', 2, 26, 7, 36);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (65, 'Charmain Oylett', 'coylett1s@wikimedia.org', 'coylett1s', 'lR6!1kxq6r%`JYk', 'http://dummyimage.com/243x100.png/cc0000/ffffff', 16, 8, 22, 37);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (66, 'Dolores Edmonds', 'dedmonds1t@oracle.com', 'dedmonds1t', 'uG5).moQgH"7|', 'http://dummyimage.com/104x100.png/ff4444/ffffff', 25, 46, 22, 44);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (67, 'Fernandina Jahnke', 'fjahnke1u@washingtonpost.com', 'fjahnke1u', 'tL8_>SS$l2TU4sCj', 'http://dummyimage.com/141x100.png/dddddd/000000', 24, 39, 36, 27);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (68, 'Sharon Chatfield', 'schatfield1v@gizmodo.com', 'schatfield1v', 'bT9@5T66_}Nkc}', 'http://dummyimage.com/123x100.png/dddddd/000000', 47, 27, 2, 37);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (69, 'Editha Underwood', 'eunderwood1w@discovery.com', 'eunderwood1w', 'jG0/l{MF44|<y', 'http://dummyimage.com/205x100.png/cc0000/ffffff', 50, 23, 45, 48);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (70, 'Blaine Knewstubb', 'bknewstubb1x@amazon.co.uk', 'bknewstubb1x', 'gE0=%o3Pmd}bFvP', 'http://dummyimage.com/233x100.png/5fa2dd/ffffff', 31, 14, 3, 11);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (71, 'Annabell Berrycloth', 'aberrycloth1y@ebay.com', 'aberrycloth1y', 'xK5$9zv(1\_@', 'http://dummyimage.com/183x100.png/cc0000/ffffff', 26, 1, 45, 36);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (72, 'Trey Dallan', 'tdallan1z@purevolume.com', 'tdallan1z', 'zA8@>y{o2Rtk<C09', 'http://dummyimage.com/133x100.png/dddddd/000000', 39, 4, 1, 42);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (73, 'Tibold Delap', 'tdelap20@unicef.org', 'tdelap20', 'lF1~vB8WmG)?9L', 'http://dummyimage.com/110x100.png/5fa2dd/ffffff', 1, 21, 3, 38);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (74, 'Wernher Iacovielli', 'wiacovielli21@businesswire.com', 'wiacovielli21', 'nV5.vHis{c&*', 'http://dummyimage.com/138x100.png/cc0000/ffffff', 46, 49, 42, 14);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (75, 'Lazar Lownie', 'llownie22@harvard.edu', 'llownie22', 'nQ8>l>GxM', 'http://dummyimage.com/186x100.png/5fa2dd/ffffff', 7, 13, 44, 22);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (76, 'Debbie Mitten', 'dmitten23@clickbank.net', 'dmitten23', 'uF7_Tx+J?D', 'http://dummyimage.com/104x100.png/cc0000/ffffff', 0, 14, 9, 23);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (77, 'Augie Mariner', 'amariner24@time.com', 'amariner24', 'jC3$RZe2U@=vL{lP', 'http://dummyimage.com/198x100.png/dddddd/000000', 3, 41, 45, 5);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (78, 'Rudd McTurley', 'rmcturley25@acquirethisname.com', 'rmcturley25', 'yX1!MD3,#>+', 'http://dummyimage.com/138x100.png/ff4444/ffffff', 16, 16, 4, 42);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (79, 'Farr Stronack', 'fstronack26@bizjournals.com', 'fstronack26', 'mL6{D/O6DG1*bhO', 'http://dummyimage.com/153x100.png/dddddd/000000', 14, 40, 5, 9);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (80, 'Suzette Pideon', 'spideon27@amazon.co.jp', 'spideon27', 'zB7"aH6X', 'http://dummyimage.com/130x100.png/cc0000/ffffff', 46, 49, 39, 11);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (81, 'Ettore Jeffcock', 'ejeffcock28@paypal.com', 'ejeffcock28', 'gO3@\VAZ', 'http://dummyimage.com/109x100.png/cc0000/ffffff', 39, 29, 48, 49);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (82, 'Leonie Comello', 'lcomello29@dailymail.co.uk', 'lcomello29', 'cZ3/vNMtSU', 'http://dummyimage.com/126x100.png/ff4444/ffffff', 46, 36, 43, 0);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (83, 'Emylee Pottell', 'epottell2a@opensource.org', 'epottell2a', 'fF8{tatSpq', 'http://dummyimage.com/224x100.png/cc0000/ffffff', 4, 39, 41, 31);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (84, 'Alfreda Bennetts', 'abennetts2b@bloglines.com', 'abennetts2b', 'bA9%rrwAv', 'http://dummyimage.com/118x100.png/cc0000/ffffff', 11, 42, 36, 26);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (85, 'Craggy Melbourn', 'cmelbourn2c@reverbnation.com', 'cmelbourn2c', 'rO9!eqvjB2', 'http://dummyimage.com/106x100.png/cc0000/ffffff', 31, 32, 24, 29);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (86, 'Boris Davis', 'bdavis2d@digg.com', 'bdavis2d', 'uJ5>f@''u12rp>~iU', 'http://dummyimage.com/221x100.png/dddddd/000000', 1, 43, 39, 44);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (87, 'Daveen Savaage', 'dsavaage2e@4shared.com', 'dsavaage2e', 'oV7_6*~LoRB', 'http://dummyimage.com/163x100.png/cc0000/ffffff', 40, 8, 39, 11);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (88, 'Antony Firbank', 'afirbank2f@phoca.cz', 'afirbank2f', 'tC0{P4<)qV', 'http://dummyimage.com/213x100.png/ff4444/ffffff', 45, 48, 7, 11);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (89, 'Gare Murgatroyd', 'gmurgatroyd2g@unicef.org', 'gmurgatroyd2g', 'aQ9{Qo?$|Apa{r,L', 'http://dummyimage.com/158x100.png/cc0000/ffffff', 31, 11, 37, 36);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (90, 'Dickie Kidstoun', 'dkidstoun2h@utexas.edu', 'dkidstoun2h', 'xT4,P`pEqYz0U>Z', 'http://dummyimage.com/247x100.png/5fa2dd/ffffff', 6, 50, 6, 47);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (91, 'Leonie Haddock', 'lhaddock2i@slideshare.net', 'lhaddock2i', 'tZ4/9b?)e?5', 'http://dummyimage.com/231x100.png/cc0000/ffffff', 42, 46, 36, 9);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (92, 'Roddy Prantoni', 'rprantoni2j@delicious.com', 'rprantoni2j', 'rE9#epcC}', 'http://dummyimage.com/109x100.png/cc0000/ffffff', 15, 32, 3, 22);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (93, 'Orlando Oleszkiewicz', 'ooleszkiewicz2k@fastcompany.com', 'ooleszkiewicz2k', 'gF9{dkjSJf', 'http://dummyimage.com/213x100.png/5fa2dd/ffffff', 1, 29, 31, 15);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (94, 'Emlyn Nulty', 'enulty2l@walmart.com', 'enulty2l', 'tF7)mS''m', 'http://dummyimage.com/130x100.png/ff4444/ffffff', 11, 22, 28, 16);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (95, 'Hailey Livings', 'hlivings2m@nifty.com', 'hlivings2m', 'qR3(!du''5MK', 'http://dummyimage.com/189x100.png/ff4444/ffffff', 32, 41, 40, 7);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (96, 'Stephi Canniffe', 'scanniffe2n@goo.gl', 'scanniffe2n', 'eO4*%+.~c|9J_GnF', 'http://dummyimage.com/155x100.png/5fa2dd/ffffff', 22, 42, 30, 23);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (97, 'Cindelyn Punter', 'cpunter2o@guardian.co.uk', 'cpunter2o', 'uI3<y8V(rR*>', 'http://dummyimage.com/215x100.png/5fa2dd/ffffff', 42, 13, 40, 19);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (98, 'Olga Lanktree', 'olanktree2p@phoca.cz', 'olanktree2p', 'lE2"JSAW@{M+e2', 'http://dummyimage.com/229x100.png/dddddd/000000', 9, 37, 2, 16);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (99, 'Kaile Volker', 'kvolker2q@imgur.com', 'kvolker2q', 'wK8?%1{N2e8.2Na', 'http://dummyimage.com/198x100.png/dddddd/000000', 20, 26, 3, 39);
insert into Authenticated_user (user_id, name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values (100, 'Sydel Foulcher', 'sfoulcher2r@macromedia.com', 'sfoulcher2r', 'iF4#3Ox%an#0', 'http://dummyimage.com/164x100.png/ff4444/ffffff', 39, 28, 14, 22);

insert into Administrator (admin_id, name, email, password, username) values (1, 'Timmi Busher', 'tbusher0@zdnet.com', 'fE9#+#Kp5M', 'tbusher0');
insert into Administrator (admin_id, name, email, password, username) values (2, 'Lavina Mapother', 'lmapother1@nasa.gov', 'sG0,hum)|"w', 'lmapother1');
insert into Administrator (admin_id, name, email, password, username) values (3, 'Nevins Roden', 'nroden2@google.ru', 'yF7\3Ef,&\4L.1n', 'nroden2');
insert into Administrator (admin_id, name, email, password, username) values (4, 'Mariellen Bottrell', 'mbottrell3@google.com.hk', 'qA4\vMkJ*rk`E', 'mbottrell3');
insert into Administrator (admin_id, name, email, password, username) values (5, 'Delmer Pearsey', 'dpearsey4@goodreads.com', 'rL8(XQ&@Opy', 'dpearsey4');
insert into Administrator (admin_id, name, email, password, username) values (6, 'Eustace Deporte', 'edeporte5@netvibes.com', 'nK6%BSn,', 'edeporte5');
insert into Administrator (admin_id, name, email, password, username) values (7, 'Jesse Mereweather', 'jmereweather6@example.com', 'uK0~i5"cu2{', 'jmereweather6');
insert into Administrator (admin_id, name, email, password, username) values (8, 'Jarred Glowinski', 'jglowinski7@issuu.com', 'bY6*GxGcYxB', 'jglowinski7');
insert into Administrator (admin_id, name, email, password, username) values (9, 'Althea Meriel', 'ameriel8@skyrock.com', 'gK9.UHu`s{', 'ameriel8');
insert into Administrator (admin_id, name, email, password, username) values (10, 'Jamima Shelbourne', 'jshelbourne9@naver.com', 'yE8"Xrfz.Yr4', 'jshelbourne9');
insert into Administrator (admin_id, name, email, password, username) values (11, 'Sapphire Greeve', 'sgreevea@seesaa.net', 'tV7!dqLs', 'sgreevea');
insert into Administrator (admin_id, name, email, password, username) values (12, 'Betteanne Sparway', 'bsparwayb@dell.com', 'eJ6+&Z{k7h', 'bsparwayb');
insert into Administrator (admin_id, name, email, password, username) values (13, 'Roosevelt Haddacks', 'rhaddacksc@squarespace.com', 'xX3*|ycv~', 'rhaddacksc');
insert into Administrator (admin_id, name, email, password, username) values (14, 'Reinaldos Nissle', 'rnissled@xrea.com', 'iA9~J+T\Pc)Ji', 'rnissled');
insert into Administrator (admin_id, name, email, password, username) values (15, 'Madalyn Dargan', 'mdargane@toplist.cz', 'cV0)@IWSqsvXQf|b', 'mdargane');
insert into Administrator (admin_id, name, email, password, username) values (16, 'Marchelle Fryett', 'mfryettf@walmart.com', 'yF0|x5tv', 'mfryettf');
insert into Administrator (admin_id, name, email, password, username) values (17, 'Husain Windmill', 'hwindmillg@oakley.com', 'aO4{T"Ays+aj{', 'hwindmillg');
insert into Administrator (admin_id, name, email, password, username) values (18, 'Elvina Kinsman', 'ekinsmanh@devhub.com', 'eK5>b_.B%T', 'ekinsmanh');
insert into Administrator (admin_id, name, email, password, username) values (19, 'Irvin Asplin', 'iasplini@sohu.com', 'xL0*7(~4', 'iasplini');
insert into Administrator (admin_id, name, email, password, username) values (20, 'Brendan Jore', 'bjorej@state.tx.us', 'xU2&}ZLFxqK0ok', 'bjorej');
insert into Administrator (admin_id, name, email, password, username) values (21, 'Milicent Canner', 'mcannerk@4shared.com', 'fL6=)&1deUUwzww', 'mcannerk');
insert into Administrator (admin_id, name, email, password, username) values (22, 'Angelika O''Mohun', 'aomohunl@vkontakte.ru', 'kE7@MV.,', 'aomohunl');
insert into Administrator (admin_id, name, email, password, username) values (23, 'Emmerich O''Loinn', 'eoloinnm@facebook.com', 'fU0++$}P!x{%', 'eoloinnm');
insert into Administrator (admin_id, name, email, password, username) values (24, 'Leelah Tilson', 'ltilsonn@apple.com', 'vH2_._(O*_OwBGv', 'ltilsonn');
insert into Administrator (admin_id, name, email, password, username) values (25, 'Ree Wilkie', 'rwilkieo@ftc.gov', 'wB4_zDa~', 'rwilkieo');
insert into Administrator (admin_id, name, email, password, username) values (26, 'Katharina Behnecke', 'kbehneckep@howstuffworks.com', 'pY6&c=6@B3s', 'kbehneckep');
insert into Administrator (admin_id, name, email, password, username) values (27, 'Patty MacKartan', 'pmackartanq@guardian.co.uk', 'sU5+ZNA||}79%2', 'pmackartanq');
insert into Administrator (admin_id, name, email, password, username) values (28, 'Rebekah Doole', 'rdooler@reference.com', 'oQ0*Wt|''@gt&I&Kw', 'rdooler');
insert into Administrator (admin_id, name, email, password, username) values (29, 'Pren Clayton', 'pclaytons@tripod.com', 'iZ5_l0/2GtI(', 'pclaytons');
insert into Administrator (admin_id, name, email, password, username) values (30, 'Teresita Cattanach', 'tcattanacht@youtube.com', 'eP4?&u@Gqt|j`AbZ', 'tcattanacht');
insert into Administrator (admin_id, name, email, password, username) values (31, 'Michelle Cops', 'mcopsu@amazon.co.jp', 'jE6%.T<lAJ0', 'mcopsu');
insert into Administrator (admin_id, name, email, password, username) values (32, 'Nance McNab', 'nmcnabv@so-net.ne.jp', 'kA8*IkbZ9FU', 'nmcnabv');
insert into Administrator (admin_id, name, email, password, username) values (33, 'Mason Campany', 'mcampanyw@symantec.com', 'zG8$CR1dQk6HMr{', 'mcampanyw');
insert into Administrator (admin_id, name, email, password, username) values (34, 'Shayne Taysbil', 'staysbilx@yahoo.co.jp', 'kL4|_QTj|', 'staysbilx');
insert into Administrator (admin_id, name, email, password, username) values (35, 'Katharyn Suttie', 'ksuttiey@apache.org', 'sL5_O6v8', 'ksuttiey');
insert into Administrator (admin_id, name, email, password, username) values (36, 'Haley Swynley', 'hswynleyz@seesaa.net', 'kF4?4~%6GD+Pi', 'hswynleyz');
insert into Administrator (admin_id, name, email, password, username) values (37, 'Romola Fulk', 'rfulk10@cisco.com', 'jV8''rAT', 'rfulk10');
insert into Administrator (admin_id, name, email, password, username) values (38, 'Waldon Quoit', 'wquoit11@miitbeian.gov.cn', 'aO82!?FG?', 'wquoit11');
insert into Administrator (admin_id, name, email, password, username) values (39, 'Fred Aimeric', 'faimeric12@alibaba.com', 'wT0=Zs5V>Ko5qn', 'faimeric12');
insert into Administrator (admin_id, name, email, password, username) values (40, 'Robbin Castro', 'rcastro13@imdb.com', 'sG0_fn9`Qaq5NN', 'rcastro13');
insert into Administrator (admin_id, name, email, password, username) values (41, 'Frederica Gillopp', 'fgillopp14@dailymail.co.uk', 'dO1?YkOP%Ob7#9', 'fgillopp14');
insert into Administrator (admin_id, name, email, password, username) values (42, 'Theresina Tash', 'ttash15@mysql.com', 'lY5)z7R(%dMiEQB', 'ttash15');
insert into Administrator (admin_id, name, email, password, username) values (43, 'Kalvin Kopps', 'kkopps16@acquirethisname.com', 'qW5+Ko`,DQa', 'kkopps16');
insert into Administrator (admin_id, name, email, password, username) values (44, 'Jelene Abrahamoff', 'jabrahamoff17@sbwire.com', 'yW6(&VZZCTW&r', 'jabrahamoff17');
insert into Administrator (admin_id, name, email, password, username) values (45, 'Elizabeth Teodorski', 'eteodorski18@elpais.com', 'iG3+''ZN?<Vp=o''', 'eteodorski18');
insert into Administrator (admin_id, name, email, password, username) values (46, 'Daniele Pether', 'dpether19@wikimedia.org', 'hL9~>f,U', 'dpether19');
insert into Administrator (admin_id, name, email, password, username) values (47, 'Yetta Whopples', 'ywhopples1a@mail.ru', 'aP8`,HlU''FE', 'ywhopples1a');
insert into Administrator (admin_id, name, email, password, username) values (48, 'Christoph Ellesmere', 'cellesmere1b@wp.com', 'iX9`N@x~Ld{vU%)', 'cellesmere1b');
insert into Administrator (admin_id, name, email, password, username) values (49, 'Fredrika Guirard', 'fguirard1c@goodreads.com', 'mC0|LnN}yB', 'fguirard1c');
insert into Administrator (admin_id, name, email, password, username) values (50, 'Yvonne Comar', 'ycomar1d@redcross.org', 'wB2,ZW(14DGHXq&', 'ycomar1d');

insert into Company (comp_id, name, admin_id) values (1, 'Fatz', 1);
insert into Company (comp_id, name, admin_id) values (2, 'Mudo', 2);
insert into Company (comp_id, name, admin_id) values (3, 'Avaveo', 3);
insert into Company (comp_id, name, admin_id) values (4, 'Snaptags', 4);
insert into Company (comp_id, name, admin_id) values (5, 'Poly', 5);
insert into Company (comp_id, name, admin_id) values (6, 'Tagchat', 6);
insert into Company (comp_id, name, admin_id) values (7, 'Viva', 7);
insert into Company (comp_id, name, admin_id) values (8, 'Vidoo', 8);
insert into Company (comp_id, name, admin_id) values (9, 'Camido', 9);
insert into Company (comp_id, name, admin_id) values (10, 'Feedmix', 10);
insert into Company (comp_id, name, admin_id) values (11, 'Yakijo', 11);
insert into Company (comp_id, name, admin_id) values (12, 'Twiyo', 12);
insert into Company (comp_id, name, admin_id) values (13, 'Feedfire', 13);
insert into Company (comp_id, name, admin_id) values (14, 'Brainlounge', 14);
insert into Company (comp_id, name, admin_id) values (15, 'Skivee', 15);
insert into Company (comp_id, name, admin_id) values (16, 'Lazzy', 16);
insert into Company (comp_id, name, admin_id) values (17, 'Twitterworks', 17);
insert into Company (comp_id, name, admin_id) values (18, 'Feed', 18);
insert into Company (comp_id, name, admin_id) values (19, 'Tekfly', 19);
insert into Company (comp_id, name, admin_id) values (20, 'Topiczoom', 20);
insert into Company (comp_id, name, admin_id) values (21, 'Kwilith', 21);
insert into Company (comp_id, name, admin_id) values (22, 'Youopia', 22);
insert into Company (comp_id, name, admin_id) values (23, 'Divanoodle', 23);
insert into Company (comp_id, name, admin_id) values (24, 'Blogtags', 24);
insert into Company (comp_id, name, admin_id) values (25, 'Kwideo', 25);
insert into Company (comp_id, name, admin_id) values (26, 'Cogidoo', 26);
insert into Company (comp_id, name, admin_id) values (27, 'Bubblebox', 27);
insert into Company (comp_id, name, admin_id) values (28, 'Plajo', 28);
insert into Company (comp_id, name, admin_id) values (29, 'Eayo', 29);
insert into Company (comp_id, name, admin_id) values (30, 'Twimm', 30);
insert into Company (comp_id, name, admin_id) values (31, 'Minyx', 31);
insert into Company (comp_id, name, admin_id) values (32, 'Meedoo', 32);
insert into Company (comp_id, name, admin_id) values (33, 'Centimia', 33);
insert into Company (comp_id, name, admin_id) values (34, 'Thoughtbeat', 34);
insert into Company (comp_id, name, admin_id) values (35, 'Jetwire', 35);
insert into Company (comp_id, name, admin_id) values (36, 'Rhyloo', 36);
insert into Company (comp_id, name, admin_id) values (37, 'Trilith', 37);
insert into Company (comp_id, name, admin_id) values (38, 'Meejo', 38);
insert into Company (comp_id, name, admin_id) values (39, 'Devcast', 39);
insert into Company (comp_id, name, admin_id) values (40, 'Brainsphere', 40);
insert into Company (comp_id, name, admin_id) values (41, 'Edgewire', 41);
insert into Company (comp_id, name, admin_id) values (42, 'Npath', 42);
insert into Company (comp_id, name, admin_id) values (43, 'Cogilith', 43);
insert into Company (comp_id, name, admin_id) values (44, 'Skiba', 44);
insert into Company (comp_id, name, admin_id) values (45, 'Babbleopia', 45);
insert into Company (comp_id, name, admin_id) values (46, 'Meembee', 46);
insert into Company (comp_id, name, admin_id) values (47, 'Zoozzy', 47);
insert into Company (comp_id, name, admin_id) values (48, 'Rhycero', 48);
insert into Company (comp_id, name, admin_id) values (49, 'Photofeed', 49);
insert into Company (comp_id, name, admin_id) values (50, 'Skipstorm', 50);


insert into Notification (notif_id, date, content) values(1, '2023-11-29 01:49:31', 'The invitation to this project has been accepted');
insert into Notification (notif_id, date, content) values(2, '2023-11-01 01:24:50', 'The invitation to this project has been accepted');
insert into Notification (notif_id, date, content) values(3, '2024-03-07 23:38:34', 'The invitation to this project has been accepted');
insert into Notification (notif_id, date, content) values(4, '2024-04-14 09:56:19', 'The invitation to this project has been accepted');
insert into Notification (notif_id, date, content) values(5, '2024-01-18 10:08:16', 'The invitation to this project has been accepted');
insert into Notification (notif_id, date, content) values(6, '2023-12-03 04:44:33', 'The invitation to this project has been accepted');
insert into Notification (notif_id, date, content) values(7, '2024-03-25 09:20:12', 'The invitation to this project has been accepted');
insert into Notification (notif_id, date, content) values(8, '2024-07-27 17:29:07', 'The invitation to this project has been accepted');
insert into Notification (notif_id, date, content) values(9, '2023-11-23 15:03:56', 'The invitation to this project has been accepted');
insert into Notification (notif_id, date, content) values(10, '2024-02-02 13:06:38', 'The invitation to this project has been accepted');
insert into Notification (notif_id, date, content) values(11, '2024-03-06 00:02:30', 'The invitation to this project has been accepted');
insert into Notification (notif_id, date, content) values(12, '2024-09-28 02:44:50', 'The invitation to this project has been accepted');
insert into Notification (notif_id, date, content) values(13, '2024-07-03 04:38:22', 'The invitation to this project has been accepted');
insert into Notification (notif_id, date, content) values(14, '2024-08-18 21:26:51', 'The invitation to this project has been accepted');
insert into Notification (notif_id, date, content) values(15, '2023-12-02 01:07:59', 'The invitation to this project has been accepted');
insert into Notification (notif_id, date, content) values(16, '2023-10-24 09:35:19', 'The invitation to this project has been accepted');
insert into Notification (notif_id, date, content) values(17, '2024-01-21 08:32:23', 'The invitation to this project has been accepted');
insert into Notification (notif_id, date, content) values(18, '2024-09-13 14:28:53', 'The project coordinator has changed');
insert into Notification (notif_id, date, content) values(19, '2024-08-17 03:37:49', 'The project coordinator has changed');
insert into Notification (notif_id, date, content) values(20, '2024-03-25 15:06:27', 'The project coordinator has changed');
insert into Notification (notif_id, date, content) values(21, '2023-12-12 04:03:44', 'The project coordinator has changed');
insert into Notification (notif_id, date, content) values(22, '2024-03-14 00:28:23', 'The project coordinator has changed');
insert into Notification (notif_id, date, content) values(23, '2024-05-06 10:59:46', 'The project coordinator has changed');
insert into Notification (notif_id, date, content) values(24, '2024-05-16 03:10:42', 'The project coordinator has changed');
insert into Notification (notif_id, date, content) values(25, '2024-03-13 19:30:21', 'The project coordinator has changed');
insert into Notification (notif_id, date, content) values(26, '2024-10-10 12:15:42', 'The project coordinator has changed');
insert into Notification (notif_id, date, content) values(27, '2023-12-24 21:49:40', 'The project coordinator has changed');
insert into Notification (notif_id, date, content) values(28, '2024-03-19 07:35:00', 'The project coordinator has changed');
insert into Notification (notif_id, date, content) values(29, '2024-07-01 16:55:22', 'The project coordinator has changed');
insert into Notification (notif_id, date, content) values(30, '2024-04-06 17:54:35', 'The project coordinator has changed');
insert into Notification (notif_id, date, content) values(31, '2023-12-12 00:14:17', 'The project coordinator has changed');
insert into Notification (notif_id, date, content) values(32, '2024-10-12 08:52:02', 'The project coordinator has changed');
insert into Notification (notif_id, date, content) values(33, '2024-05-05 06:54:31', 'The project coordinator has changed');
insert into Notification (notif_id, date, content) values(34, '2023-12-19 16:20:08', 'The project coordinator has changed');
insert into Notification (notif_id, date, content) values(35, '2023-12-19 16:20:08', 'The task is completed');
insert into Notification (notif_id, date, content) values(36, '2024-02-28 19:23:42', 'The task is completed');
insert into Notification (notif_id, date, content) values(37, '2024-01-11 05:02:19', 'The task is completed');
insert into Notification (notif_id, date, content) values(38, '2024-08-22 04:31:59', 'The task is completed');
insert into Notification (notif_id, date, content) values(39, '2024-08-29 00:15:45', 'The task is completed');
insert into Notification (notif_id, date, content) values(40, '2024-03-25 02:44:43', 'The task is completed');
insert into Notification (notif_id, date, content) values(41, '2024-03-26 14:07:51', 'The task is completed');
insert into Notification (notif_id, date, content) values(42, '2024-05-18 12:42:53', 'The task is completed');
insert into Notification (notif_id, date, content) values(43, '2024-07-02 05:31:25', 'The task is completed');
insert into Notification (notif_id, date, content) values(44, '2024-07-29 23:43:48', 'The task is completed');
insert into Notification (notif_id, date, content) values(45, '2024-08-30 15:27:40', 'The task is completed');
insert into Notification (notif_id, date, content) values(46, '2023-10-26 20:48:20', 'The task is completed');
insert into Notification (notif_id, date, content) values(47, '2024-03-08 07:03:51', 'The task is completed');
insert into Notification (notif_id, date, content) values(48, '2023-12-25 18:36:54', 'The task is completed');
insert into Notification (notif_id, date, content) values(49, '2024-01-20 15:41:32', 'The task is completed');
insert into Notification (notif_id, date, content) values(50, '2024-05-09 06:01:29', 'The task is completed');
insert into Notification (notif_id, date, content) values(51, '2023-12-02 23:28:41', 'The task is completed');
insert into Notification (notif_id, date, content) values(52, '2023-12-12 17:51:26', 'The user has been assigned to the task');
insert into Notification (notif_id, date, content) values(53, '2024-05-23 08:27:57', 'The user has been assigned to the task');
insert into Notification (notif_id, date, content) values(54, '2024-07-31 22:59:05', 'The user has been assigned to the task');
insert into Notification (notif_id, date, content) values(55, '2024-08-19 02:38:36', 'The user has been assigned to the task');
insert into Notification (notif_id, date, content) values(56, '2024-02-17 18:10:47', 'The user has been assigned to the task');
insert into Notification (notif_id, date, content) values(57, '2024-03-19 09:12:59', 'The user has been assigned to the task');
insert into Notification (notif_id, date, content) values(58, '2024-06-16 22:03:54', 'The user has been assigned to the task');
insert into Notification (notif_id, date, content) values(59, '2024-09-21 03:52:56', 'The user has been assigned to the task');
insert into Notification (notif_id, date, content) values(60, '2024-08-06 16:31:39', 'The user has been assigned to the task');
insert into Notification (notif_id, date, content) values(61, '2024-01-19 19:25:29', 'The user has been assigned to the task');
insert into Notification (notif_id, date, content) values(62, '2024-09-12 15:41:52', 'The user has been assigned to the task');
insert into Notification (notif_id, date, content) values(63, '2024-08-25 15:48:51', 'The user has been assigned to the task');
insert into Notification (notif_id, date, content) values(64, '2023-12-08 01:15:44', 'The user has been assigned to the task');
insert into Notification (notif_id, date, content) values(65, '2024-07-05 02:36:24', 'The user has been assigned to the task');
insert into Notification (notif_id, date, content) values(66, '2024-06-11 14:48:55', 'The user has been assigned to the task');
insert into Notification (notif_id, date, content) values(67, '2024-07-31 16:43:50', 'The user has been assigned to the task');
insert into Notification (notif_id, date, content) values(68, '2024-01-08 21:35:55', 'The user has been assigned to the task');
insert into Notification (notif_id, date, content) values(69, '2024-09-03 10:56:00', 'A comment has been made to your task');
insert into Notification (notif_id, date, content) values(70, '2024-09-16 07:54:47', 'A comment has been made to your task');
insert into Notification (notif_id, date, content) values(71, '2024-04-30 00:39:46', 'A comment has been made to your task');
insert into Notification (notif_id, date, content) values(72, '2024-09-16 14:06:56', 'A comment has been made to your task');
insert into Notification (notif_id, date, content) values(73, '2024-07-11 22:36:55', 'A comment has been made to your task');
insert into Notification (notif_id, date, content) values(74, '2023-11-26 00:41:21', 'A comment has been made to your task');
insert into Notification (notif_id, date, content) values(75, '2023-11-02 22:10:45', 'A comment has been made to your task');
insert into Notification (notif_id, date, content) values(76, '2023-12-10 05:06:19', 'A comment has been made to your task');
insert into Notification (notif_id, date, content) values(77, '2024-02-16 21:01:49', 'A comment has been made to your task');
insert into Notification (notif_id, date, content) values(78, '2024-02-23 11:11:13', 'A comment has been made to your task');
insert into Notification (notif_id, date, content) values(79, '2024-04-29 11:56:27', 'A comment has been made to your task');
insert into Notification (notif_id, date, content) values(80, '2024-06-12 07:30:09', 'A comment has been made to your task');
insert into Notification (notif_id, date, content) values(81, '2024-02-18 09:53:51', 'A comment has been made to your task');
insert into Notification (notif_id, date, content) values(82, '2024-10-18 23:06:00', 'A comment has been made to your task');
insert into Notification (notif_id, date, content) values(83, '2024-02-13 03:26:00', 'A comment has been made to your task');
insert into Notification (notif_id, date, content) values(84, '2024-10-10 21:04:44', 'A comment has been made to your task');

insert into Project (proj_id, name, description, due_date, is_archived, is_favorite, percentageCompleted, comp_id, coord_id) values(1, 'Zontrax', 'Maecenas leo odio, condimentum id, luctus nec, molestie sed, justo. Pellentesque viverra pede ac diam. Cras pellentesque volutpat dui.', '2024-04-26 17:17:45', false, true, 73.11, 46, 20);
insert into Project (proj_id, name, description, due_date, is_archived, is_favorite, percentageCompleted, comp_id, coord_id) values(2, 'Asoka', 'Cras mi pede, malesuada in, imperdiet et, commodo vulputate, justo. In blandit ultrices enim. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', '2024-10-07 05:02:14', false, true, 23.02, 49, 21);
insert into Project (proj_id, name, description, due_date, is_archived, is_favorite, percentageCompleted, comp_id, coord_id) values(3, 'Job', 'Duis aliquam convallis nunc. Proin at turpis a pede posuere nonummy. Integer non velit.', '2024-01-13 06:38:50', false, true, 6.16, 47, 22);
insert into Project (proj_id, name, description, due_date, is_archived, is_favorite, percentageCompleted, comp_id, coord_id) values(4, 'Subin', 'In congue. Etiam justo. Etiam pretium iaculis justo.', '2024-03-20 13:11:24', false, false, 55.8, 36, 23);
insert into Project (proj_id, name, description, due_date, is_archived, is_favorite, percentageCompleted, comp_id, coord_id) values(5, 'Bitchip', 'Mauris enim leo, rhoncus sed, vestibulum sit amet, cursus id, turpis. Integer aliquet, massa id lobortis convallis, tortor risus dapibus augue, vel accumsan tellus nisi eu orci. Mauris lacinia sapien quis libero.', '2024-05-29 11:52:14', false, false, 97.75, 29, 24);
insert into Project (proj_id, name, description, due_date, is_archived, is_favorite, percentageCompleted, comp_id, coord_id) values(6, 'Flexidy', 'Quisque id justo sit amet sapien dignissim vestibulum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla dapibus dolor vel est. Donec odio justo, sollicitudin ut, suscipit a, feugiat et, eros.', '2024-07-11 18:21:49', true, false, 41.44, 30, 25);
insert into Project (proj_id, name, description, due_date, is_archived, is_favorite, percentageCompleted, comp_id, coord_id) values(7, 'Domainer', 'Vestibulum ac est lacinia nisi venenatis tristique. Fusce congue, diam id ornare imperdiet, sapien urna pretium nisl, ut volutpat sapien arcu sed augue. Aliquam erat volutpat.', '2024-07-27 03:49:12', false, false, 18.65, 43, 26);
insert into Project (proj_id, name, description, due_date, is_archived, is_favorite, percentageCompleted, comp_id, coord_id) values(8, 'Zamit', 'Proin interdum mauris non ligula pellentesque ultrices. Phasellus id sapien in sapien iaculis congue. Vivamus metus arcu, adipiscing molestie, hendrerit at, vulputate vitae, nisl.', '2024-03-29 05:57:10', false, false, 76.09, 41, 27);
insert into Project (proj_id, name, description, due_date, is_archived, is_favorite, percentageCompleted, comp_id, coord_id) values(9, 'Zontrax', 'Fusce posuere felis sed lacus. Morbi sem mauris, laoreet ut, rhoncus aliquet, pulvinar sed, nisl. Nunc rhoncus dui vel sem.', '2024-09-17 05:14:53', false, true, 84.27, 27, 28);
insert into Project (proj_id, name, description, due_date, is_archived, is_favorite, percentageCompleted, comp_id, coord_id) values(10, 'Redhold', 'Phasellus in felis. Donec semper sapien a libero. Nam dui.', '2024-04-12 18:41:08', false, false, 46.29, 28, 29);
insert into Project (proj_id, name, description, due_date, is_archived, is_favorite, percentageCompleted, comp_id, coord_id) values(11, 'Tampflex', 'Maecenas tristique, est et tempus semper, est quam pharetra magna, ac consequat metus sapien ut nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris viverra diam vitae quam. Suspendisse potenti.', '2024-10-07 16:12:19', true, true, 3.63, 40, 30);
insert into Project (proj_id, name, description, due_date, is_archived, is_favorite, percentageCompleted, comp_id, coord_id) values(12, 'Stringtough', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Proin risus. Praesent lectus.', '2024-05-21 21:21:43', false, false, 99.52, 7, 31);
insert into Project (proj_id, name, description, due_date, is_archived, is_favorite, percentageCompleted, comp_id, coord_id) values(13, 'Voltsillam', 'Etiam vel augue. Vestibulum rutrum rutrum neque. Aenean auctor gravida sem.', '2024-06-22 00:34:03', false, true, 14.84, 13, 32);
insert into Project (proj_id, name, description, due_date, is_archived, is_favorite, percentageCompleted, comp_id, coord_id) values(14, 'Cardguard', 'Maecenas ut massa quis augue luctus tincidunt. Nulla mollis molestie lorem. Quisque ut erat.', '2024-04-11 04:16:26', false, false, 92.99, 16, 33);
insert into Project (proj_id, name, description, due_date, is_archived, is_favorite, percentageCompleted, comp_id, coord_id) values(15, 'Alphazap', 'Duis consequat dui nec nisi volutpat eleifend. Donec ut dolor. Morbi vel lectus in quam fringilla rhoncus.', '2023-12-26 08:58:41', false, true, 42.27, 48, 34);
insert into Project (proj_id, name, description, due_date, is_archived, is_favorite, percentageCompleted, comp_id, coord_id) values(16, 'Cardify', 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus vestibulum sagittis sapien. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.', '2024-07-08 17:51:31', true, false, 40.42, 2, 35);
insert into Project (proj_id, name, description, due_date, is_archived, is_favorite, percentageCompleted, comp_id, coord_id) values(17, 'Wrapsafe', 'Aenean lectus. Pellentesque eget nunc. Donec quis orci eget orci vehicula condimentum.', '2024-05-04 18:50:26', false, false, 91.02, 14, 36);
insert into Project (proj_id, name, description, due_date, is_archived, is_favorite, percentageCompleted, comp_id, coord_id) values(18, 'Prodder', 'Etiam vel augue. Vestibulum rutrum rutrum neque. Aenean auctor gravida sem.', '2024-05-12 10:34:05', false, false, 57.71, 22, 37);
insert into Project (proj_id, name, description, due_date, is_archived, is_favorite, percentageCompleted, comp_id, coord_id) values(19, 'Bigtax', 'Sed ante. Vivamus tortor. Duis mattis egestas metus.', '2024-05-30 18:18:08', false, false, 49.07, 22, 38);
insert into Project (proj_id, name, description, due_date, is_archived, is_favorite, percentageCompleted, comp_id, coord_id) values(20, 'Cookley', 'Vestibulum quam sapien, varius ut, blandit non, interdum in, ante. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Duis faucibus accumsan odio. Curabitur convallis.', '2024-06-25 02:37:09', false, false, 26.41, 19, 39);
insert into Project (proj_id, name, description, due_date, is_archived, is_favorite, percentageCompleted, comp_id, coord_id) values(21, 'Y-find', 'Maecenas tristique, est et tempus semper, est quam pharetra magna, ac consequat metus sapien ut nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris viverra diam vitae quam. Suspendisse potenti.', '2024-05-05 02:37:03', false, true, 36.12, 31, 40);
insert into Project (proj_id, name, description, due_date, is_archived, is_favorite, percentageCompleted, comp_id, coord_id) values(22, 'Temp', 'Duis aliquam convallis nunc. Proin at turpis a pede posuere nonummy. Integer non velit.', '2024-05-03 21:51:54', false, true, 95.0, 22, 41);
insert into Project (proj_id, name, description, due_date, is_archived, is_favorite, percentageCompleted, comp_id, coord_id) values(23, 'Overhold', 'Maecenas tristique, est et tempus semper, est quam pharetra magna, ac consequat metus sapien ut nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris viverra diam vitae quam. Suspendisse potenti.', '2024-09-20 13:43:37', false, false, 67.39, 7, 42);
insert into Project (proj_id, name, description, due_date, is_archived, is_favorite, percentageCompleted, comp_id, coord_id) values(24, 'Zoolab', 'Curabitur at ipsum ac tellus semper interdum. Mauris ullamcorper purus sit amet nulla. Quisque arcu libero, rutrum ac, lobortis vel, dapibus at, diam.', '2024-10-12 13:02:03', false, false, 13.3, 22, 43);
insert into Project (proj_id, name, description, due_date, is_archived, is_favorite, percentageCompleted, comp_id, coord_id) values(25, 'Greenlam', 'Integer tincidunt ante vel ipsum. Praesent blandit lacinia erat. Vestibulum sed magna at nunc commodo placerat.', '2024-03-13 00:28:28', false, false, 79.33, 8, 44);
insert into Project (proj_id, name, description, due_date, is_archived, is_favorite, percentageCompleted, comp_id, coord_id) values(26, 'Tresom', 'Morbi porttitor lorem id ligula. Suspendisse ornare consequat lectus. In est risus, auctor sed, tristique in, tempus sit amet, sem.', '2024-05-05 09:49:33', false, false, 67.1, 13, 45);
insert into Project (proj_id, name, description, due_date, is_archived, is_favorite, percentageCompleted, comp_id, coord_id) values(27, 'Bitwolf', 'Duis consequat dui nec nisi volutpat eleifend. Donec ut dolor. Morbi vel lectus in quam fringilla rhoncus.', '2023-12-09 10:12:58', false, false, 35.14, 41, 46);
insert into Project (proj_id, name, description, due_date, is_archived, is_favorite, percentageCompleted, comp_id, coord_id) values(28, 'Toughjoyfax', 'Proin leo odio, porttitor id, consequat in, consequat ut, nulla. Sed accumsan felis. Ut at dolor quis odio consequat varius.', '2024-06-01 22:07:08', false, true, 79.61, 4, 47);
insert into Project (proj_id, name, description, due_date, is_archived, is_favorite, percentageCompleted, comp_id, coord_id) values(29, 'Gembucket', 'Cras mi pede, malesuada in, imperdiet et, commodo vulputate, justo. In blandit ultrices enim. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', '2024-04-17 06:10:41', false, true, 75.71, 31, 48);
insert into Project (proj_id, name, description, due_date, is_archived, is_favorite, percentageCompleted, comp_id, coord_id) values(30, 'Bytecard', 'Sed ante. Vivamus tortor. Duis mattis egestas metus.', '2023-12-04 09:26:16', false, false, 50.18, 17, 49);

insert into Project_notification (notif_id, proj_id) values (1, 17);
insert into Project_notification (notif_id, proj_id) values (2, 26);
insert into Project_notification (notif_id, proj_id) values (3, 2);
insert into Project_notification (notif_id, proj_id) values (4, 27);
insert into Project_notification (notif_id, proj_id) values (5, 15);
insert into Project_notification (notif_id, proj_id) values (6, 25);
insert into Project_notification (notif_id, proj_id) values (7, 4);
insert into Project_notification (notif_id, proj_id) values (8, 13);
insert into Project_notification (notif_id, proj_id) values (9, 28);
insert into Project_notification (notif_id, proj_id) values (10, 16);
insert into Project_notification (notif_id, proj_id) values (11, 2);
insert into Project_notification (notif_id, proj_id) values (12, 3);
insert into Project_notification (notif_id, proj_id) values (13, 17);
insert into Project_notification (notif_id, proj_id) values (14, 9);
insert into Project_notification (notif_id, proj_id) values (15, 20);
insert into Project_notification (notif_id, proj_id) values (16, 4);
insert into Project_notification (notif_id, proj_id) values (17, 16);
insert into Project_notification (notif_id, proj_id) values (18, 10);
insert into Project_notification (notif_id, proj_id) values (19, 27);
insert into Project_notification (notif_id, proj_id) values (20, 22);
insert into Project_notification (notif_id, proj_id) values (21, 26);
insert into Project_notification (notif_id, proj_id) values (22, 11);
insert into Project_notification (notif_id, proj_id) values (23, 28);
insert into Project_notification (notif_id, proj_id) values (24, 29);
insert into Project_notification (notif_id, proj_id) values (25, 26);
insert into Project_notification (notif_id, proj_id) values (26, 13);
insert into Project_notification (notif_id, proj_id) values (27, 4);
insert into Project_notification (notif_id, proj_id) values (28, 17);
insert into Project_notification (notif_id, proj_id) values (29, 3);
insert into Project_notification (notif_id, proj_id) values (30, 25);
insert into Project_notification (notif_id, proj_id) values (31, 26);
insert into Project_notification (notif_id, proj_id) values (32, 16);
insert into Project_notification (notif_id, proj_id) values (33, 23);
insert into Project_notification (notif_id, proj_id) values (34, 3);

insert into Project_member (proj_id, user_id) values (1, 20);
insert into Project_member (proj_id, user_id) values (2, 21);
insert into Project_member (proj_id, user_id) values (3, 22);
insert into Project_member (proj_id, user_id) values (4, 23);
insert into Project_member (proj_id, user_id) values (5, 24);
insert into Project_member (proj_id, user_id) values (6, 25);
insert into Project_member (proj_id, user_id) values (7, 26);
insert into Project_member (proj_id, user_id) values (8, 27);
insert into Project_member (proj_id, user_id) values (9, 28);
insert into Project_member (proj_id, user_id) values (10, 29);
insert into Project_member (proj_id, user_id) values (11, 30);
insert into Project_member (proj_id, user_id) values (12, 31);
insert into Project_member (proj_id, user_id) values (13, 32);
insert into Project_member (proj_id, user_id) values (14, 33);
insert into Project_member (proj_id, user_id) values (15, 34);
insert into Project_member (proj_id, user_id) values (16, 35);
insert into Project_member (proj_id, user_id) values (17, 36);
insert into Project_member (proj_id, user_id) values (18, 37);
insert into Project_member (proj_id, user_id) values (19, 38);
insert into Project_member (proj_id, user_id) values (20, 39);
insert into Project_member (proj_id, user_id) values (21, 40);
insert into Project_member (proj_id, user_id) values (22, 41);
insert into Project_member (proj_id, user_id) values (23, 42);
insert into Project_member (proj_id, user_id) values (24, 43);
insert into Project_member (proj_id, user_id) values (25, 44);
insert into Project_member (proj_id, user_id) values (26, 45);
insert into Project_member (proj_id, user_id) values (27, 46);
insert into Project_member (proj_id, user_id) values (28, 47);
insert into Project_member (proj_id, user_id) values (29, 48);
insert into Project_member (proj_id, user_id) values (30, 49);
insert into Project_member (proj_id, user_id) values (19, 50);
insert into Project_member (proj_id, user_id) values (9, 51);
insert into Project_member (proj_id, user_id) values (12, 52);
insert into Project_member (proj_id, user_id) values (24, 53);
insert into Project_member (proj_id, user_id) values (6, 54);
insert into Project_member (proj_id, user_id) values (21, 55);
insert into Project_member (proj_id, user_id) values (12, 56);
insert into Project_member (proj_id, user_id) values (12, 57);
insert into Project_member (proj_id, user_id) values (15, 58);
insert into Project_member (proj_id, user_id) values (20, 59);
insert into Project_member (proj_id, user_id) values (29, 60);
insert into Project_member (proj_id, user_id) values (3, 61);
insert into Project_member (proj_id, user_id) values (27, 62);
insert into Project_member (proj_id, user_id) values (26, 63);
insert into Project_member (proj_id, user_id) values (15, 64);
insert into Project_member (proj_id, user_id) values (7, 65);
insert into Project_member (proj_id, user_id) values (7, 66);
insert into Project_member (proj_id, user_id) values (18, 67);
insert into Project_member (proj_id, user_id) values (24, 68);
insert into Project_member (proj_id, user_id) values (6, 69);
insert into Project_member (proj_id, user_id) values (11, 70);
insert into Project_member (proj_id, user_id) values (27, 71);
insert into Project_member (proj_id, user_id) values (1, 72);
insert into Project_member (proj_id, user_id) values (5, 73);
insert into Project_member (proj_id, user_id) values (11, 74);
insert into Project_member (proj_id, user_id) values (27, 75);
insert into Project_member (proj_id, user_id) values (24, 76);
insert into Project_member (proj_id, user_id) values (20, 77);
insert into Project_member (proj_id, user_id) values (23, 78);
insert into Project_member (proj_id, user_id) values (30, 79);


insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (1, 'Glyceria striata (Lam.) Hitchc.', 'Curabitur at ipsum ac tellus semper interdum. Mauris ullamcorper purus sit amet nulla. Quisque arcu libero, rutrum ac, lobortis vel, dapibus at, diam.', '2024-09-16 04:55:05', 'In Progress', 'Low', 1, 20);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (2, 'Aristida dichotoma Michx. var. curtissii A. Gray', 'Quisque porta volutpat erat. Quisque erat eros, viverra eget, congue eget, semper rutrum, nulla. Nunc purus.', '2024-05-12 14:07:44', 'In Progress', 'Medium', 2, 21);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (3, 'Fabronia Raddi', 'Quisque id justo sit amet sapien dignissim vestibulum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla dapibus dolor vel est. Donec odio justo, sollicitudin ut, suscipit a, feugiat et, eros.', '2024-10-13 19:22:52', 'To-do', 'Medium', 3, 22);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (4, 'Pelexia adnata (Sw.) Spreng.', 'Aenean lectus. Pellentesque eget nunc. Donec quis orci eget orci vehicula condimentum.', '2024-04-22 02:55:15', 'Completed', 'Medium', 4, 23);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (5, 'Penstemon fremontii Torr. & A. Gray ex A. Gray var. glabrescens Dorn & Lichvar', 'In quis justo. Maecenas rhoncus aliquam lacus. Morbi quis tortor id nulla ultrices aliquet.', '2024-10-13 06:24:17', 'In Progress', 'Low', 5, 24);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (6, 'Pedilanthus tithymaloides (L.) Poit. ssp. angustifolius (Poit.) Dressler', 'Duis bibendum, felis sed interdum venenatis, turpis enim blandit mi, in porttitor pede justo eu massa. Donec dapibus. Duis at velit eu est congue elementum.', '2023-12-26 10:22:55', 'In Progress', 'High', 6, 25);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (7, 'Dichelostemma volubile (Kellogg) A. Heller', 'Sed ante. Vivamus tortor. Duis mattis egestas metus.', '2024-06-15 22:10:24', 'In Progress', 'Medium', 7, 26);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (8, 'Flavoparmelia Hale', 'Mauris enim leo, rhoncus sed, vestibulum sit amet, cursus id, turpis. Integer aliquet, massa id lobortis convallis, tortor risus dapibus augue, vel accumsan tellus nisi eu orci. Mauris lacinia sapien quis libero.', '2024-04-30 08:58:43', 'Completed', 'High', 8, 27);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (9, 'Astragalus conjunctus S. Watson var. rickardii S.L. Welsh, K. Beck & F. Caplow', 'Nullam porttitor lacus at turpis. Donec posuere metus vitae ipsum. Aliquam non mauris.', '2023-12-20 05:36:57', 'To-do', 'Medium', 9, 28);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (10, 'Antiphytum DC. & Meisn.', 'Quisque id justo sit amet sapien dignissim vestibulum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla dapibus dolor vel est. Donec odio justo, sollicitudin ut, suscipit a, feugiat et, eros.', '2024-04-23 06:48:56', 'In Progress', 'Low', 10, 29);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (11, 'Eriogonum contiguum (Reveal) Reveal', 'Maecenas tristique, est et tempus semper, est quam pharetra magna, ac consequat metus sapien ut nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris viverra diam vitae quam. Suspendisse potenti.', '2024-09-15 00:11:28', 'Completed', 'Low', 11, 30);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (12, 'Opegrapha Ach.', 'Integer ac leo. Pellentesque ultrices mattis odio. Donec vitae nisi.', '2024-03-01 09:34:57', 'In Progress', 'Low', 12, 31);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (13, 'Lupinus ×cymba-egressus C.P. Sm. (pro sp.)', 'Curabitur in libero ut massa volutpat convallis. Morbi odio odio, elementum eu, interdum eu, tincidunt in, leo. Maecenas pulvinar lobortis est.', '2024-09-06 06:43:34', 'In Progress', 'Medium', 13, 32);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (14, 'Viola pubescens Aiton var. peckii House', 'Maecenas leo odio, condimentum id, luctus nec, molestie sed, justo. Pellentesque viverra pede ac diam. Cras pellentesque volutpat dui.', '2024-01-21 11:11:21', 'To-do', 'High', 14, 33);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (15, 'Cliostomum griffithii (Sm.) Coppins', 'Nulla ut erat id mauris vulputate elementum. Nullam varius. Nulla facilisi.', '2023-11-30 23:45:44', 'Completed', 'Low', 15, 34);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (16, 'Cladonia cariosa (Ach.) Spreng.', 'In sagittis dui vel nisl. Duis ac nibh. Fusce lacus purus, aliquet at, feugiat non, pretium quis, lectus.', '2024-04-30 18:53:13', 'To-do', 'Medium', 16, 35);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (17, 'Phlyctidia ludoviciensis Müll. Arg.', 'Duis aliquam convallis nunc. Proin at turpis a pede posuere nonummy. Integer non velit.', '2024-08-12 12:14:41', 'Completed', 'Medium', 17, 36);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (18, 'Heterodermia erinacea (Ach.) W.A. Weber', 'Cras non velit nec nisi vulputate nonummy. Maecenas tincidunt lacus at velit. Vivamus vel nulla eget eros elementum pellentesque.', '2024-02-12 19:55:16', 'To-do', 'Low', 18, 37);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (19, 'Isoetes acadiensis Kott', 'Nam ultrices, libero non mattis pulvinar, nulla pede ullamcorper augue, a suscipit nulla elit ac nulla. Sed vel enim sit amet nunc viverra dapibus. Nulla suscipit ligula in lacus.', '2024-04-25 16:30:58', 'To-do', 'Medium', 19, 38);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (20, 'Matelea atrostellata Rintz', 'Fusce posuere felis sed lacus. Morbi sem mauris, laoreet ut, rhoncus aliquet, pulvinar sed, nisl. Nunc rhoncus dui vel sem.', '2024-07-18 17:44:10', 'Completed', 'Low', 20, 39);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (21, 'Festuca rubra L. ssp. vallicola (Rydb.) Pavlick', 'In congue. Etiam justo. Etiam pretium iaculis justo.', '2024-08-17 14:46:50', 'Completed', 'Medium', 21, 40);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (22, 'Thelypteris cyatheoides (Kaulf.) Fosberg', 'Vestibulum ac est lacinia nisi venenatis tristique. Fusce congue, diam id ornare imperdiet, sapien urna pretium nisl, ut volutpat sapien arcu sed augue. Aliquam erat volutpat.', '2024-09-20 00:39:07', 'To-do', 'Medium', 22, 41);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (23, 'Ocotea spathulata Mez', 'In hac habitasse platea dictumst. Etiam faucibus cursus urna. Ut tellus.', '2024-03-02 20:19:09', 'To-do', 'High', 23, 42);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (24, 'Hesperolinon drymarioides (Curran) Small', 'Nam ultrices, libero non mattis pulvinar, nulla pede ullamcorper augue, a suscipit nulla elit ac nulla. Sed vel enim sit amet nunc viverra dapibus. Nulla suscipit ligula in lacus.', '2023-12-31 03:36:32', 'Completed', 'High', 24, 43);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (25, 'Eriogonum ovalifolium Nutt. var. focarium Reveal & Mansfield', 'Morbi porttitor lorem id ligula. Suspendisse ornare consequat lectus. In est risus, auctor sed, tristique in, tempus sit amet, sem.', '2024-02-07 08:46:15', 'To-do', 'High', 25, 44);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (26, 'Collomia mazama Coville', 'Integer ac leo. Pellentesque ultrices mattis odio. Donec vitae nisi.', '2024-06-20 14:46:31', 'Completed', 'High', 26, 45);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (27, 'Utricularia foliosa L.', 'Pellentesque at nulla. Suspendisse potenti. Cras in purus eu magna vulputate luctus.', '2024-09-07 01:51:42', 'To-do', 'Low', 27, 46);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (28, 'Croton alabamensis E.A. Sm. ex Chapm. var. texensis Ginzbarg', 'Cras mi pede, malesuada in, imperdiet et, commodo vulputate, justo. In blandit ultrices enim. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', '2024-08-02 04:19:37', 'In Progress', 'Medium', 28, 47);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (29, 'Penstemon lemhiensis (D.D. Keck) D.D. Keck & Cronquist', 'Phasellus in felis. Donec semper sapien a libero. Nam dui.', '2024-05-13 04:54:59', 'To-do', 'High', 29, 48);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (30, 'Andropogon leucostachyus Kunth', 'Cras non velit nec nisi vulputate nonummy. Maecenas tincidunt lacus at velit. Vivamus vel nulla eget eros elementum pellentesque.', '2024-09-21 17:52:12', 'Completed', 'Low', 30, 49);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (31, 'Brachythecium acuminatum (Hedw.) Austin', 'Pellentesque at nulla. Suspendisse potenti. Cras in purus eu magna vulputate luctus.', '2024-04-17 22:33:23', 'To-do', 'Low', 19, 50);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (32, 'Rhynchosia difformis (Elliott) DC.', 'Duis consequat dui nec nisi volutpat eleifend. Donec ut dolor. Morbi vel lectus in quam fringilla rhoncus.', '2024-02-09 21:23:25', 'In Progress', 'Medium', 9, 51);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (33, 'Choisya dumosa (Torr.) A. Gray var. arizonica (Standl.) L.D. Benson', 'Praesent id massa id nisl venenatis lacinia. Aenean sit amet justo. Morbi ut odio.', '2024-01-28 21:07:43', 'Completed', 'High', 12, 52);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (34, 'Seymeria scabra A. Gray', 'Pellentesque at nulla. Suspendisse potenti. Cras in purus eu magna vulputate luctus.', '2024-08-16 16:07:30', 'To-do', 'High', 24, 53);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (35, 'Tragopogon mirabilis Rouy', 'Quisque id justo sit amet sapien dignissim vestibulum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla dapibus dolor vel est. Donec odio justo, sollicitudin ut, suscipit a, feugiat et, eros.', '2024-07-10 20:25:21', 'Completed', 'Medium', 6, 54);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (36, 'Calotis cuneifolia R. Br.', 'Nullam sit amet turpis elementum ligula vehicula consequat. Morbi a ipsum. Integer a nibh.', '2023-12-02 06:10:45', 'To-do', 'Low', 21, 55);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (37, 'Acacia muricata (L.) Willd.', 'Vestibulum quam sapien, varius ut, blandit non, interdum in, ante. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Duis faucibus accumsan odio. Curabitur convallis.', '2024-10-05 18:27:03', 'In Progress', 'Low', 12, 56);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (38, 'Koerberia A. Massal.', 'Curabitur in libero ut massa volutpat convallis. Morbi odio odio, elementum eu, interdum eu, tincidunt in, leo. Maecenas pulvinar lobortis est.', '2024-04-21 10:53:43', 'In Progress', 'High', 12, 57);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (39, 'Caloplaca brattiae W.A. Weber', 'Donec diam neque, vestibulum eget, vulputate ut, ultrices vel, augue. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec pharetra, magna vestibulum aliquet ultrices, erat tortor sollicitudin mi, sit amet lobortis sapien sapien non mi. Integer ac neque.', '2024-06-22 02:19:05', 'In Progress', 'High', 15, 58);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (40, 'Scaevola hobdyi W.L. Wagner', 'Proin interdum mauris non ligula pellentesque ultrices. Phasellus id sapien in sapien iaculis congue. Vivamus metus arcu, adipiscing molestie, hendrerit at, vulputate vitae, nisl.', '2024-09-11 08:00:37', 'In Progress', 'Medium', 20, 59);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (41, 'Pyrenula ochraceoflavens (Nyl.) R.C. Harris', 'Maecenas ut massa quis augue luctus tincidunt. Nulla mollis molestie lorem. Quisque ut erat.', '2024-10-19 00:08:29', 'In Progress', 'High', 29, 60);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (42, 'Erodium moschatum (L.) L''Hér. ex Aiton var. moschatum', 'In quis justo. Maecenas rhoncus aliquam lacus. Morbi quis tortor id nulla ultrices aliquet.', '2024-01-28 04:47:49', 'Completed', 'Low', 3, 61);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (43, 'Dalea laniceps Barneby', 'Fusce posuere felis sed lacus. Morbi sem mauris, laoreet ut, rhoncus aliquet, pulvinar sed, nisl. Nunc rhoncus dui vel sem.', '2023-12-20 04:18:44', 'In Progress', 'Medium', 27, 62);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (44, 'Spigelia hedyotidea A. DC.', 'In quis justo. Maecenas rhoncus aliquam lacus. Morbi quis tortor id nulla ultrices aliquet.', '2023-12-01 07:23:18', 'To-do', 'High', 26, 63);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (45, 'Oreoxis Raf.', 'Mauris enim leo, rhoncus sed, vestibulum sit amet, cursus id, turpis. Integer aliquet, massa id lobortis convallis, tortor risus dapibus augue, vel accumsan tellus nisi eu orci. Mauris lacinia sapien quis libero.', '2024-09-21 06:24:45', 'To-do', 'Low', 15, 64);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (46, 'Hymenocallis henryae Traub var. glaucifolia J.N. Henry & G. Lom. Sm.', 'Aliquam quis turpis eget elit sodales scelerisque. Mauris sit amet eros. Suspendisse accumsan tortor quis turpis.', '2024-05-08 03:43:18', 'To-do', 'Medium', 27, 65);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (47, 'Brickellia grandiflora (Hook.) Nutt.', 'Duis consequat dui nec nisi volutpat eleifend. Donec ut dolor. Morbi vel lectus in quam fringilla rhoncus.', '2024-08-18 20:49:15', 'In Progress', 'High', 7, 66);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (48, 'Astragalus desperatus M.E. Jones var. neeseae Barneby', 'Cras non velit nec nisi vulputate nonummy. Maecenas tincidunt lacus at velit. Vivamus vel nulla eget eros elementum pellentesque.', '2024-01-06 06:51:00', 'Completed', 'Medium', 18, 67);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (49, 'Penstemon bicolor (Brandegee) Clokey & D.D. Keck ssp. roseus Clokey & D.D. Keck', 'In congue. Etiam justo. Etiam pretium iaculis justo.', '2024-08-19 17:21:01', 'In Progress', 'Low', 24, 68);
insert into Task (task_id, name, description, due_date, status, priority, proj_id, assigned_member) values (50, 'Asplenium trichomanes L. ssp. quadrivalens D.E. Mey.', 'Duis aliquam convallis nunc. Proin at turpis a pede posuere nonummy. Integer non velit.', '2024-06-28 07:23:20', 'Completed', 'High', 6, 69);

insert into Subtask (subtask_id, name, description, status, task_id) values (1, 'Semnopithecus entellus', 'Praesent blandit. Nam nulla. Integer pede justo, lacinia eget, tincidunt eget, tempus vel, pede.', 'Completed', 4);
insert into Subtask (subtask_id, name, description, status, task_id) values (2, 'Tamiasciurus hudsonicus', 'Praesent id massa id nisl venenatis lacinia. Aenean sit amet justo. Morbi ut odio.', 'In Progress', 19);
insert into Subtask (subtask_id, name, description, status, task_id) values (3, 'Sus scrofa', 'Maecenas tristique, est et tempus semper, est quam pharetra magna, ac consequat metus sapien ut nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris viverra diam vitae quam. Suspendisse potenti.', 'In Progress', 27);
insert into Subtask (subtask_id, name, description, status, task_id) values (4, 'Eira barbata', 'Duis consequat dui nec nisi volutpat eleifend. Donec ut dolor. Morbi vel lectus in quam fringilla rhoncus.', 'To-do', 10);
insert into Subtask (subtask_id, name, description, status, task_id) values (5, 'Cereopsis novaehollandiae', 'Duis bibendum, felis sed interdum venenatis, turpis enim blandit mi, in porttitor pede justo eu massa. Donec dapibus. Duis at velit eu est congue elementum.', 'Completed', 3);
insert into Subtask (subtask_id, name, description, status, task_id) values (6, 'Eolophus roseicapillus', 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus vestibulum sagittis sapien. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.', 'In Progress', 50);
insert into Subtask (subtask_id, name, description, status, task_id) values (7, 'Haliaeetus leucoryphus', 'Phasellus sit amet erat. Nulla tempus. Vivamus in felis eu sapien cursus vestibulum.', 'In Progress', 40);
insert into Subtask (subtask_id, name, description, status, task_id) values (8, 'Drymarchon corias couperi', 'Integer tincidunt ante vel ipsum. Praesent blandit lacinia erat. Vestibulum sed magna at nunc commodo placerat.', 'To-do', 23);
insert into Subtask (subtask_id, name, description, status, task_id) values (9, 'Bassariscus astutus', 'Aenean lectus. Pellentesque eget nunc. Donec quis orci eget orci vehicula condimentum.', 'In Progress', 6);
insert into Subtask (subtask_id, name, description, status, task_id) values (10, 'Trichoglossus chlorolepidotus', 'Pellentesque at nulla. Suspendisse potenti. Cras in purus eu magna vulputate luctus.', 'To-do', 40);
insert into Subtask (subtask_id, name, description, status, task_id) values (11, 'Nyctanassa violacea', 'Maecenas tristique, est et tempus semper, est quam pharetra magna, ac consequat metus sapien ut nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris viverra diam vitae quam. Suspendisse potenti.', 'In Progress', 9);
insert into Subtask (subtask_id, name, description, status, task_id) values (12, 'Chelodina longicollis', 'Nam ultrices, libero non mattis pulvinar, nulla pede ullamcorper augue, a suscipit nulla elit ac nulla. Sed vel enim sit amet nunc viverra dapibus. Nulla suscipit ligula in lacus.', 'Completed', 28);
insert into Subtask (subtask_id, name, description, status, task_id) values (13, 'Rhea americana', 'Vestibulum ac est lacinia nisi venenatis tristique. Fusce congue, diam id ornare imperdiet, sapien urna pretium nisl, ut volutpat sapien arcu sed augue. Aliquam erat volutpat.', 'Completed', 31);
insert into Subtask (subtask_id, name, description, status, task_id) values (14, 'Melanerpes erythrocephalus', 'In hac habitasse platea dictumst. Morbi vestibulum, velit id pretium iaculis, diam erat fermentum justo, nec condimentum neque sapien placerat ante. Nulla justo.', 'Completed', 4);
insert into Subtask (subtask_id, name, description, status, task_id) values (15, 'Mazama gouazoubira', 'In sagittis dui vel nisl. Duis ac nibh. Fusce lacus purus, aliquet at, feugiat non, pretium quis, lectus.', 'To-do', 33);
insert into Subtask (subtask_id, name, description, status, task_id) values (16, 'Fulica cristata', 'Quisque id justo sit amet sapien dignissim vestibulum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla dapibus dolor vel est. Donec odio justo, sollicitudin ut, suscipit a, feugiat et, eros.', 'To-do', 40);
insert into Subtask (subtask_id, name, description, status, task_id) values (17, 'Trichoglossus chlorolepidotus', 'Proin eu mi. Nulla ac enim. In tempor, turpis nec euismod scelerisque, quam turpis adipiscing lorem, vitae mattis nibh ligula nec sem.', 'Completed', 16);
insert into Subtask (subtask_id, name, description, status, task_id) values (18, 'Tauraco porphyrelophus', 'Morbi non lectus. Aliquam sit amet diam in magna bibendum imperdiet. Nullam orci pede, venenatis non, sodales sed, tincidunt eu, felis.', 'To-do', 14);
insert into Subtask (subtask_id, name, description, status, task_id) values (19, 'Tragelaphus strepsiceros', 'Suspendisse potenti. In eleifend quam a odio. In hac habitasse platea dictumst.', 'In Progress', 8);
insert into Subtask (subtask_id, name, description, status, task_id) values (20, 'Bradypus tridactylus', 'Duis consequat dui nec nisi volutpat eleifend. Donec ut dolor. Morbi vel lectus in quam fringilla rhoncus.', 'In Progress', 28);
insert into Subtask (subtask_id, name, description, status, task_id) values (21, 'Paroaria gularis', 'Aliquam quis turpis eget elit sodales scelerisque. Mauris sit amet eros. Suspendisse accumsan tortor quis turpis.', 'To-do', 48);
insert into Subtask (subtask_id, name, description, status, task_id) values (22, 'Motacilla aguimp', 'Integer ac leo. Pellentesque ultrices mattis odio. Donec vitae nisi.', 'To-do', 36);
insert into Subtask (subtask_id, name, description, status, task_id) values (23, 'Martes pennanti', 'Fusce consequat. Nulla nisl. Nunc nisl.', 'Completed', 9);
insert into Subtask (subtask_id, name, description, status, task_id) values (24, 'Pteronura brasiliensis', 'Etiam vel augue. Vestibulum rutrum rutrum neque. Aenean auctor gravida sem.', 'To-do', 40);
insert into Subtask (subtask_id, name, description, status, task_id) values (25, 'Canis lupus baileyi', 'Sed ante. Vivamus tortor. Duis mattis egestas metus.', 'To-do', 39);

insert into Invitation (user_id, proj_id, coord_id, approved) values (1, 1, 20, false);
insert into Invitation (user_id, proj_id, coord_id, approved) values (2, 2, 21, false);
insert into Invitation (user_id, proj_id, coord_id, approved) values (3, 3, 22, false);
insert into Invitation (user_id, proj_id, coord_id, approved) values (4, 4, 23, false);
insert into Invitation (user_id, proj_id, coord_id, approved) values (5, 5, 24, false);
insert into Invitation (user_id, proj_id, coord_id, approved) values (6, 6, 25, false);
insert into Invitation (user_id, proj_id, coord_id, approved) values (7, 7, 26, false);
insert into Invitation (user_id, proj_id, coord_id, approved) values (8, 8, 27, false);
insert into Invitation (user_id, proj_id, coord_id, approved) values (9, 9, 28, false);
insert into Invitation (user_id, proj_id, coord_id, approved) values (10, 10, 29, false);
insert into Invitation (user_id, proj_id, coord_id, approved) values (11, 11, 30, false);
insert into Invitation (user_id, proj_id, coord_id, approved) values (12, 12, 31, false);
insert into Invitation (user_id, proj_id, coord_id, approved) values (13, 13, 32, false);
insert into Invitation (user_id, proj_id, coord_id, approved) values (14, 14, 33, false);
insert into Invitation (user_id, proj_id, coord_id, approved) values (15, 15, 34, false);
insert into Invitation (user_id, proj_id, coord_id, approved) values (16, 16, 35, false);
insert into Invitation (user_id, proj_id, coord_id, approved) values (17, 17, 36, false);
insert into Invitation (user_id, proj_id, coord_id, approved) values (18, 18, 37, false);
insert into Invitation (user_id, proj_id, coord_id, approved) values (19, 19, 38, false);
insert into Invitation (user_id, proj_id, coord_id, approved) values (20, 20, 39, false);

insert into Post (post_id, date, content, assigned_member, proj_id) values (1, '2024-09-01 05:39:14', 'Etiam vel augue. Vestibulum rutrum rutrum neque. Aenean auctor gravida sem.', 20, 1);
insert into Post (post_id, date, content, assigned_member, proj_id) values (2, '2024-02-20 04:13:38', 'Phasellus in felis. Donec semper sapien a libero. Nam dui.', 21, 2);
insert into Post (post_id, date, content, assigned_member, proj_id) values (3, '2024-05-05 05:59:02', 'In sagittis dui vel nisl. Duis ac nibh. Fusce lacus purus, aliquet at, feugiat non, pretium quis, lectus.', 22, 3);
insert into Post (post_id, date, content, assigned_member, proj_id) values (4, '2024-01-11 05:22:44', 'Fusce consequat. Nulla nisl. Nunc nisl.', 23, 4);
insert into Post (post_id, date, content, assigned_member, proj_id) values (5, '2024-09-23 05:27:38', 'Proin interdum mauris non ligula pellentesque ultrices. Phasellus id sapien in sapien iaculis congue. Vivamus metus arcu, adipiscing molestie, hendrerit at, vulputate vitae, nisl.', 24, 5);
insert into Post (post_id, date, content, assigned_member, proj_id) values (6, '2024-07-28 21:36:12', 'Praesent id massa id nisl venenatis lacinia. Aenean sit amet justo. Morbi ut odio.', 25, 6);
insert into Post (post_id, date, content, assigned_member, proj_id) values (7, '2024-05-29 15:52:27', 'Proin leo odio, porttitor id, consequat in, consequat ut, nulla. Sed accumsan felis. Ut at dolor quis odio consequat varius.', 26, 7);
insert into Post (post_id, date, content, assigned_member, proj_id) values (8, '2024-01-04 20:36:58', 'Aenean fermentum. Donec ut mauris eget massa tempor convallis. Nulla neque libero, convallis eget, eleifend luctus, ultricies eu, nibh.', 27, 8);
insert into Post (post_id, date, content, assigned_member, proj_id) values (9, '2024-09-23 18:22:36', 'Duis aliquam convallis nunc. Proin at turpis a pede posuere nonummy. Integer non velit.', 28, 9);
insert into Post (post_id, date, content, assigned_member, proj_id) values (10, '2024-05-09 18:23:56', 'Duis bibendum. Morbi non quam nec dui luctus rutrum. Nulla tellus.', 29, 10);
insert into Post (post_id, date, content, assigned_member, proj_id) values (11, '2024-09-18 02:06:01', 'Nulla ut erat id mauris vulputate elementum. Nullam varius. Nulla facilisi.', 30, 11);
insert into Post (post_id, date, content, assigned_member, proj_id) values (12, '2024-04-29 08:34:57', 'In hac habitasse platea dictumst. Morbi vestibulum, velit id pretium iaculis, diam erat fermentum justo, nec condimentum neque sapien placerat ante. Nulla justo.', 31, 12);
insert into Post (post_id, date, content, assigned_member, proj_id) values (13, '2024-09-22 20:25:51', 'Curabitur at ipsum ac tellus semper interdum. Mauris ullamcorper purus sit amet nulla. Quisque arcu libero, rutrum ac, lobortis vel, dapibus at, diam.', 32, 13);
insert into Post (post_id, date, content, assigned_member, proj_id) values (14, '2024-06-06 13:26:58', 'Maecenas ut massa quis augue luctus tincidunt. Nulla mollis molestie lorem. Quisque ut erat.', 33, 14);
insert into Post (post_id, date, content, assigned_member, proj_id) values (15, '2024-10-21 19:57:11', 'Duis bibendum. Morbi non quam nec dui luctus rutrum. Nulla tellus.', 34, 15);

insert into Employee (comp_id, user_id) values (1, 1);
insert into Employee (comp_id, user_id) values (2, 2);
insert into Employee (comp_id, user_id) values (3, 3);
insert into Employee (comp_id, user_id) values (4, 4);
insert into Employee (comp_id, user_id) values (5, 5);
insert into Employee (comp_id, user_id) values (6, 6);
insert into Employee (comp_id, user_id) values (7, 7);
insert into Employee (comp_id, user_id) values (8, 8);
insert into Employee (comp_id, user_id) values (9, 9);
insert into Employee (comp_id, user_id) values (10, 10);
insert into Employee (comp_id, user_id) values (11, 11);
insert into Employee (comp_id, user_id) values (12, 12);
insert into Employee (comp_id, user_id) values (13, 13);
insert into Employee (comp_id, user_id) values (14, 14);
insert into Employee (comp_id, user_id) values (15, 15);
insert into Employee (comp_id, user_id) values (16, 16);
insert into Employee (comp_id, user_id) values (17, 17);
insert into Employee (comp_id, user_id) values (18, 18);
insert into Employee (comp_id, user_id) values (19, 19);
insert into Employee (comp_id, user_id) values (20, 20);
insert into Employee (comp_id, user_id) values (21, 21);
insert into Employee (comp_id, user_id) values (22, 22);
insert into Employee (comp_id, user_id) values (23, 23);
insert into Employee (comp_id, user_id) values (24, 24);
insert into Employee (comp_id, user_id) values (25, 25);
insert into Employee (comp_id, user_id) values (26, 26);
insert into Employee (comp_id, user_id) values (27, 27);
insert into Employee (comp_id, user_id) values (28, 28);
insert into Employee (comp_id, user_id) values (29, 29);
insert into Employee (comp_id, user_id) values (30, 30);
insert into Employee (comp_id, user_id) values (31, 31);
insert into Employee (comp_id, user_id) values (32, 32);
insert into Employee (comp_id, user_id) values (33, 33);
insert into Employee (comp_id, user_id) values (34, 34);
insert into Employee (comp_id, user_id) values (35, 35);
insert into Employee (comp_id, user_id) values (36, 36);
insert into Employee (comp_id, user_id) values (37, 37);
insert into Employee (comp_id, user_id) values (38, 38);
insert into Employee (comp_id, user_id) values (39, 39);
insert into Employee (comp_id, user_id) values (40, 40);
insert into Employee (comp_id, user_id) values (41, 41);
insert into Employee (comp_id, user_id) values (42, 42);
insert into Employee (comp_id, user_id) values (43, 43);
insert into Employee (comp_id, user_id) values (44, 44);
insert into Employee (comp_id, user_id) values (45, 45);
insert into Employee (comp_id, user_id) values (46, 46);
insert into Employee (comp_id, user_id) values (47, 47);
insert into Employee (comp_id, user_id) values (48, 48);
insert into Employee (comp_id, user_id) values (49, 49);
insert into Employee (comp_id, user_id) values (50, 50);
insert into Employee (comp_id, user_id) values (1, 51);
insert into Employee (comp_id, user_id) values (2, 52);
insert into Employee (comp_id, user_id) values (3, 53);
insert into Employee (comp_id, user_id) values (4, 54);
insert into Employee (comp_id, user_id) values (5, 55);
insert into Employee (comp_id, user_id) values (6, 56);
insert into Employee (comp_id, user_id) values (7, 57);
insert into Employee (comp_id, user_id) values (8, 58);
insert into Employee (comp_id, user_id) values (9, 59);
insert into Employee (comp_id, user_id) values (10, 60);
insert into Employee (comp_id, user_id) values (11, 61);
insert into Employee (comp_id, user_id) values (12, 62);
insert into Employee (comp_id, user_id) values (13, 63);
insert into Employee (comp_id, user_id) values (14, 64);
insert into Employee (comp_id, user_id) values (15, 65);
insert into Employee (comp_id, user_id) values (16, 66);
insert into Employee (comp_id, user_id) values (17, 67);
insert into Employee (comp_id, user_id) values (18, 68);
insert into Employee (comp_id, user_id) values (19, 69);
insert into Employee (comp_id, user_id) values (20, 70);
insert into Employee (comp_id, user_id) values (21, 71);
insert into Employee (comp_id, user_id) values (22, 72);
insert into Employee (comp_id, user_id) values (23, 73);
insert into Employee (comp_id, user_id) values (24, 74);
insert into Employee (comp_id, user_id) values (25, 75);
insert into Employee (comp_id, user_id) values (26, 76);
insert into Employee (comp_id, user_id) values (27, 77);
insert into Employee (comp_id, user_id) values (28, 78);
insert into Employee (comp_id, user_id) values (29, 79);
insert into Employee (comp_id, user_id) values (30, 80);
insert into Employee (comp_id, user_id) values (31, 81);
insert into Employee (comp_id, user_id) values (32, 82);
insert into Employee (comp_id, user_id) values (33, 83);
insert into Employee (comp_id, user_id) values (34, 84);
insert into Employee (comp_id, user_id) values (35, 85);
insert into Employee (comp_id, user_id) values (36, 86);
insert into Employee (comp_id, user_id) values (37, 87);
insert into Employee (comp_id, user_id) values (38, 88);
insert into Employee (comp_id, user_id) values (39, 89);
insert into Employee (comp_id, user_id) values (40, 90);
insert into Employee (comp_id, user_id) values (41, 91);
insert into Employee (comp_id, user_id) values (42, 92);
insert into Employee (comp_id, user_id) values (43, 93);
insert into Employee (comp_id, user_id) values (44, 94);
insert into Employee (comp_id, user_id) values (45, 95);
insert into Employee (comp_id, user_id) values (46, 96);
insert into Employee (comp_id, user_id) values (47, 97);
insert into Employee (comp_id, user_id) values (48, 98);
insert into Employee (comp_id, user_id) values (49, 99);
insert into Employee (comp_id, user_id) values (50, 100);

insert into Comment (comment_id, date, content, task_id, assigned_member, reply) values (1, '2024-08-26 12:26:48', 'Morbi non lectus. Aliquam sit amet diam in magna bibendum imperdiet. Nullam orci pede, venenatis non, sodales sed, tincidunt eu, felis.', 1, 20, 0);
insert into Comment (comment_id, date, content, task_id, assigned_member, reply) values (2, '2024-05-15 23:54:01', 'Duis consequat dui nec nisi volutpat eleifend. Donec ut dolor. Morbi vel lectus in quam fringilla rhoncus.', 2, 21, 5);
insert into Comment (comment_id, date, content, task_id, assigned_member, reply) values (3, '2024-06-06 22:07:31', 'Sed ante. Vivamus tortor. Duis mattis egestas metus.', 3, 22, 3);
insert into Comment (comment_id, date, content, task_id, assigned_member, reply) values (4, '2024-05-31 21:08:51', 'Maecenas leo odio, condimentum id, luctus nec, molestie sed, justo. Pellentesque viverra pede ac diam. Cras pellentesque volutpat dui. 
Maecenas tristique, est et tempus semper, est quam pharetra magna, ac consequat metus sapien ut nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris viverra diam vitae quam. Suspendisse potenti.', 4, 23, 0);
insert into Comment (comment_id, date, content, task_id, assigned_member, reply) values (5, '2024-01-13 15:55:51', 'In hac habitasse platea dictumst. Etiam faucibus cursus urna. Ut tellus.', 5, 24, 1);
insert into Comment (comment_id, date, content, task_id, assigned_member, reply) values (6, '2024-05-11 14:01:54', 'Curabitur gravida nisi at nibh. In hac habitasse platea dictumst. Aliquam augue quam, sollicitudin vitae, consectetuer eget, rutrum at, lorem.', 6, 25, 4);
insert into Comment (comment_id, date, content, task_id, assigned_member, reply) values (7, '2024-04-14 18:33:20', 'Duis consequat dui nec nisi volutpat eleifend. Donec ut dolor. Morbi vel lectus in quam fringilla rhoncus.', 7, 26, 4);
insert into Comment (comment_id, date, content, task_id, assigned_member, reply) values (8, '2024-04-18 09:22:10', 'Aenean lectus. Pellentesque eget nunc. Donec quis orci eget orci vehicula condimentum.
Curabitur in libero ut massa volutpat convallis. Morbi odio odio, elementum eu, interdum eu, tincidunt in, leo. Maecenas pulvinar lobortis est.', 8, 27, 2);
insert into Comment (comment_id, date, content, task_id, assigned_member, reply) values (9, '2024-06-05 06:44:37', 'Curabitur in libero ut massa volutpat convallis. Morbi odio odio, elementum eu, interdum eu, tincidunt in, leo. Maecenas pulvinar lobortis est.
Phasellus sit amet erat. Nulla tempus. Vivamus in felis eu sapien cursus vestibulum.', 9, 28, 2);
insert into Comment (comment_id, date, content, task_id, assigned_member, reply) values (10, '2023-12-26 20:35:32', 'Proin interdum mauris non ligula pellentesque ultrices. Phasellus id sapien in sapien iaculis congue. Vivamus metus arcu, adipiscing molestie, hendrerit at, vulputate vitae, nisl.
Aenean lectus. Pellentesque eget nunc. Donec quis orci eget orci vehicula condimentum.', 10, 29, 4);
insert into Comment (comment_id, date, content, task_id, assigned_member, reply) values (11, '2024-08-22 20:32:19', 'Mauris enim leo, rhoncus sed, vestibulum sit amet, cursus id, turpis. Integer aliquet, massa id lobortis convallis, tortor risus dapibus augue, vel accumsan tellus nisi eu orci. Mauris lacinia sapien quis libero.
Nullam sit amet turpis elementum ligula vehicula consequat. Morbi a ipsum. Integer a nibh.', 11, 30, 3);
insert into Comment (comment_id, date, content, task_id, assigned_member, reply) values (12, '2024-09-07 15:18:46', 'Nam ultrices, libero non mattis pulvinar, nulla pede ullamcorper augue, a suscipit nulla elit ac nulla. Sed vel enim sit amet nunc viverra dapibus. Nulla suscipit ligula in lacus.', 12, 31, 0);
insert into Comment (comment_id, date, content, task_id, assigned_member, reply) values (13, '2023-12-21 00:47:06', 'Proin interdum mauris non ligula pellentesque ultrices. Phasellus id sapien in sapien iaculis congue. Vivamus metus arcu, adipiscing molestie, hendrerit at, vulputate vitae, nisl.
Aenean lectus. Pellentesque eget nunc. Donec quis orci eget orci vehicula condimentum.', 13, 32, 5);
insert into Comment (comment_id, date, content, task_id, assigned_member, reply) values (14, '2024-06-12 11:01:42', 'Pellentesque at nulla. Suspendisse potenti. Cras in purus eu magna vulputate luctus.', 14, 33, 3);
insert into Comment (comment_id, date, content, task_id, assigned_member, reply) values (15, '2024-09-04 19:11:35', 'Proin eu mi. Nulla ac enim. In tempor, turpis nec euismod scelerisque, quam turpis adipiscing lorem, vitae mattis nibh ligula nec sem.', 15, 34, 4);
insert into Comment (comment_id, date, content, task_id, assigned_member, reply) values (16, '2024-04-05 02:09:52', 'Duis aliquam convallis nunc. Proin at turpis a pede posuere nonummy. Integer non velit.
Donec diam neque, vestibulum eget, vulputate ut, ultrices vel, augue. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec pharetra, magna vestibulum aliquet ultrices, erat tortor sollicitudin mi, sit amet lobortis sapien sapien non mi. Integer ac neque.', 16, 35, 1);
insert into Comment (comment_id, date, content, task_id, assigned_member, reply) values (17, '2023-12-31 09:14:32', 'Phasellus in felis. Donec semper sapien a libero. Nam dui.
Proin leo odio, porttitor id, consequat in, consequat ut, nulla. Sed accumsan felis. Ut at dolor quis odio consequat varius.', 17, 36, 4);
insert into Comment (comment_id, date, content, task_id, assigned_member, reply) values (18, '2024-03-29 06:43:46', 'Duis bibendum. Morbi non quam nec dui luctus rutrum. Nulla tellus.', 18, 37, 1);
insert into Comment (comment_id, date, content, task_id, assigned_member, reply) values (19, '2024-03-08 02:14:48', 'In hac habitasse platea dictumst. Morbi vestibulum, velit id pretium iaculis, diam erat fermentum justo, nec condimentum neque sapien placerat ante. Nulla justo.', 19, 38, 5);
insert into Comment (comment_id, date, content, task_id, assigned_member, reply) values (20, '2024-03-02 08:32:36', 'Curabitur gravida nisi at nibh. In hac habitasse platea dictumst. Aliquam augue quam, sollicitudin vitae, consectetuer eget, rutrum at, lorem.', 20, 39, 3);
insert into Comment (comment_id, date, content, task_id, assigned_member, reply) values (21, '2024-02-28 19:31:11', 'Nulla ut erat id mauris vulputate elementum. Nullam varius. Nulla facilisi.
Cras non velit nec nisi vulputate nonummy. Maecenas tincidunt lacus at velit. Vivamus vel nulla eget eros elementum pellentesque.', 21, 40, 3);
insert into Comment (comment_id, date, content, task_id, assigned_member, reply) values (22, '2024-04-28 19:16:15', 'In hac habitasse platea dictumst. Etiam faucibus cursus urna. Ut tellus.
Nulla ut erat id mauris vulputate elementum. Nullam varius. Nulla facilisi.', 22, 41, 3);
insert into Comment (comment_id, date, content, task_id, assigned_member, reply) values (23, '2024-03-20 16:24:41', 'Duis bibendum. Morbi non quam nec dui luctus rutrum. Nulla tellus.', 23, 42, 2);
insert into Comment (comment_id, date, content, task_id, assigned_member, reply) values (24, '2024-04-15 12:07:04', 'Aliquam quis turpis eget elit sodales scelerisque. Mauris sit amet eros. Suspendisse accumsan tortor quis turpis.', 24, 43, 4);
insert into Comment (comment_id, date, content, task_id, assigned_member, reply) values (25, '2024-03-18 03:44:05', 'Sed sagittis. Nam congue, risus semper porta volutpat, quam pede lobortis ligula, sit amet eleifend pede libero quis orci. Nullam molestie nibh in lectus.
Pellentesque at nulla. Suspendisse potenti. Cras in purus eu magna vulputate luctus.', 25, 44, 5);
insert into Comment (comment_id, date, content, task_id, assigned_member, reply) values (26, '2024-09-07 23:38:47', 'Suspendisse potenti. In eleifend quam a odio. In hac habitasse platea dictumst.
Maecenas ut massa quis augue luctus tincidunt. Nulla mollis molestie lorem. Quisque ut erat.', 26, 45, 5);
insert into Comment (comment_id, date, content, task_id, assigned_member, reply) values (27, '2024-07-16 04:31:00', 'Sed sagittis. Nam congue, risus semper porta volutpat, quam pede lobortis ligula, sit amet eleifend pede libero quis orci. Nullam molestie nibh in lectus.
Pellentesque at nulla. Suspendisse potenti. Cras in purus eu magna vulputate luctus.', 27, 46, 1);
insert into Comment (comment_id, date, content, task_id, assigned_member, reply) values (28, '2024-06-03 01:58:53', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Proin risus. Praesent lectus.
Vestibulum quam sapien, varius ut, blandit non, interdum in, ante. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Duis faucibus accumsan odio. Curabitur convallis.', 28, 47, 2);
insert into Comment (comment_id, date, content, task_id, assigned_member, reply) values (29, '2023-12-04 17:58:49', 'Integer tincidunt ante vel ipsum. Praesent blandit lacinia erat. Vestibulum sed magna at nunc commodo placerat.
Praesent blandit. Nam nulla. Integer pede justo, lacinia eget, tincidunt eget, tempus vel, pede.', 29, 48, 5);
insert into Comment (comment_id, date, content, task_id, assigned_member, reply) values (30, '2024-06-13 09:54:22', 'Morbi porttitor lorem id ligula. Suspendisse ornare consequat lectus. In est risus, auctor sed, tristique in, tempus sit amet, sem.
Fusce consequat. Nulla nisl. Nunc nisl.', 30, 49, 5);

insert into Assignment_notification (notif_id, task_id) values (35, 19);
insert into Assignment_notification (notif_id, task_id) values (36, 9);
insert into Assignment_notification (notif_id, task_id) values (37, 44);
insert into Assignment_notification (notif_id, task_id) values (38, 47);
insert into Assignment_notification (notif_id, task_id) values (39, 46);
insert into Assignment_notification (notif_id, task_id) values (40, 2);
insert into Assignment_notification (notif_id, task_id) values (41, 18);
insert into Assignment_notification (notif_id, task_id) values (42, 7);
insert into Assignment_notification (notif_id, task_id) values (43, 5);
insert into Assignment_notification (notif_id, task_id) values (44, 18);
insert into Assignment_notification (notif_id, task_id) values (45, 41);
insert into Assignment_notification (notif_id, task_id) values (46, 11);
insert into Assignment_notification (notif_id, task_id) values (47, 40);
insert into Assignment_notification (notif_id, task_id) values (48, 6);
insert into Assignment_notification (notif_id, task_id) values (49, 38);
insert into Assignment_notification (notif_id, task_id) values (50, 30);
insert into Assignment_notification (notif_id, task_id) values (51, 16);
insert into Assignment_notification (notif_id, task_id) values (52, 50);
insert into Assignment_notification (notif_id, task_id) values (53, 21);
insert into Assignment_notification (notif_id, task_id) values (54, 3);
insert into Assignment_notification (notif_id, task_id) values (55, 37);
insert into Assignment_notification (notif_id, task_id) values (56, 6);
insert into Assignment_notification (notif_id, task_id) values (57, 16);
insert into Assignment_notification (notif_id, task_id) values (58, 32);
insert into Assignment_notification (notif_id, task_id) values (59, 23);
insert into Assignment_notification (notif_id, task_id) values (60, 19);
insert into Assignment_notification (notif_id, task_id) values (61, 34);
insert into Assignment_notification (notif_id, task_id) values (62, 33);
insert into Assignment_notification (notif_id, task_id) values (63, 11);
insert into Assignment_notification (notif_id, task_id) values (64, 26);
insert into Assignment_notification (notif_id, task_id) values (65, 31);
insert into Assignment_notification (notif_id, task_id) values (66, 17);
insert into Assignment_notification (notif_id, task_id) values (67, 22);
insert into Assignment_notification (notif_id, task_id) values (68, 10);
insert into Assignment_notification (notif_id, task_id) values (69, 28);

insert into Comment_notification (notif_id, comment_id) values (70, 4);
insert into Comment_notification (notif_id, comment_id) values (71, 12);
insert into Comment_notification (notif_id, comment_id) values (72, 25);
insert into Comment_notification (notif_id, comment_id) values (73, 22);
insert into Comment_notification (notif_id, comment_id) values (74, 13);
insert into Comment_notification (notif_id, comment_id) values (75, 17);
insert into Comment_notification (notif_id, comment_id) values (76, 14);
insert into Comment_notification (notif_id, comment_id) values (77, 25);
insert into Comment_notification (notif_id, comment_id) values (78, 11);
insert into Comment_notification (notif_id, comment_id) values (79, 7);
insert into Comment_notification (notif_id, comment_id) values (80, 12);
insert into Comment_notification (notif_id, comment_id) values (81, 6);
insert into Comment_notification (notif_id, comment_id) values (82, 12);
insert into Comment_notification (notif_id, comment_id) values (83, 20);
insert into Comment_notification (notif_id, comment_id) values (84, 11);

```

---

## Revision history

Changes made to the first submission:

1. Item 1
2. ..
