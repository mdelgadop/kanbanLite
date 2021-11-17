<?php
//http://www.pagina-web.com/index.html
$db->exec("CREATE TABLE IF NOT EXISTS users(id INTEGER PRIMARY KEY, username TEXT, password TEXT, code TEXT, name TEXT, surname TEXT, email TEXT)");
$db->exec("CREATE TABLE IF NOT EXISTS projects(id INTEGER PRIMARY KEY, name TEXT, user_id INTEGER, FOREIGN KEY(user_id) REFERENCES users(id))");
$db->exec("CREATE TABLE IF NOT EXISTS statuses(id INTEGER PRIMARY KEY, name TEXT, type TEXT, project_id INTEGER, FOREIGN KEY(project_id) REFERENCES projects(id))");
$db->exec("CREATE TABLE IF NOT EXISTS sprints(id INTEGER PRIMARY KEY, name TEXT, project_id INTEGER)");
$db->exec("CREATE TABLE IF NOT EXISTS tasks(id INTEGER PRIMARY KEY, title TEXT, role TEXT, request TEXT, purpose TEXT, sprint_id INTEGER, status_id INTEGER, FOREIGN KEY(status_id) REFERENCES statuses(id))");
$db->exec("CREATE TABLE IF NOT EXISTS notes(id INTEGER PRIMARY KEY, task_id INTEGER, note TEXT, FOREIGN KEY(task_id) REFERENCES tasks(id))");
?>