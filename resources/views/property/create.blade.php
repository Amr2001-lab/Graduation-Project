<!DOCTYPE html>
<html>
<head>
    <title>List a New Property</title>
    <link rel="stylesheet" href="{{ asset('look.css') }}">
</head>
<body>
    <header>
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
                    <input type="number" name="size" id="size" required value="{{ old('size') }}" placeholder="e.g. 1200">
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" name="price" id="price" required value="{{ old('price') }}" step="0.01" placeholder="e.g. 250000">
                </div>

                <div class="form-group">
                    <label for="street">Street</label>
                    <input type="text" name="street" id="street" required value="{{ old('street') }}" placeholder="e.g. 123 Main St">
                </div>

                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" name="city" id="city" required value="{{ old('city') }}" placeholder="e.g. Los Angeles">
                </div>

                <div class="form-group">
                    <label for="age">Building Age (years)</label>
                    <input type="number" name="age" id="age" value="{{ old('age') }}" placeholder="e.g. 5">
                </div>

                <div class="form-group">
                    <label for="rooms">Rooms</label>
                    <input type="number" name="rooms" id="rooms" value="{{ old('rooms') }}" placeholder="e.g. 3">
                </div>

                <div class="form-group">
                    <label for="bathrooms">Bathrooms</label>
                    <input type="number" name="bathrooms" id="bathrooms" value="{{ old('bathrooms') }}" placeholder="e.g. 2">
                </div>

                <div class="form-group">
                    <label for="phone">Contact Phone</label>
                    <input type="text" name="phone" id="phone" placeholder="e.g. +1 555-555-5555" value="{{ old('phone') }}">
                </div>

                <div class="form-group">
                    <label for="images">Property Images</label>
                    <input type="file" name="images[]" id="images" multiple>
                    <div id="image-names"></div>
                </div>

                <button type="submit" class="btn btn-primary">List Property</button>
            </form>
        </div>
    </main>

    <footer>
        </footer>
    <script>
        document.getElementById('images').addEventListener('change', function() {
            const files = this.files;
            let names = 'Selected files: ';
            for (let i = 0; i < files.length; i++) {
                names += files[i].name + ', ';
            }
            document.getElementById('image-names').innerText = names.slice(0, -2); // Remove last comma and space
        });
    </script>
</body>
</html>