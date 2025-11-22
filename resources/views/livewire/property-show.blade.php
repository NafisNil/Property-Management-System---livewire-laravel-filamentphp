<div style="background-color: var(--neutral); min-height: 100vh;">
    <style>
        :root { --primary:#003366; --secondary:#3CB371; --accent:#FF4500; --neutral:#F4F4F4; }
        .container { max-width: 1120px; margin: 0 auto; }
        .stat { display:flex; align-items:center; gap:.5rem; padding:.5rem .75rem; background:#f8fafc; border-radius:.5rem; font-weight:600; color:#334155; }
        .thumb { width:88px; height:66px; border-radius:.375rem; overflow:hidden; background:#e5e7eb; }
        .thumb img{ width:100%; height:100%; object-fit:cover; }
        .badge { position:absolute; top:.75rem; left:.75rem; padding:.25rem .5rem; font-size:.75rem; font-weight:700; border-radius:.375rem; color:#fff; line-height:1; background:#3B82F6; }
        .photo-count { position:absolute; bottom:.75rem; left:.75rem; font-size:.75rem; font-weight:600; background:rgba(255,255,255,.9); padding:.25rem .5rem; border-radius:.25rem; }
        .panel { background:#fff; border-radius:.75rem; box-shadow:0 4px 14px rgba(0,0,0,.06); }
        .section-title { color: var(--primary); font-weight:800; }
        .feature { display:inline-block; margin:.25rem; padding:.35rem .55rem; border-radius:.5rem; background:#f1f5f9; font-size:.85rem; color:#334155; }
        .btn-primary-new { background:var(--primary); color:white; padding:.6rem .9rem; border-radius:.5rem; font-weight:600; }
        .btn-secondary-new { background:var(--secondary); color:white; padding:.6rem .9rem; border-radius:.5rem; font-weight:600; }
    </style>

    <div class="px-4 sm:px-6 lg:px-8 py-6">
        <div class="container">
            <!-- Breadcrumb + Title -->
            <div class="panel px-6 py-4 mb-6">
                <div class="text-xs font-medium uppercase tracking-wide mb-1">
                    <a href="{{ route('properties.listing') }}" class="text-gray-500 hover:text-primary transition">Home</a>
                    <span class="text-gray-400 mx-1">/</span>
                    <a href="{{ route('properties.listing', ['city' => $property->city]) }}" class="text-gray-500 hover:text-primary transition">{{ $property->city }}</a>
                    <span class="text-gray-400 mx-1">/</span>
                    <span class="text-gray-700 font-semibold">{{ $property->title }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold" style="color: var(--primary);">{{ $property->title }}</h1>
            </div>

            <!-- Hero + Gallery -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
                <!-- Main image -->
                <div class="panel lg:col-span-2 overflow-hidden relative">
                    <div class="h-72 sm:h-96 bg-gray-200 flex items-center justify-center relative">
                        @if($property->main_image)
                            <img src="/storage/{{ $property->main_image }}" alt="{{ $property->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="text-gray-400 text-2xl">📷</div>
                        @endif
                        @if($property->is_featured)
                            <span class="badge">Featured</span>
                        @endif
                        <div class="photo-count">📷 {{ is_array($property->images ?? null) ? count($property->images) : 0 }}</div>
                    </div>
                    @if(is_array($property->images) && count($property->images) > 1)
                        <div class="p-3 flex gap-2 overflow-x-auto bg-white">
                            @foreach(array_slice($property->images, 0, 8) as $img)
                                <a href="/storage/{{ $img }}" target="_blank" rel="noopener noreferrer" class="inline-block">
                                    <div class="thumb"><img src="/storage/{{ $img }}" alt="thumb"></div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Key Info / Contact -->
                <aside class="panel p-5 flex flex-col gap-4">
                    @php
                        $typeIcons = [ 'house' => '🏠','apartment' => '🏢','condo' => '🏬','townhouse' => '🏘️','villa' => '🏡','land' => '🌱','commercial' => '🏢','other' => '❓' ];
                        $typeLabel = \App\Models\Property::getPropertyTypes()[$property->type] ?? ucfirst($property->type);
                        $icon = $typeIcons[$property->type] ?? '🏢';
                    @endphp
                    <div class="flex items-center justify-between">
                        <div class="text-xl sm:text-2xl font-extrabold" style="color: var(--accent);">{{ $property->formatted_price }}</div>
                        <div class="text-sm text-gray-600">{{ $icon }} {{ $typeLabel }}</div>
                    </div>
                    <div class="flex gap-2 flex-wrap">
                        <div class="stat">🛏 {{ $property->bedrooms }} bd</div>
                        <div class="stat">🛁 {{ $property->bathrooms }} ba</div>
                        <div class="stat">📐 {{ number_format($property->area_sqft) }} sqft</div>
                        <div class="stat">📍 {{ $property->city }}, {{ $property->state }}</div>
                    </div>
                    <div class="text-sm text-gray-600">{{ $property->full_address }}</div>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2 mt-2">
                        <button class="btn-secondary-new">Call {{ $property->owner_name ?? 'Owner' }}</button>
                        <a class="btn-primary-new text-center" href="mailto:{{ $property->owner_email ?? '' }}">Email</a>
                        <a href="{{ route('properties.contact', $property) }}" class="btn-primary-new text-center" style="background: var(--secondary);">Contact Us</a>
                    </div>
                </aside>
            </div>

            <!-- Description & Features -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <div class="panel p-6 lg:col-span-2">
                    <h2 class="section-title text-lg mb-3">Description</h2>
                    <div class="prose max-w-none text-gray-700 leading-relaxed text-sm">
                        {!! nl2br(e($property->description)) !!}
                    </div>
                </div>
                <div class="panel p-6">
                    <h2 class="section-title text-lg mb-3">Features</h2>
                    @if(is_array($property->features) && count($property->features))
                        @foreach($property->features as $feat)
                            <span class="feature">{{ $feat }}</span>
                        @endforeach
                    @else
                        <p class="text-sm text-gray-500">No features listed.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
