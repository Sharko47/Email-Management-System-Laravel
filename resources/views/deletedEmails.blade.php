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
                            <li class="page-item">{{$deletedEmailData->links()}}</a></li>
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
                    @if (session('email-restore-success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('email-restore-success') }}
                        </div>
                    @endif
                    @if (session('email-p-delete-success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('email-p-delete-success') }}
                        </div>
                    @endif
                    <table class="table table-striped table-bordered table-hover data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Sent To</th>
                                <th>Subject</th>
                                <th>Had Attachments</th>
                                <th>Deleted At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $c = 1 ?>
                            @foreach ($deletedEmailData as $item)
                            <tr>
                            <td>{{$c}}</td>
                            <td>{{$item->to}}</td>
                            <td>{{$item->subject}}</td>
                            @if (! empty($item->email_attachments))
                                <td>Yes</td>  
                            @else
                                <td>No</td>
                            @endif
                            <td>{{$item->deleted_at}}</td>
                            <td>
                                <div class="justify-content-center">
                                    <a  class="btn btn-success" href="{{route('restoreEmail',$item->id)}}">
                                        Restore
                                    </a>
                                    <a href="{{route('permanentDeleteEmail',$item->id)}}" class="btn btn-danger text-white font-weight-bold">Permanent Delete</a>

                                    @if ($item->is_important)
                                    <i class="fa fa-star fa-lg" aria-hidden="true" style="color: #f7c911;"
                                    data-toggle="tooltip" data-placement="bottom"
                                    title="Important Email!"></i>
                                    @else
                                    <i class="fa fa-star fa-lg" aria-hidden="true" style="color: rgb(175, 168, 168);"
                                    data-toggle="tooltip" data-placement="bottom"
                                    title="Not Important Email!"></i>
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
