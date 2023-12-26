insert into users (name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values ('Maria Doe', 'mariadoe@example.com', 'mariadoe', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', NULL, 20, 26, 3, 39);
--pass: 1234
insert into users (name, email, username, password, profile_image, projects_in_progress, projects_completed, tasks_in_progress, tasks_completed) values ('John Doe', 'johndoe@example.com', 'johndoe', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', NULL, 20, 26, 3, 39);


insert into administrator (admin_id, name, email, password, username) values (1, 'Timmi Busher', 'admin@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 'tbusher0');

insert into company (comp_id, name, admin_id) values (1, 'FEUP', 1);

insert into notification (notif_id, date, content) values(1, '2023-11-29 01:49:31', 'The invitation to this project has been accepted');
insert into notification (notif_id, date, content) values(2, '2023-11-29 01:49:31', 'Your comment received a like');
insert into notification (notif_id, date, content) values(3, '2023-11-29 01:49:31', 'The coordinator has changed');

insert into project (name, description, due_date, is_archived, is_favorite, percentageCompleted, comp_id, coord_id) values('LBAW', 'This is a test project for LBAW A8', '2024-04-26', false, false, 50.0, 1, 1);

insert into project_notification (notif_id, proj_id) values (1, 1);

insert into project_member (proj_id, user_id) values (1, 1);

insert into task (name, description, due_date, status, priority, proj_id, user_id) values ('Task - LBAW', 'This is a task test for LBAW', '2024-09-16', 'In Progress', 'Low', 1, 1);

insert into subtask (subtask_id, name, description, status, task_id) values (1, 'SubTask - LBAW', 'This is a subtask text for LBAW', 'To-do', 1);

insert into invitation (user_id, proj_id, coord_id, approved) values (1, 1, 1, false);

insert into post (post_id, date, content, assigned_member, proj_id) values (1, '2024-09-01 05:39:14', 'Test for post', 1, 1);

insert into employee (comp_id, user_id) values (1, 1);

insert into comment (comment_id, date, content, task_id, assigned_member, reply) values (1, '2024-08-26 12:26:48', 'Test for comment', 1, 1, 0);

insert into assignment_notification (notif_id, task_id) values (1, 1);

insert into comment_notification (notif_id, comment_id) values (2, 1);

insert into project_notification (notif_id, proj_id) values (3, 1);


