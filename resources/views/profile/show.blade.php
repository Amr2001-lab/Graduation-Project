<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ $user->name }}’s Profile – Real Estate Listings</title>
  <link rel="stylesheet" href="{{ asset('look.css') }}" />
  <link rel="stylesheet" href="{{ asset('fontawesome/fontawesome-free-6.7.2-web/css/all.min.css') }}">
</head>
<body>
  <!-- Header omitted for brevity… same as before -->

  <!-- Hero omitted for brevity… same as before -->

  <main class="container profile-content" style="padding:40px 0;">
    <!-- User Details -->
    <section class="user-details" style="margin-bottom:40px;">
      <h2>My Profile</h2>
      <p><strong>Name:</strong> {{ $user->name }}</p>
      <p><strong>Email:</strong> {{ $user->email }}</p>
    </section>

    <!-- WRAP BOTH SECTIONS IN ONE #apartment-grid for the JS handler -->
    <div id="apartment-grid">

      <!-- Bookmarked Properties -->
      <section class="bookmarked-properties" style="margin-bottom:40px;">
        <h2>My Bookmarked Properties</h2>
        @if($bookmarks->isEmpty())
          <p>You haven’t bookmarked any properties yet.</p>
        @else
          <div class="grid">
            @foreach($bookmarks as $bookmark)
              @php
                $apt    = $bookmark->apartment;
                $img    = optional($apt->images->first())->image_url;
                $imgSrc = $img
                  ? asset("storage/Images/{$img}")
                  : 'https://via.placeholder.com/400x250.png?text=No+Image';
              @endphp
              <div class="card">
                <img src="{{ $imgSrc }}" alt="Property Image">
                <div class="card-content">
                  <h3>{{ $apt->city }} Apartment</h3>
                  <p class="price">${{ number_format($apt->price,2) }}</p>
                  <ul>
                    <li><strong>Size:</strong> {{ $apt->size }} sq ft</li>
                    <li><strong>Address:</strong> {{ $apt->street }}</li>
                  </ul>
                </div>
                <div class="card-actions" style="text-align:center;">
                  <a href="{{ route('property.show',$apt->id) }}" class="btn">View Details</a>
                  @auth
                    <form action="{{ route('bookmarks.store') }}"
                          method="POST"
                          class="bookmark-form"
                          style="display:inline-block;">
                      @csrf
                      <input type="hidden" name="apartment_id" value="{{ $apt->id }}">
                      <button type="submit"
                              class="bookmark-btn-only active"
                              title="Remove Bookmark">
                        <svg viewBox="0 0 24 24">
                          <path d="M17 3H7c-1.1 0-2 .9-2 2v16l7-3 7 3V5c0-1.1-.9-2-2-2z"/>
                        </svg>
                      </button>
                    </form>
                  @endauth
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </section>

      <!-- Listed Properties -->
      <section class="listed-properties">
        <h2>My Listed Properties</h2>
        @if($properties->isEmpty())
          <p>You haven’t listed any properties yet.</p>
        @else
          <div class="grid">
            @foreach($properties as $apt)
              @php
                $img    = optional($apt->images->first())->image_url;
                $imgSrc = $img
                  ? asset("storage/Images/{$img}")
                  : 'https://via.placeholder.com/400x250.png?text=No+Image';
                $booked = auth()->check()
                  && auth()->user()->bookmarkedApartments->contains($apt->id);
              @endphp
              <div class="card">
                <img src="{{ $imgSrc }}" alt="Property Image">
                <div class="card-content">
                  <h3>{{ $apt->city }} Apartment</h3>
                  <p class="price">${{ number_format($apt->price,2) }}</p>
                  <ul>
                    <li><strong>Size:</strong> {{ $apt->size }} sq ft</li>
                    <li><strong>Address:</strong> {{ $apt->street }}</li>
                  </ul>
                </div>
                <div class="card-actions" style="text-align:center;">
                  <a href="{{ route('property.show',$apt->id) }}" class="btn">View Details</a>
                  @auth
                    <form action="{{ route('bookmarks.store') }}"
                          method="POST"
                          class="bookmark-form"
                          style="display:inline-block;">
                      @csrf
                      <input type="hidden" name="apartment_id" value="{{ $apt->id }}">
                      <button type="submit"
                              class="bookmark-btn-only {{ $booked ? 'active' : '' }}"
                              title="{{ $booked ? 'Remove Bookmark' : 'Add Bookmark' }}">
                        <svg viewBox="0 0 24 24">
                          <path d="M17 3H7c-1.1 0-2 .9-2 2v16l7-3 7 3V5c0-1.1-.9-2-2-2z"/>
                        </svg>
                      </button>
                    </form>
                  @endauth
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </section>

    </div><!-- /#apartment-grid -->
  </main>

  <!-- Footer omitted for brevity… same as before -->

  <script>window.flashMessages = @json(session()->only(['message','success','error']));</script>
  <script src="{{ asset('script.js') }}"></script>
</body>
</html>
