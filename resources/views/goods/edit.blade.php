@extends('goods.bootstrap')
@section('content')
    <form method="post" action="{{ route('goods.update',$goods->goods_id) }}">
        <div class="form-group">
            <label>商品名称</label>
            <input type="text" class="form-control" name="goods_name" value="{{ $goods->goods_name }}" />
            <label>商品描述</label>
            <textarea class="form-control" name="desc">{{ $goods->desc }}</textarea>
            <label>商品单价</label>
            <input type="text" class="form-control" name="price" value="{{ $goods->price }}"/>
            {{ csrf_field() }}
            {{ method_field('put') }}
        </div>
        <button type="submit" class="btn btn-default">提交</button>
    </form>

@stop
