<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $property->city }} Apartment Details</title>

    <link rel="stylesheet" href="{{ asset('look.css') }}">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O5ZtovKkfM2aDmpssY47Qq8N5k6v2hQcN8uHlbzqcpFzMVzIw5N0d7HgA9ETV5k4vYRqcpKdT2DsFIV9y+A=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}">

</head>
<body>
    <header>
        <div class="container header-container">
            <div class="logo">
                <a href="/">
                    <img src="https://www.creativefabrica.com/wp-content/uploads/2021/03/15/blue-real-estate-logo-Graphics-9602598-1-1-580x387.jpg"
                         alt="Real Estate Logo">
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
                            <a href="{{ route('estimate') }}" class="nav-btn">Estimate Property</a>
                        </li>
                        <li class="user-dropdown">
                            <span class="welcome-msg">
                                Welcome, {{ Auth::user()->name }} <i class="fas fa-caret-down"></i>
                            </span>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('profile.show') }}" class="nav-btn">Profile</a>
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="logout-form">
                                        @csrf
                                        <button type="submit" class="nav-btn">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('login.show') }}" class="nav-btn">Login</a>
                        </li>
                        <li>
                            <a href="{{ route('register.show') }}" class="nav-btn">Register</a>
                        </li>
                    @endauth
                </ul>
            </nav>
        </div>
    </header>

    <section class="gallery-slider">
        <div class="swiper-container gallery-top">
            <div class="swiper-wrapper">
                @if(isset($property->images) && count($property->images) > 0)
                    @foreach($property->images as $image)
                        <div class="swiper-slide">
                            <img src="{{ asset('storage/Images/' . $image->image_url) }}"
                                 alt="Image of {{ $property->city }} Apartment">
                        </div>
                    @endforeach
                @else
                    <div class="swiper-slide">
                        <img src="{{ asset('storage/Images/' . $property->image_url) }}"
                             alt="Image of {{ $property->city }} Apartment">
                    </div>
                @endif
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>

        @if(isset($property->images) && count($property->images) > 0)
            <div class="swiper-container gallery-thumbs">
                <div class="swiper-wrapper">
                    @foreach($property->images as $image)
                        <div class="swiper-slide">
                            <img src="{{ asset('storage/Images/' . $image->image_url) }}"
                                 alt="Thumbnail of {{ $property->city }} Apartment">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </section>

    <main class="container" style="padding: 40px 0;">
        <div id="compare-secondary-content">
            <div class="property-details">
                <h2>{{ $property->city }} Apartment Details</h2>
                <p class="price">${{ number_format($property->price, 2) }}</p>
                <ul>
                    <li><strong>Size:</strong> {{ $property->size }} sq ft</li>
                    <li><strong>Address:</strong> {{ $property->street }}</li>
                    <li><strong>Age:</strong> {{ $property->age }} years</li>
                    <li><strong>Rooms:</strong> {{ $property->rooms }}</li>
                    <li><strong>Bathrooms:</strong> {{ $property->bathrooms }}</li>
                    <li><strong>Seller Contact:</strong> {{ $property->phone ?? 'Not Provided' }}</li>
                </ul>
                <div class="card-actions" style="margin-top: 20px;">
                    <a href="{{ route('property.compare', $property->id) }}" class="btn">Compare</a>
                    @auth
                        @if(Auth::user()->id == $property->seller_id)
                            <a href="{{ route('seller.properties.edit', $property->id) }}" class="btn">Edit</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} Real Estate Listings. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('script.js') }}"></script>
</body>
</html>