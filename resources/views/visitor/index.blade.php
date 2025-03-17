<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>HealthGate - Your Health Portal</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- AOS CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
<script>
              tailwind.config = {
              theme: {
              extend: {
              colors: {
              primary: '#F8F8F8', // White/Off-white
              secondary: '#FFFFFF', // White
              accent: '#00928C', // Teal
              darkTeal: '#007A75', // Dark Teal
              lightGray: '#F0F0F0' // Light Gray
              }
              }
              }
              }
</script>
<style>
              html {
              scroll-behavior: smooth;
              }

              .animate-fade-in {
              animation: fadeIn 0.8s ease-in-out;
              }

              @keyframes fadeIn {
              from { opacity: 0; transform: translateY(20px); }
              to { opacity: 1; transform: translateY(0); }
              }

              .hover-lift {
              transition: transform 0.3s ease, box-shadow 0.3s ease;
              }

              .hover-lift:hover {
              transform: translateY(-5px);
              box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
              }

              .mobile-menu {
              transition: transform 0.4s ease, opacity 0.4s ease;
              transform: translateY(-100%);
              opacity: 0;
              }

              .mobile-menu.active {
              transform: translateY(0);
              opacity: 1;
              }

              .parallax {
              background-attachment: fixed;
              background-position: center;
              background-repeat: no-repeat;
              background-size: cover;
              }

              .btn-hover-effect {
              position: relative;
              overflow: hidden;
              transition: all 0.3s ease;
              }

              .btn-hover-effect:after {
              content: '';
              position: absolute;
              top: 0;
              left: -100%;
              width: 100%;
              height: 100%;
              background: rgba(255, 255, 255, 0.2);
              transition: all 0.4s ease;
              }

              .btn-hover-effect:hover:after {
              left: 100%;
              }

              @media (prefers-reduced-motion: reduce) {
              *, ::before, ::after {
              animation-duration: 0.01ms !important;
              animation-iteration-count: 1 !important;
              transition-duration: 0.01ms !important;
              scroll-behavior: auto !important;
              }
              .parallax {
              background-attachment: scroll;
              }
              }
</style>

</head>
<body class="bg-primary text-gray-800">
<!-- Navigation -->
<nav class="bg-white shadow-lg sticky top-0 z-50">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="flex justify-between h-16">
<div class="flex items-center">
<div class="flex-shrink-0 flex items-center">
<span class="text-gray-800 text-2xl font-bold">Health<span class="text-accent">Gate</span></span>
</div>
<div class="hidden md:ml-6 md:flex md:space-x-8">
<a href="#home" class="border-accent text-gray-800 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-all duration-300 hover:text-accent">
Home
</a>
<a href="#services" class="border-transparent text-gray-600 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-all duration-300 hover:border-accent hover:text-accent">
Services
</a>
<a href="#doctors" class="border-transparent text-gray-600 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-all duration-300 hover:border-accent hover:text-accent">
Find Doctors
</a>
<a href="#testimonials" class="border-transparent text-gray-600 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-all duration-300 hover:border-accent hover:text-accent">
Testimonials
</a>
<a href="#contact" class="border-transparent text-gray-600 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-all duration-300 hover:border-accent hover:text-accent">
Contact
</a>
</div>
</div>
<div class="hidden md:flex md:items-center md:space-x-4">
              @auth
              <a href="{{ route('patient.dashboard')}}" class="text-gray-600 hover:text-accent px-3 py-2 rounded-md text-sm font-medium transition-all duration-300">Dashboard</a>
              @else
<a href="{{ route('login')}}" class="text-gray-600 hover:text-accent px-3 py-2 rounded-md text-sm font-medium transition-all duration-300">Login</a>
<a href="{{ route('register')}}" class="bg-accent hover:bg-darkTeal text-white px-4 py-2 rounded-md text-sm font-medium transition-all duration-300 btn-hover-effect">Register</a>
              @endauth
</div>
<div class="-mr-2 flex items-center md:hidden">
<button id="mobile-menu-button" type="button" class="bg-white inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-accent hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-accent transition-all duration-300" aria-expanded="false">
<span class="sr-only">Open main menu</span>
<i class="fas fa-bars"></i>
</button>
</div>
</div>
</div>

