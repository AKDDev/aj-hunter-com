<div class="flex flex-col justify-center items-center">

    <div
        class="max-w-4xl mx-auto relative"
        x-data="{ activeSlide: 0, slides: {{ $slides  }} }"
    >
        <!-- Slides -->
        {!! $slot !!}

        <!-- Prev/Next Arrows -->
        <div class="absolute inset-0 flex">
            <div class="flex items-center justify-start w-1/2">
                <button
                    class="bg-orange-100 text-orange-500 hover:text-orange-900 font-bold hover:shadow-lg rounded-full w-12 h-12 -ml-6"
                    x-on:click="activeSlide = activeSlide === 0 ? slides.length - 1 : activeSlide">
                    &#8592;
                </button>
            </div>
            <div class="flex items-center justify-end w-1/2">
                <button
                    class="bg-orange-100 text-orange-500 hover:text-orange-900 font-bold hover:shadow rounded-full w-12 h-12 -mr-6"
                    x-on:click="activeSlide = activeSlide === slides.length - 1 ? 0 : activeSlide">
                    &#8594;
                </button>
            </div>
        </div>

        <!-- Buttons -->
        <div class="absolute w-full flex items-center justify-center px-4">
            <template x-for="slide in slides" :key="slide">
                <button
                    class="flex-1 w-4 h-2 mt-4 mx-2 mb-0 rounded-full overflow-hidden transition-colors duration-200 ease-out hover:bg-teal-600 hover:shadow-lg"
                    :class="{
              'bg-orange-600': activeSlide === slide,
              'bg-teal-300': activeSlide !== slide
          }"
                    x-on:click="activeSlide = slide"
                ></button>
            </template>
        </div>
    </div>

</div>
</div>
