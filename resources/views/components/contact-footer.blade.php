<footer class="flex flex-col gap-y-4 justify-center bg-black mt-10 p-6">
    <h1 class="text-white font-bold text-4xl">Nog niet tevreden?</h1>
    <p class="text-white font-semibold text-2xl md:w-2/5">Hier kan je ons ook bereiken!</p>
    <ul class="text-white text-2xl">
        <li><strong>Telefoon: </strong>{{ $contactInfo->contact_number }}</li>
        <li><strong>Email: </strong>{{ $contactInfo->contact_email }}</li>
    </ul>
</footer>