<!-- Mobile menu, show/hide based on menu state -->
<div id="mobile-menu" class="mobile-menu md:hidden bg-white shadow-lg absolute w-full z-50">
<div class="px-2 pt-2 pb-3 space-y-1">
<a href="#home" class="block px-3 py-2 rounded-md text-base font-medium text-accent bg-gray-50">Home</a>
<a href="#services" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-accent hover:bg-gray-50 transition-all duration-300">Services</a>
<a href="#doctors" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-accent hover:bg-gray-50 transition-all duration-300">Find Doctors</a>
<a href="#testimonials" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-accent hover:bg-gray-50 transition-all duration-300">Testimonials</a>
<a href="#contact" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-accent hover:bg-gray-50 transition-all duration-300">Contact</a>
<div class="border-t border-gray-200 my-2"></div>
<a href="{{ route('login')}}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-accent hover:bg-gray-50 transition-all duration-300">Login</a>
<a href="{{ route('register')}}" class="block px-3 py-2 rounded-md text-base font-medium bg-accent text-white hover:bg-darkTeal transition-all duration-300">Register</a>
</div>
</div>
</nav>

<!-- Hero Section -->
<section id="home" class="relative bg-gradient-to-r from-accent to-darkTeal py-20 overflow-hidden">
<div class="absolute w-full h-full top-0 left-0 parallax" style="background-image: url('https://images.unsplash.com/photo-1504439468489-c8920d796a29?q=80&w=2000&auto=format&fit=crop'); opacity: 0.1;"></div>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
<div class="lg:flex lg:items-center lg:justify-between">
<div class="lg:w-1/2" data-aos="fade-right" data-aos-duration="1000">
<h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl md:text-6xl">
Your Health, Our Priority
</h1>
<p class="mt-3 max-w-md mx-auto text-lg text-white sm:text-xl md:mt-5 md:max-w-3xl">
Access quality healthcare services, book appointments with specialist doctors, and manage your health records all in one place.
</p>
<div class="mt-4 sm:flex">
<div class="rounded-md shadow">
<a href="#services" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-accent bg-white hover:bg-gray-100 md:py-4 md:text-lg md:px-10 transition-all duration-300 btn-hover-effect">
Book Appointment
</a>
</div>
<div class="mt-3 sm:mt-0 sm:ml-3">
<a href="#services" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-darkTeal bg-opacity-80 hover:bg-opacity-100 md:py-4 md:text-lg md:px-10 transition-all duration-300 btn-hover-effect">
Learn More
</a>
</div>
</div>
</div>
<div class="mt-12 lg:mt-0 lg:w-1/2 flex justify-center" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
<img class="h-96 w-auto animate-fade-in hover:-translate-y-2 transition-transform duration-300" src="https://cdn.pixabay.com/photo/2017/01/31/22/32/doctor-2027768_1280.png" alt="Healthcare Professional">
</div>
</div>
</div>
<div class="absolute bottom-0 left-0 right-0">
<div class="mt-16"></div>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full h-auto">
<path fill="#F8F8F8" fill-opacity="1" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,202.7C672,203,768,181,864,181.3C960,181,1056,203,1152,208C1248,213,1344,203,1392,197.3L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
</svg>
</div>
</section>

<!-- Services Section -->
<section id="services" class="py-16 bg-primary">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="text-center" data-aos="fade-up">
<h2 class="text-3xl font-extrabold text-gray-800 sm:text-4xl">
Our Services
</h2>
<p class="mt-4 max-w-2xl mx-auto text-xl text-gray-600">
Comprehensive healthcare solutions for you and your family
</p>
</div>

<div class="mt-16 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
<!-- Service 1 -->
<div class="bg-white rounded-lg shadow-lg overflow-hidden hover-lift border border-gray-200" data-aos="fade-up" data-aos-delay="100">
<div class="p-6">
<div class="flex items-center justify-center h-16 w-16 rounded-full bg-accent bg-opacity-10 text-accent mx-auto transform transition-transform duration-500 hover:rotate-12">
<i class="fas fa-calendar-check text-2xl"></i>
</div>
<h3 class="mt-6 text-center text-xl font-medium text-gray-800">Online Booking</h3>
<p class="mt-4 text-gray-600 text-center">
Book appointments with your preferred doctors online without waiting in queues.
</p>
<div class="mt-6 text-center">
<a href="#" class="inline-flex items-center text-accent hover:text-darkTeal transition-all duration-300">
Book Now
<svg class="ml-2 h-4 w-4 transform transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
</svg>
</a>
</div>
</div>
</div>

