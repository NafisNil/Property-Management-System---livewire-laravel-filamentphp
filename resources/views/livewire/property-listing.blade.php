<div style="background-color: var(--neutral); min-height: 100vh;">
    <style>
        :root {
            --primary: #003366;
            --secondary: #3CB371;
            --accent: #FF4500;
            --neutral: #F4F4F4;
        }
        /* Force 3/6/3 layout (filters / content / ads) */
        .property-grid { display: grid; grid-template-columns: 3fr 6fr 3fr; gap: 2rem; }
        @media (max-width: 1024px){ /* collapse to single column on smaller screens */
            .property-grid { grid-template-columns: 1fr; }
        }
        
        .btn-primary-new {
            background-color: var(--primary);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: none;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .btn-primary-new:hover {
            background-color: #002244;
        }
        
        .btn-secondary-new {
            background-color: var(--secondary);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: none;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .btn-secondary-new:hover {
            background-color: #2fa55f;
        }
        
        .btn-accent-new {
            background-color: var(--accent);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: none;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .btn-accent-new:hover {
            background-color: #e63d00;
        }
        
        .filter-input {
            border: 1px solid #ddd;
            border-radius: 0.375rem;
            padding: 0.5rem;
            width: 100%;
            font-size: 0.875rem;
        }
        
        .filter-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 51, 102, 0.1);
        }
        /* Two-column listing grid (collapses to one on small screens) */
        .two-col-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
        @media (max-width: 640px){ .two-col-grid { grid-template-columns: 1fr; } }

        /* Badge utilities: fixed top-left overlay */
        .badge { position: absolute; top: 0.75rem; left: 0.75rem; padding: 0.25rem 0.5rem; font-size: 0.75rem; font-weight: 700; border-radius: 0.375rem; color: #fff; line-height: 1; }
        .badge-featured { background-color: #3B82F6; }
        .badge-standard { background-color: #4B5563; }
        .photo-count { position: absolute; bottom: 0.75rem; left: 0.75rem; font-size: 0.75rem; font-weight: 600; background: rgba(255,255,255,0.9); padding: 0.25rem 0.5rem; border-radius: 0.25rem; display: flex; align-items: center; gap: 0.25rem; }
        /* List view thumbnail size override (stable even if utility classes absent) */
        .list-thumb { width: 144px; height: 112px; }
        /* Consistent internal paddings */
        .grid-card { padding: 0.5rem; }
        .card-body-pad { padding: 1rem; }
        .list-row-pad { padding: 1rem; }
        /* Sort bar spacing */
        .sort-bar { display:flex; align-items:center; justify-content:space-between; padding: 1rem 1.25rem; gap:1.25rem; }
        .sort-group { display:flex; align-items:center; gap:0.75rem; flex-wrap:wrap; }
        .toggle-group { display:flex; align-items:center; gap:0.5rem; }
        /* Filter panel extra padding */
        .filters-panel { padding: 1.75rem 1.5rem; }
    </style>
    


    <!-- Main Content Grid: 3 columns for filters, 6 for results, 3 for ads -->
    <div class="px-4 sm:px-6 lg:px-8 py-6">
        <div class="max-w-7xl mx-auto property-grid">
            
            <!-- LEFT COLUMN: FILTERS (1/4 width) -->
            <aside>
                <div class="bg-white rounded-lg filters-panel shadow-md h-fit sticky top-20">
                    <div style="border-bottom: 3px solid var(--primary);" class="pb-3 mb-5">
                        <h3 class="text-lg font-bold" style="color: var(--primary);">Filters</h3>
                    </div>

                    <!-- Search -->
                    <div class="mb-4">
                        <label class="text-sm font-semibold mb-2 block" style="color: var(--primary);">Search</label>
                        <input wire:model.debounce.500ms="search" type="text" class="filter-input" placeholder="Title, city, state...">
                    </div>


                    <!-- Listing Type -->
                    <div class="mb-5 pb-5 border-b">
                        <h4 class="text-sm font-bold mb-3" style="color: var(--primary);">Listing type</h4>
                        <select wire:model.lazy="listingType" class="filter-input">
                            <option value="">Any</option>
                            @foreach(\App\Models\Property::getListingTypes() as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Filter -->
                    <div class="mb-5 pb-5 border-b">
                        <h4 class="text-sm font-bold mb-3" style="color: var(--primary);">Price</h4>
                        <input wire:model.lazy="minPrice" type="number" min="0" class="filter-input mb-2" placeholder="Min price">
                        <input wire:model.lazy="maxPrice" type="number" min="0" class="filter-input" placeholder="Max price">
                    </div>

                    <!-- Property Type -->
                    <div class="mb-4">
                        <h4 class="text-sm font-bold mb-3" style="color: var(--primary);">Property type</h4>
                        <select wire:model.lazy="propertyType" class="filter-input">
                            <option value="">Any</option>
                            @foreach(\App\Models\Property::getPropertyTypes() as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Bedrooms & Featured -->
                    <div class="mb-4">
                        <label class="text-sm font-semibold mb-2 block" style="color: var(--primary);">Min bedrooms</label>
                        <input wire:model.lazy="minBedrooms" type="number" min="0" class="filter-input" placeholder="0">
                    </div>
                    <div class="mb-4 flex items-center gap-2">
                        <input wire:model="featuredOnly" id="featuredOnlySidebar" type="checkbox" class="w-4 h-4" style="accent-color: var(--primary);">
                        <label for="featuredOnlySidebar" class="text-sm">Featured only</label>
                    </div>

                    <button wire:click="resetFilters" type="button" class="w-full btn-secondary-new mt-4">Update</button>
                </div>
            </aside>

            <!-- CENTER COLUMN: SEARCH RESULTS (2/4 width - double) -->
            <section>
                    <!-- Header Section -->
    <div class="border-b bg-white px-4 sm:px-6 lg:px-8 py-4 mt-6 rounded shadow-sm mb-4" style="padd">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold" style="color: var(--primary);">{{ $properties->total() ?? '—' }} ads Property for Sale</h1>
                    <nav class="text-xs font-medium text-gray-500 mt-1 uppercase tracking-wide">Home / Property / For Sale</nav>
                </div>

            </div>
        </div>
    </div>
                <!-- Sort Bar -->
                <div class="sort-bar mt-6 bg-white rounded-lg shadow-sm flex-wrap">
                    <div class="sort-group">
                        <span class="text-sm font-semibold" style="color: var(--primary);">Sort:</span>
                        <select wire:model="sortPreset" wire:change="applySortPreset($event.target.value)" class="filter-input py-2 px-3 text-sm">
                            <option value="recent">Most recent first</option>
                            <option value="price_asc">Price (low to high)</option>
                            <option value="price_desc">Price (high to low)</option>
                        </select>
                    </div>
                    <div class="toggle-group">
                        <button wire:click="toggleViewMode('grid')" type="button" class="p-2 rounded transition {{ $viewMode === 'grid' ? 'btn-primary-new' : 'bg-white text-gray-700 border border-gray-300 hover:border-gray-400' }}" title="Grid view">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                <rect x="3" y="3" width="7" height="7"></rect>
                                <rect x="14" y="3" width="7" height="7"></rect>
                                <rect x="14" y="14" width="7" height="7"></rect>
                                <rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                        </button>
                        <button wire:click="toggleViewMode('list')" type="button" class="p-2 rounded transition {{ $viewMode === 'list' ? 'btn-primary-new' : 'bg-white text-gray-700 border border-gray-300 hover:border-gray-400' }}" title="List view">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="8" y1="6" x2="21" y2="6"></line>
                                <line x1="8" y1="12" x2="21" y2="12"></line>
                                <line x1="8" y1="18" x2="21" y2="18"></line>
                                <line x1="3" y1="6" x2="3.01" y2="6"></line>
                                <line x1="3" y1="12" x2="3.01" y2="12"></line>
                                <line x1="3" y1="18" x2="3.01" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Listings -->
                @if($properties->count())
                    @if($viewMode === 'grid')
                        <div class="two-col-grid">
                            @foreach($properties as $property)
                                <article class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition grid-card">
                                    <a href="{{ route('properties.show', $property) }}" class="h-48 bg-gray-200 flex items-center justify-center relative overflow-hidden group">
                                        @if($property->main_image)
                                            <img src="/storage/{{ $property->main_image }}" alt="{{ $property->title }}" class="h-full w-full object-cover group-hover:scale-105 transition duration-300">
                                        @else
                                            <div class="text-gray-400 text-2xl">📷</div>
                                        @endif
                                        @if($property->is_featured)
                                            <span class="badge badge-featured">Featured</span>
                                        @else
                                            <span class="badge badge-standard">Standard</span>
                                        @endif

                                        <div class="photo-count">📷 {{ is_array($property->images ?? null) ? count($property->images) : 0 }}</div>
                                    </a>

                                    <div class="card-body-pad">
                                        <a href="{{ route('properties.show', $property) }}" class="hover:underline">
                                            <h3 class="text-base font-bold mb-1 line-clamp-2" style="color: var(--primary);">{{ $property->title }}</h3>
                                        </a>
                                        <p class="text-xs text-gray-600 mb-3">{{ $property->full_address }}</p>
                                        @php
                                            $typeIcons = [
                                                'house' => '🏠',
                                                'apartment' => '🏢',
                                                'condo' => '🏬',
                                                'townhouse' => '🏘️',
                                                'villa' => '🏡',
                                                'land' => '🌱',
                                                'commercial' => '🏢',
                                                'other' => '❓'
                                            ];
                                            $typeLabel = \App\Models\Property::getPropertyTypes()[$property->type] ?? ucfirst($property->type);
                                            $icon = $typeIcons[$property->type] ?? '🏢';
                                        @endphp
                                        <div class="flex items-center gap-1 text-xs text-gray-600 mb-2">
                                            <span>{{ $icon }}</span>
                                            <span>{{ $typeLabel }}</span>
                                        </div>
                                        <div class="text-lg font-bold" style="color: var(--secondary);">
                                            {{ $property->bedrooms }}bd • {{ $property->bathrooms }}ba • {{ number_format($property->area_sqft) }}sqft
                                        </div>
                                        <div class="text-lg font-bold mt-2" style="color: var(--accent);">{{ $property->formatted_price }}</div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($properties as $property)
                                <div class="flex gap-3 list-row-pad bg-white rounded-lg shadow-sm hover:shadow-md transition border-l-4" style="border-left-color: var(--secondary);">
                                    <a href="{{ route('properties.show', $property) }}" class="list-thumb bg-gray-200 flex items-center justify-center overflow-hidden rounded shrink-0 relative">
                                        @if($property->main_image)
                                            <img src="storage/{{ $property->main_image }}" alt="{{ $property->title }}" class="w-full h-full object-cover" style="object-fit: cover;">
                                        @else
                                            <div class="text-gray-400 text-lg">📷</div>
                                        @endif
                                        @if($property->is_featured)
                                            <span class="badge badge-featured">Featured</span>
                                        @else
                                            <span class="badge badge-standard">Standard</span>
                                        @endif
                                    </a>

                                    <div class="flex-1 min-w-0">
                                        <a href="{{ route('properties.show', $property) }}" class="hover:underline">
                                            <h4 class="text-sm font-bold mb-1 line-clamp-1" style="color: var(--primary);">{{ $property->title }}</h4>
                                        </a>
                                        <p class="text-xs text-gray-600 mb-2 line-clamp-1">{{ $property->full_address }}</p>
                                        @php
                                            $typeIcons = [
                                                'house' => '🏠',
                                                'apartment' => '🏢',
                                                'condo' => '🏬',
                                                'townhouse' => '🏘️',
                                                'villa' => '🏡',
                                                'land' => '🌱',
                                                'commercial' => '🏢',
                                                'other' => '❓'
                                            ];
                                            $typeLabel = \App\Models\Property::getPropertyTypes()[$property->type] ?? ucfirst($property->type);
                                            $icon = $typeIcons[$property->type] ?? '🏢';
                                        @endphp
                                        <div class="flex items-center gap-1 text-xs text-gray-600 mb-1">
                                            <span>{{ $icon }}</span>
                                            <span>{{ $typeLabel }}</span>
                                        </div>
                                        <p class="text-xs text-gray-500">{{ $property->bedrooms }}bd • {{ $property->bathrooms }}ba</p>
                                    </div>

                                    <div class="text-right shrink-0">
                                        <div class="font-bold" style="color: var(--accent); font-size: 0.875rem;">{{ $property->formatted_price }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-6">
                        {{ $properties->links() }}
                    </div>
                @else
                    <div class="p-8 text-center bg-white rounded-lg shadow-md">
                        <div class="text-4xl mb-2">🔍</div>
                        <h3 class="font-bold mb-1" style="color: var(--primary);">No Properties Found</h3>
                        <p class="text-sm text-gray-600">Try adjusting your filters</p>
                    </div>
                @endif
            </section>

            <!-- RIGHT COLUMN: ADS (1/4 width) -->
            <aside>
                <div class="sticky top-20 space-y-4">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="h-48" style="background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);">
                            <div class="h-full flex items-center justify-center text-white">
                                <div class="text-center">
                                    <div class="text-3xl font-bold mb-1">AD 1</div>
                                    <p class="text-xs opacity-90">Advertisement</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-lg shadow-md border-t-4" style="border-top-color: var(--accent);">
                        <h4 class="text-sm font-bold mb-2" style="color: var(--primary);">Save search</h4>
                        <p class="text-xs text-gray-600 mb-3">Get alerts for new listings matching your criteria.</p>
                        <button class="w-full btn-accent-new text-sm py-2 rounded font-semibold">Create Alert</button>
                    </div>

                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="h-40" style="background: linear-gradient(135deg, var(--secondary) 0%, var(--accent) 100%);">
                            <div class="h-full flex items-center justify-center text-white">
                                <div class="text-center">
                                    <div class="text-2xl font-bold">AD 2</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

        </div>
    </div>

</div>
