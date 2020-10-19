@extends('goods.bootstrap')
@section('content')
    <form class="form-inline" >
        <div class="form-group">
            <label >商品名称</label>
            <input type="text" class="form-control" name="goods_name">
        </div>
        <div class="form-group">
            <label >商品描述</label>
            <input type="text" class="form-control" name="desc">
        </div>
        <button type="submit" class="btn btn-default">搜索</button>
    </form>

    <table class="table table-striped">
        <th>商品名称</th>
        <th>商品描述</th>
        <th>商品价格</th>
        <th>操作</th>
        @foreach($goods as $v)
            <tr>
                <td>{{ $v->goods_name }}</td>
                <td>{{ $v->desc }}</td>
                <td>{{ $v->price }}</td>
                <td>
                    <a href="{{ route('goods.edit',$v->goods_id) }}" class="btn btn-success btn-group-xs">修改</a>
                    <a href="{{ route('goods.delete',$v->goods_id) }}" class="btn btn-danger btn-group-xs">删除</a>
                </td>
            </tr>
        @endforeach
    </table>
@stop