<!-- Service 2 -->
<div class="bg-white rounded-lg shadow-lg overflow-hidden hover-lift border border-gray-200" data-aos="fade-up" data-aos-delay="200">
<div class="p-6">
<div class="flex items-center justify-center h-16 w-16 rounded-full bg-accent bg-opacity-10 text-accent mx-auto transform transition-transform duration-500 hover:rotate-12">
<i class="fas fa-user-md text-2xl"></i>
</div>
<h3 class="mt-6 text-center text-xl font-medium text-gray-800">Find Specialists</h3>
<p class="mt-4 text-gray-600 text-center">
Find and connect with specialized doctors based on your health needs.
</p>
<div class="mt-6 text-center">
<a href="#doctors" class="inline-flex items-center text-accent hover:text-darkTeal transition-all duration-300">
Find Doctors
<svg class="ml-2 h-4 w-4 transform transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
</svg>
</a>
</div>
</div>
</div>

<!-- Service 3 -->
<div class="bg-white rounded-lg shadow-lg overflow-hidden hover-lift border border-gray-200" data-aos="fade-up" data-aos-delay="300">
<div class="p-6">
<div class="flex items-center justify-center h-16 w-16 rounded-full bg-accent bg-opacity-10 text-accent mx-auto transform transition-transform duration-500 hover:rotate-12">
<i class="fas fa-file-medical text-2xl"></i>
</div>
<h3 class="mt-6 text-center text-xl font-medium text-gray-800">Health Records</h3>
<p class="mt-4 text-gray-600 text-center">
Access your medical records, prescriptions, and test results anytime, anywhere.
</p>
<div class="mt-6 text-center">
<a href="#" class="inline-flex items-center text-accent hover:text-darkTeal transition-all duration-300">
View Records
<svg class="ml-2 h-4 w-4 transform transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
</svg>
</a>
</div>
</div>
</div>
</div>
</div>
</section>

<!-- Featured Doctors -->
<section id="doctors" class="py-16 bg-secondary">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="text-center" data-aos="fade-up">
<h2 class="text-3xl font-extrabold text-gray-800 sm:text-4xl">
Our Featured Doctors
</h2>
<p class="mt-4 max-w-2xl mx-auto text-xl text-gray-600">
Experienced specialists committed to providing quality healthcare
</p>
</div>

<div class="mt-16 grid gap-8 md:grid-cols-2 lg:grid-cols-4">
<!-- Doctor Cards -->
<div class="bg-white rounded-lg overflow-hidden shadow-lg hover-lift border border-gray-200" data-aos="fade-up" data-aos-delay="100">
<img class="h-64 w-full object-cover object-center transform transition-transform duration-700 hover:scale-105" src="https://randomuser.me/api/portraits/men/32.jpg" alt="Doctor">
<div class="p-6">
<h3 class="text-lg font-medium text-gray-800">Dr. John Smith</h3>
<p class="text-sm text-accent font-medium">Cardiologist</p>
<div class="flex mt-2 text-yellow-500">
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star-half-alt"></i>
<span class="ml-1 text-gray-600">4.8</span>
</div>
<p class="mt-3 text-gray-600 text-sm">
Specializes in heart diseases with over 15 years of experience.
</p>
<div class="mt-4">
<a href="#" class="block w-full bg-accent hover:bg-darkTeal text-white text-center py-2 rounded-md transition-all duration-300 btn-hover-effect">Book Appointment</a>
</div>
</div>
</div>

