@extends('goods.bootstrap')
@section('content')
    <form method="post" action="{{ route('goods.store') }}">
        <div class="form-group">
            <label>商品名称</label>
            <input type="text" class="form-control" name="goods_name" />
            <label>商品描述</label>
            <textarea class="form-control" name="desc"></textarea>
            <label>商品单价</label>
            <input type="text" class="form-control" name="price" />
            {{ csrf_field() }}
        </div>
        <button type="submit" class="btn btn-default">提交</button>
    </form>

@stop
