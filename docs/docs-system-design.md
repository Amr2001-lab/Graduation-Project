# docs/System Design

## System Design

### Architectural Overview

The application follows Laravel’s MVC (Model-View-Controller) architecture to separate concerns. **Routes** define how HTTP requests map to controllers, **Controllers** contain the logic to handle requests and interact with data, **Models** represent the database tables and relations, and **Views** are Blade templates for the UI. The table below summarizes each layer:

| Layer           | Description                                                                                                                                                    |
| --------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Routes**      | Define endpoints (URLs + HTTP verbs) and map them to controller actions (e.g. `GET /property/{id}` invokes `PropertyController@show`).                         |
| **Controllers** | Handle incoming requests: validate user input, call Models for data operations, and return a response (often a Blade view for HTML or JSON for API endpoints). |
| **Models**      | Eloquent ORM classes (e.g. `User`, `Apartment`, `Bookmark`) that correspond to database tables and encapsulate business logic and relationships.               |
| **Views**       | Blade template files that render HTML/CSS/JS for the client, displaying data passed from controllers.                                                          |

In a typical request flow, a user’s action hits a specific route, the route calls the appropriate controller method, and that controller uses models to fetch or modify data. Finally, the controller returns a view to the user (or a JSON response for AJAX calls). This design ensures a clear separation of concerns and maintainable code structure.

### Key Controllers & Responsibilities

All main controllers (located in the `app/Http/Controllers/` directory) coordinate the application's functionality. Below are the primary controllers and their roles:

| Controller             | Key Methods                                                | Purpose / Responsibility                                                                                                                                                                                                                                         |
| ---------------------- | ---------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **HomeController**     | `index`                                                    | Show the homepage (e.g. featured or latest property listings).                                                                                                                                                                                                   |
| **AuthController**     | `showLogin`, `login`, `showRegister`, `register`, `logout` | User authentication: handles showing forms and processing user login/registration (using `Auth::attempt` for login) and logout (clearing session).                                                                                                               |
| **ProfileController**  | `show`                                                     | Displays the user’s profile dashboard – showing their saved bookmarks and their own listed properties (accessible only after login).                                                                                                                             |
| **PropertyController** | `show`, `create`, `store`, `update`                        | Manages property listings (apartments) for sellers: showing a property’s details, rendering the “create new listing” form, saving a new listing, and updating listing info. _(Note: Deletion and some edit actions are handled by `SellerController` as below.)_ |
| **SellerController**   | `edit`, `destroy`, `destroyImage`, `removeTour`            | Allows a seller to manage existing listings: edit property details, delete property listings, remove uploaded images, or remove the virtual tour for a listing. These actions are restricted to the property’s owner.                                            |
| **BookmarkController** | `store` (toggles save/remove)                              | Saves a property to the user’s favourites or removes it if already bookmarked. Returns a JSON response indicating success.                                                                                                                                       |
| **InquiryController**  | `store` (and potentially an `index` for sellers)           | Handles inquiries from interested buyers. On the property page, a buyer (logged in) can send a message which is emailed to the seller and recorded in the database. _In a seller’s dashboard, an inquiry list could be displayed (if implemented)._              |
| **EstimateController** | `index` (handles GET form & POST submit)                   | Provides a “Price Estimator” tool. Shows a form for city, size, age, rooms and on submission calculates a suggested price using a service (based on average price per sqft for the city).                                                                        |
| **SearchController**   | `search`, `showResults`                                    | Implements property search. `search` returns live search suggestions as JSON (filtering apartments by city, street or price), and `showResults` processes a search query and displays the resulting property detail page (or 404 if not found).                  |
| **CompareController**  | `show`, `updateComparison`                                 | Enables side-by-side comparison of two properties. `show` displays one property and an optional second property if provided, while `updateComparison` (often via AJAX) loads a property’s data into a comparison view dynamically.                               |

> **Note:** All routes that modify data or require user state changes are protected by Laravel’s **authentication middleware**. In practice, this means only authenticated users (session-based login) can create listings, bookmark properties, send inquiries, etc. The `auth` middleware is applied in the route definitions or controller constructors to enforce this protection.

### Models and Data Layer

The application uses MySQL as its database, with Laravel Eloquent models representing each table. Each model corresponds to a table and defines relationships to other models. Below are the key Eloquent models, their tables, important fields, and relationships:

**User**

* **Table:** `users`
* **Columns:** `id` (integer, primary key), `name` (string), `email` (string, unique), `password` (string, hashed), `role` (string – e.g. “buyer” or “seller”), plus Laravel’s timestamps (`created_at`, `updated_at`) and other default fields (e.g. `remember_token` for sessions).
* **Relationships:** A user can have many bookmarks (`hasMany` `Bookmark` entries for saved properties). A user in the “seller” role can have many properties (`hasMany` `Apartment` listings where they are the seller). A user can also have many inquiries (`hasMany` `Inquiry` where they are the buyer). Additionally, through the bookmarks pivot table, a user has a convenient many-to-many relation to `Apartment` models they have bookmarked.

