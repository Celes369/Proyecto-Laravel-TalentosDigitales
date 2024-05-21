@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
    <h1>Edit User</h1>
@stop

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Create user</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="post" action="{{ route('user.update', $user->id) }}" onsubmit="return validateForm();" enctype="multipart/form-data" autocomplete="off">
                        @method('PUT')
                        @csrf
                       @include('user.partials.form')
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!--/.col (left) -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection

@section('css')
    <link rel="stylesheet" href="/css/style.css">
@endsection

@section('scripts')
    <script src="{{ asset('js/modules/user/form.js') }}"></script>
@endsection

