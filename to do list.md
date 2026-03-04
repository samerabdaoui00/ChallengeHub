# ChallengeHub To-Do List

This list summarizes the simplest path to complete the project while matching the "Cahier des Charges" requirements.

## 1. Core Logic & Database (Models)
- [x] **Challenge Model**: Implement `create`, `update`, `delete`, `getAll`, `getById`, and `getByUser`.
- [x] **Participation Model**: Implement `create`, `delete`, `getByChallenge`, and `getByUser`.
- [x] **Comment Model**: Implement `create`, `delete`, and `getBySubmission`.
- [x] **Vote Model**: Implement `create` (ensure one vote per user per submission) and `countBySubmission`.
- [x] **Database Setup**: Verify and run `config/webbd.sql` to ensure all mandatory tables (`users`, `challenges`, `submissions`, `comments`, `votes`) are present.

## 2. Features & Controllers
- [x] **Challenge Management**:
    - [x] Create/Edit/Delete challenges (Title, Description, Category, Deadline, Image).
    - [x] Publicly list all challenges.

- [x] **Participation System**:
    - [x] Allow logged-in users to submit their participation (Description + Image/Link).
    - [x] Allow users to edit/delete their own submissions.
- [x] **Social Features**:
    - [x] Implement comment addition on participations.
    - [x] Implement the voting system (1 vote limit).

- [x] **Search & Ranking**:
    - [x] Add keyword search and category filtering for challenges.
    - [x] Create a "Ranking" page showing participations sorted by votes.


## 3. UI & Views (Templates)
- [ ] **Authentication**: Enhance `register.php` and `login.php` UX.
- [ ] **Profile**: Complete the `profile.php` view (view/edit/delete account).
- [ ] **Challenges**: 
    - [ ] `list.php`: Display challenges with search/filter bars.
    - [ ] `show.php`: Display challenge details and associated submissions.
- [ ] **Participations**: Create/display submission forms and details.
- [ ] **Ranking**: Display a leaderboard of the best contributions.

## 4. Security & Refinement
- [ ] **XSS Protection**: Ensure all dynamic outputs use the `e()` helper function.
- [ ] **SQL Injection**: Ensure all DB queries use PDO prepared statements (already started).
- [ ] **Session Security**: Implement `session_start()` consistently and protect sensitive routes.
- [ ] **Final Deliverable**: Prepare the SQL script and a simple Technical Report as per PDF requirements.
