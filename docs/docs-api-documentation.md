# docs/API Documentation



### Authentication

#### GET `/login`

Displays the login page (no authentication required). Used to retrieve the HTML login form.

#### POST `/login`

**Description:** Authenticates a user with email and password using Laravel’s session-based auth. On success, a session cookie is issued and the user is redirected to their profile.

**Auth Required:** No (not logged in)\
**Request Body:** (form fields)

* `email` – **string**, required, must be a valid email format
* `password` – **string**, required

If the credentials are valid, the user’s session is regenerated and they are logged in. If authentication fails, the response returns to the login page with an error on the email field (“Invalid Email!”).

**Example Request:**

```json
{
  "email": "alice@example.com",
  "password": "secret123"
}
```

**Example Response (Success):** HTTP 302 redirect to `/profile` (session cookie established).

#### GET `/register`

Displays the user registration page (no authentication required). Used to retrieve the HTML sign-up form.

#### POST `/register`

**Description:** Creates a new user account and logs them in. On success, the new user session is started and redirected to their profile page.

**Auth Required:** No (must be logged out)\
**Request Body:** (form fields)

* `name` – **string**, required
* `email` – **string**, required, must be a valid email and **unique** (not already registered)
* `password` – **string**, required, minimum 6 characters
* `password_confirmation` – **string**, required (must match `password`)
* `role` – **string**, required (expected values: `"buyer"` or `"seller"`)

If the input passes validation, a new user is created with the given role. The password is hashed before saving. The user is then automatically logged in (session created).

**Example Request:**

```json
{
  "name": "Alice Example",
  "email": "alice@example.com",
  "password": "secret123",
  "password_confirmation": "secret123",
  "role": "seller"
}
```

**Example Response (Success):** HTTP 302 redirect to `/profile` (new account created and logged in). Subsequent requests can use the session cookie for authentication.

#### POST `/logout`

**Description:** Logs out the currently authenticated user and ends the session.

**Auth Required:** Yes (must be logged in)\
On success, the server invalidates the user’s session and CSRF token, then redirects to the home page.

**Example Response:** HTTP 302 redirect to `/` (home). The session cookie is invalidated and the user is no longer authenticated.

***

### Property Listings (Public)

#### GET `/`

**Description:** Retrieves a paginated list of property listings with optional filtering. This is the home endpoint showing featured/browsable listings.

**Auth Required:** No\
**Query Parameters (optional filters):**

* `price` – price range filter, format `"min-max"` (e.g. `0-200000` for under 200k, `600000-1000000` for 600k–1M, or `"1000000-"` for 1M+). If omitted or empty, no price filter is applied.
* `location` – **string**, filter by city name (partial matches allowed).
* `age` – building age range, options: `"0-5"`, `"6-10"`, `"11-20"`, or `"21+"` (21+ means older than 20 years). If omitted, no age filter.
* `rooms` – number of rooms filter. Options: `"1"`, `"2"`, `"3"`, or `"4"` (`"4"` means 4 **or more** rooms). If omitted, no rooms filter.
* `time_posted` – how recent the listing was posted. Options: `"24h"` (past day), `"week"` (past 7 days), `"month"` (past 30 days), `"year"` (past year). If omitted, no date filter.

Listings are sorted by newest first. The response is an HTML page displaying up to 12 properties per page (use `?page=X` for pagination).

**Example Request:** `GET /?location=Cairo&rooms=3&price=200000-400000`\
**Example Response Data:** (the page will render a list; for example, two matching properties in JSON form)

```json
[
  {
    "id": 10,
    "city": "Cairo",
    "street": "123 Elm Street",
    "price": 250000,
    "size": 1200,
    "rooms": 3,
    "bathrooms": 2,
    "age": 5,
    "posted_at": "2025-04-15T10:30:00Z",
    "image_url": "Images/house1.jpg"
  },
  {
    "id": 11,
    "city": "Cairo",
    "street": "456 Oak Avenue",
    "price": 300000,
    "size": 1400,
    "rooms": 4,
    "bathrooms": 3,
    "age": 8,
    "posted_at": "2025-03-20T08:15:00Z",
    "image_url": "Images/house2.png"
  }
]
```