<div class="bg-white rounded-lg overflow-hidden shadow-lg hover-lift border border-gray-200" data-aos="fade-up" data-aos-delay="200">
<img class="h-64 w-full object-cover object-center transform transition-transform duration-700 hover:scale-105" src="https://randomuser.me/api/portraits/women/32.jpg" alt="Doctor">
<div class="p-6">
<h3 class="text-lg font-medium text-gray-800">Dr. Sarah Johnson</h3>
<p class="text-sm text-accent font-medium">Neurologist</p>
<div class="flex mt-2 text-yellow-500">
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<span class="ml-1 text-gray-600">5.0</span>
</div>
<p class="mt-3 text-gray-600 text-sm">
Expert in brain disorders and nervous system conditions.
</p>
<div class="mt-4">
<a href="#" class="block w-full bg-accent hover:bg-darkTeal text-white text-center py-2 rounded-md transition-all duration-300 btn-hover-effect">Book Appointment</a>
</div>
</div>
</div>

<div class="bg-white rounded-lg overflow-hidden shadow-lg hover-lift border border-gray-200" data-aos="fade-up" data-aos-delay="300">
<img class="h-64 w-full object-cover object-center transform transition-transform duration-700 hover:scale-105" src="https://randomuser.me/api/portraits/men/44.jpg" alt="Doctor">
<div class="p-6">
<h3 class="text-lg font-medium text-gray-800">Dr. David Lee</h3>
<p class="text-sm text-accent font-medium">Pediatrician</p>
<div class="flex mt-2 text-yellow-500">
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="far fa-star"></i>
<span class="ml-1 text-gray-600">4.1</span>
</div>
<p class="mt-3 text-gray-600 text-sm">
Specializes in child healthcare with a gentle approach.
</p>
<div class="mt-4">
<a href="#" class="block w-full bg-accent hover:bg-darkTeal text-white text-center py-2 rounded-md transition-all duration-300 btn-hover-effect">Book Appointment</a>
</div>
</div>
</div>

<div class="bg-white rounded-lg overflow-hidden shadow-lg hover-lift border border-gray-200" data-aos="fade-up" data-aos-delay="400">
<img class="h-64 w-full object-cover object-center transform transition-transform duration-700 hover:scale-105" src="https://randomuser.me/api/portraits/women/44.jpg" alt="Doctor">
<div class="p-6">
<h3 class="text-lg font-medium text-gray-800">Dr. Emily Wilson</h3>
<p class="text-sm text-accent font-medium">Dermatologist</p>
<div class="flex mt-2 text-yellow-500">
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star-half-alt"></i>
<span class="ml-1 text-gray-600">4.7</span>
</div>
<p class="mt-3 text-gray-600 text-sm">
Expert in skin conditions and cosmetic dermatology.
</p>
<div class="mt-4">
<a href="#" class="block w-full bg-accent hover:bg-darkTeal text-white text-center py-2 rounded-md transition-all duration-300 btn-hover-effect">Book Appointment</a>
</div>
</div>
</div>
</div>
</div>
</section>

<!-- Testimonials -->
<section id="testimonials" class="py-16 bg-lightGray">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="text-center" data-aos="fade-up">
<h2 class="text-3xl font-extrabold text-gray-800 sm:text-4xl">
What Our Patients Say
</h2>
<p class="mt-4 max-w-2xl mx-auto text-xl text-gray-600">
Testimonials from people who have used our platform
</p>
</div>

<div class="mt-16 grid gap-8 md:grid-cols-3">
<!-- Testimonials -->
<div class="bg-white rounded-lg p-6 shadow-md hover-lift border border-gray-200" data-aos="fade-up" data-aos-delay="100">
<div class="flex items-center mb-4">
<img class="h-12 w-12 rounded-full" src="https://randomuser.me/api/portraits/women/21.jpg" alt="Patient">
<div class="ml-4">
<h4 class="text-lg font-medium text-gray-800">Lisa Thompson</h4>
<div class="flex text-yellow-500">
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
</div>
</div>
</div>
<p class="text-gray-600 italic">
"HealthGate made it so easy to find a specialist and book an appointment. The entire process was smooth and I received great care!"
</p>
</div>

