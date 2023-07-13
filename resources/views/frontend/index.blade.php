@extends('frontend.layout.front')
@section('content')
 <div>
    <div
      class="relative flex flex-col items-center justify-center pt-5 bg-white"
    >
      <div
        class="
          flex flex-col
          items-center
          justify-center
          p-5
          mx-auto
          lg:flex-row
          lg:max-w-6xl
          lg:p-0
        "
      >
        <div
          class="
            container
            relative
            z-20
            flex flex-col
            w-full
            px-5
            pb-1
            pr-12
            mb-16
            text-2xl text-gray-700
            lg:w-1/2
            sm:px-0
            md:px-10
            sm:items-center
            lg:items-start
            lg:mb-0
          "
        >
          <h1
            class="
              relative
              z-20
              text-5xl
              font-extrabold
              leading-none
              text-purple-500
              xl:text-6xl
              sm:text-center
              lg:text-left
            "
          >
            {{ __('Welcome!') }}
            <div class="md:hidden lg:block">
              <span class="text-gray-800">
                {{$app_data['name']}}
              </span>
            </div>
          </h1>
          <p
            class="
              relative
              z-20
              block
              mt-6
              text-base text-gray-500
              xl:text-xl
              sm:text-center
              lg:text-left
            "
          >
            {{$app_data['portal_about']}}
          </p>
          <div class="relative flex mt-4">
            <a
              href="/book-repair"
              class="
                flex
                items-center
                self-start
                justify-center
                px-5
                py-3
                mt-5
                text-base
                font-medium
                leading-tight
                text-white
                transition
                duration-150
                ease-in-out
                bg-purple-500
                border border-transparent
                rounded-full
                shadow
                hover:bg-purple-600
                focus:outline-none
                focus:border-purple-600
                focus:shadow-outline-purple
                md:py-4
                md:text-lg
                xl:text-xl
                md:px-10
              "
            >
              {{ __('Lets book') }}
            </a>
          </div>
        </div>
        <div
          class="
            relative
            w-full
            px-5
            rounded-lg
            cursor-pointer
            md:w-2/3
            lg:w-1/2
            group
            xl:px-0
          "
        >
          <div class="relative overflow-hidden md:p-5">
            <img
              class="z-10 object-cover w-full h-full"
              src="/images/default/maintenance.svg"
            />
          </div>
        </div>
      </div>
    </div>
    <div class="flex items-center justify-center p-5 bg-white">
      <div
        class="
          relative
          flex flex-col
          items-center
          w-full
          px-4
          py-8
          mx-auto
          text-center
          rounded-lg
          shadow-2xl
          lg:text-left
          lg:block
          bg-gradient-to-br
          from-purple-600
          via-indigo-500
          to-teal-400
          sm:px-6
          md:pb-0
          md:pt-12
          lg:px-12
          lg:py-12
        "
      >
        <h2
          class="
            my-4
            text-3xl
            font-extrabold
            tracking-tight
            text-white
            sm:text-4xl
            md:text-5xl
            lg:my-0
            xl:text-4xl
            sm:leading-tight
          "
        >
          {{ __('Track your repair current status and progress') }}
        </h2>
        <p
          class="
            mt-1
            mb-10
            text-sm
            font-medium
            text-indigo-200
            uppercase
            xl:text-base
            xl:tracking-wider
            lg:mb-0
          "
        >
          {{ __('by entering your repair order identity code') }}
        </p>
        <div class="flex mb-8 lg:mt-6 lg:mb-0">
          <div class="inline-flex">
            <a
              href="/track"
              class="
                inline-flex
                items-center
                justify-center
                px-5
                py-3
                text-base
                font-medium
                text-indigo-700
                transition
                duration-150
                ease-in-out
                bg-indigo-100
                border border-transparent
                rounded-md
                hover:text-indigo-600
                hover:bg-indigo-50
                focus:outline-none
                focus:shadow-outline
                focus:border-indigo-300
              "
            >
              {{ __('Track') }}
            </a>
          </div>
        </div>
        <div class="bottom-0 right-0 mb-0 mr-3 lg:absolute lg:-mb-12">
          <img
            class="
              max-w-xs
              mb-4
              opacity-75
              md:max-w-2xl
              lg:max-w-lg
              xl:mb-0
              xl:max-w-md
            "
            src="/images/default/cta-1.png"
          />
        </div>
      </div>
    </div>
    <section class="py-10 px-4 text-center">
      <h2 class="text-4xl mb-12 font-semibold font-heading">
        {{ __('How to submit repair order') }}
      </h2>
      <div class="flex flex-wrap items-center justify-center mb-12">
        <div class="lg:w-1/3 px-8 mb-8 lg:mb-0">
          <span
            class="
              flex
              w-16
              h-16
              mx-auto
              items-center
              justify-center
              text-2xl
              font-bold font-heading
              rounded-full
              bg-blue-100
              text-blue-600
            "
          >
            1
          </span>
          <h3 class="text-2xl mt-6 mb-3 font-semibold font-heading">
            {{ __('Select device and defect') }}
          </h3>
          <p class="text-gray-600 leading-relaxed">
            {{__('Select brand and device list will be appear,select available defects under selected device')}}
          </p>
        </div>
        <div class="lg:w-1/3 px-8 mb-8 lg:mb-0">
          <span
            class="
              flex
              w-16
              h-16
              mx-auto
              items-center
              justify-center
              text-2xl
              font-bold font-heading
              rounded-full
              bg-blue-100
              text-blue-600
            "
          >
            2
          </span>
          <h3 class="text-2xl mt-6 mb-3 font-semibold font-heading">
            {{ __('Select repair priority level') }}
          </h3>
          <p class="text-gray-600 leading-relaxed">
            {{__('Repair priority level is just repairing preference level select your desire level.')}}
          </p>
        </div>
        <div class="lg:w-1/3 px-8 mb-8 lg:mb-0">
          <span
            class="
              flex
              w-16
              h-16
              mx-auto
              items-center
              justify-center
              text-2xl
              font-bold font-heading
              rounded-full
              bg-blue-100
              text-blue-600
            "
          >
            3
          </span>
          <h3 class="text-2xl mt-6 mb-3 font-semibold font-heading">
            {{ __('Fill information & payment') }}
          </h3>
          <p class="text-gray-600 leading-relaxed">
            {{__('Fill up your valid information to get in touch in various cases and make payment.')}}
          </p>
        </div>
      </div>
      <div>
        <a
         href="/book-repair"
          class="
            inline-block
            py-4
            px-8
            leading-none
            text-white
            bg-indigo-600
            hover:bg-indigo-700
            font-semibold
            rounded
            shadow
          "
        >
          {{ __('Lets book') }}
        </a>
      </div>
    </section>
  </div>
@endsection