_(Results include basic details and an image thumbnail for each property. A maximum of 12 results are shown per page.)_

#### GET `/property/{id}`

**Description:** Fetches the details of a single property listing by its ID.

**Auth Required:** No\
**Path Parameters:**

* `{id}` – **integer**, required, the ID of the property to retrieve. Must correspond to an existing property.

On success, returns the property’s detail page (HTML) including all information about the listing: images, price, address, specs, amenities, seller contact, and an embedded 360° virtual tour if available. If the property ID is not found, a 404 error is returned.

**Example Request:** `GET /property/10`\
**Example Response Data:** (the page displays property details; for example, in JSON form)

```json
{
  "id": 10,
  "city": "Cairo",
  "street": "123 Elm Street",
  "price": 250000,
  "size": 1200,
  "rooms": 3,
  "bathrooms": 2,
  "age": 5,
  "phone": "0123456789",
  "elevator": true,
  "balcony": false,
  "parking": true,
  "private_garden": false,
  "central_air_conditioning": true,
  "images": [
    "Images/house1.jpg",
    "Images/house2.jpg"
  ],
  "virtual_tour_path": "tours/10",
  "posted_at": "2025-04-15T10:30:00Z",
  "seller_id": 7
}
```

_(Example above shows a property with multiple images and a virtual tour. Boolean flags indicate available amenities. In the actual HTML page, these details are presented in a user-friendly format, and the virtual tour is embedded if `virtual_tour_path` is set.)_

#### GET `/search`

**Description:** Provides live search suggestions for properties based on a query string. Returns a JSON array of matching listings (for use in an auto-complete dropdown or similar).

**Auth Required:** No\
**Query Parameters:**

* `q` – **string**, optional. The search query to match against property address (street or city) or price. If omitted or empty, an empty response is returned.

The search will find properties where the street, city, **or** price contains the given substring. All matches are returned in an array. Each result includes a few key fields for quick display.

**Example Request:** `GET /search?q=Cairo`\
**Example Response:**

```json
[
  {
    "id": 10,
    "street": "123 Elm Street",
    "price": 250000,
    "first_image_url": "Images/house1.jpg"
  },
  {
    "id": 12,
    "street": "789 Cairo Gardens",
    "price": 180000,
    "first_image_url": null
  }
]
```

_(If a property has images, `first_image_url` is the URL of the first image; otherwise `null`. An empty query `q` would return an empty JSON array.)_

#### GET `/search/results`

**Description:** Performs a direct search and navigates to the best matching result. If a property matching the query exists, this endpoint redirects the user to that property’s detail page.

**Auth Required:** No\
**Query Parameters:**

* `q` – **string**, required. The search query to look up.

The server finds the first property whose street, city, or price matches the query string. If found, it returns the property detail page (same as visiting `/property/{id}`). If no property matches, it returns a 404 response with the message "No property found!" (the user would see an error page).

***

### User Profile

#### GET `/profile`

**Description:** Retrieves the profile page for the currently authenticated user. The profile includes the user’s personal info, their bookmarked properties (if the user is a buyer), and their own listed properties (if the user is a seller).

**Auth Required:** Yes (must be logged in)\
On success, returns an HTML page showing the profile details. The data includes the user’s name and email, and lists of related properties.

* For **buyers**: “My Bookmarked Properties” – a list of properties the user has bookmarked.
* For **sellers**: “My Listed Properties” – a list of properties the user has created (with edit/delete options).

**Example Response Data:** (profile page rendered; for example, in JSON form for a seller user)

