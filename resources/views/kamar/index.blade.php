@extends('layouts.app')

@section('page_title', 'Daftar Kamar')
<x-hero-section 
    title="Find Your Perfect Sanctuary"
    subtitle="Luxury Accommodation"
    description="Explore our wide range of rooms and suites designed for your ultimate comfort and relaxation."
    image="https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
    ctaText="Scroll Down to Explore"
    ctaLink="#room-filter"
    splitPercent="55"
    angle="110"
/>
@section('content')
<div id="room-filter" class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8 text-center">Temukan Kamar Impian Anda</h1>
    
    <livewire:room-filter />
</div>
