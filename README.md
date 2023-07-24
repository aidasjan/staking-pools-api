# Staking Pools API

This is the backend repository for the Staking Pools project, which is built using the Laravel framework. The backend handles user authentication and management.

## Features

- User Authentication: Users can authenticate with the backend using their wallet by signing messages.
- Profile: The users are able to update their name and email, which are associated with their wallet.
- API Endpoints: The backend provides API endpoints for the frontend application to interact with.

## Installation

1. Clone the repository

2. Install PHP dependencies using Composer:

   ```bash
   composer install
   ```

3. Copy the `.env.example` file to `.env`:

   ```bash
   cp .env.example .env
   ```

4. Generate the application key:

   ```bash
   php artisan key:generate
   ```

5. Configure the database connection in the `.env` file:

   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=...
   DB_USERNAME=...
   DB_PASSWORD=...
   ```

6. Migrate the database:

   ```bash
   php artisan migrate:fresh
   ```

7. Start the development server


## API Endpoints

The backend provides the following API endpoints for communication with the frontend React application:

- `GET /users/self`: Retrieves the profile data of the currently authenticated user.
- `PUT /users/self`: Update the authenticated user's data.
- `POST /auth/challenge`: Generate a challenge for wallet authentication.
- `POST /auth/login`: Authenticate the user using the provided wallet address and signature.

## Running Tests

Run unit tests using the following command:

```bash
php artisan test
```

## Licence

Copyright (c) 2023 Aidas Jankauskas

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