```json
{
  "user": {
    "id": 7,
    "name": "Alice Example",
    "email": "alice@example.com",
    "role": "seller"
  },
  "bookmarks": [
    {
      "id": 15,
      "city": "Giza",
      "street": "500 Nile St",
      "price": 120000,
      "rooms": 3,
      "image_url": "Images/giza1.jpg"
    },
    {
      "id": 18,
      "city": "Cairo",
      "street": "75 Tahrir Sq",
      "price": 210000,
      "rooms": 4,
      "image_url": "Images/cairo2.jpg"
    }
  ],
  "properties": [
    {
      "id": 10,
      "city": "Cairo",
      "street": "123 Elm Street",
      "price": 250000,
      "size": 1200,
      "rooms": 3,
      "bathrooms": 2,
      "age": 5,
      "image_url": "Images/house1.jpg"
    },
    {
      "id": 14,
      "city": "Cairo",
      "street": "90 Sunset Blvd",
      "price": 300000,
      "size": 1500,
      "rooms": 4,
      "bathrooms": 3,
      "age": 2,
      "image_url": "Images/house3.png"
    }
  ]
}
```

_(In the example above, the user is a seller with two listed properties and has two bookmarks. The profile page would show the user’s info, a section for bookmarked listings, and a section for their own listings. Buyers would see their bookmarks list, and sellers see their listings list. If a section is empty, a message like “No properties listed” or “No bookmarks yet” is shown.)_

***

### Bookmarks

#### POST `/bookmark`

**Description:** Toggles a bookmark (favorite) for a property. If the property is not yet bookmarked by the user, this call will bookmark it; if it’s already bookmarked, this call will remove the bookmark.

**Auth Required:** Yes (must be logged in as a buyer or seller)\
**Request Body:**

* `apartment_id` – **integer**, required. The ID of the property to bookmark or unbookmark. Must correspond to an existing property ID.

The server will check the user’s current bookmarks for the given property:

* If a bookmark already exists, it will be removed (unfavorited).
* If no bookmark exists, a new one is created.

The response is returned in JSON indicating the new state.

**Example Request:**

```json
{
  "apartment_id": 10
}
```

**Example Response (Bookmarked):**

```json
{
  "added": true,
  "message": "Property bookmarked successfully."
}
```

If the same endpoint is called again for the same property, the response would be:

```json
{
  "added": false,
  "message": "Bookmark removed."
}
```

_(In the above, `"added": false` indicates the property was already bookmarked and has now been removed. The `message` provides a human-readable confirmation.)_

***

### Property Management (Listings for Sellers)

These endpoints allow **seller** users to create and manage their property listings. All require authentication (and the user should have a seller role).

#### GET `/properties/create`

**Description:** Displays the “Create New Property” form for sellers. (Requires login; only users with role `seller` should access.) Returns an HTML form where the seller can input property details, upload images, and an optional virtual tour ZIP.

#### POST `/properties`

**Description:** Handles the submission of the “Create Property” form. Creates a new property listing with the provided details.

**Auth Required:** Yes (seller only)\
**Request Body:** (multipart form data, including images)

* `size` – **integer**, required (property size in square feet).
* `price` – **numeric**, required (listing price).
* `street` – **string**, required (street address of the property).
* `city` – **string**, required (city/location of the property).
* `age` – **integer**, required (age of the building in years).
* `rooms` – **integer**, required (number of rooms).
* `bathrooms` – **integer**, required (number of bathrooms).
* `phone` – **string**, required (contact phone number for the listing, max 20 characters).
* `elevator` – **boolean**, optional (amenity flag; include if the building has an elevator).
* `balcony` – **boolean**, optional (amenity flag; include if there is a balcony).
* `parking` – **boolean**, optional (amenity flag for parking availability).
* `private_garden` – **boolean**, optional (amenity flag for a private garden).
* `central_air_conditioning` – **boolean**, optional (amenity flag for central A/C).
* `images[]` – **file array**, required. One or more image files for the property. Each file must be an image of type jpeg, png, jpg, gif, or svg and max size 2MB (2048 KB).
* `tour_zip` – **file**, required. A ZIP file containing the 360° virtual tour assets for the property. (Must include an `index.html` entry and related assets.)

All fields above marked required must be provided and pass validation. The boolean amenity fields are checkboxes on the form; if a checkbox is checked it will be treated as `true` (1), otherwise it will be `false` (0) by default.

