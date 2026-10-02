@extends('layouts.app')

@section('page_title', 'Contact Us - Royal Heaven Hotel')

@section('content')
    {{-- Hero Section --}}
    <x-hero-section
        title="Contact Us"
        subtitle="Get In Touch"
        description="Get in touch with us for reservations, inquiries, or any questions about your stay at Royal Heaven Hotel."
        image="user/contactUs3 (1).jpg"
        ctaText="Call Now"
        ctaLink="tel:+6281239450638"
        splitPercent="50"
        angle="105"
    />

    <!-- Contact Information & Form Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

                <!-- Contact Information -->
                <div class="space-y-8">
                    <div>
                        <span class="inline-block px-3 py-1 text-xs font-semibold tracking-wider text-yellow-800 uppercase bg-yellow-100 rounded-full mb-4">Get In Touch</span>
                        <h2 class="text-3xl font-extrabold text-gray-900 mb-6">
                            Contact Information
                        </h2>
                        <p class="text-lg text-gray-600 mb-8">
                            We're here to help and answer any question you might have. We look forward to hearing from you.
                        </p>

                        <!-- Contact Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Address -->
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Address</h3>
                                    <p class="text-gray-600">Jl. Raya Bogor KM 47, Cibinong, Bogor<br>Jawa Barat 16911, Indonesia</p>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Phone</h3>
                                    <p class="text-gray-600">+62 812-3945-0638</p>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Email</h3>
                                    <p class="text-gray-600">muhammadarkanfauzi@gmail.com</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Business Hours -->
                    <div class="bg-yellow-50 p-6 rounded-lg">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Business Hours</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h4 class="font-medium text-gray-900">Check-in/Check-out</h4>
                                <p class="text-gray-600">Check-in: 2:00 PM</p>
                                <p class="text-gray-600">Check-out: 12:00 PM</p>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Front Desk</h4>
                                <p class="text-gray-600">24 Hours</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    <div>
                        <span class="inline-block px-3 py-1 text-xs font-semibold tracking-wider text-yellow-800 uppercase bg-yellow-100 rounded-full mb-4">Send Message</span>
                        <h2 class="text-3xl font-extrabold text-gray-900 mb-6">
                            Get In Touch
                        </h2>
                        <p class="text-lg text-gray-600 mb-8">
                            Have a question or need assistance? Send us a message and we'll get back to you as soon as possible.
                        </p>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                            <input type="text" id="name" name="name" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition">
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                            <input type="text" id="subject" name="subject" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition">
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                            <textarea id="message" name="message" rows="6" required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition resize-none"></textarea>
                        </div>

                        <div class="space-y-4">
                            <button type="submit"
                                    class="w-full bg-yellow-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-yellow-700 transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                Send Message
                            </button>

                            <div class="text-center">
                                <span class="text-gray-500 text-sm">or contact us directly:</span>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <a href="https://wa.me/6281239450638?text=Hello%20Royal%20Heaven%20Hotel,%20I%20would%20like%20to%20inquire%20about..."
                                   target="_blank"
                                   class="flex items-center justify-center bg-green-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-green-700 transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                    </svg>
                                    WhatsApp
                                </a>

                                <a href="mailto:muhammadarkanfauzi@gmail.com?subject=Inquiry%20from%20Royal%20Heaven%20Hotel%20Website"
                                   class="flex items-center justify-center bg-blue-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-700 transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    Email
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="py-16 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Find Us</h2>
                <p class="text-lg text-gray-600">Located in the heart of Cibinong, easily accessible from major highways.</p>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-lg">
                <!-- Placeholder for Google Maps -->
                <div class="aspect-w-16 aspect-h-9 bg-gray-200 rounded-lg flex items-center justify-center">
                    <div class="text-center">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                        </svg>
                        <p class="text-gray-500">Interactive Map Coming Soon</p>
                        <p class="text-sm text-gray-400 mt-2">Jl. Raya Bogor KM 47, Cibinong, Bogor</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Frequently Asked Questions</h2>
                <p class="text-lg text-gray-600">Quick answers to common questions about our hotel and services.</p>
            </div>

            <div class="space-y-6">
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">What time is check-in and check-out?</h3>
                    <p class="text-gray-600">Check-in time is 2:00 PM and check-out time is 12:00 PM. Early check-in or late check-out may be available upon request.</p>
                </div>

                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Do you accept pets?</h3>
                    <p class="text-gray-600">We welcome well-behaved pets in designated pet-friendly rooms. Additional fees may apply.</p>
                </div>

                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Is parking available?</h3>
                    <p class="text-gray-600">Yes, we offer complimentary parking for all our guests. Valet parking is also available.</p>
                </div>

                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Do you have airport transfer services?</h3>
                    <p class="text-gray-600">Yes, we provide airport transfer services. Please contact our front desk to arrange transportation.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
