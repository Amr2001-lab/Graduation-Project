<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Edit {{ $apartment->city }} Listing</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" href="{{ asset('look.css') }}" />
  <link rel="stylesheet" href="{{ asset('fontawesome/fontawesome-free-6.7.2-web/css/all.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}" />
</head>
<body>
  {{-- ---------- Header ---------- --}}
  <header>
    <div class="container header-container">
      <div class="logo">
        <a href="/" aria-label="Home">
          <img src="https://www.creativefabrica.com/wp-content/uploads/2021/03/15/blue-real-estate-logo-Graphics-9602598-1-1-580x387.jpg" alt="Logo">
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
            <li><a href="{{ route('property.create') }}" class="nav-btn">List New Property</a></li>
            <li>
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="nav-btn">Logout</button>
              </form>
            </li>
          @endauth
        </ul>
      </nav>
    </div>
  </header>

  {{-- ---------- Page Title ---------- --}}
  <section style="padding:40px 0 10px;text-align:center;">
    <h1 style="font-size:2rem;font-weight:700;margin:0;">Edit Property Listing</h1>
  </section>

  {{-- ---------- Main Card ---------- --}}
  <main class="container" style="padding-bottom:40px;">
    <div class="form-card">
      @if($errors->any())
        <div class="error-message">
          @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
        </div>
      @endif

      {{-- Remove Tour --}}
      @if($apartment->virtual_tour_path)
        <div class="form-group">
          <label>Current Virtual Tour</label>
          <iframe src="{{ asset($apartment->virtual_tour_path.'/index.html') }}"
                  style="width:100%;height:400px;border:1px solid #ccc;" loading="lazy"></iframe>
          <form action="{{ route('seller.properties.removeTour', $apartment->id) }}" method="POST"
                style="display:inline-block;margin-top:0.5rem;">
            @csrf @method('DELETE')
            <button type="submit" class="nav-btn danger">Remove Tour</button>
          </form>
        </div>
      @endif

      {{-- Update Form --}}
      <form action="{{ route('seller.properties.update',$apartment->id) }}" method="POST"
            enctype="multipart/form-data">
        @csrf @method('PUT')
        {{-- City --}}
        <div class="form-group"><label for="city">City</label>
          <input id="city" name="city" value="{{ old('city',$apartment->city) }}" required></div>
        {{-- Address --}}
        <div class="form-group"><label for="street">Address</label>
          <input id="street" name="street" value="{{ old('street',$apartment->street) }}" required></div>
        {{-- Size --}}
        <div class="form-group"><label for="size">Size (sq ft)</label>
          <input type="number" id="size" name="size" value="{{ old('size',$apartment->size) }}" required></div>
        {{-- Price --}}
        <div class="form-group"><label for="price">Price</label>
          <input type="number" id="price" step="0.01" name="price"
                 value="{{ old('price',$apartment->price) }}" required></div>
        {{-- Age --}}
        <div class="form-group"><label for="age">Building Age (years)</label>
          <input type="number" id="age" name="age" value="{{ old('age',$apartment->age) }}" required></div>
        {{-- Rooms --}}
        <div class="form-group"><label for="rooms">Rooms</label>
          <input type="number" id="rooms" name="rooms" value="{{ old('rooms',$apartment->rooms) }}" required></div>
        {{-- Bathrooms --}}
        <div class="form-group"><label for="bathrooms">Bathrooms</label>
          <input type="number" id="bathrooms" name="bathrooms"
                 value="{{ old('bathrooms',$apartment->bathrooms) }}" required></div>

        {{-- Features --}}
        <div class="form-group features-checkboxes"><label>Features (Optional)</label>
          <div class="checkboxes-wrapper">
            @foreach([
              'elevator'=>'Elevator','balcony'=>'Balcony','parking'=>'Parking',
              'private_garden'=>'Private Garden','central_air_conditioning'=>'Central Air Conditioning',
            ] as $field=>$label)
              <div class="checkbox-item">
                <input type="checkbox" id="{{ $field }}" name="{{ $field }}" value="1"
                       {{ old($field,$apartment->$field) ? 'checked' : '' }}>
                <label for="{{ $field }}">{{ $label }}</label>
              </div>
            @endforeach
          </div>
        </div>

        {{-- Phone --}}
        <div class="form-group"><label for="phone">Seller Contact Phone (Optional)</label>
          <input id="phone" name="phone" value="{{ old('phone',$apartment->phone) }}"></div>

        {{-- Upload New Tour --}}
        <div class="form-group"><label for="tour_zip">Upload Virtual Tour (ZIP)</label>
          <input type="file" id="tour_zip" name="tour_zip" accept=".zip">
          <small>Must contain <code>index.html</code>, <code>Build/</code>, and <code>TemplateData</code></small>
        </div>

        {{-- Current Images --}}
        <div class="form-group">
          <label>Current Images</label>
          <div class="current-images-container">
            @forelse($apartment->images as $image)
              <div class="current-image-item"
                   style="display:inline-block;margin:0.5rem;text-align:center;">
                <img src="{{ asset('storage/Images/'.$image->image_url) }}"
                     style="max-width:150px;display:block;margin-bottom:0.5rem;"
                     alt="Image #{{ $loop->iteration }}">
                <button type="button"
                        class="nav-btn danger sm remove-image-btn"
                        data-image-id="{{ $image->id }}">
                  Remove
                </button>
              </div>
            @empty
              <p>No images uploaded yet.</p>
            @endforelse
          </div>
        </div>

        {{-- Add Images --}}
        <div class="form-group">
          <label for="images">Add Property Images (multiple)</label>
          <input type="file" id="images" name="images[]" multiple accept="image/*">
          <div id="images-names" style="margin-top:0.5rem;"></div>
        </div>

        <button type="submit" class="nav-btn" style="margin-top:1.5rem;">Update Property</button>
      </form>
    </div>
  </main>

  <footer>
    <div class="container" style="padding:20px 0;text-align:center;color:#777;font-size:0.9rem;">
      &copy; {{ date('Y') }} Real Estate Listings. All rights reserved.
    </div>
  </footer>

  <script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script>
    window.flashMessages = @json(session()->only(['message','success','error']));
  </script>
  <script src="{{ asset('script.js') }}"></script>
</body>
</html>
