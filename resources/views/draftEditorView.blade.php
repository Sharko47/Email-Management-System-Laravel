@extends('layouts.app')

@section('content')
<div class="home-container">
    <div class="row justify-content-end">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <a  class="btn btn-danger" href="{{route('deleteEmail',$draftedEmailData[0]['id'])}}">
                        Delete
                    </a>
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
                    <form role="form" method="POST" action="{{route('sendEmail',Auth::user()->id)}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="from-draft-to-sent" value="{{$draftedEmailData[0]['id']}}">
                        <div class="form-group">
                            <input type="checkbox" id="is-important" name="is-important"
                            >
                            <label for="is-important"
                            data-toggle="tooltip" data-placement="bottom"
                            title="Mark this email as Important!"
                            >Mark Important</label><br>
                            <label for="to-email">
                                To :</label>
                            <input type="email" class="form-control"
                            id="to-email" name="to-email" 
                            value="{{ $draftedEmailData[0]['to'] }}"
                            maxlength="50" list="contact-list"
                            required>
                            <datalist id="contact-list">
                                <?php 
                                $contactData = DB::table('contact_lists')->where('user_id',Auth::user()->id)->get();?>
                                @foreach ($contactData as $item)
                                <option value="{{$item->contact_email}}"> 
                                @endforeach  
                            </datalist>
    
                        </div>
                        <div class="form-group">
                            <label for="subject">
                                Subject :</label>
                            <input type="text" class="form-control"
                            id="subject" name="subject" maxlength="100" value="{{ $draftedEmailData[0]['subject'] }}">
                        </div>
                        <div class="form-group">
                            <label for="message">
                                Message :</label>
                            <textarea class="form-control" type="textarea" name="message"
                            id="message" placeholder="Your Message Here"
                            maxlength="6000" rows="7" style="resize: none"
                            
                            >{{ $draftedEmailData[0]['message'] }}</textarea>
                        </div>
                        <div class="form-group">
                                <span class="btn btn-secondary">
                                <i class="fa fa-plus fa fa-white"></i>
                                <input type="file" name="email-attachments" id="email-attachments" class="@error('email-attachments') is-invalid @enderror">
                                
                                @error('email-attachments')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                        </div>
                        
                        
                        <div class="btn-group d-flex">
                            <button type="submit" class="btn btn-dark text-white w-100"
                            style="font-size: 17px" formaction="{{route('saveDraft',Auth::user()->id)}}"
                            data-toggle="tooltip" data-placement="bottom"
                            title="Save this email as Draft email to send later!">Save Draft</button>
    
                            <button type="submit" class="btn btn-success w-100" id="send-email"style="font-size: 17px">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
   
</div>
@endsection