On success, a new property record is created. All uploaded images are saved to storage (`public/Images/` directory) and recorded in the database. The `tour_zip` file is extracted to `public/tours/{property_id}/` and the `virtual_tour_path` is set to that directory.

**Example Request:** (multipart/form-data)

```json
{
  "size": 1200,
  "price": 250000,
  "street": "123 Elm Street",
  "city": "Cairo",
  "age": 5,
  "rooms": 3,
  "bathrooms": 2,
  "phone": "0123456789",
  "elevator": true,
  "balcony": false,
  "parking": true,
  "private_garden": false,
  "central_air_conditioning": true,
  "images": [ /* house1.jpg file, house2.jpg file */ ],
  "tour_zip": /* file tour10.zip */
}
```

_(In the above JSON, `images` would be the array of image files uploaded, and `tour_zip` is a single ZIP file. Boolean fields like `elevator` are sent if true; if a checkbox is unchecked, it will not appear in the request.)_

**Response:** On success, the server returns a redirect to the new property’s detail page (e.g. `/property/10`) with a flash message “Property created successfully.” The newly created listing will now appear in the user’s “My Listed Properties” on their profile. If validation fails, the user is redirected back to the form with error messages for any invalid fields.

#### GET `/properties/{apartment}/edit`

**Description:** Displays the “Edit Property” form for an existing listing. Allows the seller to modify details, add/remove images, or update the virtual tour.

**Auth Required:** Yes (seller only; the authenticated user should be the owner of the listing)\
**Path Parameters:**

* `{apartment}` – **integer**, required. The ID of the property to edit. Must belong to the current user (not enforced in backend code, but the UI only exposes this for the owner).

On success, returns an HTML form pre-filled with the property’s current data. The page also shows the current images with options to remove each, and if a virtual tour is present, it displays it with an option to remove it.

#### PUT `/properties/{apartment}`

**Description:** Processes the “Edit Property” form submission. Updates an existing property listing with new data and/or files.

**Auth Required:** Yes (seller only; must be the listing’s owner)\
**Path Parameters:**

* `{apartment}` – **integer**, required. The ID of the property to update.

**Request Body:** (multipart form data) – The fields are the same as in **Create Property**, with the following differences:

* `phone` – optional (nullable). If not provided, the phone contact remains unchanged or can be cleared.
* `images[]` – optional. New image files to add to the listing (same file rules as before). If no new images are uploaded, existing images remain unchanged (unless removed separately via the image remove endpoint).
* `tour_zip` – optional. A new virtual tour ZIP to replace the current one. If a new `tour_zip` is uploaded, it will overwrite the existing tour (the old tour directory will be deleted and replaced with the new contents). If no file is provided here, the existing tour remains (unless removed separately).
* The boolean fields (`elevator`, `balcony`, `parking`, `private_garden`, `central_air_conditioning`) – if a checkbox is unchecked in the edit form, that field will be updated to `false`. If checked, it remains or becomes `true`. (Any amenity not included in the request is treated as false, effectively turning off that feature if it was previously true.)

The server validates the input similar to creation (all the same rules, except image and tour fields can be empty). After validation, the property record is updated. Specifically:

* Basic fields (price, size, address, etc.) are overwritten with the new values.
* For each new image file provided, it is stored in `public/Images/` and an `ApartmentImage` record is created linking it to the property.
* If a new `tour_zip` is provided, the existing virtual tour directory for this property (if any) is deleted and replaced with the contents of the new ZIP, and `virtual_tour_path` is updated.

**Example Request:** (updating a listing, JSON representation)

```json
{
  "price": 275000,
  "street": "123 Elm Street, Apt 5B",
  "city": "Cairo",
  "age": 6,
  "rooms": 4,
  "bathrooms": 2,
  "phone": "0123456789",
  "elevator": true,
  "balcony": true,
  "parking": true,
  "private_garden": false,
  "central_air_conditioning": true,
  "images": [ /* newImage1.jpg */ ],
  "tour_zip": /* file newTour.zip */
}
```

