<!DOCTYPE html>
<html>
  <head> 
        @include('admin.css')
        <style type="text/css">
            table{
                border: 2px solid skyblue;
                text-align: center;
            }
            th{
                background-color: skyblue;
                padding: 10px;
                font-size: 18px;
                font-weight: bold;
                text-align: center;
                color: white;
            }
            .table_center{
                display: flex;
                justify-content: center;
                align-items: center;
            }
            td{
                color: white;
            }
        </style>
  </head>
  <body>
        @include('admin.header')
    <div class="d-flex align-items-stretch">

        @include('admin.sidebar')
      <!-- Sidebar Navigation end-->
      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <div class="table_center">
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Product title</th>
                        <th>Product image</th>
                        <th>Price</th>
                    </tr>
                    @foreach($data as $data)
                    <tr>
                        <td>{{$data->name}}</td>
                        <td>{{$data->rec_address}}</td>
                        <td>{{$data->phone}}</td>
                        <td>{{$data->product->title}}</td>
                        <td>
                            <img width="150" src="{{ asset('storage/products/'.$data->product->image) }}" alt="">
                        </td>
                        <td>{{ number_format($data->product->price, 0, ',', '.') }}đ</td>
                    </tr>
                    @endforeach
                </table>
            </div>
      </div>
    </div>
      @include('admin.js')
  </body>
</html>