@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.edit').' '.trans('messages.user'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-building"></i> @lang('messages.edit') @lang('messages.information')
        </h1>
    </div>
    <!-- End Page Heading -->

    <form action="{{ route('business.update', $business->id) }}" method="post" autocomplete="off" id="form" enctype="multipart/form-data">
        @csrf
        @method("PATCH")
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary float-right">
                            <i class="fa fa-fw fa-save"></i> @lang('messages.save') @lang('messages.user')
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
                            <input type="text" id="name" name="name" required autofocus maxlength="255" class="form-control" value="{{ old('name') ?? $business->name }}" placeholder="@lang('messages.name')...">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" maxlength="255" class="form-control" value="{{ old('email') ??$business->email }}" placeholder="Email...">
                        </div>
                        <div class="form-group">
                            <label for="phone">@lang('messages.phone')</label>
                            <input type="tel" id="phone" name="phone" maxlength="20" class="form-control" value="{{ old('phone') ?? $business->phone }}" placeholder="@lang('messages.phone')...">
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
                                @if(isset($business))
                                    @if(!empty($business->logo))
                                        <img src="{{ asset($business->logo) }}?dummy={{ time() }}" alt="" id="LogoPreview" class="img-thumbnail mx-auto" style="width: 50%;">
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
@endsection

@section('javascript')
    <script>
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
