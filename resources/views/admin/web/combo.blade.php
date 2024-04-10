@extends('admin.layouts.index')
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Combo</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <a style="float:right;padding-right:30px;" class="text-light">
                            <button class=" btn btn-primary float-right mb-3" data-bs-toggle="modal"
                                    data-bs-target="#combo">Tạo
                            </button>
                        </a>
                        <table class="table align-items-center mb-0 ">
                            <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7">Tên</th>
                                <th class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7">Hình ảnh</th>
                                <th class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7">Chi tiết</th>
                                <th class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7">Giá</th>
                                <th class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7">Trạng thái</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($combos as $combo)
                                <tr>
                                    <td class="align-middle text-center">
                                        <h6 class="mb-0 text-sm ">{{ $combo->name }}</h6>
                                    </td>
                                    <td class="align-middle text-center">
                                        <img style="height: 200px"
                                            src="/images/combo/{{$combo->image}}"
                                            alt="user1">
                                    </td>
                                    <td class="align-middle text-center">
                                        @foreach($combo->foods as $food)
                                            {{ $food->name . ' x '. $food->pivot->quantity}} <br>
                                        @endforeach
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary font-weight-bold">{{ number_format($combo->price) }} đ</span>
                                    </td>
                                    <td id="status{{$combo->id}}" class="align-middle text-center text-sm ">
                                        @if($combo->status == 1)
                                            <a href="javascript:void(0)" class="btn_active" onclick="changeStatus({{ $combo->id }},0)">
                                                <span class="badge badge-sm bg-gradient-success">Online</span>
                                            </a>
                                        @else
                                            <a href="javascript:void(0)" class="btn_active" onclick="changeStatus({{ $combo->id }},1)">
                                                <span class="badge badge-sm bg-gradient-secondary">Offline</span>
                                            </a>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <a class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                           data-original-title="Edit combo" data-bs-target="#comboEdit_{{$combo->id}}"
                                           data-bs-toggle="modal">
                                            <i class="fa-solid fa-pen-to-square fa-lg"></i>
                                        </a>
                                        <div class="modal fade" id="comboEdit_{{ $combo->id }}" tabindex="-1" aria-labelledby="combo_title" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="combo_title">Combo</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="admin/combo/edit/{{$combo->id}}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label for="name_{{$combo->id}}">Tên</label>
                                                                            <input id="name_{{$combo->id}}" class="form-control" type="text" value="{{ $combo->name }}" name="name"
                                                                                   autocomplete="off"
                                                                                   placeholder="Nhập tên" aria-label="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label for="price_{{$combo->id}}">Giá</label>
                                                                            <input id="price_{{$combo->id}}" class="form-control" type="number" name="price" value="{{ $combo->price }}"
                                                                                   placeholder="Nhập giá" aria-label="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group file-uploader">
                                                                            <label for="img_{{$combo->id}}">Hình ảnh</label>
                                                                            <input id="img_{{$combo->id}}" type='file' name='Image' class="form-control image-combo">
                                                                                <img style="width: 100px" alt="..." class="img-thumbnail"
                                                                                src="/images/combo/{{$combo->image}}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 food_group">
                                                                        <span class="form-label">Foods</span>
                                                                        @foreach($combo->foods as $foodOfCombo)
                                                                            <div class="input-group m-1">
                                                                                <span class="input-group-text text-black-50">Thực phẩm: </span>
                                                                                <select type='text' name='food[]' class="form-select" aria-label="food">
                                                                                    @foreach($foods as $food)
                                                                                        <option value="{{$food->id}}" @if($food->id == $foodOfCombo->id) selected @endif>
                                                                                            {{$food->name}}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                                <span class="input-group-text text-black-50">Số lượng: </span>
                                                                                <input type="number" value="{{$foodOfCombo->pivot->quantity}}" name="quantity[]" class="form-control"
                                                                                       placeholder="quantity..."
                                                                                       aria-label="quantity">
                                                                                <button type="button" class="btn btn-danger mb-0 delete_food"><i class="fa-solid fa-trash"></i></button>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                    <button type="button" class="btn m-1 btn-primary add_food">ADD FOOD</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                        
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                            <button type="submit" class="btn btn-primary">Lưu</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>                                        
                                    </td>
                                    <td class="align-middle">
                                        <a onclick="deleteCombo({{$combo->id}})"
                                           class="text-secondary font-weight-bold text-xs delete_combo">
                                            <i class="fa-solid fa-trash-can fa-lg"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="admin/combo/create" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="combo" tabindex="-1" aria-labelledby="combo_title" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="combo_title">Combo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
    
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="nameCreate">Tên</label>
                                        <input id="nameCreate" class="form-control" type="text" name="name" required autocomplete="off"
                                               placeholder="Nhập tên">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="priceCreate">Giá</label>
                                        <input id="priceCreate" class="form-control" type="number" name="price"
                                               placeholder="Nhập giá">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group file-uploader">
                                        <label for="imgCreate">Hình ảnh</label>
                                        <input id="imgCreate" type='file' name='Image' class="form-control image-combo">
                                        <img style="width: 150px" src="" class="img_combo d-none" alt="...">
                                    </div>
                                </div>
                                <div class="col-12 food_group">
                                    <span class="form-label">Foods</span>
                                    <div class="input-group m-1">
                                        <span class="input-group-text text-black-50">Thành phần: </span>
                                        <select type='text' name='food[]' class="form-select" aria-label="food">
                                            @foreach($foods as $food)
                                                <option value="{{$food->id}}">{{$food->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="input-group-text text-black-50">Số lượng: </span>
                                        <input type="number" name="quantity[]" class="form-control" placeholder="Số lượng" aria-label="quantity">
                                        <button type="button" class="btn btn-danger mb-0 delete_food"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                </div>
                                <button type="button" class="btn m-1 btn-primary add_food">Thêm</button>
                            </div>
                        </div>
                    </div>
    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
    
                </div>
            </div>
        </div>
    </form>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            deleteCombo = (id) => {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if (confirm("Xóa combo này?") === true) {
                    $.ajax({
                        url: 'admin/combo/delete/' + id,
                        type: 'DELETE',
                        statusCode: {
                            200: function (data) {
                                console.log(trObj);
                                $('.delete_combo').parents("tr").remove();
                            },
                            400: (data) => {
                                alert(data.error);
                            }
                        }
                    })
                    ;
                }
            }

            $('.add_food').on('click', (e) => {
                foodGroup =
                    `<div class="input-group m-1">
                    <span class="input-group-text text-black-50">Thức ăn: </span>
                    <select type='text' name='food[]' class="form-select" aria-label="food">
                        @foreach($foods as $food)<option value="{{$food->id}}">{{$food->name}}</option>@endforeach
                    </select>
                    <span class="input-group-text text-black-50">Số lượng: </span>
                    <input type="number" name="quantity[]" class="form-control" placeholder="quantity..." aria-label="quantity">
                    <button type="button" class="btn btn-danger mb-0 delete_food"><i class="fa-solid fa-trash"></i></button>
                </div>`
                $(e.target).parent().find('.food_group').append(foodGroup);
            })

            $('.food_group').on('click', '.delete_food', (e) => {
                $(e.target).parent('.input-group').remove();
            })

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.file-uploader .img_combo').attr('src', e.target.result).removeClass('d-none');
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $(".image-combo").change(function () {
                readURL(this);
            });
        });
    </script>
    <script>
        function changeStatus(combo_id, active) {
            if (active === 1) {
                $("#status" + combo_id).html(' <a href="javascript:void(0)"  class="btn_active" onclick="changeStatus(' + combo_id + ',0)">\
                    <span class="badge badge-sm bg-gradient-success">Online</span>\
            </a>')
            } else {
                $("#status" + combo_id).html(' <a  href="javascript:void(0)" class="btn_active"  onclick="changeStatus(' + combo_id + ',1)">\
                    <span class="badge badge-sm bg-gradient-secondary">Offline</span>\
            </a>')
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/admin/combo/status",
                type: 'GET',
                dataType: 'json',
                data: {
                    'active': active,
                    'combo_id': combo_id
                },
                success: function (data) {
                    if (data['success']) {
                        // alert(data.success);
                    } else if (data['error']) {
                        alert(data.error);
                    }
                }
            });
        }

    </script>
@endsection
