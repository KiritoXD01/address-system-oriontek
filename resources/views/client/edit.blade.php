@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.edit').' '.trans('messages.client'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-users"></i> @lang('messages.edit') @lang('messages.client')
        </h1>
    </div>
    <!-- End Page Heading -->

    <form action="{{ route('client.update', $client->id) }}" method="post" autocomplete="off" id="form" enctype="multipart/form-data">
        @csrf
        @method("PATCH")
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-6">
                        <a href="{{ route('client.index') }}" class="btn btn-warning">
                            <i class="fa fa-fw fa-arrow-circle-left"></i> @lang('messages.cancel')
                        </a>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary float-right">
                            <i class="fa fa-fw fa-save"></i> @lang('messages.save') @lang('messages.client')
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="list-group">
                            @foreach ($errors->all() as $error)
                                <li class="list-group-item">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ session('success') }}</strong>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">@lang('messages.name')</label>
                            <input type="text" id="name" name="name" required autofocus maxlength="255" class="form-control" value="{{ old('name') ?? $client->name }}" placeholder="@lang('messages.name')...">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" maxlength="255" class="form-control" value="{{ old('email') ?? $client->email }}" placeholder="Email...">
                        </div>
                        <div class="form-group">
                            <label for="phone">@lang('messages.phone')</label>
                            <input type="tel" id="phone" name="phone" maxlength="20" class="form-control" value="{{ old('phone') ?? $client->phone }}" placeholder="@lang('messages.phone')...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <input type="file" id="logo" name="logo" accept="image/*" style="display: none;">
                            <button type="button" class="btn btn-primary btn-block" id="btnLogo">
                                <i class="fa fa-picture-o fa-fw"></i> Logo
                            </button>
                            <br>
                            <div class="text-center">
                                @if(isset($client))
                                    @if(!empty($client->logo))
                                        <img src="{{ asset($client->logo) }}?dummy={{ time() }}" alt="" id="LogoPreview" class="img-thumbnail mx-auto" style="width: 50%;">
                                    @else
                                        <img src="{{ asset('img/addimage.png') }}" alt="" id="LogoPreview" class="img-thumbnail mx-auto" style="width: 50%;">
                                    @endif
                                @else
                                    <img src="{{ asset('img/addimage.png') }}" alt="" id="LogoPreview" class="img-thumbnail mx-auto" style="width: 50%;">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('clientAddress.create', $client->id) }}" class="btn btn-primary float-right">
                        <i class="fa fa-fw fa-plus-circle"></i> @lang('messages.create') @lang('messages.address')
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="list-group">
                        @foreach ($errors->all() as $error)
                            <li class="list-group-item">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(session('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ session('success') }}</strong>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-hover" id="datatable" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>@lang('messages.name')</th>
                            <th>@lang('messages.actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($client->addresses as $address)
                        <tr class="text-center">
                            <td>{{ $address->address }}</td>
                            <td style="width: 20%;">
                                <form action="{{ route('clientAddress.delete', $address->id) }}" method="post" id="formDelete-{{ $address->id }}">
                                    @method('DELETE')
                                    @csrf
                                    <div class="btn-group btn-block">
                                        <a href="{{ route('clientAddress.edit', $address->id) }}" class="btn btn-primary">
                                            <i class="fa fa-fw fa-edit"></i> @lang('messages.edit')
                                        </a>
                                        <button type="button" class="btn btn-danger" onclick="deleteItem({{ $address->id }})">
                                            <i class="fa fa-trash fa-fw"></i> @lang('messages.delete')
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        function deleteItem(id) {
            Swal.fire({
                title: "@lang('messages.deleteItem')",
                icon: 'question',
                showCancelButton: true,
                allowEscapeKey: false,
                allowOutsideClick: false,
                confirmButtonText: "@lang('messages.yes')",
                cancelButtonText: "No",
                reverseButtons: true
            })
                .then((result) => {
                    if (result.value) {
                        Swal.fire({
                            title: "@lang('messages.pleaseWait')",
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            onOpen: () => {
                                Swal.showLoading();
                                document.getElementById(`formDelete-${id}`).submit();
                            }
                        });
                    }
                });
        }

        $(document).ready(function(){
            $("#form").submit(function() {
                Swal.fire({
                    title: "@lang('messages.pleaseWait')",
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    onOpen: () => {
                        Swal.showLoading();
                    }
                });
            });

            $("#btnLogo").click(function(){
                document.getElementById("logo").click();
            });

            $("#logo").change(function() {
                let file    = document.getElementById('logo').files[0];
                let preview = document.getElementById('LogoPreview');
                let reader  = new FileReader();

                reader.onloadend = function() {
                    preview.src = reader.result;
                };

                if (file)
                    reader.readAsDataURL(file);
            });
        });
    </script>
@endsection
