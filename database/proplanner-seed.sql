create schema if not exists lbaw23132;
set search_path to lbaw23132;

DROP INDEX IF EXISTS project_name_search;
DROP INDEX IF EXISTS tasks_id_project;
DROP INDEX IF EXISTS members_id_project;
DROP INDEX IF EXISTS projects_id_user;
DROP TABLE IF EXISTS comment_notification CASCADE;
DROP TABLE IF EXISTS assignment_notification CASCADE;
DROP TABLE IF EXISTS project_notification CASCADE;
DROP TABLE IF EXISTS notification CASCADE;
DROP TABLE IF EXISTS comment CASCADE;
DROP TABLE IF EXISTS employee CASCADE;
DROP TABLE IF EXISTS post CASCADE;
DROP TABLE IF EXISTS password_reset_tokens CASCADE;
DROP TABLE IF EXISTS invitation CASCADE;
DROP TABLE IF EXISTS subtask CASCADE;
DROP TABLE IF EXISTS task CASCADE;
DROP TABLE IF EXISTS project_member CASCADE;
DROP TABLE IF EXISTS project CASCADE;
DROP TABLE IF EXISTS favorite CASCADE;
DROP TABLE IF EXISTS archive CASCADE;
DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS company CASCADE;
DROP TABLE IF EXISTS support CASCADE;
DROP TYPE IF EXISTS priority_task;
DROP TYPE IF EXISTS status_task;

DROP FUNCTION IF EXISTS task_status_upd() CASCADE;
DROP FUNCTION IF EXISTS proj_prog() CASCADE;
DROP FUNCTION IF EXISTS user_projass() CASCADE;
DROP FUNCTION IF EXISTS user_projcomp() CASCADE;


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

CREATE TABLE password_reset_tokens(
    email TEXT NOT NULL,
    token TEXT NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE,
    PRIMARY KEY(email,token)
);

CREATE TABLE users (
    user_id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    username TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    profile_image TEXT,
    projects_in_progress INTEGER DEFAULT 0,
    projects_completed INTEGER DEFAULT 0,
    tasks_in_progress INTEGER DEFAULT 0,
    tasks_completed INTEGER DEFAULT 0,
    is_admin BOOLEAN DEFAULT FALSE,
    is_blocked BOOLEAN DEFAULT FALSE,
    is_projcoord BOOLEAN DEFAULT FALSE,
    remember_token VARCHAR
);

CREATE TABLE company (
    comp_id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    user_id INTEGER REFERENCES users(user_id) ON UPDATE CASCADE ON DELETE SET NULL
);


CREATE TABLE project (
    proj_id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    description TEXT NOT NULL,
    due_date DATE NOT NULL CHECK (due_date >= CURRENT_DATE),
    percentageCompleted NUMERIC(5,2),
    comp_id INTEGER REFERENCES company(comp_id) ON UPDATE CASCADE ON DELETE SET NULL,
    coord_id INTEGER REFERENCES users(user_id) ON UPDATE CASCADE ON DELETE SET NULL
);



CREATE TABLE project_member (
    proj_id INTEGER REFERENCES project(proj_id) ON UPDATE CASCADE ON DELETE SET NULL,
    user_id INTEGER REFERENCES users(user_id) ON UPDATE CASCADE ON DELETE CASCADE,
    PRIMARY KEY (proj_id, user_id)
);

