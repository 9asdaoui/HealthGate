<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthGate - Your Health Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#121212', // Almost black
                        secondary: '#1E1E1E', // Dark gray
                        accent: '#FF5722', // Orange
                        darkOrange: '#BF360C', // Dark Orange
                        charcoal: '#2D2D2D' // Charcoal Gray
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-900 text-gray-200">
    <!-- Navigation -->
    <nav class="bg-primary shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <span class="text-gray-200 text-2xl font-bold">Health<span class="text-accent">Gate</span></span>
                    </div>
                    <div class="hidden md:ml-6 md:flex md:space-x-8">
                        <a href="#home" class="border-accent text-white inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Home
                        </a>
                        <a href="#services" class="border-transparent text-gray-400 hover:border-gray-500 hover:text-gray-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Services
                        </a>
                        <a href="#doctors" class="border-transparent text-gray-400 hover:border-gray-500 hover:text-gray-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Find Doctors
                        </a>
                        <a href="#testimonials" class="border-transparent text-gray-400 hover:border-gray-500 hover:text-gray-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Testimonials
                        </a>
                        <a href="#contact" class="border-transparent text-gray-400 hover:border-gray-500 hover:text-gray-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Contact
                        </a>
                    </div>
                </div>
                <div class="hidden md:flex md:items-center md:space-x-4">
                    <a href="#" class="text-gray-400 hover:text-accent px-3 py-2 rounded-md text-sm font-medium">Login</a>
                    <a href="#" class="bg-accent hover:bg-darkOrange text-white px-4 py-2 rounded-md text-sm font-medium">Register</a>
                </div>
                <div class="-mr-2 flex items-center md:hidden">
                    <button type="button" class="bg-primary inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-200 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-accent" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="relative bg-gradient-to-r from-primary to-charcoal py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:flex lg:items-center lg:justify-between">
                <div class="lg:w-1/2">
                    <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl md:text-6xl">
                        Your Health, Our Priority
                    </h1>
                    <p class="mt-3 max-w-md mx-auto text-lg text-gray-300 sm:text-xl md:mt-5 md:max-w-3xl">
                        Access quality healthcare services, book appointments with specialist doctors, and manage your health records all in one place.
                    </p>
                    <div class="mt-4 sm:flex">
                        <div class="rounded-md shadow">
                            <a href="#services" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-accent hover:bg-darkOrange md:py-4 md:text-lg md:px-10">
                                Book Appointment
                            </a>
                        </div>
                        <div class="mt-3 sm:mt-0 sm:ml-3">
                            <a href="#services" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-gray-300 bg-secondary bg-opacity-80 hover:bg-opacity-100 md:py-4 md:text-lg md:px-10">
                                Learn More
                            </a>
                        </div>
                    </div>
                </div>
                <div class="mt-12 lg:mt-0 lg:w-1/2 flex justify-center">
                    <img class="h-96 w-auto" src="https://cdn.pixabay.com/photo/2017/01/31/22/32/doctor-2027768_1280.png" alt="Healthcare Professional">
                </div>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0">
            <div class="mt-16"></div><!-- Added spacing before the wave -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full h-auto">
            <path fill="#111111" fill-opacity="1" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,202.7C672,203,768,181,864,181.3C960,181,1056,203,1152,208C1248,213,1344,203,1392,197.3L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-16 bg-primary">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    Our Services
                </h2>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-400">
                    Comprehensive healthcare solutions for you and your family
                </p>
            </div>

            <div class="mt-16 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                <!-- Service 1 -->
                <div class="bg-secondary rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 border border-gray-800">
                    <div class="p-6">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-gray-800 text-accent mx-auto">
                            <i class="fas fa-calendar-check text-2xl"></i>
                        </div>
                        <h3 class="mt-6 text-center text-xl font-medium text-white">Online Booking</h3>
                        <p class="mt-4 text-gray-400 text-center">
                            Book appointments with your preferred doctors online without waiting in queues.
                        </p>
                        <div class="mt-6 text-center">
                            <a href="#" class="inline-flex items-center text-accent hover:text-white">
                                Book Now
                                <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Service 2 -->
                <div class="bg-secondary rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 border border-gray-800">
                    <div class="p-6">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-gray-800 text-accent mx-auto">
                            <i class="fas fa-user-md text-2xl"></i>
                        </div>
                        <h3 class="mt-6 text-center text-xl font-medium text-white">Find Specialists</h3>
                        <p class="mt-4 text-gray-400 text-center">
                            Find and connect with specialized doctors based on your health needs.
                        </p>
                        <div class="mt-6 text-center">
                            <a href="#doctors" class="inline-flex items-center text-accent hover:text-white">
                                Find Doctors
                                <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Service 3 -->
                <div class="bg-secondary rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 border border-gray-800">
                    <div class="p-6">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-gray-800 text-accent mx-auto">
                            <i class="fas fa-file-medical text-2xl"></i>
                        </div>
                        <h3 class="mt-6 text-center text-xl font-medium text-white">Health Records</h3>
                        <p class="mt-4 text-gray-400 text-center">
                            Access your medical records, prescriptions, and test results anytime, anywhere.
                        </p>
                        <div class="mt-6 text-center">
                            <a href="#" class="inline-flex items-center text-accent hover:text-white">
                                View Records
                                <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    Our Featured Doctors
                </h2>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-400">
                    Experienced specialists committed to providing quality healthcare
                </p>
            </div>

            <div class="mt-16 grid gap-8 md:grid-cols-2 lg:grid-cols-4">
                <!-- Doctor Cards -->
                <div class="bg-primary rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-800">
                    <img class="h-64 w-full object-cover object-center" src="https://randomuser.me/api/portraits/men/32.jpg" alt="Doctor">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-white">Dr. John Smith</h3>
                        <p class="text-sm text-accent font-medium">Cardiologist</p>
                        <div class="flex mt-2 text-yellow-500">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <span class="ml-1 text-gray-400">4.8</span>
                        </div>
                        <p class="mt-3 text-gray-400 text-sm">
                            Specializes in heart diseases with over 15 years of experience.
                        </p>
                        <div class="mt-4">
                            <a href="#" class="block w-full bg-accent hover:bg-darkOrange text-white text-center py-2 rounded-md">Book Appointment</a>
                        </div>
                    </div>
                </div>

                <div class="bg-primary rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-800">
                    <img class="h-64 w-full object-cover object-center" src="https://randomuser.me/api/portraits/women/32.jpg" alt="Doctor">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-white">Dr. Sarah Johnson</h3>
                        <p class="text-sm text-accent font-medium">Neurologist</p>
                        <div class="flex mt-2 text-yellow-500">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span class="ml-1 text-gray-400">5.0</span>
                        </div>
                        <p class="mt-3 text-gray-400 text-sm">
                            Expert in brain disorders and nervous system conditions.
                        </p>
                        <div class="mt-4">
                            <a href="#" class="block w-full bg-accent hover:bg-darkOrange text-white text-center py-2 rounded-md">Book Appointment</a>
                        </div>
                    </div>
                </div>

                <div class="bg-primary rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-800">
                    <img class="h-64 w-full object-cover object-center" src="https://randomuser.me/api/portraits/men/44.jpg" alt="Doctor">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-white">Dr. David Lee</h3>
                        <p class="text-sm text-accent font-medium">Pediatrician</p>
                        <div class="flex mt-2 text-yellow-500">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                            <span class="ml-1 text-gray-400">4.1</span>
                        </div>
                        <p class="mt-3 text-gray-400 text-sm">
                            Specializes in child healthcare with a gentle approach.
                        </p>
                        <div class="mt-4">
                            <a href="#" class="block w-full bg-accent hover:bg-darkOrange text-white text-center py-2 rounded-md">Book Appointment</a>
                        </div>
                    </div>
                </div>

                <div class="bg-primary rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-800">
                    <img class="h-64 w-full object-cover object-center" src="https://randomuser.me/api/portraits/women/44.jpg" alt="Doctor">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-white">Dr. Emily Wilson</h3>
                        <p class="text-sm text-accent font-medium">Dermatologist</p>
                        <div class="flex mt-2 text-yellow-500">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <span class="ml-1 text-gray-400">4.7</span>
                        </div>
                        <p class="mt-3 text-gray-400 text-sm">
                            Expert in skin conditions and cosmetic dermatology.
                        </p>
                        <div class="mt-4">
                            <a href="#" class="block w-full bg-accent hover:bg-darkOrange text-white text-center py-2 rounded-md">Book Appointment</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section id="testimonials" class="py-16 bg-primary">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    What Our Patients Say
                </h2>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-400">
                    Testimonials from people who have used our platform
                </p>
            </div>

            <div class="mt-16 grid gap-8 md:grid-cols-3">
                <!-- Testimonials -->
                <div class="bg-secondary rounded-lg p-6 shadow-md hover:shadow-lg transition-shadow duration-300 border border-gray-800">
                    <div class="flex items-center mb-4">
                        <img class="h-12 w-12 rounded-full" src="https://randomuser.me/api/portraits/women/21.jpg" alt="Patient">
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-white">Lisa Thompson</h4>
                            <div class="flex text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-300 italic">
                        "HealthGate made it so easy to find a specialist and book an appointment. The entire process was smooth and I received great care!"
                    </p>
                </div>

                <div class="bg-secondary rounded-lg p-6 shadow-md hover:shadow-lg transition-shadow duration-300 border border-gray-800">
                    <div class="flex items-center mb-4">
                        <img class="h-12 w-12 rounded-full" src="https://randomuser.me/api/portraits/men/67.jpg" alt="Patient">
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-white">Robert Brown</h4>
                            <div class="flex text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-300 italic">
                        "Having my health records available digitally has been a game-changer. I can access my test results instantly and share with my doctors."
                    </p>
                </div>

                <div class="bg-secondary rounded-lg p-6 shadow-md hover:shadow-lg transition-shadow duration-300 border border-gray-800">
                    <div class="flex items-center mb-4">
                        <img class="h-12 w-12 rounded-full" src="https://randomuser.me/api/portraits/women/54.jpg" alt="Patient">
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-white">Jennifer Martinez</h4>
                            <div class="flex text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-300 italic">
                        "The reminders for appointments and medications have helped me stay on top of my health. The doctors on the platform are excellent!"
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-charcoal">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                <span class="block">Ready to take control of your health?</span>
                <span class="block text-accent">Register today and get started.</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-md shadow">
                    <a href="#" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-charcoal bg-accent hover:bg-darkOrange hover:text-white">
                        Register Now
                    </a>
                </div>
                <div class="ml-3 inline-flex rounded-md shadow">
                    <a href="#services" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-secondary hover:bg-opacity-90">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-black">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
            <div class="xl:grid xl:grid-cols-4 xl:gap-8">
                <div class="xl:col-span-1">
                    <span class="text-white text-2xl font-bold">Health<span class="text-accent">Gate</span></span>
                    <p class="mt-4 text-sm text-gray-400">
                        Your comprehensive healthcare platform for all your medical needs.
                    </p>
                    <div class="mt-8 flex space-x-6">
                        <a href="#" class="text-gray-500 hover:text-accent">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-accent">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-accent">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-accent">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
                <div class="mt-12 grid grid-cols-3 gap-8 xl:mt-0 xl:col-span-3">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-300 tracking-wider uppercase">Services</h3>
                        <ul class="mt-4 space-y-4">
                            <li><a href="#services" class="text-base text-gray-500 hover:text-accent">Online Booking</a></li>
                            <li><a href="#doctors" class="text-base text-gray-500 hover:text-accent">Find Doctors</a></li>
                            <li><a href="#" class="text-base text-gray-500 hover:text-accent">Health Records</a></li>
                            <li><a href="#" class="text-base text-gray-500 hover:text-accent">Medication Reminders</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-300 tracking-wider uppercase">Company</h3>
                        <ul class="mt-4 space-y-4">
                            <li><a href="#" class="text-base text-gray-500 hover:text-accent">About</a></li>
                            <li><a href="#" class="text-base text-gray-500 hover:text-accent">Blog</a></li>
                            <li><a href="#" class="text-base text-gray-500 hover:text-accent">Careers</a></li>
                            <li><a href="#" class="text-base text-gray-500 hover:text-accent">Press</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-300 tracking-wider uppercase">Legal</h3>
                        <ul class="mt-4 space-y-4">
                            <li><a href="#" class="text-base text-gray-500 hover:text-accent">Privacy Policy</a></li>
                            <li><a href="#" class="text-base text-gray-500 hover:text-accent">Terms of Service</a></li>
                            <li><a href="#" class="text-base text-gray-500 hover:text-accent">Cookie Policy</a></li>
                            <li><a href="#contact" class="text-base text-gray-500 hover:text-accent">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="mt-12 border-t border-gray-800 pt-8">
                <p class="text-base text-gray-400 text-center">
                    © 2023 HealthGate. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- Smooth scroll script -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>