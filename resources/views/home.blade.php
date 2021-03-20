@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
   
                    @if (Session::has('success'))
                        <div class="alert alert-success text-center">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif

                    <form action="{{ route('codesnippet') }}" method="POST">
                    @csrf   
                    <table class="table table-bordered" id="dynamicTable">  
                        <tr>  
                            <td>
                                <select class="form-control"  name="addmore[0][show_on]">
                                    @foreach(\App\PageRule::$showOnArr as $key=>$val)
                                        <option value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="form-control"  name="addmore[0][rule]" required>
                                    <option value="">Select Rule</option>
                                    @foreach(\App\PageRule::$ruleArr as $key=>$val)
                                        <option value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>www.domain.com/</td>
                            <td><input type="text" name="addmore[0][rule_text]" placeholder="Enter text/javascript" class="form-control" required /></td>  
                            <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>  
                        </tr>  
                    </table> 
    
                    <button type="submit" class="btn btn-success">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
   
   $(document).ready(function(){
    var showOnArr =  <?php echo json_encode(\App\PageRule::$showOnArr); ?>;
    var ruleArr =  <?php echo json_encode(\App\PageRule::$ruleArr); ?>;
    var i = 0;
    var showOnTemplate = '';
    var ruleTemplate = '<option value="">Select rule</option>';

    $.each( showOnArr, function( key, value ) {
        showOnTemplate += '<option value="'+key+'">'+value+'</option>';
    });
    $.each( ruleArr, function( key, value ) {
        ruleTemplate += '<option value="'+key+'">'+value+'</option>';
    });
    
    $("#add").click(function(){
        ++i;
        $("#dynamicTable").append(
            '<tr><td><select name="addmore['+i+'][show_on]" class="form-control" required>'+showOnTemplate+'</select></td><td><select name="addmore['+i+'][rule]" class="form-control" required>'+ruleTemplate+'</select></td><td>www.example.com/</td><td><input type="text" name="addmore['+i+'][rule_text]" placeholder="Enter text/javascript" class="form-control" required/></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>'
        );
    });
   
    $(document).on('click', '.remove-tr', function(){  
         $(this).parents('tr').remove();
    });  
   });
    
   
</script>
