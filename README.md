# MY_Portfolio — Fixed Release

The UI/design (HTML, CSS, layout) is untouched. Everything below was a
backend/config fix so the site actually runs and works correctly.

## Problems found and fixed

1. **Mismatched database credentials (main bug).** `index1.php` connected to
   `localhost` (XAMPP), but `api/certification_api.php`, `api/project_api.php`,
   and `api/skills_api.php` were hard-coded to a remote InfinityFree hosting
   database with live credentials committed in the code. Result: the page
   could load, but every "Add Project / Add Skill / Add Certification" button
   would fail (or silently try to reach the internet) on a local install.
   **Fix:** added `config/db_config.php` as a single source of truth. All
   files now include it instead of duplicating credentials. It reads
   `DB_HOST`/`DB_USER`/`DB_PASS`/`DB_NAME` from environment variables if set
   (used by Docker) and otherwise defaults to XAMPP's `root` / no password.

2. **No database schema was included in the zip at all.** A fresh XAMPP
   install had no `myportfolio` database and no tables, so the page would
   show "not connected" or query errors. **Fix:** added
   `database/schema.sql`, which creates the database and all four tables
   (`projects`, `technical_skills`, `soft_skills`, `certifications`) with a
   couple of starter rows.

3. **Contact form was broken in three separate ways.**
   - The "Recipient" field in the contact modal was used as the actual
     destination email, so a visitor's message was mailed to whatever
     address *they* typed, and the owner never received anything.
   - `js/mail.js` never called `event.preventDefault()` on the form
     submit. That let the browser's default form submission fire right
     after the AJAX request, reloading the page and killing the request
     before it ever completed — so nothing was sent and no error/success
     message ever appeared.
   - The backend used PHP's `mail()` function, which requires a locally
     configured MTA (sendmail/postfix) to deliver anything. It's not
     installed in the Docker image and isn't configured by default on
     XAMPP either, so `mail()` silently failed in both setups.

   **Fix:** the message is now always sent to the owner's address with the
   visitor's email set as `Reply-To` (validated, header-injection safe);
   `js/mail.js` now calls `preventDefault()` and shows a real
   loading/success/error state; and `api/sendMail_api.php` was rewritten to
   send over real SMTP using [PHPMailer](https://github.com/PHPMailer/PHPMailer)
   (bundled in `vendor/phpmailer/`), configured via `config/mail_config.php`
   — see **Setting up the contact form (SMTP)** below.

4. **SQL injection in `project_api.php`.** Form fields were concatenated
   directly into the `INSERT` query. **Fix:** rewritten to use a
   parameterized/prepared statement, same as the other API files.

5. **Unrestricted certificate file upload.** Any file type could be
   uploaded as a "certificate image" and stored in a public folder — a
   remote-code-execution risk if someone uploaded a `.php` file. **Fix:**
   only real image files (verified by content, not just extension) under
   5MB are accepted now.

6. Minor: added basic required-field validation to the API endpoints so
   missing form fields fail with a clear JSON error instead of a PHP
   warning.

## Option A — Run with XAMPP

1. Install XAMPP (Windows/macOS/Linux) from apachefriends.org if you don't
   already have it.
2. Copy the whole `MY_Portfolio-main` folder into XAMPP's web root:
   - Windows: `C:\xampp\htdocs\MY_Portfolio-main`
   - macOS: `/Applications/XAMPP/htdocs/MY_Portfolio-main`
   - Linux: `/opt/lampp/htdocs/MY_Portfolio-main`
3. Open the **XAMPP Control Panel** and click **Start** next to both
   **Apache** and **MySQL**.
4. Import the database:
   - Go to `http://localhost/phpmyadmin`
   - Click **Import** → choose the file `database/schema.sql` from this
     project → click **Go**.
   - This creates the `myportfolio` database and all required tables.
5. Open the site in your browser: `http://localhost/MY_Portfolio-main/index.php`
6. That's it — the DB credentials in `config/db_config.php` already match
   XAMPP's defaults (`root` user, empty password), so no editing is needed.

Note: the "Send Message" contact form now sends real email over SMTP — see
**Setting up the contact form (SMTP)** below, it works the same under XAMPP
and Docker.

## Option B — Run it without installing XAMPP at all (Docker)

If you have **Docker Desktop** installed, you can run the whole stack
(PHP + Apache + MySQL) with one command and skip installing XAMPP entirely.
A `Dockerfile` and `docker-compose.yml` are included in this release.

1. Install Docker Desktop (docker.com) if you don't have it.
2. Open a terminal in the project folder.
3. Run:
   ```
   docker compose up --build
   ```
4. Open `http://localhost:8080/index.php` in your browser.
5. The database and tables are created automatically the first time (from
   `database/schema.sql`) — no phpMyAdmin step needed.
6. To stop it: `Ctrl+C`, then `docker compose down` (add `-v` to also wipe
   the database data volume).

Everything else about the site (forms, add-project/skill/certification,
uploads) works the same in both options.

## Setting up the contact form (SMTP)

The contact form sends mail over SMTP via PHPMailer, so it needs real SMTP
credentials — it can't send anything until you provide them.

**Using Gmail (easiest):**
1. Turn on 2-Step Verification on the Google account you want to send from:
   `https://myaccount.google.com/signinoptions/two-step-verification`
2. Create an App Password: `https://myaccount.google.com/apppasswords`
   (choose "Mail" as the app). Copy the 16-character password it gives you.
3. Set these as environment variables (Docker: edit the `SMTP_*` values in
   `docker-compose.yml`; XAMPP: set them as system/OS environment variables,
   or just hard-code them directly in `config/mail_config.php` for local
   testing only — never commit real credentials):
   - `SMTP_USER` = your full Gmail address
   - `SMTP_PASS` = the 16-character App Password from step 2
   - `OWNER_EMAIL` = the address you want contact-form messages delivered to
     (defaults to the portfolio owner's address already in the code)

Any other SMTP provider (Outlook, a custom domain mailbox, SendGrid, etc.)
works too — just change `SMTP_HOST`/`SMTP_PORT`/`SMTP_SECURE` in
`config/mail_config.php` or via environment variables to match that
provider's settings, and use its credentials for `SMTP_USER`/`SMTP_PASS`.

If `SMTP_USER`/`SMTP_PASS` are left empty, the form now fails with a clear
"Mail is not configured on the server yet" message instead of pretending to
send and silently losing the message.
