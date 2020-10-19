<?php

namespace App\Http\Controllers\Goods;

use App\Model\Goods;
use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsController extends Controller
{
    private $client;
    public function __construct()
    {
        $hosts = [
            '47.107.160.174:9200',         // IP + Port
        ];
        $client = ClientBuilder::create()           // Instantiate a new ClientBuilder
        ->setHosts($hosts)      // Set the hosts
        ->build();              // Build the client object
        $this->client = $client;
    }

    /**
     * 商品列表
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $where = [];
        if ($request->goods_name){
//            $where[] = ['goods_name','like',"%$request->goods_name%"];
            $where['goods_name'] = ['query'=>$request->goods_name,'slop'=>20];
        }
        if ($request->desc){
//            $where[] = ['desc','like',"%$request->desc%"];
            $where['desc'] = ['query'=>$request->desc,'slop'=>20];
        }
        if ($request->goods_name || $request->desc)
        {
            $params = [
                'index' => 'goods',
                'body'  => [
                    'query' => [
                        'match_phrase' =>$where
                    ]
                ]
            ];

            $results = $this->client->search($params);
            if (!empty($results)){
//                dd($results['hits']['hits']);
                $ids = [];
                foreach ($results['hits']['hits'] as $k=>$v){
                    $ids[] = $v['_id'];
                }
                $goods = Goods::whereIn('goods_id',$ids)->get();
            }
        }else{
            $goods = Goods::where($where)->get();
        }
//        $goods = Goods::all();
        return view('goods.index',compact('goods'));
    }

    /**
     * 返回添加页面
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('goods.create');
    }

    /**
     * 执行添加操作
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
//        dd($request->input());
        $goods = Goods::create($request->input());
        $params = [
            'index' => 'goods',
            'id'    => $goods->goods_id,
            'body'  => [
                'goods_name' => $request->goods_name,
                'desc' => $request->desc,
            ]
        ];

// Document will be indexed to my_index/_doc/my_id
        $response = $this->client->index($params);
        return redirect(route('goods.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $goods = Goods::find($id);
        return view('goods.edit',compact('goods'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $input = $request->except(['_token','_method']);
        $goods = Goods::where('goods_id',$id)->update($input);
        $params = [
            'index' => 'goods',
            'id'    => $id,
            'body'  => [
                'goods_name' => $request->goods_name,
                'desc' => $request->desc,
            ]
        ];

// Document will be indexed to my_index/_doc/my_id
        $response = $this->client->index($params);
        return redirect(route('goods.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Goods::where('goods_id',$id)->delete();
        return redirect(route('goods.index'));
    }

    public function delete($id)
    {
        Goods::where('goods_id',$id)->delete();
        return redirect(route('goods.index'));
    }

    public function init(){
        $params = [
            'index' => 'goods',
            'body' => [
                'settings' => [
                    'number_of_shards' => 1,
                    'number_of_replicas' => 0
                ],
                'mappings' => [
                    '_source' => [
                        'enabled' => true
                    ],
                    'properties' => [
                        'goods_name' => [
                            'type' => 'text',
                            "analyzer"=>"ik_max_word",
                            "search_analyzer"=>"ik_max_word"
                        ],
                        'desc' => [
                            'type' => 'text',
                            "analyzer"=>"ik_max_word",
                            "search_analyzer"=>"ik_max_word"
                        ]
                    ]
                ]
            ]
        ];


// Create the index with mappings and settings now
        $response = $this->client->indices()->create($params);
        dd($response);
    }
}
