<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Property Listing</title>
    <link rel="stylesheet" href="{{ asset('look.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <a href="/">
                    <img src="https://www.creativefabrica.com/wp-content/uploads/2021/03/15/blue-real-estate-logo-Graphics-9602598-1-1-580x387.jpg" alt="Real Estate Logo">
                </a>
            </div>
            <nav class="main-nav">
                <ul class="nav-left">
                    <li><a href="/buy">Buy</a></li>
                    <li><a href="/rent">Rent</a></li>
                    <li><a href="/sell">Sell</a></li>
                    <li><a href="/contact">Contact</a></li>
                </ul>
                <ul class="nav-right">
                    @auth
                        <li>
                            <a href="{{ route('property.create') }}" class="nav-btn">List New Property</a>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="nav-btn">Logout</button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </nav>
        </div>
    </header>

    <main class="container" style="padding: 20px 0;">
        <div class="form-card">
            <h2>Edit Property Listing</h2>
            <form action="{{ route('seller.properties.update', $apartment->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" value="{{ $apartment->city }}" required>
                </div>

                <div class="form-group">
                    <label for="street">Address</label>
                    <input type="text" id="street" name="street" value="{{ $apartment->street }}" required>
                </div>

                <div class="form-group">
                    <label for="size">Size (sq ft)</label>
                    <input type="number" id="size" name="size" value="{{ $apartment->size }}" required>
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" id="price" name="price" value="{{ $apartment->price }}" required>
                </div>

                <div class="form-group">
                    <label for="age">Age (years)</label>
                    <input type="number" id="age" name="age" value="{{ $apartment->age }}" required>
                </div>

                <div class="form-group">
                    <label for="rooms">Rooms</label>
                    <input type="number" id="rooms" name="rooms" value="{{ $apartment->rooms }}" required>
                </div>

                <div class="form-group">
                    <label for="bathrooms">Bathrooms</label>
                    <input type="number" id="bathrooms" name="bathrooms" value="{{ $apartment->bathrooms }}" required>
                </div>

                <!-- New Features Checkboxes (Horizontal Row) -->
                <div class="form-group features-checkboxes">
                    <label>Features (Optional)</label>
                    <div class="checkboxes-wrapper">
                        <div class="checkbox-item">
                            <input type="checkbox" name="elevator" id="elevator" value="1" {{ $apartment->elevator ? 'checked' : '' }}>
                            <label for="elevator">Elevator</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="balcony" id="balcony" value="1" {{ $apartment->balcony ? 'checked' : '' }}>
                            <label for="balcony">Balcony</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="parking" id="parking" value="1" {{ $apartment->parking ? 'checked' : '' }}>
                            <label for="parking">Parking</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="private_garden" id="private_garden" value="1" {{ $apartment->private_garden ? 'checked' : '' }}>
                            <label for="private_garden">Private Garden</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" name="central_air_conditioning" id="central_air_conditioning" value="1" {{ $apartment->central_air_conditioning ? 'checked' : '' }}>
                            <label for="central_air_conditioning">Central Air Conditioning</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone">Seller Contact Phone (Optional)</label>
                    <input type="text" id="phone" name="phone" value="{{ $apartment->phone }}">
                </div>

                <div class="form-group">
                    <label>Current Images</label>
                    <div class="current-images-container">
                        @if ($apartment->images->isNotEmpty())
                            @foreach ($apartment->images as $image)
                                <div class="current-image-item">
                                    <img src="{{ asset('storage/Images/' . $image->image_url) }}" alt="Existing Image" style="max-width: 150px; height: auto; margin-right: 10px; margin-bottom: 10px; border: 1px solid #ccc;">
                                    <button type="button" class="btn btn-sm btn-danger remove-image-btn" data-image-id="{{ $image->id }}">Remove</button>
                                </div>
                            @endforeach
                        @else
                            <p>No images uploaded yet.</p>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="images">Property Images (Multiple)</label>
                    <input type="file" id="images" name="images[]" multiple accept="image/*">
                    <div id="selected-images-names"></div>
                </div>

                <button type="submit" class="btn">Update Property</button>
            </form>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} Real Estate Listings. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="{{ asset('script.js') }}"></script>
</body>
</html>