CREATE TABLE task (
   task_id SERIAL PRIMARY KEY,
   name TEXT NOT NULL,
   description TEXT,
   due_date DATE NOT NULL CHECK (due_date >= CURRENT_DATE),
   status status_task NOT NULL DEFAULT 'To-do',
   priority priority_task NOT NULL,
   CONSTRAINT status_check CHECK (status IN ('To-do', 'In Progress', 'Completed')),
   CONSTRAINT priority_check CHECK (priority IN ('Low', 'Medium', 'High')),
   proj_id INTEGER REFERENCES project(proj_id) ON UPDATE CASCADE ON DELETE SET NULL,
   user_id INTEGER REFERENCES users(user_id) ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE subtask (
    subtask_id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    description TEXT,
    status status_task NOT NULL DEFAULT 'To-do',
    task_id INTEGER REFERENCES task(task_id) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT status_check CHECK (status IN ('To-do', 'In Progress', 'Completed'))
);


CREATE TABLE invitation (
    proj_id INTEGER NOT NULL REFERENCES project(proj_id) ON DELETE CASCADE,
    user_id INTEGER NOT NULL REFERENCES users(user_id) ON DELETE CASCADE,
    token TEXT NOT NULL,
    PRIMARY KEY(proj_id,user_id)
);


CREATE TABLE post (
    post_id SERIAL PRIMARY KEY,
    date DATE NOT NULL,
    content TEXT NOT NULL,
    assigned_member INTEGER REFERENCES users(user_id) ON UPDATE CASCADE ON DELETE CASCADE,
    proj_id INTEGER REFERENCES project(proj_id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE employee (
    comp_id INTEGER REFERENCES company(comp_id) ON UPDATE CASCADE ON DELETE CASCADE,
    user_id INTEGER REFERENCES users(user_id) ON UPDATE CASCADE ON DELETE CASCADE,
    PRIMARY KEY (comp_id, user_id)
);

CREATE TABLE comment (
    comment_id SERIAL PRIMARY KEY,
    date DATE NOT NULL,
    content TEXT NOT NULL,
    task_id INTEGER REFERENCES task(task_id) ON UPDATE CASCADE ON DELETE CASCADE,
    assigned_member INTEGER REFERENCES users(user_id) ON UPDATE CASCADE ON DELETE CASCADE,
    reply INTEGER REFERENCES comment(comment_id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE favorite (
    proj_id INTEGER REFERENCES project(proj_id) ON UPDATE CASCADE ON DELETE CASCADE,
    owner_id INTEGER REFERENCES users(user_id) ON UPDATE CASCADE ON DELETE CASCADE,
    PRIMARY KEY (proj_id, owner_id)
);
CREATE TABLE archive (
    proj_id INTEGER REFERENCES project(proj_id) ON UPDATE CASCADE ON DELETE CASCADE,
    author_id INTEGER REFERENCES users(user_id) ON UPDATE CASCADE ON DELETE CASCADE,
    PRIMARY KEY (proj_id, author_id)
);


CREATE TABLE notification (
    notif_id SERIAL PRIMARY KEY,
    date DATE NOT NULL,
    content TEXT NOT NULL
);

CREATE TABLE project_notification (
    notif_id INTEGER PRIMARY KEY REFERENCES notification(notif_id) ON UPDATE CASCADE ON DELETE CASCADE,
    proj_id INTEGER REFERENCES project(proj_id) ON DELETE CASCADE NOT NULL
);


CREATE TABLE assignment_notification (
    notif_id INTEGER PRIMARY KEY REFERENCES notification(notif_id) ON UPDATE CASCADE ON DELETE CASCADE,
    task_id INTEGER REFERENCES task(task_id) ON DELETE CASCADE NOT NULL
);

CREATE TABLE comment_notification (
    notif_id INTEGER PRIMARY KEY REFERENCES notification(notif_id) ON UPDATE CASCADE ON DELETE CASCADE,
    comment_id INTEGER REFERENCES comment(comment_id) NOT NULL
);

CREATE TABLE support
(
    id        SERIAL PRIMARY KEY,
    email     VARCHAR NOT NULL,
    name      VARCHAR,
    subject   VARCHAR NOT NULL,
    content      VARCHAR NOT NULL,
    responded BOOLEAN NOT NULL DEFAULT FALSE,
    response  VARCHAR
);


CREATE INDEX projects_id_user ON project_member USING hash (user_id);
CREATE INDEX members_id_project ON project_member USING hash (proj_id);
CREATE INDEX tasks_id_project ON task USING hash (proj_id);
CREATE INDEX project_name_search ON project USING gist (to_tsvector('english', name));



CREATE OR REPLACE FUNCTION task_status_upd() RETURNS TRIGGER AS 
    $BODY$
    BEGIN
    IF EXISTS (SELECT 1
               FROM subtask
               WHERE NEW.task_id = subtask.task_id AND subtask.status = 'In Progress') THEN
        UPDATE task
        SET status = 'In Progress'
        WHERE NEW.task_id = task.task_id;
    ELSIF NOT EXISTS (SELECT 1
                     FROM subtask
                     WHERE NEW.task_id = subtask.task_id AND subtask.status IN ('To-do', 'In Progress'))
                     AND EXISTS (SELECT 1
                                FROM subtask
                                WHERE NEW.task_id = subtask.task_id AND subtask.status = 'Completed') THEN
        UPDATE task
        SET status = 'Completed'
        WHERE NEW.task_id = task.task_id;
    END IF;
    RETURN NEW;
    END
    $BODY$
    LANGUAGE plpgsql;
    CREATE TRIGGER task_status_upd
    AFTER INSERT OR UPDATE ON subtask
    FOR EACH ROW
    EXECUTE FUNCTION task_status_upd();



CREATE OR REPLACE FUNCTION proj_prog() RETURNS TRIGGER AS 
$BODY$
DECLARE
    Completed INT;
    NumberofTasks INT;
BEGIN
    SELECT COUNT(CASE WHEN status = 'Completed' THEN 1 ELSE NULL END),
           COUNT(task_id)
    INTO Completed, NumberofTasks
    FROM task
    WHERE NEW.proj_id = task.proj_id;

    IF NumberofTasks > 0 THEN
        UPDATE project
        SET percentageCompleted = Completed * 100.0 / NumberofTasks
        WHERE NEW.proj_id = project.proj_id;
    END IF;

    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;
CREATE TRIGGER proj_prog
AFTER INSERT OR UPDATE ON task
FOR EACH ROW
EXECUTE FUNCTION proj_prog();



CREATE OR REPLACE FUNCTION user_projass() RETURNS TRIGGER AS 
$BODY$
BEGIN
    UPDATE users
    SET projects_in_progress = projects_in_progress + 1
    WHERE NEW.user_id = user_id;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;
CREATE TRIGGER user_projass
AFTER INSERT ON project_member
FOR EACH ROW
EXECUTE PROCEDURE user_projass();

CREATE OR REPLACE FUNCTION user_projcomp() RETURNS TRIGGER AS 
$BODY$
BEGIN
    IF EXISTS (
        SELECT proj_id
        FROM project
        WHERE NEW.proj_id = proj_id AND percentageCompleted = 100
    ) THEN
        UPDATE users
        SET projects_completed = projects_completed + 1,
            projects_in_progress = projects_in_progress - 1
        FROM project_member
        WHERE NEW.proj_id = project_member.proj_id
            AND project_member.user_id = users.user_id;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;
CREATE TRIGGER user_projcomp
AFTER UPDATE ON project
FOR EACH ROW
EXECUTE FUNCTION user_projcomp();

insert into users (name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed,is_admin,is_blocked) values ('Maria Doe', 'mariadoe@example.com', 'mariadoe', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', '/images/profiles/1.png', 20, 26, 3, 39,FALSE,FALSE);
--pass: 1234
insert into users (name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed,is_admin,is_blocked) values ('John Doe', 'johndoe@example.com', 'johndoe', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', '/images/profiles/2.png', 20, 26, 3, 39,TRUE,FALSE);
insert into users (name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed,is_admin,is_blocked) values ('Ana Doe', 'anadoe@example.com', 'anadoe', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', '/images/profiles/3.png', 20, 26, 3, 39,FALSE,FALSE);
insert into users (name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed,is_admin,is_blocked) values ('Mike Doe', 'mikedoe@example.com', 'mikedoe', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', '/images/profiles/4.png', 20, 26, 3, 39,FALSE,FALSE);

insert into company (comp_id, name, user_id) values (1, 'FEUP', 1);
insert into company (comp_id, name, user_id) values (2, 'FCUP', 1);

/*insert into notification (notif_id, date, content) values(1, '2023-11-29 01:49:31', 'The invitation to this project has been accepted');
insert into notification (notif_id, date, content) values(2, '2023-11-29 01:49:31', 'Your comment received a like');
insert into notification (notif_id, date, content) values(3, '2023-11-29 01:49:31', 'The coordinator has changed');*/

insert into project (name, description, due_date, percentageCompleted, comp_id, coord_id) values('TEST', 'This is a test', '2024-07-26', 0.0, 1, 1);
insert into project (name, description, due_date, percentageCompleted, comp_id, coord_id) values('LBAW', 'This is a test project for LBAW A8', '2024-04-26', 50.0, 1, 1);

/*insert into project_notification (notif_id, proj_id) values (1, 1);*/

insert into project_member (proj_id, user_id) values (1, 1);
insert into project_member (proj_id, user_id) values (2, 1);

insert into task (name, description, due_date, status, priority, proj_id, user_id) values ('Task - LBAW', 'This is a task test for LBAW', '2024-09-16', 'In Progress', 'Low', 1, 1);

insert into post (post_id, date, content, assigned_member, proj_id) values (1, '2024-09-01 05:39:14', 'Test for post', 1, 1);

insert into employee (comp_id, user_id) values (1, 1);
insert into employee (comp_id, user_id) values (1, 2);
insert into employee (comp_id, user_id) values (1, 3);
insert into employee (comp_id, user_id) values (1, 4);
insert into employee (comp_id, user_id) values (2, 1);

insert into comment (date, content, task_id, assigned_member, reply) values ('2023-12-09', 'The first part of this task is completed', 1, 1, NULL);