<div class="bg-white rounded-lg p-6 shadow-md hover-lift border border-gray-200" data-aos="fade-up" data-aos-delay="200">
<div class="flex items-center mb-4">
<img class="h-12 w-12 rounded-full" src="https://randomuser.me/api/portraits/men/67.jpg" alt="Patient">
<div class="ml-4">
<h4 class="text-lg font-medium text-gray-800">Robert Brown</h4>
<div class="flex text-yellow-500">
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="far fa-star"></i>
</div>
</div>
</div>
<p class="text-gray-600 italic">
"Having my health records available digitally has been a game-changer. I can access my test results instantly and share with my doctors."
</p>
</div>

<div class="bg-white rounded-lg p-6 shadow-md hover-lift border border-gray-200" data-aos="fade-up" data-aos-delay="300">
<div class="flex items-center mb-4">
<img class="h-12 w-12 rounded-full" src="https://randomuser.me/api/portraits/women/54.jpg" alt="Patient">
<div class="ml-4">
<h4 class="text-lg font-medium text-gray-800">Jennifer Martinez</h4>
<div class="flex text-yellow-500">
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star"></i>
<i class="fas fa-star-half-alt"></i>
</div>
</div>
</div>
<p class="text-gray-600 italic">
"The reminders for appointments and medications have helped me stay on top of my health. The doctors on the platform are excellent!"
</p>
</div>
</div>
</div>
</section>

<!-- CTA Section -->
@auth

<section class="bg-accent">
<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between" data-aos="fade-up">
<h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
<span class="block">Welcome back, {{ session('user_name') }}!</span>
<span class="block text-white opacity-90">Manage your health and appointments with ease.</span>
</h2>
<div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
<div class="inline-flex rounded-md shadow">
<a href="" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-accent bg-white hover:bg-gray-100 transition-all duration-300 btn-hover-effect">
Go to Dashboard
</a>
</div>
<div class="ml-3 inline-flex rounded-md shadow">
<a href="#services" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-darkTeal hover:bg-accent transition-all duration-300 btn-hover-effect">
Learn More
</a>
</div>
</div>
</div>
</section>
@else

<section class="bg-accent">
<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between" data-aos="fade-up">
<h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
<span class="block">Ready to take control of your health?</span>
<span class="block text-white opacity-90">Register today and get started.</span>
</h2>
<div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
<div class="inline-flex rounded-md shadow">
<a href="{{ route('register')}}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-accent bg-white hover:bg-gray-100 transition-all duration-300 btn-hover-effect">
Register Now
</a>
</div>
<div class="ml-3 inline-flex rounded-md shadow">
<a href="#services" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-darkTeal hover:bg-accent transition-all duration-300 btn-hover-effect">
Learn More
</a>
</div>        
</div>
</div>        
</section>
@endauth
<!-- Contact Section -->
<section id="contact" class="py-16 bg-primary">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="text-center" data-aos="fade-up">
<h2 class="text-3xl font-extrabold text-gray-800 sm:text-4xl">
Contact Us
</h2>


<p class="mt-4 max-w-2xl mx-auto text-xl text-gray-600">
Reach out to us for any queries or support
</p>
</div>

<div class="mt-16 lg:flex lg:gap-8">
<div class="lg:w-1/3" data-aos="fade-up" data-aos-delay="100">
<div class="bg-white rounded-lg shadow-lg p-6 hover-lift border border-gray-200">
<div class="flex items-center justify-center h-16 w-16 rounded-full bg-accent bg-opacity-10 text-accent mx-auto transform transition-transform duration-500 hover:rotate-12">
<i class="fas fa-map-marker-alt text-2xl"></i>
</div>
<h3 class="mt-6 text-center text-xl font-medium text-gray-800">Our Location</h3>
<p class="mt-2 text-gray-600 text-center">
123 Healthcare Avenue<br>
Medical District<br>
City, ST 12345
</p>
</div>

<div class="bg-white rounded-lg shadow-lg p-6 hover-lift border border-gray-200 mt-8">
<div class="flex items-center justify-center h-16 w-16 rounded-full bg-accent bg-opacity-10 text-accent mx-auto transform transition-transform duration-500 hover:rotate-12">
<i class="fas fa-phone-alt text-2xl"></i>
</div>
<h3 class="mt-6 text-center text-xl font-medium text-gray-800">Phone</h3>
<p class="mt-2 text-gray-600 text-center">
+1 (555) 123-4567<br>
Mon-Fri: 8am - 8pm
</p>
</div>

