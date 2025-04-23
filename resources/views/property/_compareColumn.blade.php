<link rel="stylesheet" href="{{ asset('fontawesome/fontawesome-free-6.7.2-web/css/all.min.css') }}">
@php
    $mainImage = $prop->images->first();
    $imgSrc = $mainImage
             ? asset('storage/Images/' . $mainImage->image_url)
             : 'https://via.placeholder.com/400x250.png?text=No+Image';
@endphp

<div style="text-align: center; margin-bottom: 15px;">
    <img src="{{ $imgSrc }}" alt="Property Image" style="width:100%; max-width:400px; border-radius:4px; object-fit:cover;">
</div>

<h3 style="margin-bottom: 10px;">{{ $prop->street }} ({{ $prop->city }})</h3>
<p style="font-weight: bold; margin-bottom: 10px;">${{ number_format($prop->price, 2) }}</p>
<ul style="list-style: none; padding: 0; margin-bottom: 10px;">
    <li>
        <i class="fa-solid fa-ruler-combined"></i>
        <strong>Size:</strong> {{ $prop->size ?? 'N/A' }} sq ft
    </li>
    <li>
        <i class="fa-solid fa-bed"></i>
        <strong>Rooms:</strong> {{ $prop->rooms ?? 'N/A' }}
    </li>
    <li>
        <i class="fa-solid fa-bath"></i>
        <strong>Bathrooms:</strong> {{ $prop->bathrooms ?? 'N/A' }}
    </li>
    <li>
        <i class="fa-solid fa-calendar-alt"></i>
        <strong>Age:</strong> {{ $prop->age ?? 'N/A' }} years
    </li>
    <li>
        <i class="fa-solid fa-phone"></i>
        <strong>Seller Phone:</strong> {{ $prop->phone ?? 'N/A' }}
    </li>
    <li>
        <i class="fa-solid fa-building"></i>
        <strong>Elevator:</strong> {{ $prop->elevator ? 'Yes' : 'No' }}
    </li>
    <li>
        <i class="fa-solid fa-window-maximize"></i>
        <strong>Balcony:</strong> {{ $prop->balcony ? 'Yes' : 'No' }}
    </li>
    <li>
        <i class="fa-solid fa-parking"></i>
        <strong>Parking:</strong> {{ $prop->parking ? 'Yes' : 'No' }}
    </li>
    <li>
        <i class="fa-solid fa-tree"></i>
        <strong>Private Garden:</strong> {{ $prop->private_garden ? 'Yes' : 'No' }}
    </li>
    <li>
        <i class="fa-solid fa-snowflake"></i>
        <strong>Central Air Conditioning:</strong> {{ $prop->central_air_conditioning ? 'Yes' : 'No' }}
    </li>
</ul>
