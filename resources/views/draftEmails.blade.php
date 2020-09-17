@extends('layouts.app')

@section('content')
<div class="home-container">
    <div class="row justify-content-end">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4>Inbox</h4>
                </div>
                <div class="card-header">
                    <div class="page-number">
                        <nav aria-label="Page navigation">
                          <ul class="pagination">
                            <li class="page-item">{{$draftEmailData->links()}}</a></li>
                          </ul>
                        </nav>
                      </div>
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
                    <table class="table table-striped table-bordered table-hover data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Receiver</th>
                                <th>Subject</th>
                                <th>Has Attachments</th>
                                <th>Drafted At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $c = 1 ?>
                            @foreach ($draftEmailData as $item)
                            <tr>
                            <td>{{$c}}</td>
                            <td>{{$item->to}}</td>
                            <td>{{$item->subject}}</td>
                            @if (! empty($item->email_attachments))
                                <td>Yes</td>  
                            @else
                                <td>No</td> 
                            @endif
                            <td>{{$item->created_at}}</td>
                            <td>
                                <div class="justify-content-center">
                                    <a  class="btn btn-danger" href="{{route('deleteEmail',$item->id)}}">
                                        Delete
                                    </a>
                                    <a href="{{route('sendDraftEmailDataToModal',$item->id)}}" class="btn btn-info text-white font-weight-bold">Edit</a>

                                    @if ($item->is_important)
                                    <i class="fa fa-star fa-lg" aria-hidden="true" style="color: #f7c911;"
                                    data-toggle="tooltip" data-placement="bottom"
                                    title="Important Email!"></i>
                                    @else
                                    <i class="fa fa-star fa-lg" aria-hidden="true" style="color: rgb(175, 168, 168);"
                                    data-toggle="tooltip" data-placement="bottom"
                                    title="Not Important"></i>
                                    @endif
                                    
                                </div>
                            </td> 
                            </tr>
                            <?php $c = $c + 1 ?>
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
   
</div>
@endsection
