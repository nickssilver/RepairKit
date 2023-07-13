<!DOCTYPE html>
<html lang="{{ config('app.locale', 'en') }}">
@include('frontend.partials.head')
<body>
    <div id="">
        <header class="w-full text-white bg-purple-500 shadow-sm body-font">
      <div
        class="
          container
          flex flex-col
          items-start
          justify-between
          p-6
          mx-auto
          md:flex-row
        "
      >
        <a
          class="
            flex
            items-center
            mb-4
            font-medium
            text-white
            title-font
            md:mb-0
          "
          href="/"
        >
          <strong>
             {{$app_data['name']}}
          </strong>
        </a>
        <div class="items-center h-full">
          <a class="mr-5 font-medium" href="/book-repair-widget-2">
            <sub>{{ __('Booking w2') }}</sub>
           <sup class="text-yellow-400">new</sup>
          </a>
           <a class="mr-5 font-medium" href="/book-repair">
            {{ __('Booking') }}
          </a>
          <a class="mr-5 font-medium" href="/track">
            {{ __('Track') }}
          </a>
          <a class="font-medium" href="/workshop/welcome">
            {{ __('Workshop') }}
          </a>
        </div>
      </div>
    </header>
        @yield('content')
         <section class="text-gray-700 bg-white">
      <div class="container px-5 py-15 mx-auto">
        <div class="mb-20 text-center">
          <h1
            class="
              mb-1
              text-2xl
              font-bold
              text-center text-gray-800
              sm:text-3xl
              title-font
            "
          >
            {{ __('Frequently Asked Questions') }}
          </h1>
          <p class="mx-auto text-base leading-relaxed xl:w-2/4 lg:w-3/4">
            {{ __('The most common questions about how our works') }}.
          </p>
        </div>
        <div class="flex flex-wrap -mx-2 lg:w-4/5 sm:mx-auto sm:mb-2">
          <div
            class="w-full px-4 py-2"
          >
          @foreach($app_data['faqs'] as $faq)
            <details class="mb-4 bg-gray-100">
              <summary
                class="
                  px-4
                  py-2
                  font-semibold
                  bg-gray-300
                  rounded-md
                  cursor-pointer
                "
              >
                {{$faq->question}}
              </summary>
              <p class="px-4 py-2">
                {{$faq->answer}}
              </p>
            </details>
          @endforeach
          </div>
        </div>
      </div>
    </section>
    <section>
      <div class="py-10 bg-gray-50 radius-for-skewed">
        <div class="container mx-auto px-4">
          <div class="flex flex-wrap items-center">
            <div class="w-full lg:w-1/2 mb-12 lg:mb-0">
              <div class="max-w-md lg:mx-auto">
                <h2 class="my-2 text-4xl lg:text-5xl font-bold font-heading">
                  {{ __('Services we love to provide') }}
                </h2>
                <p class="mb-6 text-gray-500 leading-loose">
                  {{__('we have been into the business and our clients cherish us for the promising that we convey them')}}
                </p>
                <ul class="text-gray-500 font-bold">
                  <li class="flex mb-4">
                    <svg-vue
                      class="mr-2 w-4 h-4 text-green-400"
                      icon="font-awesome.check-circle-solid"
                    >
                    </svg-vue>
                    <span>
                      {{ __('We take care your data privacy') }}
                    </span>
                  </li>
                  <li class="flex mb-4">
                    <svg-vue
                      class="mr-2 w-4 h-4 text-green-400"
                      icon="font-awesome.check-circle-solid"
                    >
                    </svg-vue>
                    <span>
                      {{ __('We provide professional solutions') }}
                    </span>
                  </li>
                  <li class="flex mb-4">
                    <svg-vue
                      class="mr-2 w-4 h-4 text-green-400"
                      icon="font-awesome.check-circle-solid"
                    >
                    </svg-vue>
                    <span>
                      {{ __('Expert and qualified technician') }}
                    </span>
                  </li>
                  <li class="flex mb-4">
                    <svg-vue
                      class="mr-2 w-4 h-4 text-green-400"
                      icon="font-awesome.check-circle-solid"
                    >
                    </svg-vue>
                    <span>
                      {{ __('Professional repairing labs') }}
                    </span>
                  </li>
                  <li class="flex mb-4">
                    <svg-vue
                      class="mr-2 w-4 h-4 text-green-400"
                      icon="font-awesome.check-circle-solid"
                    >
                    </svg-vue>
                    <span>
                      {{ __('Trusted and reliable repairing') }}
                    </span>
                  </li>
                  <li class="flex mb-4">
                    <svg-vue
                      class="mr-2 w-4 h-4 text-green-400"
                      icon="font-awesome.check-circle-solid"
                    >
                    </svg-vue>
                    <span>
                      {{ __('Best quality hardware parts for replace') }}
                    </span>
                  </li>
                </ul>
              </div>
            </div>
            <div class="w-full lg:w-1/2 flex flex-wrap -mx-4">
              <div class="mb-8 lg:mb-0 w-full md:w-1/2 px-4">
                <div class="mb-8 py-6 pl-6 pr-4 shadow rounded bg-white">
                  <span
                    class="
                      mb-4
                      inline-block
                      p-3
                      rounded
                      bg-purple-300
                      text-white
                    "
                  >
                    <svg-vue class="w-10 h-10" icon="font-awesome.tags-solid">
                    </svg-vue>
                  </span>
                  <h4 class="mb-2 text-2xl font-bold font-heading">
                    {{ __('Excellent services') }}
                  </h4>
                  <p class="text-gray-500 leading-loose">
                    {{__('We promise to provide excellent repair services with multiple bands and the devices')}}
                  </p>
                </div>
                <div class="py-6 pl-6 pr-4 shadow rounded bg-white">
                  <span
                    class="
                      mb-4
                      inline-block
                      p-3
                      rounded
                      bg-purple-300
                      text-white
                    "
                  >
                    <svg-vue class="w-10 h-10" icon="font-awesome.tags-solid">
                    </svg-vue>
                  </span>
                  <h4 class="mb-2 text-2xl font-bold font-heading">
                    {{ __('Expert technical team') }}
                  </h4>
                  <p class="text-gray-500 leading-loose">
                    {{__('We have well trained and professional experts with relevant experience to fix your devices issues')}}
                  </p>
                </div>
              </div>
              <div class="w-full md:w-1/2 lg:mt-20 px-4">
                <div class="mb-8 py-6 pl-6 pr-4 shadow rounded-lg bg-white">
                  <span
                    class="
                      mb-4
                      inline-block
                      p-3
                      rounded
                      bg-purple-300
                      text-white
                    "
                  >
                    <svg-vue class="w-10 h-10" icon="font-awesome.tags-solid">
                    </svg-vue>
                  </span>
                  <h4 class="mb-2 text-2xl font-bold font-heading">
                    {{ __('Track repair status') }}
                  </h4>
                  <p class="text-gray-500 leading-loose">
                    {{__('Track your device repairing status with complete details at any time and from any place or even from your home')}}
                  </p>
                </div>
                <div class="py-6 pl-6 pr-4 shadow rounded-lg bg-white">
                  <span
                    class="
                      mb-4
                      inline-block
                      p-3
                      rounded
                      bg-purple-300
                      text-white
                    "
                  >
                    <svg-vue class="w-10 h-10" icon="font-awesome.tags-solid">
                    </svg-vue>
                  </span>
                  <h4 class="mb-2 text-2xl font-bold font-heading">
                    {{ __('Notifications') }}
                  </h4>
                  <p class="text-gray-500 leading-loose">
                    {{__('When does a technician update repair status the customer will be notified by email.')}}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div class="px-8 py-16">
       <iframe src="{{url('repair-contact-us-embed?lhgtxtecdlygdbkwzwkvpdfuqmghridk')}}" name="iframe_contact_us" style="border: none; height:600px; width:100%;" title="Contact us form embed code"></iframe>
    </div>
    <footer class="bg-gray-900 pt-8 pb-6 text-white">
      <div class="container mx-auto">
        <div class="flex flex-wrap">
          <div class="w-full lg:w-6/12 px-4">
            <h4 class="text-3xl font-semibold">
              {{$app_data['name']}}
            </h4>
            <h5 class="text-lg mt-0 mb-2">
                {{$app_data['address']}}
            </h5>
            <div class="mt-6 text-xl" v-if="$store.state.settings.phone">
              {{ __('Got Question? Call us 24/7') }}
              <br />
                {{$app_data['phone']}}
              <br />
            </div>
          </div>
          <div class="w-full lg:w-6/12 px-4">
            <div class="flex flex-wrap items-top mb-6">
              <div class="w-full lg:w-4/12 px-4 ml-auto">
                <span class="block uppercase text-sm font-semibold mb-2">
                  {{ __('Useful Links') }}
                </span>
                <ul class="list-unstyled">
                  @foreach($app_data['pages'] as $page)
                  <li>
                    <a
                      href="/custom-page?read={{$page->slug}}"
                      class="font-semibold block pb-2 text-sm"
                    >
                     {{$page->title}}
                    </a>
                  </li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
        </div>
        <hr class="my-6 border" />
        <div
          class="flex flex-wrap items-center md:justify-between justify-center"
        >
          <div class="w-full md:w-4/12 px-4 mx-auto text-center">
            <a
              class="text-sm font-semibold py-1"
              href="https://codecanyon.net/user/rose-finch/portfolio"
              rel="noopener"
              target="_blank"
            >
              Copyright © {{ date('Y') }} {{config('app.name')}}
            </a>
          </div>
        </div>
      </div>
    </footer>
    </div>
    </body>
</html>