<div class="bg-white rounded-lg shadow-lg p-6 hover-lift border border-gray-200 mt-8">
<div class="flex items-center justify-center h-16 w-16 rounded-full bg-accent bg-opacity-10 text-accent mx-auto transform transition-transform duration-500 hover:rotate-12">
<i class="fas fa-envelope text-2xl"></i>
</div>
<h3 class="mt-6 text-center text-xl font-medium text-gray-800">Email</h3>
<p class="mt-2 text-gray-600 text-center">
info@healthgate.com<br>
support@healthgate.com
</p>
</div>
</div>

<div class="mt-12 lg:mt-0 lg:w-2/3" data-aos="fade-up" data-aos-delay="200">
<div class="bg-white rounded-lg shadow-lg p-8 border border-gray-200 hover-lift">
<h3 class="text-2xl font-bold text-gray-800 mb-6">Send us a message</h3>
<form>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div class="relative">
<input type="text" id="name" name="name" class="peer w-full border-b-2 border-gray-300 focus:border-accent py-2 px-1 placeholder-transparent transition-all duration-300 focus:outline-none" placeholder="Your Name" required>
<label for="name" class="absolute left-1 -top-5 text-sm text-gray-600 transition-all duration-300 peer-placeholder-shown:top-2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:-top-5 peer-focus:text-sm peer-focus:text-accent">Your Name</label>
</div>
<div class="relative">
<input type="email" id="email" name="email" class="peer w-full border-b-2 border-gray-300 focus:border-accent py-2 px-1 placeholder-transparent transition-all duration-300 focus:outline-none" placeholder="Your Email" required>
<label for="email" class="absolute left-1 -top-5 text-sm text-gray-600 transition-all duration-300 peer-placeholder-shown:top-2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:-top-5 peer-focus:text-sm peer-focus:text-accent">Your Email</label>
</div>
<div class="relative md:col-span-2">
<input type="text" id="subject" name="subject" class="peer w-full border-b-2 border-gray-300 focus:border-accent py-2 px-1 placeholder-transparent transition-all duration-300 focus:outline-none" placeholder="Subject" required>
<label for="subject" class="absolute left-1 -top-5 text-sm text-gray-600 transition-all duration-300 peer-placeholder-shown:top-2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:-top-5 peer-focus:text-sm peer-focus:text-accent">Subject</label>
</div>
<div class="relative md:col-span-2">
<textarea id="message" name="message" rows="4" class="peer w-full border-b-2 border-gray-300 focus:border-accent py-2 px-1 placeholder-transparent transition-all duration-300 focus:outline-none" placeholder="Your Message" required></textarea>
<label for="message" class="absolute left-1 -top-5 text-sm text-gray-600 transition-all duration-300 peer-placeholder-shown:top-2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:-top-5 peer-focus:text-sm peer-focus:text-accent">Your Message</label>
</div>
</div>
<div class="mt-8">
<button type="submit" class="w-full md:w-auto bg-accent hover:bg-darkTeal text-white px-6 py-3 rounded-md transition-all duration-300 btn-hover-effect">
Send Message
<i class="fas fa-paper-plane ml-2"></i>
</button>
</div>
</form>
</div>
</div>
</div>
</div>
</section>

<!-- Footer -->
<footer class="bg-gray-800 text-white">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="py-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
<div>
<div class="flex-shrink-0 flex items-center">
<span class="text-white text-2xl font-bold">Health<span class="text-accent">Gate</span></span>
</div>
<p class="mt-4 text-gray-400">
Your comprehensive healthcare platform designed to make healthcare accessible for everyone.
</p>
<div class="mt-6 flex space-x-4">
<a href="#" class="text-gray-400 hover:text-accent transition-colors duration-300">
<i class="fab fa-facebook-f text-xl"></i>
</a>
<a href="#" class="text-gray-400 hover:text-accent transition-colors duration-300">
<i class="fab fa-twitter text-xl"></i>
</a>
<a href="#" class="text-gray-400 hover:text-accent transition-colors duration-300">
<i class="fab fa-instagram text-xl"></i>
</a>
<a href="#" class="text-gray-400 hover:text-accent transition-colors duration-300">
<i class="fab fa-linkedin-in text-xl"></i>
</a>
</div>
</div>

