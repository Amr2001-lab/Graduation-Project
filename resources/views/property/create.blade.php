{{-- resources/views/property/create.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>List a New Property</title>
    <link rel="stylesheet" href="{{ asset('look.css') }}">
</head>
<body>
    <header>
        <!-- (your header/nav here) -->
    </header>

    <main class="container" style="padding: 40px;">
        <div class="card form-card">
            <h1 class="form-heading">List a New Property</h1>

            @if(session('message'))
                <p class="success-message">{{ session('message') }}</p>
            @endif

            @if($errors->any())
                <div class="error-message">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('property.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="size">Size (sq ft)</label>
                    <input
                      type="number"
                      name="size"
                      id="size"
                      required
                      value="{{ old('size') }}"
                      placeholder="e.g. 1200">
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input
                      type="number"
                      name="price"
                      id="price"
                      required
                      step="0.01"
                      value="{{ old('price') }}"
                      placeholder="e.g. 250000">
                </div>

                <div class="form-group">
                    <label for="street">Street</label>
                    <input
                      type="text"
                      name="street"
                      id="street"
                      required
                      value="{{ old('street') }}"
                      placeholder="e.g. 123 Main St">
                </div>

                <div class="form-group">
                    <label for="city">City</label>
                    <input
                      type="text"
                      name="city"
                      id="city"
                      required
                      value="{{ old('city') }}"
                      placeholder="e.g. Los Angeles">
                </div>

                <div class="form-group">
                    <label for="age">Building Age (years)</label>
                    <input
                      type="number"
                      name="age"
                      id="age"
                      value="{{ old('age') }}"
                      placeholder="e.g. 5">
                </div>

                <div class="form-group">
                    <label for="rooms">Rooms</label>
                    <input
                      type="number"
                      name="rooms"
                      id="rooms"
                      value="{{ old('rooms') }}"
                      placeholder="e.g. 3">
                </div>

                <div class="form-group">
                    <label for="bathrooms">Bathrooms</label>
                    <input
                      type="number"
                      name="bathrooms"
                      id="bathrooms"
                      value="{{ old('bathrooms') }}"
                      placeholder="e.g. 2">
                </div>

                <div class="form-group features-checkboxes">
                    <label>Features</label>
                    <div class="checkboxes-wrapper">
                        <div class="checkbox-item">
                            <input
                              type="checkbox"
                              name="elevator"
                              id="elevator"
                              value="1"
                              {{ old('elevator') ? 'checked' : '' }}>
                            <label for="elevator">Elevator</label>
                        </div>
                        <div class="checkbox-item">
                            <input
                              type="checkbox"
                              name="balcony"
                              id="balcony"
                              value="1"
                              {{ old('balcony') ? 'checked' : '' }}>
                            <label for="balcony">Balcony</label>
                        </div>
                        <div class="checkbox-item">
                            <input
                              type="checkbox"
                              name="parking"
                              id="parking"
                              value="1"
                              {{ old('parking') ? 'checked' : '' }}>
                            <label for="parking">Parking</label>
                        </div>
                        <div class="checkbox-item">
                            <input
                              type="checkbox"
                              name="private_garden"
                              id="private_garden"
                              value="1"
                              {{ old('private_garden') ? 'checked' : '' }}>
                            <label for="private_garden">Private Garden</label>
                        </div>
                        <div class="checkbox-item">
                            <input
                              type="checkbox"
                              name="central_air_conditioning"
                              id="central_air_conditioning"
                              value="1"
                              {{ old('central_air_conditioning') ? 'checked' : '' }}>
                            <label for="central_air_conditioning">Central Air Conditioning</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone">Contact Phone</label>
                    <input
                      type="text"
                      name="phone"
                      id="phone"
                      value="{{ old('phone') }}"
                      placeholder="e.g. +1 555-555-5555">
                </div>

                {{-- **Corrected ZIP upload field** --}}
                <div class="form-group">
                    <label for="tour_zip">Virtual Tour (ZIP)</label>
                    <input
                      type="file"
                      name="tour_zip"
                      id="tour_zip"
                      accept=".zip">
                    <small>
                      Must contain <code>index.html</code>, a <code>Build/</code> folder and <code>TemplateData/</code>
                    </small>
                </div>

                <div class="form-group">
                    <label for="images">Property Images</label>
                    <input
                      type="file"
                      name="images[]"
                      id="images"
                      multiple
                      accept="image/*">
                    <div id="image-names" style="margin-top:0.5rem;"></div>
                </div>

                <button type="submit" class="btn btn-primary">
                  List Property
                </button>
            </form>
        </div>
    </main>

    <footer>
        <!-- (your footer here) -->
    </footer>

    <script>
      // show selected image-names preview
      document.getElementById('images').addEventListener('change', function() {
        const names = Array.from(this.files).map(f => f.name).join(', ');
        document.getElementById('image-names').innerText = names ? `Selected: ${names}` : '';
      });
    </script>
</body>
</html>
