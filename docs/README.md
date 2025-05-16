# README

## Real-Estate Platform (Laravel 10)

A web application that connects **property sellers** with **buyers**.\
Sellers list apartments or houses for sale; buyers search, bookmark, and inquire — all on a modern Laravel stack.

***

### Core Features

| Area                  | Buyer Experience                                  | Seller Experience\*             |
| --------------------- | ------------------------------------------------- | ------------------------------- |
| Registration & Login  | Manual authentication (Laravel session)           |                                 |
| Property Listings     | Browse & filter (city, price, rooms, etc.)        | Create · Edit · Delete          |
| Images & 360° Tours   | Photo gallery, optional ZIP-based virtual tour    | Multi-image upload, AJAX delete |
| Bookmarks             | Save / remove favourites                          |                                 |
| Inquiries / Messaging | Send message to seller                            | View inquiries per listing      |
| Price Estimator       | Input city · size · age · rooms → suggested price |                                 |

\*Blank = same as buyer experience

***

### Tech Stack

| Layer                       | Details                                                                 |
| --------------------------- | ----------------------------------------------------------------------- |
| Front-End (HTML / CSS / JS) | Blade templates (HTML), Tailwind CSS, JavaScript                        |
| Back-End                    | Laravel 10 (MVC, Eloquent, Blade, Artisan)                              |
| Server                      | Apache (XAMPP)                                                          |
| Language                    | PHP 8.2                                                                 |
| Database                    | MySQL 8 — schema `real_estate`                                          |
| Auth                        | Laravel session-based authentication (custom login via `Auth::attempt`) |
| Jobs & Mail                 | Laravel Queue (`jobs`, `job_batches`) for async email                   |

***

