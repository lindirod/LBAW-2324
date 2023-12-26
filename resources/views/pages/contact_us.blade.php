@extends('layouts.app')

@section('content')

<div class="contacts-container">
   <section>
        <h2>Contact us!</h2>
        <h3>We're happy to answer any questions you have or provide you an estimate. 
        <br>Just send us a message in the form below with any questions you may have. </h3> 
    </section>

    <h3>Please provide the following informations so we can receive your message!</h3> 
    <main class="conts_row"> 
        <form id="forms" method="POST" action="{{ url('/contact-us') }}">
        @csrf
            <label for="supp_name">Name (required)</label><br>
            <input type="text" id="supp_name" name="supp_name" required autofocus><br>
            <br>
            <label for="supp_subject">Subject (required)</label><br>
            <input type="text" id="supp_subject" name="supp_subject" required autofocus><br>
            <br>
            <label for="supp_email">Email (required)</label><br>
            <input type="email" id="supp_email" name="supp_email" required><br><br>
            <br>
            <label for="supp_content">Enter your message (required)</label><br><br>
            <textarea id = "supp_content" name = "supp_content" required></textarea>
            <br>
            <br>
            <button type="submit" id="buttonContacts">Submit</button>
            <p id="my-form-status"></p>
        </form>
    
        <div class="informations">  
            <h3> <i class="fa-regular fa-at"></i>  Email</h3>
            <p>info@proplanner.com</p>
            <br>
            <h3> <i class="fas fa-phone"></i> Phone number</h3>
            <p>+315 180 180 360</p>
        </div>
    </main>
</div>
@endsection