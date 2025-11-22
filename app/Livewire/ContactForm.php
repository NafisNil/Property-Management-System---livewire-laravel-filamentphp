<?php

namespace App\Livewire;

use App\Models\Property;
use App\Models\Enquiry;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ContactForm extends Component
{
    public Property $property;
    public $name = '';
    public $email = '';
    public $message = '';
    public $successMessage = '';
    public $phone = '';
    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'message' => 'required|string|max:1000',
    ];

    public function mount(Property $property): void
    {
        $this->property = $property;
        $this->message = "I'm interested in the property: " . $property->title;
    }
    public function submit(): void
    {
        $data = $this->validate();
        Enquiry::create([
            'property_id' => $this->property->id,
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'message' => $data['message'],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        if ($this->property->contact_email) {
            # code...
            Mail::to($this->property->contact_email)->send(new \App\Mail\PropertyEnquiryMail($this->property, $data));
        }
        $this->successMessage = 'Your enquiry has been sent successfully.';
        $this->reset(['name','email','phone']);
        $this->message = "I'm interested in the property: " . $this->property->title; // keep base msg
    }


    public function render()
    {
        return view('livewire.contact-form');
    }
}
