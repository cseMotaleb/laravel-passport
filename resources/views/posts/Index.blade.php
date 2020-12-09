@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Laravel 8 CRUD </h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('posts.create') }}" title="Create a project"> <i class="fas fa-plus-circle"></i>
                    </a>
            </div>
        </div>
    </div>

     @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <table class="table table-bordered table-sm">
       <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>email</th>
            <th>Phone</th>
            <th>City</th>
            <th width="280px">Action</th>
        </tr>
       </thead>
       <tbody id="bodyData">

       </tbody>  
    </table>



@endsection

<script type="text/javascript">
    $(document).ready(function() {
        var url = "{{URL('index')}}";
        $.ajax({
            url: "/posts/index",
            type: "POST",
            data:{ 
                _token:'{{ csrf_token() }}'
            },
            cache: false,
            dataType: 'json',
            success: function(dataResult){
                console.log(dataResult);
                var resultData = dataResult.data;
                var bodyData = '';
                var i=1;
                $.each(resultData,function(index,row){
                    var editUrl = url+'/'+row.id+"/edit";
                    bodyData+="<tr>"
                    bodyData+="<td>"+ i++ +"</td><td>"+row.title+"</td><td>"+row.description+"</td>"
                   
                    +"<button class='btn btn-danger delete' value='"+row.id+"' style='margin-left:20px;'>Delete</button></td>";
                    bodyData+="</tr>";
                    
                })
                $("#bodyData").append(bodyData);
            }
        });


    $(document).on("click", ".delete", function() { 
        var $ele = $(this).parent().parent();
        var id= $(this).val();
        var url = "{{URL('posts')}}";
        var dltUrl = url+"/"+id;
        $.ajax({
            url: dltUrl,
            type: "DELETE",
            cache: false,
            data:{
                _token:'{{ csrf_token() }}'
            },
            success: function(dataResult){
                var dataResult = JSON.parse(dataResult);
                if(dataResult.statusCode==200){
                    $ele.fadeOut().remove();
                }
            }
        });
    });
        
});
</script>