<div>
<h3 class="text-xl font-semibold mb-4">Quick Links</h3>
<ul class="space-y-2">
<li><a href="#home" class="text-gray-400 hover:text-accent transition-colors duration-300">Home</a></li>
<li><a href="#services" class="text-gray-400 hover:text-accent transition-colors duration-300">Services</a></li>
<li><a href="#doctors" class="text-gray-400 hover:text-accent transition-colors duration-300">Find Doctors</a></li>
<li><a href="#testimonials" class="text-gray-400 hover:text-accent transition-colors duration-300">Testimonials</a></li>
<li><a href="#contact" class="text-gray-400 hover:text-accent transition-colors duration-300">Contact Us</a></li>
</ul>
</div>

<div>
<h3 class="text-xl font-semibold mb-4">Our Services</h3>
<ul class="space-y-2">
<li><a href="#" class="text-gray-400 hover:text-accent transition-colors duration-300">Appointment Booking</a></li>
<li><a href="#" class="text-gray-400 hover:text-accent transition-colors duration-300">Online Consultation</a></li>
<li><a href="#" class="text-gray-400 hover:text-accent transition-colors duration-300">Health Records</a></li>
<li><a href="#" class="text-gray-400 hover:text-accent transition-colors duration-300">Medication Reminders</a></li>
<li><a href="#" class="text-gray-400 hover:text-accent transition-colors duration-300">Health Tips</a></li>
</ul>
</div>

<div>
<h3 class="text-xl font-semibold mb-4">Support</h3>
<ul class="space-y-2">
<li><a href="#" class="text-gray-400 hover:text-accent transition-colors duration-300">FAQ</a></li>
<li><a href="#" class="text-gray-400 hover:text-accent transition-colors duration-300">Privacy Policy</a></li>
<li><a href="#" class="text-gray-400 hover:text-accent transition-colors duration-300">Terms of Service</a></li>
<li><a href="#" class="text-gray-400 hover:text-accent transition-colors duration-300">Help Center</a></li>
</ul>
</div>
</div>

<div class="border-t border-gray-700 py-6">
<p class="text-center text-gray-400">
&copy; {{ date('Y') }} HealthGate. All rights reserved.
</p>
</div>
</div>
</footer>

<!-- Scripts -->
<!-- AOS JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

<script>
// Initialize AOS
AOS.init({
duration: 800,
easing: 'ease-in-out',
once: true,
mirror: false
});

// Mobile Menu Toggle
document.addEventListener('DOMContentLoaded', function() {
const mobileMenuButton = document.getElementById('mobile-menu-button');
const mobileMenu = document.getElementById('mobile-menu');

mobileMenuButton.addEventListener('click', function() {
mobileMenu.classList.toggle('active');
});

// Close mobile menu when clicking on a link
const mobileMenuLinks = mobileMenu.querySelectorAll('a');
mobileMenuLinks.forEach(link => {
link.addEventListener('click', function() {
mobileMenu.classList.remove('active');
});
});

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
anchor.addEventListener('click', function(e) {
e.preventDefault();

const targetId = this.getAttribute('href');
if (targetId === '#') return;

const targetElement = document.querySelector(targetId);
if (targetElement) {
window.scrollTo({
top: targetElement.offsetTop - 80, // Adjust for header height
behavior: 'smooth'
});
}
});
});

// Active navigation highlight based on scroll position
const sections = document.querySelectorAll('section[id]');
const navLinks = document.querySelectorAll('.md\:flex a');

window.addEventListener('scroll', function() {
let current = '';
const scrollPosition = window.scrollY + 100;

sections.forEach(section => {
const sectionTop = section.offsetTop;
const sectionHeight = section.clientHeight;

if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
current = section.getAttribute('id');
}
});

navLinks.forEach(link => {
link.classList.remove('border-accent', 'text-gray-800');
link.classList.add('border-transparent', 'text-gray-600');

if (link.getAttribute('href') === `#${current}`) {
link.classList.remove('border-transparent', 'text-gray-600');
link.classList.add('border-accent', 'text-gray-800');
}
});
});
});
</script>
</body>
</html>
