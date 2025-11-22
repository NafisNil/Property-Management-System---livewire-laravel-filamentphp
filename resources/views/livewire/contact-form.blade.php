<div style="background-color: var(--neutral); min-height: 100vh;">
    <style>
        :root { --primary:#003366; --secondary:#3CB371; --accent:#FF4500; --neutral:#F4F4F4; }
        .panel { background:#fff; border-radius:.75rem; box-shadow:0 4px 14px rgba(0,0,0,.06); }
        .field-label { font-size:.75rem; font-weight:600; letter-spacing:.02em; color:var(--primary); text-transform:uppercase; }
        .input-control { width:100%; border:1px solid #d1d5db; background:#fff; border-radius:.5rem; padding:.65rem .85rem; font-size:.875rem; }
        .input-control:focus { outline:none; border-color:var(--primary); box-shadow:0 0 0 3px rgba(0,51,102,.18); }
        .error { font-size:.7rem; color:#dc2626; margin-top:.25rem; }
        .btn-primary-new { background:var(--primary); color:#fff; padding:.7rem 1.1rem; border-radius:.55rem; font-weight:600; display:inline-flex; align-items:center; gap:.5rem; }
        .btn-primary-new:hover { background:#002244; }
        .success-box { background:#ecfdf5; border:1px solid #10b981; color:#065f46; padding:.75rem 1rem; border-radius:.5rem; font-size:.85rem; }
    </style>
    <div class="px-4 sm:px-6 lg:px-8 py-6">
        <div class="max-w-3xl mx-auto">
            <div class="panel p-6 mb-6">
                <div class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">
                    <a href="{{ route('properties.listing') }}" class="text-gray-500 hover:text-primary transition">Home</a>
                    <span class="text-gray-400 mx-1">/</span>
                    <a href="{{ route('properties.show', $property) }}" class="text-gray-500 hover:text-primary transition">{{ $property->title }}</a>
                    <span class="text-gray-400 mx-1">/</span>
                    <span class="text-gray-700 font-semibold">Contact</span>
                </div>
                <h1 class="text-2xl font-extrabold mb-1" style="color: var(--primary);">Contact About This Property</h1>
                <p class="text-sm text-gray-600">Fill in the form below and the owner will get your enquiry.</p>
            </div>

            <div class="panel p-6">
                @if($successMessage)
                    <div class="success-box mb-4">{{ $successMessage }}</div>
                @endif
                <form wire:submit.prevent="submit" class="space-y-5">
                    <div>
                        <label class="field-label" for="name">Name</label>
                        <input wire:model.lazy="name" id="name" type="text" class="input-control" placeholder="Your full name">
                        @error('name') <div class="error">{{ $message }}</div> @enderror
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="field-label" for="email">Email</label>
                            <input wire:model.lazy="email" id="email" type="email" class="input-control" placeholder="you@example.com">
                            @error('email') <div class="error">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label class="field-label" for="phone">Phone (optional)</label>
                            <input wire:model.lazy="phone" id="phone" type="text" class="input-control" placeholder="+1 555 123 4567">
                            @error('phone') <div class="error">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="field-label" for="message">Message</label>
                        <textarea wire:model.lazy="message" id="message" rows="5" class="input-control" placeholder="Your message about this property"></textarea>
                        @error('message') <div class="error">{{ $message }}</div> @enderror
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="submit" class="btn-primary-new">Send Enquiry</button>
                        <a href="{{ route('properties.show', $property) }}" class="text-sm text-gray-600 hover:text-primary">Back to property</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
