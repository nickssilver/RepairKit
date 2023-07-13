@php
$links = [
  [
    'url'=> url('/admin/dashboard'),
    'title' =>'Click to RepairBox\'s  Admin Area'
  ],
   [
    'url'=> url('/workshop'),
    'title' =>'Click to RepairBox\'s  workshop Area'
  ],
   [
    'url'=> url('/'),
    'title' =>'View Ready made portfolio'
  ],
   [
    'url'=> url('https://pronic.co.ke/'),
    'title' =>'Read RepairBox\'s  Documentation'
  ],
];

$faqs=[
  [
    'question' => 'if you have already a website or webpage or even made in WordPress for your business, how can use the repair box?',
    'answer' => 'Yes, it can be used go to : <a class="text-blue-400" href="https://pronic.co.ke/faq#i-have-already-a-website-how-can-use-the-repair-box">https://pronic.co.ke/faq#i-have-already-a-website-how-can-use-the-repair-box</a>'
  ],
  [
    'question' => 'What is Workflow of repair box?',
     'answer' => 'Yes, it can be used go to : <a class="text-blue-400" href="https://pronic.co.ke/faq#what-is-a-repair-boxs-workflow">https://pronic.co.ke/faq#what-is-a-repair-boxs-workflow</a>'

  ],
  [
    'question' => 'Looking for all features ?',
     'answer' => 'Go to : <a class="text-blue-400" href="https://pronic.co.ke/get-started/features">https://pronic.co.ke/get-started/features</a>'
  ],
  [
    'question' => 'Looking for Version Change logs ?',
     'answer' => 'Go to : <a class="text-blue-400" href="https://pronic.co.ke/">https://pronic.co.ke/</a>'
  ],
  [
    'question' => 'Where can get sample CSV files for import batch resource entries?',
    'answer' => 'Go to : <a class="text-blue-400" href="https://pronic.co.ke/faq#where-can-get-sample-csv-files-for-import-batch-resource-entries">https://pronic.co.ke/faq#where-can-get-sample-csv-files-for-import-batch-resource-entries</a>'
  ],
  [
    'question' => ' ',
    'answer' => 'Read at: <a class="text-blue-400" href="https://pronic.co.ke/faq#how-to-frontend-portfolio-can-be-customized">https://pronic.co.ke/faq#how-to-frontend-portfolio-can-be-customized</a>'
  ],
   [
    'question' => ' ',
      'answer' => 'Read at: <a class="text-blue-400" href="https://pronic.co.ke/faq#how-to-configured-sms-sending-gateways">https://pronic.co.ke/faq#how-to-configured-sms-sending-gateways</a>'

  ],
  [
      'question' => ' ',
        'answer' => 'Read at: <a class="text-blue-400" href="https://pronic.co.ke/faq#how-to-configure-payment-gateways">https://pronic.co.ke/faq#how-to-configure-payment-gateways</a>'

  ]
];
@endphp

<!DOCTYPE html>
<html lang="{{ config('app.locale', 'en') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Demo {{config('app.name')}}</title>
    <link rel="shortcut icon" href="/images/default/icon.png">
    <link href="/css/app.css" rel="stylesheet">
</head>
<body>
    <main class="flex-1 relative overflow-y-auto min-h-screen focus:outline-none p-10 pt-5" tabindex="0">
    <div class="max-w-1/6 mx-auto px-4 sm:px-6 lg:px-8">
      <div class="md:flex md:items-center md:justify-between">
        <div class="flex min-w-0">
        <h1 class="mb-1 text-2xl font-bold text-center text-gray-800 sm:text-3xl title-font">
            Welcome to demo for {{config('app.name')}} <small>({{config('app.version')}}v)</small>
          </h1>
        </div>
      </div>
    </div>
    <div class="mt-2 max-w-1/6 mx-auto px-4 sm:px-6 lg:px-8">
      <div class="my-1">
        <ul class="grid grid-cols-2 gap-4">
          @foreach($links as $link)
          <a class="col-span-1 flex flex-col text-center font-semibold btn btn-purple" target="_blank" tag="li" href="{{$link['url']}}">
            <div class="flex-1 flex flex-col p-2">
              <h3>{{$link['title']}}</h3>
            </div>
          </a>
          @endforeach
        </ul>
      </div>
             <div class="container px-5 py-5 mx-auto">
        <div class="mb-6 text-center">
          <h1 class="mb-1 text-2xl font-bold text-center text-gray-800 sm:text-3xl title-font">
            Frequently Asked Questions
          </h1>
          <p class="mx-auto text-base leading-relaxed xl:w-2/4 lg:w-3/4">
           The most common questions about the RepairBox.
          </p>
        </div>
        <div class="flex flex-wrap -mx-2 lg:w-4/5 sm:mx-auto sm:mb-2">
          <div
            class="w-full px-4"
          >
          @foreach($faqs as $faq)
            <details class="mb-4 bg-gray-100 rounded-md">
              <summary
                class="px-4 py-2 text-sm font-semibold bg-gray-300 rounded-md cursor-pointer"
              >
                {{$faq['question']}}
              </summary>
              <p class="px-4 py-2">
                {!!$faq['answer']!!}
              </p>
            </details>
          @endforeach
          </div>
        </div>
      </div>
    </div>
        <div class="flex flex-wrap items-center md:justify-between justify-center">
          <div class="w-full md:w-4/12 px-4 mx-auto text-center">
           <a href="https://codecanyon.net/item/repair-box-repair-bookingtracking-and-workshop-management-system/33436740#" class="btn" target="_blank"> <img src="https://2465857270-files.gitbook.io/~/files/v0/b/gitbook-x-prod.appspot.com/o/spaces%2F-MeYJ67BJ1mcjfifTiur%2Fuploads%2FyJ2U63DljxD6NozBLkv9%2Fimage.png?alt=media&token=9e093767-8304-4ef3-ac97-b0aba48f9d99"></a>
            <a
              class="text-sm font-semibold py-1 text-gray-400"
              href="https://codecanyon.net/user/rose-finch/portfolio"
              rel="noopener"
              target="_blank"
            >
              Copyright © {{ date('Y') }} {{config('app.name')}} ({{config('app.version')}}v)
            </a>
          </div>
        </div>
  </main>
</body>

</html>
