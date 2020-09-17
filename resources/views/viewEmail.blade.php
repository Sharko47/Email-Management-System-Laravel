@extends('layouts.app')

@section('content')
<div class="home-container">
    <div class="row justify-content-end">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <a  class="btn btn-danger" href="{{route('deleteEmail',$viewEmailData[0]['id'])}}">
                        Delete
                    </a>
                    @if ($viewEmailData[0]['is_important'])
                        <i class="fa fa-star fa-lg float-right mt-2" aria-hidden="true"
                        style="color: #f7c911;"
                        data-toggle="tooltip" data-placement="bottom"
                        title="Important Email!"></i>
                    @endif
                </div>
                <div class="card-body">
                    @if (session('email-deleted-success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('email-deleted-success') }}
                        </div>
                    @endif
                    @if (session('email-deleted-error'))
                        <div class="alert alert-success" role="alert">
                            {{ session('email-deleted-error') }}
                        </div>
                    @endif
                    <h4>From : {{$viewEmailData[0]['from']}}</h4>
                    <h6 style="font-size: 17px">To : {{$viewEmailData[0]['to']}}</h6>
                    <h6 style="font-size: 14px">Sent At : {{$viewEmailData[0]['created_at']}}</h6> <br>
                    <div class="text-center">
                        <p style="font-size: 22px">Subject : {{$viewEmailData[0]['subject']}}</p>
                    </div>
                    <br>
                    <p style="font-size: 18px">{!! $viewEmailData[0]['message'] !!}</p>
                </div>
            </div>
        </div>
    </div>
   
</div>
@endsection

