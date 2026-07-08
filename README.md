# Student Election Portal (Online Voting System)

A PHP + MySQL web application for conducting student council / class elections. Voters log in, view candidate groups, cast a single vote, and view results once the results date has passed. A separate admin panel approves or rejects candidate registrations.

## Tech Stack

- **Backend:** PHP (procedural, `mysqli`)
- **Database:** MySQL (database name: `voting`)
- **Frontend:** HTML, CSS (`css/stylesheet.css`), inline `<style>` blocks
- **Sessions:** PHP native sessions (`session_start()`)

## Folder Structure

```
/
├── admin/
│   ├── dashboard.php     # Admin panel — approve/reject candidates
│   ├── login.html        # Admin login form
│   ├── login.php         # Admin auth handler (hardcoded credentials)
│   └── logout.php        # Admin logout
├── api/
│   ├── connect.php       # MySQL connection (mysqli_connect)
│   ├── login.php         # Voter/candidate login handler
│   ├── register.php      # New user registration handler
│   ├── adminActions.php  # Approve/reject actions (called by admin dashboard)
│   └── vote.php          # Vote submission handler
├── routes/
│   ├── login.html         # Voter/candidate login form
│   ├── register.html      # Registration form
│   ├── dashboard.php      # Logged-in user dashboard (profile + candidate list + voting)
│   ├── result.php         # Public-facing results page
│   └── logout.php         # Session logout
├── css/
│   └── stylesheet.css
├── uploads/               # Uploaded candidate/voter photos
└── index.html             # Entry point (redirects here when not logged in)
```

> Note: `admin/verify.php` referenced in your file list appears to correspond to the `admin/login.php` handler shown above — the login/auth-check logic and the "verify" step are combined in one file. Let me know if `verify.php` is actually a distinct file with different logic and I'll fold it in separately.

## User Roles

| Role value | Meaning  |
|-----------|----------|
| `1`       | Voter    |
| `2`       | Candidate (appears as a "group"/candidate on the ballot) |
| Admin     | Not stored in DB — hardcoded credentials in `admin/login.php` |

## Inferred Database Schema

Based on the queries used across the codebase, the `user` table looks like this:

| Column     | Type          | Notes |
|------------|---------------|-------|
| `id`       | INT, PK       | |
| `name`     | VARCHAR       | |
| `mobile`   | VARCHAR(10)   | Used as login identifier |
| `password` | VARCHAR       | **Stored in plain text** |
| `photo`    | VARCHAR       | Filename in `uploads/` |
| `role`     | INT           | `1` = voter, `2` = candidate |
| `status`   | INT           | `0` = not voted, `1` = voted (per voter) |
| `votes`    | INT           | Vote tally (only meaningful for role `2`) |
| `approved` | INT (0/1)     | Used by admin dashboard to gate candidates |

I did not receive a `.sql` schema file — this table structure is reverse-engineered from the `SELECT`/`INSERT`/`UPDATE` statements. Send the actual schema if you want this section corrected/completed.

## Core Workflows

1. **Registration** (`routes/register.html` → `api/register.php`)
   Validates name/mobile/password, checks mobile is 10 digits, checks password confirmation, uploads photo to `uploads/`, inserts new row with `status=0, votes=0`.

2. **Login** (`routes/login.html` → `api/login.php`)
   Looks up `user` by mobile + password + role. On match, stores `userdata` and `groupsdata` (all role-2 candidates) in `$_SESSION` and redirects to `routes/dashboard.php`.

3. **Voting** (`routes/dashboard.php` → `api/vote.php`)
   Dashboard lists all candidates with a "Vote" button (disabled/shows "Voted" if the user's session status is already `1`). Submitting increments the target candidate's `votes` and sets the voter's `status` to `1`.

4. **Results** (`routes/result.php`)
   Gated behind a hardcoded `$result_date` (currently `2025-04-29`). Before that date it shows a "coming soon" message; after, it lists all role-2 users ordered by `votes DESC`, highlighting the top row as the winner.

5. **Admin Approval** (`admin/dashboard.php` → `api/adminActions.php`)
   Admin logs in with hardcoded credentials, sees pending (`approved=0`) and approved (`approved=1`) candidates, and can approve/reject via a form POST.

## Setup Instructions

1. Install a local PHP + MySQL stack (XAMPP/WAMP/MAMP or `php -S` + MySQL).
2. Create a database named `voting` and create the `user` table (see schema above — you'll want to supply/confirm the real `CREATE TABLE` statement).
3. Update `api/connect.php` credentials if your MySQL root user has a password (currently blank).
4. Place the project in your web root and ensure the `uploads/` folder is writable by the web server.
5. Visit `index.html` to log in, or `routes/register.html` to create an account.
6. Visit `admin/login.html` to access the admin panel (default hardcoded credentials — see Known Issues).

## Known Issues / Security Recommendations

These are worth fixing before any real deployment:

- **Plain-text passwords.** Passwords are stored and compared as plain text in `api/login.php` / `api/register.php`. Use `password_hash()` / `password_verify()`.
- **Hardcoded admin credentials.** `admin/login.php` checks `admin@gmail.com` / `admin123` directly in code. Move admin accounts into the database with hashed passwords.
- **No file upload validation.** `api/register.php` uses `move_uploaded_file()` on `$_FILES['photo']` without checking file type, extension, or size — allows arbitrary file upload (e.g. a `.php` shell) to a publicly-served `uploads/` directory.
- **No CSRF protection** on the vote form, registration form, or admin approve/reject actions.
- **Client-trusted vote count.** `api/vote.php` takes the current vote count from a hidden form field (`gvotes`) submitted by the browser rather than reading it fresh from the database — a user could tamper with this value before submitting.
- **No duplicate-vote race protection.** Vote/status updates aren't wrapped in a transaction, so concurrent requests could bypass the one-vote-per-user rule.
- **SQL injection partially mitigated.** Most inputs go through `mysqli_real_escape_string`, but prepared statements (`mysqli_prepare`/bound params) would be safer and are the standard recommendation over escaping.
- **Admin login has no HTTPS/session-timeout hardening** mentioned — worth adding `session_regenerate_id()` on login and secure cookie flags.
- **Duplicate OTP-timer markup** in `routes/result.php` — there's a leftover `<title>OTP Timer</title>` block with no associated logic; likely a copy-paste remnant that can be removed.

## Files Not Yet Reviewed

I don't have the contents of these files you listed — send them if you'd like them documented too:
- `index.html`
- `routes/register.html`
- `api/adminActions.php` (referenced by `admin/dashboard.php` but not shared)
- The actual `admin/verify.php` (if distinct from `admin/login.php`)
- Any `.sql` schema/dump file