_(In this example, the address and some details were changed, one new image is added, and a new tour ZIP is uploaded. Fields like `balcony` that were previously false are now sent as true to update them.)_

**Response:** On success, returns a redirect to the property’s detail page (`/property/{id}`) with a flash message “Property updated successfully.” The updated information is immediately visible on the listing page. If validation fails, the user is redirected back to the edit form with error messages.

#### DELETE `/seller/images/{image}`

**Description:** Removes a specific image from a property listing.

**Auth Required:** Yes (seller only; must own the listing that the image belongs to)\
**Path Parameters:**

* `{image}` – **integer**, required. The ID of the image to delete (this corresponds to an `ApartmentImage` record).

When this endpoint is called, the server will delete the image file from storage (`public/Images/{filename}`) if it exists, and remove the image record from the database.

**Response:** A JSON confirmation is returned upon success.

```json
{
  "success": "Image deleted successfully"
}
```

After this, the removed image will no longer appear on the property’s detail page or edit form. (If the image ID is invalid or does not belong to a property of the current user, the request will result in a 404 error.)

#### DELETE `/properties/{apartment}`

**Description:** Deletes an entire property listing, including all its images and associated data.

**Auth Required:** Yes (seller only; must be the owner of the listing)\
**Path Parameters:**

* `{apartment}` – **integer**, required. The ID of the property to delete.

On calling this endpoint, the server will:

* Delete all image files for that property from storage and remove their database records.
* Delete the property record itself. (This will also implicitly remove related bookmarks or inquiries via foreign key constraints, if any.)
* **Note:** If a virtual tour directory exists for this property, it is **not** automatically removed here (the code does not explicitly handle tour cleanup on property deletion).

**Response:** On success, returns a redirect to the profile page (`/profile`) with a flash message “Property removed.” The deleted listing will no longer appear in any listing or profile. (If the property ID is not found or the user is not authorized, a 404 or redirect will occur accordingly.)

#### DELETE `/properties/{apartment}/tour`

**Description:** Removes the 360° virtual tour for a property listing.

**Auth Required:** Yes (seller only; must own the listing)\
**Path Parameters:**

* `{apartment}` – **integer**, required. The ID of the property whose virtual tour should be removed.

When called, the server deletes the directory containing the virtual tour assets (`public/tours/{propertyId}`) and sets the property’s `virtual_tour_path` field to `null` (no tour). This effectively disables the virtual tour feature for that listing.

**Response:** On success, returns a redirect back to the property edit page (`/properties/{id}/edit`) with a flash message “Virtual tour removed.” The property will no longer show a virtual tour on its detail page. (If the property ID is invalid or the user is not the owner, a 404 or access error is returned.)

***

### Property Comparison

#### GET `/property/{id}/compare`

**Description:** Displays the property comparison page. Allows a user to compare the details of one property with another.

**Auth Required:** No (any user can compare listings)\
**Path Parameters:**

* `{id}` – **integer**, required. The ID of the primary property to compare.

**Query Parameters:**

* `other_id` – **integer**, optional. The ID of a second property to compare against.

On initial load (without `other_id`), this endpoint shows the comparison view with the chosen property in one column and the second column empty (prompting the user to select another property). If `other_id` is provided and valid, the page will display both the primary property and the secondary property side by side, comparing their attributes (price, size, rooms, amenities, etc.).

If the primary property ID is not found, a 404 error occurs. If `other_id` is provided but is invalid or not found, the second column will simply remain empty (no error is thrown on the page; the comparison will just show the first property).

**Response:** Returns an HTML page (`property.compare` view) showing the comparison interface. Users can use a search or select dropdown on this page to pick a second property (which triggers the endpoint below).

#### GET `/compare/update/{id}`

**Description:** AJAX endpoint to fetch a property’s info for comparison. This is used to dynamically load a second property into the comparison view without a full page reload.

**Auth Required:** No\
**Path Parameters:**

* `{id}` – **integer**, required. The ID of the property to load into the comparison.

When called (via an AJAX request from the comparison page), the server finds the property by ID and returns a fragment of HTML containing that property’s details formatted as a comparison column. This includes all the key fields (price, size, rooms, etc.) laid out in the same structure as the first column.

