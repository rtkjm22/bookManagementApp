<!-- resource/views/books.blade.php -->

@extends('layouts/app')
@section('content')

@if (session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div><!-- / .alert alert-success -->
@endif

<div class="card-body">
    <div class="card-title">
        本のタイトル
    </div><!-- / .card-title -->

    @include('common.errors')

    <form enctype="multipart/form-data" action="{{ url('books') }}" method="POST" class="form-horizontal">
        @csrf
        <div class="form-row">
            <!-- item_name -->
            <div class="form-group col-md-6">
                <label for="book" class="col-sm-3 control-labal">Book</label>
                <input type="text" name="item_name" class="form-control">
            </div><!-- / .form-group -->

            <!-- item_number -->
            <div class="form-group col-md-6">
                <label for="number" class="col-sm-3 control-labal">数</label>
                <input type="number" name="item_number" class="form-control">
            </div><!-- / .form-group -->

            <!-- item_amount -->
            <div class="form-group col-md-6">
                <label for="amount" class="col-sm-3 control-labal">金額</label>
                <input type="number" name="item_amount" class="form-control">
            </div><!-- / .form-group -->

            <!-- published -->
            <div class="form-group col-md-6">
                <label for="published" class="col-sm-3 control-labal">公開日</label>
                <input type="date" name="published" class="form-control">
            </div><!-- / .form-group -->

            <!-- item_img -->
            <div class="col-sm-6">
                <label>画像</label>
                <input type="file" name="item_img">
            </div><!-- / .col-sm-6 -->

        </div><!-- / .form-row -->


        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <button type="submit" class="btn btn-primary">Save</button>
            </div><!-- / .col-sm-offset-3 col-sm-6 -->
        </div><!-- / .form-group -->
    </form>
</div><!-- / .card-body -->

<!-- 本のリスト -->

@if (count($books) > 0)
<div class="card-body">
    <div class="card-body">
        <table class="table table-striped task-table">
            <thead>
                <th>本一覧</th>
                <th>&nbsp;</th>
            </thead>
            <tbody>
                @foreach ($books as $book)
                <tr>
                    <!-- 本タイトル -->
                    <td class="table-text">
                        <div>{{ $book -> item_name }}</div>
                        <div><img src="assets/upload/{{ $book -> item_img }}" width="100" alt=""></div>
                    </td>

                    <!-- 更新ボタン -->
                    <td>
                        <form action="{{ url('booksedit/' . $book -> id ) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">更新</button>
                        </form>
                    </td>

                    <!-- 本削除ボタン -->
                    <td>
                        <form method="POST" action="{{ url('book/'. $book -> id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">
                                削除
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table><!-- / .table table-striped task-table -->
    </div><!-- / .card-body -->
</div><!-- / .card-body -->

<div class="row">
    <div class="col-md-4 offset-md-4">
        {{ $books ->  links()}}
    </div>
</div><!-- / .row -->
@endif




@endsection