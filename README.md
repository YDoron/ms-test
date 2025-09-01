# Demo
## https://asdf1.work/ms-test

# Development Process

## Technology Choice
I chose **PHP** for the backend because it provides straightforward session management and runs reliably without additional setup.  
For the frontend, I used **JavaScript** because it is lightweight and well-suited for handling dynamic user interactions.

## File Structure
The project is organized into the following files:

- **index.html** – the main page that displays the user interface
- **style.css** – applies minimal styling to the app
- **script.js** – contains the frontend logic and handles HTTP requests to the backend
- **init.php** – starts a new session on the server side if one doesn’t already exist, and returns the current session state to the client
- **game.php** – contains the server-side game logic, including random rolls and any necessary corrections
- **cash-out.php** – the "cash-out endpoint." It saves the session ID and balance to a CSV file, effectively moving credits from the game session to the user’s account. Once stored, the session is destroyed both on the server and on the client side
- **cashouts.csv** – stores the cash-out data in CSV format

This separation of concerns ensures a clear flow from frontend UI to backend logic and data persistence.

## Session Management
- Implemented PHP sessions to persist user data across requests.
- Differentiated between new and ongoing sessions by explicitly checking if a `sessionId` variable was set.

## Frontend–Backend Communication
- The frontend (`script.js`) communicates with the backend using `fetch()` requests.
- Responsibilities were separated into different PHP endpoints (*init.php*, *game.php*, *cash-out.php*) to prevent unwanted side effects (such as rolling the game on page refresh).

## Preventing Unintended Rolls
- Initially, the balance decreased every time the page was reloaded.
- To fix this, I created *init.php*, which initializes or resumes the session without triggering a roll.
- This file is called on the `DOMContentLoaded` event before any gameplay begins.

## Cash-Out Mechanism
- Implemented a cash-out endpoint to simulate “moving credits to a user’s account.”
- On cash-out, the session ID and balance are written into *cashouts.csv*.
- After saving, the session is destroyed both on the server and the client side to prevent reuse.

## Iteration and Debugging
- Used PHP’s built-in server (`php -S`) for local testing.
- Inspected logs and outputs directly in the terminal for debugging.
- Random rolls were generated using PHP’s `mt_rand()` for fairness.
- Adjusted balance handling, session persistence, and reward logic through repeated testing and refinement.
