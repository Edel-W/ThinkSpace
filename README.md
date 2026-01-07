# ThinkSpace — Submission README

Brief: A small PHP + MySQL note-taking app. Users can sign up, log in, add notes, and search notes by title. Notes are private to each user.

Quick setup
- Install XAMPP (Apache + MySQL) on Windows.
- Place this project under XAMPP's web root (for example `c:\xampp_server\htdocs\ThinkSpace`).
- Start Apache and MySQL from the XAMPP control panel.
- Open a browser and go to: `http://localhost/ThinkSpace/signUp.html` to create an account.

What the project does automatically
- The first time the app runs it will create the database `thinkspace_db` and the `users` and `notes` tables via `PHP/config.php`.

How to use
1. Sign up: `signUp.html` (creates a user and signs you in).
2. Log in: `logIn.html` (after login you'll be taken to `dashboard.php`).
3. Add a note: Click `Add note` on the dashboard to open the workspace, enter a title and content, then Save.
4. View/search notes: On the dashboard use the search box to search by note title. Notes shown belong only to the logged-in user.
5. Logout: Click the Logout button (header) to end the session.

Important files
- `dashboard.php` — main view, lists notes and includes search.
- `workspace.html` — note editor (posts to `PHP/save_note.php`).
- `PHP/save_note.php` — saves notes (requires session).
- `PHP/search_notes.php` — forwards search queries to `dashboard.php`.
- `PHP/logIn.php`, `PHP/signUp.php`, `PHP/logOut.php` — authentication flow.
- `PHP/config.php` — DB connection and table creation.
- `Style/` and `JS/` — front-end assets.

Notes & troubleshooting
- If you see a 404 when saving, check the browser address bar and confirm the POST target is `http://localhost/ThinkSpace/PHP/save_note.php`.
- If notes are not appearing, ensure you are logged in (session cookie) and that the user_id exists in `users` table.
- To reset the DB manually, use phpMyAdmin or run the following SQL in MySQL:

  DROP DATABASE IF EXISTS thinkspace_db;
  CREATE DATABASE thinkspace_db;

Security notes (for instructor review)
- Passwords are hashed with `password_hash()`.
- Prepared statements are used for database inserts/queries.
- Output is escaped with `htmlspecialchars()` when rendering notes to avoid XSS.

Optional improvements (not required for submission)
- AJAX-based save and search for smoother UX.
- Note edit/delete operations and pagination.
- Flash messages stored in session instead of using query parameters.

If you want, I can also create a zip of the project files for submission or add a short demo video script.

— End
