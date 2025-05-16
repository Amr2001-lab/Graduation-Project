# docs/System Design

## System Design

### Architectural Overview

The application follows **Laravel 10’s MVC (Model‑View‑Controller)** architecture to keep presentation, business logic and persistence concerns cleanly separated.

* **Routes** map HTTP verbs + URIs to controller actions.
* **Controllers** validate requests, call services / Eloquent models, and return a view or JSON.
* **Models** are Eloquent ORM classes that represent database tables and their relationships.
* **Views** are Blade templates that render HTML/CSS/JS for the client.

```
 Request  ─▶ Route ─▶ Controller ─▶ Model ──┐
                                          │
               ◀── View / JSON  ◀──────────┘
```

In a typical flow the user’s browser hits a route, the controller fetches or updates data via models, then returns a Blade view (or an API / AJAX JSON response). This layering enables testability and long‑term maintainability.

***

### Routes & Endpoints

All web routes live in **`routes/web.php`**. They’re listed here with HTTP method, URI, controller method, middleware and route name.

| Verb       | URI                            | Controller @ method                  | Middleware | Name                           |
| ---------- | ------------------------------ | ------------------------------------ | ---------- | ------------------------------ |
| GET        | `/`                            | `HomeController@index`               |  –         | `home`                         |
| GET        | `/property/{id}`               | `PropertyController@show`            |  –         | `property.show`                |
| GET        | `/login`                       | `AuthController@showLogin`           |  –         | `login.show`                   |
| POST       | `/login`                       | `AuthController@login`               |  –         | `login.submit`                 |
| GET        | `/register`                    | `AuthController@showRegister`        |  –         | `register.show`                |
| POST       | `/register`                    | `AuthController@register`            |  –         | `register.submit`              |
| POST       | `/logout`                      | `AuthController@logout`              |  –         | `logout`                       |
| GET        | `/search`                      | `SearchController@search`            |  –         | `search.index`                 |
| GET        | `/search/results`              | `SearchController@showResults`       |  –         | `search.results`               |
| GET        | `/profile`                     | `ProfileController@show`             | **auth**   | `profile.show`                 |
| POST       | `/bookmark`                    | `BookmarkController@store`           | **auth**   | `bookmarks.store`              |
| GET        | `/compare/update/{id}`         | `CompareController@updateComparison` |  –         | `compare.update`               |
| GET        | `/property/{id}/compare`       | `CompareController@show`             |  –         | `property.compare`             |
| GET / POST | `/estimate`                    | `EstimateController@index`           |  –         | `estimate`                     |
| GET        | `/properties/create`           | `PropertyController@create`          | **auth**   | `property.create`              |
| POST       | `/properties`                  | `PropertyController@store`           | **auth**   | `property.store`               |
| GET        | `/properties/{apartment}/edit` | `SellerController@edit`              | **auth**   | `seller.properties.edit`       |
| PUT        | `/properties/{apartment}`      | `PropertyController@update`          | **auth**   | `seller.properties.update`     |
| DELETE     | `/seller/images/{image}`       | `SellerController@destroyImage`      | **auth**   | `seller.images.destroy`        |
| DELETE     | `/properties/{apartment}`      | `SellerController@destroy`           | **auth**   | `seller.properties.destroy`    |
| POST       | `/inquiry/{id}/email`          | `InquiryController@store`            | **auth**   | `inquiry.store`                |
| DELETE     | `/properties/{apartment}/tour` | `PropertyController@removeTour`      | **auth**   | `seller.properties.removeTour` |

> **Security note:** any route that changes data or reveals private state is protected by the `auth` middleware so only logged‑in users can access it.

***

### Key Controllers & Responsibilities

