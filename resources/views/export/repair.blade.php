<!DOCTYPE html>
<html lang="{{ config('app.locale', 'en') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Repair Box') }}</title>
    <link rel="stylesheet" href="{{public_path('export/css/bootstrap.min.css')}}">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="invoice-title">
                    <div class="row ">
                        <div class="col-6">
                            <img src="{{($setting->app_icon)}}" alt="{{$setting->app_name}}" height="100">
                        </div>
                    </div>
                    <br>
                    <div class="mt-1">
                        <div class="col-xs-12">
                            <h2>
                                {{'Invoice'}}
                                <span class="small"> # {{$repairOrder->tracking}}</span>
                            </h2>
                        </div>
                        <div class="col-xs-12">
                            <h2>
                                {{'Date'}}
                                <span class="small"> # {{$repairOrder->created_at}}</span>
                            </h2>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="col-12">
                    <strong>{{'Device Information'}} : </strong><br>
                    <ul>
                        <li>
                            {{'Brand'}} : {{$repairOrder->is_manual ? $repairOrder->brand_info['name'] : $repairOrder->brand->name}}
                        </li>
                        <li>
                            {{'Name'}} : {{$repairOrder->is_manual ? $repairOrder->device_info['name'] :$repairOrder->device->name}}
                        </li>
                        <li>
                            {{'Model'}} : {{$repairOrder->is_manual ? $repairOrder->device_info['model']: $repairOrder->device->model}}
                        </li>
                        <li>
                            {{'Serial number'}} : {{$repairOrder->serial_number}}
                        </li>
                    </ul>
                </div>
                <div class="col-12 mt-2">
                    <strong>{{'Customer Information'}} : </strong><br>
                    <ul>
                        <li>
                            {{'Name'}} : {{$repairOrder->name}}
                        </li>
                        <li>
                            {{'Email'}} : {{$repairOrder->email}}
                        </li>
                        <li>
                            {{'Phone'}} : {{$repairOrder->phone}}
                        </li>
                        <li>
                            {{'Address'}} : {{$repairOrder->address}}
                        </li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h3>{{'Issues'}}</h3>
                        <table class="table table-striped">
                        <caption class="hidden">Repair issues</caption>
                            <thead>
                                <tr class="line">
                                    <th scope="row">#</th>
                                    <th scope="row" class="text-center" width="90%">{{'Title'}}</th>
                                    <th scope="row" class="text-center">{{'Charges'}}</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if($repairOrder->is_manual)
                                 <tr>
                                    <td>{{1}}</td>
                                    <td>{{$repairOrder->defects_info['title']}}</td>
                                    <td class="text-center">{{$setting->currency_symbol}}{{$repairOrder->defects_info['price']}}</td>
                                </tr>
                                @else
                                @foreach($repairOrder->defects as $key => $defect)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$defect->title}}</td>
                                    <td class="text-center">{{$setting->currency_symbol}}{{$defect->price}}</td>
                                </tr>
                                @endforeach
                                @endif
                                <tr class="mt-10">
                                    <td colspan="1"></td>
                                    <td class="text-right"><strong>{{'Priority charge'}}</strong></td>
                                    <td class="text-right"><strong>{{$setting->currency_symbol}}{{$repairOrder->repairPriority->extra_charge}}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="1"></td>
                                    <td class="text-right"><strong>{{'Tax'}}</strong></td>
                                    <td class="text-right"><strong>{{$setting->currency_symbol}}{{$repairOrder->tax}}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="1">
                                    </td>
                                    <td class="text-right"><strong>{{'Total amount'}}</strong></td>
                                    <td class="text-right"><strong>{{$setting->currency_symbol}} {{$repairOrder->total_charges}}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                {{'Track repair status'}} : {{url('track/'.$repairOrder->tracking)}}
            </div>
        </div>
    </div>
</body>

</html>
