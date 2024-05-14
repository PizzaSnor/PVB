<x-app-layout>
    <div class="flex flex-col items-center lg:flex-row gap-x-8 mb-0 lg:mb-48 mt-10 px-10 xl:px-60">
        <div class="lg:hidden">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1194.877629903935!2d6.562264057916276!3d53.20430531068849!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c832ae8b38fb37%3A0xf8ed82115525c5de!2sMuntinglaan%203%2C%209727%20JT%20Groningen!5e0!3m2!1snl!2snl!4v1715603218201!5m2!1snl!2snl" width="300" height="300" style="border:1px solid black;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div class="hidden lg:flex">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1194.877629903935!2d6.562264057916276!3d53.20430531068849!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c832ae8b38fb37%3A0xf8ed82115525c5de!2sMuntinglaan%203%2C%209727%20JT%20Groningen!5e0!3m2!1snl!2snl!4v1715603218201!5m2!1snl!2snl" width="450" height="450" style="border:1px solid black;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        <div class="flex flex-col gap-y-4 my-8">
            <h1 class="text-6xl text-center md:text-left font-bold">Hier kan je ons vinden!</h1>
            <p class="text-xl text-center md:text-left font-semibold">{{$contactInfo->main_content}}</p>
            <ul class="text-xl">
                <li><strong>- Adres:</strong> Muntinglaan 3</li>
                <li><strong>- Postcode:</strong> 9727 JT</li>
            </ul>
            <a target="_blank" href="https://www.google.com/maps/dir//Muntinglaan+3,+Groningen/@53.2024394,6.5411964,15z/data=!4m8!4m7!1m0!1m5!1m1!1s0x47c832ae8b38fb37:0xf8ed82115525c5de!2m2!1d6.5622814!2d53.2034332?entry=ttu">
                <x-yellow-button content="Plan een route in!" />
            </a>
        </div>
        <div class="flex flex-col gap-y-4">
            <h2 class="text-4xl font-semibold">Openingstijden</h2>
            <div class="flex gap-x-4">
                <ul class="text-xl">
                    <li><strong>- Maandag:</strong></li>
                    <li><strong>- Dinsdag:</strong></li>
                    <li><strong>- Woensdag:</strong></li>
                    <li><strong>- Donderdag:</strong></li>
                    <li><strong>- Vrijdag:</strong></li>
                    <li><strong>- Zaterdag:</strong></li>
                    <li><strong>- Zondag:</strong></li>
                </ul>
                <ul class="text-xl">
                    @foreach($days as $day)
                        @if(!$day->closed)
                            <li> {{ \Carbon\Carbon::parse($day->opening_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($day->closing_time)->format('H:i') }} </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <x-footer />
</x-app-layout>
