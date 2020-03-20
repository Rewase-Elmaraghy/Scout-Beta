@extends('master')

@section('content')
    <meta name="csrf-token" content="{{csrf_token()}}"/>

    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-6 col-md-6">

            <div class="panel panel-default">
                <!-- default panel content-->
                <div class="panel-heading"><h1>Managing Categories</h1></div>
                <div class="panel-body"><br/>
                    <h3>Creating new Category </h3><br/>
                    @if(count($errors)>0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
        @endif

        <form id="add_category" method="post" action="create" enctype="multipart/form-data">
            <br>
            <label id="X" class="control-label" for="">Category Name:</label>
            <input name="category_name" id="category_name"/>
            <br><br>

            <label id="Y" class="control-label" for="">Quantity Available: </label>
            <input type="number" class="y" name="available" id="available"
                   min="1" max="999999" autofocus onkeypress="return isNumber(event)"/>
            <br><br>
            {!!csrf_field()!!}
            <label id="Z" class="control-label" for="">Upload an image:</label>
            <input type="file" name="image" id="image"/>
            <br><br>
            <button id="Add" type="submit" class="btn btn-primary">Add</button>
        </form>
        <br>
    </div>


    <div class="row">
        <div class="col-md-10">
            @if($categories != null)
                <table class="table table-hover" width="100%">
                    <tr>
                        <th><h3>Category Name</h3></th>
                        <th><h3>Total </h3></th>
                        <th><h3>Available </h3></th>
                        <th><h3>Update</h3></th>
                        <th><h3>Delete</h3></th>
                    </tr>
                    @foreach($categories as $category)
                        @if($category->trashed())
                            <tr style="background: #CA3C3C">
                        @else
                            <tr style="background: #fff">
                                @endif

                                <form id="edit_category" method="post" action="update/{{$category->id}}">
                                    <td width="10%">
                                        <input name="category_name2" id="category_name2"
                                               value="{{$category->category_name}}"/></td>
                                    <td width="20%">
                                        <input type="number" class="y" name="total2" id="total2"
                                               min="1" max="999999" value="{{$category->total}}" autofocus
                                               onkeypress="return isNumber(event)"/></td>
                                    <td width="20%">
                                        <input type="number" class="y" name="available2" id="available2"
                                               min="1" max="999999" value="{{$category->available}}" autofocus
                                               onkeypress="return isNumber(event)"/></td>
                                    <td width="20%">
                                    {!!csrf_field()!!}
                                    @if($category->trashed())
                                </form>
                                @else
                                    <button id="update" type="submit" class="btn btn-success">Update</button>
                                    </form>
                                @endif

                                <td width="20%">
                                    @if($category->trashed())
                                        <a href="deleteForever/{{$category->id}}" class="btn btn-danger">Eliminate</a>
                                </td>
                                @else
                                    <a href="delete/{{$category->id}}" class="btn btn-danger">Delete</a>

                                    </td>
                                @endif

                                @if($category->trashed())
                                    <td>
                                        <a href="restore/{{$category->id}}" class="btn btn-dark">Restore</a>
                                    </td>
                                @endif
                            </tr>

                            @endforeach
                </table>
            @endif
        </div>
    </div>

    <script>
        function isNumber(event) {
            var charCode = (event.which) ? event.which : event.keyCode;
            if (charCode > 31 && (charCode != 46 && (charCode < 48 || charCode > 57)))
                return false;
            else true;
        }
    </script>

@stop
