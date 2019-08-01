@extends('layouts.admin')
@section('content')
<div class="box">
    <div class="box-header">
      <h3 class="box-title">Simple Full Width Table</h3>
      <div class="box-tools">
        <ul class="pagination pagination-sm no-margin pull-right">
          <li><a href="#">«</a></li>
          <li><a href="#">title</a></li>
          <li><a href="#">content</a></li>
          <li><a href="#">desc</a></li>
        </ul>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body no-padding">
      <table class="table">
      <tbody>
       @foreach ($list as $r)
           <tr>
             <td>{{$r->id}}</td>
             <td>{{$r->title}}</td>
             <td>{{$r->content}}</td>
             <td>{{$r->description}}</td>
           </tr>
       @endforeach
      </tbody></table>
    </div>
    <!-- /.box-body -->
  </div>

  {{$list->links()}}
@endsection