@php
    $imgSrc = $prop->image_url
              ? asset('storage/Images/' . $prop->image_url)
              : 'https://via.placeholder.com/400x250.png?text=No+Image';
@endphp



<div style="text-align: center; margin-bottom: 15px;">
    <img src="{{ $imgSrc }}" alt="Property Image" style="width:100%; max-width:400px; border-radius:4px; object-fit:cover;">
</div>

<h3 style="margin-bottom: 10px;">{{ $prop->street }} ({{ $prop->city }})</h3>
<p style="font-weight: bold; margin-bottom: 10px;">
    ${{ number_format($prop->price, 2) }}
</p>
<ul style="list-style: none; padding: 0; margin-bottom: 10px;">
    <li><strong>Size:</strong> {{ $prop->size ?? 'N/A' }} sq ft</li>
    <li><strong>Rooms:</strong> {{ $prop->rooms ?? 'N/A' }}</li>
    <li><strong>Bathrooms:</strong> {{ $prop->bathrooms ?? 'N/A' }}</li>
    <li><strong>Age:</strong> {{ $prop->age ?? 'N/A' }} years</li>
    <li><strong>Seller Phone:</strong> {{ $prop->phone ?? 'N/A' }}</li>
</ul>