**Apartment**

* **Table:** `apartments` (stores property listings – labeled as “apartment” in code/database)
* **Columns:** `id` (integer, primary key), `seller_id` (integer, foreign key referencing a `users.id` – the owner/seller; nullable if listing can exist without an attached user), `size` (integer, square meters), `price` (decimal or float, price of the property), `street` (string), `city` (string), `age` (integer, age of property in years), `rooms` (integer, number of rooms), `bathrooms` (integer), `phone` (string, contact number for the listing), `elevator` (boolean), `parking` (boolean), `private_garden` (boolean), `central_air_conditioning` (boolean) – these are feature flags, `virtual_tour_path` (string, path to an uploaded 360° tour, if any), and timestamps.
* **Relationships:** An apartment _belongs to_ a User (`seller`) via `seller_id`. It _has many_ `ApartmentImage` entries (each image associated with this listing). It also _has many_ `Bookmark` records (users who bookmarked it). An apartment can have many inquiries from buyers (`Inquiry` records with its `apartment_id`).

**ApartmentImage**

* **Table:** `apartment_images`
* **Columns:** `id` (integer), `apartment_id` (integer foreign key to `apartments.id`), `image_url` (string path/filename of the image), plus timestamps.
* **Relationships:** Each image _belongs to_ an `Apartment`. (In this design, images are stored as separate records linked to a property. When a new property is created, multiple images can be uploaded and a record is created for each.)

**Bookmark**

* **Table:** `bookmarks` (acts as a pivot table linking users and apartments)
* **Columns:** `id` (integer), `user_id` (integer foreign key to `users.id`), `apartment_id` (integer foreign key to `apartments.id`), timestamps.
* **Relationships:** A bookmark _belongs to_ a `User` and _belongs to_ an `Apartment`. This model connects a user with a property they marked as favorite. (The `User` model also defines a `belongsToMany` relationship to `Apartment` through this table for convenient access to all bookmarked apartments.)

**Inquiry**

* **Table:** `inquiries`
* **Columns:** `id` (integer), `buyer_id` (integer foreign key to `users.id` of the user who sent the inquiry; may be NULL or 0 if guest inquiries were allowed, but here it’s used for logged-in buyers), `apartment_id` (integer foreign key to the property listing in question), `full_name` (string, name of the inquirer), `email` (string, contact email of the inquirer), `phone` (string, contact number), `message` (text, the content of the inquiry message), plus timestamps.
* **Relationships:** An inquiry _belongs to_ an `Apartment` (the listing being inquired about) and _belongs to_ a `User` (the buyer who sent it, if logged in). This allows sellers to see who contacted them and the message details. Each seller (user with listings) can retrieve all inquiries on their properties by looking at inquiries where their property’s ID matches.

**AveragePrice**

* **Table:** `average_prices`
* **Columns:** `id` (integer), `city` (string), `avg_price_per_sqft` (float), timestamps.
* **Purpose:** This is a supporting table used for the price estimation feature. It stores the pre-calculated average price per square foot for properties in a given city. The `PropertyEstimator` service uses these values to suggest a price in the **Estimate** tool. (This table is generally static reference data and not directly modified by users, so there are typically no relationships to other models besides being queried by the estimator logic.)

_The ER diagram image below visualizes all tables and relationships._&#x20;

![](.gitbook/assets/real_estate.png)

#### Infrastructure & Environment (Concise)

* **Local stack:** Runs on XAMPP (Apache + MySQL 8, port 3306) with PHP 8.2 / Laravel 10. DB schema lives in `real_estate`.
* **DB GUI:** Use **MySQL Workbench** to query, browse tables, and view relations.
*   **`.env` config:**

    ```dotenv
    dotenvCopyEditDB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=real_estate
    DB_USERNAME=root
    DB_PASSWORD=
    ```

    Centralizes DB creds, mail driver, debug mode, etc.
* **Auth & sessions:** Default `web` guard; `SESSION_DRIVER=database` stores sessions in the `sessions` table (scales across servers). `auth` middleware protects any state-changing route.
* **Migrations:** `php artisan migrate` builds all core tables (`users`, `apartments`, `bookmarks`, `inquiries`, `images`, …) and tracks them in `migrations`.
  * Extra framework tables appear when features are enabled:
    * `jobs`, `job_batches`, `failed_jobs` for queued tasks (`QUEUE_CONNECTION=database`)
    * `cache`, `cache_locks` when using DB cache (`CACHE_STORE=database`)

That's the entire environment—clone, set `.env`, run `composer install` + `php artisan migrate` .