If the property ID is not found, a 404 error is returned (the frontend should handle this by showing an appropriate message). Otherwise, the HTML snippet for the property’s comparison column is returned.

**Response:** An HTML snippet (partial view `property._compareColumn`) with the property’s specs. The front-end script inserts this into the comparison page to display the second property next to the first one.

***

### Price Estimation

#### GET `/estimate`

**Description:** Displays the property price estimation form. Users (typically logged in, though no strict auth required) can input details about a hypothetical property to get a suggested price.

**Auth Required:** No (accessible to any user, link is shown in nav when logged in)\
Returns an HTML page with a form asking for City, Size, Age, and Rooms. No calculation is done on GET.

#### POST `/estimate`

**Description:** Calculates an estimated price for a property given basic details.

**Auth Required:** No\
**Request Body:** (form fields)

* `city` – **string**, required. The city or location of the property.
* `size` – **numeric**, required. The size of the property in square feet.
* `age` – **integer**, required. The age of the property (years).
* `rooms` – **integer**, required. The number of rooms.

When the form is submitted, these inputs are validated and then fed into the pricing algorithm. The system looks up an average price-per-square-foot for the given city (from an internal `average_prices` dataset). If the city is not found in the dataset, the estimation will not be available (result will be `null`). If the city is known, the estimated price is calculated as:

* **Base Price** = `avg_price_per_sqft * size` (product of average price per sqft in that city and the given size).
* **Age Factor**: For properties older than 5 years, the price is adjusted downwards by 1% per year over 5 (up to a 50% reduction for very old properties). For example, age 10 → 5% reduction, age 20 → 15% reduction, etc.
* **Room Factor**: For properties with more than 2 rooms, the price is adjusted upwards by 5% for each extra room over 2. (e.g. 3 rooms → +5%, 5 rooms → +15%).

The final estimated price = Base Price × Age Factor × Room Factor, rounded to 2 decimal places.

**Example Request:**

```json
{
  "city": "Los Angeles",
  "size": 1000,
  "age": 10,
  "rooms": 4
}
```

**Example Response:** (If data for the city exists)

```json
{
  "estimatedPrice": 950000.00
}
```

In this example, the city’s average price data was found and the calculation yielded $950,000.00 as the estimate. The HTML page will display this number to the user. If the city is not in the database (or no data), the result would be `estimatedPrice: null` and the view might indicate that no estimate could be provided for that city.

_(Note: The estimation is for guidance only. This endpoint does not create any record; it purely returns a calculated value on the form page.)_

***

### Inquiries (Contact Seller)

#### POST `/inquiry/{id}/email`

**Description:** Sends an inquiry message from a logged-in buyer to the seller of a property. Also logs the inquiry in the system.

**Auth Required:** Yes (must be logged in to send an inquiry)\
**Path Parameters:**

* `{id}` – **integer**, required. The ID of the property for which the inquiry is being made. Typically this is the property currently being viewed by the buyer.

**Request Body:** (form fields)

* `name` – **string**, required. The full name of the inquiring user (buyer).
* `email` – **string**, required. Email address of the buyer (for the seller to reply to).
* `phone` – **string**, required. Phone number of the buyer (contact number).
* `message` – **string**, required. The content of the inquiry message.

All fields are required and are validated for presence (and proper format for email). Upon submission:

* A new Inquiry record is created in the database linking the buyer (if logged in, the `buyer_id` is set to the user’s ID) and the property (`apartment_id`).
* An email is sent to the property’s seller’s email address, containing the buyer’s message and contact info (using a mailable `BuyerInquiryMail`).
* The buyer remains on the property page (the request uses `back()` to return to the same page) and a success message is flashed.

**Response:** On success, returns a redirect back to the property page (HTTP 302) with a flash message “Inquiry submitted successfully!”. The seller will receive an email if their email is on file, and can later view inquiries (if an inquiries management interface is implemented). If validation fails (any field missing or invalid), the user is redirected back with error messages.