| Controller             | Key Responsibilities                                                            |
| ---------------------- | ------------------------------------------------------------------------------- |
| **HomeController**     | Show landing page, paginate featured / recent listings.                         |
| **PropertyController** | CRUD for properties; show single listing; handle virtual‑tour upload & removal. |
| **SellerController**   | Seller‑only actions: edit / update / delete listings, delete images.            |
| **SearchController**   | Advanced search, filtering, and results pagination.                             |
| **CompareController**  | Compare primary listing with a second, returns partials for AJAX updates.       |
| **EstimateController** | Invoke `PropertyEstimator` service, return form & estimated price.              |
| **BookmarkController** | Add / remove bookmarks for logged‑in users.                                     |
| **InquiryController**  | Store buyer inquiries and dispatch email to seller.                             |
| **ProfileController**  | Display user dashboard with their data.                                         |
| **AuthController**     | Login / registration / logout.                                                  |

All mutating actions are behind the `auth` middleware; controllers either declare it in their constructor (`$this->middleware('auth')`) or routes apply it.

***

### Models and Data Layer

| Model              | Table               | Relationships (⇢ means “hasMany / belongsToMany”)           |
| ------------------ | ------------------- | ----------------------------------------------------------- |
| **User**           | `users`             | ⇢ bookmarks, ⇢ inquiries (buyer), ⇢ apartments (seller)     |
| **Apartment**      | `apartments`        | belongsTo user (seller), ⇢ images, ⇢ bookmarks, ⇢ inquiries |
| **ApartmentImage** | `apartment_images`  | belongsTo apartment                                         |
| **Bookmark**       | `bookmarks` (pivot) | belongsTo user, belongsTo apartment                         |
| **Inquiry**        | `inquiries`         | belongsTo buyer (user), belongsTo apartment                 |
| **AveragePrice**   | `average_prices`    | referenced by `PropertyEstimator` (no FK relationships)     |

***

### Views (Blade Templates)

All UI screens are Blade templates under `resources/views`.\
File path and role of each template:

| Template                               | Location                                            | Purpose                                                                        |
| -------------------------------------- | --------------------------------------------------- | ------------------------------------------------------------------------------ |
| **homepage.blade.php**                 | `resources/views/homepage.blade.php`                | Landing page with search, filters and featured listings grid.                  |
| **login.blade.php**                    | `resources/views/login.blade.php`                   | User login form.                                                               |
| **register.blade.php**                 | `resources/views/register.blade.php`                | New‑account registration form.                                                 |
| **profile/show.blade.php**             | `resources/views/profile/show.blade.php`            | Logged‑in dashboard → user info, bookmarked & listed properties.               |
| **property/show.blade.php**            | `resources/views/property/show.blade.php`           | Full property details + image carousel & 360° tour + inquiry modal.            |
| **property/create.blade.php**          | `resources/views/property/create.blade.php`         | “Add property” form for sellers, handles images & tour upload.                 |
| **seller/edit-property.blade.php**     | `resources/views/seller/edit-property.blade.php`    | Edit existing listing, add / remove images & virtual tour.                     |
| **property/compare.blade.php**         | `resources/views/property/compare.blade.php`        | Two‑column compare view for side‑by‑side property comparison.                  |
| **property/\_compareColumn.blade.php** | `resources/views/property/_compareColumn.blade.php` | Partial that renders a compact property card (used on compare page, via AJAX). |
| **estimate/form.blade.php**            | `resources/views/estimate/form.blade.php`           | Price‑estimator tool (form + result).                                          |
| **buyer-inquiry.blade.php**            | `resources/views/buyer-inquiry.blade.php`           | Email template sent to sellers when a buyer submits an inquiry.                |

***

### Infrastructure & Environment

* **Local stack:** XAMPP (Apache + MySQL 8) · PHP 8.2 · Laravel 10.\
  Clone → `composer install` → configure `.env` → `php artisan migrate`.
* **Database:** runs in schema `real_estate`; migrations create core + framework tables (`jobs`, `cache`, etc.) as needed.
* **Sessions & auth:** default `web` guard; `SESSION_DRIVER=database` so sessions scale horizontally.
* **Queues / cache (optional):** `QUEUE_CONNECTION=database`, `CACHE_STORE=database` create `jobs`, `failed_jobs`, `cache`, `cache_locks` tables.
* **Tools:** MySQL Workbench for queries / diagrams; Laravel Pint + PHP‑Stan for code‑quality (CI).
