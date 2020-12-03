<x-guest-layout>
    <div class="md:fixed w-full">
        <x-site.menu>
            <x-site.menu-item href="https://themindofnox.com">The Mind of Nox</x-site.menu-item>
            <x-site.menu-item  href="#books">Books</x-site.menu-item>
            <x-site.menu-item  href="#work-in-progress">Work In Progress</x-site.menu-item>
            <x-site.menu-item  href="#contact">Contact</x-site.menu-item>
            <x-site.menu-item  href="#about">About AJ</x-site.menu-item>
        </x-site.menu>
    </div>
    <x-site.section :image="asset('images/stories.jpg')" name="top">
        <div class="py-9">
            <img
                src="{{ asset('images/logo.png') }}"
                alt="AJ Hunter"
                class="md:pt-32 mx-auto"
            />
        </div>
    </x-site.section>
    <x-site.section :image="asset('images/the-mind-of-nox-bg.jpg')" name="about">
        <div class="px-9 pt-32">
            <div class="md:w-1/2 bg-orange-900 text-orange-100 bg-opacity-25 p-5 rounded">
                <h1>About AJ</h1>
                <p>AJ Hunter writes predominately urban fantasy but ventures into romance and medieval fantasy at times. AJ resides in the deep south of the US but is still a Yankee by any standards. AJ is married to her online sweetheart of more than 20 years.  They have two lovely daughters together, and AJ's step son has two of his own children whom they love dearly but get to send home.</p>
            </div>
        </div>
    </x-site.section>
    <x-site.section :image="asset('images/contact.jpg')" name="contact">
        <div class="px-9 pt-32">
            <div class="md:w-1/2 bg-orange-900 text-orange-100 bg-opacity-25 p-5 rounded">
                <h1>Contact AJ</h1>
                <div class="text-center text-2xl w-full">
                    <a href="https://www.facebook.com/ajs.voices">
                        <i class="fab fa-facebook-square fa-fw"></i>
                    </a>
                    <a href="https://twitter.com/AJs_Voices">
                        <i class="fab fa-twitter-square fa-fw"></i>
                    </a>
                    <a href="mailto://ajs.voices@gmail.com">
                        <i class="fas fa-envelope-square fa-fw"></i>
                    </a>
                </div>
                <hr class="border-orange-100 my-5"/>
                <h1>Contact Nox</h1>
                <div class="text-center text-2xl w-full">
                    <a href="https://www.facebook.com/nox.setanta">
                        <i class="fab fa-facebook-square fa-fw"></i>
                    </a>
                    <a href="https://twitter.com/NoxSetanta">
                        <i class="fab fa-twitter-square fa-fw"></i>
                    </a>
                    <a href="https://discord.gg/Z4m5DYW">
                        <i class="fab fa-discord fa-fw"></i>
                    </a>
                    <a href="https://themindofnox.com">
                        <i class="fab fa-wordpress-simple fa-fw"></i>
                    </a>
                    <a href="mailto://nox.durante@gmail.com">
                        <i class="fas fa-envelope-square fa-fw"></i>
                    </a>
                </div>
            </div>
        </div>
    </x-site.section>
    <x-site.section :image="asset('images/books.jpg')" name="books">
        <div class="px-9 pt-32">
            <div class="md:w-1/2 bg-orange-900 text-orange-100 bg-opacity-50 p-5 rounded">
                <h1>Books</h1>
                <h2>Coming Soon!</h2>
            </div>
        </div>
    </x-site.section>
    <x-site.section :image="asset('images/wip.jpg')" name="work-in-progress">
        <div class="px-9 pt-32">
            <div class="md:w-1/2 bg-orange-900 text-orange-100 bg-opacity-25 p-5 rounded">
                <h1>Work In Progress</h1>
                <x-carousel :slides="json_encode($goals->keys())">
                    @foreach($goals as $key => $goal)
                        <x-slide :slide="$key">
                            <x-goal :goal="$goal"></x-goal>
                        </x-slide>
                    @endforeach
                </x-carousel>

            </div>
        </div>
    </x-site.section>

</x-guest-layout>
